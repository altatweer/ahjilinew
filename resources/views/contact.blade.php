<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اتصل بنا - احجيلي</title>
    
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
        
        .main-header {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            color: white;
            padding: 3rem 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .contact-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #5C7D99;
            box-shadow: 0 0 0 0.2rem rgba(92, 125, 153, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(92, 125, 153, 0.4);
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #5C7D99 !important;
        }
        
        .contact-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #5C7D99 0%, #4A6A85 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .contact-details h6 {
            margin: 0;
            color: #2d3748;
        }
        
        .contact-details p {
            margin: 0;
            color: #6c757d;
        }
        
        .type-selector {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .type-option {
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }
        
        .type-option.active {
            border-color: #5C7D99;
            background-color: #f8f9fa;
        }
        
        .type-option:hover {
            border-color: #5C7D99;
        }
        
        .type-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .faq-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 2rem;
            margin: 2rem 0;
        }
        
        .faq-item {
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 0;
        }
        
        .faq-item:last-child {
            border-bottom: none;
        }
        
        .faq-question {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .faq-answer {
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
                        <a class="nav-link" href="{{ route('posts.create') }}">أضف مشكلة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('contact') }}">اتصل بنا</a>
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
                    <h1>اتصل بنا</h1>
                    <p>نحن هنا لمساعدتك! أرسل لنا رسالتك وسنتواصل معك في أقرب وقت ممكن</p>
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

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-card">
                    <h3 class="mb-4">
                        <i class="bi bi-envelope"></i>
                        أرسل لنا رسالة
                    </h3>

                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        
                        <!-- Message Type Selector -->
                        <div class="mb-4">
                            <label class="form-label h6">نوع الرسالة</label>
                            <div class="type-selector">
                                <div class="type-option" data-type="complaint">
                                    <div class="type-icon">📢</div>
                                    <h6>شكوى</h6>
                                    <small>مشكلة في الموقع</small>
                                </div>
                                <div class="type-option" data-type="suggestion">
                                    <div class="type-icon">💡</div>
                                    <h6>اقتراح</h6>
                                    <small>فكرة لتحسين الموقع</small>
                                </div>
                                <div class="type-option" data-type="support">
                                    <div class="type-icon">🛟</div>
                                    <h6>دعم فني</h6>
                                    <small>مساعدة في الاستخدام</small>
                                </div>
                                <div class="type-option" data-type="other">
                                    <div class="type-icon">💬</div>
                                    <h6>أخرى</h6>
                                    <small>رسالة عامة</small>
                                </div>
                            </div>
                            <input type="hidden" name="type" id="message_type" value="other" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">الاسم *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', Auth::user()->display_name ?? '') }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني (اختياري)</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email ?? '') }}"
                                       placeholder="example@domain.com">
                                <div class="form-text">لن نرسل لك رسائل دعائية</div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف (اختياري)</label>
                            <input type="tel" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                                   placeholder="07xxxxxxxxx">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">موضوع الرسالة *</label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}" 
                                   required
                                   placeholder="مثال: مشكلة في عرض المنشورات">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">نص الرسالة *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      placeholder="اكتب رسالتك بالتفصيل..."
                                      maxlength="2000">{{ old('message') }}</textarea>
                            <div class="form-text">الحد الأقصى 2000 حرف</div>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>
                                إرسال الرسالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Info & FAQ -->
            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="contact-info">
                    <h5 class="mb-4">معلومات التواصل</h5>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h6>البريد الإلكتروني</h6>
                            <p>info@ahjili.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h6>وقت الرد</h6>
                            <p>خلال 24 ساعة</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="contact-details">
                            <h6>الخصوصية</h6>
                            <p>رسائلك آمنة ومحمية</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="faq-section">
                    <h5 class="mb-4">أسئلة شائعة</h5>
                    
                    <div class="faq-item">
                        <div class="faq-question">كيف أضيف منشور جديد؟</div>
                        <div class="faq-answer">اضغط على زر "أضف مشكلة" أو الزر العائم في الصفحة الرئيسية</div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">هل يمكنني النشر بدون تسجيل؟</div>
                        <div class="faq-answer">نعم، يمكنك النشر كمجهول أو التسجيل للحصول على ميزات إضافية</div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">كيف أبلغ عن محتوى مخالف؟</div>
                        <div class="faq-answer">اضغط على زر "إبلاغ" في أي منشور واملأ النموذج</div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">هل بياناتي آمنة؟</div>
                        <div class="faq-answer">نعم، نحن نحمي خصوصيتك ولا نشارك بياناتك مع أي طرف ثالث</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Message type selector
        document.querySelectorAll('.type-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.type-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('message_type').value = this.dataset.type;
            });
        });

        // Set default active
        document.querySelector('.type-option[data-type="other"]').classList.add('active');

        // Character counter for message
        document.getElementById('message').addEventListener('input', function() {
            const maxLength = 2000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            // You can add a character counter display here if needed
        });
    </script>
</body>
</html>

