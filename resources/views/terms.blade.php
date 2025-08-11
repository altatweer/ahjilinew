<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شروط الاستخدام - احجيلي</title>
    
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
            padding: 3rem;
            margin: 2rem 0;
        }
        
        .section-title {
            color: #2d3748;
            margin-bottom: 1.5rem;
            font-weight: 700;
            border-bottom: 2px solid #5C7D99;
            padding-bottom: 0.5rem;
        }
        
        .subsection-title {
            color: #4a5568;
            margin: 2rem 0 1rem 0;
            font-weight: 600;
        }
        
        .content-paragraph {
            line-height: 1.8;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }
        
        .highlight-box {
            background: #e3f2fd;
            border-left: 4px solid #1976d2;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 8px;
        }
        
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #856404;
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: 8px;
        }
        
        .toc {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .toc ul {
            list-style: none;
            padding-right: 1rem;
        }
        
        .toc li {
            margin-bottom: 0.5rem;
        }
        
        .toc a {
            color: #5C7D99;
            text-decoration: none;
            font-weight: 500;
        }
        
        .toc a:hover {
            text-decoration: underline;
        }
        
        .date-updated {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin: 2rem 0;
        }
        
        ol.main-list {
            counter-reset: item;
        }
        
        ol.main-list > li {
            display: block;
            margin-bottom: 1.5rem;
            padding-right: 1rem;
        }
        
        ol.main-list > li:before {
            content: counter(item) ".";
            counter-increment: item;
            font-weight: bold;
            color: #5C7D99;
            margin-left: 0.5rem;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
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
                    <h1>شروط الاستخدام</h1>
                    <p class="lead">القواعد والشروط الخاصة باستخدام منصة احجيلي</p>
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
        <!-- Last Updated -->
        <div class="date-updated">
            <strong>آخر تحديث:</strong> أغسطس 2024
        </div>

        <!-- Table of Contents -->
        <div class="toc">
            <h5><i class="bi bi-list"></i> جدول المحتويات</h5>
            <ul>
                <li><a href="#acceptance">قبول الشروط</a></li>
                <li><a href="#description">وصف الخدمة</a></li>
                <li><a href="#registration">التسجيل والحساب</a></li>
                <li><a href="#content">المحتوى والنشر</a></li>
                <li><a href="#behavior">السلوك المقبول</a></li>
                <li><a href="#privacy">الخصوصية والبيانات</a></li>
                <li><a href="#responsibilities">المسؤوليات</a></li>
                <li><a href="#termination">إنهاء الخدمة</a></li>
                <li><a href="#changes">تغيير الشروط</a></li>
                <li><a href="#contact">التواصل</a></li>
            </ul>
        </div>

        <!-- Terms Content -->
        <div class="content-section">
            <div class="highlight-box">
                <h5><i class="bi bi-info-circle"></i> مقدمة مهمة</h5>
                <p>
                    مرحباً بكم في منصة "احجيلي". باستخدامكم لموقعنا وخدماتنا، فإنكم توافقون على الالتزام بهذه الشروط والأحكام. 
                    يرجى قراءتها بعناية قبل البدء في استخدام الموقع.
                </p>
            </div>

            <section id="acceptance">
                <h3 class="section-title">1. قبول الشروط</h3>
                
                <p class="content-paragraph">
                    من خلال الوصول إلى موقع "احجيلي" أو استخدامه، فإنك توافق على الالتزام بهذه الشروط والأحكام وجميع القوانين واللوائح المعمول بها. 
                    إذا كنت لا توافق على أي من هذه الشروط، يُمنع عليك استخدام هذا الموقع أو الوصول إليه.
                </p>
                
                <p class="content-paragraph">
                    هذه الشروط تشكل اتفاقية قانونية بينك وبين إدارة موقع "احجيلي"، وتحكم استخدامك للموقع وجميع الخدمات المقدمة من خلاله.
                </p>
            </section>

            <section id="description">
                <h3 class="section-title">2. وصف الخدمة</h3>
                
                <p class="content-paragraph">
                    "احجيلي" هي منصة مجتمعية تهدف إلى:
                </p>
                
                <ol class="main-list">
                    <li>مساعدة المواطنين العراقيين في حل مشاكلهم اليومية</li>
                    <li>توفير منصة لمشاركة التجارب والتحذيرات من النصب والاحتيال</li>
                    <li>بناء مجتمع متعاون لتقديم الدعم والمساعدة</li>
                    <li>حماية المستهلكين من خلال توفير معلومات موثوقة</li>
                    <li>توفير خدمة النشر المجهول لضمان الخصوصية</li>
                </ol>
                
                <div class="warning-box">
                    <strong>تنبيه:</strong> نحتفظ بالحق في تعديل أو إيقاف أي جزء من الخدمة في أي وقت دون إشعار مسبق.
                </div>
            </section>

            <section id="registration">
                <h3 class="section-title">3. التسجيل والحساب</h3>
                
                <h5 class="subsection-title">3.1 شروط التسجيل</h5>
                <p class="content-paragraph">
                    للتسجيل في الموقع، يجب أن تكون قد بلغت سن 16 عاماً على الأقل. كما يجب تقديم معلومات صحيحة ودقيقة عند إنشاء الحساب.
                </p>
                
                <h5 class="subsection-title">3.2 مسؤولية الحساب</h5>
                <p class="content-paragraph">
                    أنت مسؤول عن الحفاظ على سرية كلمة المرور وجميع الأنشطة التي تحدث تحت حسابك. يجب إخطارنا فوراً في حالة الاشتباه في الوصول غير المصرح به لحسابك.
                </p>
                
                <h5 class="subsection-title">3.3 النشر بدون تسجيل</h5>
                <p class="content-paragraph">
                    نوفر إمكانية النشر المجهول بدون تسجيل، ولكن هذا لا يعفيك من الالتزام بجميع شروط الاستخدام المذكورة في هذه الوثيقة.
                </p>
            </section>

            <section id="content">
                <h3 class="section-title">4. المحتوى والنشر</h3>
                
                <h5 class="subsection-title">4.1 المحتوى المسموح</h5>
                <ol class="main-list">
                    <li>مشاركة تجارب حقيقية مع المحلات والخدمات</li>
                    <li>طلب المساعدة في حل المشاكل</li>
                    <li>تقديم النصائح والحلول البناءة</li>
                    <li>التحذير من النصب والاحتيال مع أدلة</li>
                    <li>مناقشة الموضوعات ذات الصلة بخدمة المجتمع</li>
                </ol>
                
                <h5 class="subsection-title">4.2 المحتوى المحظور</h5>
                <div class="warning-box">
                    <strong>يُحظر نشر المحتوى التالي:</strong>
                    <ul>
                        <li>المحتوى المسيء أو المهين أو التمييزي</li>
                        <li>التهديدات أو التحريض على العنف</li>
                        <li>المعلومات الكاذبة أو المضللة</li>
                        <li>انتهاك الخصوصية أو نشر معلومات شخصية للآخرين</li>
                        <li>المحتوى الإباحي أو غير اللائق</li>
                        <li>الإعلانات التجارية غير المصرح بها</li>
                        <li>انتهاك حقوق الملكية الفكرية</li>
                        <li>المحتوى الذي ينتهك القوانين العراقية</li>
                    </ul>
                </div>
                
                <h5 class="subsection-title">4.3 حقوق المحتوى</h5>
                <p class="content-paragraph">
                    تحتفظ بجميع حقوق الملكية للمحتوى الذي تنشره، ولكنك تمنحنا رخصة غير حصرية لاستخدام وعرض وتوزيع هذا المحتوى على منصتنا.
                </p>
            </section>

            <section id="behavior">
                <h3 class="section-title">5. السلوك المقبول</h3>
                
                <h5 class="subsection-title">5.1 التفاعل الإيجابي</h5>
                <p class="content-paragraph">
                    نشجع على التفاعل البناء والمفيد. يجب التعامل مع الآخرين بأدب واحترام، حتى عند الاختلاف في الآراء.
                </p>
                
                <h5 class="subsection-title">5.2 الصدق والأمانة</h5>
                <p class="content-paragraph">
                    يجب أن تكون جميع المعلومات المشاركة صحيحة وقائمة على تجارب حقيقية. تجنب المبالغة أو التلفيق في الوقائع.
                </p>
                
                <h5 class="subsection-title">5.3 احترام الخصوصية</h5>
                <p class="content-paragraph">
                    لا تشارك معلومات شخصية للآخرين بدون إذنهم، ولا تحاول كشف هوية المستخدمين الذين اختاروا النشر بشكل مجهول.
                </p>
            </section>

            <section id="privacy">
                <h3 class="section-title">6. الخصوصية والبيانات</h3>
                
                <p class="content-paragraph">
                    نحن ملتزمون بحماية خصوصيتك وأمان بياناتك. لمعرفة المزيد حول كيفية جمع واستخدام بياناتك، يرجى مراجعة 
                    <a href="{{ route('privacy') }}">سياسة الخصوصية</a> الخاصة بنا.
                </p>
                
                <div class="highlight-box">
                    <h5><i class="bi bi-shield-check"></i> التزامنا بالخصوصية</h5>
                    <ul>
                        <li>لا نبيع بياناتك الشخصية لأطراف ثالثة</li>
                        <li>نحمي هوية المستخدمين المجهولين</li>
                        <li>نستخدم تقنيات التشفير لحماية البيانات</li>
                        <li>نتبع أفضل الممارسات في أمان المعلومات</li>
                    </ul>
                </div>
            </section>

            <section id="responsibilities">
                <h3 class="section-title">7. المسؤوليات</h3>
                
                <h5 class="subsection-title">7.1 مسؤولية المستخدم</h5>
                <p class="content-paragraph">
                    أنت مسؤول عن جميع الأنشطة التي تحدث من خلال حسابك، وعن ضمان أن استخدامك للموقع يتوافق مع هذه الشروط والقوانين المعمول بها.
                </p>
                
                <h5 class="subsection-title">7.2 مسؤولية الموقع</h5>
                <p class="content-paragraph">
                    نحن نبذل قصارى جهدنا لتوفير خدمة موثوقة وآمنة، ولكننا لا نضمن دقة جميع المعلومات المنشورة من قبل المستخدمين. 
                    استخدام هذه المعلومات يكون على مسؤوليتك الشخصية.
                </p>
                
                <div class="warning-box">
                    <strong>إخلاء مسؤولية:</strong> الموقع يوفر منصة للمشاركة، ولا نتحمل مسؤولية الأضرار الناتجة عن المعلومات المنشورة من قبل المستخدمين.
                </div>
            </section>

            <section id="termination">
                <h3 class="section-title">8. إنهاء الخدمة</h3>
                
                <h5 class="subsection-title">8.1 إنهاء الحساب من قبلك</h5>
                <p class="content-paragraph">
                    يمكنك إنهاء حسابك في أي وقت عبر التواصل معنا أو من خلال إعدادات الحساب.
                </p>
                
                <h5 class="subsection-title">8.2 إنهاء الحساب من قبلنا</h5>
                <p class="content-paragraph">
                    نحتفظ بالحق في تعليق أو إنهاء حسابك في حالة انتهاك هذه الشروط أو في حالة السلوك الضار بالمجتمع.
                </p>
                
                <h5 class="subsection-title">8.3 آثار الإنهاء</h5>
                <p class="content-paragraph">
                    عند إنهاء الحساب، قد نحتفظ ببعض البيانات وفقاً لسياسة الخصوصية والمتطلبات القانونية.
                </p>
            </section>

            <section id="changes">
                <h3 class="section-title">9. تغيير الشروط</h3>
                
                <p class="content-paragraph">
                    نحتفظ بالحق في تحديث هذه الشروط والأحكام في أي وقت. سيتم إشعارك بأي تغييرات جوهرية عبر الموقع أو البريد الإلكتروني.
                </p>
                
                <p class="content-paragraph">
                    استمرارك في استخدام الموقع بعد تحديث الشروط يعني موافقتك على الشروط الجديدة.
                </p>
            </section>

            <section id="contact">
                <h3 class="section-title">10. التواصل</h3>
                
                <div class="contact-info">
                    <h5><i class="bi bi-envelope"></i> للأسئلة حول شروط الاستخدام</h5>
                    <p>
                        إذا كان لديك أي أسئلة حول هذه الشروط والأحكام، يمكنك التواصل معنا عبر:
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>البريد الإلكتروني:</strong><br>
                            legal@ahjili.com
                        </div>
                        <div class="col-md-6">
                            <strong>صفحة الاتصال:</strong><br>
                            <a href="{{ route('contact') }}">اتصل بنا</a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="highlight-box">
                <h5><i class="bi bi-check-circle"></i> شكراً لك</h5>
                <p>
                    شكراً لاختيارك "احجيلي" وانضمامك لمجتمعنا. نحن ملتزمون بتوفير بيئة آمنة ومفيدة لجميع المستخدمين.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

