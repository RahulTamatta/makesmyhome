class AutocareServiceModel {
  final String id;
  final String name;
  final String description;
  final String imageUrl;
  final bool hasDiscount;
  final String? discountText;

  AutocareServiceModel({
    required this.id,
    required this.name,
    required this.description,
    required this.imageUrl,
    this.hasDiscount = false,
    this.discountText,
  });
}

class AutocarePackageModel {
  final String id;
  final String name;
  final String description;
  final String imageUrl;
  final double price;
  final int durationMinutes;
  final List<String> features;

  AutocarePackageModel({
    required this.id,
    required this.name,
    required this.description,
    required this.imageUrl,
    required this.price,
    required this.durationMinutes,
    required this.features,
  });

  factory AutocarePackageModel.fromJson(Map<String, dynamic> json) {
    return AutocarePackageModel(
      id: json['id'] ?? '',
      name: json['name'] ?? '',
      description: json['description'] ?? '',
      imageUrl: json['image_url'] ?? '',
      price: (json['price'] ?? 0).toDouble(),
      durationMinutes: json['duration_minutes'] ?? 0,
      features: List<String>.from(json['features'] ?? []),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'image_url': imageUrl,
      'price': price,
      'duration_minutes': durationMinutes,
      'features': features,
    };
  }
}
