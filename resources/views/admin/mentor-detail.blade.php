{{--
    ADMIN MENTOR DETAIL PAGE
    Detail pembimbing dengan peserta yang dibimbing
    Using unified layout with design system
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Detail Pembimbing')

@php
    use Carbon\Carbon;
    $role = 'admin';

    $mentorName = $mentor->division_mentor->mentor_name ?? $mentor->name;
    $parts = explode(' ', $mentorName);
    $initials = strtoupper(substr($parts[0], 0, 1)) . (isset($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) : '');

    $activeCount   = $participants->where('status', 'accepted')->count();
    $finishedCount = $participants->where('status', 'finished')->count();
    $totalCount    = $participants->count();
@endphp

@push('styles')
<style>
/* ── Profile Card (two-column) ── */
.profile-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
    display: flex;
}

/* Left column — gradient identity panel */
.profile-left {
    width: 240px;
    flex-shrink: 0;
    background: linear-gradient(160deg, #EE2E24 0%, #9B1C1C 100%);
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.profile-left::before {
    content: '';
    position: absolute;
    top: -40%;
    right: -30%;
    width: 80%;
    height: 80%;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
}

.profile-left::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: -20%;
    width: 60%;
    height: 60%;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
}

.profile-left .profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.6);
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: #fff;
    overflow: hidden;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.profile-left .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }

.profile-name {
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 0.625rem;
    position: relative;
    z-index: 1;
}

.profile-left .badge {
    position: relative;
    z-index: 1;
    background: rgba(255,255,255,0.2);
    color: #fff;
    border-color: rgba(255,255,255,0.4);
    font-size: 0.7rem;
}

/* Right column — info + stats */
.profile-right {
    flex: 1;
    padding: 1.75rem 2rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.profile-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem 2rem;
}

.profile-info-item {}

.profile-info-label {
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #9CA3AF;
    margin-bottom: 0.25rem;
}

.profile-info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.profile-info-value i { color: #EE2E24; font-size: 0.8rem; }

/* Mini stats strip */
.profile-stats {
    display: flex;
    gap: 1px;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #E5E7EB;
}

.profile-stat {
    flex: 1;
    padding: 0.875rem 1rem;
    text-align: center;
    background: #F9FAFB;
}

.profile-stat + .profile-stat { border-left: 1px solid #E5E7EB; }

.profile-stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #111827;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.profile-stat-value.clr-success { color: #16A34A; }
.profile-stat-value.clr-info    { color: #0284C7; }
.profile-stat-value.clr-primary { color: #EE2E24; }

.profile-stat-label {
    font-size: 0.72rem;
    color: #6B7280;
    font-weight: 500;
}

/* Empty State */
.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state i { font-size: 3.5rem; color: #D1D5DB; margin-bottom: 1rem; display: block; }
.empty-state h4 { font-size: 1.1rem; font-weight: 600; color: #374151; margin: 0 0 0.5rem; }
.empty-state p { color: #6B7280; margin: 0; font-size: 0.875rem; }

@media (max-width: 900px) {
    .profile-card { flex-direction: column; }
    .profile-left { width: 100%; padding: 1.5rem; flex-direction: row; text-align: left; gap: 1rem; }
    .profile-left .profile-avatar { width: 80px; height: 80px; font-size: 1.8rem; margin-bottom: 0; flex-shrink: 0; }
    .profile-left .badge { align-self: flex-start; }
    .profile-info-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Detail Pembimbing"
    :description="$mentorName"
    icon="fas fa-user-tie"
    role="admin"
>
    <a href="{{ route('admin.mentors') }}" class="ctx-btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</x-dashboard.page-context-bar>

{{-- Profile Card (two-column) --}}
<div class="profile-card">

    {{-- Left: identity --}}
    <div class="profile-left">
        <div class="profile-avatar">
            @if($mentor->profile_picture)
                <img src="{{ asset('storage/' . $mentor->profile_picture) }}" alt="{{ $mentorName }}">
            @else
                {{ $initials }}
            @endif
        </div>
        <div class="profile-name">{{ $mentorName }}</div>
        <span class="badge badge-info">Pembimbing Lapangan</span>
    </div>

    {{-- Right: info + mini stats --}}
    <div class="profile-right">
        <div class="profile-info-grid">
            <div class="profile-info-item">
                <div class="profile-info-label">Divisi</div>
                <div class="profile-info-value">
                    <i class="fas fa-building"></i>
                    {{ $mentor->division_admin->division_name ?? '-' }}
                </div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">NIK</div>
                <div class="profile-info-value">
                    <i class="fas fa-id-card"></i>
                    {{ $mentor->division_mentor->nik_number ?? '-' }}
                </div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Email</div>
                <div class="profile-info-value">
                    <i class="fas fa-envelope"></i>
                    {{ $mentor->email }}
                </div>
            </div>
        </div>

        <div class="profile-stats">
            <div class="profile-stat">
                <div class="profile-stat-value clr-success">{{ $activeCount }}</div>
                <div class="profile-stat-label">Peserta Aktif</div>
            </div>
            <div class="profile-stat">
                <div class="profile-stat-value clr-info">{{ $finishedCount }}</div>
                <div class="profile-stat-label">Peserta Selesai</div>
            </div>
            <div class="profile-stat">
                <div class="profile-stat-value clr-primary">{{ $totalCount }}</div>
                <div class="profile-stat-label">Total Peserta</div>
            </div>
        </div>
    </div>

</div>

{{-- Participants Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-list"></i>
            <span>Daftar Peserta Magang</span>
        </div>
        <span class="badge badge-gray">{{ $totalCount }} Peserta</span>
    </div>

    @if($participants->count() > 0)
    <div class="overflow-x-auto">
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
                    <td style="text-align:left;">
                        <span style="font-weight:600;color:#111827;">{{ $participant->user->name ?? '-' }}</span>
                    </td>
                    <td>{{ $participant->user->nim ?? '-' }}</td>
                    <td>{{ $participant->user->university ?? '-' }}</td>
                    <td>
                        @if($participant->status == 'accepted')
                            <span class="status-badge status-active">
                                <i class="fas fa-circle-dot"></i> Aktif
                            </span>
                        @elseif($participant->status == 'finished')
                            <span class="status-badge status-finished">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        @else
                            <span class="status-badge status-pending">
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

@endsection
