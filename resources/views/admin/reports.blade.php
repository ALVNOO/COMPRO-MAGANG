{{--
    ADMIN REPORTS PAGE
    Generate dan export laporan peserta magang berdasarkan periode
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Laporan Peserta Magang')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Laporan Peserta Magang';
    $pageSubtitle = 'Generate dan export laporan peserta magang berdasarkan periode';
@endphp

@push('styles')
<style>
/* ============================================
   REPORTS PAGE STYLES
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

/* Hero Export Buttons */
.hero-actions {
    display: flex;
    gap: 12px;
}

.hero-export-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.hero-export-btn.pdf {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-export-btn.pdf:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.hero-export-btn.excel {
    background: rgba(34, 197, 94, 0.9);
    color: white;
}

.hero-export-btn.excel:hover {
    background: rgba(34, 197, 94, 1);
    transform: translateY(-2px);
}

.hero-export-btn.manual {
    background: rgba(59, 130, 246, 0.9);
    color: white;
}

.hero-export-btn.manual:hover {
    background: rgba(59, 130, 246, 1);
    transform: translateY(-2px);
}

/* Filter Card */
.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.06);
}

.filter-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

.filter-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.filter-header i {
    color: #EE2E24;
    font-size: 1.1rem;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.filter-group label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}

.filter-select {
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

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.manual-entry-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.06);
}

.manual-entry-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.manual-entry-actions {
    margin-top: 1rem;
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.manual-entry-hint {
    font-size: 0.8rem;
    color: #6b7280;
}

.manual-entry-submit {
    border: none;
    border-radius: 10px;
    background: #2563eb;
    color: #fff;
    padding: 0.6rem 1rem;
    font-weight: 600;
}

.manual-entry-submit:hover {
    background: #1d4ed8;
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

.table-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.table-header h3 i {
    color: #EE2E24;
}

.table-content {
    padding: 0;
}

.table-responsive {
    overflow-x: auto;
}

/* Admin Table */
.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead {
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(238, 46, 36, 0.02) 100%);
}

.admin-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    white-space: nowrap;
}

.admin-table td {
    padding: 1rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
}

.admin-table tbody tr {
    transition: all 0.2s ease;
}

.admin-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
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

/* Loading State */
.loading-state {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 3rem;
    color: #6b7280;
}

.loading-state i {
    font-size: 1.5rem;
    color: #EE2E24;
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

    .hero-actions {
        flex-direction: column;
        width: 100%;
    }

    .hero-export-btn {
        width: 100%;
        justify-content: center;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .manual-entry-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')

{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1><i class="fas fa-chart-bar"></i> Laporan Peserta Magang</h1>
            <p>Generate dan export laporan peserta magang berdasarkan periode</p>
        </div>
        <div class="hero-actions">
            <button id="btn-toggle-manual-form" class="hero-export-btn manual" type="button">
                <i class="fas fa-plus-circle"></i> Tambah Data Manual
            </button>
            <button id="btn-export-pdf" class="hero-export-btn pdf">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <button id="btn-export-excel" class="hero-export-btn excel">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="filter-card">
    <div class="filter-header">
        <i class="fas fa-filter"></i>
        <h3>Filter Laporan</h3>
    </div>
    <div class="filter-grid">
        <div class="filter-group">
            <label for="tahun">Tahun</label>
            <select id="tahun" class="filter-select">
                <option value="">Pilih Tahun</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="bulan">Bulan</label>
            <select id="bulan" class="filter-select">
                <option value="">Pilih Bulan</option>
            </select>
        </div>
    </div>
</div>

{{-- Manual Entry Card --}}
<div class="manual-entry-card" id="manual-entry-card" style="display: none;">
    <div class="filter-header">
        <i class="fas fa-user-plus"></i>
        <h3>Tambah Data Peserta Manual</h3>
    </div>
    <form id="manual-entry-form">
        @csrf
        <div class="manual-entry-grid">
            <div class="filter-group">
                <label for="manual_nama">Nama Peserta</label>
                <input id="manual_nama" name="nama" type="text" class="filter-select" required>
            </div>
            <div class="filter-group">
                <label for="manual_universitas">Universitas/Sekolah</label>
                <input id="manual_universitas" name="universitas" type="text" class="filter-select" required>
            </div>
            <div class="filter-group">
                <label for="manual_jurusan">Jurusan</label>
                <input id="manual_jurusan" name="jurusan" type="text" class="filter-select" required>
            </div>
            <div class="filter-group">
                <label for="manual_nim">NIM</label>
                <input id="manual_nim" name="nim" type="text" class="filter-select" required>
            </div>
            <div class="filter-group">
                <label for="manual_tanggal_mulai">Tanggal Mulai</label>
                <input id="manual_tanggal_mulai" name="tanggal_mulai" type="date" class="filter-select" required>
            </div>
            <div class="filter-group">
                <label for="manual_tanggal_berakhir">Tanggal Berakhir</label>
                <input id="manual_tanggal_berakhir" name="tanggal_berakhir" type="date" class="filter-select">
            </div>
            <div class="filter-group">
                <label for="manual_divisi">Divisi</label>
                <select id="manual_divisi" name="divisi" class="filter-select" required>
                    <option value="">Pilih Divisi</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->division_name }}">{{ $division->division_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="manual_judul_proyek">Judul Proyek</label>
                <input id="manual_judul_proyek" name="judul_proyek" type="text" class="filter-select">
            </div>
            <div class="filter-group">
                <label for="manual_nilai">Nilai</label>
                <input id="manual_nilai" name="nilai" type="number" min="0" max="100" step="0.1" class="filter-select">
            </div>
        </div>
        <div class="manual-entry-actions">
            <button type="submit" class="manual-entry-submit">Simpan Data Manual</button>
            <span id="manual-entry-status" class="manual-entry-hint"></span>
        </div>
    </form>
</div>

{{-- Report Table --}}
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-table"></i> Data Laporan</h3>
    </div>
    <div class="table-content">
        <div class="table-responsive">
            <table class="admin-table" id="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Universitas/Sekolah</th>
                        <th>Jurusan</th>
                        <th>NIM</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Divisi</th>
                        <th>Judul Proyek</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10">
                            <div class="loading-state">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Memuat data...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function loadTahun() {
    const tahunSelect = document.getElementById('tahun');
    // Hapus semua option kecuali placeholder
    while (tahunSelect.options.length > 1) {
        tahunSelect.remove(1);
    }

    fetch(`/admin/reports/years`)
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
            } else {
                console.warn('No year data available');
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

    // Hapus semua option kecuali placeholder
    while (bulanSelect.options.length > 1) {
        bulanSelect.remove(1);
    }

    // Nama bulan dalam bahasa Indonesia
    const namaBulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    // Jika tahun dipilih, tampilkan opsi semua bulan + daftar bulan untuk tahun tersebut
    if (selectedYear) {
        const allOpt = document.createElement('option');
        allOpt.value = 'all';
        allOpt.textContent = 'Semua Bulan';
        bulanSelect.appendChild(allOpt);

        namaBulan.forEach((nama, index) => {
            const monthNumber = String(index + 1).padStart(2, '0');
            const opt = document.createElement('option');
            // Value format MM-YYYY
            opt.value = `${monthNumber}-${selectedYear}`;
            // Text hanya nama bulan
            opt.textContent = nama;
            bulanSelect.appendChild(opt);
        });
    } else {
        // Jika tidak ada tahun yang dipilih, ambil dari API untuk mendapatkan bulan yang tersedia
        fetch(`/admin/reports/periods?period=bulanan`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Network response was not ok');
                }
                return res.json();
            })
            .then(res => {
                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    // Buat set untuk menghindari duplikasi bulan
                    const bulanSet = new Set();

                    res.data.forEach(item => {
                        // Ekstrak nama bulan saja (hapus tahun dari label)
                        const bulanName = item.label.split(' ')[0];
                        const monthNumber = item.value.split('-')[0];

                        if (!bulanSet.has(monthNumber)) {
                            bulanSet.add(monthNumber);
                            const opt = document.createElement('option');
                            // Ambil tahun dari item pertama yang memiliki bulan ini
                            const year = item.value.split('-')[1];
                            opt.value = `${monthNumber}-${year}`;
                            opt.textContent = bulanName;
                            bulanSelect.appendChild(opt);
                        }
                    });
                } else {
                    console.warn('No period data available');
                }
            })
            .catch(error => {
                console.error('Error loading bulan:', error);
            });
    }
}

// Event listeners
document.getElementById('tahun').addEventListener('change', function() {
    // Reset bulan saat tahun berubah
    document.getElementById('bulan').value = '';
    loadBulan();
    fetchReport();
});

document.getElementById('bulan').addEventListener('change', fetchReport);

const manualCard = document.getElementById('manual-entry-card');
const manualToggleBtn = document.getElementById('btn-toggle-manual-form');
const manualForm = document.getElementById('manual-entry-form');
const manualStatus = document.getElementById('manual-entry-status');

manualToggleBtn.addEventListener('click', function () {
    const isHidden = manualCard.style.display === 'none';
    manualCard.style.display = isHidden ? 'block' : 'none';
});

manualForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(manualForm);
    manualStatus.textContent = 'Menyimpan data...';

    fetch('/admin/reports/manual', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData,
    })
        .then(async (res) => {
            const payload = await res.json();
            if (!res.ok) {
                const firstError = payload?.errors ? Object.values(payload.errors)[0]?.[0] : null;
                throw new Error(firstError || payload?.message || 'Gagal menyimpan data manual');
            }

            return payload;
        })
        .then((payload) => {
            const savedStartDate = payload?.data?.tanggal_mulai;
            if (savedStartDate) {
                const date = new Date(savedStartDate);
                if (!Number.isNaN(date.getTime())) {
                    const savedYear = String(date.getFullYear());
                    const savedMonth = String(date.getMonth() + 1).padStart(2, '0');
                    const yearSelect = document.getElementById('tahun');
                    const hasYearOption = Array.from(yearSelect.options).some(option => option.value === savedYear);
                    if (!hasYearOption) {
                        const option = document.createElement('option');
                        option.value = savedYear;
                        option.textContent = savedYear;
                        yearSelect.appendChild(option);
                    }
                    yearSelect.value = savedYear;
                    loadBulan();
                    document.getElementById('bulan').value = `${savedMonth}-${savedYear}`;
                }
            }

            manualStatus.textContent = 'Data manual berhasil disimpan.';
            manualForm.reset();
            fetchReport();
        })
        .catch((error) => {
            manualStatus.textContent = error.message || 'Terjadi kesalahan saat menyimpan data.';
        });
});

function fetchReport() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/data?period=bulanan`;

    if (bulan === 'all' && tahun) {
        url = `/admin/reports/data?period=tahunan&year=${tahun}`;
    } else if (bulan && tahun) {
        // Jika bulan dan tahun dipilih, gunakan keduanya
        const [month, year] = bulan.split('-');
        // Prioritaskan tahun dari dropdown tahun jika ada
        const selectedYear = tahun || year;
        url += `&year=${selectedYear}&month=${month}`;
    } else if (bulan) {
        // Jika hanya bulan dipilih (tidak ada tahun), gunakan tahun dari value bulan
        const [month, year] = bulan.split('-');
        url += `&year=${year}&month=${month}`;
    } else if (tahun) {
        // Jika hanya tahun dipilih, tampilkan 1 tahun penuh
        url = `/admin/reports/data?period=tahunan&year=${tahun}`;
    }

    // Show loading
    const tbody = document.querySelector('#report-table tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="10">
                <div class="loading-state">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>Memuat data...</span>
                </div>
            </td>
        </tr>
    `;

    fetch(url)
        .then(res => res.json())
        .then(res => {
            tbody.innerHTML = '';
            const data = res.data;
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    const esc = (s) => String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td><strong>${esc(row.nama)}</strong></td>
                        <td>${esc(row.universitas)}</td>
                        <td>${esc(row.jurusan)}</td>
                        <td>${esc(row.nim)}</td>
                        <td>${esc(row.tanggal_mulai)}</td>
                        <td>${esc(row.tanggal_berakhir)}</td>
                        <td>${esc(row.divisi)}</td>
                        <td>${esc(row.judul_proyek)}</td>
                        <td>${esc(row.nilai)}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>Tidak Ada Data</h4>
                                <p>Tidak ada peserta magang untuk periode yang dipilih</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching report:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4>Gagal Memuat Data</h4>
                            <p>Terjadi kesalahan saat memuat data laporan</p>
                        </div>
                    </td>
                </tr>
            `;
        });
}

// Panggil saat load awal
loadTahun();
loadBulan();

// Fetch report dengan delay untuk menunggu dropdown ter-load
setTimeout(fetchReport, 500);

// Export PDF
document.getElementById('btn-export-pdf').addEventListener('click', function() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/export/pdf?period=bulanan`;

    if (bulan === 'all' && tahun) {
        url = `/admin/reports/export/pdf?period=tahunan&year=${tahun}`;
    } else if (bulan && tahun) {
        const [month, year] = bulan.split('-');
        const selectedYear = tahun || year;
        url += `&year=${selectedYear}&month=${month}`;
    } else if (bulan) {
        const [month, year] = bulan.split('-');
        url += `&year=${year}&month=${month}`;
    } else if (tahun) {
        url = `/admin/reports/export/pdf?period=tahunan&year=${tahun}`;
    }

    window.location.href = url;
});

// Export Excel
document.getElementById('btn-export-excel').addEventListener('click', function() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/export/excel?period=bulanan`;

    if (bulan === 'all' && tahun) {
        url = `/admin/reports/export/excel?period=tahunan&year=${tahun}`;
    } else if (bulan && tahun) {
        const [month, year] = bulan.split('-');
        const selectedYear = tahun || year;
        url += `&year=${selectedYear}&month=${month}`;
    } else if (bulan) {
        const [month, year] = bulan.split('-');
        url += `&year=${year}&month=${month}`;
    } else if (tahun) {
        url = `/admin/reports/export/excel?period=tahunan&year=${tahun}`;
    }

    window.location.href = url;
});
</script>
@endpush
