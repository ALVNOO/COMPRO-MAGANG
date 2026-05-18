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
    <style>
        @keyframes sk-pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        .sk-bl { background:#E9EAEC; border-radius:8px; animation:sk-pulse 1.5s ease-in-out infinite; }
        #pg-sk { position:fixed; inset:0; z-index:9000; background:#F0F2F5; display:flex; transition:opacity .3s ease; pointer-events:none; }
        #pg-sk .sk-sidebar { width:260px; flex-shrink:0; background:linear-gradient(180deg,#1a1a2e,#16213e); padding:1.5rem 1rem; display:flex; flex-direction:column; gap:1rem; }
        #pg-sk .sk-main { flex:1; padding:2rem; display:flex; flex-direction:column; gap:1.5rem; overflow:hidden; }
        #nav-progress { position:fixed; top:0; left:0; height:3px; width:0%; z-index:9999; opacity:0; background:linear-gradient(90deg,#EE2E24,#FF6B6B,#EE2E24); background-size:200% 100%; transition:width .4s ease,opacity .15s ease; }
        #nav-progress.loading { opacity:1; animation:np-sh 1.2s linear infinite; }
        @keyframes np-sh { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
    </style>
</head>
<body>
    <div id="nav-progress"></div>
    <div id="pg-sk" aria-hidden="true">
        <div class="sk-sidebar">
            <div class="sk-bl" style="height:60px;border-radius:12px;background:rgba(255,255,255,.12);animation-delay:.05s;"></div>
            <div style="height:1px;background:rgba(255,255,255,.08);margin:.25rem 0;"></div>
            <div class="sk-bl" style="height:44px;border-radius:10px;background:rgba(255,255,255,.18);animation-delay:.08s;"></div>
            @for($i=0;$i<6;$i++)<div class="sk-bl" style="height:36px;border-radius:10px;background:rgba(255,255,255,.1);animation-delay:{{ ($i+1)*.06 }}s;"></div>@endfor
        </div>
        <div class="sk-main">
            <div class="sk-bl" style="height:70px;border-radius:16px;background:#DDDFE2;animation-delay:.1s;"></div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;">
                @for($i=0;$i<4;$i++)<div class="sk-bl" style="height:88px;border-radius:16px;background:#DDDFE2;animation-delay:{{ .15+$i*.08 }}s;"></div>@endfor
            </div>
            <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:1.5rem;">
                <div class="sk-bl" style="height:260px;border-radius:16px;background:#DDDFE2;animation-delay:.22s;"></div>
                <div class="sk-bl" style="height:260px;border-radius:16px;background:#DDDFE2;animation-delay:.3s;"></div>
            </div>
        </div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('image/logo_terbaru.png') }}" alt="Logo" class="logo-img">
            </div>
            <div class="brand-text">Telkom Indonesia</div>
        </div>
        
        <div class="user-info">
            @php
                $divisionMentor = \App\Models\DivisionMentor::where('nik_number', Auth::user()->username)->first();
                $mentorName = $divisionMentor ? $divisionMentor->mentor_name : Auth::user()->name;
            @endphp
            <div class="user-avatar">
                {{ strtoupper(substr($mentorName, 0, 1)) }}
            </div>
            <div class="user-name">{{ $mentorName }}</div>
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
            <div class="nav-item">
                <a href="{{ route('mentor.evaluasi-akhir') }}" class="nav-link {{ request()->routeIs('mentor.evaluasi-akhir*') ? 'active' : '' }}">
                    <i class="fas fa-file-signature nav-icon"></i>
                    <span class="nav-text">Evaluasi Akhir</span>
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
                            @php
                                $divisionMentor = \App\Models\DivisionMentor::where('nik_number', Auth::user()->username)->first();
                                $mentorName = $divisionMentor ? $divisionMentor->mentor_name : Auth::user()->name;
                            @endphp
                            <div class="user-menu-avatar">
                                {{ strtoupper(substr($mentorName, 0, 1)) }}
                            </div>
                            <span class="user-menu-name">{{ $mentorName }}</span>
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
    <script>
    (function(){
        var _t0=Date.now();
        document.addEventListener('DOMContentLoaded',function(){
            var r=Math.max(0,150-(Date.now()-_t0));
            setTimeout(function(){
                var sk=document.getElementById('pg-sk');
                if(sk){sk.style.opacity='0';setTimeout(function(){if(sk&&sk.parentNode)sk.parentNode.removeChild(sk);},320);}
            },r);
        });
        document.addEventListener('click',function(e){
            var a=e.target.closest('a[href]');if(!a)return;
            try{var u=new URL(a.href,location.href);if(u.hostname!==location.hostname||a.target||a.hasAttribute('download'))return;if(u.pathname===location.pathname&&u.hash)return;var b=document.getElementById('nav-progress');if(b){b.style.width='72%';b.classList.add('loading');}}catch(x){}
        },true);
    })();
    </script>
</body>
</html>