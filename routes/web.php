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

// Homepage and main pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Posts
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->middleware('spam.protection')->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// Anonymous Comments (with spam protection)
Route::post('/posts/{post}/comments/anonymous', [CommentController::class, 'storeAnonymous'])
    ->middleware('spam.protection')
    ->name('comments.store.anonymous');

// Anonymous Post Interactions (with spam protection)
Route::post('/posts/{post}/like/anonymous', [PostController::class, 'toggleLikeAnonymous'])
    ->middleware('spam.protection')
    ->name('posts.like.anonymous');
Route::post('/posts/{post}/share/anonymous', [PostController::class, 'shareAnonymous'])
    ->middleware('spam.protection')
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
    // Post interactions (with spam protection)
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])
        ->middleware('spam.protection')
        ->name('posts.like');
    Route::post('/posts/{post}/share', [PostController::class, 'share'])
        ->middleware('spam.protection')
        ->name('posts.share');
    Route::post('/posts/{post}/save', [PostController::class, 'toggleSave'])
        ->middleware('spam.protection')
        ->name('posts.save');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])
        ->middleware('spam.protection')
        ->name('posts.report');
    
    // Comments (with spam protection)
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->middleware('spam.protection')
        ->name('comments.store');
    Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])
        ->middleware('spam.protection')
        ->name('comments.like');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])
        ->middleware('spam.protection')
        ->name('comments.reply');
    
    // User dashboard
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');
});
