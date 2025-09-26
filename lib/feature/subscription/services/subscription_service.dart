import 'dart:convert';

import 'package:makesmyhome/feature/subscription/model.dart';
import 'package:http/http.dart' as http;

class SubscriptionService {
  final String baseUrl = 'https://housecraft.online/api/subscriptionmodule';
  final String token;

  SubscriptionService(this.token, {required apiClient});

  Map<String, String> get headers => {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      };

  Future<List<Subscription>> getSubscriptions() async {
    final response = await http.get(
      Uri.parse('$baseUrl/subscriptions'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final List<dynamic> data = json.decode(response.body);
      return data.map((json) => Subscription.fromJson(json)).toList();
    } else {
      throw Exception('Failed to load subscriptions');
    }
  }

  Future<List<Subscription>> getUserSubscriptions(int userId) async {
    final response = await http.get(
      Uri.parse('$baseUrl/MySubcription/$userId'),
      headers: headers,
    );

    if (response.statusCode == 200) {
      final List<dynamic> data = json.decode(response.body);
      return data.map((json) => Subscription.fromJson(json)).toList();
    } else {
      throw Exception('Failed to load user subscriptions');
    }
  }

  Future<bool> subscribeToService(
      int subscriptionId, String transactionId, String paymentMethod) async {
    final body = json.encode({
      'subscription_id': subscriptionId,
      'transaction_id': transactionId,
      'payment_method': paymentMethod,
      'user_id': 2 // Replace with actual user ID
    });

    final response = await http.post(
      Uri.parse('$baseUrl/subscriptions'),
      headers: headers,
      body: body,
    );

    return response.statusCode == 200;
  }
}
