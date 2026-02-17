{{--
    USER PROFILE PAGE
    Profile information and password management for participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Profile - PT Telkom Indonesia')

@php
    $role = 'participant';
    $pageTitle = 'Profile';
@endphp

@push('styles')
<style>
/* ============================================
   PROFILE PAGE STYLES
   ============================================ */

/* Hero Section */
.profile-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2.5rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
    text-align: center;
}

.profile-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.profile-hero-content {
    position: relative;
    z-index: 1;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}

.profile-avatar i {
    font-size: 2.75rem;
    color: white;
}

.profile-hero h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.35rem;
}

.profile-hero .hero-email {
    font-size: 1rem;
    opacity: 0.9;
}

/* Cards Grid */
.cards-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

/* Info Card */
.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.info-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-card-header .header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(238, 46, 36, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #EE2E24;
    flex-shrink: 0;
}

.info-card-header h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.info-card-body {
    padding: 1.25rem 1.5rem;
}

/* Info Items */
.info-item {
    display: flex;
    align-items: flex-start;
    padding: 0.85rem 1rem;
    background: #f9fafb;
    border-radius: 12px;
    margin-bottom: 0.65rem;
    transition: background 0.2s;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item:hover {
    background: #f3f4f6;
}

.info-item-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 160px;
    font-weight: 600;
    color: #6b7280;
    font-size: 0.85rem;
    flex-shrink: 0;
}

.info-item-label i {
    color: #EE2E24;
    font-size: 0.8rem;
    width: 16px;
    text-align: center;
}

.info-item-value {
    color: #1f2937;
    font-weight: 500;
    font-size: 0.9rem;
    flex: 1;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-badge.accepted {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
}

.status-badge.finished {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

/* Download Button */
.btn-download-letter {
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
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(238, 46, 36, 0.25);
}

.btn-download-letter:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.35);
    color: white;
}

/* Password Card */
.password-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.password-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.password-card-header .header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(238, 46, 36, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #EE2E24;
    flex-shrink: 0;
}

.password-card-header h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.password-card-body {
    padding: 1.5rem;
}

.password-card-body .form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    margin-bottom: 0.5rem;
}

.password-card-body .form-label i {
    color: #EE2E24;
    font-size: 0.85rem;
}

.password-card-body .form-control {
    border: 1px solid #d1d5db;
    border-radius: 12px;
    padding: 0.7rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.password-card-body .form-control:focus {
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.btn-save-password {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.75rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
}

.btn-save-password:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.35);
    color: white;
}

/* Alert Styling */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.875rem;
}

.alert-modern.success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.alert-modern.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.alert-modern i {
    margin-top: 0.1rem;
    font-size: 1rem;
}

.alert-modern ul {
    margin: 0;
    padding-left: 1.25rem;
}

.alert-modern .btn-close {
    margin-left: auto;
    padding: 0.5rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .cards-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .profile-hero {
        padding: 2rem 1.5rem;
    }

    .profile-hero h2 {
        font-size: 1.35rem;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
    }

    .profile-avatar i {
        font-size: 2.25rem;
    }

    .info-item {
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-item-label {
        min-width: auto;
    }

    .password-fields-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="profile-hero">
    <div class="profile-hero-content">
        <div class="profile-avatar">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            @else
                <i class="fas fa-user"></i>
            @endif
        </div>
        <h2>{{ $user->name ?? 'User' }}</h2>
        <p class="hero-email">{{ $user->email ?? '' }}</p>
    </div>
</div>

{{-- Info Cards Grid --}}
<div class="cards-grid">
    {{-- Biodata Card --}}
    <div class="info-card">
        <div class="info-card-header">
            <div class="header-icon">
                <i class="fas fa-user"></i>
            </div>
            <h5>Biodata Peserta</h5>
        </div>
        <div class="info-card-body">
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-id-card"></i>
                    <span>Nama</span>
                </div>
                <div class="info-item-value">{{ $user->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-envelope"></i>
                    <span>Email</span>
                </div>
                <div class="info-item-value">{{ $user->email ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-graduation-cap"></i>
                    <span>NIM</span>
                </div>
                <div class="info-item-value">{{ $user->nim ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-phone"></i>
                    <span>No HP</span>
                </div>
                <div class="info-item-value">{{ $user->phone ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-university"></i>
                    <span>Universitas</span>
                </div>
                <div class="info-item-value">{{ $user->university ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-book"></i>
                    <span>Jurusan</span>
                </div>
                <div class="info-item-value">{{ $user->major ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-id-badge"></i>
                    <span>NIK (No. KTP)</span>
                </div>
                <div class="info-item-value">{{ $user->ktp_number ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Status Magang Card --}}
    @if($application)
    <div class="info-card">
        <div class="info-card-header">
            <div class="header-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h5>Status Pengajuan Magang</h5>
        </div>
        <div class="info-card-body">
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-building"></i>
                    <span>Divisi Penempatan</span>
                </div>
                <div class="info-item-value">
                    @if($application->status == 'accepted' || $application->status == 'finished')
                        {{ $application->divisionAdmin->division_name ?? '-' }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-user-tie"></i>
                    <span>Mentor</span>
                </div>
                <div class="info-item-value">
                    @if($application->status == 'accepted' || $application->status == 'finished')
                        {{ $application->divisionMentor->mentor_name ?? '-' }}
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-tags"></i>
                    <span>Bidang Peminatan</span>
                </div>
                <div class="info-item-value">{{ $application->fieldOfInterest->name ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-info-circle"></i>
                    <span>Status</span>
                </div>
                <div class="info-item-value">
                    @if($application->status == 'accepted')
                        <span class="status-badge accepted"><i class="fas fa-check-circle"></i> Diterima</span>
                    @elseif($application->status == 'rejected')
                        <span class="status-badge rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                    @elseif($application->status == 'finished')
                        <span class="status-badge finished"><i class="fas fa-flag-checkered"></i> Selesai</span>
                    @else
                        <span class="status-badge pending"><i class="fas fa-clock"></i> Pending</span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-calendar"></i>
                    <span>Tanggal Pengajuan</span>
                </div>
                <div class="info-item-value">{{ $application->created_at ? $application->created_at->format('d M Y') : '-' }}</div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-calendar-check"></i>
                    <span>Mulai Magang</span>
                </div>
                <div class="info-item-value">
                    {{ $application->start_date ? \Carbon\Carbon::parse($application->start_date)->format('d M Y') : '-' }}
                </div>
            </div>
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-calendar-times"></i>
                    <span>Selesai Magang</span>
                </div>
                <div class="info-item-value">
                    {{ $application->end_date ? \Carbon\Carbon::parse($application->end_date)->format('d M Y') : '-' }}
                </div>
            </div>
            @if($application->status == 'accepted' || $application->status == 'finished')
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-file-pdf"></i>
                    <span>Surat Penerimaan</span>
                </div>
                <div class="info-item-value">
                    @if($application->acceptance_letter_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($application->acceptance_letter_path))
                        <a href="{{ route('dashboard.acceptance-letter.download') }}" class="btn-download-letter" target="_blank">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @else
                        <span style="color: #9ca3af;">Belum tersedia</span>
                    @endif
                </div>
            </div>
            @endif
            @if($application->notes)
            <div class="info-item">
                <div class="info-item-label">
                    <i class="fas fa-sticky-note"></i>
                    <span>Catatan</span>
                </div>
                <div class="info-item-value">{{ $application->notes }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- Password Card --}}
<div class="password-card">
    <div class="password-card-header">
        <div class="header-icon">
            <i class="fas fa-key"></i>
        </div>
        <h5>Ganti Password</h5>
    </div>
    <div class="password-card-body">
        @if(session('success'))
            <div class="alert-modern success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-modern danger">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;" class="password-fields-grid">
                <div>
                    <label for="current_password" class="form-label">
                        <i class="fas fa-lock"></i> Password Saat Ini
                    </label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password" name="current_password" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password" class="form-label">
                        <i class="fas fa-key"></i> Password Baru
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-check-double"></i> Konfirmasi Password
                    </label>
                    <input type="password" class="form-control"
                           id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <div style="text-align: right; margin-top: 1.5rem;">
                <button type="submit" class="btn-save-password">
                    <i class="fas fa-save"></i> Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
