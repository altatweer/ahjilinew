<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecalculateCommentsCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:recalculate {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إعادة حساب عدد التعليقات لجميع المنشورات (يشمل التعليقات المجهولة المعتمدة)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 بدء إعادة حساب عدد التعليقات...');
        
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->warn('📋 وضع التجربة مفعل - لن يتم تطبيق التغييرات');
        }

        $posts = \App\Models\Post::all();
        $totalUpdated = 0;
        $totalPosts = $posts->count();

        $this->info("📊 معالجة {$totalPosts} منشور...");

        $progressBar = $this->output->createProgressBar($totalPosts);

        foreach ($posts as $post) {
            // حساب التعليقات المعتمدة (يشمل المجهولة والمسجلة)
            $approvedCommentsCount = \App\Models\Comment::where('post_id', $post->id)
                ->where('status', 'approved')
                ->whereNull('parent_id') // فقط التعليقات الرئيسية، ليس الردود
                ->count();

            $currentCount = $post->comments_count;

            if ($currentCount != $approvedCommentsCount) {
                $this->newLine();
                $this->line("📝 منشور #{$post->id}: {$currentCount} → {$approvedCommentsCount}");
                
                if (!$dryRun) {
                    $post->update(['comments_count' => $approvedCommentsCount]);
                }
                
                $totalUpdated++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("📋 تم فحص {$totalPosts} منشور");
            $this->info("🔢 {$totalUpdated} منشور بحاجة لتحديث");
            $this->warn("⚠️  لتطبيق التغييرات: php artisan comments:recalculate");
        } else {
            $this->info("✅ تم تحديث {$totalUpdated} منشور من أصل {$totalPosts}");
            $this->info("📊 عدد التعليقات محدث لجميع المنشورات");
        }

        // تسجيل العملية
        \Log::info('Comments count recalculated', [
            'total_posts' => $totalPosts,
            'updated_posts' => $totalUpdated,
            'dry_run' => $dryRun
        ]);

        return 0;
    }
}
