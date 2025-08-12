<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Show create post form
     */
    public function create(): View
    {
        // Check if registration is required
        $requireRegistration = SiteSetting::get('require_registration', false);
        
        if ($requireRegistration && !Auth::check()) {
            return redirect()->route('register')
                ->with('error', 'يجب التسجيل أولاً لإضافة منشور');
        }

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

        return view('posts.create', compact('locations'));
    }

    /**
     * Store a new post
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            \Log::info('Post store method called', [
                'user_logged_in' => Auth::check(),
                'user_id' => Auth::id(),
                'request_method' => $request->method(),
                'content_length' => strlen($request->input('content', '')),
                'has_csrf_token' => !empty($request->input('_token'))
            ]);
            
            $requireRegistration = SiteSetting::get('require_registration', false);
            
            if ($requireRegistration && !Auth::check()) {
                return redirect()->route('register')
                    ->with('error', 'يجب التسجيل أولاً لإضافة منشور');
            }

        $validated = $request->validate([
            'content' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:anonymous,community',
            'category' => 'required|in:complaint,experience,recommendation,question,review,general',
            'location' => 'required|string',
            'hashtags' => 'nullable|string|max:200',
            'guest_name' => 'nullable|string|max:100', // للمنشورات المجهولة
        ]);

        // Validate community type for authenticated users only
        if ($validated['type'] === 'community' && !Auth::check()) {
            return back()->withErrors([
                'type' => 'يجب تسجيل الدخول للمشاركة باسمك'
            ])->withInput();
        }

        // Check for duplicate posts only (rate limiting handled by SpamProtection middleware)
        if (Auth::check()) {
            $userId = Auth::id();
            
            // Check for exact duplicate content in last 24 hours
            $recentDuplicate = Post::where('user_id', $userId)
                ->where('content', $validated['content'])
                ->where('created_at', '>=', now()->subHours(24))
                ->exists();
            
            if ($recentDuplicate) {
                return back()->withErrors([
                    'content' => 'لا يمكن تكرار نفس المنشور'
                ])->withInput();
            }
        } else {
            // For anonymous users - only check duplicates (rate limiting handled by SpamProtection middleware)
            
            // Check for exact duplicate content
            $recentDuplicateByIP = Post::where('content', $validated['content'])
                ->whereNull('user_id') // Anonymous posts
                ->where('created_at', '>=', now()->subHours(24))
                ->exists();
            
            if ($recentDuplicateByIP) {
                return back()->withErrors([
                    'content' => 'لا يمكن تكرار المنشور'
                ])->withInput();
            }
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Determine auto-approval
        $autoApprove = SiteSetting::get('auto_approve_posts', true);
        
        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
            'image_url' => $imagePath,
            'type' => $validated['type'],
            'category' => $validated['category'],
            'status' => $autoApprove ? 'approved' : 'pending',
            'location' => $validated['location'],
            'hashtags' => $validated['hashtags'],
            'is_active' => true,
        ]);
        
        \Log::info('Post created successfully', [
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content_preview' => substr($validated['content'], 0, 50),
            'created_at' => $post->created_at
        ]);

        $message = $autoApprove ? 
            'تم نشر المنشور بنجاح!' : 
            'تم إرسال المنشور للمراجعة وسيظهر بعد الموافقة عليه.';

            return redirect()->route('home')
                ->with('success', $message)
                ->header('Content-Type', 'text/html; charset=UTF-8');
                
        } catch (\Exception $e) {
            \Log::error('Post creation error: ' . $e->getMessage());
            
            return back()->withErrors([
                'content' => 'حدث خطأ. حاول مرة أخرى'
            ])->withInput()
            ->header('Content-Type', 'text/html; charset=UTF-8');
        }
    }

    /**
     * Show single post
     */
    public function show(Post $post): View
    {
        $post->load(['user', 'comments.user', 'comments.replies.user']);
        
        // Increment views count
        $post->increment('views_count');

        return view('posts.show', compact('post'));
    }

    /**
     * Like/Unlike a post
     */
    public function toggleLike(Post $post): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول للإعجاب بالمنشورات');
        }

        $user = Auth::user();
        $interaction = $user->interactions()
            ->where('post_id', $post->id)
            ->where('type', 'like')
            ->first();

        if ($interaction) {
            // Unlike
            $interaction->delete();
            $post->decrement('likes_count');
            $message = 'تم إلغاء الإعجاب';
        } else {
            // Like
            $user->interactions()->create([
                'post_id' => $post->id,
                'type' => 'like'
            ]);
            $post->increment('likes_count');
            $message = 'تم الإعجاب بالمنشور';
        }

        return back()->with('success', $message);
    }

    /**
     * Share a post
     */
    public function share(Post $post): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول لمشاركة المنشورات');
        }

        $user = Auth::user();
        
        // Check if already shared
        $existingShare = $user->interactions()
            ->where('post_id', $post->id)
            ->where('type', 'share')
            ->first();

        if (!$existingShare) {
            $user->interactions()->create([
                'post_id' => $post->id,
                'type' => 'share'
            ]);
            $post->increment('shares_count');
        }

        return back()->with('success', 'تم مشاركة المنشور');
    }

    /**
     * Save/Unsave a post
     */
    public function toggleSave(Post $post): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول لحفظ المنشورات');
        }

        $user = Auth::user();
        $interaction = $user->interactions()
            ->where('post_id', $post->id)
            ->where('type', 'save')
            ->first();

        if ($interaction) {
            $interaction->delete();
            $message = 'تم إلغاء حفظ المنشور';
        } else {
            $user->interactions()->create([
                'post_id' => $post->id,
                'type' => 'save'
            ]);
            $message = 'تم حفظ المنشور';
        }

        return back()->with('success', $message);
    }

    /**
     * Report a post
     */
    public function report(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول للإبلاغ عن المنشورات');
        }

        $user = Auth::user();
        
        // Check if already reported
        $existingReport = $user->interactions()
            ->where('post_id', $post->id)
            ->where('type', 'report')
            ->first();

        if (!$existingReport) {
            $user->interactions()->create([
                'post_id' => $post->id,
                'type' => 'report'
            ]);
        }

        return back()->with('success', 'تم الإبلاغ عن المنشور. شكراً لك على المساعدة في تحسين المجتمع.');
    }

    /**
     * Anonymous Like/Unlike a post
     */
    public function toggleLikeAnonymous(Request $request, Post $post): RedirectResponse
    {
        $ipAddress = $request->ip();
        
        // Check if already liked by this IP
        $interaction = \App\Models\Interaction::where('post_id', $post->id)
            ->where('type', 'like')
            ->where('metadata->ip_address', $ipAddress)
            ->whereNull('user_id')
            ->first();

        if ($interaction) {
            // Unlike
            $interaction->delete();
            $post->decrement('likes_count');
            $message = 'تم إلغاء الإعجاب';
        } else {
            // Like
            \App\Models\Interaction::create([
                'post_id' => $post->id,
                'type' => 'like',
                'user_id' => null,
                'metadata' => [
                    'ip_address' => $ipAddress,
                    'user_agent' => $request->header('User-Agent'),
                    'timestamp' => now()
                ]
            ]);
            $post->increment('likes_count');
            $message = 'تم الإعجاب بالمنشور';
        }

        return back()->with('success', $message);
    }

    /**
     * Anonymous Share a post
     */
    public function shareAnonymous(Request $request, Post $post): RedirectResponse
    {
        $ipAddress = $request->ip();
        
        // Check if already shared by this IP
        $existingShare = \App\Models\Interaction::where('post_id', $post->id)
            ->where('type', 'share')
            ->where('metadata->ip_address', $ipAddress)
            ->whereNull('user_id')
            ->first();

        if (!$existingShare) {
            \App\Models\Interaction::create([
                'post_id' => $post->id,
                'type' => 'share',
                'user_id' => null,
                'metadata' => [
                    'ip_address' => $ipAddress,
                    'user_agent' => $request->header('User-Agent'),
                    'timestamp' => now()
                ]
            ]);
            $post->increment('shares_count');
        }

        return back()->with('success', 'تم مشاركة المنشور');
    }
}
