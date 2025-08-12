<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Str::limit($post->content, 60) }} - احجيلي</title>
    
    <!-- Bootstrap CSS RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts for Arabic -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            direction: rtl;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #5C7D99 !important;
        }
        
        .post-detail-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin: 2rem 0;
            overflow: hidden;
        }
        
        .post-header {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            color: white;
            padding: 1.5rem;
        }
        
        .post-body {
            padding: 2rem;
        }
        
        .post-type-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .anonymous-badge {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .community-badge {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #2d3748;
            margin-bottom: 2rem;
        }
        
        .post-image {
            max-width: 100%;
            border-radius: 10px;
            margin: 1rem 0 2rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .post-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            padding: 1rem 0;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        /* Hashtags Styling */
        .hashtags-section {
            border: 1px solid #dee2e6;
        }
        
        .hashtag-badge {
            background: #e8f4f8;
            color: #5C7D99;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 400;
            border: 1px solid #d1e7dd;
            display: inline-block;
            margin: 0.1rem;
        }
        
        .post-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 1.5rem 0;
            border-top: 1px solid #e9ecef;
        }
        
        .btn-action {
            border-radius: 20px;
            padding: 0.5rem 1rem;
            border: 2px solid #e9ecef;
            background: white;
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-action:hover {
            border-color: #5C7D99;
            color: #5C7D99;
            transform: translateY(-2px);
        }
        
        .btn-action.liked {
            border-color: #28a745;
            color: #28a745;
            background: #f8fff9;
        }
        
        .comments-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin: 2rem 0;
        }
        
        .comments-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }
        
        .comment-form {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .comment-item {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .comment-item:last-child {
            border-bottom: none;
        }
        
        .comment-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .comment-meta {
            flex-grow: 1;
        }
        
        .comment-author {
            font-weight: 600;
            color: #2d3748;
        }
        
        .comment-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .comment-content {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }
        
        .comment-actions {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
        }
        
        .comment-action {
            color: #6c757d;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.3s ease;
        }
        
        .comment-action:hover {
            color: #5C7D99;
        }
        
        .reply-form {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            display: none;
        }
        
        .reply-item {
            margin-right: 3rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            margin-top: 1rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }
        
        .form-control:focus {
            border-color: #5C7D99;
            box-shadow: 0 0 0 0.2rem rgba(92, 125, 153, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .hashtags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .hashtag {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
            text-decoration: none;
        }
        
        .hashtag:hover {
            background: #1976d2;
            color: white;
        }
        

    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">احجيلي</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.create') }}">أضف مشكلة</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->display_name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">لوحتي</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">انضم إلينا</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Back Button -->
        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-right"></i>
                العودة للرئيسية
            </a>
        </div>

        <!-- Post Detail -->
        <div class="post-detail-card">
            <div class="post-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        @if($post->type === 'anonymous')
                            <span class="post-type-badge anonymous-badge">
                                <i class="bi bi-incognito"></i> مجهول
                            </span>
                        @else
                            <span class="post-type-badge community-badge">
                                <i class="bi bi-person"></i> {{ $post->user->display_name ?? 'مستخدم' }}
                            </span>
                        @endif
                    </div>
                    <div class="text-end">
                        @if($post->location)
                            @php
                                $locations = [
                                    'baghdad' => 'بغداد', 'basra' => 'البصرة', 'erbil' => 'أربيل', 'mosul' => 'الموصل',
                                    'najaf' => 'النجف', 'karbala' => 'كربلاء', 'sulaymaniyah' => 'السليمانية',
                                    'kirkuk' => 'كركوك', 'diyala' => 'ديالى', 'anbar' => 'الأنبار',
                                    'dhi_qar' => 'ذي قار', 'babylon' => 'بابل', 'wasit' => 'واسط',
                                    'saladin' => 'صلاح الدين', 'qadisiyyah' => 'القادسية',
                                    'maysan' => 'ميسان', 'muthanna' => 'المثنى', 'dohuk' => 'دهوك'
                                ];
                            @endphp
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-geo-alt"></i> {{ $locations[$post->location] ?? $post->location }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="post-body">
                <div class="post-content">
                    {{ $post->content }}
                </div>
                
                @if($post->image_url)
                    <img src="{{ asset('storage/' . $post->image_url) }}" 
                         alt="صورة المنشور" 
                         class="post-image">
                @endif
                
                @if($post->hashtags)
                    <div class="hashtags">
                        @foreach(explode(',', $post->hashtags) as $hashtag)
                            <a href="{{ route('home', ['search' => trim($hashtag)]) }}" class="hashtag">
                                #{{ trim($hashtag) }}
                            </a>
                        @endforeach
                    </div>
                @endif
                
                <div class="post-meta">
                    <div class="meta-item">
                        <i class="bi bi-clock"></i>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-eye"></i>
                        <span>{{ $post->views_count }} مشاهدة</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-chat"></i>
                        <span>{{ $post->comments_count }} تعليق</span>
                    </div>
                    @if($post->likes_count > 0)
                        <div class="meta-item">
                            <i class="bi bi-hand-thumbs-up text-success"></i>
                            <span>{{ $post->likes_count }} إعجاب</span>
                        </div>
                    @endif
                </div>
                
                <!-- Hashtags Display -->
                @if($post->hashtags && trim($post->hashtags) !== '')
                <div class="mt-2">
                    @php
                        $hashtags = array_filter(array_map('trim', explode(',', $post->hashtags)));
                    @endphp
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($hashtags as $hashtag)
                            <span class="hashtag-badge">
                                #{{ ltrim($hashtag, '#') }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="post-actions">
                    @auth
                        <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-action {{ $post->interactions->where('user_id', Auth::id())->where('type', 'like')->first() ? 'liked' : '' }}">
                                <i class="bi bi-hand-thumbs-up"></i>
                                إعجاب {{ $post->likes_count > 0 ? '(' . $post->likes_count . ')' : '' }}
                            </button>
                        </form>
                        
                        <button type="button" 
                                class="btn-action" 
                                onclick="copyPostLink('{{ route('posts.show', $post) }}')"
                                title="نسخ رابط المنشور">
                            <i class="bi bi-share"></i>
                            مشاركة
                        </button>
                        
                        <form action="{{ route('posts.save', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-action">
                                <i class="bi bi-bookmark"></i>
                                حفظ
                            </button>
                        </form>
                        
                        <button type="button" class="btn-action text-danger" data-bs-toggle="modal" data-bs-target="#reportModal">
                            <i class="bi bi-flag"></i>
                            إبلاغ
                        </button>
                    @else
                        <form action="{{ route('posts.like.anonymous', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-action">
                                <i class="bi bi-hand-thumbs-up"></i>
                                إعجاب {{ $post->likes_count > 0 ? '(' . $post->likes_count . ')' : '' }}
                            </button>
                        </form>
                        
                        <button type="button" 
                                class="btn-action" 
                                onclick="copyPostLink('{{ route('posts.show', $post) }}')"
                                title="نسخ رابط المنشور">
                            <i class="bi bi-share"></i>
                            مشاركة
                        </button>
                        
                        <button type="button" class="btn-action" onclick="document.getElementById('anonymous-tab').click()">
                            <i class="bi bi-chat"></i>
                            تعليق
                        </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <div class="comments-header">
                <h5><i class="bi bi-chat-dots"></i> التعليقات ({{ $post->comments_count }})</h5>
            </div>
            
            <!-- Add Comment Form -->
            <div class="comment-form">
                @auth
                    <!-- Authenticated User Comment Form -->
                    <div class="user-comment-form">
                        <div class="d-flex align-items-center mb-3">
                            <div class="user-avatar me-2">
                                {{ Str::upper(Str::substr(Auth::user()->display_name ?? 'م', 0, 1)) }}
                            </div>
                            <strong>{{ Auth::user()->display_name }}</strong>
                        </div>
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" 
                                          name="content" 
                                          rows="3" 
                                          placeholder="أضف تعليقك..." 
                                          required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i>
                                إضافة تعليق
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Anonymous and Login Options -->
                    <div class="comment-options">
                        <ul class="nav nav-tabs" id="commentTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="anonymous-tab" data-bs-toggle="tab" data-bs-target="#anonymous-comment" type="button" role="tab">
                                    <i class="bi bi-person"></i> تعليق مجهول
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-comment" type="button" role="tab">
                                    <i class="bi bi-box-arrow-in-right"></i> تسجيل الدخول
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-3" id="commentTabContent">
                            <!-- Anonymous Comment Tab -->
                            <div class="tab-pane fade show active" id="anonymous-comment" role="tabpanel">
                                <form action="{{ route('comments.store.anonymous', $post) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">اسمك (اختياري)</label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="anonymous_name" 
                                               placeholder="اكتب اسمك أو اتركه فارغاً للبقاء مجهولاً تماماً" 
                                               value="{{ old('anonymous_name') }}"
                                               maxlength="50">
                                        <div class="form-text">
                                            <i class="bi bi-info-circle"></i>
                                            هذا الحقل اختياري - يمكنك تركه فارغاً للبقاء مجهولاً
                                        </div>
                                        @error('anonymous_name')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">تعليقك</label>
                                        <textarea class="form-control" 
                                                  name="content" 
                                                  rows="3" 
                                                  placeholder="اكتب تعليقك هنا..." 
                                                  required>{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="alert alert-info small">
                                        <i class="bi bi-info-circle"></i>
                                        سيتم مراجعة التعليق قبل نشره. التعليقات المجهولة محدودة بـ 5 تعليقات كل ساعة لمنع spam.
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i>
                                        إرسال التعليق
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Login Tab -->
                            <div class="tab-pane fade" id="login-comment" role="tabpanel">
                                <div class="text-center">
                                    <p class="mb-3">سجل الدخول للحصول على مزايا إضافية:</p>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="bi bi-check text-success"></i> تعليقات فورية بدون مراجعة</li>
                                        <li><i class="bi bi-check text-success"></i> إمكانية تعديل وحذف التعليقات</li>
                                        <li><i class="bi bi-check text-success"></i> الرد على التعليقات</li>
                                        <li><i class="bi bi-check text-success"></i> عدد أكبر من التعليقات المسموحة</li>
                                    </ul>
                                    <a href="{{ route('login') }}" class="btn btn-primary me-2">تسجيل الدخول</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">إنشاء حساب</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
            
            <!-- Comments List -->
            @forelse($post->comments->where('parent_id', null)->where('status', 'approved') as $comment)
                <div class="comment-item">
                    <div class="comment-header">
                        <div class="comment-avatar {{ $comment->is_anonymous ? 'anonymous' : '' }}">
                            @if($comment->is_anonymous)
                                <i class="bi bi-person"></i>
                            @else
                                {{ Str::upper(Str::substr($comment->user->display_name ?? 'م', 0, 1)) }}
                            @endif
                        </div>
                        <div class="comment-meta">
                            <div class="comment-author">
                                {{ $comment->author_name }}
                                @if($comment->is_anonymous)
                                    <span class="badge bg-secondary ms-2">مجهول</span>
                                @endif
                            </div>
                            <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="comment-content">
                        {{ $comment->content }}
                    </div>
                    
                    <div class="comment-actions">
                        @auth
                            <form action="{{ route('comments.like', $comment) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="comment-action">
                                    <i class="bi bi-hand-thumbs-up"></i>
                                    {{ $comment->likes_count > 0 ? $comment->likes_count : '' }}
                                </button>
                            </form>
                            
                            <a href="#" class="comment-action" onclick="toggleReplyForm({{ $comment->id }})">
                                <i class="bi bi-reply"></i>
                                رد
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="comment-action">
                                <i class="bi bi-hand-thumbs-up"></i>
                                إعجاب
                            </a>
                        @endauth
                    </div>
                    
                    <!-- Reply Form -->
                    @auth
                        <div id="replyForm{{ $comment->id }}" class="reply-form">
                            <form action="{{ route('comments.reply', $comment) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" 
                                              name="content" 
                                              rows="2" 
                                              placeholder="اكتب ردك..." 
                                              required></textarea>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm">إرسال</button>
                                    <button type="button" class="btn btn-secondary btn-sm" onclick="toggleReplyForm({{ $comment->id }})">إلغاء</button>
                                </div>
                            </form>
                        </div>
                    @endauth
                    
                    <!-- Replies -->
                    @foreach($comment->replies as $reply)
                        <div class="reply-item">
                            <div class="comment-header">
                                <div class="comment-avatar">
                                    {{ Str::upper(Str::substr($reply->user->display_name ?? 'م', 0, 1)) }}
                                </div>
                                <div class="comment-meta">
                                    <div class="comment-author">{{ $reply->user->display_name ?? 'مستخدم' }}</div>
                                    <div class="comment-date">{{ $reply->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            
                            <div class="comment-content">
                                {{ $reply->content }}
                            </div>
                            
                            <div class="comment-actions">
                                @auth
                                    <form action="{{ route('comments.like', $reply) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="comment-action">
                                            <i class="bi bi-hand-thumbs-up"></i>
                                            {{ $reply->likes_count > 0 ? $reply->likes_count : '' }}
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="comment-action">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                        إعجاب
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-chat-dots" style="font-size: 3rem; opacity: 0.5;"></i>
                    <p class="mt-3">لا توجد تعليقات بعد</p>
                    <p>كن أول من يعلق على هذا المنشور</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Report Modal -->
    @auth
        <div class="modal fade" id="reportModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إبلاغ عن المنشور</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('posts.report', $post) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">سبب الإبلاغ</label>
                                <textarea name="reason" class="form-control" rows="3" required 
                                          placeholder="اذكر سبب الإبلاغ عن هذا المنشور..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-danger">إرسال الإبلاغ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('replyForm' + commentId);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                form.querySelector('textarea').focus();
            } else {
                form.style.display = 'none';
            }
        }
        
        function copyPostLink(url) {
            // Create a temporary text area element
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            
            // Select and copy the text
            textArea.select();
            document.execCommand('copy');
            
            // Remove the temporary element
            document.body.removeChild(textArea);
            
            // Show success message
            showToast('تم نسخ رابط المنشور بنجاح!', 'success');
        }
        
        function showToast(message, type = 'info') {
            // Create toast element
            const toastHtml = `
                <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'primary'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-check-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1055';
                document.body.appendChild(toastContainer);
            }
            
            // Add toast to container
            const toastElement = document.createElement('div');
            toastElement.innerHTML = toastHtml;
            toastContainer.appendChild(toastElement.firstElementChild);
            
            // Initialize and show toast
            const toast = new bootstrap.Toast(toastContainer.lastElementChild, {
                autohide: true,
                delay: 3000
            });
            toast.show();
            
            // Remove toast element after it's hidden
            toastContainer.lastElementChild.addEventListener('hidden.bs.toast', function() {
                this.remove();
            });
        }
    </script>
</body>
</html>

