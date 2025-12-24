import 'package:makesmyhome/common/enums/enums.dart';
import 'package:flutter/foundation.dart';
import 'package:makesmyhome/common/models/api_response_model.dart';
import 'package:makesmyhome/common/repo/data_sync_repo.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/app_constants.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';

class ServiceRepo extends DataSyncRepo {
  ServiceRepo(
      {required super.apiClient,
      required SharedPreferences super.sharedPreferences});

  Future<ApiResponseModel<T>> getAllServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crAllServiceUri}?offset=$offset&limit=10'
        : '${AppConstants.allServiceUri}?offset=$offset&limit=10';
    debugPrint(
        '[ServiceRepo] getAllServiceList isCr=$isCr uri=$uri source=$source');
    return await fetchData<T>(uri, source);
  }

  Future<ApiResponseModel<T>> getPopularServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crAllServiceUri}?offset=$offset&limit=10'
        : '${AppConstants.popularServiceUri}?offset=$offset&limit=10';
    debugPrint(
        '[ServiceRepo] getPopularServiceList isCr=$isCr uri=$uri source=$source');
    return await fetchData<T>(uri, source);
  }

  Future<ApiResponseModel<T>> getTrendingServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crAllServiceUri}?offset=$offset&limit=10'
        : '${AppConstants.trendingServiceUri}?offset=$offset&limit=10';
    debugPrint(
        '[ServiceRepo] getTrendingServiceList isCr=$isCr uri=$uri source=$source');
    return await fetchData<T>(uri, source);
  }

  Future<ApiResponseModel<T>> getRecentlyViewedServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crAllServiceUri}?offset=$offset&limit=10'
        : '${AppConstants.recentlyViewedServiceUri}?offset=$offset&limit=10';
    debugPrint(
        '[ServiceRepo] getRecentlyViewedServiceList isCr=$isCr uri=$uri source=$source');
    return await fetchData<T>(uri, source);
  }

  Future<ApiResponseModel<T>> getFeatheredCategoryServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    return await fetchData<T>(AppConstants.getFeaturedCategoryService, source);
  }

  Future<ApiResponseModel<T>> getRecommendedServiceList<T>(
      {required DataSourceEnum source, int offset = 1}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crAllServiceUri}?limit=10&offset=$offset'
        : '${AppConstants.recommendedServiceUri}?limit=10&offset=$offset';
    debugPrint(
        '[ServiceRepo] getRecommendedServiceList isCr=$isCr uri=$uri source=$source');
    return await fetchData<T>(uri, source);
  }

  Future<Response> getRecommendedSearchList() async {
    return await apiClient.getData(AppConstants.recommendedSearchUri);
  }

  Future<Response> getOffersList(int offset) async {
    return await apiClient
        .getData('${AppConstants.offerListUri}?limit=10&offset=$offset');
  }

  Future<Response> getServiceListBasedOnSubCategory(
      {required String subCategoryID, required int offset}) async {
    final bool isCr = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String uri = isCr
        ? '${AppConstants.crServicesBySubcategoryUri}$subCategoryID?limit=150&offset=$offset'
        : '${AppConstants.serviceBasedOnSubcategory}$subCategoryID?limit=150&offset=$offset';
    debugPrint(
        '[ServiceRepo] getServiceListBasedOnSubCategory isCr=$isCr uri=$uri');
    return await apiClient.getData(uri);
  }

  Future<Response> getItemsBasedOnCampaignId(
      {required String campaignID}) async {
    return await apiClient.getData(
        '${AppConstants.itemsBasedOnCampaignId}$campaignID&limit=100&offset=1');
  }

  Future<Response> updateIsFavoriteStatus({required String serviceId}) async {
    return await apiClient.postData(
        AppConstants.updateFavoriteServiceStatus, {"service_id": serviceId});
  }

  Future<Response> getAutocareServiceList({int offset = 1}) async {
    return await apiClient
        .getData('${AppConstants.autocareServiceUri}?limit=10&offset=$offset');
  }
}
