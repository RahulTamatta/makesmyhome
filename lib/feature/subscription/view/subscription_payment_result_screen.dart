import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class SubscriptionPaymentResultScreen extends StatefulWidget {
  final String? flag;
  final String? subscriptionId;
  final String? amount;
  final String? transactionId;
  final String? paymentMethod;

  const SubscriptionPaymentResultScreen({
    super.key,
    this.flag,
    this.subscriptionId,
    this.amount,
    this.transactionId,
    this.paymentMethod,
  });

  @override
  State<SubscriptionPaymentResultScreen> createState() =>
      _SubscriptionPaymentResultScreenState();
}

class _SubscriptionPaymentResultScreenState
    extends State<SubscriptionPaymentResultScreen> {
  bool _isProcessing = false;

  @override
  void initState() {
    super.initState();
    // Defer to next frame to avoid setState during build
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (mounted) {
        _handlePaymentResult();
      }
    });
  }

  void _handlePaymentResult() async {
    debugPrint('[SUBSCRIBE][RESULT] SubscriptionPaymentResultScreen initialized with:');
    debugPrint('[SUBSCRIBE][RESULT]   - flag: ${widget.flag}');
    debugPrint('[SUBSCRIBE][RESULT]   - subscriptionId: ${widget.subscriptionId}');
    debugPrint('[SUBSCRIBE][RESULT]   - amount: ${widget.amount}');
    debugPrint('[SUBSCRIBE][RESULT]   - transactionId: ${widget.transactionId}');
    debugPrint('[SUBSCRIBE][RESULT]   - paymentMethod: ${widget.paymentMethod}');
    
    if (widget.flag == 'success') {
      if (mounted) {
        setState(() {
          _isProcessing = true;
        });
      }

      try {
        final controller = Get.find<SubscriptionController>();
        final dynamic rawUserId = Get.find<UserController>().userInfoModel?.id ??
            Get.find<SplashController>().getGuestId();
        final String userIdStr = rawUserId?.toString() ?? '';

        debugPrint('[SUBSCRIBE][RESULT] Processing success');
        debugPrint('[SUBSCRIBE][RESULT] user_id=$userIdStr subId=${widget.subscriptionId} amount=${widget.amount} txn=${widget.transactionId}');

        // FIXED: Use actual payment method from widget instead of hardcoded 'makemyhome'
        final String paymentMethod = widget.paymentMethod ?? 'makemyhome';
        debugPrint('[SUBSCRIBE][RESULT] Using payment method: $paymentMethod (from widget: ${widget.paymentMethod})');

        if ((widget.subscriptionId ?? '').isNotEmpty && userIdStr.isNotEmpty) {
          final double amount = double.tryParse(widget.amount ?? '0') ?? 0.0;
          if (amount > 0) {
            // Resolve numeric subscription id (server expects numeric)
            int? subIdInt = int.tryParse(widget.subscriptionId!);
            if (subIdInt == null) {
              // subscriptionId arrived as UUID; try to map from cache
              try {
                final subs = controller.subscriptions;
                for (final s in subs) {
                  if (s.id == widget.subscriptionId) {
                    subIdInt = s.subscriptionId;
                    break;
                  }
                }
                debugPrint('[SUBSCRIBE][RESULT] Resolved numeric subscriptionId from UUID -> $subIdInt');
              } catch (_) {}
            }

            if ((subIdInt ?? 0) > 0) {
              debugPrint('[SUBSCRIBE][RESULT] About to call subscribeUser API with:');
              debugPrint('[SUBSCRIBE][RESULT]   - subscriptionId: $subIdInt');
              debugPrint('[SUBSCRIBE][RESULT]   - amount: $amount');
              debugPrint('[SUBSCRIBE][RESULT]   - transactionId: ${widget.transactionId}');
              debugPrint('[SUBSCRIBE][RESULT]   - paymentMethod: $paymentMethod');
              debugPrint('[SUBSCRIBE][RESULT]   - user_id: $userIdStr');
              
              await controller.subscribeUser(
                subscriptionId: subIdInt!,
                amount: amount,
                transactionId: widget.transactionId ?? 'pending',
                paymentMethod: paymentMethod,
                user_id: userIdStr,
              );
              debugPrint('[SUBSCRIBE][RESULT] Subscribe API invoked');

              await controller.fetchUserSubscriptions();
              debugPrint('[SUBSCRIBE][RESULT] Refreshed user subscriptions');
            } else {
              debugPrint('[SUBSCRIBE][RESULT][WARN] Could not resolve numeric subscriptionId; skipping POST');
              await controller.fetchSubscriptions();
            }
          } else {
            debugPrint('[SUBSCRIBE][RESULT][WARN] Invalid amount, skipping POST');
            await controller.fetchSubscriptions();
          }
        } else {
          debugPrint('[SUBSCRIBE][RESULT][WARN] Missing subscriptionId or userId, refreshing list');
          await controller.fetchSubscriptions();
        }

        await Future.delayed(const Duration(seconds: 1));
      } catch (e) {
        debugPrint('[SUBSCRIBE][RESULT][ERR] $e');
        try {
          await Get.find<SubscriptionController>().fetchSubscriptions();
        } catch (_) {}
      }

      if (mounted) {
        setState(() {
          _isProcessing = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    final bool isSuccess = widget.flag == 'success';

    return Scaffold(
      backgroundColor: Theme.of(context).cardColor,
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(Dimensions.paddingSizeLarge),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              // Status Icon
              Container(
                height: 100,
                width: 100,
                decoration: BoxDecoration(
                  color: isSuccess
                      ? Colors.green.withValues(alpha: 0.1)
                      : Colors.red.withValues(alpha: 0.1),
                  shape: BoxShape.circle,
                ),
                child: Icon(
                  isSuccess ? Icons.check_circle : Icons.cancel,
                  size: 60,
                  color: isSuccess ? Colors.green : Colors.red,
                ),
              ),

              const SizedBox(height: Dimensions.paddingSizeLarge),

              // Status Title
              Text(
                isSuccess
                    ? 'subscription_successful'.tr
                    : 'subscription_failed'.tr,
                style: robotoBold.copyWith(
                  fontSize: Dimensions.fontSizeExtraLarge,
                  color: isSuccess ? Colors.green : Colors.red,
                ),
                textAlign: TextAlign.center,
              ),

              const SizedBox(height: Dimensions.paddingSizeDefault),

              // Status Message
              Text(
                isSuccess
                    ? 'your_subscription_has_been_activated_successfully'.tr
                    : 'subscription_payment_failed_please_try_again'.tr,
                style: robotoRegular.copyWith(
                  fontSize: Dimensions.fontSizeDefault,
                  color: Theme.of(context).disabledColor,
                ),
                textAlign: TextAlign.center,
              ),

              if (_isProcessing) ...[
                const SizedBox(height: Dimensions.paddingSizeLarge),
                const CircularProgressIndicator(),
                const SizedBox(height: Dimensions.paddingSizeDefault),
                Text(
                  'processing_subscription'.tr,
                  style: robotoRegular.copyWith(
                    fontSize: Dimensions.fontSizeSmall,
                    color: Theme.of(context).disabledColor,
                  ),
                ),
              ],

              const SizedBox(height: Dimensions.paddingSizeExtraLarge),

              // Action Buttons
              Row(
                children: [
                  if (!isSuccess) ...[
                    Expanded(
                      child: CustomButton(
                        buttonText: 'try_again'.tr,
                        onPressed: () {
                          // Navigate back to all subscriptions screen
                          Get.back();
                        },
                      ),
                    ),
                    const SizedBox(width: Dimensions.paddingSizeDefault),
                  ],
                  Expanded(
                    child: CustomButton(
                      buttonText: isSuccess
                          ? 'view_subscriptions'.tr
                          : 'back_to_home'.tr,
                      onPressed: () {
                        if (isSuccess) {
                          // Navigate to user subscriptions
                          Get.offAllNamed(RouteHelper.getMainRoute("home"));
                          // You can add navigation to user subscriptions screen here
                        } else {
                          Get.offAllNamed(RouteHelper.getMainRoute("home"));
                        }
                      },
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
