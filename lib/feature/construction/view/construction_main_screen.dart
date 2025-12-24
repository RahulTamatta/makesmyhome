import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:makesmyhome/utils/dimensions.dart';
import 'package:makesmyhome/utils/styles.dart';

class ConstructionMainScreen extends StatelessWidget {
  const ConstructionMainScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: CustomScrollView(
          slivers: [
            SliverToBoxAdapter(child: _buildPromoBanner(context)),

            SliverToBoxAdapter(
              child: Padding(
                padding: const EdgeInsets.fromLTRB(
                  Dimensions.paddingSizeDefault,
                  Dimensions.paddingSizeLarge,
                  Dimensions.paddingSizeDefault,
                  Dimensions.paddingSizeSmall,
                ),
                child: Text(
                  'Construction & Renovation',
                  style: robotoBold.copyWith(
                    fontSize: Dimensions.fontSizeLarge,
                    color: Theme.of(context).textTheme.bodyLarge?.color,
                  ),
                ),
              ),
            ),

            // Trigger subcategory loading for the Construction parent category
            SliverToBoxAdapter(
              child: GetBuilder<CategoryController>(
                initState: (state) {
                  Future.delayed(Duration.zero, () async {
                    final cc = Get.find<CategoryController>();
                    await cc.getCategoryList(true);
                    final list = cc.categoryList ?? [];
                    final keywords = [
                      'construction',
                      'renovation',
                      'civil',
                      'builder',
                      'repair'
                    ];
                    int index = list.indexWhere((c) {
                      final n = (c.name ?? '').toLowerCase();
                      return keywords.any((k) => n.contains(k)) ||
                          n.contains('construction & renovation');
                    });
                    if (index >= 0) {
                      final cat = list[index];
                      await cc.getSubCategoryList(cat.id!, shouldUpdate: true);
                    }
                  });
                },
                builder: (_) => const SizedBox.shrink(),
              ),
            ),

            // Grid of subcategories
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
              child: SizedBox(height: Dimensions.paddingSizeLarge),
            ),
          ],
        ),
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

  Widget _buildPromoBanner(BuildContext context) {
    return Container(
      margin: const EdgeInsets.all(Dimensions.paddingSizeDefault),
      height: 180,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
        image: const DecorationImage(
          image: NetworkImage(
              'https://images.unsplash.com/photo-1503387762-592deb58ef4e?q=80&w=1600&auto=format&fit=crop'),
          fit: BoxFit.cover,
        ),
      ),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(Dimensions.radiusDefault),
          color: Colors.black.withOpacity(0.3),
        ),
        alignment: Alignment.centerLeft,
        padding: const EdgeInsets.all(Dimensions.paddingSizeDefault),
        child: Text(
          'Find Experts for Your Construction & Renovation',
          style: robotoBold.copyWith(color: Colors.white),
        ),
      ),
    );
  }
}
