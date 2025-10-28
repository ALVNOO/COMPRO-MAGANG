@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center justify-between relative">
            <div>
                <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#ee2e24] via-[#ee2e24] to-[#ee2e24] rounded opacity-60"></div>
                <i class="fas fa-tags text-[#ee2e24]"></i>
                <h5 class="text-lg font-bold mb-0 text-[#ee2e24]">{{ isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan' }}</h5>
            </div>
            <a href="{{ route('admin.fields') }}" class="text-[#706f6c] hover:text-[#ee2e24] transition text-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="p-6">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($field) ? route('admin.fields.update', $field) : route('admin.fields.store') }}" method="POST">
                @csrf
                @if(isset($field))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Bidang <span class="text-red-600">*</span></label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="name" name="name" 
                               value="{{ old('name', $field->name ?? '') }}" required>
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon <span class="text-red-600">*</span></label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="icon" name="icon" required>
                            <option value="">Pilih Icon</option>
                            <option value="fas fa-building" {{ old('icon', $field->icon ?? '') == 'fas fa-building' ? 'selected' : '' }}>
                                🏢 Building (Administration)
                            </option>
                            <option value="fas fa-calculator" {{ old('icon', $field->icon ?? '') == 'fas fa-calculator' ? 'selected' : '' }}>
                                🧮 Calculator (Finance)
                            </option>
                            <option value="fas fa-user-tie" {{ old('icon', $field->icon ?? '') == 'fas fa-user-tie' ? 'selected' : '' }}>
                                👔 User Tie (Human Capital)
                            </option>
                            <option value="fas fa-chart-line" {{ old('icon', $field->icon ?? '') == 'fas fa-chart-line' ? 'selected' : '' }}>
                                📈 Chart Line (Digital Business)
                            </option>
                            <option value="fas fa-bullhorn" {{ old('icon', $field->icon ?? '') == 'fas fa-bullhorn' ? 'selected' : '' }}>
                                📢 Bullhorn (Marketing)
                            </option>
                            <option value="fas fa-headset" {{ old('icon', $field->icon ?? '') == 'fas fa-headset' ? 'selected' : '' }}>
                                🎧 Headset (Customer Service)
                            </option>
                            <option value="fas fa-gavel" {{ old('icon', $field->icon ?? '') == 'fas fa-gavel' ? 'selected' : '' }}>
                                ⚖️ Gavel (Legal)
                            </option>
                            <option value="fas fa-laptop-code" {{ old('icon', $field->icon ?? '') == 'fas fa-laptop-code' ? 'selected' : '' }}>
                                💻 Laptop Code (IT)
                            </option>
                            <option value="fas fa-palette" {{ old('icon', $field->icon ?? '') == 'fas fa-palette' ? 'selected' : '' }}>
                                🎨 Palette (Design)
                            </option>
                            <option value="fas fa-chart-bar" {{ old('icon', $field->icon ?? '') == 'fas fa-chart-bar' ? 'selected' : '' }}>
                                📊 Chart Bar (Analytics)
                            </option>
                            <option value="fas fa-broadcast-tower" {{ old('icon', $field->icon ?? '') == 'fas fa-broadcast-tower' ? 'selected' : '' }}>
                                📡 Broadcast Tower (Telecom)
                            </option>
                            <option value="fas fa-folder-open" {{ old('icon', $field->icon ?? '') == 'fas fa-folder-open' ? 'selected' : '' }}>
                                📁 Folder (Collection)
                            </option>
                            <option value="fas fa-cubes" {{ old('icon', $field->icon ?? '') == 'fas fa-cubes' ? 'selected' : '' }}>
                                🧊 Cubes (Asset)
                            </option>
                            <option value="fas fa-hands-helping" {{ old('icon', $field->icon ?? '') == 'fas fa-hands-helping' ? 'selected' : '' }}>
                                🤝 Hands Helping (CSR)
                            </option>
                            <option value="fas fa-database" {{ old('icon', $field->icon ?? '') == 'fas fa-database' ? 'selected' : '' }}>
                                💾 Database
                            </option>
                            <option value="fas fa-network-wired" {{ old('icon', $field->icon ?? '') == 'fas fa-network-wired' ? 'selected' : '' }}>
                                🔗 Network Wired
                            </option>
                            <option value="fas fa-shield-alt" {{ old('icon', $field->icon ?? '') == 'fas fa-shield-alt' ? 'selected' : '' }}>
                                🛡️ Shield (Security)
                            </option>
                            <option value="fas fa-project-diagram" {{ old('icon', $field->icon ?? '') == 'fas fa-project-diagram' ? 'selected' : '' }}>
                                🔀 Project Diagram
                            </option>
                            <option value="fas fa-cloud" {{ old('icon', $field->icon ?? '') == 'fas fa-cloud' ? 'selected' : '' }}>
                                ☁️ Cloud
                            </option>
                        </select>
                        <small class="text-xs text-gray-500 mt-1 block">Pilih icon yang sesuai dengan bidang peminatan</small>
                        <div id="icon-preview" class="mt-2"></div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Warna</label>
                        <input type="color" class="w-full h-10 border border-gray-300 rounded-sm cursor-pointer" id="color" name="color" 
                               value="{{ old('color', $field->color ?? '#EE2E24') }}">
                    </div>
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil <span class="text-red-600">*</span></label>
                        <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="sort_order" name="sort_order" 
                               value="{{ old('sort_order', $field->sort_order ?? 0) }}" min="0" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-600">*</span></label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="description" name="description" rows="4" required>{{ old('description', $field->description ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="division_count" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Divisi <span class="text-red-600">*</span></label>
                        <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="division_count" name="division_count" 
                               value="{{ old('division_count', $field->division_count ?? 0) }}" min="0" required>
                    </div>
                    <div>
                        <label for="position_count" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Posisi <span class="text-red-600">*</span></label>
                        <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="position_count" name="position_count" 
                               value="{{ old('position_count', $field->position_count ?? 0) }}" min="0" required>
                    </div>
                    <div>
                        <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-2">Durasi (Bulan) <span class="text-red-600">*</span></label>
                        <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-sm focus:ring-2 focus:ring-[#ee2e24] focus:border-transparent" id="duration_months" name="duration_months" 
                               value="{{ old('duration_months', $field->duration_months ?? 6) }}" min="1" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="w-5 h-5 border-gray-300 rounded text-[#ee2e24] focus:ring-2 focus:ring-[#ee2e24]" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $field->is_active ?? true) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.fields') }}" class="px-6 py-2 border border-gray-300 rounded-sm text-gray-700 hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-[#ee2e24] text-white rounded-sm hover:bg-[#B91C1C] transition">
                        <i class="fas fa-save"></i> {{ isset($field) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview icon function
function updateIconPreview() {
    const iconValue = document.getElementById('icon').value;
    const preview = document.getElementById('icon-preview');
    const color = document.getElementById('color').value;
    
    if (preview && iconValue) {
        preview.innerHTML = '<i class="' + iconValue + ' text-2xl" style="color: ' + color + '"></i>';
    } else {
        preview.innerHTML = '';
    }
}

// Preview icon on change
document.getElementById('icon').addEventListener('change', function() {
    updateIconPreview();
});

// Initialize icon preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updateIconPreview();
});

// Update preview color when color changes
document.getElementById('color').addEventListener('input', function() {
    updateIconPreview();
});
</script>
@endsection
