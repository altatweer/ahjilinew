<!-- زر التثبيت الثابت في الأسفل -->
<div id="pwa-install-floating-btn" class="pwa-install-bottom-bar" style="display: none;">
    <div class="container-fluid">
        <button type="button" class="btn btn-success w-100 shadow-lg" onclick="handleFloatingInstall()" title="ثبت تطبيق احجيلي للشاشة الرئيسية">
            <i class="bi bi-download me-2"></i>
            <span class="install-text">ثبت التطبيق على الشاشة الرئيسية</span>
        </button>
    </div>
</div>

<style>
    .pwa-install-bottom-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 1050;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding: 10px 15px;
        animation: slideUpIn 0.5s ease-out;
    }

    .pwa-install-bottom-bar .btn {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 600;
        border: none;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .pwa-install-bottom-bar .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4) !important;
        background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    }

    .pwa-install-bottom-bar .btn i {
        font-size: 18px;
    }

    .pwa-install-bottom-bar .install-text {
        font-size: 16px;
        line-height: 1;
        color: white;
        font-weight: 600;
    }

    @keyframes slideUpIn {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* تأكد من وجود padding في الأسفل للمحتوى */
    body.has-install-bar {
        padding-bottom: 80px !important;
    }

    /* تحسينات للشاشات الصغيرة */
    @media (max-width: 768px) {
        .pwa-install-bottom-bar {
            padding: 8px 10px;
        }
        
        .pwa-install-bottom-bar .btn {
            height: 45px;
            font-size: 14px;
        }
        
        .pwa-install-bottom-bar .install-text {
            font-size: 14px;
        }
    }

    /* إخفاء الزر عند وجود لوحة مفاتيح على الجوال */
    @media (max-height: 500px) {
        .pwa-install-bottom-bar {
            display: none !important;
        }
    }


</style>

<script>
    // إدارة زر التثبيت في الأسفل المشترك
    if (typeof window.pwaFloatingButtonManager === 'undefined') {
        window.pwaFloatingButtonManager = {
            floatingButtonShown: false,
            
            // إظهار زر التثبيت في الأسفل
            showFloatingInstallButton: function() {
                const floatingBtn = document.getElementById('pwa-install-floating-btn');
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
                const isStandalone = window.navigator.standalone;
                const isInstalled = this.isAppInstalled();
                
                // عدم إظهار الزر إذا كان التطبيق مثبت
                if (isInstalled || isStandalone || this.floatingButtonShown) {
                    return;
                }
                
                console.log('📱 إظهار زر التثبيت في الأسفل');
                
                if (floatingBtn) {
                    floatingBtn.style.display = 'block';
                    document.body.classList.add('has-install-bar');
                    this.floatingButtonShown = true;
                    
                    // تحديث النص والأيقونة حسب النظام
                    const btnElement = floatingBtn.querySelector('.btn');
                    const iconElement = btnElement.querySelector('i');
                    const textElement = btnElement.querySelector('.install-text');
                    
                    if (isIOS) {
                        iconElement.className = 'bi bi-plus-square me-2';
                        textElement.textContent = 'ثبت التطبيق على الشاشة الرئيسية';
                        btnElement.title = 'ثبت تطبيق احجيلي للشاشة الرئيسية';
                    } else {
                        iconElement.className = 'bi bi-download me-2';
                        textElement.textContent = 'ثبت التطبيق على الشاشة الرئيسية';
                        btnElement.title = 'ثبت تطبيق احجيلي للشاشة الرئيسية';
                    }
                }
            },
            
            // إخفاء الزر السفلي
            hideFloatingInstallButton: function() {
                const floatingBtn = document.getElementById('pwa-install-floating-btn');
                if (floatingBtn) {
                    floatingBtn.style.display = 'none';
                    document.body.classList.remove('has-install-bar');
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
                                    اضغط <span class="badge bg-primary">⋯</span> أو <span class="badge bg-primary">⬆️</span> في ${appName} ← اختر "فتح في Safari"<br>
                                    <small>أو انسخ الرابط والصقه في Safari مباشرة</small>
                                </div>
                                ` : `
                                <div class="alert alert-info" style="border-radius: 10px;">
                                    <strong>📱 طريقة سريعة لـ Android:</strong><br>
                                    اضغط <span class="badge bg-primary">⋮</span> أو <span class="badge bg-primary">⋯</span> في ${appName} ← اختر "فتح في Chrome"<br>
                                    <small>أو انسخ الرابط والصقه في Chrome مباشرة</small>
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
            
            // نسخ الرابط فوراً
            copyUrlToClipboard();
            
            // إظهار تعليمات واضحة للمستخدم
            const instructionsModal = `
                <div class="modal fade" id="safariInstructionsModal" tabindex="-1" style="z-index: 1060;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <div class="modal-header border-0 text-center">
                                <div class="w-100">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">🧭</div>
                                    <h5 class="modal-title">فتح في Safari</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success text-center">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>تم نسخ الرابط بنجاح!</strong>
                                </div>
                                
                                <h6 class="mb-3 text-center">اتبع هذه الخطوات:</h6>
                                
                                <div class="step-by-step">
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #007AFF;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary rounded-pill me-2">1</span>
                                            <strong>اضغط على زر المشاركة في Instagram</strong>
                                        </div>
                                        <small class="text-muted">الزر الذي يبدو مثل: <span style="font-size: 1.2em;">⬆️</span> أو <span style="font-size: 1.2em;">📤</span></small>
                                    </div>
                                    
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #28A745;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-success rounded-pill me-2">2</span>
                                            <strong>اختر "فتح في Safari"</strong>
                                        </div>
                                        <small class="text-muted">أو "Copy Link" ثم افتح Safari واللصق</small>
                                    </div>
                                    
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #FFC107;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning rounded-pill me-2">3</span>
                                            <strong>إذا لم تجد "فتح في Safari":</strong>
                                        </div>
                                        <small class="text-muted">افتح Safari → الصق الرابط المنسوخ → اضغط Enter</small>
                                    </div>
                                    
                                    <div class="step p-3" style="background: #e7f3ff; border-radius: 10px; border-left: 4px solid #0066CC;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info rounded-pill me-2">4</span>
                                            <strong>ثبت التطبيق من Safari</strong>
                                        </div>
                                        <small class="text-muted">اضغط زر "ثبت التطبيق" → سيعمل بنجاح! 🎉</small>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary" onclick="openSafariDirectly()">
                                        <i class="bi bi-safari me-2"></i>جرب فتح Safari مباشرة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // إزالة المودال السابق إن وجد
            const existingModal = document.getElementById('safariInstructionsModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // إضافة المودال الجديد
            document.body.insertAdjacentHTML('beforeend', instructionsModal);
            
            // إغلاق المودال السابق
            const browserModal = bootstrap.Modal.getInstance(document.getElementById('openInBrowserModal'));
            if (browserModal) {
                browserModal.hide();
            }
            
            // إظهار مودال التعليمات
            const instructModal = new bootstrap.Modal(document.getElementById('safariInstructionsModal'));
            instructModal.show();
            
            // إزالة المودال بعد الإغلاق
            document.getElementById('safariInstructionsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        };
        
        // فتح Safari مباشرة (محاولة أخرى)
        window.openSafariDirectly = function() {
            const currentUrl = window.location.href;
            
            // محاولة عدة طرق لفتح Safari
            const safariSchemes = [
                currentUrl, // URL عادي
                'safari://' + currentUrl.replace(/^https?:\/\//, ''), // Safari scheme
                'https://safari.com' // fallback
            ];
            
            // محاولة الطريقة الأولى
            try {
                window.open(currentUrl, '_blank');
            } catch (e) {
                copyUrlToClipboard();
                alert('الرجاء فتح Safari يدوياً والصق الرابط المنسوخ');
            }
        };
        
        // فتح في Chrome
        window.openInChrome = function() {
            const currentUrl = window.location.href;
            
            // نسخ الرابط فوراً
            copyUrlToClipboard();
            
            // إظهار تعليمات Chrome
            const chromeInstructionsModal = `
                <div class="modal fade" id="chromeInstructionsModal" tabindex="-1" style="z-index: 1060;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 15px;">
                            <div class="modal-header border-0 text-center">
                                <div class="w-100">
                                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌐</div>
                                    <h5 class="modal-title">فتح في Chrome</h5>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-success text-center">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>تم نسخ الرابط بنجاح!</strong>
                                </div>
                                
                                <h6 class="mb-3 text-center">اتبع هذه الخطوات:</h6>
                                
                                <div class="step-by-step">
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #4285F4;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-primary rounded-pill me-2">1</span>
                                            <strong>اضغط على قائمة التطبيق (⋮ أو ⋯)</strong>
                                        </div>
                                        <small class="text-muted">عادة في الزاوية العلوية</small>
                                    </div>
                                    
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #28A745;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-success rounded-pill me-2">2</span>
                                            <strong>اختر "فتح في Chrome" أو "Open in Chrome"</strong>
                                        </div>
                                        <small class="text-muted">أو "فتح في متصفح خارجي"</small>
                                    </div>
                                    
                                    <div class="step mb-3 p-3" style="background: #f8f9fa; border-radius: 10px; border-left: 4px solid #FFC107;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-warning rounded-pill me-2">3</span>
                                            <strong>إذا لم تجد الخيار:</strong>
                                        </div>
                                        <small class="text-muted">افتح Chrome → الصق الرابط → اضغط Enter</small>
                                    </div>
                                    
                                    <div class="step p-3" style="background: #e7f3ff; border-radius: 10px; border-left: 4px solid #0066CC;">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge bg-info rounded-pill me-2">4</span>
                                            <strong>ثبت التطبيق من Chrome</strong>
                                        </div>
                                        <small class="text-muted">اضغط زر "ثبت التطبيق" → سيعمل بنجاح! 🎉</small>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-success" onclick="openChromeDirectly()">
                                        <i class="bi bi-google me-2"></i>جرب فتح Chrome مباشرة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // إزالة المودال السابق إن وجد
            const existingModal = document.getElementById('chromeInstructionsModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // إضافة المودال الجديد
            document.body.insertAdjacentHTML('beforeend', chromeInstructionsModal);
            
            // إغلاق المودال السابق
            const browserModal = bootstrap.Modal.getInstance(document.getElementById('openInBrowserModal'));
            if (browserModal) {
                browserModal.hide();
            }
            
            // إظهار مودال التعليمات
            const instructModal = new bootstrap.Modal(document.getElementById('chromeInstructionsModal'));
            instructModal.show();
            
            // إزالة المودال بعد الإغلاق
            document.getElementById('chromeInstructionsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        };
        
        // فتح Chrome مباشرة (محاولة أخرى)
        window.openChromeDirectly = function() {
            const currentUrl = window.location.href;
            
            // محاولة فتح Chrome بطرق مختلفة
            try {
                // محاولة URL scheme للـ Chrome
                const chromeUrl = 'googlechrome://navigate?url=' + encodeURIComponent(currentUrl);
                window.location.href = chromeUrl;
                
                // fallback بعد ثانية واحدة
                setTimeout(() => {
                    // إذا لم يعمل، جرب طريقة أخرى
                    window.open(currentUrl, '_blank');
                }, 1000);
            } catch (e) {
                copyUrlToClipboard();
                alert('الرجاء فتح Chrome يدوياً والصق الرابط المنسوخ');
            }
        };
        
        // فتح في Firefox  
        window.openInFirefox = function() {
            const currentUrl = window.location.href;
            
            // نسخ الرابط فوراً
            copyUrlToClipboard();
            
            // عرض رسالة بسيطة للـ Firefox (أقل شيوعاً)
            if (typeof showToast === 'function') {
                showToast('تم نسخ الرابط! افتح Firefox والصق الرابط للتثبيت', 'info');
            } else {
                alert('تم نسخ الرابط! افتح Firefox والصق الرابط للتثبيت');
            }
            
            // محاولة فتح Firefox (قد لا تعمل دائماً)
            try {
                window.open(currentUrl, '_blank');
            } catch (e) {
                // تم التعامل معها بالرسالة أعلاه
            }
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
                // إظهار تعليمات iOS (الآن يظهر عند النقر فقط)
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
