import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/feature/autocare/controller/autocare_controller.dart';
import 'package:makesmyhome/utils/dimensions.dart';
import 'package:makesmyhome/utils/styles.dart';
import 'package:cached_network_image/cached_network_image.dart';

class AutocareMainScreen extends StatelessWidget {
  const AutocareMainScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: GetBuilder<AutocareController>(
          init: AutocareController(),
          builder: (controller) {
            return CustomScrollView(
              slivers: [
                // Header with location and vehicle info
                SliverToBoxAdapter(
                  child: _buildHeader(context),
                ),

                // Banner with cashback offer
                SliverToBoxAdapter(
                  child: _buildPromoBanner(context),
                ),

                // Services Section
                SliverToBoxAdapter(
                  child: Padding(
                    padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Doorstep Autocare Services',
                          style: robotoBold.copyWith(
                            fontSize: Dimensions.fontSizeLarge,
                            color: Theme.of(context).textTheme.bodyLarge?.color,
                          ),
                        ),
                        const SizedBox(height: Dimensions.paddingSizeDefault),
                      ],
                    ),
                  ),
                ),

                // Services Grid
                SliverPadding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: Dimensions.paddingSizeDefault,
                  ),
                  sliver: SliverGrid(
                    gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: 3,
                      childAspectRatio: 0.85,
                      crossAxisSpacing: Dimensions.paddingSizeDefault,
                      mainAxisSpacing: Dimensions.paddingSizeDefault,
                    ),
                    delegate: SliverChildBuilderDelegate(
                      (context, index) {
                        final service = controller.services[index];
                        return _buildServiceCard(context, service, controller);
                      },
                      childCount: controller.services.length,
                    ),
                  ),
                ),

                const SliverToBoxAdapter(
                  child: SizedBox(height: Dimensions.paddingSizeLarge),
                ),
              ],
            );
          },
        ),
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          // Call support action
          Get.snackbar(
            'Support',
            'Calling customer support...',
            snackPosition: SnackPosition.BOTTOM,
          );
        },
        backgroundColor: Colors.blue,
        child: const Icon(Icons.call, color: Colors.white),
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          // Location Section
          Expanded(
            child: Row(
              children: [
                Icon(
                  Icons.location_on,
                  color: Theme.of(context).primaryColor,
                  size: 24,
                ),
                const SizedBox(width: Dimensions.paddingSizeSmall),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        children: [
                          Text(
                            'Other - Add address',
                            style: robotoMedium.copyWith(
                              fontSize: Dimensions.fontSizeDefault,
                              color: Theme.of(context).textTheme.bodyLarge?.color,
                            ),
                          ),
                          const Icon(Icons.arrow_drop_down, size: 20),
                        ],
                      ),
                      Text(
                        'Surat',
                        style: robotoRegular.copyWith(
                          fontSize: Dimensions.fontSizeSmall,
                          color: Theme.of(context).hintColor,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // Vehicle Section
          Row(
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.end,
                children: [
                  Text(
                    'Baleno',
                    style: robotoMedium.copyWith(
                      fontSize: Dimensions.fontSizeDefault,
                      color: Theme.of(context).textTheme.bodyLarge?.color,
                    ),
                  ),
                  Text(
                    'Maruti Suzuki',
                    style: robotoRegular.copyWith(
                      fontSize: Dimensions.fontSizeSmall,
                      color: Theme.of(context).hintColor,
                    ),
                  ),
                ],
              ),
              const SizedBox(width: Dimensions.paddingSizeSmall),
              Icon(
                Icons.directions_car,
                color: Theme.of(context).textTheme.bodyLarge?.color,
                size: 32,
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildPromoBanner(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(Dimensions.paddingSizeDefault),
      height: 200,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
        image: const DecorationImage(
          image: NetworkImage(
            'https://lh3.googleusercontent.com/aida-public/AB6AXuCuwkRjJZC_jgV_WDWeUZqekAuFVZN-r2zWCTtRr2kDRMqf7T00KzzfuuyXPvTfDQre9Wpar1xPtpv54d4iOHSI4BldoIZfqTkSLZElGUG-jIroFaP6JHF1kTSgqF0fsWJIre2LDXRIKKLtWZt-E-KgVVAzsQ5DNBkfuIABCctBxSUiapOsDJpa4LO5cQJAfG2JsEY0Rum8q1iFkPxC5E5MDiUNXCx_9l-D1dnwgDeS2YZDrSTzL5rKMz2RL5vuBY8aA2BZZM1VPmk',
          ),
          fit: BoxFit.cover,
        ),
      ),
      child: Stack(
        children: [
          // Dark overlay
          Container(
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
              color: Colors.black.withOpacity(0.3),
            ),
          ),

          // Promo content
          Padding(
            padding: const EdgeInsets.all(Dimensions.paddingSizeSmall),
            child: Column(
              children: [
                Container(
                  padding: const EdgeInsets.symmetric(
                    horizontal: Dimensions.paddingSizeDefault,
                    vertical: Dimensions.paddingSizeSmall,
                  ),
                  decoration: BoxDecoration(
                    color: Theme.of(context).primaryColor,
                    borderRadius: const BorderRadius.only(
                      topLeft: Radius.circular(Dimensions.radiusDefault),
                      topRight: Radius.circular(Dimensions.radiusDefault),
                    ),
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            RichText(
                              text: TextSpan(
                                children: [
                                  TextSpan(
                                    text: '100% ',
                                    style: robotoBold.copyWith(
                                      fontSize: 24,
                                      color: Colors.white,
                                    ),
                                  ),
                                  TextSpan(
                                    text: 'Cashback up to ₹500',
                                    style: robotoBold.copyWith(
                                      fontSize: Dimensions.fontSizeLarge,
                                      color: Colors.white,
                                    ),
                                  ),
                                ],
                              ),
                            ),
                            Text(
                              'ON FIRST CAR WASH',
                              style: robotoMedium.copyWith(
                                fontSize: Dimensions.fontSizeSmall,
                                color: Colors.white,
                              ),
                            ),
                          ],
                        ),
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(
                          horizontal: Dimensions.paddingSizeDefault,
                          vertical: Dimensions.paddingSizeSmall,
                        ),
                        decoration: BoxDecoration(
                          color: Colors.black.withOpacity(0.8),
                          borderRadius: BorderRadius.circular(Dimensions.radiusSmall),
                        ),
                        child: Text(
                          '05:58:09',
                          style: robotoMedium.copyWith(
                            fontSize: Dimensions.fontSizeDefault,
                            color: Colors.white,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // Dots indicator
          Positioned(
            bottom: 8,
            left: 0,
            right: 0,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                _buildDot(true),
                const SizedBox(width: 8),
                _buildDot(false),
                const SizedBox(width: 8),
                _buildDot(false),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildDot(bool isActive) {
    return Container(
      width: 8,
      height: 8,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        color: isActive ? Colors.white : Colors.white.withOpacity(0.5),
      ),
    );
  }

  Widget _buildServiceCard(
    BuildContext context,
    service,
    AutocareController controller,
  ) {
    return InkWell(
      onTap: () {
        controller.navigateToPackageDetails(service.id);
      },
      child: Column(
        children: [
          Stack(
            children: [
              // Service Image
              Container(
                width: 80,
                height: 80,
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
                ),
                child: ClipRRect(
                  borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
                  child: CachedNetworkImage(
                    imageUrl: service.imageUrl,
                    fit: BoxFit.contain,
                    placeholder: (context, url) => Container(
                      color: Theme.of(context).cardColor,
                      child: const Center(
                        child: CircularProgressIndicator(),
                      ),
                    ),
                    errorWidget: (context, url, error) => Container(
                      color: Theme.of(context).cardColor,
                      child: const Icon(Icons.car_repair),
                    ),
                  ),
                ),
              ),

              // Discount Badge
              if (service.hasDiscount && service.discountText != null)
                Positioned(
                  top: -4,
                  right: -4,
                  child: Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 8,
                      vertical: 4,
                    ),
                    decoration: BoxDecoration(
                      color: Theme.of(context).primaryColor,
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Text(
                      service.discountText!,
                      style: robotoMedium.copyWith(
                        fontSize: 10,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
            ],
          ),
          const SizedBox(height: Dimensions.paddingSizeSmall),
          Text(
            service.name,
            textAlign: TextAlign.center,
            style: robotoMedium.copyWith(
              fontSize: Dimensions.fontSizeSmall,
              color: Theme.of(context).textTheme.bodyLarge?.color,
            ),
            maxLines: 2,
            overflow: TextOverflow.ellipsis,
          ),
        ],
      ),
    );
  }
}
