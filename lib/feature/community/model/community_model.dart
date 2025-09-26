class CommunityPostModel {
  final String userName;
  final String postContent;
  final String postTime;
  final String photoUrl;

  CommunityPostModel({
    required this.userName,
    required this.postContent,
    required this.postTime,
    required this.photoUrl,
  });

  factory CommunityPostModel.mock(int index) {
    return CommunityPostModel(
      userName: 'User $index',
      postContent: 'This is a community post content #$index',
      postTime: 'Just now',
      photoUrl: 'https://randomuser.me/api/portraits/men/${index + 10}.jpg',
    );
  }
}
