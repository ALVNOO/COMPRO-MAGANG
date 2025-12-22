@extends('layouts.dashboard')

@section('title', 'Penugasan & Penilaian - PT Telkom Indonesia')

@push('styles')
<style>
    .container-fluid {
        max-width: 100%;
        overflow-x: hidden;
        padding-bottom: 2rem;
    }
    .card {
        word-wrap: break-word;
    }
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Penugasan & Penilaian</h1>
            <p class="text-muted">Kelola tugas dan lihat penilaian dari pembimbing</p>
        </div>
    </div>

    @if($assignments->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks me-2"></i>Daftar Tugas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Deskripsi Tugas</th>
                                    <th>Deadline</th>
                                    <th>File Tugas</th>
                                    <th>Status Pengumpulan</th>
                                    <th>Nilai</th>
                                    <th>Feedback</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($assignments->sortBy('created_at') as $assignment)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <div>
                                            <strong>{{ Str::limit($assignment->description, 100) }}</strong>
                                            <br>
                                            <small class="text-muted">Dibuat: {{ $assignment->created_at->format('d M Y H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $assignment->deadline ? \Illuminate\Support\Carbon::parse($assignment->deadline)->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        @if($assignment->file_path)
                                            <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        @else
                                            <span class="text-muted">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $showBelumKumpul = false;
                                            if ($assignment->is_revision === 1) {
                                                // Cek apakah submission terakhir dibuat sebelum status revisi diberikan
                                                $lastSubmission = $assignment->submissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;
                                                if (!$lastSubmission || ($assignment->updated_at && $lastSubmission->submitted_at < $assignment->updated_at)) {
                                                    $showBelumKumpul = true;
                                                }
                                            }
                                        @endphp
                                        @if(!$assignment->submitted_at)
                                            <span class="text-danger"><i class="fas fa-times"></i> Belum dikumpulkan</span>
                                        @elseif($showBelumKumpul)
                                            <span class="text-danger"><i class="fas fa-times"></i> Belum dikumpulkan (Revisi)</span>
                                        @else
                                            <span class="text-success"><i class="fas fa-check"></i> Sudah dikumpulkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->grade !== null)
                                            <span class="badge bg-info fs-6">{{ $assignment->grade }}/10</span>
                                        @else
                                            <span class="text-muted">Belum dinilai</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $assignment->feedback ?? '-' }}
                                    </td>
                                    <td>
                                        @if(!$assignment->submitted_at || $assignment->is_revision === 1)
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#submitModal{{ $assignment->id }}">
                                                <i class="fas fa-upload me-1"></i>{{ !$assignment->submitted_at ? 'Kumpulkan' : 'Kumpulkan Ulang' }}
                                            </button>
                                        @else
                                            <span class="text-success">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tasks fa-4x text-muted mb-4"></i>
                    @if(isset($application) && $application && $application->status == 'accepted')
                        <h4 class="text-muted mb-3">Belum ada tugas yang diberikan oleh pembimbing.</h4>
                        <p class="text-muted mb-4">Tunggu hingga pembimbing memberikan tugas pertama Anda.</p>
                    @else
                        <h4 class="text-muted mb-3">Belum Ada Tugas</h4>
                        <p class="text-muted mb-4">Belum ada tugas yang diberikan oleh pembimbing. Tugas akan muncul di sini setelah Anda diterima magang.</p>
                        <a href="{{ route('dashboard.status') }}" class="btn btn-primary">
                            <i class="fas fa-clipboard-list me-2"></i>Lihat Status Pengajuan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Submit Assignment Modals -->
@foreach($assignments as $assignment)
@if(!$assignment->submitted_at || $assignment->is_revision === 1)
<div class="modal fade" id="submitModal{{ $assignment->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ !$assignment->submitted_at ? 'Kumpulkan Tugas' : 'Kumpulkan Ulang Tugas (Revisi)' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('dashboard.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Tugas:</label>
                        <p class="text-muted">{{ $assignment->description }}</p>
                    </div>
                    @if($assignment->online_text)
                    <div class="mb-3">
                        <label for="online_text_{{ $assignment->id }}" class="form-label">Online Text (opsional)</label>
                        <textarea class="form-control" id="online_text_{{ $assignment->id }}" name="online_text" rows="3"></textarea>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="submission_file" class="form-label">Upload File Tugas <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="submission_file" name="submission_file" accept=".pdf,.doc,.docx" required>
                        <div class="form-text">Format yang diterima: PDF, DOC, DOCX (Maksimal 2MB)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i>{{ !$assignment->submitted_at ? 'Kumpulkan Tugas' : 'Kumpulkan Ulang' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach

@include('partials.tour-guide')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const assignmentsTourSteps = [
        {
            element: '.container-fluid > .row:first-child',
            title: 'Halaman Tugas',
            content: 'Ini adalah halaman Tugas dimana Anda dapat melihat semua tugas yang diberikan oleh mentor, status pengerjaan, dan nilai yang diperoleh.'
        },
        {
            element: '.card:first-of-type',
            title: 'Daftar Tugas',
            content: 'Setiap kartu menampilkan satu tugas dengan informasi deskripsi, tenggat waktu, dan status pengerjaan.'
        },
        {
            element: '.btn-success',
            title: 'Kumpulkan Tugas',
            content: 'Klik tombol ini untuk mengumpulkan file tugas Anda. Pastikan file dalam format PDF, DOC, atau DOCX dengan ukuran maksimal 2MB.'
        },
        {
            element: '.badge',
            title: 'Status Tugas',
            content: 'Badge menunjukkan status tugas: Pending (belum dikumpulkan), Submitted (sudah dikumpulkan), atau Graded (sudah dinilai).'
        }
    ];

    initTourGuide(assignmentsTourSteps);
});
</script>
@endpush
@endsection 