@extends('layouts.app')

@section('title', 'Program Magang - PT Telkom Indonesia')

@section('content')
@php
    use App\Models\FieldOfInterest;
    $fields = FieldOfInterest::active()->ordered()->get();
@endphp

<!-- Hero Section -->
<section class="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-content">
        <div class="page-hero-badge">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
            Bidang Peminatan Magang
        </div>
        <h1 class="page-hero-title">Pilih Bidang Sesuai <span class="text-gradient">Passion Anda</span></h1>
        <p class="page-hero-description">
            Temukan program magang yang sesuai dengan minat dan tujuan karir Anda.
            Setiap bidang menawarkan pengalaman langsung dengan profesional industri.
        </p>
    </div>
</section>

<!-- Program Cards Section -->
<section class="program-section">
    <div class="program-container">
        <!-- Stats Bar -->
        <div class="program-stats">
            <div class="program-stat">
                <span class="stat-value">{{ $fields->count() }}+</span>
                <span class="stat-label">Bidang Tersedia</span>
            </div>
            <div class="stat-divider"></div>
            <div class="program-stat">
                <span class="stat-value">50+</span>
                <span class="stat-label">Divisi Aktif</span>
            </div>
            <div class="stat-divider"></div>
            <div class="program-stat">
                <span class="stat-value">500+</span>
                <span class="stat-label">Peserta/Tahun</span>
            </div>
        </div>

        <!-- Program Grid -->
        <div class="program-grid">
            @foreach($fields as $field)
            <div class="program-card hover-lift">
                <div class="program-card-header">
                    <div class="program-icon" style="background: {{ $field->color ?? 'var(--gradient-primary)' }};">
                        <i class="{{ $field->icon ?? 'fas fa-briefcase' }}"></i>
                    </div>
                    <div class="program-meta">
                        <span class="program-duration">{{ $field->duration_months ?? 3 }} bulan</span>
                    </div>
                </div>
                <h3 class="program-title">{{ $field->name }}</h3>
                <p class="program-description">{{ Str::limit($field->description, 100) }}</p>
                <div class="program-info">
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                        <span>{{ $field->division_count ?? 5 }} Divisi</span>
                    </div>
                    <div class="info-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        <span>{{ $field->position_count ?? 10 }}+ Posisi</span>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="program-btn">
                    Daftar Sekarang
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Other Fields CTA -->
        <div class="other-fields">
            <div class="other-fields-content">
                <div class="other-fields-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 8v8M8 12h8"/>
                    </svg>
                </div>
                <div class="other-fields-text">
                    <h3>Bidang Lainnya?</h3>
                    <p>Tidak menemukan bidang yang sesuai? Kami tetap membuka kesempatan untuk bidang minat lainnya.</p>
                </div>
                <a href="{{ route('register') }}" class="other-fields-btn">
                    Daftar dengan Bidang Lain
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="benefits-container">
        <div class="benefits-header">
            <h2 class="benefits-title">Keuntungan Program Magang</h2>
            <p class="benefits-subtitle">Dapatkan pengalaman berharga selama program magang berlangsung</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <h4>Pelatihan Intensif</h4>
                <p>Program training khusus dari mentor profesional</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="7"/>
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                    </svg>
                </div>
                <h4>Sertifikat Resmi</h4>
                <p>Sertifikat resmi yang diakui industri</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h4>Networking</h4>
                <p>Bangun koneksi dengan profesional industri</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <h4>Proyek Nyata</h4>
                <p>Terlibat dalam proyek yang berdampak</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.program-card, .benefit-card').forEach((el, i) => {
        el.style.transitionDelay = `${i * 100}ms`;
        el.classList.add('scroll-fade-in');
        observer.observe(el);
    });
});
</script>
@endpush
