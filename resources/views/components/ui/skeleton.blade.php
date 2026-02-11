{{--
    Skeleton Loader Component

    Usage:
    <x-ui.skeleton type="text" />
    <x-ui.skeleton type="avatar" size="lg" />
    <x-ui.skeleton type="card" />
    <x-ui.skeleton type="table" :rows="5" />
--}}

@props([
    'type' => 'text',
    'size' => 'md',
    'width' => null,
    'height' => null,
    'rows' => 3,
    'columns' => 4,
    'count' => 1
])

@php
    $baseClass = 'skeleton-loader';
@endphp

@for($i = 0; $i < $count; $i++)
    @switch($type)
        @case('text')
            <div
                {{ $attributes->merge(['class' => $baseClass . ' skeleton-text']) }}
                style="{{ $width ? 'width: ' . $width . ';' : '' }}"
            ></div>
            @break

        @case('title')
            <div
                {{ $attributes->merge(['class' => $baseClass . ' skeleton-title']) }}
                style="{{ $width ? 'width: ' . $width . ';' : '' }}"
            ></div>
            @break

        @case('avatar')
            @php
                $sizes = [
                    'xs' => '24px',
                    'sm' => '32px',
                    'md' => '40px',
                    'lg' => '48px',
                    'xl' => '64px',
                    '2xl' => '80px'
                ];
                $avatarSize = $sizes[$size] ?? $sizes['md'];
            @endphp
            <div
                {{ $attributes->merge(['class' => $baseClass . ' skeleton-avatar']) }}
                style="width: {{ $avatarSize }}; height: {{ $avatarSize }};"
            ></div>
            @break

        @case('button')
            <div {{ $attributes->merge(['class' => $baseClass . ' skeleton-button']) }}></div>
            @break

        @case('image')
            <div
                {{ $attributes->merge(['class' => $baseClass . ' skeleton-image']) }}
                style="{{ $width ? 'width: ' . $width . ';' : '' }} {{ $height ? 'height: ' . $height . ';' : '' }}"
            ></div>
            @break

        @case('card')
            <div {{ $attributes->merge(['class' => 'skeleton-card']) }}>
                <div class="{{ $baseClass }} skeleton-image" style="height: 180px;"></div>
                <div class="skeleton-card-content">
                    <div class="{{ $baseClass }} skeleton-title" style="width: 70%;"></div>
                    <div class="{{ $baseClass }} skeleton-text" style="width: 100%;"></div>
                    <div class="{{ $baseClass }} skeleton-text" style="width: 85%;"></div>
                    <div class="skeleton-card-footer">
                        <div class="{{ $baseClass }} skeleton-avatar" style="width: 32px; height: 32px;"></div>
                        <div class="{{ $baseClass }} skeleton-text" style="width: 100px;"></div>
                    </div>
                </div>
            </div>
            @break

        @case('stat-card')
            <div {{ $attributes->merge(['class' => 'skeleton-stat-card']) }}>
                <div class="{{ $baseClass }} skeleton-avatar" style="width: 48px; height: 48px; border-radius: 12px;"></div>
                <div class="{{ $baseClass }} skeleton-title" style="width: 60%; margin-top: 16px;"></div>
                <div class="{{ $baseClass }} skeleton-text" style="width: 80%; margin-top: 8px;"></div>
            </div>
            @break

        @case('table')
            <div {{ $attributes->merge(['class' => 'skeleton-table']) }}>
                <div class="skeleton-table-header">
                    @for($col = 0; $col < $columns; $col++)
                        <div class="{{ $baseClass }} skeleton-text" style="width: {{ rand(60, 90) }}%;"></div>
                    @endfor
                </div>
                @for($row = 0; $row < $rows; $row++)
                    <div class="skeleton-table-row">
                        @for($col = 0; $col < $columns; $col++)
                            <div class="{{ $baseClass }} skeleton-text" style="width: {{ rand(50, 95) }}%;"></div>
                        @endfor
                    </div>
                @endfor
            </div>
            @break

        @case('list')
            <div {{ $attributes->merge(['class' => 'skeleton-list']) }}>
                @for($row = 0; $row < $rows; $row++)
                    <div class="skeleton-list-item">
                        <div class="{{ $baseClass }} skeleton-avatar" style="width: 40px; height: 40px;"></div>
                        <div class="skeleton-list-content">
                            <div class="{{ $baseClass }} skeleton-text" style="width: {{ rand(40, 70) }}%;"></div>
                            <div class="{{ $baseClass }} skeleton-text skeleton-text-sm" style="width: {{ rand(60, 90) }}%;"></div>
                        </div>
                    </div>
                @endfor
            </div>
            @break

        @case('form')
            <div {{ $attributes->merge(['class' => 'skeleton-form']) }}>
                @for($row = 0; $row < $rows; $row++)
                    <div class="skeleton-form-group">
                        <div class="{{ $baseClass }} skeleton-text skeleton-text-sm" style="width: 120px;"></div>
                        <div class="{{ $baseClass }} skeleton-input"></div>
                    </div>
                @endfor
                <div class="{{ $baseClass }} skeleton-button" style="width: 120px; margin-top: 16px;"></div>
            </div>
            @break

        @default
            <div
                {{ $attributes->merge(['class' => $baseClass]) }}
                style="{{ $width ? 'width: ' . $width . ';' : '' }} {{ $height ? 'height: ' . $height . ';' : '' }}"
            ></div>
    @endswitch
@endfor

@once
<style>
    .skeleton-loader {
        background: linear-gradient(
            90deg,
            var(--color-gray-200) 25%,
            var(--color-gray-100) 50%,
            var(--color-gray-200) 75%
        );
        background-size: 200% 100%;
        animation: skeleton-shimmer 1.5s infinite;
        border-radius: var(--radius-md);
    }

    @keyframes skeleton-shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .skeleton-text {
        height: 16px;
        margin-bottom: 8px;
    }

    .skeleton-text-sm {
        height: 12px;
    }

    .skeleton-title {
        height: 24px;
        margin-bottom: 12px;
    }

    .skeleton-avatar {
        border-radius: var(--radius-full);
        flex-shrink: 0;
    }

    .skeleton-button {
        height: 40px;
        width: 100px;
        border-radius: var(--radius-lg);
    }

    .skeleton-image {
        width: 100%;
        height: 200px;
        border-radius: var(--radius-lg);
    }

    .skeleton-input {
        height: 44px;
        width: 100%;
        border-radius: var(--radius-lg);
    }

    /* Card skeleton */
    .skeleton-card {
        background: var(--color-white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .skeleton-card-content {
        padding: var(--space-4);
    }

    .skeleton-card-footer {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        margin-top: var(--space-4);
    }

    /* Stat card skeleton */
    .skeleton-stat-card {
        background: var(--color-white);
        border-radius: var(--radius-xl);
        padding: var(--space-6);
        box-shadow: var(--shadow-sm);
    }

    /* Table skeleton */
    .skeleton-table {
        background: var(--color-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--color-gray-200);
    }

    .skeleton-table-header {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: var(--space-4);
        padding: var(--space-4);
        background: var(--color-gray-50);
        border-bottom: 1px solid var(--color-gray-200);
    }

    .skeleton-table-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: var(--space-4);
        padding: var(--space-4);
        border-bottom: 1px solid var(--color-gray-100);
    }

    .skeleton-table-row:last-child {
        border-bottom: none;
    }

    /* List skeleton */
    .skeleton-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .skeleton-list-item {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        padding: var(--space-3);
        background: var(--color-white);
        border-radius: var(--radius-lg);
    }

    .skeleton-list-content {
        flex: 1;
    }

    /* Form skeleton */
    .skeleton-form {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }

    .skeleton-form-group {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
    }
</style>
@endonce
