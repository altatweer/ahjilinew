// احجيلي PWA Service Worker
// إصدار 1.0.0

const CACHE_NAME = 'ahjili-v1.0.0';
const OFFLINE_URL = '/offline.html';
const API_CACHE_NAME = 'ahjili-api-v1.0.0';

// الملفات الأساسية للتطبيق
const CORE_FILES = [
  '/',
  '/offline.html',
  '/css/app.css',
  '/js/app.js',
  '/images/logo.png',
  '/manifest.json',
  // Bootstrap RTL
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
  // Bootstrap Icons
  'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css',
  // الخطوط العربية
  'https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap'
];

// الصفحات المهمة
const IMPORTANT_PAGES = [
  '/posts/create',
  '/login',
  '/register',
  '/about',
  '/contact'
];

// تثبيت Service Worker
self.addEventListener('install', event => {
  console.log('🔧 تثبيت Service Worker...');
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('📦 حفظ الملفات الأساسية...');
        return cache.addAll(CORE_FILES);
      })
      .then(() => {
        console.log('✅ تم تثبيت Service Worker بنجاح!');
        // تفعيل Service Worker فوراً
        return self.skipWaiting();
      })
      .catch(error => {
        console.error('❌ خطأ في تثبيت Service Worker:', error);
      })
  );
});

// تنشيط Service Worker
self.addEventListener('activate', event => {
  console.log('🚀 تنشيط Service Worker...');
  
  event.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            // حذف الكاش القديم
            if (cacheName !== CACHE_NAME && cacheName !== API_CACHE_NAME) {
              console.log('🗑️ حذف كاش قديم:', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        console.log('✅ تم تنشيط Service Worker بنجاح!');
        // السيطرة على جميع التابات المفتوحة
        return self.clients.claim();
      })
  );
});

// التعامل مع الطلبات (استراتيجية الكاش)
self.addEventListener('fetch', event => {
  const { request } = event;
  const url = new URL(request.url);
  
  // تجاهل طلبات غير HTTP
  if (!request.url.startsWith('http')) {
    return;
  }
  
  // استراتيجية مختلفة لكل نوع طلب
  if (request.destination === 'document') {
    // صفحات HTML - Network First with Cache Fallback
    event.respondWith(handleDocumentRequest(request));
  } else if (request.url.includes('/api/') || request.url.includes('/posts')) {
    // طلبات API - Network First with Cache
    event.respondWith(handleApiRequest(request));
  } else if (request.destination === 'image') {
    // الصور - Cache First
    event.respondWith(handleImageRequest(request));
  } else {
    // باقي الملفات - Cache First with Network Fallback
    event.respondWith(handleStaticRequest(request));
  }
});

// التعامل مع طلبات الصفحات
async function handleDocumentRequest(request) {
  try {
    // محاولة الحصول على الصفحة من الشبكة أولاً
    const response = await fetch(request);
    
    // إذا نجحت، احفظها في الكاش
    if (response.status === 200) {
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.log('🌐 لا يوجد إنترنت، البحث في الكاش...');
    
    // البحث في الكاش
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      return cachedResponse;
    }
    
    // إذا لم توجد في الكاش، عرض صفحة offline
    console.log('📄 عرض صفحة عدم الاتصال...');
    return caches.match(OFFLINE_URL);
  }
}

// التعامل مع طلبات API
async function handleApiRequest(request) {
  try {
    const response = await fetch(request);
    
    // حفظ البيانات المهمة في كاش API
    if (response.status === 200 && request.method === 'GET') {
      const cache = await caches.open(API_CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    // في حالة عدم وجود إنترنت، استخدم الكاش
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
      console.log('📦 استخدام بيانات محفوظة:', request.url);
      return cachedResponse;
    }
    
    // إرجاع رسالة خطأ JSON
    return new Response(
      JSON.stringify({
        error: 'لا يوجد اتصال بالإنترنت',
        message: 'تأكد من اتصالك بالإنترنت وحاول مرة أخرى',
        offline: true
      }),
      {
        status: 503,
        headers: { 'Content-Type': 'application/json; charset=utf-8' }
      }
    );
  }
}

// التعامل مع طلبات الصور
async function handleImageRequest(request) {
  // البحث في الكاش أولاً
  const cachedResponse = await caches.match(request);
  if (cachedResponse) {
    return cachedResponse;
  }
  
  try {
    // تحميل الصورة من الشبكة
    const response = await fetch(request);
    
    if (response.status === 200) {
      // حفظ الصورة في الكاش
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    // في حالة الفشل، إرجاع صورة placeholder
    console.log('🖼️ فشل تحميل الصورة:', request.url);
    return new Response(
      '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="#ddd"><rect width="100%" height="100%" fill="#f8f9fa"/><text x="50%" y="50%" text-anchor="middle" dy=".3em" font-family="Arial" font-size="14" fill="#6c757d">صورة غير متاحة</text></svg>',
      { headers: { 'Content-Type': 'image/svg+xml' } }
    );
  }
}

// التعامل مع الملفات الثابتة
async function handleStaticRequest(request) {
  // البحث في الكاش أولاً
  const cachedResponse = await caches.match(request);
  if (cachedResponse) {
    return cachedResponse;
  }
  
  try {
    // تحميل الملف من الشبكة
    const response = await fetch(request);
    
    if (response.status === 200) {
      // حفظ الملف في الكاش
      const cache = await caches.open(CACHE_NAME);
      cache.put(request, response.clone());
    }
    
    return response;
  } catch (error) {
    console.log('📁 فشل تحميل الملف:', request.url);
    throw error;
  }
}

// إشعارات Push (سيتم تطويرها لاحقاً)
self.addEventListener('push', event => {
  console.log('🔔 وصل إشعار جديد:', event);
  
  const options = {
    body: event.data ? event.data.text() : 'إشعار جديد من احجيلي',
    icon: '/images/pwa/icon-192x192.png',
    badge: '/images/pwa/badge-72x72.png',
    vibrate: [200, 100, 200],
    data: {
      url: '/'
    },
    actions: [
      {
        action: 'open',
        title: 'فتح'
      },
      {
        action: 'close',
        title: 'إغلاق'
      }
    ]
  };
  
  event.waitUntil(
    self.registration.showNotification('احجيلي', options)
  );
});

// النقر على الإشعار
self.addEventListener('notificationclick', event => {
  event.notification.close();
  
  if (event.action === 'open' || !event.action) {
    event.waitUntil(
      clients.openWindow(event.notification.data.url || '/')
    );
  }
});

// رسائل من الموقع الرئيسي
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
  
  if (event.data && event.data.type === 'GET_VERSION') {
    event.ports[0].postMessage({ version: CACHE_NAME });
  }
});

// تنظيف الكاش الزائد (تشغيل كل 6 ساعات)
setInterval(() => {
  console.log('🧹 تنظيف الكاش القديم...');
  
  caches.open(API_CACHE_NAME).then(cache => {
    cache.keys().then(requests => {
      requests.forEach(request => {
        cache.match(request).then(response => {
          if (response) {
            const responseDate = new Date(response.headers.get('date'));
            const now = new Date();
            
            // حذف البيانات الأقدم من 24 ساعة
            if (now - responseDate > 24 * 60 * 60 * 1000) {
              cache.delete(request);
              console.log('🗑️ تم حذف:', request.url);
            }
          }
        });
      });
    });
  });
}, 6 * 60 * 60 * 1000); // 6 ساعات

console.log('🎉 احجيلي PWA Service Worker جاهز للعمل!');
