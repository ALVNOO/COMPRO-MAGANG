<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $user = auth()->user();
    
    // Admin: lewat langsung
    if ($user->role === 'admin') {
        return $next($request);
    }
    
    // Mentor/Peserta: wajib setup 2FA
    if (!$user->hasTwoFactorEnabled()) {
        return redirect()->route('2fa.setup')
            ->with('error', 'Anda wajib mengaktifkan 2FA untuk melanjutkan');
    }
    
    // Cek session verifikasi
    if (!session('2fa_verified')) {
        return redirect()->route('2fa.verify');
    }
    
    return $next($request);
}
}
