<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إضافة إعداد الموافقة التلقائية للتعليقات المجهولة
        SiteSetting::updateOrCreate(
            ['key' => 'auto_approve_anonymous_comments'],
            [
                'value' => 'true', // تفعيل الموافقة التلقائية للتعليقات المجهولة
                'type' => 'boolean',
                'description' => 'الموافقة التلقائية على التعليقات المجهولة',
                'category' => 'comments'
            ]
        );

        // إضافة إعداد للسماح بالتعليقات المجهولة (إذا لم يكن موجود)
        SiteSetting::updateOrCreate(
            ['key' => 'allow_anonymous_comments'],
            [
                'value' => 'true',
                'type' => 'boolean', 
                'description' => 'السماح بالتعليقات المجهولة',
                'category' => 'comments'
            ]
        );

        // إضافة إعداد عام للموافقة على التعليقات (إذا لم يكن موجود)
        SiteSetting::updateOrCreate(
            ['key' => 'auto_approve_comments'],
            [
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'الموافقة التلقائية على تعليقات المستخدمين المسجلين',
                'category' => 'comments'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف الإعدادات المضافة
        SiteSetting::where('key', 'auto_approve_anonymous_comments')->delete();
        SiteSetting::where('key', 'allow_anonymous_comments')->delete();
        SiteSetting::where('key', 'auto_approve_comments')->delete();
    }
};