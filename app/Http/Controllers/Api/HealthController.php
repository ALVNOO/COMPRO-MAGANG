<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    /** Quick liveness probe — for load balancers. */
    public function ping(): JsonResponse
    {
        return response()->json([
            'status'    => 'ok',
            'timestamp' => now()->toISOString(),
        ]);
    }

    /** Deep health check — verifies DB, cache, and queue. Returns 503 if degraded. */
    public function health(): JsonResponse
    {
        $checks  = [];
        $healthy = true;

        // Database
        try {
            DB::select('SELECT 1');
            $checks['database'] = ['status' => 'ok', 'driver' => config('database.default')];
        } catch (\Exception $e) {
            $checks['database'] = ['status' => 'fail', 'error' => $e->getMessage()];
            $healthy = false;
        }

        // Cache
        try {
            Cache::put('_health_probe', 1, 5);
            $ok = Cache::get('_health_probe') === 1;
            Cache::forget('_health_probe');
            $checks['cache'] = ['status' => $ok ? 'ok' : 'fail', 'driver' => config('cache.default')];
            if (! $ok) {
                $healthy = false;
            }
        } catch (\Exception $e) {
            $checks['cache'] = ['status' => 'fail', 'error' => $e->getMessage()];
            $healthy = false;
        }

        // Queue
        try {
            $pending = DB::table('jobs')->count();
            $failed  = DB::table('failed_jobs')->count();
            $checks['queue'] = [
                'status'  => 'ok',
                'driver'  => config('queue.default'),
                'pending' => $pending,
                'failed'  => $failed,
            ];
        } catch (\Exception $e) {
            $checks['queue'] = ['status' => 'fail', 'error' => $e->getMessage()];
        }

        return response()->json([
            'status'  => $healthy ? 'healthy' : 'degraded',
            'version' => config('app.version', '1.0.0'),
            'checks'  => $checks,
        ], $healthy ? 200 : 503);
    }

    /**
     * Service discovery metadata.
     * Public callers get minimal info; authenticated admins get full details.
     */
    public function status(): JsonResponse
    {
        $base = [
            'service' => config('app.name'),
            'status'  => 'ok',
        ];

        // Detailed info only for authenticated admins — prevents version fingerprinting
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            $base += [
                'version'      => config('app.version', '1.0.0'),
                'environment'  => config('app.env'),
                'region'       => env('APP_REGION', 'sulbagsel'),
                'php_version'  => PHP_VERSION,
                'laravel'      => app()->version(),
                'capabilities' => ['web', 'queue', 'storage', '2fa', 'pdf-generation'],
                'endpoints'    => [
                    'health' => url('/api/health'),
                    'ping'   => url('/api/ping'),
                    'up'     => url('/up'),
                ],
                'dependencies' => [
                    'database' => config('database.default'),
                    'cache'    => config('cache.default'),
                    'queue'    => config('queue.default'),
                    'session'  => config('session.driver'),
                    'storage'  => config('filesystems.default'),
                ],
            ];
        }

        return response()->json($base);
    }
}

