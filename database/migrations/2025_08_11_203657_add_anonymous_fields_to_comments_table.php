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
        Schema::table('comments', function (Blueprint $table) {
            $table->string('anonymous_name')->nullable()->after('content');
            $table->boolean('is_anonymous')->default(false)->after('anonymous_name');
            $table->string('ip_address')->nullable()->after('is_anonymous');
            $table->text('user_agent')->nullable()->after('ip_address');
            
            // Make user_id nullable to support anonymous comments
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['anonymous_name', 'is_anonymous', 'ip_address', 'user_agent']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
