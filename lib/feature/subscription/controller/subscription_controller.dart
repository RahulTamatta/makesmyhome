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
  var userSubscriptionStatus = <int, bool>{}.obs;
  
  // FIXED: Track when we have fresh user subscription data
  bool _hasUserSubscriptionData = false;

  @override
  void onInit() {
    super.onInit();
    _initializeSubscriptions();
  }
  
  // Initialize subscriptions with cache loading
  Future<void> _initializeSubscriptions() async {
    // FIXED: Fetch user subscriptions first to get accurate status
    if (Get.find<AuthController>().isLoggedIn()) {
      await fetchUserSubscriptions();
    }
    
    // Then fetch all subscriptions (this will preserve the user subscription status)
    await fetchSubscriptions();
  }

  Future<void> fetchSubscriptions({bool forceRefresh = false}) async {
    isLoading(true);
    try {
      debugPrint('[FETCH_SUBS][CTRL] Starting subscription fetch...');
      
      // FIXED: Store current subscription statuses before fetching
      final currentStatuses = Map<int, bool>.from(userSubscriptionStatus);
      debugPrint('[FETCH_SUBS][CTRL] Preserving ${currentStatuses.length} current subscription statuses');
      
      // FIXED: If we have fresh user subscription data and subscriptions list, skip unnecessary fetch
      if (_hasUserSubscriptionData && currentStatuses.isNotEmpty && subscriptions.isNotEmpty && !forceRefresh) {
        debugPrint('[FETCH_SUBS][CTRL] Skipping fetch - already have fresh user subscription data and subscription list');
        isLoading(false);
        return;
      }
      
      // FIXED: If we have fresh user subscription data, prioritize it
      if (_hasUserSubscriptionData && currentStatuses.isNotEmpty) {
        debugPrint('[FETCH_SUBS][CTRL] Using fresh user subscription data - will preserve all statuses');
      }
      
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
          
          // FIXED: Preserve existing subscription status if available
          final subscriptionId = sub.subscriptionId;
          if (subscriptionId != null && currentStatuses.containsKey(subscriptionId)) {
            final preservedStatus = currentStatuses[subscriptionId]!;
            final updatedSub = sub.copyWith(subscribed: preservedStatus);
            uniqueSubscriptions.add(updatedSub);
            debugPrint('[FETCH_SUBS][CTRL] Added subscription ID: $subscriptionId, Name: ${sub.name}, Preserved Status: $preservedStatus');
          } else {
            uniqueSubscriptions.add(sub);
            debugPrint('[FETCH_SUBS][CTRL] Added subscription ID: ${sub.subscriptionId}, Name: ${sub.name}, New Status: ${sub.subscribed}');
          }
        } else {
          debugPrint('[FETCH_SUBS][CTRL] Skipped duplicate subscription ID: $id');
        }
      }

      subscriptions.assignAll(uniqueSubscriptions);
      debugPrint('[FETCH_SUBS][CTRL] Final count: ${uniqueSubscriptions.length} unique subscriptions');
      debugPrint('[FETCH_SUBS][CTRL] Subscription objects: ${uniqueSubscriptions.map((s) => '${s.name} (ID: ${s.subscriptionId})').join(', ')}');
      
      // FIXED: If API failed but we have user subscription data, create fallback subscriptions
      if (uniqueSubscriptions.isEmpty && userSubscriptions.isNotEmpty) {
        debugPrint('[FETCH_SUBS][CTRL] API failed but we have user subscriptions, creating fallback list');
        final fallbackSubscriptions = <Subscription>[];
        
        for (final userSub in userSubscriptions) {
          if (userSub.subscriptionId != null) {
            // Create a basic subscription object from user subscription data
            final fallbackSub = Subscription(
              subscriptionId: userSub.subscriptionId,
              id: userSub.id,
              name: userSub.name ?? 'Subscription ${userSub.subscriptionId}',
              description: userSub.description,
              price: userSub.price,
              image: userSub.image,
              status: 'active',
              duration: userSub.duration,
              subscribed: true, // User has this subscription
              isActive: 1,
            );
            fallbackSubscriptions.add(fallbackSub);
            debugPrint('[FETCH_SUBS][CTRL] Created fallback subscription: ${fallbackSub.name}');
          }
        }
        
        if (fallbackSubscriptions.isNotEmpty) {
          subscriptions.assignAll(fallbackSubscriptions);
          debugPrint('[FETCH_SUBS][CTRL] Using ${fallbackSubscriptions.length} fallback subscriptions');
          debugPrint('[FETCH_SUBS][CTRL] Fallback subscription objects: ${fallbackSubscriptions.map((s) => '${s.name} (ID: ${s.subscriptionId})').join(', ')}');
        }
      }
      
      // FIXED: Only update status for truly new subscriptions, preserve existing ones
      _updateUserSubscriptionStatusPreserving(currentStatuses);
      
      // Force UI update
      subscriptions.refresh();
      userSubscriptionStatus.refresh();
      update();
      
      debugPrint('[FETCH_SUBS][CTRL] UI refreshed after subscription update');
    } catch (e) {
      debugPrint('[FETCH_SUBS][CTRL][ERR] Error fetching subscriptions: $e');
      
      // FIXED: If API failed but we have user subscription data, create fallback subscriptions
      if (subscriptions.isEmpty && userSubscriptions.isNotEmpty) {
        debugPrint('[FETCH_SUBS][CTRL][ERR] API failed but we have user subscriptions, creating fallback list');
        final fallbackSubscriptions = <Subscription>[];
        
        for (final userSub in userSubscriptions) {
          if (userSub.subscriptionId != null) {
            // Create a basic subscription object from user subscription data
            final fallbackSub = Subscription(
              subscriptionId: userSub.subscriptionId,
              id: userSub.id,
              name: userSub.name ?? 'Subscription ${userSub.subscriptionId}',
              description: userSub.description,
              price: userSub.price,
              image: userSub.image,
              status: 'active',
              duration: userSub.duration,
              subscribed: true, // User has this subscription
              isActive: 1,
            );
            fallbackSubscriptions.add(fallbackSub);
            debugPrint('[FETCH_SUBS][CTRL][ERR] Created fallback subscription: ${fallbackSub.name}');
          }
        }
        
        if (fallbackSubscriptions.isNotEmpty) {
          subscriptions.assignAll(fallbackSubscriptions);
          debugPrint('[FETCH_SUBS][CTRL][ERR] Using ${fallbackSubscriptions.length} fallback subscriptions');
          
          // Update status map with fallback data
          _updateUserSubscriptionStatusPreserving(Map<int, bool>.from(userSubscriptionStatus));
        }
      }
      
      // Force UI update even on error
      subscriptions.refresh();
      userSubscriptionStatus.refresh();
      update();
      
      debugPrint('[FETCH_SUBS][CTRL] UI refreshed after error handling');
      
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

  // Build map of subscriptionId -> subscribed for quick lookup (preserving existing statuses)
  void _updateUserSubscriptionStatusPreserving(Map<int, bool> currentStatuses) {
    debugPrint('[UPDATE_STATUS][CTRL] Updating user subscription status map (preserving existing)...');
    
    // First, restore all existing statuses
    for (final entry in currentStatuses.entries) {
      userSubscriptionStatus[entry.key] = entry.value;
      debugPrint('[UPDATE_STATUS][CTRL] Preserved subscription ID ${entry.key}: subscribed=${entry.value}');
    }
    
    // Then, add any new subscriptions that weren't in the existing map
    for (final sub in subscriptions) {
      if (sub.subscriptionId != null && !currentStatuses.containsKey(sub.subscriptionId)) {
        final isSubscribed = sub.subscribed ?? false;
        userSubscriptionStatus[sub.subscriptionId!] = isSubscribed;
        debugPrint('[UPDATE_STATUS][CTRL] Added new subscription ID ${sub.subscriptionId}: subscribed=$isSubscribed');
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

  // FIXED: Manual refresh method to force update subscription status
  Future<void> refreshSubscriptionStatus() async {
    debugPrint('[REFRESH][CTRL] Manually refreshing subscription status...');
    try {
      // Refresh both subscription lists
      await fetchSubscriptions();
      await fetchUserSubscriptions();
      
      // Force UI update
      subscriptions.refresh();
      userSubscriptionStatus.refresh();
      update();
      
      debugPrint('[REFRESH][CTRL] Subscription status refreshed successfully');
    } catch (e) {
      debugPrint('[REFRESH][CTRL][ERR] Failed to refresh: $e');
    }
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

      // FIXED: Update subscription status based on user's active subscriptions
      final activeSubIds = uniqueSubscriptions
          .where((sub) => (sub.status?.toLowerCase() == 'active' || 
                          sub.status == null)) // Handle null status as active
          .map((sub) => sub.subscriptionId)
          .toSet();

      debugPrint('[MY_SUBS][CTRL] Active subscription IDs: $activeSubIds');

      // Update userSubscriptionStatus map with active subscriptions
      for (final subId in activeSubIds) {
        if (subId != null) {
          userSubscriptionStatus[subId] = true;
          debugPrint('[MY_SUBS][CTRL] Marked subscription $subId as subscribed=true');
        }
      }

      // Update the main subscriptions list with subscribed status
      for (var i = 0; i < subscriptions.length; i++) {
        final sub = subscriptions[i];
        if (sub.subscriptionId != null) {
          final isActive = activeSubIds.contains(sub.subscriptionId);
          subscriptions[i] = sub.copyWith(subscribed: isActive, isActive: isActive ? 1 : 0);
          debugPrint('[MY_SUBS][CTRL] Updated subscription ${sub.subscriptionId} to subscribed=$isActive');
        }
      }

      // Force UI update
      subscriptions.refresh();
      userSubscriptionStatus.refresh();
      update();
      
      debugPrint('[FETCH_SUBS][CTRL] UI refreshed after subscription update');
      
    } catch (e) {
      debugPrint('[MY_SUBS][CTRL][ERR] $e');
    } finally {
      isLoading(false);
    }
  }

  // Manual refresh method for testing
  Future<void> refreshSubscriptions() async {
    debugPrint('[REFRESH][CTRL] Manually refreshing subscription status...');
    try {
      // Force refresh both subscription lists
      await fetchSubscriptions(forceRefresh: true);
      await fetchUserSubscriptions();
      
      // Force UI update
      subscriptions.refresh();
      userSubscriptionStatus.refresh();
      update();
      
      debugPrint('[REFRESH][CTRL] Manual refresh completed');
    } catch (e) {
      debugPrint('[REFRESH][CTRL][ERR] Manual refresh failed: $e');
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
        
        // FIXED: Force UI update with proper state management
        subscriptions.refresh(); // Notify observers of list change
        userSubscriptionStatus.refresh(); // Notify observers of map change
        update(); // Trigger GetBuilder update
        
        Get.snackbar('Success', 'Subscription added successfully!');
        
        // Refresh both lists to sync with backend
        await fetchSubscriptions();
        await fetchUserSubscriptions();
        
        // FIXED: Additional UI refresh after backend sync
        subscriptions.refresh();
        userSubscriptionStatus.refresh();
        update();
        
        // FIXED: Extra delay and refresh to ensure UI consistency
        await Future.delayed(const Duration(milliseconds: 500));
        update();
        
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
