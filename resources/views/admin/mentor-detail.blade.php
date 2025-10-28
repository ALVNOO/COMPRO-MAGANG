@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#ee2e24] inline-block pb-1 pr-6">Detail Pembimbing</h2>
        <p class="text-sm text-[#000000]">Informasi lengkap pembimbing dan peserta yang dibimbing</p>
    </div>

    <!-- Mentor Profile Card -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl animate-slide-up">
        <div class="border-b border-[#e3e3e0] px-6 py-4 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-[#000000]">{{ $mentor->divisi->vp ?? $mentor->name }}</h3>
                        <p class="text-[#706f6c]">{{ $mentor->divisi->name ?? '-' }}</p>
                        <p class="text-[#706f6c] text-sm">{{ $mentor->divisi->subDirektorat->name ?? '-' }} • {{ $mentor->divisi->subDirektorat->direktorat->name ?? '-' }}</p>
                        <p class="text-[#706f6c] text-sm mt-1">
                            <i class="fas fa-envelope"></i> {{ $mentor->email }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('admin.mentors') }}" class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-sm hover:bg-gray-200 transition text-sm font-medium">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pembimbing
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">Total Peserta Aktif</p>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $participants->where('status', 'accepted')->count() }}</p>
                    </div>
                    <div class="bg-blue-500 rounded-full p-3">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">Total Peserta Selesai</p>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ $participants->where('status', 'finished')->count() }}</p>
                    </div>
                    <div class="bg-green-500 rounded-full p-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-600 text-sm font-medium">Total Semua Peserta</p>
                        <p class="text-3xl font-bold text-purple-700 mt-2">{{ $participants->count() }}</p>
                    </div>
                    <div class="bg-purple-500 rounded-full p-3">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Table -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 animate-slide-up" style="animation-delay: 0.2s;">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center justify-between relative">
            <div>
                <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
                <i class="fas fa-list text-[#ee2e24]"></i>
                <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">Daftar Peserta Magang</h5>
            </div>
        </div>
        <div class="p-6">
            @if($participants->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700">No</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Nama Peserta</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">NIM</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Universitas</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Tanggal Mulai</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $index => $participant)
                                <tr class="border-b border-[#e3e3e0] hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <span class="font-medium">{{ $participant->user->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $participant->user->nim ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $participant->user->university ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($participant->status == 'accepted')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                <i class="fas fa-spinner fa-spin mr-1"></i> Aktif
                                            </span>
                                        @elseif($participant->status == 'finished')
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Selesai
                                            </span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                                {{ ucfirst($participant->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ $participant->start_date ? \Carbon\Carbon::parse($participant->start_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <button class="text-blue-600 hover:text-blue-800 transition" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox fa-4x text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Belum ada peserta magang yang dibimbing</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .animate-slide-up {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection
