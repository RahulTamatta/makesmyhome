// ignore_for_file: deprecated_member_use

import 'dart:convert';
import 'dart:async';
import 'dart:developer';
import 'package:makesmyhome/helper/payment_guard.dart';
import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';

import 'package:flutter_inappwebview/flutter_inappwebview.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';

class PaymentScreen extends StatefulWidget {
  final String url;
  final String? fromPage;
  // Subscription context (optional)
  final String? subscriptionId;
  final String? subscriptionAmount;
  const PaymentScreen({
    super.key,
    required this.url,
    this.fromPage,
    this.subscriptionId,
    this.subscriptionAmount,
  });

  @override
  PaymentScreenState createState() => PaymentScreenState();
}

class PaymentScreenState extends State<PaymentScreen> {
  String? selectedUrl;
  double value = 0.0;
  final bool _isLoading = true;
  PullToRefreshController? pullToRefreshController;
  late MyInAppBrowser browser;
  Timer? _paymentTimer;
  static const int _timeoutSeconds = 90;

  @override
  void initState() {
    super.initState();
    selectedUrl = widget.url;
    debugPrint('[PAYMENT_SCREEN] PaymentScreen initialized');
    debugPrint('[PAYMENT_SCREEN] URL: ${widget.url}');
    debugPrint('[PAYMENT_SCREEN] From Page: ${widget.fromPage}');
    debugPrint('[PAYMENT_SCREEN] Subscription ID: ${widget.subscriptionId}');
    debugPrint('[PAYMENT_SCREEN] Amount: ${widget.subscriptionAmount}');
    _initData(widget.fromPage ?? "");

    log(widget.url);
  }

  void _initData(String fromPage) async {
    debugPrint('[PAYMENT_SCREEN] Initializing browser for page: $fromPage');
    browser = MyInAppBrowser(
      fromPage: fromPage,
      subscriptionId: widget.subscriptionId,
      subscriptionAmount: widget.subscriptionAmount,
    );

    if (GetPlatform.isAndroid) {
      await InAppWebViewController.setWebContentsDebuggingEnabled(kDebugMode);

      bool swAvailable = await WebViewFeature.isFeatureSupported(
          WebViewFeature.SERVICE_WORKER_BASIC_USAGE);
      bool swInterceptAvailable = await WebViewFeature.isFeatureSupported(
          WebViewFeature.SERVICE_WORKER_SHOULD_INTERCEPT_REQUEST);

      if (swAvailable && swInterceptAvailable) {
        ServiceWorkerController serviceWorkerController =
            ServiceWorkerController.instance();
        await serviceWorkerController
            .setServiceWorkerClient(ServiceWorkerClient(
          shouldInterceptRequest: (request) async {
            if (kDebugMode) {
              print(request);
            }
            return null;
          },
        ));
      }
    }

    debugPrint('[PAYMENT_SCREEN] Opening browser with URL: $selectedUrl');
    try {
      await browser.openUrlRequest(
        urlRequest: URLRequest(url: WebUri(selectedUrl!)),
        settings: InAppBrowserClassSettings(
          webViewSettings: InAppWebViewSettings(
              useShouldOverrideUrlLoading: true, useOnLoadResource: true),
          browserSettings: InAppBrowserSettings(
              hideUrlBar: true, hideToolbarTop: GetPlatform.isAndroid),
        ),
      );
      debugPrint('[PAYMENT_SCREEN] Browser opened successfully');
      _startPaymentTimeout();
      // Mark global payment guard active
      PaymentGuard.inProgress = true;
    } catch (e) {
      debugPrint('[PAYMENT_SCREEN] Error opening browser: $e');
      // Show error and navigate back
      if (mounted) {
        customSnackBar('failed_to_open_payment_gateway'.tr,
            type: ToasterMessageType.error);
        Get.back();
      }
    }
  }

  void _startPaymentTimeout() {
    _paymentTimer?.cancel();
    _paymentTimer =
        Timer(const Duration(seconds: _timeoutSeconds), _onPaymentTimeout);
  }

  void _onPaymentTimeout() {
    if (!mounted) return;
    Get.defaultDialog(
      title: 'payment_pending'.tr,
      middleText: 'no_payment_response_received'.tr,
      barrierDismissible: false,
      textCancel: 'close'.tr,
      onCancel: () {},
      textConfirm: 'retry'.tr,
      onConfirm: () async {
        Get.back();
        try {
          await browser.openUrlRequest(
            urlRequest: URLRequest(url: WebUri(selectedUrl!)),
          );
          _startPaymentTimeout();
        } catch (e) {
          customSnackBar('retry_failed'.tr, type: ToasterMessageType.error);
        }
      },
    );
  }

  @override
  void dispose() {
    _paymentTimer?.cancel();
    // Clear guard on screen dispose
    PaymentGuard.inProgress = false;
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).colorScheme.primary,
      appBar: CustomAppBar(
        title: 'payment'.tr,
      ),
      body: Center(
        child: Stack(
          children: [
            _isLoading
                ? Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        CircularProgressIndicator(
                            valueColor: AlwaysStoppedAnimation<Color>(
                                Theme.of(context).colorScheme.primary)),
                        const SizedBox(height: 16),
                        Text(
                          'opening_payment_gateway'.tr,
                          style: const TextStyle(
                            fontSize: 16,
                            color: Colors.white,
                          ),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          'please_wait'.tr,
                          style: const TextStyle(
                            fontSize: 14,
                            color: Colors.white70,
                          ),
                        ),
                      ],
                    ),
                  )
                : const SizedBox.shrink(),
          ],
        ),
      ),
    );
  }
}

class MyInAppBrowser extends InAppBrowser {
  final String fromPage;
  // Subscription context forwarded from PaymentScreen
  final String? subscriptionId;
  final String? subscriptionAmount;

  MyInAppBrowser({
    required this.fromPage,
    this.subscriptionId,
    this.subscriptionAmount,
  });

  bool _canRedirect = true;
  // Track last known gateway clues from intermediate URLs
  String? _lastPaymentId; // e.g., Razorpay pay_xxx
  String? _lastPaymentMethod; // e.g., 'razorpay'

  @override
  Future onBrowserCreated() async {
    debugPrint('[PAYMENT_BROWSER] Browser Created!');
    if (kDebugMode) {
      print("\n\nBrowser Created!\n\n");
    }
  }

  @override
  Future onLoadStart(url) async {
    debugPrint('[PAYMENT_BROWSER] Load Started: $url');
    if (kDebugMode) {
      print("\n\nStarted: $url\n\n");
    }

    // DEBUGGING: Check if backend is immediately redirecting to success
    final urlStr = url.toString();
    if (urlStr.contains('payment/razor-pay/pay') &&
        urlStr.contains('payment_id=')) {
      debugPrint(
          '[PAYMENT_DEBUG] ⚠️ BACKEND ISSUE: Immediate redirect to success detected!');
      debugPrint('[PAYMENT_DEBUG] URL: $urlStr');
      debugPrint(
          '[PAYMENT_DEBUG] This means backend is not creating new payment session');
    }

    // Do not redirect-check on start; wait for page to finish loading to avoid premature closes
    // _pageRedirect(url.toString());
  }

  @override
  Future onLoadStop(url) async {
    pullToRefreshController?.endRefreshing();
    debugPrint('[PAYMENT_BROWSER] Load Stopped: $url');
    if (kDebugMode) {
      print("\n\nStopped: $url\n\n");
    }
    _pageRedirect(url.toString());
  }

  @override
  void onLoadError(url, code, message) {
    pullToRefreshController?.endRefreshing();
    if (kDebugMode) {
      print("Can't load [$url] Error: $message");
    }

    // Handle subscription payment load errors
    if (fromPage == "subscription") {
      print("=== SUBSCRIPTION PAYMENT LOAD ERROR ===");
      print("ERROR: Failed to load payment URL: $url");
      print("ERROR Code: $code");
      print("ERROR Message: $message");
      print("=== END LOAD ERROR ===");

      // Show error and navigate back
      Get.back();
      customSnackBar("payment_page_load_error".tr,
          type: ToasterMessageType.error);
      Get.offNamed(RouteHelper.getSubscriptionPaymentResultRoute(
        flag: 'fail',
      ));
    }
  }

  @override
  void onProgressChanged(progress) {
    if (progress == 100) {
      pullToRefreshController?.endRefreshing();
    }
    if (kDebugMode) {
      print("Progress: $progress");
    }

    // Handle subscription payment progress
    if (fromPage == "subscription") {
      print("SUBSCRIPTION Payment Progress: $progress%");
      if (progress == 0) {
        print("WARNING: Payment page not loading - progress stuck at 0%");
      }
    }
  }

  @override
  void onExit() {
    if (_canRedirect) {
      // Handle subscription payment exit/back button
      if (fromPage == "subscription") {
        print("=== SUBSCRIPTION PAYMENT EXIT ===");
        print("DEBUG: User exited payment screen");
        print("=== END EXIT DEBUG ===");

        Get.back();
        Get.offNamed(RouteHelper.getSubscriptionPaymentResultRoute(
          flag: 'cancel',
        ));
        return;
      }

      showDialog(
        context: Get.context!,
        barrierDismissible: false,
        builder: (BuildContext context) {
          return const CustomPopScopeWidget(
            canPop: false,
            child: AlertDialog(
              contentPadding: EdgeInsets.all(Dimensions.paddingSizeSmall),
              content: PaymentFailedDialog(),
            ),
          );
        },
      );
    }

    if (kDebugMode) {
      print("\n\nBrowser closed!\n\n");
    }
  }

  @override
  Future<NavigationActionPolicy> shouldOverrideUrlLoading(
      navigationAction) async {
    if (kDebugMode) {
      print("\n\nOverride ${navigationAction.request.url}\n\n");
    }
    try {
      final urlStr = navigationAction.request.url?.toString() ?? '';
      if (urlStr.isNotEmpty) {
        final uri = Uri.parse(urlStr);
        final qp = uri.queryParameters;
        // Capture Razorpay verify-payment params so we can use them after redirect
        if (uri.path.contains('/payment/razor-pay/verify-payment') ||
            qp.containsKey('payment_id')) {
          _lastPaymentId = qp['payment_id'] ?? _lastPaymentId;
          _lastPaymentMethod = 'razorpay';
          if (kDebugMode) {
            print(
                '[PAYMENT_CAPTURE] method=$_lastPaymentMethod payment_id=$_lastPaymentId');
          }
        }
      }
    } catch (_) {}
    return NavigationActionPolicy.ALLOW;
  }

  @override
  void onLoadResource(resource) {}

  @override
  void onConsoleMessage(consoleMessage) {
    if (kDebugMode) {
      print("""
    console output:
      message: ${consoleMessage.message}
      messageLevel: ${consoleMessage.messageLevel.toValue()}
   """);
    }
  }

  void _pageRedirect(String url) async {
    if (kDebugMode) {
      print("inside_page_redirect");
    }
    printLog("url:$url");
    if (_canRedirect) {
      // Parse URL for robust checks
      final uri = Uri.parse(url);
      // Determine our base host from AppConstants.baseUrl
      final String baseHost = Uri.parse(AppConstants.baseUrl).host;
      final host = uri.host;
      final path = uri.path;
      final qp = uri.queryParameters;

      final bool isOurDomain =
          host == baseHost || host.endsWith('.' + baseHost);
      final bool isCallbackPath = path.contains('payment/callback') ||
          path.contains('payment/razor-pay/callback') ||
          path.contains('payment/razor-pay/pay') ||
          path.contains('payment/success') ||
          path.endsWith('/success') ||
          path.contains('payment/fail') ||
          path.endsWith('/fail');

      final String? flag = qp['flag'];
      final bool flagSuccess = flag == 'success';
      final bool flagFail = flag == 'fail';

      // Success only when backend explicitly says so or Razorpay verification keys exist
      final bool razorVerified = qp.containsKey('razorpay_payment_id') &&
          qp.containsKey('razorpay_signature');

      // Razorpay payment completion - treat /payment/razor-pay/pay with payment_id as success
      final bool razorPaymentComplete =
          path.contains('payment/razor-pay/pay') &&
              qp.containsKey('payment_id');

      // Consider success if: success flags OR razor verified OR token contains attribute_id OR razorpay payment complete
      bool tokenIndicatesSuccess = false;
      final String tokenQp = qp['token'] ?? '';
      if (tokenQp.isNotEmpty) {
        try {
          final decoded = utf8.decode(base64Url.decode(tokenQp));
          tokenIndicatesSuccess = decoded.contains('attribute_id=');
        } catch (_) {}
      }

      // FIXED: For subscription payments, only consider success if user actually interacted with payment
      bool isSuccess = false;
      if (fromPage == "subscription") {
        // For subscriptions, accept success if:
        // 1. Real razorpay success with verification params
        // 2. Success flag with token (after razorpay verification)
        // 3. Verified razorpay payment
        isSuccess = isOurDomain &&
            ((flagSuccess &&
                    tokenIndicatesSuccess) || // Success page with valid token
                (qp['status'] == 'success' &&
                    qp.containsKey('razorpay_signature')) ||
                (path.contains('payment/success') &&
                    flagSuccess &&
                    tokenIndicatesSuccess) ||
                razorVerified);

        // Do NOT auto-close on razor-pay/pay URLs for subscriptions - wait for actual payment
        if (path.contains('payment/razor-pay/pay') &&
            !qp.containsKey('razorpay_signature')) {
          print(
              '[PAYMENT_DEBUG] ⚠️ Ignoring fake success - waiting for real payment interaction');
          isSuccess = false;
        }

        // Debug the success detection
        if (isSuccess) {
          print('[PAYMENT_DEBUG] ✅ REAL SUCCESS DETECTED!');
          print('[PAYMENT_DEBUG] - flagSuccess: $flagSuccess');
          print(
              '[PAYMENT_DEBUG] - tokenIndicatesSuccess: $tokenIndicatesSuccess');
          print('[PAYMENT_DEBUG] - path: $path');
        }
      } else {
        // Service/other payments: be strict to ensure Razorpay UI actually opens
        // Do NOT treat intermediate /payment/razor-pay/pay?payment_id=... as success
        // Do NOT treat token-only presence as success
        isSuccess = isOurDomain &&
            (
              // Explicit success markers from backend
              flagSuccess ||
              qp['status'] == 'success' ||
              qp['payment_status'] == 'success' ||
              // Verified Razorpay completion (signature present)
              razorVerified
            );
        if (kDebugMode && fromPage == "checkout") {
          debugPrint('[SERVICE_PAYMENT_DEBUG] Strict success detection for checkout:');
          debugPrint('  - flagSuccess: ' + flagSuccess.toString());
          debugPrint('  - status: ' + (qp['status'] ?? '')); 
          debugPrint('  - payment_status: ' + (qp['payment_status'] ?? ''));
          debugPrint('  - razorVerified: ' + razorVerified.toString());
          debugPrint('  - tokenIndicatesSuccess (ignored): ' + tokenIndicatesSuccess.toString());
          debugPrint('  - razorPaymentComplete (ignored): ' + razorPaymentComplete.toString());
          debugPrint('  - final isSuccess: ' + isSuccess.toString());
        }
      }

      bool isFailed = flagFail ||
          (qp['status'] == 'fail' ||
              qp['payment_status'] == 'failed' ||
              path.contains('fail'));
      bool isCancel = (qp['status'] == 'cancel' ||
          qp['payment_status'] == 'cancel' ||
          path.contains('cancel'));

      if (kDebugMode) {
        print('This_called_1::::$url');
        print(
            'Redirect debug -> baseHost:$baseHost host:$host path:$path qp:${uri.query}');
        print('Callback path checks:');
        print(
            '  - path.contains("payment/callback"): ${path.contains('payment/callback')}');
        print(
            '  - path.contains("payment/razor-pay/callback"): ${path.contains('payment/razor-pay/callback')}');
        print(
            '  - path.contains("payment/razor-pay/pay"): ${path.contains('payment/razor-pay/pay')}');
        print(
            '  - path.contains("payment/success"): ${path.contains('payment/success')}');
        print('  - path.endsWith("/success"): ${path.endsWith('/success')}');
        print(
            '  - path.contains("payment/fail"): ${path.contains('payment/fail')}');
        print('  - path.endsWith("/fail"): ${path.endsWith('/fail')}');
        print(
            'Redirect result -> isSuccess:$isSuccess isFailed:$isFailed isCancel:$isCancel isCallbackPath:$isCallbackPath');
        print(
            'Debug flags -> razorVerified:$razorVerified razorPaymentComplete:$razorPaymentComplete tokenIndicatesSuccess:$tokenIndicatesSuccess');
        print('Domain check -> isOurDomain:$isOurDomain');
        print(
            'Flag values -> flag:$flag flagSuccess:$flagSuccess flagFail:$flagFail');

        // Additional debug for subscription payments
        if (fromPage == "subscription") {
          print('[SUBSCRIPTION_DEBUG] Razorpay verification check:');
          print('  - razorpay_payment_id: ${qp['razorpay_payment_id']}');
          print('  - razorpay_signature: ${qp['razorpay_signature']}');
          print('  - payment_id: ${qp['payment_id']}');
          print('  - Will close webview: ${isSuccess || isFailed || isCancel}');
        }
      }
      // Close browser if our domain reports a terminal state OR token success, even if path is non-standard
      // Also close if it's a callback path with clear status
      if (((isSuccess || isFailed || isCancel) && isOurDomain) ||
          (isCallbackPath &&
              isOurDomain &&
              (isSuccess || isFailed || isCancel))) {
        _canRedirect = false;

        // FIXED: Add delay for subscription payments to let user see the payment interface
        if (fromPage == "subscription" && isSuccess) {
          // Delay closure for subscription payments to improve UX
          Future.delayed(const Duration(seconds: 2), () {
            close();
          });
        } else {
          close();
        }
      }

      if (isSuccess) {
        // Clear global guard before navigating
        PaymentGuard.inProgress = false;
        Get.back();

        if (fromPage == "checkout") {
          String token = StringParser.parseString(url, "token");
          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
            token: token,
          ));
        } else if (fromPage == "custom-checkout") {
          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
          ));
        } else if (fromPage == "subscription") {
          print("\x1B[32m=== SUBSCRIPTION PAYMENT SUCCESS ===\x1B[0m");
          print("\x1B[32mDEBUG: Payment success callback URL: $url\x1B[0m");

          // Attempt to collect values from callback
          final String token = StringParser.parseString(url, "token");
          String transactionId = StringParser.parseString(url, "transactionId");
          String paymentMethod = StringParser.parseString(url, "paymentMethod");

          // Fallbacks for Razorpay: use values captured from verify-payment step
          if ((transactionId.isEmpty || transactionId == 'null') &&
              (_lastPaymentId?.isNotEmpty ?? false)) {
            transactionId = _lastPaymentId!;
          }
          if (paymentMethod.isEmpty || paymentMethod == 'null') {
            // Infer from path for Razorpay flow and extract actual payment method
            if (path.contains('razor-pay') ||
                (_lastPaymentMethod?.isNotEmpty ?? false)) {
              // Try to get actual payment method from query parameters
              String actualMethod = qp['method'] ?? qp['payment_method'] ?? '';
              if (actualMethod.isNotEmpty) {
                paymentMethod =
                    actualMethod; // Use actual method (e.g., 'card', 'upi', 'netbanking')
              } else {
                paymentMethod =
                    _lastPaymentMethod ?? 'razorpay'; // Fallback to razorpay
              }
            }
          }

          // CRITICAL FIX: Extract actual user_id from JWT token, not guest_id
          String userId = '';
          try {
            userId = Get.find<UserController>().userInfoModel?.id ?? '';
            if (userId.isEmpty) {
              // Extract from JWT token
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
                    final decoded =
                        utf8.decode(base64Decode(normalizedPayload));
                    final Map<String, dynamic> tokenData = jsonDecode(decoded);
                    userId = tokenData['sub']?.toString() ?? '';
                    debugPrint(
                        '\x1B[32m[PAYMENT_SUCCESS] Extracted real user_id from token: $userId\x1B[0m');
                  }
                }
              }
            }
          } catch (e) {
            debugPrint('[PAYMENT_SUCCESS][ERR] Failed to extract user_id: $e');
            userId = Get.find<SplashController>().getGuestId();
          }

          // Additional debug for payment method extraction
          debugPrint(
              "\x1B[32mDEBUG: Payment method extraction - path: $path\x1B[0m");
          debugPrint("DEBUG: Query params method: ${qp['method']}");
          debugPrint(
              "DEBUG: Query params payment_method: ${qp['payment_method']}");
          debugPrint(
              "\x1B[32mDEBUG: Final paymentMethod: $paymentMethod\x1B[0m");

          print("\x1B[32mDEBUG: Extracted token: $token\x1B[0m");
          print(
              "\x1B[32mDEBUG: Extracted transactionId: $transactionId\x1B[0m");
          print(
              "\x1B[32mDEBUG: Extracted paymentMethod: $paymentMethod\x1B[0m");
          print("\x1B[32mDEBUG: Using user_id: $userId\x1B[0m");

          // CRITICAL: Immediately call the subscription creation API
          if (subscriptionId != null &&
              subscriptionId!.isNotEmpty &&
              userId.isNotEmpty) {
            final int numericSubscriptionId =
                int.tryParse(subscriptionId!) ?? 26;
            final double amount =
                double.tryParse(subscriptionAmount ?? '2499') ?? 2499.0;

            debugPrint(
                '\x1B[32m[PAYMENT_SUCCESS] Immediately creating subscription in backend\x1B[0m');
            debugPrint(
                '\x1B[32m[PAYMENT_SUCCESS] subscription_id: $numericSubscriptionId, amount: $amount, user_id: $userId\x1B[0m');

            // Call the subscription controller to handle payment success immediately
            try {
              final subscriptionController = Get.find<SubscriptionController>();

              // Force update subscription status immediately
              Future.microtask(() async {
                try {
                  await subscriptionController.forceUpdateSubscriptionStatus(
                      numericSubscriptionId, true);
                  debugPrint(
                      '\x1B[32m[PAYMENT_SUCCESS] Local status updated immediately\x1B[0m');

                  // Then handle the full payment success flow
                  await subscriptionController.handlePaymentSuccess(
                    subscriptionId: numericSubscriptionId,
                    userId: userId,
                    transactionId: transactionId.isNotEmpty
                        ? transactionId
                        : 'razorpay_${DateTime.now().millisecondsSinceEpoch}',
                  );
                  debugPrint(
                      '\x1B[32m[PAYMENT_SUCCESS] Backend subscription creation completed\x1B[0m');
                } catch (e) {
                  debugPrint(
                      '[PAYMENT_SUCCESS][ERR] Error in payment success handling: $e');
                }
              });
            } catch (e) {
              debugPrint(
                  '[PAYMENT_SUCCESS][ERR] Error getting subscription controller: $e');
            }
          }

          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
            paymentData: {
              'subscriptionId': subscriptionId,
              'amount': subscriptionAmount,
              'transactionId': transactionId,
              'paymentMethod': paymentMethod,
              'user_id': userId, // Use the correct user_id
              // Optionally pass raw token for server-side verification if needed later
              'token': token,
            },
          ));
        } else if (fromPage == "add-fund") {
          String uuid = const Uuid().v1();
          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
            token: uuid,
          ));
        } else if (fromPage == "repeat-booking") {
          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
          ));
        } else if (fromPage == "switch-payment-method") {
          Get.offNamed(RouteHelper.getPaymentWaitingRoute(
            fromPage: fromPage,
          ));
        }
      } else if (isFailed || isCancel) {
        // Clear guard on non-success terminal states
        PaymentGuard.inProgress = false;
        if (fromPage == "add-fund") {
          Get.offNamed(RouteHelper.getMyWalletScreen(flag: 'failed'));
        } else if (fromPage == "repeat-booking") {
          Get.back();
          customSnackBar("payment_failed_try_again".tr,
              type: ToasterMessageType.error, showDefaultSnackBar: false);
        } else if (fromPage == "subscription") {
          Get.back();
          print("=== SUBSCRIPTION PAYMENT FAILED ===");
          print("DEBUG: Payment failed callback URL: $url");
          print("DEBUG: Reason - isFailed: $isFailed, isCancel: $isCancel");
          print("=== END FAILED DEBUG ===");

          // For subscription payment failures, pass the flag only
          Get.offNamed(RouteHelper.getSubscriptionPaymentResultRoute(
            flag: 'fail',
          ));
        } else {
          Get.offNamed(RouteHelper.getOrderSuccessRoute('fail'));
        }
      } else {
        // Handle case where payment status is unclear
        if (fromPage == "subscription") {
          print("=== SUBSCRIPTION PAYMENT UNCLEAR STATUS ===");
          print("DEBUG: Unclear status callback URL: $url");
          print(
              "DEBUG: isSuccess: $isSuccess, isFailed: $isFailed, isCancel: $isCancel");
          print("=== END UNCLEAR DEBUG ===");
          // Do not close the WebView on intermediate URLs. Wait for explicit callback.
        }
      }
    }
  }
}
