@extends('layouts.dashboard')

@section('title', 'Status Pengajuan - PT Telkom Indonesia')

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
            <h1 class="h3 mb-0">Status Pengajuan Magang</h1>
            <p class="text-muted">Informasi status pengajuan magang Anda</p>
        </div>
    </div>

    @if($application)
        @php
            $isAccepted = in_array($application->status, ['accepted', 'finished']);
        @endphp
        
        @if(!$isAccepted)
        <!-- Status Pengajuan untuk User Belum Diterima -->
        <div class="row">
            <div class="col-md-8">
                <!-- Biodata Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Biodata
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>Nama:</strong></p>
                                <p>{{ $user->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>Email:</strong></p>
                                <p>{{ $user->email ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>NIM:</strong></p>
                                <p>{{ $user->nim ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>No HP:</strong></p>
                                <p>{{ $user->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>Universitas/Sekolah:</strong></p>
                                <p>{{ $user->university ?? '-' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="mb-1"><strong>Jurusan:</strong></p>
                                <p>{{ $user->major ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bidang Peminatan Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tags me-2"></i>Bidang Peminatan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><strong>Bidang yang Dipilih:</strong></p>
                        <p>{{ $application->fieldOfInterest->name ?? '-' }}</p>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Status Pengajuan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="mb-1"><strong>Status:</strong></p>
                            @if($application->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($application->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong></p>
                            <p>{{ $application->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($application->status == 'rejected' && $application->notes)
                            <div class="mt-3 p-3 bg-light border-start border-danger border-4">
                                <h6 class="text-danger mb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan:
                                </h6>
                                <p class="mb-0">{{ $application->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Contact Information -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-phone me-2"></i>Kontak HR
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Email:</strong></p>
                        <p class="text-primary">hr@telkom.co.id</p>
                        
                        <p class="mb-2"><strong>Telepon:</strong></p>
                        <p>(021) 789-0123</p>
                        
                        <p class="mb-2"><strong>Jam Kerja:</strong></p>
                        <p>Senin - Jumat<br>08:00 - 17:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($isAccepted)
        <!-- Status Pengajuan untuk User Sudah Diterima (Original) -->
        <div class="row">
            <div class="col-md-8">
                <!-- Application Status Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt me-2"></i>Detail Pengajuan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Divisi:</strong></p>
                                <p class="text-primary">{{ $application->divisi->name }}</p>
                                
                                <p class="mb-2"><strong>Sub Direktorat:</strong></p>
                                <p>{{ $application->divisi->subDirektorat->name }}</p>
                                
                                <p class="mb-2"><strong>Direktorat:</strong></p>
                                <p>{{ $application->divisi->subDirektorat->direktorat->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Status:</strong></p>
                                @if($application->status == 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($application->status == 'finished')
                                    <span class="badge bg-primary">Finished</span>
                                @endif
                                
                                <p class="mb-2 mt-3"><strong>Tanggal Pengajuan:</strong></p>
                                <p>{{ $application->created_at->format('d M Y H:i') }}</p>
                                
                                @if($application->updated_at != $application->created_at)
                                    <p class="mb-2"><strong>Terakhir Diupdate:</strong></p>
                                    <p>{{ $application->updated_at->format('d M Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        @if($application->status == 'accepted')
                            @if(!$application->acknowledged_additional_requirements)
                                <div class="mt-4 p-3 bg-warning bg-opacity-10 border-start border-warning border-4">
                                    <h6 class="text-warning mb-2">
                                        <i class="fas fa-exclamation-circle me-2"></i>Persyaratan Tambahan
                                    </h6>
                                    <ol class="mb-3">
                                        <li>Siapkan berkas pengajuan/permohonan dalam format pdf</li>
                                        <li>Pastikan sudah install aplikasi PosPay (screenshot aplikasi)</li>
                                        <li>Buat Prangko Prisma di loket Kantor Pos.</li>
                                        <li>Lengkapi informasi dengan lengkap dan benar untuk pengiriman form Name Tag yang wajib digunakan selama proses internship</li>
                                        <li>Link Name Tag: <a href="https://www.canva.com/design/DAF--E97Wqg/1d-ph6OCvDsncMRtKqbgXw/edit?utm_content=DAF--E97Wqg&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton" target="_blank">Klik di sini</a></li>
                                    </ol>
                                    <form method="POST" action="{{ route('dashboard.status.acknowledge') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Saya mengerti</button>
                                    </form>
                                </div>
                            @elseif(
                                !$application->cover_letter_path ||
                                !$application->foto_nametag_path ||
                                !$application->screenshot_pospay_path ||
                                !$application->foto_prangko_prisma_path ||
                                !$application->ss_follow_ig_museum_path ||
                                !$application->ss_follow_ig_posindonesia_path ||
                                !$application->ss_subscribe_youtube_path
                            )
                                <div class="mt-4 p-3 bg-info bg-opacity-10 border-start border-info border-4">
                                    <h6 class="text-info mb-2">
                                        <i class="fas fa-upload me-2"></i>Upload Dokumen Tambahan
                                    </h6>
                                    <p class="text-danger mb-2" style="font-size: 0.95em;">
                                        Maksimal ukuran file yang dapat diupload adalah <b>2 MB</b> untuk setiap dokumen.
                                    </p>
                                    <form method="POST" action="{{ route('dashboard.status.upload-additional') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">Surat Pengantar Kampus (PDF)</label>
                                            <input type="file" name="cover_letter" class="form-control" accept=".pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Foto Name Tag</label>
                                            <input type="file" name="foto_nametag" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Screenshot aplikasi PosPay</label>
                                            <input type="file" name="screenshot_pospay" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Foto Prangko Prisma</label>
                                            <input type="file" name="foto_prangko_prisma" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Screenshot follow Instagram (museumposindonesia)</label>
                                            <input type="file" name="ss_follow_ig_museum" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Screenshot follow Instagram (posindonesia.ig)</label>
                                            <input type="file" name="ss_follow_ig_posindonesia" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Screenshot subscribe Youtube (Pos Indonesia)</label>
                                            <input type="file" name="ss_subscribe_youtube" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-2">Kumpulkan</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                        @if($application->acceptance_letter_path && is_null($application->acceptance_letter_downloaded_at))
                            <div class="mt-4 p-3 bg-success bg-opacity-10 border-start border-success border-4">
                                <h6 class="text-success mb-2">
                                    <i class="fas fa-envelope-open-text me-2"></i>Surat Penerimaan Magang Anda
                                </h6>
                                <a href="{{ route('dashboard.acceptance-letter.download') }}" class="btn btn-success" target="_blank">Download Surat Penerimaan</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Application Timeline -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Timeline Pengajuan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Pengajuan Dikirim</h6>
                                    <p class="text-muted mb-0">{{ $application->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($application->status != 'pending')
                                <div class="timeline-item">
                                    <div class="timeline-marker {{ $application->status == 'accepted' ? 'bg-success' : ($application->status == 'rejected' ? 'bg-danger' : ($application->status == 'postponed' ? 'bg-secondary' : 'bg-primary')) }}"></div>
                                    <div class="timeline-content">
                                        <span class="small text-muted">{{ $application->updated_at->format('d M Y H:i') }}</span><br>
                                        @if($application->status == 'accepted')
                                            Pengajuan Diterima
                                        @elseif($application->status == 'rejected')
                                            Pengajuan Ditolak
                                        @elseif($application->status == 'postponed')
                                            Pengajuan Ditunda
                                        @elseif($application->status == 'finished')
                                            Pengajuan Diterima
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if($application->status == 'finished')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <span class="small text-muted">{{ $application->updated_at->format('d M Y H:i') }}</span><br>
                                        Kegiatan Magang sudah berakhir
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Contact Information -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-phone me-2"></i>Kontak HR
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Email:</strong></p>
                        <p class="text-primary">hr@telkom.co.id</p>
                        
                        <p class="mb-2"><strong>Telepon:</strong></p>
                        <p>(021) 789-0123</p>
                        
                        <p class="mb-2"><strong>Jam Kerja:</strong></p>
                        <p>Senin - Jumat<br>08:00 - 17:00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @else
        <!-- No Application Found -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted mb-3">Belum Ada Pengajuan</h4>
                        <p class="text-muted mb-4">Anda belum mengajukan permintaan magang. Silakan ajukan permintaan magang terlebih dahulu.</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('dashboard.program') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Permintaan Magang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    padding-left: 20px;
}
</style>
@endsection 