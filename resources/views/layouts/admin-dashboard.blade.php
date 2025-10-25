<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 bg-dark text-white min-vh-100">
            <div class="d-flex flex-column p-3 h-100">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-4"><i class="fas fa-user-shield me-2"></i>Admin Panel</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.applications') }}" class="nav-link text-white">
                            <i class="fas fa-inbox me-2"></i>Pengajuan Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.participants') }}" class="nav-link text-white">
                            <i class="fas fa-users me-2"></i>Daftar Peserta Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mentors') }}" class="nav-link text-white">
                            <i class="fas fa-user-tie me-2"></i>Monitoring Pembimbing
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports') }}" class="nav-link text-white">
                            <i class="fas fa-chart-bar me-2"></i>Report Peserta Magang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.divisions') }}" class="nav-link text-white">
                            <i class="fas fa-sitemap me-2"></i>Divisi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.fields') }}" class="nav-link text-white">
                            <i class="fas fa-tags me-2"></i>Bidang Peminatan
                        </a>
                    </li>
                </ul>
                <hr>
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-0">
            <main class="p-4">
                <!-- Session Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="z-index: 9999;">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="z-index: 9999;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="z-index: 9999;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="d-flex justify-content-end mb-3">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @yield('admin-content')
            </main>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Auto hide alert after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@stack('scripts')
</body>
</html> 