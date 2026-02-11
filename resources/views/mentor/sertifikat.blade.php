{{--
    MENTOR SERTIFIKAT PAGE
    Certificate management for participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Sertifikat')

@php
    $role = 'mentor';
    $pageTitle = 'Sertifikat Peserta';
    $pageSubtitle = 'Kelola sertifikat untuk peserta magang';

    // Calculate statistics
    $totalParticipants = $participants->count();
    $completedCount = $participants->filter(function($p) {
        return $p->status === 'finished' || ($p->end_date && now()->isAfter($p->end_date));
    })->count();
    $certificateCount = $participants->filter(function($p) {
        return $p->user->certificates && $p->user->certificates->count() > 0;
    })->count();
    $pendingCount = $completedCount - $certificateCount;
@endphp

@push('styles')
<style>
/* ============================================
   SERTIFIKAT PAGE STYLES
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

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
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
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
}

.stat-icon.green {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.stat-icon.yellow {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
}

.stat-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.stat-info p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
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
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.table-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

/* Data Table */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f9fafb;
}

.data-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.data-table td {
    padding: 1rem 1.25rem;
    font-size: 0.9rem;
    color: #1f2937;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.2s;
}

.data-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Participant Info */
.participant-name {
    font-weight: 600;
    color: #1f2937;
}

.participant-nim {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Status Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    white-space: nowrap;
}

.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
}

.badge-secondary {
    background: rgba(107, 114, 128, 0.1);
    color: #4B5563;
}

.status-info {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.status-info.success {
    color: #059669;
}

/* Action Buttons */
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
    color: white;
}

.btn-outline {
    background: white;
    color: #EE2E24;
    border: 1.5px solid #e5e7eb;
}

.btn-outline:hover {
    border-color: #EE2E24;
    background: rgba(238, 46, 36, 0.05);
    color: #EE2E24;
}

/* Certificate Status */
.certificate-pending {
    font-size: 0.8rem;
    color: #6b7280;
    line-height: 1.5;
    max-width: 300px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #EE2E24;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9375rem;
    color: #6b7280;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-text h1 {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="mentor-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-certificate"></i> Sertifikat Peserta</h1>
            <p>Kelola dan kirimkan sertifikat untuk peserta magang yang telah menyelesaikan program</p>
        </div>
    </div>
</div>

{{-- Statistics Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalParticipants }}</h3>
            <p>Total Peserta</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $certificateCount }}</h3>
            <p>Sertifikat Terkirim</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $pendingCount > 0 ? $pendingCount : 0 }}</h3>
            <p>Menunggu Sertifikat</p>
        </div>
    </div>
</div>

{{-- Table Card --}}
<div class="table-card">
    <div class="table-header">
        <i class="fas fa-award"></i>
        <h3>Daftar Peserta Magang</h3>
    </div>
    @if($participants->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Belum Ada Peserta</h3>
            <p>Belum ada peserta magang yang terdaftar di divisi Anda</p>
        </div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nama Peserta</th>
                    <th style="width: 120px;">NIM</th>
                    <th style="width: 200px;">Status Magang</th>
                    <th style="width: 250px;">Sertifikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $i => $p)
                    @php
                        $isEndDatePassed = $p->end_date && now()->isAfter($p->end_date);
                        $assignments = $p->user->assignments;
                        $allAssignmentsGraded = $assignments->count() > 0 && $assignments->every(fn($a) => $a->grade !== null);
                        $canUploadCertificate = $p->can_upload_certificate;
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <span class="participant-name">{{ $p->user->name ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="participant-nim">{{ $p->user->nim ?? '-' }}</span>
                        </td>
                        <td>
                            @if($p->status === 'finished' || $isEndDatePassed)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                                <div class="status-info">Periode magang berakhir</div>
                            @elseif($p->status === 'accepted')
                                <span class="badge badge-warning">
                                    <i class="fas fa-hourglass-half"></i> Sedang Berlangsung
                                </span>
                                @if($p->end_date)
                                    <div class="status-info">Berakhir: {{ \Carbon\Carbon::parse($p->end_date)->format('d M Y') }}</div>
                                @endif
                                @if($allAssignmentsGraded)
                                    <div class="status-info success">
                                        <i class="fas fa-check"></i> Semua tugas dinilai
                                    </div>
                                @endif
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($p->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($canUploadCertificate)
                                @if($p->user->certificates && $p->user->certificates->count() > 0)
                                    <a href="{{ asset('storage/' . $p->user->certificates->first()->certificate_path) }}"
                                       target="_blank"
                                       class="btn-action btn-outline">
                                        <i class="fas fa-eye"></i> Preview Sertifikat
                                    </a>
                                @else
                                    <a href="{{ route('mentor.sertifikat.form', $p->user->id) }}"
                                       class="btn-action btn-primary">
                                        <i class="fas fa-paper-plane"></i> Kirimkan Sertifikat
                                    </a>
                                @endif
                            @else
                                <span class="certificate-pending">
                                    <i class="fas fa-info-circle"></i>
                                    Upload sertifikat hanya bisa dilakukan jika semua tugas sudah dinilai dan tidak ada tugas status revisi.
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
