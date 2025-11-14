@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="max-width: 1200px;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            
            <!-- Card dengan border putih dan animasi -->
            <div class="shadow-lg rounded-4 hover-lift animate-fade-in" style="background: white; overflow: hidden; border: 1px solid rgba(255,255,255,0.3);">
                
                <!-- Header -->
                <div class="text-white text-center py-5 animate-gradient" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-bottom: 1px solid rgba(255,255,255,0.3);">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <i class="bi bi-shield-lock-fill fs-1 me-4"></i>
                        <h3 class="mb-0 fw-bold display-6" style="color: white;">Secure Your Account</h3>
                    </div>
                    <p class="mb-0 opacity-75 fs-5" style="color: rgba(255,255,255,0.8);">Setup Two-Factor Authentication</p>
                </div>

                <div class="p-6">
                    
                    <!-- Status Messages -->
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm animate-slide-down" style="border-left: 4px solid #0dcaf0;">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm animate-slide-down" style="border-left: 4px solid #198754;">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm animate-slide-down" style="border-left: 4px solid #dc3545;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Oops!</strong> Please fix the following:
                            <ul class="mb-0 mt-3">
                                @foreach($errors->all() as $error)
                                    <li class="mb-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Instruction -->
                    <div class="text-center mb-5 animate-fade-in-up">
                        <div class="mb-4">
                            <i class="bi bi-qr-code fs-1 text-primary p-3 bg-light rounded-circle"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">Scan QR Code dengan Authenticator App</h5>
                        <p class="text-muted fs-6">
                            Gunakan <strong>Google Authenticator</strong>, <strong>Authy</strong>, atau <strong>1Password</strong>
                        </p>
                    </div>

                    <!-- QR Code - Subtle animation -->
                    <div class="text-center mb-5 animate-fade-in-up">
                        <div class="p-5 bg-light rounded-4 d-inline-block qr-wrapper">
                            {!! QrCode::size(320)->margin(0)->generate($qrCodeUrl) !!}
                        </div>
                        
                        <!-- Secret Key Section -->
                        <div class="mt-5">
                            <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                                <span class="badge bg-dark px-4 py-3 fs-6">
                                    <i class="bi bi-key me-2"></i>
                                    Secret Key:
                                </span>
                                <code class="user-select-all bg-dark text-light p-3 rounded fs-6" id="secretKey" style="max-width: 350px; overflow-x: auto;">
                                    {{ auth()->user()->two_factor_secret }}
                                </code>
                                <button class="btn btn-lg btn-outline-primary px-4 btn-ripple" onclick="copySecret()" title="Copy to clipboard">
                                    <i class="bi bi-clipboard fs-5"></i> Copy
                                </button>
                            </div>
                            <small class="text-muted d-block mt-3 fs-6">
                                <i class="bi bi-info-circle"></i> 
                                Klik tombol copy jika scan QR gagal
                            </small>
                        </div>
                    </div>

                    <!-- Verification Form -->
                    <div class="bg-light p-5 rounded-4 animate-fade-in-up" style="border: none;">
                        <form method="POST" action="{{ route('2fa.enable') }}" id="verifyForm">
                            @csrf
                            
                            <div class="mb-4 text-center">
                                <label for="code" class="form-label fw-bold fs-5 mb-3">
                                    <i class="bi bi-keyboard"></i> 
                                    Masukkan 6-Digit Code
                                </label>
                                
                                <div class="code-inputs d-flex justify-content-center">
                                    <input type="text" name="code" id="code" 
                                           class="form-control text-center fw-bold py-4 input-animated" 
                                           placeholder="000000" 
                                           maxlength="6" 
                                           required 
                                           autofocus
                                           style="letter-spacing: 12px; font-size: 36px; width: 320px; height: 80px;">
                                </div>
                                
                                <!-- Timer dengan progress bar -->
                                <div class="mt-4">
                                    <small class="text-muted d-block mb-2 fs-6">
                                        <i class="bi bi-clock-history"></i> 
                                        Kode akan berubah dalam 
                                        <span id="timer" class="fw-bold text-danger fs-5">30 detik</span>
                                    </small>
                                    <div class="progress" style="height: 4px; max-width: 200px; margin: 0 auto;">
                                        <div class="progress-bar bg-danger" id="timerProgress" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Button dengan ripple effect -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg fw-bold py-3 fs-5 btn-ripple">
                                    <i class="bi bi-shield-check me-2"></i> 
                                    AKTIFKAN 2FA SEKARANG
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Logout Option -->
                    <div class="text-center mt-4 animate-fade-in-up">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger text-decoration-none fs-6 btn-ripple">
                                <i class="bi bi-box-arrow-right me-2"></i> 
                                Logout & Setup Nanti
                            </button>
                        </form>
                    </div>

                </div>
                
                <!-- Footer dengan border putih -->
                <div class="text-center py-3" style="border-top: 1px solid rgba(255,255,255,0.3); background: white;">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> 
                        Keamanan akun Anda adalah prioritas kami
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Animasi fade-in untuk elemen */
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .animate-slide-down {
        animation: slideDown 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Gradient animation untuk header */
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradientShift 8s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Hover effect card */
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    }

    /* QR Code hover - Subtle zoom */
    .qr-wrapper {
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }
    .qr-wrapper:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    /* Input focus animation */
    .input-animated {
        transition: all 0.3s ease;
    }
    .input-animated:focus {
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        border-color: #667eea;
        transform: scale(1.02);
    }

    /* Ripple effect untuk button */
    .btn-ripple {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .btn-ripple::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    .btn-ripple:active::before {
        width: 300px;
        height: 300px;
    }
    
    /* Progress bar animation */
    .progress {
        animation: progressShrink 30s linear infinite;
    }
    
    @keyframes progressShrink {
        from { width: 100%; }
        to { width: 0%; }
    }

    /* Large screen optimizations */
    @media (min-width: 1200px) {
        .p-6 {
            padding: 4rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Animasi fade-in berurutan
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.animate-fade-in-up');
    elements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.15}s`;
    });
    
    // Auto-focus ke input
    const codeInput = document.getElementById('code');
    if (codeInput) {
        setTimeout(() => codeInput.focus(), 500);
        
        // Input animation
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                document.getElementById('verifyForm').submit();
            }
        });
    }
    
    // Copy secret key animation
    window.copySecret = function() {
        const secret = document.getElementById('secretKey').textContent;
        navigator.clipboard.writeText(secret).then(() => {
            // Create toast with slide animation
            const toast = document.createElement('div');
            toast.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 animate-slide-down';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            toast.style.textAlign = 'center';
            toast.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Secret key copied!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }).catch(() => {
            // Fallback untuk browser lama
            window.getSelection().selectAllChildren(document.getElementById('secretKey'));
            document.execCommand('copy');
        });
    }
    
    // Timer dengan progress bar
    const timerElement = document.getElementById('timer');
    const progressBar = document.getElementById('timerProgress');
    if (timerElement && progressBar) {
        let timeLeft = 30;
        setInterval(() => {
            timeLeft--;
            timerElement.textContent = `${timeLeft} detik`;
            
            // Update progress bar
            const percentage = (timeLeft / 30) * 100;
            progressBar.style.width = `${percentage}%`;
            
            // Warna berubah
            if (timeLeft <= 10) {
                timerElement.classList.add('text-danger');
                progressBar.classList.remove('bg-warning');
                progressBar.classList.add('bg-danger');
            } else {
                timerElement.classList.remove('text-danger');
                progressBar.classList.remove('bg-danger');
                progressBar.classList.add('bg-warning');
            }
            
            if (timeLeft <= 0) {
                timeLeft = 30;
                progressBar.style.width = '100%';
            }
        }, 1000);
    }
});
</script>
@endpush

@endsection