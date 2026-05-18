<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Telkom Internship</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Notification Dropdown Script (must be before Alpine.js) -->
    <script>
    // Make notificationDropdown available globally for Alpine.js
    window.notificationDropdown = function() {
        return {
            open: false,
            notifications: [],
            allNotifications: [],
            unreadCount: 0,
            loading: true,
            loadingAll: false,
            showAll: false,

            init() {
                this.loadNotifications();
                // Refresh notifications every 30 seconds
                setInterval(() => {
                    if (!this.open) {
                        this.loadNotifications();
                    }
                }, 30000);
            },

            toggleDropdown() {
                this.open = !this.open;
                if (this.open) {
                    this.loadNotifications();
                    this.showAll = false; // Reset expanded state when closing
                }
            },

            async loadNotifications() {
                try {
                    this.loading = true;
                    const response = await fetch('{{ route("notifications.recent") }}');
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const data = await response.json();
                    let notifs = data.notifications || [];
                    let count  = data.unread_count || 0;

                    // Prepend any page-injected system alerts (e.g. pending assignments)
                    const sysAlerts = window.__systemAlerts || [];
                    if (sysAlerts.length > 0) {
                        notifs = [...sysAlerts, ...notifs];
                        count  += sysAlerts.length;
                    }

                    this.notifications    = notifs;
                    this.allNotifications = notifs;
                    this.unreadCount      = count;
                    this.loading = false;
                } catch (error) {
                    console.error('Error loading notifications:', error);
                    this.loading = false;
                    // Still show system alerts even if API fails
                    const sysAlerts = window.__systemAlerts || [];
                    this.notifications    = sysAlerts;
                    this.allNotifications = sysAlerts;
                    this.unreadCount      = sysAlerts.length;
                }
            },

            async toggleShowAll() {
                if (!this.showAll) {
                    // Load all notifications
                    await this.loadAllNotifications();
                }
                this.showAll = !this.showAll;
            },

            async loadAllNotifications() {
                try {
                    this.loadingAll = true;
                    const response = await fetch('/notifications?format=json');
                    if (response.ok) {
                        const data = await response.json();
                        this.allNotifications = data.notifications || this.notifications;
                    } else {
                        // Fallback: use recent notifications
                        this.allNotifications = this.notifications;
                    }
                    this.loadingAll = false;
                } catch (error) {
                    console.error('Error loading all notifications:', error);
                    // Fallback: use recent notifications
                    this.allNotifications = this.notifications;
                    this.loadingAll = false;
                }
            },

            async markAsRead(notificationId, event) {
                if (event) {
                    event.preventDefault();
                    const notification = this.allNotifications.find(n => n.id === notificationId) ||
                                       this.notifications.find(n => n.id === notificationId);
                    if (notification && !notification.is_read) {
                        try {
                            const response = await fetch(`/notifications/${notificationId}/read`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                            });
                            if (response.ok) {
                                notification.is_read = true;
                                this.unreadCount = Math.max(0, this.unreadCount - 1);
                            }
                        } catch (error) {
                            console.error('Error marking notification as read:', error);
                        }
                    }
                }
            },

            async markAllAsRead() {
                try {
                    const response = await fetch('{{ route("notifications.mark-all-read") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                    });
                    if (response.ok) {
                        this.allNotifications.forEach(n => {
                            n.is_read = true;
                        });
                        this.notifications.forEach(n => {
                            n.is_read = true;
                        });
                        this.unreadCount = 0;
                    }
                } catch (error) {
                    console.error('Error marking all as read:', error);
                }
            },

            getIconClass(icon) {
                const icons = {
                    'success': 'fas fa-check-circle',
                    'info': 'fas fa-info-circle',
                    'warning': 'fas fa-exclamation-triangle',
                    'error': 'fas fa-times-circle',
                };
                return icons[icon] || 'fas fa-bell';
            }
        }
    }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/design-system.css', 'resources/css/ux-utilities.css'])
    
    {{-- Load role-specific CSS if needed --}}
    @if(isset($role) && $role === 'mentor')
        @vite(['resources/css/mentor-dashboard.css', 'resources/js/mentor-dashboard.js'])
    @elseif(isset($role) && $role === 'admin')
        @vite(['resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js'])
    @elseif(isset($role) && $role === 'participant')
        @vite(['resources/css/peserta-dashboard.css', 'resources/js/peserta-dashboard.js'])
    @endif

    <style>
        /* ============================================
           UNIFIED DASHBOARD LAYOUT STYLES
           ============================================ */

        :root {
            /* Colors */
            --color-primary: #EE2E24;
            --color-primary-light: #FF4D45;
            --color-primary-dark: #C41E1A;
            --color-primary-50: rgba(238, 46, 36, 0.05);
            --color-primary-100: rgba(238, 46, 36, 0.1);
            --color-primary-200: rgba(238, 46, 36, 0.2);

            --color-success: #10B981;
            --color-warning: #F59E0B;
            --color-danger: #EF4444;
            --color-info: #3B82F6;

            --color-gray-50: #F9FAFB;
            --color-gray-100: #F3F4F6;
            --color-gray-200: #E5E7EB;
            --color-gray-300: #D1D5DB;
            --color-gray-400: #9CA3AF;
            --color-gray-500: #6B7280;
            --color-gray-600: #4B5563;
            --color-gray-700: #374151;
            --color-gray-800: #1F2937;
            --color-gray-900: #111827;
            --color-white: #FFFFFF;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);

            /* Typography */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;

            /* Spacing */
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;

            /* Z-index */
            --z-dropdown: 100;
            --z-sticky: 200;
            --z-fixed: 300;
            --z-modal: 500;

            /* Transitions */
            --transition-spring: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: var(--font-sans);
            background: var(--color-gray-50);
            color: var(--color-gray-900);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ============================================
           BACKGROUND EFFECTS
           ============================================ */

        .dashboard-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        /* Floating Orbs */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: floatOrb 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, rgba(238, 46, 36, 0.15) 0%, rgba(255, 107, 107, 0.1) 100%);
            top: -150px;
            right: -100px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(147, 197, 253, 0.08) 100%);
            bottom: -100px;
            left: 20%;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(110, 231, 183, 0.08) 100%);
            top: 40%;
            right: 10%;
            animation-delay: -10s;
        }

        .orb-4 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(196, 181, 253, 0.06) 100%);
            bottom: 20%;
            left: -50px;
            animation-delay: -15s;
        }

        @keyframes floatOrb {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(30px, -30px) scale(1.05);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.95);
            }
            75% {
                transform: translate(-30px, -20px) scale(1.02);
            }
        }


        /* ============================================
           MAIN LAYOUT
           ============================================ */

        .dashboard-wrapper {
            display: block;
            min-height: 100vh;
        }

        .dashboard-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--transition-spring);
            overflow-x: hidden;
        }

        .dashboard-main.sidebar-collapsed {
            margin-left: var(--sidebar-collapsed);
        }

        .dashboard-content {
            flex: 1;
            padding: 2rem;
            position: relative;
        }

        /* ============================================
           ALERT MESSAGES
           ============================================ */

        .alert-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: var(--z-modal);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-width: 400px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 1.25rem;
            background: var(--color-white);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            border-left-color: var(--color-success);
        }

        .alert-success .alert-icon-box { background: var(--color-success-light); color: var(--color-success); }
        .alert-danger  .alert-icon-box { background: var(--color-danger-light);  color: var(--color-danger); }
        .alert-warning .alert-icon-box { background: var(--color-warning-light); color: var(--color-warning); }
        .alert-info    .alert-icon-box { background: var(--color-info-light);    color: var(--color-info); }

        .alert-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--color-gray-900);
            margin-bottom: 2px;
        }

        .alert-message {
            font-size: 0.875rem;
            color: var(--color-gray-600);
            line-height: 1.5;
            margin: 0;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 0;
            }

            .dashboard-main.sidebar-collapsed {
                margin-left: 0;
            }

            .dashboard-content {
                padding: 1.5rem;
                padding-top: 5rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-content {
                padding: 1rem;
                padding-top: 5rem;
            }
        }

        /* ============================================
           UTILITY CLASSES
           ============================================ */

        .text-primary { color: var(--color-primary); }
        .text-success { color: var(--color-success); }
        .text-warning { color: var(--color-warning); }
        .text-danger { color: var(--color-danger); }
        .text-info { color: var(--color-info); }

        .bg-primary { background: var(--color-primary); }
        .bg-success { background: var(--color-success); }
        .bg-warning { background: var(--color-warning); }
        .bg-danger { background: var(--color-danger); }
        .bg-info { background: var(--color-info); }

        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }

        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, 1fr); }
        .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-cols-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }

        @media (max-width: 1200px) {
            .lg\:grid-cols-3 { grid-template-columns: repeat(2, 1fr); }
            .lg\:grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .md\:grid-cols-1 { grid-template-columns: 1fr; }
            .md\:grid-cols-2 { grid-template-columns: 1fr; }
        }

        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }

        .rounded-lg { border-radius: 12px; }
        .rounded-xl { border-radius: 16px; }
        .rounded-2xl { border-radius: 20px; }

        .shadow-sm { box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .shadow-md { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .shadow-lg { box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        .transition { transition: all var(--transition-spring); }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(238, 46, 36, 0.35);
        }

        .btn-secondary {
            background: #fff;
            color: #4B5563;
            border: 1px solid #D1D5DB;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }

        .btn-secondary:hover {
            background: #F9FAFB;
            border-color: #9CA3AF;
        }

        .btn-outline {
            background: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }

        .btn-outline:hover {
            background: var(--color-primary);
            color: white;
        }

        .btn-danger {
            background: #DC2626;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        .btn-success {
            background: linear-gradient(135deg, #16A34A, #15803D);
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #15803D, #166534);
        }

        .btn-warning {
            background: #D97706;
            color: #fff;
            border: none;
        }

        .btn-warning:hover {
            background: #B45309;
        }

        .btn-info {
            background: #0284C7;
            color: #fff;
            border: none;
        }

        .btn-info:hover {
            background: #0369A1;
        }

        .btn-sm {
            padding: 0.45rem 0.9rem;
            font-size: 0.78rem;
            border-radius: 10px;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        /* Counter Animation */
        .counter-value {
            transition: all 0.3s ease;
        }

        /* ============================================
           SKELETON LOADING
           ============================================ */

        @keyframes sk-pulse { 0%,100% { opacity:1; } 50% { opacity:.4; } }

        .sk-block {
            background: #F3F4F6;
            border-radius: 8px;
            animation: sk-pulse 1.5s ease-in-out infinite;
        }

        #page-skeleton {
            position: absolute;
            inset: 0;
            z-index: 5;
            background: var(--color-gray-50);
            padding: 2rem;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        #page-content {
            opacity: 0;
            transition: opacity .3s ease;
        }

        @media(max-width:1024px) {
            #page-skeleton { padding: 1.5rem; padding-top: 1.5rem; }
        }
        @media(max-width:768px) {
            #page-skeleton { padding: 1rem; padding-top: 1rem; }
        }
        @media(max-width:1200px) {
            .sk-cards { grid-template-columns: repeat(2,1fr) !important; }
        }
        @media(max-width:640px) {
            .sk-cards { grid-template-columns: 1fr !important; }
            .sk-panels, .sk-bottom { grid-template-columns: 1fr !important; }
        }

        /* Navigation progress bar */
        #nav-progress {
            position: fixed;
            top: 0; left: 0;
            height: 3px;
            width: 0%;
            z-index: 9999;
            opacity: 0;
            background: linear-gradient(90deg, #EE2E24 0%, #FF6B6B 50%, #EE2E24 100%);
            background-size: 200% 100%;
            transition: width .4s ease, opacity .15s ease;
        }
        #nav-progress.loading {
            opacity: 1;
            animation: nav-shimmer 1.2s linear infinite;
        }
        @keyframes nav-shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Navigation progress bar --}}
    <div id="nav-progress"></div>

    {{-- Background Effects --}}
    <div class="dashboard-bg">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        <div class="floating-orb orb-4"></div>
    </div>

    {{-- Dashboard Wrapper --}}
    <div class="dashboard-wrapper">
        {{-- Sidebar --}}
        @include('components.dashboard.sidebar', ['role' => $role ?? 'participant'])

        {{-- Main Content Area --}}
        <main class="dashboard-main" id="dashboardMain">
            {{-- Header --}}
            @include('components.dashboard.header', [
                'pageTitle' => $pageTitle ?? 'Dashboard',
                'pageSubtitle' => $pageSubtitle ?? null,
                'breadcrumbs' => $breadcrumbs ?? []
            ])

            {{-- Flash Messages --}}
            @if(session('success') || session('error') || session('warning') || session('info') || (isset($errors) && $errors->any()))
                <div class="alert-container" id="alertContainer">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <div class="alert-icon-box"><i class="fas fa-check-circle"></i></div>
                            <div class="alert-content">
                                <p class="alert-title">Berhasil</p>
                                <p class="alert-message">{{ session('success') }}</p>
                            </div>
                            <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <div class="alert-icon-box"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="alert-content">
                                <p class="alert-title">Error</p>
                                <p class="alert-message">{{ session('error') }}</p>
                            </div>
                            <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            <div class="alert-icon-box"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="alert-content">
                                <p class="alert-title">Perhatian</p>
                                <p class="alert-message">{{ session('warning') }}</p>
                            </div>
                            <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info">
                            <div class="alert-icon-box"><i class="fas fa-info-circle"></i></div>
                            <div class="alert-content">
                                <p class="alert-title">Info</p>
                                <p class="alert-message">{{ session('info') }}</p>
                            </div>
                            <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger">
                            <div class="alert-icon-box"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="alert-content">
                                <p class="alert-title">Terdapat Kesalahan</p>
                                <ul class="alert-message" style="margin: 0.25rem 0 0; padding-left: 1.25rem;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="alert-dismiss" onclick="this.closest('.alert').remove()" aria-label="Tutup">&times;</button>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Page Content --}}
            <div class="dashboard-content">

                {{-- ── Skeleton overlay (visible until DOMContentLoaded + 150ms) ── --}}
                <div id="page-skeleton" aria-hidden="true">
                    {{-- Context bar --}}
                    <div class="sk-block" style="height:88px;border-radius:20px;margin-bottom:2rem;animation-delay:0s;"></div>

                    {{-- 4 stat cards --}}
                    <div class="sk-cards" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:2rem;">
                        <div class="sk-block" style="height:96px;border-radius:20px;animation-delay:.08s;"></div>
                        <div class="sk-block" style="height:96px;border-radius:20px;animation-delay:.16s;"></div>
                        <div class="sk-block" style="height:96px;border-radius:20px;animation-delay:.24s;"></div>
                        <div class="sk-block" style="height:96px;border-radius:20px;animation-delay:.32s;"></div>
                    </div>

                    {{-- 3 focus / detail panels --}}
                    <div class="sk-panels" style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2rem;">
                        <div class="sk-block" style="height:168px;border-radius:16px;animation-delay:.1s;"></div>
                        <div class="sk-block" style="height:168px;border-radius:16px;animation-delay:.18s;"></div>
                        <div class="sk-block" style="height:168px;border-radius:16px;animation-delay:.26s;"></div>
                    </div>

                    {{-- Bottom: wide + narrow (chart / table area) --}}
                    <div class="sk-bottom" style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;">
                        <div class="sk-block" style="height:320px;border-radius:20px;animation-delay:.14s;"></div>
                        <div class="sk-block" style="height:320px;border-radius:20px;animation-delay:.22s;"></div>
                    </div>
                </div>

                {{-- Real page content (revealed after skeleton hides) --}}
                <div id="page-content">
                    @yield('content')
                </div>

            </div>
        </main>
    </div>

    {{-- Scripts --}}
    <script>
        /* ── Skeleton: reveal content after DOM ready ── */
        (function() {
            var _navStart = Date.now();

            document.addEventListener('DOMContentLoaded', function() {
                var elapsed   = Date.now() - _navStart;
                var minShow   = 150; // minimum ms skeleton is visible
                var remaining = Math.max(0, minShow - elapsed);

                setTimeout(function() {
                    var sk      = document.getElementById('page-skeleton');
                    var content = document.getElementById('page-content');

                    if (sk) {
                        sk.style.opacity = '0';
                        setTimeout(function() { if (sk && sk.parentNode) sk.parentNode.removeChild(sk); }, 320);
                    }
                    if (content) content.style.opacity = '1';
                }, remaining);
            });

            /* ── Navigation progress bar ── */
            document.addEventListener('click', function(e) {
                var a = e.target.closest('a[href]');
                if (!a) return;
                try {
                    var href = a.getAttribute('href');
                    if (!href || href.charAt(0) === '#') return;
                    var url = new URL(a.href, location.href);
                    if (url.hostname !== location.hostname) return;
                    if (a.target && a.target !== '_self') return;
                    if (a.hasAttribute('download')) return;
                    if (url.pathname === location.pathname && url.hash) return;

                    var bar = document.getElementById('nav-progress');
                    if (bar) {
                        bar.style.width = '72%';
                        bar.classList.add('loading');
                    }
                } catch(err) {}
            }, true);
        })();

        document.addEventListener('DOMContentLoaded', function() {
            // Handle sidebar toggle
            window.addEventListener('sidebarToggle', function(e) {
                const main = document.getElementById('dashboardMain');
                if (e.detail.collapsed) {
                    main.classList.add('sidebar-collapsed');
                } else {
                    main.classList.remove('sidebar-collapsed');
                }
            });

            // Load initial sidebar state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth > 1024) {
                document.getElementById('dashboardMain').classList.add('sidebar-collapsed');
            }

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });

            // Counter animation
            const counters = document.querySelectorAll('.stat-number[data-target]');
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px'
            };

            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                        entry.target.classList.add('counted');
                        animateCounter(entry.target);
                    }
                });
            }, observerOptions);

            counters.forEach(counter => counterObserver.observe(counter));

            function animateCounter(element) {
                const target = parseFloat(element.dataset.target) || 0;
                const duration = 1500;
                const startTime = performance.now();
                const isDecimal = String(target).includes('.');

                function update(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 4);
                    const current = target * easeOut;

                    if (isDecimal) {
                        element.textContent = current.toFixed(1);
                    } else {
                        element.textContent = Math.floor(current);
                    }

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        element.textContent = isDecimal ? target.toFixed(1) : target;
                    }
                }

                requestAnimationFrame(update);
            }
        });
    </script>

    <script>window.__systemAlerts = @json($systemAlertsData ?? []);</script>
    @stack('scripts')
</body>
</html>
