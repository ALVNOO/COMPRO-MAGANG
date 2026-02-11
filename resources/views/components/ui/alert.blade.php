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
        'danger' => 'alert-danger',
        'error' => 'alert-danger',
        'info' => 'alert-info',
    ];

    $icons = [
        'success' => 'fas fa-check-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'danger' => 'fas fa-times-circle',
        'error' => 'fas fa-times-circle',
        'info' => 'fas fa-info-circle',
    ];

    $alertClass = 'alert ' . ($types[$type] ?? $types['info']);
    $iconClass = $icon ?? ($icons[$type] ?? $icons['info']);
@endphp

<div {{ $attributes->merge(['class' => $alertClass]) }} role="alert">
    <div class="alert-icon">
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
        <button type="button" class="btn-ghost btn-icon" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    @endif
</div>
