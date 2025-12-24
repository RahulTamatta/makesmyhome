import 'package:makesmyhome/common/models/api_response_model.dart';
import 'package:makesmyhome/common/repo/data_sync_repo.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class CartRepo extends DataSyncRepo {
  CartRepo(
      {required super.apiClient,
      required SharedPreferences super.sharedPreferences});

  Future<Response> addToCartListToServer(CartModelBody cartModel) async {
    return await apiClient.postData(AppConstants.addToCart, cartModel.toJson());
  }

  Future<ApiResponseModel<T>> getCartListFromServer<T>(
      {required DataSourceEnum source}) async {
    final bool isLoggedIn =
        (sharedPreferences?.getString(AppConstants.token) ?? '').isNotEmpty;
    final String uri = isLoggedIn
        ? AppConstants.getCartList
        : "${AppConstants.getCartList}&guest_id=${Get.find<SplashController>().getGuestId()}";
    return await fetchData<T>(uri, source);
  }

  Future<Response> removeCartFromServer(String cartID) async {
    final bool isLoggedIn =
        (sharedPreferences?.getString(AppConstants.token) ?? '').isNotEmpty;
    final String uri = isLoggedIn
        ? "${AppConstants.removeCartItem}$cartID"
        : "${AppConstants.removeCartItem}$cartID?guest_id=${Get.find<SplashController>().getGuestId()}";
    return await apiClient.deleteData(uri);
  }

  Future<Response> removeAllCartFromServer() async {
    final bool isLoggedIn =
        (sharedPreferences?.getString(AppConstants.token) ?? '').isNotEmpty;
    final String uri = isLoggedIn
        ? AppConstants.removeAllCartItem
        : "${AppConstants.removeAllCartItem}?guest_id=${Get.find<SplashController>().getGuestId()}";
    return await apiClient.deleteData(uri);
  }

  Future<Response> updateCartQuantity(String cartID, int quantity) async {
    final bool isLoggedIn =
        (sharedPreferences?.getString(AppConstants.token) ?? '').isNotEmpty;
    final String uri = isLoggedIn
        ? "${AppConstants.updateCartQuantity}$cartID"
        : "${AppConstants.updateCartQuantity}$cartID?guest_id=${Get.find<SplashController>().getGuestId()}";
    return await apiClient.putData(uri, {'quantity': quantity});
  }

  Future<Response> updateProvider(String providerId) async {
    final bool isLoggedIn =
        (sharedPreferences?.getString(AppConstants.token) ?? '').isNotEmpty;
    final Map<String, String> body = {
      'provider_id': providerId,
      '_method': 'put',
    };
    if (!isLoggedIn) {
      body['guest_id'] = Get.find<SplashController>().getGuestId();
    }
    return await apiClient.postData(AppConstants.updateCartProvider, body);
  }

  Future<Response> getProviderBasedOnSubcategory(String subcategoryId) async {
    return await apiClient.getData(
        "${AppConstants.getProviderBasedOnSubcategory}?sub_category_id=$subcategoryId");
  }

  Future<Response> addRebookToServer(String bookingId) async {
    return await apiClient.postData(AppConstants.rebookApi, {
      'booking_id': bookingId,
      'guest_id': Get.find<SplashController>().getGuestId()
    });
  }
}
