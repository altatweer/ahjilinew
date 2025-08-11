<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // مفتاح الإعداد
            $table->text('value')->nullable(); // قيمة الإعداد
            $table->string('type')->default('text'); // نوع البيانات
            $table->text('description')->nullable(); // وصف الإعداد
            $table->timestamps();
            
            $table->index('key');
        });
        
        // إدراج الإعدادات الافتراضية
        DB::table('site_settings')->insert([
            [
                'key' => 'require_registration',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'إجبار التسجيل للنشر والتعليق',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'auto_approve_posts',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'الموافقة التلقائية على المنشورات',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'auto_approve_comments',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'الموافقة التلقائية على التعليقات',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'site_maintenance',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'وضع الصيانة للموقع',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'admin_email',
                'value' => 'admin@ahjili.com',
                'type' => 'email',
                'description' => 'بريد المدير لاستقبال المراسلات',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'posts_per_page',
                'value' => '10',
                'type' => 'number',
                'description' => 'عدد المنشورات في كل صفحة',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
