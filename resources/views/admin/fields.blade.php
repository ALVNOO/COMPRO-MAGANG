@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#ee2e24] inline-block pb-1 pr-6">Kelola Bidang Peminatan</h2>
        <p class="text-sm text-[#000000]">Kelola bidang peminatan untuk program magang</p>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center justify-between relative">
            <div>
                <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
                <i class="fas fa-tags text-[#ee2e24]"></i>
                <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">Bidang Peminatan</h5>
            </div>
            <a href="{{ route('admin.fields.create') }}" class="inline-block px-4 py-2 bg-[#ee2e24] text-white rounded-sm hover:bg-[#B91C1C] transition text-sm font-medium">
                <i class="fas fa-plus"></i> Tambah Bidang Peminatan
            </a>
        </div>
        <div class="p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bidang</th>
                                    <th>Deskripsi</th>
                                    <th>Icon</th>
                                    <th>Divisi</th>
                                    <th>Posisi</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th>Urutan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fields as $index => $field)
                                    <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 font-medium">
                                            <strong>{{ $field->name }}</strong>
                                        </td>
                                        <td class="px-4 py-2 text-[#706f6c] max-w-xs truncate">{{ $field->description }}</td>
                                        <td class="px-4 py-2">
                                            @if($field->icon)
                                                <i class="{{ $field->icon }}" style="color: {{ $field->color }}; font-size: 1.2rem;"></i>
                                            @else
                                                <span class="text-[#706f6c]">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">{{ $field->division_count }}</span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">{{ $field->position_count }}</span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">{{ $field->duration_months }} bln</span>
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($field->is_active)
                                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Aktif</span>
                                            @else
                                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">{{ $field->sort_order }}</span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.fields.edit', $field) }}" class="inline-block px-2 py-1 rounded-sm border border-yellow-600 text-yellow-600 font-medium hover:bg-yellow-600 hover:text-white transition text-xs" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.fields.toggle', $field) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="inline-block px-2 py-1 rounded-sm border border-{{ $field->is_active ? 'gray' : 'green' }}-600 text-{{ $field->is_active ? 'gray' : 'green' }}-600 font-medium hover:bg-{{ $field->is_active ? 'gray' : 'green' }}-600 hover:text-white transition text-xs" 
                                                            title="{{ $field->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas {{ $field->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.fields.delete', $field) }}" method="POST" class="inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang peminatan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-block px-2 py-1 rounded-sm border border-red-600 text-red-600 font-medium hover:bg-red-600 hover:text-white transition text-xs" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-8 text-[#706f6c]">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Belum ada bidang peminatan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
