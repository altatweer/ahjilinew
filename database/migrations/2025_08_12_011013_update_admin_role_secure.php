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
        // إضافة عمود role إذا لم يكن موجوداً
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['user', 'moderator', 'admin', 'super-admin'])
                      ->default('user')
                      ->after('account_type')
                      ->comment('دور المستخدم - أمان محدود للإدارة');
                
                // فهرسة للأمان والأداء
                $table->index(['role', 'is_active']);
            });
        }

        // تحديث المستخدم admin ليصبح super-admin
        \DB::table('users')
            ->where('username', 'admin')
            ->update(['role' => 'super-admin']);
            
        // تسجيل أمني للعملية
        \Log::warning('SECURITY: Admin role system activated', [
            'admin_user_promoted' => true,
            'timestamp' => now(),
            'ip' => request()->ip() ?? 'console'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // إعادة تعيين admin كمستخدم عادي
        \DB::table('users')
            ->where('username', 'admin')
            ->update(['role' => 'user']);
            
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex(['role', 'is_active']);
                $table->dropColumn('role');
            });
        }
    }
};
