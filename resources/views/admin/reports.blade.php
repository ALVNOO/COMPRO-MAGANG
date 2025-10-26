@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Laporan Peserta Magang</h2>
        <p class="text-sm text-[#000000]">Generate dan export laporan peserta magang berdasarkan periode</p>
    </div>
    
    <!-- Filter Controls -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-xl p-6 mb-6">
        <h5 class="text-lg font-bold text-[#B91C1C] mb-4 flex items-center gap-2">
            <i class="fas fa-filter"></i> Filter Laporan
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="group_by" class="block text-sm font-medium text-[#B91C1C] mb-2">Group By</label>
                <select id="group_by" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition">
                    <option value="direktorat">Direktorat</option>
                    <option value="subdirektorat">Sub Direktorat</option>
                    <option value="divisi">Divisi</option>
                </select>
            </div>
            <div>
                <label for="classification" class="block text-sm font-medium text-[#B91C1C] mb-2">Klasifikasi</label>
                <select id="classification" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition">
                    <option value="all">All</option>
                </select>
            </div>
            <div>
                <label for="period" class="block text-sm font-medium text-[#B91C1C] mb-2">Periode</label>
                <select id="period" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition">
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                    <option value="tahunan">Tahunan</option>
                </select>
            </div>
            <div>
                <label for="waktu_detail" class="block text-sm font-medium text-[#B91C1C] mb-2">Waktu</label>
                <select id="waktu_detail" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B91C1C] focus:border-[#B91C1C] transition"></select>
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
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Sub Direktorat</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Direktorat</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Predikat</th>
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
function loadClassifications() {
    const groupBy = document.getElementById('group_by').value;
    const select = document.getElementById('classification');
    select.innerHTML = '<option value="all">All</option>';
    fetch(`/admin/reports/classifications?group_by=${groupBy}`)
        .then(res => res.json())
        .then(res => {
            res.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.name;
                select.appendChild(opt);
            });
        });
}

function loadWaktuDetail() {
    const period = document.getElementById('period').value;
    const waktuSelect = document.getElementById('waktu_detail');
    waktuSelect.innerHTML = '';
    fetch(`/admin/reports/periods?period=${period}`)
        .then(res => res.json())
        .then(res => {
            res.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.value;
                opt.textContent = item.label;
                waktuSelect.appendChild(opt);
            });
        });
}

document.getElementById('group_by').addEventListener('change', function() {
    loadClassifications();
    fetchReport();
});
document.getElementById('classification').addEventListener('change', fetchReport);
document.getElementById('period').addEventListener('change', function() {
    loadWaktuDetail();
    fetchReport();
});
document.getElementById('waktu_detail').addEventListener('change', fetchReport);

function fetchReport() {
    const groupBy = document.getElementById('group_by').value;
    const period = document.getElementById('period').value;
    const classification = document.getElementById('classification').value;
    const waktu = document.getElementById('waktu_detail').value;
    let url = `/admin/reports/data?group_by=${groupBy}&period=${period}`;
    if (classification && classification !== 'all') {
        url += `&classification=${classification}`;
    }
    // Tambahkan filter waktu detail
    if (waktu) {
        if (period === 'tahunan') {
            url += `&year=${waktu}`;
        } else if (period === 'bulanan') {
            const [month, year] = waktu.split('-');
            url += `&year=${year}&month=${month}`;
        } else if (period === 'mingguan') {
            url += `&week=${waktu}`;
        }
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
                        <td>${row.subdirektorat}</td>
                        <td>${row.direktorat}</td>
                        <td>${row.predikat}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="11" class="text-center">Tidak ada Peserta Magang</td></tr>';
            }
        });
}

// Panggil saat load awal
loadClassifications();
loadWaktuDetail();
fetchReport();

// Export PDF
    document.getElementById('btn-export-pdf').addEventListener('click', function() {
        const groupBy = document.getElementById('group_by').value;
        const period = document.getElementById('period').value;
        const classification = document.getElementById('classification').value;
        let url = `/admin/reports/export/pdf?group_by=${groupBy}&period=${period}`;
        if (classification && classification !== 'all') {
            url += `&classification=${classification}`;
        }
        window.location.href = url;
    });
// Export Excel
    document.getElementById('btn-export-excel').addEventListener('click', function() {
        const groupBy = document.getElementById('group_by').value;
        const period = document.getElementById('period').value;
        const classification = document.getElementById('classification').value;
        let url = `/admin/reports/export/excel?group_by=${groupBy}&period=${period}`;
        if (classification && classification !== 'all') {
            url += `&classification=${classification}`;
        }
        window.location.href = url;
    });
</script>
@endpush 