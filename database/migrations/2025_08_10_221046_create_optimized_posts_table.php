<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // null للمشاركات المجهولة
            $table->text('content'); // محتوى المشاركة
            $table->string('image_url')->nullable(); // رابط الصورة
            $table->enum('type', ['anonymous', 'community'])->default('anonymous'); // نوع المشاركة
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved'); // حالة الموافقة
            $table->boolean('is_active')->default(true);
            $table->string('hashtags')->nullable(); // الهاشتاجات منفصلة بفاصلات
            $table->string('location', 100)->nullable(); // المحافظة العراقية
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('shares_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->timestamp('featured_at')->nullable(); // للمشاركات المميزة
            $table->timestamps();
            
            // فهرسة محسنة للأداء العالي
            $table->index(['type', 'status', 'is_active', 'created_at']); // للصفحة الرئيسية
            $table->index(['user_id', 'type', 'is_active']); // لمشاركات المستخدم
            $table->index(['likes_count', 'created_at']); // للمشاركات الأكثر تفاعلاً
            $table->index(['featured_at', 'created_at']); // للمشاركات المميزة
            $table->index(['location', 'type', 'is_active']); // للبحث المحلي
            // $table->fullText(['content', 'hashtags']); // للبحث النصي - MySQL only
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optimized_posts');
    }
};
