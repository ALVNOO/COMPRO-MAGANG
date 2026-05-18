@php
    $color = $color ?? 'primary';
    $icon  = $icon  ?? 'fa-chart-line';

    $colorMap = [
        'primary' => ['card' => 'stat-card-primary', 'icon' => 'stat-icon-primary'],
        'success' => ['card' => 'stat-card-success', 'icon' => 'stat-icon-success'],
        'warning' => ['card' => 'stat-card-warning', 'icon' => 'stat-icon-warning'],
        'danger'  => ['card' => 'stat-card-danger',  'icon' => 'stat-icon-danger'],
        'info'    => ['card' => 'stat-card-info',    'icon' => 'stat-icon-info'],
        'purple'  => ['card' => 'stat-card-primary', 'icon' => 'stat-icon-primary'],
        'cyan'    => ['card' => 'stat-card-info',    'icon' => 'stat-icon-info'],
    ];

    $variants  = $colorMap[$color] ?? $colorMap['primary'];
    $cardClass = 'stat-card ' . $variants['card'];
    $iconClass = $variants['icon'];

    $trendIcons = [
        'up'   => 'fa-arrow-up',
        'down' => 'fa-arrow-down',
        'flat' => 'fa-minus',
    ];
@endphp

@if(isset($link))
<a href="{{ $link }}" class="stat-card-link">
@endif

<div class="{{ $cardClass }}">
    <div class="stat-card-header">
        <div class="stat-meta">
            <div class="stat-value">{{ (isset($prefix) ? $prefix : '') . $value . (isset($suffix) ? $suffix : '') }}</div>
            <div class="stat-label">{{ $label }}</div>
        </div>
        <div class="stat-icon {{ $iconClass }}">
            <i class="fas {{ $icon }}"></i>
        </div>
    </div>

    @if(isset($trend) && isset($trendValue))
        <div class="stat-trend stat-trend-{{ $trend }}">
            <span class="stat-trend-badge">
                <i class="fas {{ $trendIcons[$trend] ?? 'fa-minus' }}"></i>
                {{ $trendValue }}
            </span>
            @if(isset($trendLabel))
                <span class="stat-trend-context">{{ $trendLabel }}</span>
            @endif
        </div>
    @endif
</div>

@if(isset($link))
</a>
@endif
