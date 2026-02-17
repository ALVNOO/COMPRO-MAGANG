{{--
    USER PROGRAM PAGE
    Division structure and internship application for participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Program Magang - PT Telkom Indonesia')

@php
    $role = 'participant';
    $pageTitle = 'Program';

    $rejectedApplication = $user->internshipApplications()->where('status', 'rejected')->latest()->first();
    $hasRejectedApplication = $user->internshipApplications()->where('status', 'rejected')->exists();
@endphp

@push('styles')
<style>
/* ============================================
   PROGRAM PAGE STYLES
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

/* Alert Cards */
.alert-card {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1.15rem 1.5rem;
    border-radius: 16px;
    margin-bottom: 1.5rem;
    border: 1px solid;
    backdrop-filter: blur(10px);
}

.alert-card.warning {
    background: rgba(245, 158, 11, 0.08);
    border-color: rgba(245, 158, 11, 0.2);
}

.alert-card.success {
    background: rgba(16, 185, 129, 0.08);
    border-color: rgba(16, 185, 129, 0.2);
}

.alert-card.info {
    background: rgba(59, 130, 246, 0.08);
    border-color: rgba(59, 130, 246, 0.2);
}

.alert-card .alert-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1rem;
}

.alert-card.warning .alert-icon { background: rgba(245, 158, 11, 0.15); color: #d97706; }
.alert-card.success .alert-icon { background: rgba(16, 185, 129, 0.15); color: #059669; }
.alert-card.info .alert-icon { background: rgba(59, 130, 246, 0.15); color: #2563eb; }

.alert-card .alert-content {
    flex: 1;
}

.alert-card .alert-content strong {
    display: block;
    font-size: 0.9rem;
    color: #1f2937;
    margin-bottom: 0.35rem;
}

.alert-card .alert-content p,
.alert-card .alert-content span {
    font-size: 0.83rem;
    color: #4b5563;
    margin: 0;
    line-height: 1.5;
}

/* Accordion Card */
.accordion-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 2rem;
}

.accordion-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.accordion-card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.accordion-card-body {
    padding: 1rem;
}

/* Custom Accordion Styling */
.program-accordion .accordion-item {
    border: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 14px !important;
    margin-bottom: 0.75rem;
    overflow: hidden;
    transition: all 0.3s;
}

.program-accordion .accordion-item:last-child {
    margin-bottom: 0;
}

.program-accordion .accordion-button {
    padding: 1rem 1.25rem;
    font-weight: 600;
    font-size: 0.9rem;
    color: #1f2937;
    background: #f9fafb;
    border: none;
    border-radius: 14px !important;
    box-shadow: none !important;
}

.program-accordion .accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.06), rgba(238, 46, 36, 0.02));
    color: #EE2E24;
}

.program-accordion .accordion-button::after {
    background-size: 0.85rem;
}

.program-accordion .accordion-button i {
    color: #EE2E24;
    margin-right: 0.5rem;
    font-size: 0.9rem;
}

.program-accordion .accordion-body {
    padding: 1rem 1.25rem;
}

/* Sub Accordion */
.sub-accordion .accordion-item {
    border: 1px solid rgba(0, 0, 0, 0.04);
    border-radius: 10px !important;
    margin-bottom: 0.5rem;
    background: white;
}

.sub-accordion .accordion-button {
    padding: 0.85rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    background: white;
    border-radius: 10px !important;
}

.sub-accordion .accordion-button:not(.collapsed) {
    background: rgba(59, 130, 246, 0.04);
    color: #2563eb;
}

.sub-accordion .accordion-button i {
    color: #3b82f6;
}

.sub-accordion .accordion-body {
    padding: 0.75rem 1rem;
}

/* Divisi Cards */
.divisi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.divisi-card {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 14px;
    padding: 1.25rem;
    transition: all 0.3s ease;
}

.divisi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    border-color: rgba(238, 46, 36, 0.15);
}

.divisi-card h6 {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.85rem;
}

.divisi-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.divisi-meta-item {
    font-size: 0.78rem;
}

.divisi-meta-item .meta-label {
    color: #9ca3af;
    font-weight: 500;
    display: block;
    margin-bottom: 0.15rem;
}

.divisi-meta-item .meta-value {
    color: #374151;
    font-weight: 600;
}

.btn-apply {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.15rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(238, 46, 36, 0.25);
}

.btn-apply:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.35);
    color: white;
}

.btn-reapply {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.15rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.25);
}

.btn-reapply:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
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

.info-section h5 i.blue-icon {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
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

.info-list li i.fa-check-circle { color: #10B981; }
.info-list li i.fa-file-alt,
.info-list li i.fa-laptop,
.info-list li i.fa-clock,
.info-list li i.fa-heart { color: #3B82F6; }

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

    .divisi-grid {
        grid-template-columns: 1fr;
    }

    .info-columns {
        grid-template-columns: 1fr;
        gap: 1.5rem;
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
                <i class="fas fa-building"></i>
                Program Magang
            </h1>
            <p>Jelajahi struktur organisasi dan ajukan permintaan magang di PT Telkom Indonesia</p>
        </div>
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $direktorats->count() }}</h4>
                <p>Direktorat</p>
            </div>
        </div>
    </div>
</div>

{{-- Status Alerts --}}
@if($rejectedApplication && !$hasAccepted && !$hasFinished)
<div class="alert-card warning">
    <div class="alert-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div class="alert-content">
        <strong>Pengajuan Sebelumnya Ditolak</strong>
        <p>
            <strong>Divisi sebelumnya:</strong> {{ $rejectedApplication->divisi->name ?? '-' }}<br>
            <strong>Alasan:</strong> {{ $rejectedApplication->notes ?? '-' }}<br>
            <span style="color: #6b7280;">Anda dapat mengajukan ulang untuk divisi yang sama atau berbeda.</span>
        </p>
    </div>
</div>
@endif

@if($hasAccepted && !$hasFinished)
<div class="alert-card success">
    <div class="alert-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="alert-content">
        <strong>Sudah Diterima</strong>
        <p>Anda sudah diterima magang di salah satu divisi. Tidak dapat mengajukan permintaan magang ke divisi lain.</p>
    </div>
</div>
@endif

@if($hasFinished)
<div class="alert-card info">
    <div class="alert-icon">
        <i class="fas fa-trophy"></i>
    </div>
    <div class="alert-content">
        <strong>Selamat!</strong>
        <p>Anda telah menyelesaikan program magang sebelumnya. Anda dapat mengajukan permintaan magang baru untuk divisi yang sama atau berbeda.</p>
    </div>
</div>
@endif

{{-- Accordion Card --}}
<div class="accordion-card">
    <div class="accordion-card-header">
        <h3>
            <i class="fas fa-building" style="color: #EE2E24;"></i>
            Struktur Organisasi & Divisi
        </h3>
    </div>
    <div class="accordion-card-body">
        <div class="accordion program-accordion" id="direktoratAccordion">
            @foreach($direktorats as $direktorat)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDirektorat{{ $direktorat->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirektorat{{ $direktorat->id }}">
                        <i class="fas fa-building"></i>{{ $direktorat->name }}
                    </button>
                </h2>
                <div id="collapseDirektorat{{ $direktorat->id }}" class="accordion-collapse collapse" data-bs-parent="#direktoratAccordion">
                    <div class="accordion-body">
                        <div class="accordion sub-accordion" id="subdirektoratAccordion{{ $direktorat->id }}">
                            @foreach($direktorat->subDirektorats as $subDirektorat)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSub{{ $subDirektorat->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{ $subDirektorat->id }}">
                                        <i class="fas fa-sitemap"></i>{{ $subDirektorat->name }}
                                    </button>
                                </h2>
                                <div id="collapseSub{{ $subDirektorat->id }}" class="accordion-collapse collapse" data-bs-parent="#subdirektoratAccordion{{ $direktorat->id }}">
                                    <div class="accordion-body">
                                        <div class="divisi-grid">
                                            @foreach($subDirektorat->divisis as $divisi)
                                            <div class="divisi-card">
                                                <h6>{{ $divisi->name }}</h6>
                                                <div class="divisi-meta">
                                                    <div class="divisi-meta-item">
                                                        <span class="meta-label">PIC</span>
                                                        <span class="meta-value">{{ $divisi->vp }}</span>
                                                    </div>
                                                    <div class="divisi-meta-item">
                                                        <span class="meta-label">NIPPOS</span>
                                                        <span class="meta-value">{{ $divisi->nippos }}</span>
                                                    </div>
                                                </div>
                                                @if(!$hasAccepted || $hasFinished)
                                                    @if($hasRejectedApplication && !$hasFinished)
                                                        <a href="{{ route('dashboard.reapply') }}?divisi={{ $divisi->id }}" class="btn-reapply">
                                                            <i class="fas fa-redo"></i> Ajukan Ulang
                                                        </a>
                                                    @else
                                                        <a href="{{ route('internship.apply', ['divisi' => $divisi->id]) }}" class="btn-apply">
                                                            <i class="fas fa-paper-plane"></i> Ajukan Magang
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Info Card --}}
<div class="info-card">
    <div class="info-card-header">
        <h3>
            <i class="fas fa-info-circle" style="color: #EE2E24;"></i>
            Informasi Program Magang
        </h3>
    </div>
    <div class="info-card-body">
        <div class="info-columns">
            <div class="info-section">
                <h5>
                    <i class="fas fa-check-circle green-icon"></i>
                    Keuntungan Program Magang
                </h5>
                <ul class="info-list">
                    <li><i class="fas fa-check-circle"></i><span>Pengalaman kerja langsung di perusahaan BUMN</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Mentoring dari profesional berpengalaman</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Sertifikat magang resmi PT Telkom Indonesia</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Networking dengan karyawan profesional</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Kesempatan bergabung sebagai karyawan</span></li>
                    <li><i class="fas fa-check-circle"></i><span>Pengembangan skill profesional</span></li>
                </ul>
            </div>
            <div class="info-section">
                <h5>
                    <i class="fas fa-clipboard-list blue-icon"></i>
                    Persyaratan Magang
                </h5>
                <ul class="info-list">
                    <li><i class="fas fa-file-alt"></i><span>Surat pengantar dari kampus</span></li>
                    <li><i class="fas fa-laptop"></i><span>Memiliki laptop dan koneksi internet</span></li>
                    <li><i class="fas fa-clock"></i><span>Dapat mengikuti jam kerja kantor</span></li>
                    <li><i class="fas fa-heart"></i><span>Memiliki motivasi tinggi untuk belajar</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
