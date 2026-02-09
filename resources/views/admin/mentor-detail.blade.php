{{--
    ADMIN MENTOR DETAIL PAGE
    Detail pembimbing dengan peserta yang dibimbing
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Detail Pembimbing')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Detail Pembimbing';
    $pageSubtitle = $mentor->division_mentor->mentor_name ?? $mentor->name;

    // Count stats
    $activeCount = $participants->where('status', 'accepted')->count();
    $finishedCount = $participants->where('status', 'finished')->count();
    $totalCount = $participants->count();
@endphp

@push('styles')
<style>
/* ============================================
   MENTOR DETAIL PAGE STYLES
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

/* Hero Back Button */
.hero-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-5px);
    color: white;
}

/* Profile Card */
.profile-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.06);
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    flex-shrink: 0;
}

.profile-info h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 8px 0;
}

.profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.profile-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #6b7280;
    font-size: 0.9rem;
}

.profile-meta span i {
    color: #EE2E24;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
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

/* Stats Card Colors */
.stat-card.blue {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
    border-color: rgba(59, 130, 246, 0.2);
}

.stat-card.blue .stat-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.stat-card.green {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(22, 163, 74, 0.05) 100%);
    border-color: rgba(34, 197, 94, 0.2);
}

.stat-card.green .stat-icon {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
}

.stat-card.purple {
    background: linear-gradient(135deg, rgba(147, 51, 234, 0.1) 0%, rgba(126, 34, 206, 0.05) 100%);
    border-color: rgba(147, 51, 234, 0.2);
}

.stat-card.purple .stat-icon {
    background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
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

.table-content {
    padding: 0;
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

/* Participant Name */
.participant-name .name {
    font-weight: 600;
    color: #1a1a2e;
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

.status-badge.active {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.status-badge.completed {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.15) 100%);
    color: #16a34a;
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

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
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

    .hero-back-btn {
        margin-top: 1rem;
    }

    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-user-tie"></i> Detail Pembimbing</h1>
            <p>{{ $mentor->division_mentor->mentor_name ?? $mentor->name }}</p>
        </div>
        <a href="{{ route('admin.mentors') }}" class="hero-back-btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
</div>

{{-- Mentor Profile Card --}}
<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="profile-info">
            <h2>{{ $mentor->division_mentor->mentor_name ?? $mentor->name }}</h2>
            <div class="profile-meta">
                <span><i class="fas fa-building"></i> {{ $mentor->division_admin->division_name ?? '-' }}</span>
                <span><i class="fas fa-envelope"></i> {{ $mentor->email }}</span>
                <span><i class="fas fa-id-card"></i> NIK: {{ $mentor->division_mentor->nik_number ?? $mentor->username }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $activeCount }}</h3>
            <p>Peserta Aktif</p>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $finishedCount }}</h3>
            <p>Peserta Selesai</p>
        </div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $totalCount }}</h3>
            <p>Total Peserta</p>
        </div>
    </div>
</div>

{{-- Participants Table --}}
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-list"></i> Daftar Peserta Magang</h3>
    </div>
    <div class="table-content">
        @if($participants->count() > 0)
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Universitas</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $index => $participant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="participant-name">
                                <span class="name">{{ $participant->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>{{ $participant->user->nim ?? '-' }}</td>
                        <td>{{ $participant->user->university ?? '-' }}</td>
                        <td>
                            @if($participant->status == 'accepted')
                                <span class="status-badge active">
                                    <i class="fas fa-spinner fa-spin"></i> Aktif
                                </span>
                            @elseif($participant->status == 'finished')
                                <span class="status-badge completed">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                            @else
                                <span class="status-badge">
                                    {{ ucfirst($participant->status) }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $participant->start_date ? Carbon::parse($participant->start_date)->format('d M Y') : '-' }}</td>
                        <td>{{ $participant->end_date ? Carbon::parse($participant->end_date)->format('d M Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h4>Belum Ada Peserta</h4>
            <p>Pembimbing ini belum memiliki peserta magang</p>
        </div>
        @endif
    </div>
</div>

@endsection
