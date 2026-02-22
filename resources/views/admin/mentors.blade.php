{{--
    ADMIN MENTORS PAGE
    Monitor and manage field mentors with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Monitoring Pembimbing')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Monitoring Pembimbing';
    $pageSubtitle = 'Pantau kinerja pembimbing dan peserta magang';

    // Count stats
    $totalMentors = $mentors->total();
    $activeMentors = 0;
    $totalMentees = 0;

    foreach($mentors as $mentor) {
        $divisionMentor = $mentor->division_mentor ?? null;
        if ($divisionMentor) {
            $count = \App\Models\InternshipApplication::where('division_mentor_id', $divisionMentor->id)
                ->whereIn('status', ['accepted', 'finished'])
                ->where(function($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->count();
            $totalMentees += $count;
            if ($count > 0) {
                $activeMentors++;
            }
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   MENTORS PAGE STYLES
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
}

.stat-icon.total { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; }
.stat-icon.active { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.stat-icon.mentees { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }

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

.mentors-table {
    width: 100%;
    border-collapse: collapse;
}

.mentors-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.mentors-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.mentors-table td {
    padding: 1rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.mentors-table tbody tr {
    transition: all 0.2s ease;
}

.mentors-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

/* Mentor Info */
.mentor-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.mentor-avatar {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    flex-shrink: 0;
}

.mentor-details {
    display: flex;
    flex-direction: column;
}

.mentor-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.125rem;
}

.mentor-name:hover {
    color: #EE2E24;
}

.mentor-username {
    font-size: 0.75rem;
    color: #9ca3af;
}

.mentor-email {
    font-size: 0.85rem;
    color: #6b7280;
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Mentee Badge */
.mentee-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.65rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.mentee-badge.has-mentees {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.mentee-badge.no-mentees {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

/* Action Buttons */
.action-btns {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 0.875rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    gap: 0.375rem;
    text-decoration: none;
}

.action-btn.view {
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
}

.action-btn.view:hover {
    background: rgba(59, 130, 246, 0.2);
}

.action-btn.reset {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.action-btn.reset:hover {
    background: rgba(245, 158, 11, 0.2);
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

/* Pagination */
.pagination-wrapper {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    justify-content: center;
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
    max-width: 480px;
    width: 100%;
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
    color: #f59e0b;
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

.warning-box {
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.warning-box i {
    color: #f59e0b;
    font-size: 1.25rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.warning-box-text {
    font-size: 0.9rem;
    color: #92400e;
}

.warning-box-text strong {
    display: block;
    margin-bottom: 0.25rem;
}

.reset-info {
    margin-bottom: 1rem;
}

.reset-info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.reset-info-row:last-child {
    border-bottom: none;
}

.reset-info-label {
    font-size: 0.85rem;
    color: #6b7280;
}

.reset-info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
}

.reset-info-value code {
    background: #f3f4f6;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-family: monospace;
    font-size: 0.85rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.modal-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-btn.cancel {
    background: #f3f4f6;
    color: #4b5563;
}

.modal-btn.cancel:hover {
    background: #e5e7eb;
}

.modal-btn.confirm {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.modal-btn.confirm:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

/* Toast Notification */
.toast-container {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 1100;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.toast {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease;
    max-width: 400px;
}

.toast.success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.toast.error {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.toast-close {
    margin-left: auto;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 6px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: white;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
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

    .filter-input {
        width: 100%;
    }

    .mentors-table {
        font-size: 0.8rem;
    }

    .mentors-table th,
    .mentors-table td {
        padding: 0.75rem 0.5rem;
    }

    .mentor-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
    }

    .action-btns {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="mentors-page" x-data="mentorsManager()">
    {{-- Hero Section --}}
    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><i class="fas fa-user-tie"></i> Monitoring Pembimbing</h1>
                <p>Pantau kinerja pembimbing lapangan dan peserta yang dibimbing</p>
            </div>
            @if($activeMentors > 0)
            <div class="hero-badge">
                <div class="hero-badge-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="hero-badge-text">
                    <h4>{{ $activeMentors }}</h4>
                    <p>Pembimbing Aktif</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalMentors }}</h3>
                <p>Total Pembimbing</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $activeMentors }}</h3>
                <p>Pembimbing Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon mentees">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalMentees }}</h3>
                <p>Total Peserta Dibimbing</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            type="text"
            class="filter-input"
            placeholder="Cari nama pembimbing atau email..."
            x-model="searchQuery"
            @input="filterTable()"
        >
        <button class="filter-btn" @click="resetFilters()">
            <i class="fas fa-sync-alt"></i> Reset
        </button>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-table"></i>
                <span>Data Pembimbing Lapangan</span>
            </div>
            <span class="text-sm text-gray-500">Halaman {{ $mentors->currentPage() }} dari {{ $mentors->lastPage() }}</span>
        </div>

        @if($mentors->count() > 0)
        <div class="overflow-x-auto">
            <table class="mentors-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Pembimbing</th>
                        <th>Email</th>
                        <th style="width: 130px;">Peserta</th>
                        <th style="width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="mentorsTableBody">
                    @foreach($mentors as $mentor)
                    @php
                        $divisionMentor = $mentor->division_mentor ?? null;
                        $participant = $divisionMentor ? \App\Models\InternshipApplication::where('division_mentor_id', $divisionMentor->id)
                            ->whereIn('status', ['accepted', 'finished'])
                            ->where(function($q) {
                                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                            })
                            ->get() : collect();
                        $participantCount = $participant->count();
                        $mentorName = $divisionMentor->mentor_name ?? $mentor->name;
                        $initials = collect(explode(' ', $mentorName))->take(2)->map(fn($n) => strtoupper(substr($n, 0, 1)))->join('');
                    @endphp
                    <tr class="mentor-row"
                        data-name="{{ strtolower($mentorName) }}"
                        data-email="{{ strtolower($mentor->email) }}">
                        <td>{{ $loop->iteration + ($mentors->currentPage() - 1) * $mentors->perPage() }}</td>
                        <td>
                            <div class="mentor-info">
                                <div class="mentor-avatar">{{ $initials }}</div>
                                <div class="mentor-details">
                                    <a href="{{ route('admin.mentor.detail', $mentor->id) }}" class="mentor-name">
                                        {{ $mentorName }}
                                    </a>
                                    <span class="mentor-username">{{ '@' . $mentor->username }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="mentor-email" title="{{ $mentor->email }}">{{ $mentor->email }}</span>
                        </td>
                        <td>
                            <span class="mentee-badge {{ $participantCount > 0 ? 'has-mentees' : 'no-mentees' }}">
                                <i class="fas fa-users"></i>
                                {{ $participantCount }} Peserta
                            </span>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.mentor.detail', $mentor->id) }}" class="action-btn view">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <button
                                    class="action-btn reset"
                                    @click="openResetModal({{ json_encode([
                                        'id' => $mentor->id,
                                        'name' => $mentorName,
                                        'username' => $mentor->username,
                                    ]) }})"
                                >
                                    <i class="fas fa-key"></i> Reset
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            {{ $mentors->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <h4>Belum Ada Pembimbing</h4>
            <p>Pembimbing akan dibuat otomatis ketika Anda menambahkan divisi baru</p>
        </div>
        @endif
    </div>

    {{-- Reset Password Modal --}}
    <div class="modal-overlay" :class="{ 'active': showResetModal }" @click.self="closeResetModal()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-key"></i>
                    <span>Reset Password Pembimbing</span>
                </div>
                <button class="modal-close" @click="closeResetModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="'/admin/mentor/' + selectedMentor?.id + '/reset-password'" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="warning-box">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="warning-box-text">
                            <strong>Perhatian!</strong>
                            Password akan direset menjadi "mentor123"
                        </div>
                    </div>

                    <div class="reset-info">
                        <div class="reset-info-row">
                            <span class="reset-info-label">Nama Pembimbing</span>
                            <span class="reset-info-value" x-text="selectedMentor?.name"></span>
                        </div>
                        <div class="reset-info-row">
                            <span class="reset-info-label">Username</span>
                            <span class="reset-info-value"><code x-text="selectedMentor?.username"></code></span>
                        </div>
                        <div class="reset-info-row">
                            <span class="reset-info-label">Password Baru</span>
                            <span class="reset-info-value"><code>mentor123</code></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeResetModal()">
                        Batal
                    </button>
                    <button type="submit" class="modal-btn confirm">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast Notifications --}}
    <div class="toast-container">
        @if(session('success'))
        <div class="toast success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="toast-close" @click="show = false">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="toast error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="toast-close" @click="show = false">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function mentorsManager() {
    return {
        searchQuery: '',
        showResetModal: false,
        selectedMentor: null,

        filterTable() {
            const rows = document.querySelectorAll('.mentor-row');

            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';

                const matchesSearch = !this.searchQuery ||
                    name.includes(this.searchQuery.toLowerCase()) ||
                    email.includes(this.searchQuery.toLowerCase());

                row.style.display = matchesSearch ? '' : 'none';
            });
        },

        resetFilters() {
            this.searchQuery = '';
            this.filterTable();
        },

        openResetModal(mentor) {
            this.selectedMentor = mentor;
            this.showResetModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeResetModal() {
            this.showResetModal = false;
            this.selectedMentor = null;
            document.body.style.overflow = '';
        }
    }
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const manager = document.querySelector('[x-data]')?.__x?.$data;
        if (manager?.showResetModal) {
            manager.closeResetModal();
        }
    }
});
</script>
@endpush
