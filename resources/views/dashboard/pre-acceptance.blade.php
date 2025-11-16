@extends('layouts.app')

@section('title', 'Lengkapi Pengajuan Magang - PT Telkom Indonesia')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

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

.pre-acceptance-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem 0;
    position: relative;
    overflow: hidden;
}

.pre-acceptance-container::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(238, 46, 36, 0.05) 0%, transparent 70%);
    animation: floatBackground 20s ease-in-out infinite;
}

@keyframes floatBackground {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-10px, -10px) rotate(5deg); }
}

.step-indicator {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}

.step {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #6c757d;
    position: relative;
    z-index: 2;
    transition: all 0.3s ease;
    animation: stepPulse 2s ease-in-out infinite;
}

.step.active {
    background: var(--gradient-primary);
    border-color: var(--telkom-red);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(238, 46, 36, 0.3);
}

.step.completed {
    background: #28a745;
    border-color: #28a745;
    color: white;
}

.step-line {
    width: 150px;
    height: 3px;
    background: #dee2e6;
    margin: 0 -25px;
    position: relative;
    z-index: 1;
    transition: all 0.3s ease;
}

.step-line.completed {
    background: var(--gradient-primary);
}

.step-indicator {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}

.step-indicator::before {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    height: 3px;
    background: #dee2e6;
    z-index: 0;
    transform: translateY(-50%);
}

@keyframes stepPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.opportunity-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease-out;
}

.opportunity-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--gradient-primary);
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.field-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    background: white;
}

.field-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(238, 46, 36, 0.1), transparent);
    transition: left 0.5s;
}

.field-card:hover::before {
    left: 100%;
}

.field-card:hover {
    border-color: var(--telkom-red);
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.2);
}

.field-card.selected {
    border-color: var(--telkom-red);
    border-width: 3px;
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
    transform: translateY(-3px);
}

.field-card.selected::after {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 35px;
    height: 35px;
    background: var(--telkom-red);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.3rem;
    z-index: 5;
    animation: checkmarkPop 0.3s ease-out;
}

@keyframes checkmarkPop {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}

.field-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    animation: iconFloat 3s ease-in-out infinite;
}

@keyframes iconFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.field-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.field-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.profile-form-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    animation: slideInUp 0.8s ease-out;
}

.form-floating {
    margin-bottom: 1.5rem;
}

.form-floating > .form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem 0.75rem;
    transition: all 0.3s ease;
}

.form-floating > .form-control:focus {
    border-color: var(--telkom-red);
    box-shadow: 0 0 0 0.2rem rgba(238, 46, 36, 0.25);
    transform: translateY(-2px);
}

.document-upload-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    animation: slideInUp 1s ease-out;
}

.upload-card {
    border: 2px dashed #dee2e6;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    margin-bottom: 1.5rem;
}

.upload-card::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(238, 46, 36, 0.1);
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
}

.upload-card:hover::before {
    width: 300px;
    height: 300px;
}

.upload-card:hover {
    border-color: var(--telkom-red);
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.2);
}

.upload-card.uploaded {
    border-color: #28a745;
    background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
}

.upload-card.uploading {
    border-color: #ffc107;
    background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
    pointer-events: none;
}

.upload-icon {
    font-size: 3rem;
    color: var(--telkom-red);
    margin-bottom: 1rem;
    animation: bounceIcon 2s ease-in-out infinite;
    position: relative;
    z-index: 1;
}

@keyframes bounceIcon {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.upload-text {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.upload-hint {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
    position: relative;
    z-index: 1;
}

.btn-submit {
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-submit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-submit:hover::before {
    left: 100%;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(238, 46, 36, 0.3);
}

.progress-bar-container {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    animation: slideInUp 0.4s ease-out;
}

.progress-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.progress-bar-custom {
    height: 10px;
    background: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: var(--gradient-primary);
    border-radius: 10px;
    transition: width 0.5s ease;
    position: relative;
    overflow: hidden;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

@media (max-width: 768px) {
    .step-line {
        width: 80px;
    }
    
    .opportunity-section,
    .profile-form-section,
    .document-upload-section {
        padding: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="pre-acceptance-container">
    <div class="container">
        <!-- Progress Indicator -->
        <div class="progress-bar-container">
            <div class="progress-label">
                <span>Progress Penyelesaian Pengajuan</span>
                <span id="progressPercent">0%</span>
            </div>
            <div class="progress-bar-custom">
                <div class="progress-fill" id="progressFill" style="width: 0%"></div>
            </div>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step active" id="step1">
                <i class="fas fa-user"></i>
            </div>
            <div class="step-line" id="line1"></div>
            <div class="step" id="step2">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="step-line" id="line2"></div>
            <div class="step" id="step3">
                <i class="fas fa-file-upload"></i>
            </div>
            <div class="step-line" id="line3"></div>
            <div class="step" id="step4">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Step 1: Profile Form Section -->
        <div class="profile-form-section" id="profileSection">
            <h2 class="mb-4" style="color: var(--telkom-red); font-weight: 700;">
                <i class="fas fa-user-edit me-2"></i>Lengkapi Data Diri
            </h2>
            <p class="text-muted mb-4">
                Lengkapi informasi pribadi Anda yang belum diisi saat registrasi. 
                Informasi ini wajib untuk kelengkapan pengajuan magang.
            </p>

            <form method="POST" action="{{ route('dashboard.pre-acceptance.profile') }}" id="profileForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Nama Lengkap">
                            <label for="name">
                                <i class="fas fa-id-card me-2"></i>Nama Lengkap
                            </label>
                            @error('name')
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
                                   value="{{ old('nim', $user->nim) }}" 
                                   placeholder="NIM">
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
                                   value="{{ old('university', $user->university) }}" 
                                   placeholder="Universitas">
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
                                   value="{{ old('major', $user->major) }}" 
                                   placeholder="Jurusan">
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
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="No HP">
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
                                   value="{{ old('ktp_number', $user->ktp_number) }}" 
                                   placeholder="NIK" 
                                   maxlength="16"
                                   pattern="[0-9]{16}">
                            <label for="ktp_number">
                                <i class="fas fa-id-card me-2"></i>NIK (No.KTP) - 16 digit
                            </label>
                            @error('ktp_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Data Diri
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Bidang Peminatan Section -->
        <div class="opportunity-section" id="opportunitySection">
            <h2 class="mb-4" style="color: var(--telkom-red); font-weight: 700;">
                <i class="fas fa-briefcase me-2"></i>Bidang Peminatan yang Tersedia
            </h2>
            <p class="lead text-muted mb-4">
                Pilih bidang peminatan yang sesuai dengan minat dan karir Anda.
            </p>
            
            <form id="fieldSelectionForm">
                <div class="row">
                    @foreach($fields as $field)
                    <div class="col-md-6 mb-3">
                        <label class="field-card" style="cursor: pointer; position: relative;">
                            <input type="radio" 
                                   name="field_of_interest_id" 
                                   value="{{ $field->id }}" 
                                   class="field-radio"
                                   style="position: absolute; opacity: 0; width: 100%; height: 100%; cursor: pointer; z-index: 10;"
                                   onchange="toggleFieldSelection(this)"
                                   @if($application && $application->field_of_interest_id == $field->id) checked @endif>
                            <div class="field-icon" style="background: {{ $field->color ?? '#EE2E24' }};">
                                <i class="{{ $field->icon ?? 'fas fa-briefcase' }}"></i>
                            </div>
                            <h5 class="field-title">{{ $field->name }}</h5>
                            <p class="field-description">{{ $field->description }}</p>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>Durasi: {{ $field->duration_months }} Bulan
                                </small>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Step 3: Document Upload Section -->
        <div class="document-upload-section" id="documentSection">
            <h2 class="mb-4" style="color: var(--telkom-red); font-weight: 700;">
                <i class="fas fa-file-upload me-2"></i>Upload Dokumen Pendukung
            </h2>
            <p class="text-muted mb-4">
                Unggah dokumen-dokumen berikut untuk melengkapi pengajuan magang Anda. 
                Semua dokumen wajib diunggah.
            </p>

            <form method="POST" action="{{ route('dashboard.pre-acceptance.documents') }}" enctype="multipart/form-data" id="documentForm">
                @csrf
                
                <!-- KTM -->
                <div class="upload-card @if($application && $application->ktm_path) uploaded @endif" id="ktm-card" onclick="document.getElementById('ktm').click()">
                    <input type="file" 
                           class="form-control d-none" 
                           id="ktm" 
                           name="ktm" 
                           accept=".jpg,.jpeg,.png,.pdf"
                           onchange="autoUploadFile(this, 'ktm')">
                    <div class="upload-icon">
                        <i class="fas fa-id-card @if($application && $application->ktm_path) text-success @endif"></i>
                    </div>
                    <div class="upload-text" id="ktm-text">
                        @if($application && $application->ktm_path)
                            <i class="fas fa-check-circle me-2 text-success"></i>{{ basename($application->ktm_path) }} <small class="text-success">(Terunggah)</small>
                        @else
                            Kartu Tanda Mahasiswa (KTM)
                        @endif
                    </div>
                    <div class="upload-hint">Format: JPG, JPEG, PNG, PDF (Maksimal 2MB)</div>
                    @if($application && $application->ktm_path)
                        <div class="mt-2 upload-status">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>File: {{ basename($application->ktm_path) }}
                            </small>
                        </div>
                    @endif
                    @error('ktm')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Surat Permohonan -->
                <div class="upload-card @if($application && $application->surat_permohonan_path) uploaded @endif" id="surat_permohonan-card" onclick="document.getElementById('surat_permohonan').click()">
                    <input type="file" 
                           class="form-control d-none" 
                           id="surat_permohonan" 
                           name="surat_permohonan" 
                           accept=".pdf"
                           onchange="autoUploadFile(this, 'surat_permohonan')">
                    <div class="upload-icon">
                        <i class="fas fa-file-alt @if($application && $application->surat_permohonan_path) text-success @endif"></i>
                    </div>
                    <div class="upload-text" id="surat_permohonan-text">
                        @if($application && $application->surat_permohonan_path)
                            <i class="fas fa-check-circle me-2 text-success"></i>{{ basename($application->surat_permohonan_path) }} <small class="text-success">(Terunggah)</small>
                        @else
                            Surat Permohonan Magang
                        @endif
                    </div>
                    <div class="upload-hint">Format: PDF (Maksimal 2MB)</div>
                    @if($application && $application->surat_permohonan_path)
                        <div class="mt-2 upload-status">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>File: {{ basename($application->surat_permohonan_path) }}
                            </small>
                        </div>
                    @endif
                    @error('surat_permohonan')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CV -->
                <div class="upload-card @if($application && $application->cv_path) uploaded @endif" id="cv-card" onclick="document.getElementById('cv').click()">
                    <input type="file" 
                           class="form-control d-none" 
                           id="cv" 
                           name="cv" 
                           accept=".pdf"
                           onchange="autoUploadFile(this, 'cv')">
                    <div class="upload-icon">
                        <i class="fas fa-file-pdf @if($application && $application->cv_path) text-success @endif"></i>
                    </div>
                    <div class="upload-text" id="cv-text">
                        @if($application && $application->cv_path)
                            <i class="fas fa-check-circle me-2 text-success"></i>{{ basename($application->cv_path) }} <small class="text-success">(Terunggah)</small>
                        @else
                            Curriculum Vitae (CV)
                        @endif
                    </div>
                    <div class="upload-hint">Format: PDF (Maksimal 2MB)</div>
                    @if($application && $application->cv_path)
                        <div class="mt-2 upload-status">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>File: {{ basename($application->cv_path) }}
                            </small>
                        </div>
                    @endif
                    @error('cv')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Surat Berperilaku Baik -->
                <div class="upload-card @if($application && $application->good_behavior_path) uploaded @endif" id="good_behavior-card" onclick="document.getElementById('good_behavior').click()">
                    <input type="file" 
                           class="form-control d-none" 
                           id="good_behavior" 
                           name="good_behavior" 
                           accept=".pdf"
                           onchange="autoUploadFile(this, 'good_behavior')">
                    <div class="upload-icon">
                        <i class="fas fa-certificate @if($application && $application->good_behavior_path) text-success @endif"></i>
                    </div>
                    <div class="upload-text" id="good_behavior-text">
                        @if($application && $application->good_behavior_path)
                            <i class="fas fa-check-circle me-2 text-success"></i>{{ basename($application->good_behavior_path) }} <small class="text-success">(Terunggah)</small>
                        @else
                            Surat Berperilaku Baik
                        @endif
                    </div>
                    <div class="upload-hint">Format: PDF (Maksimal 2MB)</div>
                    @if($application && $application->good_behavior_path)
                        <div class="mt-2 upload-status">
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i>File: {{ basename($application->good_behavior_path) }}
                            </small>
                        </div>
                    @endif
                    @error('good_behavior')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

            </form>
        </div>

        <!-- Step 4: Waktu Magang Section -->
        <div class="date-section" id="dateSection">
            <h2 class="mb-4" style="color: var(--telkom-red); font-weight: 700;">
                <i class="fas fa-calendar-alt me-2"></i>Waktu Mulai dan Selesai Magang
            </h2>
            <p class="text-muted mb-4">
                Tentukan periode magang Anda. Pastikan tanggal yang dipilih sesuai dengan jadwal Anda.
            </p>

            <form method="POST" action="{{ route('dashboard.pre-acceptance.dates') }}" id="dateForm">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date', $application && $application->start_date ? $application->start_date->format('Y-m-d') : '') }}" 
                                   placeholder="Tanggal Mulai"
                                   min="{{ date('Y-m-d') }}"
                                   required>
                            <label for="start_date">
                                <i class="fas fa-calendar-check me-2"></i>Tanggal Mulai Magang
                            </label>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" 
                                   class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date', $application && $application->end_date ? $application->end_date->format('Y-m-d') : '') }}" 
                                   placeholder="Tanggal Selesai"
                                   required>
                            <label for="end_date">
                                <i class="fas fa-calendar-times me-2"></i>Tanggal Selesai Magang
                            </label>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Waktu Magang
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Bottom CTA: Daftar Sekarang -->
        <div class="mt-4">
            <form method="POST" action="{{ route('dashboard.pre-acceptance.complete') }}" id="completeForm">
                @csrf
                <input type="hidden" name="field_of_interest_id" id="field_of_interest_id_input" value="">
                <button type="submit" class="btn btn-submit w-100">
                    <i class="fas fa-check-circle me-2"></i>Daftar Sekarang
                </button>
                <small class="text-muted d-block text-center mt-2">
                    Pengajuan Anda akan ditinjau oleh admin. Anda akan mendapat notifikasi setelah admin memproses pengajuan.
                </small>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
    updateSteps();
    
    // NIK validation
    const nikInput = document.getElementById('ktp_number');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    }
});

function toggleFieldSelection(radio) {
    // Remove selected class from all cards
    document.querySelectorAll('.field-card').forEach(c => {
        c.classList.remove('selected');
    });
    
    // Add selected class to the clicked card
    if (radio && radio.checked) {
        const card = radio.closest('.field-card');
        if (card) {
            card.classList.add('selected');
        }
    }
    
    // Update hidden input untuk form submit
    const hiddenInput = document.getElementById('field_of_interest_id_input');
    if (hiddenInput && radio) {
        hiddenInput.value = radio.value;
    }
    
    // Visual feedback
    console.log('Field selected:', radio.value);
}

// Update hidden input saat halaman load dan setup event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize selected state
    document.querySelectorAll('input[name="field_of_interest_id"]').forEach(radio => {
        if (radio.checked) {
            toggleFieldSelection(radio);
        }
        
        // Add click event to ensure radio is checked
        radio.addEventListener('click', function(e) {
            this.checked = true;
            toggleFieldSelection(this);
        });
        
        // Add change event
        radio.addEventListener('change', function() {
            toggleFieldSelection(this);
        });
    });
    
    // Also make the entire card clickable
    document.querySelectorAll('.field-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Don't trigger if clicking on the radio itself
            if (e.target.type !== 'radio') {
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    toggleFieldSelection(radio);
                }
            }
        });
    });
});

function autoUploadFile(input, fieldName) {
    if (input.files && input.files[0]) {
        const card = input.closest('.upload-card');
        const textId = fieldName + '-text';
        const textElement = document.getElementById(textId);
        const icon = card.querySelector('.upload-icon i');
        
        // Show loading state
        card.classList.add('uploading');
        if (textElement) {
            textElement.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>Mengunggah...`;
        }
        if (icon) {
            icon.className = 'fas fa-spinner fa-spin';
        }
        
        // Create FormData
        const formData = new FormData();
        formData.append('file', input.files[0]);
        formData.append('field_name', fieldName);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value);
        
        // Upload file
        fetch('{{ route("dashboard.pre-acceptance.documents") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Upload gagal');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                card.classList.remove('uploading');
                card.classList.add('uploaded');
                
                if (icon) {
                    icon.className = 'fas fa-check-circle';
                    icon.style.color = '#28a745';
                }
                
                if (textElement) {
                    textElement.innerHTML = `<i class="fas fa-check-circle me-2 text-success"></i>${input.files[0].name} <small class="text-success">(Terunggah)</small>`;
                }
                
                // Add success indicator
                const existingStatus = card.querySelector('.upload-status');
                if (existingStatus) {
                    existingStatus.remove();
                }
                const statusDiv = document.createElement('div');
                statusDiv.className = 'mt-2 upload-status';
                statusDiv.innerHTML = `<small class="text-success"><i class="fas fa-check-circle me-1"></i>File: ${data.filename || input.files[0].name}</small>`;
                card.appendChild(statusDiv);
                
                // Show success message
                showNotification('File berhasil diunggah!', 'success');
                
                // Update progress
                setTimeout(updateProgress, 100);
                setTimeout(updateSteps, 100);
            } else {
                throw new Error(data.message || 'Upload gagal');
            }
        })
        .catch(error => {
            card.classList.remove('uploading');
            if (icon) {
                icon.className = 'fas fa-exclamation-circle';
            }
            if (textElement) {
                textElement.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>Upload gagal`;
            }
            showNotification(error.message || 'Terjadi kesalahan saat mengunggah file', 'error');
            // Reset input
            input.value = '';
        });
    }
}

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    const alert = document.createElement('div');
    alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        <i class="fas ${icon} me-2"></i>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}

function updateProgress() {
    const profileFields = ['name', 'nim', 'university', 'major', 'phone', 'ktp_number'];
    const documents = ['ktm_path', 'surat_permohonan_path', 'cv_path', 'good_behavior_path'];
    
    let completed = 0;
    let total = 0;
    
    // Step 1: Profile (6 fields = 25%)
    total += 6;
    profileFields.forEach(field => {
        const input = document.getElementById(field);
        if (input && input.value && input.value.trim() !== '') {
            completed++;
        }
    });
    
    // Step 2: Field of interest (1 = 25%)
    total += 1;
    if (document.querySelector('input[name="field_of_interest_id"]:checked') !== null) {
        completed++;
    }
    
    // Step 3: Documents (4 = 25%)
    total += 4;
    @if($application)
    const applicationData = @json($application);
    documents.forEach(doc => {
        if (applicationData && applicationData[doc]) {
            completed++;
        }
    });
    @endif
    
    // Step 4: Dates (2 = 25%)
    total += 2;
    const startDate = document.getElementById('start_date')?.value;
    const endDate = document.getElementById('end_date')?.value;
    if (startDate) completed++;
    if (endDate) completed++;
    
    const percent = Math.round((completed / total) * 100);
    document.getElementById('progressPercent').textContent = percent + '%';
    document.getElementById('progressFill').style.width = percent + '%';
}

function updateSteps() {
    const profileFields = ['name', 'nim', 'university', 'major', 'phone', 'ktp_number'];
    const documents = ['ktm_path', 'surat_permohonan_path', 'cv_path', 'good_behavior_path'];
    
    let profileCompleted = true;
    profileFields.forEach(field => {
        const input = document.getElementById(field);
        if (!input || !input.value || input.value.trim() === '') {
            profileCompleted = false;
        }
    });
    
    @if($application)
    const applicationData = @json($application);
    let documentsCompleted = true;
    documents.forEach(doc => {
        if (!applicationData || !applicationData[doc]) {
            documentsCompleted = false;
        }
    });
    @else
    let documentsCompleted = false;
    @endif
    
    // Check step 2: Field of interest
    const fieldSelected = document.querySelector('input[name="field_of_interest_id"]:checked') !== null;
    
    // Check step 4: Dates
    const startDate = document.getElementById('start_date')?.value;
    const endDate = document.getElementById('end_date')?.value;
    const datesCompleted = startDate && endDate;
    
    // Update step 1
    if (profileCompleted) {
        document.getElementById('step1').classList.add('completed');
        document.getElementById('step2').classList.add('active');
        document.getElementById('line1').classList.add('completed');
    }
    
    // Update step 2
    if (fieldSelected) {
        document.getElementById('step2').classList.add('completed');
        document.getElementById('step3').classList.add('active');
        document.getElementById('line2').classList.add('completed');
    }
    
    // Update step 3
    if (documentsCompleted) {
        document.getElementById('step3').classList.add('completed');
        document.getElementById('step4').classList.add('active');
        document.getElementById('line3').classList.add('completed');
    }
    
    // Update step 4
    if (datesCompleted) {
        document.getElementById('step4').classList.add('completed');
    }
}

// Update progress on form changes
document.getElementById('profileForm')?.addEventListener('input', function() {
    setTimeout(updateProgress, 100);
    setTimeout(updateSteps, 100);
});

document.getElementById('documentForm')?.addEventListener('change', function() {
    setTimeout(updateProgress, 100);
    setTimeout(updateSteps, 100);
});

document.getElementById('dateForm')?.addEventListener('input', function() {
    setTimeout(updateProgress, 100);
    setTimeout(updateSteps, 100);
});

document.getElementById('dateForm')?.addEventListener('change', function() {
    setTimeout(updateProgress, 100);
    setTimeout(updateSteps, 100);
});

// Update when field of interest changes
document.querySelectorAll('input[name="field_of_interest_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        setTimeout(updateProgress, 100);
        setTimeout(updateSteps, 100);
    });
});
</script>
@endpush

