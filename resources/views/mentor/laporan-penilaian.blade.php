{{-- Mentor: Upload dan kelola laporan penilaian peserta --}}
@extends('layouts.dashboard-unified')

@section('title', 'Laporan Penilaian')

@php
    $role = 'mentor';
    $pageTitle = 'Laporan Penilaian';
    $pageSubtitle = 'Upload dan kelola laporan penilaian peserta magang';
@endphp

@push('styles')
<style>
/* ============================================================
   LAPORAN PENILAIAN — namespace lp-*
   ============================================================ */

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

/* ── Filter Card ──────────────────────────────────────────── */
.lp-filter {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    padding: 1.375rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.lp-filter-head {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin-bottom: 1.125rem;
}

.lp-filter-head i   { color: #EE2E24; font-size: 0.95rem; }
.lp-filter-head span { font-size: 0.9375rem; font-weight: 600; color: #111827; }

.lp-filter-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.125rem;
}

.lp-filter-lbl {
    display: block;
    font-size: 0.72rem;
    font-weight: 600;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 0.45rem;
}

.lp-select {
    width: 100%;
    padding: 0.7rem 2.25rem 0.7rem 0.875rem;
    font-size: 0.9rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    background: #fff;
    color: #1f2937;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.625rem center;
    background-size: 1.1rem;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.lp-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238,46,36,0.1);
}

/* ── Table Card ───────────────────────────────────────────── */
.lp-table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.lp-table-head {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid #F3F4F6;
}

.lp-table-head i    { color: #EE2E24; font-size: 0.95rem; }
.lp-table-head span { font-size: 0.9375rem; font-weight: 600; color: #111827; }

.lp-table { width: 100%; border-collapse: collapse; }

.lp-table thead th {
    padding: 0.75rem 1.25rem;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: #6B7280;
    background: #F9FAFB;
    border-bottom: 1px solid #F3F4F6;
    text-align: left;
}

.lp-table tbody td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #F9FAFB;
    vertical-align: middle;
}

.lp-table tbody tr:last-child td { border-bottom: none; }
.lp-table tbody tr:hover { background: #FAFAFA; }

/* Participant cell */
.lp-participant { display: flex; align-items: center; gap: 0.75rem; }

.lp-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: #fff;
    font-size: 0.875rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.lp-name { font-size: 0.9rem; font-weight: 600; color: #111827; }

/* Upload zone — dashed */
.lp-upload-form { display: flex; align-items: center; gap: 0.5rem; }

.lp-file-label {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 0.75rem;
    border: 1.5px dashed #D1D5DB;
    border-radius: 8px;
    font-size: 0.75rem;
    color: #6B7280;
    cursor: pointer;
    transition: border-color 0.15s, color 0.15s;
    white-space: nowrap;
    overflow: hidden;
    min-width: 0;
}

.lp-file-label:hover { border-color: #EE2E24; color: #EE2E24; }

.lp-file-name {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 130px;
}

/* Buttons */
.lp-actions { display: flex; align-items: center; gap: 0.375rem; flex-wrap: wrap; }

.lp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 0.875rem;
    border: none;
    border-radius: 8px;
    font-size: 0.775rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    text-decoration: none;
}

.lp-btn-primary             { background: #EE2E24; color: #fff; }
.lp-btn-primary:hover       { background: #C41E1A; color: #fff; }
.lp-btn-primary:disabled    { opacity: 0.55; cursor: not-allowed; }

.lp-btn-success             { background: rgba(22,163,74,0.1); color: #16A34A; border: 1px solid rgba(22,163,74,0.25); }
.lp-btn-success:hover       { background: rgba(22,163,74,0.18); color: #16A34A; }

.lp-btn-danger              { background: rgba(220,38,38,0.08); color: #DC2626; border: 1px solid rgba(220,38,38,0.2); }
.lp-btn-danger:hover        { background: rgba(220,38,38,0.15); color: #DC2626; }

/* File uploaded indicator */
.lp-file-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.72rem;
    color: #16A34A;
    font-weight: 500;
    margin-top: 0.375rem;
}

/* Empty state */
.lp-empty { text-align: center; padding: 3.5rem 2rem; }

.lp-empty-icon {
    width: 72px;
    height: 72px;
    margin: 0 auto 1.25rem;
    background: rgba(238,46,36,0.07);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    color: #EE2E24;
}

.lp-empty h3 { font-size: 1.1rem; font-weight: 600; color: #1f2937; margin: 0 0 0.4rem; }
.lp-empty p  { font-size: 0.875rem; color: #6B7280; margin: 0; }

/* Delete confirm modal */
.lp-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    z-index: 9000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.lp-modal-box {
    background: #fff;
    border-radius: 18px;
    padding: 2rem;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 24px 64px rgba(0,0,0,0.18);
    text-align: center;
}

.lp-modal-icon {
    width: 56px; height: 56px;
    margin: 0 auto 1.125rem;
    border-radius: 50%;
    background: rgba(220,38,38,0.1);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.375rem;
    color: #DC2626;
}

.lp-modal-title { font-size: 1.0625rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem; }
.lp-modal-desc  { font-size: 0.875rem; color: #6B7280; margin: 0 0 1.5rem; line-height: 1.55; }
.lp-modal-actions { display: flex; gap: 0.75rem; justify-content: center; }

/* Responsive */
@media (max-width: 768px) {
    .stats-grid     { grid-template-columns: repeat(2, 1fr); }
    .lp-filter-grid { grid-template-columns: 1fr; }
    .lp-table-card  { overflow-x: auto; }
    .lp-actions     { flex-direction: column; align-items: flex-start; }
    .lp-btn         { width: 100%; justify-content: center; }
}

@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<div class="lp-page" x-data="{
    showDeleteModal: false,
    deleteTargetId: null,
    confirmDelete() {
        if (!this.deleteTargetId) return;
        deleteReport(this.deleteTargetId);
        this.showDeleteModal = false;
        this.deleteTargetId = null;
    }
}">

<x-dashboard.page-context-bar
    title="Laporan Penilaian"
    description="Upload dan kelola laporan penilaian peserta magang berdasarkan periode"
    icon="fas fa-chart-bar"
    role="pembimbing"
/>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card stat-card-primary">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value" id="stat-total">—</div>
                <div class="stat-label">Total Peserta</div>
            </div>
            <div class="stat-icon stat-icon-primary">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value" id="stat-uploaded">—</div>
                <div class="stat-label">Sudah Upload</div>
            </div>
            <div class="stat-icon stat-icon-success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    <div class="stat-card stat-card-warning">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value" id="stat-pending">—</div>
                <div class="stat-label">Belum Upload</div>
            </div>
            <div class="stat-icon stat-icon-warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="lp-filter">
    <div class="lp-filter-head">
        <i class="fas fa-filter"></i>
        <span>Filter Periode</span>
    </div>
    <div class="lp-filter-grid">
        <div>
            <label class="lp-filter-lbl" for="tahun">Tahun</label>
            <select id="tahun" class="lp-select">
                <option value="">Pilih Tahun</option>
            </select>
        </div>
        <div>
            <label class="lp-filter-lbl" for="bulan">Bulan</label>
            <select id="bulan" class="lp-select">
                <option value="">Pilih Bulan</option>
            </select>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="lp-table-card">
    <div class="lp-table-head">
        <i class="fas fa-file-alt"></i>
        <span>Data Laporan Penilaian</span>
    </div>
    <table class="lp-table">
        <thead>
            <tr>
                <th style="width:52px;">No</th>
                <th>Nama Peserta</th>
                <th>Laporan PDF</th>
            </tr>
        </thead>
        <tbody id="lp-tbody">
            <tr>
                <td colspan="3">
                    <div class="lp-empty">
                        <div class="lp-empty-icon"><i class="fas fa-inbox"></i></div>
                        <h3>Tidak Ada Data</h3>
                        <p>Pilih tahun dan bulan untuk melihat data peserta</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Delete Confirm Modal --}}
<div class="lp-modal-backdrop" x-show="showDeleteModal" x-cloak @click.self="showDeleteModal = false">
    <div class="lp-modal-box">
        <div class="lp-modal-icon"><i class="fas fa-trash-alt"></i></div>
        <p class="lp-modal-title">Hapus Laporan Penilaian?</p>
        <p class="lp-modal-desc">Tindakan ini tidak dapat dibatalkan. Laporan yang telah dihapus tidak bisa dipulihkan kembali.</p>
        <div class="lp-modal-actions">
            <button class="lp-btn lp-btn-danger" @click="confirmDelete()">
                <i class="fas fa-trash-alt"></i> Ya, Hapus
            </button>
            <button class="lp-btn" style="background:#F3F4F6;color:#374151;" @click="showDeleteModal = false">
                Batal
            </button>
        </div>
    </div>
</div>

</div>{{-- end .lp-page --}}

@endsection

@push('scripts')
<script>
function lpGetInitials(name) {
    return name.trim().split(' ').slice(0, 2).map(w => w[0].toUpperCase()).join('');
}

function loadTahun() {
    const tahunSelect = document.getElementById('tahun');
    while (tahunSelect.options.length > 1) tahunSelect.remove(1);

    fetch('/mentor/laporan-penilaian/years')
        .then(res => { if (!res.ok) throw new Error(); return res.json(); })
        .then(res => {
            if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                res.data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.value;
                    opt.textContent = item.label;
                    tahunSelect.appendChild(opt);
                });
                const currentYear = new Date().getFullYear();
                const match = Array.from(tahunSelect.options).find(o => o.value == currentYear);
                if (match) tahunSelect.value = currentYear;
            }
        })
        .catch(() => {});
}

function loadBulan() {
    const bulanSelect = document.getElementById('bulan');
    const tahunSelect = document.getElementById('tahun');
    const selectedYear = tahunSelect.value;
    const namaBulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    while (bulanSelect.options.length > 1) bulanSelect.remove(1);

    if (selectedYear) {
        namaBulan.forEach((nama, index) => {
            const monthNumber = String(index + 1).padStart(2, '0');
            const opt = document.createElement('option');
            opt.value = `${monthNumber}-${selectedYear}`;
            opt.textContent = nama;
            bulanSelect.appendChild(opt);
        });
        if (selectedYear == new Date().getFullYear()) {
            const currentMonth = String(new Date().getMonth() + 1).padStart(2, '0');
            bulanSelect.value = `${currentMonth}-${selectedYear}`;
        }
    } else {
        fetch('/mentor/laporan-penilaian/periods?period=bulanan')
            .then(res => { if (!res.ok) throw new Error(); return res.json(); })
            .then(res => {
                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    const bulanSet = new Set();
                    res.data.forEach(item => {
                        const monthNumber = item.value.split('-')[0];
                        if (!bulanSet.has(monthNumber)) {
                            bulanSet.add(monthNumber);
                            const opt = document.createElement('option');
                            const year = item.value.split('-')[1];
                            opt.value = `${monthNumber}-${year}`;
                            opt.textContent = item.label.split(' ')[0];
                            bulanSelect.appendChild(opt);
                        }
                    });
                }
            })
            .catch(() => {});
    }
}

document.getElementById('tahun').addEventListener('change', function() {
    document.getElementById('bulan').value = '';
    loadBulan();
    fetchReport();
});
document.getElementById('bulan').addEventListener('change', fetchReport);

function lpUpdateStats(data) {
    const total    = Array.isArray(data) ? data.length : 0;
    const uploaded = Array.isArray(data) ? data.filter(r => r.has_report).length : 0;
    document.getElementById('stat-total').textContent    = total;
    document.getElementById('stat-uploaded').textContent = uploaded;
    document.getElementById('stat-pending').textContent  = total - uploaded;
}

function fetchReport() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = '/mentor/laporan-penilaian/data?period=bulanan';

    if (bulan && tahun) {
        const [month] = bulan.split('-');
        url += `&year=${tahun}&month=${month}`;
    } else if (bulan) {
        const [month, year] = bulan.split('-');
        url += `&year=${year}&month=${month}`;
    } else if (tahun) {
        url += `&year=${tahun}`;
    }

    const tbody = document.getElementById('lp-tbody');
    tbody.innerHTML = `<tr><td colspan="3" style="padding:2.5rem;text-align:center;color:#9CA3AF;font-size:.875rem;">
        <i class="fas fa-spinner fa-spin" style="margin-right:.5rem;color:#EE2E24;"></i>Memuat data...
    </td></tr>`;

    fetch(url)
        .then(res => res.json())
        .then(res => {
            const data = res.data;
            tbody.innerHTML = '';
            lpUpdateStats(data);

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const initials = lpGetInitials(row.nama);
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="font-size:.85rem;color:#6B7280;font-variant-numeric:tabular-nums;">${row.no}</td>
                        <td>
                            <div class="lp-participant">
                                <div class="lp-avatar">${initials}</div>
                                <span class="lp-name">${row.nama}</span>
                            </div>
                        </td>
                        <td>
                            ${row.has_report
                                ? `<div class="lp-actions">
                                    <a href="/mentor/laporan-penilaian/${row.id}/download" class="lp-btn lp-btn-success">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <button onclick="triggerDelete(${row.id})" class="lp-btn lp-btn-danger">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </div>
                                <div class="lp-file-indicator">
                                    <i class="fas fa-check-circle"></i> File sudah diupload
                                </div>`
                                : `<form class="lp-upload-form" onsubmit="uploadReport(event, ${row.id})">
                                    <label class="lp-file-label" for="file-${row.id}">
                                        <i class="fas fa-paperclip"></i>
                                        <span class="lp-file-name" id="fname-${row.id}">Pilih file PDF...</span>
                                    </label>
                                    <input type="file" id="file-${row.id}" name="assessment_report" accept=".pdf" required
                                           style="display:none;" onchange="updateFileName(${row.id}, this)">
                                    <button type="submit" class="lp-btn lp-btn-primary">
                                        <i class="fas fa-upload"></i> Upload
                                    </button>
                                </form>`
                            }
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="3">
                    <div class="lp-empty">
                        <div class="lp-empty-icon"><i class="fas fa-inbox"></i></div>
                        <h3>Tidak Ada Data</h3>
                        <p>Tidak ada data peserta magang untuk periode ini</p>
                    </div>
                </td></tr>`;
            }
        })
        .catch(() => {
            tbody.innerHTML = `<tr><td colspan="3" style="padding:2rem;text-align:center;color:#DC2626;font-size:.875rem;">
                <i class="fas fa-exclamation-circle" style="margin-right:.5rem;"></i>Gagal memuat data. Silakan coba lagi.
            </td></tr>`;
        });
}

function updateFileName(id, input) {
    const label = document.getElementById(`fname-${id}`);
    if (label) label.textContent = input.files[0]?.name || 'Pilih file PDF...';
}

function triggerDelete(id) {
    const alpine = document.querySelector('.lp-page').__x.$data;
    alpine.deleteTargetId = id;
    alpine.showDeleteModal = true;
}

function uploadReport(event, applicationId) {
    event.preventDefault();
    const form   = event.target;
    const button = form.querySelector('button[type="submit"]');
    const origHtml = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

    fetch(`/mentor/laporan-penilaian/${applicationId}/upload`, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            fetchReport();
        } else {
            alert('Gagal upload: ' + (data.message || 'Terjadi kesalahan'));
            button.disabled = false;
            button.innerHTML = origHtml;
        }
    })
    .catch(() => {
        alert('Gagal upload laporan. Silakan coba lagi.');
        button.disabled = false;
        button.innerHTML = origHtml;
    });
}

function deleteReport(applicationId) {
    fetch(`/mentor/laporan-penilaian/${applicationId}/delete`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            fetchReport();
        } else {
            alert('Gagal menghapus: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(() => { alert('Gagal menghapus laporan. Silakan coba lagi.'); });
}

document.addEventListener('DOMContentLoaded', function() {
    loadTahun();
    loadBulan();
    setTimeout(fetchReport, 500);
});
</script>
@endpush
