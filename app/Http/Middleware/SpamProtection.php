<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SpamProtection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        
        // Rate limiting based on IP
        $key = 'spam_protection:' . $ip;
        
        // Different limits for different actions
        if ($request->is('posts') && $request->isMethod('POST')) {
            $maxAttempts = 15; // 15 posts per hour (أكثر عقلانية)  
            $decayMinutes = 15; // انتظار 15 دقيقة بدلاً من ساعة كاملة
        } elseif ($request->is('comments') || $request->is('posts/*/comments')) {
            $maxAttempts = 10; // 10 comments per hour  
            $decayMinutes = 60;
        } elseif ($request->is('posts/*/share') || $request->is('posts/*/like')) {
            $maxAttempts = 50; // 50 interactions per hour
            $decayMinutes = 60;
        } else {
            return $next($request);
        }

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            
            // تسجيل مفصل للتشخيص
            \Log::info('Rate limiting activated by SpamProtection', [
                'ip' => $ip,
                'key' => $key,
                'max_attempts' => $maxAttempts,
                'decay_minutes' => $decayMinutes,
                'retry_after_seconds' => $seconds,
                'retry_after_minutes' => $minutes,
                'user_agent' => $userAgent
            ]);
            
            return response()->json([
                'message' => "تم تجاوز الحد المسموح ({$maxAttempts} منشور). المحاولة التالية خلال {$minutes} دقيقة.",
                'retry_after' => $seconds
            ], 429);
        }

        // Content spam detection
        if ($request->has('content') || $request->has('comment')) {
            $content = $request->input('content') ?: $request->input('comment');
            if ($this->isSpamContent($content)) {
                RateLimiter::hit($key, $decayMinutes * 60);
                return response()->json([
                    'message' => 'المحتوى يحتوي على كلمات مشبوهة أو تكرار مفرط.',
                    'errors' => ['content' => ['المحتوى غير مقبول']]
                ], 422);
            }
        }

        // Check for suspicious patterns
        if ($this->isSuspiciousRequest($request)) {
            RateLimiter::hit($key, $decayMinutes * 60);
            return response()->json([
                'message' => 'طلب مشبوه تم رفضه.',
            ], 403);
        }

        // Count the attempt
        RateLimiter::hit($key, $decayMinutes * 60);
        
        // تسجيل نجاح الطلب مع عدد المحاولات المتبقية
        $attemptsUsed = RateLimiter::attempts($key);
        $attemptsLeft = $maxAttempts - $attemptsUsed;
        \Log::info('Request passed SpamProtection', [
            'ip' => $ip,
            'attempts_used' => $attemptsUsed,
            'attempts_left' => $attemptsLeft,
            'max_attempts' => $maxAttempts,
            'decay_minutes' => $decayMinutes
        ]);

        return $next($request);
    }

    /**
     * Check if content is spam
     */
    private function isSpamContent(?string $content): bool
    {
        if (empty($content)) {
            return false;
        }

        // Check for excessive repetition
        $words = str_word_count($content, 1);
        if (count($words) > 3) {
            $wordCounts = array_count_values($words);
            $maxRepeat = max($wordCounts);
            if ($maxRepeat > ceil(count($words) * 0.5)) {
                return true;
            }
        }

        // Check for suspicious patterns
        $spamPatterns = [
            '/(.)\1{10,}/', // Repeated characters
            '/https?:\/\/[^\s]+/i', // URLs (can be configured)
            '/\b(viagra|casino|poker|lottery|winner|congratulations|prize|click here|free money)\b/i',
            '/[^\w\s\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]{5,}/u', // Too many special chars
        ];

        foreach ($spamPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        // Check length (very short or very long)
        if (strlen($content) < 2 || strlen($content) > 2000) {
            return true;
        }

        return false;
    }

    /**
     * Check if request is suspicious
     */
    private function isSuspiciousRequest(Request $request): bool
    {
        $userAgent = $request->userAgent();
        
        // Check for bot user agents
        $botPatterns = [
            '/bot/i',
            '/crawler/i', 
            '/spider/i',
            '/scraper/i',
            '/curl/i',
            '/wget/i',
        ];

        foreach ($botPatterns as $pattern) {
            if (preg_match($pattern, $userAgent)) {
                return true;
            }
        }

        // Check for empty or suspicious user agent
        if (empty($userAgent) || strlen($userAgent) < 10) {
            return true;
        }

        return false;
    }
}
