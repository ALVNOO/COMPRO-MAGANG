@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="max-width: 1100px;">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">
            
            <!-- Card -->
            <div class="card shadow-lg border-white rounded-4 hover-lift" style="border-width: 2px;">
                
                <div class="card-header bg-gradient text-white text-center py-4 border-white" 
                     style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-bottom-width: 2px;">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="bi bi-shield-shaded fs-1 me-3"></i>
                        <h3 class="mb-0 fw-bold fs-2" style="color: white;">Verifikasi Keamanan</h3>
                    </div>
                    <p class="mb-0 opacity-75 fs-6" style="color: rgba(255,255,255,0.8);">Two-Factor Authentication Required</p>
                </div>

                <div class="card-body p-6">
                    
                    <!-- Error Messages -->
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Akses Ditolak!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Kode Salah!</strong> Periksa kembali kode 6 digit Anda.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- User Info -->
                    <div class="text-center mb-5">
                        <div class="avatar-circle bg-light text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-person-circle fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ auth()->user()->name }}</h5>
                        <p class="text-muted fs-6 mb-1">
                            <i class="bi bi-envelope-fill me-1"></i> {{ auth()->user()->email }}
                        </p>
                        <p class="text-muted fs-6">
                            <i class="bi bi-shield-lock-fill me-1"></i> {{ ucfirst(auth()->user()->role) }}
                        </p>
                    </div>

                    <!-- Instructions -->
                    <div class="p-4 rounded-3 mb-4" style="background: #f8f9fa;">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-info-circle-fill text-primary fs-4 me-3 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-2">Buka Authenticator App Anda</h6>
                                <p class="text-muted mb-0 fs-6">
                                    Masukkan kode 6 digit yang tertera di aplikasi Google Authenticator, Authy, atau 1Password.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Form -->
                    <form method="POST" action="{{ route('2fa.verify.post') }}" id="verifyForm">
                        @csrf
                        
                        <div class="mb-4 text-center">
                            <label for="code" class="form-label fw-bold fs-5 mb-3">
                                <i class="bi bi-keyboard-fill"></i> 
                                Masukkan Kode 6 Digit
                            </label>
                            
                            <div class="code-inputs d-flex justify-content-center gap-2 mb-3">
                                <input type="text" name="code" id="code" 
                                       class="form-control form-control-lg text-center fw-bold py-4" 
                                       placeholder="000000" 
                                       maxlength="6" 
                                       required 
                                       autofocus
                                       style="letter-spacing: 12px; font-size: 32px; width: 280px; height: 75px;">
                            </div>
                            
                            <!-- TIMER & TEKS 30 DETIK SUDAH DIHAPUS -->
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary btn-md fw-bold px-4 py-2">
                                <i class="bi bi-unlock-fill me-2"></i> 
                                Verifikasi & Masuk
                            </button>
                            
                            <button type="button" class="btn btn-outline-secondary btn-md px-4 py-2"
                                    onclick="document.getElementById('logout-form').submit()">
                                <i class="bi bi-box-arrow-left me-2"></i> 
                                Batalkan Login
                            </button>
                        </div>
                    </form>

                    <!-- Hidden Logout Form -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <!-- Help Section -->
                    <div class="text-center mt-5 py-3 border-top border-white">
                        <small class="text-muted d-block mb-2 fs-6">
                            <i class="bi bi-question-circle-fill"></i> 
                            Butuh bantuan?
                        </small>
                        <p class="mb-0">
                            <a href="mailto:admin@example.com" class="text-decoration-none fw-bold">
                                <i class="bi bi-envelope"></i> Hubungi Admin
                            </a>
                        </p>
                    </div>

                </div>
                
                <!-- Footer -->
                <div class="card-footer text-center py-3 border-white" style="border-top-width: 2px;">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> 
                        Keamanan akun Anda adalah prioritas kami
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Hanya auto-focus dan angka-only (script timer dihapus)
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');  
    if (codeInput) {
        codeInput.focus();
        
        codeInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                document.getElementById('verifyForm').submit();
            }
        });
    }
});
</script>
@endpush

@endsection