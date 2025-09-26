import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';

class PaymentWaitingScreen extends StatefulWidget {
  final String fromPage;
  final String? token;
  final Map<String, dynamic>? paymentData;

  const PaymentWaitingScreen({
    Key? key,
    required this.fromPage,
    this.token,
    this.paymentData,
  }) : super(key: key);

  @override
  State<PaymentWaitingScreen> createState() => _PaymentWaitingScreenState();
}

class _PaymentWaitingScreenState extends State<PaymentWaitingScreen>
    with TickerProviderStateMixin {
  late AnimationController _controller;
  late Animation<double> _animation;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(
      duration: const Duration(seconds: 2),
      vsync: this,
    )..repeat();
    _animation = CurvedAnimation(parent: _controller, curve: Curves.linear);

    // Process payment after showing waiting screen
    _processPayment();
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  Future<void> _processPayment() async {
    // Show waiting screen for at least 2 seconds for better UX
    await Future.delayed(const Duration(seconds: 2));

    try {
      if (widget.fromPage == "checkout") {
        // Refresh cart data
        await Get.find<CartController>().getCartListFromServer();
        
        // Navigate to checkout complete
        Get.offNamed(RouteHelper.getCheckoutRoute(
          RouteHelper.checkout, 
          'complete', 
          'null',
          token: widget.token ?? '',
        ));
      } else if (widget.fromPage == "custom-checkout") {
        // Navigate to order success
        Get.offNamed(RouteHelper.getOrderSuccessRoute('success'));
      } else if (widget.fromPage == "subscription") {
        // Handle subscription success
        final data = widget.paymentData;
        debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Processing subscription payment data: $data');
        
        if (data != null) {
          // Parse and validate subscription data
          final subscriptionId = int.tryParse(data['subscriptionId']?.toString() ?? '0') ?? 0;
          final amount = double.tryParse(data['amount']?.toString() ?? '0.0') ?? 0.0;
          final transactionId = data['transactionId']?.toString() ?? '';
          final paymentMethod = data['paymentMethod']?.toString() ?? 'razorpay';
          final userId = data['user_id']?.toString() ?? '';
          
          debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Parsed data:');
          debugPrint('  - subscriptionId: $subscriptionId');
          debugPrint('  - amount: $amount');
          debugPrint('  - transactionId: $transactionId');
          debugPrint('  - paymentMethod: $paymentMethod');
          debugPrint('  - userId: $userId');
          
          if (subscriptionId > 0 && amount > 0 && userId.isNotEmpty) {
            debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Calling subscribeUser API...');
            try {
              await Get.find<SubscriptionController>().subscribeUser(
                subscriptionId: subscriptionId,
                amount: amount,
                transactionId: transactionId,
                paymentMethod: paymentMethod,
                user_id: userId,
              );
              debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Subscription API call completed');
              
              // Refresh subscription list to get updated status
              debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Refreshing subscription list...');
              await Get.find<SubscriptionController>().fetchSubscriptions();
              debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Subscription list refreshed');
            } catch (e) {
              debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Subscription API call failed: $e');
            }
          } else {
            debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] Invalid subscription data - skipping API call');
          }
        } else {
          debugPrint('[PAYMENT_WAITING][SUBSCRIPTION] No payment data provided');
        }
        
        Get.offNamed(RouteHelper.getSubscriptionPaymentResultRoute(
          flag: 'success',
          subscriptionId: data?['subscriptionId']?.toString() ?? '',
          amount: data?['amount']?.toString() ?? '',
          transactionId: data?['transactionId'] ?? '',
          paymentMethod: data?['paymentMethod'] ?? '',
        ));
      } else if (widget.fromPage == "add-fund") {
        Get.offNamed(RouteHelper.getMyWalletScreen(
          flag: 'success', 
          token: widget.token ?? '',
        ));
      } else if (widget.fromPage == "repeat-booking") {
        Get.back();
        customSnackBar(
          'payment_successful'.tr,
          type: ToasterMessageType.success,
        );
      } else if (widget.fromPage == "switch-payment-method") {
        Get.back();
        customSnackBar(
          'your_payment_confirm_successfully'.tr,
          toasterTitle: 'payment_status'.tr,
          type: ToasterMessageType.success,
          duration: 4,
        );
      }
    } catch (e) {
      // Handle error - navigate to appropriate failure screen
      if (widget.fromPage == "subscription") {
        Get.offNamed(RouteHelper.getSubscriptionPaymentResultRoute(flag: 'fail'));
      } else {
        Get.offNamed(RouteHelper.getOrderSuccessRoute('fail'));
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).colorScheme.background,
      body: SafeArea(
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // Animated loading indicator
              RotationTransition(
                turns: _animation,
                child: Container(
                  width: 80,
                  height: 80,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    border: Border.all(
                      color: Theme.of(context).colorScheme.primary,
                      width: 4,
                    ),
                  ),
                  child: Container(
                    margin: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      shape: BoxShape.circle,
                      color: Theme.of(context).colorScheme.primary,
                    ),
                    child: Icon(
                      Icons.payment,
                      color: Colors.white,
                      size: 32,
                    ),
                  ),
                ),
              ),
              
              const SizedBox(height: 32),
              
              // Processing text
              Text(
                'processing_payment'.tr,
                style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                  fontWeight: FontWeight.w600,
                  color: Theme.of(context).colorScheme.primary,
                ),
                textAlign: TextAlign.center,
              ),
              
              const SizedBox(height: 16),
              
              Text(
                'please_wait_while_we_process_your_payment'.tr,
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                  color: Theme.of(context).textTheme.bodyMedium?.color?.withOpacity(0.7),
                ),
                textAlign: TextAlign.center,
              ),
              
              const SizedBox(height: 48),
              
              // Progress indicator
              Container(
                width: 200,
                height: 4,
                decoration: BoxDecoration(
                  color: Theme.of(context).colorScheme.primary.withOpacity(0.2),
                  borderRadius: BorderRadius.circular(2),
                ),
                child: AnimatedBuilder(
                  animation: _animation,
                  builder: (context, child) {
                    return FractionallySizedBox(
                      alignment: Alignment.centerLeft,
                      widthFactor: (_animation.value * 0.8) + 0.2,
                      child: Container(
                        decoration: BoxDecoration(
                          color: Theme.of(context).colorScheme.primary,
                          borderRadius: BorderRadius.circular(2),
                        ),
                      ),
                    );
                  },
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
