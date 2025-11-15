@extends('layouts.admin-dashboard')

@section('admin-content')
<div x-data="{ showEditModal: false, showRuleContent: true }" @keydown.escape.window="showEditModal = false" class="space-y-8 relative">
    <!-- Decorative SVG Pattern BG -->
    <svg class="absolute right-0 top-0 opacity-10 w-80 h-80 z-0 pointer-events-none" viewBox="0 0 320 320" fill="none"><ellipse cx="160" cy="160" rx="160" ry="160" fill="url(#paint-red)"/><defs><radialGradient id="paint-red" cx="0" cy="0" r="1" gradientTransform="translate(160 160) scale(180 160)" gradientUnits="userSpaceOnUse"><stop stop-color="#B91C1C"/><stop offset="1" stop-color="#fff" stop-opacity="0"/></radialGradient></defs></svg>
    <div class="mb-6 relative z-10 mt-8">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#ee2e24] inline-block pb-1 pr-6">Welcome, Admin!</h2>
        <p class="text-sm text-[#000000]">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12 relative z-10">
        <div class="bg-white border border-[#e3e3e0] rounded-lg p-6 flex flex-col items-start shadow-2xl relative transform transition-all duration-300 hover:scale-105 hover:shadow-3xl hover:-translate-y-1">
            <span class="w-12 h-12 bg-[#ee2e24] text-white flex items-center justify-center rounded-full mb-2 shadow-lg animate-pulse"><i class="fas fa-users text-2xl"></i></span>
            <div class="flex items-center gap-2 text-[#ee2e24] text-lg font-bold mb-2">Total Peserta Magang</div>
            <div class="text-4xl font-bold">{{ $totalParticipants }}</div>
        </div>
        <div class="bg-white border border-[#e3e3e0] rounded-lg p-6 flex flex-col items-start shadow-2xl relative transform transition-all duration-300 hover:scale-105 hover:shadow-3xl hover:-translate-y-1">
            <span class="w-12 h-12 bg-white border-2 border-[#ee2e24] text-[#ee2e24] flex items-center justify-center rounded-full mb-2 shadow-lg animate-pulse"><i class="fas fa-envelope-open-text text-2xl"></i></span>
            <div class="flex items-center gap-2 text-[#B91C1C] text-lg font-bold mb-2">Total Pengajuan Magang</div>
            <div class="text-4xl font-bold">{{ $totalApplications }}</div>
        </div>
        <div class="bg-white border border-[#e3e3e0] rounded-lg p-6 flex flex-col items-start shadow-2xl relative transform transition-all duration-300 hover:scale-105 hover:shadow-3xl hover:-translate-y-1">
            <span class="w-12 h-12 bg-white border-2 border-[#ee2e24] text-[#ee2e24] flex items-center justify-center rounded-full mb-2 shadow-lg animate-pulse"><i class="fas fa-check-circle text-2xl"></i></span>
            <div class="flex items-center gap-2 text-[#ee2e24] text-lg font-bold mb-2">Total Peserta Selesai</div>
            <div class="text-4xl font-bold">{{ $totalFinishedParticipants }}</div>
        </div>
    </div>
    <!-- Tabel Pengajuan Terbaru -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 mb-12 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
            <i class="fas fa-clock text-[#ee2e24]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">Pengajuan Magang Terbaru</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">#</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Nama Peserta</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Divisi</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Status</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Tanggal Pengajuan</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">Start Date</th>
                        <th class="px-4 py-2 font-bold text-[#ee2e24]">End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentApplications as $i => $app)
                    <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0]">
                        <td class="px-4 py-2">{{ $i+1 }}</td>
                        <td class="px-4 py-2">{{ $app->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $app->divisi->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                @if($app->status=='finished') bg-[#ee2e24] text-white
                                @elseif($app->status=='accepted') bg-[#DCFCE7] text-[#15803D]
                                @elseif($app->status=='rejected') bg-[#FEE2E2] text-[#DC2626]
                                @else bg-[#E5E7EB] text-[#6B7280]
                                @endif
                            ">
                              {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $app->created_at->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                        <td class="px-4 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-[#706f6c]">Belum ada pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Peraturan -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 mb-12 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center justify-between relative">
            <span class="flex items-center gap-2 text-lg font-bold text-[#ee2e24]"><i class="fas fa-gavel"></i> Peraturan Saat Ini</span>
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
            <div class="flex items-center gap-2">
                <!-- Dropdown Toggle Button (Buka/Tutup Peraturan) -->
                <button type="button" class="px-4 py-2 border border-[#e3e3e0] rounded-sm bg-white text-[#ee2e24] font-bold hover:bg-[#FFF2F2] transition text-sm flex items-center gap-2" @click="showRuleContent = !showRuleContent">
                    <i class="fas" :class="showRuleContent ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                    <span x-text="showRuleContent ? 'Tutup' : 'Buka'"></span>
                </button>
                <!-- Edit Button -->
                <button type="button" class="px-4 py-2 border border-[#e3e3e0] rounded-sm bg-[#ee2e24] text-white font-bold hover:bg-[#991B1B] transition text-sm" @click="showEditModal = true">
                    <i class="fas fa-pen mr-1"></i> Edit Peraturan
                </button>
            </div>
        </div>
        <div class="px-6 py-5" x-show="showRuleContent" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 max-h-screen" x-transition:leave-end="opacity-0 max-h-0">
            @if($rule && $rule->content)
                <div class="whitespace-pre-line">{!! nl2br(e($rule->content)) !!}</div>
            @else
                <span class="text-[#706f6c]">Belum ada peraturan yang ditetapkan.</span>
            @endif
        </div>
    </div>
    
    <!-- Modal Native Tailwind+Alpine -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;" aria-modal="true" role="dialog" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black opacity-30" @click="showEditModal = false"></div>
        <!-- Modal Box -->
        <div class="relative w-full max-w-lg bg-[#FDFDFC] border border-[#e3e3e0] rounded-lg shadow-lg mx-4">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#e3e3e0]">
                <h5 class="text-lg font-bold text-[#ee2e24] flex items-center gap-2"><i class="fas fa-gavel"></i>Edit Peraturan</h5>
                <button class="text-[#1b1b18] px-2 py-1 hover:bg-[#dbdbd7] rounded transition" @click="showEditModal = false" aria-label="Tutup">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.rules.update') }}">
                @csrf
                <div class="p-6">
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-bold text-[#ee2e24] mb-2">Isi Peraturan</label>
                        <textarea name="content" id="content" class="block w-full border border-[#e3e3e0] rounded-sm text-base px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#ee2e24] focus:border-[#ee2e24] transition" rows="8" required>{{ old('content', $rule ? $rule->content : '') }}</textarea>
                        @error('content')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-3 px-6 pb-6">
                    <button type="button" class="px-4 py-2 rounded-sm border border-[#e3e3e0] bg-white text-[#ee2e24] font-bold hover:bg-[#FFF2F2] transition" @click="showEditModal = false">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-sm bg-[#ee2e24] text-white font-bold border border-transparent hover:bg-[#991B1B] transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal -->
</div>
@endsection 