@extends('layouts.dashboard-unified')

@section('title', 'Notifikasi')

@php
    $role = Auth::user()->role === 'admin' ? 'admin' : (Auth::user()->role === 'mentor' ? 'mentor' : 'participant');
    $pageTitle = 'Notifikasi';
@endphp

@push('styles')
<style>
.notifications-page {
    padding: 2rem;
}

.notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.notifications-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-gray-900);
}

.mark-all-read-btn {
    padding: 0.5rem 1rem;
    background: var(--color-primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.mark-all-read-btn:hover {
    background: var(--color-primary-dark);
    transform: translateY(-2px);
}

.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notification-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    border: 1px solid var(--color-gray-200);
    transition: all 0.2s;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
}

.notification-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.notification-card.unread {
    background: rgba(238, 46, 36, 0.02);
    border-left: 4px solid var(--color-primary);
}

.notification-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.notification-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.notification-icon.info {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.notification-icon.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.notification-icon.error {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin-bottom: 0.25rem;
}

.notification-message {
    font-size: 0.875rem;
    color: var(--color-gray-600);
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.notification-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--color-gray-500);
}

.notification-time {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.notification-actions {
    display: flex;
    gap: 0.5rem;
}

.delete-btn {
    padding: 0.25rem 0.5rem;
    background: none;
    border: none;
    color: var(--color-gray-400);
    cursor: pointer;
    font-size: 0.875rem;
    transition: color 0.2s;
}

.delete-btn:hover {
    color: var(--color-danger);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--color-gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-gray-400);
    font-size: 2rem;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--color-gray-500);
    font-size: 0.875rem;
}

.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}
</style>
@endpush

@section('content')
<div class="notifications-page">
    <div class="notifications-header">
        <h1>Notifikasi</h1>
        @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="mark-all-read-btn">
                    <i class="fas fa-check-double"></i> Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if($notifications->count() > 0)
        <div class="notifications-list">
            @foreach($notifications as $notification)
                <a href="{{ $notification->link ?: '#' }}" 
                   class="notification-card {{ !$notification->is_read ? 'unread' : '' }}">
                    <div class="notification-icon {{ $notification->icon }}">
                        @if($notification->icon === 'success')
                            <i class="fas fa-check-circle"></i>
                        @elseif($notification->icon === 'info')
                            <i class="fas fa-info-circle"></i>
                        @elseif($notification->icon === 'warning')
                            <i class="fas fa-exclamation-triangle"></i>
                        @elseif($notification->icon === 'error')
                            <i class="fas fa-times-circle"></i>
                        @else
                            <i class="fas fa-bell"></i>
                        @endif
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">{{ $notification->title }}</div>
                        <div class="notification-message">{{ $notification->message }}</div>
                        <div class="notification-meta">
                            <span class="notification-time">
                                <i class="fas fa-clock"></i>
                                {{ $notification->time_ago }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('notifications.destroy', $notification->id) }}" 
                          method="POST" 
                          class="notification-actions"
                          onclick="event.stopPropagation();"
                          onsubmit="return confirm('Hapus notifikasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h3>Tidak ada notifikasi</h3>
            <p>Anda belum memiliki notifikasi saat ini.</p>
        </div>
    @endif
</div>
@endsection
