@props([
    'type'        => 'info',
    'variant'     => null,       {{-- null | 'compact' | 'filled' | 'banner' --}}
    'title'       => null,
    'dismissible' => false,
    'icon'        => null,
])

@php
    $types = [
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger'  => 'alert-danger',
        'error'   => 'alert-danger',
        'info'    => 'alert-info',
    ];

    $icons = [
        'success' => 'fas fa-check',
        'warning' => 'fas fa-exclamation',
        'danger'  => 'fas fa-times',
        'error'   => 'fas fa-times',
        'info'    => 'fas fa-info',
    ];

    $typeKey   = array_key_exists($type, $types) ? $type : 'info';
    $typeClass = $types[$typeKey];
    $iconClass = $icon ?? $icons[$typeKey];

    $variantClass = match($variant) {
        'compact' => 'alert-compact',
        'filled'  => 'alert-filled alert-filled-' . ($typeKey === 'error' ? 'danger' : $typeKey),
        'banner'  => 'alert-banner',
        default   => '',
    };

    $alertClass = trim('alert ' . $typeClass . ($variantClass ? ' ' . $variantClass : ''));
@endphp

<div {{ $attributes->merge(['class' => $alertClass]) }} role="alert">
    <div class="alert-icon-box">
        <i class="{{ $iconClass }}"></i>
    </div>
    <div class="alert-content">
        @if($title)
            <div class="alert-title">{{ $title }}</div>
        @endif
        @if($slot->isNotEmpty())
            <div class="alert-message">{{ $slot }}</div>
        @endif
    </div>
    @if($dismissible)
        <button type="button" class="alert-dismiss" onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    @endif
</div>
