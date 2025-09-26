import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class ApiChecker {
  static void checkApi(Response response, {bool showDefaultToaster = true}) {
    // On web, avoid showing snackbars during early initialization when context might be null
    if (kIsWeb && Get.context == null) {
      debugPrint('API Error (${response.statusCode}): ${response.body} - Skipping snackbar on web');
      return;
    }
    // Safely handle null/unexpected response bodies to avoid crashes
    final dynamic body = response.body;
    if(response.statusCode == 401) {
      Get.find<AuthController>().clearSharedData(response: response);
      if(Get.currentRoute != RouteHelper.getInitialRoute()){
        Get.offAllNamed(RouteHelper.getInitialRoute());
        customSnackBar("${response.statusCode!}".tr);
      }
    }else if(response.statusCode == 500){
      customSnackBar("${response.statusCode!}".tr, showDefaultSnackBar: showDefaultToaster);
    }
    else if(response.statusCode == 400 && body is Map && body['errors'] != null){
      try{
        customSnackBar("${body['errors'][0]['message']}",showDefaultSnackBar: showDefaultToaster);
      }catch(_){
        customSnackBar("${response.statusCode!}".tr, showDefaultSnackBar: showDefaultToaster);
      }
    }
    else if(response.statusCode == 429){
      customSnackBar("too_many_request".tr, showDefaultSnackBar: showDefaultToaster);
    }
    else{
      String message = 'something_went_wrong'.tr;
      if(body is Map && body['message'] != null){
        message = body['message'].toString();
      }else if(response.statusText != null && response.statusText!.isNotEmpty){
        message = response.statusText!;
      }
      customSnackBar(message, showDefaultSnackBar: showDefaultToaster);
    }
  }
}