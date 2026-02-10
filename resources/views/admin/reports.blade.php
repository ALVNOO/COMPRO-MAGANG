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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8">
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
                // Set default ke tahun saat ini jika ada
                const currentYear = new Date().getFullYear();
                const option = Array.from(tahunSelect.options).find(opt => opt.value == currentYear);
                if (option) {
                    tahunSelect.value = currentYear;
                }
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

    // Jika tahun dipilih, tampilkan semua bulan untuk tahun tersebut
    if (selectedYear) {
        namaBulan.forEach((nama, index) => {
            const monthNumber = String(index + 1).padStart(2, '0');
            const opt = document.createElement('option');
            // Value format MM-YYYY
            opt.value = `${monthNumber}-${selectedYear}`;
            // Text hanya nama bulan
            opt.textContent = nama;
            bulanSelect.appendChild(opt);
        });

        // Set default ke bulan saat ini jika tahun yang dipilih adalah tahun saat ini
        if (selectedYear == new Date().getFullYear()) {
            const now = new Date();
            const currentMonth = String(now.getMonth() + 1).padStart(2, '0');
            const currentValue = `${currentMonth}-${selectedYear}`;
            bulanSelect.value = currentValue;
        }
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

function fetchReport() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/data?period=bulanan`;

    if (bulan && tahun) {
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
        // Jika hanya tahun dipilih
        url += `&year=${tahun}`;
    }

    // Show loading
    const tbody = document.querySelector('#report-table tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="8">
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
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td><strong>${row.nama}</strong></td>
                        <td>${row.universitas}</td>
                        <td>${row.jurusan}</td>
                        <td>${row.nim}</td>
                        <td>${row.tanggal_mulai}</td>
                        <td>${row.tanggal_berakhir}</td>
                        <td>${row.divisi}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8">
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
                    <td colspan="8">
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

    window.location.href = url;
});

// Export Excel
document.getElementById('btn-export-excel').addEventListener('click', function() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/export/excel?period=bulanan`;

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

    window.location.href = url;
});
</script>
@endpush
