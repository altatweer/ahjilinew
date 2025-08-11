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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('content'); // محتوى الرسالة
            $table->enum('type', ['text', 'voice', 'image'])->default('text');
            $table->string('media_url')->nullable(); // للصوت أو الصورة
            $table->boolean('is_read')->default(false);
            $table->boolean('is_consultation')->default(false); // للاستشارات
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            // فهرسة محسنة للأداء
            $table->index(['receiver_id', 'is_read', 'created_at']); // للرسائل غير المقروءة
            $table->index(['sender_id', 'receiver_id', 'created_at']); // للمحادثات
            $table->index(['is_consultation', 'created_at']); // للاستشارات
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
