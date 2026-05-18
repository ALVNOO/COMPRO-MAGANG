@extends('layouts.app')

@section('title', 'Email Terkirim - Reset 2FA')

@push('styles')
<style>
    body.public-page .navbar { display: none !important; }
    .auth-page { padding-top: 0 !important; }
    .auth-wrapper { min-height: 100vh !important; }

    .sent-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #E5E7EB;
        padding: 2.5rem 2rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .sent-icon {
        width: 72px; height: 72px;
        border-radius: 20px;
        background: linear-gradient(135deg, #DCFCE7, #BBF7D0);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }

    .sent-icon svg { color: #16A34A; }

    .sent-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin: 0 0 .5rem;
    }

    .sent-desc {
        font-size: .875rem;
        color: #6B7280;
        line-height: 1.6;
        margin: 0 0 1.5rem;
    }

    .email-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1rem;
        background: #F3F4F6;
        border: 1px solid #E5E7EB;
        border-radius: 9999px;
        font-size: .8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1.5rem;
    }

    .expiry-note {
        display: flex;
        align-items: center;
        gap: .5rem;
        justify-content: center;
        padding: .75rem 1rem;
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        border-radius: 10px;
        font-size: .8rem;
        color: #92400E;
        font-weight: 500;
        margin-bottom: 1.25rem;
    }

    .tips-box {
        background: #F9FAFB;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        text-align: left;
        margin-bottom: 0;
    }

    .tips-box p { margin: 0 0 .5rem; font-size: .75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: .5px; }

    .tips-list { margin: 0; padding-left: 1rem; }
    .tips-list li { font-size: .8rem; color: #6B7280; line-height: 1.6; margin-bottom: .25rem; }

    .btn-back-verify {
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
        text-decoration: none;
        transition: all .15s;
        margin-bottom: .75rem;
    }

    .btn-back-verify:hover { border-color: #D1D5DB; color: #374151; background: #F9FAFB; }

    .btn-resend {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .6rem 1.5rem;
        background: transparent;
        color: #EE2E24;
        border: none;
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: opacity .15s;
        width: 100%;
        margin-bottom: 0;
    }

    .btn-resend:hover { opacity: .75; }
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
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>
                <h2 class="auth-panel-title">Email Terkirim!</h2>
                <p class="auth-panel-subtitle">Cek inbox atau folder spam email Anda untuk menemukan link reset 2FA</p>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="auth-panel-right">
            <div class="auth-form-wrapper">
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('image/logo_terbaru.png') }}" alt="Telkom" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo-fallback" style="display:none;">TELKOM</div>
                </a>

                <div class="sent-card">
                    <div class="sent-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h2 class="sent-title">Email Berhasil Dikirim!</h2>
                    <p class="sent-desc">Link reset 2FA telah dikirim ke:</p>

                    <div class="email-chip">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        {{ \Illuminate\Support\Str::mask($email, '*', 3, -4) }}
                    </div>

                    <div class="expiry-note">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        Link berlaku selama <strong style="margin:0 .25rem;">15 menit</strong> dan hanya sekali pakai
                    </div>

                    <div class="tips-box">
                        <p>Tips jika email tidak muncul:</p>
                        <ul class="tips-list">
                            <li>Cek folder <strong>Spam</strong> atau <strong>Junk</strong></li>
                            <li>Tunggu beberapa menit, pengiriman bisa sedikit terlambat</li>
                            <li>Pastikan email yang terdaftar sudah benar</li>
                            <li>Jika masih bermasalah, hubungi admin sistem</li>
                        </ul>
                    </div>
                </div>

                <a href="{{ route('2fa.verify') }}" class="btn-back-verify">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Verifikasi 2FA
                </a>

                <form method="POST" action="{{ route('2fa.reset.send') }}">
                    @csrf
                    <button type="submit" class="btn-resend">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                            <path d="M21 3v5h-5"/>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                            <path d="M8 16H3v5"/>
                        </svg>
                        Kirim ulang email
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
