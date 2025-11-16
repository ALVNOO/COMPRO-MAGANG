@extends('layouts.dashboard')

@section('title', 'Sertifikat - PT Telkom Indonesia')

@push('styles')
<style>
    .container-fluid {
        max-width: 100%;
        overflow-x: hidden;
        padding-bottom: 2rem;
    }
    .card {
        word-wrap: break-word;
    }
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sertifikat Magang</h1>
            <p class="text-muted">Download sertifikat magang Anda</p>
        </div>
    </div>

    @if($certificates->count() > 0)
    <div class="row">
        @foreach($certificates as $certificate)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-certificate fa-4x text-primary mb-3"></i>
                    <h5 class="card-title">Sertifikat Magang</h5>
                    <p class="card-text text-muted">
                        Sertifikat resmi dari PT Pos Indonesia untuk program magang Anda.
                    </p>
                    @if($certificate->certificate_path)
                        <div class="mb-3">
                            <embed src="{{ asset('storage/' . $certificate->certificate_path) }}" type="application/pdf" width="100%" height="200px" />
                        </div>
                    @endif
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Diterbitkan: {{ $certificate->created_at->format('d M Y') }}
                        </small>
                    </div>
                    <a href="{{ route('dashboard.certificates.download', $certificate->id) }}" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Download Sertifikat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-certificate fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">Belum Ada Sertifikat</h4>
                    <p class="text-muted mb-4">
                        Sertifikat magang akan tersedia setelah Anda menyelesaikan program magang dan semua tugas yang diberikan.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('dashboard.assignments') }}" class="btn btn-primary">
                            <i class="fas fa-tasks me-2"></i>Lihat Tugas
                        </a>
                        <a href="{{ route('dashboard.status') }}" class="btn btn-outline-primary">
                            <i class="fas fa-clipboard-list me-2"></i>Status Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Certificate Info -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Sertifikat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Syarat Mendapatkan Sertifikat:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Pengajuan magang diterima</li>
                                <li><i class="fas fa-check text-success me-2"></i>Menyelesaikan semua tugas yang diberikan</li>
                                <li><i class="fas fa-check text-success me-2"></i>Mengikuti program magang dengan baik</li>
                                <li><i class="fas fa-check text-success me-2"></i>Mendapatkan penilaian positif dari pembimbing</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Manfaat Sertifikat:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-star text-warning me-2"></i>Bukti pengalaman kerja di BUMN</li>
                                <li><i class="fas fa-star text-warning me-2"></i>Menambah nilai CV dan portofolio</li>
                                <li><i class="fas fa-star text-warning me-2"></i>Kesempatan bergabung sebagai karyawan</li>
                                <li><i class="fas fa-star text-warning me-2"></i>Networking dengan profesional</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 