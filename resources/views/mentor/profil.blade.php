@extends('layouts.mentor-dashboard')

@section('title', 'Profil Pembimbing - PT Telkom Indonesia')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%);
    }

    .profile-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Mega Hero Card */
    .mega-hero {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 50%, #C41E3A 100%);
        border-radius: 32px;
        padding: 0;
        margin-bottom: 2.5rem;
        overflow: hidden;
        box-shadow:
            0 25px 50px -12px rgba(238, 46, 36, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        position: relative;
        min-height: 400px;
    }

    .hero-bg-pattern {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            linear-gradient(45deg, transparent 45%, rgba(255, 255, 255, 0.05) 50%, transparent 55%);
        background-size: 100% 100%, 100% 100%, 40px 40px;
        animation: bgShift 20s ease-in-out infinite;
    }

    @keyframes bgShift {
        0%, 100% { opacity: 0.8; transform: translateX(0); }
        50% { opacity: 1; transform: translateX(20px); }
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 10;
        padding: 3.5rem;
    }

    .profile-mega-card {
        display: flex;
        align-items: center;
        gap: 3rem;
    }

    .avatar-mega-wrapper {
        position: relative;
    }

    .avatar-mega {
        width: 180px;
        height: 180px;
        background: white;
        border-radius: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.3),
            0 0 0 8px rgba(255, 255, 255, 0.1),
            0 0 60px rgba(255, 255, 255, 0.4);
        position: relative;
        overflow: hidden;
        transform: rotate(-3deg);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .avatar-mega:hover {
        transform: rotate(0deg) scale(1.05);
    }

    .avatar-mega::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(246, 0, 0, 0.05) 100%);
    }

    .avatar-mega i {
        font-size: 5rem;
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 1;
        animation: iconPulse 3s ease-in-out infinite;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .avatar-badge-floating {
        position: absolute;
        bottom: -10px;
        right: -10px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
        border: 4px solid white;
        animation: badgeBounce 2s ease-in-out infinite;
    }

    @keyframes badgeBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .avatar-badge-floating i {
        font-size: 1.5rem;
        color: white;
        -webkit-text-fill-color: white;
    }

    .hero-info-mega {
        flex: 1;
    }

    .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(20px);
        padding: 0.75rem 1.5rem;
        border-radius: 100px;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .hero-name {
        font-size: 3.5rem;
        font-weight: 900;
        color: white;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        line-height: 1.1;
    }

    .hero-meta-grid {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.25rem;
        border-radius: 16px;
        color: white;
        font-weight: 600;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .meta-pill:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .meta-pill i {
        font-size: 1.25rem;
    }

    /* Floating Stats */
    .floating-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        margin-top: -60px;
        position: relative;
        z-index: 100;
    }

    .stat-float-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .stat-float-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-float-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        opacity: 0.1;
        transition: all 0.4s ease;
    }

    .stat-float-card:hover::before {
        transform: scale(1.2);
        opacity: 0.15;
    }

    .stat-float-card.purple::before {
        background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);
    }

    .stat-float-card.red::before {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
    }

    .stat-float-card.green::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-float-card.orange::before {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-icon-mega {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 1;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-icon-mega i {
        font-size: 2.5rem;
        color: white;
    }

    .stat-label-mega {
        font-size: 0.8rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.5rem;
    }

    .stat-value-mega {
        font-size: 2rem;
        font-weight: 900;
        color: #000;
        line-height: 1.2;
        word-break: break-word;
    }

    /* Content Sections */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2.5rem;
    }

    .info-visual-card {
        background: white;
        border-radius: 28px;
        padding: 0;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-visual-card:hover {
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        transform: translateY(-5px);
    }

    .card-visual-header {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .card-visual-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: headerFloat 15s ease-in-out infinite;
    }

    @keyframes headerFloat {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-30px, -30px); }
    }

    .header-icon-wrapper {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .header-icon-wrapper i {
        font-size: 2rem;
        color: white;
    }

    .card-visual-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: white;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .card-visual-body {
        padding: 2.5rem;
    }

    .info-visual-list {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }

    .info-visual-item {
        position: relative;
        padding-left: 4rem;
        transition: all 0.3s ease;
    }

    .info-visual-item:hover {
        transform: translateX(5px);
    }

    .info-visual-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        box-shadow: 0 8px 16px rgba(238, 46, 36, 0.25);
    }

    .info-visual-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #9CA3AF;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .info-visual-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
        line-height: 1.3;
    }

    /* Password Section */
    .password-mega-section {
        background: white;
        border-radius: 28px;
        padding: 0;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .password-visual-header {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .password-visual-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px);
    }

    .password-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .password-icon-mega {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 35px rgba(238, 46, 36, 0.4);
    }

    .password-icon-mega i {
        font-size: 2.75rem;
        color: white;
    }

    .password-header-text h2 {
        font-size: 2.25rem;
        font-weight: 900;
        color: white;
        margin: 0 0 0.5rem 0;
    }

    .password-header-text p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    .password-visual-body {
        padding: 3rem;
    }

    .form-visual-grid {
        display: grid;
        gap: 2rem;
    }

    .form-visual-group {
        position: relative;
    }

    .form-visual-label {
        font-size: 0.9rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-visual-label i {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }

    .form-visual-input-wrapper {
        position: relative;
    }

    .form-visual-input {
        width: 100%;
        padding: 1.25rem 1.5rem;
        padding-left: 4rem;
        border: 3px solid #E5E7EB;
        border-radius: 16px;
        font-size: 1.05rem;
        font-weight: 600;
        transition: all 0.3s ease;
        background: #F9FAFB;
    }

    .form-visual-input:focus {
        outline: none;
        border-color: #EE2E24;
        background: white;
        box-shadow: 0 0 0 6px rgba(238, 46, 36, 0.1);
        transform: translateY(-2px);
    }

    .form-visual-input.is-invalid {
        border-color: #EF4444;
        background: #FEF2F2;
    }

    .input-icon-left {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        font-size: 1.25rem;
    }

    .form-visual-input:focus + .input-icon-left {
        color: #EE2E24;
    }

    .btn-save-mega {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        color: white;
        border: none;
        padding: 1.5rem 4rem;
        border-radius: 16px;
        font-weight: 900;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(238, 46, 36, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn-save-mega::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-save-mega:hover::before {
        left: 100%;
    }

    .btn-save-mega:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(238, 46, 36, 0.5);
    }

    .btn-save-mega:active {
        transform: translateY(-1px);
    }

    .alert-visual {
        border-radius: 20px;
        border: none;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        font-weight: 600;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .alert-visual i {
        font-size: 2rem;
        flex-shrink: 0;
    }

    .alert-visual.alert-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%);
        color: #065F46;
        border-left: 6px solid #10b981;
    }

    .alert-visual.alert-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);
        color: #991B1B;
        border-left: 6px solid #EF4444;
    }

    @media (max-width: 1200px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .hero-content-wrapper {
            padding: 2rem;
        }

        .profile-mega-card {
            flex-direction: column;
            text-align: center;
            gap: 2rem;
        }

        .avatar-mega {
            width: 140px;
            height: 140px;
        }

        .avatar-mega i {
            font-size: 3.5rem;
        }

        .hero-name {
            font-size: 2.25rem;
        }

        .hero-meta-grid {
            flex-direction: column;
            gap: 1rem;
        }

        .floating-stats {
            margin-top: 0;
            grid-template-columns: 1fr;
        }

        .password-header-content {
            flex-direction: column;
            text-align: center;
        }

        .btn-save-mega {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-wrapper">
    <!-- Mega Hero -->
    <div class="mega-hero">
        <div class="hero-bg-pattern"></div>
        <div class="hero-content-wrapper">
            <div class="profile-mega-card">
                <div class="avatar-mega-wrapper">
                    <div class="avatar-mega">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="avatar-badge-floating">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                <div class="hero-info-mega">
                    <div class="role-pill">
                        <i class="fas fa-shield-alt"></i>
                        <span>Pembimbing Lapangan Telkom Indonesia</span>
                    </div>
                    <h1 class="hero-name">{{ $divisionMentor ? $divisionMentor->mentor_name : ($user->name ?? 'Pembimbing Lapangan') }}</h1>
                    <div class="hero-meta-grid">
                        <div class="meta-pill">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $user->email ?? '-' }}</span>
                        </div>
                        @if($divisionAdmin)
                        <div class="meta-pill">
                            <i class="fas fa-building"></i>
                            <span>{{ $divisionAdmin->division_name }}</span>
                        </div>
                        @endif
                        <div class="meta-pill">
                            <i class="fas fa-check-circle"></i>
                            <span>Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Stats -->
    <div class="floating-stats">
        <div class="stat-float-card purple">
            <div class="stat-icon-mega" style="background: linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%);">
                <i class="fas fa-id-card"></i>
            </div>
            <div class="stat-label-mega">Nomor Induk Karyawan</div>
            <div class="stat-value-mega">{{ $divisionMentor ? $divisionMentor->nik_number : ($user->username ?? '-') }}</div>
        </div>

        <div class="stat-float-card red">
            <div class="stat-icon-mega" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="stat-label-mega">Divisi Penempatan</div>
            <div class="stat-value-mega" style="font-size: 1.5rem;">{{ $divisionAdmin ? $divisionAdmin->division_name : '-' }}</div>
        </div>

        <div class="stat-float-card green">
            <div class="stat-icon-mega" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-label-mega">Posisi Jabatan</div>
            <div class="stat-value-mega" style="font-size: 1.25rem;">Pembimbing Lapangan</div>
        </div>

        <div class="stat-float-card orange">
            <div class="stat-icon-mega" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-label-mega">Perusahaan</div>
            <div class="stat-value-mega" style="font-size: 1.25rem;">PT Telkom Indonesia</div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="content-grid">
        <div class="info-visual-card">
            <div class="card-visual-header">
                <div class="header-icon-wrapper">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3 class="card-visual-title">Informasi Personal</h3>
            </div>
            <div class="card-visual-body">
                <div class="info-visual-list">
                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-visual-label">Nama Lengkap</div>
                        <div class="info-visual-value">{{ $divisionMentor ? $divisionMentor->mentor_name : ($user->name ?? '-') }}</div>
                    </div>

                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div class="info-visual-label">NIK</div>
                        <div class="info-visual-value">{{ $divisionMentor ? $divisionMentor->nik_number : ($user->username ?? '-') }}</div>
                    </div>

                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-visual-label">Email Address</div>
                        <div class="info-visual-value">{{ $user->email ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-visual-card">
            <div class="card-visual-header">
                <div class="header-icon-wrapper">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="card-visual-title">Informasi Perusahaan</h3>
            </div>
            <div class="card-visual-body">
                <div class="info-visual-list">
                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="info-visual-label">Nama Perusahaan</div>
                        <div class="info-visual-value">PT Telkom Indonesia</div>
                    </div>

                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        <div class="info-visual-label">Divisi</div>
                        <div class="info-visual-value">{{ $divisionAdmin ? $divisionAdmin->division_name : '-' }}</div>
                    </div>

                    <div class="info-visual-item">
                        <div class="info-visual-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="info-visual-label">Jabatan</div>
                        <div class="info-visual-value">Pembimbing Lapangan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Section -->
    <div class="password-mega-section">
        <div class="password-visual-header">
            <div class="password-header-content">
                <div class="password-icon-mega">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="password-header-text">
                    <h2>Keamanan & Password</h2>
                    <p>Kelola keamanan akun Anda dengan mengubah password secara berkala</p>
                </div>
            </div>
        </div>
        <div class="password-visual-body">
            @if(session('success'))
                <div class="alert alert-visual alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-visual alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <ul style="margin: 0; padding-left: 1.25rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="form-visual-grid">
                    <div class="form-visual-group">
                        <label class="form-visual-label">
                            <i class="fas fa-lock"></i>
                            <span>Password Saat Ini</span>
                        </label>
                        <div class="form-visual-input-wrapper">
                            <input
                                type="password"
                                name="current_password"
                                class="form-visual-input @error('current_password') is-invalid @enderror"
                                placeholder="Masukkan password lama Anda"
                                required>
                            <i class="fas fa-lock input-icon-left"></i>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-visual-group">
                                <label class="form-visual-label">
                                    <i class="fas fa-key"></i>
                                    <span>Password Baru</span>
                                </label>
                                <div class="form-visual-input-wrapper">
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-visual-input @error('password') is-invalid @enderror"
                                        placeholder="Buat password baru"
                                        required>
                                    <i class="fas fa-key input-icon-left"></i>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-visual-group">
                                <label class="form-visual-label">
                                    <i class="fas fa-check-double"></i>
                                    <span>Konfirmasi Password</span>
                                </label>
                                <div class="form-visual-input-wrapper">
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        class="form-visual-input"
                                        placeholder="Ulangi password baru"
                                        required>
                                    <i class="fas fa-check-double input-icon-left"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn-save-mega">
                        <i class="fas fa-save"></i>
                        <span>Perbarui Password Saya</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
