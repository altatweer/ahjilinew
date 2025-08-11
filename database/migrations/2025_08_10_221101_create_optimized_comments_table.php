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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // للردود
            $table->text('content'); // محتوى التعليق
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->integer('likes_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->timestamps();
            
            // فهرسة محسنة للأداء العالي
            $table->index(['post_id', 'parent_id', 'is_active', 'created_at']); // لتعليقات المشاركة
            $table->index(['user_id', 'is_active', 'created_at']); // لتعليقات المستخدم
            $table->index(['parent_id', 'is_active']); // للردود
            $table->index(['status', 'created_at']); // للإشراف
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optimized_comments');
    }
};
