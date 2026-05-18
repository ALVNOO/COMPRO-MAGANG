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

    $profileRoute = match($user->role ?? '') {
        'admin'      => route('admin.profile'),
        'pembimbing' => route('mentor.profil'),
        default      => route('dashboard.profile'),
    };

    $contactWidget = null;
    if ($user->role === 'peserta') {
        $activeApp = $user->activeApplication;
        if ($activeApp && $activeApp->divisionMentor) {
            $mentorU = \App\Models\User::where('username', $activeApp->divisionMentor->nik_number)
                ->where('role', 'pembimbing')
                ->first();
            if ($mentorU && ($mentorU->phone || $mentorU->email)) {
                $contactWidget = [
                    'label' => 'Kontak Mentor',
                    'name'  => $activeApp->divisionMentor->mentor_name,
                    'photo' => $mentorU->profile_picture,
                    'phone' => $mentorU->phone,
                    'email' => $mentorU->email,
                ];
            }
        }
    } elseif ($user->role === 'pembimbing') {
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin && ($admin->phone || $admin->email)) {
            $contactWidget = [
                'label' => 'Kontak Admin',
                'name'  => $admin->name,
                'photo' => $admin->profile_picture,
                'phone' => $admin->phone,
                'email' => $admin->email,
            ];
        }
    }
@endphp

<header class="dashboard-header">
    <div class="header-right">
        {{-- Contact Widget --}}
        @if($contactWidget)
        <div class="contact-widget">
            <div class="contact-photo">
                @if($contactWidget['photo'])
                    <img src="{{ asset('storage/' . $contactWidget['photo']) }}" alt="{{ $contactWidget['name'] }}">
                @else
                    @php
                        $cInitials = collect(explode(' ', $contactWidget['name']))->take(2)->map(fn($w) => strtoupper($w[0] ?? ''))->join('');
                    @endphp
                    <div class="contact-initials">{{ $cInitials }}</div>
                @endif
            </div>
            <div class="contact-meta">
                <div class="contact-tag">{{ $contactWidget['label'] }}</div>
                <div class="contact-name">{{ Str::limit($contactWidget['name'], 18) }}</div>
            </div>
            <div class="contact-actions">
                @if($contactWidget['phone'])
                    @php
                        $waNum  = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $contactWidget['phone']));
                        $waText = urlencode('Halo, saya ' . $user->name . ' ingin bertanya mengenai magang.');
                    @endphp
                    <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}"
                       target="_blank" rel="noopener"
                       class="contact-btn contact-wa" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                @endif
                @if($contactWidget['email'])
                    <a href="mailto:{{ $contactWidget['email'] }}"
                       class="contact-btn contact-mail" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                @endif
            </div>
        </div>
        @endif

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

        {{-- User Avatar Dropdown (inline Alpine — avoids component conflict) --}}
        @php
            $roleLabel = match($user->role ?? '') {
                'admin'      => 'Administrator',
                'pembimbing' => 'Pembimbing Lapangan',
                default      => 'Peserta Magang',
            };
        @endphp
        <div class="user-dropdown-wrap" x-data="{ userOpen: false }" @keydown.escape.window="userOpen = false">

            {{-- Trigger --}}
            <button type="button" class="user-avatar-btn" @click="userOpen = !userOpen" :aria-expanded="userOpen">
                <div class="user-avatar-circle">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                    @else
                        {{ $initials }}
                    @endif
                </div>
                <span class="user-avatar-name">{{ Str::limit($user->name, 16) }}</span>
                <i class="fas fa-chevron-down user-avatar-chevron" :class="{ 'rotate-180': userOpen }"></i>
            </button>

            {{-- Menu --}}
            <div class="user-dropdown-menu"
                 x-show="userOpen"
                 @click.outside="userOpen = false"
                 x-transition:enter="ud-enter"
                 x-transition:enter-start="ud-enter-start"
                 x-transition:enter-end="ud-enter-end"
                 x-transition:leave="ud-leave"
                 x-transition:leave-start="ud-leave-start"
                 x-transition:leave-end="ud-leave-end"
                 style="display:none;">

                {{-- Profile Header --}}
                <div class="dd-profile-header">
                    <div class="dd-avatar">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                        @else
                            {{ $initials }}
                        @endif
                    </div>
                    <div class="dd-info">
                        <div class="dd-name">{{ Str::limit($user->name, 22) }}</div>
                        <div class="dd-email">{{ $user->email }}</div>
                        <span class="dd-role-badge">{{ $roleLabel }}</span>
                    </div>
                </div>

                <a href="{{ $profileRoute }}" class="ud-item">
                    <i class="fas fa-user"></i> Profil Saya
                </a>
                <a href="{{ route('password.change') }}" class="ud-item">
                    <i class="fas fa-lock"></i> Ganti Password
                </a>
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
    padding: 0.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    z-index: var(--z-sticky);
    min-height: 60px;
}

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

/* Contact Widget */
.contact-widget {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 5px 12px 5px 6px;
    background: var(--color-gray-50);
    border: 1px solid var(--color-gray-200);
    border-radius: 12px;
}

.contact-photo {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.contact-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.contact-initials {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
}

.contact-meta { min-width: 0; }

.contact-tag {
    font-size: 10px;
    color: var(--color-gray-500);
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    line-height: 1;
    margin-bottom: 3px;
}

.contact-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-900);
    white-space: nowrap;
    line-height: 1;
}

.contact-actions {
    display: flex;
    gap: 4px;
    margin-left: 4px;
}

.contact-btn {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    text-decoration: none;
    transition: background .15s;
    flex-shrink: 0;
}

.contact-wa   { background: #DCFCE7; color: #16A34A; }
.contact-wa:hover  { background: #BBF7D0; }
.contact-mail { background: #DBEAFE; color: #2563EB; }
.contact-mail:hover { background: #BFDBFE; }

/* User Avatar Dropdown */
.user-avatar-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 10px 5px 6px;
    background: var(--color-gray-50);
    border: 1px solid var(--color-gray-200);
    border-radius: 12px;
    cursor: pointer;
    transition: all .15s;
    user-select: none;
}
.user-avatar-btn:hover { background: var(--color-gray-100); }

.user-avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
}
.user-avatar-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.user-avatar-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-gray-800);
    white-space: nowrap;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-avatar-chevron {
    font-size: 10px;
    color: var(--color-gray-400);
    transition: transform .15s;
}

/* Profile Dropdown Header */
.dd-profile-header {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #FEF2F2 0%, #FFF7F7 100%);
    border-bottom: 1px solid #E5E7EB;
}

.dd-avatar {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.dd-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }

.dd-info { min-width: 0; flex: 1; }

.dd-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dd-email {
    font-size: 0.72rem;
    color: #9CA3AF;
    margin: 0.15rem 0 0.4rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dd-role-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.15rem 0.55rem;
    background: rgba(238,46,36,0.1);
    color: #C41E1A;
    border-radius: 9999px;
    font-size: 0.63rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* User Dropdown Wrap & Menu */
.user-dropdown-wrap {
    position: relative;
}

.user-dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 260px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 10px 40px rgba(0,0,0,0.12);
    overflow: hidden;
    z-index: 300;
}

.ud-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    color: #4B5563;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    font-family: inherit;
}

.ud-item i {
    width: 16px;
    color: #9CA3AF;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.ud-item:hover {
    background: #F9FAFB;
    color: #EE2E24;
}

.ud-item:hover i {
    color: #EE2E24;
}

.ud-danger {
    color: #DC2626;
}

.ud-danger i {
    color: #DC2626;
}

.ud-danger:hover {
    background: #FEF2F2;
    color: #B91C1C;
}

.ud-danger:hover i {
    color: #B91C1C;
}

.ud-divider {
    height: 1px;
    background: #E5E7EB;
    margin: 0.25rem 0;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 0.75rem 1rem;
        padding-left: 70px;
    }

    .header-datetime { display: none; }
    .contact-widget  { display: none; }

    .user-avatar-name,
    .user-avatar-chevron { display: none; }

    .user-avatar-btn { padding: 5px 6px; }

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
