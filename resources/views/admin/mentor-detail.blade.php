@extends('layouts.dashboard-unified')

@section('content')
@php $role = 'admin'; @endphp

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
            <h3>{{ $participants->where('status', 'accepted')->count() }}</h3>
            <p>Peserta Aktif</p>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $participants->where('status', 'finished')->count() }}</h3>
            <p>Peserta Selesai</p>
        </div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $participants->count() }}</h3>
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
                        <td>{{ $participant->start_date ? \Carbon\Carbon::parse($participant->start_date)->format('d M Y') : '-' }}</td>
                        <td>{{ $participant->end_date ? \Carbon\Carbon::parse($participant->end_date)->format('d M Y') : '-' }}</td>
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

<style>
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
}

.hero-back-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-5px);
}

/* Profile Card */
.profile-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.8);
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

/* Participant Name */
.participant-name .name {
    font-weight: 600;
    color: #1a1a2e;
}

/* Status Badge Overrides */
.status-badge.active {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #2563eb;
}

.status-badge.completed {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(22, 163, 74, 0.15) 100%);
    color: #16a34a;
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

/* Responsive */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }

    .profile-meta {
        justify-content: center;
    }

    .hero-back-btn {
        margin-top: 16px;
    }
}
</style>
@endsection
