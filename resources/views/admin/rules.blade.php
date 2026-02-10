{{--
    ADMIN RULES PAGE
    Edit Peraturan Magang
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Edit Peraturan')

@php
    $role = 'admin';
    $pageTitle = 'Edit Peraturan';
    $pageSubtitle = 'Kelola peraturan dan ketentuan program magang';
@endphp

@push('styles')
<style>
/* ============================================
   RULES PAGE STYLES
   ============================================ */

/* Hero Section */
.admin-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.admin-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hero-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 500px;
    margin: 0;
}

/* Alert Styles */
.alert-success {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    color: #16a34a;
    font-weight: 500;
}

.alert-success i {
    font-size: 1.25rem;
}

/* Form Card */
.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.form-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
}

.form-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.form-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.form-body {
    padding: 2rem;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
}

.form-textarea {
    width: 100%;
    padding: 1rem 1.25rem;
    font-size: 0.95rem;
    line-height: 1.7;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: white;
    color: #1f2937;
    transition: all 0.2s ease;
    resize: vertical;
    min-height: 400px;
    font-family: inherit;
}

.form-textarea:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-error {
    font-size: 0.875rem;
    color: #dc2626;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-hint {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-hint i {
    color: #9ca3af;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 32px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Tips Card */
.tips-card {
    background: rgba(238, 46, 36, 0.03);
    border: 1px solid rgba(238, 46, 36, 0.1);
    border-radius: 16px;
    padding: 1.5rem;
    margin-top: 1.5rem;
}

.tips-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.tips-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.tips-header h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.tips-list li:last-child {
    margin-bottom: 0;
}

.tips-list li::before {
    content: '•';
    color: #EE2E24;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-hero {
        padding: 1.5rem;
    }

    .form-body {
        padding: 1.5rem;
    }

    .form-textarea {
        min-height: 300px;
    }

    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-gavel"></i> Edit Peraturan</h1>
            <p>Kelola peraturan dan ketentuan yang berlaku untuk peserta program magang</p>
        </div>
    </div>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

{{-- Form Card --}}
<div class="form-card">
    <div class="form-header">
        <i class="fas fa-edit"></i>
        <h3>Isi Peraturan Magang</h3>
    </div>
    <div class="form-body">
        <form method="POST" action="{{ route('admin.rules.update') }}">
            @csrf

            <div class="form-group">
                <label for="content">Isi Peraturan</label>
                <textarea name="content" id="content" class="form-textarea" rows="15"
                          placeholder="Tuliskan peraturan dan ketentuan program magang di sini..."
                          required>{{ old('content', $rule ? $rule->content : '') }}</textarea>
                @error('content')
                    <div class="form-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="form-hint">
                    <i class="fas fa-info-circle"></i>
                    Peraturan ini akan ditampilkan kepada peserta magang di halaman dashboard mereka
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="tips-card">
                <div class="tips-header">
                    <i class="fas fa-lightbulb"></i>
                    <h4>Tips Penulisan Peraturan</h4>
                </div>
                <ul class="tips-list">
                    <li>Gunakan nomor atau bullet point untuk daftar peraturan</li>
                    <li>Jelaskan dengan bahasa yang jelas dan mudah dipahami</li>
                    <li>Sertakan konsekuensi jika peraturan dilanggar</li>
                    <li>Perbarui peraturan secara berkala jika ada perubahan</li>
                </ul>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan Peraturan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
