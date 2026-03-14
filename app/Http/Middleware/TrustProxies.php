<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response;

class TrustProxies
{
    /**
     * Trust proxy headers (Railway, load balancer) agar request()->secure() dan
     * URL yang di-generate pakai HTTPS saat user akses lewat https://.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $trustedProxies = '*';
        $trustedHeaders = SymfonyRequest::HEADER_X_FORWARDED_FOR
            | SymfonyRequest::HEADER_X_FORWARDED_HOST
            | SymfonyRequest::HEADER_X_FORWARDED_PORT
            | SymfonyRequest::HEADER_X_FORWARDED_PROTO;

        SymfonyRequest::setTrustedProxies(
            $trustedProxies === '*' ? [$request->server->get('REMOTE_ADDR')] : explode(',', $trustedProxies),
            $trustedHeaders
        );

        return $next($request);
    }
}
