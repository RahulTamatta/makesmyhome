import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class OnBoardController extends GetxController implements GetxService {
  int pageIndex = 0;
  final PageController pageController = PageController();

  List<Map<String, String>> onBoardPagerData = [
    {
      "text":
          "${'welcome_to'.tr} ${AppConstants.appName}!\n${'on_boarding_1_title'.tr}",
      "subTitle": "on_boarding_1_subtitle".tr,
      "image": "assets/images/onboarding_one.png",
      "top_image": Images.onBoardTopOne
    },
    {
      "text": "on_boarding_2_title".tr,
      "subTitle": "on_boarding_2_subtitle".tr,
      "image": "assets/images/onboarding_two.png",
      "top_image": Images.onBoardTopTwo
    },
    {
      "text": "on_boarding_3_title".tr,
      "subTitle": "on_boarding_3_subtitle".tr,
      "image": "assets/images/onboarding_three.png",
      "top_image": ""
    }
  ];

  void onPageChanged(int index) {
    pageIndex = index;
    update();
  }
}
