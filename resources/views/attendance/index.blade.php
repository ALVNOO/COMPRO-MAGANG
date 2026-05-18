{{--
    USER ATTENDANCE PAGE
    Attendance tracking for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Absensi Magang')

@php
    $role = 'participant';
    $pageTitle = 'Absensi';

    $totalAttendance = $attendanceHistory->count();
    $hadirCount = $attendanceHistory->where('status', 'Hadir')->count();
    $terlambatCount = $attendanceHistory->where('status', 'Terlambat')->count();
    $absenCount = $attendanceHistory->where('status', 'Absen')->count();
    $attendanceRate = $totalAttendance > 0 ? round((($hadirCount + $terlambatCount) / $totalAttendance) * 100) : 0;

    $attBadgeMap = ['hadir' => 'badge-success', 'terlambat' => 'badge-warning', 'absen' => 'badge-danger'];
    $attIconMap  = ['hadir' => 'fa-check-circle', 'terlambat' => 'fa-clock', 'absen' => 'fa-times-circle'];
@endphp

@push('styles')
<style>
/* ============================================
   ATTENDANCE PAGE STYLES
   ============================================ */

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}


/* Today Card */
.today-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: all 0.3s ease;
    animation: slide-up 0.6s ease-out;
}

.today-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.today-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.today-card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.today-card-body {
    padding: 2rem;
}

.today-status {
    text-align: center;
    padding: 1rem 0;
}

.status-badge-large {
    font-size: 1rem;
    padding: 0.75rem 1.5rem;
    margin-bottom: 1rem;
}

.checkin-time {
    font-size: 0.95rem;
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.checkin-photo {
    width: 200px;
    height: 200px;
    border-radius: 20px;
    object-fit: cover;
    border: 4px solid #10B981;
    margin-top: 1rem;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
}

.checkin-photo:hover {
    transform: scale(1.05) rotate(2deg);
    box-shadow: 0 12px 32px rgba(16, 185, 129, 0.4);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.btn-checkin {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-checkin::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-checkin:hover::before {
    width: 300px;
    height: 300px;
}

.btn-checkin:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.5);
    color: white;
}

.btn-checkin:active {
    transform: translateY(-1px) scale(1.02);
}

.btn-absent {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: linear-gradient(135deg, #EF4444, #DC2626);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-absent::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-absent:hover::before {
    width: 300px;
    height: 300px;
}

.btn-absent:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.5);
    color: white;
}

.btn-absent:active {
    transform: translateY(-1px) scale(1.02);
}

.table-card-header .badge-count {
    background: rgba(238, 46, 36, 0.1);
    color: #EE2E24;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.attendance-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.attendance-table thead th {
    background: #f9fafb;
    padding: 0.875rem 1.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.attendance-table tbody td {
    padding: 1rem 1.5rem;
    font-size: 0.9rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.attendance-table tbody tr {
    transition: background-color 0.2s;
}

.attendance-table tbody tr:hover {
    background-color: rgba(238, 46, 36, 0.03);
}

.attendance-table tbody tr:last-child td {
    border-bottom: none;
}


.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem;
    color: #9ca3af;
}

.empty-state h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-weight: 600;
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    padding: 1rem 1.5rem;
}

/* Camera Styles */
#cameraPreview {
    width: 100%;
    max-width: 480px;
    border-radius: 16px;
    margin: 1rem auto;
    display: block;
    background: #000;
}

#capturedPhoto {
    width: 100%;
    max-width: 480px;
    border-radius: 16px;
    margin: 1rem auto;
    display: none;
}

.camera-controls {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    margin-top: 1rem;
}

.btn-capture {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-capture:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-retake {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-retake:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

.btn-open-camera {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
}

.btn-open-camera:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.35);
}

.info-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 12px;
    margin-top: 1rem;
}

.info-alert i {
    color: #3b82f6;
    font-size: 1.1rem;
    margin-top: 0.1rem;
}

.info-alert p {
    font-size: 0.85rem;
    color: #374151;
    margin: 0;
    line-height: 1.5;
}

/* Attendance Type Selector */
.attendance-type-selector {
    display: flex;
    gap: 1rem;
    justify-content: center;
    max-width: 600px;
    margin: 0 auto;
}

.type-btn {
    flex: 1;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    padding: 1.25rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
}

.type-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
    opacity: 0;
    transition: opacity 0.3s;
}

.type-btn:hover::before {
    opacity: 1;
}

.type-btn i {
    font-size: 2rem;
    color: #6b7280;
    transition: all 0.3s;
}

.type-btn span {
    font-weight: 600;
    font-size: 1rem;
    color: #374151;
    transition: color 0.3s;
}

.type-btn small {
    font-size: 0.8rem;
    color: #9ca3af;
    text-align: center;
}

.type-btn:hover {
    border-color: #10B981;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
}

.type-btn:hover i {
    color: #10B981;
    transform: scale(1.1);
}

.type-btn:hover span {
    color: #10B981;
}

.type-btn.active {
    border-color: #10B981;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
}

.type-btn.active i {
    color: #10B981;
}

.type-btn.active span {
    color: #10B981;
}

.type-btn[data-type="absent"]:hover {
    border-color: #EF4444;
}

.type-btn[data-type="absent"].active {
    border-color: #EF4444;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
    box-shadow: 0 4px 20px rgba(239, 68, 68, 0.2);
}

.type-btn[data-type="absent"]:hover i,
.type-btn[data-type="absent"].active i {
    color: #EF4444;
}

.type-btn[data-type="absent"]:hover span,
.type-btn[data-type="absent"].active span {
    color: #EF4444;
}

.type-btn[data-type="absent"]:hover {
    box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
}

/* Attendance Form Section */
.attendance-form-section {
    max-width: 600px;
    margin: 0 auto;
    animation: fade-in-up 0.4s ease-out;
}

.form-content {
    background: rgba(249, 250, 251, 0.5);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce-in {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes pulse-icon {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

@keyframes rotating-slow {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-up {
    animation: slide-up 0.8s ease-out 0.2s both;
}

.animate-bounce-in {
    animation: bounce-in 0.8s ease-out 0.4s both;
}

.pulse-icon {
    display: inline-block;
    animation: pulse-icon 2s ease-in-out infinite;
}

.rotating-slow {
    display: inline-block;
    animation: rotating-slow 20s linear infinite;
}

.time-display {
    font-family: 'Courier New', monospace;
    letter-spacing: 0.05em;
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .attendance-type-selector {
        flex-direction: column;
        gap: 0.75rem;
    }

    .type-btn {
        padding: 1rem;
    }

    .type-btn i {
        font-size: 1.5rem;
    }

    .attendance-table thead th,
    .attendance-table tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
    }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Absensi Magang"
    description="Catat kehadiran harian Anda di PT Telkom Indonesia"
    icon="fas fa-calendar-check"
    role="peserta"
/>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card stat-card-info">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $totalAttendance }}</div>
                <div class="stat-label">Total Kehadiran</div>
            </div>
            <div class="stat-icon stat-icon-info">
                <i class="fas fa-calendar-days"></i>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $hadirCount }}</div>
                <div class="stat-label">Hadir Tepat Waktu</div>
            </div>
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-warning">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $terlambatCount }}</div>
                <div class="stat-label">Terlambat</div>
            </div>
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-primary">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $attendanceRate }}%</div>
                <div class="stat-label">Tingkat Kehadiran</div>
            </div>
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
</div>

{{-- Today's Attendance Card --}}
<div class="today-card">
    <div class="today-card-header">
        <h3>
            <i class="fas fa-calendar-day" style="color: #EE2E24;"></i>
            Absensi Hari Ini
        </h3>
        <span style="font-size: 0.85rem; color: #6b7280;">
            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </span>
    </div>
    <div class="today-card-body">
        @if($todayAttendance)
            <div class="today-status">
                @php
                    $attBadge = $attBadgeMap[strtolower($todayAttendance->status)] ?? 'badge-danger';
                    $attIcon  = $attIconMap[strtolower($todayAttendance->status)] ?? 'fa-times-circle';
                @endphp
                <div class="badge {{ $attBadge }} status-badge-large">
                    <i class="fas {{ $attIcon }}"></i>
                    {{ $todayAttendance->status }}
                </div>

                @if($todayAttendance->check_in_time)
                    <div class="checkin-time">
                        <i class="fas fa-clock" style="color: #EE2E24;"></i>
                        <strong>Check In:</strong> {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i:s') }}
                    </div>
                @endif

                @if($todayAttendance->photo_path)
                    <img src="{{ Storage::url($todayAttendance->photo_path) }}" alt="Foto Check In" class="checkin-photo">
                @endif

                @if($todayAttendance->latitude && $todayAttendance->longitude)
                    <div style="margin-top:.75rem;">
                        <a href="https://www.google.com/maps?q={{ $todayAttendance->latitude }},{{ $todayAttendance->longitude }}"
                           target="_blank" rel="noopener"
                           style="display:inline-flex;align-items:center;gap:.4rem;padding:.45rem 1rem;background:rgba(59,130,246,.08);border:1px solid rgba(59,130,246,.25);border-radius:8px;font-size:.82rem;font-weight:600;color:#3b82f6;text-decoration:none;">
                            <i class="fas fa-map-marker-alt"></i> Lihat Lokasi di Maps
                        </a>
                    </div>
                @endif

                @if($todayAttendance->absence_reason)
                    <div style="margin-top: 1rem; padding: 1rem; background: rgba(239, 68, 68, 0.05); border-radius: 12px; max-width: 500px; margin-left: auto; margin-right: auto;">
                        <p style="font-size: 0.85rem; color: #6b7280; margin: 0 0 0.25rem;"><strong>Alasan Absen:</strong></p>
                        <p style="font-size: 0.9rem; color: #374151; margin: 0;">{{ $todayAttendance->absence_reason }}</p>
                    </div>
                @endif

                <p style="color: #9ca3af; margin-top: 1.5rem; font-size: 0.9rem;">
                    <i class="fas fa-info-circle"></i> Anda sudah melakukan absensi hari ini.
                </p>
            </div>
        @else
            <div class="today-status">
                <div class="empty-state-icon" style="margin-bottom: 1rem;">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <h4 style="font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Belum Absensi</h4>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Pilih jenis absensi Anda hari ini</p>

                {{-- Attendance Type Selection --}}
                <div class="attendance-type-selector" style="margin-bottom: 1.5rem;">
                    <button type="button" class="type-btn active" data-type="checkin" id="selectCheckinBtn">
                        <i class="fas fa-camera"></i>
                        <span>Check In</span>
                        <small>Hadir dengan foto selfie</small>
                    </button>
                    <button type="button" class="type-btn" data-type="absent" id="selectAbsentBtn">
                        <i class="fas fa-file-alt"></i>
                        <span>Izin / Absen</span>
                        <small>Tidak dapat hadir</small>
                    </button>
                </div>

                {{-- Check In Form --}}
                <div id="checkinSection" class="attendance-form-section">
                    <form action="{{ route('attendance.check-in') }}" method="POST" enctype="multipart/form-data" id="checkInForm">
                        @csrf
                        <input type="hidden" name="latitude"  id="latInput">
                        <input type="hidden" name="longitude" id="lngInput">
                        <div class="form-content">
                            <label style="font-weight: 600; color: #374151; margin-bottom: 0.75rem; display: block; text-align: center;">
                                <i class="fas fa-camera" style="color: #10B981;"></i> Ambil Foto Selfie
                            </label>

                            {{-- Location status indicator --}}
                            <div id="locationStatus" style="display:flex;align-items:center;gap:.5rem;justify-content:center;margin-bottom:.75rem;font-size:.82rem;color:#6b7280;">
                                <i class="fas fa-circle-notch fa-spin" style="color:#3b82f6;"></i>
                                <span id="locationText">Mendeteksi lokasi…</span>
                            </div>

                            <video id="cameraPreview" autoplay playsinline style="display: none;"></video>
                            <img id="capturedPhoto" alt="Captured Photo">
                            <input type="file" id="photo" name="photo" accept="image/*" required style="display: none;">

                            <div id="cameraControls" class="camera-controls" style="display: none;">
                                <button type="button" class="btn-capture" id="captureBtn">
                                    <i class="fas fa-camera"></i> Ambil Foto
                                </button>
                                <button type="button" class="btn-retake" id="stopCameraBtn">
                                    <i class="fas fa-stop"></i> Batal
                                </button>
                            </div>

                            <div id="photoControls" class="camera-controls" style="display: none;">
                                <button type="button" class="btn-retake" id="retakeBtn">
                                    <i class="fas fa-redo"></i> Ambil Ulang
                                </button>
                            </div>

                            <div id="startCameraSection" style="text-align: center;">
                                <button type="button" class="btn-open-camera" id="startCameraBtn">
                                    <i class="fas fa-camera"></i> Buka Kamera
                                </button>
                            </div>

                            <div class="info-alert" style="margin-top: 1rem;">
                                <i class="fas fa-info-circle"></i>
                                <p>Check in setelah <strong>08:00</strong> akan ditandai sebagai <strong>"Terlambat"</strong>.</p>
                            </div>

                            <div style="text-align: center; margin-top: 1.5rem;">
                                <button type="submit" class="btn-checkin" id="submitCheckinBtn" disabled>
                                    <i class="fas fa-check"></i> Submit Check In
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Absent Form --}}
                <div id="absentSection" class="attendance-form-section" style="display: none;">
                    <form action="{{ route('attendance.absent') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-content">
                            <div class="mb-3">
                                <label for="reason" style="font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block;">
                                    <i class="fas fa-file-alt" style="color: #EF4444;"></i> Alasan Absen <span style="color: #EF4444;">*</span>
                                </label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" required
                                          placeholder="Jelaskan alasan Anda tidak dapat hadir hari ini..."
                                          style="border-radius: 12px; border: 1px solid #d1d5db; padding: 0.75rem 1rem;"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="proof" style="font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block;">
                                    <i class="fas fa-paperclip"></i> Bukti (Opsional)
                                </label>
                                <input type="file" class="form-control" id="proof" name="proof" accept=".pdf,.jpg,.jpeg,.png"
                                       style="border-radius: 12px; border: 1px solid #d1d5db; padding: 0.5rem 0.75rem;">
                                <small style="display: block; margin-top: 0.5rem; color: #6b7280; font-size: 0.8rem;">
                                    Format: PDF, JPG, PNG. Maksimal 2MB
                                </small>
                            </div>

                            <div style="text-align: center; margin-top: 1.5rem;">
                                <button type="submit" class="btn-absent">
                                    <i class="fas fa-paper-plane"></i> Submit Absen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Attendance History Table --}}
<div class="table-card">
    <div class="table-card-header">
        <h3>
            <i class="fas fa-history" style="color: #EE2E24;"></i>
            Riwayat Absensi
        </h3>
        <span class="badge-count">30 Hari Terakhir</span>
    </div>

    @if($attendanceHistory->count() > 0)
        <div style="overflow-x: auto;">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Waktu Check In</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceHistory as $attendance)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($attendance->date)->locale('id')->isoFormat('D MMMM Y') }}</strong>
                        </td>
                        <td>
                            @php
                                $histBadge = $attBadgeMap[strtolower($attendance->status)] ?? 'badge-danger';
                                $histIcon = $attIconMap[strtolower($attendance->status)] ?? 'fa-times-circle';
                            @endphp
                            <span class="badge {{ $histBadge }}">
                                <i class="fas {{ $histIcon }}"></i>
                                {{ $attendance->status }}
                            </span>
                        </td>
                        <td>
                            @if($attendance->check_in_time)
                                {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') }}
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->latitude && $attendance->longitude)
                                <a href="https://www.google.com/maps?q={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                   target="_blank" rel="noopener"
                                   style="display:inline-flex;align-items:center;gap:.3rem;font-size:.8rem;color:#3b82f6;font-weight:600;text-decoration:none;">
                                    <i class="fas fa-map-marker-alt"></i> Maps
                                </a>
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->absence_reason)
                                {{ Str::limit($attendance->absence_reason, 50) }}
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-calendar-xmark"></i>
            </div>
            <h4>Belum Ada Riwayat</h4>
            <p>Riwayat absensi akan muncul setelah Anda melakukan check-in pertama kali.</p>
        </div>
    @endif
</div>


@endsection

@push('scripts')
<script>
    // ── Geolocation ──
    (function() {
        const latInput  = document.getElementById('latInput');
        const lngInput  = document.getElementById('lngInput');
        const locStatus = document.getElementById('locationStatus');
        const locText   = document.getElementById('locationText');
        if (!latInput || !locStatus) return;

        function setStatus(icon, color, text) {
            locStatus.innerHTML = `<i class="${icon}" style="color:${color};"></i><span>${text}</span>`;
        }

        if (!navigator.geolocation) {
            setStatus('fas fa-map-marker-alt', '#9ca3af', 'Lokasi tidak didukung browser ini');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                latInput.value = pos.coords.latitude;
                lngInput.value = pos.coords.longitude;
                setStatus('fas fa-map-marker-alt', '#10B981', 'Lokasi terdeteksi ✓');
            },
            function(err) {
                if (err.code === 1) {
                    setStatus('fas fa-map-marker-slash', '#f59e0b', 'Izin lokasi ditolak — absensi tetap dapat dilakukan');
                } else {
                    setStatus('fas fa-map-marker-alt', '#9ca3af', 'Lokasi tidak dapat dideteksi');
                }
            },
            { timeout: 10000, maximumAge: 60000 }
        );
    })();

    // Type Selection
    const selectCheckinBtn = document.getElementById('selectCheckinBtn');
    const selectAbsentBtn = document.getElementById('selectAbsentBtn');
    const checkinSection = document.getElementById('checkinSection');
    const absentSection = document.getElementById('absentSection');

    if (selectCheckinBtn && selectAbsentBtn) {
        selectCheckinBtn.addEventListener('click', function() {
            selectCheckinBtn.classList.add('active');
            selectAbsentBtn.classList.remove('active');
            checkinSection.style.display = 'block';
            absentSection.style.display = 'none';
        });

        selectAbsentBtn.addEventListener('click', function() {
            selectAbsentBtn.classList.add('active');
            selectCheckinBtn.classList.remove('active');
            absentSection.style.display = 'block';
            checkinSection.style.display = 'none';

            // Stop camera if running
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            resetCameraUI();
        });
    }

    // Camera functionality
    let stream = null;
    let canvas = null;

    const startCameraBtn = document.getElementById('startCameraBtn');
    const cameraPreview = document.getElementById('cameraPreview');
    const capturedPhoto = document.getElementById('capturedPhoto');
    const cameraControls = document.getElementById('cameraControls');
    const photoControls = document.getElementById('photoControls');
    const startCameraSection = document.getElementById('startCameraSection');
    const captureBtn = document.getElementById('captureBtn');
    const retakeBtn = document.getElementById('retakeBtn');
    const stopCameraBtn = document.getElementById('stopCameraBtn');
    const photoInput = document.getElementById('photo');
    const submitCheckinBtn = document.getElementById('submitCheckinBtn');

    function resetCameraUI() {
        if (cameraPreview) cameraPreview.style.display = 'none';
        if (cameraControls) cameraControls.style.display = 'none';
        if (photoControls) photoControls.style.display = 'none';
        if (capturedPhoto) capturedPhoto.style.display = 'none';
        if (startCameraSection) startCameraSection.style.display = 'block';
        if (submitCheckinBtn) submitCheckinBtn.disabled = true;
        if (photoInput) photoInput.value = '';
    }

    if (startCameraBtn) {
        startCameraBtn.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });

                cameraPreview.srcObject = stream;
                cameraPreview.style.display = 'block';
                cameraControls.style.display = 'flex';
                startCameraSection.style.display = 'none';
                capturedPhoto.style.display = 'none';
                photoControls.style.display = 'none';
            } catch (error) {
                console.error('Error accessing camera:', error);
                alert('Tidak dapat mengakses kamera. Pastikan Anda memberikan izin akses kamera dan menggunakan browser yang mendukung.');
            }
        });
    }

    if (captureBtn) {
        captureBtn.addEventListener('click', function() {
            canvas = document.createElement('canvas');
            canvas.width = cameraPreview.videoWidth;
            canvas.height = cameraPreview.videoHeight;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(cameraPreview, 0, 0);

            canvas.toBlob(function(blob) {
                const file = new File([blob], 'selfie.jpg', { type: 'image/jpeg' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                photoInput.files = dataTransfer.files;

                capturedPhoto.src = canvas.toDataURL('image/jpeg');
                capturedPhoto.style.display = 'block';

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }

                cameraPreview.style.display = 'none';
                cameraControls.style.display = 'none';
                photoControls.style.display = 'flex';
                submitCheckinBtn.disabled = false;
            }, 'image/jpeg', 0.9);
        });
    }

    if (retakeBtn) {
        retakeBtn.addEventListener('click', function() {
            resetCameraUI();
        });
    }

    if (stopCameraBtn) {
        stopCameraBtn.addEventListener('click', function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            resetCameraUI();
        });
    }
</script>
@endpush
