{{--
    MENTOR PROFIL PAGE
    Profile and password management
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Profil Pembimbing')

@php
    $role = 'mentor';
    $pageTitle = 'Profil Pembimbing';
    $pageSubtitle = 'Kelola informasi profil dan keamanan akun';
@endphp

@push('styles')
<style>
/* ============================================
   PROFIL PAGE STYLES
   ============================================ */

/* Hero Section */
.profile-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
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

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    background: white;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    position: relative;
    flex-shrink: 0;
}

.profile-avatar i {
    font-size: 3.5rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.avatar-badge {
    position: absolute;
    bottom: -8px;
    right: -8px;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.avatar-badge i {
    font-size: 1rem;
    color: white;
    -webkit-text-fill-color: white;
}

.profile-info {
    flex: 1;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.profile-name {
    font-size: 2rem;
    font-weight: 800;
    margin: 0 0 1rem 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.profile-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.9rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stat-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
}

.stat-icon.red {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
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

.stat-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.375rem;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    word-break: break-word;
}

/* Info Cards Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.info-card-header {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.info-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.1) 0%, transparent 70%);
    pointer-events: none;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 1;
}

.header-icon i {
    font-size: 1.5rem;
    color: white;
}

.info-card-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin: 0;
    position: relative;
    z-index: 1;
}

.info-card-body {
    padding: 1.75rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.info-item-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #EE2E24;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.info-item-content {
    flex: 1;
}

.info-item-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.info-item-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

/* Password Section */
.password-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.password-header {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    overflow: hidden;
}

.password-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.02) 35px, rgba(255,255,255,.02) 70px);
    pointer-events: none;
}

.password-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}

.password-icon i {
    font-size: 1.75rem;
    color: white;
}

.password-header-text {
    position: relative;
    z-index: 1;
}

.password-header-text h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.375rem 0;
}

.password-header-text p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

.password-body {
    padding: 2rem;
}

/* Alerts */
.alert-custom {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid rgba(16, 185, 129, 0.2);
    color: #059669;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    color: #DC2626;
}

.alert-custom i {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.alert-custom ul {
    margin: 0;
    padding-left: 1.25rem;
}

/* Form Elements */
.form-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
}

.form-label .label-icon {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
}

.form-input-wrapper {
    position: relative;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    padding-left: 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s ease;
    background: #f9fafb;
}

.form-input:focus {
    outline: none;
    border-color: #EE2E24;
    background: white;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-input.is-invalid {
    border-color: #EF4444;
    background: #FEF2F2;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1rem;
}

.form-input:focus ~ .input-icon {
    color: #EE2E24;
}

.invalid-feedback {
    color: #DC2626;
    font-size: 0.8rem;
    margin-top: 0.375rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(238, 46, 36, 0.4);
}

/* Responsive */
@media (max-width: 1024px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .profile-hero {
        padding: 1.75rem;
    }

    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
    }

    .profile-avatar i {
        font-size: 2.5rem;
    }

    .profile-name {
        font-size: 1.5rem;
    }

    .profile-meta {
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .password-header {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        justify-content: stretch;
    }

    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Profile Hero --}}
<div class="profile-hero">
    <div class="hero-content">
        <div class="profile-avatar">
            <i class="fas fa-user-tie"></i>
            <div class="avatar-badge">
                <i class="fas fa-check"></i>
            </div>
        </div>
        <div class="profile-info">
            <div class="role-badge">
                <i class="fas fa-shield-alt"></i>
                <span>Pembimbing Lapangan</span>
            </div>
            <h1 class="profile-name">{{ $divisionMentor ? $divisionMentor->mentor_name : ($user->name ?? 'Pembimbing Lapangan') }}</h1>
            <div class="profile-meta">
                <div class="meta-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $user->email ?? '-' }}</span>
                </div>
                @if($divisionAdmin)
                    <div class="meta-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $divisionAdmin->division_name }}</span>
                    </div>
                @endif
                <div class="meta-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Aktif</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="stat-label">Nomor Induk Karyawan</div>
        <div class="stat-value">{{ $divisionMentor ? $divisionMentor->nik_number : ($user->username ?? '-') }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-sitemap"></i>
        </div>
        <div class="stat-label">Divisi Penempatan</div>
        <div class="stat-value">{{ $divisionAdmin ? $divisionAdmin->division_name : '-' }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="stat-label">Posisi Jabatan</div>
        <div class="stat-value">Pembimbing Lapangan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-label">Perusahaan</div>
        <div class="stat-value">PT Telkom Indonesia</div>
    </div>
</div>

{{-- Info Cards Grid --}}
<div class="info-grid">
    <div class="info-card">
        <div class="info-card-header">
            <div class="header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <h3>Informasi Personal</h3>
        </div>
        <div class="info-card-body">
            <div class="info-list">
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">Nama Lengkap</div>
                        <div class="info-item-value">{{ $divisionMentor ? $divisionMentor->mentor_name : ($user->name ?? '-') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-id-badge"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">NIK</div>
                        <div class="info-item-value">{{ $divisionMentor ? $divisionMentor->nik_number : ($user->username ?? '-') }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">Email Address</div>
                        <div class="info-item-value">{{ $user->email ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header">
            <div class="header-icon">
                <i class="fas fa-building"></i>
            </div>
            <h3>Informasi Perusahaan</h3>
        </div>
        <div class="info-card-body">
            <div class="info-list">
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">Nama Perusahaan</div>
                        <div class="info-item-value">PT Telkom Indonesia</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">Divisi</div>
                        <div class="info-item-value">{{ $divisionAdmin ? $divisionAdmin->division_name : '-' }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="info-item-content">
                        <div class="info-item-label">Jabatan</div>
                        <div class="info-item-value">Pembimbing Lapangan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Password Section --}}
<div class="password-card">
    <div class="password-header">
        <div class="password-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="password-header-text">
            <h2>Keamanan & Password</h2>
            <p>Kelola keamanan akun Anda dengan mengubah password secara berkala</p>
        </div>
    </div>
    <div class="password-body">
        @if(session('success'))
            <div class="alert-custom alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-custom alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">
                        <span class="label-icon"><i class="fas fa-lock"></i></span>
                        <span>Password Saat Ini</span>
                    </label>
                    <div class="form-input-wrapper">
                        <input type="password"
                               name="current_password"
                               class="form-input @error('current_password') is-invalid @enderror"
                               placeholder="Masukkan password lama Anda"
                               required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="label-icon"><i class="fas fa-key"></i></span>
                            <span>Password Baru</span>
                        </label>
                        <div class="form-input-wrapper">
                            <input type="password"
                                   name="password"
                                   class="form-input @error('password') is-invalid @enderror"
                                   placeholder="Buat password baru"
                                   required>
                            <i class="fas fa-key input-icon"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="label-icon"><i class="fas fa-check-double"></i></span>
                            <span>Konfirmasi Password</span>
                        </label>
                        <div class="form-input-wrapper">
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-input"
                                   placeholder="Ulangi password baru"
                                   required>
                            <i class="fas fa-check-double input-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        <span>Perbarui Password</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
