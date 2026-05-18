@props([
    'src' => null,
    'alt' => '',
    'name' => null,
    'size' => 'md'
])

@php
    $sizes = [
        'xs' => 'avatar-xs',
        'sm' => 'avatar-sm',
        'md' => 'avatar-md',
        'lg' => 'avatar-lg',
        'xl' => 'avatar-xl',
        '2xl' => 'avatar-2xl',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // Get initials from name
    $initials = '';
    if ($name && !$src) {
        $words = explode(' ', $name);
        $initials = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) {
            $initials .= strtoupper(substr(end($words), 0, 1));
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'avatar ' . $sizeClass]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt ?: $name }}">
    @elseif($initials)
        {{ $initials }}
    @else
        <i class="fas fa-user"></i>
    @endif
</div>
