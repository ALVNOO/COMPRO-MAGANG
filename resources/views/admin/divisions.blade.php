@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold mb-1 text-[#B91C1C] border-b-4 border-[#000000] inline-block pb-1 pr-6">Kelola Direktorat, Subdirektorat, dan Divisi</h2>
            <p class="text-sm text-[#000000]">Kelola struktur organisasi dan divisi perusahaan</p>
        </div>
        <button class="px-4 py-2 rounded-sm bg-[#B91C1C] text-white font-bold border border-transparent hover:bg-[#991B1B] transition flex items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDirektoratModal">
            <i class="fas fa-plus"></i>Tambah Direktorat
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="accordion" id="direktoratAccordion">
                @foreach($direktorats as $direktorat)
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="headingDirektorat{{ $direktorat->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirektorat{{ $direktorat->id }}" aria-expanded="false" aria-controls="collapseDirektorat{{ $direktorat->id }}">
                            {{ $direktorat->name }}
                        </button>
                    </h2>
                    <div id="collapseDirektorat{{ $direktorat->id }}" class="accordion-collapse collapse" aria-labelledby="headingDirektorat{{ $direktorat->id }}" data-bs-parent="#direktoratAccordion">
                        <div class="accordion-body">
                            <div class="d-flex mb-2">
                                <button class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#addSubdirektoratModal{{ $direktorat->id }}">Tambah Subdirektorat</button>
                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editDirektoratModal{{ $direktorat->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('Direktorat', '{{ $direktorat->name }}', '{{ route('admin.direktorat.delete', $direktorat->id) }}')">Hapus</button>
                            </div>
                            <div class="accordion" id="subdirektoratAccordion{{ $direktorat->id }}">
                                @foreach($direktorat->subDirektorats as $sub)
                                <div class="accordion-item mb-2">
                                    <h2 class="accordion-header" id="headingSub{{ $sub->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSub{{ $sub->id }}" aria-expanded="false" aria-controls="collapseSub{{ $sub->id }}">
                                            {{ $sub->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseSub{{ $sub->id }}" class="accordion-collapse collapse" aria-labelledby="headingSub{{ $sub->id }}" data-bs-parent="#subdirektoratAccordion{{ $direktorat->id }}">
                                        <div class="accordion-body">
                                            <div class="d-flex mb-2">
                                                <button class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#addDivisiModal{{ $sub->id }}">Tambah Divisi</button>
                                                <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editSubdirektoratModal{{ $sub->id }}">Edit</button>
                                                                                <button class="btn btn-sm btn-danger" onclick="confirmDelete('Subdirektorat', '{{ $sub->name }}', '{{ route('admin.subdirektorat.delete', $sub->id) }}')">Hapus</button>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Divisi</th>
                                                        <th>VP</th>
                                                        <th>NIPPOS</th>
                                                        <th>Akun Pembimbing</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sub->divisis as $divisi)
                                                    <tr>
                                                        <td>{{ $divisi->name }}</td>
                                                        <td>{{ $divisi->vp }}</td>
                                                        <td>{{ $divisi->nippos }}</td>
                                                        <td>
                                                            @php
                                                                $pembimbing = \App\Models\User::where('divisi_id', $divisi->id)
                                                                                            ->where('role', 'pembimbing')
                                                                                            ->first();
                                                            @endphp
                                                            @if($pembimbing)
                                                                <div>
                                                                    <span class="badge bg-success">{{ $pembimbing->username }}</span>
                                                                    <small class="d-block text-muted mt-1">
                                                                        <strong>Password:</strong> mentor123<br>
                                                                        <strong>Email:</strong> {{ $pembimbing->email }}
                                                                    </small>
                                                                </div>
                                                            @else
                                                                <span class="badge bg-warning">Belum ada pembimbing</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editDivisiModal{{ $divisi->id }}">Edit</button>
                                                            <button class="btn btn-sm btn-danger" onclick="confirmDelete('Divisi', '{{ $divisi->name }}', '{{ route('admin.divisi.delete', $divisi->id) }}')">Hapus</button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal Tambah Direktorat --}}
    <div class="modal fade" id="addDirektoratModal" tabindex="-1" aria-labelledby="addDirektoratModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDirektoratModalLabel">Tambah Direktorat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.direktorat.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Direktorat</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Direktorat --}}
    @foreach($direktorats as $direktorat)
    <div class="modal fade" id="editDirektoratModal{{ $direktorat->id }}" tabindex="-1" aria-labelledby="editDirektoratModalLabel{{ $direktorat->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDirektoratModalLabel{{ $direktorat->id }}">Edit Direktorat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.direktorat.update', $direktorat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name{{ $direktorat->id }}" class="form-label">Nama Direktorat</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ $direktorat->id }}" name="name" value="{{ old('name', $direktorat->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Subdirektorat --}}
    <div class="modal fade" id="addSubdirektoratModal{{ $direktorat->id }}" tabindex="-1" aria-labelledby="addSubdirektoratModalLabel{{ $direktorat->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubdirektoratModalLabel{{ $direktorat->id }}">Tambah Subdirektorat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.subdirektorat.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                                                    <div class="mb-3">
                                <label for="name_sub{{ $direktorat->id }}" class="form-label">Nama Subdirektorat</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_sub{{ $direktorat->id }}" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        <input type="hidden" name="direktorat_id" value="{{ $direktorat->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Modal Edit Subdirektorat --}}
    @foreach($direktorats as $direktorat)
        @foreach($direktorat->subDirektorats as $sub)
        <div class="modal fade" id="editSubdirektoratModal{{ $sub->id }}" tabindex="-1" aria-labelledby="editSubdirektoratModalLabel{{ $sub->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSubdirektoratModalLabel{{ $sub->id }}">Edit Subdirektorat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.subdirektorat.update', $sub->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Anda hanya dapat mengedit nama subdirektorat.
                            </div>
                            <div class="mb-3">
                                <label for="name{{ $sub->id }}" class="form-label">Nama Subdirektorat</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ $sub->id }}" name="name" value="{{ old('name', $sub->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="direktorat_id" value="{{ $sub->direktorat_id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Divisi --}}
        <div class="modal fade" id="addDivisiModal{{ $sub->id }}" tabindex="-1" aria-labelledby="addDivisiModalLabel{{ $sub->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDivisiModalLabel{{ $sub->id }}">Tambah Divisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.divisi.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> User pembimbing akan dibuat otomatis dengan:<br>
                                • Username: mentor_[nama_divisi]<br>
                                • Password: mentor123<br>
                                • Email: username@posindonesia.co.id
                            </div>
                            <div class="mb-3">
                                <label for="name_div{{ $sub->id }}" class="form-label">Nama Divisi</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_div{{ $sub->id }}" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                                        <label for="vp_div{{ $sub->id }}" class="form-label">Nama VP</label>
                        <input type="text" class="form-control @error('vp') is-invalid @enderror" id="vp_div{{ $sub->id }}" name="vp" value="{{ old('vp') }}" required>
                        @error('vp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="nippos_div{{ $sub->id }}" class="form-label">NIPPOS</label>
                                <input type="text" class="form-control @error('nippos') is-invalid @enderror" id="nippos_div{{ $sub->id }}" name="nippos" value="{{ old('nippos') }}" required>
                                @error('nippos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <input type="hidden" name="sub_direktorat_id" value="{{ $sub->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach

    {{-- Modal Edit Divisi --}}
    @foreach($direktorats as $direktorat)
        @foreach($direktorat->subDirektorats as $sub)
            @foreach($sub->divisis as $divisi)
            <div class="modal fade" id="editDivisiModal{{ $divisi->id }}" tabindex="-1" aria-labelledby="editDivisiModalLabel{{ $divisi->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDivisiModalLabel{{ $divisi->id }}">Edit Divisi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <form action="{{ route('admin.divisi.update', $divisi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Info:</strong> Anda hanya dapat mengedit informasi divisi.
                            </div>
                                <div class="mb-3">
                                    <label for="name{{ $divisi->id }}" class="form-label">Nama Divisi</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name{{ $divisi->id }}" name="name" value="{{ old('name', $divisi->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="vp{{ $divisi->id }}" class="form-label">Nama VP</label>
                                    <input type="text" class="form-control @error('vp') is-invalid @enderror" id="vp{{ $divisi->id }}" name="vp" value="{{ old('vp', $divisi->vp) }}" required>
                                    @error('vp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nippos{{ $divisi->id }}" class="form-label">NIPPOS</label>
                                    <input type="text" class="form-control @error('nippos') is-invalid @enderror" id="nippos{{ $divisi->id }}" name="nippos" value="{{ old('nippos', $divisi->nippos) }}" required>
                                    @error('nippos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <input type="hidden" name="sub_direktorat_id" value="{{ $divisi->sub_direktorat_id }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            @endforeach
        @endforeach
    @endforeach
</div>



@endsection

@push('scripts')
<script>
    // Function to confirm delete
    function confirmDelete(type, name, url) {
        if (confirm('Apakah anda yakin menghapus ' + type + ' "' + name + '" ini?')) {
            // Create and submit form
            var form = $('<form>', {
                'method': 'POST',
                'action': url,
                'style': 'display: none;'
            });
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{ csrf_token() }}'
            }));
            
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_method',
                'value': 'DELETE'
            }));
            
            $('body').append(form);
            form.submit();
        }
    }
</script>
@endpush 