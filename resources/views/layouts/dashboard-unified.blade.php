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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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

        /* Grid Pattern */
        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: gridMove 30s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(40px, 40px); }
        }

        /* ============================================
           MAIN LAYOUT
           ============================================ */

        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .dashboard-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left var(--transition-spring);
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

        .alert-success .alert-icon {
            color: var(--color-success);
        }

        .alert-danger, .alert-error {
            border-left-color: var(--color-danger);
        }

        .alert-danger .alert-icon, .alert-error .alert-icon {
            color: var(--color-danger);
        }

        .alert-warning {
            border-left-color: var(--color-warning);
        }

        .alert-warning .alert-icon {
            color: var(--color-warning);
        }

        .alert-info {
            border-left-color: var(--color-info);
        }

        .alert-info .alert-icon {
            color: var(--color-info);
        }

        .alert-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-message {
            font-size: 0.9rem;
            color: var(--color-gray-700);
            line-height: 1.5;
        }

        .alert-close {
            background: none;
            border: none;
            color: var(--color-gray-400);
            cursor: pointer;
            font-size: 1.25rem;
            padding: 0;
            line-height: 1;
            transition: color 0.2s;
        }

        .alert-close:hover {
            color: var(--color-gray-600);
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
            background: var(--color-white);
            color: var(--color-gray-700);
            border: 1px solid var(--color-gray-300);
        }

        .btn-secondary:hover {
            background: var(--color-gray-50);
            border-color: var(--color-gray-400);
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

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        /* Counter Animation */
        .counter-value {
            transition: all 0.3s ease;
        }
    </style>

    @stack('styles')
</head>
<body>
    {{-- Background Effects --}}
    <div class="dashboard-bg">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
        <div class="floating-orb orb-4"></div>
        <div class="grid-pattern"></div>
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
                            <i class="fas fa-check-circle alert-icon"></i>
                            <div class="alert-content">
                                <p class="alert-message">{{ session('success') }}</p>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <div class="alert-content">
                                <p class="alert-message">{{ session('error') }}</p>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle alert-icon"></i>
                            <div class="alert-content">
                                <p class="alert-message">{{ session('warning') }}</p>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle alert-icon"></i>
                            <div class="alert-content">
                                <p class="alert-message">{{ session('info') }}</p>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle alert-icon"></i>
                            <div class="alert-content">
                                <ul class="alert-message" style="margin: 0; padding-left: 1rem;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Page Content --}}
            <div class="dashboard-content">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    <script>
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

    @stack('scripts')
</body>
</html>
