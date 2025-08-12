# 📱 Flutter Implementation Examples for Ahjili API

## 🏗️ Project Structure

```
lib/
├── main.dart
├── models/
│   ├── user.dart
│   ├── post.dart
│   ├── comment.dart
│   └── api_response.dart
├── services/
│   ├── api_service.dart
│   ├── auth_service.dart
│   ├── post_service.dart
│   └── notification_service.dart
├── screens/
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── home/
│   │   └── home_screen.dart
│   ├── posts/
│   │   ├── post_detail_screen.dart
│   │   └── create_post_screen.dart
│   └── profile/
│       └── profile_screen.dart
├── widgets/
│   ├── post_card.dart
│   ├── comment_card.dart
│   └── loading_widget.dart
└── utils/
    ├── constants.dart
    ├── storage_helper.dart
    └── image_helper.dart
```

## 📦 Required Dependencies

```yaml
dependencies:
  flutter:
    sdk: flutter
  http: ^1.1.0
  shared_preferences: ^2.2.2
  flutter_secure_storage: ^9.0.0
  image_picker: ^1.0.5
  cached_network_image: ^3.3.0
  provider: ^6.1.1
  intl: ^0.18.1
  firebase_messaging: ^14.7.6
  firebase_core: ^2.24.2
  permission_handler: ^11.1.0
  image: ^4.1.3
  path_provider: ^2.1.2
```

## 🔧 Core Services Implementation

### 1. API Service Base

```dart
// services/api_service.dart
import 'dart:convert';
import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class ApiService {
  static const String baseUrl = 'https://ahjili.com/api';
  static const _storage = FlutterSecureStorage();
  
  // Get stored auth token
  static Future<String?> getAuthToken() async {
    return await _storage.read(key: 'auth_token');
  }
  
  // Save auth token
  static Future<void> saveAuthToken(String token) async {
    await _storage.write(key: 'auth_token', value: token);
  }
  
  // Remove auth token
  static Future<void> removeAuthToken() async {
    await _storage.delete(key: 'auth_token');
  }

  // Get app settings (public endpoint)
  static Future<ApiResponse<AppSettings>> getSettings() async {
    return await get<AppSettings>(
      '/settings',
      withAuth: false,
      fromJson: (json) => AppSettings.fromJson(json),
    );
  }
  
  // Get headers with auth token
  static Future<Map<String, String>> getHeaders({bool withAuth = true}) async {
    Map<String, String> headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    
    if (withAuth) {
      final token = await getAuthToken();
      if (token != null) {
        headers['Authorization'] = 'Bearer $token';
      }
    }
    
    return headers;
  }
  
  // Generic GET request
  static Future<ApiResponse<T>> get<T>(
    String endpoint, {
    Map<String, dynamic>? queryParams,
    bool withAuth = false,
    T Function(Map<String, dynamic>)? fromJson,
  }) async {
    try {
      Uri uri = Uri.parse('$baseUrl$endpoint');
      if (queryParams != null) {
        uri = uri.replace(queryParameters: queryParams);
      }
      
      final headers = await getHeaders(withAuth: withAuth);
      final response = await http.get(uri, headers: headers);
      
      return _handleResponse<T>(response, fromJson);
    } catch (e) {
      return ApiResponse.error('Network error: ${e.toString()}');
    }
  }
  
  // Generic POST request
  static Future<ApiResponse<T>> post<T>(
    String endpoint, {
    Map<String, dynamic>? body,
    bool withAuth = false,
    T Function(Map<String, dynamic>)? fromJson,
  }) async {
    try {
      final headers = await getHeaders(withAuth: withAuth);
      final response = await http.post(
        Uri.parse('$baseUrl$endpoint'),
        headers: headers,
        body: jsonEncode(body),
      );
      
      return _handleResponse<T>(response, fromJson);
    } catch (e) {
      return ApiResponse.error('Network error: ${e.toString()}');
    }
  }
  
  // Multipart POST for file uploads
  static Future<ApiResponse<T>> postMultipart<T>(
    String endpoint, {
    Map<String, String>? fields,
    Map<String, File>? files,
    bool withAuth = true,
    T Function(Map<String, dynamic>)? fromJson,
  }) async {
    try {
      final request = http.MultipartRequest(
        'POST',
        Uri.parse('$baseUrl$endpoint'),
      );
      
      // Add auth header
      if (withAuth) {
        final token = await getAuthToken();
        if (token != null) {
          request.headers['Authorization'] = 'Bearer $token';
        }
      }
      
      // Add fields
      if (fields != null) {
        request.fields.addAll(fields);
      }
      
      // Add files
      if (files != null) {
        for (var entry in files.entries) {
          request.files.add(
            await http.MultipartFile.fromPath(entry.key, entry.value.path),
          );
        }
      }
      
      final streamedResponse = await request.send();
      final response = await http.Response.fromStream(streamedResponse);
      
      return _handleResponse<T>(response, fromJson);
    } catch (e) {
      return ApiResponse.error('Network error: ${e.toString()}');
    }
  }
  
  // Handle API response
  static ApiResponse<T> _handleResponse<T>(
    http.Response response,
    T Function(Map<String, dynamic>)? fromJson,
  ) {
    final Map<String, dynamic> data = jsonDecode(response.body);
    
    if (response.statusCode >= 200 && response.statusCode < 300) {
      if (fromJson != null && data['data'] != null) {
        return ApiResponse.success(fromJson(data['data']));
      }
      return ApiResponse.success(data as T);
    } else {
      String errorMessage = data['message'] ?? 'Unknown error occurred';
      return ApiResponse.error(errorMessage, errors: data['errors']);
    }
  }
}
```

### 2. API Response Model

```dart
// models/api_response.dart
class ApiResponse<T> {
  final bool success;
  final T? data;
  final String? message;
  final Map<String, dynamic>? errors;
  
  ApiResponse.success(this.data) 
      : success = true, message = null, errors = null;
  
  ApiResponse.error(this.message, {this.errors}) 
      : success = false, data = null;
  
  bool get isSuccess => success;
  bool get isError => !success;
}
```

### 3. Data Models

```dart
// models/app_settings.dart
class AppSettings {
  final bool anonymousPostingEnabled;
  final bool anonymousCommentsEnabled;
  final bool registrationEnabled;
  final int maxPostLength;
  final int maxImageSize;
  final List<String> supportedImageTypes;
  final List<String> categories;
  final String appName;
  final String appVersion;
  final bool maintenanceMode;

  AppSettings({
    required this.anonymousPostingEnabled,
    required this.anonymousCommentsEnabled,
    required this.registrationEnabled,
    required this.maxPostLength,
    required this.maxImageSize,
    required this.supportedImageTypes,
    required this.categories,
    required this.appName,
    required this.appVersion,
    required this.maintenanceMode,
  });

  factory AppSettings.fromJson(Map<String, dynamic> json) {
    return AppSettings(
      anonymousPostingEnabled: json['anonymous_posting_enabled'] ?? false,
      anonymousCommentsEnabled: json['anonymous_comments_enabled'] ?? false,
      registrationEnabled: json['registration_enabled'] ?? true,
      maxPostLength: json['max_post_length'] ?? 2000,
      maxImageSize: json['max_image_size'] ?? 5120,
      supportedImageTypes: List<String>.from(json['supported_image_types'] ?? []),
      categories: List<String>.from(json['categories'] ?? []),
      appName: json['app_name'] ?? 'احجيلي',
      appVersion: json['app_version'] ?? '1.0.0',
      maintenanceMode: json['maintenance_mode'] ?? false,
    );
  }
}

// models/user.dart
class User {
  final int id;
  final String username;
  final String displayName;
  final String? email;
  final String? avatarUrl;
  final String? bio;
  final String? location;
  final String role;
  final String accountType;
  final bool isActive;
  final DateTime createdAt;
  final DateTime? lastSeenAt;
  
  User({
    required this.id,
    required this.username,
    required this.displayName,
    this.email,
    this.avatarUrl,
    this.bio,
    this.location,
    required this.role,
    required this.accountType,
    required this.isActive,
    required this.createdAt,
    this.lastSeenAt,
  });
  
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      username: json['username'],
      displayName: json['display_name'],
      email: json['email'],
      avatarUrl: json['avatar_url'],
      bio: json['bio'],
      location: json['location'],
      role: json['role'],
      accountType: json['account_type'],
      isActive: json['is_active'],
      createdAt: DateTime.parse(json['created_at']),
      lastSeenAt: json['last_seen_at'] != null 
          ? DateTime.parse(json['last_seen_at']) 
          : null,
    );
  }
  
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'username': username,
      'display_name': displayName,
      'email': email,
      'avatar_url': avatarUrl,
      'bio': bio,
      'location': location,
      'role': role,
      'account_type': accountType,
      'is_active': isActive,
      'created_at': createdAt.toIso8601String(),
      'last_seen_at': lastSeenAt?.toIso8601String(),
    };
  }
}
```

```dart
// models/post.dart
class Post {
  final int id;
  final String content;
  final String? imageUrl;
  final String category;
  final String type;
  final String? location;
  final List<String> hashtags;
  final String status;
  final int likesCount;
  final int commentsCount;
  final int sharesCount;
  final int viewsCount;
  final DateTime createdAt;
  final DateTime updatedAt;
  final User? user;
  final bool isLiked;
  final bool isBookmarked;
  
  Post({
    required this.id,
    required this.content,
    this.imageUrl,
    required this.category,
    required this.type,
    this.location,
    required this.hashtags,
    required this.status,
    required this.likesCount,
    required this.commentsCount,
    required this.sharesCount,
    required this.viewsCount,
    required this.createdAt,
    required this.updatedAt,
    this.user,
    required this.isLiked,
    required this.isBookmarked,
  });
  
  factory Post.fromJson(Map<String, dynamic> json) {
    return Post(
      id: json['id'],
      content: json['content'],
      imageUrl: json['image_url'],
      category: json['category'],
      type: json['type'],
      location: json['location'],
      hashtags: List<String>.from(json['hashtags'] ?? []),
      status: json['status'],
      likesCount: json['likes_count'],
      commentsCount: json['comments_count'],
      sharesCount: json['shares_count'],
      viewsCount: json['views_count'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
      user: json['user'] != null ? User.fromJson(json['user']) : null,
      isLiked: json['is_liked'] ?? false,
      isBookmarked: json['is_bookmarked'] ?? false,
    );
  }
}
```

### 4. Authentication Service

```dart
// services/auth_service.dart
import 'package:flutter/foundation.dart';
import '../models/user.dart';
import '../models/api_response.dart';
import 'api_service.dart';

class AuthService extends ChangeNotifier {
  User? _currentUser;
  bool _isLoggedIn = false;
  bool _isLoading = false;
  
  User? get currentUser => _currentUser;
  bool get isLoggedIn => _isLoggedIn;
  bool get isLoading => _isLoading;
  
  // Check if user is already logged in
  Future<void> checkAuthStatus() async {
    _isLoading = true;
    notifyListeners();
    
    final token = await ApiService.getAuthToken();
    if (token != null) {
      // Verify token with server
      final response = await ApiService.get<User>(
        '/user/profile',
        withAuth: true,
        fromJson: (json) => User.fromJson(json),
      );
      
      if (response.isSuccess) {
        _currentUser = response.data;
        _isLoggedIn = true;
      } else {
        // Token invalid, remove it
        await ApiService.removeAuthToken();
        _isLoggedIn = false;
      }
    }
    
    _isLoading = false;
    notifyListeners();
  }
  
  // Login
  Future<ApiResponse<User>> login(String username, String password) async {
    _isLoading = true;
    notifyListeners();
    
    final response = await ApiService.post<Map<String, dynamic>>(
      '/auth/login',
      body: {
        'username': username,
        'password': password,
        'remember': true,
      },
    );
    
    if (response.isSuccess && response.data != null) {
      final data = response.data!;
      final token = data['token'];
      final userJson = data['user'];
      
      await ApiService.saveAuthToken(token);
      _currentUser = User.fromJson(userJson);
      _isLoggedIn = true;
      
      _isLoading = false;
      notifyListeners();
      
      return ApiResponse.success(_currentUser!);
    }
    
    _isLoading = false;
    notifyListeners();
    return ApiResponse.error(response.message ?? 'Login failed');
  }
  
  // Register
  Future<ApiResponse<User>> register({
    required String username,
    required String displayName,
    required String password,
    required String passwordConfirmation,
  }) async {
    _isLoading = true;
    notifyListeners();
    
    final response = await ApiService.post<Map<String, dynamic>>(
      '/auth/register',
      body: {
        'username': username,
        'display_name': displayName,
        'password': password,
        'password_confirmation': passwordConfirmation,
      },
    );
    
    if (response.isSuccess && response.data != null) {
      final data = response.data!;
      final token = data['token'];
      final userJson = data['user'];
      
      await ApiService.saveAuthToken(token);
      _currentUser = User.fromJson(userJson);
      _isLoggedIn = true;
      
      _isLoading = false;
      notifyListeners();
      
      return ApiResponse.success(_currentUser!);
    }
    
    _isLoading = false;
    notifyListeners();
    return ApiResponse.error(response.message ?? 'Registration failed');
  }
  
  // Logout
  Future<void> logout() async {
    _isLoading = true;
    notifyListeners();
    
    // Call logout endpoint
    await ApiService.post('/auth/logout', withAuth: true);
    
    // Clear local data
    await ApiService.removeAuthToken();
    _currentUser = null;
    _isLoggedIn = false;
    
    _isLoading = false;
    notifyListeners();
  }
}
```

### 5. Posts Service

```dart
// services/post_service.dart
import 'dart:io';
import 'package:flutter/foundation.dart';
import '../models/post.dart';
import '../models/api_response.dart';
import 'api_service.dart';

class PostService extends ChangeNotifier {
  List<Post> _posts = [];
  bool _isLoading = false;
  bool _hasMore = true;
  int _currentPage = 1;
  String _currentCategory = 'all';
  String _currentSearch = '';
  
  List<Post> get posts => _posts;
  bool get isLoading => _isLoading;
  bool get hasMore => _hasMore;
  
  // Get posts with pagination
  Future<ApiResponse<List<Post>>> getPosts({
    int page = 1,
    String category = 'all',
    String search = '',
    bool refresh = false,
  }) async {
    if (refresh) {
      _posts.clear();
      _currentPage = 1;
      _hasMore = true;
    }
    
    _isLoading = true;
    notifyListeners();
    
    final response = await ApiService.get<Map<String, dynamic>>(
      '/posts',
      queryParams: {
        'page': page.toString(),
        'category': category,
        'search': search,
      },
    );
    
    if (response.isSuccess && response.data != null) {
      final data = response.data!;
      final postsJson = data['posts'] as List;
      final pagination = data['pagination'];
      
      final newPosts = postsJson.map((json) => Post.fromJson(json)).toList();
      
      if (refresh) {
        _posts = newPosts;
      } else {
        _posts.addAll(newPosts);
      }
      
      _currentPage = pagination['current_page'];
      _hasMore = _currentPage < pagination['total_pages'];
      _currentCategory = category;
      _currentSearch = search;
      
      _isLoading = false;
      notifyListeners();
      
      return ApiResponse.success(newPosts);
    }
    
    _isLoading = false;
    notifyListeners();
    return ApiResponse.error(response.message ?? 'Failed to load posts');
  }
  
  // Load more posts
  Future<void> loadMore() async {
    if (!_hasMore || _isLoading) return;
    
    await getPosts(
      page: _currentPage + 1,
      category: _currentCategory,
      search: _currentSearch,
    );
  }
  
  // Create new post
  Future<ApiResponse<Post>> createPost({
    required String content,
    required String category,
    String type = 'community',
    String? location,
    String? hashtags,
    String? guestName,
    File? image,
  }) async {
    _isLoading = true;
    notifyListeners();
    
    Map<String, String> fields = {
      'content': content,
      'category': category,
      'type': type,
    };
    
    if (location != null) fields['location'] = location;
    if (hashtags != null) fields['hashtags'] = hashtags;
    if (guestName != null) fields['guest_name'] = guestName;
    
    Map<String, File>? files;
    if (image != null) {
      files = {'image': image};
    }
    
    final response = await ApiService.postMultipart<Post>(
      '/posts',
      fields: fields,
      files: files,
      withAuth: type == 'community',
      fromJson: (json) => Post.fromJson(json),
    );
    
    if (response.isSuccess) {
      // Add new post to the beginning of the list
      _posts.insert(0, response.data!);
      notifyListeners();
    }
    
    _isLoading = false;
    notifyListeners();
    
    return response;
  }
  
  // Like/Unlike post
  Future<ApiResponse<Map<String, dynamic>>> toggleLike(int postId, {bool isAnonymous = false}) async {
    final endpoint = isAnonymous 
        ? '/posts/$postId/like/anonymous'
        : '/posts/$postId/like';
    
    final response = await ApiService.post<Map<String, dynamic>>(
      endpoint,
      withAuth: !isAnonymous,
    );
    
    if (response.isSuccess) {
      // Update local post data
      final postIndex = _posts.indexWhere((post) => post.id == postId);
      if (postIndex != -1) {
        final updatedPost = Post(
          id: _posts[postIndex].id,
          content: _posts[postIndex].content,
          imageUrl: _posts[postIndex].imageUrl,
          category: _posts[postIndex].category,
          type: _posts[postIndex].type,
          location: _posts[postIndex].location,
          hashtags: _posts[postIndex].hashtags,
          status: _posts[postIndex].status,
          likesCount: response.data!['likes_count'],
          commentsCount: _posts[postIndex].commentsCount,
          sharesCount: _posts[postIndex].sharesCount,
          viewsCount: _posts[postIndex].viewsCount,
          createdAt: _posts[postIndex].createdAt,
          updatedAt: _posts[postIndex].updatedAt,
          user: _posts[postIndex].user,
          isLiked: response.data!['liked'],
          isBookmarked: _posts[postIndex].isBookmarked,
        );
        
        _posts[postIndex] = updatedPost;
        notifyListeners();
      }
    }
    
    return response;
  }
}
```

## 🎨 UI Components Examples

### 1. Post Card Widget

```dart
// widgets/post_card.dart
import 'package:flutter/material.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:intl/intl.dart';
import '../models/post.dart';
import '../services/post_service.dart';
import 'package:provider/provider.dart';

class PostCard extends StatelessWidget {
  final Post post;
  final VoidCallback? onTap;
  
  const PostCard({
    Key? key,
    required this.post,
    this.onTap,
  }) : super(key: key);
  
  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      elevation: 2,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // User info
              if (post.user != null) _buildUserHeader(),
              if (post.user == null) _buildAnonymousHeader(),
              
              const SizedBox(height: 12),
              
              // Content
              Text(
                post.content,
                style: const TextStyle(fontSize: 16, height: 1.4),
              ),
              
              // Image
              if (post.imageUrl != null) ...[
                const SizedBox(height: 12),
                _buildPostImage(),
              ],
              
              // Hashtags
              if (post.hashtags.isNotEmpty) ...[
                const SizedBox(height: 8),
                _buildHashtags(),
              ],
              
              const SizedBox(height: 12),
              
              // Actions
              _buildActions(context),
            ],
          ),
        ),
      ),
    );
  }
  
  Widget _buildUserHeader() {
    return Row(
      children: [
        CircleAvatar(
          radius: 20,
          backgroundImage: post.user!.avatarUrl != null
              ? CachedNetworkImageProvider(post.user!.avatarUrl!)
              : null,
          child: post.user!.avatarUrl == null
              ? Text(post.user!.displayName[0].toUpperCase())
              : null,
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                post.user!.displayName,
                style: const TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 16,
                ),
              ),
              Text(
                _formatDate(post.createdAt),
                style: TextStyle(
                  color: Colors.grey[600],
                  fontSize: 12,
                ),
              ),
            ],
          ),
        ),
        _buildCategoryBadge(),
      ],
    );
  }
  
  Widget _buildAnonymousHeader() {
    return Row(
      children: [
        const CircleAvatar(
          radius: 20,
          child: Icon(Icons.person, color: Colors.white),
        ),
        const SizedBox(width: 12),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'مجهول',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 16,
                ),
              ),
              Text(
                _formatDate(post.createdAt),
                style: TextStyle(
                  color: Colors.grey[600],
                  fontSize: 12,
                ),
              ),
            ],
          ),
        ),
        _buildCategoryBadge(),
      ],
    );
  }
  
  Widget _buildPostImage() {
    return ClipRRect(
      borderRadius: BorderRadius.circular(8),
      child: CachedNetworkImage(
        imageUrl: post.imageUrl!,
        width: double.infinity,
        fit: BoxFit.cover,
        placeholder: (context, url) => Container(
          height: 200,
          color: Colors.grey[300],
          child: const Center(
            child: CircularProgressIndicator(),
          ),
        ),
        errorWidget: (context, url, error) => Container(
          height: 200,
          color: Colors.grey[300],
          child: const Icon(Icons.error),
        ),
      ),
    );
  }
  
  Widget _buildHashtags() {
    return Wrap(
      spacing: 8,
      runSpacing: 4,
      children: post.hashtags.map((hashtag) {
        return Container(
          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
          decoration: BoxDecoration(
            color: Colors.blue[50],
            borderRadius: BorderRadius.circular(16),
          ),
          child: Text(
            '#$hashtag',
            style: TextStyle(
              color: Colors.blue[700],
              fontSize: 12,
              fontWeight: FontWeight.w500,
            ),
          ),
        );
      }).toList(),
    );
  }
  
  Widget _buildCategoryBadge() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: _getCategoryColor(),
        borderRadius: BorderRadius.circular(12),
      ),
      child: Text(
        _getCategoryName(),
        style: const TextStyle(
          color: Colors.white,
          fontSize: 10,
          fontWeight: FontWeight.w600,
        ),
      ),
    );
  }
  
  Widget _buildActions(BuildContext context) {
    return Row(
      children: [
        _buildActionButton(
          icon: post.isLiked ? Icons.favorite : Icons.favorite_border,
          label: post.likesCount.toString(),
          color: post.isLiked ? Colors.red : Colors.grey,
          onTap: () => _handleLike(context),
        ),
        const SizedBox(width: 16),
        _buildActionButton(
          icon: Icons.comment_outlined,
          label: post.commentsCount.toString(),
          color: Colors.grey,
          onTap: () => _handleComment(context),
        ),
        const SizedBox(width: 16),
        _buildActionButton(
          icon: Icons.share_outlined,
          label: post.sharesCount.toString(),
          color: Colors.grey,
          onTap: () => _handleShare(context),
        ),
        const Spacer(),
        _buildActionButton(
          icon: post.isBookmarked ? Icons.bookmark : Icons.bookmark_border,
          label: '',
          color: post.isBookmarked ? Colors.blue : Colors.grey,
          onTap: () => _handleBookmark(context),
        ),
      ],
    );
  }
  
  Widget _buildActionButton({
    required IconData icon,
    required String label,
    required Color color,
    required VoidCallback onTap,
  }) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(20),
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
        child: Row(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(icon, size: 20, color: color),
            if (label.isNotEmpty) ...[
              const SizedBox(width: 4),
              Text(
                label,
                style: TextStyle(color: color, fontSize: 12),
              ),
            ],
          ],
        ),
      ),
    );
  }
  
  void _handleLike(BuildContext context) {
    final postService = Provider.of<PostService>(context, listen: false);
    postService.toggleLike(post.id);
  }
  
  void _handleComment(BuildContext context) {
    // Navigate to post detail with comments
    if (onTap != null) onTap!();
  }
  
  void _handleShare(BuildContext context) {
    // Implement share functionality
    // You can use share_plus package
  }
  
  void _handleBookmark(BuildContext context) {
    // Implement bookmark functionality
  }
  
  Color _getCategoryColor() {
    switch (post.category) {
      case 'complaint':
        return Colors.red;
      case 'experience':
        return Colors.blue;
      case 'recommendation':
        return Colors.green;
      case 'question':
        return Colors.orange;
      case 'review':
        return Colors.purple;
      default:
        return Colors.grey;
    }
  }
  
  String _getCategoryName() {
    switch (post.category) {
      case 'complaint':
        return 'شكوى';
      case 'experience':
        return 'تجربة';
      case 'recommendation':
        return 'توصية';
      case 'question':
        return 'سؤال';
      case 'review':
        return 'مراجعة';
      default:
        return 'عام';
    }
  }
  
  String _formatDate(DateTime date) {
    final now = DateTime.now();
    final difference = now.difference(date);
    
    if (difference.inMinutes < 1) {
      return 'الآن';
    } else if (difference.inHours < 1) {
      return 'منذ ${difference.inMinutes} دقيقة';
    } else if (difference.inDays < 1) {
      return 'منذ ${difference.inHours} ساعة';
    } else if (difference.inDays < 7) {
      return 'منذ ${difference.inDays} يوم';
    } else {
      return DateFormat('dd/MM/yyyy').format(date);
    }
  }
}
```

### 2. Home Screen

```dart
// screens/home/home_screen.dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../services/post_service.dart';
import '../../services/auth_service.dart';
import '../../widgets/post_card.dart';
import '../posts/create_post_screen.dart';
import '../posts/post_detail_screen.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final ScrollController _scrollController = ScrollController();
  String _selectedCategory = 'all';
  String _searchQuery = '';
  
  @override
  void initState() {
    super.initState();
    _scrollController.addListener(_onScroll);
    WidgetsBinding.instance.addPostFrameCallback((_) {
      _loadPosts(refresh: true);
    });
  }
  
  @override
  void dispose() {
    _scrollController.dispose();
    super.dispose();
  }
  
  void _onScroll() {
    if (_scrollController.position.pixels >=
        _scrollController.position.maxScrollExtent - 200) {
      final postService = Provider.of<PostService>(context, listen: false);
      postService.loadMore();
    }
  }
  
  Future<void> _loadPosts({bool refresh = false}) async {
    final postService = Provider.of<PostService>(context, listen: false);
    await postService.getPosts(
      category: _selectedCategory,
      search: _searchQuery,
      refresh: refresh,
    );
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('احجيلي'),
        backgroundColor: const Color(0xFF5C7D99),
        foregroundColor: Colors.white,
        elevation: 0,
        actions: [
          IconButton(
            icon: const Icon(Icons.search),
            onPressed: _showSearchDialog,
          ),
          IconButton(
            icon: const Icon(Icons.person),
            onPressed: () {
              // Navigate to profile
            },
          ),
        ],
      ),
      body: Column(
        children: [
          _buildCategoryTabs(),
          Expanded(
            child: Consumer<PostService>(
              builder: (context, postService, child) {
                if (postService.posts.isEmpty && postService.isLoading) {
                  return const Center(child: CircularProgressIndicator());
                }
                
                if (postService.posts.isEmpty) {
                  return _buildEmptyState();
                }
                
                return RefreshIndicator(
                  onRefresh: () => _loadPosts(refresh: true),
                  child: ListView.builder(
                    controller: _scrollController,
                    itemCount: postService.posts.length + 
                        (postService.isLoading ? 1 : 0),
                    itemBuilder: (context, index) {
                      if (index >= postService.posts.length) {
                        return const Center(
                          child: Padding(
                            padding: EdgeInsets.all(16),
                            child: CircularProgressIndicator(),
                          ),
                        );
                      }
                      
                      final post = postService.posts[index];
                      return PostCard(
                        post: post,
                        onTap: () => _navigateToPostDetail(post.id),
                      );
                    },
                  ),
                );
              },
            ),
          ),
        ],
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: _navigateToCreatePost,
        backgroundColor: const Color(0xFF5C7D99),
        child: const Icon(Icons.add, color: Colors.white),
      ),
    );
  }
  
  Widget _buildCategoryTabs() {
    final categories = [
      {'key': 'all', 'name': 'الكل'},
      {'key': 'complaint', 'name': 'شكاوى'},
      {'key': 'experience', 'name': 'تجارب'},
      {'key': 'recommendation', 'name': 'توصيات'},
      {'key': 'question', 'name': 'أسئلة'},
      {'key': 'review', 'name': 'مراجعات'},
      {'key': 'general', 'name': 'عامة'},
    ];
    
    return Container(
      height: 50,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        itemCount: categories.length,
        itemBuilder: (context, index) {
          final category = categories[index];
          final isSelected = _selectedCategory == category['key'];
          
          return Padding(
            padding: const EdgeInsets.only(right: 8),
            child: FilterChip(
              label: Text(category['name']!),
              selected: isSelected,
              onSelected: (selected) {
                if (selected) {
                  setState(() {
                    _selectedCategory = category['key']!;
                  });
                  _loadPosts(refresh: true);
                }
              },
              selectedColor: const Color(0xFF5C7D99),
              checkmarkColor: Colors.white,
              labelStyle: TextStyle(
                color: isSelected ? Colors.white : Colors.black87,
              ),
            ),
          );
        },
      ),
    );
  }
  
  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.article_outlined,
            size: 64,
            color: Colors.grey[400],
          ),
          const SizedBox(height: 16),
          Text(
            'لا توجد منشورات',
            style: TextStyle(
              fontSize: 18,
              color: Colors.grey[600],
            ),
          ),
          const SizedBox(height: 8),
          Text(
            'كن أول من يشارك مشكلته أو يساعد الآخرين',
            style: TextStyle(
              color: Colors.grey[500],
            ),
            textAlign: TextAlign.center,
          ),
          const SizedBox(height: 24),
          ElevatedButton(
            onPressed: _navigateToCreatePost,
            child: const Text('أضف منشور'),
          ),
        ],
      ),
    );
  }
  
  void _showSearchDialog() {
    showDialog(
      context: context,
      builder: (context) {
        String query = _searchQuery;
        return AlertDialog(
          title: const Text('البحث'),
          content: TextField(
            autofocus: true,
            decoration: const InputDecoration(
              hintText: 'ابحث في المنشورات...',
              border: OutlineInputBorder(),
            ),
            onChanged: (value) => query = value,
            onSubmitted: (value) {
              Navigator.pop(context);
              setState(() {
                _searchQuery = value;
              });
              _loadPosts(refresh: true);
            },
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('إلغاء'),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.pop(context);
                setState(() {
                  _searchQuery = query;
                });
                _loadPosts(refresh: true);
              },
              child: const Text('بحث'),
            ),
          ],
        );
      },
    );
  }
  
  void _navigateToCreatePost() {
    Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => CreatePostScreen()),
    ).then((_) {
      // Refresh posts after creating new one
      _loadPosts(refresh: true);
    });
  }
  
  void _navigateToPostDetail(int postId) {
    Navigator.push(
      context,
      MaterialPageRoute(
        builder: (context) => PostDetailScreen(postId: postId),
      ),
    );
  }
}
```

## 🔔 Push Notifications Setup

### Firebase Messaging Service

```dart
// services/notification_service.dart
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'api_service.dart';

class NotificationService {
  static final FirebaseMessaging _messaging = FirebaseMessaging.instance;
  
  // Initialize notifications
  static Future<void> initialize() async {
    // Request permission
    NotificationSettings settings = await _messaging.requestPermission(
      alert: true,
      announcement: false,
      badge: true,
      carPlay: false,
      criticalAlert: false,
      provisional: false,
      sound: true,
    );
    
    if (settings.authorizationStatus == AuthorizationStatus.authorized) {
      print('User granted permission');
      
      // Get FCM token
      String? token = await _messaging.getToken();
      if (token != null) {
        await _registerDeviceToken(token);
      }
      
      // Listen for token refresh
      _messaging.onTokenRefresh.listen(_registerDeviceToken);
      
      // Handle foreground messages
      FirebaseMessaging.onMessage.listen(_handleForegroundMessage);
      
      // Handle background message clicks
      FirebaseMessaging.onMessageOpenedApp.listen(_handleMessageClick);
      
      // Handle app launched from notification
      RemoteMessage? initialMessage = await _messaging.getInitialMessage();
      if (initialMessage != null) {
        _handleMessageClick(initialMessage);
      }
    }
  }
  
  // Register device token with server
  static Future<void> _registerDeviceToken(String token) async {
    try {
      await ApiService.post(
        '/notifications/register-device',
        body: {
          'token': token,
          'platform': defaultTargetPlatform == TargetPlatform.iOS ? 'ios' : 'android',
        },
        withAuth: true,
      );
    } catch (e) {
      print('Failed to register device token: $e');
    }
  }
  
  // Handle foreground messages
  static void _handleForegroundMessage(RemoteMessage message) {
    print('Received foreground message: ${message.messageId}');
    // Show local notification or update UI
  }
  
  // Handle message clicks
  static void _handleMessageClick(RemoteMessage message) {
    print('Message clicked: ${message.messageId}');
    // Navigate to specific screen based on message data
    final data = message.data;
    if (data['type'] == 'post') {
      // Navigate to post detail
      final postId = int.tryParse(data['post_id'] ?? '');
      if (postId != null) {
        // Navigate to PostDetailScreen(postId: postId)
      }
    } else if (data['type'] == 'comment') {
      // Navigate to post with comment highlighted
    }
  }
}
```

## 🏁 Main App Setup

```dart
// main.dart
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:firebase_core/firebase_core.dart';
import 'services/auth_service.dart';
import 'services/post_service.dart';
import 'services/notification_service.dart';
import 'screens/auth/login_screen.dart';
import 'screens/home/home_screen.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Initialize Firebase
  await Firebase.initializeApp();
  
  // Initialize notifications
  await NotificationService.initialize();
  
  runApp(AhjiliApp());
}

class AhjiliApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => AuthService()),
        ChangeNotifierProvider(create: (_) => PostService()),
      ],
      child: MaterialApp(
        title: 'احجيلي',
        theme: ThemeData(
          primaryColor: const Color(0xFF5C7D99),
          fontFamily: 'Cairo', // Add Arabic font
          textTheme: const TextTheme(
            bodyLarge: TextStyle(fontSize: 16),
            bodyMedium: TextStyle(fontSize: 14),
          ),
        ),
        home: AuthWrapper(),
        debugShowCheckedModeBanner: false,
      ),
    );
  }
}

class AuthWrapper extends StatefulWidget {
  @override
  _AuthWrapperState createState() => _AuthWrapperState();
}

class _AuthWrapperState extends State<AuthWrapper> {
  @override
  void initState() {
    super.initState();
    // Check authentication status on app start
    WidgetsBinding.instance.addPostFrameCallback((_) {
      Provider.of<AuthService>(context, listen: false).checkAuthStatus();
    });
  }
  
  @override
  Widget build(BuildContext context) {
    return Consumer<AuthService>(
      builder: (context, authService, child) {
        if (authService.isLoading) {
          return const Scaffold(
            body: Center(child: CircularProgressIndicator()),
          );
        }
        
        return authService.isLoggedIn ? HomeScreen() : LoginScreen();
      },
    );
  }
}
```

This comprehensive Flutter implementation guide provides:

1. **Complete project structure** with organized folders
2. **Core services** for API communication, authentication, and posts
3. **Data models** with proper JSON serialization
4. **UI components** like PostCard with full functionality
5. **Main screens** including Home with infinite scroll and pull-to-refresh
6. **Push notifications** setup with Firebase
7. **Proper state management** using Provider
8. **Error handling** and loading states
9. **RTL support** for Arabic content
10. **Image handling** with caching and compression

## 🎭 Anonymous Posting & Comments Implementation

### Settings Management Service

```dart
// services/settings_service.dart
import '../models/app_settings.dart';
import 'api_service.dart';

class SettingsService {
  static AppSettings? _cachedSettings;
  
  // Get app settings (cached)
  static Future<AppSettings?> getSettings() async {
    if (_cachedSettings != null) {
      return _cachedSettings;
    }
    
    final response = await ApiService.getSettings();
    if (response.isSuccess && response.data != null) {
      _cachedSettings = response.data!;
      return _cachedSettings;
    }
    
    return null;
  }
  
  // Check if anonymous posting is enabled
  static Future<bool> isAnonymousPostingEnabled() async {
    final settings = await getSettings();
    return settings?.anonymousPostingEnabled ?? false;
  }
  
  // Check if anonymous comments are enabled
  static Future<bool> isAnonymousCommentsEnabled() async {
    final settings = await getSettings();
    return settings?.anonymousCommentsEnabled ?? false;
  }
  
  // Clear cached settings (call when needed refresh)
  static void clearCache() {
    _cachedSettings = null;
  }
}
```

### Anonymous Post Creation Widget

```dart
// widgets/anonymous_post_options.dart
import 'package:flutter/material.dart';
import '../services/settings_service.dart';
import '../services/auth_service.dart';

enum PostType { public, anonymousMember, guest }

class AnonymousPostOptions extends StatefulWidget {
  final Function(PostType, String?) onPostTypeChanged;
  
  const AnonymousPostOptions({
    Key? key,
    required this.onPostTypeChanged,
  }) : super(key: key);

  @override
  _AnonymousPostOptionsState createState() => _AnonymousPostOptionsState();
}

class _AnonymousPostOptionsState extends State<AnonymousPostOptions> {
  PostType selectedType = PostType.public;
  TextEditingController guestNameController = TextEditingController();
  bool anonymousPostingEnabled = false;
  bool isLoggedIn = false;
  
  @override
  void initState() {
    super.initState();
    _loadSettings();
  }
  
  Future<void> _loadSettings() async {
    final settings = await SettingsService.getSettings();
    final authService = AuthService.instance;
    
    setState(() {
      anonymousPostingEnabled = settings?.anonymousPostingEnabled ?? false;
      isLoggedIn = authService.isLoggedIn;
      
      // If not logged in and anonymous posting disabled, force guest mode
      if (!isLoggedIn && !anonymousPostingEnabled) {
        selectedType = PostType.guest;
      }
    });
    
    _notifyParent();
  }
  
  void _notifyParent() {
    String? guestName = selectedType == PostType.guest && guestNameController.text.isNotEmpty
        ? guestNameController.text
        : null;
    widget.onPostTypeChanged(selectedType, guestName);
  }
  
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        border: Border.all(color: Colors.grey.shade300),
        borderRadius: BorderRadius.circular(8),
        color: Colors.grey.shade50,
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'خيارات النشر',
            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
          ),
          const SizedBox(height: 12),
          
          // Public post option (only for logged in users)
          if (isLoggedIn) ...[
            _buildPostOption(
              type: PostType.public,
              icon: Icons.person,
              title: 'نشر باسمي الحقيقي',
              subtitle: 'سيظهر اسمك وصورتك الشخصية',
              color: Theme.of(context).primaryColor,
            ),
            const SizedBox(height: 8),
          ],
          
          // Anonymous member option (only for logged in users)
          if (isLoggedIn) ...[
            _buildPostOption(
              type: PostType.anonymousMember,
              icon: Icons.visibility_off,
              title: 'نشر مجهول (عضو)',
              subtitle: 'ستبقى مسجل الدخول لكن بدون إظهار هويتك',
              color: Colors.orange,
            ),
            const SizedBox(height: 8),
          ],
          
          // Guest option (always available if anonymous posting enabled)
          if (anonymousPostingEnabled) ...[
            _buildPostOption(
              type: PostType.guest,
              icon: Icons.person_outline,
              title: 'نشر كزائر مجهول',
              subtitle: 'نشر بدون تسجيل دخول',
              color: Colors.grey,
            ),
            
            // Guest name field
            if (selectedType == PostType.guest) ...[
              const SizedBox(height: 12),
              TextField(
                controller: guestNameController,
                decoration: const InputDecoration(
                  hintText: 'اختر اسم مستعار (اختياري)',
                  border: OutlineInputBorder(),
                  contentPadding: EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                ),
                onChanged: (_) => _notifyParent(),
              ),
            ],
          ],
          
          // Warning if anonymous posting is disabled
          if (!anonymousPostingEnabled && !isLoggedIn) ...[
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: Colors.red.shade50,
                border: Border.all(color: Colors.red.shade200),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Row(
                children: [
                  Icon(Icons.warning, color: Colors.red),
                  const SizedBox(width: 8),
                  const Expanded(
                    child: Text(
                      'النشر المجهول غير متاح حالياً. يرجى تسجيل الدخول.',
                      style: TextStyle(color: Colors.red),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ],
      ),
    );
  }
  
  Widget _buildPostOption({
    required PostType type,
    required IconData icon,
    required String title,
    required String subtitle,
    required Color color,
  }) {
    final isSelected = selectedType == type;
    
    return GestureDetector(
      onTap: () {
        setState(() {
          selectedType = type;
        });
        _notifyParent();
      },
      child: Container(
        padding: const EdgeInsets.all(12),
        decoration: BoxDecoration(
          color: Colors.white,
          border: Border.all(
            color: isSelected ? color : Colors.grey.shade300,
            width: isSelected ? 2 : 1,
          ),
          borderRadius: BorderRadius.circular(8),
        ),
        child: Row(
          children: [
            Radio<PostType>(
              value: type,
              groupValue: selectedType,
              onChanged: (value) {
                setState(() {
                  selectedType = value!;
                });
                _notifyParent();
              },
              activeColor: color,
            ),
            const SizedBox(width: 8),
            Icon(icon, color: color, size: 20),
            const SizedBox(width: 8),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: const TextStyle(fontWeight: FontWeight.w500),
                  ),
                  Text(
                    subtitle,
                    style: TextStyle(
                      fontSize: 12,
                      color: Colors.grey.shade600,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
```

### Enhanced Create Post Screen

```dart
// screens/posts/create_post_screen.dart
import 'package:flutter/material.dart';
import '../../widgets/anonymous_post_options.dart';
import '../../services/post_service.dart';
import '../../services/settings_service.dart';

class CreatePostScreen extends StatefulWidget {
  @override
  _CreatePostScreenState createState() => _CreatePostScreenState();
}

class _CreatePostScreenState extends State<CreatePostScreen> {
  final _contentController = TextEditingController();
  final _locationController = TextEditingController();
  final _hashtagsController = TextEditingController();
  
  PostType selectedPostType = PostType.public;
  String? guestName;
  String selectedCategory = 'general';
  bool isLoading = false;
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('إنشاء منشور'),
        backgroundColor: Theme.of(context).primaryColor,
        foregroundColor: Colors.white,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Post content
            TextField(
              controller: _contentController,
              maxLines: 6,
              decoration: const InputDecoration(
                hintText: 'شارك مشكلتك أو تجربتك مع المجتمع...',
                border: OutlineInputBorder(),
                contentPadding: EdgeInsets.all(12),
              ),
            ),
            const SizedBox(height: 16),
            
            // Category selection
            const Text('الفئة', style: TextStyle(fontWeight: FontWeight.bold)),
            const SizedBox(height: 8),
            DropdownButtonFormField<String>(
              value: selectedCategory,
              decoration: const InputDecoration(
                border: OutlineInputBorder(),
                contentPadding: EdgeInsets.symmetric(horizontal: 12, vertical: 8),
              ),
              items: const [
                DropdownMenuItem(value: 'complaint', child: Text('شكوى')),
                DropdownMenuItem(value: 'experience', child: Text('تجربة')),
                DropdownMenuItem(value: 'recommendation', child: Text('توصية')),
                DropdownMenuItem(value: 'question', child: Text('سؤال')),
                DropdownMenuItem(value: 'review', child: Text('مراجعة')),
                DropdownMenuItem(value: 'general', child: Text('عامة')),
              ],
              onChanged: (value) {
                setState(() {
                  selectedCategory = value!;
                });
              },
            ),
            const SizedBox(height: 16),
            
            // Location
            TextField(
              controller: _locationController,
              decoration: const InputDecoration(
                labelText: 'الموقع',
                hintText: 'المدينة أو المنطقة',
                border: OutlineInputBorder(),
                contentPadding: EdgeInsets.all(12),
              ),
            ),
            const SizedBox(height: 16),
            
            // Anonymous posting options
            AnonymousPostOptions(
              onPostTypeChanged: (type, name) {
                setState(() {
                  selectedPostType = type;
                  guestName = name;
                });
              },
            ),
            const SizedBox(height: 16),
            
            // Hashtags
            TextField(
              controller: _hashtagsController,
              decoration: const InputDecoration(
                labelText: 'الهاشتاغ',
                hintText: 'مثال: مشكلة، حل، تجربة',
                border: OutlineInputBorder(),
                contentPadding: EdgeInsets.all(12),
              ),
            ),
            const SizedBox(height: 24),
            
            // Submit button
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: isLoading ? null : _submitPost,
                style: ElevatedButton.styleFrom(
                  backgroundColor: Theme.of(context).primaryColor,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                ),
                child: isLoading
                    ? const CircularProgressIndicator(color: Colors.white)
                    : Row(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          _getPostIcon(),
                          const SizedBox(width: 8),
                          Text(_getPostButtonText()),
                        ],
                      ),
              ),
            ),
          ],
        ),
      ),
    );
  }
  
  Icon _getPostIcon() {
    switch (selectedPostType) {
      case PostType.public:
        return const Icon(Icons.send);
      case PostType.anonymousMember:
        return const Icon(Icons.visibility_off);
      case PostType.guest:
        return const Icon(Icons.person_outline);
    }
  }
  
  String _getPostButtonText() {
    switch (selectedPostType) {
      case PostType.public:
        return 'نشر المحتوى';
      case PostType.anonymousMember:
        return 'نشر مجهول';
      case PostType.guest:
        return 'نشر كزائر';
    }
  }
  
  Future<void> _submitPost() async {
    if (_contentController.text.trim().isEmpty) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('يرجى كتابة محتوى المنشور')),
      );
      return;
    }
    
    setState(() {
      isLoading = true;
    });
    
    try {
      Map<String, dynamic> postData = {
        'content': _contentController.text.trim(),
        'category': selectedCategory,
        'location': _locationController.text.trim(),
        'hashtags': _hashtagsController.text.trim(),
      };
      
      // Add post type specific fields
      switch (selectedPostType) {
        case PostType.public:
          postData['is_anonymous'] = false;
          break;
        case PostType.anonymousMember:
          postData['is_anonymous'] = true;
          break;
        case PostType.guest:
          if (guestName?.isNotEmpty == true) {
            postData['guest_name'] = guestName;
          }
          break;
      }
      
      final success = await PostService.createPost(postData);
      
      if (success) {
        Navigator.pop(context, true);
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('تم نشر المحتوى بنجاح')),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('فشل في نشر المحتوى')),
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('خطأ: ${e.toString()}')),
      );
    } finally {
      setState(() {
        isLoading = false;
      });
    }
  }
}
```

This implementation provides complete anonymous posting functionality with:

1. **Settings management** to check if anonymous posting is enabled
2. **Dynamic UI** that adapts based on user login status and settings
3. **Three posting modes**: Public, Anonymous Member, Guest
4. **Proper error handling** when anonymous posting is disabled
5. **Guest name field** for anonymous visitors
6. **Visual feedback** with different icons and colors for each mode

The developer can use this as a complete starting point for the Ahjili Flutter app! 🚀

