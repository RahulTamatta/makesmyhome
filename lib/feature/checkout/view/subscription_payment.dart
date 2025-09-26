// import 'package:makesmyhome/utils/core_export.dart';
// import 'package:get/get.dart';
//
// class SubscriptionCheckoutController extends GetxController {
//   final CheckoutRepo checkoutRepo;
//   SubscriptionCheckoutController({required this.checkoutRepo});
//
//   bool _isLoading = false;
//   bool get isLoading => _isLoading;
//
//   String? _transactionId;
//   String? get transactionId => _transactionId;
//
//   Future<void> placeSubscriptionRequest({
//     required String subscriptionId,
//     required String paymentMethod,
//   }) async {
//     _isLoading = true;
//     update();
//
//     Response response = await checkoutRepo.placeSubscriptionRequest(
//       subscriptionId: subscriptionId,
//       paymentMethod: paymentMethod,
//     );
//
//     if (response.statusCode == 200 &&
//         response.body["response_code"] == "subscription_success_200") {
//       _transactionId = response.body['content']['transaction_id'];
//       String token = response.body['content']['token'];
//       String amount = response.body['content']['amount'];
//
//       // go to digital payment gateway
//       Get.offAllNamed(RouteHelper.getDigitalPaymentRoute(
//         token: token,
//         paymentMethod: paymentMethod,
//         amount: amount,
//         reference: subscriptionId,
//         fromPage: "subscription",
//       ));
//     } else {
//       ApiChecker.checkApi(response);
//     }
//
//     _isLoading = false;
//     update();
//   }
//
//   Future<void> getDigitalPaymentResponse(String transactionId) async {
//     _isLoading = true;
//     update();
//
//     Response response = await checkoutRepo.getDigitalPaymentResponse(
//         transactionId: transactionId);
//
//     if (response.statusCode == 200 &&
//         response.body["response_code"] == "default_200") {
//       Get.offAllNamed(RouteHelper.getSubscriptionSuccessRoute("success"));
//     } else {
//       Get.offAllNamed(RouteHelper.getSubscriptionSuccessRoute("fail"));
//     }
//
//     _isLoading = false;
//     update();
//   }
// }
