@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Daftar Pengajuan Magang Belum Direspon</h2>
        <p class="text-sm text-[#000000]">Kelola pengajuan magang yang masih menunggu persetujuan</p>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-inbox text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Pengajuan Pending</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Nama Peserta</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">KTM</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Email</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No HP</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Divisi</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Tanggal Pengajuan</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Start Date</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">End Date</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications->where('status', 'pending') as $i => $app)
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
                        <td class="px-4 py-2">{{ $app->user->email ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->user->phone ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->divisi->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->created_at ? $app->created_at->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-[#FFF2F2] text-[#B91C1C]">Pending</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center py-8 text-[#706f6c]">Tidak ada pengajuan pending.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 