<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        // Login: 5 attempts per minute per IP
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.'
                    ], 429);
                });
        });

        // Registration: 3 attempts per 5 minutes per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinutes(5, 3)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan registrasi. Silakan coba lagi dalam 5 menit.'
                    ], 429);
                });
        });

        // 2FA: 10 attempts per 5 minutes per IP
        RateLimiter::for('2fa', function (Request $request) {
            return Limit::perMinutes(5, 10)->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan verifikasi. Silakan coba lagi dalam 5 menit.'
                    ], 429);
                });
        });

        // Sensitive actions: 5 attempts per minute per user+IP
        RateLimiter::for('sensitive', function (Request $request) {
            $key = ($request->user()?->id ?: 'guest') . '|' . $request->ip();
            return Limit::perMinute(5)->by($key)
                ->response(function () {
                    return response()->json([
                        'message' => 'Terlalu banyak permintaan. Silakan coba lagi dalam 1 menit.'
                    ], 429);
                });
        });

        // Form submissions: 10 attempts per minute per user+IP
        RateLimiter::for('form-submission', function (Request $request) {
            $key = ($request->user()?->id ?: 'guest') . '|' . $request->ip();
            return Limit::perMinute(10)->by($key)
                ->response(function () {
                    return response()->json([
                        'message' => 'Terlalu banyak permintaan. Silakan coba lagi dalam 1 menit.'
                    ], 429);
                });
        });

        // Global: 60 requests per minute per IP for all authenticated routes
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
