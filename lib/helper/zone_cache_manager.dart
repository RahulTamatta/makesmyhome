import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:makesmyhome/utils/core_export.dart';

/// Zone caching manager to prevent redundant API calls
/// Caches zone information based on coordinates with intelligent invalidation
class ZoneCacheManager {
  static ZoneCacheManager? _instance;
  static ZoneCacheManager get instance => _instance ??= ZoneCacheManager._();
  ZoneCacheManager._();

  final Map<String, _ZoneCacheEntry> _cache = {};
  static const Duration cacheExpiry = Duration(minutes: 30);
  static const double coordinateTolerance = 0.001; // ~100m accuracy
  Timer? _cleanupTimer;

  /// Get zone information with caching
  Future<ZoneResponseModel?> getZone(double lat, double lng) async {
    final cacheKey = _generateCacheKey(lat, lng);
    
    // Check if we have a valid cached entry
    final cachedEntry = _getCachedEntry(lat, lng);
    if (cachedEntry != null) {
      debugPrint('ZoneCacheManager: Using cached zone for ($lat, $lng)');
      return cachedEntry.zoneResponse;
    }

    // Prevent duplicate API calls for the same coordinates
    if (_cache.containsKey(cacheKey) && _cache[cacheKey]!.isLoading) {
      debugPrint('ZoneCacheManager: Zone request already in progress for ($lat, $lng)');
      return await _cache[cacheKey]!.future;
    }

    // Make API call and cache result
    debugPrint('ZoneCacheManager: Fetching zone from API for ($lat, $lng)');
    return await _fetchAndCacheZone(lat, lng);
  }

  /// Fetch zone from API and cache the result
  Future<ZoneResponseModel?> _fetchAndCacheZone(double lat, double lng) async {
    final cacheKey = _generateCacheKey(lat, lng);
    final completer = Completer<ZoneResponseModel?>();
    
    // Mark as loading
    _cache[cacheKey] = _ZoneCacheEntry(
      latitude: lat,
      longitude: lng,
      isLoading: true,
      future: completer.future,
      timestamp: DateTime.now(),
    );

    try {
      final locationController = Get.find<LocationController>();
      final zoneResponse = await locationController.getZone(lat.toString(), lng.toString(), false);
      
      if (zoneResponse.isSuccess) {
        // Cache successful response
        _cache[cacheKey] = _ZoneCacheEntry(
          latitude: lat,
          longitude: lng,
          zoneResponse: zoneResponse,
          isLoading: false,
          timestamp: DateTime.now(),
        );
        
        debugPrint('ZoneCacheManager: Cached zone ${zoneResponse.zoneIds} for ($lat, $lng)');
        completer.complete(zoneResponse);
        
        // Update API client headers if zone changed
        _updateApiClientHeaders(zoneResponse);
        
        return zoneResponse;
      } else {
        _cache.remove(cacheKey);
        completer.complete(null);
        return null;
      }
    } catch (e) {
      debugPrint('ZoneCacheManager: Error fetching zone: $e');
      _cache.remove(cacheKey);
      completer.completeError(e);
      rethrow;
    }
  }

  /// Get cached entry if available and valid
  _ZoneCacheEntry? _getCachedEntry(double lat, double lng) {
    // Check for exact match first
    final exactKey = _generateCacheKey(lat, lng);
    final exactEntry = _cache[exactKey];
    if (exactEntry != null && _isValidEntry(exactEntry)) {
      return exactEntry;
    }

    // Check for nearby cached entries within tolerance
    for (final entry in _cache.values) {
      if (_isValidEntry(entry) && _isWithinTolerance(lat, lng, entry.latitude, entry.longitude)) {
        debugPrint('ZoneCacheManager: Found nearby cached entry for ($lat, $lng)');
        return entry;
      }
    }

    return null;
  }

  /// Check if cache entry is valid (not expired and has data)
  bool _isValidEntry(_ZoneCacheEntry entry) {
    if (entry.isLoading) return false;
    if (entry.zoneResponse == null) return false;
    
    final age = DateTime.now().difference(entry.timestamp);
    return age < cacheExpiry;
  }

  /// Check if coordinates are within tolerance
  bool _isWithinTolerance(double lat1, double lng1, double lat2, double lng2) {
    final latDiff = (lat1 - lat2).abs();
    final lngDiff = (lng1 - lng2).abs();
    return latDiff <= coordinateTolerance && lngDiff <= coordinateTolerance;
  }

  /// Generate cache key from coordinates
  String _generateCacheKey(double lat, double lng) {
    // Round to tolerance precision to group nearby coordinates
    final roundedLat = (lat / coordinateTolerance).round() * coordinateTolerance;
    final roundedLng = (lng / coordinateTolerance).round() * coordinateTolerance;
    return '${roundedLat.toStringAsFixed(6)},${roundedLng.toStringAsFixed(6)}';
  }

  /// Update API client headers when zone changes
  void _updateApiClientHeaders(ZoneResponseModel zoneResponse) {
    try {
      final apiClient = Get.find<ApiClient>();
      final currentZoneId = Get.find<SharedPreferences>().getString(AppConstants.zoneId);
      final newZoneId = zoneResponse.zoneIds;
      
      if (newZoneId != currentZoneId) {
        debugPrint('ZoneCacheManager: Zone changed from $currentZoneId to $newZoneId');
        
        // Update stored zone ID
        Get.find<SharedPreferences>().setString(AppConstants.zoneId, newZoneId);
        
        // Refresh API client headers
        apiClient.refreshHeaders();
        
        // Clear service cache when zone changes
        _clearServiceCacheOnZoneChange();
      }
    } catch (e) {
      debugPrint('ZoneCacheManager: Error updating headers: $e');
    }
  }

  /// Clear service cache when zone changes
  void _clearServiceCacheOnZoneChange() {
    try {
      final sharedPreferences = Get.find<SharedPreferences>();
      final serviceEndpoints = [
        AppConstants.allServiceUri,
        AppConstants.popularServiceUri,
        AppConstants.trendingServiceUri,
        AppConstants.recommendedServiceUri,
        AppConstants.getFeaturedCategoryService,
      ];

      for (final endpoint in serviceEndpoints) {
        sharedPreferences.remove(AppConstants.baseUrl + endpoint);
      }
      
      debugPrint('ZoneCacheManager: Cleared service cache due to zone change');
    } catch (e) {
      debugPrint('ZoneCacheManager: Error clearing service cache: $e');
    }
  }

  /// Start periodic cleanup of expired entries
  void startCleanup() {
    _cleanupTimer?.cancel();
    _cleanupTimer = Timer.periodic(const Duration(minutes: 10), (_) {
      _cleanupExpiredEntries();
    });
  }

  /// Clean up expired cache entries
  void _cleanupExpiredEntries() {
    final now = DateTime.now();
    final expiredKeys = <String>[];
    
    for (final entry in _cache.entries) {
      final age = now.difference(entry.value.timestamp);
      if (age > cacheExpiry) {
        expiredKeys.add(entry.key);
      }
    }
    
    for (final key in expiredKeys) {
      _cache.remove(key);
    }
    
    if (expiredKeys.isNotEmpty) {
      debugPrint('ZoneCacheManager: Cleaned up ${expiredKeys.length} expired entries');
    }
  }

  /// Clear all cached zones
  void clearCache() {
    _cache.clear();
    debugPrint('ZoneCacheManager: Cache cleared');
  }

  /// Get cache statistics for debugging
  Map<String, dynamic> getCacheStats() {
    final now = DateTime.now();
    int validEntries = 0;
    int expiredEntries = 0;
    int loadingEntries = 0;

    for (final entry in _cache.values) {
      if (entry.isLoading) {
        loadingEntries++;
      } else {
        final age = now.difference(entry.timestamp);
        if (age < cacheExpiry) {
          validEntries++;
        } else {
          expiredEntries++;
        }
      }
    }

    return {
      'totalEntries': _cache.length,
      'validEntries': validEntries,
      'expiredEntries': expiredEntries,
      'loadingEntries': loadingEntries,
      'cacheExpiryMinutes': cacheExpiry.inMinutes,
      'coordinateTolerance': coordinateTolerance,
    };
  }

  /// Dispose resources
  void dispose() {
    _cleanupTimer?.cancel();
    _cleanupTimer = null;
    _cache.clear();
  }
}

/// Cache entry for zone information
class _ZoneCacheEntry {
  final double latitude;
  final double longitude;
  final ZoneResponseModel? zoneResponse;
  final bool isLoading;
  final Future<ZoneResponseModel?>? future;
  final DateTime timestamp;

  _ZoneCacheEntry({
    required this.latitude,
    required this.longitude,
    this.zoneResponse,
    this.isLoading = false,
    this.future,
    required this.timestamp,
  });
}
