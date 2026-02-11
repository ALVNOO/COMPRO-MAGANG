{{--
    STAT CARD COMPONENT
    Reusable statistic card with icon, value, and label

    Required:
    - $value: The main value to display
    - $label: Description label

    Optional:
    - $icon: FontAwesome icon class (e.g., 'fa-users')
    - $color: 'primary' | 'success' | 'warning' | 'danger' | 'info' | 'purple' | 'cyan'
    - $suffix: Suffix for value (e.g., '%')
    - $prefix: Prefix for value (e.g., 'Rp')
    - $trend: 'up' | 'down' | null
    - $trendValue: Trend percentage or value
    - $animate: boolean - animate counter on scroll
    - $link: URL to link the card
--}}

@php
    $color = $color ?? 'primary';
    $icon = $icon ?? 'fa-chart-line';
    $animate = $animate ?? true;

    $colorClasses = [
        'primary' => 'stat-primary',
        'success' => 'stat-success',
        'warning' => 'stat-warning',
        'danger' => 'stat-danger',
        'info' => 'stat-info',
        'purple' => 'stat-purple',
        'cyan' => 'stat-cyan',
    ];

    $colorClass = $colorClasses[$color] ?? 'stat-primary';
@endphp

@if(isset($link))
<a href="{{ $link }}" class="stat-card-link">
@endif

<div class="stat-card {{ $colorClass }} {{ $animate ? 'animate-counter' : '' }}" data-value="{{ $value }}">
    <div class="stat-card-header">
        <div class="stat-icon-wrapper">
            <i class="fas {{ $icon }}"></i>
        </div>
        @if(isset($trend))
            <div class="stat-trend {{ $trend === 'up' ? 'trend-up' : 'trend-down' }}">
                <i class="fas {{ $trend === 'up' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                <span>{{ $trendValue ?? '' }}</span>
            </div>
        @endif
    </div>

    <div class="stat-card-body">
        <div class="stat-value">
            @if(isset($prefix))<span class="stat-prefix">{{ $prefix }}</span>@endif
            <span class="stat-number" data-target="{{ $value }}">{{ $animate ? '0' : $value }}</span>
            @if(isset($suffix))<span class="stat-suffix">{{ $suffix }}</span>@endif
        </div>
        <div class="stat-label">{{ $label }}</div>
    </div>

    <div class="stat-card-glow"></div>
</div>

@if(isset($link))
</a>
@endif

<style>
/* ============================================
   STAT CARD STYLES
   ============================================ */

.stat-card-link {
    text-decoration: none;
    display: block;
}

.stat-card {
    position: relative;
    background: var(--color-white);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--color-gray-100);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.stat-card-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.25rem;
}

.stat-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    transition: transform 0.3s;
}

.stat-card:hover .stat-icon-wrapper {
    transform: scale(1.1) rotate(-5deg);
}

/* Color Variants */
.stat-primary .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.15) 0%, rgba(238, 46, 36, 0.05) 100%);
    color: var(--color-primary);
}

.stat-success .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #10B981;
}

.stat-warning .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: #F59E0B;
}

.stat-danger .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: #EF4444;
}

.stat-info .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0.05) 100%);
    color: #3B82F6;
}

.stat-purple .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(139, 92, 246, 0.05) 100%);
    color: #8B5CF6;
}

.stat-cyan .stat-icon-wrapper {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 100%);
    color: #06B6D4;
}

/* Trend Badge */
.stat-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.3rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.trend-up {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.trend-down {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.stat-trend i {
    font-size: 0.65rem;
}

/* Card Body */
.stat-card-body {
    position: relative;
    z-index: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-gray-900);
    line-height: 1.2;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: baseline;
    gap: 0.15rem;
}

.stat-prefix,
.stat-suffix {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--color-gray-600);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--color-gray-500);
    font-weight: 500;
}

/* Glow Effect */
.stat-card-glow {
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    filter: blur(60px);
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
    right: -30px;
    bottom: -30px;
}

.stat-card:hover .stat-card-glow {
    opacity: 0.4;
}

.stat-primary .stat-card-glow { background: var(--color-primary); }
.stat-success .stat-card-glow { background: #10B981; }
.stat-warning .stat-card-glow { background: #F59E0B; }
.stat-danger .stat-card-glow { background: #EF4444; }
.stat-info .stat-card-glow { background: #3B82F6; }
.stat-purple .stat-card-glow { background: #8B5CF6; }
.stat-cyan .stat-card-glow { background: #06B6D4; }

/* Accent Line */
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 20px 20px 0 0;
}

.stat-primary::before { background: linear-gradient(90deg, var(--color-primary), #FF6B6B); }
.stat-success::before { background: linear-gradient(90deg, #10B981, #34D399); }
.stat-warning::before { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
.stat-danger::before { background: linear-gradient(90deg, #EF4444, #F87171); }
.stat-info::before { background: linear-gradient(90deg, #3B82F6, #60A5FA); }
.stat-purple::before { background: linear-gradient(90deg, #8B5CF6, #A78BFA); }
.stat-cyan::before { background: linear-gradient(90deg, #06B6D4, #22D3EE); }

/* Responsive */
@media (max-width: 768px) {
    .stat-card {
        padding: 1.25rem;
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        font-size: 1.1rem;
    }

    .stat-value {
        font-size: 1.75rem;
    }
}
</style>
