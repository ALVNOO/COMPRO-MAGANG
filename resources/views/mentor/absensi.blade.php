{{--
    MENTOR ATTENDANCE PAGE
    Monitor attendance of internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Absensi Peserta Magang')

@php
    $role = 'mentor';
    $pageTitle = 'Absensi Peserta';
    $pageSubtitle = 'Pantau kehadiran peserta magang Anda';

    // Calculate stats
    $totalParticipants = $participants->count();
    $presentCount = 0;
    $lateCount = 0;
    $absentCount = 0;

    foreach($participants as $participant) {
        $todayAttendance = $participant->attendance_history[0] ?? null;
        if($todayAttendance) {
            if($todayAttendance['status'] === 'Hadir') $presentCount++;
            elseif($todayAttendance['status'] === 'Terlambat') $lateCount++;
            elseif($todayAttendance['status'] === 'Absen') $absentCount++;
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   MENTOR ATTENDANCE PAGE STYLES
   ============================================ */

/* Hero Section */
.mentor-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.mentor-hero::before {
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
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
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

/* Alert Styles */
.alert-success-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    color: #16a34a;
    font-weight: 500;
}

.alert-info-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.5rem;
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    color: #2563eb;
    font-weight: 500;
}

/* Filter Card */
.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.filter-row {
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.filter-group label i {
    color: #EE2E24;
}

.filter-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: white;
}

.filter-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.btn-filter {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.stat-icon.purple { background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%); }
.stat-icon.green { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
.stat-icon.yellow { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
.stat-icon.red { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-value.purple { color: #8B5CF6; }
.stat-value.green { color: #22c55e; }
.stat-value.yellow { color: #f59e0b; }
.stat-value.red { color: #ef4444; }

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
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
    gap: 0.75rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
}

.table-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.table-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.attendance-table {
    width: 100%;
    border-collapse: collapse;
}

.attendance-table thead {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
}

.attendance-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.attendance-table th:first-child {
    padding-left: 1.5rem;
}

.attendance-table th:last-child {
    padding-right: 1.5rem;
}

.attendance-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-size: 0.9rem;
    color: #374151;
    vertical-align: middle;
}

.attendance-table td:first-child {
    padding-left: 1.5rem;
}

.attendance-table td:last-child {
    padding-right: 1.5rem;
}

.attendance-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.attendance-table tbody tr:last-child td {
    border-bottom: none;
}

/* Participant Info */
.participant-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.participant-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.participant-details .name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.15rem;
}

.participant-details .nim {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge.present {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.status-badge.late {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

.status-badge.absent {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

.status-badge.not-checked {
    background: rgba(107, 114, 128, 0.15);
    color: #6b7280;
}

/* Check-in Time */
.checkin-time {
    font-weight: 600;
    color: #1f2937;
}

/* History Dots */
.history-dots {
    display: flex;
    gap: 0.35rem;
    justify-content: center;
}

.history-dot {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    color: white;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.history-dot:hover {
    transform: scale(1.1);
}

.history-dot.present { background: #22c55e; }
.history-dot.late { background: #f59e0b; }
.history-dot.absent { background: #ef4444; }
.history-dot.unknown { background: #9ca3af; }

/* Action Button */
.btn-view-photo {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-view-photo:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.btn-view-photo:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Modal Styles */
.modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modal-header-custom {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
}

.modal-header-custom .modal-title {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-header-custom .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body-custom {
    padding: 2rem;
}

.photo-container {
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.photo-container img {
    width: 100%;
    height: auto;
    display: block;
}

.detail-item {
    margin-bottom: 1rem;
}

.detail-item label {
    display: block;
    font-size: 0.8rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.detail-item .value {
    font-weight: 600;
    color: #1f2937;
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .filter-row {
        flex-direction: column;
    }

    .filter-group {
        width: 100%;
    }

    .btn-filter {
        width: 100%;
        justify-content: center;
    }

    .attendance-table {
        font-size: 0.85rem;
    }

    .history-dots {
        flex-wrap: wrap;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="mentor-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-calendar-check"></i> Absensi Peserta Magang</h1>
            <p>Pantau kehadiran peserta magang Anda secara real-time</p>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert-success-custom">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if($participants->isEmpty())
    <div class="alert-info-custom">
        <i class="fas fa-info-circle"></i>
        Belum ada peserta magang yang diterima di divisi Anda.
    </div>
@else
    {{-- Filter Card --}}
    <div class="filter-card">
        <div class="filter-row">
            <div class="filter-group">
                <label><i class="fas fa-calendar"></i> Filter Tanggal</label>
                <input type="date" id="filterDate" class="filter-input"
                       value="{{ $selectedDate ?? today()->toDateString() }}"
                       max="{{ today()->toDateString() }}">
            </div>
            <button onclick="filterByDate()" class="btn-filter">
                <i class="fas fa-filter"></i> Terapkan Filter
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value purple">{{ $totalParticipants }}</div>
            <div class="stat-label">Total Peserta</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-value green">{{ $presentCount }}</div>
            <div class="stat-label">Hadir</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value yellow">{{ $lateCount }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-value red">{{ $absentCount }}</div>
            <div class="stat-label">Absen</div>
        </div>
    </div>

    {{-- Attendance Table --}}
    <div class="table-card">
        <div class="table-header">
            <i class="fas fa-table"></i>
            <h3>Data Kehadiran Peserta</h3>
        </div>
        <div class="table-responsive">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th style="text-align: center;">Status Hari Ini</th>
                        <th style="text-align: center;">Waktu Check-in</th>
                        <th style="text-align: center;">Riwayat 7 Hari</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $participant)
                        @php
                            $todayAttendance = $participant->attendance_history[0] ?? null;
                        @endphp
                        <tr>
                            {{-- Participant Info --}}
                            <td>
                                <div class="participant-info">
                                    <div class="participant-avatar">
                                        {{ strtoupper(substr($participant->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="participant-details">
                                        <div class="name">{{ $participant->user->name ?? '-' }}</div>
                                        <div class="nim">{{ $participant->user->nim ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Status Today --}}
                            <td style="text-align: center;">
                                @if($todayAttendance)
                                    @if($todayAttendance['status'] === 'Hadir')
                                        <span class="status-badge present">
                                            <i class="fas fa-check-circle"></i> Hadir
                                        </span>
                                    @elseif($todayAttendance['status'] === 'Terlambat')
                                        <span class="status-badge late">
                                            <i class="fas fa-clock"></i> Terlambat
                                        </span>
                                    @else
                                        <span class="status-badge absent">
                                            <i class="fas fa-times-circle"></i> Absen
                                        </span>
                                    @endif
                                @else
                                    <span class="status-badge not-checked">
                                        <i class="fas fa-minus-circle"></i> Belum Absen
                                    </span>
                                @endif
                            </td>

                            {{-- Check-in Time --}}
                            <td style="text-align: center;">
                                <span class="checkin-time">
                                    {{ $todayAttendance ? \Carbon\Carbon::parse($todayAttendance['check_in_time'])->format('H:i') : '-' }}
                                </span>
                            </td>

                            {{-- 7-Day History --}}
                            <td>
                                <div class="history-dots">
                                    @foreach($participant->attendance_history as $history)
                                        @php
                                            $dotClass = 'unknown';
                                            $icon = 'question';
                                            $tooltip = $history['date'];

                                            if($history['status'] === 'Hadir') {
                                                $dotClass = 'present';
                                                $icon = 'check';
                                                $tooltip .= ' - Hadir';
                                            } elseif($history['status'] === 'Terlambat') {
                                                $dotClass = 'late';
                                                $icon = 'clock';
                                                $tooltip .= ' - Terlambat';
                                            } elseif($history['status'] === 'Absen') {
                                                $dotClass = 'absent';
                                                $icon = 'times';
                                                $tooltip .= ' - Absen';
                                            }
                                        @endphp
                                        <div class="history-dot {{ $dotClass }}" title="{{ $tooltip }}" data-bs-toggle="tooltip">
                                            <i class="fas fa-{{ $icon }}"></i>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td style="text-align: center;">
                                @if($todayAttendance && $todayAttendance['photo_path'])
                                    <button onclick="showPhoto('{{ $participant->user->name }}', '{{ asset('storage/' . $todayAttendance['photo_path']) }}', '{{ $todayAttendance['status'] }}', '{{ \Carbon\Carbon::parse($todayAttendance['check_in_time'])->format('H:i') }}', '{{ $todayAttendance['keterangan'] ?? '' }}')" class="btn-view-photo">
                                        <i class="fas fa-image"></i> Lihat Foto
                                    </button>
                                @else
                                    <button class="btn-view-photo" disabled>
                                        <i class="fas fa-image"></i> Tidak Ada
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- Photo Modal --}}
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">
                    <i class="fas fa-camera"></i>
                    Foto Absensi - <span id="modalName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body modal-body-custom">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <div class="photo-container">
                            <img id="modalPhoto" src="" alt="Foto Absensi">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h6 style="font-weight: 600; color: #1f2937; margin-bottom: 1.5rem;">Detail Absensi</h6>
                        <div class="detail-item">
                            <label>Status</label>
                            <div id="modalStatus"></div>
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
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Filter by date
function filterByDate() {
    const date = document.getElementById('filterDate').value;
    if(date) {
        window.location.href = "{{ route('mentor.absensi') }}?date=" + date;
    }
}

// Show photo modal
function showPhoto(name, photo, status, time, reason) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalPhoto').src = photo;
    document.getElementById('modalTime').textContent = time;
    document.getElementById('modalReason').textContent = reason || '-';

    // Set status badge
    let statusBadge = '';
    if(status === 'Hadir') {
        statusBadge = '<span class="status-badge present"><i class="fas fa-check-circle"></i> Hadir</span>';
    } else if(status === 'Terlambat') {
        statusBadge = '<span class="status-badge late"><i class="fas fa-clock"></i> Terlambat</span>';
    } else {
        statusBadge = '<span class="status-badge absent"><i class="fas fa-times-circle"></i> Absen</span>';
    }
    document.getElementById('modalStatus').innerHTML = statusBadge;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
