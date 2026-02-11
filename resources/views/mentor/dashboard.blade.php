{{--
    MENTOR DASHBOARD
    Main dashboard for field mentors - Redesigned with Unified Layout System

    Required variables:
    - $tugasBaruDiupload: New assignments uploaded
    - $activeParticipants: Active participants count
    - $totalAssignments: Total assignments
    - $completedAssignments: Completed assignments
    - $assignmentsToGrade: Assignments pending grading
    - $averageGrade: Average grade
    - $completionRate: Completion rate percentage
    - $attendanceStats: Array with 'present', 'late', 'absent' keys
    - $recentSubmissions: Recent submissions collection
    - $participantCompletionData: Data for bar chart
    - $completionDistributionData: Data for doughnut chart
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Dashboard Pembimbing Lapangan')
@section('page-title', 'Dashboard Pembimbing')
@section('breadcrumb', 'Dashboard')

@php
    $role = 'mentor';
@endphp

@push('styles')
<style>
/* ============================================
   MENTOR DASHBOARD STYLES
   ============================================ */

/* Hero Section */
.mentor-hero {
    background: linear-gradient(135deg, #10B981 0%, #059669 50%, #047857 100%);
    border-radius: 24px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
}

.mentor-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
    animation: heroGlow 15s ease-in-out infinite;
}

.mentor-hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
    opacity: 0.4;
}

@keyframes heroGlow {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.1) rotate(10deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: center;
}

.hero-text h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.hero-text p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 1rem;
}

.hero-date {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
    opacity: 0.85;
}

.hero-date i {
    font-size: 1.1rem;
}

.hero-illustration {
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    backdrop-filter: blur(10px);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(3deg); }
}

/* Alert Banner */
.alert-banner {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(251, 191, 36, 0.1) 100%);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-left: 4px solid #F59E0B;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    animation: slideDown 0.5s ease-out;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #F59E0B, #D97706);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #92400E;
    margin: 0 0 0.25rem 0;
}

.alert-content p {
    font-size: 0.85rem;
    color: #A16207;
    margin: 0;
}

.alert-action {
    padding: 0.5rem 1rem;
    background: #F59E0B;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s;
}

.alert-action:hover {
    background: #D97706;
    transform: translateY(-2px);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.stat-card.green::before { background: linear-gradient(90deg, #10B981, #34D399); }
.stat-card.blue::before { background: linear-gradient(90deg, #3B82F6, #60A5FA); }
.stat-card.amber::before { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
.stat-card.purple::before { background: linear-gradient(90deg, #8B5CF6, #A78BFA); }
.stat-card.cyan::before { background: linear-gradient(90deg, #06B6D4, #22D3EE); }
.stat-card.red::before { background: linear-gradient(90deg, #EF4444, #F87171); }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.stat-card.has-pending {
    animation: attentionPulse 2s ease-in-out infinite;
}

@keyframes attentionPulse {
    0%, 100% { box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2); }
    50% { box-shadow: 0 4px 20px rgba(245, 158, 11, 0.4); }
}

.stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon.green { background: rgba(16, 185, 129, 0.15); color: #059669; }
.stat-icon.blue { background: rgba(59, 130, 246, 0.15); color: #2563EB; }
.stat-icon.amber { background: rgba(245, 158, 11, 0.15); color: #D97706; }
.stat-icon.purple { background: rgba(139, 92, 246, 0.15); color: #7C3AED; }
.stat-icon.cyan { background: rgba(6, 182, 212, 0.15); color: #0891B2; }
.stat-icon.red { background: rgba(239, 68, 68, 0.15); color: #DC2626; }

.stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    background: var(--color-gray-100);
    color: var(--color-gray-600);
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-gray-900);
    line-height: 1.2;
}

.stat-desc {
    font-size: 0.85rem;
    color: var(--color-gray-500);
    margin-top: 0.25rem;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .quick-actions {
        grid-template-columns: 1fr;
    }
}

.quick-action-btn {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: var(--color-gray-900);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.quick-action-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    background: white;
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.quick-action-icon.green { background: linear-gradient(135deg, #10B981, #059669); color: white; }
.quick-action-icon.blue { background: linear-gradient(135deg, #3B82F6, #2563EB); color: white; }
.quick-action-icon.purple { background: linear-gradient(135deg, #8B5CF6, #7C3AED); color: white; }
.quick-action-icon.amber { background: linear-gradient(135deg, #F59E0B, #D97706); color: white; }

.quick-action-content h4 {
    font-size: 0.95rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.quick-action-content p {
    font-size: 0.8rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* Charts Section */
.charts-section {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .charts-section {
        grid-template-columns: 1fr;
    }
}

.chart-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s;
}

.chart-card:hover {
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
}

.chart-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.chart-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #10B981, #059669);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.chart-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0;
}

.chart-body {
    position: relative;
    min-height: 280px;
}

.chart-loading {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.9);
    z-index: 10;
}

.chart-loading.active {
    display: flex;
}

.chart-loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid var(--color-gray-200);
    border-top-color: #10B981;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Activity Section */
.activity-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .activity-section {
        grid-template-columns: 1fr;
    }
}

.activity-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    padding: 1.5rem;
}

.activity-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.activity-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.activity-header-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #10B981, #059669);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.activity-header-title h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0 0 0.15rem 0;
}

.activity-header-title p {
    font-size: 0.8rem;
    color: var(--color-gray-500);
    margin: 0;
}

.live-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.75rem;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 20px;
}

.live-dot {
    width: 8px;
    height: 8px;
    background: #10B981;
    border-radius: 50%;
    animation: livePulse 2s ease-in-out infinite;
}

@keyframes livePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

.live-text {
    font-size: 0.75rem;
    font-weight: 600;
    color: #059669;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.activity-body {
    max-height: 400px;
    overflow-y: auto;
}

.activity-body::-webkit-scrollbar {
    width: 4px;
}

.activity-body::-webkit-scrollbar-thumb {
    background: var(--color-gray-300);
    border-radius: 4px;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 0.5rem;
    transition: all 0.2s;
}

.activity-item:hover {
    background: var(--color-gray-50);
}

.activity-item.new {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(16, 185, 129, 0.02));
    border-left: 3px solid #10B981;
}

.activity-avatar {
    width: 40px;
    height: 40px;
    background: var(--color-gray-100);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-gray-500);
    font-size: 1rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-gray-900);
    margin: 0 0 0.25rem 0;
}

.activity-desc {
    font-size: 0.85rem;
    color: var(--color-gray-600);
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--color-gray-400);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.activity-time i {
    font-size: 0.7rem;
}

.activity-badge {
    padding: 0.25rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 6px;
    white-space: nowrap;
}

.activity-badge.graded {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.activity-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
}

.activity-empty {
    text-align: center;
    padding: 2rem;
}

.activity-empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    background: var(--color-gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-gray-400);
    font-size: 1.5rem;
}

.activity-empty p {
    color: var(--color-gray-500);
    font-size: 0.9rem;
    margin: 0;
}

/* Attendance Card */
.attendance-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.attendance-item {
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    background: var(--color-gray-50);
}

.attendance-item.present { background: rgba(16, 185, 129, 0.1); }
.attendance-item.late { background: rgba(245, 158, 11, 0.1); }
.attendance-item.absent { background: rgba(239, 68, 68, 0.1); }

.attendance-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.attendance-item.present .attendance-value { color: #059669; }
.attendance-item.late .attendance-value { color: #D97706; }
.attendance-item.absent .attendance-value { color: #DC2626; }

.attendance-label {
    font-size: 0.8rem;
    color: var(--color-gray-600);
}

/* Responsive */
@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-content {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .hero-text h1 {
        font-size: 1.5rem;
    }

    .hero-illustration {
        display: none;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .charts-section,
    .activity-section {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="mentor-hero" data-aos="fade-down">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p>Panel Pembimbing Lapangan - PT Telkom Indonesia</p>
            <div class="hero-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
        </div>
        <div class="hero-illustration">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
    </div>
</div>

{{-- Alert Notification (if there are assignments to grade) --}}
@if($assignmentsToGrade > 0)
<div class="alert-banner" data-aos="fade-up">
    <div class="alert-icon">
        <i class="fas fa-clipboard-check"></i>
    </div>
    <div class="alert-content">
        <h4>Ada {{ $assignmentsToGrade }} Tugas Menunggu Penilaian!</h4>
        <p>Segera berikan penilaian untuk submission tugas dari peserta magang.</p>
    </div>
    <a href="{{ route('mentor.penugasan') }}" class="alert-action">
        <i class="fas fa-arrow-right"></i> Lihat Tugas
    </a>
</div>
@endif

{{-- Stats Grid --}}
<div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
    {{-- Active Participants --}}
    <div class="stat-card green">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <span class="stat-label">Aktif</span>
        </div>
        <div class="stat-value" data-count="{{ $activeParticipants }}">{{ $activeParticipants }}</div>
        <div class="stat-desc">Peserta Aktif</div>
    </div>

    {{-- Total Assignments --}}
    <div class="stat-card blue">
        <div class="stat-header">
            <div class="stat-icon blue">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-value" data-count="{{ $totalAssignments }}">{{ $totalAssignments }}</div>
        <div class="stat-desc">Total Tugas</div>
    </div>

    {{-- Completed Assignments --}}
    <div class="stat-card green">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <span class="stat-label">Selesai</span>
        </div>
        <div class="stat-value" data-count="{{ $completedAssignments }}">{{ $completedAssignments }}</div>
        <div class="stat-desc">Tugas Selesai</div>
    </div>

    {{-- Assignments to Grade --}}
    <div class="stat-card amber {{ $assignmentsToGrade > 0 ? 'has-pending' : '' }}">
        <div class="stat-header">
            <div class="stat-icon amber">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-value" data-count="{{ $assignmentsToGrade }}">{{ $assignmentsToGrade }}</div>
        <div class="stat-desc">Perlu Dinilai</div>
    </div>

    {{-- Average Grade --}}
    <div class="stat-card purple">
        <div class="stat-header">
            <div class="stat-icon purple">
                <i class="fas fa-star"></i>
            </div>
            <span class="stat-label">Rata-rata</span>
        </div>
        <div class="stat-value">{{ number_format($averageGrade, 1) }}</div>
        <div class="stat-desc">Nilai Rata-Rata</div>
    </div>

    {{-- Completion Rate --}}
    <div class="stat-card cyan">
        <div class="stat-header">
            <div class="stat-icon cyan">
                <i class="fas fa-chart-line"></i>
            </div>
            <span class="stat-label">Rate</span>
        </div>
        <div class="stat-value">{{ number_format($completionRate, 0) }}%</div>
        <div class="stat-desc">Tingkat Penyelesaian</div>
    </div>

    {{-- Present Today --}}
    <div class="stat-card green">
        <div class="stat-header">
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
            <span class="stat-label">Hari Ini</span>
        </div>
        <div class="stat-value" data-count="{{ $attendanceStats['present'] ?? 0 }}">{{ $attendanceStats['present'] ?? 0 }}</div>
        <div class="stat-desc">Hadir Hari Ini</div>
    </div>

    {{-- Late/Absent --}}
    <div class="stat-card amber {{ (($attendanceStats['late'] ?? 0) + ($attendanceStats['absent'] ?? 0)) > 0 ? 'has-pending' : '' }}">
        <div class="stat-header">
            <div class="stat-icon amber">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <span class="stat-label">Perhatian</span>
        </div>
        <div class="stat-value" data-count="{{ ($attendanceStats['late'] ?? 0) + ($attendanceStats['absent'] ?? 0) }}">{{ ($attendanceStats['late'] ?? 0) + ($attendanceStats['absent'] ?? 0) }}</div>
        <div class="stat-desc">Terlambat/Absen</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions" data-aos="fade-up" data-aos-delay="200">
    <a href="{{ route('mentor.penugasan') }}" class="quick-action-btn">
        <div class="quick-action-icon green">
            <i class="fas fa-tasks"></i>
        </div>
        <div class="quick-action-content">
            <h4>Kelola Penugasan</h4>
            <p>Buat dan nilai tugas peserta</p>
        </div>
    </a>

    <a href="{{ route('mentor.absensi') }}" class="quick-action-btn">
        <div class="quick-action-icon blue">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="quick-action-content">
            <h4>Monitor Absensi</h4>
            <p>Pantau kehadiran harian</p>
        </div>
    </a>

    <a href="{{ route('mentor.logbook') }}" class="quick-action-btn">
        <div class="quick-action-icon purple">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="quick-action-content">
            <h4>Review Logbook</h4>
            <p>Lihat aktivitas harian peserta</p>
        </div>
    </a>
</div>

{{-- Charts Section --}}
<div class="charts-section" data-aos="fade-up" data-aos-delay="300">
    {{-- Participant Completion Bar Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <h5 class="chart-title">Persentase Penyelesaian Tugas per Peserta</h5>
        </div>
        <div class="chart-body">
            <div class="chart-loading active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="participantCompletionChart"></canvas>
        </div>
    </div>

    {{-- Completion Distribution Doughnut Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <h5 class="chart-title">Distribusi Penyelesaian</h5>
        </div>
        <div class="chart-body">
            <div class="chart-loading active">
                <div class="chart-loading-spinner"></div>
            </div>
            <canvas id="completionDistributionChart"></canvas>
        </div>
    </div>
</div>

{{-- Activity Section --}}
<div class="activity-section" data-aos="fade-up" data-aos-delay="400">
    {{-- Recent Submissions --}}
    <div class="activity-card">
        <div class="activity-header">
            <div class="activity-header-left">
                <div class="activity-header-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="activity-header-title">
                    <h4>Aktivitas Terbaru</h4>
                    <p>7 hari terakhir</p>
                </div>
            </div>
            <div class="live-indicator">
                <span class="live-dot"></span>
                <span class="live-text">Live</span>
            </div>
        </div>
        <div class="activity-body">
            @if($recentSubmissions->isEmpty())
                <div class="activity-empty">
                    <div class="activity-empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p>Belum ada aktivitas dalam 7 hari terakhir</p>
                </div>
            @else
                @foreach($recentSubmissions as $index => $submission)
                    @php
                        $latestSubmission = $submission->submissions->first();
                        $submittedAt = $latestSubmission ? $latestSubmission->submitted_at : null;
                        $isNew = $submittedAt && \Carbon\Carbon::parse($submittedAt)->diffInHours(now()) < 6;
                    @endphp
                    <div class="activity-item {{ $isNew ? 'new' : '' }}">
                        <div class="activity-avatar">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="activity-content">
                            <h6 class="activity-name">{{ $submission->user->name }}</h6>
                            <p class="activity-desc">Mengumpulkan: {{ $submission->title }}</p>
                            <span class="activity-time">
                                <i class="fas fa-clock"></i>
                                {{ $submittedAt ? \Carbon\Carbon::parse($submittedAt)->diffForHumans() : '-' }}
                            </span>
                        </div>
                        @if($submission->grade)
                            <span class="activity-badge graded">{{ $submission->grade }}</span>
                        @else
                            <span class="activity-badge pending">Belum Dinilai</span>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Attendance Summary --}}
    <div class="activity-card">
        <div class="activity-header">
            <div class="activity-header-left">
                <div class="activity-header-icon" style="background: linear-gradient(135deg, #3B82F6, #2563EB);">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="activity-header-title">
                    <h4>Ringkasan Kehadiran</h4>
                    <p>Hari ini</p>
                </div>
            </div>
        </div>
        <div class="activity-body" style="padding-top: 1rem;">
            <div class="attendance-grid">
                <div class="attendance-item present">
                    <div class="attendance-value">{{ $attendanceStats['present'] ?? 0 }}</div>
                    <div class="attendance-label">Hadir</div>
                </div>
                <div class="attendance-item late">
                    <div class="attendance-value">{{ $attendanceStats['late'] ?? 0 }}</div>
                    <div class="attendance-label">Terlambat</div>
                </div>
                <div class="attendance-item absent">
                    <div class="attendance-value">{{ $attendanceStats['absent'] ?? 0 }}</div>
                    <div class="attendance-label">Tidak Hadir</div>
                </div>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-gray-100);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <span style="font-size: 0.85rem; color: var(--color-gray-600);">Tingkat Kehadiran</span>
                    @php
                        $totalToday = ($attendanceStats['present'] ?? 0) + ($attendanceStats['late'] ?? 0) + ($attendanceStats['absent'] ?? 0);
                        $attendanceRate = $totalToday > 0 ? (($attendanceStats['present'] ?? 0) / $totalToday) * 100 : 0;
                    @endphp
                    <span style="font-size: 0.9rem; font-weight: 600; color: #059669;">{{ number_format($attendanceRate, 0) }}%</span>
                </div>
                <div style="height: 8px; background: var(--color-gray-100); border-radius: 4px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $attendanceRate }}%; background: linear-gradient(90deg, #10B981, #059669); border-radius: 4px; transition: width 1s ease-out;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js default styling
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#64748B';

    // Participant Completion Bar Chart
    const participantData = @json($participantCompletionData ?? []);
    const completionCtx = document.getElementById('participantCompletionChart');

    if (completionCtx && participantData.labels && participantData.labels.length > 0) {
        setTimeout(() => {
            new Chart(completionCtx, {
                type: 'bar',
                data: {
                    labels: participantData.labels,
                    datasets: [{
                        label: 'Penyelesaian (%)',
                        data: participantData.data,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return '#10B981';
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.6)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 1)');
                            return gradient;
                        },
                        borderRadius: 8,
                        borderSkipped: false,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            titleColor: '#F9FAFB',
                            bodyColor: '#E5E7EB',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '% selesai';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            completionCtx.closest('.chart-card').querySelector('.chart-loading').classList.remove('active');
        }, 500);
    } else if (completionCtx) {
        completionCtx.closest('.chart-card').querySelector('.chart-loading').classList.remove('active');
        completionCtx.parentElement.innerHTML = '<div style="text-align:center; padding:2rem; color:#64748B;"><i class="fas fa-chart-bar" style="font-size:2rem; margin-bottom:1rem; display:block; opacity:0.3;"></i>Belum ada data</div>';
    }

    // Completion Distribution Doughnut Chart
    const distributionData = @json($completionDistributionData ?? []);
    const distributionCtx = document.getElementById('completionDistributionChart');

    if (distributionCtx && distributionData.labels && distributionData.labels.length > 0) {
        setTimeout(() => {
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: distributionData.labels,
                    datasets: [{
                        data: distributionData.data,
                        backgroundColor: [
                            '#10B981',
                            '#3B82F6',
                            '#F59E0B',
                            '#EF4444'
                        ],
                        borderWidth: 0,
                        spacing: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            titleColor: '#F9FAFB',
                            bodyColor: '#E5E7EB',
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });

            distributionCtx.closest('.chart-card').querySelector('.chart-loading').classList.remove('active');
        }, 700);
    } else if (distributionCtx) {
        distributionCtx.closest('.chart-card').querySelector('.chart-loading').classList.remove('active');
        distributionCtx.parentElement.innerHTML = '<div style="text-align:center; padding:2rem; color:#64748B;"><i class="fas fa-chart-pie" style="font-size:2rem; margin-bottom:1rem; display:block; opacity:0.3;"></i>Belum ada data</div>';
    }

    // Animate stat values
    const statValues = document.querySelectorAll('.stat-value[data-count]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseFloat(el.dataset.count);
                const isDecimal = target % 1 !== 0;

                let current = 0;
                const duration = 1500;
                const startTime = performance.now();

                const animate = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 3);

                    current = target * easeOut;
                    el.textContent = isDecimal ? current.toFixed(1) : Math.floor(current);

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    } else {
                        el.textContent = isDecimal ? target.toFixed(1) : target;
                    }
                };

                requestAnimationFrame(animate);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    statValues.forEach(el => observer.observe(el));
});
</script>
@endpush
