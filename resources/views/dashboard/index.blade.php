@extends('layouts.dashboard')

@section('title', 'Dashboard - PT Pos Indonesia')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted">Selamat datang di dashboard peserta magang PT Pos Indonesia</p>
        </div>
        <div class="text-end">
            <small class="text-muted">Terakhir login: {{ Auth::user()->updated_at->format('d M Y H:i') }}</small>
        </div>
    </div>

    <!-- Calendar & Timeline -->
    <div class="row mb-4">
        <div class="col-md-7 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt me-2"></i>Kalender Kegiatan</h5>
                    <small class="text-muted">{{ now()->translatedFormat('F Y') }}</small>
                </div>
                <div class="card-body">
                    @php
                        $start = now()->startOfMonth()->startOfWeek();
                        $end = now()->endOfMonth()->endOfWeek();
                        $cursor = $start->copy();
                        $events = collect([]);
                        // Contoh event: tenggat tugas atau tanggal penting
                        $eventsMap = [
                            optional($user->assignments->sortBy('due_date')->first())->due_date?->toDateString() => 'Tenggat Tugas',
                            optional($application)->start_date?->toDateString() => 'Mulai Magang',
                            optional($application)->end_date?->toDateString() => 'Selesai Magang',
                        ];
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Min</th><th>Sen</th><th>Sel</th><th>Rab</th><th>Kam</th><th>Jum</th><th>Sab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @while($cursor->lte($end))
                                    <tr>
                                        @for($i=0;$i<7;$i++)
                                            @php
                                                $isCurrentMonth = $cursor->month === now()->month;
                                                $label = $cursor->day;
                                                $eventLabel = $eventsMap[$cursor->toDateString()] ?? null;
                                            @endphp
                                            <td class="p-2 {{ $isCurrentMonth ? '' : 'text-muted' }}" style="vertical-align: middle;">
                                                <div class="fw-semibold">{{ $label }}</div>
                                                @if($eventLabel)
                                                    <span class="badge bg-primary mt-1">{{ $eventLabel }}</span>
                                                @endif
                                            </td>
                                            @php $cursor->addDay(); @endphp
                                        @endfor
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-timeline me-2"></i>Timeline Aktivitas</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-start">
                            <i class="fas fa-flag-checkered text-success me-3 mt-1"></i>
                            <div>
                                <div class="fw-semibold">Diterima Magang</div>
                                <small class="text-muted">{{ optional($application?->created_at)->format('d M Y') ?: '-' }}</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start">
                            <i class="fas fa-briefcase text-primary me-3 mt-1"></i>
                            <div>
                                <div class="fw-semibold">Mulai Magang</div>
                                <small class="text-muted">{{ optional($application?->start_date)->format('d M Y') ?: '-' }}</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start">
                            <i class="fas fa-calendar-check text-warning me-3 mt-1"></i>
                            <div>
                                <div class="fw-semibold">Tenggat Tugas Terdekat</div>
                                @php $nearestDue = optional($user->assignments->whereNotNull('due_date')->sortBy('due_date')->first())->due_date; @endphp
                                <small class="text-muted">{{ optional($nearestDue)->format('d M Y') ?: '-' }}</small>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-start">
                            <i class="fas fa-award text-info me-3 mt-1"></i>
                            <div>
                                <div class="fw-semibold">Selesai Magang</div>
                                <small class="text-muted">{{ optional($application?->end_date)->format('d M Y') ?: '-' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    @php
        $tugasBaru = $user->assignments->where('submitted_at', null)->count();
        $tugasDinilai = $user->assignments->where('grade', '!=', null)->where('updated_at', '>=', Auth::user()->updated_at)->count();
        $latestApp = $user->internshipApplications->whereIn('status', ['accepted', 'finished'])->sortByDesc('end_date')->first();
        $isEndDatePassed = $latestApp && $latestApp->end_date && now()->isAfter($latestApp->end_date);
        $jumlahSertifikat = $isEndDatePassed ? $user->certificates->count() : 0;
        $revisiBaru = $user->assignments->where('is_revision', 1)->where('feedback', '!=', null)->count();
        // Notifikasi persyaratan tambahan
        $notifPersyaratan = false;
        if(isset($application) && $application && $application->status == 'accepted') {
            if(!$application->acknowledged_additional_requirements
                || !$application->cover_letter_path
                || !$application->foto_nametag_path
                || !$application->screenshot_pospay_path
                || !$application->foto_prangko_prisma_path
                || !$application->ss_follow_ig_museum_path
                || !$application->ss_follow_ig_posindonesia_path
                || !$application->ss_subscribe_youtube_path) {
                $notifPersyaratan = true;
            }
        }
        $showAcceptanceNotif = isset($application) && $application && $application->acceptance_letter_path && is_null($application->acceptance_letter_downloaded_at);
    @endphp
    @if($tugasBaru > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-tasks me-2"></i>
            <strong>{{ $tugasBaru }} tugas baru</strong> menunggu untuk dikerjakan!
            <a href="{{ route('dashboard.assignments') }}" class="alert-link">Lihat Tugas</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($tugasDinilai > 0)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>{{ $tugasDinilai }} tugas Anda sudah dinilai!</strong>
            <a href="{{ route('dashboard.assignments') }}" class="alert-link">Lihat Nilai</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($jumlahSertifikat > 0)
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i class="fas fa-certificate me-2"></i>
            <strong>Selamat!</strong> Anda mendapatkan {{ $jumlahSertifikat }} sertifikat baru.
            <a href="{{ route('dashboard.certificates') }}" class="alert-link">Lihat Sertifikat</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($revisiBaru > 0)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-undo me-2"></i>
            Anda mendapat <strong>revisi tugas</strong> dari pembimbing pada {{ $revisiBaru }} tugas. Silakan cek feedback dan kumpulkan ulang tugas Anda!
            <a href="{{ route('dashboard.assignments') }}" class="alert-link">Lihat Feedback</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($notifPersyaratan)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Lengkapi persyaratan tambahan magang Anda!</strong> Silakan cek dan kumpulkan dokumen tambahan pada menu <a href="{{ route('dashboard.status') }}" class="alert-link">Status Pengajuan</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if($showAcceptanceNotif)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-envelope-open-text me-2"></i>
            <strong>Surat Penerimaan Magang Anda sudah tersedia!</strong> Silakan download pada menu <a href="{{ route('dashboard.status') }}" class="alert-link">Status Pengajuan</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php session(['acceptance_letter_notif_shown' => true]); @endphp
    @endif

    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-3">Informasi Peserta</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Nama:</strong> {{ $user->name }}</p>
                                    <p class="mb-1"><strong>NIM:</strong> {{ $user->nim }}</p>
                                    <p class="mb-1"><strong>Universitas/Sekolah:</strong> {{ $user->university }}</p>
                                    <p class="mb-1"><strong>Jurusan:</strong> {{ $user->major }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                                    <p class="mb-1"><strong>No HP:</strong> {{ $user->phone }}</p>
                                    <p class="mb-1"><strong>Status:</strong> 
                                        @if($application)
                                            @if($application->status == 'accepted')
                                                <span class="badge bg-success">{{ ucfirst($application->status) }}</span>
                                            @elseif($application->status == 'rejected')
                                                <span class="badge bg-danger">{{ ucfirst($application->status) }}</span>
                                            @elseif($application->status == 'finished')
                                                <span class="badge bg-primary">{{ ucfirst($application->status) }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ ucfirst($application->status) }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum ada pengajuan</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-graduate fa-4x text-primary mb-3"></i>
                            <h6>Peserta Magang</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Status -->
    @if($application && $application->divisi)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>Status Pengajuan Magang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Divisi:</strong> {{ $application->divisi->name ?? '-' }}</p>
                            <p class="mb-1"><strong>Sub Direktorat:</strong> {{ $application->divisi->subDirektorat->name ?? '-' }}</p>
                            <p class="mb-1"><strong>Direktorat:</strong> {{ $application->divisi->subDirektorat->direktorat->name ?? '-' }}</p>
                            <p class="mb-1"><strong>PIC:</strong> {{ $application->divisi->vp ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Status:</strong> 
                                @if($application->status == 'accepted')
                                    <span class="badge bg-success">{{ ucfirst($application->status) }}</span>
                                @elseif($application->status == 'rejected')
                                    <span class="badge bg-danger">{{ ucfirst($application->status) }}</span>
                                @elseif($application->status == 'finished')
                                    <span class="badge bg-primary">{{ ucfirst($application->status) }}</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($application->status) }}</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal Pengajuan:</strong> {{ $application->created_at->format('d M Y') }}</p>
                            @if($application->notes)
                                <p class="mb-1"><strong>Catatan:</strong> {{ $application->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->internshipApplications->count() }}</h4>
                    <small>Pengajuan Magang</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-tasks fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->assignments->count() }}</h4>
                    <small>Total Tugas</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $user->assignments->where('submitted_at', null)->count() }}</h4>
                    <small>Tugas Pending</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-certificate fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $jumlahSertifikat }}</h4>
                    <small>Sertifikat</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>Tugas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->assignments->count() > 0)
                        @foreach($user->assignments->take(3) as $assignment)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">{{ Str::limit($assignment->description, 50) }}</h6>
                                <small class="text-muted">{{ $assignment->created_at->format('d M Y') }}</small>
                            </div>
                            <div>
                                @if($assignment->submitted_at)
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ route('dashboard.assignments') }}" class="btn btn-primary btn-sm">Lihat Semua Tugas</a>
                    @else
                        <p class="text-muted mb-0">Belum ada tugas yang diberikan.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-certificate me-2"></i>Sertifikat Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @if($isEndDatePassed && $user->certificates->count() > 0)
                        @foreach($user->certificates->take(3) as $certificate)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Sertifikat Magang</h6>
                                <small class="text-muted">{{ $certificate->created_at->format('d M Y') }}</small>
                            </div>
                            <div>
                                <a href="{{ route('dashboard.certificates.download', $certificate->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <a href="{{ route('dashboard.certificates') }}" class="btn btn-primary btn-sm">Lihat Semua Sertifikat</a>
                    @else
                        <p class="text-muted mb-0">Belum ada sertifikat yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
