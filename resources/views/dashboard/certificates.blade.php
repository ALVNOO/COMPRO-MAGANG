{{--
    USER CERTIFICATES PAGE
    Certificate management for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Sertifikat Magang')

@php
    $role = 'participant';
    $pageTitle = 'Sertifikat';

    $totalCertificates = $certificates->count();
@endphp

@push('styles')
<style>
/* ============================================
   CERTIFICATES PAGE STYLES
   ============================================ */

/* Hero Section */
.page-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.page-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.hero-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hero-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 500px;
    margin: 0;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-badge-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.hero-badge-text h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.hero-badge-text p {
    font-size: 0.8rem;
    opacity: 0.9;
    margin: 0;
}

/* Certificate Cards Grid */
.cert-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.cert-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
}

.cert-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.cert-card-header {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    padding: 1.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cert-card-header::before {
    content: '';
    position: absolute;
    top: -30%;
    right: -20%;
    width: 50%;
    height: 160%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.cert-icon-wrapper {
    position: relative;
    z-index: 1;
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.75rem;
    color: white;
}

.cert-card-header h4 {
    position: relative;
    z-index: 1;
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
}

.cert-card-body {
    padding: 1.5rem;
}

.cert-preview {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    margin-bottom: 1.25rem;
    overflow: hidden;
    background: #f9fafb;
}

.cert-preview embed {
    width: 100%;
    height: 100%;
}

.cert-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 1.25rem;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    border-radius: 10px;
}

.cert-meta i {
    color: #EE2E24;
}

.btn-download-cert {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
}

.btn-download-cert:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.35);
    color: white;
}

/* Info Card */
.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.info-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card-body {
    padding: 1.5rem;
}

.info-columns {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.info-section h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-section h5 i {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.info-section h5 i.green-icon {
    background: rgba(16, 185, 129, 0.12);
    color: #059669;
}

.info-section h5 i.amber-icon {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
}

.info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.65rem 0;
    font-size: 0.875rem;
    color: #4b5563;
    line-height: 1.5;
}

.info-list li + li {
    border-top: 1px solid rgba(0, 0, 0, 0.04);
}

.info-list li i {
    flex-shrink: 0;
    margin-top: 0.15rem;
    font-size: 0.75rem;
}

.info-list li i.fa-check-circle {
    color: #10B981;
}

.info-list li i.fa-star {
    color: #F59E0B;
}

/* Empty State */
.empty-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.empty-state {
    text-align: center;
    padding: 3.5rem 2rem;
}

.empty-state-icon {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.08), rgba(238, 46, 36, 0.03));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: #EE2E24;
}

.empty-state h4 {
    font-size: 1.15rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 1.75rem;
    max-width: 420px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.empty-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-empty-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
}

.btn-empty-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.35);
    color: white;
}

.btn-empty-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: white;
    color: #374151;
    border: 1px solid #d1d5db;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-empty-secondary:hover {
    background: #f3f4f6;
    transform: translateY(-1px);
    color: #1f2937;
}

/* Responsive */
@media (max-width: 768px) {
    .page-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-text h1 {
        font-size: 1.35rem;
        justify-content: center;
    }

    .cert-grid {
        grid-template-columns: 1fr;
    }

    .info-columns {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .empty-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-empty-primary,
    .btn-empty-secondary {
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="page-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-award"></i>
                Sertifikat Magang
            </h1>
            <p>Download sertifikat resmi dari program magang PT Telkom Indonesia</p>
        </div>
        @if($totalCertificates > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $totalCertificates }}</h4>
                <p>Sertifikat</p>
            </div>
        </div>
        @endif
    </div>
</div>

@if($totalCertificates > 0)
{{-- Certificate Cards --}}
<div class="cert-grid">
    @foreach($certificates as $certificate)
    <div class="cert-card">
        <div class="cert-card-header">
            <div class="cert-icon-wrapper">
                <i class="fas fa-award"></i>
            </div>
            <h4>Sertifikat Magang</h4>
        </div>
        <div class="cert-card-body">
            @if($certificate->certificate_path)
            <div class="cert-preview">
                <embed src="{{ asset('storage/' . $certificate->certificate_path) }}" type="application/pdf">
            </div>
            @endif

            <div class="cert-meta">
                <i class="fas fa-calendar-check"></i>
                <span>Diterbitkan: <strong>{{ $certificate->created_at->locale('id')->isoFormat('D MMMM Y') }}</strong></span>
            </div>

            <a href="{{ route('dashboard.certificates.download', $certificate->id) }}" class="btn-download-cert">
                <i class="fas fa-download"></i> Download Sertifikat
            </a>
        </div>
    </div>
    @endforeach
</div>
@else
{{-- Empty State --}}
<div class="empty-card" style="margin-bottom: 2rem;">
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-award"></i>
        </div>
        <h4>Belum Ada Sertifikat</h4>
        <p>Sertifikat magang akan tersedia setelah Anda menyelesaikan program magang dan semua tugas yang diberikan oleh pembimbing.</p>
        <div class="empty-actions">
            <a href="{{ route('dashboard.assignments') }}" class="btn-empty-primary">
                <i class="fas fa-tasks"></i> Lihat Tugas
            </a>
        </div>
    </div>
</div>
@endif

{{-- Info Card --}}
<div class="info-card">
    <div class="info-card-header">
        <h3>
            <i class="fas fa-info-circle" style="color: #EE2E24;"></i>
            Informasi Sertifikat
        </h3>
    </div>
    <div class="info-card-body">
        <div class="info-columns">
            <div class="info-section">
                <h5>
                    <i class="fas fa-clipboard-check green-icon"></i>
                    Syarat Mendapatkan Sertifikat
                </h5>
                <ul class="info-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Pengajuan magang diterima oleh admin</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Menyelesaikan semua tugas yang diberikan pembimbing</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Mengikuti program magang dengan baik dan penuh</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Mendapatkan penilaian positif dari pembimbing</span>
                    </li>
                </ul>
            </div>
            <div class="info-section">
                <h5>
                    <i class="fas fa-star amber-icon"></i>
                    Manfaat Sertifikat
                </h5>
                <ul class="info-list">
                    <li>
                        <i class="fas fa-star"></i>
                        <span>Bukti resmi pengalaman kerja di BUMN</span>
                    </li>
                    <li>
                        <i class="fas fa-star"></i>
                        <span>Menambah nilai CV dan portofolio profesional</span>
                    </li>
                    <li>
                        <i class="fas fa-star"></i>
                        <span>Kesempatan bergabung sebagai karyawan tetap</span>
                    </li>
                    <li>
                        <i class="fas fa-star"></i>
                        <span>Memperluas networking dengan profesional industri</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
