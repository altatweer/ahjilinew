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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('auto_approve_posts')->default(true); // الموافقة التلقائية
            $table->boolean('allow_anonymous_messages')->default(true); // رسائل من المجهولين
            $table->boolean('email_notifications')->default(true);
            $table->boolean('push_notifications')->default(true);
            $table->json('notification_types')->nullable(); // أنواع الإشعارات المفضلة
            $table->enum('privacy_level', ['public', 'followers', 'private'])->default('public');
            $table->json('blocked_users')->nullable(); // المستخدمون المحظورون
            $table->timestamps();
            
            // فهرسة
            $table->unique('user_id');
            $table->index(['auto_approve_posts', 'privacy_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
