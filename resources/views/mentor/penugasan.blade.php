@extends('layouts.mentor-dashboard')

@section('title', 'Penugasan & Penilaian')

@section('content')
<div class="container-fluid">
    <h1 class="h4 mb-4">Penugasan & Penilaian</h1>
    @if($participants->isEmpty())
        <div class="alert alert-info mb-4">Belum ada peserta magang diterima di divisi Anda.</div>
        <!-- Tabel kosong untuk menunjukkan struktur -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user me-2"></i>Belum ada peserta</span>
                    <span class="badge bg-secondary">Tidak ada data</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Tabel Tugas Harian -->
                <h6 class="mb-3"><i class="fas fa-calendar-day me-2 text-info"></i>Tugas Harian</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>File Tugas</th>
                                <th>Nilai</th>
                                <th>Feedback</th>
                                <th>Revisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Belum ada peserta magang diterima di divisi Anda. Tabel akan muncul setelah ada peserta yang diterima.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <hr class="my-4">
                
                <!-- Tabel Tugas Proyek -->
                <h6 class="mb-3"><i class="fas fa-project-diagram me-2 text-primary"></i>Tugas Proyek</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Deadline</th>
                                <th>Tanggal Presentasi</th>
                                <th>Status</th>
                                <th>File Tugas</th>
                                <th>Nilai</th>
                                <th>Feedback</th>
                                <th>Revisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Belum ada peserta magang diterima di divisi Anda. Tabel akan muncul setelah ada peserta yang diterima.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        @foreach($participants as $participant)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user me-2"></i>{{ $participant->user->name ?? '-' }} ({{ $participant->user->nim ?? '-' }})</span>
                        <span class="badge bg-success">Diterima</span>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $tugasHarian = $participant->user->assignments->where('assignment_type', 'tugas_harian')->sortBy('created_at');
                        $tugasProyek = $participant->user->assignments->where('assignment_type', 'tugas_proyek')->sortBy('created_at');
                    @endphp
                    
                    <!-- Tabel Tugas Harian -->
                    <h6 class="mb-3"><i class="fas fa-calendar-day me-2 text-info"></i>Tugas Harian</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>File Tugas</th>
                                    <th>Nilai</th>
                                    <th>Feedback</th>
                                    <th>Revisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $noHarian = 1; @endphp
                                @forelse($tugasHarian as $assignment)
                                    <tr>
                                        <td>{{ $noHarian++ }}</td>
                                        <td>{{ $assignment->title ?? '-' }}</td>
                                        <td>{{ $assignment->description ?? '-' }}</td>
                                        <td>{{ $assignment->deadline ? \Illuminate\Support\Carbon::parse($assignment->deadline)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <span class="text-success"><i class="fas fa-check"></i> Sudah diberi tugas</span>
                                        </td>
                                        <td>
                                            @if($assignment->submissions && $assignment->submissions->count() > 0)
                                                @foreach($assignment->submissions as $i => $submission)
                                                    <div class="mb-1">
                                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            File Tugas {{ $i+1 }}{{ $i == 0 ? '' : ' (Revisi ' . $i . ')'}}
                                                        </a>
                                                        <small class="text-muted">{{ $submission->submitted_at ? \Illuminate\Support\Carbon::parse($submission->submitted_at)->format('d-m-Y H:i') : '' }}</small>
                                                    </div>
                                                @endforeach
                                            @elseif($assignment->file_path)
                                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">File Tugas</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->grade ?? '-' }}</td>
                                        <td>{{ $assignment->feedback ?? '-' }}</td>
                                        <td>
                                            @if($assignment->submission_file_path)
                                                @if($assignment->is_revision === 1)
                                                    <span class="badge bg-danger">Revisi</span>
                                                @else
                                                    <form method="POST" action="{{ route('mentor.penugasan.revisi', $assignment->id) }}">
                                                        @csrf
                                                        <button type="submit" name="is_revision" value="1" class="btn btn-danger btn-sm" @if($assignment->grade !== null) disabled @endif>Revisi</button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center text-muted">Belum ada tugas harian yang diberikan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Tabel Tugas Proyek -->
                    <h6 class="mb-3"><i class="fas fa-project-diagram me-2 text-primary"></i>Tugas Proyek</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Deadline</th>
                                    <th>Tanggal Presentasi</th>
                                    <th>Status</th>
                                    <th>File Tugas</th>
                                    <th>Nilai</th>
                                    <th>Feedback</th>
                                    <th>Revisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $noProyek = 1; @endphp
                                @forelse($tugasProyek as $assignment)
                                    <tr>
                                        <td>{{ $noProyek++ }}</td>
                                        <td>{{ $assignment->title ?? '-' }}</td>
                                        <td>{{ $assignment->description ?? '-' }}</td>
                                        <td>{{ $assignment->deadline ? \Illuminate\Support\Carbon::parse($assignment->deadline)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $assignment->presentation_date ? \Illuminate\Support\Carbon::parse($assignment->presentation_date)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            <span class="text-success"><i class="fas fa-check"></i> Sudah diberi tugas</span>
                                        </td>
                                        <td>
                                            @if($assignment->submissions && $assignment->submissions->count() > 0)
                                                @foreach($assignment->submissions as $i => $submission)
                                                    <div class="mb-1">
                                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                            File Tugas {{ $i+1 }}{{ $i == 0 ? '' : ' (Revisi ' . $i . ')'}}
                                                        </a>
                                                        <small class="text-muted">{{ $submission->submitted_at ? \Illuminate\Support\Carbon::parse($submission->submitted_at)->format('d-m-Y H:i') : '' }}</small>
                                                    </div>
                                                @endforeach
                                            @elseif($assignment->file_path)
                                                <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">File Tugas</a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->grade ?? '-' }}</td>
                                        <td>{{ $assignment->feedback ?? '-' }}</td>
                                        <td>
                                            @if($assignment->submission_file_path)
                                                @if($assignment->is_revision === 1)
                                                    <span class="badge bg-danger">Revisi</span>
                                                @else
                                                    <form method="POST" action="{{ route('mentor.penugasan.revisi', $assignment->id) }}">
                                                        @csrf
                                                        <button type="submit" name="is_revision" value="1" class="btn btn-danger btn-sm" @if($assignment->grade !== null) disabled @endif>Revisi</button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="10" class="text-center text-muted">Belum ada tugas proyek yang diberikan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <!-- Form Penilaian di bawah tabel, kanan bawah -->
                    <div class="d-flex justify-content-between align-items-start mt-3">
                        @if($participant->start_date && \Carbon\Carbon::parse($participant->start_date)->gt(now()))
                            <div class="alert alert-warning mt-3 mb-0">
                                Penugasan hanya dapat diberikan setelah peserta mulai periode magang ({{ \Carbon\Carbon::parse($participant->start_date)->format('d-m-Y') }}).
                            </div>
                        @else
                            <div>
                                <button class="btn btn-primary mb-3" type="button" id="toggleCreateTaskBtn{{ $participant->user->id }}">
                                    <i class="fas fa-plus me-1"></i>Buat Tugas Baru
                                </button>
                            </div>
                        @endif
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($participant->user->assignments->sortBy('created_at') as $assignment)
                                @php
                                    // Tugas perlu dinilai/feedback jika:
                                    // - Sudah ada submission_file_path (sudah dikumpulkan)
                                    // - Belum ada grade ATAU (status revisi dan feedback kosong)
                                    $perluNilai = false;
                                    if ($assignment->submission_file_path) {
                                        if (is_null($assignment->grade) && $assignment->is_revision !== 1) {
                                            $perluNilai = true;
                                        } elseif ($assignment->is_revision === 1 && empty($assignment->feedback)) {
                                            $perluNilai = true;
                                        }
                                    }
                                @endphp
                                @if($perluNilai)
                                    <form method="POST" action="{{ route('mentor.penugasan.nilai', $assignment->id) }}" class="d-flex align-items-center gap-2">
                                        @csrf
                                        <span><strong>{{ $assignment->title }}</strong></span>
                                        <input type="number" name="grade" class="form-control form-control-sm" placeholder="Nilai" min="0" max="100" value="{{ $assignment->grade ?? '' }}" style="width:80px;" @if($assignment->is_revision === 1) disabled @else required @endif>
                                        <input type="text" name="feedback" class="form-control form-control-sm" placeholder="Feedback" value="{{ session('feedback_saved_assignment_id') == $assignment->id ? '' : ($assignment->feedback ?? '') }}" style="width:140px;" @if($assignment->is_revision === 1) required @endif>
                                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div id="createTaskForm{{ $participant->user->id }}" style="display:none;">
                        <form method="POST" action="{{ route('mentor.penugasan.tambah') }}" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $participant->user->id }}">
                            <div class="col-md-3">
                                <select name="assignment_type" class="form-select" id="assignmentTypeSelect{{ $participant->user->id }}" required>
                                    <option value="">Pilih Jenis Tugas</option>
                                    <option value="tugas_harian">Tugas Harian</option>
                                    <option value="tugas_proyek">Tugas Proyek</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="title" class="form-control" placeholder="Judul Penugasan" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="deadline" class="form-control" placeholder="Deadline" required>
                            </div>
                            <div class="col-md-3">
                                <input type="file" name="file_path" class="form-control">
                            </div>
                            <div class="col-md-3" id="presentationDateWrapper{{ $participant->user->id }}" style="display:none;">
                                <input type="date" name="presentation_date" class="form-control" placeholder="Tanggal Presentasi">
                            </div>
                            <div class="col-12">
                                <textarea name="description" class="form-control" placeholder="Deskripsi atau instruksi tugas (boleh kosong)"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Buat Penugasan</button>
                            </div>
                        </form>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var toggleBtn = document.getElementById('toggleCreateTaskBtn{{ $participant->user->id }}');
                            var form = document.getElementById('createTaskForm{{ $participant->user->id }}');
                            if (toggleBtn && form) {
                                toggleBtn.addEventListener('click', function() {
                                    form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
                                });
                            }
                            var assignmentTypeSelect = document.getElementById('assignmentTypeSelect{{ $participant->user->id }}');
                            var presentationWrapper = document.getElementById('presentationDateWrapper{{ $participant->user->id }}');
                            if (assignmentTypeSelect && presentationWrapper) {
                                var presentationInput = presentationWrapper.querySelector('input');
                                var togglePresentationField = function() {
                                    if (assignmentTypeSelect.value === 'tugas_proyek') {
                                        presentationWrapper.style.display = 'block';
                                    } else {
                                        presentationWrapper.style.display = 'none';
                                        if (presentationInput) {
                                            presentationInput.value = '';
                                        }
                                    }
                                };
                                assignmentTypeSelect.addEventListener('change', togglePresentationField);
                                togglePresentationField();
                            }
                        });
                    </script>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection 