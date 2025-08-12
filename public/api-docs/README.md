# 📱 Ahjili API Documentation Package للمطور

## 🎯 محتويات الحزمة

هذه الحزمة تحتوي على كل ما يحتاجه مطور Flutter لتطوير تطبيق احجيلي:

### 📄 الملفات المتوفرة:

1. **`index.html`** - توثيق تفاعلي شامل (HTML/CSS/JS)
2. **`app-design.html`** - تصميم التطبيق التفاعلي (4 شاشات كاملة)
3. **`postman-collection.json`** - مجموعة Postman للاختبار
4. **`flutter-examples.md`** - أمثلة كود Flutter كاملة
5. **`README.md`** - هذا الملف (دليل سريع)

---

## 🚀 كيفية الاستخدام

### للمطور:

#### 1. **افتح التوثيق التفاعلي**
```
https://ahjili.com/api-docs
```
أو محلياً:
```
http://127.0.0.1:8000/api-docs
```

#### 1.1 **شاهد تصميم التطبيق**
```
https://ahjili.com/app-design
```
أو محلياً:
```
http://127.0.0.1:8000/app-design
```
📱 **4 شاشات تفاعلية كاملة**: الرئيسية، تفاصيل المنشور، إنشاء منشور، الملف الشخصي

#### 2. **استيراد Postman Collection**
- افتح Postman
- اختر Import
- ارفع ملف `postman-collection.json`
- اضبط المتغيرات:
  - `base_url`: `https://ahjili.com/api`
  - `auth_token`: (سيتم ملؤه بعد Login)

#### 3. **استخدم أمثلة Flutter**
- افتح `flutter-examples.md`
- انسخ الكود المطلوب
- اتبع البنية المقترحة للمشروع

---

## 🔑 معلومات سريعة للاختبار

### 🔐 بيانات تسجيل دخول تجريبية:
```json
{
  "username": "admin",
  "password": "10stor89AS"
}
```

### 🌐 الرابط الأساسي:
```
https://ahjili.com/api
```

### 📋 العمليات الأساسية:

#### تسجيل دخول:
```http
POST /auth/login
Content-Type: application/json

{
  "username": "admin", 
  "password": "10stor89AS"
}
```

#### جلب المنشورات:
```http
GET /posts?page=1&category=all
```

#### إنشاء منشور:
```http
POST /posts
Authorization: Bearer {token}
Content-Type: multipart/form-data

content=محتوى المنشور&category=complaint&type=community
```

---

## 📊 هيكل البيانات الأساسي

### 👤 المستخدم (User):
```typescript
{
  id: number,
  username: string,
  display_name: string,
  avatar_url?: string,
  role: 'user' | 'admin' | 'super-admin',
  account_type: 'regular' | 'verified' | 'counselor'
}
```

### 📝 المنشور (Post):
```typescript
{
  id: number,
  content: string,
  image_url?: string,
  category: 'complaint' | 'experience' | 'recommendation' | 'question' | 'review' | 'general',
  hashtags: string[],
  likes_count: number,
  comments_count: number,
  user?: User,
  is_liked: boolean
}
```

### 💬 التعليق (Comment):
```typescript
{
  id: number,
  content: string,
  likes_count: number,
  replies_count: number,
  user?: User,
  is_anonymous: boolean,
  anonymous_name?: string
}
```

---

## 🎯 الميزات المطلوبة في التطبيق

### ✅ الأساسيات:
- [x] تسجيل دخول/خروج
- [x] إنشاء حساب  
- [x] عرض المنشورات مع التصفح
- [x] إنشاء منشورات (مع صور)
- [x] التعليق والرد
- [x] الإعجاب والمشاركة
- [x] المنشورات والتعليقات المجهولة

### 🔔 الإشعارات:
- [x] Firebase Cloud Messaging
- [x] إشعارات الإعجاب
- [x] إشعارات التعليقات الجديدة
- [x] إشعارات المنشورات الجديدة

### 📱 الميزات التقنية:
- [x] العمل بدون إنترنت (Offline)
- [x] تحميل الصور وضغطها
- [x] Pull to refresh
- [x] Infinite scroll
- [x] Deep links للمنشورات
- [x] مشاركة خارجية

### 🎨 واجهة المستخدم:
- [x] تصميم RTL (العربية)
- [x] الوضع الداكن
- [x] أنيميشن سلس
- [x] تصميم متجاوب

---

## 🔧 متطلبات تقنية

### Flutter Dependencies:
```yaml
dependencies:
  http: ^1.1.0                    # HTTP requests
  provider: ^6.1.1               # State management  
  shared_preferences: ^2.2.2     # Local storage
  flutter_secure_storage: ^9.0.0 # Secure token storage
  cached_network_image: ^3.3.0   # Image caching
  image_picker: ^1.0.5           # Camera/Gallery
  firebase_messaging: ^14.7.6    # Push notifications
  permission_handler: ^11.1.0    # Permissions
```

### الحد الأدنى للدعم:
- **Android**: 5.0 (API 21)
- **iOS**: 12.0
- **Flutter**: 3.10+
- **Dart**: 3.0+

---

## 🎉 ملاحظات مهمة

### 🔒 الأمان:
- **لا تحفظ** كلمات المرور في التطبيق
- استخدم **Secure Storage** للـ tokens
- **تحقق دائماً** من صحة المدخلات
- استخدم **HTTPS** فقط

### ⚡ الأداء:
- استخدم **lazy loading** للصور
- طبق **pagination** للمنشورات
- استخدم **caching** للبيانات المكررة
- **ضغط الصور** قبل الرفع

### 🌐 تجربة المستخدم:
- **رسائل خطأ واضحة** بالعربية
- **loading states** في كل مكان
- **offline support** للمحتوى المحفوظ
- **pull to refresh** في جميع القوائم

---

## ✨ نصائح للتطوير

### 🎯 ابدأ بـ:
1. **إعداد المشروع** والـ dependencies
2. **تطبيق نظام Auth** (login/logout)
3. **عرض المنشورات** الأساسي
4. **إنشاء منشور** بسيط
5. **التفاعل** (إعجاب/تعليق)

### 🔄 ثم طور:
1. **الصور** والتحميل
2. **الإشعارات** 
3. **البحث والفلاتر**
4. **الملف الشخصي**
5. **الميزات المتقدمة**

### 🧪 واختبر:
1. **كل الأجهزة** (Android/iOS)
2. **السيناريوهات المختلفة** (no internet, etc.)
3. **الأداء** مع كمية كبيرة من البيانات
4. **الأمان** والـ validation

---

## 📱 تصميم التطبيق التفاعلي

### 🎨 **الشاشات المتوفرة:**

#### 🏠 **الشاشة الرئيسية**:
- ✅ **تبويبات الفئات** مع تصفح أفقي
- ✅ **بطاقات المنشورات** مع التفاعلات (إعجاب، تعليق، مشاركة، حفظ)
- ✅ **معلومات المستخدم** والصورة الشخصية
- ✅ **الهاشتاغات** الملونة
- ✅ **الصور** مع عرض مُحسن

#### 📄 **تفاصيل المنشور**:
- ✅ **المنشور كاملاً** مع جميع التفاصيل
- ✅ **قسم التعليقات** مع الردود
- ✅ **تفاعلات التعليقات** (إعجاب، رد)
- ✅ **تعليقات مجهولة** واضحة

#### ✏️ **إنشاء منشور**:
- ✅ **حقل النص** الكبير
- ✅ **اختيار الفئة** dropdown
- ✅ **حقل الموقع** والهاشتاغ
- ✅ **رفع الصور** مع UI واضح
- ✅ **زر النشر** بتصميم جذاب

#### 👤 **الملف الشخصي**:
- ✅ **معلومات المستخدم** مع الإحصائيات
- ✅ **قائمة الإعدادات** المنظمة
- ✅ **أيقونات واضحة** لكل خيار
- ✅ **تصميم متدرج** أنيق

### 🎮 **التفاعل:**
- 🔄 **تبديل بين الشاشات** بسهولة
- 🎯 **أزرار التفاعل** مع animations
- 📱 **تصميم responsive** لجميع الأحجام
- ✨ **تأثيرات بصرية** smooth

### 🎨 **التصميم:**
- 🎨 **ألوان متطابقة** مع الموقع الأصلي
- 📝 **خط Tajawal** للعربية
- 📱 **mobile-first** تماماً
- 🔄 **RTL** كامل للعربية

---

**🚀 جاهز للبدء؟ شاهد التصميم وافتح التوثيق!**

**[📱 شاهد تصميم التطبيق](https://ahjili.com/app-design)** | **[📖 افتح التوثيق](https://ahjili.com/api-docs)**
