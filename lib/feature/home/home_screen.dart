import 'dart:async';
import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/feature/subscription/view/view.dart';
import 'package:makesmyhome/helper/service_loading_manager.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class HomeScreen extends StatefulWidget {
  /// Optimized service loading using ServiceLoadingManager
  /// Eliminates race conditions and provides better error handling
  static Future<void> loadData(bool reload, {int availableServiceCount = 1}) async {
    debugPrint('HomeScreen.loadData: Delegating to ServiceLoadingManager (reload: $reload, count: $availableServiceCount)');
    
    await ServiceLoadingManager.instance.loadAllServices(
      reload: reload,
      availableServiceCount: availableServiceCount,
    );
    
    // Log loading status for debugging
    final status = ServiceLoadingManager.instance.getLoadingStatus();
    debugPrint('HomeScreen.loadData: Loading completed. Status: $status');
  }

  final AddressModel? addressModel;
  final bool showServiceNotAvailableDialog;
  const HomeScreen({
    super.key,
    this.addressModel,
    required this.showServiceNotAvailableDialog,
  });
  
  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final ScrollController scrollController = ScrollController();
  final signInShakeKey = GlobalKey<CustomShakingWidgetState>();
  AddressModel? _previousAddress;
  int availableServiceCount = 0;

  @override
  void initState() {
    super.initState();
    _initializeHomeScreen();
  }

  /// Initialize home screen with proper sequencing
  Future<void> _initializeHomeScreen() async {
    debugPrint('HomeScreen: Initializing...');
    
    Get.find<LocalizationController>().filterLanguage(shouldUpdate: false);
    
    // Get address list if user is logged in
    if (Get.find<AuthController>().isLoggedIn()) {
      Get.find<UserController>().getUserInfo();
      Get.find<LocationController>().getAddressList();
    }
    
    // Get available service count from current address
    if (Get.find<LocationController>().getUserAddress() != null) {
      availableServiceCount = Get.find<LocationController>()
          .getUserAddress()!
          .availableServiceCountInZone!;
    }
    
    _previousAddress = widget.addressModel;

    // Show service not available dialog if needed
    if (_previousAddress != null &&
        availableServiceCount == 0 &&
        widget.showServiceNotAvailableDialog) {
      _showServiceNotAvailableDialog();
    }

    // Wait for zone to be properly set before loading services
    _waitForZoneAndLoadServices();
  }

  /// Wait for zone to be properly resolved before loading services
  void _waitForZoneAndLoadServices() {
    // Check if zone is properly set every 500ms
    Timer.periodic(const Duration(milliseconds: 500), (timer) {
      final sharedPreferences = Get.find<SharedPreferences>();
      final currentZoneId = sharedPreferences.getString(AppConstants.zoneId) ?? '';
      
      debugPrint('HomeScreen: Checking zone status - zoneId: $currentZoneId');
      
      // If zone is set and not the default 'configuration', load services
      if (currentZoneId.isNotEmpty && currentZoneId != 'configuration') {
        timer.cancel();
        debugPrint('HomeScreen: Zone resolved ($currentZoneId), starting service loading with availableServiceCount: $availableServiceCount');
        HomeScreen.loadData(false, availableServiceCount: availableServiceCount);
      } else if (timer.tick > 20) { // Stop after 10 seconds
        timer.cancel();
        debugPrint('HomeScreen: Timeout waiting for zone, loading services anyway');
        HomeScreen.loadData(false, availableServiceCount: availableServiceCount);
      }
    });
  }

  /// Show service not available dialog
  void _showServiceNotAvailableDialog() {
    Future.delayed(const Duration(milliseconds: 1000), () {
      Get.dialog(ServiceNotAvailableDialog(
        address: _previousAddress,
        forCard: false,
        showButton: true,
        onBackPressed: () {
          Get.back();
          Get.find<LocationController>().setZoneContinue('false');
        },
      ));
    });
  }

  homeAppBar({GlobalKey<CustomShakingWidgetState>? signInShakeKey}) {
    if (ResponsiveHelper.isDesktop(context)) {
      return WebMenuBar(
        signInShakeKey: signInShakeKey,
      );
    } else {
      return const AddressAppBar(backButton: false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: homeAppBar(signInShakeKey: signInShakeKey),
      endDrawer: ResponsiveHelper.isDesktop(context) ? const MenuDrawer() : null,
      body: ResponsiveHelper.isDesktop(context)
          ? WebHomeScreen(
              scrollController: scrollController,
              availableServiceCount: availableServiceCount,
              signInShakeKey: signInShakeKey,
            )
          : SafeArea(
              child: RefreshIndicator(
                onRefresh: () async {
                  // Use ServiceLoadingManager for consistent refresh
                  await ServiceLoadingManager.instance.loadAllServices(
                    reload: true,
                    availableServiceCount: availableServiceCount,
                    forceLoad: true,
                  );
                },
                child: CustomScrollView(
                  controller: scrollController,
                  physics: const AlwaysScrollableScrollPhysics(),
                  slivers: [
                    SliverToBoxAdapter(
                      child: Column(
                        children: [
                          // Banner Section
                          const BannerView(),
                          
                          const SizedBox(height: Dimensions.paddingSizeSmall),
                          
                          // Categories Section
                          const CategoryView(),
                          
                          const SizedBox(height: Dimensions.paddingSizeSmall),
                          
                          // Popular Services Section
                          GetBuilder<ServiceController>(
                            builder: (serviceController) {
                              debugPrint('HomeScreen: Popular services - ${serviceController.popularServiceList?.length ?? 0} items');
                              return serviceController.popularServiceList != null &&
                                      serviceController.popularServiceList!.isNotEmpty
                                  ? HorizontalScrollServiceView(
                                      fromPage: "popular",
                                      serviceList: serviceController.popularServiceList!,
                                    )
                                  : const SizedBox();
                            },
                          ),
                          
                          const SizedBox(height: Dimensions.paddingSizeSmall),
                          
                          // Trending Services Section
                          GetBuilder<ServiceController>(
                            builder: (serviceController) {
                              debugPrint('HomeScreen: Trending services - ${serviceController.trendingServiceList?.length ?? 0} items');
                              return serviceController.trendingServiceList != null &&
                                      serviceController.trendingServiceList!.isNotEmpty
                                  ? HorizontalScrollServiceView(
                                      fromPage: "trending",
                                      serviceList: serviceController.trendingServiceList!,
                                    )
                                  : const SizedBox();
                            },
                          ),
                          
                          const SizedBox(height: Dimensions.paddingSizeSmall),
                          
                          // Recommended Services Section
                          GetBuilder<ServiceController>(
                            builder: (serviceController) {
                              return serviceController.recommendedServiceList != null &&
                                      serviceController.recommendedServiceList!.isNotEmpty
                                  ? RecommendedServiceView(
                                      height: 200,
                                    )
                                  : const SizedBox();
                            },
                          ),
                          
                          const SizedBox(height: Dimensions.paddingSizeSmall),
                          
                          // Subscription Section
                          GetBuilder<SubscriptionController>(
                            builder: (subscriptionController) {
                              debugPrint('HomeScreen: Subscription section - subscriptions count: ${subscriptionController.subscriptions.length}, isNotEmpty: ${subscriptionController.subscriptions.isNotEmpty}');
                              debugPrint('HomeScreen: isLoading: ${subscriptionController.isLoading.value}, userSubscriptionStatus: ${subscriptionController.userSubscriptionStatus.length}');
                              
                              if (subscriptionController.subscriptions.isNotEmpty) {
                                debugPrint('HomeScreen: Showing subscription section with ${subscriptionController.subscriptions.length} items');
                                return Container(
                                  constraints: BoxConstraints(minHeight: 200), // Ensure minimum height
                                  child: SubscriptionView(),
                                );
                              } else if (subscriptionController.isLoading.value) {
                                debugPrint('HomeScreen: Subscriptions are loading - showing loading state');
                                return Container(
                                  height: 200,
                                  child: Center(
                                    child: Column(
                                      mainAxisAlignment: MainAxisAlignment.center,
                                      children: [
                                        CircularProgressIndicator(),
                                        SizedBox(height: 16),
                                        Text('Loading subscriptions...'),
                                      ],
                                    ),
                                  ),
                                );
                              } else {
                                debugPrint('HomeScreen: No subscriptions available - hiding section');
                                return const SizedBox();
                              }
                            },
                          ),
                          
                          const SizedBox(height: 100),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
    );
  }
}
