import 'package:get/get.dart';
import 'package:makesmyhome/feature/autocare/model/autocare_service_model.dart';

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
    // Load doorstep autocare services
    _services.value = [
      AutocareServiceModel(
        id: '1',
        name: 'Car Wash',
        description: 'Professional car washing service',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBh4UEZHt86S3_ByyHFRpcLSueWbnmjp8iLV0TmqMtpN7CIBFV4KgMaTF2Q9NQKJxZpSSVzkaDHf5P7DxhDm9JPp95Eneb5-EZ5rmdVnPGPyyQt_KFs_HZk0ObOMIUOofiQ_7GcU8Ij5MBUMlfbbRgCOvbQ8wcmYHhJ6sJn2nYJ-8TsFWS4gPUQSoXNoDTDOGxOaYzRDqvNqcRYPcP-CdTPZGO7EyUG_lc7uVc0VUlrPg2u7FWRs_y6YyqFmWtEo7AMoYmwlJmzSGM',
      ),
      AutocareServiceModel(
        id: '2',
        name: 'Monthly Packages',
        description: 'Save with monthly subscriptions',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCtQIpxIFMr54YpiUX6-Fu8L6fsMol8YbuLS5SPZmvDX-a9gfnV4dsK7vXWSzFWIiJObLhtlVVycUbf-y0KqQJMSUkyMYT_GcrVd7Z5275TjZih0Boid0Ko7FR4l85DvsPrO0JF0gDy6Ir2QnK9d3lL-AHsBHCtVWzWAy1vefMV4ySS3YZyHAfH-XpcTWiKPog-RSM6SxIOjRaigRZY3FNnlhq710RcbtMm8zzf31LDSM4IubzDxicTU5EiixIbKX95YGYfheJDMM0',
        hasDiscount: true,
        discountText: '50% OFF',
      ),
      AutocareServiceModel(
        id: '3',
        name: 'Deep Clean',
        description: 'Complete interior and exterior cleaning',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC3inFmv8Dxk7YMl_VZbcYacnXHf1BdFCGKMrxnifLWl4bNqzrbpCbKS631CDP97l2gkwKg0xvbagoh4LgwnREZkH7vGJxTssdGBK6j-vdUon6yO_YVrukcSjgCNuH2EajGhZ4a8lgnilpHl_t0ATNkzrWsdrdsnj_-fWxM3ADmD24kYyi6TGMkSIRwdQEqJSyKe72pJnDDq62HNtodOps_vSo4sPRfZ_Abo40e3BAsMtuGQ82GFbtZnIElRoXQg3eA9SyjhUdU2vI',
      ),
      AutocareServiceModel(
        id: '4',
        name: 'Special Car Care',
        description: 'Premium detailing services',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDlB3D7RdFV_RXCL9wwdFXBYrfITUWOOYX5ExnYW9tQlViiGhSgXNZLNUoM4vbbcBd629UYqrHV-c2GOWMvRjC5hnZdRwkfw33m02VQTIuZ1FXgOp-QKZIjL4qKbmdFmEsiRJFwk_Ci8eoI8uChogn-8e07WPubHNcU7wIGpOXKAdfL3INEFGVLnlWIWJc5HzSnHlP-ilWiC--UkpTt53gBsFAGg9-ce57GwTFMPkRI4pcbgEeOtV99VgIaU6qMaVG__Pdb1Ipc_5A',
      ),
      AutocareServiceModel(
        id: '5',
        name: 'Shine & Coat',
        description: 'Protective coating and shine',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCRm2XnE5Q3cY4aqAInSypA_eA_yTrmHNx_XzSBsDxS-1HpDHLZvZtMRRU6-Xct92HLoKzxCSezyxYW9BwPopxnCAhS8rZNWAwstha7u5LDIJeF4u7IpE5UTzq_f022GdFend-pqt9z9LiDEDTTZVEXdCDPKcKQ33bL4f50Sk9MThDm5d-VxKY029IIXwIENISa4al-darWjpnpZC8wdeM0HCQADbRH8i4JqrDmYCyT0Z5G50FgfwRarYZztfRGzgMJpYlxgRIr7PE',
      ),
      AutocareServiceModel(
        id: '6',
        name: 'Luxury Car Care',
        description: 'Premium care for luxury vehicles',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCKJY4zTiB9TnQUjFa-OT3vdcIKCSLxUKbeUHEZpCNtxJWOFvTe1YOl7ux5ZS0ooHvI8bVQuIbPucE-_vfVKLsZGUBHscES2gk7oVzLUNJHunLHqTGGHlfkLjiHun_Ckhl0x_z7f0_GibWc9PuVuiPsyiKAdzQgZiq86sUbQwI45n2KYJlfhVqhvw1IGGroZBEsRXtBECkFPUwjytJyhjSWjCb7dAyzut0u-vpSk6xB1RhQJ0L-m5Cn5zirgu0V-rTTxbmVJootJL8',
      ),
      AutocareServiceModel(
        id: '7',
        name: 'Bike & Scooty',
        description: 'Two-wheeler cleaning service',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuArgfZaGjfX_yR2gDXJqzBTAR2_5JTmzQPxVWsqMiBFECtkJYNJuHQC_-YYjacHBs-9KEnQBewhztJZuz-oRp_KBROAjAcyL7Xj_WEDXMXf2czPQbpf6BsLV032AhzitC9b4n2IbVOH8ub32xDP-ZoO1skkYS33YxKPTBaqU2Y6QwMBE4HL4cEHd_GRa6OvbWPkk-dH5sxXdOlfIkD3B_mgT_t55h8tLMYK7ET-DNPP8JF6xiNKzZxJWaSUY6nUmV0DtGwm4GZ8P3k',
      ),
    ];
  }

  void _loadPackages() {
    // Load wash packages
    _packages.value = [
      AutocarePackageModel(
        id: 'pkg_1',
        name: 'Express Wash',
        description: 'Exterior Wash, Tyre Cleaning',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDHd_XN8UCFWALcmebaJ8TCrFYp0_X8sQ7ItCOk82PhzRsOadzWgFkIk5KgpLU_H-bwEh6ZgCvIRjt4RhDlOzkQeajbW2fkhqciT59WAdhxSQw9a90qqRiEW3VqhvGhJRCLo7M15mNqKkTuZNuzu1v2_cuEGY_E2Bg0MY0F1exmvWpRMg7LlEYY_plSLDznQqZLWhxlyt6WfsJbbwrGUGeiGQazDmIrkgNhbg-Dzv2w4xQNQOxRCdgTdvwdHMfZJrtOkhgU9reYmWU',
        price: 25.0,
        durationMinutes: 30,
        features: ['Exterior Wash', 'Tyre Cleaning'],
      ),
      AutocarePackageModel(
        id: 'pkg_2',
        name: 'Foam Wash',
        description: 'Express Wash services, plus Exterior Foam Wash, Basic Interior Vacuum, Tyre Polishing.',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBZlZTU6e5oWNt_l933pjdnkWxIKhbTDuDmrwawrOZsBQt4f53Nez7zQYgd5ciNQpiOmm65p4fnVrO80cKd--jt1zu2vK72THT5n5oW_9in9c0kyxSodYiPj9JLr0Hu8B8jCF0kbYmUn3o26LOj19SED4W7yUpthHhf2fTvEg0Kjgnqz0ZQM17aXvGG1_ExT6p2FIOplaDy6CGktVAZYbaSwN-oNy07RKytP0xOI0KcTjHu_9uK_tVbG5p2CgI0GAoDOUmiMhoXL0M',
        price: 45.0,
        durationMinutes: 45,
        features: ['Exterior Foam Wash', 'Basic Interior Vacuum', 'Tyre Polishing'],
      ),
      AutocarePackageModel(
        id: 'pkg_3',
        name: 'Premium Deep Clean',
        description: 'Foam Wash services, plus Full Interior Detailing, Wax Polish, Engine Bay Cleaning.',
        imageUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBymrkAP4ku2Sdl5toT-uM0prIvjgyDcQOmqHXclHT88e3Tf0XV3iU8u9cMfxwMm-0bL1qwybo3_fbrSgDFGM66rYGRglabKTuq9JxbJBJYYqxL2AIPH3mrfZLUfKAVp9zCnqPtTCMyyRnckuN1dTuhu-FAKd0Lf_EE4av9wcUwc96QU0P8vKjX4v0BMayRQeHVdyknkb9a4SKkKQlWHhhoKg2Sy1XXND9hWwvQbQtGjgGuu1yxdJZn9rHtNdLfICgIc9Z6Hbyxj2g',
        price: 80.0,
        durationMinutes: 90,
        features: ['Full Interior Detailing', 'Wax Polish', 'Engine Bay Cleaning'],
      ),
    ];
  }

  void navigateToPackageDetails(String serviceId) {
    // This will be implemented when we add routing
    Get.toNamed('/autocare/packages', arguments: {'serviceId': serviceId});
  }

  void bookPackage(AutocarePackageModel package) {
    // Implement booking logic here
    Get.snackbar(
      'Booking',
      'Booking ${package.name} for \$${package.price}',
      snackPosition: SnackPosition.BOTTOM,
    );
  }
}
