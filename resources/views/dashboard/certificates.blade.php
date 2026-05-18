{{--
    USER CERTIFICATES PAGE
    Certificate management for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Sertifikat & Surat Selesai')

@php
    $role = 'participant';
    $pageTitle = 'Sertifikat & Surat Selesai';
    $documentsUnlocked = $documentsUnlocked ?? false;
    $eligible = $eligible ?? false;
    $completionLetterPath = $completionLetterPath ?? null;
    $hasCompletionLetter = ! empty($completionLetterPath);

    $totalCertificates = $certificates->count();
    $totalDocumentsShown = $totalCertificates + ($hasCompletionLetter ? 1 : 0);
@endphp

@push('styles')
<style>
/* ============================================
   CERTIFICATES PAGE STYLES
   ============================================ */

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

.cert-preview-locked {
    width: 100%;
    height: 180px;
    border-radius: 12px;
    border: 1px dashed rgba(0, 0, 0, 0.12);
    margin-bottom: 1.25rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    color: #6b7280;
    font-size: 0.9rem;
    text-align: center;
    padding: 1rem;
}

.cert-preview-locked i {
    font-size: 2rem;
    color: #d1d5db;
}

.btn-download-cert:disabled,
.btn-download-cert.disabled {
    opacity: 0.55;
    cursor: not-allowed;
    pointer-events: none;
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

@php
    $finalEvaluationRequired = $finalEvaluationRequired ?? false;
@endphp

@if($finalEvaluationRequired)
<div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 16px;" role="alert">
    <div class="d-flex align-items-start gap-3">
        <i class="fas fa-exclamation-triangle fa-lg mt-1" style="color: #b45309;"></i>
        <div>
            <strong>Evaluasi akhir diperlukan untuk unduh</strong>
            <p class="mb-2 small text-secondary">Admin dapat mengunggah sertifikat dan surat selesai kapan saja. Anda dapat melihat dokumen di halaman ini setelah magang selesai, namun tombol unduh sertifikat dan surat selesai magang aktif setelah Anda mengunggah evaluasi akhir (atau admin mengunggahkannya untuk Anda). Persyaratan ini menambah syarat yang sudah berlaku sebelumnya.</p>
            <a href="{{ route('dashboard.final-evaluation') }}" class="btn btn-sm btn-danger rounded-pill">
                <i class="fas fa-file-signature me-1"></i>Buka Evaluasi Akhir
            </a>
        </div>
    </div>
</div>
@endif

<x-dashboard.page-context-bar
    title="Sertifikat & Surat Selesai"
    description="Sertifikat magang dan surat keterangan selesai magang dari admin"
    icon="fas fa-award"
    role="peserta"
/>

@if(! $eligible)
{{-- Belum periode unduh --}}
<div class="empty-card" style="margin-bottom: 2rem;">
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-award"></i>
        </div>
        <h4>Program Masih Berlangsung</h4>
        <p>Setelah magang selesai (melewati tanggal selesai atau status selesai), sertifikat dan surat selesai magang akan ditampilkan di halaman ini jika sudah diunggah admin.</p>
        <div class="empty-actions">
            <a href="{{ route('dashboard.assignments') }}" class="btn-empty-primary">
                <i class="fas fa-tasks"></i> Lihat Tugas
            </a>
        </div>
    </div>
</div>
@elseif($totalDocumentsShown === 0)
<div class="empty-card" style="margin-bottom: 2rem;">
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-folder-open"></i>
        </div>
        <h4>Belum Ada Dokumen</h4>
        <p>Belum ada sertifikat atau surat keterangan selesai magang dari admin. Hubungi admin jika Anda sudah menyelesaikan program.</p>
    </div>
</div>
@else
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
                @if($documentsUnlocked)
                <div class="cert-preview">
                    <embed src="{{ asset('storage/' . $certificate->certificate_path) }}" type="application/pdf">
                </div>
                @else
                <div class="cert-preview-locked">
                    <i class="fas fa-lock"></i>
                    <span>Pratinjau PDF tersedia setelah evaluasi akhir diunggah.</span>
                </div>
                @endif
            @endif

            <div class="cert-meta">
                <i class="fas fa-calendar-check"></i>
                <span>Diterbitkan: <strong>{{ $certificate->created_at->locale('id')->isoFormat('D MMMM Y') }}</strong></span>
            </div>

            @if($documentsUnlocked)
            <a href="{{ route('dashboard.certificates.download', $certificate->id) }}" class="btn-download-cert">
                <i class="fas fa-download"></i> Unduh Sertifikat
            </a>
            @else
            <button type="button" class="btn-download-cert w-100 border-0" disabled aria-disabled="true">
                <i class="fas fa-lock"></i> Unduh setelah evaluasi akhir
            </button>
            @endif
        </div>
    </div>
    @endforeach

    <div class="cert-card">
        <div class="cert-card-header">
            <div class="cert-icon-wrapper">
                <i class="fas fa-file-signature"></i>
            </div>
            <h4>Surat Selesai Magang</h4>
        </div>
        <div class="cert-card-body">
            @if($hasCompletionLetter)
                @if($documentsUnlocked)
                <div class="cert-preview">
                    <embed src="{{ asset('storage/' . $completionLetterPath) }}" type="application/pdf">
                </div>
                @else
                <div class="cert-preview-locked">
                    <i class="fas fa-lock"></i>
                    <span>Pratinjau PDF tersedia setelah evaluasi akhir diunggah.</span>
                </div>
                @endif
                <div class="cert-meta">
                    <i class="fas fa-check-double"></i>
                    <span>Surat keterangan selesai magang</span>
                </div>
                @if($documentsUnlocked)
                <a href="{{ route('dashboard.certificates.download-completion-letter') }}" class="btn-download-cert">
                    <i class="fas fa-download"></i> Unduh Surat Selesai
                </a>
                @else
                <button type="button" class="btn-download-cert w-100 border-0" disabled aria-disabled="true">
                    <i class="fas fa-lock"></i> Unduh setelah evaluasi akhir
                </button>
                @endif
            @else
                <div class="cert-preview-locked" style="border-style: solid;">
                    <i class="fas fa-inbox"></i>
                    <span>Belum ada file dari admin.</span>
                </div>
                <p class="text-muted small mb-0 mt-2">Surat selesai akan muncul di sini setelah admin mengunggahnya.</p>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Info Card --}}
<div class="info-card">
    <div class="info-card-header">
        <h3>
            <i class="fas fa-info-circle" style="color: #EE2E24;"></i>
            Informasi Dokumen
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
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Mengunggah dokumen evaluasi akhir (PDF) untuk mengaktifkan unduh sertifikat dan surat selesai magang di halaman ini (tambahan; selain persyaratan yang sudah ada)</span>
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
