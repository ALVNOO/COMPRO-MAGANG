{{--
    MENTOR PENUGASAN & PENILAIAN PAGE
    Assignment and grading management
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Penugasan & Penilaian')

@php
    $role = 'mentor';
    $pageTitle = 'Penugasan & Penilaian';
    $pageSubtitle = 'Kelola tugas dan penilaian peserta magang';

    // Calculate statistics
    $totalParticipants = $participants->count();
    $activeParticipants = $participants->filter(function($p) {
        if ($p->start_date) {
            return \Carbon\Carbon::parse($p->start_date)->lte(now());
        }
        return true;
    })->count();

    $totalTasks = 0;
    $pendingGrading = 0;
    $completedTasks = 0;

    foreach ($participants as $participant) {
        $assignments = $participant->user->assignments ?? collect();
        $totalTasks += $assignments->count();
        $completedTasks += $assignments->whereNotNull('grade')->count();

        foreach ($assignments as $assignment) {
            $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
            if (($hasSubmissions || $assignment->submission_file_path) && is_null($assignment->grade) && $assignment->is_revision !== 1) {
                $pendingGrading++;
            }
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   PENUGASAN PAGE STYLES
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

.stat-icon.red {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
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

/* Tabs Navigation */
.tabs-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    padding: 0.5rem;
    margin-bottom: 2rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tab-btn {
    flex: 1;
    min-width: 150px;
    padding: 0.875rem 1.5rem;
    border: none;
    background: transparent;
    color: #6b7280;
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn:hover {
    background: rgba(238, 46, 36, 0.05);
    color: #1f2937;
}

.tab-btn.active {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.tab-btn .badge-count {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
}

.tab-btn.active .badge-count {
    background: rgba(255, 255, 255, 0.25);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Participants Grid */
.participants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.participant-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    border: 2px solid transparent;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    cursor: pointer;
}

.participant-card:hover {
    border-color: #EE2E24;
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(238, 46, 36, 0.15);
}

.participant-card.not-started {
    opacity: 0.6;
    background: rgba(249, 250, 251, 0.95);
    cursor: not-allowed;
}

.participant-card.not-started:hover {
    border-color: transparent;
    transform: none;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.participant-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.participant-avatar {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.participant-info {
    flex: 1;
    min-width: 0;
}

.participant-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.participant-nim {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.participant-start-date {
    font-size: 0.75rem;
    color: #F59E0B;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.badge-not-started {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #FEF3C7;
    color: #92400E;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    font-weight: 500;
}

.participant-stats-row {
    display: flex;
    gap: 1rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.participant-stat {
    flex: 1;
    text-align: center;
}

.participant-stat-value {
    display: block;
    font-size: 1.375rem;
    font-weight: 700;
    color: #EE2E24;
}

.participant-stat-label {
    display: block;
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Form Card */
.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.form-section {
    padding: 1.75rem 2rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.form-section:last-child {
    border-bottom: none;
}

.form-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.form-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    color: #EE2E24;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.form-section-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

/* Participant Selector */
.participant-selector {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    max-height: 300px;
    overflow-y: auto;
}

.select-all-option {
    padding: 0.875rem 1rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
    border-radius: 10px;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(238, 46, 36, 0.1);
}

.participant-checkbox {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.participant-checkbox:hover {
    background: rgba(238, 46, 36, 0.03);
}

.participant-checkbox.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f9fafb;
}

.participant-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin-right: 0.875rem;
    cursor: pointer;
    accent-color: #EE2E24;
}

.participant-checkbox input[type="checkbox"]:disabled {
    cursor: not-allowed;
}

.participant-checkbox-label {
    font-size: 0.9375rem;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-label .required {
    color: #EE2E24;
}

.form-control, .form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: white;
    color: #1f2937;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

/* Buttons */
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
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
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-title i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.table-title h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

/* Filters */
.filter-bar {
    padding: 1.25rem 1.5rem;
    background: #f9fafb;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 180px;
}

.filter-group label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-group select {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
}

.filter-group select:focus {
    outline: none;
    border-color: #EE2E24;
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
    font-size: 0.875rem;
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

/* Badges */
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

.badge-primary {
    background: rgba(238, 46, 36, 0.1);
    color: #EE2E24;
}

.badge-success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.badge-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
}

.badge-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #DC2626;
}

.badge-info {
    background: rgba(59, 130, 246, 0.1);
    color: #2563EB;
}

/* Action Buttons */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-outline {
    background: white;
    color: #EE2E24;
    border: 1.5px solid #e5e7eb;
}

.btn-outline:hover {
    border-color: #EE2E24;
    background: rgba(238, 46, 36, 0.05);
}

.btn-success {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

/* Grade Input */
.grade-input {
    width: 80px;
    padding: 0.5rem 0.75rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    text-align: center;
}

.grade-input:focus {
    outline: none;
    border-color: #EE2E24;
}

.feedback-input {
    width: 180px;
    padding: 0.5rem 0.75rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
}

.feedback-input:focus {
    outline: none;
    border-color: #EE2E24;
}

/* Submission Info */
.submission-info {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.deadline-overdue {
    color: #DC2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.grade-display {
    font-size: 1.1rem;
    font-weight: 700;
    color: #EE2E24;
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

/* Modal Styles */
.modal-content {
    border-radius: 16px;
    border: none;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
}

.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    background: #f9fafb;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.btn-close-white {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.btn-close-white:hover {
    opacity: 1;
}

/* Form Actions */
.form-actions {
    padding: 1.5rem 2rem;
    background: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Loading State */
.btn-loading {
    display: none;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
}

/* Responsive */
@media (max-width: 1024px) {
    .tabs-card {
        flex-direction: column;
    }

    .tab-btn {
        min-width: 100%;
    }
}

@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-text h1 {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .participants-grid {
        grid-template-columns: 1fr;
    }

    .form-section {
        padding: 1.25rem;
    }

    .filter-bar {
        flex-direction: column;
    }

    .filter-group {
        min-width: 100%;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="mentor-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-tasks"></i> Penugasan & Penilaian</h1>
            <p>Kelola tugas dan berikan penilaian untuk peserta magang di divisi Anda</p>
        </div>
    </div>
</div>

@if($participants->isEmpty())
    {{-- Empty State --}}
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>Belum Ada Peserta</h3>
        <p>Belum ada peserta magang yang diterima di divisi Anda.</p>
    </div>
@else
    {{-- Statistics Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $activeParticipants }}</h3>
                <p>Peserta Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalTasks }}</h3>
                <p>Total Tugas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $pendingGrading }}</h3>
                <p>Menunggu Dinilai</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $completedTasks }}</h3>
                <p>Sudah Dinilai</p>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="tabs-card">
        <button class="tab-btn active" onclick="switchTab('overview')">
            <i class="fas fa-th-large"></i> Overview Peserta
        </button>
        <button class="tab-btn" onclick="switchTab('create')">
            <i class="fas fa-plus-circle"></i> Buat Tugas Baru
        </button>
        <button class="tab-btn" onclick="switchTab('tasks')">
            <i class="fas fa-list"></i> Semua Tugas
            <span class="badge-count">{{ $totalTasks }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('grading')">
            <i class="fas fa-star"></i> Penilaian
            @if($pendingGrading > 0)
                <span class="badge-count">{{ $pendingGrading }}</span>
            @endif
        </button>
    </div>

    {{-- Detail Peserta (Modal / Panel) --}}
    <div class="modal fade" id="participantDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-graduate"></i> Detail Peserta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="participantDetailContent">
                    {{-- Content will be loaded here --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Tab: Overview Peserta --}}
    <div id="tab-overview" class="tab-content active">
        <div class="participants-grid">
            @foreach($participants as $participant)
                @php
                    $totalTugas = $participant->user->assignments->count();
                    $tugasSelesai = $participant->user->assignments->where('grade', '!=', null)->count();
                    $rataRata = $participant->user->assignments->whereNotNull('grade')->avg('grade');

                    $hasStarted = true;
                    if ($participant->start_date) {
                        $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                    }
                @endphp
                <div class="participant-card {{ !$hasStarted ? 'not-started' : '' }}"
                     @if($hasStarted) onclick="viewParticipantDetail({{ $participant->user->id }})" @endif>
                    <div class="participant-header">
                        <div class="participant-avatar">
                            {{ strtoupper(substr($participant->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="participant-info">
                            <h3 class="participant-name">
                                {{ $participant->user->name ?? '-' }}
                                @if(!$hasStarted)
                                    <span class="badge-not-started">
                                        <i class="fas fa-clock"></i> Belum Mulai
                                    </span>
                                @endif
                            </h3>
                            <p class="participant-nim">{{ $participant->user->nim ?? '-' }}</p>
                            @if(!$hasStarted && $participant->start_date)
                                <p class="participant-start-date">
                                    <i class="fas fa-calendar"></i>
                                    Mulai: {{ \Carbon\Carbon::parse($participant->start_date)->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="participant-stats-row">
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $totalTugas }}</span>
                            <span class="participant-stat-label">Tugas</span>
                        </div>
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $tugasSelesai }}</span>
                            <span class="participant-stat-label">Selesai</span>
                        </div>
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $rataRata ? number_format($rataRata, 0) : '-' }}</span>
                            <span class="participant-stat-label">Rata-rata</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tab: Buat Tugas Baru --}}
    <div id="tab-create" class="tab-content">
        <div class="form-card">
            <form method="POST" action="{{ route('mentor.penugasan.tambah') }}" enctype="multipart/form-data" id="createTaskForm">
                @csrf

                {{-- Section 1: Pilih Peserta --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="form-section-title">1. Pilih Peserta</h3>
                            <p class="form-section-subtitle">Tentukan peserta yang akan menerima tugas</p>
                        </div>
                    </div>
                    <div class="participant-selector">
                        <div class="select-all-option">
                            <label class="participant-checkbox">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                                <span class="participant-checkbox-label">
                                    <strong>Pilih Semua Peserta</strong>
                                    <span style="color: #6b7280; font-size: 0.8rem;">(yang sudah mulai)</span>
                                </span>
                            </label>
                        </div>
                        @foreach($participants as $participant)
                            @php
                                $hasStarted = true;
                                if ($participant->start_date) {
                                    $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                                }
                            @endphp
                            <label class="participant-checkbox {{ !$hasStarted ? 'disabled' : '' }}">
                                <input type="checkbox"
                                       name="user_ids[]"
                                       value="{{ $participant->user->id }}"
                                       class="participant-check"
                                       {{ !$hasStarted ? 'disabled' : '' }}>
                                <span class="participant-checkbox-label">
                                    {{ $participant->user->name ?? '-' }} ({{ $participant->user->nim ?? '-' }})
                                    @if(!$hasStarted)
                                        <span class="badge-not-started">
                                            <i class="fas fa-clock"></i>
                                            Belum Mulai
                                            @if($participant->start_date)
                                                - {{ \Carbon\Carbon::parse($participant->start_date)->format('d M') }}
                                            @endif
                                        </span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Section 2: Detail Tugas --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <div>
                            <h3 class="form-section-title">2. Detail Tugas</h3>
                            <p class="form-section-subtitle">Isi informasi detail tugas yang akan diberikan</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jenis Tugas <span class="required">*</span></label>
                                <select name="assignment_type" class="form-select" id="assignmentType" required>
                                    <option value="">Pilih Jenis Tugas</option>
                                    <option value="tugas_harian">Tugas Harian</option>
                                    <option value="tugas_proyek">Tugas Proyek</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Judul Tugas <span class="required">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Masukkan judul tugas..." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Deadline <span class="required">*</span></label>
                                <input type="date" name="deadline" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6" id="presentationDateGroup" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Tanggal Presentasi</label>
                                <input type="date" name="presentation_date" class="form-control" id="presentationDate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">File Tugas <span style="color: #6b7280; font-weight: 400;">(Opsional)</span></label>
                                <input type="file" name="file_path" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Deskripsi Tugas</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail tugas, instruksi pengerjaan, atau kriteria penilaian..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-actions">
                    <button type="submit" class="btn-submit" id="submitTaskBtn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane"></i> Buat Tugas
                        </span>
                        <span class="btn-loading">
                            <span class="spinner-border spinner-border-sm me-2"></span> Membuat tugas...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tab: Semua Tugas --}}
    <div id="tab-tasks" class="tab-content">
        <div class="table-card">
            <div class="filter-bar">
                <div class="filter-group">
                    <label>Filter Peserta</label>
                    <select id="filterPeserta" onchange="filterTasks()">
                        <option value="">Semua Peserta</option>
                        @foreach($participants as $participant)
                            <option value="{{ $participant->user->id }}">{{ $participant->user->name ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label>Filter Jenis</label>
                    <select id="filterJenis" onchange="filterTasks()">
                        <option value="">Semua Jenis</option>
                        <option value="tugas_harian">Tugas Harian</option>
                        <option value="tugas_proyek">Tugas Proyek</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Filter Status</label>
                    <select id="filterStatus" onchange="filterTasks()">
                        <option value="">Semua Status</option>
                        <option value="belum_dikerjakan">Belum Dikerjakan</option>
                        <option value="sudah_submit">Sudah Submit</option>
                        <option value="sudah_dinilai">Sudah Dinilai</option>
                        <option value="revisi">Revisi</option>
                    </select>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Peserta</th>
                        <th>Judul Tugas</th>
                        <th style="width: 120px;">Jenis</th>
                        <th style="width: 120px;">Deadline</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 80px;">Nilai</th>
                        <th style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="taskTableBody">
                    @php $no = 1; @endphp
                    @foreach($participants as $participant)
                        @foreach($participant->user->assignments as $assignment)
                            @php
                                $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
                                $latestSubmission = $hasSubmissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;

                                $status = 'belum_dikerjakan';
                                if ($assignment->is_revision === 1) {
                                    $status = 'revisi';
                                } elseif ($assignment->grade !== null) {
                                    $status = 'sudah_dinilai';
                                } elseif ($hasSubmissions || $assignment->submission_file_path) {
                                    $status = 'sudah_submit';
                                }
                            @endphp
                            <tr class="task-row"
                                data-peserta="{{ $participant->user->id }}"
                                data-jenis="{{ $assignment->assignment_type }}"
                                data-status="{{ $status }}">
                                <td>{{ $no++ }}</td>
                                <td>{{ $participant->user->name ?? '-' }}</td>
                                <td>
                                    {{ $assignment->title ?? '-' }}
                                    @if($hasSubmissions)
                                        <div class="submission-info">
                                            <i class="fas fa-upload"></i>
                                            {{ $latestSubmission->submitted_at ? \Carbon\Carbon::parse($latestSubmission->submitted_at)->format('d/m/Y H:i') : '' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($assignment->assignment_type === 'tugas_harian')
                                        <span class="badge badge-primary"><i class="fas fa-calendar-day"></i> Harian</span>
                                    @else
                                        <span class="badge badge-warning"><i class="fas fa-project-diagram"></i> Proyek</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d/m/Y') : '-' }}
                                    @if($assignment->deadline)
                                        @php
                                            $deadline = \Carbon\Carbon::parse($assignment->deadline);
                                            $isOverdue = $deadline->lt(now()) && $status === 'belum_dikerjakan';
                                        @endphp
                                        @if($isOverdue)
                                            <div class="deadline-overdue">
                                                <i class="fas fa-exclamation-triangle"></i> Terlambat
                                            </div>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if($status === 'revisi')
                                        <span class="badge badge-danger"><i class="fas fa-redo"></i> Revisi</span>
                                    @elseif($status === 'sudah_dinilai')
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Dinilai</span>
                                    @elseif($status === 'sudah_submit')
                                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Nilai</span>
                                    @else
                                        <span class="badge badge-info"><i class="fas fa-hourglass-half"></i> Belum Dikerjakan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($assignment->grade !== null)
                                        <span class="grade-display">{{ $assignment->grade }}</span>
                                    @else
                                        <span style="color: #9ca3af;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($hasSubmissions || $assignment->submission_file_path)
                                        <a href="{{ $hasSubmissions ? asset('storage/' . $latestSubmission->file_path) : asset('storage/' . $assignment->submission_file_path) }}"
                                           target="_blank"
                                           class="btn-action btn-outline btn-sm"
                                           title="Download file">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @else
                                        <button class="btn-action btn-outline btn-sm" disabled title="Belum ada file">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tab: Penilaian --}}
    <div id="tab-grading" class="tab-content">
        <div class="table-card">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-star"></i>
                    <h3>Tugas Menunggu Penilaian</h3>
                </div>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Peserta</th>
                        <th>Judul Tugas</th>
                        <th style="width: 100px;">Jenis</th>
                        <th style="width: 120px;">File</th>
                        <th style="width: 100px;">Nilai</th>
                        <th style="width: 200px;">Feedback</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $noGrade = 1; @endphp
                    @foreach($participants as $participant)
                        @foreach($participant->user->assignments as $assignment)
                            @php
                                $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
                                $latestSubmission = $hasSubmissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;

                                $perluNilai = false;
                                if ($hasSubmissions || $assignment->submission_file_path) {
                                    if (is_null($assignment->grade) && $assignment->is_revision !== 1) {
                                        $perluNilai = true;
                                    } elseif ($assignment->is_revision === 1 && empty($assignment->feedback)) {
                                        $perluNilai = true;
                                    }
                                }
                            @endphp
                            @if($perluNilai)
                                <tr>
                                    <td>{{ $noGrade++ }}</td>
                                    <td>{{ $participant->user->name ?? '-' }}</td>
                                    <td>
                                        {{ $assignment->title ?? '-' }}
                                        @if($hasSubmissions && $latestSubmission->submitted_at)
                                            <div class="submission-info">
                                                <i class="fas fa-clock"></i>
                                                {{ \Carbon\Carbon::parse($latestSubmission->submitted_at)->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->assignment_type === 'tugas_harian')
                                            <span class="badge badge-primary"><i class="fas fa-calendar-day"></i> Harian</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-project-diagram"></i> Proyek</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($hasSubmissions)
                                            <a href="{{ asset('storage/' . $latestSubmission->file_path) }}" target="_blank" class="btn-action btn-outline btn-sm">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @elseif($assignment->submission_file_path)
                                            <a href="{{ asset('storage/' . $assignment->submission_file_path) }}" target="_blank" class="btn-action btn-outline btn-sm">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @else
                                            <span style="color: #9ca3af;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('mentor.penugasan.nilai', $assignment->id) }}" class="d-inline grade-form">
                                            @csrf
                                            <input type="number" name="grade" class="grade-input"
                                                placeholder="0-100" min="0" max="100"
                                                value="{{ $assignment->grade ?? '' }}"
                                                @if($assignment->is_revision === 1) disabled @else required @endif>
                                    </td>
                                    <td>
                                            <input type="text" name="feedback" class="feedback-input"
                                                placeholder="Feedback"
                                                value="{{ $assignment->feedback ?? '' }}"
                                                @if($assignment->is_revision === 1) required @endif>
                                    </td>
                                    <td>
                                            <button type="submit" class="btn-action btn-success btn-sm grade-submit-btn">
                                                <span class="btn-text">
                                                    <i class="fas fa-save"></i> Simpan
                                                </span>
                                                <span class="btn-loading">
                                                    <span class="spinner-border spinner-border-sm"></span>
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach

                    @if($pendingGrading === 0)
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 3rem;">
                                <div class="empty-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <p style="margin-top: 1rem; color: #6b7280;">Semua tugas sudah dinilai</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
// Tab switching
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.closest('.tab-btn').classList.add('active');
}

// Select all participants (only enabled ones)
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.participant-check:not(:disabled)');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}

// Show/hide presentation date based on task type
document.getElementById('assignmentType')?.addEventListener('change', function() {
    const presentationGroup = document.getElementById('presentationDateGroup');
    const presentationDate = document.getElementById('presentationDate');

    if (this.value === 'tugas_proyek') {
        presentationGroup.style.display = 'block';
    } else {
        presentationGroup.style.display = 'none';
        presentationDate.value = '';
    }
});

// Filter tasks
function filterTasks() {
    const filterPeserta = document.getElementById('filterPeserta').value;
    const filterJenis = document.getElementById('filterJenis').value;
    const filterStatus = document.getElementById('filterStatus').value;

    const rows = document.querySelectorAll('.task-row');

    rows.forEach(row => {
        let show = true;

        if (filterPeserta && row.dataset.peserta !== filterPeserta) {
            show = false;
        }

        if (filterJenis && row.dataset.jenis !== filterJenis) {
            show = false;
        }

        if (filterStatus && row.dataset.status !== filterStatus) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    });
}

// View participant detail
function viewParticipantDetail(userId) {
    // Switch to "Semua Tugas" tab and filter by this participant
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    document.getElementById('tab-tasks').classList.add('active');
    document.querySelectorAll('.tab-btn')[2].classList.add('active');

    // Filter by participant
    const filterPeserta = document.getElementById('filterPeserta');
    if (filterPeserta) {
        filterPeserta.value = userId;
        filterTasks();
    }
}

// Form validation and loading state
const createTaskForm = document.getElementById('createTaskForm');
const submitTaskBtn = document.getElementById('submitTaskBtn');

if (createTaskForm && submitTaskBtn) {
    let formSubmitted = false;

    createTaskForm.addEventListener('submit', function(e) {
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }

        // Validate participant selection
        const checkedBoxes = document.querySelectorAll('.participant-check:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu peserta untuk ditugaskan!');
            return false;
        }

        // Show loading state
        const btnText = submitTaskBtn.querySelector('.btn-text');
        const btnLoading = submitTaskBtn.querySelector('.btn-loading');

        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            submitTaskBtn.disabled = true;
        }

        formSubmitted = true;
        return true;
    });
}

// Grade form loading state
document.querySelectorAll('.grade-form').forEach(form => {
    form.addEventListener('submit', function() {
        const btn = this.querySelector('.grade-submit-btn');
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');

        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            btn.disabled = true;
        }
    });
});
</script>
@endpush
