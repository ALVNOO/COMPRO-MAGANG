@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pengajuan Magang Belum Direspon</h2>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Bidang Peminatan</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Dokumen</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications->where('status', 'pending') as $i => $app)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $app->user->name ?? '-' }}</td>
                            <td>
                                @if($app->fieldOfInterest)
                                    <span class="badge bg-info">{{ $app->fieldOfInterest->name }}</span>
                                @else
                                    <span class="badge bg-secondary">Bidang Lainnya</span>
                                @endif
                            </td>
                            <td>{{ $app->user->email ?? '-' }}</td>
                            <td>{{ $app->user->phone ?? '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($app->ktm_path)
                                        <a href="{{ asset('storage/' . $app->ktm_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="KTM">KTM</a>
                                    @endif
                                    @if($app->surat_permohonan_path)
                                        <a href="{{ asset('storage/' . $app->surat_permohonan_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Surat Permohonan">SP</a>
                                    @endif
                                    @if($app->cv_path)
                                        <a href="{{ asset('storage/' . $app->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="CV">CV</a>
                                    @endif
                                    @if($app->good_behavior_path)
                                        <a href="{{ asset('storage/' . $app->good_behavior_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Surat Berperilaku Baik">SBB</a>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $app->created_at ? $app->created_at->format('d-m-Y') : '-' }}</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('admin.applications.approve', $app->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menerima pengajuan ini?')">
                                            <i class="fas fa-check"></i> Terima
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $app->id }}">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                                
                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $app->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Pengajuan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.applications.reject', $app->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="notes{{ $app->id }}" class="form-label">Alasan Penolakan (Opsional)</label>
                                                        <textarea class="form-control" id="notes{{ $app->id }}" name="notes" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center">Tidak ada pengajuan pending.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 