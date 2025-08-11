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
        // First, temporarily disable strict mode
        DB::statement("SET sql_mode = ''");
        
        // Fix any posts with invalid featured_at values using CASE statement
        DB::statement("UPDATE posts SET featured_at = NULL WHERE featured_at IS NOT NULL AND (featured_at < '1970-01-02 00:00:00' OR featured_at = '0000-00-00 00:00:00')");
        
        // Re-enable strict mode
        DB::statement("SET sql_mode = 'TRADITIONAL'");
        
        // Make sure featured_at is nullable
        Schema::table('posts', function (Blueprint $table) {
            $table->timestamp('featured_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback needed
    }
};
