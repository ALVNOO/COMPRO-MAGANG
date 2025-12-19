<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Vite Assets -->
    @vite(['resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body, html {font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';}

        /* Override warna link bawaan Bootstrap di sidebar admin */
        aside a {
            color: #1b1b18;
            text-decoration: none;
        }

        aside a:hover {
            color: #B91C1C;
        }
        
        .dropdown-menu {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.2s ease;
            pointer-events: none;
            z-index: 1000;
        }
        
        /* Override Bootstrap: jika class hidden dihapus, paksa tampil */
        .dropdown-menu:not(.hidden) {
            display: block;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .dropdown-menu form {
            margin: 0;
        }
        
        .dropdown-menu button[type="submit"] {
            cursor: pointer;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            padding: 0;
            font-size: inherit;
            color: inherit;
        }
        
        .dropdown-menu button[type="submit"]:hover {
            background-color: #dbdbd7;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <div class="flex flex-1 min-h-0 bg-gradient-to-br from-[#B91C1C] via-[#fff2f2] to-[#F8F9FB]">
        <!-- Sidebar -->
        <aside class="w-[235px] p-6 bg-white border-r border-[#dbdbd7] flex flex-col min-h-screen shadow-xl relative z-10">
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 rounded-full bg-white shadow-lg flex items-center justify-center mb-2">
                    <img src="/image/telkom-logo.png" alt="Telkom Logo" class="w-12 h-12 object-contain">
                </div>
                <span class="text-[#B91C1C] text-xl font-bold leading-tight">Admin Panel</span>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.dashboard') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.applications') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.applications') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-inbox mr-2"></i>Pengajuan Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.participants') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.participants') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-users mr-2"></i>Daftar Peserta Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mentors') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.mentors') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-user-tie mr-2"></i>Monitoring Pembimbing
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.attendance') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.attendance') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-calendar-check mr-2"></i>Absensi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.logbook') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.logbook') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-book mr-2"></i>Logbook
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.reports') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-chart-bar mr-2"></i>Report Peserta Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fields') }}"
                            class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.fields') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                            <i class="fas fa-tags mr-2"></i>Bidang Peminatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.divisions.index') }}"
                           class="flex items-center px-3 py-2 rounded-sm border-l-4 transition font-medium border-l-transparent hover:border-l-[#B91C1C] hover:text-[#B91C1C] {{ request()->routeIs('admin.divisions.*') ? 'border-l-[#B91C1C] bg-[#FEF2F2] text-[#B91C1C] font-semibold' : '' }} transform hover:scale-105">
                             <i class="fas fa-sitemap mr-2"></i>Kelola Divisi
                        </a>
                    </li>
                </ul>
            </nav>
            <form action="{{ route('logout') }}" method="POST" class="mt-8">
                @csrf
                <button type="submit" class="w-full px-3 py-2 rounded-sm border-[#e3e3e0] border text-[#B91C1C] font-semibold bg-white hover:bg-[#fee2e2] transition flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-auto min-h-screen relative z-0">
            <!-- Gradient bar accent -->
            <div class="absolute left-0 right-0 -top-8 h-3 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded-b-2xl opacity-75 z-10"></div>
            <!-- SVG Pattern bottom right for accent -->
            <svg class="absolute bottom-0 right-0 w-96 h-96 opacity-30 z-0 pointer-events-none" viewBox="0 0 380 380" fill="none"><circle cx="320" cy="320" r="160" fill="url(#br-red2)"/><defs><radialGradient id="br-red2" cx="0" cy="0" r="1" gradientTransform="translate(320 320) scale(180 160)" gradientUnits="userSpaceOnUse"><stop stop-color="#fff2f2"/><stop offset="0.4" stop-color="#B91C1C" stop-opacity="0.5"/><stop offset="1" stop-color="#B91C1C" stop-opacity="0.18"/></radialGradient></defs></svg>
            <!-- Session Messages -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4 flex items-center gap-3 alert-notification">
                <i class="fas fa-check-circle"></i> <span><strong>Berhasil!</strong> {{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4 flex items-center gap-3 alert-notification">
                <i class="fas fa-exclamation-triangle"></i><span><strong>Error!</strong> {{ session('error') }}</span>
            </div>
            @endif
            @if($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-4 alert-notification">
                <strong>Error!</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-4 flex justify-end">
                <div class="relative" style="z-index: 1000;">
                    <button class="px-4 py-2 bg-white border border-[#e3e3e0] rounded-sm text-[#1b1b18] font-medium flex items-center gap-2 hover:bg-[#dbdbd7] cursor-pointer" id="adminDropdown">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <ul class="dropdown-menu absolute right-0 top-full mt-2 w-48 bg-white shadow-md border rounded-sm text-sm hidden" aria-labelledby="adminDropdown" style="z-index: 1001;">
                        <li><a class="dropdown-item p-3 hover:bg-[#dbdbd7] block" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><hr class="my-1 border-[#e3e3e0]"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item p-3 w-full text-left hover:bg-[#dbdbd7] block cursor-pointer">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('admin-content')
        </main>
    </div>

    @stack('scripts')
</body>
</html> 