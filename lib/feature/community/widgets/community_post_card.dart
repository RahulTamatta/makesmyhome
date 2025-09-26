import 'package:makesmyhome/feature/community/model/community_model.dart';
import 'package:makesmyhome/utils/core_export.dart';

class CommunityPostCard extends StatelessWidget {
  final CommunityPostModel post;

  const CommunityPostCard({super.key, required this.post});

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      child: Padding(
        padding: const EdgeInsets.all(12.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(post.userName, style: robotoMedium.copyWith(fontSize: 16)),
            const SizedBox(height: 4),
            Text(post.postTime,
                style: robotoRegular.copyWith(color: Colors.grey)),
            const SizedBox(height: 8),
            Image.network(
              'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmR_0AmKMFuFu2-DAC1kAR1StvgXGtQIx_Qg&s',
              height: 200,
              width: double.infinity,
              fit: BoxFit.cover,
            ),
            const SizedBox(height: 12),
            Text(post.postContent, style: robotoRegular),
            const SizedBox(height: 12),
            Row(
              children: [
                IconButton(
                    onPressed: () {},
                    icon: const Icon(Icons.thumb_up_alt_outlined)),
                IconButton(
                    onPressed: () {}, icon: const Icon(Icons.comment_outlined)),
                IconButton(
                    onPressed: () {}, icon: const Icon(Icons.share_outlined)),
              ],
            ),
          ],
        ),
      ),
    );
  }
}
