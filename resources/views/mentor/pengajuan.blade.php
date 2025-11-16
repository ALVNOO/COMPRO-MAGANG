@extends('layouts.mentor-dashboard')

@section('title', 'Pengajuan Magang')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Pengajuan Magang</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            @if($applications->isEmpty())
                <div class="alert alert-info">Belum ada pengajuan magang untuk divisi Anda.</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIM</th>
                            <th>Universitas</th>
                            <th>Jurusan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>No KTP</th>
                            <th>No HP</th>
                            <th>KTM</th>
                            <th>Surat Pengantar</th>
                            <th>Surat Penerimaan</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $i => $app)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $app->user->name ?? '-' }}</td>
                            <td>{{ $app->user->email ?? '-' }}</td>
                            <td>{{ $app->user->nim ?? '-' }}</td>
                            <td>{{ $app->user->university ?? '-' }}</td>
                            <td>{{ $app->user->major ?? '-' }}</td>
                            <td>{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $app->user->ktp_number ?? '-' }}</td>
                            <td>{{ $app->user->phone ?? '-' }}</td>
                            <td>
                                @if($app->user && $app->user->ktm)
                                    <a href="{{ asset('storage/' . $app->user->ktm) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat KTM</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($app->cover_letter_path)
                                    <a href="{{ asset('storage/' . $app->cover_letter_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Surat</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($app->acceptance_letter_path)
                                    <a href="{{ asset('storage/' . $app->acceptance_letter_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat Surat</a>
                                @elseif($app->cover_letter_path)
                                    <a href="{{ route('mentor.pengajuan.acceptance-letter.form', $app->id) }}" class="btn btn-sm btn-primary">Kirimkan Surat Penerimaan</a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Kirimkan Surat Penerimaan</button>
                                @endif
                            </td>
                            <td>
                                @if($app->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($app->status === 'accepted')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($app->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($app->status === 'postponed')
                                    <span class="badge bg-secondary">Ditunda</span>
                                @elseif($app->status === 'finished')
                                    <span class="badge bg-primary">Selesai</span>
                                @endif
                            </td>
                            <td>
                                @if($app->notes)
                                    <span class="text-muted">{{ $app->notes }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($app->status === 'pending' || $app->status === 'postponed')
                                    <div class="btn-group">
                                        <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}" style="display:inline">
                                            @csrf
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-success btn-sm" title="Terima"><i class="fas fa-check"></i></button>
                                        </form>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $app->id }}" title="Tolak"><i class="fas fa-times"></i></button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#tundaModal{{ $app->id }}" title="Tunda"><i class="fas fa-clock"></i></button>
                                    </div>
                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="tolakModal{{ $app->id }}" tabindex="-1" aria-labelledby="tolakModalLabel{{ $app->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="tolakModalLabel{{ $app->id }}">Alasan Penolakan</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <label for="notes-rejected-{{ $app->id }}" class="form-label">Alasan <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="notes-rejected-{{ $app->id }}" name="notes" required></textarea>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                              <button type="submit" class="btn btn-danger">Tolak</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- Modal Tunda -->
                                    <div class="modal fade" id="tundaModal{{ $app->id }}" tabindex="-1" aria-labelledby="tundaModalLabel{{ $app->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}">
                                            @csrf
                                            <input type="hidden" name="status" value="postponed">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="tundaModalLabel{{ $app->id }}">Alasan Penundaan</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="mb-3">
                                                <label for="notes-postponed-{{ $app->id }}" class="form-label">Alasan <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="notes-postponed-{{ $app->id }}" name="notes" required></textarea>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                              <button type="submit" class="btn btn-secondary">Tunda</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
