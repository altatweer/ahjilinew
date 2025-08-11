<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the main homepage with posts
     */
    public function index(Request $request): View
    {
        $perPage = SiteSetting::get('posts_per_page', 10);
        
        $posts = Post::query()
            ->with(['user', 'comments.user'])
            ->active()
            ->approved()
            ->when($request->location, function ($query, $location) {
                $query->where('location', $location);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('content', 'like', "%{$search}%")
                      ->orWhere('hashtags', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);

        $locations = [
            'baghdad' => 'بغداد',
            'basra' => 'البصرة',
            'erbil' => 'أربيل',
            'mosul' => 'الموصل',
            'najaf' => 'النجف',
            'karbala' => 'كربلاء',
            'sulaymaniyah' => 'السليمانية',
            'kirkuk' => 'كركوك',
            'diyala' => 'ديالى',
            'anbar' => 'الأنبار',
            'dhi_qar' => 'ذي قار',
            'babylon' => 'بابل',
            'wasit' => 'واسط',
            'saladin' => 'صلاح الدين',
            'qadisiyyah' => 'القادسية',
            'maysan' => 'ميسان',
            'muthanna' => 'المثنى',
            'dohuk' => 'دهوك'
        ];

        // Statistics for header
        $stats = [
            'solved_problems' => Post::where('status', 'approved')->count(),
            'active_users' => \App\Models\User::where('is_active', true)->count(),
            'total_comments' => \App\Models\Comment::where('status', 'approved')->count(),
        ];

        return view('home', compact('posts', 'locations', 'stats'));
    }

    /**
     * Show about page
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Show contact page
     */
    public function contact(): View
    {
        return view('contact');
    }

    /**
     * Show privacy policy
     */
    public function privacy(): View
    {
        return view('privacy');
    }

    /**
     * Show terms of service
     */
    public function terms(): View
    {
        return view('terms');
    }
}
