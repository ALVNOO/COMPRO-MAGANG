@extends('layouts.dashboard')

@section('title', 'Ubah Password - PT Telkom Indonesia')

@push('styles')
<style>
:root {
    --telkom-red: #EE2E24;
    --telkom-red-bright: #EE2B24;
    --telkom-red-pure: #F60000;
    --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
}

.password-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.password-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    max-width: 500px;
    width: 100%;
    margin: 0 1rem;
}

.password-header {
    background: var(--gradient-primary);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.password-header::before {
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

.password-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    position: relative;
    z-index: 2;
}

.password-icon i {
    font-size: 2rem;
    color: white;
}

.password-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 2;
}

.password-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    position: relative;
    z-index: 2;
}

.password-body {
    padding: 3rem;
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

.btn-change-password {
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

.btn-change-password::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-change-password:hover::before {
    left: 100%;
}

.btn-change-password:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
}

.btn-change-password:active {
    transform: translateY(0);
}

.password-strength {
    margin-top: 0.5rem;
}

.strength-bar {
    height: 4px;
    border-radius: 2px;
    background-color: #e9ecef;
    overflow: hidden;
    margin-top: 0.5rem;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-weak { background-color: #dc3545; }
.strength-medium { background-color: #ffc107; }
.strength-strong { background-color: #28a745; }

.strength-text {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

@media (max-width: 768px) {
    .password-container {
        padding: 1rem 0;
    }
    
    .password-card {
        margin: 0 0.5rem;
    }
    
    .password-body {
        padding: 2rem;
    }
    
    .password-title {
        font-size: 1.5rem;
    }
    
    .password-icon {
        width: 60px;
        height: 60px;
    }
    
    .password-icon i {
        font-size: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="password-container">
    <div class="password-card">
        <!-- Header -->
        <div class="password-header">
            <div class="password-icon">
                <i class="fas fa-key"></i>
            </div>
            
            <h1 class="password-title">Ubah Password</h1>
            <p class="password-subtitle">Pastikan password Anda aman dan mudah diingat</p>
        </div>
        
        <!-- Form Section -->
        <div class="password-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" id="changePasswordForm">
                @csrf
                
                <div class="form-floating">
                    <input type="password" 
                           class="form-control @error('current_password') is-invalid @enderror" 
                           id="current_password" 
                           name="current_password" 
                           placeholder="Password Lama"
                           required>
                    <label for="current_password">
                        <i class="fas fa-lock me-2"></i>Password Lama
                    </label>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-floating">
                    <input type="password" 
                           class="form-control @error('new_password') is-invalid @enderror" 
                           id="new_password" 
                           name="new_password" 
                           placeholder="Password Baru"
                           required>
                    <label for="new_password">
                        <i class="fas fa-key me-2"></i>Password Baru
                    </label>
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Password Strength Indicator -->
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText">Masukkan password baru</div>
                    </div>
                </div>
                
                <div class="form-floating">
                    <input type="password" 
                           class="form-control" 
                           id="new_password_confirmation" 
                           name="new_password_confirmation" 
                           placeholder="Konfirmasi Password Baru"
                           required>
                    <label for="new_password_confirmation">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Password Baru
                    </label>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-change-password">
                        <i class="fas fa-save me-2"></i>Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    // Password strength checker
    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = checkPasswordStrength(password);
        
        // Update strength bar
        strengthFill.className = 'strength-fill';
        if (password.length === 0) {
            strengthFill.style.width = '0%';
            strengthText.textContent = 'Masukkan password baru';
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
    });
    
    // Password confirmation checker
    confirmPasswordInput.addEventListener('input', function() {
        const password = newPasswordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        } else {
            this.classList.remove('is-valid', 'is-invalid');
        }
    });
    
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
});
</script>
@endpush