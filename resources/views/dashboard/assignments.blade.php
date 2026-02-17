{{--
    USER ASSIGNMENTS PAGE
    Task management and grading for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Penugasan & Penilaian')

@php
    $role = 'participant';
    $pageTitle = 'Tugas';

    $totalAssignments = $assignments->count();
    $sortedAssignments = $assignments->sortBy('created_at');

    $submittedCount = $assignments->filter(function($a) {
        if (!$a->submitted_at) return false;
        if ($a->is_revision === 1) {
            $lastSubmission = $a->submissions ? $a->submissions->sortByDesc('submitted_at')->first() : null;
            if (!$lastSubmission || ($a->updated_at && $lastSubmission->submitted_at < $a->updated_at)) {
                return false;
            }
        }
        return true;
    })->count();

    $pendingCount = $totalAssignments - $submittedCount;
    $gradedCount = $assignments->whereNotNull('grade')->count();
    $avgGrade = $gradedCount > 0 ? round($assignments->whereNotNull('grade')->avg('grade'), 1) : null;
@endphp

@push('styles')
<style>
/* ============================================
   ASSIGNMENTS PAGE STYLES
   ============================================ */

/* Hero Section */
.page-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.page-hero::before {
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

.stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.stat-icon.green { background: linear-gradient(135deg, #22c55e, #16a34a); color: white; }
.stat-icon.amber { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }
.stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; }

.stat-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1.2;
}

.stat-info p {
    font-size: 0.8rem;
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

.table-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.table-card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-card-header .badge-count {
    background: rgba(238, 46, 36, 0.1);
    color: #EE2E24;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.assignment-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.assignment-table thead th {
    background: #f9fafb;
    padding: 0.875rem 1.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    white-space: nowrap;
}

.assignment-table tbody td {
    padding: 1rem 1.25rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.assignment-table tbody tr {
    transition: background-color 0.2s;
}

.assignment-table tbody tr:hover {
    background-color: rgba(238, 46, 36, 0.03);
}

.assignment-table tbody tr:last-child td {
    border-bottom: none;
}

/* Assignment Description Cell */
.assignment-desc {
    max-width: 280px;
}

.assignment-desc strong {
    display: block;
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 0.25rem;
    line-height: 1.4;
}

.assignment-desc .meta {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    font-size: 0.78rem;
    font-weight: 600;
    white-space: nowrap;
}

.status-badge.submitted {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
}

.status-badge.pending {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
}

.status-badge.revision {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

/* Grade Badge */
.grade-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.85rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.grade-badge.excellent {
    background: linear-gradient(135deg, #10B981, #059669);
}

.grade-badge.good {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.grade-badge.average {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.grade-badge.low {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

/* Deadline styling */
.deadline-text {
    font-size: 0.85rem;
    white-space: nowrap;
}

.deadline-text.overdue {
    color: #dc2626;
    font-weight: 600;
}

.deadline-text.upcoming {
    color: #d97706;
}

.deadline-text.normal {
    color: #374151;
}

/* Feedback text */
.feedback-text {
    font-size: 0.83rem;
    color: #4b5563;
    max-width: 200px;
    line-height: 1.5;
}

/* Action Buttons */
.btn-submit-task {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 1rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(238, 46, 36, 0.25);
    white-space: nowrap;
}

.btn-submit-task:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.35);
    color: white;
}

.btn-download-file {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-download-file:hover {
    background: rgba(59, 130, 246, 0.2);
    color: #1d4ed8;
    transform: translateY(-1px);
}

.completed-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 0.85rem;
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Empty State */
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
    margin-bottom: 1.5rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.btn-empty-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
}

.btn-empty-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.35);
    color: white;
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
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    padding: 1rem 1.5rem;
}

.modal-body .task-description {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    border-left: 4px solid #EE2E24;
}

.modal-body .task-description p {
    color: #374151;
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.6;
}

.modal-body label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    display: block;
    font-size: 0.9rem;
}

.modal-body .form-control {
    border-radius: 12px;
    border: 1px solid #d1d5db;
    padding: 0.65rem 1rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.modal-body .form-control:focus {
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.modal-body .form-text {
    font-size: 0.78rem;
    color: #9ca3af;
    margin-top: 0.4rem;
}

.btn-modal-cancel {
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-modal-cancel:hover {
    background: #f3f4f6;
}

.btn-modal-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-modal-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
    color: white;
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .page-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-text h1 {
        font-size: 1.35rem;
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .stat-card {
        padding: 1rem;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .stat-info h3 {
        font-size: 1.25rem;
    }

    .assignment-table thead th,
    .assignment-table tbody td {
        padding: 0.75rem 0.75rem;
        font-size: 0.78rem;
    }

    .assignment-desc {
        max-width: 180px;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="page-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-clipboard-check"></i>
                Penugasan & Penilaian
            </h1>
            <p>Kelola tugas dan lihat penilaian dari pembimbing Anda</p>
        </div>
        @if($pendingCount > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $pendingCount }}</h4>
                <p>Tugas Pending</p>
            </div>
        </div>
        @elseif($totalAssignments > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $submittedCount }}/{{ $totalAssignments }}</h4>
                <p>Tugas Selesai</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-list-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalAssignments }}</h3>
            <p>Total Tugas</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $submittedCount }}</h3>
            <p>Sudah Dikumpulkan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon amber">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $pendingCount }}</h3>
            <p>Belum Dikumpulkan</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $avgGrade !== null ? $avgGrade . '/10' : '-' }}</h3>
            <p>Rata-rata Nilai</p>
        </div>
    </div>
</div>

{{-- Assignments Table --}}
@if($totalAssignments > 0)
<div class="table-card">
    <div class="table-card-header">
        <h3>
            <i class="fas fa-tasks" style="color: #EE2E24;"></i>
            Daftar Tugas
        </h3>
        <span class="badge-count">{{ $totalAssignments }} tugas</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="assignment-table">
            <thead>
                <tr>
                    <th style="width: 45px;">No</th>
                    <th>Deskripsi Tugas</th>
                    <th>Deadline</th>
                    <th>File Tugas</th>
                    <th>Status</th>
                    <th>Nilai</th>
                    <th>Feedback</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($sortedAssignments as $assignment)
                @php
                    $showBelumKumpul = false;
                    if ($assignment->is_revision === 1) {
                        $lastSubmission = $assignment->submissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;
                        if (!$lastSubmission || ($assignment->updated_at && $lastSubmission->submitted_at < $assignment->updated_at)) {
                            $showBelumKumpul = true;
                        }
                    }

                    $isOverdue = $assignment->deadline && \Carbon\Carbon::parse($assignment->deadline)->isPast() && !$assignment->submitted_at;
                    $isUpcoming = $assignment->deadline && \Carbon\Carbon::parse($assignment->deadline)->diffInDays(now()) <= 3 && \Carbon\Carbon::parse($assignment->deadline)->isFuture();
                @endphp
                <tr>
                    <td style="font-weight: 600; color: #6b7280;">{{ $no++ }}</td>
                    <td>
                        <div class="assignment-desc">
                            <strong>{{ Str::limit($assignment->description, 80) }}</strong>
                            <span class="meta">
                                <i class="fas fa-calendar-plus"></i> {{ $assignment->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </td>
                    <td>
                        @if($assignment->deadline)
                            <span class="deadline-text {{ $isOverdue ? 'overdue' : ($isUpcoming ? 'upcoming' : 'normal') }}">
                                @if($isOverdue)<i class="fas fa-exclamation-triangle"></i> @endif
                                {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                            </span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($assignment->file_path)
                            <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="btn-download-file">
                                <i class="fas fa-download"></i> Download
                            </a>
                        @else
                            <span style="color: #9ca3af; font-size: 0.83rem;">Tidak ada file</span>
                        @endif
                    </td>
                    <td>
                        @if(!$assignment->submitted_at)
                            <span class="status-badge pending">
                                <i class="fas fa-clock"></i> Belum dikumpulkan
                            </span>
                        @elseif($showBelumKumpul)
                            <span class="status-badge revision">
                                <i class="fas fa-redo"></i> Perlu Revisi
                            </span>
                        @else
                            <span class="status-badge submitted">
                                <i class="fas fa-check-circle"></i> Sudah dikumpulkan
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($assignment->grade !== null)
                            @php
                                $gradeClass = 'good';
                                if ($assignment->grade >= 9) $gradeClass = 'excellent';
                                elseif ($assignment->grade >= 7) $gradeClass = 'good';
                                elseif ($assignment->grade >= 5) $gradeClass = 'average';
                                else $gradeClass = 'low';
                            @endphp
                            <span class="grade-badge {{ $gradeClass }}">
                                <i class="fas fa-star"></i> {{ $assignment->grade }}/10
                            </span>
                        @else
                            <span style="color: #9ca3af; font-size: 0.83rem;">Belum dinilai</span>
                        @endif
                    </td>
                    <td>
                        @if($assignment->feedback)
                            <span class="feedback-text">{{ Str::limit($assignment->feedback, 60) }}</span>
                        @else
                            <span style="color: #9ca3af; font-size: 0.83rem;">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if(!$assignment->submitted_at || $assignment->is_revision === 1)
                            <button type="button" class="btn-submit-task" data-bs-toggle="modal" data-bs-target="#submitModal{{ $assignment->id }}">
                                <i class="fas fa-upload"></i>
                                {{ !$assignment->submitted_at ? 'Kumpulkan' : 'Revisi' }}
                            </button>
                        @else
                            <span class="completed-badge">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
{{-- Empty State --}}
<div class="table-card">
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
        @if(isset($application) && $application && $application->status == 'accepted')
            <h4>Belum Ada Tugas</h4>
            <p>Tugas dari pembimbing akan muncul di sini. Tunggu hingga pembimbing memberikan tugas pertama Anda.</p>
        @else
            <h4>Belum Ada Tugas</h4>
            <p>Tugas akan tersedia setelah Anda diterima dalam program magang.</p>
            <a href="{{ route('dashboard.status') }}" class="btn-empty-action">
                <i class="fas fa-clipboard-list"></i> Lihat Status Pengajuan
            </a>
        @endif
    </div>
</div>
@endif

{{-- Submit Assignment Modals --}}
@foreach($assignments as $assignment)
@if(!$assignment->submitted_at || $assignment->is_revision === 1)
<div class="modal fade" id="submitModal{{ $assignment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload" style="color: #EE2E24;"></i>
                    {{ !$assignment->submitted_at ? 'Kumpulkan Tugas' : 'Kumpulkan Ulang (Revisi)' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dashboard.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="task-description">
                        <label style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin-bottom: 0.5rem;">Deskripsi Tugas</label>
                        <p>{{ $assignment->description }}</p>
                    </div>

                    @if($assignment->deadline)
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem; padding: 0.75rem 1rem; background: {{ \Carbon\Carbon::parse($assignment->deadline)->isPast() ? 'rgba(239, 68, 68, 0.08)' : 'rgba(59, 130, 246, 0.08)' }}; border-radius: 10px;">
                        <i class="fas fa-calendar-day" style="color: {{ \Carbon\Carbon::parse($assignment->deadline)->isPast() ? '#dc2626' : '#2563eb' }};"></i>
                        <span style="font-size: 0.85rem; color: {{ \Carbon\Carbon::parse($assignment->deadline)->isPast() ? '#dc2626' : '#374151' }}; font-weight: 500;">
                            Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->locale('id')->isoFormat('D MMMM Y') }}
                            @if(\Carbon\Carbon::parse($assignment->deadline)->isPast())
                                <strong>(Sudah lewat)</strong>
                            @endif
                        </span>
                    </div>
                    @endif

                    @if($assignment->online_text)
                    <div class="mb-3">
                        <label for="online_text_{{ $assignment->id }}">Online Text (opsional)</label>
                        <textarea class="form-control" id="online_text_{{ $assignment->id }}" name="online_text" rows="3" placeholder="Tuliskan jawaban atau catatan tambahan..."></textarea>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="submission_file_{{ $assignment->id }}">
                            Upload File Tugas <span style="color: #EF4444;">*</span>
                        </label>
                        <input type="file" class="form-control" id="submission_file_{{ $assignment->id }}" name="submission_file" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Format: PDF, DOC, DOCX (Maks. 2MB)
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-submit">
                        <i class="fas fa-upload"></i>
                        {{ !$assignment->submitted_at ? 'Kumpulkan' : 'Kumpulkan Ulang' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@endsection

@push('scripts')
<script>
// Assignments page scripts
</script>
@endpush
