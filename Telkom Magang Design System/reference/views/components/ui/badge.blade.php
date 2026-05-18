@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null
])

@php
    $variants = [
        'primary' => 'badge-primary',
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'danger' => 'badge-danger',
        'info' => 'badge-info',
        'gray' => 'badge-gray',
    ];

    $badgeClass = 'badge ' . ($variants[$variant] ?? $variants['primary']);
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    {{ $slot }}
</span>
