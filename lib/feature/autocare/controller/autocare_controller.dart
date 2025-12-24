import 'package:get/get.dart';
import 'package:makesmyhome/feature/autocare/model/autocare_service_model.dart';
import 'package:makesmyhome/utils/core_export.dart';

class AutocareController extends GetxController implements GetxService {
  static AutocareController get to => Get.find();

  final RxList<AutocareServiceModel> _services = <AutocareServiceModel>[].obs;
  final RxList<AutocarePackageModel> _packages = <AutocarePackageModel>[].obs;
  final RxBool _isLoading = false.obs;

  List<AutocareServiceModel> get services => _services;
  List<AutocarePackageModel> get packages => _packages;
  bool get isLoading => _isLoading.value;

  @override
  void onInit() {
    super.onInit();
    _loadServices();
    _loadPackages();
  }

  void _loadServices() {
    fetchWashServices();
  }

  void _loadPackages() {
    ever<List<AutocareServiceModel>>(_services, (list) {
      final packages = <AutocarePackageModel>[];
      for (final s in list) {
        packages.add(
          AutocarePackageModel(
            id: s.id,
            name: s.name,
            description: s.description,
            imageUrl: s.imageUrl,
            price: 0.0,
            durationMinutes: 30,
            features: const [],
          ),
        );
      }
      _packages.value = packages;
      update();
    });
  }

  void navigateToPackageDetails(String serviceId) {
    Get.toNamed(RouteHelper.getServiceRoute(serviceId, fromPage: 'autocare'));
  }

  void bookPackage(AutocarePackageModel package) {
    if (package.id.isNotEmpty) {
      Get.toNamed(RouteHelper.getServiceRoute(package.id, fromPage: 'autocare'));
    }
  }

  Future<void> openWashCategory() async {
    try{
      final categoryController = Get.find<CategoryController>();
      await categoryController.getCategoryList(true);
      final list = categoryController.categoryList ?? [];
      final keywords = ['wash','car wash','autocare','detailing'];
      int index = list.indexWhere((c){
        final n = (c.name ?? '').toLowerCase();
        return keywords.any((k)=> n.contains(k));
      });
      if(index >= 0){
        final cat = list[index];
        Get.toNamed(RouteHelper.getCategoryProductRoute(cat.id ?? '', cat.name ?? '', index.toString()));
      }else{
        // Fallback: open categories screen so user can pick it manually
        Get.toNamed(RouteHelper.getCategoryRoute('fromAutocare',''));
      }
    }catch(_){
      customSnackBar('something_went_wrong'.tr);
    }
  }

  Future<void> fetchWashServices() async {
    _isLoading.value = true;
    update();
    try {
      final repo = Get.find<ServiceRepo>();
      final res = await repo.getAutocareServiceList(offset: 1);
      if (res.statusCode == 200) {
        final content = ServiceModel.fromJson(res.body).content;
        final list = content?.serviceList ?? [];
        _services.value = list.map((svc) {
          final hasDiscount = ((svc.serviceDiscount != null && svc.serviceDiscount!.isNotEmpty) ||
              (svc.campaignDiscount != null && svc.campaignDiscount!.isNotEmpty));
          return AutocareServiceModel(
            id: svc.id ?? '',
            name: svc.name ?? '',
            description: svc.shortDescription ?? svc.description ?? '',
            imageUrl: svc.thumbnailFullPath ?? svc.coverImageFullPath ?? '',
            hasDiscount: hasDiscount,
            discountText: hasDiscount ? 'Offer' : null,
          );
        }).toList();
      } else {
        final sc = Get.find<ServiceController>();
        if (sc.allService == null || (sc.allService?.isEmpty ?? true)) {
          await sc.getAllServiceList(1, true);
        }
        final List<Service> all = sc.allService ?? [];
        final keywords = ['wash', 'car wash', 'detailing', 'autocare', 'bike'];
        final filtered = all.where((svc) {
          final n = (svc.name ?? '').toLowerCase();
          final d = (svc.shortDescription ?? svc.description ?? '').toLowerCase();
          return keywords.any((k) => n.contains(k) || d.contains(k));
        }).toList();
        _services.value = filtered.map((svc) {
          final hasDiscount = ((svc.serviceDiscount != null && svc.serviceDiscount!.isNotEmpty) ||
              (svc.campaignDiscount != null && svc.campaignDiscount!.isNotEmpty));
          return AutocareServiceModel(
            id: svc.id ?? '',
            name: svc.name ?? '',
            description: svc.shortDescription ?? svc.description ?? '',
            imageUrl: svc.thumbnailFullPath ?? svc.coverImageFullPath ?? '',
            hasDiscount: hasDiscount,
            discountText: hasDiscount ? 'Offer' : null,
          );
        }).toList();
      }
      update();
    } catch (_) {}
    _isLoading.value = false;
    update();
  }
}
