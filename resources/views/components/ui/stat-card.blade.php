@props([
    'value' => '0',
    'label' => '',
    'icon' => null,
    'iconVariant' => 'primary',
    'description' => null,
    'trend' => null,
    'trendValue' => null
])

@php
    $iconVariants = [
        'primary' => 'stat-icon-primary',
        'success' => 'stat-icon-success',
        'warning' => 'stat-icon-warning',
        'info' => 'stat-icon-info',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'stat-card']) }}>
    @if($icon)
        <div class="stat-icon {{ $iconVariants[$iconVariant] ?? $iconVariants['primary'] }}">
            <i class="{{ $icon }}"></i>
        </div>
    @endif

    <div class="stat-value">{{ $value }}</div>
    <div class="stat-label">{{ $label }}</div>

    @if($description)
        <div class="stat-description text-sm text-gray-500 mt-2">{{ $description }}</div>
    @endif

    @if($trend && $trendValue)
        <div class="stat-trend mt-3 flex items-center gap-1 text-sm">
            @if($trend === 'up')
                <i class="fas fa-arrow-up text-success"></i>
                <span class="text-success">{{ $trendValue }}</span>
            @elseif($trend === 'down')
                <i class="fas fa-arrow-down text-danger"></i>
                <span class="text-danger">{{ $trendValue }}</span>
            @else
                <i class="fas fa-minus text-gray-500"></i>
                <span class="text-gray-500">{{ $trendValue }}</span>
            @endif
        </div>
    @endif
</div>
