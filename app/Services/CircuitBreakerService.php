<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Cache-backed circuit breaker for external service calls (SMTP, etc.).
 *
 * States:
 *  CLOSED  — normal operation, calls go through
 *  OPEN    — too many failures, calls are rejected until cooldown expires
 *  HALF-OPEN — cooldown expired, next call probes the service
 */
class CircuitBreakerService
{
    private string $cacheKey;

    public function __construct(
        private readonly string $serviceName,
        private readonly int $failureThreshold = 5,
        private readonly int $cooldownSeconds = 60,
    ) {
        $this->cacheKey = "circuit_breaker.{$serviceName}";
    }

    public function isOpen(): bool
    {
        $state = $this->state();

        if ($state['open_until'] && now()->timestamp < $state['open_until']) {
            return true;
        }

        return false;
    }

    public function recordSuccess(): void
    {
        Cache::forget($this->cacheKey);
    }

    public function recordFailure(): void
    {
        $state = $this->state();
        $state['failures']++;

        if ($state['failures'] >= $this->failureThreshold) {
            $state['open_until'] = now()->addSeconds($this->cooldownSeconds)->timestamp;
            Log::warning("[CircuitBreaker] {$this->serviceName} tripped OPEN after {$state['failures']} failures. Cooldown: {$this->cooldownSeconds}s.");
        }

        Cache::put($this->cacheKey, $state, now()->addHours(2));
    }

    /**
     * Execute $action through the circuit breaker.
     * If the circuit is open, $fallback is called instead (or null returned).
     * On exception, records failure then re-throws unless $fallback is provided.
     */
    public function call(callable $action, ?callable $fallback = null): mixed
    {
        if ($this->isOpen()) {
            Log::info("[CircuitBreaker] {$this->serviceName} is OPEN — skipping call.");
            return $fallback ? $fallback() : null;
        }

        try {
            $result = $action();
            $this->recordSuccess();
            return $result;
        } catch (\Exception $e) {
            $this->recordFailure();
            Log::error("[CircuitBreaker] {$this->serviceName} failure: {$e->getMessage()}");

            if ($fallback) {
                return $fallback();
            }

            throw $e;
        }
    }

    private function state(): array
    {
        return Cache::get($this->cacheKey, ['failures' => 0, 'open_until' => null]);
    }
}
