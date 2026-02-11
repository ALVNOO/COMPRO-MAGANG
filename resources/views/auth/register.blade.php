@extends('layouts.app')

@section('title', 'Daftar - Sistem Magang PT Telkom Indonesia')

@section('content')
<div class="auth-page">
    <div class="auth-wrapper">
        <!-- Left Panel - Illustration -->
        <div class="auth-panel-left">
            <div class="auth-panel-content">
                <div class="auth-illustration">
                    <div class="illustration-circle">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                    </div>
                    <div class="floating-shapes">
                        <div class="shape shape-1"></div>
                        <div class="shape shape-2"></div>
                        <div class="shape shape-3"></div>
                    </div>
                </div>
                <h2 class="auth-panel-title">Mulai Perjalanan Anda</h2>
                <p class="auth-panel-subtitle">Buat akun dalam hitungan detik dan mulai pendaftaran magang Anda</p>
                <div class="auth-features">
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Registrasi Cepat & Mudah</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Lengkapi Data Setelah Login</span>
                    </div>
                    <div class="auth-feature">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        <span>Pilih Bidang Sesuai Minat</span>
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
                    <h1 class="auth-title">Buat Akun Baru</h1>
                    <p class="auth-subtitle">Hanya perlu email dan password untuk memulai</p>
                </div>

                <!-- Error Alert -->
                @if($errors->any())
                <div class="auth-alert auth-alert-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="auth-form" autocomplete="off">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input type="email" id="email" name="email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" placeholder="contoh@email.com" required autofocus>
                        </div>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password" name="password" class="form-input @error('password') input-error @enderror" placeholder="Minimal 8 karakter" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <span class="strength-text" id="strengthText">Masukkan password</span>
                        </div>
                        @error('password')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg class="eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                            </button>
                        </div>
                        <span class="password-match" id="passwordMatch"></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-auth-primary">
                        <span>Buat Akun</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </form>

                <!-- Footer -->
                <div class="auth-footer">
                    <p>Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a></p>
                </div>

                <!-- Back to Home -->
                <a href="{{ route('home') }}" class="back-to-home">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');

    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    const passwordMatch = document.getElementById('passwordMatch');

    function checkStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        return strength;
    }

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = checkStrength(password);

        strengthFill.className = 'strength-fill';

        if (password.length === 0) {
            strengthFill.style.width = '0%';
            strengthText.textContent = 'Masukkan password';
            strengthText.className = 'strength-text';
        } else if (strength < 3) {
            strengthFill.style.width = '33%';
            strengthFill.classList.add('strength-weak');
            strengthText.textContent = 'Lemah';
            strengthText.className = 'strength-text text-weak';
        } else if (strength < 5) {
            strengthFill.style.width = '66%';
            strengthFill.classList.add('strength-medium');
            strengthText.textContent = 'Sedang';
            strengthText.className = 'strength-text text-medium';
        } else {
            strengthFill.style.width = '100%';
            strengthFill.classList.add('strength-strong');
            strengthText.textContent = 'Kuat';
            strengthText.className = 'strength-text text-strong';
        }

        checkMatch();
    });

    confirmInput.addEventListener('input', checkMatch);

    function checkMatch() {
        if (confirmInput.value.length === 0) {
            passwordMatch.textContent = '';
            return;
        }

        if (passwordInput.value === confirmInput.value) {
            passwordMatch.textContent = '✓ Password cocok';
            passwordMatch.className = 'password-match match-success';
        } else {
            passwordMatch.textContent = '✗ Password tidak cocok';
            passwordMatch.className = 'password-match match-error';
        }
    }
});
</script>
@endpush
