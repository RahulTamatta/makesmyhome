import 'package:makesmyhome/feature/profile/model/profile_cart_item_model.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({super.key});

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  @override
  void initState() {
    super.initState();
    if (Get.find<AuthController>().isLoggedIn()) {
      Get.find<UserController>().getUserInfo(reload: false);
    }
  }

  @override
  Widget build(BuildContext context) {
    bool isLoggedIn = Get.find<AuthController>().isLoggedIn();
    ConfigModel configModel = Get.find<SplashController>().configModel;

    bool pickedAddress =
        Get.find<LocationController>().getUserAddress() != null;

    final List<ProfileCardItemModel> menuListAsProfileCards = [
      ProfileCardItemModel(
        'MySubscription'.tr,
        Images.image,
        RouteHelper.subscription,
      ),
      ProfileCardItemModel(
        'inbox'.tr,
        Images.chatImage,
        isLoggedIn
            ? RouteHelper.getInboxScreenRoute()
            : RouteHelper.getNotLoggedScreen(RouteHelper.chatInbox, "inbox"),
      ),
      // ProfileCardItemModel(
      //   'language'.tr,
      //   Images.translate,
      //   RouteHelper.getLanguageScreen('fromSettingsPage'),
      // ),
      ProfileCardItemModel(
        'settings'.tr,
        Images.settings,
        RouteHelper.getSettingRoute(),
      ),

      // ProfileCardItemModel(
      //   configModel.content?.guestCheckout == 0 || isLoggedIn
      //       ? 'bookings'.tr
      //       : "track_booking".tr,
      //   Images.bookingsIcon,
      //   !isLoggedIn && configModel.content?.guestCheckout == 1
      //       ? RouteHelper.getTrackBookingRoute()
      //       : !isLoggedIn
      //           ? RouteHelper.getNotLoggedScreen("booking", "my_bookings")
      //           : RouteHelper.getBookingScreenRoute(true),
      // ),
      ProfileCardItemModel(
        'vouchers'.tr,
        Images.voucherIcon,
        RouteHelper.getVoucherRoute(fromPage: 'menu'),
      ),
      // ProfileCardItemModel(
      //   'my_favorite'.tr,
      //   Images.myFavorite,
      //   !isLoggedIn
      //       ? RouteHelper.getNotLoggedScreen(
      //           RouteHelper.favorite, "my_favorite")
      //       : RouteHelper.getMyFavoriteScreen(),
      // ),

      if (configModel.content!.walletStatus != 0 && isLoggedIn)
        ProfileCardItemModel(
          'my_wallet'.tr,
          Images.walletMenu,
          RouteHelper.getMyWalletScreen(),
        ),
      if (configModel.content!.loyaltyPointStatus != 0 && isLoggedIn)
        ProfileCardItemModel(
          'loyalty_point'.tr,
          Images.myPoint,
          RouteHelper.getLoyaltyPointScreen(),
        ),
      if (configModel.content?.referEarnStatus == 1)
        ProfileCardItemModel(
          'refer_and_earn'.tr,
          Images.shareIcon,
          isLoggedIn
              ? RouteHelper.getReferAndEarnScreen()
              : RouteHelper.getNotLoggedScreen(
                  RouteHelper.referAndEarn, "refer_and_earn"),
        ),
      ProfileCardItemModel(
        'service_area'.tr,
        Images.areaMenuIcon,
        RouteHelper.getServiceArea(),
      ),
      ProfileCardItemModel(
        'about_us'.tr,
        Images.aboutUs,
        RouteHelper.getHtmlRoute('about_us'),
      ),
      ProfileCardItemModel(
        'help_&_support'.tr,
        Images.helpIcon,
        RouteHelper.getSupportRoute(),
      ),
      if (configModel.content?.providerSelfRegistration == 1)
        ProfileCardItemModel(
          'become_a_provider'.tr,
          Images.providerImage,
          GetPlatform.isWeb
              ? '${AppConstants.baseUrl}/provider/auth/sign-up'
              : RouteHelper.getProviderWebView(),
        ),
      ProfileCardItemModel(
        'privacy_policy'.tr,
        Images.privacyPolicyIcon,
        RouteHelper.getHtmlRoute('privacy-policy'),
      ),
      if (configModel.content?.termsAndConditions != "")
        ProfileCardItemModel(
          'terms_and_conditions'.tr,
          Images.termsIcon,
          RouteHelper.getHtmlRoute('terms-and-condition'),
        ),
      if (configModel.content?.refundPolicy != "")
        ProfileCardItemModel(
          'refund_policy'.tr,
          Images.refundPolicy,
          RouteHelper.getHtmlRoute('refund_policy'),
        ),
      if (configModel.content?.cancellationPolicy != "")
        ProfileCardItemModel(
          'cancellation_policy'.tr,
          Images.cancellationPolicy,
          RouteHelper.getHtmlRoute('cancellation_policy'),
        ),
    ];

    final profileCartModelList = [
      ProfileCardItemModel(
        'cart'.tr,
        Images.completed,
        !isLoggedIn
            ? RouteHelper.getSignInRoute(fromPage: RouteHelper.home)
            : RouteHelper.getCartRoute(),
      ),
      ProfileCardItemModel(
        'my_address'.tr,
        Images.address,
        Get.find<AuthController>().isLoggedIn()
            ? RouteHelper.getAddressRoute('fromProfileScreen')
            : RouteHelper.getNotLoggedScreen(RouteHelper.profile, "profile"),
      ),
      ProfileCardItemModel(
        'notifications'.tr,
        Images.notification,
        pickedAddress
            ? RouteHelper.getNotificationRoute()
            : RouteHelper.getPickMapRoute(
                RouteHelper.notification, true, 'false', null, null),
      ),
      if (!Get.find<AuthController>().isLoggedIn())
        ProfileCardItemModel(
          'sign_in'.tr,
          Images.logout,
          RouteHelper.getSignInRoute(fromPage: RouteHelper.profile),
        ),
      if (Get.find<AuthController>().isLoggedIn())
        ProfileCardItemModel(
          'suggest_new_service'.tr,
          Images.suggestServiceIcon,
          pickedAddress
              ? RouteHelper.getNewSuggestedServiceScreen()
              : RouteHelper.getPickMapRoute(
                  RouteHelper.suggestService, true, 'false', null, null),
        ),
      if (Get.find<AuthController>().isLoggedIn())
        ProfileCardItemModel(
          'delete_account'.tr,
          Images.accountDelete,
          'delete_account',
        ),
      if (Get.find<AuthController>().isLoggedIn())
        ProfileCardItemModel(
          'logout'.tr,
          Images.logout,
          'sign_out',
        ),
      ...menuListAsProfileCards,
    ];

    return CustomPopScopeWidget(
      child: Scaffold(
        backgroundColor: Theme.of(context).colorScheme.surface,
        endDrawer:
            ResponsiveHelper.isDesktop(context) ? const MenuDrawer() : null,
        appBar: CustomAppBar(
          title: 'profile'.tr,
          centerTitle: true,
          bgColor: Theme.of(context).primaryColor,
          isBackButtonExist: true,
          onBackPressed: () {
            if (Navigator.canPop(context)) {
              Get.back();
            } else {
              Get.offAllNamed(RouteHelper.getMainRoute("home"));
            }
          },
        ),
        body: GetBuilder<UserController>(
          builder: (userController) {
            return userController.userInfoModel == null &&
                    Get.find<AuthController>().isLoggedIn()
                ? const Center(child: CircularProgressIndicator())
                : FooterBaseView(
                    child: WebShadowWrap(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          ProfileHeader(
                            userInfoModel: userController.userInfoModel,
                          ),
                          const SizedBox(height: Dimensions.paddingSizeLarge),
                          GridView.builder(
                            physics: const NeverScrollableScrollPhysics(),
                            shrinkWrap: true,
                            padding: const EdgeInsets.symmetric(
                                horizontal: Dimensions.paddingSizeDefault),
                            gridDelegate:
                                SliverGridDelegateWithFixedCrossAxisCount(
                              crossAxisCount:
                                  ResponsiveHelper.isMobile(context) ? 1 : 2,
                              childAspectRatio: 6,
                              crossAxisSpacing:
                                  Dimensions.paddingSizeExtraLarge,
                              mainAxisSpacing: Dimensions.paddingSizeSmall,
                            ),
                            itemCount: profileCartModelList.length,
                            itemBuilder: (context, index) {
                              return ProfileCardItem(
                                title: profileCartModelList[index].title,
                                leadingIcon:
                                    profileCartModelList[index].loadingIcon,
                                onTap: () {
                                  if (profileCartModelList[index].routeName ==
                                      'sign_out') {
                                    if (Get.find<AuthController>()
                                        .isLoggedIn()) {
                                      Get.dialog(
                                          ConfirmationDialog(
                                              icon: Images.logoutIcon,
                                              title:
                                                  'are_you_sure_to_logout'.tr,
                                              description:
                                                  "if_you_logged_out_your_cart_will_be_removed"
                                                      .tr,
                                              yesButtonColor:
                                                  Theme.of(Get.context!)
                                                      .colorScheme
                                                      .primary,
                                              onYesPressed: () async {
                                                Get.find<AuthController>()
                                                    .clearSharedData();
                                                Get.find<AuthController>()
                                                    .googleLogout();
                                                Get.find<AuthController>()
                                                    .signOutWithFacebook();
                                                Get.find<AuthController>()
                                                    .signOutWithFacebook();
                                                Get.offAllNamed(RouteHelper
                                                    .getInitialRoute());
                                              }),
                                          useSafeArea: false);
                                    } else {
                                      Get.toNamed(RouteHelper.getSignInRoute());
                                    }
                                  } else if (profileCartModelList[index]
                                          .routeName ==
                                      'delete_account') {
                                    Get.dialog(
                                        ConfirmationDialog(
                                            icon: Images.deleteProfile,
                                            title:
                                                'are_you_sure_to_delete_your_account'
                                                    .tr,
                                            description:
                                                'it_will_remove_your_all_information'
                                                    .tr,
                                            yesButtonText: 'delete',
                                            noButtonText: 'cancel',
                                            onYesPressed: () =>
                                                userController.removeUser()),
                                        useSafeArea: false);
                                  } else {
                                    Get.toNamed(
                                        profileCartModelList[index].routeName);
                                  }
                                },
                              );
                            },
                          ),
                          const SizedBox(
                            height: Dimensions.paddingSizeDefault,
                          )
                        ],
                      ),
                    ),
                  );
          },
        ),
      ),
    );
  }
}
