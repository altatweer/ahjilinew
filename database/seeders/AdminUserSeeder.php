<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المستخدم الإداري الرئيسي
        $admin = \App\Models\User::create([
            'username' => 'admin',
            'display_name' => 'مدير احجيلي',
            'email' => 'admin@ahjili.com',
            'phone' => null,
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'avatar_url' => null,
            'bio' => 'مدير منصة احجيلي للحلول والتحذيرات',
            'location' => 'baghdad',
            'birth_date' => '1990-01-01',
            'account_type' => 'verified',
            'is_active' => true,
            'is_private' => false,
            'last_active_at' => now(),
            'email_verified_at' => now(),
        ]);

        // إنشاء إعدادات المستخدم الإداري
        \App\Models\UserSetting::create([
            'user_id' => $admin->id,
            'auto_approve_posts' => false, // يراجع المنشورات يدوياً
            'allow_anonymous_messages' => true,
            'email_notifications' => true,
            'push_notifications' => true,
            'notification_types' => json_encode([
                'new_posts' => true,
                'new_comments' => true,
                'new_messages' => true,
                'reports' => true
            ]),
            'privacy_level' => 'public',
            'blocked_users' => null,
        ]);

        $this->command->info('تم إنشاء المستخدم الإداري بنجاح:');
        $this->command->info('البريد الإلكتروني: admin@ahjili.com');
        $this->command->info('كلمة المرور: admin123');
        $this->command->warn('تذكر تغيير كلمة المرور بعد أول تسجيل دخول!');
    }
}
