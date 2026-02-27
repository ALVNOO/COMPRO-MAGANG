{{--
    ADMIN DIVISIONS PAGE
    Kelola Divisi untuk program magang
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Kelola Divisi')

@php
    $role = 'admin';
    $pageTitle = 'Kelola Divisi';
    $pageSubtitle = 'Kelola divisi untuk program magang PT Telkom Indonesia';

    // Calculate stats
    $totalDivisions = $divisions->count();
    $activeDivisions = $divisions->where('is_active', true)->count();
    $totalMentors = $divisions->sum(fn($d) => $d->mentors ? $d->mentors->count() : 0);
@endphp

@push('styles')
<style>
/* ============================================
   DIVISIONS ADMIN PAGE STYLES
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

.hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.hero-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; }
.stat-icon.green { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.stat-icon.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }

.stat-content h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1;
}

.stat-content p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

/* Table Card */
.table-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.table-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
}

.table-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-title i {
    color: #EE2E24;
}

/* Divisions Table */
.divisions-table {
    width: 100%;
    border-collapse: collapse;
}

.divisions-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.divisions-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.divisions-table td {
    padding: 1rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.divisions-table tbody tr {
    transition: all 0.2s ease;
}

.divisions-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.divisions-table tbody tr:last-child td {
    border-bottom: none;
}

/* Division Name */
.division-name {
    font-weight: 600;
    color: #1f2937;
}

/* Mentor List */
.mentor-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.mentor-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
}

.mentor-name {
    font-weight: 500;
    color: #374151;
}

.mentor-nik {
    font-family: monospace;
    font-size: 0.75rem;
    color: #9ca3af;
    background: rgba(0, 0, 0, 0.04);
    padding: 2px 6px;
    border-radius: 4px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.status-badge.inactive {
    background: rgba(156, 163, 175, 0.2);
    color: #6b7280;
}

/* Action Buttons */
.action-btns {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.action-btn.edit {
    background: rgba(234, 179, 8, 0.1);
    color: #ca8a04;
}

.action-btn.edit:hover {
    background: rgba(234, 179, 8, 0.2);
}

.action-btn.toggle {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.action-btn.toggle:hover {
    background: rgba(107, 114, 128, 0.2);
}

.action-btn.delete {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.action-btn.delete:hover {
    background: rgba(239, 68, 68, 0.2);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: #6b7280;
    margin: 0;
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: 20px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.95);
    transition: transform 0.3s ease;
}

.modal-overlay.active .modal-container {
    transform: scale(1);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-header h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.modal-header h3 i {
    color: #EE2E24;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: rgba(0, 0, 0, 0.05);
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.25rem;
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

/* Mentors Container */
.mentors-container {
    margin-bottom: 1.25rem;
}

.mentors-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.mentors-header label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.add-mentor-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: none;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.add-mentor-btn:hover {
    background: rgba(34, 197, 94, 0.2);
}

.mentors-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.mentor-field {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
}

.mentor-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 0.75rem;
    align-items: end;
}

.mentor-field-grid .form-group {
    margin-bottom: 0;
}

.mentor-field-grid .form-group label {
    font-size: 0.75rem;
    margin-bottom: 0.375rem;
}

.mentor-field-grid .form-input {
    padding: 0.625rem 0.75rem;
    font-size: 0.85rem;
}

.remove-mentor-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.remove-mentor-btn:hover {
    background: rgba(239, 68, 68, 0.2);
}

/* Checkbox */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: rgba(238, 46, 36, 0.03);
    border-radius: 10px;
}

.form-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #EE2E24;
}

.checkbox-label {
    font-size: 0.9rem;
    color: #374151;
    cursor: pointer;
}

/* Modal Buttons */
.btn-cancel {
    padding: 0.75rem 1.25rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}

.btn-submit {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Toast */
.toast-container {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 2000;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.toast {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.toast.success {
    background: white;
    border-left: 4px solid #22c55e;
    color: #16a34a;
}

.toast.error {
    background: white;
    border-left: 4px solid #ef4444;
    color: #dc2626;
}

/* Error Messages */
.form-error {
    font-size: 0.75rem;
    color: #dc2626;
    margin-top: 0.375rem;
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

    .hero-btn {
        width: 100%;
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .mentor-field-grid {
        grid-template-columns: 1fr;
    }

    .mentor-field-grid .remove-mentor-btn {
        width: 100%;
        height: auto;
        padding: 0.5rem;
    }

    .action-btns {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
@php
    $initialMentors = old('mentors') ?? [['id' => null, 'mentor_name' => '', 'nik_number' => '']];
@endphp
<div x-data="divisionsManager()"
     data-initial-show-modal="{{ $errors->any() ? 'true' : 'false' }}"
     data-initial-form-mode="{{ old('form_mode', 'create') }}"
     data-initial-division-id="{{ old('division_id') }}"
     data-initial-division-name="{{ old('division_name') }}"
     data-initial-is-active="{{ old('is_active', 1) ? 'true' : 'false' }}"
     data-initial-mentors='@json($initialMentors)'>
    {{-- Hero Section --}}
    <div class="admin-hero">
        <div class="hero-content">  
            <div class="hero-text">
                <h1><i class="fas fa-sitemap"></i> Kelola Divisi</h1>
                <p>Kelola divisi dan pembimbing untuk program magang PT Telkom Indonesia</p>
            </div>
            <button class="hero-btn" @click="openModal('create')">
                <i class="fas fa-plus"></i> Tambah Divisi
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalDivisions }}</h3>
                <p>Total Divisi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $activeDivisions }}</h3>
                <p>Divisi Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalMentors }}</h3>
                <p>Total Mentor</p>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-table"></i> Data Divisi
            </div>
        </div>

        @if($divisions->count() > 0)
        <div class="overflow-x-auto">
            <table class="divisions-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Divisi</th>
                        <th>Mentor</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($divisions as $index => $division)
                    <tr>
                        <td><strong>{{ $index + 1 }}</strong></td>
                        <td>
                            <span class="division-name">{{ $division->division_name }}</span>
                        </td>
                        <td>
                            @if($division->mentors && $division->mentors->count() > 0)
                            <div class="mentor-list">
                                @foreach($division->mentors as $mentor)
                                <div class="mentor-item">
                                    <span class="mentor-name">{{ $mentor->mentor_name }}</span>
                                    <span class="mentor-nik">{{ $mentor->nik_number }}</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($division->is_active)
                            <span class="status-badge active">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                            @else
                            <span class="status-badge inactive">
                                <i class="fas fa-times-circle"></i> Nonaktif
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                @php
                                    $divisionPayload = [
                                        'id' => $division->id,
                                        'division_name' => $division->division_name,
                                        'is_active' => (bool) $division->is_active,
                                        'mentors' => $division->mentors
                                            ? $division->mentors->map(function ($m) {
                                                return [
                                                    'id' => $m->id,
                                                    'mentor_name' => $m->mentor_name,
                                                    'nik_number' => $m->nik_number,
                                                ];
                                            })->values()->toArray()
                                            : [],
                                    ];
                                @endphp
                                <button class="action-btn edit" @click='openEditModal(@json($divisionPayload))'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.divisions.toggle', $division) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="action-btn toggle">
                                        <i class="fas {{ $division->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        {{ $division->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST" style="display: inline;"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-sitemap"></i>
            <h4>Belum Ada Divisi</h4>
            <p>Tambahkan divisi pertama untuk memulai</p>
        </div>
        @endif
    </div>

    {{-- Modal Create/Edit --}}
    <div class="modal-overlay" :class="{ 'active': showModal }" @click.self="closeModal()">
        <div class="modal-container" @click.stop>
            <div class="modal-header">
                <h3>
                    <i class="fas fa-sitemap"></i>
                    <span x-text="modalMode === 'create' ? 'Tambah Divisi Baru' : 'Edit Divisi'"></span>
                </h3>
                <button class="modal-close" @click="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form :action="formAction" method="POST" @submit="handleSubmit">
                @csrf
                <input type="hidden" name="_method" x-bind:value="modalMode === 'edit' ? 'PUT' : 'POST'">
                <input type="hidden" name="form_mode" x-model="modalMode">
                <input type="hidden" name="division_id" x-model="selectedDivisionId">

                <div class="modal-body">
                    {{-- Division Name --}}
                    <div class="form-group">
                        <label>Nama Divisi <span class="required">*</span></label>
                        <input type="text" name="division_name" class="form-input"
                               x-model="formData.division_name"
                               placeholder="Contoh: IT & Digital" required>
                        @error('division_name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mentors --}}
                    <div class="mentors-container">
                        <div class="mentors-header">
                            <label>Mentor <span class="required">*</span></label>
                            <button type="button" class="add-mentor-btn" @click="addMentor()">
                                <i class="fas fa-plus"></i> Tambah Mentor
                            </button>
                        </div>
                        <div class="mentors-list">
                            <template x-for="(mentor, index) in formData.mentors" :key="index">
                                <div class="mentor-field">
                                    <input type="hidden" :name="'mentors[' + index + '][id]'" x-model="mentor.id">
                                    <div class="mentor-field-grid">
                                        <div class="form-group">
                                            <label>Nama Mentor <span class="required">*</span></label>
                                            <input type="text" :name="'mentors[' + index + '][mentor_name]'"
                                                   class="form-input" x-model="mentor.mentor_name"
                                                   placeholder="Nama lengkap" required>
                                        </div>
                                        <div class="form-group">
                                            <label>NIK <span class="required">*</span></label>
                                            <input type="text" :name="'mentors[' + index + '][nik_number]'"
                                                   class="form-input" x-model="mentor.nik_number"
                                                   placeholder="6 digit NIK" maxlength="6" pattern="[0-9]{6}" required>
                                        </div>
                                        <button type="button" class="remove-mentor-btn"
                                                @click="removeMentor(index)"
                                                x-show="formData.mentors.length > 1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @error('mentors')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Is Active --}}
                    <div class="checkbox-group">
                        <input type="checkbox" class="form-checkbox" id="is_active" name="is_active" value="1"
                               x-model="formData.is_active">
                        <label for="is_active" class="checkbox-label">Aktifkan Divisi</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" @click="closeModal()">Batal</button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        <span x-text="modalMode === 'create' ? 'Simpan' : 'Update'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast Notifications --}}
    <div class="toast-container">
        @if(session('success'))
        <div class="toast success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="toast error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
function divisionsManager() {
    const rootEl = document.querySelector('[x-data="divisionsManager()"]');
    const dataset = rootEl ? rootEl.dataset : {};

    let mentors = [];
    if (dataset.initialMentors) {
        try {
            mentors = JSON.parse(dataset.initialMentors);
        } catch (e) {
            mentors = [];
        }
    }
    if (!Array.isArray(mentors) || mentors.length === 0) {
        mentors = [{ id: null, mentor_name: '', nik_number: '' }];
    }

    return {
        showModal: dataset.initialShowModal === 'true',
        modalMode: dataset.initialFormMode || 'create',
        selectedDivisionId: dataset.initialDivisionId ? Number(dataset.initialDivisionId) : null,
        formData: {
            division_name: dataset.initialDivisionName || '',
            is_active: dataset.initialIsActive === 'true',
            mentors: mentors
        },

        get formAction() {
            if (this.modalMode === 'create') {
                return '{{ route("admin.divisions.store") }}';
            }
            return '/admin/divisions/' + this.selectedDivisionId;
        },

        openModal(mode) {
            this.modalMode = mode;
            this.showModal = true;
            if (mode === 'create') {
                this.resetForm();
            }
        },

        openEditModal(division) {
            this.modalMode = 'edit';
            this.selectedDivisionId = division.id;
            this.formData = {
                division_name: division.division_name,
                is_active: division.is_active,
                mentors: division.mentors.length > 0
                    ? division.mentors.map(m => ({ id: m.id, mentor_name: m.mentor_name, nik_number: m.nik_number }))
                    : [{ id: null, mentor_name: '', nik_number: '' }]
            };
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
            this.resetForm();
        },

        resetForm() {
            this.selectedDivisionId = null;
            this.formData = {
                division_name: '',
                is_active: true,
                mentors: [{ id: null, mentor_name: '', nik_number: '' }]
            };
        },

        addMentor() {
            this.formData.mentors.push({ id: null, mentor_name: '', nik_number: '' });
        },

        removeMentor(index) {
            if (this.formData.mentors.length > 1) {
                this.formData.mentors.splice(index, 1);
            }
        },

        handleSubmit(e) {
            // Form will submit normally
            return true;
        }
    }
}
</script>
@endpush
