{{--
    ADMIN LOGBOOK PAGE
    View logbooks submitted by interns
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Logbook Peserta')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Logbook Peserta Magang';
    $pageSubtitle = 'Lihat logbook yang sudah diisi oleh peserta magang';

    // Count total logbooks
    $totalLogbooks = collect($participants)->sum(fn($p) => $p['logbooks']->count());
    $totalParticipants = count($participants);
@endphp

@push('styles')
<style>
/* ============================================
   LOGBOOK PAGE STYLES
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

.hero-stats {
    display: flex;
    gap: 1.5rem;
}

.hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-stat h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.hero-stat p {
    font-size: 0.8rem;
    opacity: 0.9;
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

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.filter-group label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-select {
    padding: 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white;
    min-width: 200px;
    transition: all 0.2s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    margin-left: auto;
}

.filter-btn {
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
}

.filter-btn.primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.filter-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.filter-btn.secondary {
    background: #f3f4f6;
    color: #374151;
}

.filter-btn.secondary:hover {
    background: #e5e7eb;
}

/* Participant Cards Container */
.participants-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Participant Card */
.participant-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
}

.participant-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Participant Header */
.participant-header {
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
}

.participant-header:hover {
    background: rgba(238, 46, 36, 0.02);
}

.participant-header.active {
    background: rgba(238, 46, 36, 0.05);
    border-bottom: 2px solid #EE2E24;
}

.participant-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.participant-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.participant-details .name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.participant-details .meta {
    font-size: 0.8rem;
    color: #6b7280;
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.participant-details .meta i {
    width: 16px;
    color: #9ca3af;
}

.participant-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.logbook-count {
    padding: 0.375rem 0.75rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.toggle-icon {
    color: #6b7280;
    transition: transform 0.3s ease;
}

.participant-header.active .toggle-icon {
    transform: rotate(180deg);
    color: #EE2E24;
}

/* Logbook Content */
.logbook-content {
    display: none;
    padding: 1.5rem;
    background: #f9fafb;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.logbook-content.show {
    display: block;
}

/* Logbook Table */
.logbook-table-wrapper {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}

.logbook-table {
    width: 100%;
    border-collapse: collapse;
}

.logbook-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.logbook-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.logbook-table td {
    padding: 1rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: top;
}

.logbook-table tbody tr:last-child td {
    border-bottom: none;
}

.logbook-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.logbook-date {
    font-weight: 600;
    color: #1f2937;
    white-space: nowrap;
}

.logbook-content-text {
    white-space: pre-wrap;
    word-wrap: break-word;
    line-height: 1.6;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state i {
    font-size: 3rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
    font-size: 0.9rem;
}

/* Main Empty State */
.main-empty-state {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    text-align: center;
    padding: 4rem 2rem;
}

.main-empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.main-empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.main-empty-state p {
    color: #6b7280;
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .hero-stats {
        flex-direction: row;
        width: 100%;
    }

    .hero-stat {
        flex: 1;
    }

    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group {
        width: 100%;
    }

    .filter-select {
        width: 100%;
    }

    .filter-actions {
        margin-left: 0;
        margin-top: 0.5rem;
    }

    .participant-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .participant-actions {
        width: 100%;
        justify-content: space-between;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-book"></i> Logbook Peserta Magang</h1>
            <p>Lihat dan pantau logbook yang sudah diisi oleh peserta magang</p>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <h4>{{ $totalParticipants }}</h4>
                <p>Peserta</p>
            </div>
            <div class="hero-stat">
                <h4>{{ $totalLogbooks }}</h4>
                <p>Total Logbook</p>
            </div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.logbook') }}" id="filterForm" class="filter-bar">
    <div class="filter-group">
        <label>Divisi</label>
        <select class="filter-select" id="division_id" name="division_id">
            <option value="">Semua Divisi</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                    {{ $division->division_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label>Pembimbing</label>
        <select class="filter-select" id="mentor_id" name="mentor_id">
            <option value="">Semua Pembimbing</option>
            @foreach($mentors as $mentor)
                <option value="{{ $mentor->id }}" {{ $filterMentor == $mentor->id ? 'selected' : '' }}>
                    {{ $mentor->mentor_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="filter-actions">
        <button type="submit" class="filter-btn primary">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('admin.logbook') }}" class="filter-btn secondary">
            <i class="fas fa-redo"></i> Reset
        </a>
    </div>
</form>

{{-- Participants List --}}
@if($participants->count() > 0)
<div class="participants-container">
    @foreach($participants as $index => $participant)
    <div class="participant-card">
        <div class="participant-header" data-target="logbook-{{ $index }}">
            <div class="participant-info">
                <div class="participant-avatar">
                    {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                </div>
                <div class="participant-details">
                    <div class="name">{{ $participant['user']->name }}</div>
                    <div class="meta">
                        <span><i class="fas fa-envelope"></i> {{ $participant['user']->email }}</span>
                        @if(isset($participant['application']) && $participant['application']->divisionAdmin)
                            <span><i class="fas fa-building"></i> {{ $participant['application']->divisionAdmin->division_name }}</span>
                        @endif
                        @if(isset($participant['application']) && $participant['application']->divisionMentor)
                            <span><i class="fas fa-user-tie"></i> {{ $participant['application']->divisionMentor->mentor_name }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="participant-actions">
                <span class="logbook-count">{{ $participant['logbooks']->count() }} Logbook</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
        </div>
        <div class="logbook-content" id="logbook-{{ $index }}">
            @if($participant['logbooks']->count() > 0)
            <div class="logbook-table-wrapper">
                <table class="logbook-table">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 85%;">Isi Logbook</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participant['logbooks'] as $logbook)
                        <tr>
                            <td>
                                <span class="logbook-date">{{ $logbook->date ? $logbook->date->format('d M Y') : '-' }}</span>
                            </td>
                            <td>
                                <div class="logbook-content-text">{{ $logbook->content ?? '-' }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-book-open"></i>
                <h4>Belum Ada Logbook</h4>
                <p>Peserta ini belum mengisi logbook</p>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="main-empty-state">
    <i class="fas fa-book"></i>
    <h4>Tidak Ada Data</h4>
    <p>Belum ada data logbook untuk filter yang dipilih</p>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion toggle for participant cards
    const headers = document.querySelectorAll('.participant-header');

    headers.forEach(header => {
        header.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);

            if (content) {
                // Toggle active class on header
                this.classList.toggle('active');

                // Toggle show class on content
                content.classList.toggle('show');
            }
        });
    });

    // Update mentor dropdown + auto-submit when division changes
    const divisionSelect = document.getElementById('division_id');
    const filterForm = document.getElementById('filterForm');

    if (divisionSelect && filterForm) {
        divisionSelect.addEventListener('change', function() {
            const divisionId = this.value;
            const mentorSelect = document.getElementById('mentor_id');
            const currentMentorId = '{{ $filterMentor }}';

            // Fetch mentors for selected division
            fetch(`{{ route('admin.logbook.mentors') }}?division_id=${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    mentorSelect.innerHTML = '<option value="">Semua Pembimbing</option>';
                    data.mentors.forEach(mentor => {
                        const option = document.createElement('option');
                        option.value = mentor.id;
                        option.textContent = mentor.mentor_name;
                        if (mentor.id == currentMentorId) {
                            option.selected = true;
                        }
                        mentorSelect.appendChild(option);
                    });

                    // Auto-submit form after dropdown update
                    filterForm.submit();
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Submit anyway if fetch fails
                    filterForm.submit();
                });
        });
    }
});
</script>
@endpush
