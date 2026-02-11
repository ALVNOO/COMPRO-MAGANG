@extends('layouts.app')

@section('title', 'Tentang Kami - PT Telkom Indonesia')

@section('content')

<!-- Hero Section -->
<section class="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-content">
        <div class="page-hero-badge">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            PT Telkom Indonesia
        </div>
        <h1 class="page-hero-title">Menghubungkan Indonesia <span class="text-gradient">Melalui Teknologi</span></h1>
        <p class="page-hero-description">
            Perusahaan telekomunikasi terbesar di Indonesia yang telah menghubungkan
            masyarakat selama lebih dari 50 tahun.
        </p>
    </div>
</section>

<!-- Company Profile Section -->
<section class="about-section">
    <div class="about-container">
        <div class="about-profile">
            <div class="about-profile-content">
                <span class="section-badge">Profil Perusahaan</span>
                <h2 class="section-title">Tentang PT Telkom Indonesia</h2>
                <p class="about-lead">
                    PT Telkom Indonesia adalah perusahaan telekomunikasi terbesar di Indonesia
                    yang telah menghubungkan masyarakat Indonesia selama lebih dari 50 tahun.
                </p>
                <p class="about-text">
                    Didirikan pada tahun 1965, PT Telkom Indonesia telah mengalami berbagai
                    transformasi untuk mengikuti perkembangan teknologi dan kebutuhan masyarakat.
                    Dari layanan telepon tradisional hingga layanan digital modern, kami terus
                    berkomitmen untuk menghubungkan seluruh Indonesia.
                </p>
                <p class="about-text">
                    Sebagai Badan Usaha Milik Negara (BUMN), PT Telkom Indonesia tidak hanya
                    fokus pada layanan telekomunikasi, tetapi juga telah berkembang menjadi
                    penyedia layanan digital, cloud computing, dan solusi teknologi yang terpercaya.
                </p>
                <div class="about-stats-inline">
                    <div class="stat-inline">
                        <span class="stat-inline-value">50+</span>
                        <span class="stat-inline-label">Tahun Berdiri</span>
                    </div>
                    <div class="stat-inline">
                        <span class="stat-inline-value">34</span>
                        <span class="stat-inline-label">Provinsi Terjangkau</span>
                    </div>
                    <div class="stat-inline">
                        <span class="stat-inline-value">150M+</span>
                        <span class="stat-inline-label">Pelanggan</span>
                    </div>
                </div>
            </div>
            <div class="about-profile-image">
                <div class="profile-image-wrapper">
                    <img src="{{ asset('image/telkom-logo.png') }}" alt="PT Telkom Indonesia" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="profile-image-fallback">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span>PT TELKOM</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Witel Sulbagsel Section -->
<section class="witel-section">
    <div class="witel-container">
        <div class="witel-header">
            <span class="section-badge">Unit Regional</span>
            <h2 class="section-title">Witel Sulawesi Bagian Selatan</h2>
            <p class="section-subtitle">
                Unit operasional PT. Telkom Indonesia di Kawasan Timur Indonesia
            </p>
        </div>
        <div class="witel-grid">
            <div class="witel-info-card">
                <div class="witel-info-header">
                    <div class="witel-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <h3>Wilayah Operasional</h3>
                </div>
                <p class="witel-description">
                    PT. Telkom Witel Sulbagsel bertanggung jawab dalam pengelolaan dan penyediaan
                    layanan digital serta layanan bisnis melalui produk-produk Telkom pada sektor
                    pendidikan, kesehatan, dan sektor lainnya.
                </p>
                <div class="witel-regions">
                    <h4>Wilayah Cakupan:</h4>
                    <div class="region-tags">
                        <span class="region-tag">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            Sulawesi Selatan
                        </span>
                        <span class="region-tag">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            Sulawesi Tenggara
                        </span>
                        <span class="region-tag">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            Sulawesi Barat
                        </span>
                    </div>
                </div>
            </div>
            <div class="witel-map-card">
                <div class="witel-map-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/>
                        <line x1="8" y1="2" x2="8" y2="18"/>
                        <line x1="16" y1="6" x2="16" y2="22"/>
                    </svg>
                    <span>Peta Wilayah Cakupan</span>
                </div>
                <div class="witel-map-image">
                    <img src="{{ asset('image/peta sulawesi.png') }}" alt="Peta Sulawesi - Wilayah Witel Sulbagsel" onerror="this.parentElement.innerHTML='<div class=\'map-placeholder\'><svg width=\'64\' height=\'64\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\'><polygon points=\'1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6\'/><line x1=\'8\' y1=\'2\' x2=\'8\' y2=\'18\'/><line x1=\'16\' y1=\'6\' x2=\'16\' y2=\'22\'/></svg><span>Peta Sulawesi</span></div>'">
                </div>
                <p class="witel-map-caption">
                    Wilayah operasional PT. Telkom Witel Sulbagsel
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="vision-section">
    <div class="vision-container">
        <div class="vision-header">
            <span class="section-badge">Tujuan Kami</span>
            <h2 class="section-title">Visi & Misi</h2>
        </div>
        <div class="vision-grid">
            <div class="vision-card">
                <div class="vision-card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <h3>Visi</h3>
                <p>Menjadi digital telco pilihan utama untuk memajukan Indonesia</p>
                <div class="vision-decoration"></div>
            </div>
            <div class="vision-card">
                <div class="vision-card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="12" cy="12" r="6"/>
                        <circle cx="12" cy="12" r="2"/>
                    </svg>
                </div>
                <h3>Misi</h3>
                <p>Membangun infrastruktur digital yang kuat, menyediakan layanan digital yang inovatif, dan memberdayakan masyarakat Indonesia</p>
                <div class="vision-decoration"></div>
            </div>
        </div>
    </div>
</section>

<!-- Business Lines Section -->
<section class="business-section">
    <div class="business-container">
        <div class="business-header">
            <span class="section-badge">Layanan Kami</span>
            <h2 class="section-title">Lini Bisnis</h2>
            <p class="section-subtitle">
                Menyediakan solusi telekomunikasi dan digital terlengkap untuk Indonesia
            </p>
        </div>
        <div class="business-grid">
            <div class="business-card hover-lift">
                <div class="business-card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M5 12.55a11 11 0 0 1 14.08 0"/>
                        <path d="M1.42 9a16 16 0 0 1 21.16 0"/>
                        <path d="M8.53 16.11a6 6 0 0 1 6.95 0"/>
                        <line x1="12" y1="20" x2="12.01" y2="20"/>
                    </svg>
                </div>
                <h3>Telekomunikasi</h3>
                <p>Layanan telepon, internet, dan komunikasi data untuk rumah tangga dan bisnis dengan jaringan yang luas dan terpercaya.</p>
            </div>
            <div class="business-card hover-lift">
                <div class="business-card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                        <line x1="12" y1="18" x2="12.01" y2="18"/>
                    </svg>
                </div>
                <h3>Digital Services</h3>
                <p>Layanan digital modern seperti cloud computing, data center, dan solusi teknologi untuk transformasi digital.</p>
            </div>
            <div class="business-card hover-lift">
                <div class="business-card-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <line x1="12" y1="20" x2="12" y2="10"/>
                        <line x1="18" y1="20" x2="18" y2="4"/>
                        <line x1="6" y1="20" x2="6" y2="16"/>
                    </svg>
                </div>
                <h3>Digital Business</h3>
                <p>Solusi bisnis digital, e-commerce, dan platform digital untuk mendukung pertumbuhan ekonomi digital Indonesia.</p>
            </div>
        </div>
    </div>
</section>

<!-- AKHLAK Values Section -->
<section class="values-section">
    <div class="values-container">
        <div class="values-header">
            <span class="section-badge">Budaya Perusahaan</span>
            <h2 class="section-title">AKHLAK</h2>
            <p class="section-subtitle">
                Core values BUMN Indonesia yang menjadi landasan budaya kerja kami
            </p>
        </div>
        <div class="values-grid">
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="value-letter">A</div>
                <h4>Amanah</h4>
                <p>Memegang teguh kepercayaan yang diberikan</p>
            </div>
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                </div>
                <div class="value-letter">K</div>
                <h4>Kompeten</h4>
                <p>Terus belajar dan mengembangkan kapabilitas</p>
            </div>
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                        <line x1="9" y1="9" x2="9.01" y2="9"/>
                        <line x1="15" y1="9" x2="15.01" y2="9"/>
                    </svg>
                </div>
                <div class="value-letter">H</div>
                <h4>Harmonis</h4>
                <p>Saling peduli dan menghargai perbedaan</p>
            </div>
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                        <line x1="4" y1="22" x2="4" y2="15"/>
                    </svg>
                </div>
                <div class="value-letter">L</div>
                <h4>Loyal</h4>
                <p>Berdedikasi & mengutamakan kepentingan bangsa & negara</p>
            </div>
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <polyline points="1 20 1 14 7 14"/>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                    </svg>
                </div>
                <div class="value-letter">A</div>
                <h4>Adaptif</h4>
                <p>Terus berinovasi dan antusias menghadapi perubahan</p>
            </div>
            <div class="value-card hover-lift">
                <div class="value-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="value-letter">K</div>
                <h4>Kolaboratif</h4>
                <p>Membangun kerja sama yang strategis</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="contact-container">
        <div class="contact-header">
            <span class="section-badge">Hubungi Kami</span>
            <h2 class="section-title">Informasi Kontak</h2>
            <p class="section-subtitle">
                Kami siap membantu Anda dengan berbagai pertanyaan
            </p>
        </div>
        <div class="contact-grid">
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h4>Alamat</h4>
                <p>Gedung Telkom Landmark Tower<br>Jl. Gatot Subroto No. 52<br>Jakarta Selatan 12950</p>
            </div>
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                </div>
                <h4>Telepon</h4>
                <p>+62 21 524 9000<br>+62 21 524 9001</p>
            </div>
            <div class="contact-card">
                <div class="contact-card-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <h4>Email</h4>
                <p>info@telkom.co.id<br>cs@telkom.co.id</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="about-cta">
    <div class="about-cta-container">
        <div class="about-cta-content">
            <h2>Tertarik Bergabung dengan Kami?</h2>
            <p>Mulai perjalanan karir Anda bersama PT Telkom Indonesia melalui program magang kami</p>
            <div class="about-cta-actions">
                <a href="{{ route('register') }}" class="btn-cta-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Daftar Magang
                </a>
                <a href="{{ route('program') }}" class="btn-cta-secondary">
                    Lihat Program
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
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

    document.querySelectorAll('.value-card, .business-card, .contact-card, .vision-card').forEach((el, i) => {
        el.style.transitionDelay = `${i * 80}ms`;
        el.classList.add('scroll-fade-in');
        observer.observe(el);
    });
});
</script>
@endpush
