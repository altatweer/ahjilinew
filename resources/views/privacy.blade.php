<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سياسة الخصوصية - احجيلي</title>
    
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
        
        .security-box {
            background: #e8f5e8;
            border-left: 4px solid #2e7d32;
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
        
        .data-table {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .data-table table {
            margin: 0;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
        }
        
        .rights-list {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .rights-list ul {
            margin: 0;
            padding-right: 1.5rem;
        }
        
        .rights-list li {
            margin-bottom: 0.5rem;
            color: #1976d2;
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
                    <h1>سياسة الخصوصية</h1>
                    <p class="lead">كيف نحمي ونستخدم بياناتك الشخصية في احجيلي</p>
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
                <li><a href="#introduction">مقدمة</a></li>
                <li><a href="#data-collection">البيانات التي نجمعها</a></li>
                <li><a href="#data-usage">كيف نستخدم بياناتك</a></li>
                <li><a href="#data-sharing">مشاركة البيانات</a></li>
                <li><a href="#data-security">أمان البيانات</a></li>
                <li><a href="#user-rights">حقوقك</a></li>
                <li><a href="#cookies">ملفات تعريف الارتباط</a></li>
                <li><a href="#anonymous-posting">النشر المجهول</a></li>
                <li><a href="#data-retention">الاحتفاظ بالبيانات</a></li>
                <li><a href="#children">خصوصية الأطفال</a></li>
                <li><a href="#changes">تغييرات السياسة</a></li>
                <li><a href="#contact">التواصل</a></li>
            </ul>
        </div>

        <!-- Privacy Content -->
        <div class="content-section">
            <div class="security-box">
                <h5><i class="bi bi-shield-check"></i> التزامنا بحماية خصوصيتك</h5>
                <p>
                    في "احجيلي"، نؤمن بأن الخصوصية حق أساسي. هذه السياسة توضح كيف نجمع ونستخدم ونحمي معلوماتك الشخصية. 
                    نحن ملتزمون بالشفافية الكاملة حول ممارساتنا في التعامل مع البيانات.
                </p>
            </div>

            <section id="introduction">
                <h3 class="section-title">1. مقدمة</h3>
                
                <p class="content-paragraph">
                    تحكم سياسة الخصوصية هذه جمع واستخدام وحماية المعلومات الشخصية عبر موقع "احجيلي" وخدماته المرتبطة. 
                    عند استخدام موقعنا، فإنك توافق على جمع واستخدام المعلومات وفقاً لهذه السياسة.
                </p>
                
                <p class="content-paragraph">
                    نحن نلتزم بمبادئ الشفافية والعدالة والمساءلة في جميع ممارساتنا المتعلقة بالبيانات، 
                    ونسعى لإعطائك السيطرة الكاملة على معلوماتك الشخصية.
                </p>
            </section>

            <section id="data-collection">
                <h3 class="section-title">2. البيانات التي نجمعها</h3>
                
                <h5 class="subsection-title">2.1 البيانات التي تقدمها مباشرة</h5>
                
                <div class="data-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>نوع البيانات</th>
                                <th>التفاصيل</th>
                                <th>الغرض</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>معلومات التسجيل</td>
                                <td>اسم المستخدم، البريد الإلكتروني، كلمة المرور</td>
                                <td>إنشاء وإدارة الحساب</td>
                            </tr>
                            <tr>
                                <td>معلومات الملف الشخصي</td>
                                <td>الاسم المعروض، الصورة الشخصية، النبذة، المحافظة</td>
                                <td>عرض الملف الشخصي والتواصل</td>
                            </tr>
                            <tr>
                                <td>المحتوى المنشور</td>
                                <td>النصوص، الصور، التعليقات</td>
                                <td>تقديم خدمة المنصة</td>
                            </tr>
                            <tr>
                                <td>معلومات التواصل</td>
                                <td>رقم الهاتف (اختياري)</td>
                                <td>التواصل عند الضرورة</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h5 class="subsection-title">2.2 البيانات التي نجمعها تلقائياً</h5>
                <p class="content-paragraph">
                    عند استخدام موقعنا، نجمع تلقائياً بعض المعلومات التقنية مثل:
                </p>
                <ul>
                    <li>عنوان IP والموقع الجغرافي التقريبي</li>
                    <li>نوع المتصفح ونظام التشغيل</li>
                    <li>أوقات الزيارة ومدة الاستخدام</li>
                    <li>الصفحات التي تمت زيارتها</li>
                    <li>مصدر الزيارة (الموقع المرجعي)</li>
                </ul>
                
                <h5 class="subsection-title">2.3 البيانات المجهولة</h5>
                <p class="content-paragraph">
                    عند اختيارك للنشر بشكل مجهول، نحن لا نربط المحتوى بهويتك الحقيقية، 
                    ولكننا قد نحتفظ ببعض المعلومات التقنية لأغراض الأمان ومنع إساءة الاستخدام.
                </p>
            </section>

            <section id="data-usage">
                <h3 class="section-title">3. كيف نستخدم بياناتك</h3>
                
                <p class="content-paragraph">نستخدم المعلومات المجمعة للأغراض التالية:</p>
                
                <div class="highlight-box">
                    <h6>الاستخدامات الأساسية:</h6>
                    <ul>
                        <li><strong>تقديم الخدمة:</strong> عرض المحتوى وإدارة الحسابات</li>
                        <li><strong>التواصل:</strong> إرسال الإشعارات والردود على الاستفسارات</li>
                        <li><strong>التحسين:</strong> تطوير وتحسين خدماتنا</li>
                        <li><strong>الأمان:</strong> حماية الموقع ومنع الاحتيال</li>
                        <li><strong>التحليل:</strong> فهم كيفية استخدام الموقع لتحسين التجربة</li>
                    </ul>
                </div>
                
                <h5 class="subsection-title">3.1 المعالجة القانونية</h5>
                <p class="content-paragraph">
                    نعتمد على الأسس القانونية التالية لمعالجة بياناتك:
                </p>
                <ul>
                    <li><strong>الموافقة:</strong> عندما تقدم موافقتك الصريحة</li>
                    <li><strong>تنفيذ العقد:</strong> لتقديم الخدمات المطلوبة</li>
                    <li><strong>المصلحة المشروعة:</strong> لتحسين خدماتنا وحماية المستخدمين</li>
                    <li><strong>الالتزام القانوني:</strong> عند الحاجة للامتثال للقوانين</li>
                </ul>
            </section>

            <section id="data-sharing">
                <h3 class="section-title">4. مشاركة البيانات</h3>
                
                <div class="security-box">
                    <h5><i class="bi bi-lock"></i> سياسة عدم البيع</h5>
                    <p>
                        <strong>نحن لا نبيع معلوماتك الشخصية لأي طرف ثالث، ولن نفعل ذلك أبداً.</strong>
                    </p>
                </div>
                
                <h5 class="subsection-title">4.1 متى نشارك المعلومات</h5>
                <p class="content-paragraph">قد نشارك معلوماتك في الحالات المحدودة التالية:</p>
                
                <ul>
                    <li><strong>بموافقتك:</strong> عندما تمنح إذناً صريحاً</li>
                    <li><strong>مقدمو الخدمات:</strong> شركات تساعدنا في تشغيل الموقع (مع اتفاقيات سرية)</li>
                    <li><strong>الامتثال القانوني:</strong> عند طلب السلطات المختصة وفقاً للقانون</li>
                    <li><strong>حماية الحقوق:</strong> لحماية حقوقنا أو حقوق المستخدمين الآخرين</li>
                    <li><strong>البيانات المجهولة:</strong> إحصائيات عامة لا تحدد الهوية</li>
                </ul>
                
                <h5 class="subsection-title">4.2 النقل الدولي</h5>
                <p class="content-paragraph">
                    قد يتم نقل بياناتك إلى خوادم خارج العراق لأغراض التشغيل والنسخ الاحتياطي. 
                    نضمن أن جميع عمليات النقل تتم مع ضمانات أمنية مناسبة.
                </p>
            </section>

            <section id="data-security">
                <h3 class="section-title">5. أمان البيانات</h3>
                
                <div class="security-box">
                    <h5><i class="bi bi-shield-fill"></i> التدابير الأمنية</h5>
                    <p>نطبق أحدث معايير الأمان لحماية بياناتك:</p>
                    <ul>
                        <li><strong>التشفير:</strong> جميع البيانات الحساسة مشفرة</li>
                        <li><strong>HTTPS:</strong> اتصال آمن ومشفر لجميع الصفحات</li>
                        <li><strong>مراقبة مستمرة:</strong> للكشف عن أي أنشطة مشبوهة</li>
                        <li><strong>النسخ الاحتياطي:</strong> نسخ آمنة ومنتظمة للبيانات</li>
                        <li><strong>التحديثات الأمنية:</strong> تحديث مستمر لأنظمة الأمان</li>
                    </ul>
                </div>
                
                <h5 class="subsection-title">5.1 أمان كلمات المرور</h5>
                <p class="content-paragraph">
                    جميع كلمات المرور مشفرة باستخدام خوارزميات قوية، ولا يمكن لأي شخص (حتى فريق العمل) الوصول إليها. 
                    ننصحك باستخدام كلمة مرور قوية وفريدة.
                </p>
                
                <h5 class="subsection-title">5.2 الإبلاغ عن الثغرات</h5>
                <p class="content-paragraph">
                    إذا اكتشفت أي ثغرة أمنية أو مشكلة تتعلق بالخصوصية، يرجى التواصل معنا فوراً عبر: security@ahjili.com
                </p>
            </section>

            <section id="user-rights">
                <h3 class="section-title">6. حقوقك</h3>
                
                <div class="rights-list">
                    <h5>حقوقك كمستخدم تشمل:</h5>
                    <ul>
                        <li><strong>الوصول:</strong> طلب نسخة من بياناتك الشخصية</li>
                        <li><strong>التصحيح:</strong> تعديل أو تحديث المعلومات الخاطئة</li>
                        <li><strong>الحذف:</strong> طلب حذف بياناتك نهائياً</li>
                        <li><strong>التقييد:</strong> تقييد معالجة بياناتك في حالات معينة</li>
                        <li><strong>النقل:</strong> الحصول على بياناتك بصيغة قابلة للنقل</li>
                        <li><strong>الاعتراض:</strong> الاعتراض على معالجة بياناتك</li>
                        <li><strong>سحب الموافقة:</strong> سحب موافقتك في أي وقت</li>
                    </ul>
                </div>
                
                <h5 class="subsection-title">6.1 كيفية ممارسة حقوقك</h5>
                <p class="content-paragraph">
                    لممارسة أي من هذه الحقوق، يمكنك:
                </p>
                <ul>
                    <li>تسجيل الدخول وتعديل إعدادات حسابك</li>
                    <li>التواصل معنا عبر صفحة <a href="{{ route('contact') }}">اتصل بنا</a></li>
                    <li>إرسال بريد إلكتروني إلى: privacy@ahjili.com</li>
                </ul>
                
                <p class="content-paragraph">
                    سنرد على طلبك خلال 30 يوماً من تاريخ الاستلام.
                </p>
            </section>

            <section id="cookies">
                <h3 class="section-title">7. ملفات تعريف الارتباط (Cookies)</h3>
                
                <h5 class="subsection-title">7.1 ما هي ملفات تعريف الارتباط</h5>
                <p class="content-paragraph">
                    ملفات تعريف الارتباط هي ملفات نصية صغيرة تُحفظ على جهازك عند زيارة موقعنا. 
                    نستخدمها لتحسين تجربتك وتذكر تفضيلاتك.
                </p>
                
                <h5 class="subsection-title">7.2 أنواع ملفات تعريف الارتباط المستخدمة</h5>
                <div class="data-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>النوع</th>
                                <th>الغرض</th>
                                <th>المدة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ضرورية</td>
                                <td>تشغيل الموقع الأساسي</td>
                                <td>جلسة المتصفح</td>
                            </tr>
                            <tr>
                                <td>وظيفية</td>
                                <td>تذكر التفضيلات</td>
                                <td>حتى سنة واحدة</td>
                            </tr>
                            <tr>
                                <td>تحليلية</td>
                                <td>فهم استخدام الموقع</td>
                                <td>حتى سنتين</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h5 class="subsection-title">7.3 إدارة ملفات تعريف الارتباط</h5>
                <p class="content-paragraph">
                    يمكنك التحكم في ملفات تعريف الارتباط من خلال إعدادات متصفحك. 
                    لاحظ أن إيقاف بعض الملفات قد يؤثر على وظائف الموقع.
                </p>
            </section>

            <section id="anonymous-posting">
                <h3 class="section-title">8. النشر المجهول</h3>
                
                <div class="highlight-box">
                    <h5><i class="bi bi-incognito"></i> حماية الهوية المجهولة</h5>
                    <p>
                        نحن ملتزمون بحماية هوية المستخدمين الذين يختارون النشر بشكل مجهول. 
                        لا نربط المحتوى المجهول بأي معلومات شخصية قابلة للتحديد.
                    </p>
                </div>
                
                <h5 class="subsection-title">8.1 ما نجمعه للمحتوى المجهول</h5>
                <p class="content-paragraph">
                    عند النشر المجهول، نجمع فقط:
                </p>
                <ul>
                    <li>المحتوى المنشور</li>
                    <li>التاريخ والوقت</li>
                    <li>عنوان IP (لأغراض الأمان فقط)</li>
                    <li>المحافظة المختارة</li>
                </ul>
                
                <h5 class="subsection-title">8.2 استثناءات الحماية</h5>
                <div class="warning-box">
                    <strong>قد نكشف عن هوية المنشور المجهول في الحالات التالية فقط:</strong>
                    <ul>
                        <li>أمر قضائي من سلطة مختصة</li>
                        <li>تهديد مباشر للأمن العام</li>
                        <li>انتهاك جسيم لشروط الاستخدام</li>
                        <li>أنشطة إجرامية محتملة</li>
                    </ul>
                </div>
            </section>

            <section id="data-retention">
                <h3 class="section-title">9. الاحتفاظ بالبيانات</h3>
                
                <h5 class="subsection-title">9.1 مدة الاحتفاظ</h5>
                <p class="content-paragraph">نحتفظ ببياناتك للمدد التالية:</p>
                
                <div class="data-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>نوع البيانات</th>
                                <th>مدة الاحتفاظ</th>
                                <th>السبب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>بيانات الحساب النشط</td>
                                <td>طوال فترة نشاط الحساب</td>
                                <td>تقديم الخدمة</td>
                            </tr>
                            <tr>
                                <td>بيانات الحساب المحذوف</td>
                                <td>30 يوماً</td>
                                <td>إمكانية الاستعادة</td>
                            </tr>
                            <tr>
                                <td>السجلات الأمنية</td>
                                <td>سنة واحدة</td>
                                <td>الأمان والامتثال</td>
                            </tr>
                            <tr>
                                <td>المحتوى العام</td>
                                <td>دائم (إلا عند طلب الحذف)</td>
                                <td>قيمة المجتمع</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <h5 class="subsection-title">9.2 الحذف التلقائي</h5>
                <p class="content-paragraph">
                    نقوم بحذف البيانات غير الضرورية تلقائياً عند انتهاء مدة الاحتفاظ المحددة، 
                    أو عندما تفقد البيانات غرضها الأصلي.
                </p>
            </section>

            <section id="children">
                <h3 class="section-title">10. خصوصية الأطفال</h3>
                
                <div class="warning-box">
                    <h5><i class="bi bi-person-x"></i> قيود السن</h5>
                    <p>
                        خدماتنا مصممة للأشخاص الذين تزيد أعمارهم عن 16 عاماً. 
                        نحن لا نجمع معلومات شخصية من الأطفال دون سن 16 عاماً عمداً.
                    </p>
                </div>
                
                <p class="content-paragraph">
                    إذا علمنا أننا جمعنا معلومات شخصية من طفل دون سن 16 عاماً، 
                    سنحذف هذه المعلومات فوراً ونقوم بإغلاق الحساب.
                </p>
                
                <p class="content-paragraph">
                    إذا كنت والداً أو وصياً وتعتقد أن طفلك قدم معلومات شخصية لنا، 
                    يرجى التواصل معنا فوراً.
                </p>
            </section>

            <section id="changes">
                <h3 class="section-title">11. تغييرات السياسة</h3>
                
                <p class="content-paragraph">
                    قد نحدث سياسة الخصوصية هذه من وقت لآخر. سننشر أي تغييرات على هذه الصفحة 
                    ونحديث تاريخ "آخر تحديث" في أعلى الصفحة.
                </p>
                
                <h5 class="subsection-title">11.1 التغييرات الجوهرية</h5>
                <p class="content-paragraph">
                    في حالة التغييرات الجوهرية التي تؤثر على حقوقك، سنرسل إشعاراً عبر:
                </p>
                <ul>
                    <li>البريد الإلكتروني (للمستخدمين المسجلين)</li>
                    <li>إشعار بارز على الموقع</li>
                    <li>رسالة في لوحة التحكم</li>
                </ul>
                
                <p class="content-paragraph">
                    ننصحك بمراجعة هذه السياسة دورياً للبقاء على اطلاع بأحدث التحديثات.
                </p>
            </section>

            <section id="contact">
                <h3 class="section-title">12. التواصل</h3>
                
                <div class="contact-info">
                    <h5><i class="bi bi-envelope"></i> للأسئلة حول الخصوصية</h5>
                    <p>
                        إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية هذه أو ممارساتنا في التعامل مع البيانات:
                    </p>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>مسؤول حماية البيانات:</strong><br>
                            privacy@ahjili.com
                        </div>
                        <div class="col-md-4">
                            <strong>الاستفسارات الأمنية:</strong><br>
                            security@ahjili.com
                        </div>
                        <div class="col-md-4">
                            <strong>صفحة الاتصال:</strong><br>
                            <a href="{{ route('contact') }}">اتصل بنا</a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="security-box">
                <h5><i class="bi bi-heart"></i> شكراً لثقتكم</h5>
                <p>
                    خصوصيتكم وثقتكم هما أهم أولوياتنا. نحن ملتزمون بحماية معلوماتكم والحفاظ على شفافية كاملة 
                    حول كيفية التعامل مع بياناتكم. معاً نبني مجتمعاً رقمياً آمناً وموثوقاً.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

