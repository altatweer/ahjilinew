<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عن الموقع - احجيلي</title>
    
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
            padding: 3rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .content-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .feature-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem auto;
        }
        
        .stats-section {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            color: white;
            border-radius: 15px;
            padding: 3rem 2rem;
            margin: 3rem 0;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .team-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 3rem 2rem;
            margin: 3rem 0;
            text-align: center;
        }
        
        .section-title {
            color: #2d3748;
            margin-bottom: 2rem;
            font-weight: 700;
        }
        
        .timeline {
            position: relative;
            padding: 2rem 0;
        }
        
        .timeline-item {
            position: relative;
            padding: 1rem 0 1rem 3rem;
            margin-bottom: 2rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            right: 0;
            top: 1.5rem;
            width: 15px;
            height: 15px;
            background: #5C7D99;
            border-radius: 50%;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            right: 7px;
            top: 2.5rem;
            width: 1px;
            height: calc(100% + 1rem);
            background: #e9ecef;
        }
        
        .timeline-item:last-child::after {
            display: none;
        }
        
        .timeline-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .timeline-description {
            color: #6c757d;
            line-height: 1.6;
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
                        <a class="nav-link active" href="{{ route('about') }}">عن الموقع</a>
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
                    <h1>عن احجيلي</h1>
                    <p class="lead">منصة مجتمعية عراقية لحل المشاكل وحماية المستهلكين</p>
                </div>
                <div class="col-md-4 text-center">
                    <a href="{{ route('home') }}" class="btn btn-light">
                        <i class="bi bi-arrow-right"></i>
                        العودة للرئيسية
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- About Section -->
        <div class="content-section">
            <h2 class="section-title">ما هو احجيلي؟</h2>
            <div class="row">
                <div class="col-lg-8">
                    <p class="lead">
                        "احجيلي" هي منصة مجتمعية عراقية مبتكرة تهدف إلى مساعدة المواطنين في حل مشاكلهم اليومية وحمايتهم من النصب والاحتيال.
                    </p>
                    
                    <p>
                        نحن نؤمن بقوة المجتمع في حل المشاكل وتقديم الدعم. من خلال منصتنا، يمكن للمواطنين العراقيين مشاركة تجاربهم، 
                        سواء كانت إيجابية أو سلبية، مع المحلات والخدمات والشركات المختلفة، مما يساعد الآخرين على اتخاذ قرارات مدروسة.
                    </p>
                    
                    <p>
                        كما نوفر مساحة آمنة للنشر المجهول، حيث يمكن للأشخاص طلب المساعدة أو النصيحة دون الكشف عن هويتهم، 
                        مما يضمن الخصوصية والحماية للجميع.
                    </p>
                </div>
                <div class="col-lg-4">
                    <img src="https://via.placeholder.com/400x300/5C7D99/FFFFFF?text=احجيلي" alt="احجيلي" class="img-fluid rounded">
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="feature-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: #e3f2fd; color: #1976d2;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4>حماية المستهلك</h4>
                <p>نساعد في حماية المستهلكين من النصب والاحتيال من خلال مشاركة التجارب والتحذيرات.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon" style="background: #e8f5e8; color: #2e7d32;">
                    <i class="bi bi-people"></i>
                </div>
                <h4>مجتمع متعاون</h4>
                <p>نبني مجتمعاً قوياً يساعد بعضه البعض في حل المشاكل وتقديم النصائح والحلول.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon" style="background: #fff3cd; color: #856404;">
                    <i class="bi bi-incognito"></i>
                </div>
                <h4>خصوصية آمنة</h4>
                <p>إمكانية النشر بشكل مجهول لضمان الخصوصية والحماية عند طلب المساعدة.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon" style="background: #f8d7da; color: #721c24;">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h4>تغطية محلية</h4>
                <p>تركيز على المشاكل والخدمات المحلية في جميع أنحاء العراق مع تصنيف حسب المحافظات.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon" style="background: #e9ecff; color: #6f42c1;">
                    <i class="bi bi-lightning"></i>
                </div>
                <h4>استجابة سريعة</h4>
                <p>حلول سريعة ومباشرة للمشاكل من خلال تفاعل المجتمع النشط.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon" style="background: #fed7cc; color: #E97451;">
                    <i class="bi bi-star"></i>
                </div>
                <h4>تقييمات موثوقة</h4>
                <p>نظام تقييم شفاف للمحلات والخدمات يساعد في اتخاذ قرارات أفضل.</p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-section">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">مشاركات</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">عضو نشط</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">18</div>
                        <div class="stat-label">محافظة مغطاة</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">خدمة متواصلة</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="content-section">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="section-title">رؤيتنا</h3>
                    <p>
                        أن نكون المنصة الرائدة في العراق لحل المشاكل المجتمعية وحماية المستهلكين، 
                        حيث يمكن لكل مواطن الحصول على المساعدة والدعم الذي يحتاجه.
                    </p>
                    
                    <h3 class="section-title mt-4">رسالتنا</h3>
                    <p>
                        نسعى لبناء مجتمع رقمي قوي ومترابط يساعد أفراده في حل المشاكل اليومية، 
                        ويحمي المستهلكين من الاستغلال، ويوفر بيئة آمنة لتبادل التجارب والمعلومات.
                    </p>
                </div>
                <div class="col-md-6">
                    <h3 class="section-title">قيمنا</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>الشفافية:</strong> نؤمن بالصدق والوضوح في جميع التفاعلات
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>التعاون:</strong> نشجع على العمل الجماعي لحل المشاكل
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>الخصوصية:</strong> نحترم خصوصية المستخدمين ونحميها
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>العدالة:</strong> نوفر فرصاً متساوية للجميع للمشاركة
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>الابتكار:</strong> نسعى لتطوير حلول مبتكرة ومفيدة
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="content-section">
            <h3 class="section-title">مسيرتنا</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-title">يناير 2024 - فكرة احجيلي</div>
                    <div class="timeline-description">
                        بدأت الفكرة من خلال ملاحظة الحاجة الماسة لمنصة تساعد المواطنين العراقيين في حل مشاكلهم اليومية.
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-title">مارس 2024 - تطوير المنصة</div>
                    <div class="timeline-description">
                        بدء تطوير المنصة بتقنيات حديثة وتصميم يناسب احتياجات المستخدم العراقي.
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-title">يونيو 2024 - الإطلاق التجريبي</div>
                    <div class="timeline-description">
                        إطلاق النسخة التجريبية مع مجموعة محدودة من المستخدمين لتجربة الميزات الأساسية.
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-title">أغسطس 2024 - الإطلاق الرسمي</div>
                    <div class="timeline-description">
                        الإطلاق الرسمي للمنصة مع جميع الميزات المتقدمة ودعم جميع المحافظات العراقية.
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="team-section">
            <h3 class="section-title">انضم إلى مجتمعنا</h3>
            <p class="lead">كن جزءاً من التغيير الإيجابي في المجتمع العراقي</p>
            <div class="mt-4">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3">
                        <i class="bi bi-person-plus"></i>
                        انضم إلينا
                    </a>
                @endguest
                <a href="{{ route('posts.create') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-plus-circle"></i>
                    أضف مشكلة
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

