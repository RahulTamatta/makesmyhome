import 'package:makesmyhome/feature/community/model/community_model.dart';
import 'package:get/get_state_manager/src/simple/get_controllers.dart';

class CommunityController extends GetxController {
  List<CommunityPostModel> posts = [];
  bool isLoading = true;

  Future<void> fetchCommunityPosts() async {
    isLoading = true;
    update();

    // Mock delay and data
    await Future.delayed(const Duration(seconds: 2));
    posts = List.generate(5, (i) => CommunityPostModel.mock(i));

    isLoading = false;
    update();
  }
}
