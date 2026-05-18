{{--
    GLASSMORPHISM CARD COMPONENT
    Reusable glass-effect card wrapper

    Optional:
    - $title: Card title
    - $subtitle: Card subtitle
    - $icon: FontAwesome icon class
    - $headerActions: Slot for header action buttons
    - $footer: Slot for footer content
    - $noPadding: boolean - remove body padding
    - $class: Additional CSS classes
--}}

@php
    $noPadding = $noPadding ?? false;
@endphp

<div class="glass-card {{ $class ?? '' }}">
    @if(isset($title) || isset($headerActions))
        <div class="glass-card-header">
            <div class="glass-card-title-section">
                @if(isset($icon))
                    <div class="glass-card-icon">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                @endif
                <div class="glass-card-title-text">
                    @if(isset($title))
                        <h3 class="glass-card-title">{{ $title }}</h3>
                    @endif
                    @if(isset($subtitle))
                        <p class="glass-card-subtitle">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if(isset($headerActions))
                <div class="glass-card-actions">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="glass-card-body {{ $noPadding ? 'no-padding' : '' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="glass-card-footer">
            {{ $footer }}
        </div>
    @endif
</div>

<style>
/* ============================================
   GLASSMORPHISM CARD STYLES
   ============================================ */

.glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow:
        0 4px 24px rgba(0, 0, 0, 0.06),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.glass-card:hover {
    box-shadow:
        0 8px 40px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    transform: translateY(-2px);
}

/* Header */
.glass-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    background: rgba(255, 255, 255, 0.5);
}

.glass-card-title-section {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.glass-card-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, var(--color-primary) 0%, #FF6B6B 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.25);
}

.glass-card-title-text {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.glass-card-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-gray-900);
    margin: 0;
    line-height: 1.3;
}

.glass-card-subtitle {
    font-size: 0.8rem;
    color: var(--color-gray-500);
    margin: 0;
}

.glass-card-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Body */
.glass-card-body {
    padding: 1.5rem;
}

.glass-card-body.no-padding {
    padding: 0;
}

/* Footer */
.glass-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    background: rgba(0, 0, 0, 0.02);
}

/* Variants */
.glass-card.glass-card-dark {
    background: rgba(26, 26, 26, 0.9);
    border-color: rgba(255, 255, 255, 0.1);
    color: var(--color-white);
}

.glass-card.glass-card-dark .glass-card-header {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.1);
}

.glass-card.glass-card-dark .glass-card-title {
    color: var(--color-white);
}

.glass-card.glass-card-dark .glass-card-subtitle {
    color: rgba(255, 255, 255, 0.6);
}

.glass-card.glass-card-accent {
    border-top: 4px solid var(--color-primary);
    border-radius: 4px 4px 20px 20px;
}

.glass-card.glass-card-success {
    border-top: 4px solid #10B981;
}

.glass-card.glass-card-warning {
    border-top: 4px solid #F59E0B;
}

.glass-card.glass-card-info {
    border-top: 4px solid #3B82F6;
}

/* Responsive */
@media (max-width: 768px) {
    .glass-card-header {
        padding: 1rem 1.25rem;
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .glass-card-body {
        padding: 1.25rem;
    }

    .glass-card-icon {
        width: 38px;
        height: 38px;
        font-size: 1rem;
    }
}
</style>
