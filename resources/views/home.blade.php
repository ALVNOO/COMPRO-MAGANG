@extends('layouts.app')

@section('title', 'Beranda - Sistem Penerimaan Magang PT Telkom Indonesia')

@push('styles')
<style>
:root {
    --telkom-red: #EE2E24;
    --telkom-red-bright: #EE2B24;
    --telkom-red-pure: #F60000;
    --telkom-black: #000000;
    --telkom-gray: #AAA5A6;
    --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
    --gradient-secondary: linear-gradient(135deg, #000000 0%, #AAA5A6 100%);
    --gradient-accent: linear-gradient(135deg, #EE2B24 0%, #EE2E24 100%);
}

.hero-section {
    background: var(--gradient-primary), url('/image/Kantor_Pusat_Pos_Indonesia.jpeg') center right/cover no-repeat;
    color: white;
    padding: 100px 0 60px 0;
    min-height: 450px;
    position: relative;
    overflow: hidden;
    margin-top: 0;
    z-index: 1;
    clear: both;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(0,0,0,0.1) 0%, rgba(238,46,36,0.1) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    animation: float 6s ease-in-out infinite;
}

.floating-circle:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-circle:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.floating-circle:nth-child(3) {
    width: 60px;
    height: 60px;
    top: 40%;
    right: 30%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.stats-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-primary);
}

.stats-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.15);
}

.stats-number {
    font-size: 3rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}

.process-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
    position: relative;
    height: 100%;
}

.process-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.process-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--gradient-primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
    margin: 0 auto 1rem;
}

.feature-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: none;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.btn-telkom {
    background: var(--gradient-primary);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(238,46,36,0.2);
}

.btn-telkom:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238,46,36,0.4);
    color: white;
    filter: brightness(1.1);
}

.btn-telkom-outline {
    background: white;
    border: 2px solid var(--telkom-red);
    color: var(--telkom-red);
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.btn-telkom-outline:hover {
    background: var(--telkom-red);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238,46,36,0.3);
    border-color: var(--telkom-red);
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.cta-section {
    background: var(--gradient-secondary);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.cta-content {
    position: relative;
    z-index: 2;
}

.progress-ring {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
}

.progress-ring circle {
    fill: none;
    stroke-width: 8;
    stroke-linecap: round;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}

.progress-ring .background {
    stroke: rgba(255,255,255,0.2);
}

.progress-ring .progress {
    stroke: var(--telkom-red);
    stroke-dasharray: 251.2;
    stroke-dashoffset: 50.24;
    animation: progress 2s ease-in-out;
}

@keyframes progress {
    from { stroke-dashoffset: 251.2; }
    to { stroke-dashoffset: 50.24; }
}

/* Button Improvements */
.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%) !important;
    border: none !important;
    color: #000 !important;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
}

.btn-warning:hover {
    background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
    color: #000 !important;
}

.btn-light {
    background: rgba(255, 255, 255, 0.95) !important;
    color: #000 !important;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-light:hover {
    background: var(--telkom-red) !important;
    color: white !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(238, 46, 36, 0.3);
    border-color: var(--telkom-red) !important;
}

/* Hero Visual Container */
.hero-visual-container {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Floating Icons */
.floating-icons {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.icon-item {
    position: absolute;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    animation: floatIcon 4s ease-in-out infinite;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

@keyframes floatIcon {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

/* Brand Center */
.brand-center {
    position: relative;
    z-index: 2;
    text-align: center;
}

.brand-circle {
    width: 200px;
    height: 200px;
    background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    backdrop-filter: blur(20px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    animation: pulse 3s ease-in-out infinite;
}

.brand-inner {
    width: 120px;
    height: 120px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: white;
    box-shadow: 0 10px 30px rgba(238, 46, 36, 0.3);
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.brand-text {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 10px;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.brand-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 300;
    letter-spacing: 2px;
    text-transform: uppercase;
}

/* Data Flow Lines */
.data-lines {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.line {
    position: absolute;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    height: 2px;
    animation: dataFlow 3s linear infinite;
}

.line-1 {
    top: 25%;
    left: 0;
    width: 100%;
    animation-delay: 0s;
}

.line-2 {
    top: 45%;
    right: 0;
    width: 80%;
    transform: rotate(15deg);
    animation-delay: 1s;
}

.line-3 {
    top: 65%;
    left: 0;
    width: 90%;
    animation-delay: 2s;
}

.line-4 {
    top: 35%;
    left: 10%;
    width: 70%;
    transform: rotate(-10deg);
    animation-delay: 1.5s;
}

@keyframes dataFlow {
    0% { transform: translateX(-100%); opacity: 0; }
    50% { opacity: 1; }
    100% { transform: translateX(100%); opacity: 0; }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 80px 0 40px 0;
        min-height: 350px;
    }
    
    .hero-visual-container {
        height: 400px;
    }
    
    .icon-item {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .brand-circle {
        width: 150px;
        height: 150px;
    }
    
    .brand-inner {
        width: 90px;
        height: 90px;
        font-size: 36px;
    }
    
    .brand-text {
        font-size: 2rem;
    }
    
    .brand-subtitle {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .stats-number {
        font-size: 2.5rem;
    }
}
</style>
@endpush

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <div class="mb-4" style="margin-top: 20px;">
                    <span class="badge bg-white text-dark px-3 py-2 rounded-pill mb-3">
                        <i class="fas fa-star me-2" style="color: #F60000;"></i>
                        Program Magang Terpercaya
                    </span>
                </div>
                <h1 class="display-3 fw-bold mb-4">
                    Selamat Datang di Program Magang<br>
                    <span class="text-warning">PT Telkom Indonesia</span>
                </h1>
                <p class="lead mb-4 fs-5">
                    Bergabunglah dengan kami dalam program magang yang akan memberikan pengalaman berharga di perusahaan telekomunikasi terbesar di Indonesia. 
                    Kembangkan skill profesional Anda bersama para ahli di bidangnya.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('program') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-pill fw-bold text-dark">
                    <i class="fas fa-rocket me-2"></i>Lihat Program Magang
                </a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-bold text-dark border-2" style="border-color: var(--telkom-red) !important;">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-visual-container">
                    <!-- Animated Icons -->
                    <div class="floating-icons">
                        <div class="icon-item" style="top: 20%; left: 10%; animation-delay: 0s;">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div class="icon-item" style="top: 30%; right: 15%; animation-delay: 1s;">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <div class="icon-item" style="top: 60%; left: 5%; animation-delay: 2s;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="icon-item" style="top: 70%; right: 10%; animation-delay: 3s;">
                            <i class="fas fa-satellite-dish"></i>
                        </div>
                        <div class="icon-item" style="top: 40%; left: 50%; animation-delay: 4s;">
                            <i class="fas fa-cloud"></i>
                        </div>
                    </div>
                    
                    <!-- Central Brand Element -->
                    <div class="brand-center">
                        <div class="brand-circle">
                            <div class="brand-inner">
                                <i class="fas fa-broadcast-tower"></i>
                            </div>
                        </div>
                        <h3 class="brand-text">PT Telkom Indonesia</h3>
                        <p class="brand-subtitle">Connecting Indonesia</p>
                    </div>
                    
                    <!-- Data Flow Lines -->
                    <div class="data-lines">
                        <div class="line line-1"></div>
                        <div class="line line-2"></div>
                        <div class="line line-3"></div>
                        <div class="line line-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Prosedur Pengajuan Magang</h2>
            <p class="lead text-muted">Ikuti langkah-langkah sederhana untuk bergabung dengan program magang kami</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row g-4">
                    <div class="col-md-4 col-12">
                        <div class="process-card text-center">
                            <div class="process-number">1</div>
                            <div class="mb-3">
                                <i class="fas fa-user-plus fa-3x" style="color: var(--telkom-red);"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Registrasi & Ajukan Magang</h5>
                            <p class="text-muted">Buat akun, lengkapi data pribadi, dan upload surat pengantar serta dokumen pengajuan magang yang diperlukan.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>5 menit
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="process-card text-center">
                            <div class="process-number">2</div>
                            <div class="mb-3">
                                <i class="fas fa-sign-in-alt fa-3x" style="color: var(--telkom-red);"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Login & Tracking</h5>
                            <p class="text-muted">Masuk ke sistem menggunakan akun yang sudah didaftarkan dan pantau status pengajuan Anda secara real-time.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>1 menit
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="process-card text-center">
                            <div class="process-number">3</div>
                            <div class="mb-3">
                                <i class="fas fa-check-circle fa-3x" style="color: var(--telkom-red);"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Verifikasi & Mulai Magang</h5>
                            <p class="text-muted">Tunggu proses verifikasi dan persetujuan dari mentor divisi, kemudian mulailah perjalanan magang Anda.</p>
                            <div class="mt-3">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>1-3 hari
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Process Steps -->
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                            <div class="me-3">
                                <i class="fas fa-tasks fa-2x" style="color: var(--telkom-red);"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Pengerjaan Tugas</h6>
                                <small class="text-muted">Menerima dan mengerjakan tugas dari mentor</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm">
                            <div class="me-3">
                                <i class="fas fa-certificate fa-2x" style="color: var(--telkom-red);"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Sertifikat Magang</h6>
                                <small class="text-muted">Mendapatkan sertifikat resmi setelah selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Features Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Bidang Peminatan Magang</h2>
                <p class="lead text-muted">
                    Temukan bidang peminatan yang sesuai dengan passion dan karir impian Anda. 
                    Di luar bidang peminatan ini, kami tetap membuka kesempatan untuk bergabung 
                    dengan program magang PT Telkom Indonesia.
                </p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="fas fa-tags fa-3x" style="color: var(--telkom-red);"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Bidang Peminatan Populer</h4>
                            <p class="text-muted mb-0">Pilih bidang yang sesuai dengan minat dan karir Anda</p>
                        </div>
                                                                                </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <i class="fas fa-laptop-code me-3 fa-2x" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Information Technology (IT)</h6>
                                    <small class="text-muted">150+ Posisi tersedia</small>
                                                                                </div>
                                                                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <i class="fas fa-broadcast-tower me-3 fa-2x" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Network & Telecommunications</h6>
                                    <small class="text-muted">100+ Posisi tersedia</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                        <div class="col-12">
                            <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                <i class="fas fa-chart-line me-3 fa-2x" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Digital Business</h6>
                                    <small class="text-muted">80+ Posisi tersedia</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('program') }}" class="btn-telkom">
                            <i class="fas fa-search me-2"></i>Lihat Semua Bidang Peminatan
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <i class="fas fa-plus-circle fa-3x" style="color: var(--telkom-red);"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Kesempatan Lainnya</h4>
                            <p class="text-muted mb-0">Bidang minat Anda tidak ada di list? Jangan khawatir!</p>
                        </div>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                <i class="fas fa-handshake me-3 mt-1" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Bidang Kustom</h6>
                                    <small class="text-muted">Kami terbuka untuk bidang minat khusus Anda</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                <i class="fas fa-lightbulb me-3 mt-1" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Inovasi & Kreativitas</h6>
                                    <small class="text-muted">Bawa ide dan inovasi baru ke perusahaan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                <i class="fas fa-users me-3 mt-1" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Kolaborasi Tim</h6>
                                    <small class="text-muted">Bekerja sama dengan berbagai divisi</small>
                                            </div>
                                        </div>
                                    </div>
                        <div class="col-12">
                            <div class="d-flex align-items-start p-3 bg-light rounded-3">
                                <i class="fas fa-rocket me-3 mt-1" style="color: var(--telkom-red);"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Pengembangan Karir</h6>
                                    <small class="text-muted">Peluang karir yang sesuai passion Anda</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="text-center mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="p-4 bg-light rounded-3">
                        <h4 class="fw-bold mb-3">Siap Memulai Perjalanan Magang Anda?</h4>
                        <p class="text-muted mb-4">
                            Baik Anda memiliki bidang minat yang spesifik atau ingin mengeksplorasi 
                            kesempatan baru, kami siap membantu mengembangkan potensi Anda.
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="{{ route('program') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Lihat Bidang Peminatan
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Pencapaian Kami</h2>
            <p class="lead text-muted">Angka-angka yang membanggakan dari program magang kami</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="mb-3">
                        <i class="fas fa-building fa-3x" style="color: var(--telkom-red);"></i>
                    </div>
                    <div class="stats-number">50+</div>
                    <h5 class="fw-bold mb-2">Divisi Tersedia</h5>
                    <p class="text-muted mb-0">Berbagai divisi di seluruh Indonesia</p>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" style="width: 85%; background: var(--gradient-primary);"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="mb-3">
                        <i class="fas fa-graduation-cap fa-3x" style="color: var(--telkom-red);"></i>
                    </div>
                    <div class="stats-number">2,500+</div>
                    <h5 class="fw-bold mb-2">Peserta Magang</h5>
                    <p class="text-muted mb-0">Mahasiswa yang telah bergabung</p>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" style="width: 90%; background: var(--gradient-primary);"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt fa-3x" style="color: var(--telkom-red);"></i>
                    </div>
                    <div class="stats-number">500+</div>
                    <h5 class="fw-bold mb-2">Kantor Cabang</h5>
                    <p class="text-muted mb-0">Lokasi magang di seluruh Indonesia</p>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" style="width: 75%; background: var(--gradient-primary);"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stats-card text-center">
                    <div class="mb-3">
                        <i class="fas fa-calendar-alt fa-3x" style="color: var(--telkom-red);"></i>
                    </div>
                    <div class="stats-number">28</div>
                    <h5 class="fw-bold mb-2">Tahun Pengalaman</h5>
                    <p class="text-muted mb-0">Pengalaman dalam industri telekomunikasi</p>
                    <div class="mt-3">
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" style="width: 95%; background: var(--gradient-primary);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Stats -->
        <div class="row mt-5">            <div class="col-lg-8 mx-auto">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded-3 shadow-sm">
                            <i class="fas fa-trophy fa-2x mb-3" style="color: var(--telkom-red);"></i>
                            <h4 class="fw-bold mb-1">95%</h4>
                            <small class="text-muted">Tingkat Kepuasan</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded-3 shadow-sm">
                            <i class="fas fa-briefcase fa-2x mb-3" style="color: var(--telkom-red);"></i>
                            <h4 class="fw-bold mb-1">70%</h4>
                            <small class="text-muted">Job Placement Rate</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-white rounded-3 shadow-sm">
                            <i class="fas fa-star fa-2x mb-3" style="color: var(--telkom-red);"></i>
                            <h4 class="fw-bold mb-1">4.8/5</h4>
                            <small class="text-muted">Rating Program</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold mb-4">Siap Bergabung dengan Program Magang Kami?</h2>
                    <p class="lead mb-5 fs-5">
                        Daftar sekarang dan dapatkan pengalaman berharga di PT Telkom Indonesia. 
                        Bergabunglah dengan ribuan mahasiswa yang telah merasakan manfaat program magang kami.
                    </p>
                    
                    <div class="d-flex flex-wrap justify-content-center gap-4 mb-5">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 rounded-pill fw-bold">
            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </a>
                    </div>
                    
                    <!-- Trust Indicators -->
                    <div class="row g-4 mt-5">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-shield-alt fa-3x mb-3 text-warning"></i>
                                <h5 class="fw-bold">100% Aman</h5>
                                <small class="text-white-50">Data Anda terlindungi dengan baik</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-clock fa-3x mb-3 text-warning"></i>
                                <h5 class="fw-bold">Proses Cepat</h5>
                                <small class="text-white-50">Verifikasi dalam 1-3 hari kerja</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-headset fa-3x mb-3 text-warning"></i>
                                <h5 class="fw-bold">Support 24/7</h5>
                                <small class="text-white-50">Tim support siap membantu Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript for animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.transition = 'width 2s ease-in-out';
                entry.target.style.width = entry.target.style.width;
            }
        });
    });
    
    progressBars.forEach(bar => {
        observer.observe(bar);
    });
    
    // Animate stats numbers
    const statsNumbers = document.querySelectorAll('.stats-number');
    const animateNumber = (element, target) => {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + (element.textContent.includes('+') ? '+' : '');
        }, 20);
    };
    
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const text = entry.target.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                if (number) {
                    animateNumber(entry.target, number);
                }
                statsObserver.unobserve(entry.target);
            }
        });
    });
    
    statsNumbers.forEach(number => {
        statsObserver.observe(number);
    });
});
</script>

