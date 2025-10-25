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
    max-width: 1000px;
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

.logo-container {
    width: 100px;
    height: 100px;
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

.logo-img {
    width: 60px;
    height: 60px;
    object-fit: contain;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
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

.form-select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: var(--telkom-red);
    box-shadow: 0 0 0 0.2rem rgba(238, 46, 36, 0.25);
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

.field-interest-card {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.field-interest-card:hover {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.05);
}

.field-interest-card.selected {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.1);
}

.field-interest-card input[type="radio"] {
    display: none;
}

.field-interest-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.field-interest-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    font-size: 1.2rem;
}

.field-interest-title {
    font-weight: 600;
    color: #333;
    margin: 0;
}

.field-interest-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.other-field-card {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.other-field-card:hover {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.05);
}

.other-field-card.selected {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.1);
}

.other-field-icon {
    font-size: 2rem;
    color: var(--telkom-red);
    margin-bottom: 1rem;
}

.other-field-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.other-field-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.file-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.05);
}

.file-upload-area.dragover {
    border-color: var(--telkom-red);
    background-color: rgba(238, 46, 36, 0.1);
}

.file-upload-icon {
    font-size: 3rem;
    color: var(--telkom-red);
    margin-bottom: 1rem;
}

.file-upload-text {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.file-upload-hint {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
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
@php
    use App\Models\FieldOfInterest;
    $fields = FieldOfInterest::active()->ordered()->get();
@endphp

<div class="auth-container">
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-header">
            <div class="logo-container">
                <img src="{{ asset('image/telkom-logo.png') }}" 
                     alt="PT Telkom Indonesia" 
                     class="logo-img"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display: none; flex-direction: column; align-items: center; justify-content: center; color: white; font-weight: bold; text-align: center;">
                    <div style="font-size: 20px;">📡</div>
                    <div style="font-size: 10px;">TELKOM</div>
                </div>
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

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
                @csrf

                <!-- Personal Information -->
                <h3 class="section-title">
                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   placeholder="Username"
                                   required>
                            <label for="username">
                                <i class="fas fa-user me-2"></i>Username
                            </label>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Nama Lengkap"
                                   required>
                            <label for="name">
                                <i class="fas fa-id-card me-2"></i>Nama Lengkap
                            </label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Email Aktif"
                                   required>
                            <label for="email">
                                <i class="fas fa-envelope me-2"></i>Email Aktif
                            </label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('nim') is-invalid @enderror" 
                                   id="nim" 
                                   name="nim" 
                                   value="{{ old('nim') }}" 
                                   placeholder="NIM"
                                   required>
                            <label for="nim">
                                <i class="fas fa-graduation-cap me-2"></i>NIM
                            </label>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('university') is-invalid @enderror" 
                                   id="university" 
                                   name="university" 
                                   value="{{ old('university') }}" 
                                   placeholder="Asal Sekolah/Perguruan Tinggi"
                                   required>
                            <label for="university">
                                <i class="fas fa-university me-2"></i>Asal Sekolah/Perguruan Tinggi
                            </label>
                            @error('university')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('major') is-invalid @enderror" 
                                   id="major" 
                                   name="major" 
                                   value="{{ old('major') }}" 
                                   placeholder="Jurusan"
                                   required>
                            <label for="major">
                                <i class="fas fa-book me-2"></i>Jurusan
                            </label>
                            @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="No HP Aktif"
                                   required>
                            <label for="phone">
                                <i class="fas fa-phone me-2"></i>No HP Aktif
                            </label>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('ktp_number') is-invalid @enderror" 
                                   id="ktp_number" 
                                   name="ktp_number" 
                                   value="{{ old('ktp_number') }}" 
                                   placeholder="No KTP"
                                   required>
                            <label for="ktp_number">
                                <i class="fas fa-id-card me-2"></i>No KTP
                            </label>
                            @error('ktp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Field of Interest -->
                <h3 class="section-title">
                    <i class="fas fa-tags me-2"></i>Bidang Peminatan
                </h3>
                
                <div class="row">
                    @foreach($fields as $field)
                    <div class="col-md-6 mb-3">
                        <div class="field-interest-card" onclick="selectField({{ $field->id }})">
                            <input type="radio" name="field_of_interest_id" value="{{ $field->id }}" id="field_{{ $field->id }}" {{ old('field_of_interest_id') == $field->id ? 'checked' : '' }}>
                            <div class="field-interest-header">
                                <div class="field-interest-icon" style="background: {{ $field->color }};">
                                    <i class="{{ $field->icon }}"></i>
                                </div>
                                <h6 class="field-interest-title">{{ $field->name }}</h6>
                            </div>
                            <p class="field-interest-description">{{ $field->description }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Other Field Option -->
                    <div class="col-md-6 mb-3">
                        <div class="other-field-card" onclick="selectOtherField()">
                            <input type="radio" name="field_of_interest_id" value="other" id="field_other" {{ old('field_of_interest_id') == 'other' ? 'checked' : '' }}>
                            <div class="other-field-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h6 class="other-field-title">Bidang Lainnya</h6>
                            <p class="other-field-description">Bidang minat Anda tidak ada di list? Pilih opsi ini</p>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <h3 class="section-title">
                    <i class="fas fa-lock me-2"></i>Keamanan Akun
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Password"
                                   required>
                            <label for="password">
                                <i class="fas fa-key me-2"></i>Password
                            </label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Harus berbeda dengan username</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Konfirmasi Password"
                                   required>
                            <label for="password_confirmation">
                                <i class="fas fa-key me-2"></i>Konfirmasi Password
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <h3 class="section-title">
                    <i class="fas fa-file-upload me-2"></i>Dokumen Pendukung
                </h3>
                
                <div class="file-upload-area" onclick="document.getElementById('ktm').click()">
                    <div class="file-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="file-upload-text">Upload Kartu Tanda Mahasiswa (KTM)</div>
                    <div class="file-upload-hint">Format: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                    <input type="file" 
                           class="form-control @error('ktm') is-invalid @enderror" 
                           id="ktm" 
                           name="ktm" 
                           accept=".jpg,.jpeg,.png,.pdf" 
                           required
                           style="display: none;">
                    @error('ktm')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Internship Period -->
                <h3 class="section-title">
                    <i class="fas fa-calendar me-2"></i>Periode Magang
                </h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" 
                                   class="form-control" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date') }}"
                                   required>
                            <label for="start_date">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal Mulai Magang
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="date" 
                                   class="form-control" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date') }}"
                                   required>
                            <label for="end_date">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal Berakhir Magang
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-paper-plane me-2"></i>Daftar & Ajukan Permintaan Magang
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

<!-- Rules Modal -->
<div class="modal fade" id="rulesModal" tabindex="-1" aria-labelledby="rulesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: var(--gradient-primary); color: white;">
                <h5 class="modal-title" id="rulesModalLabel">
                    <i class="fas fa-gavel me-2"></i>Peraturan Pelaksanaan Magang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;" id="rulesContent">
                @php $rule = \App\Models\Rule::first(); @endphp
                @if($rule && $rule->content)
                    <div style="white-space: pre-line;">{!! nl2br(e($rule->content)) !!}</div>
                @else
                    <span class="text-muted">Belum ada peraturan yang ditetapkan.</span>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="agreeBtn" disabled>
                    <i class="fas fa-check me-2"></i>Saya mengerti dan setuju
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Field selection
function selectField(fieldId) {
    // Remove selected class from all cards
    document.querySelectorAll('.field-interest-card, .other-field-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Check the radio button
    document.getElementById('field_' + fieldId).checked = true;
}

function selectOtherField() {
    // Remove selected class from all cards
    document.querySelectorAll('.field-interest-card, .other-field-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selected class to clicked card
    event.currentTarget.classList.add('selected');
    
    // Check the radio button
    document.getElementById('field_other').checked = true;
}

// File upload handling
document.getElementById('ktm').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const uploadArea = document.querySelector('.file-upload-area');
        const icon = uploadArea.querySelector('.file-upload-icon i');
        const text = uploadArea.querySelector('.file-upload-text');
        
        icon.className = 'fas fa-file-check';
        text.textContent = 'File dipilih: ' + file.name;
        uploadArea.style.borderColor = 'var(--telkom-red)';
        uploadArea.style.backgroundColor = 'rgba(238, 46, 36, 0.05)';
    }
});

// Drag and drop
const uploadArea = document.querySelector('.file-upload-area');

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    uploadArea.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    uploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('ktm').files = files;
        const file = files[0];
        const icon = uploadArea.querySelector('.file-upload-icon i');
        const text = uploadArea.querySelector('.file-upload-text');
        
        icon.className = 'fas fa-file-check';
        text.textContent = 'File dipilih: ' + file.name;
        uploadArea.style.borderColor = 'var(--telkom-red)';
        uploadArea.style.backgroundColor = 'rgba(238, 46, 36, 0.05)';
    }
});

// Form submission with rules modal
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const rulesModal = new bootstrap.Modal(document.getElementById('rulesModal'));
    let formShouldSubmit = false;

    form.addEventListener('submit', function(e) {
        if (!formShouldSubmit) {
            e.preventDefault();
            rulesModal.show();
        }
    });

    // Enable agree button only after scroll to bottom
    const rulesContent = document.getElementById('rulesContent');
    const agreeBtn = document.getElementById('agreeBtn');
    
    if (rulesContent && agreeBtn) {
        rulesContent.addEventListener('scroll', function() {
            const isBottom = rulesContent.scrollTop + rulesContent.clientHeight >= rulesContent.scrollHeight - 5;
            if (isBottom) {
                agreeBtn.disabled = false;
            }
        });
        
        // Reset button if modal closed
        document.getElementById('rulesModal').addEventListener('hidden.bs.modal', function () {
            agreeBtn.disabled = true;
            rulesContent.scrollTop = 0;
        });
    }

    // On agree, submit the form
    if (agreeBtn) {
        agreeBtn.addEventListener('click', function() {
            formShouldSubmit = true;
            rulesModal.hide();
            setTimeout(() => {
                form.submit();
            }, 300);
        });
    }
});

// Auto-select field if coming from program page
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const fieldId = urlParams.get('field');
    
    if (fieldId) {
        const fieldCard = document.querySelector(`[onclick="selectField(${fieldId})"]`);
        if (fieldCard) {
            fieldCard.click();
        }
    }
});
</script>
@endpush
