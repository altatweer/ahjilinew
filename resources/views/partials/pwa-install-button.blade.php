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
        
        // التعامل مع النقر على الزر العائم
        window.handleFloatingInstall = function() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isInAppBrowser = /WebView|(iPhone|iPod|iPad)(?!.*Safari)/i.test(navigator.userAgent);
            
            console.log('🎯 النقر على زر التثبيت العائم');
            
            if (isIOS) {
                if (isInAppBrowser) {
                    window.pwaFloatingButtonManager.showToast('للتثبيت: افتح الموقع في Safari مباشرة', 'warning');
                    return;
                }
                
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
