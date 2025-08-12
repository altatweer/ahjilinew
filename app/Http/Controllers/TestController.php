<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TestController extends Controller
{
    public function createPost(Request $request): RedirectResponse
    {
        try {
            // Simple validation
            $request->validate([
                'content' => 'required|string|min:5|max:500',
            ]);

            // Create post directly
            $post = Post::create([
                'user_id' => null,
                'content' => $request->content,
                'type' => 'anonymous',
                'category' => 'general',
                'status' => 'approved',
                'location' => 'baghdad',
                'is_active' => true,
            ]);

            // Simple success response in Arabic
            return response()
                ->redirectTo('/test-form')
                ->with('success', 'تم إنشاء المنشور بنجاح! رقم: ' . $post->id)
                ->header('Content-Type', 'text/html; charset=UTF-8');

        } catch (\Exception $e) {
            \Log::error('Test post creation error: ' . $e->getMessage());
            
            return response()
                ->redirectTo('/test-form')
                ->withErrors(['content' => 'فشل في الإنشاء: ' . $e->getMessage()])
                ->withInput()
                ->header('Content-Type', 'text/html; charset=UTF-8');
        }
    }
}