import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'dart:convert';
import 'package:makesmyhome/feature/subscription/view/all_subscriptions_screen.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';
import 'package:universal_html/html.dart' as html;
import 'package:makesmyhome/helper/route_helper.dart';

class SubscriptionView extends StatelessWidget {
  // Helper method to build placeholder image
  Widget _buildPlaceholderImage() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.grey[200],
        borderRadius: BorderRadius.circular(12),
      ),
      child: const Center(
        child: Icon(Icons.image, size: 40, color: Colors.grey),
      ),
    );
  }

  // Optimized network image with loading and error handling
  Widget _buildNetworkImage(String? url) {
    if (url == null || url.isEmpty) return _buildPlaceholderImage();
    return Image.network(
      url,
      fit: BoxFit.cover,
      loadingBuilder: (context, child, progress) {
        if (progress == null) return child;
        return Container(
          decoration: BoxDecoration(
            color: Colors.grey[100],
            borderRadius: BorderRadius.circular(12),
          ),
          child: Center(
            child: CircularProgressIndicator(
              value: (progress.expectedTotalBytes != null)
                  ? progress.cumulativeBytesLoaded / (progress.expectedTotalBytes ?? 1)
                  : null,
              strokeWidth: 2,
            ),
          ),
        );
      },
      errorBuilder: (context, error, stack) => _buildPlaceholderImage(),
      cacheWidth: 400,
      cacheHeight: 240,
    );
  }

  // Helper method to build info chip
  Widget _buildInfoChip({
    required IconData icon,
    required String text,
    required Color color,
  }) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: color.withOpacity(0.1),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 14, color: color),
          const SizedBox(width: 4),
          Text(
            text,
            style: TextStyle(
              fontSize: 12,
              color: color,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  // Helper method to build status chip
  Widget _buildStatusChip({required bool isActive}) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: isActive
            ? Colors.green.withOpacity(0.1)
            : Colors.red.withOpacity(0.1),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(
            isActive ? Icons.check_circle : Icons.cancel,
            size: 14,
            color: isActive ? Colors.green : Colors.red,
          ),
          const SizedBox(width: 4),
          Text(
            isActive ? 'Active' : 'Inactive',
            style: TextStyle(
              fontSize: 12,
              color: isActive ? Colors.green : Colors.red,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final controller = Get.find<SubscriptionController>();

    return Obx(() {
      // if (controller.isLoading.value) {
      //   return const Center(child: CircularProgressIndicator());
      // }
      if (controller.subscriptions.isEmpty) {
        return Container(
          height: 20,
          width: 20,
          color: Colors.black,
        ); // hide section if empty
      }
      // if (controller.subscriptions.isEmpty) {
      //   return const Center(child: Text("No subscriptions available"));
      // }
      print("Subscription list ==========> ${controller.subscriptions[0]}");
      return Container(
        decoration: BoxDecoration(
          color: Theme.of(context).primaryColor.withOpacity(0.05),
        ),
        margin: const EdgeInsets.symmetric(
            vertical: Dimensions.paddingSizeExtraSmall),
        padding: const EdgeInsets.symmetric(
            vertical: Dimensions.paddingSizeSmall, horizontal: 0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Padding(
              padding: const EdgeInsets.symmetric(
                horizontal: Dimensions.paddingSizeDefault,
                vertical: Dimensions.paddingSizeSmall,
              ),
              child: TitleWidget(
                textDecoration: TextDecoration.underline,
                title: "Subscriptions Services",
                onTap: () {
                  Get.to(() => const AllSubscriptionsScreen());
                },
              ),
            ),
            SizedBox(
              height: ResponsiveHelper.isMobile(context) ? 350 : 370,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: controller.subscriptions.length,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                itemBuilder: (context, index) {
                  final sub = controller.subscriptions[index];
                  return Container(
                    width: Get.width * 0.78,
                    margin:
                        const EdgeInsets.symmetric(horizontal: 8, vertical: 12),
                    child: Card(
                      elevation: 2,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: Padding(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 14.0, vertical: 10.0),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            // Image with fixed aspect ratio
                            AspectRatio(
                              aspectRatio: 9 / 5.5,
                              child: ClipRRect(
                                borderRadius: BorderRadius.circular(12),
                                child: _buildNetworkImage(sub.image),
                              ),
                            ),
                            const SizedBox(height: 6),

                            // Title and Price Row
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Expanded(
                                  child: Text(
                                    sub.name?.toUpperCase() ?? "SUBSCRIPTION",
                                    style: const TextStyle(
                                      fontSize: 13,
                                      fontWeight: FontWeight.bold,
                                      letterSpacing: 0.5,
                                    ),
                                    maxLines: 1,
                                    overflow: TextOverflow.ellipsis,
                                  ),
                                ),
                                const SizedBox(width: 4),
                                Container(
                                  padding: const EdgeInsets.symmetric(
                                      horizontal: 6, vertical: 2),
                                  decoration: BoxDecoration(
                                    color: Theme.of(context)
                                        .primaryColor
                                        .withOpacity(0.1),
                                    borderRadius: BorderRadius.circular(12),
                                  ),
                                  child: Text(
                                    "₹${sub.price is num ? (sub.price as num).toStringAsFixed(2) : sub.price}",
                                    style: TextStyle(
                                      fontSize: 12,
                                      fontWeight: FontWeight.bold,
                                      color: Theme.of(context).primaryColor,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                            const SizedBox(height: 4),

                            // Description
                            if (sub.shortDescription?.isNotEmpty == true) ...[
                              Text(
                                sub.shortDescription!,
                                style: TextStyle(
                                  fontSize: 11,
                                  color: Colors.grey[600],
                                  height: 1.2,
                                ),
                                maxLines: 1,
                                overflow: TextOverflow.ellipsis,
                              ),
                              const SizedBox(height: 4),
                            ],

                            // Duration and Status Row -> Wrap to handle tight space
                            Wrap(
                              alignment: WrapAlignment.spaceBetween,
                              runSpacing: 4,
                              spacing: 6,
                              children: [
                                _buildInfoChip(
                                  icon: Icons.calendar_today,
                                  text: "${sub.duration} days",
                                  color: Colors.blue,
                                ),
                                _buildStatusChip(
                                  // Show status based on backend response fields
                                  // Prefer explicit "status" string, fallback to computed isActive flag
                                  isActive: sub.subscribed ?? false,
                                ),
                              ],
                            ),
                            const SizedBox(height: 8),

                            SizedBox(
                              width: double.infinity,
                              child: GetBuilder<SubscriptionController>(
                                builder: (subscriptionCtrl) {
                                  final isSubscribed =
                                      subscriptionCtrl.isUserSubscribed(
                                          sub.subscriptionId ?? 0);
                                  final auth = Get.find<AuthController>();

                                  debugPrint('[SUB_BUTTON][VIEW] Subscription ID: ${sub.subscriptionId}, isSubscribed: $isSubscribed, subscribed field: ${sub.subscribed}');
                                  
                                  return ElevatedButton(
                                    onPressed: () {
                                      if (isSubscribed) {
                                        debugPrint('[SUB_BUTTON][VIEW] User already subscribed to ${sub.subscriptionId}');
                                        Get.snackbar('Info', 'You are already subscribed to this service');
                                      } else {
                                        debugPrint('[SUB_BUTTON][VIEW] Initiating subscription for ${sub.subscriptionId}');
                                        if (!auth.isLoggedIn()) {
                                          debugPrint('[SUB_BUTTON][VIEW] User not logged in, redirecting to sign in');
                                          Get.toNamed(RouteHelper.signIn);
                                        } else {
                                          _initiatePaymentFlow(context, sub);
                                        }
                                      }
                                    },
                                    style: ElevatedButton.styleFrom(
                                      backgroundColor: isSubscribed
                                          ? Colors.green
                                          : Colors.red,
                                      foregroundColor: Colors.white,
                                      padding: const EdgeInsets.symmetric(
                                          vertical: 8, horizontal: 12),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(12),
                                      ),
                                      minimumSize: const Size(0, 36),
                                    ),
                                    child: Text(
                                      isSubscribed ? 'Subscribed' : 'Subscribe Now',
                                      style: const TextStyle(
                                          fontSize: 12,
                                          fontWeight: FontWeight.w600),
                                    ),
                                  );
                                },
                              ),
                            )
                          ],
                        ),
                      ),
                    ),
                  );
                },
              ),
            ),
          ],
        ),
      );

      //   SizedBox(
      //   height: Get.find<LocalizationController>().isLtr
      //       ? ResponsiveHelper.isMobile(context)
      //           ? 260
      //           : 270
      //       : 270,
      //   child: ListView.builder(
      //     shrinkWrap: true,
      //     physics: const NeverScrollableScrollPhysics(),
      //     itemCount: controller.subscriptions.length,
      //     itemBuilder: (context, index) {
      //       final controller = Get.find<SubscriptionController>();
      //       final sub = controller.subscriptions[index];
      //       return Card(
      //         margin: const EdgeInsets.all(8),
      //         child: ListTile(
      //           title: Text(sub.name),
      //           subtitle: Text(sub.serviceName),
      //           trailing: ElevatedButton(
      //             onPressed: () {
      //               final controller = Get.find<SubscriptionController>();
      //               controller.subscribeUser(
      //                 subscriptionId: sub.id,
      //                 transactionId:
      //                     "TXN12345", // generate or get from payment gateway
      //                 paymentMethod: "online", // or "cash"
      //                 userId: 2, // replace with logged-in user id
      //               );
      //             },
      //             child: const Text("Subscribe"),
      //           ),
      //         ),
      //       );
      //     },
      //   ),
      // );
    });
  }

  void _showSubscriptionDialog(BuildContext context, dynamic subscription) {
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
                debugPrint('[PAYMENT_FLOW] Subscription confirmed, showing payment dialog');
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

  void _showPayWithMakeMyHomeDialog(
      BuildContext context, dynamic subscription) {
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount = double.tryParse(rawPrice) ??
        double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
        0.0;
    showDialog(
      context: context,
      builder: (_) => AlertDialog(
        title: Text('complete_payment'.tr),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
                '${'total_amount'.tr}: ${PriceConverter.convertPrice(amount)}'),
            const SizedBox(height: 8),
            Text('pay_using_make_my_home'.tr, style: robotoMedium),
          ],
        ),
        actions: [
          TextButton(onPressed: () => Get.back(), child: Text('cancel'.tr)),
          ElevatedButton(
            onPressed: () {
              debugPrint('[PAYMENT_FLOW] Pay now clicked, processing subscription');
              Get.back();
              _processSubscription(subscription);
            },
            child: Text('pay_now'.tr),
          ),
        ],
      ),
    );
  }

  void _initiatePaymentFlow(BuildContext context, dynamic subscription) {
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount = double.tryParse(rawPrice) ??
        double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
        0.0;
    debugPrint('[PAYMENT_FLOW] Starting payment flow for subscription: ${subscription.name}');
    debugPrint('[PAYMENT_FLOW] Raw price: $rawPrice, Parsed amount: $amount');
    if (amount <= 0) {
      debugPrint('[PAYMENT_FLOW] Invalid amount, showing error');
      customSnackBar('invalid_subscription_amount'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
      return;
    }
    debugPrint('[PAYMENT_FLOW] Showing subscription confirmation dialog');
    _showSubscriptionDialog(context, subscription);
  }

  void _processSubscription(dynamic subscription) {
    final auth = Get.find<AuthController>();
    if (!auth.isLoggedIn()) {
      Get.toNamed(
          RouteHelper.getNotLoggedScreen(RouteHelper.checkout, "subscription"));
      return;
    }

    final userId = Get.find<UserController>().userInfoModel?.id ??
        Get.find<SplashController>().getGuestId();
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount = double.tryParse(rawPrice) ??
        double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
        0.0;

    print(
        "DEBUG: SubscriptionView._processSubscription -> userId: $userId, rawPrice: $rawPrice, amount: $amount, subId: ${subscription.id}");

    // Basic validations
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

    debugPrint('[PAYMENT_FLOW] Initiating Razorpay payment');
    _initiateRazorpayPayment(subscription);
  }

  void _initiateRazorpayPayment(dynamic subscription) {
    debugPrint('[PAYMENT_FLOW] Setting up Razorpay payment parameters');
    final userId = Get.find<UserController>().userInfoModel?.id ??
        Get.find<SplashController>().getGuestId();
    final String rawPrice = subscription.price?.toString() ?? '';
    final double amount = double.tryParse(rawPrice) ??
        double.tryParse(rawPrice.replaceAll(RegExp(r'[^0-9\\.]'), '')) ??
        0.0;

    String platform = GetPlatform.isWeb ? "web" : "app";
    String callbackUrl;
    if (GetPlatform.isWeb) {
      final hostname = html.window.location.hostname ?? '';
      final protocol = html.window.location.protocol;
      final port = html.window.location.port;
      callbackUrl =
          "$protocol//$hostname${port.isNotEmpty ? ':$port' : ''}/payment/success";
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
      final Map<String, String> params = {
        'payment_method': 'razor_pay',
        'provider_id': userId.toString(),
        'package_id': (subscription.id ?? '').toString(),
        'access_token': accessToken,
        'amount': amount.toString(),
        'payment_platform': platform,
        'payment_type': 'subscription',
        'subscription_type': 'customer',
        'service_location': 'customer',
        'callback': callbackUrl,
      };

      if (zoneId.isNotEmpty) params['zone_id'] = zoneId;

      // Always provide service_schedule (fallback to now if empty)
      final String effectiveSchedule =
          (schedule != null && schedule.toString().isNotEmpty)
              ? schedule.toString()
              : DateTime.now().toIso8601String();
      params['service_schedule'] = effectiveSchedule;

      // Provide address_id if available else encoded address payload
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

      debugPrint('[PAYMENT_FLOW] Payment URL generated: $url');
      debugPrint('[PAYMENT_FLOW] Platform: ${GetPlatform.isWeb ? 'web' : 'mobile'}');
      
      if (GetPlatform.isWeb) {
        debugPrint('[PAYMENT_FLOW] Opening payment URL in web browser');
        html.window.open(url, "_self");
      } else {
        final int? numericId = subscription.subscriptionId;
        debugPrint('[PAYMENT_FLOW] Navigating to PaymentScreen');
        debugPrint('[PAYMENT_FLOW] Subscription ID (UUID): ${subscription.id}');
        debugPrint('[PAYMENT_FLOW] Subscription ID (numeric): $numericId');
        debugPrint('[PAYMENT_FLOW] Amount: $amount');
        Get.to(() => PaymentScreen(
              url: url,
              fromPage: "subscription",
              subscriptionId: (numericId ?? 0).toString(),
              subscriptionAmount: amount.toString(),
            ));
      }
    } catch (e) {
      print("ERROR: Failed to initiate payment: $e");
      customSnackBar('payment_initiation_failed'.tr,
          showDefaultSnackBar: false, type: ToasterMessageType.error);
    }
  }
}

// class MySubscriptionsView extends StatelessWidget {
//   final int userId; // pass logged-in user id
//
//   MySubscriptionsView({required this.userId});
//
//   @override
//   Widget build(BuildContext context) {
//     final controller = Get.find<SubscriptionController>();
//
//     // Fetch on widget load
//     controller.fetchUserSubscriptions(userId);
//
//     return Obx(() {
//       if (controller.isLoading.value) {
//         return const Center(child: CircularProgressIndicator());
//       }
//
//       if (controller.subscriptions.isEmpty) {
//         return const Center(child: Text("You have no active subscriptions"));
//       }
//
//       return ListView.builder(
//         itemCount: controller.subscriptions.length,
//         itemBuilder: (context, index) {
//           final sub = controller.subscriptions[index];
//           return Card(
//             margin: const EdgeInsets.all(8),
//             child: ListTile(
//               title: Text(sub.name),
//               subtitle: Text(sub.serviceName),
//               trailing: const Icon(Icons.check_circle, color: Colors.green),
//             ),
//           );
//         },
//       );
//     });
//   }
// }
