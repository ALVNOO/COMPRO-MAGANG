@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $baseClasses = 'btn';

    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline-primary',
        'ghost' => 'btn-ghost',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
    ];

    $sizes = [
        'sm' => 'btn-sm',
        'md' => '',
        'lg' => 'btn-lg',
        'icon' => 'btn-icon',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? '');
@endphp

@if($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled) aria-disabled="true" @endif
    >
        @if($loading)
            <i class="fas fa-spinner animate-spin"></i>
        @elseif($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="{{ $icon }}"></i>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled || $loading) disabled @endif
    >
        @if($loading)
            <i class="fas fa-spinner animate-spin"></i>
        @elseif($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right' && !$loading)
            <i class="{{ $icon }}"></i>
        @endif
    </button>
@endif
