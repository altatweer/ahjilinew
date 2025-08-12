<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول لإضافة تعليق');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:2|max:500',
        ]);

        // Check auto-approval setting
        $autoApprove = SiteSetting::get('auto_approve_comments', true);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'content' => $validated['content'],
            'status' => $autoApprove ? 'approved' : 'pending',
            'is_active' => true,
            'likes_count' => 0,
            'replies_count' => 0,
        ]);

        // Increment comments count for the post
        if ($autoApprove) {
            $post->increment('comments_count');
        }

        $message = $autoApprove ? 
            'تم إضافة تعليقك بنجاح!' : 
            'تم إرسال تعليقك للمراجعة وسيظهر بعد الموافقة عليه.';

        return back()->with('success', $message);
    }

    /**
     * Store an anonymous comment
     */
    public function storeAnonymous(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|min:2|max:500',
            'anonymous_name' => 'nullable|string|min:2|max:50',
        ]);

        // Extra spam checks for anonymous comments
        $ip = $request->ip();
        
        // Check IP rate limiting (more strict for anonymous)
        $recentCommentsFromIP = Comment::countRecentFromIP($ip, 1);
        if ($recentCommentsFromIP >= 5) {
            return back()->withErrors([
                'content' => 'تم تجاوز الحد المسموح للتعليقات. حاول مرة أخرى بعد ساعة.'
            ])->withInput();
        }

        // Check if the site allows anonymous comments
        $allowAnonymousComments = SiteSetting::get('allow_anonymous_comments', true);
        if (!$allowAnonymousComments) {
            return redirect()->route('register')
                ->with('error', 'يجب التسجيل لإضافة تعليق');
        }

        // Check auto-approval setting for anonymous comments
        // Falls back to general comment approval setting if not set
        $autoApproveAnonymous = SiteSetting::get('auto_approve_anonymous_comments', 
            SiteSetting::get('auto_approve_comments', false)
        );
        
        $status = $autoApproveAnonymous ? 'approved' : 'pending';

        $comment = Comment::createAnonymous([
            'post_id' => $post->id,
            'content' => $validated['content'],
            'anonymous_name' => $validated['anonymous_name'],
            'status' => $status,
        ]);

        $message = $autoApproveAnonymous ? 
            'تم إضافة تعليقك بنجاح!' : 
            'تم إرسال تعليقك للمراجعة وسيظهر بعد الموافقة عليه.';

        return back()->with('success', $message);
    }

    /**
     * Reply to a comment
     */
    public function reply(Request $request, Comment $comment): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول لإضافة رد');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:2|max:500',
        ]);

        // Check auto-approval setting
        $autoApprove = SiteSetting::get('auto_approve_comments', true);

        $reply = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $comment->post_id,
            'parent_id' => $comment->id,
            'content' => $validated['content'],
            'status' => $autoApprove ? 'approved' : 'pending',
            'is_active' => true,
            'likes_count' => 0,
            'replies_count' => 0,
        ]);

        // Increment replies count for the parent comment
        if ($autoApprove) {
            $comment->increment('replies_count');
            
            // Also increment the post's comments count
            $comment->post->increment('comments_count');
        }

        $message = $autoApprove ? 
            'تم إضافة ردك بنجاح!' : 
            'تم إرسال ردك للمراجعة وسيظهر بعد الموافقة عليه.';

        return back()->with('success', $message);
    }

    /**
     * Like/Unlike a comment
     */
    public function toggleLike(Comment $comment): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول للإعجاب بالتعليقات');
        }

        $user = Auth::user();
        
        // Check if user already liked this comment
        // We'll use a simple approach here - you might want to create a separate comment_likes table later
        $interaction = $user->interactions()
            ->where('post_id', $comment->post_id)
            ->where('type', 'comment_like')
            ->whereRaw("JSON_EXTRACT(metadata, '$.comment_id') = ?", [$comment->id])
            ->first();

        if ($interaction) {
            // Unlike
            $interaction->delete();
            $comment->decrement('likes_count');
            $message = 'تم إلغاء الإعجاب';
        } else {
            // Like - Store comment_id in metadata
            $user->interactions()->create([
                'post_id' => $comment->post_id,
                'type' => 'comment_like',
                'metadata' => json_encode(['comment_id' => $comment->id])
            ]);
            $comment->increment('likes_count');
            $message = 'تم الإعجاب بالتعليق';
        }

        return back()->with('success', $message);
    }

    /**
     * Show comment details (for admin)
     */
    public function show(Comment $comment)
    {
        $comment->load(['user', 'post', 'parent', 'replies.user']);
        return view('comments.show', compact('comment'));
    }

    /**
     * Delete a comment (for comment owner or admin)
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول');
        }

        $user = Auth::user();
        
        // Only allow comment owner or admin to delete
        if ($comment->user_id !== $user->id && $user->account_type !== 'verified') {
            return back()->with('error', 'ليس لديك صلاحية لحذف هذا التعليق');
        }

        // Decrement counters
        $comment->post->decrement('comments_count');
        if ($comment->parent_id) {
            $comment->parent->decrement('replies_count');
        }

        // Delete replies first
        $comment->replies()->delete();
        
        // Delete the comment
        $comment->delete();

        return back()->with('success', 'تم حذف التعليق بنجاح');
    }
}
