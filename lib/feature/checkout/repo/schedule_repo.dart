import 'package:makesmyhome/api/remote/client_api.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/app_constants.dart';

class ScheduleRepo extends GetxService {
  final ApiClient apiClient;
  ScheduleRepo({required this.apiClient});

  Future<Response> changePostScheduleTime(String postId, String scheduleTime) async {
    return await apiClient.postData(AppConstants.updatePostInfo,{
      "_method":"put",
      "post_id":postId,
      "booking_schedule":scheduleTime
    });
  }

  Future<Response> getAvailability({required String serviceId, required String providerId, required String date, int duration = 60, int step = 30}) async {
    final uri = "${AppConstants.availabilityUri}?service_id=$serviceId&provider_id=$providerId&date=$date&duration=$duration&step=$step";
    return await apiClient.getData(uri);
  }
}