@extends('layouts.app')

@section('title', 'Login - PT Telkom Indonesia')

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
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 900px;
    width: 100%;
    margin: 0 1rem;
}

.auth-left {
    background: var(--gradient-primary);
    color: white;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.auth-left::before {
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

.auth-right {
    padding: 3rem;
}

.geometric-shapes-container {
    width: 180px;
    height: 180px;
    position: relative;
    margin: 0 auto 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

.shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.shape-1 {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    animation: floatUpDown 4s ease-in-out infinite;
}

.shape-2 {
    width: 15px;
    height: 15px;
    border-radius: 3px;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    animation: floatLeftRight 3s ease-in-out infinite;
}

.shape-3 {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    bottom: 20px;
    left: 20px;
    animation: floatDiagonal 5s ease-in-out infinite;
}

.shape-4 {
    width: 18px;
    height: 18px;
    border-radius: 3px;
    bottom: 20px;
    right: 20px;
    animation: floatRotate 6s ease-in-out infinite;
}

.shape-5 {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    top: 30%;
    left: 20px;
    animation: floatPulse 4.5s ease-in-out infinite;
}

.shape-6 {
    width: 16px;
    height: 16px;
    border-radius: 3px;
    top: 30%;
    right: 20px;
    animation: floatWave 3.5s ease-in-out infinite;
}

.center-circle {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(15px);
    border: 2px solid rgba(255, 255, 255, 0.4);
    color: white;
    font-size: 24px;
    animation: centerPulse 2s ease-in-out infinite;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
}

@keyframes floatUpDown {
    0%, 100% { transform: translateX(-50%) translateY(0px); }
    50% { transform: translateX(-50%) translateY(-15px); }
}

@keyframes floatLeftRight {
    0%, 100% { transform: translateY(-50%) translateX(0px); }
    50% { transform: translateY(-50%) translateX(-10px); }
}

@keyframes floatDiagonal {
    0%, 100% { transform: translate(0px, 0px) rotate(0deg); }
    50% { transform: translate(10px, -10px) rotate(180deg); }
}

@keyframes floatRotate {
    0%, 100% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(180deg) scale(1.2); }
}

@keyframes floatPulse {
    0%, 100% { transform: scale(1); opacity: 0.7; }
    50% { transform: scale(1.5); opacity: 1; }
}

@keyframes floatWave {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-8px) rotate(90deg); }
    75% { transform: translateY(8px) rotate(270deg); }
}

@keyframes centerPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 20px rgba(255, 255, 255, 0.3); }
    50% { transform: scale(1.1); box-shadow: 0 0 30px rgba(255, 255, 255, 0.5); }
}

.auth-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.auth-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 2rem;
    position: relative;
    z-index: 2;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    font-size: 1rem;
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

.btn-login {
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

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
}

.btn-login:active {
    transform: translateY(0);
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 2rem 0;
}

.feature-list li {
    padding: 0.5rem 0;
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
}

.feature-list li i {
    margin-right: 1rem;
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
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

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 8s ease-in-out infinite;
}

.floating-circle:nth-child(1) {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-circle:nth-child(2) {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
}

.floating-circle:nth-child(3) {
    width: 60px;
    height: 60px;
    top: 40%;
    left: 20%;
    animation-delay: 4s;
}

@media (max-width: 768px) {
    .auth-container {
        padding: 1rem 0;
    }
    
    .auth-card {
        margin: 0 0.5rem;
    }
    
    .auth-left {
        padding: 2rem;
    }
    
    .auth-right {
        padding: 2rem;
    }
    
    .auth-title {
        font-size: 2rem;
    }
    
    .logo-container {
        width: 100px;
        height: 100px;
    }
    
    .logo-img {
        width: 60px;
        height: 60px;
    }
}
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="row g-0">
            <!-- Left Side - Branding -->
            <div class="col-lg-5 auth-left">
                <div class="floating-elements">
                    <div class="floating-circle"></div>
                    <div class="floating-circle"></div>
                    <div class="floating-circle"></div>
                </div>
                
                <div class="geometric-shapes-container">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                    <div class="shape shape-4"></div>
                    <div class="shape shape-5"></div>
                    <div class="shape shape-6"></div>
                    <div class="center-circle">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                </div>
                
                <h1 class="auth-title">Selamat Datang</h1>
                <p class="auth-subtitle">Masuk ke akun Anda untuk mengakses program magang PT Telkom Indonesia</p>
                
                <ul class="feature-list">
                    <li>
                        <i class="fas fa-graduation-cap"></i>
                        <span>Program Magang Berkualitas</span>
                    </li>
                    <li>
                        <i class="fas fa-users"></i>
                        <span>Mentoring Profesional</span>
                    </li>
                    <li>
                        <i class="fas fa-certificate"></i>
                        <span>Sertifikat Resmi</span>
                    </li>
                    <li>
                        <i class="fas fa-network-wired"></i>
                        <span>Jaringan Luas</span>
                    </li>
                </ul>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="col-lg-7 auth-right">
                <div class="text-center mb-4">
                    <h2 class="fw-bold mb-2" style="color: var(--telkom-red);">Login</h2>
                    <p class="text-muted">Masuk ke akun Anda</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Login Gagal!</strong> Periksa kembali username/email dan password Anda.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Form dengan autocomplete="off" dan data-lpignore -->
                <form method="POST" action="{{ route('login') }}" autocomplete="off" data-lpignore="true">
                    @csrf

                    <!-- Hidden input untuk mengelabui browser -->
                    <input type="text" style="display:none;">
                    <input type="password" style="display:none;">

                    <div class="form-floating">
                        <input type="text" 
                               class="form-control @error('username') is-invalid @enderror" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}" 
                               placeholder="Username atau Email"
                               required 
                               autofocus
                               autocomplete="off"
                               data-lpignore="true">
                        <label for="username">
                            <i class="fas fa-user me-2"></i>Username atau Email
                        </label>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Password"
                               required
                               autocomplete="new-password"
                               data-lpignore="true">
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="mb-0">Belum punya akun? 
                        <a href="{{ route('register') }}" class="link-primary">Daftar di sini</a>
                    </p>
                    
                    <div class="mt-4">
                        <div class="position-relative">
                            <hr>
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">atau</span>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" class="btn btn-outline-danger btn-lg w-100" onclick="loginWithGoogle()">
                                <i class="fab fa-google me-2"></i>Login dengan Google
                            </button>
                            <p class="text-muted mt-2 mb-0" style="font-size: 0.875rem;">
                                Email dan password akan terisi otomatis
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mencegah auto-fill saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const usernameField = document.getElementById('username');
    const passwordField = document.getElementById('password');
    
    // Kosongkan field setelah halaman load
    setTimeout(function() {
        usernameField.value = '';
        passwordField.value = '';
        
        // Pastikan browser tidak menyimpan nilai
        usernameField.setAttribute('autocomplete', 'off');
        passwordField.setAttribute('autocomplete', 'new-password');
    }, 50);
});

function loginWithGoogle() {
    // Simulasi login dengan Google
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        alert('Fitur login dengan Google akan segera tersedia!\n\nUntuk saat ini, silakan gunakan form login biasa.');
    }, 2000);
}
</script>
@endsection