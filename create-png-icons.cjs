// إنشاء أيقونات PNG عالية الجودة لاحجيلي PWA
const { createCanvas } = require('canvas');
const fs = require('fs');
const path = require('path');

// إعدادات الأيقونات
const iconSizes = [
    { size: 16, name: 'icon-16x16.png' },
    { size: 32, name: 'icon-32x32.png' },
    { size: 72, name: 'icon-72x72.png' },
    { size: 96, name: 'icon-96x96.png' },
    { size: 128, name: 'icon-128x128.png' },
    { size: 144, name: 'icon-144x144.png' },
    { size: 152, name: 'icon-152x152.png' },
    { size: 180, name: 'icon-180x180.png' },
    { size: 192, name: 'icon-192x192.png' },
    { size: 384, name: 'icon-384x384.png' },
    { size: 512, name: 'icon-512x512.png' }
];

// ألوان احجيلي
const colors = {
    primary: '#5C7D99',
    secondary: '#4A6A85',
    accent: '#ffffff',
    shadow: 'rgba(0,0,0,0.3)'
};

// إنشاء أيقونة واحدة
function createIcon(size, text = 'احجيلي') {
    const canvas = createCanvas(size, size);
    const ctx = canvas.getContext('2d');
    
    // تفعيل الـ antialiasing للجودة العالية
    ctx.antialias = 'subpixel';
    ctx.patternQuality = 'best';
    ctx.textDrawingMode = 'path';
    
    // خلفية متدرجة
    const gradient = ctx.createLinearGradient(0, 0, size, size);
    gradient.addColorStop(0, colors.primary);
    gradient.addColorStop(1, colors.secondary);
    ctx.fillStyle = gradient;
    
    // رسم مستطيل مع زوايا دائرية
    const radius = size * 0.15;
    drawRoundRect(ctx, 0, 0, size, size, radius);
    ctx.fill();
    
    // إضافة ظل داخلي للعمق
    const innerShadow = ctx.createRadialGradient(
        size * 0.3, size * 0.3, 0,
        size * 0.5, size * 0.5, size * 0.7
    );
    innerShadow.addColorStop(0, 'rgba(255,255,255,0.1)');
    innerShadow.addColorStop(1, 'rgba(0,0,0,0.1)');
    ctx.fillStyle = innerShadow;
    ctx.fill();
    
    // دائرة للرمز مع ظل
    ctx.shadowColor = colors.shadow;
    ctx.shadowBlur = size * 0.02;
    ctx.shadowOffsetX = size * 0.01;
    ctx.shadowOffsetY = size * 0.01;
    
    ctx.fillStyle = 'rgba(255,255,255,0.2)';
    ctx.beginPath();
    ctx.arc(size / 2, size * 0.35, size * 0.13, 0, 2 * Math.PI);
    ctx.fill();
    
    // إزالة الظل للنص
    ctx.shadowColor = 'transparent';
    ctx.shadowBlur = 0;
    ctx.shadowOffsetX = 0;
    ctx.shadowOffsetY = 0;
    
    // النص
    ctx.fillStyle = colors.accent;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    
    // تحديد حجم الخط وفقاً لحجم الأيقونة
    let fontSize = size * 0.15;
    let iconText = 'ح';
    
    if (size >= 128) {
        // للأيقونات الكبيرة - رمز ونص كامل
        ctx.font = `bold ${fontSize * 0.8}px Arial, sans-serif`;
        
        // رسم الرمز
        ctx.fillText(iconText, size / 2, size * 0.35);
        
        // رسم النص
        ctx.font = `bold ${fontSize}px Arial, sans-serif`;
        ctx.fillText(text, size / 2, size * 0.7);
        
    } else if (size >= 72) {
        // للأيقونات المتوسطة - رمز ونص مختصر
        ctx.font = `bold ${fontSize * 0.9}px Arial, sans-serif`;
        ctx.fillText(iconText, size / 2, size * 0.35);
        
        ctx.font = `bold ${fontSize * 0.8}px Arial, sans-serif`;
        ctx.fillText('احجيلي', size / 2, size * 0.7);
        
    } else {
        // للأيقونات الصغيرة - رمز فقط
        ctx.font = `bold ${fontSize * 1.5}px Arial, sans-serif`;
        ctx.fillText(iconText, size / 2, size / 2);
    }
    
    // إضافة ظل للنص للوضوح
    ctx.globalCompositeOperation = 'source-atop';
    ctx.shadowColor = colors.shadow;
    ctx.shadowBlur = 2;
    ctx.shadowOffsetX = 1;
    ctx.shadowOffsetY = 1;
    ctx.fill();
    
    return canvas;
}

// دالة مساعدة لحفظ الصورة
function saveIcon(canvas, filename) {
    const buffer = canvas.toBuffer('image/png');
    const filepath = path.join(__dirname, 'public', 'images', 'pwa', filename);
    fs.writeFileSync(filepath, buffer);
    return filepath;
}

// الدالة الرئيسية
async function generateAllIcons() {
    console.log('🎨 بدء إنشاء أيقونات PNG عالية الجودة...\n');
    
    // إنشاء مجلد الأيقونات إذا لم يكن موجوداً
    const iconsDir = path.join(__dirname, 'public', 'images', 'pwa');
    if (!fs.existsSync(iconsDir)) {
        fs.mkdirSync(iconsDir, { recursive: true });
        console.log('📁 تم إنشاء مجلد الأيقونات');
    }
    
    let successCount = 0;
    
    // إنشاء كل أيقونة
    for (const iconConfig of iconSizes) {
        try {
            console.log(`🖌️  إنشاء ${iconConfig.name}...`);
            
            const canvas = createIcon(iconConfig.size);
            const filepath = saveIcon(canvas, iconConfig.name);
            
            // فحص حجم الملف
            const stats = fs.statSync(filepath);
            const fileSizeKB = Math.round(stats.size / 1024);
            
            console.log(`   ✅ تم الإنشاء بنجاح (${fileSizeKB}KB)`);
            successCount++;
            
        } catch (error) {
            console.error(`   ❌ فشل في إنشاء ${iconConfig.name}:`, error.message);
        }
    }
    
    // إنشاء أيقونات خاصة
    console.log('\n🎯 إنشاء أيقونات خاصة...');
    
    const specialIcons = [
        { size: 72, name: 'badge-72x72.png', text: '🔔' },
        { size: 192, name: 'apple-touch-icon.png', text: 'احجيلي' },
        { size: 32, name: 'favicon-32x32.png', text: 'ح' },
        { size: 16, name: 'favicon-16x16.png', text: 'ح' }
    ];
    
    for (const special of specialIcons) {
        try {
            console.log(`🎨 إنشاء ${special.name}...`);
            
            let canvas;
            if (special.text.includes('🔔')) {
                // أيقونة إشعارات مخصصة
                canvas = createNotificationIcon(special.size);
            } else {
                canvas = createIcon(special.size, special.text);
            }
            
            saveIcon(canvas, special.name);
            console.log(`   ✅ تم الإنشاء بنجاح`);
            successCount++;
            
        } catch (error) {
            console.error(`   ❌ فشل في إنشاء ${special.name}:`, error.message);
        }
    }
    
    // النتائج النهائية
    console.log('\n🎉 انتهاء الإنشاء!');
    console.log(`✅ تم إنشاء ${successCount} أيقونة بنجاح`);
    console.log(`📁 المجلد: ${iconsDir}`);
    console.log('\n📋 الخطوات التالية:');
    console.log('1. ✅ manifest.json محدث لاستخدام PNG');
    console.log('2. 🚀 ارفع التحديثات إلى الخادم');
    console.log('3. 🧪 اختبر التثبيت مرة أخرى');
    
    return successCount;
}

// إنشاء أيقونة إشعارات مخصصة
function createNotificationIcon(size) {
    const canvas = createCanvas(size, size);
    const ctx = canvas.getContext('2d');
    
    // خلفية دائرية
    const gradient = ctx.createRadialGradient(
        size / 2, size / 2, 0,
        size / 2, size / 2, size / 2
    );
    gradient.addColorStop(0, '#FF6B6B');
    gradient.addColorStop(1, '#FF5252');
    ctx.fillStyle = gradient;
    
    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2 - 2, 0, 2 * Math.PI);
    ctx.fill();
    
    // رمز الجرس
    ctx.fillStyle = 'white';
    ctx.font = `bold ${size * 0.5}px Arial, sans-serif`;
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText('🔔', size / 2, size / 2);
    
    return canvas;
}

// دالة رسم مستطيل بزوايا دائرية
function drawRoundRect(ctx, x, y, width, height, radius) {
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + width - radius, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
    ctx.lineTo(x + width, y + height - radius);
    ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
    ctx.lineTo(x + radius, y + height);
    ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
}

// تشغيل المولد
if (require.main === module) {
    generateAllIcons()
        .then(count => {
            console.log(`\n🚀 تم الانتهاء! إجمالي ${count} أيقونة`);
            process.exit(0);
        })
        .catch(error => {
            console.error('❌ خطأ في الإنشاء:', error);
            process.exit(1);
        });
}

module.exports = { generateAllIcons, createIcon };
