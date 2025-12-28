@extends('layouts.dashboard')

@section('title', 'Dashboard - PT Telkom Indonesia')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
    /* Thunderbird Color Scheme - 60% White Background, 30% Black Text, 10% Red CTA */
    :root {
        --thunderbird-red: #EE2E24;
        --thunderbird-red-dark: #C41E3A;
        --thunderbird-red-light: #FF6B6B;
        --text-primary: #212529;
        --text-secondary: #6c757d;
        --background-white: #ffffff;
        --background-light: #f8f9fa;
    }

    .container-fluid {
        padding-bottom: 2rem;
        max-width: 100%;
        overflow-x: hidden;
        background: var(--background-light);
    }

    .card {
        margin-bottom: 1.5rem;
        overflow: visible;
        word-wrap: break-word;
        background: var(--background-white);
        border: 1px solid #e9ecef;
    }

    /* Stat Cards Hover Effects & Symmetry */
    .row.mb-4 .card {
        min-height: 220px;
        display: flex;
        flex-direction: column;
    }

    .row.mb-4 .card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .row.mb-4 .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2) !important;
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

    /* Calendar Styles with Thunderbird Theme - Clean & Professional */
    #calendar {
        background: transparent;
        padding: 0;
    }

    .fc {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Toolbar */
    .fc .fc-toolbar {
        padding: 1.25rem;
        background: white;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        border: 1px solid #e9ecef;
    }

    .fc .fc-toolbar-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #EE2E24;
        letter-spacing: -0.5px;
    }

    .fc .fc-button-primary {
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(238, 46, 36, 0.25);
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .fc .fc-button-primary:hover {
        background: linear-gradient(135deg, #C41E3A 0%, #A01830 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(238, 46, 36, 0.35);
    }

    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: linear-gradient(135deg, #A01830 0%, #8B1528 100%);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .fc .fc-button-primary:focus {
        box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.2);
    }

    /* Header Days */
    .fc .fc-col-header {
        background: linear-gradient(to bottom, #f8f9fa 0%, #f1f3f5 100%);
    }

    .fc .fc-col-header-cell {
        padding: 0.875rem;
        font-weight: 700;
        color: #212529;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.8px;
        border: 1px solid #dee2e6;
    }

    .fc .fc-col-header-cell a {
        color: #212529 !important;
        text-decoration: none !important;
    }

    /* Calendar Grid */
    .fc .fc-scrollgrid {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .fc .fc-daygrid-day {
        background: white;
        border: 1px solid #e9ecef;
        transition: background 0.15s ease;
        min-height: 90px;
    }

    .fc .fc-daygrid-day:hover {
        background: #fafbfc;
    }

    .fc .fc-daygrid-day-frame {
        padding: 0.5rem;
        min-height: 90px;
    }

    .fc .fc-daygrid-day-number {
        color: #495057;
        font-weight: 600;
        padding: 0.4rem;
        font-size: 0.875rem;
    }

    .fc .fc-daygrid-day-top {
        justify-content: flex-start;
        padding: 0.25rem;
    }

    /* Events */
    .fc-event {
        cursor: pointer;
        border: none !important;
        padding: 4px 6px;
        margin: 2px 0;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        transition: all 0.2s ease;
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.18);
    }

    .fc-daygrid-event {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .fc-event-main {
        color: white;
    }

    .fc-event-title {
        font-weight: 600;
    }

    /* Today */
    .fc .fc-daygrid-day.fc-day-today {
        background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
        box-shadow: inset 0 0 0 2px #EE2E24 !important;
        position: relative;
    }

    .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        color: white;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(238, 46, 36, 0.35);
        font-weight: 700;
    }

    /* Weekend */
    .fc .fc-day-sat,
    .fc .fc-day-sun {
        background-color: #fafbfc;
    }

    .fc .fc-day-sat .fc-daygrid-day-number,
    .fc .fc-day-sun .fc-daygrid-day-number {
        color: #6c757d;
    }

    /* Border consistency */
    .fc-theme-standard td,
    .fc-theme-standard th {
        border-color: #e9ecef;
    }

    .fc-theme-standard .fc-scrollgrid {
        border-color: #dee2e6;
    }

    /* Remove extra borders */
    .fc .fc-daygrid-body {
        border-color: #e9ecef;
    }

    /* Task Card Styles with Thunderbird Red - Enhanced */
    .task-item {
        border-left: 5px solid #EE2E24;
        padding: 1.25rem;
        background: white;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e9ecef;
        border-left-width: 5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }

    .task-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(to bottom, #EE2E24 0%, #C41E3A 100%);
        transition: width 0.3s ease;
    }

    .task-item:hover {
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
        transform: translateX(8px) translateY(-2px);
        box-shadow: 0 6px 20px rgba(238, 46, 36, 0.15);
        border-color: #EE2E24;
    }

    .task-item:hover::before {
        width: 8px;
    }

    .task-item.completed {
        border-left-color: #28a745;
        opacity: 0.75;
        background: linear-gradient(135deg, #f0f9f4 0%, #ffffff 100%);
    }

    .task-item.completed::before {
        background: linear-gradient(to bottom, #28a745 0%, #218838 100%);
    }

    .task-item.revision {
        border-left-color: #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .task-item.revision::before {
        background: linear-gradient(to bottom, #dc3545 0%, #c82333 100%);
    }

    .task-meta {
        display: flex;
        gap: 1.25rem;
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.75rem;
        font-weight: 500;
    }

    .task-meta i {
        margin-right: 0.4rem;
        color: #EE2E24;
    }

    .task-item h6 {
        color: #212529;
        font-weight: 700;
        font-size: 1rem;
    }

    /* Button Thunderbird Style */
    .btn-outline-danger {
        color: var(--thunderbird-red);
        border-color: var(--thunderbird-red);
    }

    .btn-outline-danger:hover {
        background-color: var(--thunderbird-red);
        border-color: var(--thunderbird-red);
        color: white;
    }

    /* Badge Thunderbird Style */
    .badge.bg-danger,
    .badge[style*="background: #EE2E24"] {
        background-color: var(--thunderbird-red) !important;
    }

    /* Card Header with Thunderbird Accent */
    .card-header {
        background-color: var(--background-white);
        border-bottom: 2px solid #e9ecef;
        color: var(--text-primary);
    }

    .card-title {
        color: var(--text-primary);
        font-weight: 600;
    }

    /* Alert Styles */
    .alert-info {
        background-color: #e7f3ff;
        border-color: var(--thunderbird-red);
        color: var(--text-primary);
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #28a745;
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        .card-body {
            padding: 1rem;
        }
        #calendar {
            padding: 0.5rem;
        }
    }

</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(238, 46, 36, 0.08); border-left: 6px solid #EE2E24;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="mb-2" style="font-size: 2rem; font-weight: 700; color: #EE2E24;">Dashboard Peserta Magang</h1>
                <p class="mb-0" style="color: #6c757d; font-size: 1.1rem;">
                    <i class="fas fa-building me-2"></i>PT Telkom Indonesia
                </p>
            </div>
            <div class="text-end">
                <div class="d-flex flex-column align-items-end">
                    <span class="badge mb-2" style="background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%); font-size: 0.9rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                    </span>
                    <small style="color: #6c757d;">
                        <i class="fas fa-clock me-1"></i>Login: {{ Auth::user()->updated_at->format('d M Y H:i') }}
                    </small>
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
            $now = now()->startOfDay();
            $start = \Carbon\Carbon::parse($application->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($application->end_date)->startOfDay();

            // Hitung sisa hari termasuk hari ini dan hari terakhir
            if($now->lessThanOrEqualTo($end)) {
                $hariTersisa = max(0, $now->diffInDays($end) + 1);
            }

            // Total hari magang (termasuk hari pertama dan terakhir)
            $totalHari = $start->diffInDays($end) + 1;
            // Hari yang sudah berjalan (termasuk hari ini jika sudah dimulai)
            $hariBerjalan = $now->greaterThanOrEqualTo($start) ? $start->diffInDays($now) + 1 : 0;
            $progressMagang = $totalHari > 0 ? min(100, round(($hariBerjalan / $totalHari) * 100)) : 0;
        }
        
        $showAcceptanceNotif = isset($application) && $application && $application->acceptance_letter_path && is_null($application->acceptance_letter_downloaded_at);

        // Cek apakah sudah check-in hari ini
        $todayAttendance = $user->attendances()
            ->whereDate('date', now()->toDateString())
            ->first();
        $hasCheckedInToday = $todayAttendance && $todayAttendance->check_in_time;

        // Hanya tampilkan reminder jika dalam periode magang dan belum check-in
        $showAttendanceReminder = false;
        if($application && $application->start_date && $application->end_date) {
            $today = now()->startOfDay();
            $start = \Carbon\Carbon::parse($application->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($application->end_date)->startOfDay();

            // Tampilkan reminder jika hari ini dalam periode magang dan belum check-in
            if($today->greaterThanOrEqualTo($start) && $today->lessThanOrEqualTo($end) && !$hasCheckedInToday) {
                $showAttendanceReminder = true;
            }
        }
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
    @if($showAttendanceReminder)
        <div class="alert alert-dismissible fade show" role="alert" style="background-color: #FFF5F5; border-left: 4px solid #EE2E24; border-color: #EE2E24;">
            <div class="d-flex align-items-center">
                <i class="fas fa-clock me-3" style="font-size: 1.5rem; color: #EE2E24;"></i>
                <div class="flex-grow-1">
                    <strong style="color: #EE2E24;">Jangan Lupa Absensi Hari Ini!</strong>
                    <p class="mb-0" style="color: #6c757d;">Anda belum melakukan check-in untuk hari ini. Segera lakukan absensi sekarang!</p>
                </div>
                <a href="{{ route('attendance.index') }}" class="btn btn-sm ms-3" style="background-color: #EE2E24; color: white; font-weight: 600;">
                    <i class="fas fa-user-check me-1"></i>Absensi Sekarang
                </a>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white border-0" style="background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(40, 167, 69, 0.3); transition: all 0.3s ease;">
                <div class="card-body text-center p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <i class="fas fa-check-circle fa-2x"></i>
                        <div class="text-end">
                            <small style="opacity: 0.75;">Selesai</small>
                        </div>
                    </div>
                    <h2 class="mb-1 fw-bold">{{ $tugasSelesai }}</h2>
                    <small class="d-block mb-2">Tugas Selesai</small>
                    @php
                        $totalTugas = $user->assignments->count();
                    @endphp
                    @if($totalTugas > 0)
                        <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.25);">
                            <div class="d-flex justify-content-between align-items-center">
                                <small style="opacity: 0.75;"><i class="fas fa-tasks me-1"></i>Total: {{ $totalTugas }}</small>
                                <small style="opacity: 0.75;"><i class="fas fa-percentage me-1"></i>{{ $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0 }}%</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(220, 53, 69, 0.3); transition: all 0.3s ease;">
                <div class="card-body text-center p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <div class="text-end">
                            <small style="opacity: 0.75;">Perlu Revisi</small>
                        </div>
                    </div>
                    <h2 class="mb-1 fw-bold">{{ $tugasPerluRevisi }}</h2>
                    <small class="d-block mb-2">Tugas Perlu Revisi</small>
                    @if($tugasPerluRevisi > 0)
                        <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.25);">
                            <div class="text-center">
                                <small style="opacity: 0.75;"><i class="fas fa-info-circle me-1"></i>Segera perbaiki & kirim ulang</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white border-0" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important; border-radius: 16px; box-shadow: 0 8px 24px rgba(23, 162, 184, 0.3); transition: all 0.3s ease;">
                <div class="card-body text-center p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <i class="fas fa-calendar-day fa-2x"></i>
                        <div class="text-end">
                            <small style="opacity: 0.75;">Sisa Waktu</small>
                        </div>
                    </div>
                    <h2 class="mb-1 fw-bold">{{ $hariTersisa }}</h2>
                    <small class="d-block mb-2">Hari Magang Tersisa</small>
                    @if($application && $application->start_date && $application->end_date)
                        <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255, 255, 255, 0.25);">
                            <div class="d-flex justify-content-between align-items-center">
                                <small style="opacity: 0.75;"><i class="fas fa-play-circle me-1"></i>{{ \Carbon\Carbon::parse($application->start_date)->format('d/m/Y') }}</small>
                                <small style="opacity: 0.75;"><i class="fas fa-stop-circle me-1"></i>{{ \Carbon\Carbon::parse($application->end_date)->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar & Tasks Section -->
    <div class="row">
        <!-- Calendar -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0" style="box-shadow: 0 8px 30px rgba(238, 46, 36, 0.12); border-radius: 16px; overflow: hidden;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%); padding: 1.25rem 1.5rem; border: none;">
                    <h5 class="mb-0" style="color: white; font-weight: 700; font-size: 1.25rem;">
                        <i class="fas fa-calendar-alt me-2"></i>Kalender Magang
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge" style="background: rgba(255, 255, 255, 0.25); color: white; border: 1px solid rgba(255, 255, 255, 0.5); font-weight: 600;">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Tugas
                        </span>
                        <span class="badge" style="background: rgba(255, 255, 255, 0.25); color: white; border: 1px solid rgba(255, 255, 255, 0.5); font-weight: 600;">
                            <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Magang
                        </span>
                    </div>
                </div>
                <div class="card-body" style="padding: 1.5rem; background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0" style="box-shadow: 0 8px 30px rgba(238, 46, 36, 0.12); border-radius: 16px; overflow: hidden;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%); padding: 1.25rem 1.5rem; border: none;">
                    <h5 class="mb-0" style="color: white; font-weight: 700; font-size: 1.25rem;">
                        <i class="fas fa-tasks me-2"></i>Tugas Terbaru
                    </h5>
                    <a href="{{ route('dashboard.assignments') }}" class="btn btn-sm" style="background: rgba(255, 255, 255, 0.25); color: white; border: 1px solid rgba(255, 255, 255, 0.5); font-weight: 600;">
                        <i class="fas fa-arrow-right me-1"></i>Lihat Semua
                    </a>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto; background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%); padding: 1.25rem;">
                    @if($user->assignments->count() > 0)
                        @foreach($user->assignments->sortByDesc('created_at')->take(5) as $assignment)
                        <div class="task-item
                            {{ $assignment->submitted_at && $assignment->grade ? 'completed' : '' }}
                            {{ $assignment->is_revision ? 'revision' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold">{{ Str::limit($assignment->description, 40) }}</h6>
                                    <div class="task-meta">
                                        <span><i class="fas fa-calendar"></i>{{ $assignment->created_at->format('d M Y') }}</span>
                                        @if($assignment->deadline)
                                            <span><i class="fas fa-clock"></i>{{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @if($assignment->submitted_at && $assignment->grade)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Selesai
                                        </span>
                                    @elseif($assignment->is_revision)
                                        <span class="badge bg-danger">
                                            <i class="fas fa-redo"></i> Revisi
                                        </span>
                                    @elseif($assignment->submitted_at)
                                        <span class="badge bg-info">
                                            <i class="fas fa-hourglass-half"></i> Menunggu
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-exclamation"></i> Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                            <p class="mb-0">Belum ada tugas yang diberikan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Calendar
    var calendarEl = document.getElementById('calendar');

    // Prepare events data
    var events = [];

    // Add internship period background (no text)
    @if($application && $application->start_date && $application->end_date)
    events.push({
        title: '',
        start: '{{ $application->start_date }}',
        end: '{{ \Carbon\Carbon::parse($application->end_date)->addDay()->format('Y-m-d') }}',
        backgroundColor: 'rgba(23, 162, 184, 0.1)',
        borderColor: 'transparent',
        allDay: true,
        display: 'background'
    });

    events.push({
        title: 'Mulai Magang',
        start: '{{ $application->start_date }}',
        backgroundColor: '#28a745',
        borderColor: '#28a745',
        textColor: 'white'
    });

    events.push({
        title: 'Akhir Magang',
        start: '{{ $application->end_date }}',
        backgroundColor: '#dc3545',
        borderColor: '#dc3545',
        textColor: 'white'
    });
    @endif

    // Add assignments as events
    @foreach($user->assignments as $assignment)
        events.push({
            title: '{{ addslashes(Str::limit($assignment->description, 30)) }}',
            start: '{{ $assignment->created_at->format('Y-m-d') }}',
            @if($assignment->deadline)
            end: '{{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d') }}',
            @endif
            backgroundColor: '{{ $assignment->submitted_at && $assignment->grade ? "#28a745" : ($assignment->is_revision ? "#dc3545" : "#EE2E24") }}',
            borderColor: '{{ $assignment->submitted_at && $assignment->grade ? "#28a745" : ($assignment->is_revision ? "#dc3545" : "#EE2E24") }}',
            textColor: 'white',
            extendedProps: {
                type: 'assignment',
                status: '{{ $assignment->submitted_at && $assignment->grade ? "completed" : ($assignment->is_revision ? "revision" : "pending") }}'
            }
        });
    @endforeach

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        locale: 'id',
        buttonText: {
            today: 'Hari Ini',
            month: 'Bulan'
        },
        events: events,
        eventClick: function(info) {
            if(info.event.extendedProps.type === 'assignment') {
                // Redirect to assignments page
                window.location.href = '{{ route("dashboard.assignments") }}';
            }
        },
        eventMouseEnter: function(info) {
            info.el.style.cursor = 'pointer';
        },
        height: 'auto',
        contentHeight: 500,
        aspectRatio: 1.8
    });

    calendar.render();
});
</script>
@endpush
@endsection 
