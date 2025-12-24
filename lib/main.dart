import 'package:get/get.dart';
import 'package:makesmyhome/firebase_options.dart';

import 'feature/autocare/controller/autocare_controller.dart';
import 'feature/community/controller/community_controller.dart';
import 'feature/subscription/controller/subscription_controller.dart';
import 'feature/subscription/service.dart';
import 'helper/get_di.dart' as di;
import 'utils/core_export.dart';

final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
    FlutterLocalNotificationsPlugin();

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  if (ResponsiveHelper.isMobilePhone()) {
    HttpOverrides.global = MyHttpOverrides();
    await FlutterDownloader.initialize();
  }
  Get.lazyPut(() => CommunityController());
  Get.lazyPut(() => AutocareController());
  setPathUrlStrategy();

  try {
    if (GetPlatform.isWeb) {
      await Firebase.initializeApp(
          options: const FirebaseOptions(
              apiKey: "AIzaSyDQqrye3mW1Ol6KsSb2XXeZPm5IlGou0F8",
              authDomain: "housecraft-bd864.firebaseapp.com",
              projectId: "housecraft-bd864",
              storageBucket: "housecraft-bd864.firebasestorage.app",
              messagingSenderId: "1024512016620",
              appId: "1:1024512016620:web:5ead8ae8621c656105a5c9"));
      await FacebookAuth.instance.webAndDesktopInitialize(
        appId: "637072917840079",
        cookie: true,
        xfbml: true,
        version: "v15.0",
      );
    } else {
      await Firebase.initializeApp(
        options: DefaultFirebaseOptions.currentPlatform,
      );
    }
  } catch (e) {
    if (kDebugMode) {
      print(
          '[FIREBASE_INIT] Firebase already initialized or initialization error: $e');
    }
  }

  if (defaultTargetPlatform == TargetPlatform.android) {
    await FirebaseMessaging.instance.requestPermission();
  }

  Map<String, Map<String, String>> languages = await di.init();
  NotificationBody? body;
  String? path;
  try {
    if (!kIsWeb) {
      path = await initDynamicLinks();
    }

    final RemoteMessage? remoteMessage =
        await FirebaseMessaging.instance.getInitialMessage();
    if (remoteMessage != null) {
      body = NotificationHelper.convertNotification(remoteMessage.data);
    }
    await NotificationHelper.initialize(flutterLocalNotificationsPlugin);
    FirebaseMessaging.onBackgroundMessage(myBackgroundMessageHandler);
  } catch (e) {
    if (kDebugMode) {
      print("");
    }
  }
  Get.put(
    SubscriptionController(
      subscriptionService: SubscriptionService(),
    ),
  );
  runApp(MyApp(
    languages: languages,
    body: body,
    route: path,
  ));
}

class MyApp extends StatefulWidget {
  final Map<String, Map<String, String>>? languages;
  final NotificationBody? body;
  final String? route;
  const MyApp(
      {super.key, @required this.languages, @required this.body, this.route});

  @override
  State<MyApp> createState() => _MyAppState();
}

Future<String?> initDynamicLinks() async {
  final appLinks = AppLinks();
  final uri = await appLinks.getInitialLink();
  String? path;
  if (uri != null) {
    path = uri.path;
  } else {
    path = null;
  }
  return path;
}

class _MyAppState extends State<MyApp> {
  void _route() async {
    Get.find<SplashController>().getConfigData().then((success) async {
      // Print token for debugging
      final token = Get.find<AuthController>().getUserToken();
      debugPrint('[moshi mosh] [APP_LOAD] bearer_token: $token');
      final uid = Get.find<UserController>().userInfoModel?.id ?? '';
      debugPrint('[moshi mosh] [APP_LOAD] user_id: $uid');

      if (Get.find<LocationController>().getUserAddress() != null) {
        AddressModel addressModel =
            Get.find<LocationController>().getUserAddress()!;
        ZoneResponseModel responseModel = await Get.find<LocationController>()
            .getZone(addressModel.latitude.toString(),
                addressModel.longitude.toString(), false);
        addressModel.availableServiceCountInZone =
            responseModel.totalServiceCount;
        Get.find<LocationController>().saveUserAddress(addressModel);
      }
      if (Get.find<AuthController>().isLoggedIn()) {
        Get.find<AuthController>().updateToken();
      }
    });
  }

  @override
  void initState() {
    super.initState();

    if (kIsWeb || widget.route != null) {
      Get.find<SplashController>().initSharedData();
      Get.find<SplashController>().getCookiesData();
      Get.find<CartController>().getCartListFromServer();

      if (Get.find<AuthController>().isLoggedIn()) {
        Get.find<UserController>().getUserInfo();
      }

      if (Get.find<SplashController>().getGuestId().isEmpty) {
        var uuid = const Uuid().v1();
        Get.find<SplashController>().setGuestId(uuid);
      }
      _route();

      if (kIsWeb) {
        final uri = Uri.base;
        debugPrint('[WEB_DEEPLINK] Current URL: ${uri.toString()}');
        debugPrint('[WEB_DEEPLINK] URL Path: ${uri.path}');
        debugPrint('[WEB_DEEPLINK] URL Query: ${uri.query}');
        debugPrint(
            '[WEB_DEEPLINK] Expected payment success path: ${RouteHelper.paymentSuccess}');

        if (uri.path == RouteHelper.paymentSuccess ||
            uri.path == '/payment/success') {
          final fullRoute =
              uri.query.isNotEmpty ? '${uri.path}?${uri.query}' : uri.path;

          debugPrint(
              '[WEB_DEEPLINK] ✅ Detected payment success callback: $fullRoute');
          debugPrint('[WEB_DEEPLINK] Query parameters: ${uri.queryParameters}');

          WidgetsBinding.instance.addPostFrameCallback((_) {
            try {
              debugPrint(
                  '[WEB_DEEPLINK] Attempting to navigate to payment success route: $fullRoute');
              Get.offAllNamed(fullRoute);
              debugPrint('[WEB_DEEPLINK] ✅ Navigation successful');
            } catch (e) {
              debugPrint(
                  '[WEB_DEEPLINK][ERR] Failed to navigate to deep link: $e');

              try {
                debugPrint(
                    '[WEB_DEEPLINK] Trying fallback navigation with parameters');
                Get.offAllNamed(RouteHelper.paymentSuccess,
                    parameters: Map.fromEntries(uri.queryParameters.entries));
                debugPrint('[WEB_DEEPLINK] ✅ Fallback navigation successful');
              } catch (fallbackError) {
                debugPrint(
                    '[WEB_DEEPLINK][ERR] Fallback navigation failed: $fallbackError');

                try {
                  debugPrint('[WEB_DEEPLINK] Trying direct route navigation');
                  Get.offAllNamed('/payment/success',
                      parameters: Map.fromEntries(uri.queryParameters.entries));
                } catch (directError) {
                  debugPrint(
                      '[WEB_DEEPLINK][ERR] Direct navigation failed: $directError');
                }
              }
            }
          });
        } else {
          debugPrint(
              '[WEB_DEEPLINK] Not a payment success route, continuing normal flow');
        }
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return GetBuilder<ThemeController>(builder: (themeController) {
      return GetBuilder<LocalizationController>(builder: (localizeController) {
        return GetBuilder<SplashController>(builder: (splashController) {
          if ((GetPlatform.isWeb &&
              splashController.configModel.content == null)) {
            return MaterialApp(
              title: 'Loading...',
              debugShowCheckedModeBanner: false,
              home: Scaffold(
                body: Center(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      CircularProgressIndicator(),
                      SizedBox(height: 16),
                      Text('Loading configuration...'),
                      SizedBox(height: 8),
                      Text('Please wait while we set up the app',
                          style: TextStyle(fontSize: 12, color: Colors.grey)),
                    ],
                  ),
                ),
              ),
            );
          } else {
            return GetMaterialApp(
              title: AppConstants.appName,
              debugShowCheckedModeBanner: false,
              navigatorKey: Get.key,
              scrollBehavior: const MaterialScrollBehavior().copyWith(
                dragDevices: {PointerDeviceKind.mouse, PointerDeviceKind.touch},
              ),
              theme: themeController.darkTheme ? dark : light,
              locale: localizeController.locale,
              translations: Messages(languages: widget.languages),
              fallbackLocale: Locale(AppConstants.languages[0].languageCode!,
                  AppConstants.languages[0].countryCode),
              initialRoute: GetPlatform.isWeb
                  ? RouteHelper.getInitialRoute()
                  : RouteHelper.getSplashRoute(widget.body, widget.route),
              getPages: RouteHelper.routes,
              defaultTransition: Transition.fadeIn,
              transitionDuration: const Duration(milliseconds: 500),
              builder: (context, widget) => MediaQuery(
                data: MediaQuery.of(context)
                    .copyWith(textScaler: const TextScaler.linear(1)),
                child: Material(
                  child: SafeArea(
                    top: false,
                    bottom: GetPlatform.isAndroid,
                    child: Stack(
                      children: [
                        widget!,
                        GetBuilder<SplashController>(
                            builder: (splashController) {
                          if (!splashController.savedCookiesData ||
                              !splashController.getAcceptCookiesStatus(
                                  splashController
                                          .configModel.content?.cookiesText ??
                                      "")) {
                            return ResponsiveHelper.isWeb()
                                ? const Align(
                                    alignment: Alignment.bottomCenter,
                                    child: CookiesView())
                                : const SizedBox();
                          } else {
                            return const SizedBox();
                          }
                        })
                      ],
                    ),
                  ),
                ),
              ),
            );
          }
        });
      });
    });
  }
}

class MyHttpOverrides extends HttpOverrides {
  @override
  HttpClient createHttpClient(SecurityContext? context) {
    return super.createHttpClient(context)
      ..badCertificateCallback =
          (X509Certificate cert, String host, int port) => true;
  }
}
