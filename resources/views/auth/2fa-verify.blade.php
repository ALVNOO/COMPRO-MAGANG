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
                            <span id="hintText">Masukkan kode 6 digit dari aplikasi authenticator</span>
                        </span>
                    </div>

                    <!-- Remember Device Checkbox -->
                    <div class="form-group remember-device">
                        <label class="remember-device-label">
                            <input type="checkbox" name="remember_device" value="1" class="remember-checkbox">
                            <span class="checkmark"></span>
                            <span class="remember-text">
                                <strong>Ingat perangkat ini</strong>
                                <span class="remember-subtitle">Tidak perlu 2FA selama 1 hari di perangkat ini</span>
                            </span>
                        </label>
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



    /* Remember Device Checkbox */
    .remember-device {
        margin-bottom: 20px;
        padding: 0;
    }

    .remember-device-label {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        padding: 16px;
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        margin: 0;
        font-size: 14px;
        line-height: 1.4;
    }

    .remember-device-label:hover {
        background: linear-gradient(135deg, #f1f3f5 0%, #fff 100%);
        border-color: #dee2e6;
    }

    .remember-checkbox {
        display: none;
    }

    .checkmark {
        width: 20px;
        height: 20px;
        background: white;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        flex-shrink: 0;
        position: relative;
        transition: all 0.3s ease;
        margin-top: 1px;
    }

    .remember-checkbox:checked + .checkmark {
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        border-color: #EE2E24;
    }

    .remember-checkbox:checked + .checkmark::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 2px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .remember-text {
        display: flex;
        flex-direction: column;
        gap: 2px;
        flex: 1;
    }

    .remember-text strong {
        color: #1a1a1a;
        font-weight: 600;
    }

    .remember-subtitle {
        color: #6c757d;
        font-size: 12px;
        font-weight: 400;
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
}

@media (max-width: 576px) {
    .auth-user-card {
        padding: 12px;
    }

    .auth-instruction-box {
        padding: 12px;
    }

    .remember-device-label {
        padding: 12px;
        gap: 10px;
    }

    .remember-text strong {
        font-size: 13px;
    }

    .remember-subtitle {
        font-size: 11px;
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
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('verifyForm');

    if (codeInput) {
        // Auto focus
        codeInput.focus();

        // Only allow numbers + auto-submit on 6 digits
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                form.requestSubmit();
            }
        });

        // Handle paste
        codeInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericOnly = pastedText.replace(/[^0-9]/g, '').substring(0, 6);
            this.value = numericOnly;
            if (numericOnly.length === 6) {
                form.requestSubmit();
            }
        });
    }

    // Form submit loading state
    form.addEventListener('submit', function(e) {
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

    @if(session('success'))
        // Show success state
        setTimeout(() => {
            submitBtn.classList.remove('loading');
            submitBtn.classList.add('success');
            document.getElementById('submitText').textContent = 'Berhasil!';
        }, 100);
    @endif
});
</script>
@endpush
