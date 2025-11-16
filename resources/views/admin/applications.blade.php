@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Daftar Pengajuan Magang</h2>
        <p class="text-sm text-[#000000]">Kelola pengajuan magang dari peserta</p>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-file-alt text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Pengajuan Magang</h5>
        </div>
        <div class="overflow-x-auto">
            @if($applications->isEmpty())
                <div class="px-6 py-8 text-center text-[#706f6c]">Belum ada pengajuan magang.</div>
            @else
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Nama Lengkap</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">NIM</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Asal Kampus</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Jurusan</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No HP Aktif</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">NIK</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Bidang Peminatan</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Tanggal Mulai</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Tanggal Selesai</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Dokumen</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $index => $app)
                    <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-medium">{{ $app->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->nim ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->university ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->major ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->phone ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->ktp_number ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->fieldOfInterest->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d M Y') : '-' }}</td>
                        <td class="px-4 py-2">
                            <div class="d-flex flex-column gap-1">
                                @if($app->ktm_path)
                                    <a href="{{ asset('storage/' . $app->ktm_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">
                                        <i class="fas fa-file-pdf me-1"></i>KTM
                                    </a>
                                @endif
                                @if($app->good_behavior_path)
                                    <a href="{{ asset('storage/' . $app->good_behavior_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">
                                        <i class="fas fa-file-pdf me-1"></i>SBB
                                    </a>
                                @endif
                                @if($app->surat_permohonan_path)
                                    <a href="{{ asset('storage/' . $app->surat_permohonan_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">
                                        <i class="fas fa-file-pdf me-1"></i>PG
                                    </a>
                                @endif
                                @if($app->cv_path)
                                    <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">
                                        <i class="fas fa-file-pdf me-1"></i>CV
                                    </a>
                                @endif
                                @if(!$app->ktm_path && !$app->good_behavior_path && !$app->surat_permohonan_path && !$app->cv_path)
                                    <span class="text-[#706f6c]">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            @if($app->status === 'rejected')
                                <div class="text-danger">
                                    <i class="fas fa-times-circle me-1"></i>
                                    <small><strong>Ditolak:</strong> {{ $app->notes ?? 'Tidak ada alasan' }}</small>
                                </div>
                            @elseif($app->status === 'pending')
                                <!-- Button Aksi Awal -->
                                <div id="actionButtons{{ $app->id }}" class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.applications.approve', $app->id) }}" style="display:inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition" title="Diterima" onclick="return confirm('Apakah Anda yakin ingin menerima pengajuan ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition reject-btn" title="Ditolak" data-app-id="{{ $app->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- Form Alasan Penolakan (Hidden Awal) -->
                                <div id="rejectForm{{ $app->id }}" class="hidden">
                                    <form method="POST" action="{{ route('admin.applications.reject', $app->id) }}" class="space-y-2">
                                        @csrf
                                        <div>
                                            <label for="notes-{{ $app->id }}" class="block text-xs font-medium text-gray-700 mb-1">Alasan Penolakan (Opsional)</label>
                                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-red-500" id="notes-{{ $app->id }}" name="notes" rows="2"></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition text-sm font-medium">
                                                Tolak
                                            </button>
                                            <button type="button" class="px-3 py-1.5 bg-black text-white rounded hover:bg-gray-800 transition text-sm font-medium border-2 border-gray-800 shadow-sm cancel-reject-btn" data-app-id="{{ $app->id }}">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @elseif($app->status === 'accepted')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Diterima
                                </span>
                            @elseif($app->status === 'finished')
                                <span class="badge bg-primary">
                                    <i class="fas fa-check-double me-1"></i>Selesai
                                </span>
                            @else
                                <span class="text-[#706f6c]">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol Ditolak
    document.querySelectorAll('.reject-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const appId = this.getAttribute('data-app-id');
            document.getElementById('actionButtons' + appId).classList.add('hidden');
            document.getElementById('rejectForm' + appId).classList.remove('hidden');
        });
    });
    
    // Event listener untuk tombol Batal
    document.querySelectorAll('.cancel-reject-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const appId = this.getAttribute('data-app-id');
            document.getElementById('actionButtons' + appId).classList.remove('hidden');
            document.getElementById('rejectForm' + appId).classList.add('hidden');
            // Clear textarea
            const textarea = document.getElementById('notes-' + appId);
            if (textarea) {
                textarea.value = '';
            }
        });
    });
});
</script>
@endsection
