import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/feature/cr_mode/controller/cr_mode_controller.dart';

class ServiceCenterDialog extends StatefulWidget {
  final Service? service;
  final CartModel? cart;
  final int? cartIndex;
  final bool? isFromDetails;
  final ProviderData? providerData;
  final bool? bookNowFlow;

  const ServiceCenterDialog(
      {super.key,
      required this.service,
      this.cart,
      this.cartIndex,
      this.isFromDetails = false,
      this.providerData,
      this.bookNowFlow = false});

  @override
  State<ServiceCenterDialog> createState() => _ProductBottomSheetState();
}

class _ProductBottomSheetState extends State<ServiceCenterDialog> {
  @override
  void initState() {
    Get.find<CartController>().setInitialCartList(widget.service!);
    Get.find<CartController>()
        .updatePreselectedProvider(null, shouldUpdate: false);
    Get.find<AllSearchController>().searchFocus.unfocus();
    try {
      final cart = Get.find<CartController>();
      final bool isCr = Get.isRegistered<CrModeController>() &&
          Get.find<CrModeController>().isCrMode;
      if (isCr && cart.initialCartList.isNotEmpty) {
        if (cart.initialCartList.length == 1 &&
            cart.initialCartList.first.quantity == 0) {
          cart.updateQuantity(0, true);
        } else if (cart.initialCartList.length > 1) {
          int idx = cart.initialCartList.indexWhere((e) => e.price > 0);
          if (idx == -1) idx = 0;
          if (cart.initialCartList[idx].quantity == 0) {
            cart.updateQuantity(idx, true);
          }
        }
      }
    } catch (_) {}
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    if (ResponsiveHelper.isDesktop(context)) {
      return Dialog(
        shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(Dimensions.radiusExtraLarge)),
        insetPadding: const EdgeInsets.all(30),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        child: pointerInterceptor(),
      );
    }
    return pointerInterceptor();
  }

  pointerInterceptor() {
    return Padding(
      padding: EdgeInsets.only(
          top: ResponsiveHelper.isWeb() ? 0 : Dimensions.cartDialogPadding),
      child: PointerInterceptor(
        child: Container(
          width: ResponsiveHelper.isDesktop(context)
              ? Dimensions.webMaxWidth / 2
              : Dimensions.webMaxWidth,
          padding: const EdgeInsets.all(Dimensions.paddingSizeLarge),
          decoration: BoxDecoration(
            color: Theme.of(context).cardColor,
            borderRadius: const BorderRadius.vertical(
                top: Radius.circular(Dimensions.radiusExtraLarge)),
          ),
          child: GetBuilder<CartController>(builder: (cartControllerInit) {
            return GetBuilder<ServiceController>(builder: (serviceController) {
              if (cartControllerInit.initialCartList.isNotEmpty) {
                return Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const SizedBox(
                          width: Dimensions.paddingSizeLarge,
                        ),
                        ClipRRect(
                          borderRadius: const BorderRadius.all(
                              Radius.circular(Dimensions.paddingSizeDefault)),
                          child: CustomImage(
                            image: widget.service!.thumbnailFullPath ??
                                widget.service!.coverImageFullPath ??
                                '',
                            height: Dimensions.imageSizeButton,
                            width: Dimensions.imageSizeButton,
                          ),
                        ),
                        Container(
                          height: 40,
                          width: 40,
                          alignment: Alignment.center,
                          decoration: BoxDecoration(
                              shape: BoxShape.circle,
                              color: Colors.white70.withValues(alpha: 0.6),
                              boxShadow: Get.isDarkMode
                                  ? null
                                  : [
                                      BoxShadow(
                                        color: Colors.grey[300]!,
                                        blurRadius: 2,
                                        spreadRadius: 1,
                                      )
                                    ]),
                          child: InkWell(
                              onTap: () => Get.back(),
                              child: const Icon(
                                Icons.close,
                                color: Colors.black54,
                              )),
                        )
                      ],
                    ),
                    const SizedBox(
                      height: Dimensions.paddingSizeEight,
                    ),
                    Text(
                      widget.service!.name!,
                      style: robotoMedium.copyWith(
                          fontSize: Dimensions.fontSizeDefault),
                      textAlign: TextAlign.center,
                      maxLines: 2,
                    ),
                    const SizedBox(
                      height: Dimensions.paddingSizeMini,
                    ),
                    Builder(builder: (_) {
                      final int availableCount =
                          cartControllerInit.initialCartList.length;
                      final String label = availableCount == 1
                          ? 'variation_available'.tr
                          : 'variations_available'.tr;
                      return Text(
                        '$availableCount $label',
                        style: robotoRegular.copyWith(
                            color: Theme.of(context)
                                .textTheme
                                .bodyLarge!
                                .color!
                                .withValues(alpha: .5)),
                      );
                    }),
                    Column(
                        mainAxisAlignment: MainAxisAlignment.start,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const SizedBox(height: Dimensions.paddingSizeLarge),
                          ConstrainedBox(
                            constraints: BoxConstraints(
                                minHeight: Get.height * 0.1,
                                maxHeight: Get.height * 0.4),
                            child: ListView.builder(
                                shrinkWrap: true,
                                itemCount:
                                    cartControllerInit.initialCartList.length,
                                itemBuilder: (context, index) {
                                  //variation item
                                  return Padding(
                                    padding: const EdgeInsets.symmetric(
                                        vertical: Dimensions.paddingSizeSmall),
                                    child: Container(
                                      padding: const EdgeInsets.symmetric(
                                          vertical:
                                              Dimensions.paddingSizeExtraSmall),
                                      decoration: BoxDecoration(
                                          color: Theme.of(context).hoverColor,
                                          borderRadius: const BorderRadius.all(
                                              Radius.circular(Dimensions
                                                  .paddingSizeDefault))),
                                      child: GetBuilder<CartController>(
                                        builder: (cartController) {
                                          final bool isCr = Get.isRegistered<
                                                  CrModeController>() &&
                                              Get.find<CrModeController>()
                                                  .isCrMode;
                                          return Padding(
                                            padding: const EdgeInsets.all(8.0),
                                            child: Row(
                                                mainAxisAlignment:
                                                    MainAxisAlignment
                                                        .spaceBetween,
                                                children: [
                                                  Expanded(
                                                    child: Column(
                                                      crossAxisAlignment:
                                                          CrossAxisAlignment
                                                              .start,
                                                      mainAxisAlignment:
                                                          MainAxisAlignment
                                                              .center,
                                                      children: [
                                                        Text(
                                                          cartControllerInit
                                                              .initialCartList[
                                                                  index]
                                                              .variantKey
                                                              .replaceAll(
                                                                  '-', ' '),
                                                          style: robotoMedium
                                                              .copyWith(
                                                                  fontSize:
                                                                      Dimensions
                                                                          .fontSizeSmall),
                                                          maxLines: 2,
                                                          overflow: TextOverflow
                                                              .ellipsis,
                                                        ),
                                                        const SizedBox(
                                                          height: Dimensions
                                                              .paddingSizeExtraSmall,
                                                        ),
                                                        Directionality(
                                                          textDirection:
                                                              TextDirection.ltr,
                                                          child: Text(
                                                            cartControllerInit
                                                                        .initialCartList[
                                                                            index]
                                                                        .price >
                                                                    0
                                                                ? PriceConverter.convertPrice(
                                                                    cartControllerInit
                                                                        .initialCartList[
                                                                            index]
                                                                        .price
                                                                        .toDouble(),
                                                                    isShowLongPrice:
                                                                        true)
                                                                : 'get_quote'
                                                                    .tr,
                                                            style: robotoMedium.copyWith(
                                                                color: Get
                                                                        .isDarkMode
                                                                    ? Theme.of(
                                                                            context)
                                                                        .primaryColorLight
                                                                    : Theme.of(
                                                                            context)
                                                                        .primaryColor,
                                                                fontSize: Dimensions
                                                                    .fontSizeSmall),
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  // Expanded(child: SizedBox()),
                                                  Expanded(
                                                    flex: 1,
                                                    child: Row(
                                                        mainAxisAlignment:
                                                            MainAxisAlignment
                                                                .end,
                                                        children: [
                                                          if (!isCr) ...[
                                                            if (cartControllerInit
                                                                    .initialCartList[
                                                                        index]
                                                                    .quantity >
                                                                0)
                                                              InkWell(
                                                                onTap: () {
                                                                  cartController
                                                                      .updateQuantity(
                                                                          index,
                                                                          false);
                                                                },
                                                                child:
                                                                    Container(
                                                                  height: 30,
                                                                  width: 30,
                                                                  margin: const EdgeInsets
                                                                      .symmetric(
                                                                      horizontal:
                                                                          Dimensions
                                                                              .paddingSizeSmall),
                                                                  decoration: BoxDecoration(
                                                                      shape: BoxShape
                                                                          .circle,
                                                                      color: Theme.of(
                                                                              context)
                                                                          .colorScheme
                                                                          .secondary),
                                                                  alignment:
                                                                      Alignment
                                                                          .center,
                                                                  child: Icon(
                                                                    Icons
                                                                        .remove,
                                                                    size: 15,
                                                                    color: Theme.of(
                                                                            context)
                                                                        .cardColor,
                                                                  ),
                                                                ),
                                                              ),
                                                            if (cartControllerInit
                                                                    .initialCartList[
                                                                        index]
                                                                    .quantity >
                                                                0)
                                                              Text(
                                                                cartControllerInit
                                                                    .initialCartList[
                                                                        index]
                                                                    .quantity
                                                                    .toString(),
                                                              ),
                                                            GestureDetector(
                                                              onTap: () {
                                                                cartController
                                                                    .updateQuantity(
                                                                        index,
                                                                        true);
                                                              },
                                                              child: Container(
                                                                height: 30,
                                                                width: 30,
                                                                margin: const EdgeInsets
                                                                    .symmetric(
                                                                    horizontal:
                                                                        Dimensions
                                                                            .paddingSizeSmall),
                                                                decoration: BoxDecoration(
                                                                    shape: BoxShape
                                                                        .circle,
                                                                    color: Theme.of(
                                                                            context)
                                                                        .colorScheme
                                                                        .secondary),
                                                                alignment:
                                                                    Alignment
                                                                        .center,
                                                                child: Icon(
                                                                  Icons.add,
                                                                  size: 15,
                                                                  color: Theme.of(
                                                                          context)
                                                                      .cardColor,
                                                                ),
                                                              ),
                                                            )
                                                          ] else ...[
                                                            // Construction: fixed quantity = 1
                                                            const Text('1'),
                                                          ]
                                                        ]),
                                                  ),
                                                ]),
                                          );
                                        },
                                      ),
                                    ),
                                  );
                                }),
                          ),
                          const SizedBox(height: Dimensions.paddingSizeLarge),
                        ]),
                    GetBuilder<CartController>(builder: (cartController) {
                      bool addToCart = true;
                      return cartController.isLoading
                          ? const Center(child: CircularProgressIndicator())
                          : Row(
                              spacing: Dimensions.paddingSizeSmall,
                              children: [
                                  if (Get.find<SplashController>()
                                              .configModel
                                              .content
                                              ?.directProviderBooking ==
                                          1 &&
                                      (widget.providerData != null ||
                                          cartController.selectedProvider !=
                                              null))
                                    GestureDetector(
                                      onTap: () {
                                        // showModalBottomSheet(
                                        //   useRootNavigator: true,
                                        //   isScrollControlled: true,
                                        //   backgroundColor: Colors.transparent,
                                        //   context: context, builder: (context) =>  AvailableProviderWidget(
                                        //   subcategoryId: widget.service?.subCategoryId ??"",
                                        // ));
                                      },
                                      child: SelectedProductWidget(
                                        providerData: widget.providerData ??
                                            cartController.selectedProvider,
                                      ),
                                    ),
                                  if (Get.find<SplashController>()
                                          .configModel
                                          .content
                                          ?.biddingStatus ==
                                      1)
                                    GestureDetector(
                                      onTap: () {
                                        Get.back();
                                        showModalBottomSheet(
                                            backgroundColor: Colors.transparent,
                                            isScrollControlled: true,
                                            context: Get.context!,
                                            builder: (BuildContext context) {
                                              return const BottomCreatePostDialog();
                                            });
                                        if (widget.service != null) {
                                          Get.find<CreatePostController>()
                                              .resetCreatePostValue(
                                                  removeService: false);
                                          Get.find<CreatePostController>()
                                              .updateSelectedService(
                                                  widget.service!);
                                        }
                                      },
                                      child: Container(
                                        height:
                                            ResponsiveHelper.isDesktop(context)
                                                ? 50
                                                : 45,
                                        decoration: BoxDecoration(
                                          borderRadius: BorderRadius.circular(
                                              Dimensions.radiusSmall),
                                          border: Border.all(
                                              color: Theme.of(context)
                                                  .colorScheme
                                                  .primary
                                                  .withValues(alpha: 0.5),
                                              width: 0.7),
                                          color: Theme.of(context)
                                              .colorScheme
                                              .primary
                                              .withValues(alpha: 0.1),
                                        ),
                                        padding: const EdgeInsets.symmetric(
                                            horizontal:
                                                Dimensions.paddingSizeSmall),
                                        child: Center(
                                            child: Hero(
                                          tag: 'provide_image',
                                          child: Image.asset(
                                            Images.customPostIcon,
                                            height: 30,
                                            width: 30,
                                          ),
                                        )),
                                      ),
                                    ),
                                  Expanded(
                                    child: CustomButton(
                                      height:
                                          ResponsiveHelper.isDesktop(context)
                                              ? 55
                                              : 45,
                                      onPressed: cartControllerInit.isButton
                                          ? () async {
                                              if (addToCart) {
                                                addToCart = false;
                                                // Resolve a provider ID to send with add-to-cart
                                                String providerId =
                                                    cartController
                                                            .selectedProvider
                                                            ?.id ??
                                                        widget
                                                            .providerData?.id ??
                                                        "";
                                                try {
                                                  if (providerId.isEmpty) {
                                                    await cartController
                                                        .getProviderBasedOnSubcategory(
                                                            widget.service
                                                                    ?.subCategoryId ??
                                                                "",
                                                            true);
                                                    if ((cartController
                                                                .providerList ??
                                                            [])
                                                        .isNotEmpty) {
                                                      providerId =
                                                          cartController
                                                                  .providerList!
                                                                  .first
                                                                  .id ??
                                                              "";
                                                    }
                                                  }
                                                } catch (_) {}
                                                await cartController
                                                    .addMultipleCartToServer(
                                                        providerId: providerId);
                                                await cartController
                                                    .getCartListFromServer(
                                                        shouldUpdate: true);
                                                if (widget.bookNowFlow ==
                                                    true) {
                                                  Get.find<CheckOutController>()
                                                      .updateState(PageState
                                                          .orderDetails);
                                                  Get.toNamed(RouteHelper
                                                      .getCheckoutRoute(
                                                          'cart',
                                                          'orderDetails',
                                                          'null'));
                                                }
                                              }
                                            }
                                          : null,
                                      buttonText: widget.bookNowFlow == true
                                          ? 'book'.tr
                                          : (cartController
                                                      .cartList.isNotEmpty &&
                                                  cartController.cartList
                                                          .elementAt(0)
                                                          .serviceId ==
                                                      widget.service!.id)
                                              ? 'update_cart'.tr
                                              : 'add_to_cart'.tr,
                                    ),
                                  )
                                ]);
                    }),
                  ],
                );
              }
              return Stack(
                children: [
                  Positioned(
                    top: 0,
                    right: 20,
                    child: Container(
                      height: 40,
                      width: 40,
                      alignment: Alignment.center,
                      decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          color: Colors.white70.withValues(alpha: 0.6),
                          boxShadow: [
                            BoxShadow(
                              color: Colors.grey[
                                  Get.find<ThemeController>().darkTheme
                                      ? 700
                                      : 300]!,
                              blurRadius: 2,
                              spreadRadius: 1,
                            )
                          ]),
                      child: InkWell(
                          onTap: () => Get.back(),
                          child: const Icon(Icons.close)),
                    ),
                  ),
                  SizedBox(
                      height: Get.height / 7,
                      child: Center(
                          child: Text(
                        'no_variation_is_available'.tr,
                        style: robotoMedium.copyWith(
                            fontSize: Dimensions.fontSizeLarge),
                      )))
                ],
              );
            });
          }),
        ),
      ),
    );
  }
}
