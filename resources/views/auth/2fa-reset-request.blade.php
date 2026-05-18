@extends('layouts.app')

@section('title', 'Reset 2FA - Sistem Magang')

@push('styles')
<style>
    body.public-page .navbar { display: none !important; }
    .auth-page { padding-top: 0 !important; }
    .auth-wrapper { min-height: 100vh !important; }

    .reset-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 2rem;
        margin-bottom: 1.25rem;
    }

    .reset-icon-wrap {
        width: 64px; height: 64px;
        border-radius: 16px;
        background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }

    .reset-icon-wrap svg { color: #EE2E24; }

    .masked-email {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .75rem 1.25rem;
        background: #F9FAFB;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 600;
        color: #374151;
        width: 100%;
        margin-bottom: 1.25rem;
    }

    .masked-email svg { color: #9CA3AF; flex-shrink: 0; }

    .warning-note {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 10px;
        padding: .875rem 1rem;
        font-size: .8rem;
        color: #92400E;
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }

    .warning-note i { color: #D97706; margin-right: .35rem; }

    .btn-send-reset {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .875rem 1.5rem;
        background: linear-gradient(135deg, #EE2E24, #C41E1A);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: .9rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity .15s;
        margin-bottom: .75rem;
    }

    .btn-send-reset:hover { opacity: .9; }

    .btn-back-verify {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .75rem 1.5rem;
        background: transparent;
        color: #6B7280;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: .875rem;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all .15s;
    }

    .btn-back-verify:hover { border-color: #D1D5DB; color: #374151; background: #F9FAFB; }

    .steps-list {
        list-style: none;
        padding: 0; margin: 0 0 1.25rem;
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }

    .steps-list li {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
        font-size: .8rem;
        color: #4B5563;
        line-height: 1.5;
    }

    .step-num {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: #EE2E24;
        color: #fff;
        font-size: .65rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-wrapper">
        <!-- Left Panel -->
        <div class="auth-panel-left">
            <div class="auth-panel-content">
                <div class="auth-illustration">
                    <div class="illustration-circle">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>
                <h2 class="auth-panel-title">Reset via Email</h2>
                <p class="auth-panel-subtitle">Kami akan mengirim link reset ke email terdaftar Anda untuk mengatur ulang authenticator</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Link hanya berlaku 15 menit</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Hanya bisa digunakan sekali</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Scan ulang QR code setelah reset</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="auth-panel-right">
            <div class="auth-form-wrapper">
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('image/logo_terbaru.png') }}" alt="Telkom" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo-fallback" style="display:none;">TELKOM</div>
                </a>

                <div class="auth-header">
                    <h1 class="auth-title">Tidak Bisa Akses Authenticator?</h1>
                    <p class="auth-subtitle">Kami akan kirim link reset 2FA ke email Anda</p>
                </div>

                @if(session('error'))
                <div class="auth-alert auth-alert-error" style="margin-bottom:1rem;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <div class="reset-card">
                    <div style="text-align:center;">
                        <div class="reset-icon-wrap">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <p style="font-size:.875rem;color:#374151;font-weight:600;margin:0 0 .25rem;">Link reset akan dikirim ke:</p>
                    </div>

                    <div class="masked-email">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        {{ \Illuminate\Support\Str::mask(auth()->user()->email, '*', 3, -4) }}
                    </div>

                    <p style="font-size:.8rem;color:#6B7280;margin:0 0 1rem;text-align:center;">Proses reset 2FA:</p>

                    <ul class="steps-list">
                        <li>
                            <span class="step-num">1</span>
                            <span>Klik tombol kirim — kami akan mengirim link ke email Anda</span>
                        </li>
                        <li>
                            <span class="step-num">2</span>
                            <span>Buka email dan klik link reset (berlaku 15 menit)</span>
                        </li>
                        <li>
                            <span class="step-num">3</span>
                            <span>Scan QR code baru di aplikasi authenticator Anda</span>
                        </li>
                        <li>
                            <span class="step-num">4</span>
                            <span>Masukkan kode 6 digit untuk mengaktifkan 2FA kembali</span>
                        </li>
                    </ul>

                    <div class="warning-note">
                        <i class="fas fa-triangle-exclamation"></i>
                        Pastikan Anda memiliki akses ke email <strong>{{ \Illuminate\Support\Str::mask(auth()->user()->email, '*', 3, -4) }}</strong>.
                        Jika tidak, hubungi admin sistem.
                    </div>
                </div>

                <form method="POST" action="{{ route('2fa.reset.send') }}">
                    @csrf
                    <button type="submit" class="btn-send-reset">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Kirim Link Reset ke Email
                    </button>
                </form>

                <a href="{{ route('2fa.verify') }}" class="btn-back-verify">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Verifikasi 2FA
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
