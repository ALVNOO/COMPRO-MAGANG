{{--
    ADMIN APPLICATIONS PAGE
    Manage internship applications with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Pengajuan Magang')

@php
    $role = 'admin';
    $pageTitle = 'Pengajuan Magang';
    $pageSubtitle = 'Kelola pengajuan magang dari peserta';

    // Count stats
    $totalCount = $applications->count();
    $pendingCount = $applications->where('status', 'pending')->count();
    $acceptedCount = $applications->where('status', 'accepted')->count();
    $rejectedCount = $applications->where('status', 'rejected')->count();
@endphp

@push('styles')
<style>
/* ============================================
   APPLICATIONS PAGE STYLES
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
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-badge-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.25);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.hero-badge-text h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.hero-badge-text p {
    font-size: 0.75rem;
    margin: 0;
    opacity: 0.85;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
}

/* Filter Bar */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1.25rem;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.filter-input {
    flex: 1;
    min-width: 200px;
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.filter-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    min-width: 150px;
    background: white;
    cursor: pointer;
}

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Table Card */
.table-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--color-gray-100, #f3f4f6);
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
}

.table-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
}

.table-count {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 400;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: #f9fafb;
    padding: 0.875rem 1rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    color: #374151;
}

.admin-table tbody tr:hover {
    background: #f9fafb;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.status-badge.accepted {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

.status-badge.finished {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

/* Action Buttons */
.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    transition: all 0.2s;
    border: none;
}

.action-btn.review {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
    color: white;
}

.action-btn.review:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.action-btn.approve {
    background: linear-gradient(135deg, #10B981, #34D399);
    color: white;
}

.action-btn.approve:hover {
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.action-btn.reject {
    background: linear-gradient(135deg, #EF4444, #F87171);
    color: white;
}

.action-btn.reject:hover {
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #9ca3af;
    font-size: 2rem;
}

.empty-text {
    font-size: 1rem;
    color: #6b7280;
    margin: 0;
}

/* Modal Overlay */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 24px;
    width: 100%;
    max-width: 700px;
    max-height: 90vh;
    overflow-y: auto;
    transform: scale(0.9) translateY(20px);
    transition: transform 0.3s ease;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
}

.modal-overlay.show .modal-content {
    transform: scale(1) translateY(0);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.modal-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: #f3f4f6;
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.modal-close:hover {
    background: #e5e7eb;
    color: #374151;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
    background: #f9fafb;
    border-radius: 0 0 24px 24px;
    justify-content: flex-end;
}

/* Applicant Info Card */
.applicant-info {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.applicant-photo {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.applicant-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.applicant-photo .placeholder-icon {
    font-size: 2.5rem;
    color: #9ca3af;
}

.applicant-details h4 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.applicant-details .meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 0.75rem;
}

.applicant-details .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.applicant-details .meta-item i {
    color: #EE2E24;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 640px) {
    .info-grid { grid-template-columns: 1fr; }
    .applicant-info { grid-template-columns: 1fr; text-align: center; }
    .applicant-photo { margin: 0 auto; }
}

.info-item {
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
}

.info-item label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}

.info-item span {
    font-size: 0.9rem;
    color: #374151;
    font-weight: 500;
}

/* Documents Section */
.documents-section h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.documents-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.doc-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    transition: all 0.2s;
}

.doc-btn:hover {
    border-color: #EE2E24;
    color: #EE2E24;
    background: #fef2f2;
}

.doc-btn i {
    color: #EE2E24;
}

/* Period Info */
.period-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.period-info i {
    font-size: 1.5rem;
    color: #10B981;
}

.period-info .period-text {
    flex: 1;
}

.period-info .period-dates {
    font-weight: 600;
    color: #1f2937;
}

.period-info .period-duration {
    font-size: 0.85rem;
    color: #6b7280;
}

/* Approve Form */
.approve-form {
    padding: 1.5rem;
    background: #f0fdf4;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.approve-form h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #10B981;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-group select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white;
}

.form-group select:focus {
    outline: none;
    border-color: #10B981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Reject Form */
.reject-form {
    padding: 1.5rem;
    background: #fef2f2;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.reject-form h5 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #EF4444;
    margin: 0 0 1rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.reject-form textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #fecaca;
    border-radius: 10px;
    font-size: 0.9rem;
    resize: vertical;
    min-height: 100px;
}

.reject-form textarea:focus {
    outline: none;
    border-color: #EF4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Modal Buttons */
.btn-cancel {
    padding: 0.75rem 1.5rem;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover {
    background: #f3f4f6;
}

.btn-approve {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #10B981, #059669);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-approve:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-reject {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EF4444, #DC2626);
    border: none;
    border-radius: 10px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-reject:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Responsive Hero */
@media (max-width: 768px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }
    .hero-text h1 {
        justify-content: center;
        font-size: 1.5rem;
    }
}

/* Responsive Table */
@media (max-width: 768px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-inbox"></i>
                Pengajuan Magang
            </h1>
            <p>Review dan kelola pengajuan magang dari peserta</p>
        </div>
        @if($pendingCount > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $pendingCount }}</h4>
                <p>Menunggu Review</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $totalCount,
        'label' => 'Total Pengajuan',
        'icon' => 'fa-file-alt',
        'color' => 'primary',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $pendingCount,
        'label' => 'Menunggu Review',
        'icon' => 'fa-clock',
        'color' => 'warning',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $acceptedCount,
        'label' => 'Diterima',
        'icon' => 'fa-check-circle',
        'color' => 'success',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $rejectedCount,
        'label' => 'Ditolak',
        'icon' => 'fa-times-circle',
        'color' => 'danger',
        'link' => '#'
    ])
</div>

{{-- Filter Bar --}}
<div class="filter-bar" x-data="{ search: '', status: '' }">
    <input type="text"
           x-model="search"
           placeholder="Cari nama, NIM, atau institusi..."
           class="filter-input"
           @input="filterTable()">
    <select x-model="status" class="filter-select" @change="filterTable()">
        <option value="">Semua Status</option>
        <option value="pending">Pending</option>
        <option value="accepted">Diterima</option>
        <option value="rejected">Ditolak</option>
        <option value="finished">Selesai</option>
    </select>
    <button type="button" class="filter-btn" @click="filterTable()">
        <i class="fas fa-search"></i> Cari
    </button>
</div>

{{-- Applications Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <div class="table-title-icon">
                <i class="fas fa-list"></i>
            </div>
            <span>Daftar Pengajuan <span class="table-count">({{ $totalCount }} data)</span></span>
        </div>
    </div>

    @if($applications->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="empty-text">Belum ada pengajuan magang</p>
        </div>
    @else
        <table class="admin-table" id="applicationsTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Institusi</th>
                    <th>Bidang Peminatan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $index => $app)
                <tr data-name="{{ strtolower($app->user->name ?? '') }}"
                    data-nim="{{ strtolower($app->user->nim ?? '') }}"
                    data-institution="{{ strtolower($app->user->university ?? '') }}"
                    data-status="{{ $app->status }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $app->user->name ?? '-' }}</strong>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $app->user->nim ?? '-' }}</div>
                    </td>
                    <td>{{ Str::limit($app->user->university ?? '-', 25) }}</td>
                    <td>{{ $app->fieldOfInterest->name ?? '-' }}</td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="status-badge {{ $app->status }}">
                            @if($app->status === 'pending')
                                <i class="fas fa-clock"></i> Pending
                            @elseif($app->status === 'accepted')
                                <i class="fas fa-check"></i> Diterima
                            @elseif($app->status === 'rejected')
                                <i class="fas fa-times"></i> Ditolak
                            @elseif($app->status === 'finished')
                                <i class="fas fa-check-double"></i> Selesai
                            @else
                                {{ ucfirst($app->status) }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <button type="button"
                                class="action-btn review"
                                onclick="openDetailModal({{ $app->id }})"
                                title="Lihat Detail">
                            <i class="fas fa-eye"></i> Review
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Detail Modal --}}
<div class="modal-overlay" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user"></i> <span id="modalTitle">Detail Pengajuan</span></h3>
            <button type="button" class="modal-close" onclick="closeDetailModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
            {{-- Content will be loaded dynamically --}}
        </div>
    </div>
</div>

{{-- Hidden data for JavaScript --}}
<script>
const applicationsData = @json($applications->map(function($app) {
    return [
        'id' => $app->id,
        'status' => $app->status,
        'notes' => $app->notes,
        'user' => [
            'name' => $app->user->name ?? '-',
            'nim' => $app->user->nim ?? '-',
            'university' => $app->user->university ?? '-',
            'major' => $app->user->major ?? '-',
            'phone' => $app->user->phone ?? '-',
            'ktp_number' => $app->user->ktp_number ?? '-',
            'profile_picture' => $app->user->profile_picture ? asset('storage/' . $app->user->profile_picture) : null,
        ],
        'field' => $app->fieldOfInterest->name ?? '-',
        'start_date' => $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d M Y') : '-',
        'end_date' => $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d M Y') : '-',
        'duration' => $app->start_date && $app->end_date ? \Carbon\Carbon::parse($app->start_date)->diffInMonths(\Carbon\Carbon::parse($app->end_date)) : 0,
        'documents' => [
            'ktm' => $app->ktm_path ? asset('storage/' . $app->ktm_path) : null,
            'cv' => $app->cv_path ? asset('storage/' . $app->cv_path) : null,
            'surat' => $app->surat_permohonan_path ? asset('storage/' . $app->surat_permohonan_path) : null,
            'skck' => $app->good_behavior_path ? asset('storage/' . $app->good_behavior_path) : null,
        ],
        'approve_url' => route('admin.applications.approve', $app->id),
        'reject_url' => route('admin.applications.reject', $app->id),
    ];
})->keyBy('id'));

const divisions = @json($divisions->map(function($div) {
    return [
        'id' => $div->id,
        'name' => $div->division_name,
        'mentors' => $div->mentors->map(function($mentor) {
            return ['id' => $mentor->id, 'name' => $mentor->mentor_name];
        })
    ];
}));

const csrfToken = '{{ csrf_token() }}';
</script>
@endsection

@push('scripts')
<script>
// Filter functionality
function filterTable() {
    const searchInput = document.querySelector('.filter-input');
    const statusSelect = document.querySelector('.filter-select');
    const rows = document.querySelectorAll('#applicationsTable tbody tr');

    const search = searchInput.value.toLowerCase();
    const status = statusSelect.value;

    rows.forEach(row => {
        const name = row.dataset.name || '';
        const nim = row.dataset.nim || '';
        const institution = row.dataset.institution || '';
        const rowStatus = row.dataset.status || '';

        const matchesSearch = name.includes(search) || nim.includes(search) || institution.includes(search);
        const matchesStatus = !status || rowStatus === status;

        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

// Modal functionality
function openDetailModal(appId) {
    const app = applicationsData[appId];
    if (!app) return;

    const modal = document.getElementById('detailModal');
    const modalBody = document.getElementById('modalBody');
    const modalTitle = document.getElementById('modalTitle');

    modalTitle.textContent = 'Detail Pengajuan - ' + app.user.name;

    let html = `
        <div class="applicant-info">
            <div class="applicant-photo">
                ${app.user.profile_picture
                    ? `<img src="${app.user.profile_picture}" alt="Foto Profil">`
                    : `<i class="fas fa-user placeholder-icon"></i>`}
            </div>
            <div class="applicant-details">
                <h4>${app.user.name}</h4>
                <span class="status-badge ${app.status}">
                    ${app.status === 'pending' ? '<i class="fas fa-clock"></i> Pending' :
                      app.status === 'accepted' ? '<i class="fas fa-check"></i> Diterima' :
                      app.status === 'rejected' ? '<i class="fas fa-times"></i> Ditolak' :
                      app.status === 'finished' ? '<i class="fas fa-check-double"></i> Selesai' : app.status}
                </span>
                <div class="meta">
                    <div class="meta-item"><i class="fas fa-id-card"></i> ${app.user.nim}</div>
                    <div class="meta-item"><i class="fas fa-university"></i> ${app.user.university}</div>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>Jurusan</label>
                <span>${app.user.major}</span>
            </div>
            <div class="info-item">
                <label>No. HP</label>
                <span>${app.user.phone}</span>
            </div>
            <div class="info-item">
                <label>NIK</label>
                <span>${app.user.ktp_number}</span>
            </div>
            <div class="info-item">
                <label>Bidang Peminatan</label>
                <span>${app.field}</span>
            </div>
        </div>

        <div class="period-info">
            <i class="fas fa-calendar-alt"></i>
            <div class="period-text">
                <div class="period-dates">${app.start_date} &rarr; ${app.end_date}</div>
                <div class="period-duration">Durasi: ${app.duration} bulan</div>
            </div>
        </div>

        <div class="documents-section">
            <h5><i class="fas fa-folder-open"></i> Dokumen</h5>
            <div class="documents-grid">
                ${app.documents.ktm ? `<a href="${app.documents.ktm}" target="_blank" class="doc-btn"><i class="fas fa-file-pdf"></i> KTM</a>` : ''}
                ${app.documents.cv ? `<a href="${app.documents.cv}" target="_blank" class="doc-btn"><i class="fas fa-file-pdf"></i> CV</a>` : ''}
                ${app.documents.surat ? `<a href="${app.documents.surat}" target="_blank" class="doc-btn"><i class="fas fa-file-pdf"></i> Surat Permohonan</a>` : ''}
                ${app.documents.skck ? `<a href="${app.documents.skck}" target="_blank" class="doc-btn"><i class="fas fa-file-pdf"></i> SKCK/SBB</a>` : ''}
                ${!app.documents.ktm && !app.documents.cv && !app.documents.surat && !app.documents.skck ? '<span style="color: #9ca3af;">Tidak ada dokumen</span>' : ''}
            </div>
        </div>
    `;

    // Show action forms only for pending applications
    if (app.status === 'pending') {
        html += `
            <div class="approve-form" id="approveForm${appId}">
                <h5><i class="fas fa-check-circle"></i> Terima Pengajuan</h5>
                <form action="${app.approve_url}" method="POST">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div class="form-group">
                        <label>Pilih Divisi <span style="color: #EF4444;">*</span></label>
                        <select name="divisi_id" required onchange="updateMentors(this, ${appId})">
                            <option value="">-- Pilih Divisi --</option>
                            ${divisions.map(d => `<option value="${d.id}">${d.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-group" id="mentorGroup${appId}" style="display: none;">
                        <label>Pilih Mentor <span style="color: #9ca3af;">(Opsional)</span></label>
                        <select name="division_mentor_id" id="mentorSelect${appId}">
                            <option value="">-- Pilih Mentor --</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-approve">
                        <i class="fas fa-check"></i> Terima Pengajuan
                    </button>
                </form>
            </div>

            <div class="reject-form">
                <h5><i class="fas fa-times-circle"></i> Tolak Pengajuan</h5>
                <form action="${app.reject_url}" method="POST">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <div class="form-group">
                        <label>Alasan Penolakan <span style="color: #9ca3af;">(Opsional)</span></label>
                        <textarea name="notes" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <button type="submit" class="btn-reject">
                        <i class="fas fa-times"></i> Tolak Pengajuan
                    </button>
                </form>
            </div>
        `;
    } else if (app.status === 'rejected' && app.notes) {
        html += `
            <div class="reject-form">
                <h5><i class="fas fa-info-circle"></i> Alasan Penolakan</h5>
                <p style="color: #374151; margin: 0;">${app.notes}</p>
            </div>
        `;
    }

    modalBody.innerHTML = html;
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function updateMentors(select, appId) {
    const divisionId = select.value;
    const mentorGroup = document.getElementById('mentorGroup' + appId);
    const mentorSelect = document.getElementById('mentorSelect' + appId);

    if (!divisionId) {
        mentorGroup.style.display = 'none';
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>';
        return;
    }

    const division = divisions.find(d => d.id == divisionId);
    if (division && division.mentors && division.mentors.length > 0) {
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>' +
            division.mentors.map(m => `<option value="${m.id}">${m.name}</option>`).join('');
        mentorGroup.style.display = 'block';
    } else {
        mentorGroup.style.display = 'none';
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>';
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDetailModal();
    }
});

// Close modal on overlay click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});
</script>
@endpush
