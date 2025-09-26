import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/feature/subscription/service.dart';
import 'package:makesmyhome/feature/subscription/model.dart';
import 'package:get/get.dart';

class AllPostScreen extends StatelessWidget {
  final String? fromNotification;
  const AllPostScreen({super.key, this.fromNotification});

  @override
  Widget build(BuildContext context) {
    final ScrollController scrollController = ScrollController();
    final userId =
        Get.find<UserController>().userInfoModel?.id?.toString() ?? '';

    // Initialize subscription controller
    Get.lazyPut(() => SubscriptionController(
          subscriptionService: SubscriptionService(),
        ));
    final subscriptionController = Get.find<SubscriptionController>();

    // Fetch user subscriptions when screen loads
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (userId.isNotEmpty) {
        subscriptionController.fetchUserSubscriptions();
      }
    });

    return CustomPopScopeWidget(
      child: Scaffold(
        appBar: CustomAppBar(
          title: 'Subscriptions'.tr,
          onBackPressed: () {
            if (fromNotification == "fromNotification" ||
                !Navigator.canPop(context)) {
              Get.offAllNamed(RouteHelper.getMainRoute("home"));
            } else {
              Get.back();
            }
          },
        ),
        endDrawer:
            ResponsiveHelper.isDesktop(context) ? const MenuDrawer() : null,
        body: SafeArea(
          child: RefreshIndicator(
            onRefresh: () async {
              if (userId.isNotEmpty) {
                await subscriptionController.fetchUserSubscriptions();
              }
            },
            child: Obx(() {
              if (subscriptionController.isLoading.value) {
                return const Center(child: CircularProgressIndicator());
              }

              if (subscriptionController.subscriptions.isEmpty) {
                return Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        Icons.subscriptions_outlined,
                        size: 80,
                        color: Theme.of(context).disabledColor,
                      ),
                      const SizedBox(height: 16),
                      Text(
                        'no_subscriptions_found'.tr,
                        style: robotoMedium.copyWith(
                          fontSize: Dimensions.fontSizeLarge,
                          color: Theme.of(context).disabledColor,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Text(
                        'subscribe_to_services_to_see_them_here'.tr,
                        style: robotoRegular.copyWith(
                          fontSize: Dimensions.fontSizeDefault,
                          color: Theme.of(context).hintColor,
                        ),
                        textAlign: TextAlign.center,
                      ),
                      const SizedBox(height: 24),
                      CustomButton(
                        width: 200,
                        buttonText: 'browse_services'.tr,
                        onPressed: () {
                          Get.back();
                        },
                      ),
                    ],
                  ),
                );
              }

              return CustomScrollView(
                controller: scrollController,
                physics: const AlwaysScrollableScrollPhysics(),
                slivers: [
                  SliverToBoxAdapter(
                    child: Column(
                      children: [
                        Center(
                          child: SizedBox(
                            width: Dimensions.webMaxWidth,
                            child: ListView.builder(
                              padding: const EdgeInsets.all(
                                  Dimensions.paddingSizeDefault),
                              itemCount:
                                  subscriptionController.subscriptions.length,
                              shrinkWrap: true,
                              physics: const NeverScrollableScrollPhysics(),
                              itemBuilder: (context, index) {
                                final subscription =
                                    subscriptionController.subscriptions[index];
                                return _buildSubscriptionCard(
                                    context, subscription);
                              },
                            ),
                          ),
                        ),
                        if (ResponsiveHelper.isDesktop(context))
                          const FooterView(),
                      ],
                    ),
                  ),
                ],
              );
            }),
          ),
        ),
      ),
    );
  }

  Widget _buildSubscriptionCard(
      BuildContext context, Subscription subscription) {
    return Card(
      margin: const EdgeInsets.only(bottom: Dimensions.paddingSizeDefault),
      child: Padding(
        padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                ClipRRect(
                  borderRadius: BorderRadius.circular(8),
                  child: CustomImage(
                    image:
                        '${AppConstants.baseUrl}/storage/app/public/subscription/${subscription.image}',
                    width: 80,
                    height: 80,
                    fit: BoxFit.cover,
                  ),
                ),
                const SizedBox(width: 16),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        subscription.name ?? '',
                        style: robotoMedium.copyWith(
                            fontSize: Dimensions.fontSizeLarge),
                        maxLines: 1,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 4),
                      Text(
                        subscription.shortDescription ?? '',
                        style: robotoRegular.copyWith(
                          fontSize: Dimensions.fontSizeSmall,
                          color: Theme.of(context).hintColor,
                        ),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 8),
                      if (subscription.endDate != null)
                        Row(
                          children: [
                            Text(
                              '${'valid_until'.tr}: ',
                              style: robotoMedium.copyWith(
                                  fontSize: Dimensions.fontSizeSmall),
                            ),
                            Text(
                              subscription.endDate ?? '',
                              style: robotoRegular.copyWith(
                                fontSize: Dimensions.fontSizeSmall,
                                color: Theme.of(context).primaryColor,
                              ),
                            ),
                          ],
                        ),
                    ],
                  ),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: Dimensions.paddingSizeSmall,
                    vertical: 4,
                  ),
                  decoration: BoxDecoration(
                    color: (subscription.isActive == 1)
                        ? Colors.green.withOpacity(0.1)
                        : Colors.orange.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(4),
                  ),
                  child: Text(
                    (subscription.isActive == 1) ? 'active'.tr : 'inactive'.tr,
                    style: robotoMedium.copyWith(
                      color: (subscription.isActive == 1)
                          ? Colors.green
                          : Colors.orange,
                      fontSize: Dimensions.fontSizeExtraSmall,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 12),
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      '${'price'.tr}:',
                      style: robotoRegular.copyWith(
                        fontSize: Dimensions.fontSizeSmall,
                        color: Theme.of(context).hintColor,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      '${PriceConverter.convertPrice(double.tryParse(subscription.price ?? '0') ?? 0)}',
                      style: robotoBold.copyWith(
                        fontSize: Dimensions.fontSizeLarge,
                        color: Theme.of(context).primaryColor,
                      ),
                    ),
                  ],
                ),
                if (subscription.isActive == 0)
                  CustomButton(
                    width: 120,
                    height: 35,
                    buttonText: 'renew'.tr,
                    onPressed: () {
                      // Navigate to subscription renewal screen
                      Get.back();
                    },
                  ),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
