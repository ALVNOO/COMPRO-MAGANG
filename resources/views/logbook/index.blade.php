{{--
    USER LOGBOOK PAGE
    Daily activity logging for internship participants
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Logbook Magang')

@php
    $role = 'participant';
    $pageTitle = 'Logbook';

    $totalLogbooks = $logbooks->count();
    $thisMonthCount = $logbooks->filter(fn($l) => $l->date->month === now()->month && $l->date->year === now()->year)->count();
    $todayExists = $logbooks->contains(fn($l) => $l->date->isToday());
@endphp

@push('styles')
<style>
/* ============================================
   LOGBOOK PAGE STYLES
   ============================================ */

/* Hero Section */
.page-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.page-hero::before {
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

.btn-hero-add {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 12px;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}

.btn-hero-add:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
    color: white;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.stat-icon.red { background: linear-gradient(135deg, #EE2E24, #C41E1A); color: white; }
.stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
.stat-icon.green { background: linear-gradient(135deg, #22c55e, #16a34a); color: white; }
.stat-icon.amber { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

.stat-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
    line-height: 1.2;
}

.stat-info p {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
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

.table-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.table-card-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.table-card-header .badge-count {
    background: rgba(238, 46, 36, 0.1);
    color: #EE2E24;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}

.logbook-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.logbook-table thead th {
    background: #f9fafb;
    padding: 0.875rem 1.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.logbook-table tbody td {
    padding: 1rem 1.5rem;
    font-size: 0.9rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.logbook-table tbody tr {
    transition: background-color 0.2s;
}

.logbook-table tbody tr:hover {
    background-color: rgba(238, 46, 36, 0.03);
}

.logbook-table tbody tr:last-child td {
    border-bottom: none;
}

.logbook-content-cell {
    white-space: pre-wrap;
    word-wrap: break-word;
    max-width: 500px;
    line-height: 1.6;
}

.logbook-date {
    font-weight: 600;
    color: #1f2937;
    white-space: nowrap;
}

/* Action Buttons */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.85rem;
}

.btn-action.edit {
    background: rgba(245, 158, 11, 0.12);
    color: #d97706;
}

.btn-action.edit:hover {
    background: rgba(245, 158, 11, 0.25);
    transform: translateY(-2px);
}

.btn-action.delete {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
}

.btn-action.delete:hover {
    background: rgba(239, 68, 68, 0.25);
    transform: translateY(-2px);
}

/* Editing Row State */
.logbook-table tbody tr.editing {
    background: rgba(238, 46, 36, 0.05);
}

.logbook-table tbody tr.editing td {
    padding: 1.25rem 1.5rem;
}

/* Add New Section */
.add-new-section {
    padding: 2rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    background: rgba(249, 250, 251, 0.5);
    transition: all 0.3s ease;
}

.add-new-section.collapsed {
    padding: 1rem 2rem;
    cursor: pointer;
}

.add-new-section.collapsed:hover {
    background: rgba(238, 46, 36, 0.03);
}

.add-new-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.95rem;
}

.add-new-toggle i {
    color: #10B981;
    font-size: 1.1rem;
}

.add-new-form {
    display: grid;
    gap: 1rem;
    animation: slide-down 0.3s ease-out;
}

@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-row {
    display: grid;
    grid-template-columns: 200px 1fr;
    gap: 1rem;
    align-items: start;
}

.form-group-inline {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group-inline label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 0.5rem;
}

/* New Entry Row */
.new-entry-row td {
    background: rgba(238, 46, 36, 0.03);
}

.new-entry-row input,
.new-entry-row textarea {
    border-radius: 10px;
    border: 1px solid #d1d5db;
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
    transition: border-color 0.2s;
}

.new-entry-row input:focus,
.new-entry-row textarea:focus {
    border-color: #EE2E24;
    outline: none;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.btn-save-entry {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    background: linear-gradient(135deg, #10B981, #059669);
    color: white;
    font-size: 0.85rem;
}

.btn-save-entry:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-cancel-entry {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    background: rgba(107, 114, 128, 0.12);
    color: #6b7280;
    font-size: 0.85rem;
}

.btn-cancel-entry:hover {
    background: rgba(107, 114, 128, 0.25);
    transform: translateY(-2px);
}

.logbook-textarea {
    min-height: 70px;
    resize: vertical;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem;
    color: #9ca3af;
}

.empty-state h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9rem;
    color: #6b7280;
    margin: 0;
}

/* Modal Styling */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
}

.modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-weight: 600;
    color: #1f2937;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    padding: 1rem 1.5rem;
}

.modal-body .form-control {
    border-radius: 12px;
    border: 1px solid #d1d5db;
    padding: 0.75rem 1rem;
}

.modal-body .form-control:focus {
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.modal-body .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.btn-modal-save {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-modal-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.3);
}

.btn-modal-danger {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #EF4444, #DC2626);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-modal-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
}

/* Alpine.js Modal */
.fixed {
    position: fixed;
}

.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}

.z-50 {
    z-index: 50;
}

.overflow-y-auto {
    overflow-y: auto;
}

.flex {
    display: flex;
}

.items-center {
    align-items: center;
}

.justify-center {
    justify-content: center;
}

.min-h-screen {
    min-height: 100vh;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

/* Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.page-hero {
    animation: fade-in 0.4s ease-out;
}

.stat-card {
    animation: fade-in 0.5s ease-out;
}

.stat-card:nth-child(2) {
    animation-delay: 0.1s;
}

.stat-card:nth-child(3) {
    animation-delay: 0.2s;
}

.table-card {
    animation: fade-in 0.6s ease-out;
}

/* Responsive */
@media (max-width: 768px) {
    .page-hero {
        padding: 1.5rem;
    }

    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-text h1 {
        font-size: 1.35rem;
        justify-content: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .logbook-table thead th,
    .logbook-table tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .form-actions button {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="page-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-book-open"></i>
                Logbook Magang
            </h1>
            <p>Catat aktivitas harian magang Anda di PT Telkom Indonesia</p>
        </div>
        <button type="button" class="btn-hero-add" id="btnAddLogbook">
            <i class="fas fa-plus"></i> Tambah Logbook
        </button>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalLogbooks }}</h3>
            <p>Total Logbook</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-calendar-week"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $thisMonthCount }}</h3>
            <p>Bulan Ini</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon {{ $todayExists ? 'green' : 'amber' }}">
            <i class="fas {{ $todayExists ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $todayExists ? 'Sudah' : 'Belum' }}</h3>
            <p>Logbook Hari Ini</p>
        </div>
    </div>
</div>

{{-- Logbook Table --}}
<div class="table-card">
    <div class="table-card-header">
        <h3>
            <i class="fas fa-list" style="color: #EE2E24;"></i>
            Daftar Logbook
        </h3>
        <span class="badge-count">{{ $totalLogbooks }} Entri</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="logbook-table" id="logbookTable">
            <thead>
                <tr>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 65%;">Isi Logbook</th>
                    <th style="width: 20%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="logbookBody">
                @foreach($logbooks as $logbook)
                <tr data-id="{{ $logbook->id }}" class="logbook-row">
                    <td>
                        <span class="logbook-date view-mode">{{ $logbook->date->format('d M Y') }}</span>
                        <input type="date" class="form-control edit-mode" style="display: none;" value="{{ $logbook->date->format('Y-m-d') }}">
                    </td>
                    <td>
                        <div class="logbook-content-cell view-mode">{{ $logbook->content }}</div>
                        <textarea class="form-control logbook-textarea edit-mode" style="display: none;" rows="4">{{ $logbook->content }}</textarea>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <div style="display: inline-flex; gap: 0.5rem;" class="view-mode">
                            <button type="button" class="btn-action edit btn-edit-logbook">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-action delete btn-delete-logbook">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div style="display: none; gap: 0.5rem;" class="edit-mode">
                            <button type="button" class="btn-save-entry btn-save-edit">
                                <i class="fas fa-check"></i>
                            </button>
                            <button type="button" class="btn-cancel-entry btn-cancel-edit">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if($logbooks->count() === 0)
                <tr class="empty-row-placeholder">
                    <td colspan="3">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h4>Belum Ada Logbook</h4>
                            <p>Klik "Tambah Logbook" untuk mulai mencatat aktivitas harian Anda.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Add New Logbook Section --}}
    <div class="add-new-section" id="addNewSection">
        <div class="add-new-toggle" id="addNewToggle">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Logbook Baru</span>
        </div>
        <div class="add-new-form" id="addNewForm" style="display: none;">
            <div class="form-row">
                <div class="form-group-inline">
                    <label for="newDate">
                        <i class="fas fa-calendar" style="color: #EE2E24;"></i> Tanggal
                    </label>
                    <input type="date" class="form-control" id="newDate" required>
                </div>
                <div class="form-group-inline">
                    <label for="newContent">
                        <i class="fas fa-file-alt" style="color: #EE2E24;"></i> Isi Logbook
                    </label>
                    <textarea class="form-control logbook-textarea" id="newContent" rows="4" placeholder="Tulis aktivitas Anda hari ini..." required></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel-entry" id="btnCancelNew">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn-modal-save" id="btnSaveNew">
                    <i class="fas fa-save"></i> Simpan Logbook
                </button>
            </div>
        </div>
    </div>

    @if($logbooks->hasPages())
        <div style="padding: 1.5rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
            {{ $logbooks->links() }}
        </div>
    @endif
</div>

{{-- Delete Confirmation Modal --}}
<div x-data="{ showDeleteModal: false, deleteId: null }"
     @delete-logbook.window="showDeleteModal = true; deleteId = $event.detail.id"
     style="display: none;"
     x-show="showDeleteModal"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div @click.away="showDeleteModal = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             style="background: white; border-radius: 20px; max-width: 500px; width: 100%; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(0, 0, 0, 0.06);">
                <h5 style="font-weight: 600; color: #1f2937; margin: 0;">
                    <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
                    Konfirmasi Hapus
                </h5>
            </div>
            <div style="padding: 1.5rem;">
                <p style="color: #374151; margin: 0;">Apakah Anda yakin ingin menghapus logbook ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div style="padding: 1rem 1.5rem; border-top: 1px solid rgba(0, 0, 0, 0.06); display: flex; gap: 0.75rem; justify-content: flex-end;">
                <button type="button" @click="showDeleteModal = false" style="padding: 0.6rem 1.25rem; background: #6b7280; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                    Batal
                </button>
                <button type="button" @click="confirmDeleteLogbook(deleteId)" class="btn-modal-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddLogbook = document.getElementById('btnAddLogbook');
    const addNewSection = document.getElementById('addNewSection');
    const addNewToggle = document.getElementById('addNewToggle');
    const addNewForm = document.getElementById('addNewForm');
    const newDate = document.getElementById('newDate');
    const newContent = document.getElementById('newContent');
    const btnSaveNew = document.getElementById('btnSaveNew');
    const btnCancelNew = document.getElementById('btnCancelNew');
    let deleteId = null;
    let currentEditRow = null;

    // Toggle add new section
    function showAddForm() {
        addNewSection.classList.remove('collapsed');
        addNewToggle.style.display = 'none';
        addNewForm.style.display = 'grid';
        newDate.value = new Date().toISOString().split('T')[0];
        newContent.value = '';
        newContent.focus();
    }

    function hideAddForm() {
        addNewSection.classList.add('collapsed');
        addNewToggle.style.display = 'flex';
        addNewForm.style.display = 'none';
        newDate.value = '';
        newContent.value = '';
    }

    // Initialize
    addNewSection.classList.add('collapsed');

    btnAddLogbook.addEventListener('click', showAddForm);
    addNewToggle.addEventListener('click', showAddForm);
    btnCancelNew.addEventListener('click', hideAddForm);

    // Save new logbook
    btnSaveNew.addEventListener('click', async function() {
        if (!newDate.value || !newContent.value.trim()) {
            alert('Mohon isi tanggal dan isi logbook.');
            return;
        }

        const originalHtml = btnSaveNew.innerHTML;
        btnSaveNew.disabled = true;
        btnSaveNew.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        try {
            const response = await fetch('{{ route("logbook.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    date: newDate.value,
                    content: newContent.value
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menyimpan logbook.');
                btnSaveNew.disabled = false;
                btnSaveNew.innerHTML = originalHtml;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan logbook.');
            btnSaveNew.disabled = false;
            btnSaveNew.innerHTML = originalHtml;
        }
    });

    // Inline editing
    document.getElementById('logbookBody').addEventListener('click', async function(e) {
        // Edit button clicked
        if (e.target.closest('.btn-edit-logbook')) {
            const row = e.target.closest('tr');

            // Cancel any other editing
            if (currentEditRow && currentEditRow !== row) {
                cancelEdit(currentEditRow);
            }

            currentEditRow = row;
            row.classList.add('editing');

            // Store original values
            const dateInput = row.querySelector('input[type="date"].edit-mode');
            const contentInput = row.querySelector('textarea.edit-mode');

            if (dateInput) {
                dateInput.defaultValue = dateInput.value;
            }
            if (contentInput) {
                contentInput.defaultValue = contentInput.value;
            }

            // Toggle visibility
            row.querySelectorAll('.view-mode').forEach(el => el.style.display = 'none');
            row.querySelectorAll('.edit-mode').forEach(el => el.style.display = el.tagName === 'DIV' ? 'inline-flex' : 'block');

            // Focus on textarea
            const textarea = row.querySelector('textarea.edit-mode');
            if (textarea) {
                textarea.focus();
                textarea.setSelectionRange(textarea.value.length, textarea.value.length);
            }
        }

        // Save edit button clicked
        if (e.target.closest('.btn-save-edit')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            const dateInput = row.querySelector('input[type="date"].edit-mode');
            const contentInput = row.querySelector('textarea.edit-mode');
            const saveBtn = e.target.closest('.btn-save-edit');

            console.log('=== EDIT SAVE CLICKED ===');
            console.log('Row ID:', id);
            console.log('Date input found:', !!dateInput, dateInput ? dateInput.value : 'N/A');
            console.log('Content input found:', !!contentInput, contentInput ? contentInput.value : 'N/A');

            if (!dateInput || !dateInput.value || !contentInput || !contentInput.value.trim()) {
                console.error('Validation failed: missing date or content');
                alert('Mohon isi tanggal dan isi logbook.');
                return;
            }

            const originalHtml = saveBtn.innerHTML;
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            const payload = {
                date: dateInput.value,
                content: contentInput.value
            };

            console.log('Payload to send:', payload);
            console.log('URL:', `/logbook/${id}`);

            fetch(`/logbook/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response ok:', response.ok);
                return response.json().then(data => ({ status: response.status, ok: response.ok, data }));
            })
            .then(({ status, ok, data }) => {
                console.log('Response data:', data);

                if (ok && data.success) {
                    console.log('Success! Reloading page...');
                    window.location.reload();
                } else {
                    console.error('Server returned error:', data);
                    let errorMsg = data.message || 'Terjadi kesalahan saat menyimpan perubahan.';

                    // Handle validation errors
                    if (data.errors) {
                        console.error('Validation errors:', data.errors);
                        errorMsg = Object.values(data.errors).flat().join('\n');
                    }

                    alert(errorMsg);
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalHtml;
                }
            })
            .catch(error => {
                console.error('=== FETCH ERROR ===');
                console.error('Error type:', error.name);
                console.error('Error message:', error.message);
                console.error('Full error:', error);
                alert('Terjadi kesalahan saat menyimpan perubahan: ' + error.message);
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalHtml;
            });
        }

        // Cancel edit button clicked
        if (e.target.closest('.btn-cancel-edit')) {
            const row = e.target.closest('tr');
            cancelEdit(row);
        }

        // Delete button clicked
        if (e.target.closest('.btn-delete-logbook')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;

            // Dispatch custom event for Alpine.js modal
            window.dispatchEvent(new CustomEvent('delete-logbook', { detail: { id: id } }));
        }
    });

    // Global function for Alpine.js modal
    window.confirmDeleteLogbook = async function(id) {
        if (!id) return;

        try {
            const response = await fetch(`/logbook/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menghapus logbook.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus logbook.');
        }
    };

    function cancelEdit(row) {
        if (!row) return;

        row.classList.remove('editing');
        row.querySelectorAll('.view-mode').forEach(el => el.style.display = '');
        row.querySelectorAll('.edit-mode').forEach(el => el.style.display = 'none');

        // Reset values
        const dateInput = row.querySelector('input[type="date"].edit-mode');
        if (dateInput && dateInput.defaultValue) {
            dateInput.value = dateInput.defaultValue;
        }

        const contentInput = row.querySelector('textarea.edit-mode');
        if (contentInput && contentInput.defaultValue) {
            contentInput.value = contentInput.defaultValue;
        }

        currentEditRow = null;
    }
});
</script>
@endpush
