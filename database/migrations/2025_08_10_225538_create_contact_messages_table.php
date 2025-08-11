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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المرسل
            $table->string('email')->nullable(); // بريد المرسل
            $table->string('phone', 20)->nullable(); // هاتف المرسل
            $table->string('subject'); // موضوع الرسالة
            $table->text('message'); // محتوى الرسالة
            $table->enum('type', ['complaint', 'suggestion', 'support', 'other'])->default('other'); // نوع الرسالة
            $table->enum('status', ['unread', 'read', 'replied', 'archived'])->default('unread'); // حالة الرسالة
            $table->text('admin_reply')->nullable(); // رد الإدارة
            $table->timestamp('replied_at')->nullable(); // تاريخ الرد
            $table->string('ip_address', 45)->nullable(); // IP المرسل
            $table->timestamps();
            
            // فهرسة للبحث والفلترة
            $table->index(['status', 'created_at']);
            $table->index(['type', 'status']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
