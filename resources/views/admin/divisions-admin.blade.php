@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#ee2e24] inline-block pb-1 pr-6">Kelola Divisi</h2>
        <p class="text-sm text-[#000000]">Kelola divisi untuk program magang PT Telkom Indonesia</p>
    </div>

    {{-- TAMPILKAN FORM JIKA MODE CREATE ATAU EDIT --}}
    @if($view_mode == 'create' || $view_mode == 'edit')
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl p-8">
        <form method="POST" action="{{ $view_mode == 'create' ? route('admin.divisions.store') : route('admin.divisions.update', $division->id) }}">
            @csrf
            @if($view_mode == 'edit')
                @method('PUT')
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Divisi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="division_name" value="{{ old('division_name', $division->division_name ?? '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('division_name') border-red-500 @enderror"
                           placeholder="Contoh: IT & Digital" required>
                    @error('division_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Mentor <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="mentor_name" value="{{ old('mentor_name', $division->mentor_name ?? '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('mentor_name') border-red-500 @enderror"
                           placeholder="Contoh: Budi Santoso" required>
                    @error('mentor_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik_number" value="{{ old('nik_number', $division->nik_number ?? '') }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('nik_number') border-red-500 @enderror"
                           placeholder="16 digit NIK" maxlength="16" pattern="[0-9]{16}" required>
                    @error('nik_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Urutan Tampil
                    </label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $division->sort_order ?? 0) }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="0" min="0">
                </div>
            </div>
            
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $division->is_active ?? true) ? 'checked' : '' }} 
                           class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Aktifkan Divisi</span>
                </label>
            </div>
            
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.divisions.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-save"></i> {{ $view_mode == 'create' ? 'Simpan' : 'Update' }}
                </button>
            </div>
        </form>
    </div>

    {{-- TAMPILKAN TABEL JIKA MODE INDEX --}}
    @else
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center justify-between relative">
            <div>
                <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
                <i class="fas fa-sitemap text-[#ee2e24]"></i>
                <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">Data Divisi</h5>
            </div>
            <a href="{{ route('admin.divisions.create') }}" class="inline-block px-4 py-2 bg-[#ee2e24] text-white rounded-sm hover:bg-[#B91C1C] transition text-sm font-medium">
                <i class="fas fa-plus"></i> Tambah Divisi
            </a>
        </div>
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                        <tr>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">No</th>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">Nama Divisi</th>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">Nama Mentor</th>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">NIK</th>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">Status</th>
                            <th class="px-4 py-2 font-bold text-[#ee2e24]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisions as $index => $division)
                            <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                                <td class="px-4 py-2 font-bold">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-medium">{{ $division->division_name }}</td>
                                <td class="px-4 py-2 text-[#706f6c]">{{ $division->mentor_name }}</td>
                                <td class="px-4 py-2 text-[#706f6c] font-mono">{{ $division->nik_number }}</td>
                                <td class="px-4 py-2">
                                    @if($division->is_active)
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.divisions.edit', $division) }}" class="inline-block px-2 py-1 rounded-sm border border-yellow-600 text-yellow-600 hover:bg-yellow-600 hover:text-white transition text-xs" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.divisions.toggle', $division) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-block px-2 py-1 rounded-sm border border-{{ $division->is_active ? 'gray' : 'green' }}-600 text-{{ $division->is_active ? 'gray' : 'green' }}-600 hover:bg-{{ $division->is_active ? 'gray' : 'green' }}-600 hover:text-white transition text-xs" 
                                                    title="{{ $division->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas {{ $division->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i> {{ $division->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST" class="inline" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block px-2 py-1 rounded-sm border border-red-600 text-red-600 hover:bg-red-600 hover:text-white transition text-xs" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-[#706f6c]">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    Belum ada data divisi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @endif
</div>
@endsection