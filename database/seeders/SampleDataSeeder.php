<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use App\Models\ContactMessage;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء منشورات تجريبية
        $posts = [
            [
                'content' => 'انتبهوا من محل الخليج للهواتف في شارع الصدر، باع لي هاتف سامسونج مقلد مع فاتورة مزورة، وحين رجعت له رفض استرداد المبلغ وقال الفاتورة ما تخصه.',
                'type' => 'anonymous',
                'status' => 'approved',
                'location' => 'baghdad',
                'hashtags' => 'نصب,احتيال,هواتف',
                'likes_count' => 25,
                'comments_count' => 8,
                'is_active' => true
            ],
            [
                'content' => 'أنصح الكل بزيارة مطعم أم علي في كربلاء، خدمة ممتازة وطعم لذيذ جداً، والأسعار معقولة والموظفين محترمين. خاصة الكباب العراقي عندهم رائع.',
                'type' => 'community',
                'status' => 'approved',
                'location' => 'karbala',
                'hashtags' => 'مطعم,توصية,كباب',
                'likes_count' => 42,
                'comments_count' => 12,
                'is_active' => true
            ],
            [
                'content' => 'محتاج تصليح تكييف في منطقة الكرادة ببغداد، صار يطفئ ويشتغل من وياه، ومحتاج تصليح سريع لأن الجو حار. مين تنصحوني؟',
                'type' => 'anonymous',
                'status' => 'approved',
                'location' => 'baghdad',
                'hashtags' => 'تكييف,تصليح,كرادة',
                'likes_count' => 15,
                'comments_count' => 6,
                'is_active' => true
            ],
            [
                'content' => 'تحذير من موقع المزادات الوهمي iraqauctions.fake - طلبوا مني 500 ألف دينار مقدم لشراء سيارة ولم يرسلوا شيء. الموقع مزيف بالكامل.',
                'type' => 'anonymous',
                'status' => 'approved',
                'location' => 'mosul',
                'hashtags' => 'نصب_إلكتروني,مزادات,تحذير',
                'likes_count' => 67,
                'comments_count' => 23,
                'is_active' => true
            ],
            [
                'content' => 'رحلتي بكرة الساعة 6 صباحاً، ومحتاج سائق يوصلني لمطار بغداد من منطقة الجادرية. مين تنصحوني؟ ضروري يكون موثوق.',
                'type' => 'anonymous',
                'status' => 'approved',
                'location' => 'baghdad',
                'hashtags' => 'مطار,توصيل,جادرية',
                'likes_count' => 8,
                'comments_count' => 15,
                'is_active' => true
            ],
            [
                'content' => 'شاركت اليوم في مبادرة تطوعية رائعة في حي السلام ببغداد لتنظيف الشوارع، كانت التجربة مميزة جداً وشعرت بالفخر للمساهمة في خدمة المجتمع.',
                'type' => 'community',
                'status' => 'approved',
                'location' => 'baghdad',
                'hashtags' => 'تطوع,تنظيف,مجتمع',
                'likes_count' => 35,
                'comments_count' => 9,
                'is_active' => true
            ]
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        // إنشاء تعليقات تجريبية
        $adminUser = \App\Models\User::where('username', 'admin')->first();
        
        $comments = [
            [
                'user_id' => $adminUser->id,
                'post_id' => 1,
                'content' => 'نفس الشي صار معي، نصبوا عليّ بنفس الطريقة!',
                'status' => 'approved',
                'likes_count' => 5,
                'is_active' => true
            ],
            [
                'user_id' => $adminUser->id,
                'post_id' => 1,
                'content' => 'شكراً للتحذير، كنت رايح أشتري منهم',
                'status' => 'approved',
                'likes_count' => 3,
                'is_active' => true
            ],
            [
                'user_id' => $adminUser->id,
                'post_id' => 2,
                'content' => 'فعلاً مطعم ممتاز، جربته الأسبوع الماضي',
                'status' => 'approved',
                'likes_count' => 8,
                'is_active' => true
            ],
            [
                'user_id' => $adminUser->id,
                'post_id' => 3,
                'content' => 'اتصل بأبو أحمد - 07901234567، ممتاز بالتكييفات',
                'status' => 'approved',
                'likes_count' => 12,
                'is_active' => true
            ],
            [
                'user_id' => $adminUser->id,
                'post_id' => 4,
                'content' => 'نفس الموقع نصب عليّ كمان! شكراً للتحذير',
                'status' => 'approved',
                'likes_count' => 15,
                'is_active' => true
            ]
        ];

        foreach ($comments as $commentData) {
            Comment::create($commentData);
        }

        // إنشاء رسائل تواصل تجريبية
        $messages = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'phone' => '07901234567',
                'subject' => 'اقتراح تحسين للموقع',
                'message' => 'أقترح إضافة خاصية التقييم بالنجوم للمحلات والخدمات',
                'type' => 'suggestion',
                'status' => 'unread',
                'ip_address' => '192.168.1.100'
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatima@example.com',
                'subject' => 'شكوى من محتوى غير لائق',
                'message' => 'يوجد منشور يحتوي على معلومات غير صحيحة عن أحد المحلات',
                'type' => 'complaint',
                'status' => 'read',
                'ip_address' => '192.168.1.101'
            ],
            [
                'name' => 'محمد حسن',
                'email' => 'mohammed@example.com',
                'phone' => '07801234567',
                'subject' => 'مشكلة تقنية',
                'message' => 'لا أستطيع رفع الصور مع المنشورات',
                'type' => 'support',
                'status' => 'replied',
                'admin_reply' => 'تم حل المشكلة، يرجى المحاولة مرة أخرى',
                'replied_at' => now(),
                'ip_address' => '192.168.1.102'
            ]
        ];

        foreach ($messages as $messageData) {
            ContactMessage::create($messageData);
        }

        $this->command->info('تم إنشاء البيانات التجريبية بنجاح:');
        $this->command->info('- 6 منشورات متنوعة');
        $this->command->info('- 5 تعليقات');
        $this->command->info('- 3 رسائل تواصل');
    }
}
