@extends('layouts.app')

@section('title', 'Tentang Kami - PT Telkom Indonesia')

@section('content')
<style>
:root {
    --telkom-red: #EE2E24;
    --telkom-red-bright: #EE2B24;
    --telkom-red-pure: #F60000;
    --telkom-black: #000000;
    --telkom-gray: #AAA5A6;
    --gradient-primary: linear-gradient(135deg, var(--telkom-red) 0%, var(--telkom-red-bright) 100%);
    --gradient-secondary: linear-gradient(135deg, var(--telkom-black) 0%, var(--telkom-gray) 100%);
}

.hero-section {
    background: var(--gradient-primary), url('/image/Kantor_Pusat_Pos_Indonesia.jpeg') center center/cover no-repeat;
    color: white;
    padding: 100px 0;
    min-height: 400px;
    position: relative;
    overflow: hidden;
}

.section-title {
    color: var(--telkom-red);
    font-weight: 700;
    margin-bottom: 2rem;
}

.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(238, 46, 36, 0.2);
}

.value-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(238, 46, 36, 0.15);
}

.value-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}


.witel-info {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 2rem;
    margin: 2rem 0;
    border-left: 5px solid var(--telkom-red);
}

.region-highlight {
    background: var(--gradient-primary);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    display: inline-block;
    margin: 0.25rem;
    font-weight: 600;
    font-size: 0.9rem;
}
</style>

<!-- Hero Section -->
<section class="hero-section position-relative">
    <div class="container position-relative" style="z-index:2;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center text-white py-5">
                <h1 class="display-4 fw-bold mb-4">Tentang PT Telkom Indonesia</h1>
                <p class="lead">Menghubungkan Indonesia melalui teknologi telekomunikasi dan digital</p>
            </div>
        </div>
    </div>
</section>

<!-- Company Overview -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="section-title">Profil Perusahaan</h2>
                <p class="lead">PT Telkom Indonesia adalah perusahaan telekomunikasi terbesar di Indonesia yang telah menghubungkan masyarakat Indonesia selama lebih dari 50 tahun.</p>
                <p>Didirikan pada tahun 1965, PT Telkom Indonesia telah mengalami berbagai transformasi untuk mengikuti perkembangan teknologi dan kebutuhan masyarakat. Dari layanan telepon tradisional hingga layanan digital modern, kami terus berkomitmen untuk menghubungkan seluruh Indonesia.</p>
                <p>Sebagai Badan Usaha Milik Negara (BUMN), PT Telkom Indonesia tidak hanya fokus pada layanan telekomunikasi, tetapi juga telah berkembang menjadi penyedia layanan digital, cloud computing, dan solusi teknologi yang terpercaya.</p>
            </div>
            <div class="col-lg-6 text-center">
                <div class="d-flex justify-content-center align-items-center" style="height: 300px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <img src="{{ asset('image/telkom-logo.png') }}" alt="PT Telkom Indonesia" class="img-fluid" style="max-height: 200px; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div style="display: none; flex-direction: column; align-items: center; justify-content: center; color: var(--telkom-red); font-weight: bold; text-align: center;">
                        <div style="font-size: 48px; margin-bottom: 10px;">📡</div>
                        <div style="font-size: 24px;">PT TELKOM</div>
                        <div style="font-size: 16px; margin-top: 5px;">INDONESIA</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Witel Sulbagsel Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="witel-info">
                    <h3 class="fw-bold mb-3" style="color: var(--telkom-red);">
                        <i class="fas fa-map-marker-alt me-2"></i>PT. Telkom Wilayah Telekomunikasi (Witel) Sulawesi Bagian Selatan
                    </h3>
                    <p class="lead mb-3">
                        PT. Telkom Wilayah Telekomunikasi (Witel) Sulawesi Bagian Selatan (Sulbagsel) merupakan salah satu unit operasional PT. Telkom Indonesia yang berada di Kawasan Timur Indonesia.
                    </p>
                    <p class="mb-3">
                        Witel Sulbagsel bertanggung jawab dalam pengelolaan dan penyediaan layanan digital serta layanan bisnis melalui produk-produk Telkom pada sektor pendidikan, kesehatan, dan sektor lainnya di wilayah Sulawesi Selatan, Sulawesi Tenggara, dan Sulawesi Barat.
                    </p>
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Wilayah Cakupan:</h5>
                        <div class="d-flex flex-wrap">
                            <span class="region-highlight">Sulawesi Selatan</span>
                            <span class="region-highlight">Sulawesi Tenggara</span>
                            <span class="region-highlight">Sulawesi Barat</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <h4 class="fw-bold mb-3" style="color: var(--telkom-red);">
                        <i class="fas fa-map me-2"></i>Peta Wilayah Cakupan Witel Sulbagsel
                    </h4>
                    <img src="{{ asset('image/peta sulawesi.png') }}" alt="Peta Sulawesi - Wilayah Witel Sulbagsel" class="img-fluid rounded shadow" style="max-height: 400px; width: 100%; object-fit: contain;">
                    <p class="text-muted mt-3 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Wilayah operasional PT. Telkom Witel Sulbagsel meliputi Sulawesi Selatan, Sulawesi Tenggara, dan Sulawesi Barat
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Mission -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Visi</h4>
                    <p class="mb-0">Menjadi digital telco pilihan utama untuk memajukan Indonesia</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Misi</h4>
                    <p class="mb-0">Membangun infrastruktur digital yang kuat, menyediakan layanan digital yang inovatif, dan memberdayakan masyarakat Indonesia</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Business Lines -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <h2 class="text-center section-title mb-5">Lini Bisnis</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-wifi fa-3x mb-3" style="color: var(--telkom-red);"></i>
                        <h5 class="card-title">Telekomunikasi</h5>
                        <p class="card-text">Layanan telepon, internet, dan komunikasi data untuk rumah tangga dan bisnis dengan jaringan yang luas dan terpercaya.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-mobile-alt fa-3x mb-3" style="color: var(--telkom-red);"></i>
                        <h5 class="card-title">Digital Services</h5>
                        <p class="card-text">Layanan digital modern seperti cloud computing, data center, dan solusi teknologi untuk transformasi digital.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line fa-3x mb-3" style="color: var(--telkom-red);"></i>
                        <h5 class="card-title">Digital Business</h5>
                        <p class="card-text">Solusi bisnis digital, e-commerce, dan platform digital untuk mendukung pertumbuhan ekonomi digital Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Values -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center section-title mb-3">AKHLAK</h2>
        <p class="text-center mb-5">AKHLAK merupakan budaya perusahaan milik negara Indonesia yang diusulkan oleh Kementerian Badan Usaha Milik Negara. Arti pokok di balik AKHLAK adalah sebagai berikut:</p>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-bold">Amanah</h5>
                    <p class="text-muted mb-0">Memegang teguh kepercayaan yang diberikan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 class="fw-bold">Kompeten</h5>
                    <p class="text-muted mb-0">Terus belajar dan mengembangkan kapabilitas</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h5 class="fw-bold">Harmonis</h5>
                    <p class="text-muted mb-0">Saling peduli dan menghargai perbedaan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h5 class="fw-bold">Loyal</h5>
                    <p class="text-muted mb-0">Berdedikasi & mengutamakan kepentingan bangsa & negara</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h5 class="fw-bold">Adaptif</h5>
                    <p class="text-muted mb-0">Terus berinovasi dan antusias dalam menggerakkan ataupun menghadapi perubahan</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="fw-bold">Kolaboratif</h5>
                    <p class="text-muted mb-0">Membangun kerja sama yang strategis</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Information -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="section-title mb-4">Informasi Kontak</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-map-marker-alt fa-2x mb-3" style="color: var(--telkom-red);"></i>
                        <h5>Alamat</h5>
                        <p>Gedung Telkom Landmark Tower<br>Jl. Gatot Subroto No. 52<br>Jakarta Selatan 12950</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-phone fa-2x mb-3" style="color: var(--telkom-red);"></i>
                        <h5>Telepon</h5>
                        <p>+62 21 524 9000<br>+62 21 524 9001</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <i class="fas fa-envelope fa-2x mb-3" style="color: var(--telkom-red);"></i>
                        <h5>Email</h5>
                        <p>info@telkom.co.id<br>cs@telkom.co.id</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection