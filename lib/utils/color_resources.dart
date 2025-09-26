import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class ColorResources {
  // Brand Colors from your app icon
  static const Color primaryRed =
      Color(0xFFDB4942); // Exact red from icon #db4942
  static const Color accentYellow =
      Color(0xFFFFBD59); // Exact yellow outline #ffbd59
  static const Color warmWhite = Color(0xFFFFFDF7); // Warm white for contrast
  static const Color darkRed = Color(0xFFC43C35); // Darker red variant
  static const Color lightRed = Color(0xFFFDF2F2); // Light red background

  static Color getRightBubbleColor() {
    return Theme.of(Get.context!).primaryColor;
  }

  static Color getLeftBubbleColor() {
    return Get.isDarkMode
        ? const Color(0xA2B7B7BB)
        : primaryRed.withValues(alpha: 0.08); // Updated to use brand red
  }

  static const Map<String, Color> buttonBackgroundColorMap = {
    'pending': Color(0x45FDD835), // Light yellow
    'accepted': Color(0x4987CEEB), // Light blue (complementary)
    'ongoing': Color(0x62FF9800), // Orange (warm progression)
    'completed': Color(0x5F4CAF50), // Green (success)
    'settled': Color(0x6E8BC34A), // Light green
    'canceled': Color(0x51FFCDD2), // Light red
    'approved': Color(0x804CAF50), // Green
    'expired': Color(0x8C9E9E9E), // Grey
    'running': Color(0x79FF9800), // Orange
    'denied': Color(0x66F44336), // Red
    'paused': Color(0xFFFF9800), // Orange
    'resumed': Color(0x6F4CAF50), // Green
    'resume': Color(0x8E4CAF50), // Green
    'subscription_purchase': Color(0x3CFDD835), // Yellow
    'subscription_renew': Color(0x1D4CAF50), // Green
    'subscription_shift': Color(0x452196F3), // Blue
    'subscription_refund': Color(0x1D9C27B0), // Purple
  };

  static const Map<String, Color> buttonTextColorMap = {
    'pending': Color(0xFFE6941A), // Darker yellow variant
    'accepted': Color(0xFF1976D2), // Blue
    'ongoing': Color(0xFFE65100), // Dark orange
    'completed': Color(0xFF2E7D32), // Dark green
    'settled': Color(0xFF558B2F), // Dark green
    'canceled': Color(0xFFDB4942), // Exact brand red
    'approved': Color(0xFF2E7D32), // Dark green
    'expired': Color(0xFF616161), // Dark grey
    'running': Color(0xFFE65100), // Dark orange
    'denied': Color(0xFFC43C35), // Darker brand red
    'paused': Color(0xFFE65100), // Dark orange
    'resumed': Color(0xFF2E7D32), // Dark green
    'resume': Color(0xFF2E7D32), // Dark green
    'subscription_purchase': Color(0xFFE6941A), // Darker yellow
    'subscription_renew': Color(0xFF2E7D32), // Dark green
    'subscription_shift': Color(0xFF1565C0), // Dark blue
    'subscription_refund': Color(0xFF7B1FA2), // Dark purple
  };

  // Additional helper colors for your home services app
  static const Color successGreen = Color(0xFF4CAF50);
  static const Color warningOrange = Color(0xFFFF9800);
  static const Color errorRed = Color(0xFFDB4942); // Using brand red for errors
  static const Color infoBlue = Color(0xFF2196F3);

  // Neutral colors that complement your brand
  static const Color textPrimary = Color(0xFF212121);
  static const Color textSecondary = Color(0xFF757575);
  static const Color dividerColor = Color(0xFFE0E0E0);
  static const Color backgroundGrey = Color(0xFFFAFAFA);
}
