import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/feature/subscription/view/subscription_screen.dart';
import 'package:makesmyhome/feature/autocare/view/autocare_main_screen.dart';

class BottomNavScreen extends StatefulWidget {
  final AddressModel? previousAddress;
  final bool showServiceNotAvailableDialog;
  final int pageIndex;
  const BottomNavScreen(
      {super.key,
      required this.pageIndex,
      this.previousAddress,
      required this.showServiceNotAvailableDialog});

  @override
  State<BottomNavScreen> createState() => _BottomNavScreenState();
}

class _BottomNavScreenState extends State<BottomNavScreen> {
  int _pageIndex = 0;
  bool _canExit = GetPlatform.isWeb ? true : false;

  @override
  void initState() {
    super.initState();
    _pageIndex = widget.pageIndex;

    if (_pageIndex == 1) {
      Get.find<BottomNavController>()
          .changePage(BnbItem.bookings, shouldUpdate: false);
    } else if (_pageIndex == 2) {
      Get.find<BottomNavController>()
          .changePage(BnbItem.cart, shouldUpdate: false);
    } else if (_pageIndex == 3) {
      Get.find<BottomNavController>()
          .changePage(BnbItem.autocare, shouldUpdate: false);
    } else if (_pageIndex == 4) {
      Get.find<BottomNavController>()
          .changePage(BnbItem.subscription, shouldUpdate: false);
    } else {
      Get.find<BottomNavController>()
          .changePage(BnbItem.homePage, shouldUpdate: false);
    }
  }

  @override
  Widget build(BuildContext context) {
    final padding = MediaQuery.of(context).padding;
    bool isUserLoggedIn = Get.find<AuthController>().isLoggedIn();

    return CustomPopScopeWidget(
      canPop: ResponsiveHelper.isWeb() ? true : false,
      onPopInvoked: () {
        if (Get.find<BottomNavController>().currentPage != BnbItem.homePage) {
          Get.find<BottomNavController>().changePage(BnbItem.homePage);
        } else {
          if (_canExit) {
            if (!GetPlatform.isWeb) {
              exit(0);
            }
          } else {
            customSnackBar('back_press_again_to_exit'.tr,
                type: ToasterMessageType.info);
            _canExit = true;
            Timer(const Duration(seconds: 2), () {
              _canExit = false;
            });
          }
        }
      },
      child: Scaffold(
        bottomNavigationBar: ResponsiveHelper.isDesktop(context)
            ? const SizedBox()
            : Container(
                padding: EdgeInsets.only(
                  top: Dimensions.paddingSizeDefault,
                  bottom:
                      padding.bottom > 15 ? 0 : Dimensions.paddingSizeDefault,
                ),
                color: Get.isDarkMode
                    ? Theme.of(context).cardColor.withValues(alpha: .5)
                    : Theme.of(context).primaryColor,
                child: SafeArea(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(
                        horizontal: Dimensions.paddingSizeExtraSmall),
                    child: Row(children: [
                      _bnbItem(
                        icon: Images.home,
                        bnbItem: BnbItem.homePage,
                        context: context,
                        onTap: () => Get.find<BottomNavController>()
                            .changePage(BnbItem.homePage),
                      ),
                      _bnbItem(
                        icon: Images.bookings,
                        bnbItem: BnbItem.bookings,
                        context: context,
                        onTap: () {
                          if (!isUserLoggedIn &&
                              Get.find<SplashController>()
                                      .configModel
                                      .content
                                      ?.guestCheckout ==
                                  1) {
                            Get.toNamed(RouteHelper.getTrackBookingRoute());
                          } else if (!isUserLoggedIn) {
                            Get.toNamed(RouteHelper.getNotLoggedScreen(
                                "booking", "my_bookings"));
                          } else {
                            Get.find<BottomNavController>()
                                .changePage(BnbItem.bookings);
                          }
                        },
                      ),
                      _bnbItem(
                        icon: Images.cart,
                        bnbItem: BnbItem.cart,
                        context: context,
                        onTap: () {
                          Get.find<BottomNavController>()
                              .changePage(BnbItem.cart);
                        },
                      ),
                      _bnbItem(
                        icon: Icons.subscriptions_rounded,
                        bnbItem: BnbItem.subscription,
                        context: context,
                        onTap: () {
                          if (!isUserLoggedIn) {
                            Get.toNamed(RouteHelper.getSignInRoute(
                                fromPage: RouteHelper.home));
                          } else {
                            Get.find<BottomNavController>()
                                .changePage(BnbItem.subscription);
                          }
                        },
                      ),
                      _bnbItem(
                        icon: Icons.local_car_wash,
                        bnbItem: BnbItem.autocare,
                        context: context,
                        onTap: () {
                          Get.find<BottomNavController>()
                              .changePage(BnbItem.autocare);
                        },
                      ),
                    ]),
                  ),
                ),
              ),
        body: GetBuilder<BottomNavController>(builder: (navController) {
          return _bottomNavigationView(
              widget.previousAddress, widget.showServiceNotAvailableDialog);
        }),
      ),
    );
  }

  Widget _bnbItem(
      {required dynamic icon,
      required BnbItem bnbItem,
      required GestureTapCallback onTap,
      context}) {
    return GetBuilder<BottomNavController>(builder: (bottomNavController) {
      return Expanded(
        child: InkWell(
          onTap: onTap,
          child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              mainAxisSize: MainAxisSize.min,
              children: [
                icon is String && icon.isEmpty
                    ? const SizedBox(width: 20, height: 20)
                    : icon is String
                        ? Image.asset(
                            icon,
                            width: 18,
                            height: 18,
                            color:
                                Get.find<BottomNavController>().currentPage ==
                                        bnbItem
                                    ? Colors.white
                                    : Colors.white60,
                          )
                        : Icon(
                            icon,
                            size: 22,
                            color:
                                Get.find<BottomNavController>().currentPage ==
                                        bnbItem
                                    ? Colors.white
                                    : Colors.white60,
                          ),
                const SizedBox(height: Dimensions.paddingSizeExtraSmall),
                Text(
                  bnbItem == BnbItem.subscription
                      ? 'Subscription'
                      : bnbItem == BnbItem.autocare
                          ? 'Wash'
                          : bnbItem.name.tr,
                  style: robotoRegular.copyWith(
                    fontSize: Dimensions.fontSizeSmall,
                    color:
                        Get.find<BottomNavController>().currentPage == bnbItem
                            ? Colors.white
                            : Colors.white60,
                  ),
                ),
              ]),
        ),
      );
    });
  }

  _bottomNavigationView(
      AddressModel? previousAddress, bool showServiceNotAvailableDialog) {
    PriceConverter.getCurrency();
    switch (Get.find<BottomNavController>().currentPage) {
      case BnbItem.homePage:
        return HomeScreen(
          addressModel: previousAddress,
          showServiceNotAvailableDialog: showServiceNotAvailableDialog,
        );
      case BnbItem.bookings:
        if (!Get.find<AuthController>().isLoggedIn()) {
          return const SizedBox();
        } else {
          return const BookingListScreen();
        }
      case BnbItem.subscription:
        if (!Get.find<AuthController>().isLoggedIn()) {
          WidgetsBinding.instance.addPostFrameCallback((_) {
            Get.toNamed(RouteHelper.getSignInRoute(fromPage: RouteHelper.home));
          });
          return const SizedBox();
        } else {
          return const MySubscriptionsPage();
        }
      case BnbItem.autocare:
        return const AutocareMainScreen();
      case BnbItem.cart:
        return const CartScreen(fromNav: true);
    }
  }
}
