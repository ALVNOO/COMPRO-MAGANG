{{--
    Empty State Component

    Usage:
    <x-ui.empty-state
        title="Belum ada data"
        description="Data yang Anda cari tidak ditemukan"
        icon="inbox"
        :action="['text' => 'Tambah Data', 'href' => '/create']"
    />
--}}

@props([
    'title' => 'Tidak ada data',
    'description' => null,
    'icon' => 'inbox',
    'action' => null,
    'size' => 'md'
])

@php
    $icons = [
        'inbox' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>',
        'document' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
        'users' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
        'calendar' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        'search' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>',
        'folder' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>',
        'clipboard' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>',
        'bell' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>',
        'chart' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
        'task' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
        'error' => '<svg class="empty-state-svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
    ];

    $sizes = [
        'sm' => 'empty-state-sm',
        'md' => 'empty-state-md',
        'lg' => 'empty-state-lg',
    ];

    $iconSvg = $icons[$icon] ?? $icons['inbox'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'empty-state ' . $sizeClass]) }}>
    <div class="empty-state-icon">
        {!! $iconSvg !!}
    </div>

    <h3 class="empty-state-title">{{ $title }}</h3>

    @if($description)
        <p class="empty-state-description">{{ $description }}</p>
    @endif

    {{ $slot }}

    @if($action)
        <div class="empty-state-action">
            @if(isset($action['href']))
                <a href="{{ $action['href'] }}" class="btn btn-primary">
                    @if(isset($action['icon']))
                        <i class="{{ $action['icon'] }}"></i>
                    @endif
                    {{ $action['text'] ?? 'Mulai' }}
                </a>
            @elseif(isset($action['onclick']))
                <button type="button" class="btn btn-primary" onclick="{{ $action['onclick'] }}">
                    @if(isset($action['icon']))
                        <i class="{{ $action['icon'] }}"></i>
                    @endif
                    {{ $action['text'] ?? 'Mulai' }}
                </button>
            @endif
        </div>
    @endif
</div>

@once
<style>
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: var(--space-10);
    }

    .empty-state-sm {
        padding: var(--space-6);
    }

    .empty-state-sm .empty-state-icon {
        width: 48px;
        height: 48px;
        margin-bottom: var(--space-3);
    }

    .empty-state-sm .empty-state-title {
        font-size: var(--text-base);
    }

    .empty-state-sm .empty-state-description {
        font-size: var(--text-sm);
    }

    .empty-state-md {
        padding: var(--space-10);
    }

    .empty-state-lg {
        padding: var(--space-16);
    }

    .empty-state-lg .empty-state-icon {
        width: 96px;
        height: 96px;
    }

    .empty-state-lg .empty-state-title {
        font-size: var(--text-2xl);
    }

    .empty-state-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--color-gray-100);
        border-radius: var(--radius-full);
        margin-bottom: var(--space-4);
        color: var(--color-gray-400);
    }

    .empty-state-svg {
        width: 50%;
        height: 50%;
    }

    .empty-state-title {
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--color-gray-900);
        margin: 0 0 var(--space-2);
    }

    .empty-state-description {
        font-size: var(--text-base);
        color: var(--color-gray-500);
        margin: 0 0 var(--space-6);
        max-width: 400px;
    }

    .empty-state-action {
        margin-top: var(--space-4);
    }

    /* Illustrated empty state variant */
    .empty-state-illustrated .empty-state-icon {
        width: 200px;
        height: 200px;
        background: transparent;
    }

    .empty-state-illustrated .empty-state-svg {
        width: 100%;
        height: 100%;
    }
</style>
@endonce
