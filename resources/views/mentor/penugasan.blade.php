@extends('layouts.mentor-dashboard')

@section('title', 'Penugasan & Penilaian')

@section('styles')
<style>
:root {
    --telkom-red: #EE2E24;
    --telkom-red-dark: #C41E3A;
    --telkom-red-pure: #F60000;
    --primary: #EE2E24;
    --primary-dark: #C41E3A;
    --secondary: #F60000;
    --success: #10B981;
    --warning: #F59E0B;
    --danger: #EF4444;
    --info: #3B82F6;
    --dark: #1F2937;
    --light: #F3F4F6;
    --border: #E5E7EB;
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-red: 0 4px 12px rgba(238, 46, 36, 0.3);
}

body {
    background: #F9FAFB;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Page Header */
.page-header-custom {
    background: white;
    padding: 1.5rem 2rem;
    border-radius: 12px;
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title-custom {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
}

.page-subtitle-custom {
    font-size: 0.875rem;
    color: #6B7280;
    margin-top: 0.25rem;
}

/* Tabs Navigation */
.tabs-nav {
    background: white;
    border-radius: 12px;
    padding: 0.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    display: flex;
    gap: 0.5rem;
}

.tab-btn {
    flex: 1;
    padding: 0.75rem 1.5rem;
    border: none;
    background: transparent;
    color: #6B7280;
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn:hover {
    background: var(--light);
    color: var(--dark);
}

.tab-btn.active {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    box-shadow: var(--shadow);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Participant Grid */
.participants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.participant-card-compact {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: var(--shadow);
    border: 2px solid transparent;
    transition: all 0.2s;
    cursor: pointer;
}

.participant-card-compact:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.participant-card-compact.not-started {
    opacity: 0.5;
    background: #F9FAFB;
    cursor: not-allowed;
}

.participant-card-compact.not-started:hover {
    border-color: var(--border);
    box-shadow: var(--shadow);
    transform: none;
}

.participant-header-compact {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.participant-avatar-compact {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.participant-info-compact {
    flex: 1;
    min-width: 0;
}

.participant-name {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9375rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.participant-nim {
    font-size: 0.8125rem;
    color: #6B7280;
}

.participant-stats {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.stat-item {
    flex: 1;
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary);
}

.stat-label {
    display: block;
    font-size: 0.75rem;
    color: #6B7280;
    margin-top: 0.25rem;
}

/* Task Creation Form */
.task-form-container {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow);
}

.form-section {
    margin-bottom: 2rem;
}

.form-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--border);
    border-radius: 8px;
    font-size: 0.9375rem;
    transition: all 0.2s;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

/* Participant Selection */
.participant-selector {
    border: 1.5px solid var(--border);
    border-radius: 8px;
    padding: 1rem;
    max-height: 300px;
    overflow-y: auto;
}

.select-all-option {
    padding: 0.75rem;
    background: var(--light);
    border-radius: 6px;
    margin-bottom: 0.75rem;
}

.participant-checkbox {
    display: flex;
    align-items: center;
    padding: 0.625rem 0.75rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

.participant-checkbox:hover {
    background: var(--light);
}

.participant-checkbox.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #F9FAFB;
}

.participant-checkbox.disabled:hover {
    background: #F9FAFB;
}

.participant-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 0.75rem;
    cursor: pointer;
}

.participant-checkbox input[type="checkbox"]:disabled {
    cursor: not-allowed;
}

.participant-checkbox-label {
    font-size: 0.9375rem;
    color: var(--dark);
    cursor: pointer;
}

.participant-checkbox.disabled .participant-checkbox-label {
    cursor: not-allowed;
}

.badge-not-started {
    background: #FEF3C7;
    color: #92400E;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    margin-left: 0.5rem;
}

/* Task Table */
.task-table-container {
    background: white;
    border-radius: 12px;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.task-filters {
    padding: 1.25rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.task-table {
    width: 100%;
    border-collapse: collapse;
}

.task-table thead {
    background: var(--light);
}

.task-table th {
    padding: 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6B7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.task-table td {
    padding: 1rem;
    border-top: 1px solid var(--border);
    font-size: 0.875rem;
    color: var(--dark);
}

.task-table tbody tr:hover {
    background: #F9FAFB;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
}

.badge-primary {
    background: #FFF5F5;
    color: var(--primary);
}

.badge-success {
    background: #D1FAE5;
    color: #065F46;
}

.badge-warning {
    background: #FEF3C7;
    color: #92400E;
}

.badge-danger {
    background: #FEE2E2;
    color: #991B1B;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    box-shadow: var(--shadow);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
}

.btn-success {
    background: var(--success);
    color: white;
}

.btn-success:hover {
    background: #059669;
}

.btn-outline {
    background: white;
    color: var(--primary);
    border: 1.5px solid var(--border);
}

.btn-outline:hover {
    border-color: var(--primary);
    background: #FFF5F5;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.btn-icon {
    padding: 0.5rem;
}

/* Modal */
.modal-content {
    border-radius: 12px;
    border: none;
}

.modal-header {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    background: var(--light);
    border-radius: 0 0 12px 12px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6B7280;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: var(--light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

/* Responsive */
@media (max-width: 768px) {
    .participants-grid {
        grid-template-columns: 1fr;
    }

    .tabs-nav {
        flex-direction: column;
    }

    .task-filters {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header-custom">
        <div>
            <h1 class="page-title-custom">
                <i class="fas fa-tasks"></i> Penugasan & Penilaian
            </h1>
            <p class="page-subtitle-custom">Kelola tugas dan penilaian peserta magang</p>
        </div>
    </div>

    @if($participants->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Belum Ada Peserta</h3>
            <p>Belum ada peserta magang yang diterima di divisi Anda.</p>
        </div>
    @else
        <!-- Tabs Navigation -->
        <div class="tabs-nav">
            <button class="tab-btn active" onclick="switchTab('overview')">
                <i class="fas fa-th-large"></i> Overview Peserta
            </button>
            <button class="tab-btn" onclick="switchTab('create')">
                <i class="fas fa-plus-circle"></i> Buat Tugas Baru
            </button>
            <button class="tab-btn" onclick="switchTab('tasks')">
                <i class="fas fa-list"></i> Semua Tugas
            </button>
            <button class="tab-btn" onclick="switchTab('grading')">
                <i class="fas fa-star"></i> Penilaian
            </button>
        </div>

        <!-- Tab: Overview Peserta -->
        <div id="tab-overview" class="tab-content active">
            <div class="participants-grid">
                @foreach($participants as $participant)
                    @php
                        $totalTugas = $participant->user->assignments->count();
                        $tugasSelesai = $participant->user->assignments->where('grade', '!=', null)->count();
                        $rataRata = $participant->user->assignments->whereNotNull('grade')->avg('grade');

                        // Check if participant has started
                        $hasStarted = true;
                        if ($participant->start_date) {
                            $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                        }
                    @endphp
                    <div class="participant-card-compact {{ !$hasStarted ? 'not-started' : '' }}"
                         onclick="viewParticipantDetail({{ $participant->user->id }})">
                        <div class="participant-header-compact">
                            <div class="participant-avatar-compact">
                                {{ strtoupper(substr($participant->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="participant-info-compact">
                                <h3 class="participant-name">
                                    {{ $participant->user->name ?? '-' }}
                                    @if(!$hasStarted)
                                        <span class="badge badge-warning" style="font-size: 0.7rem; vertical-align: middle;">
                                            <i class="fas fa-clock"></i> Belum Mulai
                                        </span>
                                    @endif
                                </h3>
                                <p class="participant-nim">{{ $participant->user->nim ?? '-' }}</p>
                                @if(!$hasStarted && $participant->start_date)
                                    <p class="participant-nim" style="color: var(--warning); font-size: 0.75rem; margin-top: 0.25rem;">
                                        <i class="fas fa-calendar"></i> Mulai: {{ \Carbon\Carbon::parse($participant->start_date)->format('d M Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="participant-stats">
                            <div class="stat-item">
                                <span class="stat-value">{{ $totalTugas }}</span>
                                <span class="stat-label">Tugas</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">{{ $tugasSelesai }}</span>
                                <span class="stat-label">Selesai</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">{{ $rataRata ? number_format($rataRata, 0) : '-' }}</span>
                                <span class="stat-label">Rata-rata</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tab: Buat Tugas Baru -->
        <div id="tab-create" class="tab-content">
            <div class="task-form-container">
                <form method="POST" action="{{ route('mentor.penugasan.tambah') }}" enctype="multipart/form-data" id="createTaskForm">
                    @csrf

                    <!-- Pilih Peserta Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-users"></i> 1. Pilih Peserta
                        </h3>
                        <div class="participant-selector">
                            <div class="select-all-option">
                                <label class="participant-checkbox">
                                    <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                                    <span class="participant-checkbox-label"><strong>Pilih Semua Peserta (yang sudah mulai)</strong></span>
                                </label>
                            </div>
                            @foreach($participants as $participant)
                                @php
                                    // Check if participant has started
                                    $hasStarted = true;
                                    if ($participant->start_date) {
                                        $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                                    }
                                @endphp
                                <label class="participant-checkbox {{ !$hasStarted ? 'disabled' : '' }}">
                                    <input type="checkbox"
                                           name="user_ids[]"
                                           value="{{ $participant->user->id }}"
                                           class="participant-check"
                                           {{ !$hasStarted ? 'disabled' : '' }}>
                                    <span class="participant-checkbox-label">
                                        {{ $participant->user->name ?? '-' }} ({{ $participant->user->nim ?? '-' }})
                                        @if(!$hasStarted)
                                            <span class="badge-not-started">
                                                <i class="fas fa-clock"></i>
                                                Belum Mulai
                                                @if($participant->start_date)
                                                    - {{ \Carbon\Carbon::parse($participant->start_date)->format('d M') }}
                                                @endif
                                            </span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Detail Tugas Section -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <i class="fas fa-clipboard"></i> 2. Detail Tugas
                        </h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jenis Tugas <span class="text-danger">*</span></label>
                                    <select name="assignment_type" class="form-select" id="assignmentType" required>
                                        <option value="">Pilih Jenis Tugas</option>
                                        <option value="tugas_harian">Tugas Harian</option>
                                        <option value="tugas_proyek">Tugas Proyek</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Judul Tugas <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Masukkan judul tugas..." required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Deadline <span class="text-danger">*</span></label>
                                    <input type="date" name="deadline" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6" id="presentationDateGroup" style="display:none;">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Presentasi</label>
                                    <input type="date" name="presentation_date" class="form-control" id="presentationDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">File Tugas (Opsional)</label>
                                    <input type="file" name="file_path" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Deskripsi Tugas</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail tugas, instruksi pengerjaan, atau kriteria penilaian..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" id="submitTaskBtn">
                            <span class="btn-text">
                                <i class="fas fa-paper-plane"></i> Buat Tugas
                            </span>
                            <span class="btn-loading" style="display: none;">
                                <span class="spinner-border spinner-border-sm me-2"></span> Membuat tugas...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tab: Semua Tugas -->
        <div id="tab-tasks" class="tab-content">
            <div class="task-table-container">
                <div class="task-filters">
                    <div class="filter-group">
                        <label class="form-label">Filter Peserta</label>
                        <select class="form-select" id="filterPeserta" onchange="filterTasks()">
                            <option value="">Semua Peserta</option>
                            @foreach($participants as $participant)
                                <option value="{{ $participant->user->id }}">{{ $participant->user->name ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="form-label">Filter Jenis</label>
                        <select class="form-select" id="filterJenis" onchange="filterTasks()">
                            <option value="">Semua Jenis</option>
                            <option value="tugas_harian">Tugas Harian</option>
                            <option value="tugas_proyek">Tugas Proyek</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="form-label">Filter Status</label>
                        <select class="form-select" id="filterStatus" onchange="filterTasks()">
                            <option value="">Semua Status</option>
                            <option value="belum_dikerjakan">Belum Dikerjakan</option>
                            <option value="sudah_submit">Sudah Submit</option>
                            <option value="sudah_dinilai">Sudah Dinilai</option>
                            <option value="revisi">Revisi</option>
                        </select>
                    </div>
                </div>

                <table class="task-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peserta</th>
                            <th>Judul Tugas</th>
                            <th>Jenis</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        @php $no = 1; @endphp
                        @foreach($participants as $participant)
                            @foreach($participant->user->assignments as $assignment)
                                @php
                                    // Check submissions untuk status real-time
                                    $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
                                    $latestSubmission = $hasSubmissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;

                                    // Tentukan status berdasarkan submissions atau submission_file_path
                                    $status = 'belum_dikerjakan';
                                    if ($assignment->is_revision === 1) {
                                        $status = 'revisi';
                                    } elseif ($assignment->grade !== null) {
                                        $status = 'sudah_dinilai';
                                    } elseif ($hasSubmissions || $assignment->submission_file_path) {
                                        $status = 'sudah_submit';
                                    }
                                @endphp
                                <tr class="task-row"
                                    data-peserta="{{ $participant->user->id }}"
                                    data-jenis="{{ $assignment->assignment_type }}"
                                    data-status="{{ $status }}">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $participant->user->name ?? '-' }}</td>
                                    <td>
                                        {{ $assignment->title ?? '-' }}
                                        @if($hasSubmissions)
                                            <br><small class="text-muted">
                                                <i class="fas fa-upload"></i>
                                                {{ $latestSubmission->submitted_at ? \Carbon\Carbon::parse($latestSubmission->submitted_at)->format('d/m/Y H:i') : '' }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->assignment_type === 'tugas_harian')
                                            <span class="badge badge-primary"><i class="fas fa-calendar-day"></i> Harian</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-project-diagram"></i> Proyek</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d/m/Y') : '-' }}
                                        @if($assignment->deadline)
                                            @php
                                                $deadline = \Carbon\Carbon::parse($assignment->deadline);
                                                $isOverdue = $deadline->lt(now()) && $status === 'belum_dikerjakan';
                                            @endphp
                                            @if($isOverdue)
                                                <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($status === 'revisi')
                                            <span class="badge badge-danger"><i class="fas fa-redo"></i> Revisi</span>
                                        @elseif($status === 'sudah_dinilai')
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Dinilai</span>
                                        @elseif($status === 'sudah_submit')
                                            <span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Nilai</span>
                                        @else
                                            <span class="badge badge-primary"><i class="fas fa-hourglass-half"></i> Belum Dikerjakan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->grade !== null)
                                            <strong style="color: var(--primary); font-size: 1.1rem;">{{ $assignment->grade }}</strong>
                                        @else
                                            <span style="color: var(--light-slate);">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($hasSubmissions || $assignment->submission_file_path)
                                            <a href="{{ $hasSubmissions ? asset('storage/' . $latestSubmission->file_path) : asset('storage/' . $assignment->submission_file_path) }}"
                                               target="_blank"
                                               class="btn btn-outline btn-sm"
                                               title="Download file">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <button class="btn btn-outline btn-sm" disabled title="Belum ada file">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Penilaian -->
        <div id="tab-grading" class="tab-content">
            <div class="task-table-container">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peserta</th>
                            <th>Judul Tugas</th>
                            <th>Jenis</th>
                            <th>File</th>
                            <th>Nilai</th>
                            <th>Feedback</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $noGrade = 1; @endphp
                        @foreach($participants as $participant)
                            @foreach($participant->user->assignments as $assignment)
                                @php
                                    // Check submissions untuk data real-time
                                    $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
                                    $latestSubmission = $hasSubmissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;

                                    // Tentukan apakah perlu dinilai berdasarkan submissions atau submission_file_path
                                    $perluNilai = false;
                                    if ($hasSubmissions || $assignment->submission_file_path) {
                                        if (is_null($assignment->grade) && $assignment->is_revision !== 1) {
                                            $perluNilai = true;
                                        } elseif ($assignment->is_revision === 1 && empty($assignment->feedback)) {
                                            $perluNilai = true;
                                        }
                                    }
                                @endphp
                                @if($perluNilai)
                                    <tr>
                                        <td>{{ $noGrade++ }}</td>
                                        <td>{{ $participant->user->name ?? '-' }}</td>
                                        <td>
                                            {{ $assignment->title ?? '-' }}
                                            @if($hasSubmissions && $latestSubmission->submitted_at)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($latestSubmission->submitted_at)->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($assignment->assignment_type === 'tugas_harian')
                                                <span class="badge badge-primary"><i class="fas fa-calendar-day"></i> Harian</span>
                                            @else
                                                <span class="badge badge-warning"><i class="fas fa-project-diagram"></i> Proyek</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($hasSubmissions)
                                                <a href="{{ asset('storage/' . $latestSubmission->file_path) }}" target="_blank" class="btn btn-outline btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @elseif($assignment->submission_file_path)
                                                <a href="{{ asset('storage/' . $assignment->submission_file_path) }}" target="_blank" class="btn btn-outline btn-sm">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('mentor.penugasan.nilai', $assignment->id) }}" class="d-inline">
                                                @csrf
                                                <input type="number" name="grade" class="form-control form-control-sm"
                                                    style="width: 80px; display: inline-block;"
                                                    placeholder="0-100" min="0" max="100"
                                                    value="{{ $assignment->grade ?? '' }}"
                                                    @if($assignment->is_revision === 1) disabled @else required @endif>
                                        </td>
                                        <td>
                                                <input type="text" name="feedback" class="form-control form-control-sm"
                                                    style="width: 200px; display: inline-block;"
                                                    placeholder="Feedback"
                                                    value="{{ $assignment->feedback ?? '' }}"
                                                    @if($assignment->is_revision === 1) required @endif>
                                        </td>
                                        <td>
                                                <button type="submit" class="btn btn-success btn-sm grade-submit-btn">
                                                    <span class="btn-text">
                                                        <i class="fas fa-save"></i> Simpan
                                                    </span>
                                                    <span class="btn-loading" style="display: none;">
                                                        <span class="spinner-border spinner-border-sm"></span>
                                                    </span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Modal Detail Participant -->
    <div class="modal fade" id="participantDetailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-graduate"></i> Detail Peserta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="participantDetailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    document.getElementById('tab-' + tabName).classList.add('active');
    event.target.closest('.tab-btn').classList.add('active');
}

// Select all participants (only enabled ones)
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.participant-check:not(:disabled)');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}

// Show/hide presentation date based on task type
document.getElementById('assignmentType')?.addEventListener('change', function() {
    const presentationGroup = document.getElementById('presentationDateGroup');
    const presentationDate = document.getElementById('presentationDate');

    if (this.value === 'tugas_proyek') {
        presentationGroup.style.display = 'block';
    } else {
        presentationGroup.style.display = 'none';
        presentationDate.value = '';
    }
});

// Filter tasks
function filterTasks() {
    const filterPeserta = document.getElementById('filterPeserta').value;
    const filterJenis = document.getElementById('filterJenis').value;
    const filterStatus = document.getElementById('filterStatus').value;

    const rows = document.querySelectorAll('.task-row');

    rows.forEach(row => {
        let show = true;

        if (filterPeserta && row.dataset.peserta !== filterPeserta) {
            show = false;
        }

        if (filterJenis && row.dataset.jenis !== filterJenis) {
            show = false;
        }

        if (filterStatus && row.dataset.status !== filterStatus) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    });
}

// View participant detail
function viewParticipantDetail(userId) {
    // For now, switch to "Semua Tugas" tab and filter by this participant
    switchTab('tasks');

    // Filter by participant
    const filterPeserta = document.getElementById('filterPeserta');
    if (filterPeserta) {
        filterPeserta.value = userId;
        filterTasks();
    }
}

// View task detail
function viewTaskDetail(taskId) {
    // Implement task detail view
    alert('View task detail: ' + taskId);
}

// Form validation and loading state
const createTaskForm = document.getElementById('createTaskForm');
const submitTaskBtn = document.getElementById('submitTaskBtn');

if (createTaskForm && submitTaskBtn) {
    // Prevent double submission
    let formSubmitted = false;

    createTaskForm.addEventListener('submit', function(e) {
        // Check if already submitted
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }

        // Validate participant selection
        const checkedBoxes = document.querySelectorAll('.participant-check:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu peserta untuk ditugaskan!');
            return false;
        }

        // Show loading state
        const btnText = submitTaskBtn.querySelector('.btn-text');
        const btnLoading = submitTaskBtn.querySelector('.btn-loading');

        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
            submitTaskBtn.disabled = true;
        }

        // Mark as submitted
        formSubmitted = true;

        // Allow form to submit
        return true;
    });
}
</script>
@endsection
