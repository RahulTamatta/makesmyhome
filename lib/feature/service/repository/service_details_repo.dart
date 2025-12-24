import 'package:makesmyhome/api/remote/client_api.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/app_constants.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';

class ServiceDetailsRepo {
  final ApiClient apiClient;
  ServiceDetailsRepo({required this.apiClient});

  Future<Response> getServiceDetails(String serviceID, String fromPage) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String base = isCr
        ? AppConstants.crServiceDetailsUri
        : AppConstants.serviceDetailsUri;
    if (fromPage == "search_page") {
      return await apiClient.getData('$base/$serviceID?attribute=service');
    } else {
      return await apiClient.getData('$base/$serviceID');
    }
  }

  Future<Response> getServiceReviewList(String serviceID, int offset) async {
    return await apiClient.getData(
        '${AppConstants.getServiceReviewList}$serviceID?offset=$offset&limit=10');
  }
}
