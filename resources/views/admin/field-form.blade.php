@extends('layouts.admin')

@section('title', isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($field) ? 'Edit Bidang Peminatan' : 'Tambah Bidang Peminatan' }}
                    </h3>
                    <a href="{{ route('admin.fields') }}" class="btn btn-secondary float-end">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Bidang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $field->name ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="icon" class="form-label">Icon (FontAwesome)</label>
                                    <input type="text" class="form-control" id="icon" name="icon" 
                                           value="{{ old('icon', $field->icon ?? '') }}" 
                                           placeholder="fas fa-building">
                                    <small class="form-text text-muted">Contoh: fas fa-building, fas fa-laptop-code</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Warna</label>
                                    <input type="color" class="form-control form-control-color" id="color" name="color" 
                                           value="{{ old('color', $field->color ?? '#EE2E24') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                           value="{{ old('sort_order', $field->sort_order ?? 0) }}" min="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $field->description ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="division_count" class="form-label">Jumlah Divisi <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="division_count" name="division_count" 
                                           value="{{ old('division_count', $field->division_count ?? 0) }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="position_count" class="form-label">Jumlah Posisi <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="position_count" name="position_count" 
                                           value="{{ old('position_count', $field->position_count ?? 0) }}" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="duration_months" class="form-label">Durasi (Bulan) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="duration_months" name="duration_months" 
                                           value="{{ old('duration_months', $field->duration_months ?? 6) }}" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $field->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.fields') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($field) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Preview icon
document.getElementById('icon').addEventListener('input', function() {
    const iconValue = this.value;
    const preview = document.getElementById('icon-preview');
    
    if (preview) {
        preview.className = iconValue || 'fas fa-question';
    }
});

// Add icon preview if not exists
if (!document.getElementById('icon-preview')) {
    const iconInput = document.getElementById('icon');
    const preview = document.createElement('div');
    preview.id = 'icon-preview';
    preview.className = iconInput.value || 'fas fa-question';
    preview.style.fontSize = '1.5rem';
    preview.style.marginTop = '5px';
    preview.style.color = document.getElementById('color').value;
    iconInput.parentNode.appendChild(preview);
}

// Update preview color when color changes
document.getElementById('color').addEventListener('input', function() {
    const preview = document.getElementById('icon-preview');
    if (preview) {
        preview.style.color = this.value;
    }
});
</script>
@endsection
