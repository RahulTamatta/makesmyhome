import 'package:makesmyhome/feature/community/controller/community_controller.dart';
import 'package:makesmyhome/feature/community/widgets/community_post_card.dart';
import 'package:makesmyhome/utils/core_export.dart';
import 'package:get/get.dart';

class CommunityScreen extends StatefulWidget {
  const CommunityScreen({super.key});

  @override
  State<CommunityScreen> createState() => _CommunityScreenState();
}

class _CommunityScreenState extends State<CommunityScreen> {
  final ScrollController _scrollController = ScrollController();

  @override
  void initState() {
    super.initState();
    // Load community-specific data here
    Get.find<CommunityController>().fetchCommunityPosts();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: CustomAppBar(title: 'Community'.tr),
      floatingActionButton: FloatingActionButton(
        onPressed: () {},
        tooltip: 'Create Post',
        // onPressed: () => Get.toNamed(RouteHelper.createCommunityPost),
        child: const Icon(Icons.add),
      ),
      body: GetBuilder<CommunityController>(builder: (communityController) {
        if (communityController.isLoading) {
          return const Center(child: CircularProgressIndicator());
        }

        if (communityController.posts.isEmpty) {
          return Center(
            child: Text('No community posts found', style: robotoRegular),
          );
        }

        return RefreshIndicator(
          onRefresh: () async {
            await communityController.fetchCommunityPosts();
          },
          child: ListView.builder(
            controller: _scrollController,
            itemCount: communityController.posts.length,
            itemBuilder: (context, index) {
              final post = communityController.posts[index];
              return CommunityPostCard(post: post);
            },
          ),
        );
      }),
    );
  }
}
