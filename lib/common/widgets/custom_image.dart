import 'package:makesmyhome/utils/core_export.dart';

class CustomImage extends StatelessWidget {
  final String? image;
  final double? height;
  final double? width;
  final BoxFit? fit;
  final BoxFit? placeHolderBoxFit;
  final String? placeholder;
  const CustomImage({super.key, @required this.image, this.height, this.width, this.fit = BoxFit.cover, this.placeholder, this.placeHolderBoxFit });

  // Helper method to safely convert double to int, handling infinity and NaN
  int? _safeToInt(double? value) {
    if (value == null || value.isInfinite || value.isNaN) {
      return null;
    }
    return value.toInt();
  }

  @override
  Widget build(BuildContext context) {
    // Safely handle infinite dimensions for UI rendering
    final safeHeight = (height?.isInfinite == true || height?.isNaN == true) ? null : height;
    final safeWidth = (width?.isInfinite == true || width?.isNaN == true) ? null : width;
    
    return kIsWeb ? Image.network(
      image!, 
      height: safeHeight, 
      width: safeWidth, 
      fit: fit,
      // Optimize memory usage for web - safely handle infinity/NaN
      cacheWidth: _safeToInt(width),
      cacheHeight: _safeToInt(height),
      errorBuilder: (context, error, stackTrace) {
        return Image.asset(placeholder ?? Images.placeholder, height: safeHeight, width: safeWidth, fit: placeHolderBoxFit ?? fit);
      }
    ) : CachedNetworkImage(
      imageUrl: image!, 
      height: safeHeight, 
      width: safeWidth, 
      fit: fit,
      // Optimize memory usage for mobile - safely handle infinity/NaN
      memCacheWidth: _safeToInt(width),
      memCacheHeight: _safeToInt(height),
      maxWidthDiskCache: 800, // Limit disk cache size
      maxHeightDiskCache: 600,
      placeholder: (context, url) => Image.asset(placeholder ?? Images.placeholder, height: safeHeight, width: safeWidth, fit: placeHolderBoxFit ?? fit),
      errorWidget: (context, url, error) => Image.asset(placeholder ?? Images.placeholder, height: safeHeight, width: safeWidth, fit: placeHolderBoxFit ?? fit),
    );
  }
}
