import 'package:makesmyhome/feature/subscription/controller/subscription_controller.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class MySubscriptionsPage extends StatelessWidget {
  const MySubscriptionsPage({super.key});

  @override
  Widget build(BuildContext context) {
    final controller = Get.find<SubscriptionController>();
    controller.fetchUserSubscriptions();
    // printf("");
    return Scaffold(
      appBar: AppBar(
        title: const Text("My Subscriptions"),
      ),
      body: Obx(() {
        if (controller.isLoading.value) {
          return const Center(child: CircularProgressIndicator());
        }

        if (controller.userSubscriptions.isEmpty) {
          return const Center(
            child: Text(
              "You don’t have any active subscriptions.",
              style: TextStyle(fontSize: 16, color: Colors.grey),
            ),
          );
        }

        return ListView.builder(
          padding: const EdgeInsets.all(12),
          itemCount: controller.userSubscriptions.length,
          itemBuilder: (context, index) {
            final sub = controller.userSubscriptions[index];
            // printf("");
            return Container(
              width: Get.width / 1.1, // wider professional look
              margin: const EdgeInsets.symmetric(vertical: 8, horizontal: 12),
              child: Card(
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(12)),
                child: Padding(
                  padding: const EdgeInsets.all(12.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      ClipRRect(
                        borderRadius: BorderRadius.circular(12),
                        child: Image.network(
                          sub.image ?? "",
                          height: 160,
                          width: double.infinity,
                          fit: BoxFit.cover,
                          errorBuilder: (ctx, _, __) => Container(
                            height: 160,
                            color: Colors.grey[300],
                            child: const Icon(Icons.image, size: 40),
                          ),
                        ),
                      ),
                      const SizedBox(height: 12),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Expanded(
                            child: Text(
                              sub.name ?? "",
                              style: const TextStyle(
                                fontSize: 18,
                                fontWeight: FontWeight.w600,
                              ),
                              overflow: TextOverflow.ellipsis,
                            ),
                          ),
                          Text(
                            "₹${sub.price}",
                            style: TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: Theme.of(context).primaryColor,
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 6),

                      Text(
                        sub.shortDescription ?? "",
                        style:
                            const TextStyle(fontSize: 14, color: Colors.grey),
                        maxLines: 2,
                        overflow: TextOverflow.ellipsis,
                      ),
                      const SizedBox(height: 10),

                      // 📌 Duration & Status
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Row(children: [
                            const Icon(Icons.schedule,
                                size: 16, color: Colors.grey),
                            const SizedBox(width: 4),
                            Text(
                              "${sub.duration} days",
                              style: const TextStyle(
                                  color: Colors.grey, fontSize: 13),
                            ),
                          ]),
                          Row(children: [
                            Icon(
                              sub.isActive == 1
                                  ? Icons.check_circle
                                  : Icons.cancel,
                              size: 16,
                              color: sub.isActive == 1
                                  ? Colors.green
                                  : Colors.redAccent,
                            ),
                            const SizedBox(width: 4),
                            Text(
                              sub.isActive == 1 ? "Active" : "Inactive",
                              style: TextStyle(
                                color: sub.isActive == 1
                                    ? Colors.green
                                    : Colors.red,
                                fontSize: 13,
                              ),
                            ),
                          ]),
                        ],
                      ),
                    ],
                  ),
                ),
              ),
            );
          },
        );
      }),
    );
  }
}
