{{-- Evaluasi akhir peserta (unggah PDF) --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir')

@php
    $role = 'participant';
    $pageTitle = 'Evaluasi Akhir';
    $pageSubtitle = 'Unggah dokumen evaluasi akhir magang (PDF, maks. 2 MB). Hanya salah satu sumber yang diizinkan: jika admin sudah mengunggah salinan, Anda tidak dapat mengunggah dari akun peserta. Dokumen ini diperlukan untuk sertifikat sebagai tambahan persyaratan yang sudah ada.';
@endphp

@push('styles')
<style>
.fe-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
}
.fe-card {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    padding: 1.75rem;
    max-width: 640px;
}
.fe-card h2 { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937; }
.fe-muted { color: #6b7280; font-size: 0.9rem; line-height: 1.5; }
</style>
@endpush

@section('content')
<div class="fe-hero">
    <h1 class="h4 mb-2"><i class="fas fa-file-signature me-2"></i>Evaluasi Akhir</h1>
    <p class="mb-0 opacity-90">Format wajib PDF, maksimal 2 MB.</p>
</div>

@if(!$application)
<div class="fe-card">
    <p class="fe-muted mb-0">Anda tidak memiliki pengajuan magang yang sedang berjalan untuk mengunggah evaluasi akhir.</p>
</div>
@else
<div class="fe-card mb-4">
    <h2><i class="fas fa-info-circle text-danger me-2"></i>Status dokumen</h2>
    <p class="fe-muted mb-0">
        <strong>Dokumen evaluasi akhir:</strong>
        @if($application->hasFinalEvaluationDocument())
            Tersedia
            @php
                $evalUploadedAt = $application->final_evaluation_participant_uploaded_at ?? $application->final_evaluation_admin_uploaded_at;
            @endphp
            @if($evalUploadedAt)
                <span class="text-muted">({{ $evalUploadedAt->locale('id')->isoFormat('D MMM Y, HH:mm') }})</span>
            @endif
        @else
            Belum ada
        @endif
    </p>
    @if($application->hasFinalEvaluationDocument())
        <p class="text-success mt-3 mb-0 small"><i class="fas fa-check-circle me-1"></i>Persyaratan dokumen evaluasi akhir untuk sertifikat telah terpenuhi.</p>
    @endif
</div>

<div class="fe-card">
    <h2><i class="fas fa-upload text-danger me-2"></i>Unggah / ganti dokumen</h2>
    @if($application->final_evaluation_admin_path)
        <p class="fe-muted">Admin telah mengunggah dokumen evaluasi akhir untuk pengajuan ini. Unggahan dari akun peserta dinonaktifkan.</p>
    @else
        <p class="fe-muted">Maksimal 2 MB, format PDF. Mengganti file akan menimpa berkas evaluasi akhir Anda sebelumnya (jika ada).</p>
        <form method="POST" action="{{ route('dashboard.final-evaluation.upload') }}" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="final_evaluation" class="form-label">File PDF</label>
                <input type="file" name="final_evaluation" id="final_evaluation" class="form-control" accept="application/pdf,.pdf" required>
            </div>
            <button type="submit" class="btn btn-danger rounded-pill px-4">
                <i class="fas fa-cloud-upload-alt me-2"></i>Simpan
            </button>
        </form>
    @endif
    @if($application->finalEvaluationDocumentPath())
        <hr>
        <a href="{{ route('dashboard.final-evaluation.download') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="fas fa-download me-2"></i>Unduh dokumen
        </a>
    @endif
</div>
@endif
@endsection
