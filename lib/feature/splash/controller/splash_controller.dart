import 'dart:convert';

import 'package:makesmyhome/api/local/cache_response.dart';
import 'package:makesmyhome/helper/data_sync_helper.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class SplashController extends GetxController implements GetxService {
  final SplashRepo splashRepo;
  SplashController({required this.splashRepo});

  ConfigModel? _configModel = ConfigModel();
  bool _firstTimeConnectionCheck = true;
  final bool _hasConnection = true;
  bool _isLoading = false;

  bool get isLoading => _isLoading;
  ConfigModel get configModel => _configModel!;
  DateTime get currentTime => DateTime.now();
  bool get firstTimeConnectionCheck => _firstTimeConnectionCheck;
  bool get hasConnection => _hasConnection;

  bool savedCookiesData = false;

  Future<bool> getConfigData() async {
    await DataSyncHelper.fetchAndSyncData(
      fetchFromLocal: () => splashRepo.getConfigData<CacheResponseData>(
          source: DataSourceEnum.local),
      fetchFromClient: () =>
          splashRepo.getConfigData(source: DataSourceEnum.client),
      onResponse: (data, source) {
        dynamic decodedData;
        if (data is String) {
          try {
            decodedData = jsonDecode(data);
          } catch (e) {
            print("JSON decode error: $e");
            return;
          }
        } else {
          decodedData = data;
        }
        _configModel = ConfigModel.fromJson(data);
        try {
          final enabled = (_configModel?.content?.crModuleEnabled ?? 1) == 1;
          if (Get.isRegistered<CrModeController>()) {
            Get.find<CrModeController>().setServerEnabled(enabled);
          }
        } catch (_) {}

        if (_configModel?.content?.maintenanceMode?.maintenanceStatus == 1 &&
            _configModel?.content?.maintenanceMode?.selectedMaintenanceSystem
                    ?.mobileApp ==
                1 &&
            source == DataSourceEnum.client &&
            !AppConstants.avoidMaintenanceMode) {
          Get.offAllNamed(RouteHelper.getMaintenanceRoute());
        } else if ((Get.currentRoute.contains(RouteHelper.maintenance) &&
            (_configModel?.content?.maintenanceMode?.maintenanceStatus == 0 ||
                (_configModel?.content?.maintenanceMode
                            ?.selectedMaintenanceSystem?.mobileApp ==
                        0 &&
                    !kIsWeb)))) {
          Get.offAllNamed(RouteHelper.getInitialRoute());
        } else if (_configModel?.content?.maintenanceMode?.maintenanceStatus ==
            0) {
          if (_configModel?.content?.maintenanceMode?.selectedMaintenanceSystem
                  ?.mobileApp ==
              1) {
            if (_configModel?.content?.maintenanceMode
                    ?.maintenanceTypeAndDuration?.maintenanceDuration ==
                'customize') {
              DateTime now = DateTime.now();
              DateTime specifiedDateTime = DateTime.parse(_configModel!.content!
                  .maintenanceMode!.maintenanceTypeAndDuration!.startDate!);

              Duration difference = specifiedDateTime.difference(now);

              if (difference.inMinutes > 0 &&
                  (difference.inMinutes < 60 || difference.inMinutes == 60)) {
                _startTimer(specifiedDateTime);
              }
            }
          }
        }

        update();
      },
    );

    return true;
  }

  void _startTimer(DateTime startTime) {
    Timer.periodic(const Duration(seconds: 30), (Timer timer) {
      DateTime now = DateTime.now();
      if (now.isAfter(startTime) || now.isAtSameMomentAs(startTime)) {
        timer.cancel();
        Get.offAllNamed(RouteHelper.getMaintenanceRoute());
      }
    });
  }

  Future<bool> initSharedData() {
    return splashRepo.initSharedData();
  }

  void setGuestId(String guestId) {
    splashRepo.setGuestId(guestId);
  }

  String getGuestId() {
    return splashRepo.getGuestId();
  }

  void setFirstTimeConnectionCheck(bool isChecked) {
    _firstTimeConnectionCheck = isChecked;
  }

  void saveCookiesData(bool data) {
    splashRepo.saveCookiesData(data);
    savedCookiesData = true;
    update();
  }

  getCookiesData() {
    savedCookiesData = splashRepo.getSavedCookiesData();
    update();
  }

  void cookiesStatusChange(String? data) {
    if (data != null) {
      splashRepo.sharedPreferences!
          .setString(AppConstants.cookiesManagement, data);
    }
  }

  bool getAcceptCookiesStatus(String data) =>
      splashRepo.sharedPreferences!.getString(AppConstants.cookiesManagement) !=
          null &&
      splashRepo.sharedPreferences!.getString(AppConstants.cookiesManagement) ==
          data;

  void disableShowOnboardingScreen() {
    splashRepo.disableShowOnboardingScreen();
  }

  bool isShowOnboardingScreen() {
    return splashRepo.isShowOnboardingScreen();
  }

  void disableShowInitialLanguageScreen() {
    splashRepo.disableShowInitialLanguageScreen();
  }

  bool isShowInitialLanguageScreen() {
    return splashRepo.isShowInitialLanguageScreen();
  }

  Future<void> updateLanguage(bool isInitial) async {
    Response response = await splashRepo.updateLanguage(getGuestId());

    if (!isInitial) {
      if (response.statusCode == 200 &&
          response.body is Map &&
          response.body['response_code'] == "default_200") {
        // success, nothing to show
      } else {
        String message = 'something_went_wrong'.tr;
        final dynamic body = response.body;
        if (body is Map && body['message'] != null) {
          message = body['message'].toString();
        } else if (response.statusText != null &&
            response.statusText!.isNotEmpty) {
          message = response.statusText!;
        }
        customSnackBar(message);
      }
    }
  }

  Future<void> addError404UrlToServer(String url) async {
    Response response = await splashRepo.addError404UrlToServer(url);
    if (kDebugMode) {
      print("Error Url Add Response Status : ${response.statusCode}");
    }
  }

  Future<ResponseModel> newsLetterSubscription({required String email}) async {
    _isLoading = true;
    update();
    Response response = await splashRepo.newsLetterSubscription(email: email);
    if (response.statusCode == 200) {
      _isLoading = false;
      update();
      return ResponseModel(true, "successfully_subscribed".tr);
    } else if (response.statusCode == 400) {
      _isLoading = false;
      update();
      return ResponseModel(
          false, "${response.body['errors'][0]['message'] ?? ""}");
    } else {
      _isLoading = false;
      update();
      return ResponseModel(false, "${response.body['message'] ?? ""}");
    }
  }
}
