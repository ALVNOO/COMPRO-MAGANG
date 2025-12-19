<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Pembimbing Lapangan - PT Telkom Indonesia')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/mentor-dashboard.css', 'resources/js/mentor-dashboard.js'])
    
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
            <div class="nav-item">
                <a href="{{ route('mentor.absensi') }}" class="nav-link {{ request()->routeIs('mentor.absensi') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <span class="nav-text">Absensi</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('mentor.logbook') }}" class="nav-link {{ request()->routeIs('mentor.logbook') ? 'active' : '' }}">
                    <i class="fas fa-book nav-icon"></i>
                    <span class="nav-text">Logbook</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('mentor.laporan-penilaian') }}" class="nav-link {{ request()->routeIs('mentor.laporan-penilaian') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar nav-icon"></i>
                    <span class="nav-text">Laporan Penilaian</span>
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
                <div class="alert alert-success alert-dismissible fade show animate-slide-up alert-notification" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-slide-up alert-notification" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    
    @yield('scripts')
</body>
</html>