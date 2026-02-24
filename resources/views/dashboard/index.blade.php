{{--
    PARTICIPANT DASHBOARD
    Main dashboard for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Dashboard Peserta Magang')

@php
    // $user and $application are passed from DashboardController::index()

    // Calculate stats
    $totalAssignments = $user->assignments->count();
    $completedAssignments = $user->assignments->filter(fn($a) => $a->submitted_at && $a->grade)->count();
    $pendingAssignments = $totalAssignments - $completedAssignments;
    $completionRate = $totalAssignments > 0 ? round(($completedAssignments / $totalAssignments) * 100) : 0;

    // Attendance stats (persentase dari controller: absensi / hari kerja magang)
    $attendances = $user->attendances ?? collect();
    $presentCount = $attendances->where('status', 'Hadir')->count();
    $lateCount = $attendances->where('status', 'Terlambat')->count();
    $absentCount = $attendances->where('status', 'Absen')->count();
    $totalAttendance = $presentCount + $lateCount + $absentCount;
    $attendanceRate = $attendanceRate ?? 0;

    // Use values from controller (already calculated with startOfDay() for accuracy)
    $daysRemaining = $hariTersisa;
    $progressPercentage = $progressMagang;

    // Calculate days completed for display
    $daysCompleted = 0;
    $totalDays = 0;
    if ($application && $application->start_date && $application->end_date) {
        $startDate = \Carbon\Carbon::parse($application->start_date)->startOfDay();
        $endDate = \Carbon\Carbon::parse($application->end_date)->startOfDay();
        $today = now()->startOfDay();

        $totalDays = $startDate->diffInDays($endDate);
        $daysCompleted = $startDate->diffInDays($today);

        if ($daysCompleted < 0) $daysCompleted = 0;
        if ($daysCompleted > $totalDays) $daysCompleted = $totalDays;
    }

    // Get greeting based on time
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 17 ? 'Selamat Siang' : 'Selamat Malam');
@endphp

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
/* ============================================
   PARTICIPANT DASHBOARD STYLES
   ============================================ */

/* Hero Section */
.dashboard-hero {
    background: linear-gradient(135deg, var(--color-primary) 0%, #C41E1A 50%, #8B1A18 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.dashboard-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.dashboard-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 40%;
    height: 150%;
    background: radial-gradient(ellipse, rgba(0,0,0,0.1) 0%, transparent 60%);
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

.wave-emoji {
    display: inline-block;
    animation: waveHand 2s ease-in-out infinite;
    transform-origin: 70% 70%;
}

@keyframes waveHand {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    50% { transform: rotate(-10deg); }
    75% { transform: rotate(20deg); }
}

.hero-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 500px;
}

.hero-stats {
    display: flex;
    gap: 1.5rem;
}

.hero-stat {
    text-align: center;
    padding: 1rem 1.5rem;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.2);
    min-width: 100px;
}

.hero-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1.2;
}

.hero-stat-label {
    font-size: 0.75rem;
    opacity: 0.85;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Progress Banner */
.progress-banner {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.progress-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-gray-800);
}

.progress-title i {
    color: var(--color-primary);
}

.progress-percentage {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-primary);
}

.progress-bar-container {
    height: 12px;
    background: var(--color-gray-100);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--color-primary), #FF6B6B);
    border-radius: 10px;
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.progress-bar-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-info {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: var(--color-gray-500);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 1.5rem;
}

@media (max-width: 1024px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

/* Calendar Card */
.calendar-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-gray-800);
}

.card-title-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--color-primary), #FF6B6B);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.calendar-legend {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    color: var(--color-gray-600);
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

/* FullCalendar Customization */
#calendar {
    --fc-border-color: var(--color-gray-100);
    --fc-today-bg-color: rgba(238, 46, 36, 0.05);
    --fc-button-text-color: white;
    --fc-button-bg-color: var(--color-primary);
    --fc-button-border-color: var(--color-primary);
    --fc-button-hover-bg-color: #C41E1A;
    --fc-button-hover-border-color: #C41E1A;
    --fc-button-active-bg-color: #A11A16;
    --fc-button-active-border-color: #A11A16;
}

.fc .fc-button {
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 500;
    font-size: 0.85rem;
}

.fc .fc-toolbar-title {
    font-size: 1.15rem;
    font-weight: 600;
}

.fc-theme-standard td, .fc-theme-standard th {
    border-color: var(--color-gray-100);
}

.fc-daygrid-day-number {
    font-weight: 500;
    color: var(--color-gray-700);
    padding: 8px;
}

.fc-event {
    border-radius: 6px;
    padding: 2px 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Tasks Card */
.tasks-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
    height: fit-content;
}

.card-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--color-primary);
    text-decoration: none;
    transition: all 0.2s;
}

.card-link:hover {
    gap: 0.75rem;
}

.task-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.task-item {
    padding: 1rem 1.25rem;
    background: var(--color-gray-50);
    border-radius: 14px;
    border-left: 4px solid var(--color-warning);
    transition: all 0.3s ease;
}

.task-item:hover {
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transform: translateX(4px);
}

.task-item.completed {
    border-left-color: var(--color-success);
}

.task-item.revision {
    border-left-color: var(--color-danger);
}

.task-item.waiting {
    border-left-color: var(--color-info);
}

.task-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.task-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-gray-800);
    margin: 0;
    flex: 1;
}

.task-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.65rem;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 20px;
    white-space: nowrap;
}

.task-badge i {
    font-size: 0.6rem;
}

.task-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.task-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.task-badge.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.task-badge.info {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.task-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--color-gray-500);
}

.task-meta-item {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.task-meta-item i {
    font-size: 0.7rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2.5rem 1.5rem;
}

.empty-icon {
    width: 64px;
    height: 64px;
    background: var(--color-gray-100);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: var(--color-gray-400);
    font-size: 1.5rem;
}

.empty-text {
    font-size: 0.9rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 2rem;
}

@media (max-width: 1024px) {
    .quick-actions {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .quick-actions {
        grid-template-columns: 1fr;
    }
}

.quick-action-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
}

.quick-action-icon.red { background: linear-gradient(135deg, #EE2E24, #FF6B6B); }
.quick-action-icon.green { background: linear-gradient(135deg, #10B981, #34D399); }
.quick-action-icon.blue { background: linear-gradient(135deg, #3B82F6, #60A5FA); }
.quick-action-icon.purple { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }

.quick-action-text h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-gray-800);
    margin: 0 0 0.25rem 0;
}

.quick-action-text p {
    font-size: 0.8rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* Responsive Hero */
@media (max-width: 900px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-text {
        order: 1;
    }

    .hero-text h1 {
        justify-content: center;
    }

    .hero-text p {
        margin: 0 auto;
    }

    .hero-stats {
        order: 2;
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                {{ $greeting }}, {{ explode(' ', $user->name)[0] }}!
                <span class="wave-emoji">👋</span>
            </h1>
            <p>
                @if($application)
                    Selamat menjalani program magang di <strong>{{ $application->divisionAdmin->division_name ?? $application->divisi->name ?? 'Telkom Indonesia' }}</strong>.
                    Tetap semangat dan raih pengalaman terbaikmu!
                @else
                    Selamat datang di dashboard peserta magang Telkom Indonesia.
                @endif
            </p>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $daysRemaining }}</div>
                <div class="hero-stat-label">Hari Tersisa</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $completionRate }}%</div>
                <div class="hero-stat-label">Tugas Selesai</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-value">{{ $attendanceRate }}%</div>
                <div class="hero-stat-label">Kehadiran</div>
            </div>
        </div>
    </div>
</div>

{{-- Progress Banner --}}
@if($application)
<div class="progress-banner">
    <div class="progress-header">
        <div class="progress-title">
            <i class="fas fa-chart-line"></i>
            <span>Progress Magang</span>
        </div>
        <span class="progress-percentage">{{ $progressPercentage }}%</span>
    </div>
    <div class="progress-bar-container">
        <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%;"></div>
    </div>
    <div class="progress-info">
        <span>{{ $daysCompleted }} hari selesai</span>
        <span>{{ $daysRemaining }} hari lagi</span>
    </div>
</div>
@endif

{{-- Stats Grid --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $totalAssignments,
        'label' => 'Total Tugas',
        'icon' => 'fa-clipboard-list',
        'color' => 'primary',
        'link' => route('dashboard.assignments')
    ])

    @include('components.dashboard.stat-card', [
        'value' => $completedAssignments,
        'label' => 'Tugas Selesai',
        'icon' => 'fa-check-circle',
        'color' => 'success'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $pendingAssignments,
        'label' => 'Tugas Pending',
        'icon' => 'fa-clock',
        'color' => 'warning'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $presentCount + $lateCount,
        'label' => 'Total Kehadiran',
        'icon' => 'fa-calendar-check',
        'color' => 'info',
        'link' => route('attendance.index')
    ])
</div>

{{-- Content Grid: Calendar + Tasks --}}
<div class="content-grid">
    {{-- Calendar --}}
    <div class="calendar-card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span>Kalender Aktivitas</span>
            </div>
            <div class="calendar-legend">
                <span class="legend-item">
                    <span class="legend-dot" style="background: #3B82F6;"></span>
                    Harian
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background: #8B5CF6;"></span>
                    Proyek
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background: #F59E0B;"></span>
                    Presentasi
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background: #10B981;"></span>
                    Selesai
                </span>
            </div>
        </div>
        <div id="calendar"></div>
    </div>

    {{-- Tasks --}}
    <div class="tasks-card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <span>Tugas Terbaru</span>
            </div>
            <a href="{{ route('dashboard.assignments') }}" class="card-link">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="task-list">
            @if($user->assignments->count() > 0)
                @foreach($user->assignments->sortByDesc('created_at')->take(5) as $assignment)
                    @php
                        $isCompleted = $assignment->submitted_at && $assignment->grade;
                        $isRevision = $assignment->is_revision;
                        $isWaiting = $assignment->submitted_at && !$assignment->grade;
                        $statusClass = $isCompleted ? 'completed' : ($isRevision ? 'revision' : ($isWaiting ? 'waiting' : ''));
                    @endphp
                    <div class="task-item {{ $statusClass }}">
                        <div class="task-header">
                            <h6 class="task-title">{{ Str::limit($assignment->description, 45) }}</h6>
                            @if($isCompleted)
                                <span class="task-badge success">
                                    <i class="fas fa-check"></i> Selesai
                                </span>
                            @elseif($isRevision)
                                <span class="task-badge danger">
                                    <i class="fas fa-redo"></i> Revisi
                                </span>
                            @elseif($isWaiting)
                                <span class="task-badge info">
                                    <i class="fas fa-hourglass-half"></i> Menunggu
                                </span>
                            @else
                                <span class="task-badge warning">
                                    <i class="fas fa-exclamation"></i> Pending
                                </span>
                            @endif
                        </div>
                        <div class="task-meta">
                            <span class="task-meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $assignment->created_at->format('d M Y') }}
                            </span>
                            @if($assignment->deadline)
                                <span class="task-meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="empty-text">Belum ada tugas yang diberikan</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <a href="{{ route('attendance.index') }}" class="quick-action-card">
        <div class="quick-action-icon green">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="quick-action-text">
            <h4>Absensi</h4>
            <p>Catat kehadiran harian</p>
        </div>
    </a>

    <a href="{{ route('dashboard.assignments') }}" class="quick-action-card">
        <div class="quick-action-icon red">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="quick-action-text">
            <h4>Tugas</h4>
            <p>Lihat & kerjakan tugas</p>
        </div>
    </a>

    <a href="{{ route('logbook.index') }}" class="quick-action-card">
        <div class="quick-action-icon blue">
            <i class="fas fa-book"></i>
        </div>
        <div class="quick-action-text">
            <h4>Logbook</h4>
            <p>Catatan harian magang</p>
        </div>
    </a>

    <a href="{{ route('dashboard.certificates') }}" class="quick-action-card">
        <div class="quick-action-icon purple">
            <i class="fas fa-award"></i>
        </div>
        <div class="quick-action-text">
            <h4>Sertifikat</h4>
            <p>Unduh sertifikat magang</p>
        </div>
    </a>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar
    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    var events = [];

    @if($application && $application->start_date && $application->end_date)
    events.push({
        title: '',
        start: '{{ $application->start_date }}',
        end: '{{ \Carbon\Carbon::parse($application->end_date)->addDay()->format('Y-m-d') }}',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        borderColor: 'transparent',
        allDay: true,
        display: 'background'
    });

    events.push({
        title: 'Mulai Magang',
        start: '{{ $application->start_date }}',
        backgroundColor: '#10B981',
        borderColor: '#10B981',
        textColor: 'white'
    });

    events.push({
        title: 'Akhir Magang',
        start: '{{ $application->end_date }}',
        backgroundColor: '#EF4444',
        borderColor: '#EF4444',
        textColor: 'white'
    });
    @endif

    @foreach($user->assignments as $assignment)
        @php
            // Color based on status first, then by type
            $isCompleted = $assignment->submitted_at && $assignment->grade;
            if ($isCompleted) {
                $eventColor = '#10B981'; // Green for completed
            } elseif ($assignment->assignment_type === 'tugas_harian') {
                $eventColor = '#3B82F6'; // Blue for daily tasks
            } else {
                $eventColor = '#8B5CF6'; // Purple for project tasks
            }
        @endphp
        events.push({
            title: '{{ addslashes(Str::limit($assignment->title ?? $assignment->description, 25)) }}',
            start: '{{ $assignment->deadline ? $assignment->deadline->format('Y-m-d') : $assignment->created_at->format('Y-m-d') }}',
            backgroundColor: '{{ $eventColor }}',
            borderColor: '{{ $eventColor }}',
            textColor: 'white',
            extendedProps: {
                type: 'assignment'
            }
        });

        @if($assignment->presentation_date)
        events.push({
            title: '📊 Presentasi: {{ addslashes(Str::limit($assignment->title ?? $assignment->description, 20)) }}',
            start: '{{ $assignment->presentation_date->format('Y-m-d') }}',
            backgroundColor: '#F59E0B',
            borderColor: '#F59E0B',
            textColor: 'white',
            extendedProps: {
                type: 'assignment'
            }
        });
        @endif
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
                window.location.href = '{{ route("dashboard.assignments") }}';
            }
        },
        eventMouseEnter: function(info) {
            info.el.style.cursor = 'pointer';
        },
        height: 'auto',
        contentHeight: 480,
        aspectRatio: 1.6
    });

    calendar.render();
});
</script>
@endpush
