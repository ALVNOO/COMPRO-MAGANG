<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Redirect HTTP ke HTTPS di production agar browser tidak anggap form "not secure".
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production')) {
            return $next($request);
        }

        $url = config('app.url');
        if (! $url || ! str_starts_with($url, 'https://')) {
            return $next($request);
        }

        // Di belakang proxy (Railway), cek X-Forwarded-Proto
        $proto = strtolower((string) $request->header('X-Forwarded-Proto', ''));
        if ($proto !== 'https') {
            return redirect()->secure($request->getRequestUri(), 302);
        }

        return $next($request);
    }
}
