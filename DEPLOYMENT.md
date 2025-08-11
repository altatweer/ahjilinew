# دليل النشر السريع - احجيلي 🚀

## 📦 النشر المباشر على الخادم (بدون npm)

المشروع جاهز للنشر المباشر! جميع الـ assets مبنية ومضمنة في الـ repository.

### 1. 📥 تحميل المشروع

```bash
# على الخادم
git clone https://github.com/altatweer/ahjilinew.git
cd ahjilinew
```

### 2. ⚙️ إعداد البيئة

```bash
# نسخ ملف البيئة
cp .env.example .env

# تحرير إعدادات قاعدة البيانات
nano .env
```

### 3. 🎛️ إعدادات قاعدة البيانات في `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ahjili_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. 📚 تثبيت Dependencies

```bash
# تثبيت Composer dependencies فقط
composer install --no-dev --optimize-autoloader

# توليد مفتاح التطبيق
php artisan key:generate
```

### 5. 🗃️ إعداد قاعدة البيانات

```bash
# إنشاء الجداول
php artisan migrate

# إدخال البيانات الأولية (اختياري)
php artisan db:seed
```

### 6. 🔐 إعدادات الأمان

```bash
# ربط مجلد التخزين
php artisan storage:link

# تحسين الكاش
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. 📁 صلاحيات المجلدات

```bash
# إعطاء صلاحيات للمجلدات المطلوبة
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🌐 إعداد Apache/Nginx

### Apache Virtual Host

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/ahjilinew/public
    
    <Directory /path/to/ahjilinew/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/ahjilinew/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🎯 مميزات النشر السريع

### ✅ المزايا:
- 🚀 **لا حاجة لـ npm** - جميع الـ assets جاهزة
- ⚡ **نشر سريع** - خطوات قليلة فقط
- 🛡️ **محسّن للإنتاج** - ملفات مضغوطة ومحسنة
- 📦 **حجم صغير** - ملفات مبنية بكفاءة

### 📊 ملفات الـ Assets المضمنة:
- ✅ `public/build/assets/app-*.css` (84.80 KB)
- ✅ `public/build/assets/app-*.js` (35.48 KB)  
- ✅ `public/build/manifest.json`

## 🔧 إعدادات إضافية

### إنشاء مستخدم إدارة:

```bash
php artisan tinker

# في Tinker console:
$user = App\Models\User::create([
    'username' => 'admin',
    'display_name' => 'مدير النظام',
    'email' => 'admin@ahjili.com',
    'password' => Hash::make('your_secure_password'),
    'role' => 'admin',
    'is_active' => true,
    'email_verified_at' => now()
]);
```

### الوصول للوحة الإدارة:
- الرابط: `https://yourdomain.com/admin`
- استخدم بيانات المستخدم المُنشأ أعلاه

## 📈 تحسينات الأداء

### Opcache (PHP):
```ini
; في php.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=20000
```

### Redis Cache (اختياري):
```bash
# تثبيت Redis
sudo apt install redis-server

# في .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## 🚨 استكشاف الأخطاء

### مشاكل شائعة:

1. **خطأ 500**: تحقق من `storage/logs/laravel.log`
2. **صفحة بيضاء**: تحقق من صلاحيات `storage` و `bootstrap/cache`
3. **خطأ قاعدة البيانات**: تحقق من إعدادات `.env`

### تسجيل الأخطاء:
```bash
# مراقبة اللوج المباشر
tail -f storage/logs/laravel.log
```

## 📞 الدعم

للدعم التقني أو الاستفسارات:
- **GitHub**: [altatweer/ahjilinew](https://github.com/altatweer/ahjilinew)
- **البريد**: info@ahjili.com

---

**المشروع جاهز للعمل! 🎉**
