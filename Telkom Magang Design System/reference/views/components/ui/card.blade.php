@props([
    'variant' => 'default',
    'padding' => true,
    'hover' => false,
    'accent' => null
])

@php
    $baseClasses = 'card';

    if ($variant === 'elevated') {
        $baseClasses .= ' card-elevated';
    }

    if ($hover) {
        $baseClasses .= ' card-elevated';
    }

    if ($accent) {
        $accentClasses = [
            'primary' => 'card-accent',
            'success' => 'card-accent-success',
            'warning' => 'card-accent-warning',
            'danger' => 'card-accent-danger',
            'info' => 'card-accent-info',
        ];
        $baseClasses .= ' ' . ($accentClasses[$accent] ?? 'card-accent');
    }
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if(isset($header))
        <div class="card-header">
            {{ $header }}
        </div>
    @endif

    <div class="{{ $padding ? 'card-body' : '' }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
