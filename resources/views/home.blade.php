<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>احجيلي - حلول وتحذيرات للمجتمع العراقي</title>
    
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
        
        .main-header {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .tagline {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .search-section {
            background: white;
            padding: 1.5rem;
            margin: -1rem 0 2rem 0;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .category-tabs {
            margin-bottom: 2rem;
        }
        
        .category-btn {
            background: white;
            border: 2px solid #e9ecef;
            color: #6c757d;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            min-height: 100px;
        }
        
        .category-btn:hover, .category-btn.active {
            background: #5C7D99;
            color: white;
            border-color: #5C7D99;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(92, 125, 153, 0.3);
        }
        
        .category-icon {
            font-size: 1.8rem;
        }
        
        .post-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-right: 5px solid #e9ecef;
        }
        
        .post-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        
        .post-card.warning {
            border-right-color: #dc3545;
        }
        
        .post-card.recommendation {
            border-right-color: #28a745;
        }
        
        .post-card.question {
            border-right-color: #E97451;
        }
        
        .post-card.tech {
            border-right-color: #6f42c1;
        }
        
        .post-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }
        
        .post-type-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .warning-icon {
            background-color: #fee2e2;
            color: #dc3545;
        }
        
        .recommendation-icon {
            background-color: #d1fae5;
            color: #28a745;
        }
        
        .question-icon {
            background-color: #fed7cc;
            color: #E97451;
        }
        
        .tech-icon {
            background-color: #e9ecff;
            color: #6f42c1;
        }
        
        .post-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0;
            color: #2d3748;
        }
        
        .post-content {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #718096;
            font-size: 0.9rem;
            border-top: 1px solid #f1f3f4;
            padding-top: 1rem;
        }
        
        .post-stats {
            display: flex;
            gap: 1rem;
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        
        .evidence-badge {
            background: #fef3cd;
            color: #856404;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        
        /* Read More Link Styles */
        .content-preview {
            line-height: 1.6;
            text-align: justify;
            color: #4a5568;
        }
        
        .read-more-section {
            text-align: left;
        }
        
        .read-more-link {
            color: #5C7D99;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            background: rgba(92, 125, 153, 0.1);
        }
        
        .read-more-link:hover {
            color: #4A6A85;
            background: rgba(92, 125, 153, 0.2);
            transform: translateX(-2px);
            text-decoration: none;
        }
        
        .read-more-link i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }
        
        .read-more-link:hover i {
            transform: translateX(-2px);
        }
        
        .add-post-btn {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            width: 70px;
            height: 70px;
            background: #E97451;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 1.2rem;
            box-shadow: 0 6px 20px rgba(233, 116, 81, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .add-post-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(233, 116, 81, 0.6);
            color: white;
            text-decoration: none;
        }
        
        .add-icon {
            font-size: 1.4rem;
            margin-bottom: 2px;
        }
        
        .add-text {
            font-size: 0.6rem;
            font-weight: 600;
            text-align: center;
            line-height: 1;
        }
        
        .rating-stars {
            color: #ffc107;
        }
        
        .location-tag {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        
        /* Hashtags Styling */
        .hashtags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.3rem;
        }
        
        .hashtag-badge {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            color: #1976D2;
            padding: 0.2rem 0.6rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid #90CAF9;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .hashtag-badge:hover {
            background: linear-gradient(135deg, #1976D2, #1565C0);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(25, 118, 210, 0.3);
        }
        
        .footer {
            background: #2d3748;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .stats-counter {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            margin: 1rem 0;
        }
        
        .counter-number {
            font-size: 2rem;
            font-weight: 700;
            color: #5C7D99;
        }
        
        .counter-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: #5C7D99 !important;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }
        
        /* تحسينات للموبايل */
        @media (max-width: 768px) {
            .category-btn {
                padding: 0.8rem;
                min-height: 80px;
            }
            
            .category-icon {
                font-size: 1.4rem;
            }
            
            .post-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .add-post-btn {
                width: 60px;
                height: 60px;
                bottom: 1.5rem;
                left: 1.5rem;
            }
            
            .add-text {
                font-size: 0.55rem;
            }
            
            .add-icon {
                font-size: 1.2rem;
            }
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
                        <a class="nav-link" href="{{ route('about') }}">عن الموقع</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a>
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

    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="logo">احجيلي</h1>
                    <p class="tagline">حلول وتحذيرات للمجتمع العراقي - شارك مشكلتك واحصل على المساعدة</p>
                </div>
                <div class="col-md-4">
                    <div class="stats-counter">
                        <div class="counter-number">{{ $stats['solved_problems'] }}</div>
                        <div class="counter-label">مشاركات</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Search Section -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="search-section">
            <form method="GET" action="{{ route('home') }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group input-group-lg">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="ابحث عن مشكلة أو محل أو خدمة..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="location" class="form-select form-select-lg">
                            <option value="">كل العراق</option>
                            @foreach($locations as $key => $name)
                                <option value="{{ $key }}" {{ request('location') === $key ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="category" class="form-select form-select-lg">
                            <option value="">كل الفئات</option>
                            <option value="complaint" {{ request('category') === 'complaint' ? 'selected' : '' }}>⚠️ شكاوى</option>
                            <option value="experience" {{ request('category') === 'experience' ? 'selected' : '' }}>💭 تجارب</option>
                            <option value="recommendation" {{ request('category') === 'recommendation' ? 'selected' : '' }}>👍 توصيات</option>
                            <option value="question" {{ request('category') === 'question' ? 'selected' : '' }}>❓ أسئلة</option>
                            <option value="review" {{ request('category') === 'review' ? 'selected' : '' }}>⭐ تقييمات</option>
                            <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>📝 عام</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <div class="row g-2">
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home') }}" class="category-btn text-decoration-none {{ !request('category') ? 'active' : '' }}">
                        <div class="category-icon">🏠</div>
                        <div>الكل</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'general']) }}" class="category-btn text-decoration-none {{ request('category') === 'general' ? 'active' : '' }}">
                        <div class="category-icon">📝</div>
                        <div>عامة</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'complaint']) }}" class="category-btn text-decoration-none {{ request('category') === 'complaint' ? 'active' : '' }}">
                        <div class="category-icon">⚠️</div>
                        <div>شكاوى</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'experience']) }}" class="category-btn text-decoration-none {{ request('category') === 'experience' ? 'active' : '' }}">
                        <div class="category-icon">💭</div>
                        <div>تجارب</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'recommendation']) }}" class="category-btn text-decoration-none {{ request('category') === 'recommendation' ? 'active' : '' }}">
                        <div class="category-icon">👍</div>
                        <div>توصيات</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'question']) }}" class="category-btn text-decoration-none {{ request('category') === 'question' ? 'active' : '' }}">
                        <div class="category-icon">❓</div>
                        <div>أسئلة</div>
                    </a>
                </div>
                <div class="col-6 col-lg-auto">
                    <a href="{{ route('home', ['category' => 'review']) }}" class="category-btn text-decoration-none {{ request('category') === 'review' ? 'active' : '' }}">
                        <div class="category-icon">⭐</div>
                        <div>تقييمات</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Posts Feed -->
        <div class="posts-feed">
            @forelse($posts as $post)
                @include('partials.post-card', ['post' => $post])
            @empty
                <div class="text-center py-5">
                    <h3>لا توجد منشورات</h3>
                    <p class="text-muted">كن أول من يشارك مشكلته أو يساعد الآخرين</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">أضف منشور</a>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($posts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->appends(request()->query())->links('custom.pagination') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Add Button -->
    <a href="{{ route('posts.create') }}" class="add-post-btn" title="أضف منشور جديد">
        <i class="bi bi-plus add-icon"></i>
        <span class="add-text">أضف</span>
    </a>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>احجيلي</h5>
                    <p>منصة مجتمعية عراقية لمساعدة الناس في حل مشاكلهم وحمايتهم من النصب والاحتيال.</p>
                </div>
                <div class="col-md-4">
                    <h6>روابط مهمة</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('about') }}" class="text-light">عن الموقع</a></li>
                        <li><a href="{{ route('terms') }}" class="text-light">شروط الاستخدام</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-light">سياسة الخصوصية</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light">اتصل بنا</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>إحصائيات</h6>
                    <div class="row text-center">
                        <div class="col-12">
                            <div class="counter-number">{{ $stats['solved_problems'] }}</div>
                            <div class="counter-label">مشاركات</div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2024 احجيلي. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Copy Link Function -->
    <script>
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

