@props([
    'status' => 'pending'
])

@php
    $statuses = [
        'pending' => [
            'class' => 'status-badge status-pending',
            'icon' => 'fas fa-clock',
            'label' => 'Menunggu'
        ],
        'accepted' => [
            'class' => 'status-badge status-accepted',
            'icon' => 'fas fa-check',
            'label' => 'Diterima'
        ],
        'rejected' => [
            'class' => 'status-badge status-rejected',
            'icon' => 'fas fa-times',
            'label' => 'Ditolak'
        ],
        'active' => [
            'class' => 'status-badge status-active',
            'icon' => 'fas fa-play',
            'label' => 'Aktif'
        ],
        'finished' => [
            'class' => 'status-badge status-finished',
            'icon' => 'fas fa-flag-checkered',
            'label' => 'Selesai'
        ],
        'present' => [
            'class' => 'badge badge-success',
            'icon' => 'fas fa-check-circle',
            'label' => 'Hadir'
        ],
        'absent' => [
            'class' => 'badge badge-danger',
            'icon' => 'fas fa-times-circle',
            'label' => 'Tidak Hadir'
        ],
        'late' => [
            'class' => 'badge badge-warning',
            'icon' => 'fas fa-clock',
            'label' => 'Terlambat'
        ],
        'permission' => [
            'class' => 'badge badge-info',
            'icon' => 'fas fa-file-alt',
            'label' => 'Izin'
        ],
    ];

    $statusConfig = $statuses[$status] ?? $statuses['pending'];
@endphp

<span {{ $attributes->merge(['class' => $statusConfig['class']]) }}>
    <i class="{{ $statusConfig['icon'] }}"></i>
    {{ $slot->isEmpty() ? $statusConfig['label'] : $slot }}
</span>
