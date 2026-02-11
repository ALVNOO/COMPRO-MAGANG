@extends('layouts.app')

@section('title', 'Setup 2FA - Sistem Magang PT Telkom Indonesia')

@section('content')
<div class="auth-page">
    <div class="auth-wrapper">
        <!-- Left Panel - Illustration -->
        <div class="auth-panel-left">
            <div class="auth-panel-content">
                <div class="auth-illustration">
                    <div class="illustration-circle">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            <circle cx="12" cy="16" r="1"/>
                        </svg>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>
                <h2 class="auth-panel-title">Amankan Akun Anda</h2>
                <p class="auth-panel-subtitle">Aktifkan Two-Factor Authentication untuk perlindungan ekstra pada akun Anda</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Scan QR atau Input Manual</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Kompatibel dengan Semua Authenticator</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Proses Cepat & Mudah</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Form -->
        <div class="auth-panel-right auth-panel-right-scroll">
            <div class="auth-form-wrapper auth-form-wrapper-wide">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('image/telkom-logo.png') }}" alt="Telkom" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="auth-logo-fallback" style="display: none;">TELKOM</div>
                </a>

                <!-- Header -->
                <div class="auth-header">
                    <h1 class="auth-title">Setup Two-Factor Authentication</h1>
                    <p class="auth-subtitle">Ikuti langkah-langkah berikut untuk mengaktifkan 2FA</p>
                </div>

                <!-- Status Messages -->
                @if(session('info'))
                <div class="auth-alert auth-alert-info">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>Kode verifikasi tidak valid. Silakan coba lagi.</span>
                </div>
                @endif

                <!-- Step 1: QR Code -->
                <div class="setup-step">
                    <div class="setup-step-header">
                        <div class="setup-step-number">1</div>
                        <div class="setup-step-title">
                            <strong>Scan QR Code</strong>
                            <span>Buka aplikasi authenticator dan scan QR code berikut</span>
                        </div>
                    </div>
                    <div class="setup-step-content">
                        <div class="qr-code-wrapper">
                            {!! QrCode::size(180)->margin(0)->generate($qrCodeUrl) !!}
                        </div>
                        <div class="qr-apps">
                            <span class="qr-apps-label">Aplikasi yang didukung:</span>
                            <div class="qr-apps-list">
                                <span class="qr-app-badge">Google Authenticator</span>
                                <span class="qr-app-badge">Authy</span>
                                <span class="qr-app-badge">1Password</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Manual Entry -->
                <div class="setup-step">
                    <div class="setup-step-header">
                        <div class="setup-step-number">2</div>
                        <div class="setup-step-title">
                            <strong>Atau Input Manual</strong>
                            <span>Jika scan QR gagal, masukkan kode ini secara manual</span>
                        </div>
                    </div>
                    <div class="setup-step-content">
                        <div class="secret-key-wrapper">
                            <code class="secret-key" id="secretKey">{{ auth()->user()->two_factor_secret }}</code>
                            <button type="button" class="btn-copy" onclick="copySecret()" id="copyBtn" title="Copy to clipboard">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                                </svg>
                                <span>Copy</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Verify -->
                <div class="setup-step">
                    <div class="setup-step-header">
                        <div class="setup-step-number">3</div>
                        <div class="setup-step-title">
                            <strong>Verifikasi Kode</strong>
                            <span>Masukkan kode 6 digit dari aplikasi authenticator</span>
                        </div>
                    </div>
                    <div class="setup-step-content">
                        <form method="POST" action="{{ route('2fa.enable') }}" class="auth-form" id="verifyForm">
                            @csrf

                            <div class="form-group">
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
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn-auth-success" id="submitBtn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    <polyline points="9 12 12 15 16 10"/>
                                </svg>
                                <span>Aktifkan 2FA</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Skip Option -->
                <div class="auth-footer">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-skip">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 12H5M12 19l-7-7 7-7"/>
                            </svg>
                            Lewati untuk saat ini
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Setup Steps */
    .setup-step {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .setup-step-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        border-bottom: 1px solid #e9ecef;
    }

    .setup-step-number {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .setup-step-title {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .setup-step-title strong {
        font-size: 14px;
        color: #1a1a1a;
    }

    .setup-step-title span {
        font-size: 12px;
        color: #6c757d;
    }

    .setup-step-content {
        padding: 16px;
    }

    /* QR Code */
    .qr-code-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .qr-apps {
        text-align: center;
    }

    .qr-apps-label {
        font-size: 12px;
        color: #6c757d;
        display: block;
        margin-bottom: 8px;
    }

    .qr-apps-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
    }

    .qr-app-badge {
        font-size: 11px;
        padding: 4px 10px;
        background: #e9ecef;
        border-radius: 20px;
        color: #495057;
    }

    /* Secret Key */
    .secret-key-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8f9fa;
        padding: 8px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .secret-key {
        flex: 1;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-size: 13px;
        color: #1a1a1a;
        background: transparent;
        padding: 8px 12px;
        word-break: break-all;
    }

    .btn-copy {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        color: #495057;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .btn-copy:hover {
        background: #f8f9fa;
        border-color: #ced4da;
    }

    .btn-copy.copied {
        background: #198754;
        border-color: #198754;
        color: white;
    }

    /* Code Input */
    .input-wrapper-code {
        position: relative;
    }

    .form-input-code {
        font-size: 24px !important;
        font-weight: 700 !important;
        letter-spacing: 8px !important;
        text-align: center !important;
        padding: 14px 14px 14px 48px !important;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace !important;
    }

    .form-input-code::placeholder {
        letter-spacing: 8px;
        color: #ced4da;
    }

    /* Success Button */
    .btn-auth-success {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 24px;
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 12px;
    }

    .btn-auth-success:hover {
        background: linear-gradient(135deg, #157347 0%, #146c43 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(25, 135, 84, 0.25);
    }

    .btn-auth-success:active {
        transform: translateY(0);
    }

    .btn-auth-success.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    /* Skip Button */
    .btn-skip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0;
        background: transparent;
        border: none;
        color: #6c757d;
        font-size: 13px;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .btn-skip:hover {
        color: #495057;
    }

    /* Mobile */
    @media (max-width: 576px) {
        .setup-step-header {
            padding: 12px;
        }

        .setup-step-content {
            padding: 12px;
        }

        .qr-code-wrapper {
            padding: 16px;
        }

        .secret-key-wrapper {
            flex-direction: column;
            align-items: stretch;
        }

        .secret-key {
            text-align: center;
            font-size: 11px;
        }

        .btn-copy {
            justify-content: center;
        }

        .form-input-code {
            font-size: 20px !important;
            letter-spacing: 6px !important;
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
        // Only allow numbers
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto submit when 6 digits
            if (this.value.length === 6) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><span>Mengaktifkan...</span>';

                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });

        // Handle paste
        codeInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericOnly = pastedText.replace(/[^0-9]/g, '').substring(0, 6);
            this.value = numericOnly;

            if (numericOnly.length === 6) {
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg><span>Mengaktifkan...</span>';

                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });
    }
});

// Copy secret key
function copySecret() {
    const secret = document.getElementById('secretKey').textContent.trim();
    const copyBtn = document.getElementById('copyBtn');

    navigator.clipboard.writeText(secret).then(() => {
        copyBtn.classList.add('copied');
        copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg><span>Copied!</span>';

        setTimeout(() => {
            copyBtn.classList.remove('copied');
            copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg><span>Copy</span>';
        }, 2000);
    }).catch(() => {
        // Fallback
        const textArea = document.createElement('textarea');
        textArea.value = secret;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);

        copyBtn.classList.add('copied');
        copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg><span>Copied!</span>';

        setTimeout(() => {
            copyBtn.classList.remove('copied');
            copyBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg><span>Copy</span>';
        }, 2000);
    });
}
</script>
@endpush
