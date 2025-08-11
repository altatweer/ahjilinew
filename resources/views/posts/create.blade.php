<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أضف مشكلة جديدة - احجيلي</title>
    
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
        
        .create-card {
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
        
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        .type-selector {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .type-option {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
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
        
        .hashtag-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .hashtag-btn {
            background: #e3f2fd;
            color: #1976d2;
            border: none;
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .hashtag-btn:hover {
            background: #1976d2;
            color: white;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 10px;
            margin-top: 1rem;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #5C7D99 !important;
        }
        
        .help-text {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .help-text h6 {
            color: #1976d2;
            margin-bottom: 0.5rem;
        }
        
        .help-text ul {
            margin: 0;
            padding-right: 1rem;
        }
        
        .help-text li {
            color: #555;
            margin-bottom: 0.25rem;
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
                    <h1>أضف مشكلة جديدة</h1>
                    <p>شارك مشكلتك مع المجتمع واحصل على المساعدة والحلول</p>
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

        <div class="create-card">
            <!-- Help Text -->
            <div class="help-text">
                <h6><i class="bi bi-lightbulb"></i> نصائح لمنشور فعال:</h6>
                <ul>
                    <li>اكتب عنواناً واضحاً ومحدداً</li>
                    <li>اذكر تفاصيل المشكلة أو التجربة</li>
                    <li>أرفق صور أو أدلة إن أمكن</li>
                    <li>استخدم الهاشتاغات المناسبة</li>
                    <li>حدد المحافظة بدقة</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Post Category -->
                <div class="mb-4">
                    <label class="form-label h5">فئة المنشور *</label>
                    <select class="form-select @error('category') is-invalid @enderror" name="category" required>
                        <option value="">اختر الفئة</option>
                        <option value="complaint" {{ old('category') == 'complaint' ? 'selected' : '' }}>⚠️ شكوى أو تحذير</option>
                        <option value="experience" {{ old('category') == 'experience' ? 'selected' : '' }}>💭 تجربة شخصية</option>
                        <option value="recommendation" {{ old('category') == 'recommendation' ? 'selected' : '' }}>👍 توصية</option>
                        <option value="question" {{ old('category') == 'question' ? 'selected' : '' }}>❓ سؤال واستفسار</option>
                        <option value="review" {{ old('category') == 'review' ? 'selected' : '' }}>⭐ تقييم خدمة</option>
                        <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>📝 عام</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Post Type Selector -->
                <div class="mb-4">
                    <label class="form-label h5">نوع المنشور</label>
                    <div class="type-selector">
                        <div class="type-option" data-type="anonymous">
                            <div class="type-icon">🕶️</div>
                            <h6>مجهول</h6>
                            <small>لا يظهر اسمك</small>
                        </div>
                        @auth
                            <div class="type-option" data-type="community">
                                <div class="type-icon">👤</div>
                                <h6>مجتمع</h6>
                                <small>يظهر اسمك</small>
                            </div>
                        @endauth
                    </div>
                    <input type="hidden" name="type" id="post_type" value="anonymous" required>
                    @guest
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>للمستخدمين المسجلين:</strong> يمكنك <a href="{{ route('register') }}">إنشاء حساب</a> أو <a href="{{ route('login') }}">تسجيل الدخول</a> للمشاركة باسمك وبناء سمعة في المجتمع.
                        </div>
                    @endguest
                </div>

                <!-- Guest Name (for anonymous posts) -->
                @guest
                <div class="mb-3">
                    <label for="guest_name" class="form-label h6">اسمك (اختياري)</label>
                    <input type="text" 
                           class="form-control @error('guest_name') is-invalid @enderror" 
                           id="guest_name" 
                           name="guest_name" 
                           placeholder="اكتب اسمك أو اتركه فارغاً للبقاء مجهولاً تماماً"
                           value="{{ old('guest_name') }}"
                           maxlength="100">
                    <div class="form-text">
                        <i class="bi bi-info-circle"></i>
                        هذا الحقل اختياري - يمكنك كتابة اسمك الحقيقي أو أي اسم تريد، أو تركه فارغاً للبقاء مجهولاً
                    </div>
                    @error('guest_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endguest

                <!-- Content -->
                <div class="mb-3">
                    <label for="content" class="form-label h6">اكتب مشكلتك أو تجربتك *</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" 
                              name="content" 
                              rows="6" 
                              required
                              placeholder="مثال: احذروا من محل اسمه (اكتب الاسم) في منطقة الكرادة، جودة الخدمة سيئة جداً ولا يلتزم بالمواعيد..."
                              maxlength="1000">{{ old('content') }}</textarea>
                    <div class="form-text">يجب أن يكون المحتوى بين 10-1000 حرف</div>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label h6">أرفق صورة أو دليل (اختياري)</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image"
                           accept="image/*"
                           onchange="previewImage(this)">
                    <div class="form-text">الحد الأقصى 2 ميجابايت، أنواع مدعومة: JPG, PNG, GIF</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <img id="imagePreview" class="image-preview" style="display: none;">
                </div>

                <!-- Location -->
                <div class="mb-3">
                    <label for="location" class="form-label h6">المحافظة *</label>
                    <select class="form-select @error('location') is-invalid @enderror" 
                            id="location" 
                            name="location" 
                            required>
                        <option value="">اختر المحافظة</option>
                        @foreach($locations as $key => $name)
                            <option value="{{ $key }}" {{ old('location') === $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hashtags -->
                <div class="mb-4">
                    <label for="hashtags" class="form-label h6">الهاشتاغات (اختياري)</label>
                    <input type="text" 
                           class="form-control @error('hashtags') is-invalid @enderror" 
                           id="hashtags" 
                           name="hashtags" 
                           value="{{ old('hashtags') }}"
                           placeholder="مثال: نصب، احتيال، كرادة، مطعم"
                           maxlength="200">
                    <div class="form-text">اكتب الهاشتاغات مفصولة بفاصلات</div>
                    @error('hashtags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Hashtag Suggestions -->
                    <div class="hashtag-suggestions">
                        <button type="button" class="hashtag-btn" onclick="addHashtag('نصب')">نصب</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('احتيال')">احتيال</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('توصية')">توصية</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('مطعم')">مطعم</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('محل')">محل</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('خدمات')">خدمات</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('تقنية')">تقنية</button>
                        <button type="button" class="hashtag-btn" onclick="addHashtag('سيارات')">سيارات</button>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary btn-lg flex-fill">
                        <i class="bi bi-send me-2"></i>
                        نشر المشكلة
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                        <i class="bi bi-x-lg me-2"></i>
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Post type selector
        document.querySelectorAll('.type-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.type-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('post_type').value = this.dataset.type;
            });
        });

        // Set default active
        document.querySelector('.type-option[data-type="anonymous"]').classList.add('active');

        // Image preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // Add hashtag
        function addHashtag(tag) {
            const hashtagsInput = document.getElementById('hashtags');
            const currentTags = hashtagsInput.value.trim();
            
            if (currentTags === '') {
                hashtagsInput.value = tag;
            } else {
                const tags = currentTags.split(',').map(t => t.trim());
                if (!tags.includes(tag)) {
                    hashtagsInput.value = currentTags + ', ' + tag;
                }
            }
        }

        // Character counter for content
        document.getElementById('content').addEventListener('input', function() {
            const maxLength = 1000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            // You can add a character counter display here if needed
        });
    </script>
</body>
</html>

