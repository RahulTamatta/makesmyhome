import 'package:makesmyhome/feature/subscription/model.dart';
import 'package:makesmyhome/feature/subscription/service.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';

class SubscriptionController extends GetxController {
  final SubscriptionService subscriptionService;

  SubscriptionController({required this.subscriptionService});

  var subscriptions = <Subscription>[].obs;
  var userSubscriptions = <Subscription>[].obs;
  var isLoading = false.obs;
  // Map of subscriptionId -> isActive
  var userSubscriptionStatus = <int, bool>{}.obs;

  @override
  void onInit() {
    super.onInit();
    _initializeSubscriptions();
  }
  
  // Initialize subscriptions with cache loading
  Future<void> _initializeSubscriptions() async {
    // Load cached subscription status first for immediate UI feedback
    if (Get.find<AuthController>().isLoggedIn()) {
      await _loadSubscriptionStatusFromCache();
    }
    
    // Then fetch fresh data from server
    await fetchSubscriptions();
    
    // Fetch user subscriptions if logged in
    if (Get.find<AuthController>().isLoggedIn()) {
      await fetchUserSubscriptions();
    }
  }

  Future<void> fetchSubscriptions() async {
    isLoading(true);
    try {
      debugPrint('[FETCH_SUBS][CTRL] Starting subscription fetch...');
      final List<Subscription> fetchedSubscriptions =
          await subscriptionService.getSubscriptionsWithUserContext();

      debugPrint('[FETCH_SUBS][CTRL] Received ${fetchedSubscriptions.length} subscriptions from API');
      
      // Remove duplicates based on subscription ID
      final Set<String> seenIds = <String>{};
      final List<Subscription> uniqueSubscriptions = [];
      for (final sub in fetchedSubscriptions) {
        final String id = (sub.subscriptionId ?? sub.id ?? '').toString();
        if (id.isNotEmpty && !seenIds.contains(id)) {
          seenIds.add(id);
          uniqueSubscriptions.add(sub);
          debugPrint('[FETCH_SUBS][CTRL] Added subscription ID: ${sub.subscriptionId}, Name: ${sub.name}, Subscribed: ${sub.subscribed}');
        } else {
          debugPrint('[FETCH_SUBS][CTRL] Skipped duplicate subscription ID: $id');
        }
      }

      subscriptions.assignAll(uniqueSubscriptions);
      debugPrint('[FETCH_SUBS][CTRL] Final count: ${uniqueSubscriptions.length} unique subscriptions');
      _updateUserSubscriptionStatus();
    } catch (e) {
      debugPrint('[FETCH_SUBS][CTRL][ERR] Error fetching subscriptions: $e');
      
      // On web, CORS errors are common during development
      if (kIsWeb && e.toString().contains('Failed to fetch')) {
        debugPrint('CORS error detected on web - this is expected during development');
        // Don't show error snackbar for CORS issues on web
        return;
      }
      
      // Use try-catch to avoid snackbar crashes during early initialization
      try {
        if (Get.context != null) {
          Get.snackbar('Error', 'Failed to load subscriptions');
        }
      } catch (_) {
        debugPrint('Could not show snackbar - context not ready');
      }
    } finally {
      isLoading(false);
    }
  }

  // Build map of subscriptionId -> subscribed for quick lookup
  void _updateUserSubscriptionStatus() {
    debugPrint('[UPDATE_STATUS][CTRL] Updating user subscription status map...');
    userSubscriptionStatus.clear();
    for (final sub in subscriptions) {
      if (sub.subscriptionId != null) {
        final isSubscribed = sub.subscribed ?? false;
        userSubscriptionStatus[sub.subscriptionId!] = isSubscribed;
        debugPrint('[UPDATE_STATUS][CTRL] Subscription ID ${sub.subscriptionId}: subscribed=$isSubscribed');
      }
    }
    debugPrint('[UPDATE_STATUS][CTRL] Status map updated with ${userSubscriptionStatus.length} entries');
    
    // Persist subscription status to local storage for app reload scenarios
    _saveSubscriptionStatusToCache();
  }

  bool isUserSubscribed(int subscriptionId) {
    final isSubscribed = userSubscriptionStatus[subscriptionId] ?? false;
    debugPrint('[IS_SUBSCRIBED][CTRL] Checking subscription ID $subscriptionId: $isSubscribed');
    return isSubscribed;
  }

  bool get hasActiveSubscription =>
      userSubscriptionStatus.values.any((active) => active);

  // Reset subscription-related state (used on logout)
  void resetSubscriptionState() {
    subscriptions.clear();
    userSubscriptions.clear();
    userSubscriptionStatus.clear();
    _clearSubscriptionStatusCache();
    update();
  }
  
  // Save subscription status to local cache
  Future<void> _saveSubscriptionStatusToCache() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userId = Get.find<UserController>().userInfoModel?.id;
      
      if (userId != null && userId.isNotEmpty) {
        final cacheKey = 'subscription_status_$userId';
        final statusJson = jsonEncode(userSubscriptionStatus.map((key, value) => MapEntry(key.toString(), value)));
        await prefs.setString(cacheKey, statusJson);
        debugPrint('[CACHE][SAVE] Subscription status cached for user $userId');
      }
    } catch (e) {
      debugPrint('[CACHE][SAVE][ERR] Failed to cache subscription status: $e');
    }
  }
  
  // Load subscription status from local cache
  Future<void> _loadSubscriptionStatusFromCache() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userId = Get.find<UserController>().userInfoModel?.id;
      
      if (userId != null && userId.isNotEmpty) {
        final cacheKey = 'subscription_status_$userId';
        final statusJson = prefs.getString(cacheKey);
        
        if (statusJson != null) {
          final Map<String, dynamic> statusMap = jsonDecode(statusJson);
          userSubscriptionStatus.clear();
          
          statusMap.forEach((key, value) {
            final subscriptionId = int.tryParse(key);
            if (subscriptionId != null) {
              userSubscriptionStatus[subscriptionId] = value as bool;
            }
          });
          
          debugPrint('[CACHE][LOAD] Loaded ${userSubscriptionStatus.length} subscription statuses from cache');
          update(); // Trigger UI update
        }
      }
    } catch (e) {
      debugPrint('[CACHE][LOAD][ERR] Failed to load subscription status from cache: $e');
    }
  }
  
  // Clear subscription status cache
  Future<void> _clearSubscriptionStatusCache() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final userId = Get.find<UserController>().userInfoModel?.id;
      
      if (userId != null && userId.isNotEmpty) {
        final cacheKey = 'subscription_status_$userId';
        await prefs.remove(cacheKey);
        debugPrint('[CACHE][CLEAR] Subscription status cache cleared for user $userId');
      }
    } catch (e) {
      debugPrint('[CACHE][CLEAR][ERR] Failed to clear subscription status cache: $e');
    }
  }

  Future<void> fetchUserSubscriptions() async {
    try {
      isLoading(true);
      debugPrint('[MY_SUBS][CTRL] Fetching user subscriptions via Bearer token...');
      final data = await subscriptionService.getMySubscriptions();
      debugPrint('[MY_SUBS][CTRL] Received ${data.length} user subscriptions from API');

      // Remove duplicates by subscription_id, keeping the most recent purchase
      final uniqueSubscriptions = <Subscription>[];
      final seenSubscriptionIds = <int>{};

      // Sort by purchase date (most recent first) to keep the latest purchase
      final sortedData = List<Subscription>.from(data);
      sortedData.sort((a, b) {
        final aDate = a.createdAt ?? DateTime(1970);
        final bDate = b.createdAt ?? DateTime(1970);
        return bDate.compareTo(aDate); // Most recent first
      });

      for (var sub in sortedData) {
        final subscriptionId = sub.subscriptionId;
        if (subscriptionId != null &&
            !seenSubscriptionIds.contains(subscriptionId)) {
          seenSubscriptionIds.add(subscriptionId);
          uniqueSubscriptions.add(sub);
        }
      }

      userSubscriptions.assignAll(uniqueSubscriptions);
      debugPrint(
          '[MY_SUBS][CTRL] Deduplicated ${data.length} -> ${uniqueSubscriptions.length} subscriptions');

      // Update the main subscriptions list with active status
      final activeSubIds = uniqueSubscriptions
          .where((sub) => sub.status?.toLowerCase() == 'active')
          .map((sub) => sub.subscriptionId)
          .toSet();

      // Update the isActive status in the main subscriptions list
      for (var i = 0; i < subscriptions.length; i++) {
        final sub = subscriptions[i];
        if (activeSubIds.contains(sub.subscriptionId)) {
          subscriptions[i] = sub.copyWith(isActive: 1);
        }
      }
    } catch (e) {
      debugPrint('[MY_SUBS][CTRL][ERR] $e');
    } finally {
      isLoading(false);
    }
  }

  Future<void> subscribeUser({
    required int subscriptionId,
    required double amount,
    required String transactionId,
    required String paymentMethod,
    required String user_id,
  }) async {
    try {
      isLoading(true);
      debugPrint(
          '[SUBSCRIBE][CTRL] subscriptionId=$subscriptionId amount=$amount txn=$transactionId method=$paymentMethod user_id=$user_id');
      final success = await subscriptionService.subscribeToService(
        subscriptionId: subscriptionId,
        amount: amount,
        transactionId: transactionId,
        paymentMethod: paymentMethod,
        userId: user_id,
      );

      if (success) {
        debugPrint('[SUBSCRIBE][CTRL] Subscribe API success - updating subscription status');
        
        // Immediately update the subscription status in memory for instant UI feedback
        userSubscriptionStatus[subscriptionId] = true;
        
        // Update the subscription object in the main list
        for (int i = 0; i < subscriptions.length; i++) {
          if (subscriptions[i].subscriptionId == subscriptionId) {
            subscriptions[i] = subscriptions[i].copyWith(subscribed: true);
            debugPrint('[SUBSCRIBE][CTRL] Updated subscription $subscriptionId status to subscribed=true');
            break;
          }
        }
        
        // Trigger UI update
        update();
        
        Get.snackbar('Success', 'Subscription added successfully!');
        
        // Refresh both lists to sync with backend
        await fetchSubscriptions();
        await fetchUserSubscriptions();
      } else {
        debugPrint('[SUBSCRIBE][CTRL] Subscribe API failed');
        Get.snackbar('Error', 'Failed to subscribe. Try again.');
      }
    } catch (e) {
      debugPrint('[SUBSCRIBE][CTRL] Error: $e');
      Get.snackbar('Error', e.toString());
    } finally {
      isLoading(false);
    }
  }

// Future<void> subscribeUser({
//   required int subscriptionId,
//   required String transactionId,
//   required String paymentMethod,
//   required int user_id,
// }) async {
//   try {
//     isLoading(true);
//     final success = await subscriptionService.subscribeToService(
//       subscriptionId: subscriptionId,
//       transactionId: transactionId,
//       paymentMethod: paymentMethod,
//       userId: user_id,
//     );
//
//     if (success) {
//       Get.snackbar("Success", "Subscription added successfully!");
//       // Refresh user subscriptions after subscribing
//       await fetchUserSubscriptions(user_id);
//     } else {
//       Get.snackbar("Error", "Failed to subscribe. Try again.");
//     }
//   } catch (e) {
//     Get.snackbar("Error", e.toString());
//   } finally {
//     isLoading(false);
//   }
// }
}
