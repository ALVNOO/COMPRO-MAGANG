{{--
    ADMIN FIELD FORM PAGE
    Create/Edit Bidang Peminatan
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan')

@php
    $role = 'admin';
    $pageTitle = isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan';
    $pageSubtitle = isset($field) ? 'Perbarui informasi bidang peminatan' : 'Tambah bidang peminatan baru';
@endphp

@push('styles')
<style>
/* ============================================
   FIELD FORM PAGE STYLES
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
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
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

/* Back Button */
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    color: white;
    font-weight: 500;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.back-btn:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    color: white;
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

/* Alert Styles */
.alert-error {
    padding: 1rem 1.25rem;
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.alert-error ul {
    margin: 0;
    padding-left: 1.25rem;
    color: #dc2626;
}

.alert-error li {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 0;
}

.form-group.full-width {
    grid-column: span 2;
}

.form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-group label .required {
    color: #EE2E24;
    margin-left: 2px;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    color: #1f2937;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    color: #1f2937;
    transition: all 0.2s ease;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1.25rem;
    padding-right: 2.5rem;
}

.form-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    background: white;
    color: #1f2937;
    transition: all 0.2s ease;
    resize: vertical;
    min-height: 120px;
}

.form-textarea:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-hint {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

/* Color Input */
.color-input-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.form-color {
    width: 60px;
    height: 44px;
    padding: 4px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
    background: white;
}

.form-color:focus {
    outline: none;
    border-color: #EE2E24;
}

.color-preview {
    flex: 1;
    height: 44px;
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
}

/* Icon Preview */
.icon-preview-box {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(238, 46, 36, 0.05);
    border-radius: 12px;
    margin-top: 0.75rem;
}

.icon-preview-box i {
    font-size: 2rem;
}

.icon-preview-text {
    font-size: 0.875rem;
    color: #6b7280;
}

/* Checkbox */
.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(238, 46, 36, 0.03);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.form-checkbox {
    width: 20px;
    height: 20px;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    cursor: pointer;
    accent-color: #EE2E24;
}

.checkbox-label {
    font-size: 0.9rem;
    color: #374151;
    cursor: pointer;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.btn-cancel {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #374151;
}

.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .admin-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .back-btn {
        width: 100%;
        justify-content: center;
    }

    .form-grid,
    .form-grid-3 {
        grid-template-columns: 1fr;
    }

    .form-group.full-width {
        grid-column: span 1;
    }

    .form-body {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-cancel, .btn-submit {
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
            <h1>
                <i class="fas fa-tags"></i>
                {{ isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan' }}
            </h1>
            <p>{{ isset($field) ? 'Perbarui informasi bidang peminatan yang sudah ada' : 'Tambahkan bidang peminatan baru untuk program magang' }}</p>
        </div>
        <a href="{{ route('admin.fields') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- Form Card --}}
<div class="form-card">
    <div class="form-header">
        <i class="fas fa-edit"></i>
        <h3>{{ isset($field) ? 'Form Edit' : 'Form Tambah' }} Bidang Peminatan</h3>
    </div>
    <div class="form-body">
        {{-- Error Messages --}}
        @if($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($field) ? route('admin.fields.update', $field) : route('admin.fields.store') }}" method="POST">
            @csrf
            @if(isset($field))
                @method('PUT')
            @endif

            {{-- Row 1: Nama & Icon --}}
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nama Bidang <span class="required">*</span></label>
                    <input type="text" class="form-input" id="name" name="name"
                           value="{{ old('name', $field->name ?? '') }}"
                           placeholder="Masukkan nama bidang peminatan"
                           required>
                </div>
                <div class="form-group">
                    <label for="icon">Icon <span class="required">*</span></label>
                    <select class="form-select" id="icon" name="icon" required>
                        <option value="">Pilih Icon</option>
                        <option value="fas fa-building" {{ old('icon', $field->icon ?? '') == 'fas fa-building' ? 'selected' : '' }}>Building (Administration)</option>
                        <option value="fas fa-calculator" {{ old('icon', $field->icon ?? '') == 'fas fa-calculator' ? 'selected' : '' }}>Calculator (Finance)</option>
                        <option value="fas fa-user-tie" {{ old('icon', $field->icon ?? '') == 'fas fa-user-tie' ? 'selected' : '' }}>User Tie (Human Capital)</option>
                        <option value="fas fa-chart-line" {{ old('icon', $field->icon ?? '') == 'fas fa-chart-line' ? 'selected' : '' }}>Chart Line (Digital Business)</option>
                        <option value="fas fa-bullhorn" {{ old('icon', $field->icon ?? '') == 'fas fa-bullhorn' ? 'selected' : '' }}>Bullhorn (Marketing)</option>
                        <option value="fas fa-headset" {{ old('icon', $field->icon ?? '') == 'fas fa-headset' ? 'selected' : '' }}>Headset (Customer Service)</option>
                        <option value="fas fa-gavel" {{ old('icon', $field->icon ?? '') == 'fas fa-gavel' ? 'selected' : '' }}>Gavel (Legal)</option>
                        <option value="fas fa-laptop-code" {{ old('icon', $field->icon ?? '') == 'fas fa-laptop-code' ? 'selected' : '' }}>Laptop Code (IT)</option>
                        <option value="fas fa-palette" {{ old('icon', $field->icon ?? '') == 'fas fa-palette' ? 'selected' : '' }}>Palette (Design)</option>
                        <option value="fas fa-chart-bar" {{ old('icon', $field->icon ?? '') == 'fas fa-chart-bar' ? 'selected' : '' }}>Chart Bar (Analytics)</option>
                        <option value="fas fa-broadcast-tower" {{ old('icon', $field->icon ?? '') == 'fas fa-broadcast-tower' ? 'selected' : '' }}>Broadcast Tower (Telecom)</option>
                        <option value="fas fa-folder-open" {{ old('icon', $field->icon ?? '') == 'fas fa-folder-open' ? 'selected' : '' }}>Folder (Collection)</option>
                        <option value="fas fa-cubes" {{ old('icon', $field->icon ?? '') == 'fas fa-cubes' ? 'selected' : '' }}>Cubes (Asset)</option>
                        <option value="fas fa-hands-helping" {{ old('icon', $field->icon ?? '') == 'fas fa-hands-helping' ? 'selected' : '' }}>Hands Helping (CSR)</option>
                        <option value="fas fa-database" {{ old('icon', $field->icon ?? '') == 'fas fa-database' ? 'selected' : '' }}>Database</option>
                        <option value="fas fa-network-wired" {{ old('icon', $field->icon ?? '') == 'fas fa-network-wired' ? 'selected' : '' }}>Network Wired</option>
                        <option value="fas fa-shield-alt" {{ old('icon', $field->icon ?? '') == 'fas fa-shield-alt' ? 'selected' : '' }}>Shield (Security)</option>
                        <option value="fas fa-project-diagram" {{ old('icon', $field->icon ?? '') == 'fas fa-project-diagram' ? 'selected' : '' }}>Project Diagram</option>
                        <option value="fas fa-cloud" {{ old('icon', $field->icon ?? '') == 'fas fa-cloud' ? 'selected' : '' }}>Cloud</option>
                    </select>
                    <p class="form-hint">Pilih icon yang sesuai dengan bidang peminatan</p>
                    <div id="icon-preview" class="icon-preview-box" style="display: none;">
                        <i id="preview-icon"></i>
                        <span class="icon-preview-text">Preview Icon</span>
                    </div>
                </div>
            </div>

            {{-- Row 2: Color & Sort Order --}}
            <div class="form-grid">
                <div class="form-group">
                    <label for="color">Warna</label>
                    <div class="color-input-wrapper">
                        <input type="color" class="form-color" id="color" name="color"
                               value="{{ old('color', $field->color ?? '#EE2E24') }}">
                        <div class="color-preview" id="color-preview-text">
                            {{ old('color', $field->color ?? '#EE2E24') }}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sort_order">Urutan Tampil <span class="required">*</span></label>
                    <input type="number" class="form-input" id="sort_order" name="sort_order"
                           value="{{ old('sort_order', $field->sort_order ?? 0) }}"
                           min="0" required>
                </div>
            </div>

            {{-- Row 3: Description --}}
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="description">Deskripsi <span class="required">*</span></label>
                <textarea class="form-textarea" id="description" name="description" rows="4"
                          placeholder="Tuliskan deskripsi bidang peminatan"
                          required>{{ old('description', $field->description ?? '') }}</textarea>
            </div>

            {{-- Row 4: Division, Position, Duration --}}
            <div class="form-grid-3">
                <div class="form-group">
                    <label for="division_count">Jumlah Divisi <span class="required">*</span></label>
                    <input type="number" class="form-input" id="division_count" name="division_count"
                           value="{{ old('division_count', $field->division_count ?? 0) }}"
                           min="0" required>
                </div>
                <div class="form-group">
                    <label for="position_count">Jumlah Posisi <span class="required">*</span></label>
                    <input type="number" class="form-input" id="position_count" name="position_count"
                           value="{{ old('position_count', $field->position_count ?? 0) }}"
                           min="0" required>
                </div>
                <div class="form-group">
                    <label for="duration_months">Durasi (Bulan) <span class="required">*</span></label>
                    <input type="number" class="form-input" id="duration_months" name="duration_months"
                           value="{{ old('duration_months', $field->duration_months ?? 6) }}"
                           min="1" required>
                </div>
            </div>

            {{-- Checkbox Active --}}
            <div class="checkbox-wrapper">
                <input type="checkbox" class="form-checkbox" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $field->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="checkbox-label">
                    <strong>Aktif</strong> - Bidang peminatan ini dapat diakses dan ditampilkan
                </label>
            </div>

            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.fields') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> {{ isset($field) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Preview icon function
function updateIconPreview() {
    const iconValue = document.getElementById('icon').value;
    const previewBox = document.getElementById('icon-preview');
    const previewIcon = document.getElementById('preview-icon');
    const color = document.getElementById('color').value;

    if (iconValue) {
        previewIcon.className = iconValue;
        previewIcon.style.color = color;
        previewBox.style.display = 'flex';
    } else {
        previewBox.style.display = 'none';
    }
}

// Update color preview text
function updateColorPreview() {
    const color = document.getElementById('color').value;
    const colorPreviewText = document.getElementById('color-preview-text');
    colorPreviewText.textContent = color.toUpperCase();
    colorPreviewText.style.background = color;
    colorPreviewText.style.color = isLightColor(color) ? '#1f2937' : '#ffffff';

    // Also update icon preview color
    const previewIcon = document.getElementById('preview-icon');
    if (previewIcon) {
        previewIcon.style.color = color;
    }
}

// Check if color is light
function isLightColor(color) {
    const hex = color.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    const brightness = ((r * 299) + (g * 587) + (b * 114)) / 1000;
    return brightness > 155;
}

// Event listeners
document.getElementById('icon').addEventListener('change', updateIconPreview);
document.getElementById('color').addEventListener('input', updateColorPreview);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateIconPreview();
    updateColorPreview();
});
</script>
@endpush
