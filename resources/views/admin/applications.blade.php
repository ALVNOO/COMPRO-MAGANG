@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#ee2e24] inline-block pb-1 pr-6">Daftar Pengajuan Magang</h2>
        <p class="text-sm text-[#000000]">Kelola semua pengajuan magang dan kirim surat penerimaan via email</p>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
            <i class="fas fa-list text-[#ee2e24]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">Semua Pengajuan Magang</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">No</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Nama Peserta</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">KTM</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Surat Permohonan Magang</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Surat Penerimaan Magang</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Email</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">No HP</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Divisi</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Tanggal Pengajuan</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Start Date</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">End Date</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Status</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $i => $app)
                    <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                        <td class="px-4 py-2">{{ $i+1 }}</td>
                        <td class="px-4 py-2 font-medium">{{ $app->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            @if($app->user && $app->user->ktm)
                                <a href="{{ asset('storage/' . $app->user->ktm) }}" target="_blank" class="inline-block px-3 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-sm">Lihat KTM</a>
                            @else
                                <span class="text-[#706f6c]">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($app->cover_letter_path)
                                <a href="{{ asset('storage/' . $app->cover_letter_path) }}" target="_blank" class="inline-block px-3 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-sm">Lihat Surat</a>
                            @else
                                <span class="text-[#706f6c]">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($app->status === 'accepted')
                                @if($app->acceptance_letter_path)
                                    <span class="text-green-600 font-semibold">✓ Sudah Terkirim</span>
                                @else
                                    <span class="text-[#706f6c]">Belum Dikirim</span>
                                @endif
                            @else
                                <span class="text-[#706f6c]">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $app->user->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->phone ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->divisi->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->created_at ? $app->created_at->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">
                            @if($app->status === 'accepted')
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Accepted</span>
                            @elseif($app->status === 'rejected')
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Rejected</span>
                            @elseif($app->status === 'pending')
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($app->status === 'postponed')
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">Postponed</span>
                            @elseif($app->status === 'finished')
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">Finished</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#FFF2F2] text-[#B91C1C]">{{ ucfirst($app->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($app->status === 'accepted' && !$app->acceptance_letter_path)
                                <a href="{{ route('admin.applications.send-acceptance-letter', $app->id) }}" 
                                   onclick="return confirm('Apakah Anda yakin ingin mengirim surat penerimaan via email ke {{ $app->user->email ?? 'email' }}?')" 
                                   class="inline-block px-3 py-1 rounded-sm border border-green-600 text-green-600 font-medium hover:bg-green-600 hover:text-white transition text-sm">
                                    Kirim Surat Penerimaan
                                </a>
                            @elseif($app->status === 'accepted' && $app->acceptance_letter_path)
                                <span class="text-green-600 text-xs">✓ Surat sudah dikirim</span>
                            @else
                                <span class="text-[#706f6c]">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="13" class="text-center py-8 text-[#706f6c]">Tidak ada pengajuan magang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 