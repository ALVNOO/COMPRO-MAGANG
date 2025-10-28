@extends('layouts.admin-dashboard')

@php
use Carbon\Carbon;
@endphp

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Monitoring Pembimbing Lapangan</h2>
        <p class="text-sm text-[#000000]">Pantau kinerja pembimbing dan peserta magang</p>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-user-tie text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Pembimbing dan Peserta Magang</h5>
        </div>
                    @if($mentors->count() > 0)
                        <div class="table-responsive" style="overflow-x:auto; max-width:1100px; margin:auto;">
                            <table class="table table-bordered table-hover" style="min-width:900px;">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle text-center" style="min-width:50px">No</th>
                                        <th class="align-middle text-center" style="min-width:180px">Nama Pembimbing</th>
                                        <th class="align-middle text-center" style="min-width:200px">Email</th>
                                        <th class="align-middle text-center" style="min-width:70px">Peserta Magang</th>
                                        <th class="align-middle text-center" style="min-width:120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mentors as $mentor)
                                    @php
                                        $divisi = $mentor->divisi;
                                        $participant = $divisi ? $divisi->internshipApplications->whereIn('status', ['accepted', 'finished'])->filter(function($p) {
                                            return !$p->end_date || \Carbon\Carbon::parse($p->end_date)->gte(now());
                                        }) : collect();
                                        $participantCount = $participant->count();
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-start">{{ $loop->iteration + ($mentors->currentPage() - 1) * $mentors->perPage() }}</td>
                                        <td class="align-middle text-start">
                                            <a href="{{ route('admin.mentor.detail', $mentor->id) }}">
                                                <strong>{{ $mentor->divisi->vp ?? '-' }}</strong>
                                            </a>
                                        </td>
                                        <td class="align-middle text-start">{{ $mentor->email }}</td>
                                        <td class="align-middle text-center"><span class="badge bg-success">{{ $participantCount }}</span></td>
                                        <td class="align-middle text-start">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#resetPasswordModal{{ $mentor->id }}">
                                                <i class="fas fa-key me-1"></i>Reset Password
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination navigation -->
                        <div class="my-4 flex justify-center">
                          {{ $mentors->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada pembimbing lapangan</h5>
                            <p class="text-muted">Pembimbing akan dibuat otomatis ketika Anda menambahkan divisi baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Penting
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user-plus me-2"></i>Pembuatan Otomatis</h6>
                            <ul class="list-unstyled">
                                <li>• User pembimbing dibuat otomatis saat menambah divisi baru</li>
                                <li>• Username: mentor_[nama_divisi]</li>
                                <li>• Password default: mentor123</li>
                                <li>• Email: username@posindonesia.co.id</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-shield-alt me-2"></i>Keamanan</h6>
                            <ul class="list-unstyled">
                                <li>• Pembimbing harus mengubah password saat login pertama</li>
                                <li>• Password dapat direset oleh admin</li>
                                <li>• Akses terbatas hanya ke divisi masing-masing</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-info-circle me-2"></i>Keterangan Status</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i>Tugas dikumpulkan</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tugas belum dikumpulkan</li>
                                        <li><i class="fas fa-star text-success me-2"></i>Sudah dinilai</li>
                                        <li><i class="fas fa-clock text-warning me-2"></i>Belum dinilai</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-certificate text-success me-2"></i>Lihat sertifikat peserta</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tidak ada sertifikat</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Tidak ada tugas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modals -->
@foreach($mentors as $mentor)
<div class="modal fade" id="resetPasswordModal{{ $mentor->id }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $mentor->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel{{ $mentor->id }}">Reset Password Pembimbing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.mentor.reset-password', $mentor->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Password akan direset menjadi "mentor123"
                    </div>
                    <p>Reset password untuk pembimbing: <strong>{{ $mentor->name }}</strong></p>
                    <p>Username: <code>{{ $mentor->username }}</code></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Certificate Detail Modals -->
@foreach($mentors as $mentor)
    @php
        $divisi = $mentor->divisi;
        $participants = $divisi ? $divisi->internshipApplications->whereIn('status', ['accepted', 'finished']) : collect();
    @endphp
    @foreach($participants as $participant)
        @if($participant->user->certificates->count() > 0)
            @php
                $certificate = $participant->user->certificates->first();
            @endphp
            <div class="modal fade" id="certificateModal{{ $certificate->id }}" tabindex="-1" aria-labelledby="certificateModalLabel{{ $certificate->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="certificateModalLabel{{ $certificate->id }}">
                                <i class="fas fa-certificate me-2"></i>Detail Sertifikat
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Informasi Peserta</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Nama:</strong></td>
                                            <td>{{ $participant->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>NIM:</strong></td>
                                            <td>{{ $participant->user->nim ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Universitas:</strong></td>
                                            <td>{{ $participant->user->university ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Divisi:</strong></td>
                                            <td>{{ $participant->divisi->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pembimbing:</strong></td>
                                            <td>{{ $mentor->divisi->vp ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-3">Informasi Sertifikat</h6>
                                    <table class="table table-sm">
                                        <tr>
                                            <td><strong>Nomor Sertifikat:</strong></td>
                                            <td>{{ $certificate->nomor_sertifikat ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Predikat:</strong></td>
                                            <td>
                                                @if($certificate->predikat)
                                                    <span class="badge bg-success">{{ $certificate->predikat }}</span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Terbit:</strong></td>
                                            <td>{{ $certificate->issued_at ? Carbon::parse($certificate->issued_at)->format('d/m/Y') : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tanggal Upload:</strong></td>
                                            <td>{{ Carbon::parse($certificate->created_at)->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Preview Sertifikat</h6>
                                    <div class="text-center">
                                        @if(pathinfo($certificate->certificate_path, PATHINFO_EXTENSION) === 'pdf')
                                            <iframe src="{{ asset('storage/' . $certificate->certificate_path) }}" width="100%" height="400" frameborder="0"></iframe>
                                        @else
                                            <img src="{{ asset('storage/' . $certificate->certificate_path) }}" class="img-fluid" alt="Sertifikat" style="max-height: 400px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ asset('storage/' . $certificate->certificate_path) }}" target="_blank" class="btn btn-success">
                                <i class="fas fa-download me-1"></i>Download Sertifikat
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endforeach

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Auto hide alert after 3 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
</script>
@endpush 