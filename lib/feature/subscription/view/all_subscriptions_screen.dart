import 'dart:convert';

import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';
import 'package:universal_html/html.dart' as html;

class AllSubscriptionsScreen extends StatelessWidget {
  const AllSubscriptionsScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      endDrawer:
          ResponsiveHelper.isDesktop(context) ? const MenuDrawer() : null,
      appBar: CustomAppBar(
        title: 'All Subscriptions'.tr,
        onBackPressed: () => Get.back(),
        actionWidget: IconButton(
          icon: const Icon(Icons.refresh),
          onPressed: () async {
            final controller = Get.find<SubscriptionController>();
            await controller.refreshSubscriptionStatus();
          },
        ),
      ),
      body: GetBuilder<SubscriptionController>(
        builder: (subscriptionController) {
          return RefreshIndicator(
            onRefresh: () async {
              await subscriptionController.fetchSubscriptions();
            },
            child: Obx(() {
              if (subscriptionController.isLoading.value) {
                return const Center(child: CircularProgressIndicator());
              }

              if (subscriptionController.subscriptions.isEmpty) {
                return Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.subscriptions_outlined,
                        size: 100,
                        color: Theme.of(context).disabledColor,
                      ),
                      const SizedBox(height: Dimensions.paddingSizeDefault),
                      Text(
                        'no_subscriptions_available'.tr,
                        style: robotoMedium.copyWith(
                          fontSize: Dimensions.fontSizeLarge,
                          color: Theme.of(context).disabledColor,
                        ),
                      ),
                    ],
                  ),
                );
              }

              return ResponsiveHelper.isDesktop(context)
                  ? _buildWebView(context, subscriptionController)
                  : _buildMobileView(context, subscriptionController);
            }),
          );
        },
      ),
    );
  }

  Widget _buildMobileView(
      BuildContext context, SubscriptionController controller) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
      child: Column(
        children: [
          GridView.builder(
            physics: const NeverScrollableScrollPhysics(),
            shrinkWrap: true,
            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 2,
              crossAxisSpacing: Dimensions.paddingSizeDefault,
              mainAxisSpacing: Dimensions.paddingSizeDefault,
              childAspectRatio: 0.75,
            ),
            itemCount: controller.subscriptions.length,
            itemBuilder: (context, index) {
              return _buildSubscriptionCard(
                  context, controller.subscriptions[index]);
            },
          ),
        ],
      ),
    );
  }

  Widget _buildWebView(
      BuildContext context, SubscriptionController controller) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
      child: Center(
        child: SizedBox(
          width: Dimensions.webMaxWidth,
          child: GridView.builder(
            physics: const NeverScrollableScrollPhysics(),
            shrinkWrap: true,
            gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 4,
              crossAxisSpacing: Dimensions.paddingSizeDefault,
              mainAxisSpacing: Dimensions.paddingSizeDefault,
              childAspectRatio: 0.8,
            ),
            itemCount: controller.subscriptions.length,
            itemBuilder: (context, index) {
              return _buildSubscriptionCard(
                  context, controller.subscriptions[index]);
            },
          ),
        ),
      ),
    );
  }

  Widget _buildSubscriptionCard(BuildContext context, subscription) {
    return Container(
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withValues(alpha: 0.1),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Subscription Image
            Expanded(
              flex: 3,
              child: ClipRRect(
                borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
                child: CustomImage(
                  image: _cleanImageUrl(subscription.image ?? ""),
                  fit: BoxFit.cover,
                ),
              ),
            ),

            const SizedBox(height: Dimensions.paddingSizeSmall),

            // Subscription Name
            Text(
              subscription.name ?? "",
              style: robotoBold.copyWith(
                fontSize: Dimensions.fontSizeDefault,
                color: Theme.of(context).textTheme.bodyLarge!.color,
              ),
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),

            const SizedBox(height: Dimensions.paddingSizeExtraSmall),

            // Short Description
            Text(
              subscription.shortDescription ?? "",
              style: robotoRegular.copyWith(
                fontSize: Dimensions.fontSizeSmall,
                color: Theme.of(context).hintColor,
              ),
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
            ),

            const SizedBox(height: Dimensions.paddingSizeSmall),

            // Price and Duration Row
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  PriceConverter.convertPrice(
                      double.tryParse(subscription.price?.toString() ?? '0') ??
                          0.0),
                  style: robotoBold.copyWith(
                    fontSize: Dimensions.fontSizeDefault,
                    color: Theme.of(context).primaryColor,
                  ),
                ),
                Row(
                  children: [
                    Icon(
                      Icons.schedule,
                      size: 14,
                      color: Theme.of(context).hintColor,
                    ),
                    const SizedBox(width: 2),
                    Text(
                      "${subscription.duration} days",
                      style: robotoRegular.copyWith(
                        fontSize: Dimensions.fontSizeSmall,
                        color: Theme.of(context).hintColor,
                      ),
                    ),
                  ],
                ),
              ],
            ),

            const SizedBox(height: Dimensions.paddingSizeSmall),

            // Subscribe Button
            SizedBox(
              width: double.infinity,
              child: GetBuilder<SubscriptionController>(
                builder: (subscriptionCtrl) {
                  final bool isSubscribed = subscriptionCtrl
                      .isUserSubscribed(subscription.subscriptionId ?? 0);
                  
                  // FIXED: Also check the subscription object's subscribed field
                  final bool isActuallySubscribed = isSubscribed || (subscription.subscribed ?? false);
                  
                  debugPrint('[ALL_SUBS_BUTTON] Subscription ID: ${subscription.subscriptionId}, isSubscribed: $isSubscribed, subscribed field: ${subscription.subscribed}, final status: $isActuallySubscribed');
                  debugPrint('[ALL_SUBS_BUTTON] Subscription Name: ${subscription.name}');
                  
                  return CustomButton(
                    buttonText: isActuallySubscribed
                            ? 'Subscribed'.tr
                            : 'Subscribe Now'.tr,
                    fontSize: Dimensions.fontSizeSmall,
                    height: 35,
                    backgroundColor: isActuallySubscribed
                        ? Colors.green
                        : Colors.red,
                    onPressed: () {
                      if (isActuallySubscribed) {
                        debugPrint('[ALL_SUBS_BUTTON] User already subscribed to ${subscription.subscriptionId}');
                        customSnackBar('already_subscribed'.tr,
                            type: ToasterMessageType.info,
                            showDefaultSnackBar: false);
                        return;
                      }
                      print("DEBUG: *** MAIN BUTTON CLICKED - SHOULD ONLY GO TO RAZORPAY ***");
                      print("DEBUG: *** SUBSCRIPTION ID: ${subscription.subscriptionId} ***");
                      debugPrint('[ALL_SUBS_BUTTON] Initiating payment for ${subscription.subscriptionId}');
                      _initiatePaymentFlow(context, subscription);
                    },
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showSubscriptionDialog(BuildContext context, dynamic subscription) {
    print("DEBUG: *** _showSubscriptionDialog called ***");
    print("DEBUG: *** Showing confirmation dialog ***");
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Confirm subscription'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text('Subscription Name: ${subscription.name ?? ''}'),
              const SizedBox(height: 8),
              Text('Price: '
                  '${PriceConverter.convertPrice(double.tryParse(subscription.price?.toString() ?? '0') ?? 0.0)}'),
              const SizedBox(height: 8),
              Text('Duration: ${subscription.duration} days'),
              const SizedBox(height: 16),
              const Text('confirm subscription message'),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Get.back(),
              child: Text('cancel'.tr),
            ),
            ElevatedButton(
              onPressed: () {
                print("DEBUG: *** User clicked CONFIRM in subscription dialog ***");
                Get.back();
                _showPayWithMakeMyHomeDialog(context, subscription);
              },
              child: Text('confirm'.tr),
            ),
          ],
        );
      },
    );
  }

  void _showPayWithMakeMyHomeDialog(BuildContext context, dynamic subscription) {
    print("DEBUG: *** _showPayWithMakeMyHomeDialog called ***");
    print("DEBUG: *** Showing payment method dialog ***");
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount =
        double.tryParse(rawPrice) ??
            double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\\\.]'), '')) ??
            0.0;
    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        title: Text('complete_payment'.tr),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('${'total_amount'.tr}: ${PriceConverter.convertPrice(amount)}'),
            const SizedBox(height: 8),
            Text('Choose payment method:', style: robotoMedium),
            const SizedBox(height: 12),
            // FIXED: Add Razorpay option
            Row(
              children: [
                Icon(Icons.payment, color: Theme.of(context).primaryColor),
                const SizedBox(width: 8),
                Text('Pay with Razorpay', style: robotoRegular),
              ],
            ),
          ],
        ),
        actions: [
          TextButton(onPressed: ()=> Get.back(), child: Text('cancel'.tr)),
          ElevatedButton(
            onPressed: (){
              Get.back();
              // FIXED: Force Razorpay payment instead of direct subscription
              print("DEBUG: *** User clicked Pay with Razorpay button ***");
              print("DEBUG: *** About to call _initiateRazorpayPayment ***");
              _initiateRazorpayPayment(subscription);
            },
            child: Text('pay_with_razorpay'.tr),
          ),
        ],
      ),
    );
  }

  void _initiatePaymentFlow(BuildContext context, subscription) {
    print("DEBUG: *** _initiatePaymentFlow method called ***");
    print("DEBUG: *** This should show dialog, then go to Razorpay ***");
    
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount =
        double.tryParse(rawPrice) ??
            double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
            0.0;

    if (amount <= 0) {
      customSnackBar('invalid_subscription_amount'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
      return;
    }

    print("DEBUG: _initiatePaymentFlow -> rawPrice: $rawPrice, amount: $amount");

    // Show confirmation dialog first
    _showSubscriptionDialog(context, subscription);
  }


  void _initiateRazorpayPayment(subscription) {
    print("DEBUG: *** _initiateRazorpayPayment method called ***");
    print("DEBUG: *** This should open Razorpay, not direct subscription ***");
    
    // FIXED: Add authentication check
    final auth = Get.find<AuthController>();
    if (!auth.isLoggedIn()) {
      Get.toNamed(
          RouteHelper.getNotLoggedScreen(RouteHelper.checkout, "subscription"));
      return;
    }

    String userId = Get.find<UserController>().userInfoModel?.id ??
        Get.find<SplashController>().getGuestId();
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount =
        double.tryParse(rawPrice) ??
            double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
            0.0;

    print("DEBUG: Starting Razorpay payment process");
    print("DEBUG: User ID: $userId");
    print("DEBUG: Raw Price: $rawPrice");
    print("DEBUG: Amount: $amount");
    print("DEBUG: Subscription ID: ${subscription.id}");

    // FIXED: Add validation before opening Razorpay
    if (userId.toString().trim().isEmpty) {
      customSnackBar('please_login_first'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
      return;
    }

    if (amount <= 0) {
      customSnackBar('invalid_subscription_amount'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
      return;
    }

    if (subscription.id == null) {
      customSnackBar('invalid_subscription_selected'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
      return;
    }

    // Build callback like working flows
    String platform = GetPlatform.isWeb ? "web" : "app";
    String callbackUrl;
    if (GetPlatform.isWeb) {
      String hostname = html.window.location.hostname!;
      String protocol = html.window.location.protocol;
      String port = html.window.location.port;
      callbackUrl = "$protocol//$hostname${port.isNotEmpty ? ':$port' : ''}/payment/success";
    } else {
      callbackUrl = "${AppConstants.baseUrl}/payment/success";
    }

    AddressModel? address = CheckoutHelper.selectedAddressModel(
      selectedAddress: Get.find<LocationController>().selectedAddress,
      pickedAddress: Get.find<LocationController>().getUserAddress(),
      selectedLocationType:
          Get.find<LocationController>().selectedServiceLocationType,
    );
    String addressId = (address?.id == "null" || address?.id == null)
        ? ""
        : (address?.id ?? "");
    String zoneId =
        Get.find<LocationController>().getUserAddress()?.zoneId ?? "";
    String? schedule = Get.find<ScheduleController>().scheduleTime;

    try {
      String accessToken = base64Url.encode(utf8.encode(userId.toString()));
      
      // Validate required parameters
      String subscriptionId = (subscription.id ?? '').toString();
      if (subscriptionId.isEmpty) {
        print("ERROR: Subscription ID is empty");
        customSnackBar('invalid_subscription_id'.tr,
            showDefaultSnackBar: false, type: ToasterMessageType.error);
        return;
      }
      
      if (userId.isEmpty) {
        print("ERROR: User ID is empty");
        customSnackBar('user_not_logged_in'.tr,
            showDefaultSnackBar: false, type: ToasterMessageType.error);
        return;
      }
      
      print("DEBUG: Subscription ID: $subscriptionId");
      print("DEBUG: User ID: $userId");
      print("DEBUG: Amount: $amount");
      print("DEBUG: Subscription object ID: ${subscription.id}");
      print("DEBUG: Subscription object subscriptionId: ${subscription.subscriptionId}");
      
      // FIXED: Use correct parameter names that backend expects
      // Backend expects 'package_id' (subscription UUID) and 'provider_id' (user UUID)
      final Map<String, String> params = {
        'payment_method': 'razor_pay',
        'provider_id': userId.toString(), // User ID as provider_id (backend expects UUID)
        'package_id': subscriptionId, // Subscription ID as package_id (backend expects UUID)
        'access_token': accessToken,
        'amount': amount.toString(),
        'payment_platform': platform,
        'payment_type': 'subscription',
        'service_location': 'customer',
        'callback': callbackUrl,
      };

      // Always include zone_id if available
      if (zoneId.isNotEmpty) params['zone_id'] = zoneId;

      // Satisfy PaymentController validators:
      // - Always provide service_schedule (use now if not set)
      final String effectiveSchedule =
          (schedule != null && schedule.toString().isNotEmpty)
              ? schedule.toString()
              : DateTime.now().toIso8601String();
      params['service_schedule'] = effectiveSchedule;

      // - Provide service_address_id if present; otherwise include service_address payload
      if (addressId.isNotEmpty) {
        params['service_address_id'] = addressId;
      } else if (address != null) {
        final Map<String, dynamic> sa = {
          'lat': address.latitude ?? 0,
          'lon': address.longitude ?? 0,
          'address': address.address ?? '',
          'contact_person_name': address.contactPersonName ?? '',
          'contact_person_number': address.contactPersonNumber ?? '',
          'address_label': address.addressLabel ?? 'subscription',
        };
        params['service_address'] = base64Encode(utf8.encode(jsonEncode(sa)));
      }

      final query = params.entries
          .map((e) => '${e.key}=${Uri.encodeComponent(e.value)}')
          .join('&');
      final url = '${AppConstants.baseUrl}/payment/subscription?$query';

      print("DEBUG: Subscription Payment URL: $url");
      print("DEBUG: Payment Parameters:");
      params.forEach((key, value) {
        print("  $key: $value");
      });
      
      // FIXED: Add validation before opening payment gateway
      if (!url.contains('package_id=') || !url.contains('provider_id=')) {
        print("ERROR: Missing required parameters in payment URL");
        customSnackBar('payment_parameters_missing'.tr,
            showDefaultSnackBar: false, type: ToasterMessageType.error);
        return;
      }

      if (GetPlatform.isWeb) {
        print("DEBUG: *** OPENING WEB PAYMENT ***");
        printLog("subscription_payment_url_web:$url");
        html.window.open(url, "_self");
      } else {
        print("DEBUG: *** OPENING MOBILE PAYMENT WEBVIEW ***");
        print("DEBUG: *** About to navigate to PaymentScreen ***");
        printLog("subscription_payment_url_mobile:$url");
        Get.to(() => PaymentScreen(
              url: url,
              fromPage: "subscription",
              subscriptionId: (subscription.id ?? '').toString(),
              subscriptionAmount: amount.toString(),
            ));
        print("DEBUG: *** PaymentScreen navigation initiated ***");
      }
    } catch (e) {
      print("ERROR: Failed to initiate payment: $e");
      customSnackBar('payment_initiation_failed'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
    }
  }

  // This method will be called after successful payment
  void _completeSubscription({
    required subscription,
    required String transactionId,
    required String paymentMethod,
  }) {
    final controller = Get.find<SubscriptionController>();
    final dynamic rawUserId = Get.find<UserController>().userInfoModel?.id ??
        Get.find<SplashController>().getGuestId();
    final String userId = rawUserId?.toString() ?? '';
    final amount =
        double.tryParse(subscription.price?.toString() ?? '0') ?? 0.0;

    debugPrint('[SUBSCRIBE][ALL] Completing subscription user_id=$userId subId=${subscription.id} amount=$amount txn=$transactionId');
    controller.subscribeUser(
      subscriptionId: subscription.id ?? 0,
      amount: amount,
      transactionId: transactionId,
      paymentMethod: 'makemyhome',
      user_id: userId,
    );
  }

  String _cleanImageUrl(String imageUrl) {
    if (imageUrl.isEmpty)
      return Images.placeholder; // Return placeholder for empty URLs

    // Remove newline characters and other whitespace
    String cleanedUrl = imageUrl
        .replaceAll('\n', '')
        .replaceAll('\r', '')
        .replaceAll('%0A', '')
        .replaceAll('%0D', '')
        .trim();

    // Return placeholder if URL is still empty after cleaning
    return cleanedUrl.isEmpty ? Images.placeholder : cleanedUrl;
  }
}
