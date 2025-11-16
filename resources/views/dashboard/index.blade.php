@extends('layouts.dashboard')

@section('title', 'Dashboard - PT Telkom Indonesia')

@push('styles')
<style>
    .container-fluid {
        padding-bottom: 2rem;
        max-width: 100%;
        overflow-x: hidden;
    }
    .card {
        margin-bottom: 1.5rem;
        overflow: visible;
        word-wrap: break-word;
    }
    .row {
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
    }
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
    .mb-3 {
        margin-bottom: 1rem !important;
    }
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        .card-body {
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
        
        // Stats untuk card
        $tugasSelesai = $user->assignments->whereNotNull('submitted_at')->whereNotNull('grade')->where('is_revision', 0)->count();
        $tugasPerluRevisi = $user->assignments->where('is_revision', 1)->whereNotNull('feedback')->count();
        
        // Hitung hari magang tersisa
        $hariTersisa = 0;
        $progressMagang = 0;
        if($application && $application->start_date && $application->end_date) {
            $now = now();
            $start = \Carbon\Carbon::parse($application->start_date);
            $end = \Carbon\Carbon::parse($application->end_date);
            
            if($now->isBefore($end)) {
                $hariTersisa = max(0, $now->diffInDays($end));
            }
            
            $totalHari = $start->diffInDays($end);
            $hariBerjalan = $now->isAfter($start) ? $start->diffInDays($now) : 0;
            $progressMagang = $totalHari > 0 ? min(100, round(($hariBerjalan / $totalHari) * 100)) : 0;
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
    @if($showAcceptanceNotif)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-envelope-open-text me-2"></i>
            <strong>Surat Penerimaan Magang Anda sudah tersedia!</strong> Silakan download pada menu <a href="{{ route('dashboard.profile') }}" class="alert-link">Profile</a>.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @php session(['acceptance_letter_notif_shown' => true]); @endphp
    @endif


    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $tugasSelesai }}</h4>
                    <small>Tugas Selesai</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $tugasPerluRevisi }}</h4>
                    <small>Tugas Perlu Revisi</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $hariTersisa }}</h4>
                    <small>Hari Magang Tersisa</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x mb-2"></i>
                    <h4 class="mb-0">{{ $progressMagang }}%</h4>
                    <small>Progress Magang</small>
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
