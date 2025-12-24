import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';

class ServiceWidgetVertical extends StatelessWidget {
  final Service service;
  final String fromType;
  final String fromPage;
  final ProviderData? providerData;
  final GlobalKey<CustomShakingWidgetState>? signInShakeKey;

  const ServiceWidgetVertical(
      {super.key,
      required this.service,
      required this.fromType,
      this.fromPage = "",
      this.providerData,
      this.signInShakeKey});

  @override
  Widget build(BuildContext context) {
    num lowestPrice = 0.0;

    if (fromType == 'fromCampaign') {
      if (service.variations != null && service.variations!.isNotEmpty) {
        lowestPrice = service.variations!.first.price ?? 0;
        for (final v in service.variations!) {
          final p = v.price ?? 0;
          if (p < lowestPrice) lowestPrice = p;
        }
      } else if (service.variationsAppFormat?.defaultPrice != null) {
        lowestPrice = service.variationsAppFormat!.defaultPrice!;
      }
    } else {
      final zoneVars = service.variationsAppFormat?.zoneWiseVariations;
      if (zoneVars != null && zoneVars.isNotEmpty) {
        lowestPrice = zoneVars.first.price ?? 0;
        for (final zv in zoneVars) {
          final p = zv.price ?? 0;
          if (p < lowestPrice) lowestPrice = p;
        }
      } else if (service.variations != null && service.variations!.isNotEmpty) {
        lowestPrice = service.variations!.first.price ?? 0;
        for (final v in service.variations!) {
          final p = v.price ?? 0;
          if (p < lowestPrice) lowestPrice = p;
        }
      } else if (service.crBasePrice != null && service.crBasePrice! > 0) {
        lowestPrice = service.crBasePrice!;
      } else if (service.variationsAppFormat?.defaultPrice != null) {
        lowestPrice = service.variationsAppFormat!.defaultPrice!;
      }
    }

    Discount discountModel = PriceConverter.discountCalculation(service);
    final bool useCrName = Get.isRegistered<CrModeController>() &&
        Get.find<CrModeController>().isCrMode;
    final String displayName = useCrName
        ? (service.category?.name ?? service.name ?? "")
        : (service.name ?? "");
    final bool hasPrice = (lowestPrice.toDouble()) > 0;
    return OnHover(
      isItem: true,
      child: GetBuilder<ServiceController>(builder: (serviceController) {
        return Stack(
          alignment: Alignment.bottomRight,
          children: [
            Stack(
              children: [
                Container(
                  decoration: BoxDecoration(
                    color: Theme.of(context).cardColor,
                    borderRadius: BorderRadius.circular(Dimensions.radiusSmall),
                    boxShadow: Get.find<ThemeController>().darkTheme
                        ? null
                        : cardShadow,
                  ),
                  child: Padding(
                    padding: const EdgeInsets.all(Dimensions.paddingSizeSmall),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      mainAxisAlignment: MainAxisAlignment.start,
                      children: [
                        Expanded(
                          flex: ResponsiveHelper.isDesktop(context) &&
                                  !Get.find<LocalizationController>().isLtr
                              ? 5
                              : 8,
                          child: Stack(
                            children: [
                              ClipRRect(
                                borderRadius: const BorderRadius.all(
                                    Radius.circular(Dimensions.radiusSmall)),
                                child: CustomImage(
                                  image: service.thumbnailFullPath ??
                                      service.coverImageFullPath ??
                                      '',
                                  fit: BoxFit.cover,
                                  width: double.maxFinite,
                                  height: double.infinity,
                                ),
                              ),
                              discountModel.discountAmount! > 0
                                  ? Align(
                                      alignment: Alignment.topLeft,
                                      child: DiscountTagWidget(
                                        discountAmount:
                                            discountModel.discountAmount,
                                        discountAmountType:
                                            discountModel.discountAmountType,
                                      ),
                                    )
                                  : const SizedBox(),
                            ],
                          ),
                        ),
                        Padding(
                          padding: const EdgeInsets.symmetric(
                              vertical: Dimensions.paddingSizeEight - 2),
                          child: Text(
                            displayName,
                            style: robotoMedium.copyWith(
                                fontSize: Dimensions.fontSizeLarge),
                            maxLines: 1,
                            overflow: TextOverflow.ellipsis,
                            textAlign: TextAlign.start,
                          ),
                        ),
                        Expanded(
                          flex: 3,
                          child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              mainAxisAlignment: MainAxisAlignment.end,
                              children: [
                                hasPrice
                                    ? Text(
                                        'starts_from'.tr,
                                        style: robotoRegular.copyWith(
                                            fontSize: Dimensions.fontSizeSmall,
                                            color: Theme.of(context)
                                                .textTheme
                                                .bodyLarge!
                                                .color!
                                                .withValues(alpha: .5)),
                                      )
                                    : const SizedBox(),
                                hasPrice
                                    ? Column(
                                        crossAxisAlignment:
                                            CrossAxisAlignment.start,
                                        children: [
                                          if (discountModel.discountAmount! > 0)
                                            Directionality(
                                              textDirection: TextDirection.ltr,
                                              child: Text(
                                                PriceConverter.convertPrice(
                                                    lowestPrice.toDouble()),
                                                maxLines: 2,
                                                style: robotoRegular.copyWith(
                                                    fontSize: Dimensions
                                                        .fontSizeSmall,
                                                    decoration: TextDecoration
                                                        .lineThrough,
                                                    color: Theme.of(context)
                                                        .colorScheme
                                                        .error),
                                              ),
                                            ),
                                          discountModel.discountAmount! > 0
                                              ? Directionality(
                                                  textDirection:
                                                      TextDirection.ltr,
                                                  child: Text(
                                                    PriceConverter.convertPrice(
                                                        lowestPrice.toDouble(),
                                                        discount: discountModel
                                                            .discountAmount!
                                                            .toDouble(),
                                                        discountType: discountModel
                                                            .discountAmountType),
                                                    style: robotoMedium.copyWith(
                                                        fontSize: Dimensions
                                                            .fontSizeDefault,
                                                        color: Get.isDarkMode
                                                            ? Theme.of(context)
                                                                .primaryColorLight
                                                            : Theme.of(context)
                                                                .primaryColor),
                                                  ),
                                                )
                                              : Directionality(
                                                  textDirection:
                                                      TextDirection.ltr,
                                                  child: Text(
                                                    PriceConverter.convertPrice(
                                                        lowestPrice.toDouble()),
                                                    style: robotoMedium.copyWith(
                                                        fontSize: Dimensions
                                                            .fontSizeDefault,
                                                        color: Get.isDarkMode
                                                            ? Theme.of(context)
                                                                .primaryColorLight
                                                            : Theme.of(context)
                                                                .primaryColor),
                                                  ),
                                                ),
                                        ],
                                      )
                                    : Text(
                                        'get_quote'.tr,
                                        style: robotoMedium.copyWith(
                                            fontSize:
                                                Dimensions.fontSizeDefault,
                                            color: Get.isDarkMode
                                                ? Theme.of(context)
                                                    .primaryColorLight
                                                : Theme.of(context)
                                                    .primaryColor),
                                      ),
                              ]),
                        ),
                      ],
                    ),
                  ),
                ),
                Positioned.fill(child: RippleButton(onTap: () {
                  if (fromPage == "search_page") {
                    Get.toNamed(
                      RouteHelper.getServiceRoute(service.id!,
                          fromPage: "search_page"),
                    );
                  } else {
                    Get.toNamed(
                      RouteHelper.getServiceRoute(service.id!),
                    );
                  }
                }))
              ],
            ),

            if (fromType != 'fromCampaign')
              Align(
                alignment: Get.find<LocalizationController>().isLtr
                    ? Alignment.bottomRight
                    : Alignment.bottomLeft,
                child: Stack(
                  children: [
                    Padding(
                      padding:
                          const EdgeInsets.all(Dimensions.paddingSizeSmall),
                      child: Icon(
                        Icons.add,
                        color: Get.isDarkMode
                            ? Theme.of(context).primaryColorLight
                            : Theme.of(context).primaryColor,
                        size: Dimensions.paddingSizeExtraLarge,
                      ),
                    ),
                    Positioned.fill(child: RippleButton(onTap: () {
                      showModalBottomSheet(
                          useRootNavigator: true,
                          isScrollControlled: true,
                          backgroundColor: Colors.transparent,
                          context: context,
                          builder: (context) => ServiceCenterDialog(
                                service: service,
                                providerData: providerData,
                              ));
                    }))
                  ],
                ),
              ),

            // Align(
            //   alignment: Alignment.topRight,
            //   child: FavoriteIconWidget(
            //     value: service.isFavorite,
            //     serviceId:  service.id!,
            //     signInShakeKey: signInShakeKey,
            //   ),
            // )
          ],
        );
      }),
    );
  }
}
