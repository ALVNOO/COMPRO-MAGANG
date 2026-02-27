@extends('layouts.app')

@section('title', 'Lengkapi Pengajuan Magang - PT Telkom Indonesia')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@section('content')
<div class="preaccept-page">

    <!-- Floating Save Indicator -->
    <div class="save-indicator" id="saveIndicator">
        <div class="save-indicator-content">
            <svg class="save-spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            <svg class="save-check" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="save-text">Tersimpan</span>
        </div>
    </div>

    <!-- Header Section -->
    <div class="preaccept-header">
        <div class="preaccept-header-inner">
            <a href="{{ route('home') }}" class="preaccept-back">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>

            <div class="preaccept-header-main">
                <div class="preaccept-header-text">
                    <h1>Lengkapi Data Pengajuan</h1>
                    <p>Data akan tersimpan otomatis saat Anda mengisi form</p>
                </div>

                <!-- Progress Circle -->
                <div class="progress-circle-wrapper">
                    <div class="progress-circle" id="progressCircle">
                        <svg viewBox="0 0 100 100">
                            <circle class="progress-bg" cx="50" cy="50" r="45"/>
                            <circle class="progress-fill-circle" cx="50" cy="50" r="45" id="progressCircleFill"/>
                        </svg>
                        <div class="progress-circle-text">
                            <span class="progress-number" id="progressPercent">0</span>
                            <span class="progress-label">%</span>
                        </div>
                    </div>
                    <span class="progress-caption">Kelengkapan Data</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Steps Navigation - Horizontal Pills -->
    <div class="preaccept-nav-wrapper">
        <nav class="preaccept-nav">
            <button type="button" class="nav-pill active" data-section="1" id="navPill1">
                <span class="pill-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <span class="pill-text">Data Diri</span>
                <span class="pill-status" id="status1"></span>
            </button>
            <button type="button" class="nav-pill" data-section="2" id="navPill2">
                <span class="pill-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </span>
                <span class="pill-text">Bidang Minat</span>
                <span class="pill-status" id="status2"></span>
            </button>
            <button type="button" class="nav-pill" data-section="3" id="navPill3">
                <span class="pill-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </span>
                <span class="pill-text">Dokumen</span>
                <span class="pill-status" id="status3"></span>
            </button>
            <button type="button" class="nav-pill" data-section="4" id="navPill4">
                <span class="pill-icon">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </span>
                <span class="pill-text">Jadwal</span>
                <span class="pill-status" id="status4"></span>
            </button>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="preaccept-main">
        <div class="preaccept-container">

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="preaccept-toast toast-success" id="flashToast">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="preaccept-toast toast-error" id="flashToast">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>{{ session('error') }}</span>
                <button type="button" onclick="this.parentElement.remove()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Section 1: Data Diri -->
            <section class="form-section active" id="section1">
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <h2>Informasi Pribadi</h2>
                            <p>Lengkapi data diri Anda dengan benar</p>
                        </div>
                    </div>

                    <div class="section-card-body">
                        <!-- Profile Picture (Optional) -->
                        <div class="profile-picture-section">
                            <div class="profile-picture-container" id="profilePictureContainer">
                                <div class="profile-picture-preview" id="profilePicturePreview">
                                    @if($user->profile_picture)
                                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" id="profileImg">
                                    @else
                                        <div class="profile-picture-placeholder" id="profilePlaceholder">
                                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="profile-picture-actions">
                                    <label for="profilePictureInput" class="btn-upload-photo">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        {{ $user->profile_picture ? 'Ganti Foto' : 'Unggah Foto' }}
                                    </label>
                                    <input type="file" id="profilePictureInput" accept="image/jpeg,image/png,image/jpg" class="hidden-input">
                                    @if($user->profile_picture)
                                        <button type="button" class="btn-remove-photo" id="removeProfilePicture">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="profile-picture-info">
                                <h4>Foto Profil <span class="optional-badge">Opsional</span></h4>
                                <p>Unggah foto formal untuk melengkapi profil Anda</p>
                                <ul class="photo-requirements">
                                    <li>Format: JPG, JPEG, atau PNG</li>
                                    <li>Ukuran maksimal: 2MB</li>
                                    <li>Disarankan foto formal dengan latar polos</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="name">
                                    Nama Lengkap
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                           placeholder="Masukkan nama lengkap sesuai KTP"
                                           data-field="profile" autocomplete="name">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="nim">
                                    NIM
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                        <line x1="6" y1="8" x2="18" y2="8"/>
                                        <line x1="6" y1="12" x2="12" y2="12"/>
                                    </svg>
                                    <input type="text" id="nim" name="nim" value="{{ old('nim', $user->nim) }}"
                                           placeholder="Nomor Induk Mahasiswa"
                                           data-field="profile">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="university">
                                    Asal Institusi
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                                    </svg>
                                    <input type="text" id="university" name="university" value="{{ old('university', $user->university) }}"
                                           placeholder="Nama universitas atau sekolah"
                                           data-field="profile">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="major">
                                    Jurusan / Program Studi
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    </svg>
                                    <input type="text" id="major" name="major" value="{{ old('major', $user->major) }}"
                                           placeholder="Jurusan atau program studi Anda"
                                           data-field="profile">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-field">
                                <label for="phone">
                                    Nomor HP / WhatsApp
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.362 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.338 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                           placeholder="08xxxxxxxxxx"
                                           data-field="profile">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="ktp_number">
                                    NIK (Nomor Induk Kependudukan)
                                    <span class="field-required">*</span>
                                </label>
                                <div class="field-input-wrap">
                                    <svg class="field-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                        <circle cx="8" cy="10" r="2"/>
                                        <path d="M14 10h4M14 14h4M6 16h12"/>
                                    </svg>
                                    <input type="text" id="ktp_number" name="ktp_number" value="{{ old('ktp_number', $user->ktp_number) }}"
                                           placeholder="16 digit NIK sesuai KTP"
                                           maxlength="16" pattern="[0-9]{16}"
                                           data-field="profile">
                                    <span class="field-check">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </span>
                                </div>
                                <span class="field-hint">Pastikan NIK terdiri dari 16 digit angka</span>
                            </div>
                        </div>
                    </div>

                    <div class="section-card-footer">
                        <button type="button" class="btn-next" onclick="goToSection(2)">
                            Lanjut ke Bidang Minat
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Section 2: Bidang Minat -->
            <section class="form-section" id="section2">
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon icon-purple">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                            </svg>
                        </div>
                        <div>
                            <h2>Pilih Bidang Peminatan</h2>
                            <p>Pilih satu bidang yang sesuai dengan minat dan keahlian Anda</p>
                        </div>
                    </div>

                    <div class="section-card-body">
                        <div class="fields-selection">
                            @foreach($fields as $field)
                            <label class="field-option @if($application && $application->field_of_interest_id == $field->id) selected @endif">
                                <input type="radio" name="field_of_interest_id" value="{{ $field->id }}"
                                    @if($application && $application->field_of_interest_id == $field->id) checked @endif
                                    data-field="interest">
                                <div class="field-option-content">
                                    <div class="field-option-icon" style="background: {{ $field->color ?? '#EE2E24' }}">
                                        <i class="{{ $field->icon ?? 'fas fa-briefcase' }}"></i>
                                    </div>
                                    <div class="field-option-info">
                                        <h4>{{ $field->name }}</h4>
                                        <p>{{ $field->description }}</p>
                                        <div class="field-option-meta">
                                            <span class="meta-item">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="10"/>
                                                    <polyline points="12 6 12 12 16 14"/>
                                                </svg>
                                                {{ $field->duration_months }} Bulan
                                            </span>
                                        </div>
                                    </div>
                                    <div class="field-option-check">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-card-footer">
                        <button type="button" class="btn-back" onclick="goToSection(1)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"/>
                                <polyline points="12 19 5 12 12 5"/>
                            </svg>
                            Kembali
                        </button>
                        <button type="button" class="btn-next" onclick="goToSection(3)">
                            Lanjut ke Upload Dokumen
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Section 3: Upload Dokumen -->
            <section class="form-section" id="section3">
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon icon-blue">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <div>
                            <h2>Upload Dokumen Pendukung</h2>
                            <p>Unggah dokumen yang diperlukan untuk melengkapi pengajuan</p>
                        </div>
                    </div>

                    <div class="section-card-body">
                        <div class="uploads-list">
                            <!-- KTM -->
                            <div class="upload-item @if($application && $application->ktm_path) completed @endif" id="upload-ktm">
                                <div class="upload-item-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                                        <circle cx="8" cy="10" r="2"/>
                                        <path d="M14 10h4M14 14h4"/>
                                    </svg>
                                </div>
                                <div class="upload-item-info">
                                    <h4>Kartu Tanda Mahasiswa (KTM)</h4>
                                    <p class="upload-item-status" id="ktm-status">
                                        @if($application && $application->ktm_path)
                                        <span class="status-uploaded">{{ basename($application->ktm_path) }}</span>
                                        @else
                                        <span class="status-pending">Belum diupload</span>
                                        @endif
                                    </p>
                                    <span class="upload-item-hint">Format: JPG, PNG, PDF (Maks. 2MB)</span>
                                </div>
                                <div class="upload-item-action">
                                    <input type="file" id="ktm" name="ktm" accept=".jpg,.jpeg,.png,.pdf"
                                           onchange="handleFileUpload(this, 'ktm')" class="upload-file-input">
                                    <label for="ktm" class="btn-upload">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        <span>@if($application && $application->ktm_path) Ganti @else Upload @endif</span>
                                    </label>
                                </div>
                                <div class="upload-item-check">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Surat Permohonan -->
                            <div class="upload-item @if($application && $application->surat_permohonan_path) completed @endif" id="upload-surat_permohonan">
                                <div class="upload-item-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                    </svg>
                                </div>
                                <div class="upload-item-info">
                                    <h4>Surat Permohonan Magang</h4>
                                    <p class="upload-item-status" id="surat_permohonan-status">
                                        @if($application && $application->surat_permohonan_path)
                                        <span class="status-uploaded">{{ basename($application->surat_permohonan_path) }}</span>
                                        @else
                                        <span class="status-pending">Belum diupload</span>
                                        @endif
                                    </p>
                                    <span class="upload-item-hint">Format: PDF (Maks. 2MB)</span>
                                </div>
                                <div class="upload-item-action">
                                    <input type="file" id="surat_permohonan" name="surat_permohonan" accept=".pdf"
                                           onchange="handleFileUpload(this, 'surat_permohonan')" class="upload-file-input">
                                    <label for="surat_permohonan" class="btn-upload">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        <span>@if($application && $application->surat_permohonan_path) Ganti @else Upload @endif</span>
                                    </label>
                                </div>
                                <div class="upload-item-check">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- CV -->
                            <div class="upload-item @if($application && $application->cv_path) completed @endif" id="upload-cv">
                                <div class="upload-item-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                    </svg>
                                </div>
                                <div class="upload-item-info">
                                    <h4>Curriculum Vitae (CV)</h4>
                                    <p class="upload-item-status" id="cv-status">
                                        @if($application && $application->cv_path)
                                        <span class="status-uploaded">{{ basename($application->cv_path) }}</span>
                                        @else
                                        <span class="status-pending">Belum diupload</span>
                                        @endif
                                    </p>
                                    <span class="upload-item-hint">Format: PDF (Maks. 2MB)</span>
                                </div>
                                <div class="upload-item-action">
                                    <input type="file" id="cv" name="cv" accept=".pdf"
                                           onchange="handleFileUpload(this, 'cv')" class="upload-file-input">
                                    <label for="cv" class="btn-upload">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        <span>@if($application && $application->cv_path) Ganti @else Upload @endif</span>
                                    </label>
                                </div>
                                <div class="upload-item-check">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Surat Berkelakuan Baik -->
                            <div class="upload-item @if($application && $application->good_behavior_path) completed @endif" id="upload-good_behavior">
                                <div class="upload-item-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="8" r="7"/>
                                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                                    </svg>
                                </div>
                                <div class="upload-item-info">
                                    <h4>Surat Berkelakuan Baik</h4>
                                    <p class="upload-item-status" id="good_behavior-status">
                                        @if($application && $application->good_behavior_path)
                                        <span class="status-uploaded">{{ basename($application->good_behavior_path) }}</span>
                                        @else
                                        <span class="status-pending">Belum diupload</span>
                                        @endif
                                    </p>
                                    <span class="upload-item-hint">Format: PDF (Maks. 2MB)</span>
                                </div>
                                <div class="upload-item-action">
                                    <input type="file" id="good_behavior" name="good_behavior" accept=".pdf"
                                           onchange="handleFileUpload(this, 'good_behavior')" class="upload-file-input">
                                    <label for="good_behavior" class="btn-upload">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                        <span>@if($application && $application->good_behavior_path) Ganti @else Upload @endif</span>
                                    </label>
                                </div>
                                <div class="upload-item-check">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-card-footer">
                        <button type="button" class="btn-back" onclick="goToSection(2)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"/>
                                <polyline points="12 19 5 12 12 5"/>
                            </svg>
                            Kembali
                        </button>
                        <button type="button" class="btn-next" onclick="goToSection(4)">
                            Lanjut ke Jadwal
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Section 4: Jadwal Magang -->
            <section class="form-section" id="section4">
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon icon-green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <div>
                            <h2>Jadwal Magang</h2>
                            <p>Tentukan periode magang yang Anda inginkan</p>
                        </div>
                    </div>

                    <div class="section-card-body">
                        <div class="date-selection">
                            <div class="date-field">
                                <label for="start_date">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    Tanggal Mulai
                                    <span class="field-required">*</span>
                                </label>
                                <input type="date" id="start_date" name="start_date"
                                    value="{{ old('start_date', $application && $application->start_date ? $application->start_date->format('Y-m-d') : '') }}"
                                    min="{{ date('Y-m-d') }}" data-field="dates">
                            </div>

                            <div class="date-arrow">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </div>

                            <div class="date-field">
                                <label for="end_date">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                        <line x1="16" y1="2" x2="16" y2="6"/>
                                        <line x1="8" y1="2" x2="8" y2="6"/>
                                        <line x1="3" y1="10" x2="21" y2="10"/>
                                    </svg>
                                    Tanggal Selesai
                                    <span class="field-required">*</span>
                                </label>
                                <input type="date" id="end_date" name="end_date"
                                    value="{{ old('end_date', $application && $application->end_date ? $application->end_date->format('Y-m-d') : '') }}"
                                    data-field="dates">
                            </div>
                        </div>

                        <div class="date-info" id="dateInfo">
                            @if($application && $application->start_date && $application->end_date)
                            @php
                                $start = \Carbon\Carbon::parse($application->start_date);
                                $end = \Carbon\Carbon::parse($application->end_date);
                                $diff = $start->diffInMonths($end);
                            @endphp
                            <div class="date-info-content">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <span>Durasi magang: <strong>{{ $diff }} bulan</strong> ({{ $start->format('d M Y') }} - {{ $end->format('d M Y') }})</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="section-card-footer">
                        <button type="button" class="btn-back" onclick="goToSection(3)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"/>
                                <polyline points="12 19 5 12 12 5"/>
                            </svg>
                            Kembali
                        </button>
                    </div>
                </div>
            </section>

            <!-- Submit Section -->
            <div class="submit-section" id="submitSection">
                <div class="submit-card">
                    <div class="submit-card-content">
                        <div class="submit-info">
                            <div class="submit-icon" id="submitIcon">
                                <!-- Default state: Document/Send icon -->
                                <svg class="icon-default" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                <!-- Complete state: Animated checkmark -->
                                <svg class="icon-complete" width="40" height="40" viewBox="0 0 52 52">
                                    <circle class="checkmark-circle" cx="26" cy="26" r="23" fill="none" stroke="currentColor" stroke-width="3"/>
                                    <path class="checkmark-check" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" d="M14 27l8 8 16-16"/>
                                </svg>
                                <!-- Ripple effects container -->
                                <div class="submit-ripples"></div>
                                <!-- Particle effects container -->
                                <div class="submit-particles" id="submitParticles"></div>
                            </div>
                            <div>
                                <h3>Siap Mengajukan Magang?</h3>
                                <p>Pastikan semua data sudah terisi dengan benar. Pengajuan akan ditinjau oleh tim kami.</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('dashboard.pre-acceptance.complete') }}" id="completeForm">
                            @csrf
                            <input type="hidden" name="field_of_interest_id" id="hidden_field_id" value="{{ $application->field_of_interest_id ?? '' }}">
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                Ajukan Magang Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cropper Modal -->
<div class="crop-dialog-overlay" id="cropperModal">
    <div class="crop-dialog">
        <div class="crop-dialog-header">
            <h3>Sesuaikan Foto Profil</h3>
            <button type="button" class="crop-dialog-close" id="closeCropperModal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="crop-dialog-body">
            <div class="crop-dialog-canvas">
                <img id="cropperImage" src="" alt="Crop Preview">
            </div>
            <div class="crop-dialog-preview">
                <p class="preview-label">Preview</p>
                <div class="crop-dialog-preview-circle" id="cropperPreview"></div>
            </div>
        </div>
        <div class="crop-dialog-footer">
            <div class="crop-dialog-tools">
                <button type="button" class="crop-tool-btn" data-action="rotate-left" title="Putar Kiri">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2.5 2v6h6M2.66 15.57a10 10 0 1 0 .57-8.38"/>
                    </svg>
                </button>
                <button type="button" class="crop-tool-btn" data-action="rotate-right" title="Putar Kanan">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38"/>
                    </svg>
                </button>
                <button type="button" class="crop-tool-btn" data-action="zoom-in" title="Perbesar">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        <line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/>
                    </svg>
                </button>
                <button type="button" class="crop-tool-btn" data-action="zoom-out" title="Perkecil">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        <line x1="8" y1="11" x2="14" y2="11"/>
                    </svg>
                </button>
                <button type="button" class="crop-tool-btn" data-action="reset" title="Reset">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/>
                        <path d="M3 3v5h5"/>
                    </svg>
                </button>
            </div>
            <div class="crop-dialog-actions">
                <button type="button" class="btn-cancel-crop" id="cancelCrop">Batal</button>
                <button type="button" class="btn-apply-crop" id="applyCrop">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Terapkan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
// Configuration
const AUTOSAVE_DELAY = 800;
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content;

// State
let saveTimeout = null;
let currentSection = 1;
let cropper = null;
let originalFile = null;
let profileValidationInProgress = false;

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

function initializeApp() {
    // Setup autosave for profile fields
    setupAutoSave();

    // Setup profile picture upload
    setupProfilePicture();

    // Setup field selection
    setupFieldSelection();

    // Setup date inputs
    setupDateInputs();

    // Setup input validation
    setupInputValidation();

    // Setup navigation
    setupNavigation();

    // Setup submit confirmation
    setupSubmitConfirmation();

    // Calculate initial progress
    updateProgress();

    // Mark filled fields
    markFilledFields();

    // Auto-hide flash messages
    setTimeout(() => {
        const flash = document.getElementById('flashToast');
        if (flash) {
            flash.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => flash.remove(), 300);
        }
    }, 5000);
}

// Auto-save for profile fields
function setupAutoSave() {
    const profileFields = document.querySelectorAll('input[data-field="profile"]');

    profileFields.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => saveProfileData(), AUTOSAVE_DELAY);
            updateFieldStatus(this);
        });

        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                clearTimeout(saveTimeout);
                saveProfileData();
            }
        });
    });
}

function buildProfileFormData() {
    const formData = new FormData();
    formData.append('_token', CSRF_TOKEN);

    const fields = ['name', 'nim', 'university', 'major', 'phone', 'ktp_number'];
    fields.forEach(field => {
        const input = document.getElementById(field);
        if (input) formData.append(field, input.value);
    });

    return formData;
}

function saveProfileData() {
    const formData = buildProfileFormData();

    showSaveIndicator('saving');

    fetch('{{ route("dashboard.pre-acceptance.profile") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json().catch(() => ({ success: true })))
    .then(data => {
        if (data && data.success === false) {
            showSaveIndicator('error');
            showToast(data.message || 'Gagal menyimpan data profil.', 'error');
            return;
        }
        showSaveIndicator('saved');
        updateProgress();
    })
    .catch(error => {
        showSaveIndicator('error');
        console.error('Save error:', error);
    });
}

// ===== PROFILE PICTURE =====
function setupProfilePicture() {
    const input = document.getElementById('profilePictureInput');
    const removeBtn = document.getElementById('removeProfilePicture');
    const cropperModal = document.getElementById('cropperModal');
    const closeCropperBtn = document.getElementById('closeCropperModal');
    const cancelCropBtn = document.getElementById('cancelCrop');
    const applyCropBtn = document.getElementById('applyCrop');

    if (input) {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];

                if (file.size > 2 * 1024 * 1024) {
                    showToast('Ukuran file maksimal 2MB', 'error');
                    this.value = '';
                    return;
                }

                if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                    showToast('Format file harus JPG, JPEG, atau PNG', 'error');
                    this.value = '';
                    return;
                }

                originalFile = file;
                openCropperModal(file);
            }
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', removeProfilePicture);
    }

    if (closeCropperBtn) closeCropperBtn.addEventListener('click', closeCropperModal);
    if (cancelCropBtn) cancelCropBtn.addEventListener('click', closeCropperModal);
    if (applyCropBtn) applyCropBtn.addEventListener('click', applyCroppedImage);

    if (cropperModal) {
        cropperModal.addEventListener('click', function(e) {
            if (e.target === cropperModal) closeCropperModal();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && cropperModal && cropperModal.classList.contains('show')) {
            closeCropperModal();
        }
    });

    document.querySelectorAll('.crop-tool-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!cropper) return;
            const action = this.dataset.action;
            switch (action) {
                case 'rotate-left': cropper.rotate(-90); break;
                case 'rotate-right': cropper.rotate(90); break;
                case 'zoom-in': cropper.zoom(0.1); break;
                case 'zoom-out': cropper.zoom(-0.1); break;
                case 'reset': cropper.reset(); break;
            }
        });
    });
}

function openCropperModal(file) {
    const cropperModal = document.getElementById('cropperModal');
    const cropperImage = document.getElementById('cropperImage');

    const reader = new FileReader();
    reader.onload = function(e) {
        cropperImage.src = e.target.result;
        cropperModal.classList.add('show');
        document.body.style.overflow = 'hidden';

        cropperImage.onload = function() {
            if (cropper) cropper.destroy();
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.85,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                background: false,
                preview: '#cropperPreview',
            });
        };
    };
    reader.readAsDataURL(file);
}

function closeCropperModal() {
    const cropperModal = document.getElementById('cropperModal');
    const input = document.getElementById('profilePictureInput');

    cropperModal.classList.remove('show');
    document.body.style.overflow = '';

    if (input) input.value = '';
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
}

function applyCroppedImage() {
    if (!cropper) return;

    const applyBtn = document.getElementById('applyCrop');
    const originalText = applyBtn.innerHTML;
    applyBtn.innerHTML = '<svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Memproses...';
    applyBtn.disabled = true;

    const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });

    canvas.toBlob(function(blob) {
        const croppedFile = new File([blob], originalFile.name.replace(/\.[^.]+$/, '.jpg'), {
            type: 'image/jpeg',
            lastModified: Date.now(),
        });

        uploadProfilePicture(croppedFile);
        closeCropperModal();

        applyBtn.innerHTML = originalText;
        applyBtn.disabled = false;
    }, 'image/jpeg', 0.9);
}

function uploadProfilePicture(file) {
    const formData = new FormData();
    formData.append('_token', CSRF_TOKEN);
    formData.append('profile_picture', file);

    showSaveIndicator('saving');

    fetch('{{ route("dashboard.pre-acceptance.profile-picture") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSaveIndicator('saved');
            const preview = document.getElementById('profilePicturePreview');
            const placeholder = document.getElementById('profilePlaceholder');
            let img = document.getElementById('profileImg');

            if (!img) {
                img = document.createElement('img');
                img.id = 'profileImg';
                img.alt = 'Profile Picture';
                preview.appendChild(img);
            }
            img.src = data.path;

            if (placeholder) placeholder.style.display = 'none';

            const uploadLabel = document.querySelector('.btn-upload-photo');
            if (uploadLabel) {
                uploadLabel.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Ganti Foto';
            }

            const actionsContainer = document.querySelector('.profile-picture-actions');
            if (actionsContainer && !document.getElementById('removeProfilePicture')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-photo';
                removeBtn.id = 'removeProfilePicture';
                removeBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg> Hapus';
                removeBtn.addEventListener('click', removeProfilePicture);
                actionsContainer.appendChild(removeBtn);
            }

            showToast('Foto profil berhasil diunggah!', 'success');
        } else {
            showSaveIndicator('error');
            showToast(data.message || 'Gagal mengunggah foto profil', 'error');
        }
    })
    .catch(error => {
        showSaveIndicator('error');
        showToast('Gagal mengunggah foto profil', 'error');
        console.error('Upload error:', error);
    });
}

function removeProfilePicture() {
    showSaveIndicator('saving');

    fetch('{{ route("dashboard.pre-acceptance.profile-picture.remove") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSaveIndicator('saved');

            const preview = document.getElementById('profilePicturePreview');
            const img = document.getElementById('profileImg');
            const placeholder = document.getElementById('profilePlaceholder');

            if (img) img.remove();
            if (placeholder) {
                placeholder.style.display = 'flex';
            } else {
                preview.innerHTML = '<div class="profile-picture-placeholder" id="profilePlaceholder"><svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>';
            }

            const uploadLabel = document.querySelector('.btn-upload-photo');
            if (uploadLabel) {
                uploadLabel.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg> Unggah Foto';
            }

            const removeBtn = document.getElementById('removeProfilePicture');
            if (removeBtn) removeBtn.remove();

            const input = document.getElementById('profilePictureInput');
            if (input) input.value = '';

            showToast('Foto profil berhasil dihapus!', 'success');
        } else {
            showSaveIndicator('error');
            showToast(data.message || 'Gagal menghapus foto profil', 'error');
        }
    })
    .catch(error => {
        showSaveIndicator('error');
        showToast('Gagal menghapus foto profil', 'error');
        console.error('Remove error:', error);
    });
}

// ===== FIELD SELECTION =====
function setupFieldSelection() {
    const fieldOptions = document.querySelectorAll('input[data-field="interest"]');

    fieldOptions.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update UI
            document.querySelectorAll('.field-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            if (this.checked) {
                this.closest('.field-option').classList.add('selected');
                document.getElementById('hidden_field_id').value = this.value;

                // Auto-save field selection
                saveFieldSelection(this.value);
            }

            updateProgress();
        });
    });
}

function saveFieldSelection(fieldId) {
    showSaveIndicator('saving');

    // Save via the complete form endpoint or a dedicated endpoint
    // For now, we update the hidden field and it will be saved on final submit
    showSaveIndicator('saved');
    updateProgress();
}

// Date inputs
function setupDateInputs() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    if (startDate) {
        startDate.addEventListener('change', function() {
            // Update end_date min value
            if (this.value && endDate) {
                endDate.min = this.value;
            }
            saveDates();
        });
    }

    if (endDate) {
        endDate.addEventListener('change', function() {
            saveDates();
        });
    }
}

function saveDates() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (!startDate || !endDate) {
        updateProgress();
        return;
    }

    showSaveIndicator('saving');

    const formData = new FormData();
    formData.append('_token', CSRF_TOKEN);
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);

    fetch('{{ route("dashboard.pre-acceptance.dates") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => {
        showSaveIndicator('saved');
        updateProgress();
        updateDateInfo();
    })
    .catch(error => {
        showSaveIndicator('error');
        console.error('Save dates error:', error);
    });
}

function updateDateInfo() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const dateInfo = document.getElementById('dateInfo');

    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const months = Math.round((end - start) / (1000 * 60 * 60 * 24 * 30));

        const formatDate = (date) => {
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        };

        dateInfo.innerHTML = `
            <div class="date-info-content">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span>Durasi magang: <strong>${months} bulan</strong> (${formatDate(start)} - ${formatDate(end)})</span>
            </div>
        `;
    }
}

// File upload handler
function handleFileUpload(input, fieldName) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const uploadItem = document.getElementById('upload-' + fieldName);
    const statusEl = document.getElementById(fieldName + '-status');

    // Validate file size
    if (file.size > 2 * 1024 * 1024) {
        showToast('File terlalu besar. Maksimal 2MB.', 'error');
        input.value = '';
        return;
    }

    // Show uploading state
    uploadItem.classList.add('uploading');
    statusEl.innerHTML = '<span class="status-uploading">Mengunggah...</span>';

    const formData = new FormData();
    formData.append('file', file);
    formData.append('field_name', fieldName);
    formData.append('_token', CSRF_TOKEN);

    fetch('{{ route("dashboard.pre-acceptance.documents") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        uploadItem.classList.remove('uploading');

        if (data.success) {
            uploadItem.classList.add('completed');
            statusEl.innerHTML = `<span class="status-uploaded">${file.name}</span>`;

            // Update button text
            const btnLabel = uploadItem.querySelector('.btn-upload span');
            if (btnLabel) btnLabel.textContent = 'Ganti';

            showToast('File berhasil diunggah!', 'success');
            updateProgress();
        } else {
            throw new Error(data.message || 'Upload gagal');
        }
    })
    .catch(error => {
        uploadItem.classList.remove('uploading');
        statusEl.innerHTML = '<span class="status-error">Gagal upload</span>';
        showToast(error.message || 'Gagal mengunggah file', 'error');
        input.value = '';
    });
}

// Input validation
function setupInputValidation() {
    const nikInput = document.getElementById('ktp_number');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
        });
    }

    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }
}

// Navigation
function setupNavigation() {
    const navPills = document.querySelectorAll('.nav-pill');

    navPills.forEach(pill => {
        pill.addEventListener('click', function() {
            const section = parseInt(this.dataset.section);
            goToSection(section);
        });
    });
}

function goToSection(sectionNumber) {
    // Jika ingin pindah ke langkah > 1, pastikan NIM valid dan tidak duplikat
    if (sectionNumber > 1) {
        validateProfileBeforeNavigation(sectionNumber);
        return;
    }

    setActiveSection(sectionNumber);
}

function setActiveSection(sectionNumber) {
    currentSection = sectionNumber;

    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    const targetSection = document.getElementById('section' + sectionNumber);
    if (targetSection) {
        targetSection.classList.add('active');
    }

    document.querySelectorAll('.nav-pill').forEach(pill => {
        pill.classList.remove('active');
    });
    const targetPill = document.getElementById('navPill' + sectionNumber);
    if (targetPill) {
        targetPill.classList.add('active');
    }

    window.scrollTo({ top: 200, behavior: 'smooth' });
}

function validateProfileBeforeNavigation(targetSection) {
    if (profileValidationInProgress) return;

    const nimInput = document.getElementById('nim');
    if (!nimInput || !nimInput.value.trim()) {
        showToast('NIM wajib diisi terlebih dahulu sebelum lanjut ke Bidang Minat.', 'error');
        if (nimInput) nimInput.focus();
        return;
    }

    const formData = buildProfileFormData();

    profileValidationInProgress = true;
    showSaveIndicator('saving');

    fetch('{{ route("dashboard.pre-acceptance.profile") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json().catch(() => ({ success: true })))
    .then(data => {
        profileValidationInProgress = false;

        if (data && data.success === false) {
            showSaveIndicator('error');
            showToast(data.message || 'NIM yang dimasukkan sudah digunakan.', 'error');
            nimInput.focus();
            return;
        }

        showSaveIndicator('saved');
        updateProgress();
        setActiveSection(targetSection);
    })
    .catch(error => {
        profileValidationInProgress = false;
        showSaveIndicator('error');
        console.error('Profile validation error:', error);
        showToast('Gagal memvalidasi data profil. Silakan coba lagi.', 'error');
    });
}

// Progress tracking
function updateProgress() {
    const profileFields = ['name', 'nim', 'university', 'major', 'phone', 'ktp_number'];
    const documents = ['ktm', 'surat_permohonan', 'cv', 'good_behavior'];

    let completed = 0;
    const total = 13; // 6 profile + 1 field + 4 docs + 2 dates

    // Count profile fields
    let profileComplete = 0;
    profileFields.forEach(field => {
        const input = document.getElementById(field);
        if (input && input.value.trim()) {
            completed++;
            profileComplete++;
        }
    });

    // Count field selection
    const fieldSelected = document.querySelector('input[data-field="interest"]:checked');
    if (fieldSelected) completed++;

    // Count documents
    let docsComplete = 0;
    documents.forEach(doc => {
        const uploadItem = document.getElementById('upload-' + doc);
        if (uploadItem && uploadItem.classList.contains('completed')) {
            completed++;
            docsComplete++;
        }
    });

    // Count dates
    let datesComplete = 0;
    if (document.getElementById('start_date')?.value) {
        completed++;
        datesComplete++;
    }
    if (document.getElementById('end_date')?.value) {
        completed++;
        datesComplete++;
    }

    // Calculate percentage
    const percent = Math.round((completed / total) * 100);

    // Update progress circle
    document.getElementById('progressPercent').textContent = percent;
    const circle = document.getElementById('progressCircleFill');
    const progressCircle = document.getElementById('progressCircle');
    const circumference = 2 * Math.PI * 45;
    const offset = circumference - (percent / 100) * circumference;
    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = offset;

    // Update progress color
    updateProgressColor(percent);

    // Update section statuses
    updateSectionStatus(1, profileComplete === 6);
    updateSectionStatus(2, fieldSelected !== null);
    updateSectionStatus(3, docsComplete === 4);
    updateSectionStatus(4, datesComplete === 2);

    // Update submit button and section state
    const submitBtn = document.getElementById('submitBtn');
    const submitSection = document.getElementById('submitSection');
    if (percent === 100) {
        submitBtn.disabled = false;
        submitBtn.classList.add('ready');
        submitSection.classList.add('complete');
        // Trigger celebration animation once
        if (!progressCircle.classList.contains('celebrated')) {
            progressCircle.classList.add('celebrated', 'celebrate');
            createSubmitParticles();
            setTimeout(() => progressCircle.classList.remove('celebrate'), 1000);
        }
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('ready');
        submitSection.classList.remove('complete');
        progressCircle.classList.remove('celebrated');
        clearSubmitParticles();
    }
}

function updateProgressColor(percent) {
    const progressCircle = document.getElementById('progressCircle');
    progressCircle.classList.remove('progress-low', 'progress-medium', 'progress-high', 'progress-complete');

    if (percent < 33) progressCircle.classList.add('progress-low');
    else if (percent < 66) progressCircle.classList.add('progress-medium');
    else if (percent < 100) progressCircle.classList.add('progress-high');
    else progressCircle.classList.add('progress-complete');
}

function createSubmitParticles() {
    const container = document.getElementById('submitParticles');
    if (!container) return;
    container.innerHTML = '';
    for (let i = 0; i < 8; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        container.appendChild(particle);
    }
}

function clearSubmitParticles() {
    const container = document.getElementById('submitParticles');
    if (container) container.innerHTML = '';
}

function updateSectionStatus(sectionNum, isComplete) {
    const statusEl = document.getElementById('status' + sectionNum);
    const navPill = document.getElementById('navPill' + sectionNum);

    if (isComplete) {
        statusEl.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>';
        navPill.classList.add('completed');
    } else {
        statusEl.innerHTML = '';
        navPill.classList.remove('completed');
    }
}

function updateFieldStatus(input) {
    const wrapper = input.closest('.field-input-wrap');
    if (wrapper) {
        if (input.value.trim()) {
            wrapper.classList.add('filled');
        } else {
            wrapper.classList.remove('filled');
        }
    }
}

function markFilledFields() {
    document.querySelectorAll('input[data-field="profile"]').forEach(input => {
        updateFieldStatus(input);
    });
}

// Save indicator
function showSaveIndicator(state) {
    const indicator = document.getElementById('saveIndicator');

    indicator.classList.remove('saving', 'saved', 'error');
    indicator.classList.add('show', state);

    if (state === 'saved') {
        setTimeout(() => {
            indicator.classList.remove('show');
        }, 2000);
    }
}

// ===== SUBMIT CONFIRMATION =====
function setupSubmitConfirmation() {
    const form = document.getElementById('completeForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const percent = parseInt(document.getElementById('progressPercent').textContent);
            if (percent < 100) {
                showToast('Mohon lengkapi semua data sebelum mengajukan magang.', 'error');
                return;
            }
            showConfirmDialog(
                'Konfirmasi Pengajuan',
                'Apakah Anda yakin ingin mengajukan magang? Data yang sudah dikirim tidak dapat diubah.',
                () => form.submit()
            );
        });
    }
}

function showConfirmDialog(title, message, onConfirm) {
    const existing = document.querySelector('.confirm-dialog-overlay');
    if (existing) existing.remove();

    const overlay = document.createElement('div');
    overlay.className = 'confirm-dialog-overlay';
    overlay.innerHTML = `
        <div class="confirm-dialog">
            <div class="confirm-dialog-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <h3>${title}</h3>
            <p>${message}</p>
            <div class="confirm-dialog-actions">
                <button type="button" class="btn-cancel" onclick="closeConfirmDialog()">Batal</button>
                <button type="button" class="btn-confirm" id="confirmBtn">Ya, Ajukan</button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);
    requestAnimationFrame(() => overlay.classList.add('show'));

    document.getElementById('confirmBtn').addEventListener('click', () => {
        closeConfirmDialog();
        onConfirm();
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeConfirmDialog();
    });
}

function closeConfirmDialog() {
    const overlay = document.querySelector('.confirm-dialog-overlay');
    if (overlay) {
        overlay.classList.remove('show');
        setTimeout(() => overlay.remove(), 300);
    }
}

// Toast notification
function showToast(message, type) {
    const existing = document.querySelector('.toast-popup');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.className = 'toast-popup toast-' + type;
    toast.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            ${type === 'success'
                ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'
                : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'}
        </svg>
        <span>${message}</span>
    `;
    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
@endpush
