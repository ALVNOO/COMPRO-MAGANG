{{--
    ADMIN PARTICIPANTS PAGE
    Manage accepted internship participants with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Daftar Peserta')

@php
    $role = 'admin';
    $pageTitle = 'Daftar Peserta Magang';
    $pageSubtitle = 'Kelola data peserta magang yang sudah diterima';

    // Count stats
    $totalParticipants = 0;
    $activeParticipants = 0;
    $completedParticipants = 0;
    $incompleteDocuments = 0;

    foreach($participants as $peserta) {
        foreach($peserta->internshipApplications as $app) {
            $totalParticipants++;

            $now = \Carbon\Carbon::now();
            $startDate = $app->start_date ? \Carbon\Carbon::parse($app->start_date) : null;
            $endDate = $app->end_date ? \Carbon\Carbon::parse($app->end_date) : null;

            if ($startDate && $endDate) {
                if ($now->between($startDate, $endDate)) {
                    $activeParticipants++;
                } elseif ($now->gt($endDate)) {
                    $completedParticipants++;
                }
            }

            // Check incomplete documents
            $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
            if (!$app->acceptance_letter_path || !$hasCertificate || !$app->completion_letter_path) {
                $incompleteDocuments++;
            }
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   PARTICIPANTS PAGE STYLES
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
    font-size: 1.5rem;
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
}

.stat-icon.total { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; }
.stat-icon.active { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.stat-icon.completed { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
.stat-icon.incomplete { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }

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

/* Legend Box */
.legend-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
}

.legend-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-items {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.legend-item i.fa-check-circle { color: #22c55e; }
.legend-item i.fa-times-circle { color: #ef4444; }
.legend-item i.fa-edit { color: #f59e0b; }

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

.filter-input {
    flex: 1;
    min-width: 200px;
    padding: 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white;
    transition: all 0.2s ease;
}

.filter-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-select {
    padding: 0.625rem 2rem 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") right 0.5rem center/1.5em 1.5em no-repeat;
    cursor: pointer;
    transition: all 0.2s ease;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-btn {
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
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

.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
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

.table-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-title i {
    color: #EE2E24;
}

.participants-table {
    width: 100%;
    border-collapse: collapse;
}

.participants-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.participants-table th {
    padding: 1rem 0.75rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    white-space: nowrap;
}

.participants-table td {
    padding: 1rem 0.75rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.participants-table tbody tr {
    transition: all 0.2s ease;
}

.participants-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.participant-name {
    font-weight: 600;
    color: #1f2937;
}

.participant-email {
    font-size: 0.75rem;
    color: #6b7280;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.division-badge {
    display: inline-flex;
    padding: 0.25rem 0.625rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: #4f46e5;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.period-info {
    font-size: 0.8rem;
    color: #6b7280;
}

.period-info .dates {
    font-weight: 500;
    color: #374151;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 500;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.status-badge.completed {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.status-badge.upcoming {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

/* Document Status */
.doc-status {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.doc-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: all 0.2s ease;
}

.doc-icon.available {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    cursor: pointer;
}

.doc-icon.available:hover {
    background: rgba(34, 197, 94, 0.2);
    transform: scale(1.05);
}

.doc-icon.missing {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    gap: 0.375rem;
}

.action-btn.primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.action-btn.secondary {
    background: rgba(107, 114, 128, 0.1);
    color: #4b5563;
}

.action-btn.secondary:hover {
    background: rgba(107, 114, 128, 0.2);
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(238, 46, 36, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #EE2E24;
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
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    inset: 0;
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

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: 20px;
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s ease;
}

.modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-title i {
    color: #EE2E24;
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
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #e5e7eb;
    color: #374151;
}

.modal-body {
    padding: 1.5rem;
}

.modal-section {
    margin-bottom: 1.5rem;
}

.modal-section:last-child {
    margin-bottom: 0;
}

.modal-section-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.75rem;
    color: #9ca3af;
}

.info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
}

.doc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.doc-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f9fafb;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.doc-item:hover {
    background: #f3f4f6;
}

.doc-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.doc-item-icon.has-file {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.doc-item-icon.no-file {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

.doc-item-info {
    flex: 1;
}

.doc-item-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
}

.doc-item-status {
    font-size: 0.7rem;
    color: #9ca3af;
}

.upload-form {
    margin-top: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
}

.upload-form-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
}

.upload-form-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.upload-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.85rem;
    background: white;
}

.upload-btn {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s ease;
}

.upload-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filter-bar {
        flex-direction: column;
    }

    .filter-input,
    .filter-select {
        width: 100%;
    }

    .legend-items {
        flex-direction: column;
        gap: 0.5rem;
    }

    .participants-table {
        font-size: 0.8rem;
    }

    .participants-table th,
    .participants-table td {
        padding: 0.75rem 0.5rem;
    }

    .info-grid,
    .doc-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="participants-page" x-data="participantsManager()">
    {{-- Hero Section --}}
    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><i class="fas fa-users"></i> Daftar Peserta Magang</h1>
                <p>Kelola data dan dokumen peserta magang yang sudah diterima</p>
            </div>
            @if($activeParticipants > 0)
            <div class="hero-badge">
                <div class="hero-badge-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="hero-badge-text">
                    <h4>{{ $activeParticipants }}</h4>
                    <p>Peserta Aktif</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalParticipants }}</h3>
                <p>Total Peserta</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $activeParticipants }}</h3>
                <p>Sedang Magang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon completed">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $completedParticipants }}</h3>
                <p>Selesai Magang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon incomplete">
                <i class="fas fa-file-circle-exclamation"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $incompleteDocuments }}</h3>
                <p>Dokumen Belum Lengkap</p>
            </div>
        </div>
    </div>

    {{-- Status Legend --}}
    <div class="legend-box">
        <div class="legend-title">
            <i class="fas fa-info-circle"></i> Keterangan Status Dokumen
        </div>
        <div class="legend-items">
            <div class="legend-item">
                <i class="fas fa-check-circle"></i>
                <span>Dokumen tersedia / sudah diunggah</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-times-circle"></i>
                <span>Dokumen belum tersedia</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-edit"></i>
                <span>Dokumen sedang direvisi</span>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            type="text"
            class="filter-input"
            placeholder="Cari nama, email, atau divisi..."
            x-model="searchQuery"
            @input="filterTable()"
        >
        <select class="filter-select" x-model="statusFilter" @change="filterTable()">
            <option value="">Semua Status</option>
            <option value="active">Sedang Magang</option>
            <option value="completed">Selesai</option>
            <option value="upcoming">Belum Mulai</option>
        </select>
        <select class="filter-select" x-model="docFilter" @change="filterTable()">
            <option value="">Semua Dokumen</option>
            <option value="complete">Lengkap</option>
            <option value="incomplete">Belum Lengkap</option>
        </select>
        <button class="filter-btn" @click="resetFilters()">
            <i class="fas fa-sync-alt"></i> Reset
        </button>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-table"></i>
                <span>Data Peserta Magang</span>
            </div>
            <span class="text-sm text-gray-500" x-text="'Menampilkan ' + visibleCount + ' dari ' + totalCount + ' peserta'"></span>
        </div>

        <div class="overflow-x-auto">
            <table class="participants-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>Divisi</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="participantsTableBody">
                    @php $row = 1; @endphp
                    @foreach($participants as $peserta)
                        @foreach($peserta->internshipApplications as $app)
                            @php
                                $now = \Carbon\Carbon::now();
                                $startDate = $app->start_date ? \Carbon\Carbon::parse($app->start_date) : null;
                                $endDate = $app->end_date ? \Carbon\Carbon::parse($app->end_date) : null;

                                $status = 'upcoming';
                                $statusLabel = 'Belum Mulai';
                                if ($startDate && $endDate) {
                                    if ($now->between($startDate, $endDate)) {
                                        $status = 'active';
                                        $statusLabel = 'Aktif';
                                    } elseif ($now->gt($endDate)) {
                                        $status = 'completed';
                                        $statusLabel = 'Selesai';
                                    }
                                }

                                $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                $certificate = $hasCertificate ? $peserta->certificates->first() : null;
                                $isDocComplete = $app->acceptance_letter_path && $hasCertificate && $app->completion_letter_path;
                            @endphp
                            <tr class="participant-row"
                                data-name="{{ strtolower($peserta->name) }}"
                                data-email="{{ strtolower($peserta->email ?? '') }}"
                                data-division="{{ strtolower($app->divisionAdmin->division_name ?? '') }}"
                                data-status="{{ $status }}"
                                data-doc="{{ $isDocComplete ? 'complete' : 'incomplete' }}">
                                <td>{{ $row++ }}</td>
                                <td>
                                    <div class="participant-name">{{ $peserta->name }}</div>
                                    <div class="participant-email" title="{{ $peserta->email }}">{{ $peserta->email }}</div>
                                </td>
                                <td>
                                    <span class="division-badge" title="{{ $app->divisionAdmin->division_name ?? '-' }}">
                                        {{ Str::limit($app->divisionAdmin->division_name ?? '-', 20) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="period-info">
                                        <div class="dates">
                                            {{ $startDate ? $startDate->format('d M Y') : '-' }}
                                        </div>
                                        <div class="text-xs text-gray-400">s/d {{ $endDate ? $endDate->format('d M Y') : '-' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $status }}">
                                        @if($status === 'active')
                                            <i class="fas fa-circle text-xs"></i> {{ $statusLabel }}
                                        @elseif($status === 'completed')
                                            <i class="fas fa-check-circle"></i> {{ $statusLabel }}
                                        @else
                                            <i class="fas fa-clock"></i> {{ $statusLabel }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="doc-status">
                                        {{-- Surat Penerimaan --}}
                                        @if($app->acceptance_letter_path)
                                            <a href="{{ asset('storage/' . $app->acceptance_letter_path) }}" target="_blank" class="doc-icon available" title="Surat Penerimaan">
                                                <i class="fas fa-file-signature"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Surat Penerimaan belum ada">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                        @endif

                                        {{-- Laporan --}}
                                        @if($app->assessment_report_path)
                                            <a href="{{ route('admin.participants.download-assessment-report', $app->id) }}" class="doc-icon available" title="Laporan">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Laporan belum ada">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                        @endif

                                        {{-- Sertifikat --}}
                                        @if($certificate && $certificate->certificate_path)
                                            <a href="{{ asset('storage/' . $certificate->certificate_path) }}" target="_blank" class="doc-icon available" title="Sertifikat">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Sertifikat belum ada">
                                                <i class="fas fa-certificate"></i>
                                            </span>
                                        @endif

                                        {{-- Surat Selesai --}}
                                        @if(!empty($app->completion_letter_path))
                                            <a href="{{ asset('storage/' . $app->completion_letter_path) }}" target="_blank" class="doc-icon available" title="Surat Selesai">
                                                <i class="fas fa-file-circle-check"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Surat Selesai belum ada">
                                                <i class="fas fa-file-circle-check"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button
                                        class="action-btn primary"
                                        @click="openModal({{ json_encode([
                                            'id' => $app->id,
                                            'userId' => $peserta->id,
                                            'name' => $peserta->name,
                                            'email' => $peserta->email,
                                            'phone' => $peserta->phone,
                                            'division' => $app->divisionAdmin->division_name ?? '-',
                                            'startDate' => $startDate ? $startDate->format('d M Y') : '-',
                                            'endDate' => $endDate ? $endDate->format('d M Y') : '-',
                                            'status' => $statusLabel,
                                            'hasAcceptance' => (bool)$app->acceptance_letter_path,
                                            'acceptancePath' => $app->acceptance_letter_path,
                                            'hasReport' => (bool)$app->assessment_report_path,
                                            'reportPath' => $app->assessment_report_path,
                                            'hasCertificate' => $hasCertificate,
                                            'certificatePath' => $certificate ? $certificate->certificate_path : null,
                                            'hasCompletion' => (bool)$app->completion_letter_path,
                                            'completionPath' => $app->completion_letter_path,
                                        ]) }})"
                                    >
                                        <i class="fas fa-folder-open"></i> Kelola
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            {{-- Empty State --}}
            @if($totalParticipants === 0)
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <h4>Belum Ada Peserta</h4>
                <p>Peserta magang yang diterima akan muncul di sini</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal-overlay" :class="{ 'active': showModal }" @click.self="closeModal()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-user"></i>
                    <span x-text="selectedParticipant?.name || 'Detail Peserta'"></span>
                </div>
                <button class="modal-close" @click="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                {{-- Personal Info --}}
                <div class="modal-section">
                    <div class="modal-section-title">Informasi Peserta</div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value" x-text="selectedParticipant?.name"></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value" x-text="selectedParticipant?.email || '-'"></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. Telepon</span>
                            <span class="info-value" x-text="selectedParticipant?.phone || '-'"></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Divisi</span>
                            <span class="info-value" x-text="selectedParticipant?.division"></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Mulai</span>
                            <span class="info-value" x-text="selectedParticipant?.startDate"></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Selesai</span>
                            <span class="info-value" x-text="selectedParticipant?.endDate"></span>
                        </div>
                    </div>
                </div>

                {{-- Documents Status --}}
                <div class="modal-section">
                    <div class="modal-section-title">Status Dokumen</div>
                    <div class="doc-grid">
                        <div class="doc-item">
                            <div class="doc-item-icon" :class="selectedParticipant?.hasAcceptance ? 'has-file' : 'no-file'">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <div class="doc-item-info">
                                <div class="doc-item-name">Surat Penerimaan</div>
                                <div class="doc-item-status" x-text="selectedParticipant?.hasAcceptance ? 'Tersedia' : 'Belum ada'"></div>
                            </div>
                            <template x-if="selectedParticipant?.hasAcceptance">
                                <a :href="'/storage/' + selectedParticipant?.acceptancePath" target="_blank" class="action-btn secondary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </template>
                        </div>
                        <div class="doc-item">
                            <div class="doc-item-icon" :class="selectedParticipant?.hasReport ? 'has-file' : 'no-file'">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="doc-item-info">
                                <div class="doc-item-name">Laporan Magang</div>
                                <div class="doc-item-status" x-text="selectedParticipant?.hasReport ? 'Tersedia' : 'Belum ada'"></div>
                            </div>
                            <template x-if="selectedParticipant?.hasReport">
                                <a :href="'/admin/participants/' + selectedParticipant?.id + '/download-assessment-report'" class="action-btn secondary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </template>
                        </div>
                        <div class="doc-item">
                            <div class="doc-item-icon" :class="selectedParticipant?.hasCertificate ? 'has-file' : 'no-file'">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="doc-item-info">
                                <div class="doc-item-name">Sertifikat</div>
                                <div class="doc-item-status" x-text="selectedParticipant?.hasCertificate ? 'Tersedia' : 'Belum ada'"></div>
                            </div>
                            <template x-if="selectedParticipant?.hasCertificate">
                                <a :href="'/storage/' + selectedParticipant?.certificatePath" target="_blank" class="action-btn secondary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </template>
                        </div>
                        <div class="doc-item">
                            <div class="doc-item-icon" :class="selectedParticipant?.hasCompletion ? 'has-file' : 'no-file'">
                                <i class="fas fa-file-circle-check"></i>
                            </div>
                            <div class="doc-item-info">
                                <div class="doc-item-name">Surat Selesai</div>
                                <div class="doc-item-status" x-text="selectedParticipant?.hasCompletion ? 'Tersedia' : 'Belum ada'"></div>
                            </div>
                            <template x-if="selectedParticipant?.hasCompletion">
                                <a :href="'/storage/' + selectedParticipant?.completionPath" target="_blank" class="action-btn secondary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Upload Forms --}}
                <div class="modal-section">
                    <div class="modal-section-title">Upload Dokumen</div>

                    {{-- Upload Surat Penerimaan --}}
                    <div class="upload-form">
                        <div class="upload-form-title"><i class="fas fa-file-signature me-2"></i> Surat Penerimaan</div>
                        <form :action="'/admin/participants/' + selectedParticipant?.id + '/upload-acceptance-letter'" method="POST" enctype="multipart/form-data" class="upload-form-row">
                            @csrf
                            <input type="file" name="acceptance_letter" accept=".pdf" class="upload-input" required>
                            <button type="submit" class="upload-btn">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </form>
                    </div>

                    {{-- Upload Sertifikat --}}
                    <div class="upload-form" style="margin-top: 0.75rem;">
                        <div class="upload-form-title"><i class="fas fa-certificate me-2"></i> Sertifikat</div>
                        <form :action="'/admin/participants/' + selectedParticipant?.userId + '/upload-certificate'" method="POST" enctype="multipart/form-data" class="upload-form-row">
                            @csrf
                            <input type="file" name="certificate" accept=".pdf" class="upload-input" required>
                            <button type="submit" class="upload-btn">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </form>
                    </div>

                    {{-- Upload Surat Selesai --}}
                    <div class="upload-form" style="margin-top: 0.75rem;">
                        <div class="upload-form-title"><i class="fas fa-file-circle-check me-2"></i> Surat Selesai Magang</div>
                        <form :action="'/admin/participants/' + selectedParticipant?.id + '/upload-completion-letter'" method="POST" enctype="multipart/form-data" class="upload-form-row">
                            @csrf
                            <input type="file" name="completion_letter" accept=".pdf" class="upload-input" required>
                            <button type="submit" class="upload-btn">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function participantsManager() {
    return {
        searchQuery: '',
        statusFilter: '',
        docFilter: '',
        showModal: false,
        selectedParticipant: null,
        visibleCount: {{ $totalParticipants }},
        totalCount: {{ $totalParticipants }},

        filterTable() {
            const rows = document.querySelectorAll('.participant-row');
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const division = row.dataset.division || '';
                const status = row.dataset.status || '';
                const doc = row.dataset.doc || '';

                const matchesSearch = !this.searchQuery ||
                    name.includes(this.searchQuery.toLowerCase()) ||
                    email.includes(this.searchQuery.toLowerCase()) ||
                    division.includes(this.searchQuery.toLowerCase());

                const matchesStatus = !this.statusFilter || status === this.statusFilter;
                const matchesDoc = !this.docFilter || doc === this.docFilter;

                if (matchesSearch && matchesStatus && matchesDoc) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            this.visibleCount = visible;
        },

        resetFilters() {
            this.searchQuery = '';
            this.statusFilter = '';
            this.docFilter = '';
            this.filterTable();
        },

        openModal(participant) {
            this.selectedParticipant = participant;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.showModal = false;
            this.selectedParticipant = null;
            document.body.style.overflow = '';
        }
    }
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const manager = document.querySelector('[x-data]')?.__x?.$data;
        if (manager?.showModal) {
            manager.closeModal();
        }
    }
});
</script>
@endpush
