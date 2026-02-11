{{--
    MENTOR LAPORAN PENILAIAN PAGE
    Assessment report management
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Laporan Penilaian')

@php
    $role = 'mentor';
    $pageTitle = 'Laporan Penilaian';
    $pageSubtitle = 'Upload dan kelola laporan penilaian peserta magang';
@endphp

@push('styles')
<style>
/* ============================================
   LAPORAN PENILAIAN PAGE STYLES
   ============================================ */

/* Hero Section */
.mentor-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.mentor-hero::before {
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
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
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

/* Filter Card */
.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    padding: 1.75rem;
    margin-bottom: 2rem;
}

.filter-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.filter-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    color: #EE2E24;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.filter-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.filter-group select {
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9375rem;
    background: white;
    color: #1f2937;
    transition: all 0.2s ease;
}

.filter-group select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
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
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.table-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

/* Data Table */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f9fafb;
}

.data-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.data-table td {
    padding: 1rem 1.25rem;
    font-size: 0.9rem;
    color: #1f2937;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.2s;
}

.data-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Participant Name */
.participant-name {
    font-weight: 600;
    color: #1f2937;
}

/* Upload Form */
.upload-form {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.file-input-wrapper {
    flex: 1;
    min-width: 200px;
}

.file-input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
    transition: all 0.2s;
}

.file-input:focus {
    outline: none;
    border-color: #EE2E24;
}

/* Buttons */
.btn-upload {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-upload:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.btn-upload:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-download {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    white-space: nowrap;
}

.btn-download:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
}

.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* File Status */
.file-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

.file-status.has-file {
    color: #059669;
}

.file-status.has-file i {
    color: #10B981;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #EE2E24;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9375rem;
    color: #6b7280;
    margin: 0;
}

/* Spinner */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-text h1 {
        font-size: 1.5rem;
    }

    .filter-card {
        padding: 1.25rem;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }

    .upload-form {
        flex-direction: column;
        align-items: stretch;
    }

    .file-input-wrapper {
        min-width: 100%;
    }

    .btn-upload {
        width: 100%;
        justify-content: center;
    }

    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .action-buttons .btn-download,
    .action-buttons .btn-delete {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="mentor-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-chart-bar"></i> Laporan Penilaian</h1>
            <p>Upload dan kelola laporan penilaian peserta magang berdasarkan periode</p>
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="filter-card">
    <div class="filter-header">
        <div class="filter-icon">
            <i class="fas fa-filter"></i>
        </div>
        <h3>Filter Laporan</h3>
    </div>
    <div class="filter-grid">
        <div class="filter-group">
            <label for="tahun">Tahun</label>
            <select id="tahun">
                <option value="">Pilih Tahun</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="bulan">Bulan</label>
            <select id="bulan">
                <option value="">Pilih Bulan</option>
            </select>
        </div>
    </div>
</div>

{{-- Report Table --}}
<div class="table-card">
    <div class="table-header">
        <i class="fas fa-table"></i>
        <h3>Data Laporan Penilaian</h3>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Peserta</th>
                <th>Upload Laporan PDF</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h3>Tidak Ada Data</h3>
                        <p>Tidak ada data peserta magang untuk periode ini</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
function loadTahun() {
    const tahunSelect = document.getElementById('tahun');
    while (tahunSelect.options.length > 1) {
        tahunSelect.remove(1);
    }

    fetch(`/mentor/laporan-penilaian/years`)
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return res.json();
        })
        .then(res => {
            if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                res.data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.value;
                    opt.textContent = item.label;
                    tahunSelect.appendChild(opt);
                });
                const currentYear = new Date().getFullYear();
                const option = Array.from(tahunSelect.options).find(opt => opt.value == currentYear);
                if (option) {
                    tahunSelect.value = currentYear;
                }
            }
        })
        .catch(error => {
            console.error('Error loading tahun:', error);
        });
}

function loadBulan() {
    const bulanSelect = document.getElementById('bulan');
    const tahunSelect = document.getElementById('tahun');
    const selectedYear = tahunSelect.value;

    while (bulanSelect.options.length > 1) {
        bulanSelect.remove(1);
    }

    const namaBulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    if (selectedYear) {
        namaBulan.forEach((nama, index) => {
            const monthNumber = String(index + 1).padStart(2, '0');
            const opt = document.createElement('option');
            opt.value = `${monthNumber}-${selectedYear}`;
            opt.textContent = nama;
            bulanSelect.appendChild(opt);
        });

        if (selectedYear == new Date().getFullYear()) {
            const now = new Date();
            const currentMonth = String(now.getMonth() + 1).padStart(2, '0');
            const currentValue = `${currentMonth}-${selectedYear}`;
            bulanSelect.value = currentValue;
        }
    } else {
        fetch(`/mentor/laporan-penilaian/periods?period=bulanan`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(res => {
                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    const bulanSet = new Set();
                    res.data.forEach(item => {
                        const bulanName = item.label.split(' ')[0];
                        const monthNumber = item.value.split('-')[0];
                        if (!bulanSet.has(monthNumber)) {
                            bulanSet.add(monthNumber);
                            const opt = document.createElement('option');
                            const year = item.value.split('-')[1];
                            opt.value = `${monthNumber}-${year}`;
                            opt.textContent = bulanName;
                            bulanSelect.appendChild(opt);
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error loading bulan:', error);
            });
    }
}

document.getElementById('tahun').addEventListener('change', function() {
    document.getElementById('bulan').value = '';
    loadBulan();
    fetchReport();
});

document.getElementById('bulan').addEventListener('change', fetchReport);

function fetchReport() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/mentor/laporan-penilaian/data?period=bulanan`;

    if (bulan && tahun) {
        const [month, year] = bulan.split('-');
        const selectedYear = tahun || year;
        url += `&year=${selectedYear}&month=${month}`;
    } else if (bulan) {
        const [month, year] = bulan.split('-');
        url += `&year=${year}&month=${month}`;
    } else if (tahun) {
        url += `&year=${tahun}`;
    }

    fetch(url)
        .then(res => res.json())
        .then(res => {
            const tbody = document.querySelector('.data-table tbody');
            tbody.innerHTML = '';
            const data = res.data;
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td><span class="participant-name">${row.nama}</span></td>
                        <td>
                            ${row.has_report ?
                                `<div class="action-buttons">
                                    <a href="/mentor/laporan-penilaian/${row.id}/download" class="btn-download">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <button onclick="deleteReport(${row.id})" class="btn-delete">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                <div class="file-status has-file">
                                    <i class="fas fa-check-circle"></i>
                                    <span>File sudah diupload</span>
                                </div>` :
                                `<form class="upload-form" onsubmit="uploadReport(event, ${row.id})">
                                    <div class="file-input-wrapper">
                                        <input type="file" name="assessment_report" class="file-input" accept=".pdf" required>
                                    </div>
                                    <button type="submit" class="btn-upload">
                                        <i class="fas fa-upload"></i> Upload PDF
                                    </button>
                                </form>`
                            }
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3>Tidak Ada Data</h3>
                                <p>Tidak ada data peserta magang untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching report:', error);
        });
}

function uploadReport(event, applicationId) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

    fetch(`/mentor/laporan-penilaian/${applicationId}/upload`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            fetchReport();
        } else {
            alert('Gagal upload: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal upload laporan. Silakan coba lagi.');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
        form.reset();
    });
}

function deleteReport(applicationId) {
    if (!confirm('Apakah Anda yakin ingin menghapus laporan penilaian ini?')) {
        return;
    }

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
            alert(data.message);
            fetchReport();
        } else {
            alert('Gagal menghapus: ' + (data.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menghapus laporan. Silakan coba lagi.');
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadTahun();
    loadBulan();
    setTimeout(fetchReport, 500);
});
</script>
@endpush
