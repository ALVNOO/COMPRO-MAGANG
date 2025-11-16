<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Penerimaan Magang - PT Telkom Indonesia')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root {
            --telkom-red: #EE2E24;
            --telkom-red-bright: #EE2B24;
            --telkom-red-pure: #F60000;
            --telkom-black: #000000;
            --telkom-gray: #AAA5A6;
            --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
            --gradient-secondary: linear-gradient(135deg, #000000 0%, #AAA5A6 100%);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--telkom-red) !important;
        }
        
        
        .footer {
            background: var(--gradient-secondary);
            color: white;
            padding: 40px 0;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }
        
        .btn-primary:hover {
            background: var(--gradient-primary);
            filter: brightness(1.1);
        }
        
        .navbar-nav .nav-link {
            font-size: 1.25rem;
            font-weight: 500;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link:focus, .navbar-nav .nav-link:hover {
            color: var(--telkom-red) !important;
        }
        
        .dropdown-menu .btn-logout {
            background-color: #dc3545 !important;
            color: #fff !important;
            width: 100%;
            text-align: left;
        }
        .dropdown-menu .btn-logout:hover {
            background-color: #b52a37 !important;
            color: #fff !important;
        }
        
        /* Logo and Brand Styling */
        .logo-container {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            flex-shrink: 0;
            overflow: visible;
        }
        
        .logo-img {
            max-width: none;
            max-height: none;
            width: 140px;
            height: 140px;
            object-fit: contain;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
            transform-origin: center center;
        }
        
        .logo-img:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 6px 12px rgba(0,0,0,0.2));
        }
        
        /* Hover effect untuk logo container - garis bawah */
        .logo-container:hover::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 140px;
            height: 3px;
            background: linear-gradient(90deg, var(--telkom-red), var(--bright-red));
            border-radius: 2px;
            z-index: 1;
            animation: logoUnderline 0.3s ease;
        }
        
        @keyframes logoUnderline {
            from {
                width: 0;
                opacity: 0;
            }
            to {
                width: 140px;
                opacity: 1;
            }
        }
        
        /* Logo scaling technique - logo bigger but container stays same */
        .logo-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 140px;
            height: 140px;
            transform: translate(-50%, -50%);
            background: transparent;
            z-index: 1;
        }
        
        
        .navbar-brand {
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.25rem 0;
            height: 70px;
            position: relative;
            z-index: 1;
            margin-right: 2rem;
        }
        
        .navbar-brand:hover {
            transform: translateY(-1px);
        }
        
        /* Navigation Improvements */
        .navbar {
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(238, 46, 36, 0.1);
            min-height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
        }
        
        .navbar-nav .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #333 !important;
            font-size: 0.95rem;
        }
        
        .navbar-nav.me-auto {
            margin-left: 1rem;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 80%;
        }
        
        .navbar-nav .nav-link:hover {
            background-color: rgba(238, 46, 36, 0.08);
            transform: translateY(-1px);
            color: var(--telkom-red) !important;
        }
        
        .navbar-nav .nav-link.active {
            color: var(--telkom-red) !important;
            background-color: rgba(238, 46, 36, 0.05);
        }
        
        /* Dropdown Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background-color: rgba(238, 46, 36, 0.1);
            color: var(--telkom-red);
            transform: translateX(5px);
        }
        
        .dropdown-item:active {
            background-color: rgba(238, 46, 36, 0.15);
        }
        
        /* Mobile Navigation */
        @media (max-width: 991.98px) {
            .navbar {
                min-height: 70px;
                padding: 0.25rem 0;
            }
            
            main {
                padding-top: 70px !important;
            }
            
            .navbar-brand {
                flex-direction: row;
                align-items: center;
                height: 60px;
                margin-right: 1rem;
            }
            
            .logo-container {
                width: 60px;
                height: 60px;
            }
            
            .logo-img {
                width: 120px;
                height: 120px;
            }
            
            .logo-fallback {
                width: 120px !important;
                height: 120px !important;
                font-size: 16px !important;
            }
            
            /* Mobile hover effect untuk logo container */
            .logo-container:hover::after {
                width: 120px;
                bottom: -6px;
            }
            
            .navbar-nav {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(238, 46, 36, 0.1);
                margin-left: 0.5rem;
            }
            
            .navbar-nav .nav-link {
                padding: 0.75rem 0;
                margin: 0.25rem 0;
                text-align: center;
            }
        }
        
        /* Navbar Toggler */
        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(238, 46, 36, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Header Enhancements */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .navbar-brand {
            position: relative;
        }
        
        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }
        
        .navbar-brand:hover::after {
            width: 100%;
        }
        
        /* Smooth scrolling for anchor links */
        html {
            scroll-behavior: smooth;
        }
        
        /* Better focus states */
        .navbar-nav .nav-link:focus {
            outline: 2px solid rgba(238, 46, 36, 0.3);
            outline-offset: 2px;
        }
        
        /* Ensure logo overflow doesn't affect layout */
        .navbar .container {
            position: relative;
            z-index: 1;
        }
        
        .navbar-nav {
            position: relative;
            z-index: 2;
        }
        
        /* Logo shadow for better visibility when overlapping */
        .logo-img {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .logo-img:hover {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
        }
    </style>
    
    @yield('styles')
</head>
<body style="margin: 0; padding: 0;">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="logo-container">
                    <img src="{{ asset('image/telkom-logo.png') }}" 
                         alt="PT Telkom Indonesia" 
                         class="logo-img"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-fallback" style="display: none; width: 140px; height: 140px; background: var(--gradient-primary); border-radius: 8px; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px; text-align: center; position: relative; z-index: 2;">
                        TELKOM
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('program') }}">Program Magang</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->role === 'pembimbing')
                                    <li><a class="dropdown-item" href="{{ route('mentor.dashboard') }}">Dashboard</a></li>
                                @elseif(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item btn-logout">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 80px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>PT Telkom Indonesia</h5>
                    <p>Perusahaan telekomunikasi terbesar di Indonesia</p>
                    <p><i class="fas fa-phone me-2"></i>+62 21 424 0000</p>
                    <p><i class="fas fa-envelope me-2"></i>info@telkom.co.id</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Ikuti Kami</h5>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} PT Telkom Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
    @yield('scripts')
</body>
</html> 