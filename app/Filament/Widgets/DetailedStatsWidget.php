<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DetailedStatsWidget extends ChartWidget
{
    protected static ?string $heading = 'إحصائيات آخر 30 يوم';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $days = collect(range(0, 29))->map(function ($day) {
            return now()->subDays($day)->format('Y-m-d');
        })->reverse();

        $posts = $this->getPostsData($days);
        $comments = $this->getCommentsData($days);
        $users = $this->getUsersData($days);

        return [
            'datasets' => [
                [
                    'label' => 'المنشورات',
                    'data' => $posts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'التعليقات',
                    'data' => $comments,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'مستخدمين جدد',
                    'data' => $users,
                    'backgroundColor' => 'rgba(168, 85, 247, 0.1)',
                    'borderColor' => 'rgb(168, 85, 247)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $days->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d/m');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getPostsData($days)
    {
        $posts = Post::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return $days->map(function ($date) use ($posts) {
            return $posts->get($date, 0);
        })->toArray();
    }

    private function getCommentsData($days)
    {
        $comments = Comment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return $days->map(function ($date) use ($comments) {
            return $comments->get($date, 0);
        })->toArray();
    }

    private function getUsersData($days)
    {
        $users = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return $days->map(function ($date) use ($users) {
            return $users->get($date, 0);
        })->toArray();
    }
}