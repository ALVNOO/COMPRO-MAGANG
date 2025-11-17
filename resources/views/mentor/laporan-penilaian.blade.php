@extends('layouts.mentor-dashboard')

@section('title', 'Laporan Penilaian - Mentor Dashboard')

@section('styles')
<style>
    :root {
        --telkom-red: #EE2E24;
        --telkom-red-bright: #EE2B24;
        --telkom-red-pure: #F60000;
        --telkom-black: #000000;
        --telkom-gray: #AAA5A6;
        --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        --gradient-card: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        --shadow-soft: 0 10px 30px rgba(0,0,0,0.1);
        --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--telkom-black);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title::after {
        content: '';
        flex: 1;
        height: 4px;
        background: var(--gradient-primary);
        border-radius: 2px;
    }

    .page-subtitle {
        color: var(--telkom-gray);
        font-size: 0.95rem;
    }

    .filter-card {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }

    .filter-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .filter-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        color: var(--telkom-red);
        font-weight: 600;
        font-size: 1.1rem;
    }

    .filter-header i {
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--telkom-black);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid rgba(0,0,0,0.1);
        border-radius: 12px;
        font-size: 0.95rem;
        transition: var(--transition);
        background: white;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--telkom-red);
        box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
    }

    .report-card {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
        position: relative;
    }

    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .report-header {
        background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(246, 0, 0, 0.05) 100%);
        padding: 1.5rem 2rem;
        border-bottom: 2px solid rgba(238, 46, 36, 0.1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .report-header i {
        color: var(--telkom-red);
        font-size: 1.3rem;
    }

    .report-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--telkom-black);
        font-size: 1.2rem;
    }

    .table-container {
        overflow-x: auto;
        padding: 1.5rem 2rem;
    }

    .report-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
    }

    .report-table thead {
        background: linear-gradient(135deg, rgba(238, 46, 36, 0.08) 0%, rgba(246, 0, 0, 0.08) 100%);
    }

    .report-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        color: var(--telkom-red);
        border-bottom: 2px solid rgba(238, 46, 36, 0.2);
        white-space: nowrap;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .report-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: var(--telkom-black);
        vertical-align: middle;
    }

    .report-table tbody tr {
        transition: var(--transition);
    }

    .report-table tbody tr:hover {
        background: rgba(238, 46, 36, 0.03);
    }

    .report-table tbody tr:last-child td {
        border-bottom: none;
    }

    .empty-state {
        padding: 3rem 2rem;
        text-align: center;
        color: var(--telkom-gray);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .upload-form {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-input-wrapper {
        position: relative;
        flex: 1;
    }

    .file-input {
        width: 100%;
        padding: 0.5rem;
        border: 2px solid rgba(0,0,0,0.1);
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .file-input:focus {
        outline: none;
        border-color: var(--telkom-red);
    }

    .btn-upload {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(238, 46, 36, 0.3);
    }

    .btn-upload:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-download {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .file-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--telkom-gray);
        font-size: 0.85rem;
    }

    .file-status.has-file {
        color: #198754;
    }

    .file-status.has-file i {
        color: #198754;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .filter-card,
        .table-container {
            padding: 1rem;
        }

        .report-table {
            font-size: 0.8rem;
        }

        .report-table th,
        .report-table td {
            padding: 0.75rem 0.5rem;
        }

        .upload-form {
            flex-direction: column;
            align-items: stretch;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-chart-bar" style="color: var(--telkom-red);"></i>
            Laporan Penilaian Peserta Magang
        </h1>
        <p class="page-subtitle">Upload dan kelola laporan penilaian peserta magang berdasarkan periode</p>
    </div>
    
    <!-- Filter Controls -->
    <div class="filter-card">
        <div class="filter-header">
            <i class="fas fa-filter"></i>
            <span>Filter Laporan</span>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select id="tahun" class="form-select">
                        <option value="">Pilih Tahun</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select id="bulan" class="form-select">
                        <option value="">Pilih Bulan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Report Table -->
    <div class="report-card">
        <div class="report-header">
            <i class="fas fa-table"></i>
            <h5>Data Laporan Penilaian</h5>
        </div>
        <div class="table-container">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Upload Laporan PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <div>Tidak ada Data Peserta Magang</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
            alert('Gagal memuat data tahun. Silakan refresh halaman.');
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
            const tbody = document.querySelector('.report-table tbody');
            tbody.innerHTML = '';
            const data = res.data;
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td><strong>${row.nama}</strong></td>
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
                                <div class="file-status has-file mt-2">
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
                        <td colspan="3" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <div>Tidak ada Data Peserta Magang</div>
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching report:', error);
            alert('Gagal memuat data laporan.');
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

// Panggil saat load awal
loadTahun();
loadBulan();
setTimeout(fetchReport, 500);
</script>
@endsection
