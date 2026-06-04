<?php

use App\Http\Controllers\Api\HealthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Health, monitoring, and service discovery endpoints.
| These routes are publicly accessible (no auth required).
*/

Route::get('/ping',   [HealthController::class, 'ping'])->name('api.ping');
Route::get('/health', [HealthController::class, 'health'])->name('api.health');
Route::get('/status', [HealthController::class, 'status'])->name('api.status');
