@extends('layouts.app')

@section('title', 'Program Magang - PT Telkom Indonesia')

@section('content')
@php
    use App\Models\FieldOfInterest;
    $fields = FieldOfInterest::active()->ordered()->get();
@endphp
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

/* Hero Section */
.program-hero {
    background: var(--gradient-primary);
    color: white;
    padding: 100px 0 80px;
    position: relative;
    overflow: hidden;
}

.program-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(0,0,0,0.1) 0%, rgba(238,46,36,0.1) 100%);
    z-index: 1;
}

.program-hero-content {
    position: relative;
    z-index: 2;
}

/* Floating Elements */
.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.floating-shape:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-shape:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.floating-shape:nth-child(3) {
    width: 60px;
    height: 60px;
    top: 40%;
    left: 80%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Section Styling */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--telkom-black);
    margin-bottom: 1rem;
    text-align: center;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--telkom-gray);
    text-align: center;
    margin-bottom: 3rem;
}

/* Field Cards */
.field-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.field-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

.field-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.field-card:hover::before {
    transform: scaleX(1);
}

.field-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: var(--telkom-red);
}

.field-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 25px rgba(238, 46, 36, 0.3);
}

.field-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--telkom-black);
    margin-bottom: 1rem;
}

.field-description {
    color: var(--telkom-gray);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.field-stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(238, 46, 36, 0.05);
    border-radius: 10px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--telkom-red);
}

.stat-label {
    font-size: 0.9rem;
    color: var(--telkom-gray);
}

.field-btn {
    width: 100%;
    padding: 0.75rem 1.5rem;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.field-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(238, 46, 36, 0.3);
    color: white;
    text-decoration: none;
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
}

.modal-header {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 2rem;
}

.modal-title {
    font-size: 1.8rem;
    font-weight: 700;
}

.modal-body {
    padding: 2rem;
}

.division-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.division-item {
    background: rgba(238, 46, 36, 0.05);
    padding: 1rem;
    border-radius: 10px;
    border-left: 4px solid var(--telkom-red);
    transition: all 0.3s ease;
}

.division-item:hover {
    background: rgba(238, 46, 36, 0.1);
    transform: translateX(5px);
}

.division-name {
    font-weight: 600;
    color: var(--telkom-black);
    margin-bottom: 0.5rem;
}

.division-description {
    font-size: 0.9rem;
    color: var(--telkom-gray);
    line-height: 1.4;
}

/* Other Fields Card */
.other-fields-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    border: 2px solid var(--telkom-red);
    position: relative;
    overflow: hidden;
}

.other-fields-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--gradient-primary);
}

.other-fields-icon {
    width: 100px;
    height: 100px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
    margin: 0 auto 2rem;
    box-shadow: 0 10px 30px rgba(238, 46, 36, 0.3);
    animation: pulse 2s ease-in-out infinite;
}

.other-fields-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--telkom-black);
    margin-bottom: 1.5rem;
}

.other-fields-description {
    font-size: 1.1rem;
    color: var(--telkom-gray);
    line-height: 1.6;
    margin-bottom: 2rem;
}

.other-fields-benefits {
    margin-bottom: 2rem;
}

.benefit-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 1rem;
    color: var(--telkom-black);
}

.benefit-item i {
    color: var(--telkom-red);
    margin-right: 1rem;
    font-size: 1.2rem;
}

.other-fields-btn {
    display: inline-block;
    padding: 1rem 2rem;
    background: var(--gradient-primary);
    color: white;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(238, 46, 36, 0.3);
}

.other-fields-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(238, 46, 36, 0.4);
    color: white;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .program-hero {
        padding: 80px 0 60px;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .field-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .field-card {
        padding: 1.5rem;
    }
    
    .field-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .division-grid {
        grid-template-columns: 1fr;
    }
    
    .other-fields-card {
        padding: 2rem;
    }
    
    .other-fields-icon {
        width: 80px;
        height: 80px;
        font-size: 2.5rem;
    }
    
    .other-fields-title {
        font-size: 1.5rem;
    }
    
    .other-fields-description {
        font-size: 1rem;
    }
}
</style>

<!-- Hero Section -->
<section class="program-hero">
    <div class="floating-shapes">
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
        <div class="floating-shape"></div>
    </div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 program-hero-content">
                <h1 class="display-4 fw-bold mb-4">Program Magang PT Telkom Indonesia</h1>
                <p class="lead fs-5 mb-0">
                    Pilih bidang peminatan yang sesuai dengan passion dan karir impian Anda. 
                    Setiap bidang menawarkan pengalaman magang yang mendalam dan relevan dengan industri.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Program Fields Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Bidang Peminatan</h2>
            <p class="section-subtitle">
                Temukan bidang yang tepat untuk mengembangkan potensi dan karir Anda
            </p>
        </div>
        
        <div class="field-grid">
            @foreach($fields as $field)
            <div class="field-card">
                <div class="field-icon" style="background: {{ $field->color }};">
                    <i class="{{ $field->icon }}"></i>
                </div>
                <h3 class="field-title">{{ $field->name }}</h3>
                <p class="field-description">{{ $field->description }}</p>
                <div class="field-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $field->division_count }}</div>
                        <div class="stat-label">Divisi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $field->position_count }}+</div>
                        <div class="stat-label">Posisi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $field->duration_months }}</div>
                        <div class="stat-label">Bulan</div>
                    </div>
                </div>
                <button class="field-btn" data-bs-toggle="modal" data-bs-target="#fieldModal{{ $field->id }}">
                    <i class="fas fa-arrow-right me-2"></i>Daftar Bidang Ini
                </button>
            </div>
            @endforeach
        </div>

        <!-- Other Fields Option -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="other-fields-card">
                    <div class="text-center">
                        <div class="other-fields-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="other-fields-title">Bidang Lainnya</h3>
                        <p class="other-fields-description">
                            Apakah bidang minat Anda tidak ada dalam daftar di atas? 
                            Jangan khawatir! Kami tetap membuka kesempatan untuk Anda bergabung 
                            dengan program magang PT Telkom Indonesia.
                        </p>
                        <div class="other-fields-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Kesempatan untuk mengeksplorasi berbagai divisi</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Mentoring dari profesional berpengalaman</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Pengalaman kerja di perusahaan telekomunikasi terbesar</span>
                            </div>
                        </div>
                        <a href="{{ route('register') }}" class="other-fields-btn">
                            <i class="fas fa-user-plus me-2"></i>Daftar dengan Bidang Lainnya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals for Field Details -->
@foreach($fields as $field)
<div class="modal fade" id="fieldModal{{ $field->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: {{ $field->color }};">
                <h5 class="modal-title text-white">
                    <i class="{{ $field->icon }} me-2"></i>{{ $field->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="lead mb-4">{{ $field->description }}</p>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h3 text-primary">{{ $field->division_count }}</div>
                            <div class="text-muted">Divisi Tersedia</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h3 text-success">{{ $field->position_count }}+</div>
                            <div class="text-muted">Posisi Magang</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h3 text-warning">{{ $field->duration_months }}</div>
                            <div class="text-muted">Bulan Durasi</div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<script>
// Add smooth scrolling and animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all field cards
    document.querySelectorAll('.field-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });

    // Add hover effects to division items
    document.querySelectorAll('.division-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>

@endsection