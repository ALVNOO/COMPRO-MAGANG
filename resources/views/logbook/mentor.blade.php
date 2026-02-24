{{--
    MENTOR LOGBOOK PAGE
    Monitor logbook entries of internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Logbook Peserta Magang')

@php
    $role = 'mentor';
    $pageTitle = 'Logbook Peserta';
    $pageSubtitle = 'Pantau aktivitas harian peserta magang Anda';
@endphp

@push('styles')
<style>
/* ============================================
   MENTOR LOGBOOK PAGE STYLES
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
    grid-template-columns: repeat(3, 1fr);
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
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: white;
}

.stat-icon.purple { background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%); }
.stat-icon.green { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
.stat-icon.blue { background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); }

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-value.purple { color: #8B5CF6; }
.stat-value.green { color: #22c55e; }
.stat-value.blue { color: #6366F1; }

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
}

/* Participant Card */
.participant-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.participant-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.participant-header {
    background: white;
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background-color 0.3s;
}

.participant-header:hover {
    background-color: #f8f9fa;
}

.participant-header.active {
    background-color: #FEF2F2;
    border-bottom: 2px solid #EE2E24;
}

.participant-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.participant-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.5rem;
    overflow: hidden;
    flex-shrink: 0;
    flex-shrink: 0;
}

.participant-details .name {
    font-weight: 600;
    color: #1f2937;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.participant-details .email {
    font-size: 0.875rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logbook-count-badge {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.toggle-icon {
    color: #6b7280;
    transition: transform 0.3s;
    font-size: 1.25rem;
}

.participant-header.active .toggle-icon {
    transform: rotate(180deg);
    color: #EE2E24;
}

.logbook-content-wrapper {
    display: none;
    background: #f8f9fa;
    padding: 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.logbook-content-wrapper.show {
    display: block;
}

.logbook-list {
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.logbook-list-header {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 1rem 1.5rem;
}

.logbook-list-header h6 {
    margin: 0;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logbook-item {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: background-color 0.2s;
}

.logbook-item:nth-child(even) {
    background: #f8f9fa;
}

.logbook-item:last-child {
    border-bottom: none;
}

.logbook-item-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.logbook-date-badge {
    min-width: 60px;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border-radius: 8px;
    text-align: center;
    flex-shrink: 0;
}

.logbook-date-badge .day {
    font-weight: 700;
    font-size: 1.5rem;
    line-height: 1;
}

.logbook-date-badge .month {
    font-size: 0.75rem;
    text-transform: uppercase;
}

.logbook-details {
    flex: 1;
}

.logbook-date-text {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #1f2937;
}

.logbook-content {
    color: #495057;
    line-height: 1.6;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.empty-logbook {
    background: white;
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
}

.empty-logbook i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-logbook h6 {
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-logbook p {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
}

.empty-state {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    padding: 3rem;
    text-align: center;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
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
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .participant-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="mentor-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-book"></i> Logbook Peserta Magang</h1>
            <p>Pantau aktivitas harian peserta magang Anda</p>
        </div>
    </div>
</div>

@if($participants->count() > 0)
    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value purple">{{ $participants->count() }}</div>
            <div class="stat-label">Total Peserta</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-value green">
                {{ $participants->sum(function($p) { return $p['logbooks']->count(); }) }}
            </div>
            <div class="stat-label">Total Logbook</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-value blue">{{ \Carbon\Carbon::today()->format('d') }}</div>
            <div class="stat-label">{{ \Carbon\Carbon::today()->locale('id')->isoFormat('MMMM Y') }}</div>
        </div>
    </div>

    {{-- Participants List --}}
    <div class="participants-container">
        @foreach($participants as $index => $participant)
            <div class="participant-card">
                <div class="participant-header" data-target="logbook-{{ $index }}">
                    <div class="participant-info">
                        <div class="participant-avatar">
                            @if($participant['user']->profile_picture)
                                <img src="{{ asset('storage/' . $participant['user']->profile_picture) }}" alt="{{ $participant['user']->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="participant-details">
                            <div class="name">{{ $participant['user']->name }}</div>
                            <div class="email">
                                <i class="fas fa-envelope"></i>
                                {{ $participant['user']->email }}
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <span class="logbook-count-badge">
                            <i class="fas fa-book"></i>
                            {{ $participant['logbooks']->count() }} Logbook
                        </span>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                </div>

                <div class="logbook-content-wrapper" id="logbook-{{ $index }}">
                    @if($participant['logbooks']->count() > 0)
                        <div class="logbook-list">
                            <div class="logbook-list-header">
                                <h6>
                                    <i class="fas fa-list"></i>
                                    Daftar Logbook
                                </h6>
                            </div>
                            <div>
                                @foreach($participant['logbooks'] as $logIdx => $logbook)
                                    <div class="logbook-item">
                                        <div class="logbook-item-content">
                                            <div class="logbook-date-badge">
                                                <div class="day">{{ $logbook->date->format('d') }}</div>
                                                <div class="month">{{ $logbook->date->format('M') }}</div>
                                            </div>
                                            <div class="logbook-details">
                                                <div class="logbook-date-text">
                                                    <i class="fas fa-calendar" style="color: #EE2E24;"></i>
                                                    <strong>{{ $logbook->date->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>
                                                </div>
                                                <div class="logbook-content">{{ $logbook->content }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="empty-logbook">
                            <i class="fas fa-book-open"></i>
                            <h6>Belum Ada Logbook</h6>
                            <p>Peserta ini belum mengisi logbook.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-users-slash"></i>
        <h5>Belum Ada Peserta</h5>
        <p>Belum ada peserta magang yang di-assign ke Anda.</p>
    </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headers = document.querySelectorAll('.participant-header');

    headers.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);

            // Toggle active class on header
            this.classList.toggle('active');

            // Toggle show class on content
            content.classList.toggle('show');
        });
    });
});
</script>
@endpush
