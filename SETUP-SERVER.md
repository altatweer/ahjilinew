# إعداد الخادم - احجيلي 🚀

## 📋 خطوات ما بعد النشر

### 1. 🗃️ إعداد قاعدة البيانات

```bash
# في cPanel أو phpMyAdmin، أنشئ قاعدة بيانات جديدة
# اسم قاعدة البيانات: ahjili_db (أو أي اسم تختاره)
```

### 2. ⚙️ تحرير ملف .env

```bash
# في cPanel File Manager، حرر ملف .env:
nano .env

# أو استخدم cPanel File Manager لتحرير الملف
```

**إعدادات قاعدة البيانات المطلوبة:**
```env
APP_NAME="احجيلي"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ahjili_db
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### 3. 🏗️ تشغيل الأوامر الأساسية

```bash
# في Terminal/SSH أو cPanel Terminal:
cd public_html

# تشغيل migrations
php artisan migrate --force

# إدخال البيانات الأولية (اختياري)
php artisan db:seed

# تحسين الأداء
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. 👤 إنشاء مستخدم إدارة

```bash
# في Terminal:
php artisan tinker

# أنسخ والصق هذا الكود في Tinker:
$user = App\Models\User::create([
    'username' => 'admin',
    'display_name' => 'مدير النظام',
    'email' => 'admin@yourdomain.com',
    'password' => Hash::make('admin123456'),
    'role' => 'admin',
    'is_active' => true,
    'email_verified_at' => now()
]);

echo "تم إنشاء المستخدم بنجاح!";
exit
```

### 5. ✅ اختبار الموقع

```bash
# اختبر هذه الصفحات:
https://yourdomain.com          # الصفحة الرئيسية
https://yourdomain.com/test     # صفحة اختبار سريع
https://yourdomain.com/admin    # لوحة الإدارة
```

## 🎯 روابط مهمة بعد التثبيت

- **الموقع الرئيسي:** `https://yourdomain.com`
- **لوحة الإدارة:** `https://yourdomain.com/admin`
- **صفحة اختبار:** `https://yourdomain.com/test`
- **إضافة منشور:** `https://yourdomain.com/posts/create`

## 🔐 بيانات تسجيل الدخول الافتراضية

```
اسم المستخدم: admin
كلمة المرور: admin123456
```

**⚠️ مهم: غيّر كلمة المرور فوراً بعد تسجيل الدخول!**

## 🚨 استكشاف الأخطاء

### إذا ظهر خطأ "Method Not Allowed":
```bash
# مسح cache
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### إذا ظهر خطأ قاعدة بيانات:
1. تحقق من إعدادات `.env`
2. تأكد من إنشاء قاعدة البيانات في cPanel
3. تأكد من صحة اسم المستخدم وكلمة المرور

### إذا ظهرت صفحة Index بدلاً من الموقع:
```bash
# تأكد من Document Root يشير إلى مجلد public
# أو انقل محتويات public إلى public_html
```

## 📞 الدعم

إذا واجهت أي مشاكل:
1. تحقق من ملف logs: `storage/logs/laravel.log`
2. راجع هذا الدليل مرة أخرى
3. تواصل مع الدعم التقني

---
**الموقع جاهز للاستخدام! 🎉**
