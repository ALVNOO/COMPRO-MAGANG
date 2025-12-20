@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Laporan Peserta Magang</h2>
        <p class="text-sm text-[#000000]">Generate dan export laporan peserta magang berdasarkan periode</p>
    </div>
    
    <!-- Filter Controls -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-xl p-6 mb-6">
        <h5 class="text-lg font-bold text-[#B91C1C] mb-4 flex items-center gap-2">
            <i class="fas fa-filter"></i> Filter Laporan
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="tahun" class="block text-sm font-medium text-[#B91C1C] mb-2">Tahun</label>
                <select id="tahun" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition">
                    <option value="">Pilih Tahun</option>
                </select>
            </div>
            <div>
                <label for="bulan" class="block text-sm font-medium text-[#B91C1C] mb-2">Bulan</label>
                <select id="bulan" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition">
                    <option value="">Pilih Bulan</option>
                </select>
            </div>
        </div>
        
        <!-- Export Buttons -->
        <div class="mt-6 flex gap-3">
            <button id="btn-export-pdf" class="px-4 py-2 rounded-sm bg-red-600 text-white font-bold border border-transparent hover:bg-red-700 transition flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <button id="btn-export-excel" class="px-4 py-2 rounded-sm bg-green-600 text-white font-bold border border-transparent hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>
    
    <!-- Report Table -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-chart-bar text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Laporan</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left" id="report-table">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Nama Peserta</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Universitas/Sekolah</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Jurusan</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">NIM</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Tanggal Mulai</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Tanggal Berakhir</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Divisi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diisi via JS -->
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
            alert('Gagal memuat data tahun. Silakan refresh halaman.');
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
                alert('Gagal memuat data bulan. Silakan refresh halaman.');
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
    
    fetch(url)
        .then(res => res.json())
        .then(res => {
            const tbody = document.querySelector('#report-table tbody');
            tbody.innerHTML = '';
            const data = res.data;
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td>${row.nama}</td>
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
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">Tidak ada Peserta Magang</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching report:', error);
            alert('Gagal memuat data laporan.');
        });
}

// Panggil saat load awal
loadTahun();
loadBulan();

// Export PDF
document.getElementById('btn-export-pdf').addEventListener('click', function() {
    const tahun = document.getElementById('tahun').value;
    const bulan = document.getElementById('bulan').value;
    let url = `/admin/reports/export/pdf?period=bulanan`;
    
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
        url += `&year=${tahun}`;
    }
    
    window.location.href = url;
});
</script>
@endpush 