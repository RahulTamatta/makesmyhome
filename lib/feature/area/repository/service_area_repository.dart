import 'package:makesmyhome/common/models/api_response_model.dart';
import 'package:makesmyhome/common/repo/data_sync_repo.dart';
import 'package:makesmyhome/utils/core_export.dart';

class ServiceAreaRepo extends DataSyncRepo {
  ServiceAreaRepo({required super.apiClient, required SharedPreferences super.sharedPreferences});

  Future<ApiResponseModel<T>> getZoneList<T>({required DataSourceEnum source}) async {
    return await fetchData<T>(AppConstants.getZoneListApi, source, method: ApiMethodType.post, body: {});
  }
}