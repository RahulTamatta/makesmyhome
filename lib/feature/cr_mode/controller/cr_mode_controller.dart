import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:makesmyhome/utils/app_constants.dart';
import 'package:makesmyhome/feature/service/controller/service_controller.dart';

class CrModeController extends GetxController implements GetxService {
  final SharedPreferences sharedPreferences;
  CrModeController({required this.sharedPreferences});

  bool _isEnabledOnServer = false; // server-side global toggle
  bool _isCrMode = false; // user-side local toggle

  bool get isEnabled => _isEnabledOnServer;
  bool get isCrMode => _isCrMode && _isEnabledOnServer;

  void hydrate() {
    _isCrMode = sharedPreferences.getBool(AppConstants.crModeKey) ?? false;
  }

  void setServerEnabled(bool enabled, {bool persistState = true}) {
    _isEnabledOnServer = enabled;
    if (!enabled) {
      // If server disabled, force local off
      _isCrMode = false;
      if (persistState)
        sharedPreferences.setBool(AppConstants.crModeKey, _isCrMode);
    }
    update();
  }

  void toggleCrMode() {
    if (!_isEnabledOnServer) return;
    _isCrMode = !_isCrMode;
    sharedPreferences.setBool(AppConstants.crModeKey, _isCrMode);
    update();
    try {
      // Clear caches and force refresh lists to reflect mode change
      if (Get.isRegistered<ServiceController>()) {
        Get.find<ServiceController>().debugClearServiceCache();
        Get.find<ServiceController>().debugForceRefreshServices();
      }
    } catch (_) {}
  }
}
