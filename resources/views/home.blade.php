@extends('layouts.app')

@section('title', 'Beranda - Sistem Penerimaan Magang PT Telkom Indonesia')

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="hero-bg">
        <!-- Animated Grid Background -->
        <div class="hero-grid"></div>
        <!-- Gradient Orbs -->
        <div class="hero-orb hero-orb-1"></div>
        <div class="hero-orb hero-orb-2"></div>
        <div class="hero-orb hero-orb-3"></div>
    </div>

    <div class="hero-content">
        <div class="hero-text">
            <!-- Animated Badge -->
            <div class="hero-badge-animated">
                <span class="badge-dot"></span>
                <span>Pendaftaran Dibuka</span>
            </div>

            <h1 class="hero-title">
                <span class="title-line">Bangun Karirmu</span>
                <span class="title-line title-gradient">Bersama Telkom</span>
            </h1>

            <p class="hero-description">
                Program magang untuk mahasiswa dan pelajar yang ingin mendapatkan
                pengalaman kerja nyata di industri telekomunikasi dan digital.
            </p>

            <div class="hero-actions">
                <a href="{{ route('program') }}" class="btn-hero-primary">
                    <span>Lihat Program Magang</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn-hero-outline">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        <span>Daftar Sekarang</span>
                    </a>
                @else
                    <a href="{{ Auth::user()->role === 'pembimbing' ? route('mentor.dashboard') : (Auth::user()->role === 'admin' ? '/admin/dashboard' : route('dashboard')) }}" class="btn-hero-outline">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        <span>Ke Dashboard</span>
                    </a>
                @endguest
            </div>

            <!-- Process Steps -->
            <div class="hero-process">
                <div class="process-item">
                    <div class="process-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                    </div>
                    <span>Daftar</span>
                </div>
                <div class="process-line"></div>
                <div class="process-item">
                    <div class="process-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <span>Lengkapi Data</span>
                </div>
                <div class="process-line"></div>
                <div class="process-item">
                    <div class="process-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <span>Mulai Magang</span>
                </div>
            </div>
        </div>

        <!-- Hero Visual -->
        <div class="hero-visual-new">
            <div class="visual-container">
                <!-- Main Card -->
                <div class="visual-card visual-card-main">
                    <div class="card-header">
                        <div class="card-logo">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <span>Program Magang</span>
                    </div>
                    <div class="card-content">
                        <h3>PT Telkom Indonesia</h3>
                        <p>Witel Sulawesi Bagian Selatan</p>
                    </div>
                    <div class="card-tags">
                        <span class="tag">IT & Digital</span>
                        <span class="tag">Marketing</span>
                        <span class="tag">+Lainnya</span>
                    </div>
                </div>

                <!-- Floating Elements -->
                <div class="floating-element floating-1">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div class="floating-element floating-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                    </svg>
                </div>
                <div class="floating-element floating-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>

                <!-- Notification Card -->
                <div class="notification-card">
                    <div class="notif-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="notif-text">
                        <span class="notif-title">Pendaftaran Mudah</span>
                        <span class="notif-desc">Hanya butuh email untuk mulai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="hero-scroll-indicator">
        <div class="scroll-mouse">
            <div class="scroll-wheel"></div>
        </div>
        <span>Scroll</span>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="features-container">
        <div class="features-header">
            <h2 class="features-title">Mengapa Magang di Telkom?</h2>
            <p class="features-subtitle">
                Kami menawarkan pengalaman magang yang komprehensif untuk mempersiapkan karir Anda
            </p>
        </div>
        <div class="features-grid">
            <div class="feature-card hover-lift">
                <div class="feature-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <h3 class="feature-title">Pembelajaran Langsung</h3>
                <p class="feature-description">
                    Belajar langsung dari para profesional berpengalaman di industri telekomunikasi
                </p>
            </div>
            <div class="feature-card hover-lift">
                <div class="feature-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3 class="feature-title">Mentor Berpengalaman</h3>
                <p class="feature-description">
                    Dibimbing oleh mentor profesional yang siap membantu perkembangan Anda
                </p>
            </div>
            <div class="feature-card hover-lift">
                <div class="feature-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <h3 class="feature-title">Proyek Nyata</h3>
                <p class="feature-description">
                    Terlibat dalam proyek-proyek nyata yang berdampak pada bisnis perusahaan
                </p>
            </div>
            <div class="feature-card hover-lift">
                <div class="feature-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                    </svg>
                </div>
                <h3 class="feature-title">Sertifikat Resmi</h3>
                <p class="feature-description">
                    Dapatkan sertifikat resmi yang diakui untuk meningkatkan portofolio Anda
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Steps Section -->
<section class="steps">
    <div class="steps-container">
        <div class="steps-header">
            <h2 class="steps-title">Cara Mendaftar</h2>
            <p class="steps-subtitle">
                Ikuti 3 langkah mudah untuk memulai perjalanan magang Anda
            </p>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                </div>
                <h3 class="step-title">Buat Akun</h3>
                <p class="step-description">
                    Daftarkan email Anda untuk membuat akun baru
                </p>
            </div>
            <div class="step-connector"></div>
            <div class="step-card">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <h3 class="step-title">Lengkapi Data</h3>
                <p class="step-description">
                    Isi data diri, pilih bidang minat, dan unggah dokumen
                </p>
            </div>
            <div class="step-connector"></div>
            <div class="step-card">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <h3 class="step-title">Mulai Magang</h3>
                <p class="step-description">
                    Setelah disetujui, mulailah perjalanan magang Anda
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="cta-container">
        <div class="cta-content">
            <h2 class="cta-title">Siap Memulai?</h2>
            <p class="cta-description">
                Daftar sekarang dan jadilah bagian dari program magang
                PT Telkom Indonesia Witel Sulawesi Bagian Selatan.
            </p>
            <div class="cta-actions">
                @guest
                    <a href="{{ route('register') }}" class="btn-cta-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="btn-cta-secondary">
                        Sudah Punya Akun? Masuk
                    </a>
                @else
                    <a href="{{ Auth::user()->role === 'pembimbing' ? route('mentor.dashboard') : (Auth::user()->role === 'admin' ? '/admin/dashboard' : route('dashboard')) }}" class="btn-cta-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        Ke Dashboard
                    </a>
                    <a href="{{ route('program') }}" class="btn-cta-secondary">
                        Lihat Program Magang
                    </a>
                @endguest
            </div>
        </div>
        <div class="cta-features">
            <div class="cta-feature">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <div>
                    <strong>Data Aman</strong>
                    <span>Informasi Anda terlindungi</span>
                </div>
            </div>
            <div class="cta-feature">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <div>
                    <strong>Proses Cepat</strong>
                    <span>Pendaftaran online mudah</span>
                </div>
            </div>
            <div class="cta-feature">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <div>
                    <strong>Support Responsif</strong>
                    <span>Tim siap membantu Anda</span>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll animations using Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.feature-card, .step-card').forEach(el => {
        el.classList.add('scroll-fade-in');
        observer.observe(el);
    });

    // Stagger animation for feature cards
    document.querySelectorAll('.feature-card').forEach((card, index) => {
        card.style.transitionDelay = `${index * 100}ms`;
    });

    // Stagger animation for step cards
    document.querySelectorAll('.step-card').forEach((card, index) => {
        card.style.transitionDelay = `${index * 150}ms`;
    });

    // Smooth scroll indicator click
    const scrollIndicator = document.querySelector('.hero-scroll-indicator');
    if (scrollIndicator) {
        scrollIndicator.addEventListener('click', () => {
            const featuresSection = document.querySelector('.features');
            if (featuresSection) {
                featuresSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }

    // Hide scroll indicator on scroll
    window.addEventListener('scroll', () => {
        if (scrollIndicator) {
            scrollIndicator.style.opacity = window.scrollY > 100 ? '0' : '1';
            scrollIndicator.style.pointerEvents = window.scrollY > 100 ? 'none' : 'auto';
        }
    });

    // Parallax for orbs
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        document.querySelectorAll('.hero-orb').forEach((orb, i) => {
            const speed = 0.05 + (i * 0.02);
            orb.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
});
</script>
@endpush
