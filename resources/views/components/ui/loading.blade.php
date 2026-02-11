{{--
    Loading Indicator Component

    Usage:
    <x-ui.loading />
    <x-ui.loading type="spinner" size="lg" />
    <x-ui.loading type="dots" />
    <x-ui.loading type="overlay" text="Memproses..." />
--}}

@props([
    'type' => 'spinner',
    'size' => 'md',
    'text' => null,
    'fullscreen' => false
])

@php
    $sizes = [
        'xs' => 'w-4 h-4',
        'sm' => 'w-5 h-5',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

@switch($type)
    @case('spinner')
        <div {{ $attributes->merge(['class' => 'loading-container']) }}>
            <div class="loading-spinner {{ $sizeClass }}">
                <svg class="animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            @if($text)
                <span class="loading-text">{{ $text }}</span>
            @endif
        </div>
        @break

    @case('dots')
        <div {{ $attributes->merge(['class' => 'loading-container']) }}>
            <div class="loading-dots">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
            @if($text)
                <span class="loading-text">{{ $text }}</span>
            @endif
        </div>
        @break

    @case('pulse')
        <div {{ $attributes->merge(['class' => 'loading-container']) }}>
            <div class="loading-pulse {{ $sizeClass }}"></div>
            @if($text)
                <span class="loading-text">{{ $text }}</span>
            @endif
        </div>
        @break

    @case('bar')
        <div {{ $attributes->merge(['class' => 'loading-bar-container']) }}>
            <div class="loading-bar">
                <div class="loading-bar-progress"></div>
            </div>
            @if($text)
                <span class="loading-text">{{ $text }}</span>
            @endif
        </div>
        @break

    @case('overlay')
        <div {{ $attributes->merge(['class' => 'loading-overlay' . ($fullscreen ? ' fullscreen' : '')]) }}>
            <div class="loading-overlay-content">
                <div class="loading-spinner {{ $sizeClass }}">
                    <svg class="animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                @if($text)
                    <span class="loading-text">{{ $text }}</span>
                @endif
            </div>
        </div>
        @break
@endswitch

@once
<style>
    .loading-container {
        display: inline-flex;
        align-items: center;
        gap: var(--space-3);
    }

    .loading-spinner {
        color: var(--color-primary);
    }

    .loading-spinner svg {
        width: 100%;
        height: 100%;
    }

    .loading-text {
        font-size: var(--text-sm);
        color: var(--color-gray-600);
        font-weight: var(--font-medium);
    }

    /* Dots animation */
    .loading-dots {
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .loading-dots .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--color-primary);
        animation: loading-dots 1.4s ease-in-out infinite;
    }

    .loading-dots .dot:nth-child(1) { animation-delay: 0s; }
    .loading-dots .dot:nth-child(2) { animation-delay: 0.2s; }
    .loading-dots .dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes loading-dots {
        0%, 80%, 100% {
            transform: scale(0.6);
            opacity: 0.5;
        }
        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Pulse animation */
    .loading-pulse {
        border-radius: 50%;
        background: var(--color-primary);
        animation: loading-pulse 1.5s ease-in-out infinite;
    }

    @keyframes loading-pulse {
        0% {
            transform: scale(0.8);
            opacity: 0.5;
        }
        50% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }
    }

    /* Bar animation */
    .loading-bar-container {
        width: 100%;
    }

    .loading-bar {
        width: 100%;
        height: 4px;
        background: var(--color-gray-200);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .loading-bar-progress {
        width: 30%;
        height: 100%;
        background: var(--gradient-primary);
        border-radius: var(--radius-full);
        animation: loading-bar 1.5s ease-in-out infinite;
    }

    @keyframes loading-bar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(400%); }
    }

    /* Overlay */
    .loading-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        z-index: var(--z-modal);
        border-radius: inherit;
    }

    .loading-overlay.fullscreen {
        position: fixed;
        border-radius: 0;
    }

    .loading-overlay-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-4);
    }

    .loading-overlay .loading-text {
        font-size: var(--text-base);
        color: var(--color-gray-700);
    }

    /* Utility classes for components */
    .is-loading {
        position: relative;
        pointer-events: none;
    }

    .is-loading::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        border-radius: inherit;
    }

    .btn.is-loading {
        color: transparent !important;
    }

    .btn.is-loading::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    .btn-primary.is-loading::before {
        border-top-color: var(--color-white);
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endonce
