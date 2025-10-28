<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pembimbing Lapangan - PT Telkom Indonesia')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/mentor-dashboard.css') }}" rel="stylesheet">
    
    <style>
        /* Additional styles for dropdown and user menu */
        .user-dropdown {
            position: relative;
        }

        .user-menu-trigger {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-menu-trigger:hover {
            background: rgba(238, 46, 36, 0.1);
        }

        .user-menu-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-menu-name {
            font-weight: 500;
            color: var(--telkom-black);
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-hover);
            border-radius: 12px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 200px;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: rgba(238, 46, 36, 0.1);
            color: var(--telkom-red);
            transform: translateX(5px);
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-soft);
            backdrop-filter: blur(10px);
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%);
            color: #0c5460;
            border-left: 4px solid #0dcaf0;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
            color: #664d03;
            border-left: 4px solid #ffc107;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
            color: #0f5132;
            border-left: 4px solid #198754;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
            color: #842029;
            border-left: 4px solid #dc3545;
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('image/telkom.png') }}" alt="PT Telkom Indonesia" class="logo-img">
            </div>
            <div class="brand-text">Telkom Indonesia</div>
        </div>
        
        <div class="user-info">
            <div class="user-avatar">
                {{ substr(Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name, 0, 1) }}
            </div>
            <div class="user-name">{{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}</div>
            <div class="user-role">Pembimbing Lapangan</div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('mentor.dashboard') }}" class="nav-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('mentor.penugasan') }}" class="nav-link {{ request()->routeIs('mentor.penugasan') ? 'active' : '' }}">
                    <i class="fas fa-tasks nav-icon"></i>
                    <span class="nav-text">Penugasan & Penilaian</span>
                </a>
            </div>
        </nav>
        
        <div class="mt-auto p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100" style="border-radius: 12px; font-weight: 500;">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <div class="top-navbar">
            <div class="navbar-content">
                <div>
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="navbar-actions">
                    <div class="user-dropdown">
                        <button class="user-menu-trigger">
                            <div class="user-menu-avatar">
                                {{ substr(Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="user-menu-name">{{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('mentor.profil') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show animate-slide-up" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-slide-up" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });

        // Mobile Sidebar Toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Ensure logout buttons work properly
        document.querySelectorAll('form[action*="logout"] button[type="submit"]').forEach(button => {
            button.addEventListener('click', function(e) {
                // Don't prevent default - let form submit
                e.stopPropagation();
            });
        });

        // Add loading animation to buttons
        document.querySelectorAll('button[type="submit"]').forEach(button => {
            button.addEventListener('click', function(e) {
                // Don't show loading for logout buttons
                if (this.form && this.form.action && this.form.action.includes('logout')) {
                    return;
                }
                
                if (this.form && this.form.checkValidity()) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                    this.disabled = true;
                }
            });
        });

        // User dropdown toggle
        const userMenuTrigger = document.querySelector('.user-menu-trigger');
        const dropdownMenu = document.querySelector('.dropdown-menu');
        
        if (userMenuTrigger && dropdownMenu) {
            userMenuTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                // Don't close if clicking on a form button or form element
                if ((event.target.tagName === 'BUTTON' && event.target.type === 'submit') ||
                    event.target.closest('form')) {
                    return;
                }
                
                if (!userMenuTrigger.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        // Close dropdown when clicking on menu items (but not form buttons)
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't close if it's a form button
                if (e.target.tagName === 'BUTTON' && e.target.type === 'submit') {
                    return;
                }
                dropdownMenu.classList.remove('show');
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>