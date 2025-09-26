import 'dart:convert';
import 'dart:developer';

import 'package:makesmyhome/common/models/errrors_model.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/foundation.dart' as foundation;
import 'package:get/get.dart';
import 'package:http/http.dart' as http;
import 'package:path/path.dart';

class ApiClient extends GetxService {
  final String? appBaseUrl;
  final SharedPreferences sharedPreferences;
  static final String noInternetMessage = 'connection_to_api_server_failed'.tr;
  final int timeoutInSeconds = 30;

  String? token;
  late Map<String, String> _mainHeaders;

  ApiClient({required this.appBaseUrl, required this.sharedPreferences}) {
    token = sharedPreferences.getString(AppConstants.token);
    printLog('Token: $token');
    AddressModel? addressModel;
    try {
      addressModel = AddressModel.fromJson(
          jsonDecode(sharedPreferences.getString(AppConstants.userAddress)!));
      printLog(addressModel.toJson());
    } catch (e) {
      if (kDebugMode) {
        print('');
      }
    }

    ///pick zone id to update header
    updateHeader(
        token,
        addressModel?.zoneId,
        sharedPreferences.getString(AppConstants.languageCode),
        sharedPreferences.getString(AppConstants.guestId));
  }
  void updateHeader(
      String? token, String? zoneIDs, String? languageCode, String? guestID) {
    // Base headers
    final headers = <String, String>{
      'Content-Type': 'application/json; charset=UTF-8',
    };

    // Always attach essential headers required by backend to resolve zone-filtered data
    final resolvedZoneId = zoneIDs ?? sharedPreferences.getString(AppConstants.zoneId) ?? '';
    final resolvedLang = languageCode ?? AppConstants.languages[0].languageCode!;

    // zoneId is critical for service endpoints - include on all platforms
    if (resolvedZoneId.isNotEmpty && resolvedZoneId != 'configuration') {
      headers[AppConstants.zoneId] = resolvedZoneId;
    } else {
      // Fallback zone for web when no zone is set or still using default
      headers[AppConstants.zoneId] = 'configuration';
    }

    // X-localization header is required for proper API responses
    headers[AppConstants.localizationKey] = resolvedLang;

    // Guest ID - include if available
    final guest = guestID ?? sharedPreferences.getString(AppConstants.guestId) ?? '';
    if (guest.isNotEmpty) {
      headers[AppConstants.guestId] = guest;
    }
    
    // Authorization token
    if (token != null && token.isNotEmpty) {
      headers['Authorization'] = 'Bearer $token';
    }
    
    _mainHeaders = headers;
    
    if (kDebugMode) {
      debugPrint('ApiClient headers updated: $headers');
    }
  }

  /// Force refresh headers - useful for web when zone/auth state changes
  void refreshHeaders() {
    final token = sharedPreferences.getString(AppConstants.token);
    final zoneId = sharedPreferences.getString(AppConstants.zoneId);
    final languageCode = sharedPreferences.getString(AppConstants.languageCode);
    final guestId = sharedPreferences.getString(AppConstants.guestId);
    
    updateHeader(token, zoneId, languageCode, guestId);
    
    if (kDebugMode) {
      debugPrint('ApiClient headers refreshed for web');
    }
  }

  Future<Response> getData(String uri,
      {Map<String, dynamic>? query, Map<String, String>? headers}) async {
    final Map<String, String> effectiveHeaders = {
      ..._mainHeaders,
      if (headers != null) ...headers,
    };
    log("My API : ${uri.startsWith('http') ? uri : appBaseUrl! + uri}, headers : $headers");
    printLog('====> API Call: $uri\nHeader: $effectiveHeaders');

    const int maxAttempts = 3;
    int attempt = 0;
    while (true) {
      attempt++;
      try {
        final Uri requestUri = uri.startsWith('http')
            ? Uri.parse(uri)
            : Uri.parse(appBaseUrl! + uri);
            
        final http.Response response = await http
            .get(
              requestUri,
              headers: effectiveHeaders,
            )
            .timeout(Duration(seconds: timeoutInSeconds));
        return handleResponse(response, uri);
      } catch (e) {
        try { log('GET $uri attempt#$attempt failed: $e'); } catch (_) {}
        if (attempt >= maxAttempts) {
          return Response(statusCode: 1, statusText: noInternetMessage);
        }
        // simple backoff: 500ms, 1000ms
        await Future.delayed(Duration(milliseconds: 500 * attempt));
      }
    }
  }

  Future<Response> postData(String? uri, dynamic body,
      {Map<String, String>? headers}) async {
    final Map<String, String> effectiveHeaders = {
      ..._mainHeaders,
      if (headers != null) ...headers,
    };
    printLog('====> API Call: $uri\nHeader: $effectiveHeaders');
    printLog('====> body : ${body.toString()}');

    const int maxAttempts = 3;
    int attempt = 0;
    while (true) {
      attempt++;
      try {
        final Uri requestUri = uri!.startsWith('http')
            ? Uri.parse(uri)
            : Uri.parse(appBaseUrl! + uri);
            
        final http.Response response = await http
            .post(
              requestUri,
              body: jsonEncode(body),
              headers: effectiveHeaders,
            )
            .timeout(Duration(seconds: timeoutInSeconds));
        return handleResponse(response, uri);
      } catch (e) {
        try { log('POST $uri attempt#$attempt failed: $e'); } catch (_) {}
        if (attempt >= maxAttempts) {
          return Response(statusCode: 1, statusText: noInternetMessage);
        }
        await Future.delayed(Duration(milliseconds: 500 * attempt));
      }
    }
  }

  Future<Response> postMultipartDataConversation(
      String? uri, Map<String, String> body, List<MultipartBody>? multipartBody,
      {Map<String, String>? headers, List<PlatformFile>? otherFile}) async {
    http.MultipartRequest request =
        http.MultipartRequest('POST', Uri.parse(appBaseUrl! + uri!));
    final Map<String, String> effectiveHeaders = {
      ..._mainHeaders,
      if (headers != null) ...headers,
    };
    request.headers.addAll(effectiveHeaders);

    if (otherFile != null) {
      if (otherFile.isNotEmpty) {
        for (PlatformFile platformFile in otherFile) {
          request.files.add(http.MultipartFile(
              'files[${otherFile.indexOf(platformFile)}]',
              platformFile.readStream!,
              platformFile.size,
              filename: basename(platformFile.name)));
        }
      }
    }
    if (multipartBody != null) {
      for (MultipartBody multipart in multipartBody) {
        Uint8List list = await multipart.file.readAsBytes();
        request.files.add(http.MultipartFile(
          multipart.key!,
          multipart.file.readAsBytes().asStream(),
          list.length,
          filename: '${DateTime.now().toString()}.png',
        ));
      }
    }
    request.fields.addAll(body);
    http.Response response =
        await http.Response.fromStream(await request.send());
    return handleResponse(response, uri);
  }

  Future<Response> postMultipartData(
      String? uri, Map<String, String> body, List<MultipartBody>? multipartBody,
      {Map<String, String>? headers}) async {
    try {
      http.MultipartRequest request =
          http.MultipartRequest('POST', Uri.parse(appBaseUrl! + uri!));
      final Map<String, String> effectiveHeaders = {
        ..._mainHeaders,
        if (headers != null) ...headers,
      };
      request.headers.addAll(effectiveHeaders);
      for (MultipartBody multipart in multipartBody!) {
        if (kIsWeb) {
          Uint8List list = await multipart.file.readAsBytes();
          http.MultipartFile part = http.MultipartFile(
            multipart.key!,
            multipart.file.readAsBytes().asStream(),
            list.length,
            filename: basename(multipart.file.path),
            contentType: MediaType('images', 'jpg'),
          );
          request.files.add(part);
        } else {
          File file = File(multipart.file.path);
          request.files.add(http.MultipartFile(
            multipart.key!,
            file.readAsBytes().asStream(),
            file.lengthSync(),
            filename: file.path.split('/').last,
          ));
        }
      }
      request.fields.addAll(body);
      http.Response response =
          await http.Response.fromStream(await request.send());
      return handleResponse(response, uri);
    } catch (e) {
      return Response(statusCode: 1, statusText: noInternetMessage);
    }
  }

  Future<Response> putData(String? uri, dynamic body,
      {Map<String, String>? headers}) async {
    printLog('====> body : ${body.toString()}');
    try {
      final Map<String, String> effectiveHeaders = {
        ..._mainHeaders,
        if (headers != null) ...headers,
      };
      
      final Uri requestUri = uri!.startsWith('http')
          ? Uri.parse(uri)
          : Uri.parse(appBaseUrl! + uri);
          
      http.Response response = await http
          .put(
            requestUri,
            body: jsonEncode(body),
            headers: effectiveHeaders,
          )
          .timeout(Duration(seconds: timeoutInSeconds));
      return handleResponse(response, uri);
    } catch (e) {
      return Response(statusCode: 1, statusText: noInternetMessage);
    }
  }

  Future<Response> deleteData(String? uri,
      {Map<String, String>? headers}) async {
    try {
      final Map<String, String> effectiveHeaders = {
        ..._mainHeaders,
        if (headers != null) ...headers,
      };
      http.Response response = await http
          .delete(
            Uri.parse(appBaseUrl! + uri!),
            headers: effectiveHeaders,
          )
          .timeout(Duration(seconds: timeoutInSeconds));
      return handleResponse(response, uri);
    } catch (e) {
      return Response(statusCode: 1, statusText: noInternetMessage);
    }
  }

  Response handleResponse(http.Response response, String? uri) {
    dynamic body;
    try {
      body = jsonDecode(response.body);
    } catch (e) {
      if (kDebugMode) {
        print("");
      }
    }
    Response response0 = Response(
      body: body ?? response.body,
      bodyString: response.body.toString(),
      request: Request(
          headers: response.request!.headers,
          method: response.request!.method,
          url: response.request!.url),
      headers: response.headers,
      statusCode: response.statusCode,
      statusText: response.reasonPhrase,
    );
    if (response0.statusCode != 200 &&
        response0.body != null &&
        response0.body is! String) {
      if (response0.body.toString().startsWith('{response_code:')) {
        ErrorsModel errorResponse = ErrorsModel.fromJson(response0.body);
        response0 = Response(
            statusCode: response0.statusCode,
            body: response0.body,
            statusText: errorResponse.responseCode);
      } else if (response0.body.toString().startsWith('{message')) {
        response0 = Response(
            statusCode: response0.statusCode,
            body: response0.body,
            statusText: response0.body['message']);
      }
    } else if (response0.statusCode != 200 && response0.body == null) {
      response0 = Response(statusCode: 0, statusText: noInternetMessage);
    }
    if (foundation.kDebugMode) {
      debugPrint('====> API Response: [${response0.statusCode}] $uri');
      // debugPrint('====> API Response: [${response0.statusCode}] $uri\n${response0.body}');
    }
    return response0;
  }
}

class MultipartBody {
  String? key;
  XFile file;

  MultipartBody(this.key, this.file);
}
