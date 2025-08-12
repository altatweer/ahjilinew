<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>احجيلي - حلول وتحذيرات للمجتمع العراقي</title>
    
    <!-- PWA Meta Tags -->
    <meta name="description" content="منصة اجتماعية عراقية لحل المشاكل والمساعدة المجتمعية. تواصل، شارك، احصل على المساعدة من مجتمعك">
    <meta name="keywords" content="احجيلي، العراق، مجتمع، مساعدة، حلول، تواصل اجتماعي">
    <meta name="author" content="احجيلي">
    <meta name="robots" content="index, follow">
    
    <!-- PWA Theme -->
    <meta name="theme-color" content="#5C7D99">
    <meta name="msapplication-navbutton-color" content="#5C7D99">
    
    <!-- iOS Safari PWA Configuration -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="احجيلي">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="format-detection" content="telephone=no">
    
    <!-- Android PWA Configuration -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="احجيلي">
    
    <!-- Windows PWA Configuration -->
    <meta name="msapplication-TileColor" content="#5C7D99">
    <meta name="msapplication-TileImage" content="/images/pwa/icon-144x144.png">
    <meta name="msapplication-starturl" content="/">
    <meta name="msapplication-navbutton-color" content="#5C7D99">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="16x16" href="/images/pwa/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/pwa/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/pwa/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/images/pwa/icon-512x512.png">
    
    <!-- iOS Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/images/pwa/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/images/pwa/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/pwa/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/pwa/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/pwa/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/pwa/icon-128x128.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/pwa/icon-128x128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/pwa/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/pwa/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/pwa/icon-180x180.png">
    
    <!-- iOS Startup Images -->
    <link rel="apple-touch-startup-image" href="/images/pwa/icon-512x512.png">
    
    <!-- Fallback favicon -->
    <link rel="shortcut icon" href="/images/pwa/favicon-32x32.png" type="image/png">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="احجيلي - منصة التواصل العراقية">
    <meta property="og:description" content="منصة اجتماعية عراقية لحل المشاكل والمساعدة المجتمعية">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:image" content="{{ url('/images/pwa/icon-512x512.png') }}">
    <meta property="og:locale" content="ar_IQ">
    <meta property="og:site_name" content="احجيلي">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="احجيلي - منصة التواصل العراقية">
    <meta name="twitter:description" content="منصة اجتماعية عراقية لحل المشاكل والمساعدة المجتمعية">
    <meta name="twitter:image" content="{{ url('/images/pwa/icon-512x512.png') }}">
    
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

    <!-- PWA Service Worker Registration -->
    <script>
        // تسجيل Service Worker للPWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', async () => {
                try {
                    console.log('🔧 بدء تسجيل Service Worker...');
                    
                    const registration = await navigator.serviceWorker.register('/sw.js', {
                        scope: '/'
                    });
                    
                    console.log('✅ تم تسجيل Service Worker بنجاح:', registration.scope);
                    
                    // التحقق من التحديثات
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        console.log('🔄 Service Worker جديد متاح');
                        
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                console.log('📱 تحديث PWA متاح');
                                showPWAUpdate(registration);
                            }
                        });
                    });
                    
                    // إظهار إشعار التثبيت
                    showInstallPromotion();
                    
                } catch (error) {
                    console.error('❌ فشل تسجيل Service Worker:', error);
                }
            });
        } else {
            console.warn('⚠️ Service Worker غير مدعوم في هذا المتصفح');
        }
        
        // متغيرات PWA
        let deferredPrompt;
        let pwaInstalled = localStorage.getItem('pwa-installed') === 'true';
        
        // التعامل مع حدث التثبيت
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('📱 PWA قابل للتثبيت');
            e.preventDefault();
            deferredPrompt = e;
            
            if (!pwaInstalled) {
                showInstallButton();
            }
        });
        
        // عند اكتمال التثبيت
        window.addEventListener('appinstalled', () => {
            console.log('🎉 تم تثبيت PWA بنجاح!');
            localStorage.setItem('pwa-installed', 'true');
            pwaInstalled = true;
            hideInstallButton();
            showToast('🎉 تم تثبيت احجيلي على جهازك بنجاح!', 'success');
        });
        
        // إظهار زر التثبيت
        function showInstallButton() {
            // التحقق من وجود زر التثبيت
            let installBtn = document.getElementById('pwa-install-btn');
            
            if (!installBtn) {
                // إنشاء زر التثبيت
                installBtn = document.createElement('button');
                installBtn.id = 'pwa-install-btn';
                installBtn.innerHTML = '📱 ثبت التطبيق';
                installBtn.className = 'btn btn-success position-fixed';
                installBtn.style.cssText = `
                    bottom: 150px;
                    right: 20px;
                    z-index: 1040;
                    border-radius: 25px;
                    padding: 10px 20px;
                    font-weight: 600;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    animation: pulse 2s infinite;
                `;
                
                // إضافة CSS للتحريك
                if (!document.getElementById('pwa-install-css')) {
                    const style = document.createElement('style');
                    style.id = 'pwa-install-css';
                    style.textContent = `
                        @keyframes pulse {
                            0% { transform: scale(1); }
                            50% { transform: scale(1.05); }
                            100% { transform: scale(1); }
                        }
                        #pwa-install-btn:hover {
                            transform: scale(1.1) !important;
                            transition: transform 0.2s ease;
                        }
                    `;
                    document.head.appendChild(style);
                }
                
                // حدث النقر
                installBtn.addEventListener('click', installPWA);
                
                document.body.appendChild(installBtn);
                
                console.log('📱 تم إظهار زر تثبيت PWA');
            }
        }
        
        // إخفاء زر التثبيت
        function hideInstallButton() {
            const installBtn = document.getElementById('pwa-install-btn');
            if (installBtn) {
                installBtn.remove();
            }
        }
        
        // تثبيت PWA
        async function installPWA() {
            if (!deferredPrompt) {
                showToast('التثبيت غير متاح حالياً', 'warning');
                return;
            }
            
            try {
                // إظهار مربع حوار التثبيت
                deferredPrompt.prompt();
                
                // انتظار رد المستخدم
                const { outcome } = await deferredPrompt.userChoice;
                
                if (outcome === 'accepted') {
                    console.log('👍 المستخدم وافق على التثبيت');
                    showToast('🔄 جاري تثبيت التطبيق...', 'info');
                } else {
                    console.log('👎 المستخدم رفض التثبيت');
                    showToast('تم إلغاء التثبيت', 'warning');
                }
                
                deferredPrompt = null;
                hideInstallButton();
                
            } catch (error) {
                console.error('❌ خطأ في التثبيت:', error);
                showToast('حدث خطأ أثناء التثبيت', 'error');
            }
        }
        
        // إظهار ترويج التثبيت
        function showInstallPromotion() {
            // فحص النظام والمتصفح
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isStandalone = window.navigator.standalone;
            const isInAppBrowser = /WebView|(iPhone|iPod|iPad)(?!.*Safari)/i.test(navigator.userAgent);
            
            console.log('🔍 PWA Detection:', {
                isIOS,
                isStandalone,
                isInAppBrowser,
                pwaInstalled,
                userAgent: navigator.userAgent
            });
            
            // فحص إذا تم عرض المودال في هذه الجلسة
            const sessionPromotionShown = sessionStorage.getItem('pwa-promotion-shown-this-session');
            
            // عدم إظهار الترويج إذا كان مثبت أو تم عرضه في هذه الجلسة
            const lastPromotion = localStorage.getItem('pwa-promotion-dismissed');
            const now = new Date().getTime();
            
            if (pwaInstalled || isStandalone || sessionPromotionShown || (lastPromotion && now - parseInt(lastPromotion) < 7 * 24 * 60 * 60 * 1000)) {
                console.log('🚫 تم تخطي ترويج التثبيت:', {
                    pwaInstalled,
                    isStandalone,
                    sessionPromotionShown: !!sessionPromotionShown,
                    recentDismissal: !!(lastPromotion && now - parseInt(lastPromotion) < 7 * 24 * 60 * 60 * 1000)
                });
                return;
            }
            
            // تسجيل أن المودال تم عرضه في هذه الجلسة
            sessionStorage.setItem('pwa-promotion-shown-this-session', 'true');
            
            // iOS Safari - تعليمات خاصة (بدون مودال تلقائي)
            if (isIOS) {
                if (isInAppBrowser) {
                    setTimeout(() => {
                        showToast('للتثبيت: افتح الموقع في Safari مباشرة', 'warning');
                    }, 3000);
                    return;
                }
                
                // إظهار زر التثبيت فقط (بدون مودال تلقائي)
                showInstallButton();
                
                // إظهار نصيحة خفيفة بدلاً من المودال الكامل
                setTimeout(() => {
                    showToast('💡 للتثبيت على iPhone: اضغط زر "ثبت" أسفل اليمين', 'info');
                }, 5000);
                return;
            }
            
            // Android وأجهزة أخرى
            showInstallButton();
            setTimeout(() => {
                if (!pwaInstalled && !document.getElementById('pwa-install-btn')) {
                    showInstallPromotionModal();
                }
            }, 10000);
        }
        
        // مودال تعليمات iOS
        function showiOSInstallModal() {
            const modalHtml = `
                <div class="modal fade" id="iosInstallModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">🍎 تثبيت احجيلي على iOS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="card border-primary">
                                            <div class="card-body">
                                                <div class="badge bg-primary rounded-pill mb-3">
                                                    <i class="bi bi-1-circle me-2"></i>الخطوة الأولى
                                                </div>
                                                <div style="font-size: 2.5rem; color: #007AFF;">
                                                    <i class="bi bi-box-arrow-up"></i>
                                                </div>
                                                <p class="mt-2 mb-0">اضغط زر <strong>المشاركة</strong> في Safari</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="card border-success">
                                            <div class="card-body">
                                                <div class="badge bg-success rounded-pill mb-3">
                                                    <i class="bi bi-2-circle me-2"></i>الخطوة الثانية
                                                </div>
                                                <div style="font-size: 2.5rem; color: #28A745;">
                                                    <i class="bi bi-plus-square"></i>
                                                </div>
                                                <p class="mt-2 mb-0">اختر <strong>"إضافة إلى الشاشة الرئيسية"</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info mt-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    سيتم إضافة أيقونة احجيلي الجميلة لشاشتك الرئيسية!
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">
                                    <i class="bi bi-check-circle me-2"></i>فهمت! سأقوم بالتثبيت
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('iosInstallModal'));
            modal.show();
            
            // إزالة المودال بعد الإغلاق
            document.getElementById('iosInstallModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }
        
        // إظهار مودال الترويج
        function showInstallPromotionModal() {
            const modalHtml = `
                <div class="modal fade" id="pwaPromotionModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <div class="modal-body text-center p-4">
                                <div style="font-size: 4rem; margin-bottom: 1rem;">📱</div>
                                <h5 class="modal-title mb-3">ثبت تطبيق احجيلي</h5>
                                <p class="text-muted mb-4">
                                    احصل على تجربة أفضل وأسرع!<br>
                                    • يعمل بدون إنترنت<br>
                                    • إشعارات فورية<br>
                                    • سرعة أعلى
                                </p>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary" onclick="installFromModal()">
                                        📱 ثبت الآن
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="dismissPromotion()">
                                        ربما لاحقاً
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('pwaPromotionModal'));
            modal.show();
            
            // إزالة المودال بعد الإغلاق
            document.getElementById('pwaPromotionModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }
        
        // تثبيت من المودال
        function installFromModal() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('pwaPromotionModal'));
            modal.hide();
            
            if (deferredPrompt) {
                installPWA();
            } else {
                showInstallButton();
                showToast('ابحث عن زر التثبيت أسفل الشاشة', 'info');
            }
        }
        
        // رفض الترويج
        function dismissPromotion() {
            localStorage.setItem('pwa-promotion-dismissed', new Date().getTime().toString());
            
            // إظهار زر لإعادة عرض التعليمات (ولكن ليس في هذه الجلسة لتجنب الإزعاج)
            setTimeout(() => {
                showToast('💡 نصيحة: يمكنك دائماً تثبيت التطبيق من الزر العائم أسفل اليمين!', 'info');
            }, 2000);
        }
        
        // إعادة إظهار تعليمات التثبيت (للاستخدام عند الحاجة)
        function resetInstallPromotion() {
            // مسح كل آثار الرفض
            localStorage.removeItem('pwa-promotion-dismissed');
            sessionStorage.removeItem('pwa-promotion-shown-this-session');
            
            // إعادة إظهار الترويج
            setTimeout(() => {
                showInstallPromotion();
            }, 1000);
            
            showToast('تم إعادة تشغيل تعليمات التثبيت!', 'success');
        }
        
        // إظهار تحديث PWA
        function showPWAUpdate(registration) {
            const updateHtml = `
                <div class="toast align-items-center text-white bg-info border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-arrow-clockwise me-2"></i>
                            تحديث جديد متاح للتطبيق
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-light me-2" onclick="updatePWA()">
                            تحديث
                        </button>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;
            
            // إظهار toast التحديث
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1055';
                document.body.appendChild(toastContainer);
            }
            
            const toastElement = document.createElement('div');
            toastElement.innerHTML = updateHtml;
            toastContainer.appendChild(toastElement.firstElementChild);
            
            const toast = new bootstrap.Toast(toastContainer.lastElementChild, {
                autohide: false // لا يختفي تلقائياً
            });
            toast.show();
            
            // حفظ registration للتحديث
            window.pwaUpdateRegistration = registration;
        }
        
        // تحديث PWA
        function updatePWA() {
            if (window.pwaUpdateRegistration && window.pwaUpdateRegistration.waiting) {
                window.pwaUpdateRegistration.waiting.postMessage({ type: 'SKIP_WAITING' });
                window.location.reload();
            }
        }
        
        // مراقبة حالة الاتصال
        window.addEventListener('online', () => {
            console.log('🌐 تم استعادة الاتصال');
            showToast('تم استعادة الاتصال بالإنترنت', 'success');
        });
        
        window.addEventListener('offline', () => {
            console.log('📡 فقدان الاتصال - تفعيل الوضع Offline');
            showToast('لا يوجد اتصال - التطبيق يعمل بوضع عدم الاتصال', 'warning');
        });
        
        console.log('🎉 احجيلي PWA جاهز للعمل!');
    </script>

    <!-- زر التثبيت العائم -->
    @include('partials.pwa-install-button')
</body>
</html>

