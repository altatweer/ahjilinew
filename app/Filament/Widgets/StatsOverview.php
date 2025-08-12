<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي المنشورات', $this->getTotalPosts())
                ->description('جميع المنشورات المنشورة')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart($this->getPostsChart()),
                
            Stat::make('إجمالي التعليقات', $this->getTotalComments())
                ->description('جميع التعليقات المعتمدة')
                ->descriptionIcon('heroicon-m-chat-bubble-left')
                ->color('success')
                ->chart($this->getCommentsChart()),
                
            Stat::make('إجمالي المشاركين', $this->getTotalUsers())
                ->description('المستخدمين المسجلين')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart($this->getUsersChart()),
                
            Stat::make('المتواجدين الآن', $this->getOnlineUsers())
                ->description('آخر 5 دقائق')
                ->descriptionIcon('heroicon-m-signal')
                ->color('warning')
                ->chart([1, 2, 1, 3, 2, 4, 3]), // Example chart
        ];
    }

    private function getTotalPosts(): int
    {
        return Post::where('status', 'approved')->count();
    }

    private function getTotalComments(): int
    {
        return Comment::where('status', 'approved')->count();
    }

    private function getTotalUsers(): int
    {
        return User::count();
    }

    private function getOnlineUsers(): int
    {
        // المستخدمين الذين زاروا الموقع في آخر 5 دقائق
        return User::where('last_seen_at', '>=', now()->subMinutes(5))->count();
    }

    private function getPostsChart(): array
    {
        // منشورات آخر 7 أيام
        $posts = Post::where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
            
        return array_pad($posts, 7, 0);
    }

    private function getCommentsChart(): array
    {
        // تعليقات آخر 7 أيام
        $comments = Comment::where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
            
        return array_pad($comments, 7, 0);
    }

    private function getUsersChart(): array
    {
        // مستخدمين جدد آخر 7 أيام
        $users = User::where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
            
        return array_pad($users, 7, 0);
    }
}