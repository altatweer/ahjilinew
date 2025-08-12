<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage - with fallback if database not ready
Route::get('/', function() {
    try {
        return app(HomeController::class)->index(request());
    } catch (\Exception $e) {
        // Fallback if database not ready
        return view('welcome-simple');
    }
})->name('home');
// Quick test route
Route::get('/test', function() {
    return 'SUCCESS! احجيلي Laravel يعمل بنجاح 🚀<br><br>
    <a href="/">← العودة للرئيسية</a> | 
    <a href="/admin">لوحة الإدارة</a> | 
    <a href="/posts/create">أضف منشور</a>';
});

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Anonymous Comments 
Route::post('/posts/{post}/comments/anonymous', [CommentController::class, 'storeAnonymous'])
    ->name('comments.store.anonymous');

// Anonymous Post Interactions 
Route::post('/posts/{post}/like/anonymous', [PostController::class, 'toggleLikeAnonymous'])
    ->name('posts.like.anonymous');
Route::post('/posts/{post}/share/anonymous', [PostController::class, 'shareAnonymous'])
    ->name('posts.share.anonymous');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login/Logout (using Laravel's built-in auth)
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::post('/login', function(Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required',
    ]);

    // Find user by username and get their email for Laravel auth
    $user = \App\Models\User::where('username', $credentials['username'])->first();
    
    if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']], $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    return back()->withErrors([
        'username' => 'اسم المستخدم أو كلمة المرور غير صحيحة.',
    ])->onlyInput('username');
})->name('login.post');

Route::post('/logout', function(Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Post interactions 
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])
        ->name('posts.like');
    Route::post('/posts/{post}/share', [PostController::class, 'share'])
        ->name('posts.share');
    Route::post('/posts/{post}/save', [PostController::class, 'toggleSave'])
        ->name('posts.save');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])
        ->name('posts.report');
    
    // Comments 
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])
        ->name('comments.like');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])
        ->name('comments.reply');
    
    // User dashboard
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');
});

// Test form route
Route::get('/test-form', function () {
    return view('test-form');
});

// Simple test post route
Route::post('/test-post', [App\Http\Controllers\TestController::class, 'createPost']);
