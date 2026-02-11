{{--
    Progress Bar Component

    Usage:
    <x-ui.progress-bar :value="75" />
    <x-ui.progress-bar :value="50" showLabel />
    <x-ui.progress-bar :value="25" variant="success" size="lg" />
--}}

@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'size' => 'md',
    'showLabel' => false,
    'labelPosition' => 'right',
    'animated' => true,
    'striped' => false
])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));

    $variants = [
        'primary' => 'progress-primary',
        'success' => 'progress-success',
        'warning' => 'progress-warning',
        'danger' => 'progress-danger',
        'info' => 'progress-info',
    ];

    $sizes = [
        'xs' => 'progress-xs',
        'sm' => 'progress-sm',
        'md' => 'progress-md',
        'lg' => 'progress-lg',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'progress-container']) }}>
    @if($showLabel && $labelPosition === 'top')
        <div class="progress-label-top">
            <span class="progress-text">{{ $slot->isEmpty() ? '' : $slot }}</span>
            <span class="progress-percentage">{{ round($percentage) }}%</span>
        </div>
    @endif

    <div class="progress-wrapper">
        <div class="progress-track {{ $sizeClass }}">
            <div
                class="progress-bar {{ $variantClass }} {{ $animated ? 'progress-animated' : '' }} {{ $striped ? 'progress-striped' : '' }}"
                style="width: {{ $percentage }}%"
                role="progressbar"
                aria-valuenow="{{ $value }}"
                aria-valuemin="0"
                aria-valuemax="{{ $max }}"
            >
                @if($showLabel && $labelPosition === 'inside' && $percentage > 10)
                    <span class="progress-label-inside">{{ round($percentage) }}%</span>
                @endif
            </div>
        </div>

        @if($showLabel && $labelPosition === 'right')
            <span class="progress-label-right">{{ round($percentage) }}%</span>
        @endif
    </div>

    @if($showLabel && $labelPosition === 'bottom')
        <div class="progress-label-bottom">
            <span class="progress-text">{{ $slot->isEmpty() ? '' : $slot }}</span>
            <span class="progress-percentage">{{ round($percentage) }}%</span>
        </div>
    @endif
</div>

@once
<style>
    .progress-container {
        width: 100%;
    }

    .progress-wrapper {
        display: flex;
        align-items: center;
        gap: var(--space-3);
    }

    .progress-track {
        flex: 1;
        background: var(--color-gray-200);
        border-radius: var(--radius-full);
        overflow: hidden;
    }

    .progress-xs { height: 4px; }
    .progress-sm { height: 6px; }
    .progress-md { height: 8px; }
    .progress-lg { height: 12px; }

    .progress-bar {
        height: 100%;
        border-radius: var(--radius-full);
        transition: width 0.5s ease-out;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .progress-primary { background: var(--gradient-primary); }
    .progress-success { background: var(--gradient-success); }
    .progress-warning { background: var(--gradient-warning); }
    .progress-danger { background: linear-gradient(135deg, var(--color-danger) 0%, var(--color-danger-dark) 100%); }
    .progress-info { background: var(--gradient-info); }

    .progress-animated {
        animation: progress-pulse 2s ease-in-out infinite;
    }

    @keyframes progress-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .progress-striped {
        background-image: linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.15) 25%,
            transparent 25%,
            transparent 50%,
            rgba(255, 255, 255, 0.15) 50%,
            rgba(255, 255, 255, 0.15) 75%,
            transparent 75%,
            transparent
        );
        background-size: 1rem 1rem;
        animation: progress-stripes 1s linear infinite;
    }

    @keyframes progress-stripes {
        0% { background-position: 1rem 0; }
        100% { background-position: 0 0; }
    }

    .progress-label-inside {
        font-size: var(--text-xs);
        font-weight: var(--font-semibold);
        color: var(--color-white);
        padding-right: var(--space-2);
    }

    .progress-label-right {
        font-size: var(--text-sm);
        font-weight: var(--font-semibold);
        color: var(--color-gray-700);
        min-width: 45px;
        text-align: right;
    }

    .progress-label-top,
    .progress-label-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: var(--text-sm);
    }

    .progress-label-top {
        margin-bottom: var(--space-2);
    }

    .progress-label-bottom {
        margin-top: var(--space-2);
    }

    .progress-text {
        color: var(--color-gray-600);
    }

    .progress-percentage {
        font-weight: var(--font-semibold);
        color: var(--color-gray-700);
    }
</style>
@endonce
