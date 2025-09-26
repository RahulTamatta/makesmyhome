class Subscription {
  final int? subscriptionId;
  final String? id;
  final String? name;
  final String? description;
  final String? price;
  final String? image;
  final String? status;
  final int? duration;
  final String? startDate;
  final String? endDate;
  final DateTime? createdAt;
  final DateTime? updatedAt;
  final String? serviceId;
  final String? shortDescription;
  final String? coverImage;
  final String? thumbnail;
  final String? categoryId;
  final String? subCategoryId;
  final String? tax;
  final int? orderCount;
  final int? isActive;
  final bool? subscribed;
  final int? ratingCount;
  final int? avgRating;
  final String? minBiddingPrice;
  final String? deletedAt;

  Subscription({
    this.subscriptionId,
    this.id,
    this.name,
    this.description,
    this.price,
    this.image,
    this.status,
    this.duration,
    this.startDate,
    this.endDate,
    this.createdAt,
    this.updatedAt,
    this.serviceId,
    this.shortDescription,
    this.coverImage,
    this.thumbnail,
    this.categoryId,
    this.subCategoryId,
    this.tax,
    this.orderCount,
    this.isActive,
    this.subscribed,
    this.ratingCount,
    this.avgRating,
    this.minBiddingPrice,
    this.deletedAt,
  });

  factory Subscription.fromJson(Map<String, dynamic> json) => Subscription(
        // Accept int or string for subscription_id
        subscriptionId: json["subscription_id"] is String
            ? int.tryParse(json["subscription_id"]) ??
                (json["subscription_id"] is num
                    ? (json["subscription_id"] as num).toInt()
                    : null)
            : (json["subscription_id"] is num
                ? (json["subscription_id"] as num).toInt()
                : null),
        // Coerce id to string (backend may send int)
        id: json["id"]?.toString(),
        name: json["name"],
        description: json["description"],
        // Some endpoints return 'amount' instead of 'price'
        price: (json["price"] ?? json["amount"])?.toString(),
        image: json["image"],
        // Status can come as 'status', 'buy_status', or 'subscription_status'
        status: (json.containsKey('status') && json['status'] != null)
            ? json['status'].toString()
            : (json.containsKey('buy_status') && json['buy_status'] != null)
                ? json['buy_status'].toString()
                : (json.containsKey('subscription_status') && json['subscription_status'] != null)
                    ? json['subscription_status'].toString()
                    : null,
        // Accept int or string for duration
        duration: json["duration"] is String
            ? int.tryParse(json["duration"]) ??
                (json["duration"] is num
                    ? (json["duration"] as num).toInt()
                    : null)
            : (json["duration"] is num
                ? (json["duration"] as num).toInt()
                : null),
        startDate: json["start_date"]?.toString(),
        endDate: json["end_date"]?.toString(),
        createdAt: _parseDateTime(json["created_at"]),
        updatedAt: _parseDateTime(json["updated_at"]),
        serviceId: json["service_id"]?.toString(),
        shortDescription: json["short_description"],
        coverImage: json["cover_image"],
        thumbnail: json["thumbnail"],
        categoryId: json["category_id"]?.toString(),
        subCategoryId: json["sub_category_id"]?.toString(),
        tax: json["tax"]?.toString(),
        orderCount: json["order_count"] is num
            ? (json["order_count"] as num).toInt()
            : int.tryParse(json["order_count"]?.toString() ?? ''),
        isActive: _determineActiveStatus(json),
        subscribed: json["subscribed"] == true || json["subscribed"] == "true",
        ratingCount: json["rating_count"] is num
            ? (json["rating_count"] as num).toInt()
            : int.tryParse(json["rating_count"]?.toString() ?? ''),
        avgRating: json["avg_rating"] is num
            ? (json["avg_rating"] as num).toInt()
            : int.tryParse(json["avg_rating"]?.toString() ?? ''),
        minBiddingPrice: json["min_bidding_price"]?.toString(),
        deletedAt: json["deleted_at"]?.toString(),
      );

  static DateTime? _parseDateTime(dynamic v) {
    if (v == null) return null;
    final s = v.toString();
    try {
      return DateTime.parse(s);
    } catch (_) {
      // Try to parse 'YYYY-MM-DD HH:MM:SS'
      try {
        final replaced = s.replaceFirst(' ', 'T');
        return DateTime.parse(replaced);
      } catch (_) {
        return null;
      }
    }
  }

  static int? _determineActiveStatus(Map<String, dynamic> json) {
    // First check if is_active is explicitly set
    if (json["is_active"] != null) {
      if (json["is_active"] is num) {
        return (json["is_active"] as num).toInt();
      }
      final parsed = int.tryParse(json["is_active"]?.toString() ?? '');
      if (parsed != null) return parsed;
    }

    // Check buy_status field
    final buyStatus = json["buy_status"]?.toString().toLowerCase();
    if (buyStatus == "active") return 1;
    if (buyStatus == "inactive" || buyStatus == "expired" || buyStatus == "cancelled") return 0;

    // Check subscription_status field
    final subscriptionStatus = json["subscription_status"]?.toString().toLowerCase();
    if (subscriptionStatus == "active") return 1;
    if (subscriptionStatus == "inactive" || subscriptionStatus == "expired" || subscriptionStatus == "cancelled") return 0;

    // Check general status field
    final status = json["status"]?.toString().toLowerCase();
    if (status == "active") return 1;
    if (status == "inactive" || status == "expired" || status == "cancelled") return 0;

    // Default to inactive if no status information is available
    return 0;
  }

  Map<String, dynamic> toJson() => {
        "subscription_id": subscriptionId,
        "id": id,
        "name": name,
        "description": description,
        "price": price,
        "image": image,
        "status": status,
        "duration": duration,
        "start_date": startDate,
        "end_date": endDate,
        "created_at": createdAt?.toIso8601String(),
        "updated_at": updatedAt?.toIso8601String(),
        "service_id": serviceId,
        "short_description": shortDescription,
        "cover_image": coverImage,
        "thumbnail": thumbnail,
        "category_id": categoryId,
        "sub_category_id": subCategoryId,
        "tax": tax,
        "order_count": orderCount,
        "is_active": isActive,
        "subscribed": subscribed,
        "rating_count": ratingCount,
        "avg_rating": avgRating,
        "min_bidding_price": minBiddingPrice,
        "deleted_at": deletedAt,
      };

  Subscription copyWith({
    int? subscriptionId,
    String? id,
    String? name,
    String? description,
    String? price,
    String? image,
    String? status,
    int? duration,
    String? startDate,
    String? endDate,
    DateTime? createdAt,
    DateTime? updatedAt,
    String? serviceId,
    String? shortDescription,
    String? coverImage,
    String? thumbnail,
    String? categoryId,
    String? subCategoryId,
    String? tax,
    int? orderCount,
    int? isActive,
    bool? subscribed,
    int? ratingCount,
    int? avgRating,
    String? minBiddingPrice,
    String? deletedAt,
  }) {
    return Subscription(
      subscriptionId: subscriptionId ?? this.subscriptionId,
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      price: price ?? this.price,
      image: image ?? this.image,
      status: status ?? this.status,
      duration: duration ?? this.duration,
      startDate: startDate ?? this.startDate,
      endDate: endDate ?? this.endDate,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
      serviceId: serviceId ?? this.serviceId,
      shortDescription: shortDescription ?? this.shortDescription,
      coverImage: coverImage ?? this.coverImage,
      thumbnail: thumbnail ?? this.thumbnail,
      categoryId: categoryId ?? this.categoryId,
      subCategoryId: subCategoryId ?? this.subCategoryId,
      tax: tax ?? this.tax,
      orderCount: orderCount ?? this.orderCount,
      isActive: isActive ?? this.isActive,
      subscribed: subscribed ?? this.subscribed,
      ratingCount: ratingCount ?? this.ratingCount,
      avgRating: avgRating ?? this.avgRating,
      minBiddingPrice: minBiddingPrice ?? this.minBiddingPrice,
      deletedAt: deletedAt ?? this.deletedAt,
    );
  }
}
