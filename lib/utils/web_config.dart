import 'package:flutter/foundation.dart';

class WebConfig {
  // Web-specific configuration for CORS handling
  static bool get isWebPlatform => kIsWeb;
  
  // Headers that are safe for web (don't trigger CORS preflight)
  static Map<String, String> get safeWebHeaders => {
    'Content-Type': 'application/json; charset=UTF-8',
  };
  
  // Check if we should use minimal headers for web
  static bool get useMinimalHeaders => kIsWeb;
  
  // Fallback configuration when API calls fail
  static const Duration apiTimeout = Duration(seconds: 10);
  static const int maxRetries = 3;
}
