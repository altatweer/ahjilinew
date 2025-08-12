// إنشاء أيقونات PNG للPWA
const fs = require('fs');
const path = require('path');

// إنشاء canvas لرسم الأيقونات
function createIcon(size, text = 'احجيلي') {
    // نستخدم SVG بدلاً من Canvas للبساطة
    const svgContent = `
<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 ${size} ${size}">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#5C7D99"/>
      <stop offset="100%" style="stop-color:#4A6A85"/>
    </linearGradient>
  </defs>
  <rect width="${size}" height="${size}" rx="${size * 0.15}" fill="url(#bg)"/>
  <text x="${size/2}" y="${size * 0.65}" text-anchor="middle" fill="white" 
        font-family="Arial, sans-serif" font-size="${size * 0.15}" font-weight="bold">${text}</text>
  <circle cx="${size/2}" cy="${size * 0.35}" r="${size * 0.13}" fill="rgba(255,255,255,0.2)"/>
  <text x="${size/2}" y="${size * 0.4}" text-anchor="middle" fill="white" 
        font-family="Arial, sans-serif" font-size="${size * 0.13}" font-weight="bold">ح</text>
</svg>`;
    
    return svgContent;
}

// الأحجام المطلوبة
const sizes = [16, 32, 72, 96, 128, 144, 152, 180, 192, 384, 512];

// إنشاء مجلد الأيقونات
const iconsDir = path.join(__dirname, 'public', 'images', 'pwa');
if (!fs.existsSync(iconsDir)) {
    fs.mkdirSync(iconsDir, { recursive: true });
}

// إنشاء الأيقونات
sizes.forEach(size => {
    const svgContent = createIcon(size);
    const filename = `icon-${size}x${size}.svg`;
    const filepath = path.join(iconsDir, filename);
    
    fs.writeFileSync(filepath, svgContent);
    console.log(`✅ تم إنشاء ${filename}`);
});

// إنشاء أيقونات خاصة
const specialIcons = [
    { size: 72, name: 'badge-72x72.svg', text: '🔔' },
    { size: 192, name: 'shortcut-new-post.svg', text: '✏️' },
    { size: 192, name: 'shortcut-search.svg', text: '🔍' }
];

specialIcons.forEach(({ size, name, text }) => {
    const svgContent = createIcon(size, text);
    const filepath = path.join(iconsDir, name);
    
    fs.writeFileSync(filepath, svgContent);
    console.log(`✅ تم إنشاء ${name}`);
});

console.log('🎉 تم إنشاء جميع الأيقونات بنجاح!');
console.log('📝 ملاحظة: هذه أيقونات SVG مؤقتة - للحصول على PNG حقيقي، استخدم أدوات التحويل online');
