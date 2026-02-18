{{--
    UNIFIED DASHBOARD SIDEBAR
    Collapsible sidebar for all dashboard roles (participant, admin, mentor)

    Required:
    - $role: 'participant' | 'admin' | 'mentor'
--}}

@php
    $user = Auth::user();
    $role = $role ?? 'participant';

    // Get user initials
    $names = explode(' ', $user->name ?? 'User');
    $initials = count($names) >= 2
        ? strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1))
        : strtoupper(substr($user->name ?? 'U', 0, 2));

    // Role-specific config
    $roleConfig = [
        'participant' => [
            'title' => 'Peserta Magang',
            'icon' => 'fa-user-graduate',
            'badge' => 'Peserta',
            'badgeClass' => 'badge-participant'
        ],
        'admin' => [
            'title' => 'Admin Panel',
            'icon' => 'fa-shield-halved',
            'badge' => 'Admin',
            'badgeClass' => 'badge-admin'
        ],
        'mentor' => [
            'title' => 'Pembimbing',
            'icon' => 'fa-chalkboard-teacher',
            'badge' => 'Mentor',
            'badgeClass' => 'badge-mentor'
        ]
    ];

    $config = $roleConfig[$role] ?? $roleConfig['participant'];

    // Navigation items based on role
    $navItems = [];

    if ($role === 'participant') {
        $application = $user->internshipApplications()
            ->whereIn('status', ['pending', 'accepted', 'finished'])
            ->latest()
            ->first();
        $isAccepted = $application && in_array($application->status, ['accepted', 'finished']);

        if ($isAccepted) {
            $navItems = [
                ['route' => 'dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Dashboard', 'routeMatch' => 'dashboard'],
                ['route' => 'attendance.index', 'icon' => 'fa-calendar-check', 'label' => 'Absensi', 'routeMatch' => 'attendance.*'],
                ['route' => 'dashboard.assignments', 'icon' => 'fa-clipboard-list', 'label' => 'Tugas', 'routeMatch' => 'dashboard.assignments*'],
                ['route' => 'logbook.index', 'icon' => 'fa-book-open', 'label' => 'Logbook', 'routeMatch' => 'logbook.*'],
                ['route' => 'dashboard.certificates', 'icon' => 'fa-award', 'label' => 'Sertifikat', 'routeMatch' => 'dashboard.certificates*'],
            ];
        } else {
            $navItems = [
                ['route' => 'dashboard.status', 'icon' => 'fa-hourglass-half', 'label' => 'Status Pengajuan', 'routeMatch' => 'dashboard.status'],
            ];
        }
    } elseif ($role === 'admin') {
        $navItems = [
            ['route' => 'admin.dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Dashboard', 'routeMatch' => 'admin.dashboard'],
            ['route' => 'admin.applications', 'icon' => 'fa-file-signature', 'label' => 'Pengajuan Magang', 'routeMatch' => 'admin.applications*'],
            ['route' => 'admin.participants', 'icon' => 'fa-users', 'label' => 'Daftar Peserta', 'routeMatch' => 'admin.participants*'],
            ['route' => 'admin.mentors', 'icon' => 'fa-user-tie', 'label' => 'Monitoring Mentor', 'routeMatch' => 'admin.mentors*'],
            ['route' => 'admin.attendance', 'icon' => 'fa-calendar-check', 'label' => 'Absensi', 'routeMatch' => 'admin.attendance*'],
            ['route' => 'admin.logbook', 'icon' => 'fa-book-open', 'label' => 'Logbook', 'routeMatch' => 'admin.logbook*'],
            ['route' => 'admin.reports', 'icon' => 'fa-chart-line', 'label' => 'Laporan', 'routeMatch' => 'admin.reports*'],
            ['route' => 'admin.fields', 'icon' => 'fa-layer-group', 'label' => 'Bidang Peminatan', 'routeMatch' => 'admin.fields*'],
            ['route' => 'admin.divisions.index', 'icon' => 'fa-building', 'label' => 'Kelola Divisi', 'routeMatch' => 'admin.divisions*'],
        ];
    } elseif ($role === 'mentor') {
        $navItems = [
            ['route' => 'mentor.dashboard', 'icon' => 'fa-gauge-high', 'label' => 'Dashboard', 'routeMatch' => 'mentor.dashboard'],
            ['route' => 'mentor.penugasan', 'icon' => 'fa-clipboard-list', 'label' => 'Penugasan & Penilaian', 'routeMatch' => 'mentor.penugasan*'],
            ['route' => 'mentor.absensi', 'icon' => 'fa-calendar-check', 'label' => 'Absensi', 'routeMatch' => 'mentor.absensi*'],
            ['route' => 'mentor.logbook', 'icon' => 'fa-book-open', 'label' => 'Logbook', 'routeMatch' => 'mentor.logbook*'],
            ['route' => 'mentor.laporan-penilaian', 'icon' => 'fa-chart-bar', 'label' => 'Laporan Penilaian', 'routeMatch' => 'mentor.laporan-penilaian*'],
            ['route' => 'mentor.sertifikat', 'icon' => 'fa-award', 'label' => 'Sertifikat', 'routeMatch' => 'mentor.sertifikat*'],
        ];
    }
@endphp

<aside class="unified-sidebar" id="unifiedSidebar">
    {{-- Logo Section --}}
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-logo">
            <img src="{{ asset('images/telkom-logo.png') }}" alt="Telkom" class="logo-image" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="logo-fallback" style="display: none;">
                <i class="fas fa-building"></i>
            </div>
            <span class="logo-text">Telkom <span class="text-primary">Intern</span></span>
        </a>
    </div>

    {{-- User Profile Section --}}
    <div class="sidebar-profile">
        <a href="{{ $role === 'admin' ? '#' : ($role === 'mentor' ? '#' : route('dashboard.profile')) }}" class="profile-link">
            <div class="profile-avatar">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="profile-info">
                <h4 class="profile-name">{{ Str::limit($user->name ?? 'User', 18) }}</h4>
                <span class="profile-badge {{ $config['badgeClass'] }}">
                    <i class="fas {{ $config['icon'] }}"></i>
                    {{ $config['badge'] }}
                </span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <ul class="nav-list">
            @foreach($navItems as $item)
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}"
                       class="nav-link {{ request()->routeIs($item['routeMatch']) ? 'active' : '' }}"
                       data-tooltip="{{ $item['label'] }}">
                        <span class="nav-icon">
                            <i class="fas {{ $item['icon'] }}"></i>
                        </span>
                        <span class="nav-text">{{ $item['label'] }}</span>
                        @if(request()->routeIs($item['routeMatch']))
                            <span class="active-indicator"></span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    {{-- Bottom Section --}}
    <div class="sidebar-footer">
        {{-- Toggle Button --}}
        <button type="button" class="sidebar-toggle" id="sidebarToggle" data-tooltip="Toggle Sidebar">
            <i class="fas fa-chevron-left toggle-icon"></i>
        </button>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn" data-tooltip="Keluar">
                <span class="nav-icon">
                    <i class="fas fa-right-from-bracket"></i>
                </span>
                <span class="nav-text">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Mobile Toggle Button --}}
<button type="button" class="mobile-menu-toggle" id="mobileMenuToggle">
    <i class="fas fa-bars"></i>
</button>

<style>
/* ============================================
   UNIFIED SIDEBAR STYLES
   ============================================ */

.unified-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: var(--color-white);
    border-right: 1px solid var(--color-gray-200);
    display: flex;
    flex-direction: column;
    z-index: var(--z-fixed);
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
}

.unified-sidebar.collapsed {
    width: 80px;
}

/* ----- Header ----- */
.sidebar-header {
    padding: 1.25rem;
    border-bottom: 1px solid var(--color-gray-100);
    flex-shrink: 0;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    color: var(--color-gray-900);
}

.logo-image {
    width: 40px;
    height: 40px;
    object-fit: contain;
    flex-shrink: 0;
}

.logo-fallback {
    width: 40px;
    height: 40px;
    background: var(--gradient-primary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.logo-text {
    font-size: 1.25rem;
    font-weight: 700;
    white-space: nowrap;
    transition: opacity 0.2s, width 0.2s;
}

.logo-text .text-primary {
    color: var(--color-primary);
}

.unified-sidebar.collapsed .logo-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

/* ----- Profile Section ----- */
.sidebar-profile {
    padding: 1rem 0.75rem;
    border-bottom: 1px solid var(--color-gray-100);
    flex-shrink: 0;
}

.profile-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 12px;
    text-decoration: none;
    transition: background 0.2s;
}

.profile-link:hover {
    background: var(--color-gray-50);
}

.profile-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--gradient-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.95rem;
    flex-shrink: 0;
    overflow: hidden;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info {
    overflow: hidden;
    transition: opacity 0.2s, width 0.2s;
}

.unified-sidebar.collapsed .profile-info {
    opacity: 0;
    width: 0;
}

.profile-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.2rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.profile-badge i {
    font-size: 0.6rem;
}

.badge-participant {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.badge-admin {
    background: rgba(139, 92, 246, 0.1);
    color: #8B5CF6;
}

.badge-mentor {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

/* ----- Navigation ----- */
.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0.75rem 0;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    padding: 0.2rem 0.75rem;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    text-decoration: none;
    color: var(--color-gray-600);
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.nav-link:hover {
    background: var(--color-gray-50);
    color: var(--color-gray-900);
    transform: translateX(4px);
}

.nav-link.active {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.08) 0%, rgba(238, 46, 36, 0.04) 100%);
    color: var(--color-primary);
    font-weight: 600;
}

/* Keep active link from moving on hover */
.nav-link.active:hover {
    transform: translateX(0);
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.12) 0%, rgba(238, 46, 36, 0.06) 100%);
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: var(--color-primary);
    border-radius: 0 4px 4px 0;
    transition: opacity 0.2s ease;
}

/* Hide the ::before indicator on hover to avoid visual conflict */
.nav-link.active:hover::before {
    opacity: 0;
}

.nav-icon {
    width: 20px;
    text-align: center;
    flex-shrink: 0;
    font-size: 1rem;
}

.nav-text {
    white-space: nowrap;
    transition: opacity 0.2s, width 0.2s;
}

.unified-sidebar.collapsed .nav-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.active-indicator {
    position: absolute;
    right: 1rem;
    width: 6px;
    height: 6px;
    background: var(--color-primary);
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.unified-sidebar.collapsed .active-indicator {
    display: none;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

/* ----- Footer ----- */
.sidebar-footer {
    padding: 0.75rem;
    border-top: 1px solid var(--color-gray-100);
    flex-shrink: 0;
}

.sidebar-toggle {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    background: var(--color-gray-50);
    border: 1px solid var(--color-gray-200);
    border-radius: 10px;
    color: var(--color-gray-600);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s;
}

.sidebar-toggle:hover {
    background: var(--color-gray-100);
    color: var(--color-gray-900);
}

.toggle-icon {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.unified-sidebar.collapsed .toggle-icon {
    transform: rotate(180deg);
}

.logout-form {
    margin: 0;
}

.logout-btn {
    width: 100%;
    padding: 0.85rem 1rem;
    background: transparent;
    border: 1px solid var(--color-gray-200);
    border-radius: 12px;
    color: var(--color-gray-600);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.05);
    border-color: rgba(239, 68, 68, 0.3);
    color: var(--color-danger);
}

.unified-sidebar.collapsed .logout-btn .nav-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

/* ----- Tooltips (collapsed mode) ----- */
.unified-sidebar.collapsed .nav-link[data-tooltip]:hover::after,
.unified-sidebar.collapsed .logout-btn[data-tooltip]:hover::after,
.unified-sidebar.collapsed .sidebar-toggle[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 12px;
    padding: 0.5rem 0.75rem;
    background: var(--color-gray-900);
    color: white;
    font-size: 0.8rem;
    font-weight: 500;
    white-space: nowrap;
    border-radius: 6px;
    z-index: 1000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.unified-sidebar.collapsed .nav-link[data-tooltip]:hover::before,
.unified-sidebar.collapsed .logout-btn[data-tooltip]:hover::before,
.unified-sidebar.collapsed .sidebar-toggle[data-tooltip]:hover::before {
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    margin-left: 4px;
    border: 6px solid transparent;
    border-right-color: var(--color-gray-900);
}

/* ----- Mobile ----- */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: calc(var(--z-fixed) - 1);
    opacity: 0;
    transition: opacity 0.3s;
}

.sidebar-overlay.show {
    display: block;
    opacity: 1;
}

.mobile-menu-toggle {
    display: none;
    position: fixed;
    top: 1rem;
    left: 1rem;
    width: 44px;
    height: 44px;
    background: var(--color-white);
    border: 1px solid var(--color-gray-200);
    border-radius: 12px;
    color: var(--color-gray-700);
    font-size: 1.25rem;
    cursor: pointer;
    z-index: calc(var(--z-fixed) + 1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: all 0.2s;
}

.mobile-menu-toggle:hover {
    background: var(--color-gray-50);
}

@media (max-width: 1024px) {
    .unified-sidebar {
        transform: translateX(-100%);
        width: 280px !important;
    }

    .unified-sidebar.show {
        transform: translateX(0);
    }

    .unified-sidebar.collapsed {
        width: 280px !important;
    }

    .unified-sidebar.collapsed .logo-text,
    .unified-sidebar.collapsed .profile-info,
    .unified-sidebar.collapsed .nav-text,
    .unified-sidebar.collapsed .logout-btn .nav-text {
        opacity: 1;
        width: auto;
    }

    .unified-sidebar.collapsed .toggle-icon {
        transform: rotate(0);
    }

    .mobile-menu-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-toggle {
        display: none;
    }
}

/* Scrollbar styling */
.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: var(--color-gray-300);
    border-radius: 4px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: var(--color-gray-400);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('unifiedSidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const overlay = document.getElementById('sidebarOverlay');

    // Load saved state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed && window.innerWidth > 1024) {
        sidebar.classList.add('collapsed');
    }

    // Toggle sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));

            // Dispatch event for main content adjustment
            window.dispatchEvent(new CustomEvent('sidebarToggle', {
                detail: { collapsed: sidebar.classList.contains('collapsed') }
            }));
        });
    }

    // Mobile toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        });
    }

    // Close on overlay click
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });
    }

    // Handle resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1024) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});
</script>
