import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/feature/subscription/service.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:shared_preferences/shared_preferences.dart';

/// Centralized service loading manager for Flutter Web optimization
/// Handles proper sequencing, error recovery, and performance optimization
class ServiceLoadingManager {
  static ServiceLoadingManager? _instance;
  static ServiceLoadingManager get instance => _instance ??= ServiceLoadingManager._();
  ServiceLoadingManager._();

  bool _isLoading = false;
  bool _hasInitialized = false;
  final Set<String> _loadedServices = {};
  Timer? _retryTimer;
  int _retryCount = 0;
  static const int maxRetries = 3;
  static const Duration retryDelay = Duration(seconds: 2);

  /// Check if services are currently loading
  bool get isLoading => _isLoading;
  
  /// Check if initial load has completed
  bool get hasInitialized => _hasInitialized;

  /// Main entry point for loading all services with proper sequencing
  Future<void> loadAllServices({
    required bool reload,
    int availableServiceCount = 1,
    bool forceLoad = false,
  }) async {
    if (_isLoading && !forceLoad) {
      debugPrint('ServiceLoadingManager: Already loading, skipping duplicate call');
      return;
    }

    _isLoading = true;
    _retryCount = 0;

    try {
      debugPrint('ServiceLoadingManager: Starting service load sequence (web: $kIsWeb, count: $availableServiceCount, reload: $reload)');
      
      // Phase 1: Ensure controllers are ready
      await _ensureControllersReady();
      
      // Phase 2: Load critical services first
      await _loadCriticalServices(reload);
      
      // Phase 3: Load secondary services
      await _loadSecondaryServices(reload, availableServiceCount);
      
      // Phase 4: Load optional services (subscriptions, etc.)
      await _loadOptionalServices(reload);
      
      _hasInitialized = true;
      debugPrint('ServiceLoadingManager: All services loaded successfully');
      
    } catch (e, stackTrace) {
      debugPrint('ServiceLoadingManager: Error during service loading: $e');
      debugPrint('ServiceLoadingManager: Stack trace: $stackTrace');
      
      if (_retryCount < maxRetries) {
        await _scheduleRetry(reload, availableServiceCount);
      } else {
        debugPrint('ServiceLoadingManager: Max retries reached, loading critical services only');
        await _loadCriticalServicesOnly(reload);
      }
    } finally {
      _isLoading = false;
    }
  }

  /// Ensure all required controllers are properly initialized
  Future<void> _ensureControllersReady() async {
    debugPrint('ServiceLoadingManager: Ensuring controllers are ready...');
    
    final requiredControllers = [
      () => Get.find<ApiClient>(),
      () => Get.find<ServiceController>(),
      () => Get.find<BannerController>(),
      () => Get.find<CategoryController>(),
      () => Get.find<LocationController>(),
    ];

    for (final getController in requiredControllers) {
      try {
        getController();
      } catch (e) {
        debugPrint('ServiceLoadingManager: Controller not ready, waiting...');
        await Future.delayed(const Duration(milliseconds: 100));
        getController(); // Retry once
      }
    }

    // Ensure API client has proper headers (only if zone is properly set)
    final apiClient = Get.find<ApiClient>();
    final sharedPreferences = Get.find<SharedPreferences>();
    final currentZoneId = sharedPreferences.getString(AppConstants.zoneId) ?? '';
    
    // Always refresh headers to ensure latest zone ID is used
    apiClient.refreshHeaders();
    debugPrint('ServiceLoadingManager: Headers refreshed with zone: $currentZoneId');
    
    debugPrint('ServiceLoadingManager: All controllers ready');
  }

  /// Load critical services that must succeed
  Future<void> _loadCriticalServices(bool reload) async {
    debugPrint('ServiceLoadingManager: Loading critical services...');
    
    final criticalServices = [
      _loadService('config', () => _loadAppConfig()),
      _loadService('banners', () => Get.find<BannerController>().getBannerList(reload)),
      _loadService('categories', () => Get.find<CategoryController>().getCategoryList(reload)),
      _loadService('all_services', () => Get.find<ServiceController>().getAllServiceList(1, reload)),
    ];

    await _executeWithRetry(criticalServices, 'critical services');
  }

  /// Load secondary services
  Future<void> _loadSecondaryServices(bool reload, int availableServiceCount) async {
    if (kIsWeb || availableServiceCount > 0) {
      debugPrint('ServiceLoadingManager: Loading secondary services...');
      
      final secondaryServices = [
        _loadService('popular_services', () => Get.find<ServiceController>().getPopularServiceList(1, reload)),
        _loadService('trending_services', () => Get.find<ServiceController>().getTrendingServiceList(1, reload)),
        _loadService('recommended_services', () => Get.find<ServiceController>().getRecommendedServiceList(1, reload)),
        _loadService('featured_categories', () => Get.find<ServiceController>().getFeatherCategoryList(reload)),
        _loadService('advertisements', () => Get.find<AdvertisementController>().getAdvertisementList(reload)),
        _loadService('campaigns', () => Get.find<CampaignController>().getCampaignList(reload)),
      ];

      await _executeWithRetry(secondaryServices, 'secondary services');
    }
  }

  /// Load optional services (can fail without breaking the app)
  Future<void> _loadOptionalServices(bool reload) async {
    debugPrint('ServiceLoadingManager: Loading optional services...');
    
    final optionalServices = <Future>[];

    // Provider services
    try {
      optionalServices.add(_loadService('providers', () => Get.find<ProviderBookingController>().getProviderList(1, reload)));
      optionalServices.add(_loadService('nearby_providers', () => Get.find<NearbyProviderController>().getProviderList(1, reload)));
    } catch (e) {
      debugPrint('ServiceLoadingManager: Provider controllers not available: $e');
    }

    // Auth-dependent services
    if (Get.find<AuthController>().isLoggedIn()) {
      optionalServices.addAll([
        _loadService('auth_token', () => Get.find<AuthController>().updateToken()),
        _loadService('recent_services', () => Get.find<ServiceController>().getRecentlyViewedServiceList(1, reload)),
        _loadService('cart', () => Get.find<CartController>().getCartListFromServer()),
      ]);
    }

    // Subscription services (with special web handling)
    optionalServices.add(_loadSubscriptionServices());

    // Other optional services
    optionalServices.addAll([
      _loadService('recommended_search', () => Get.find<ServiceController>().getRecommendedSearchList()),
      _loadService('payment_methods', () => Get.find<CheckOutController>().getOfflinePaymentMethod(false, shouldUpdate: false)),
    ]);

    // Execute optional services without blocking main flow
    await Future.wait(
      optionalServices.map((future) => future.catchError((e) {
        debugPrint('ServiceLoadingManager: Optional service failed: $e');
        return null;
      })),
    );
  }

  /// Load subscription services with web-specific error handling
  Future<void> _loadSubscriptionServices() async {
    try {
      // Ensure SubscriptionController is available
      if (!Get.isRegistered<SubscriptionController>()) {
        Get.put(SubscriptionController(subscriptionService: SubscriptionService()));
      }
      
      await Get.find<SubscriptionController>().fetchSubscriptions();
      _loadedServices.add('subscriptions');
      debugPrint('ServiceLoadingManager: Subscriptions loaded successfully');
    } catch (e) {
      debugPrint('ServiceLoadingManager: Subscription loading failed (non-critical): $e');
      // Don't block the main flow for subscription failures
    }
  }

  /// Load app configuration
  Future<void> _loadAppConfig() async {
    try {
      final splashController = Get.find<SplashController>();
      if (splashController.configModel.content == null) {
        await splashController.getConfigData();
      }
    } catch (e) {
      debugPrint('ServiceLoadingManager: Config loading failed: $e');
      rethrow;
    }
  }

  /// Execute services with retry logic
  Future<void> _executeWithRetry(List<Future> services, String serviceName) async {
    try {
      await Future.wait(services);
      debugPrint('ServiceLoadingManager: $serviceName loaded successfully');
    } catch (e) {
      debugPrint('ServiceLoadingManager: $serviceName failed: $e');
      if (_retryCount < maxRetries) {
        debugPrint('ServiceLoadingManager: Retrying $serviceName...');
        await Future.delayed(retryDelay);
        await Future.wait(services);
      } else {
        rethrow;
      }
    }
  }

  /// Wrap service loading with tracking
  Future<void> _loadService(String serviceName, Future<void> Function() loader) async {
    try {
      await loader();
      _loadedServices.add(serviceName);
      debugPrint('ServiceLoadingManager: ✓ $serviceName loaded');
    } catch (e) {
      debugPrint('ServiceLoadingManager: ✗ $serviceName failed: $e');
      rethrow;
    }
  }

  /// Load only critical services as fallback
  Future<void> _loadCriticalServicesOnly(bool reload) async {
    try {
      await Future.wait([
        Get.find<BannerController>().getBannerList(reload),
        Get.find<ServiceController>().getAllServiceList(1, reload),
        Get.find<CategoryController>().getCategoryList(reload),
      ]);
      debugPrint('ServiceLoadingManager: Critical services fallback completed');
    } catch (e) {
      debugPrint('ServiceLoadingManager: Even critical services failed: $e');
    }
  }

  /// Schedule retry with exponential backoff
  Future<void> _scheduleRetry(bool reload, int availableServiceCount) async {
    _retryCount++;
    final delay = Duration(seconds: retryDelay.inSeconds * _retryCount);
    
    debugPrint('ServiceLoadingManager: Scheduling retry $_retryCount/$maxRetries in ${delay.inSeconds}s');
    
    await Future.delayed(delay);
    await loadAllServices(
      reload: reload,
      availableServiceCount: availableServiceCount,
      forceLoad: true,
    );
  }

  /// Get loading status for debugging
  Map<String, dynamic> getLoadingStatus() {
    return {
      'isLoading': _isLoading,
      'hasInitialized': _hasInitialized,
      'loadedServices': _loadedServices.toList(),
      'retryCount': _retryCount,
    };
  }

  /// Reset loading state (for testing/debugging)
  void reset() {
    _isLoading = false;
    _hasInitialized = false;
    _loadedServices.clear();
    _retryCount = 0;
    _retryTimer?.cancel();
    _retryTimer = null;
  }
}
