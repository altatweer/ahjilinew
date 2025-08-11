<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحتي - احجيلي</title>
    
    <!-- Bootstrap CSS -->
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
        
        .main-header {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin: 0 auto 1rem auto;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem auto;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .posts-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin: 2rem 0;
        }
        
        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }
        
        .nav-tabs .nav-link {
            border-radius: 10px 10px 0 0;
            border: none;
            color: #6c757d;
            font-weight: 600;
        }
        
        .nav-tabs .nav-link.active {
            background: #5C7D99;
            color: white;
        }
        
        .post-item {
            padding: 1.5rem;
            border-bottom: 1px solid #f1f3f4;
            display: flex;
            gap: 1rem;
        }
        
        .post-item:last-child {
            border-bottom: none;
        }
        
        .post-type-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-anonymous {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .badge-community {
            background: #e8f5e8;
            color: #2e7d32;
        }
        
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-approved {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .post-content {
            flex-grow: 1;
        }
        
        .post-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .post-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        .post-actions {
            display: flex;
            gap: 0.5rem;
            align-items: flex-start;
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            background: white;
            color: #6c757d;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .btn-action:hover {
            color: #5C7D99;
            border-color: #5C7D99;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        .activity-like {
            background: #e8f5e8;
            color: #2e7d32;
        }
        
        .activity-comment {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .activity-post {
            background: #fff3cd;
            color: #856404;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .quick-action {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
        }
        
        .quick-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            color: #5C7D99;
        }
        
        .quick-action-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 3rem;
            opacity: 0.5;
            margin-bottom: 1rem;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->display_name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="{{ route('dashboard') }}">لوحتي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>مرحباً، {{ Auth::user()->display_name }}!</h1>
                    <p>هذه لوحة تحكمك الشخصية في احجيلي</p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="{{ route('posts.create') }}" class="btn btn-light">
                        <i class="bi bi-plus-circle"></i>
                        أضف مشكلة جديدة
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="profile-avatar">
                        {{ Str::upper(Str::substr(Auth::user()->display_name, 0, 1)) }}
                    </div>
                </div>
                <div class="col-md-9">
                    <h4>{{ Auth::user()->display_name }}</h4>
                    <p class="text-muted">{{ '@' . Auth::user()->username }}</p>
                    
                    @if(Auth::user()->bio)
                        <p>{{ Auth::user()->bio }}</p>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="bi bi-envelope"></i>
                                {{ Auth::user()->email }}
                            </small>
                        </div>
                        @if(Auth::user()->location)
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt"></i>
                                    @php
                                        $locations = [
                                            'baghdad' => 'بغداد', 'basra' => 'البصرة', 'erbil' => 'أربيل', 
                                            'mosul' => 'الموصل', 'najaf' => 'النجف', 'karbala' => 'كربلاء',
                                            'sulaymaniyah' => 'السليمانية', 'kirkuk' => 'كركوك', 
                                            'diyala' => 'ديالى', 'anbar' => 'الأنبار', 'dhi_qar' => 'ذي قار',
                                            'babylon' => 'بابل', 'wasit' => 'واسط', 'saladin' => 'صلاح الدين',
                                            'qadisiyyah' => 'القادسية', 'maysan' => 'ميسان', 
                                            'muthanna' => 'المثنى', 'dohuk' => 'دهوك'
                                        ];
                                    @endphp
                                    {{ $locations[Auth::user()->location] ?? Auth::user()->location }}
                                </small>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-3">
                        <span class="badge badge-{{ Auth::user()->account_type === 'verified' ? 'success' : 'secondary' }}">
                            {{ Auth::user()->account_type === 'verified' ? 'حساب موثق' : 'عضو عادي' }}
                        </span>
                        <small class="text-muted ms-3">
                            عضو منذ {{ Auth::user()->created_at->format('M Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="stat-number">{{ Auth::user()->posts->count() }}</div>
                <div class="stat-label">منشوراتي</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #e8f5e8; color: #2e7d32;">
                    <i class="bi bi-chat-dots"></i>
                </div>
                <div class="stat-number">{{ Auth::user()->comments->count() }}</div>
                <div class="stat-label">تعليقاتي</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-hand-thumbs-up"></i>
                </div>
                <div class="stat-number">{{ Auth::user()->posts->sum('likes_count') }}</div>
                <div class="stat-label">إعجابات حصلت عليها</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background: #f8d7da; color: #721c24;">
                    <i class="bi bi-eye"></i>
                </div>
                <div class="stat-number">{{ Auth::user()->posts->sum('views_count') }}</div>
                <div class="stat-label">مشاهدات منشوراتي</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('posts.create') }}" class="quick-action">
                <div class="quick-action-icon">📝</div>
                <h6>أضف مشكلة</h6>
                <small>شارك مشكلة جديدة</small>
            </a>
            
            <a href="{{ route('home') }}" class="quick-action">
                <div class="quick-action-icon">🏠</div>
                <h6>الصفحة الرئيسية</h6>
                <small>تصفح المنشورات</small>
            </a>
            
            <a href="{{ route('contact') }}" class="quick-action">
                <div class="quick-action-icon">📞</div>
                <h6>اتصل بنا</h6>
                <small>تواصل مع الإدارة</small>
            </a>
        </div>

        <!-- My Posts -->
        <div class="posts-section">
            <div class="section-header">
                <h5><i class="bi bi-file-text"></i> منشوراتي</h5>
            </div>
            
            <ul class="nav nav-tabs" id="postsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                        الكل ({{ Auth::user()->posts->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                        موافق عليها ({{ Auth::user()->posts->where('status', 'approved')->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        في الانتظار ({{ Auth::user()->posts->where('status', 'pending')->count() }})
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="postsTabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    @forelse(Auth::user()->posts->sortByDesc('created_at') as $post)
                        <div class="post-item">
                            <div class="post-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="post-title">{{ Str::limit($post->content, 80) }}</div>
                                    <div class="d-flex gap-2">
                                        <span class="post-type-badge badge-{{ $post->type }}">
                                            {{ $post->type === 'anonymous' ? 'مجهول' : 'مجتمع' }}
                                        </span>
                                        <span class="post-type-badge badge-{{ $post->status }}">
                                            @switch($post->status)
                                                @case('approved') موافق عليه @break
                                                @case('pending') في الانتظار @break
                                                @case('rejected') مرفوض @break
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="post-meta">
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->diffForHumans() }}</span>
                                    <span><i class="bi bi-eye"></i> {{ $post->views_count }} مشاهدة</span>
                                    <span><i class="bi bi-chat"></i> {{ $post->comments_count }} تعليق</span>
                                    <span><i class="bi bi-hand-thumbs-up"></i> {{ $post->likes_count }} إعجاب</span>
                                </div>
                            </div>
                            
                            <div class="post-actions">
                                <a href="{{ route('posts.show', $post) }}" class="btn-action">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-file-text"></i>
                            <h6>لا توجد منشورات</h6>
                            <p>لم تقم بإضافة أي منشورات بعد</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">أضف منشور الآن</a>
                        </div>
                    @endforelse
                </div>
                
                <div class="tab-pane fade" id="approved" role="tabpanel">
                    @forelse(Auth::user()->posts->where('status', 'approved')->sortByDesc('created_at') as $post)
                        <div class="post-item">
                            <div class="post-content">
                                <div class="post-title">{{ Str::limit($post->content, 80) }}</div>
                                <div class="post-meta">
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->diffForHumans() }}</span>
                                    <span><i class="bi bi-eye"></i> {{ $post->views_count }} مشاهدة</span>
                                    <span><i class="bi bi-chat"></i> {{ $post->comments_count }} تعليق</span>
                                    <span><i class="bi bi-hand-thumbs-up"></i> {{ $post->likes_count }} إعجاب</span>
                                </div>
                            </div>
                            <div class="post-actions">
                                <a href="{{ route('posts.show', $post) }}" class="btn-action">
                                    <i class="bi bi-eye"></i> عرض
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-check-circle"></i>
                            <h6>لا توجد منشورات موافق عليها</h6>
                            <p>لم يتم الموافقة على أي من منشوراتك بعد</p>
                        </div>
                    @endforelse
                </div>
                
                <div class="tab-pane fade" id="pending" role="tabpanel">
                    @forelse(Auth::user()->posts->where('status', 'pending')->sortByDesc('created_at') as $post)
                        <div class="post-item">
                            <div class="post-content">
                                <div class="post-title">{{ Str::limit($post->content, 80) }}</div>
                                <div class="post-meta">
                                    <span><i class="bi bi-calendar"></i> {{ $post->created_at->diffForHumans() }}</span>
                                    <span class="text-warning"><i class="bi bi-clock"></i> في انتظار المراجعة</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="bi bi-clock"></i>
                            <h6>لا توجد منشورات في الانتظار</h6>
                            <p>جميع منشوراتك تمت مراجعتها</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="posts-section">
            <div class="section-header">
                <h5><i class="bi bi-activity"></i> النشاط الأخير</h5>
            </div>
            
            @php
                $recentActivities = collect();
                
                // Add recent posts
                Auth::user()->posts->take(3)->each(function($post) use ($recentActivities) {
                    $recentActivities->push([
                        'type' => 'post',
                        'data' => $post,
                        'created_at' => $post->created_at
                    ]);
                });
                
                // Add recent comments
                Auth::user()->comments->take(3)->each(function($comment) use ($recentActivities) {
                    $recentActivities->push([
                        'type' => 'comment',
                        'data' => $comment,
                        'created_at' => $comment->created_at
                    ]);
                });
                
                $recentActivities = $recentActivities->sortByDesc('created_at')->take(5);
            @endphp
            
            @forelse($recentActivities as $activity)
                <div class="activity-item">
                    @if($activity['type'] === 'post')
                        <div class="activity-icon activity-post">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div>
                            <div><strong>أضفت منشور جديد</strong></div>
                            <div class="text-muted">{{ Str::limit($activity['data']->content, 60) }}</div>
                            <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                        </div>
                    @elseif($activity['type'] === 'comment')
                        <div class="activity-icon activity-comment">
                            <i class="bi bi-chat"></i>
                        </div>
                        <div>
                            <div><strong>أضفت تعليق</strong></div>
                            <div class="text-muted">{{ Str::limit($activity['data']->content, 60) }}</div>
                            <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-activity"></i>
                    <h6>لا يوجد نشاط</h6>
                    <p>ابدأ بإضافة منشورات أو تعليقات</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

