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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['like', 'share', 'save', 'report']); // نوع التفاعل
            $table->timestamp('created_at')->useCurrent();
            
            // فهرسة محسنة للأداء العالي
            $table->unique(['user_id', 'post_id', 'type']); // منع التكرار
            $table->index(['post_id', 'type']); // لحساب التفاعلات
            $table->index(['user_id', 'type', 'created_at']); // لتاريخ المستخدم
            $table->index(['type', 'created_at']); // للإحصائيات العامة
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optimized_interactions');
    }
};
