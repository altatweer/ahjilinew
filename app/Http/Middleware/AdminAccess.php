<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل الدخول
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'يجب تسجيل الدخول للوصول للوحة الإدارة');
        }

        $user = auth()->user();
        
        // التحقق من وجود دور المستخدم
        if (!isset($user->role)) {
            abort(403, 'ليس لديك صلاحية للوصول للوحة الإدارة');
        }

        // الأدوار المسموح لها بالوصول للوحة الإدارة
        $allowedRoles = ['admin', 'super-admin', 'moderator'];
        
        if (!in_array($user->role, $allowedRoles)) {
            // رسالة واضحة للمستخدم العادي
            return redirect()->route('home')
                ->with('error', 'عذراً، لوحة الإدارة مخصصة للموظفين والمدراء فقط. يمكنك تصفح الموقع كمستخدم عادي.');
        }

        // تسجيل محاولة الوصول للوحة الإدارة
        \Log::info('Admin panel access granted', [
            'user_id' => $user->id,
            'username' => $user->username,
            'role' => $user->role,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return $next($request);
    }
}
