@extends('layouts.app')

@section('title', 'Verifikasi 2FA - Sistem Magang PT Telkom Indonesia')

@section('content')
<div class="auth-page">
    <div class="auth-wrapper">
        <!-- Left Panel - Illustration -->
        <div class="auth-panel-left">
            <div class="auth-panel-content">
                <div class="auth-illustration">
                    <div class="illustration-circle">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>
                <h2 class="auth-panel-title">Verifikasi Keamanan</h2>
                <p class="auth-panel-subtitle">Satu langkah lagi untuk mengamankan akun Anda dengan Two-Factor Authentication</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Perlindungan Akun Ekstra</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Mencegah Akses Tidak Sah</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Standar Keamanan Enterprise</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-panel-right">
            <div class="auth-form-wrapper">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('image/telkom-logo.png') }}" alt="Telkom" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo-fallback" style="display: none;">TELKOM</div>
                </a>

                <!-- Header -->
                <div class="auth-header">
                    <h1 class="auth-title">Verifikasi 2FA</h1>
                    <p class="auth-subtitle">Masukkan kode 6 digit dari aplikasi authenticator Anda</p>
                </div>

                <!-- User Info Card -->
                <div class="auth-user-card">
                    <div class="auth-user-avatar">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile">
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        @endif
                    </div>
                    <div class="auth-user-info">
                        <span class="auth-user-name">{{ auth()->user()->name ?? 'User' }}</span>
                        <span class="auth-user-email">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                <!-- Error Alert -->
                @if(session('error'))
                <div class="auth-alert auth-alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @if($errors->any() && !str_contains($errors->first(), 'Coba lagi dalam 0 menit'))
                <div class="auth-alert auth-alert-error" id="errorAlert">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Instruction Box -->
                <div class="auth-instruction-box">
                    <div class="auth-instruction-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                            <line x1="12" y1="18" x2="12.01" y2="18"/>
                        </svg>
                    </div>
                    <div class="auth-instruction-text">
                        <strong>Buka Authenticator App</strong>
                        <span>Google Authenticator, Authy, atau 1Password</span>
                    </div>
                </div>

                <!-- Countdown Timer -->
                <div class="countdown-container" id="countdownBox">
                    <div class="countdown-main">
                        <div class="countdown-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12,6 12,12 16,14"/>
                            </svg>
                        </div>
                        <div class="countdown-content">
                            <span class="countdown-label">Kode berlaku selama</span>
                            <span class="countdown-number" id="countdown">30</span>
                            <span class="countdown-unit">detik</span>
                        </div>
                    </div>

                    <div class="countdown-progress">
                        <div class="countdown-progress-track">
                            <div class="countdown-progress-bar" id="countdownBar"></div>
                        </div>

                    </div>
                </div>

                <!-- Verify Form -->
                <form method="POST" action="{{ route('2fa.verify.post') }}" class="auth-form" id="verifyForm">
                    @csrf

                    <div class="form-group">
                        <label for="code" class="form-label">Kode Verifikasi</label>
                        <div class="input-wrapper input-wrapper-code">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="text"
                                   id="code"
                                   name="code"
                                   class="form-input form-input-code"
                                   placeholder="000000"
                                   maxlength="6"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   required
                                   autofocus>
                        </div>
                        <span class="form-hint" id="formHint">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="16" x2="12" y2="12"/>
                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                            </svg>
                            <span id="hintText">Kode akan diverifikasi otomatis setelah 6 digit</span>
                        </span>
                    </div>

                    <button type="submit" class="btn-auth-primary" id="submitBtn">
                        <span id="submitText">Verifikasi & Masuk</span>
                        <svg id="submitArrow" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        <svg id="submitCheck" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </button>
                </form>

                <!-- Refresh Code Button (shown when expired) -->
                <div id="refresh-container" style="display: none;">
                    <form id="refresh-form" action="{{ route('2fa.refresh') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-auth-primary btn-auth-refresh" id="refreshBtn">
                            <svg id="refreshIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="23 4 23 10 17 10"/>
                                <polyline points="1 20 1 14 7 14"/>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/>
                            </svg>
                            <span id="refreshText">Dapatkan Kode Baru</span>
                        </button>
                    </form>
                    <div class="refresh-hint">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        <span>Kode Google Authenticator berubah setiap 30 detik</span>
                    </div>
                </div>

                <!-- Cancel Action -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-auth-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        <span>Batalkan & Logout</span>
                    </button>
                </form>

                <!-- Help -->
                <div class="auth-footer">
                    <p>Tidak bisa akses kode? <a href="mailto:admin@telkom.co.id" class="auth-link">Hubungi Admin</a></p>
                </div>

                <!-- Back to Login -->
                <a href="{{ route('login') }}" class="back-to-home">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* User Card */
    .auth-user-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .auth-user-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        overflow: hidden;
    }

    .auth-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .auth-user-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
        min-width: 0;
    }

    .auth-user-name {
        font-weight: 600;
        color: #1a1a1a;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .auth-user-email {
        font-size: 12px;
        color: #6c757d;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Instruction Box */
    .auth-instruction-box {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
        border: 1px solid rgba(238, 46, 36, 0.15);
        border-radius: 12px;
        margin-bottom: 24px;
    }

    .auth-instruction-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .form-hint.expired {
        color: #dc3545;
    }

    .auth-instruction-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .auth-instruction-text strong {
        font-size: 14px;
        color: #1a1a1a;
    }

    .auth-instruction-text span {
        font-size: 12px;
        color: #6c757d;
    }

    /* Countdown Container */
    .countdown-container {
        background: linear-gradient(135deg, #fff8f5 0%, #fff 100%);
        border: 1px solid rgba(238, 46, 36, 0.15);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(238, 46, 36, 0.08);
    }

    .countdown-container.expired {
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border-color: #dee2e6;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .countdown-main {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 16px;
        padding: 0 8px;
    }

    .countdown-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .countdown-container.expired .countdown-icon {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .countdown-content {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 1;
        min-width: 0;
        line-height: 1.2;
        gap: 12px;
    }

    .countdown-label {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        letter-spacing: 0.025em;
        margin: 0;
        white-space: nowrap;
    }





    .countdown-number {
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        color: #EE2E24;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        text-shadow: 0 2px 4px rgba(238, 46, 36, 0.1);
        margin: 0;
        padding: 0;
    }

    .countdown-container.expired .countdown-number {
        color: #6c757d;
        text-shadow: none;
    }

    .countdown-unit {
        font-size: 14px;
        font-weight: 500;
        color: #6c757d;
    }

    .countdown-progress {
        position: relative;
    }

    .countdown-progress-track {
        width: 100%;
        height: 6px;
        background: rgba(238, 46, 36, 0.1);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .countdown-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #EE2E24 0%, #C41E3A 100%);
        border-radius: 3px;
        transition: width 0.3s ease;
        width: 100%;
        position: relative;
    }

    .countdown-progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 20%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.3) 100%);
        border-radius: 3px;
    }

    .countdown-container.expired .countdown-progress-bar {
        width: 0;
        background: #dee2e6;
    }

    .countdown-container.expired .countdown-progress-bar::after {
        display: none;
    }



    /* Animations */
    .countdown-number {
        transition: all 0.3s ease;
    }

    .countdown-container:not(.expired) .countdown-number {
        animation: pulse-subtle 2s ease-in-out infinite;
    }

    @keyframes pulse-subtle {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* Warning state when time is low */
    .countdown-container.warning .countdown-number {
        color: #dc3545;
        animation: pulse-warning 1s ease-in-out infinite;
    }

    .countdown-container.warning .countdown-progress-bar {
        background: linear-gradient(90deg, #dc3545 0%, #c82333 100%);
    }

    @keyframes pulse-warning {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
    }

    /* Code Input Styling */
    .input-wrapper-code {
        position: relative;
    }

    .form-input-code {
        font-size: 32px !important;
        font-weight: 700 !important;
        letter-spacing: 12px !important;
        text-align: center !important;
        padding: 20px 20px 20px 52px !important;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace !important;
        transition: all 0.3s ease;
        height: 70px !important;
        border: 2px solid #e9ecef !important;
    }

    .form-input-code.expired {
        background: #f8f9fa;
        color: #6c757d;
        border-color: #dee2e6;
    }

    .form-input-code::placeholder {
        letter-spacing: 12px;
        color: #ced4da;
        font-size: 24px;
    }

    .form-hint {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #6c757d;
        margin-top: 8px;
    }

    .form-hint svg {
        flex-shrink: 0;
    }

    /* Secondary Button */
    .btn-auth-secondary {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 24px;
        background: transparent;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 12px;
    }

    .btn-auth-secondary:hover {
        background: #f8f9fa;
        border-color: #ced4da;
        color: #495057;
    }

    /* Refresh Container */
    #refresh-container {
        margin-bottom: 16px;
    }

    /* Refresh Button */
    .btn-auth-refresh {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        margin-bottom: 12px;
    }

    .btn-auth-refresh:hover {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-auth-refresh.loading {
        pointer-events: none;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    }

    .btn-auth-refresh.loading #refreshIcon {
        animation: rotate 1s linear infinite;
    }

    .btn-auth-refresh.loading #refreshText {
        opacity: 0.7;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .refresh-hint {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 12px;
        color: #6c757d;
        text-align: center;
        padding: 8px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .refresh-hint svg {
        flex-shrink: 0;
        color: #28a745;
    }

    /* Loading State */
    .btn-auth-primary.loading {
        pointer-events: none;
        background: linear-gradient(135deg, #ffa726 0%, #ff9800 100%);
    }

    .btn-auth-primary.loading #submitText {
        opacity: 0;
    }

    .btn-auth-primary.loading #submitArrow {
        display: none;
    }

    .btn-auth-primary.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    .btn-auth-primary.success {
        background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
        pointer-events: none;
    }

    .btn-auth-primary.success #submitText {
        opacity: 1;
    }

    .btn-auth-primary.success #submitArrow {
        display: none;
    }

    .btn-auth-primary.success #submitCheck {
        display: block;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .btn-auth-primary.success {
        animation: pulse 0.3s ease-in-out;
    }

    /* Mobile Responsive */
@media (max-width: 991px) {
    .form-input-code {
        font-size: 28px !important;
        letter-spacing: 10px !important;
        height: 65px !important;
    }

    .form-input-code::placeholder {
        font-size: 22px;
        letter-spacing: 10px;
    }

    .countdown-container {
        padding: 16px;
    }

    .countdown-number {
        font-size: 28px;
    }

    .countdown-icon {
        width: 28px;
        height: 28px;
    }

    .countdown-label {
        font-size: 13px;
    }

    .countdown-unit {
        font-size: 13px;
    }

    .countdown-main {
        gap: 10px;
    }

    .countdown-content {
        justify-content: flex-start;
    }
}

@media (max-width: 576px) {
    .auth-user-card {
        padding: 12px;
    }

    .auth-instruction-box {
        padding: 12px;
    }

    .countdown-container {
        padding: 14px;
        margin-bottom: 16px;
    }

    .countdown-number {
        font-size: 24px;
    }

    .countdown-icon {
        width: 24px;
        height: 24px;
    }

    .countdown-label {
        font-size: 12px;
    }

    .countdown-unit {
        font-size: 12px;
    }

    .countdown-main {
        margin-bottom: 12px;
        gap: 8px;
    }

    .countdown-content {
        justify-content: flex-start;
    }

    .form-input-code {
        font-size: 24px !important;
        letter-spacing: 8px !important;
        padding: 16px 16px 16px 48px !important;
        height: 60px !important;
    }

    .form-input-code::placeholder {
        font-size: 20px;
        letter-spacing: 8px;
    }

    .btn-auth-refresh {
        font-size: 13px;
        padding: 12px 20px;
    }

    .refresh-hint {
        font-size: 11px;
        padding: 6px;
    }

    #refresh-container {
        margin-bottom: 12px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const submitBtn = document.getElementById('submitBtn');
    const refreshBtn = document.getElementById('refreshBtn');
    const form = document.getElementById('verifyForm');
    const countdownElement = document.getElementById('countdown');
    const countdownBar = document.getElementById('countdownBar');
    const countdownBox = document.getElementById('countdownBox');
    const formHint = document.getElementById('formHint');
    const hintText = document.getElementById('hintText');

    let timeLeft = Math.floor({{ $timeRemaining ?? 30 }});
    let countdownInterval;
    let isExpired = false;

    function startCountdown() {
        // Set initial display
        countdownElement.textContent = timeLeft;

        countdownInterval = setInterval(() => {
            timeLeft--;

            // Always show integer values
            countdownElement.textContent = Math.max(0, timeLeft);

            // Update progress bar
            const percentage = Math.max(0, (timeLeft / 30) * 100);
            countdownBar.style.width = percentage + '%';

            // Change color when time is running out
            if (timeLeft <= 10 && timeLeft > 0) {
                countdownBox.classList.add('warning');
                countdownBox.style.borderColor = '#dc3545';
            } else {
                countdownBox.classList.remove('warning');
            }

            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = '0';
                handleExpired();
            }
        }, 1000);
    }

    function handleExpired() {
        isExpired = true;

        // Update UI to show expired state
        countdownBox.classList.add('expired');
        codeInput.classList.add('expired');
        codeInput.disabled = true;
        codeInput.placeholder = 'EXPIRED';
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';

        // Update hint text
        formHint.classList.add('expired');
        hintText.innerHTML = 'Kode sudah kedaluwarsa. Klik "Dapatkan Kode Baru" untuk refresh.';

        // Show refresh button
        document.getElementById('refresh-container').style.display = 'block';

        countdownElement.textContent = '0';
    }

    if (codeInput) {
        // Start countdown
        if (timeLeft > 0) {
            startCountdown();
        } else {
            handleExpired();
        }

        // Auto focus
        codeInput.focus();

        // Only allow numbers
        codeInput.addEventListener('input', function() {
            if (isExpired) return;

            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto submit when 6 digits
            if (this.value.length === 6) {
                submitBtn.classList.add('loading');
                document.getElementById('submitText').textContent = 'Memverifikasi...';

                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });

        // Handle paste
        codeInput.addEventListener('paste', function(e) {
            if (isExpired) return;

            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericOnly = pastedText.replace(/[^0-9]/g, '').substring(0, 6);
            this.value = numericOnly;

            if (numericOnly.length === 6) {
                submitBtn.classList.add('loading');
                document.getElementById('submitText').textContent = 'Memverifikasi...';

                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });
    }

    // Form submit loading state
    form.addEventListener('submit', function(e) {
        if (isExpired) {
            e.preventDefault();
            return;
        }

        submitBtn.classList.add('loading');
        document.getElementById('submitText').textContent = 'Memverifikasi...';
    });

    // Auto-clear irrelevant error messages
    function clearIrrelevantErrors() {
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            const errorText = errorAlert.textContent || '';
            // Hide rate limit errors with 0 minutes
            if (errorText.includes('Coba lagi dalam 0 menit')) {
                errorAlert.style.display = 'none';
            }
        }
    }

    // Clear errors on page load
    clearIrrelevantErrors();

    // Handle server-side errors and success states
    @if(session('error_type') == 'expired')
        // If server says code is expired, immediately show expired state
        setTimeout(() => {
            clearInterval(countdownInterval);
            handleExpired();
        }, 100);
    @endif

    @if(session('refresh_success'))
        // Reset timer and enable form after refresh
        setTimeout(() => {
            timeLeft = 30;
            isExpired = false;
            countdownBox.classList.remove('expired', 'warning');
            countdownBox.style.borderColor = 'rgba(238, 46, 36, 0.15)';
            codeInput.classList.remove('expired');
            codeInput.disabled = false;
            codeInput.placeholder = '000000';
            codeInput.value = '';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            formHint.classList.remove('expired');
            hintText.innerHTML = 'Kode akan diverifikasi otomatis setelah 6 digit';
            document.getElementById('refresh-container').style.display = 'none';
            codeInput.focus();

            // Clear any existing countdown
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            // Start fresh countdown with proper integer display
            countdownElement.textContent = '30';
            document.getElementById('countdownBar').style.width = '100%';
            startCountdown();
        }, 100);
    @endif

    // Handle refresh button loading state
    const refreshForm = document.getElementById('refresh-form');
    if (refreshForm) {
        refreshForm.addEventListener('submit', function() {
            const refreshBtn = document.getElementById('refreshBtn');
            const refreshText = document.getElementById('refreshText');

            refreshBtn.classList.add('loading');
            refreshText.textContent = 'Mengatur Ulang...';
        });
    }

    @if(session('success') && !session('refresh_success'))
        // Show success state for regular success
        setTimeout(() => {
            submitBtn.classList.remove('loading');
            submitBtn.classList.add('success');
            document.getElementById('submitText').textContent = 'Berhasil!';
        }, 100);
    @endif
});
</script>
@endpush
