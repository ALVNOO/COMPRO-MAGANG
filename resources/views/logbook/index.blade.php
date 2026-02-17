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
                <tr data-id="{{ $logbook->id }}">
                    <td>
                        <span class="logbook-date">{{ $logbook->date->format('d M Y') }}</span>
                    </td>
                    <td>
                        <div class="logbook-content-cell">{{ $logbook->content }}</div>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <div style="display: inline-flex; gap: 0.5rem;">
                            <button type="button" class="btn-action edit btn-edit-logbook"
                                    data-id="{{ $logbook->id }}"
                                    data-date="{{ $logbook->date->format('Y-m-d') }}"
                                    data-content="{{ $logbook->content }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-action delete btn-delete-logbook"
                                    data-id="{{ $logbook->id }}">
                                <i class="fas fa-trash"></i>
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

                @php $emptyRows = max(0, 5 - $logbooks->count()); @endphp
                @for($i = 0; $i < $emptyRows; $i++)
                <tr class="new-entry-row" style="display: none;">
                    <td>
                        <input type="date" class="form-control input-date" required>
                    </td>
                    <td>
                        <textarea class="form-control logbook-textarea input-content" rows="3" placeholder="Tulis aktivitas Anda hari ini..." required></textarea>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <div style="display: inline-flex; gap: 0.5rem;">
                            <button type="button" class="btn-save-entry btn-save-new">
                                <i class="fas fa-save"></i>
                            </button>
                            <button type="button" class="btn-cancel-entry btn-cancel-new">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit" style="color: #F59E0B;"></i>
                    Edit Logbook
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="editDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="editContent" class="form-label">Isi Logbook</label>
                        <textarea class="form-control" id="editContent" rows="6" required placeholder="Tulis aktivitas Anda..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="color: #374151;">Apakah Anda yakin ingin menghapus logbook ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">Batal</button>
                <button type="button" class="btn-modal-danger" id="confirmDelete">
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
    const logbookBody = document.getElementById('logbookBody');
    const btnAddLogbook = document.getElementById('btnAddLogbook');
    let visibleEmptyRows = 0;
    const maxEmptyRows = {{ $emptyRows }};
    let deleteId = null;

    showNextEmptyRow();

    function showNextEmptyRow() {
        const emptyRows = document.querySelectorAll('.new-entry-row');
        let shown = false;

        for (let row of emptyRows) {
            if (row.style.display === 'none') {
                row.style.display = '';
                visibleEmptyRows++;
                shown = true;

                // Hide empty placeholder if visible
                const placeholder = document.querySelector('.empty-row-placeholder');
                if (placeholder) placeholder.style.display = 'none';

                break;
            }
        }

        if (!shown) {
            addNewEmptyRow();
        }
    }

    function addNewEmptyRow() {
        const placeholder = document.querySelector('.empty-row-placeholder');
        if (placeholder) placeholder.style.display = 'none';

        const newRow = document.createElement('tr');
        newRow.className = 'new-entry-row';
        newRow.innerHTML = `
            <td>
                <input type="date" class="form-control input-date" required>
            </td>
            <td>
                <textarea class="form-control logbook-textarea input-content" rows="3" placeholder="Tulis aktivitas Anda hari ini..." required></textarea>
            </td>
            <td style="text-align: center; white-space: nowrap;">
                <div style="display: inline-flex; gap: 0.5rem;">
                    <button type="button" class="btn-save-entry btn-save-new">
                        <i class="fas fa-save"></i>
                    </button>
                    <button type="button" class="btn-cancel-entry btn-cancel-new">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </td>
        `;
        logbookBody.appendChild(newRow);
        visibleEmptyRows++;
    }

    btnAddLogbook.addEventListener('click', function() {
        showNextEmptyRow();
    });

    logbookBody.addEventListener('click', async function(e) {
        if (e.target.closest('.btn-save-new')) {
            const row = e.target.closest('tr');
            const dateInput = row.querySelector('.input-date');
            const contentInput = row.querySelector('.input-content');
            const saveBtn = row.querySelector('.btn-save-new');

            if (!dateInput.value || !contentInput.value.trim()) {
                alert('Mohon isi tanggal dan isi logbook.');
                return;
            }

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            try {
                const response = await fetch('{{ route("logbook.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        date: dateInput.value,
                        content: contentInput.value
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyimpan logbook.');
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i>';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan logbook.');
                saveBtn.disabled = false;
                saveBtn.innerHTML = '<i class="fas fa-save"></i>';
            }
        }

        if (e.target.closest('.btn-cancel-new')) {
            const row = e.target.closest('tr');
            row.querySelector('.input-date').value = '';
            row.querySelector('.input-content').value = '';
            row.style.display = 'none';
            visibleEmptyRows--;
        }

        if (e.target.closest('.btn-edit-logbook')) {
            const btn = e.target.closest('.btn-edit-logbook');
            document.getElementById('editId').value = btn.dataset.id;
            document.getElementById('editDate').value = btn.dataset.date;
            document.getElementById('editContent').value = btn.dataset.content;

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        if (e.target.closest('.btn-delete-logbook')) {
            const btn = e.target.closest('.btn-delete-logbook');
            deleteId = btn.dataset.id;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    });

    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const id = document.getElementById('editId').value;
        const date = document.getElementById('editDate').value;
        const content = document.getElementById('editContent').value;
        const submitBtn = this.querySelector('button[type="submit"]');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        try {
            const response = await fetch(`/logbook/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ date, content })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan saat menyimpan perubahan.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan perubahan.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Perubahan';
        }
    });

    document.getElementById('confirmDelete').addEventListener('click', async function() {
        if (!deleteId) return;

        const deleteBtn = this;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

        try {
            const response = await fetch(`/logbook/${deleteId}`, {
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
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fas fa-trash"></i> Hapus';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus logbook.');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i> Hapus';
        }
    });
});
</script>
@endpush
