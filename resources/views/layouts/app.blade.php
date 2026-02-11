<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Program Magang PT Telkom Indonesia - Kembangkan karir Anda bersama perusahaan telekomunikasi terbesar di Indonesia">
    <title>@yield('title', 'Sistem Penerimaan Magang - PT Telkom Indonesia')</title>

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/public-app.css', 'resources/js/public-app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <!-- Cropper.js for image cropping -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

    @stack('styles')
</head>
<body class="public-page">
    <!-- Navigation -->
    <nav class="navbar" x-data="{ mobileOpen: false, userDropdownOpen: false }">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('image/telkom-logo.png') }}"
                     alt="PT Telkom Indonesia"
                     class="navbar-logo"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="navbar-logo-fallback" style="display: none;">
                    <span>TELKOM</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="navbar-nav desktop-nav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('program') }}" class="nav-link {{ request()->routeIs('program') ? 'active' : '' }}">
                    Program Magang
                </a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    Tentang
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="navbar-actions desktop-nav">
                @auth
                    <div class="user-dropdown" id="userDropdown">
                        <button class="user-trigger" id="userDropdownTrigger" type="button">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email ?? 'U', 0, 1)) }}
                            </div>
                            <span class="user-name">{{ Auth::user()->name ?? explode('@', Auth::user()->email ?? 'User')[0] }}</span>
                            <svg class="dropdown-arrow" id="dropdownArrow" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="dropdown-menu" id="userDropdownMenu">
                            @if(Auth::user()->role === 'pembimbing')
                                <a href="{{ route('mentor.dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @elseif(Auth::user()->role === 'admin')
                                <a href="/admin/dashboard" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-nav-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-nav-primary">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" @click="mobileOpen = !mobileOpen">
                <svg x-show="!mobileOpen" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18"/>
                </svg>
                <svg x-show="mobileOpen" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" x-show="mobileOpen" x-transition>
            <a href="{{ route('home') }}" class="mobile-nav-link">Beranda</a>
            <a href="{{ route('program') }}" class="mobile-nav-link">Program Magang</a>
            <a href="{{ route('about') }}" class="mobile-nav-link">Tentang</a>
            <div class="mobile-nav-divider"></div>
            @auth
                @if(Auth::user()->role === 'pembimbing')
                    <a href="{{ route('mentor.dashboard') }}" class="mobile-nav-link">Dashboard</a>
                @elseif(Auth::user()->role === 'admin')
                    <a href="/admin/dashboard" class="mobile-nav-link">Dashboard</a>
                @else
                    <a href="{{ route('dashboard') }}" class="mobile-nav-link">Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="mobile-nav-link logout">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="btn-nav-primary mobile-cta">Daftar Sekarang</a>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
    <div class="flash-container">
        @if(session('success'))
            <div class="flash-message flash-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="flash-close">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="flash-message flash-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="flash-close">&times;</button>
            </div>
        @endif
    </div>
    @endif

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- Brand -->
                <div class="footer-brand">
                    <img src="{{ asset('image/telkom-logo.png') }}" alt="Telkom" class="footer-logo" onerror="this.style.display='none'">
                    <p class="footer-tagline">Menghubungkan Indonesia, membangun masa depan digital bersama talenta muda berbakat.</p>
                </div>

                <!-- Quick Links -->
                <div class="footer-links">
                    <h4>Tautan</h4>
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('program') }}">Program Magang</a>
                    <a href="{{ route('about') }}">Tentang Kami</a>
                </div>

                <!-- Contact -->
                <div class="footer-contact">
                    <h4>Kontak</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Japati No. 1, Bandung</p>
                    <p><i class="fas fa-envelope"></i> magang@telkom.co.id</p>
                    <p><i class="fas fa-phone"></i> (022) 452 0000</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} PT Telkom Indonesia. All rights reserved.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <x-ui.toast />

    <!-- Cropper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    @stack('scripts')
    @yield('scripts')

    <!-- Navbar Dropdown Script (Pure JavaScript - No Alpine.js dependency) -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // User Dropdown Toggle
        const userTrigger = document.getElementById('userDropdownTrigger');
        const dropdownMenu = document.getElementById('userDropdownMenu');
        const dropdownArrow = document.getElementById('dropdownArrow');

        if (userTrigger && dropdownMenu) {
            let isOpen = false;

            function openDropdown() {
                isOpen = true;
                dropdownMenu.style.display = 'block';
                dropdownMenu.style.opacity = '1';
                dropdownMenu.style.visibility = 'visible';
                dropdownMenu.style.transform = 'translateY(0)';
                if (dropdownArrow) dropdownArrow.classList.add('rotate');
            }

            function closeDropdown() {
                isOpen = false;
                dropdownMenu.style.display = 'none';
                dropdownMenu.style.opacity = '0';
                dropdownMenu.style.visibility = 'hidden';
                dropdownMenu.style.transform = 'translateY(-10px)';
                if (dropdownArrow) dropdownArrow.classList.remove('rotate');
            }

            userTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                if (isOpen) {
                    closeDropdown();
                } else {
                    openDropdown();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (isOpen && !userTrigger.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    closeDropdown();
                }
            });

            // Close dropdown on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isOpen) {
                    closeDropdown();
                }
            });
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileNav = document.querySelector('.mobile-nav');

        if (mobileMenuBtn && mobileNav) {
            let mobileOpen = false;

            mobileMenuBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                mobileOpen = !mobileOpen;

                if (mobileOpen) {
                    mobileNav.style.display = 'flex';
                    mobileNav.style.flexDirection = 'column';
                } else {
                    mobileNav.style.display = 'none';
                }
            });
        }
    });
    </script>
</body>
</html>
