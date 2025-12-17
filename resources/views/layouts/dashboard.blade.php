<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Peserta')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7f8fb;
            overflow-x: hidden;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .brand {
            padding: 1.5rem 1rem;
            font-weight: 700;
            color: #ffffff;
            font-size: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .sidebar .brand i {
            font-size: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .sidebar .nav {
            padding: 1rem 0;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.875rem 1.5rem;
            border-radius: 0;
            margin: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .sidebar .nav-link i {
            width: 1.25rem;
            margin-right: 0.75rem;
            font-size: 1rem;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .main {
            margin-left: 260px;
            min-height: 100vh;
            background: #f7f8fb;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            overflow-x: hidden;
            width: calc(100% - 260px);
        }
        
        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
            padding-left: 0;
            padding-right: 0;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        .row > * {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .card {
            max-width: 100%;
            overflow: hidden;
        }
        
        .card-body {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 1rem;
                width: 100%;
            }
            
            .container-fluid {
                padding: 0.5rem;
            }
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
            color: #ffffff;
            border-radius: 1rem 1rem 0 0 !important;
            padding: 1rem 1.5rem;
            border: none;
        }
        
        .profile-section {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        
        .profile-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto 1rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .profile-name {
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 0.25rem;
        }
        
        .profile-email {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            text-align: center;
            word-break: break-word;
        }
        
        .card-header h5 {
            margin: 0;
            font-weight: 600;
        }
        
        .btn-logout {
            margin: 1rem 0.5rem;
            width: calc(100% - 1rem);
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #ffffff;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        .toast-container {
            z-index: 1055;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main {
                margin-left: 0;
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            animation: fadeIn 0.5s ease-out;
        }
        
        .table th {
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
        }
        
        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="container-fluid p-0">
    <div class="row g-0">
        <aside class="sidebar">
            <div class="brand">
                <i class="fas fa-user-graduate"></i>
                <span>Peserta Magang</span>
            </div>
            
            <!-- Profile Section -->
            <a href="{{ route('dashboard.profile') }}" class="profile-section-link" style="text-decoration: none; color: inherit;">
                <div class="profile-section">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="profile-name">{{ Auth::user()->name ?? 'User' }}</div>
                    <div class="profile-email">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </a>
            
            <nav class="nav flex-column" style="flex: 1; overflow-y: auto;">
                @php
                    $user = Auth::user();
                    $application = $user->internshipApplications()
                        ->whereIn('status', ['pending', 'accepted', 'finished'])
                        ->latest()
                        ->first();
                    $isAccepted = $application && in_array($application->status, ['accepted', 'finished']);
                    $isPending = $application && $application->status === 'pending';
                @endphp
                
                @if($isAccepted)
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-gauge"></i>
                    <span>Dashboard</span>
                </a>
                @else
                <a class="nav-link {{ request()->routeIs('dashboard.status') ? 'active' : '' }}" href="{{ route('dashboard.status') }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Status Pengajuan</span>
                </a>
                @endif
                
                @if($isAccepted)
                <a class="nav-link {{ request()->routeIs('dashboard.assignments') ? 'active' : '' }}" href="{{ route('dashboard.assignments') }}">
                    <i class="fas fa-tasks"></i>
                    <span>Tugas</span>
                </a>
                <a class="nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Absensi</span>
                </a>
                <a class="nav-link {{ request()->routeIs('logbook.index') ? 'active' : '' }}" href="{{ route('logbook.index') }}">
                    <i class="fas fa-book"></i>
                    <span>Logbook</span>
                </a>
                <a class="nav-link {{ request()->routeIs('dashboard.certificates') ? 'active' : '' }}" href="{{ route('dashboard.certificates') }}">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>
                @endif
            </nav>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </aside>
        
        <main class="main">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show alert-notification" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show alert-notification" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
    // Auto-hide notifications after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.alert-notification');
        notifications.forEach(function(notification) {
            setTimeout(function() {
                notification.style.transition = 'opacity 0.5s ease-out';
                notification.style.opacity = '0';
                setTimeout(function() {
                    notification.remove();
                }, 500);
            }, 3000);
        });
    });
</script>
</body>
</html>

