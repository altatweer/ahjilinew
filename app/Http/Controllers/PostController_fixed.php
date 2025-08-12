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
                'guest_name' => 'nullable|string|max:100',
            ]);

            // Validate community type for authenticated users only
            if ($validated['type'] === 'community' && !Auth::check()) {
                return back()->withErrors([
                    'type' => 'يجب تسجيل الدخول للمشاركة باسمك'
                ])->withInput();
            }

            // Rate limiting check
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Rate limiting: max 1 post per minute
                $recentPost = Post::where('user_id', $userId)
                    ->where('created_at', '>=', now()->subMinute())
                    ->exists();
                
                if ($recentPost) {
                    return back()->withErrors([
                        'content' => 'يجب الانتظار دقيقة واحدة بين كل منشور والآخر'
                    ])->withInput();
                }
                
                // Check for exact duplicate content in last 24 hours
                $recentDuplicate = Post::where('user_id', $userId)
                    ->where('content', $validated['content'])
                    ->where('created_at', '>=', now()->subHours(24))
                    ->exists();
                
                if ($recentDuplicate) {
                    return back()->withErrors([
                        'content' => 'لقد قمت بنشر نفس هذا المحتوى مؤخراً'
                    ])->withInput();
                }
            } else {
                // Rate limiting for anonymous posts: max 1 post per 2 minutes
                $recentPostByIP = Post::whereNull('user_id')
                    ->where('created_at', '>=', now()->subMinutes(2))
                    ->exists();
                    
                if ($recentPostByIP) {
                    return back()->withErrors([
                        'content' => 'يجب الانتظار دقيقتين بين كل منشور والآخر للمستخدمين المجهولين'
                    ])->withInput();
                }
                
                // Check for exact duplicate content
                $recentDuplicateByIP = Post::where('content', $validated['content'])
                    ->whereNull('user_id')
                    ->where('created_at', '>=', now()->subHours(24))
                    ->exists();
                
                if ($recentDuplicateByIP) {
                    return back()->withErrors([
                        'content' => 'تم نشر نفس هذا المحتوى مؤخراً'
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

            $message = $autoApprove ? 
                'تم نشر منشورك بنجاح!' : 
                'تم إرسال منشورك للمراجعة وسيظهر بعد الموافقة عليه';

            return redirect()->route('home')->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Error creating post: ' . $e->getMessage());
            
            return back()->withErrors([
                'content' => 'حدث خطأ أثناء نشر المنشور. يرجى المحاولة مرة أخرى'
            ])->withInput();
        }
    }

    // Rest of the methods remain the same...
}
