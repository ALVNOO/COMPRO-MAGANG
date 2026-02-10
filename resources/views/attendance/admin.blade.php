{{--
    ADMIN ATTENDANCE PAGE
    Monitor daily attendance of interns
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Daily Attendance')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Daily Attendance';
    $pageSubtitle = 'Pantau absensi peserta magang';

    // Count stats for today
    $hadirCount = collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Hadir')->count();
    $absenCount = collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Absen')->count();
    $terlambatCount = collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Terlambat')->count();
    $belumAbsen = collect($participants)->filter(fn($p) => !$p['attendance'])->count();
@endphp

@push('styles')
<style>
/* ============================================
   ATTENDANCE PAGE STYLES
   ============================================ */

/* Hero Section */
.admin-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.admin-hero::before {
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
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.hero-badge-text p {
    font-size: 0.8rem;
    opacity: 0.9;
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    color: white;
}

.stat-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
    line-height: 1.2;
}

.stat-content p {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}

.stat-card.green .stat-icon { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
.stat-card.yellow .stat-icon { background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); }
.stat-card.orange .stat-icon { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }
.stat-card.gray .stat-icon { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); }

/* Filter Bar */
.filter-bar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.filter-group label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-select, .filter-date {
    padding: 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white;
    min-width: 180px;
    transition: all 0.2s ease;
}

.filter-select:focus, .filter-date:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    margin-left: auto;
}

.filter-btn {
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.filter-btn.primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.filter-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.filter-btn.secondary {
    background: #f3f4f6;
    color: #374151;
}

.filter-btn.secondary:hover {
    background: #e5e7eb;
}

/* Table Card */
.table-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.table-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
}

.table-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.table-header h3 i {
    color: #EE2E24;
}

.table-responsive {
    overflow-x: auto;
}

/* Admin Table */
.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.admin-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.admin-table td {
    padding: 1rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.admin-table tbody tr {
    transition: all 0.2s ease;
}

.admin-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

/* User Info Cell */
.user-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-info .name {
    font-weight: 600;
    color: #1f2937;
}

.user-info .email, .user-info .division {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge.hadir {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.15) 100%);
    color: #16a34a;
}

.status-badge.absen {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #dc2626;
}

.status-badge.terlambat {
    background: linear-gradient(135deg, rgba(234, 179, 8, 0.15) 0%, rgba(202, 138, 4, 0.15) 100%);
    color: #ca8a04;
}

.status-badge.none {
    background: #f3f4f6;
    color: #6b7280;
}

/* 7 Days Status */
.seven-days {
    display: flex;
    gap: 0.25rem;
    justify-content: center;
}

.day-status {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 32px;
}

.day-status .date {
    font-size: 0.65rem;
    color: #9ca3af;
    margin-bottom: 0.25rem;
}

.day-status .badge {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 600;
}

.day-status .badge.hadir { background: #22c55e; color: white; }
.day-status .badge.absen { background: #ef4444; color: white; }
.day-status .badge.terlambat { background: #eab308; color: white; }
.day-status .badge.none { background: #e5e7eb; color: #9ca3af; }

/* Action Button */
.btn-view-photo {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-view-photo:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.no-photo {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    color: #9ca3af;
    border-radius: 8px;
    font-size: 0.8rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
}

.modal-container {
    background: white;
    border-radius: 20px;
    max-width: 800px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.modal-header {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-body {
    padding: 1.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.modal-photo {
    border-radius: 12px;
    overflow: hidden;
}

.modal-photo img {
    width: 100%;
    height: auto;
    display: block;
}

.modal-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-item label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-item .value {
    font-size: 1rem;
    color: #1f2937;
    font-weight: 500;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
}

.btn-close-modal {
    padding: 0.625rem 1.25rem;
    background: #f3f4f6;
    color: #374151;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-close-modal:hover {
    background: #e5e7eb;
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .modal-body {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .admin-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        width: 100%;
    }

    .filter-select, .filter-date {
        width: 100%;
    }

    .filter-actions {
        margin-left: 0;
        margin-top: 0.5rem;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-clipboard-check"></i> Daily Attendance</h1>
            <p>Pantau absensi peserta magang secara real-time</p>
        </div>
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ Carbon::parse($filterDate)->format('d M Y') }}</h4>
                <p>{{ Carbon::parse($filterDate)->translatedFormat('l') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $hadirCount }}</h3>
            <p>Hadir</p>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $terlambatCount }}</h3>
            <p>Terlambat</p>
        </div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $absenCount }}</h3>
            <p>Absen</p>
        </div>
    </div>
    <div class="stat-card gray">
        <div class="stat-icon">
            <i class="fas fa-question-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $belumAbsen }}</h3>
            <p>Belum Absen</p>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<form id="adminAttendanceFilterForm" method="GET" action="{{ route('admin.attendance') }}" class="filter-bar">
    <div class="filter-group">
        <label>Divisi</label>
        <select class="filter-select" id="division_id" name="division_id">
            <option value="">Semua Divisi</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                    {{ $division->division_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label>Tanggal</label>
        <input type="date" class="filter-date" id="date" name="date" value="{{ $filterDate }}" required>
    </div>
    <div class="filter-actions">
        <button type="submit" class="filter-btn primary">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('admin.attendance') }}" class="filter-btn secondary">
            <i class="fas fa-redo"></i> Reset
        </a>
    </div>
</form>

{{-- Attendance Table --}}
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-list"></i> Data Absensi - {{ Carbon::parse($filterDate)->format('d M Y') }}</h3>
    </div>

    @if(count($participants) > 0)
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 22%;">Peserta</th>
                    <th style="width: 12%; text-align: center;">Status</th>
                    <th style="width: 28%; text-align: center;">Status 7 Hari Terakhir</th>
                    <th style="width: 13%; text-align: center;">Waktu</th>
                    <th style="width: 20%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $participant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="user-info">
                            <span class="name">{{ $participant['user']->name }}</span>
                            <span class="email">{{ $participant['user']->email }}</span>
                            @if($participant['application']->divisionAdmin)
                                <span class="division">{{ $participant['application']->divisionAdmin->division_name }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @if($participant['attendance'])
                            @if($participant['attendance']->status == 'Hadir')
                                <span class="status-badge hadir"><i class="fas fa-check"></i> Hadir</span>
                            @elseif($participant['attendance']->status == 'Absen')
                                <span class="status-badge absen"><i class="fas fa-times"></i> Absen</span>
                            @elseif($participant['attendance']->status == 'Terlambat')
                                <span class="status-badge terlambat"><i class="fas fa-clock"></i> Terlambat</span>
                            @endif
                        @else
                            <span class="status-badge none">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="seven-days">
                            @php
                                $workingDays = $participant['workingDays'] ?? collect();
                                if ($workingDays->isEmpty()) {
                                    $workingDays = collect();
                                    $currentDate = Carbon::parse($filterDate);
                                    $daysBack = 0;
                                    while ($workingDays->count() < 7) {
                                        $checkDate = $currentDate->copy()->subDays($daysBack);
                                        if ($checkDate->dayOfWeek != Carbon::SATURDAY && $checkDate->dayOfWeek != Carbon::SUNDAY) {
                                            $workingDays->push($checkDate->toDateString());
                                        }
                                        $daysBack++;
                                        if ($daysBack > 20) break;
                                    }
                                    $workingDays = $workingDays->reverse()->values();
                                }
                            @endphp
                            @foreach($workingDays as $workDate)
                                @php
                                    $checkDate = Carbon::parse($workDate);
                                    $dayAttendance = $participant['last7Days']->firstWhere('date', is_string($workDate) ? $workDate : $workDate->toDateString());
                                @endphp
                                <div class="day-status">
                                    <span class="date">{{ $checkDate->format('d') }}</span>
                                    @if($dayAttendance)
                                        @if($dayAttendance->status == 'Hadir')
                                            <span class="badge hadir">✓</span>
                                        @elseif($dayAttendance->status == 'Absen')
                                            <span class="badge absen">✗</span>
                                        @elseif($dayAttendance->status == 'Terlambat')
                                            <span class="badge terlambat">L</span>
                                        @endif
                                    @else
                                        <span class="badge none">-</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td style="text-align: center;">
                        @if($participant['attendance'] && $participant['attendance']->check_in_time)
                            <span style="font-weight: 500;">{{ Carbon::parse($participant['attendance']->check_in_time)->format('H:i:s') }}</span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($participant['attendance'] && $participant['attendance']->photo_path)
                            <button onclick="showPhoto('{{ $participant['user']->name }}', '{{ asset('storage/' . $participant['attendance']->photo_path) }}', '{{ $participant['attendance']->status }}', '{{ $participant['attendance']->check_in_time ? Carbon::parse($participant['attendance']->check_in_time)->format('H:i') : '-' }}', '{{ $participant['attendance']->keterangan ?? '' }}')" class="btn-view-photo">
                                <i class="fas fa-image"></i> Lihat Foto
                            </button>
                        @else
                            <span class="no-photo">
                                <i class="fas fa-image"></i> Tidak ada foto
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-clipboard-list"></i>
        <h4>Tidak Ada Data</h4>
        <p>Belum ada data absensi untuk filter yang dipilih</p>
    </div>
    @endif
</div>

{{-- Photo Modal --}}
<div id="photoModal" class="modal-overlay" style="display: none;" x-data="{ show: false }" x-show="show" x-cloak>
    <div class="modal-container" @click.away="show = false">
        <div class="modal-header">
            <h3><i class="fas fa-camera"></i> Foto Absensi - <span id="modalName"></span></h3>
            <button class="modal-close" onclick="closePhotoModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-photo">
                <img id="modalPhoto" src="" alt="Foto Absensi">
            </div>
            <div class="modal-details">
                <div class="detail-item">
                    <label>Status</label>
                    <div class="value" id="modalStatus"></div>
                </div>
                <div class="detail-item">
                    <label>Waktu Check-in</label>
                    <div class="value" id="modalTime"></div>
                </div>
                <div class="detail-item">
                    <label>Keterangan</label>
                    <div class="value" id="modalReason"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" onclick="closePhotoModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const divisionSelect = document.getElementById('division_id');
    const filterForm = document.getElementById('adminAttendanceFilterForm');

    if (divisionSelect && filterForm) {
        divisionSelect.addEventListener('change', function () {
            filterForm.submit();
        });
    }
});

function showPhoto(name, photo, status, time, reason) {
    const modal = document.getElementById('photoModal');
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalPhoto').src = photo;
    document.getElementById('modalTime').textContent = time;
    document.getElementById('modalReason').textContent = reason || '-';

    let statusBadge = '';
    if(status === 'Hadir') {
        statusBadge = '<span class="status-badge hadir"><i class="fas fa-check-circle"></i> Hadir</span>';
    } else if(status === 'Terlambat') {
        statusBadge = '<span class="status-badge terlambat"><i class="fas fa-clock"></i> Terlambat</span>';
    } else {
        statusBadge = '<span class="status-badge absen"><i class="fas fa-times-circle"></i> Absen</span>';
    }
    document.getElementById('modalStatus').innerHTML = statusBadge;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
    const modal = document.getElementById('photoModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePhotoModal();
    }
});

// Close modal when clicking outside
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});
</script>
@endpush
