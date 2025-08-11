<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm(): View
    {
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

        return view('auth.register', compact('locations'));
    }

    /**
     * Handle registration request
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:50|unique:users,username|alpha_dash',
            'display_name' => 'required|string|min:2|max:100',
            'password' => ['required', 'confirmed', Password::min(6)],
            'location' => 'required|string|max:100',
            'bio' => 'nullable|string|max:500',
            'account_type' => 'nullable|in:regular,verified,counselor',
        ]);

        // Generate a unique email from username
        $generatedEmail = $validated['username'] . '@ahjili.local';

        // Create user
        $user = User::create([
            'username' => $validated['username'],
            'display_name' => $validated['display_name'],
            'email' => $generatedEmail,
            'password' => Hash::make($validated['password']),
            'location' => $validated['location'],
            'bio' => $validated['bio'] ?? null,
            'account_type' => $validated['account_type'] ?? 'regular',
            'is_active' => true,
            'is_private' => false,
            'email_verified_at' => now(), // Auto-verify for simplicity
        ]);

        // Create user settings
        UserSetting::create([
            'user_id' => $user->id,
            'auto_approve_posts' => true,
            'allow_anonymous_messages' => true,
            'email_notifications' => true,
            'push_notifications' => true,
            'notification_types' => json_encode([
                'new_posts' => true,
                'new_comments' => true,
                'new_messages' => true,
            ]),
            'privacy_level' => 'public',
        ]);

        // Log the user in
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'مرحباً بك في احجيلي! تم إنشاء حسابك بنجاح.');
    }
}
