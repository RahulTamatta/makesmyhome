import 'dart:async';
import 'dart:convert';
import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:makesmyhome/api/remote/client_api.dart';
import 'package:makesmyhome/feature/auth/controller/auth_controller.dart';
import 'package:makesmyhome/feature/subscription/model.dart';
import 'package:makesmyhome/utils/app_constants.dart';
import 'package:makesmyhome/utils/core_export.dart';

class SubscriptionService {
  SubscriptionService();
  static const Duration _timeout = Duration(seconds: 30);
  static const int _maxRetries = 3;

  Map<String, String> get headers {
    final Map<String, String> h = {
      'Content-Type': 'application/json; charset=UTF-8',
    };

    // On web, use minimal headers to avoid CORS preflights
    // Only add Authorization if we have a valid token
    if (!kIsWeb) {
      // Mobile: include all headers
      h.addAll(AppConstants.configHeader);
      try {
        final authController = Get.find<AuthController>();
        if (authController.isLoggedIn()) {
          final token = authController.getUserToken();
          if (token.isNotEmpty) {
            h['Authorization'] = 'Bearer $token';
            debugPrint('[HEADERS] Added Bearer token for authenticated user');
          } else {
            debugPrint('[HEADERS] User logged in but no token found');
          }
        } else {
          debugPrint('[HEADERS] User not logged in, no Bearer token added');
        }
      } catch (e) {
        debugPrint('[HEADERS] Error getting auth token: $e');
      }
    } else {
      // Web: minimal headers only
      try {
        final authController = Get.find<AuthController>();
        if (authController.isLoggedIn()) {
          final token = authController.getUserToken();
          if (token.isNotEmpty) {
            h['Authorization'] = 'Bearer $token';
            debugPrint(
                '[HEADERS][WEB] Added Bearer token for authenticated user');
          }
        }
      } catch (e) {
        debugPrint('[HEADERS][WEB] Error getting auth token: $e');
      }
    }

    return h;
  }

  Future<http.Response> _makeRequest(
    Future<http.Response> Function() request,
    String op,
  ) async {
    int attempt = 0;
    Exception? lastErr;
    while (attempt < _maxRetries) {
      attempt++;
      try {
        final res = await request().timeout(_timeout);
        return res;
      } on SocketException catch (e) {
        lastErr = e;
        debugPrint('[$op] SocketException attempt $attempt: ${e.message}');
      } on HttpException catch (e) {
        lastErr = e;
        debugPrint('[$op] HttpException attempt $attempt: ${e.message}');
      } on TimeoutException catch (e) {
        lastErr = e;
        debugPrint('[$op] Timeout attempt $attempt: ${e.message}');
      } catch (e) {
        lastErr = Exception(e.toString());
        debugPrint('[$op] Error attempt $attempt: $e');
      }
      if (attempt < _maxRetries) {
        await Future.delayed(Duration(seconds: attempt * 2));
      }
    }
    throw lastErr ?? Exception('[$op] Failed after $_maxRetries attempts');
  }

  Future<List<Subscription>> getSubscriptions() async {
    final uri = Uri.parse(AppConstants.baseUrl + AppConstants.subscriptionUri);
    debugPrint('[GET_SUBSCRIPTIONS][REQ] GET ${uri.toString()}');
    debugPrint('[GET_SUBSCRIPTIONS][REQ] Headers: ${headers}');

    final response = await _makeRequest(
      () => http.get(uri, headers: headers),
      'GET_SUBSCRIPTIONS',
    );

    debugPrint('[GET_SUBSCRIPTIONS][RES] Status: ${response.statusCode}');
    debugPrint('[GET_SUBSCRIPTIONS][RES] Body: ${response.body}');

    if (response.statusCode == 200) {
      final dynamic decoded = json.decode(response.body);
      final List<dynamic> data = decoded is List
          ? decoded
          : (decoded is Map<String, dynamic>
              ? (decoded['data'] is List ? decoded['data'] : [])
              : []);
      debugPrint(
          '[GET_SUBSCRIPTIONS][PARSED] Found ${data.length} subscriptions');

      // Debug each subscription's subscribed status
      for (int i = 0; i < data.length && i < 3; i++) {
        final item = data[i];
        debugPrint(
            '[GET_SUBSCRIPTIONS][ITEM_$i] ID: ${item['subscription_id']}, Name: ${item['name']}, Subscribed: ${item['subscribed']}');
      }

      return data.map((json) => Subscription.fromJson(json)).toList();
    } else {
      debugPrint(
          '[GET_SUBSCRIPTIONS][ERR] Failed with status ${response.statusCode}: ${response.body}');
      throw Exception(
          'Failed to load subscriptions [${response.statusCode}]: ${response.body}');
    }
  }

  // New flow: backend can infer user from Bearer token; GET without body
  Future<List<Subscription>> getMySubscriptions() async {
    final uri =
        Uri.parse('${AppConstants.baseUrl}${AppConstants.mySubscriptionUri}');
    debugPrint('[MY_SUBS][REQ] GET ${uri.toString()}');
    debugPrint('[MY_SUBS][REQ] Headers: ${headers}');

    // Check if we have a valid Bearer token
    final authHeader = headers['Authorization'];
    if (authHeader == null || !authHeader.startsWith('Bearer ')) {
      debugPrint('[MY_SUBS][WARN] No valid Bearer token found in headers');
    } else {
      debugPrint(
          '[MY_SUBS][INFO] Bearer token present: ${authHeader.substring(0, 20)}...');
    }

    final response = await _makeRequest(
      () => http.get(uri, headers: headers),
      'GET_MY_SUBSCRIPTIONS',
    );

    debugPrint('[MY_SUBS][RES] Status: ${response.statusCode}');
    debugPrint('[MY_SUBS][RES] Body: ${response.body}');

    if (response.statusCode == 200) {
      final dynamic decoded = json.decode(response.body);
      List<dynamic> data;
      if (decoded is List) {
        data = decoded;
      } else if (decoded is Map<String, dynamic>) {
        if (decoded['data'] is List) {
          data = decoded['data'];
        } else if (decoded['my_Subription'] is List) {
          data = decoded['my_Subription'];
        } else if (decoded['my_Subscription'] is List) {
          data = decoded['my_Subscription'];
        } else {
          data = const [];
        }
      } else {
        data = const [];
      }

      debugPrint('[MY_SUBS][PARSED] Found ${data.length} user subscriptions');

      // Debug each user subscription
      for (int i = 0; i < data.length && i < 3; i++) {
        final item = data[i];
        debugPrint(
            '[MY_SUBS][ITEM_$i] ID: ${item['subscription_id']}, Status: ${item['status']}, Buy Status: ${item['buy_status']}');
      }

      return data.map((json) => Subscription.fromJson(json)).toList();
    } else if (response.statusCode == 401) {
      debugPrint(
          '[MY_SUBS][ERR] Unauthorized - Bearer token may be invalid or expired');
      throw Exception(
          'Unauthorized while loading my subscriptions. Ensure valid Bearer token. Body: ${response.body}');
    } else {
      debugPrint(
          '[MY_SUBS][ERR] Failed with status ${response.statusCode}: ${response.body}');
      throw Exception(
          'Failed to load my subscriptions [${response.statusCode}]: ${response.body}');
    }
  }

  Future<List<Subscription>> getUserSubscriptions(int userId) async {
    final uri = Uri.parse(
        '${AppConstants.baseUrl}${AppConstants.mySubscriptionUri}/$userId');
    final response = await _makeRequest(
      () => http.get(uri, headers: headers),
      'GET_USER_SUBSCRIPTIONS',
    );

    if (response.statusCode == 200) {
      final dynamic decoded = json.decode(response.body);
      final List<dynamic> data = decoded is List
          ? decoded
          : (decoded is Map<String, dynamic>
              ? (decoded['data'] is List ? decoded['data'] : [])
              : []);
      return data.map((json) => Subscription.fromJson(json)).toList();
    } else if (response.statusCode == 401) {
      throw Exception(
          'Unauthorized while loading user subscriptions. Ensure valid Bearer token. Body: ${response.body}');
    } else {
      throw Exception(
          'Failed to load user subscriptions [${response.statusCode}]: ${response.body}');
    }
  }

  // Fetch subscriptions with user context - Backend expects POST with user_id in body
  // This matches the backend apilist method that checks user_id to determine subscribed status
  Future<List<Subscription>> getSubscriptionsWithUserContext() async {
    try {
      // FIXED: Ensure user_id is always sent when user is logged in
      final Map<String, dynamic> body = {};

      try {
        final authController = Get.find<AuthController>();
        if (authController.isLoggedIn()) {
          // Get user ID for authenticated users
          final userId = Get.find<UserController>().userInfoModel?.id;
          if (userId != null && userId.isNotEmpty) {
            body['user_id'] = userId;
            debugPrint(
                '[SUBS_WITH_CTX][INFO] Adding user_id to request: $userId');
          } else {
            debugPrint(
                '[SUBS_WITH_CTX][WARN] User logged in but no user_id found');
            // FIXED: Try to get user ID from alternative source
            final guestId = Get.find<SplashController>().getGuestId();
            if (guestId.isNotEmpty) {
              body['user_id'] = guestId;
              debugPrint('[SUBS_WITH_CTX][INFO] Using guest ID: $guestId');
            }
          }
        } else {
          debugPrint(
              '[SUBS_WITH_CTX][INFO] User not logged in - sending empty body');
        }
      } catch (e) {
        debugPrint('[SUBS_WITH_CTX][ERR] Error getting user context: $e');
      }

      debugPrint(
          '[SUBS_WITH_CTX][REQ] POST ${AppConstants.baseUrl + AppConstants.subscriptionUri}');
      debugPrint('[SUBS_WITH_CTX][REQ] Body: $body');
      debugPrint('[SUBS_WITH_CTX][REQ] Headers: ${headers}');

      // For web, use ApiClient to handle CORS properly
      // For mobile, use direct HTTP request
      http.Response response;
      
      if (kIsWeb) {
        try {
          // Use ApiClient for web CORS handling
          final apiClient = Get.find<ApiClient>();
          debugPrint('[SUBS_WITH_CTX][WEB] Using ApiClient for CORS handling');
          
          final apiResponse = await apiClient.postData(
            AppConstants.subscriptionUri,
            body,
          );
          
          debugPrint('[SUBS_WITH_CTX][WEB] ApiClient response: ${apiResponse.statusCode}');
          debugPrint('[SUBS_WITH_CTX][WEB] ApiClient body: ${apiResponse.body}');
          
          // Convert ApiClient response to http.Response format
          response = http.Response(
            jsonEncode(apiResponse.body),
            apiResponse.statusCode ?? 200,
            headers: {'content-type': 'application/json'},
          );
          
        } catch (e) {
          debugPrint('[SUBS_WITH_CTX][WEB] ApiClient failed: $e');
          // For web, if POST fails due to CORS, fall back to GET
          debugPrint('[SUBS_WITH_CTX][FALLBACK] Trying GET method as fallback');
          
          // Add delay to prevent rapid retries
          await Future.delayed(Duration(milliseconds: 500));
          return await getSubscriptions(); // Use existing GET method
        }
      } else {
        // Mobile: use direct HTTP request
        response = await _makeRequest(
          () => http.post(
            Uri.parse(AppConstants.baseUrl + AppConstants.subscriptionUri),
            headers: headers,
            body: jsonEncode(body),
          ),
          'GET_SUBSCRIPTIONS_WITH_USER_CONTEXT',
        );
      } 
      debugPrint('[SUBS_WITH_CTX][RES] Status: ${response.statusCode}');
      debugPrint('[SUBS_WITH_CTX][RES] Body: ${response.body}');

      if (response.statusCode == 200) {
        final dynamic decoded = json.decode(response.body);
        final List<dynamic> data = decoded is List
            ? decoded
            : (decoded is Map<String, dynamic>
                ? (decoded['data'] is List ? decoded['data'] : [])
                : []);

        debugPrint(
            '[SUBS_WITH_CTX][PARSED] Found ${data.length} subscriptions');

        // Debug subscription status for first few items
        for (int i = 0; i < data.length && i < 3; i++) {
          final item = data[i];
          debugPrint(
              '[SUBS_WITH_CTX][ITEM_$i] ID: ${item['subscription_id']}, Name: ${item['name']}, Subscribed: ${item['subscribed']}');
        }

        return data.map((json) => Subscription.fromJson(json)).toList();
      } else {
        debugPrint(
            '[SUBS_WITH_CTX][ERR] Failed with status ${response.statusCode}: ${response.body}');
        throw Exception(
            'Failed to load subscriptions [${response.statusCode}]: ${response.body}');
      }
    } catch (e, stackTrace) {
      debugPrint('[SUBS_WITH_CTX][ERR] Exception: $e');
      debugPrint('[SUBS_WITH_CTX][ERR] Stack trace: $stackTrace');

      // Fallback to GET method if POST fails
      try {
        debugPrint('[SUBS_WITH_CTX][FALLBACK] Trying GET method as fallback');
        return await getSubscriptions();
      } catch (fallbackError) {
        debugPrint(
            '[SUBS_WITH_CTX][FALLBACK_ERR] GET fallback also failed: $fallbackError');
        return [];
      }
    }
  }

  Future<bool> subscribeToService({
    required int subscriptionId,
    required double amount,
    required String transactionId,
    required String paymentMethod,
    required String userId,
  }) async {
    // CRITICAL: This is the exact API call after successful Razorpay payment
    debugPrint('\x1B[32m[RAZORPAY_SUCCESS] Creating subscription after successful payment\x1B[0m');
    debugPrint('[moshi mosh] [RAZORPAY_SUCCESS] subscription_id: $subscriptionId, amount: $amount, user_id: $userId, transaction_id: $transactionId');
    
    // Validate required fields
    if (subscriptionId <= 0) {
      debugPrint('[SUBSCRIBE][ERR] Invalid subscription_id: $subscriptionId');
      return false;
    }

    if (userId.isEmpty) {
      debugPrint('[SUBSCRIBE][ERR] Empty user_id provided');
      return false;
    }

    if (amount <= 0) {
      debugPrint('[SUBSCRIBE][ERR] Invalid amount: $amount');
      return false;
    }

    // CRITICAL: Prepare payload exactly as specified in the example
    // FIXED: Extract actual user_id from JWT token, not guest_id
    String actualUserId = userId;
    if (userId.isEmpty || userId.startsWith('14d344b0')) {
      // This is a guest_id, extract real user_id from JWT token
      try {
        final authController = Get.find<AuthController>();
        if (authController.isLoggedIn()) {
          final token = authController.getUserToken();
          if (token.isNotEmpty) {
            final parts = token.split('.');
            if (parts.length == 3) {
              final payload = parts[1];
              String normalizedPayload = payload;
              while (normalizedPayload.length % 4 != 0) {
                normalizedPayload += '=';
              }
              final decoded = utf8.decode(base64Decode(normalizedPayload));
              final Map<String, dynamic> tokenData = jsonDecode(decoded);
              actualUserId = tokenData['sub']?.toString() ?? userId;
              debugPrint('\x1B[32m[SUBSCRIBE][USER_FIX] Extracted real user_id from token: $actualUserId\x1B[0m');
            }
          }
        }
      } catch (e) {
        debugPrint('[SUBSCRIBE][USER_FIX][ERR] Failed to extract user_id from token: $e');
      }
    }
    
    final Map<String, dynamic> payload = {
      'subscription_id': subscriptionId,
      'amount': amount,
      'transaction_id': transactionId.isNotEmpty
          ? transactionId
          : 'TXN_${DateTime.now().millisecondsSinceEpoch}',
      'payment_method': paymentMethod.isNotEmpty
          ? paymentMethod
          : 'credit_card', // Use credit_card as specified in the API example
      'user_id': actualUserId, // Use the actual authenticated user_id
    };

    final body = json.encode(payload);
    final fullUrl = 'https://housecraft.online/api/subscriptionmodule/subscriptions';
    
    debugPrint('\x1B[32m[SUBSCRIBE][REQ] POST $fullUrl\x1B[0m');
    debugPrint('\x1B[32m[SUBSCRIBE][REQ] Payload: $body\x1B[0m');
    debugPrint('[SUBSCRIBE][REQ] Headers: ${headers}');
    debugPrint('[moshi mosh] [API_CALL] calling_subscription_creation_api');
    debugPrint('\x1B[32m[SUBSCRIBE][CRITICAL] Using user_id: $actualUserId (was: $userId)\x1B[0m');

    try {
      if (kIsWeb) {
        // Use ApiClient on web to avoid CORS/preflight issues
        try {
          final apiClient = Get.find<ApiClient>();
          final apiResponse = await apiClient.postData(
            AppConstants.subscriptionUri,
            payload,
          );
          debugPrint('\x1B[32m[SUBSCRIBE][WEB] Response Status: ${apiResponse.statusCode}\x1B[0m');
          debugPrint('\x1B[32m[SUBSCRIBE][WEB] Response Body: ${apiResponse.body}\x1B[0m');
          debugPrint('[moshi mosh] [API_RESPONSE] status: ${apiResponse.statusCode}, body: ${apiResponse.body}');
          
          final status = apiResponse.statusCode ?? 0;
          if (status == 200 || status == 201) {
            debugPrint('\x1B[32m[SUBSCRIBE][WEB] ✅ Subscription created successfully in backend!\x1B[0m');
            debugPrint('[moshi mosh] [SUBSCRIPTION_CREATED] backend_success: true, subscription_id: $subscriptionId');
            
            // Parse and log the response details
            try {
              final responseData = apiResponse.body;
              debugPrint('\x1B[32m[SUBSCRIBE][WEB] Backend Response Data: $responseData\x1B[0m');
            } catch (e) {
              debugPrint('[SUBSCRIBE][WEB][WARN] Could not parse response: $e');
            }
            
            return true;
          } else {
            debugPrint('[SUBSCRIBE][WEB][ERR] ❌ Server error status: $status');
            debugPrint('[SUBSCRIBE][WEB][ERR] Error response: ${apiResponse.body}');
            debugPrint('[moshi mosh] [SUBSCRIPTION_FAILED] backend_error: status_$status');
            return false;
          }
        } catch (e) {
          debugPrint('[SUBSCRIBE][WEB][ERR] ApiClient exception: $e');
          return false;
        }
      }

      // Native platforms: direct HTTP
      // CRITICAL FIX: Use the full URL to avoid any routing issues
      final response = await _makeRequest(
        () => http.post(
          Uri.parse('https://housecraft.online/api/subscriptionmodule/subscriptions'),
          headers: headers,
          body: body,
        ),
        'SUBSCRIBE_TO_SERVICE',
      );

      debugPrint('\x1B[32m[SUBSCRIBE][RES] Response Status: ${response.statusCode}\x1B[0m');
      debugPrint('\x1B[32m[SUBSCRIBE][RES] Response Body: ${response.body}\x1B[0m');
      debugPrint('[moshi mosh] [API_RESPONSE] status: ${response.statusCode}, body: ${response.body}');

      if (response.statusCode == 200 || response.statusCode == 201) {
        debugPrint('\x1B[32m[SUBSCRIBE][SUCCESS] ✅ Subscription created successfully in backend!\x1B[0m');
        debugPrint('[moshi mosh] [SUBSCRIPTION_CREATED] backend_success: true, subscription_id: $subscriptionId');

        // Parse response to get subscription details if available
        try {
          final responseData = json.decode(response.body);
          debugPrint('\x1B[32m[SUBSCRIBE][SUCCESS] Backend Response Data: $responseData\x1B[0m');
          debugPrint('[moshi mosh] [BACKEND_RESPONSE] parsed_data: $responseData');
        } catch (e) {
          debugPrint('[SUBSCRIBE][WARN] Could not parse response JSON: $e');
        }

        return true;
      } else {
        debugPrint('[SUBSCRIBE][ERR] ❌ Server returned error status: ${response.statusCode}');
        debugPrint('[SUBSCRIBE][ERR] Error response: ${response.body}');
        debugPrint('[moshi mosh] [SUBSCRIPTION_FAILED] backend_error: status_${response.statusCode}');
        return false;
      }
    } catch (e, stackTrace) {
      debugPrint('[SUBSCRIBE][ERR] ❌ Network/Exception error: $e');
      debugPrint('[SUBSCRIBE][ERR] Stack trace: $stackTrace');
      debugPrint('[moshi mosh] [SUBSCRIPTION_FAILED] network_error: $e');
      return false;
    }
  }
}
