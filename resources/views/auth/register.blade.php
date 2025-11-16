@extends('layouts.app')

@section('title', 'Registrasi - PT Telkom Indonesia')

@push('styles')
<style>
:root {
    --telkom-red: #EE2E24;
    --telkom-red-bright: #EE2B24;
    --telkom-red-pure: #F60000;
    --telkom-black: #000000;
    --telkom-gray: #AAA5A6;
    --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
    --gradient-secondary: linear-gradient(135deg, #000000 0%, #AAA5A6 100%);
}

.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem 0;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
}

.auth-header {
    background: var(--gradient-primary);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.auth-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

.particle-system-container {
    width: 160px;
    height: 160px;
    position: relative;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

.particle {
    position: absolute;
    width: 8px;
    height: 8px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: particleOrbit 8s linear infinite;
}

.particle-1 {
    animation-delay: 0s;
    background: rgba(255, 255, 255, 0.8);
}

.particle-2 {
    animation-delay: 1s;
    background: rgba(255, 255, 255, 0.6);
}

.particle-3 {
    animation-delay: 2s;
    background: rgba(255, 255, 255, 0.7);
}

.particle-4 {
    animation-delay: 3s;
    background: rgba(255, 255, 255, 0.5);
}

.particle-5 {
    animation-delay: 4s;
    background: rgba(255, 255, 255, 0.9);
}

.particle-6 {
    animation-delay: 5s;
    background: rgba(255, 255, 255, 0.4);
}

.particle-7 {
    animation-delay: 6s;
    background: rgba(255, 255, 255, 0.6);
}

.particle-8 {
    animation-delay: 7s;
    background: rgba(255, 255, 255, 0.8);
}

.central-hub {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255, 255, 255, 0.5);
    color: white;
    font-size: 20px;
    animation: hubGlow 3s ease-in-out infinite;
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
}

.connection-line {
    position: absolute;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: lineFlow 2s ease-in-out infinite;
}

.line-1 {
    width: 60px;
    top: 30px;
    left: 50%;
    transform: translateX(-50%) rotate(0deg);
    animation-delay: 0s;
}

.line-2 {
    width: 60px;
    top: 50%;
    right: 30px;
    transform: translateY(-50%) rotate(90deg);
    animation-delay: 0.5s;
}

.line-3 {
    width: 60px;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) rotate(180deg);
    animation-delay: 1s;
}

.line-4 {
    width: 60px;
    top: 50%;
    left: 30px;
    transform: translateY(-50%) rotate(270deg);
    animation-delay: 1.5s;
}

@keyframes particleOrbit {
    0% {
        transform: rotate(0deg) translateX(70px) rotate(0deg);
        opacity: 0.6;
    }
    25% {
        transform: rotate(90deg) translateX(70px) rotate(-90deg);
        opacity: 1;
    }
    50% {
        transform: rotate(180deg) translateX(70px) rotate(-180deg);
        opacity: 0.8;
    }
    75% {
        transform: rotate(270deg) translateX(70px) rotate(-270deg);
        opacity: 1;
    }
    100% {
        transform: rotate(360deg) translateX(70px) rotate(-360deg);
        opacity: 0.6;
    }
}

@keyframes hubGlow {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 35px rgba(255, 255, 255, 0.6);
    }
}

@keyframes lineFlow {
    0%, 100% {
        opacity: 0.3;
        transform: translateX(-50%) rotate(0deg) scaleX(0.5);
    }
    50% {
        opacity: 1;
        transform: translateX(-50%) rotate(0deg) scaleX(1);
    }
}

.auth-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 2;
}

.auth-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    position: relative;
    z-index: 2;
}

.form-section {
    padding: 3rem;
}

.section-title {
    color: var(--telkom-red);
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f8f9fa;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus {
    border-color: var(--telkom-red);
    box-shadow: 0 0 0 0.2rem rgba(238, 46, 36, 0.25);
}

.form-floating > label {
    color: #6c757d;
    font-weight: 500;
}

.btn-register {
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.btn-register::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-register:hover::before {
    left: 100%;
}

.btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
}

.btn-register:active {
    transform: translateY(0);
}

.password-strength {
    margin-top: 0.5rem;
}

.strength-bar {
    height: 6px;
    border-radius: 3px;
    background-color: #e9ecef;
    overflow: hidden;
    margin-top: 0.5rem;
    border: 1px solid #dee2e6;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 3px;
    width: 0%;
}

.strength-weak { 
    background-color: #dc3545 !important; 
    box-shadow: 0 0 5px rgba(220, 53, 69, 0.3);
}

.strength-medium { 
    background-color: #ffc107 !important; 
    box-shadow: 0 0 5px rgba(255, 193, 7, 0.3);
}

.strength-strong { 
    background-color: #28a745 !important; 
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.3);
}

.strength-text {
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
}

.required-field {
    color: var(--telkom-red);
    font-weight: 600;
}


.link-primary {
    color: var(--telkom-red) !important;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.link-primary:hover {
    color: var(--telkom-red-pure) !important;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem 0;
    }
    
    .form-section {
        padding: 2rem;
    }
    
    .auth-title {
        font-size: 1.8rem;
    }
    
    .logo-container {
        width: 80px;
        height: 80px;
    }
    
    .logo-img {
        width: 50px;
        height: 50px;
    }
}
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="particle-system-container">
                <div class="particle particle-1"></div>
                <div class="particle particle-2"></div>
                <div class="particle particle-3"></div>
                <div class="particle particle-4"></div>
                <div class="particle particle-5"></div>
                <div class="particle particle-6"></div>
                <div class="particle particle-7"></div>
                <div class="particle particle-8"></div>
                <div class="central-hub">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="connection-line line-1"></div>
                <div class="connection-line line-2"></div>
                <div class="connection-line line-3"></div>
                <div class="connection-line line-4"></div>
            </div>
            
            <h1 class="auth-title">Daftar Program Magang</h1>
            <p class="auth-subtitle">Bergabunglah dengan program magang PT Telkom Indonesia dan kembangkan potensi Anda</p>
        </div>
        
        <!-- Form Section -->
        <div class="form-section">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Registrasi Gagal!</strong> Periksa kembali data yang Anda masukkan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form dengan autocomplete="off" dan data-lpignore -->
            <form method="POST" action="{{ route('register') }}" id="registerForm" autocomplete="off" data-lpignore="true">
                @csrf

                <!-- Hidden input untuk mengelabui browser -->
                <input type="text" style="display:none;" autocomplete="false" data-lpignore="true">
                <input type="password" style="display:none;" autocomplete="false" data-lpignore="true">

                <!-- Personal Information -->
                <h3 class="section-title">
                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                </h3>
                
                <!-- Info Box -->
                <div class="alert alert-info mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Informasi Penting:</strong> NIM, Asal Sekolah/Perguruan Tinggi, Jurusan, No HP Aktif, dan NIK (No.KTP) tidak wajib diisi saat registrasi, tetapi akan menjadi wajib ketika Anda hendak mendaftar program magang.
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Nama Lengkap"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="name">
                                <i class="fas fa-id-card me-2"></i>Nama Lengkap (Opsional)
                            </label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Email Aktif"
                                   required
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="email">
                                <i class="fas fa-envelope me-2"></i>Email Aktif <span class="required-field">*</span>
                            </label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('nim') is-invalid @enderror" 
                                   id="nim" 
                                   name="nim" 
                                   value="{{ old('nim') }}" 
                                   placeholder="NIM"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="nim">
                                <i class="fas fa-graduation-cap me-2"></i>NIM (Opsional)
                            </label>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('university') is-invalid @enderror" 
                                   id="university" 
                                   name="university" 
                                   value="{{ old('university') }}" 
                                   placeholder="Asal Sekolah/Perguruan Tinggi"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="university">
                                <i class="fas fa-university me-2"></i>Asal Sekolah/Perguruan Tinggi (Opsional)
                            </label>
                            @error('university')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('major') is-invalid @enderror" 
                                   id="major" 
                                   name="major" 
                                   value="{{ old('major') }}" 
                                   placeholder="Jurusan"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="major">
                                <i class="fas fa-book me-2"></i>Jurusan (Opsional)
                            </label>
                            @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="No HP Aktif"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="phone">
                                <i class="fas fa-phone me-2"></i>No HP Aktif (Opsional)
                            </label>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('ktp_number') is-invalid @enderror" 
                                   id="ktp_number" 
                                   name="ktp_number" 
                                   value="{{ old('ktp_number') }}" 
                                   placeholder="NIK (No.KTP) - 16 digit"
                                   maxlength="16"
                                   pattern="[0-9]{16}"
                                   inputmode="numeric"
                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                   autocomplete="off"
                                   data-lpignore="true">
                            <label for="ktp_number">
                                <i class="fas fa-id-card me-2"></i>NIK (No.KTP) - 16 digit (Opsional)
                            </label>
                            @error('ktp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <h3 class="section-title">
                    <i class="fas fa-lock me-2"></i>Keamanan Akun
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Password"
                                   required
                                   autocomplete="new-password"
                                   data-lpignore="true">
                            <label for="password">
                                <i class="fas fa-key me-2"></i>Password <span class="required-field">*</span>
                            </label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="password-strength mb-3">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Masukkan password</div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Konfirmasi Password"
                                   required
                                   autocomplete="new-password"
                                   data-lpignore="true">
                            <label for="password_confirmation">
                                <i class="fas fa-check-circle me-2"></i>Konfirmasi Password <span class="required-field">*</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="mb-0">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="link-primary">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function initPasswordStrength() {
        // Password strength elements
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');
        
        // Check if elements exist
        if (!passwordInput || !strengthFill || !strengthText) {
            console.warn('Password strength elements not found, retrying...');
            setTimeout(initPasswordStrength, 100);
            return;
        }
        
        console.log('Password strength indicator initialized');
        
        // Password strength checker
        function updatePasswordStrength() {
            const password = passwordInput.value;
            const strength = checkPasswordStrength(password);
            
            // Reset classes
            strengthFill.className = 'strength-fill';
            strengthFill.style.width = '0%';
            
            // Update strength bar based on strength
            if (password.length === 0) {
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Masukkan password';
                strengthText.className = 'strength-text';
            } else if (strength < 3) {
                strengthFill.style.width = '33%';
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Password lemah';
                strengthText.className = 'strength-text text-danger';
            } else if (strength < 5) {
                strengthFill.style.width = '66%';
                strengthFill.classList.add('strength-medium');
                strengthText.textContent = 'Password sedang';
                strengthText.className = 'strength-text text-warning';
            } else {
                strengthFill.style.width = '100%';
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Password kuat';
                strengthText.className = 'strength-text text-success';
            }
        }
        
        // Password input event listeners
        passwordInput.addEventListener('input', updatePasswordStrength);
        passwordInput.addEventListener('keyup', updatePasswordStrength);
        passwordInput.addEventListener('paste', function() {
            setTimeout(updatePasswordStrength, 10);
        });
        passwordInput.addEventListener('change', updatePasswordStrength);
        
        // Initialize if password field has value
        if (passwordInput.value) {
            updatePasswordStrength();
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initPasswordStrength();
            
            // Mencegah auto-fill saat halaman dimuat
            setTimeout(function() {
                const form = document.getElementById('registerForm');
                if (form) {
                    const inputs = form.querySelectorAll('input[type="password"]');
                    inputs.forEach(input => {
                        input.setAttribute('autocomplete', 'new-password');
                    });
                }
            }, 50);
        });
    } else {
        initPasswordStrength();
    }
    
    // Password confirmation checker
    function initPasswordConfirmation() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        if (!passwordInput || !confirmPasswordInput) {
            setTimeout(initPasswordConfirmation, 100);
            return;
        }
        
        function updatePasswordConfirmation() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    confirmPasswordInput.classList.remove('is-invalid');
                    confirmPasswordInput.classList.add('is-valid');
                } else {
                    confirmPasswordInput.classList.remove('is-valid');
                    confirmPasswordInput.classList.add('is-invalid');
                }
            } else {
                confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
            }
        }
        
        confirmPasswordInput.addEventListener('input', updatePasswordConfirmation);
        confirmPasswordInput.addEventListener('keyup', updatePasswordConfirmation);
        passwordInput.addEventListener('input', updatePasswordConfirmation);
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPasswordConfirmation);
    } else {
        initPasswordConfirmation();
    }
    
    function checkPasswordStrength(password) {
        let strength = 0;
        
        // Length check
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Character type checks
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        return strength;
    }
    
    // NIK validation
    function initNIKValidation() {
        const nikInput = document.getElementById('ktp_number');
        
        if (!nikInput) {
            setTimeout(initNIKValidation, 100);
            return;
        }
        
        function validateNIK() {
            // Remove any non-numeric characters
            nikInput.value = nikInput.value.replace(/[^0-9]/g, '');
            
            // Limit to 16 digits
            if (nikInput.value.length > 16) {
                nikInput.value = nikInput.value.slice(0, 16);
            }
        }
        
        nikInput.addEventListener('input', validateNIK);
        nikInput.addEventListener('keyup', validateNIK);
        nikInput.addEventListener('paste', function() {
            setTimeout(validateNIK, 10);
        });
        
        // Prevent non-numeric input on keypress
        nikInput.addEventListener('keypress', function(e) {
            // Allow: backspace, delete, tab, escape, enter, home, end, left, right, up, down
            if ([8, 9, 27, 13, 46, 35, 36, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true) ||
                (e.keyCode === 90 && e.ctrlKey === true)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        
        nikInput.addEventListener('blur', validateNIK);
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNIKValidation);
    } else {
        initNIKValidation();
    }
})();
</script>
@endpush