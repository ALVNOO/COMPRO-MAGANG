@props([
    'value'       => '0',
    'label'       => '',
    'icon'        => null,
    'iconVariant' => 'primary',
    'trend'       => null,   {{-- 'up' | 'down' | 'flat' --}}
    'trendValue'  => null,   {{-- e.g. '+12' --}}
    'trendLabel'  => null,   {{-- e.g. 'minggu ini' --}}
])

@php
    $iconVariants = [
        'primary' => 'stat-icon-primary',
        'success' => 'stat-icon-success',
        'warning' => 'stat-icon-warning',
        'info'    => 'stat-icon-info',
        'danger'  => 'stat-icon-danger',
    ];

    $cardVariants = [
        'primary' => 'stat-card-primary',
        'success' => 'stat-card-success',
        'warning' => 'stat-card-warning',
        'info'    => 'stat-card-info',
        'danger'  => 'stat-card-danger',
    ];

    $trendIcons = [
        'up'   => 'fas fa-arrow-up',
        'down' => 'fas fa-arrow-down',
        'flat' => 'fas fa-minus',
    ];

    $cardClass    = 'stat-card ' . ($cardVariants[$iconVariant] ?? '');
    $iconClass    = $iconVariants[$iconVariant] ?? $iconVariants['primary'];
    $trendClass   = $trend ? 'stat-trend stat-trend-' . $trend : null;
    $trendIconCls = $trendIcons[$trend] ?? 'fas fa-minus';
@endphp

<div {{ $attributes->merge(['class' => $cardClass]) }}>
    <div class="stat-card-header">
        <div class="stat-meta">
            <div class="stat-value">{{ $value }}</div>
            <div class="stat-label">{{ $label }}</div>
        </div>
        @if($icon)
            <div class="stat-icon {{ $iconClass }}">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
    </div>

    @if($trend && $trendValue)
        <div class="{{ $trendClass }}">
            <span class="stat-trend-badge">
                <i class="{{ $trendIconCls }}"></i>
                {{ $trendValue }}
            </span>
            @if($trendLabel)
                <span class="stat-trend-context">{{ $trendLabel }}</span>
            @endif
        </div>
    @endif
</div>
