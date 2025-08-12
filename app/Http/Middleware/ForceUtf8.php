<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceUtf8
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set proper charset for incoming request
        $request->headers->set('Accept-Charset', 'utf-8');
        
        $response = $next($request);
        
        // Force UTF-8 for all responses
        if ($response instanceof \Illuminate\Http\Response || 
            $response instanceof \Illuminate\Http\RedirectResponse) {
            $response->header('Content-Type', 'text/html; charset=UTF-8');
        }
        
        return $response;
    }
}