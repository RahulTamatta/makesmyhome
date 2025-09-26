import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class LanguageController extends GetxController {
  int _selectIndex = 0;
  int get selectIndex => _selectIndex;

  void setSelectIndex(int index) {
    _selectIndex = index;
    final selectedLanguage = AppConstants.languages[index];
    Locale newLocale = Locale(selectedLanguage.languageCode!, selectedLanguage.countryCode);
    Get.updateLocale(newLocale); // ✅ This updates the app's locale
    update();
  }

  List<LanguageModel> _languages = [];
  List<LanguageModel> get languages => _languages;

  void searchLanguage(String query, BuildContext context) {
    if (query.isEmpty) {
      _languages.clear();
      _languages = AppConstants.languages;
      update();
    } else {
      _selectIndex = -1;
      _languages = [];
      for (var product in AppConstants.languages) {
        if (product.languageName!.toLowerCase().contains(query.toLowerCase())) {
          _languages.add(product);
        }
      }
      update();
    }
  }

  void initializeAllLanguages(BuildContext context) {
    if (_languages.isEmpty) {
      _languages.clear();
      _languages = AppConstants.languages;
    }
  }
}
