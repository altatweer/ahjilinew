<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>احجيلي - منصة مجتمعية عراقية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            direction: rtl;
        }
        
        .hero {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            margin: 2rem auto;
            max-width: 800px;
            text-align: center;
            color: white;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .success-badge {
            background: rgba(46, 204, 113, 0.2);
            border: 2px solid #2ecc71;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .setup-info {
            background: rgba(52, 152, 219, 0.2);
            border: 2px solid #3498db;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: right;
        }
        
        .setup-info h5 {
            color: #fff;
            margin-bottom: 1rem;
        }
        
        .setup-info ol {
            color: #ecf0f1;
            font-size: 0.9rem;
        }
        
        .setup-info li {
            margin-bottom: 0.5rem;
        }
        
        .btn-custom {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 0.5rem;
        }
        
        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <div class="logo">🏛️ احجيلي</div>
            <div class="subtitle">منصة مجتمعية عراقية لحل المشاكل والمساعدة</div>
            
            <div class="success-badge">
                <h4><i class="bi bi-check-circle-fill me-2"></i>Laravel يعمل بنجاح!</h4>
                <p class="mb-0">المشروع تم رفعه وتثبيته بنجاح. جاهز للإعداد النهائي.</p>
            </div>
            
            <div class="setup-info">
                <h5><i class="bi bi-gear-fill me-2"></i>خطوات الإعداد النهائي:</h5>
                <ol>
                    <li>تأكد من إعدادات قاعدة البيانات في ملف <code>.env</code></li>
                    <li>تشغيل الأمر: <code>php artisan migrate</code></li>
                    <li>تشغيل الأمر: <code>php artisan db:seed</code> (اختياري)</li>
                    <li>إنشاء مستخدم إدارة عبر <code>php artisan tinker</code></li>
                </ol>
            </div>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h6>منصة شاملة</h6>
                    <small>نظام منشورات وتعليقات متطور</small>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🛡️</div>
                    <h6>حماية متقدمة</h6>
                    <small>نظام حماية من الـ spam</small>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎨</div>
                    <h6>تصميم عصري</h6>
                    <small>واجهة متجاوبة مع دعم العربية</small>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h6>إدارة متطورة</h6>
                    <small>لوحة إدارة بـ Filament</small>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="/admin" class="btn-custom">
                    <i class="bi bi-shield-lock-fill me-2"></i>لوحة الإدارة
                </a>
                <a href="/posts/create" class="btn-custom">
                    <i class="bi bi-plus-circle-fill me-2"></i>أضف منشور
                </a>
            </div>
            
            <div class="mt-4">
                <small class="text-white-50">
                    <i class="bi bi-code-slash me-1"></i>
                    Laravel {{ app()->version() }} | PHP {{ phpversion() }}
                </small>
            </div>
        </div>
    </div>
</body>
</html>
