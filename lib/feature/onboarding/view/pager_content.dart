import 'dart:developer';

import 'package:makesmyhome/feature/onboarding/controller/on_board_pager_controller.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class PagerContent extends StatefulWidget {
  const PagerContent({
    super.key,
    required this.image,
    required this.text,
    required this.subText,
    required this.topImage,
    // required this.index
  });
  final String image;
  final String text;
  final String subText;
  final String topImage;
  // final int index;

  @override
  State<PagerContent> createState() => _PagerContentState();
}

class _PagerContentState extends State<PagerContent> {
  @override
  Widget build(BuildContext context) {
    return GetBuilder<OnBoardController>(builder: (onBoardingController) {
      return onBoardingController.pageIndex == 2
          ? Column(
              children: [
                Expanded(
                  child: Stack(
                    alignment: Alignment.bottomCenter,
                    children: [
                      Image.asset(
                        Images.onBoardingTopTwo,
                        width: Get.width,
                        fit: BoxFit.cover,
                      ),
                      Padding(
                        padding: const EdgeInsets.only(
                            bottom: Dimensions.paddingSizeExtraMoreLarge),
                        child: Column(
                          mainAxisSize: MainAxisSize.min,
                          children: [
                            SizedBox(
                                child: Image.asset(widget.image,
                                    height: Get.height * 0.30)),
                            const SizedBox(
                                height: Dimensions.paddingSizeExtraMoreLarge),
                            Text(
                              widget.text,
                              textAlign: TextAlign.center,
                              style: robotoBold.copyWith(
                                  color: Theme.of(context).colorScheme.primary,
                                  fontSize: Dimensions.fontSizeLarge),
                            ),
                            const SizedBox(
                              height: Dimensions.paddingSizeDefault,
                            ),
                            Padding(
                              padding: const EdgeInsets.symmetric(
                                  horizontal: Dimensions.paddingSizeExtraLarge),
                              child: Text(
                                widget.subText,
                                textAlign: TextAlign.center,
                                style: robotoRegular.copyWith(
                                  color: Theme.of(context).colorScheme.primary,
                                  fontSize: Dimensions.fontSizeDefault,
                                ),
                              ),
                            ),
                            const SizedBox(
                                height: Dimensions.paddingSizeExtraMoreLarge),
                            CustomButton(
                              buttonText: "get_started".tr,
                              height: 40,
                              width: 150,
                              onPressed: () {
                                _checkPermissionAndNavigate(
                                    setState: () => {setState(() {})});
                              },
                            )
                          ],
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: Get.height * 0.25,
                  child: Image.asset(
                    Images.onBoardingBottomThree,
                    width: Get.width,
                    fit: BoxFit.fitHeight,
                  ),
                )
              ],
            )
          : Column(
              children: [
                Stack(
                  clipBehavior: Clip.none,
                  children: [
                    Image.asset(
                      Images.onBoardingTop,
                      width: Get.width,
                      fit: BoxFit.cover,
                    ),
                    SafeArea(
                      child: InkWell(
                        onTap: () {
                          _checkPermissionAndNavigate(
                              setState: () => {setState(() {})});
                        },
                        child: Container(
                          decoration: const BoxDecoration(
                              borderRadius:
                                  BorderRadius.all(Radius.circular(10.0))),
                          child: Padding(
                            padding: const EdgeInsets.all(
                                Dimensions.paddingSizeLarge),
                            child: Text(
                              "skip".tr,
                              style: robotoRegular.copyWith(
                                fontSize: Dimensions.fontSizeExtraLarge,
                                color: Theme.of(context)
                                    .colorScheme
                                    .primary
                                    .withValues(alpha: 0.7),
                              ),
                            ),
                          ),
                        ),
                      ),
                    ),
                    Positioned(
                      bottom: -10,
                      left: 40,
                      right: 40,
                      child: Image.asset(
                        widget.topImage,
                      ),
                    ),
                  ],
                ),
                SizedBox(
                  height: Get.height * 0.07,
                ),
                Expanded(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        widget.text,
                        textAlign: TextAlign.center,
                        style: robotoBold.copyWith(
                            color: Theme.of(context).colorScheme.primary,
                            fontSize: Dimensions.fontSizeLarge),
                      ),
                      const SizedBox(
                        height: Dimensions.paddingSizeDefault,
                      ),
                      Padding(
                        padding: const EdgeInsets.symmetric(
                            horizontal: Dimensions.paddingSizeExtraLarge),
                        child: Text(
                          widget.subText,
                          textAlign: TextAlign.center,
                          style: robotoRegular.copyWith(
                            color: Theme.of(context).colorScheme.primary,
                            fontSize: Dimensions.fontSizeDefault,
                          ),
                        ),
                      ),
                      const SizedBox(
                        height: Dimensions.paddingSizeExtraMoreLarge,
                      ),
                      Expanded(
                          child: Image.asset(
                        widget.image,
                      )),
                    ],
                  ),
                ),
              ],
            );
    });
  }
}

void _checkPermissionAndNavigate({required Function setState}) async {
  log("Permission is started....");
  Get.find<SplashController>().disableShowOnboardingScreen();

  LocationPermission permission = await Geolocator.checkPermission();

  if (permission == LocationPermission.denied) {
    log("Permission is denied");
    permission = await Geolocator.requestPermission();
  }
  if (permission == LocationPermission.denied ||
      permission == LocationPermission.deniedForever) {
    log("Permission is denied forever");
    Get.offAllNamed(RouteHelper.getPickMapRoute("", false, "", null, null));
    log("Permission is finish");
  } else {
    log("Permission is granted");
    // Get.offAllNamed(RouteHelper.getAccessLocationRoute('address'));
    Get.dialog(const CustomLoader(), barrierDismissible: false);

    AddressModel address =
        await Get.find<LocationController>().getCurrentLocation(true);

    setState();

    log("ADDRESS : $address");
    ZoneResponseModel response = await Get.find<LocationController>()
        .getZone(address.latitude!, address.longitude!, false);

    log("RESPONSE : $response");
    setState();

    if (response.isSuccess) {
      log("----------------------");
      log("Successs Get Location.....");
      Get.find<LocationController>()
          .saveAddressAndNavigate(address, false, '', false, true);
    } else {
      log("----------------------");
      log("Failed Get Location.....");
      Get.back();
      Get.offAllNamed(RouteHelper.getPickMapRoute("", false, "", null, null));
    }
  }
}
