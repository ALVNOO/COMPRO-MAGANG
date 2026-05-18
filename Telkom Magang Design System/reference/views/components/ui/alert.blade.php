@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
    'icon' => null
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

    $alertClass = 'alert ' . ($types[$type] ?? $types['info']);
    $iconClass  = $icon ?? ($icons[$type] ?? $icons['info']);
@endphp

<div {{ $attributes->merge(['class' => $alertClass]) }} role="alert">
    <div class="alert-icon-box">
        <i class="{{ $iconClass }}"></i>
    </div>
    <div class="alert-content">
        @if($title)
            <div class="alert-title">{{ $title }}</div>
        @endif
        <div class="alert-message">
            {{ $slot }}
        </div>
    </div>
    @if($dismissible)
        <button type="button" class="alert-dismiss" onclick="this.closest('[role=alert]').remove()" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    @endif
</div>
