<!-- زر التثبيت العائم - مكون مشترك -->
<div id="pwa-install-floating-btn" class="pwa-install-floating" style="display: none;">
    <button type="button" class="btn btn-success rounded-circle shadow-lg" onclick="handleFloatingInstall()" title="ثبت تطبيق احجيلي">
        <i class="bi bi-download"></i>
        <span class="install-text">ثبت</span>
    </button>
</div>

<style>
    .pwa-install-floating {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 1050;
        animation: floatingBounce 2s ease-in-out infinite;
    }

    .pwa-install-floating .btn {
        width: 60px;
        height: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        border: none;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        transition: all 0.3s ease;
        padding: 0;
    }

    .pwa-install-floating .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4) !important;
        background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    }

    .pwa-install-floating .btn i {
        font-size: 18px;
        margin-bottom: 2px;
    }

    .pwa-install-floating .install-text {
        font-size: 10px;
        line-height: 1;
        color: white;
    }

    @keyframes floatingBounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    /* تعديل موضع الزر للشاشات الصغيرة */
    @media (max-width: 768px) {
        .pwa-install-floating {
            bottom: 90px;
            right: 15px;
        }
        
        .pwa-install-floating .btn {
            width: 55px;
            height: 55px;
        }
        
        .pwa-install-floating .btn i {
            font-size: 16px;
        }
        
        .install-text {
            font-size: 9px;
        }
    }

    /* إخفاء الزر عند وجود لوحة مفاتيح على الجوال */
    @media (max-height: 500px) {
        .pwa-install-floating {
            display: none !important;
        }
    }

    /* تجنب تضارب مع زر إضافة منشور على اليسار */
    .pwa-install-floating {
        right: 20px; /* على اليمين دائماً */
    }
    
    /* إذا كان هناك عناصر أخرى على اليمين، قم بتعديل الموضع */
    @media (max-width: 576px) {
        .pwa-install-floating {
            right: 15px;
            bottom: 85px; /* مساحة إضافية للجوال */
        }
    }
</style>

<script>
    // إدارة زر التثبيت العائم المشترك
    if (typeof window.pwaFloatingButtonManager === 'undefined') {
        window.pwaFloatingButtonManager = {
            floatingButtonShown: false,
            
            // إظهار الزر العائم
            showFloatingInstallButton: function() {
                const floatingBtn = document.getElementById('pwa-install-floating-btn');
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
                const isStandalone = window.navigator.standalone;
                const isInstalled = this.isAppInstalled();
                
                // عدم إظهار الزر إذا كان التطبيق مثبت
                if (isInstalled || isStandalone || this.floatingButtonShown) {
                    return;
                }
                
                console.log('📱 إظهار زر التثبيت العائم');
                
                if (floatingBtn) {
                    floatingBtn.style.display = 'block';
                    this.floatingButtonShown = true;
                    
                    // تحديث النص والأيقونة حسب النظام
                    const btnElement = floatingBtn.querySelector('.btn');
                    const iconElement = btnElement.querySelector('i');
                    const textElement = btnElement.querySelector('.install-text');
                    
                    if (isIOS) {
                        iconElement.className = 'bi bi-plus-square';
                        textElement.textContent = 'أضف';
                        btnElement.title = 'أضف إلى الشاشة الرئيسية';
                    } else {
                        iconElement.className = 'bi bi-download';
                        textElement.textContent = 'ثبت';
                        btnElement.title = 'ثبت تطبيق احجيلي';
                    }
                }
            },
            
            // إخفاء الزر العائم
            hideFloatingInstallButton: function() {
                const floatingBtn = document.getElementById('pwa-install-floating-btn');
                if (floatingBtn) {
                    floatingBtn.style.display = 'none';
                    this.floatingButtonShown = false;
                }
            },
            
            // فحص إذا كان التطبيق مثبت
            isAppInstalled: function() {
                // فحص متعدد للتأكد من حالة التثبيت
                const isStandalone = window.navigator.standalone;
                const isPWADisplayMode = window.matchMedia('(display-mode: standalone)').matches;
                const hasBeenInstalled = localStorage.getItem('pwa-installed') === 'true';
                
                return isStandalone || isPWADisplayMode || hasBeenInstalled;
            },
            
            // تشغيل toast
            showToast: function(message, type = 'info') {
                if (typeof showToast === 'function') {
                    showToast(message, type);
                } else {
                    console.log(`Toast (${type}): ${message}`);
                }
            },
            
            // تهيئة الزر
            init: function() {
                // إظهار الزر بعد تحميل الصفحة
                setTimeout(() => {
                    if (!this.isAppInstalled() && !window.navigator.standalone) {
                        this.showFloatingInstallButton();
                    }
                }, 5000);
                
                // إخفاء الزر عند التثبيت
                window.addEventListener('appinstalled', () => {
                    console.log('✅ تم تثبيت التطبيق - إخفاء الزر العائم');
                    this.hideFloatingInstallButton();
                    this.showToast('تم تثبيت احجيلي بنجاح! 🎉', 'success');
                    localStorage.setItem('pwa-installed', 'true');
                });
                
                // التحقق الدوري من حالة التثبيت
                setInterval(() => {
                    const isInstalled = this.isAppInstalled();
                    const isStandalone = window.navigator.standalone;
                    
                    if ((isInstalled || isStandalone) && this.floatingButtonShown) {
                        this.hideFloatingInstallButton();
                    } else if (!isInstalled && !isStandalone && !this.floatingButtonShown) {
                        this.showFloatingInstallButton();
                    }
                }, 10000); // فحص كل 10 ثواني
            }
        };
        
        // فحص المتصفحات الداخلية لتطبيقات التواصل الاجتماعي
        function detectInAppBrowser() {
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;
            
            // فحص التطبيقات الشائعة
            const inAppBrowsers = {
                instagram: /Instagram/i.test(userAgent),
                facebook: /FBAN|FBAV|FB_IAB/i.test(userAgent),
                twitter: /Twitter/i.test(userAgent),
                tiktok: /TikTok/i.test(userAgent),
                snapchat: /Snapchat/i.test(userAgent),
                linkedin: /LinkedInApp/i.test(userAgent),
                telegram: /Telegram/i.test(userAgent),
                whatsapp: /WhatsApp/i.test(userAgent),
                pinterest: /Pinterest/i.test(userAgent),
                reddit: /RedditClient/i.test(userAgent),
                wechat: /MicroMessenger/i.test(userAgent),
                line: /Line/i.test(userAgent),
                // فحص عام للمتصفحات الداخلية
                webview: /WebView|(iPhone|iPod|iPad)(?!.*Safari)|Android.*(wv|\.0\.0\.0)/i.test(userAgent)
            };
            
            // العثور على التطبيق المحدد
            for (const [app, detected] of Object.entries(inAppBrowsers)) {
                if (detected && app !== 'webview') {
                    return { isInApp: true, app: app, displayName: getAppDisplayName(app) };
                }
            }
            
            // فحص WebView عام
            if (inAppBrowsers.webview) {
                return { isInApp: true, app: 'webview', displayName: 'التطبيق' };
            }
            
            return { isInApp: false, app: null, displayName: null };
        }
        
        // أسماء التطبيقات للعرض
        function getAppDisplayName(app) {
            const names = {
                instagram: 'Instagram',
                facebook: 'Facebook',
                twitter: 'Twitter',
                tiktok: 'TikTok',
                snapchat: 'Snapchat',
                linkedin: 'LinkedIn',
                telegram: 'Telegram',
                whatsapp: 'WhatsApp',
                pinterest: 'Pinterest',
                reddit: 'Reddit',
                wechat: 'WeChat',
                line: 'LINE'
            };
            return names[app] || 'التطبيق';
        }
        
        // مودال لفتح المتصفح الخارجي
        function showOpenInBrowserModal(appName = 'التطبيق') {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const currentUrl = window.location.href;
            
            const modalHtml = `
                <div class="modal fade" id="openInBrowserModal" tabindex="-1" style="z-index: 1055;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px; border: none;">
                            <div class="modal-header border-0 text-center">
                                <div class="w-100">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚀</div>
                                    <h5 class="modal-title">ثبت تطبيق احجيلي</h5>
                                    <p class="text-muted mb-0">للحصول على أفضل تجربة</p>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="alert alert-warning" style="border-radius: 10px;">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>أنت تتصفح من داخل ${appName}</strong><br>
                                    <small>المتصفحات الداخلية لا تدعم تثبيت التطبيقات</small>
                                </div>
                                
                                <div class="mb-4">
                                    <h6 class="mb-3">💡 لتثبيت التطبيق، تحتاج لفتح الرابط في:</h6>
                                    <div class="row g-2">
                                        ${isIOS ? `
                                        <div class="col-6">
                                            <div class="card border-primary" style="cursor: pointer;" onclick="openInSafari()">
                                                <div class="card-body text-center py-3">
                                                    <div style="font-size: 2rem;">🧭</div>
                                                    <div><strong>Safari</strong></div>
                                                    <small class="text-muted">الأفضل لـ iOS</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card border-success" style="cursor: pointer;" onclick="openInChrome()">
                                                <div class="card-body text-center py-3">
                                                    <div style="font-size: 2rem;">🌐</div>
                                                    <div><strong>Chrome</strong></div>
                                                    <small class="text-muted">متصفح بديل</small>
                                                </div>
                                            </div>
                                        </div>
                                        ` : `
                                        <div class="col-6">
                                            <div class="card border-success" style="cursor: pointer;" onclick="openInChrome()">
                                                <div class="card-body text-center py-3">
                                                    <div style="font-size: 2rem;">🌐</div>
                                                    <div><strong>Chrome</strong></div>
                                                    <small class="text-muted">الأفضل لـ Android</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="card border-info" style="cursor: pointer;" onclick="openInFirefox()">
                                                <div class="card-body text-center py-3">
                                                    <div style="font-size: 2rem;">🦊</div>
                                                    <div><strong>Firefox</strong></div>
                                                    <small class="text-muted">متصفح بديل</small>
                                                </div>
                                            </div>
                                        </div>
                                        `}
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>أو انسخ الرابط:</strong></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="urlToCopy" value="${currentUrl}" readonly>
                                        <button class="btn btn-outline-primary" type="button" onclick="copyUrlToClipboard()">
                                            <i class="bi bi-clipboard"></i> نسخ
                                        </button>
                                    </div>
                                </div>
                                
                                ${isIOS ? `
                                <div class="alert alert-info" style="border-radius: 10px;">
                                    <strong>📱 طريقة سريعة لـ iOS:</strong><br>
                                    اضغط <span class="badge bg-primary">⋯</span> في ${appName} ← اختر "فتح في Safari"
                                </div>
                                ` : `
                                <div class="alert alert-info" style="border-radius: 10px;">
                                    <strong>📱 طريقة سريعة لـ Android:</strong><br>
                                    اضغط <span class="badge bg-primary">⋮</span> في ${appName} ← اختر "فتح في Chrome"
                                </div>
                                `}
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    ربما لاحقاً
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // إزالة المودال السابق إن وجد
            const existingModal = document.getElementById('openInBrowserModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // إضافة المودال الجديد
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // إظهار المودال
            const modal = new bootstrap.Modal(document.getElementById('openInBrowserModal'));
            modal.show();
            
            // إزالة المودال بعد الإغلاق
            document.getElementById('openInBrowserModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }
        
        // فتح في Safari (iOS)
        window.openInSafari = function() {
            const currentUrl = window.location.href;
            // محاولة فتح في Safari
            window.location.href = currentUrl.replace(/^https?:\/\//, 'x-web-search://');
            // fallback
            setTimeout(() => {
                copyUrlToClipboard();
                alert('تم نسخ الرابط! الصق الرابط في Safari لتثبيت التطبيق');
            }, 1000);
        };
        
        // فتح في Chrome
        window.openInChrome = function() {
            const currentUrl = window.location.href;
            // محاولة فتح في Chrome
            const chromeUrl = 'googlechrome://' + currentUrl.replace(/^https?:\/\//, '');
            window.location.href = chromeUrl;
            // fallback
            setTimeout(() => {
                copyUrlToClipboard();
                alert('تم نسخ الرابط! الصق الرابط في Chrome لتثبيت التطبيق');
            }, 1000);
        };
        
        // فتح في Firefox  
        window.openInFirefox = function() {
            const currentUrl = window.location.href;
            // محاولة فتح في Firefox
            const firefoxUrl = 'firefox://' + currentUrl.replace(/^https?:\/\//, '');
            window.location.href = firefoxUrl;
            // fallback
            setTimeout(() => {
                copyUrlToClipboard();
                alert('تم نسخ الرابط! الصق الرابط في Firefox لتثبيت التطبيق');
            }, 1000);
        };
        
        // نسخ الرابط
        window.copyUrlToClipboard = function() {
            const urlInput = document.getElementById('urlToCopy');
            if (urlInput) {
                urlInput.select();
                document.execCommand('copy');
                
                // تحديث نص الزر
                const copyBtn = urlInput.nextElementSibling;
                const originalText = copyBtn.innerHTML;
                copyBtn.innerHTML = '<i class="bi bi-check"></i> تم النسخ!';
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-success');
                
                // إعادة النص الأصلي بعد ثانيتين
                setTimeout(() => {
                    copyBtn.innerHTML = originalText;
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-primary');
                }, 2000);
                
                // إظهار toast
                if (typeof showToast === 'function') {
                    showToast('تم نسخ الرابط! الصق في المتصفح الرئيسي', 'success');
                }
            }
        };
        
        // التعامل مع النقر على الزر العائم
        window.handleFloatingInstall = function() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const browserInfo = detectInAppBrowser();
            
            console.log('🎯 النقر على زر التثبيت العائم', {
                isIOS,
                browserInfo
            });
            
            // إذا كان في متصفح داخلي لتطبيق
            if (browserInfo.isInApp) {
                console.log(`🚨 متصفح داخلي مكتشف: ${browserInfo.displayName}`);
                showOpenInBrowserModal(browserInfo.displayName);
                return;
            }
            
            // إذا كان iOS وفي متصفح عادي
            if (isIOS) {
                // إظهار تعليمات iOS
                if (typeof showiOSInstallModal === 'function') {
                    showiOSInstallModal();
                } else {
                    showIOSInstructions();
                }
            } else {
                // Android وأجهزة أخرى
                if (typeof deferredPrompt !== 'undefined' && deferredPrompt) {
                    if (typeof installPWA === 'function') {
                        installPWA();
                    } else {
                        deferredPrompt.prompt();
                    }
                } else {
                    if (typeof showInstallPromotionModal === 'function') {
                        showInstallPromotionModal();
                    } else {
                        showAndroidInstructions();
                    }
                }
            }
        };
        
        // تعليمات iOS بسيطة
        function showIOSInstructions() {
            window.pwaFloatingButtonManager.showToast('للتثبيت: اضغط زر المشاركة ثم "إضافة إلى الشاشة الرئيسية"', 'info');
        }
        
        // تعليمات Android بسيطة
        function showAndroidInstructions() {
            window.pwaFloatingButtonManager.showToast('للتثبيت: ابحث عن خيار "إضافة إلى الشاشة الرئيسية" في قائمة المتصفح', 'info');
        }
        
        // تشغيل المدير عند تحميل الصفحة
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                window.pwaFloatingButtonManager.init();
            });
        } else {
            window.pwaFloatingButtonManager.init();
        }
    }
</script>
