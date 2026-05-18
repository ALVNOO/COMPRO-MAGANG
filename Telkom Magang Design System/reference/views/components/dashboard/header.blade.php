{{--
    UNIFIED DASHBOARD HEADER
    Top navigation bar with page title, breadcrumbs, and user actions

    Optional:
    - $pageTitle: Page title
    - $pageSubtitle: Page subtitle/description
    - $breadcrumbs: Array of ['label' => '', 'url' => ''] or just labels
--}}

@php
    $user = Auth::user();
    $names = explode(' ', $user->name ?? 'User');
    $initials = count($names) >= 2
        ? strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1))
        : strtoupper(substr($user->name ?? 'U', 0, 2));
@endphp

<header class="dashboard-header">
    <div class="header-left">
        {{-- Page Title --}}
        <div class="page-title-section">
            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                <nav class="breadcrumb-nav">
                    @foreach($breadcrumbs as $index => $crumb)
                        @if(is_array($crumb) && isset($crumb['url']))
                            <a href="{{ $crumb['url'] }}" class="breadcrumb-link">{{ $crumb['label'] }}</a>
                        @else
                            <span class="breadcrumb-current">{{ is_array($crumb) ? $crumb['label'] : $crumb }}</span>
                        @endif
                        @if($index < count($breadcrumbs) - 1)
                            <span class="breadcrumb-separator">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    @endforeach
                </nav>
            @endif

            <h1 class="page-title">{{ $pageTitle ?? 'Dashboard' }}</h1>

            @if(isset($pageSubtitle))
                <p class="page-subtitle">{{ $pageSubtitle }}</p>
            @endif
        </div>
    </div>

    <div class="header-right">
        {{-- Date & Time --}}
        <div class="header-datetime">
            <span class="datetime-day" id="currentDay"></span>
            <span class="datetime-date" id="currentDate"></span>
        </div>

        {{-- Notifications --}}
        <div class="header-notifications" x-data="window.notificationDropdown()">
            <button class="notification-btn" @click="toggleDropdown()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" x-show="unreadCount > 0" x-text="unreadCount"></span>
            </button>

            <div class="notification-dropdown" 
                 :class="{ 'expanded': showAll }"
                 x-show="open" 
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 style="display: none;">
                <div class="notification-header">
                    <h4>Notifikasi</h4>
                    <button class="mark-read-btn" @click="markAllAsRead()" x-show="unreadCount > 0">Tandai semua dibaca</button>
                </div>
                <div class="notification-list" 
                     :class="{ 'expanded': showAll }"
                     x-ref="notificationList"
                     :style="showAll ? 'max-height: 60vh;' : ''">
                    <template x-if="loading">
                        <div style="padding: 2rem; text-align: center; color: var(--color-gray-500);">
                            <i class="fas fa-spinner fa-spin"></i> Memuat...
                        </div>
                    </template>
                    <template x-if="loadingAll">
                        <div style="padding: 1rem; text-align: center; color: var(--color-gray-500); font-size: 0.85rem;">
                            <i class="fas fa-spinner fa-spin"></i> Memuat semua notifikasi...
                        </div>
                    </template>
                    <template x-if="!loading && !loadingAll && allNotifications.length === 0">
                        <div style="padding: 2rem; text-align: center; color: var(--color-gray-500);">
                            <i class="fas fa-bell-slash" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3; display: block;"></i>
                            <p>Tidak ada notifikasi</p>
                        </div>
                    </template>
                    <template x-if="!loading && !loadingAll">
                        <template x-for="notification in allNotifications" :key="notification.id">
                            <a :href="notification.link || '#'" 
                               class="notification-item"
                               :class="{ 'unread': !notification.is_read }"
                               @click="markAsRead(notification.id, $event)">
                                <div class="notification-icon" :class="notification.icon">
                                    <i :class="getIconClass(notification.icon)"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text" x-text="notification.message"></p>
                                    <span class="notification-time" x-text="notification.time_ago"></span>
                                </div>
                            </a>
                        </template>
                    </template>
                </div>
                <button class="notification-footer" 
                        @click="toggleShowAll()"
                        x-show="!showAll && notifications.length > 0">
                    <i class="fas fa-chevron-down"></i> Lihat semua notifikasi
                </button>
                <button class="notification-footer" 
                        @click="toggleShowAll()"
                        x-show="showAll">
                    <i class="fas fa-chevron-up"></i> Sembunyikan
                </button>
            </div>
        </div>

    </div>
</header>

<style>
/* ============================================
   DASHBOARD HEADER STYLES
   ============================================ */

.dashboard-header {
    position: sticky;
    top: 0;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid var(--color-gray-100);
    padding: 1rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: var(--z-sticky);
    min-height: 72px;
}

/* ----- Left Section ----- */
.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.page-title-section {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: var(--color-gray-500);
}

.breadcrumb-link {
    color: var(--color-gray-500);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-link:hover {
    color: var(--color-primary);
}

.breadcrumb-separator {
    font-size: 0.6rem;
    color: var(--color-gray-400);
}

.breadcrumb-current {
    color: var(--color-gray-700);
    font-weight: 500;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-gray-900);
    margin: 0;
    line-height: 1.3;
}

.page-subtitle {
    font-size: 0.875rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* ----- Right Section ----- */
.header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* Date Time */
.header-datetime {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    padding-right: 1rem;
    border-right: 1px solid var(--color-gray-200);
}

.datetime-day {
    font-size: 0.75rem;
    color: var(--color-gray-500);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.datetime-date {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-gray-700);
}

/* Notifications */
.header-notifications {
    position: relative;
}

.notification-btn {
    width: 44px;
    height: 44px;
    background: var(--color-gray-50);
    border: 1px solid var(--color-gray-200);
    border-radius: 12px;
    color: var(--color-gray-600);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.2s;
    position: relative;
}

.notification-btn:hover {
    background: var(--color-gray-100);
    color: var(--color-gray-900);
}

.notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 20px;
    height: 20px;
    background: var(--color-primary);
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.5rem;
    width: 360px;
    max-width: 90vw;
    background: var(--color-white);
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    border: 1px solid var(--color-gray-200);
    overflow: hidden;
    z-index: var(--z-dropdown);
    transition: width 0.3s ease, max-height 0.3s ease;
}

.notification-dropdown.expanded {
    width: 500px;
    max-width: 90vw;
}

.notification-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.notification-header h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0;
}

.mark-read-btn {
    background: none;
    border: none;
    color: var(--color-primary);
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
}

.notification-list {
    max-height: 320px;
    overflow-y: auto;
    transition: max-height 0.3s ease;
}

.notification-list.expanded {
    max-height: 60vh;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    text-decoration: none;
    transition: background 0.2s;
    border-bottom: 1px solid var(--color-gray-50);
}

.notification-item:hover {
    background: var(--color-gray-50);
}

.notification-item.unread {
    background: rgba(238, 46, 36, 0.02);
}

.notification-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
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

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-text {
    font-size: 0.875rem;
    color: var(--color-gray-700);
    margin: 0 0 0.25rem 0;
    line-height: 1.4;
}

.notification-time {
    font-size: 0.75rem;
    color: var(--color-gray-500);
}

.notification-footer {
    display: block;
    width: 100%;
    text-align: center;
    padding: 0.875rem;
    color: var(--color-primary);
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    background: var(--color-gray-50);
    border: none;
    cursor: pointer;
    transition: background 0.2s;
}

.notification-footer:hover {
    background: var(--color-gray-100);
}

.notification-footer i {
    margin-right: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1rem;
        padding-left: 70px;
    }

    .header-datetime {
        display: none;
    }

    .page-title {
        font-size: 1.25rem;
    }

    .notification-dropdown {
        width: 300px;
        right: -80px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update date/time
    function updateDateTime() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayEl = document.getElementById('currentDay');
        const dateEl = document.getElementById('currentDate');

        if (dayEl) dayEl.textContent = days[now.getDay()];
        if (dateEl) dateEl.textContent = `${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
    }

    updateDateTime();
    setInterval(updateDateTime, 60000);
});
</script>
