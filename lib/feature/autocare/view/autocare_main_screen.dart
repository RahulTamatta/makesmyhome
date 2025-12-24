import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/feature/autocare/controller/autocare_controller.dart';
import 'package:makesmyhome/utils/dimensions.dart';
import 'package:makesmyhome/utils/styles.dart';

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
                // Banner with cashback offer
                SliverToBoxAdapter(
                  child: _buildPromoBanner(context),
                ),

                // Section Title
                SliverToBoxAdapter(
                  child: Padding(
                    padding: const EdgeInsets.fromLTRB(
                        Dimensions.paddingSizeDefault,
                        Dimensions.paddingSizeLarge,
                        Dimensions.paddingSizeDefault,
                        Dimensions.paddingSizeSmall),
                    child: Text(
                      'Car Wash',
                      style: robotoBold.copyWith(
                        fontSize: Dimensions.fontSizeLarge,
                        color: Theme.of(context).textTheme.bodyLarge?.color,
                      ),
                    ),
                  ),
                ),

                // Init loader to fetch Car Wash subcategories
                SliverToBoxAdapter(
                  child: GetBuilder<CategoryController>(
                    initState: (state) {
                      Future.delayed(Duration.zero, () async {
                        final cc = Get.find<CategoryController>();
                        await cc.getCategoryList(true);
                        final list = cc.categoryList ?? [];
                        final keywords = [
                          'wash',
                          'car wash',
                          'autocare',
                          'detailing'
                        ];
                        int index = list.indexWhere((c) {
                          final n = (c.name ?? '').toLowerCase();
                          return keywords.any((k) => n.contains(k));
                        });
                        if (index >= 0) {
                          final cat = list[index];
                          await cc.getSubCategoryList(cat.id!,
                              shouldUpdate: true);
                        }
                      });
                    },
                    builder: (_) => const SizedBox.shrink(),
                  ),
                ),

                // Box grid (HOORA-like) of car wash subcategories
                GetBuilder<CategoryController>(
                  builder: (categoryController) {
                    final subCategoryList =
                        categoryController.subCategoryList ?? [];
                    if (categoryController.subCategoryList == null) {
                      return SliverGrid(
                        gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                          crossAxisCount:
                              ResponsiveHelper.isMobile(context) ? 4 : 6,
                          mainAxisSpacing: Dimensions.paddingSizeSmall,
                          crossAxisSpacing: Dimensions.paddingSizeSmall,
                          childAspectRatio: 0.75,
                        ),
                        delegate: SliverChildBuilderDelegate(
                          (context, index) => _buildBoxShimmer(context),
                          childCount: 8,
                        ),
                      );
                    }
                    if (subCategoryList.isEmpty) {
                      return SliverToBoxAdapter(
                        child: SizedBox(
                          height: Get.height / 1.5,
                          child: NoDataScreen(
                            text: 'no_subcategory_found'.tr,
                            type: NoDataType.categorySubcategory,
                          ),
                        ),
                      );
                    }
                    return SliverPadding(
                      padding: const EdgeInsets.symmetric(
                        horizontal: Dimensions.paddingSizeDefault,
                      ),
                      sliver: SliverGrid(
                        gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                          crossAxisCount:
                              ResponsiveHelper.isMobile(context) ? 4 : 6,
                          mainAxisSpacing: Dimensions.paddingSizeSmall,
                          crossAxisSpacing: Dimensions.paddingSizeSmall,
                          childAspectRatio: 0.75,
                        ),
                        delegate: SliverChildBuilderDelegate(
                          (context, index) {
                            final cat = subCategoryList[index];
                            return _buildBoxItem(context, cat);
                          },
                          childCount: subCategoryList.length,
                        ),
                      ),
                    );
                  },
                ),

                const SliverToBoxAdapter(
                    child: SizedBox(height: Dimensions.paddingSizeLarge)),
              ],
            );
          },
        ),
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
                          borderRadius:
                              BorderRadius.circular(Dimensions.radiusSmall),
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

  Widget _buildBoxItem(BuildContext context, CategoryModel categoryModel) {
    return InkWell(
      onTap: () {
        Get.find<ServiceController>().cleanSubCategory();
        Get.toNamed(
            RouteHelper.allServiceScreenRoute(categoryModel.id!.toString()));
      },
      child: Container(
        decoration: BoxDecoration(
          color: Theme.of(context).cardColor,
          borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
          border: Border.all(
            color: Theme.of(context).dividerColor.withOpacity(0.1),
          ),
        ),
        padding: const EdgeInsets.all(Dimensions.paddingSizeSmall),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            ClipRRect(
              borderRadius: BorderRadius.circular(40),
              child: CustomImage(
                image: categoryModel.imageFullPath ?? "",
                height: 42,
                width: 42,
                fit: BoxFit.cover,
              ),
            ),
            const SizedBox(height: Dimensions.paddingSizeSmall),
            Text(
              categoryModel.name ?? '',
              style: robotoMedium.copyWith(fontSize: Dimensions.fontSizeSmall),
              textAlign: TextAlign.center,
              maxLines: 2,
              overflow: TextOverflow.ellipsis,
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildBoxShimmer(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Theme.of(context).cardColor,
        borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
      ),
    );
  }
}
