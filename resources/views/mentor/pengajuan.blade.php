{{--
    MENTOR PENGAJUAN PAGE
    Manage internship applications for mentor's division
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Pengajuan Magang')

@php
    $role = 'mentor';
    $pageTitle = 'Pengajuan Magang';
    $pageSubtitle = 'Kelola pengajuan magang untuk divisi Anda';

    // Calculate stats
    $totalApplications = $applications->count();
    $pendingCount = $applications->where('status', 'pending')->count();
    $acceptedCount = $applications->where('status', 'accepted')->count();
    $rejectedCount = $applications->where('status', 'rejected')->count();
@endphp

@push('styles')
<style>
/* ============================================
   MENTOR PENGAJUAN PAGE STYLES
   ============================================ */

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}


.applications-table {
    width: 100%;
    border-collapse: collapse;
}

.applications-table thead {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
}

.applications-table th {
    padding: 1rem 1rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    white-space: nowrap;
}

.applications-table th:first-child {
    padding-left: 1.5rem;
}

.applications-table th:last-child {
    padding-right: 1.5rem;
}

.applications-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    font-size: 0.85rem;
    color: #374151;
    vertical-align: middle;
}

.applications-table td:first-child {
    padding-left: 1.5rem;
}

.applications-table td:last-child {
    padding-right: 1.5rem;
}

.applications-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.applications-table tbody tr:last-child td {
    border-bottom: none;
}

/* Applicant Info */
.applicant-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.applicant-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
    overflow: hidden;
}

.applicant-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.applicant-details .name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.1rem;
}

.applicant-details .email {
    font-size: 0.75rem;
    color: #6b7280;
}


/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.35rem;
}

.btn-action {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.8rem;
}

.btn-action.accept {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.btn-action.accept:hover {
    background: #22c55e;
    color: white;
}

.btn-action.reject {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

.btn-action.reject:hover {
    background: #ef4444;
    color: white;
}

.btn-action.postpone {
    background: rgba(107, 114, 128, 0.15);
    color: #6b7280;
}

.btn-action.postpone:hover {
    background: #6b7280;
    color: white;
}

/* Document Link */
.doc-link {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    background: rgba(59, 130, 246, 0.1);
    color: #2563eb;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.doc-link:hover {
    background: #3b82f6;
    color: white;
}

.btn-send-letter {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-send-letter:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
    color: white;
}

.btn-disabled {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    background: rgba(107, 114, 128, 0.1);
    color: #9ca3af;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: not-allowed;
}

/* Notes Text */
.notes-text {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-size: 0.8rem;
    color: #6b7280;
}

/* Modal Styles */
.modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modal-header-custom {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
}

.modal-header-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
}

.modal-header-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    border: none;
}

.modal-header-custom .modal-title,
.modal-header-danger .modal-title,
.modal-header-secondary .modal-title {
    font-weight: 600;
}

.modal-header-custom .btn-close,
.modal-header-danger .btn-close,
.modal-header-secondary .btn-close {
    filter: brightness(0) invert(1);
}

.modal-body-custom {
    padding: 1.5rem;
}

.form-label-custom {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-textarea-custom {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    resize: vertical;
    min-height: 100px;
}

.form-textarea-custom:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.modal-footer-custom {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    background: #f9fafb;
}

.btn-cancel {
    padding: 0.6rem 1.25rem;
    background: #f3f4f6;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: #e5e7eb;
}

.btn-reject {
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-reject:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-postpone {
    padding: 0.6rem 1.25rem;
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    border: none;
    border-radius: 8px;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-postpone:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .applications-table {
        font-size: 0.8rem;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Pengajuan Magang"
    description="Kelola dan review pengajuan magang untuk divisi Anda"
    icon="fas fa-file-alt"
    role="pembimbing"
/>

@if($applications->isEmpty())
    <div class="alert alert-compact alert-info">
        <div class="alert-icon-box"><i class="fas fa-info"></i></div>
        <div class="alert-content"><div class="alert-title">Belum ada pengajuan magang untuk divisi Anda.</div></div>
    </div>
@else
    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalApplications }}</div>
                    <div class="stat-label">Total Pengajuan</div>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-warning">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $pendingCount }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $acceptedCount }}</div>
                    <div class="stat-label">Diterima</div>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-danger">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $rejectedCount }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Applications Table --}}
    <div class="table-card">
        <div class="table-header">
            <i class="fas fa-list"></i>
            <h3>Daftar Pengajuan Magang</h3>
        </div>
        <div class="table-responsive">
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pendaftar</th>
                        <th>NIM</th>
                        <th>Universitas</th>
                        <th>Jurusan</th>
                        <th>Periode</th>
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
                        <td>
                            <div class="applicant-info">
                                <div class="applicant-avatar">
                                    @if($app->user->profile_picture)
                                        <img src="{{ asset('storage/' . $app->user->profile_picture) }}" alt="{{ $app->user->name }}">
                                    @else
                                        {{ strtoupper(substr($app->user->name ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                                <div class="applicant-details">
                                    <div class="name">{{ $app->user->name ?? '-' }}</div>
                                    <div class="email">{{ $app->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $app->user->nim ?? '-' }}</td>
                        <td>{{ $app->user->university ?? '-' }}</td>
                        <td>{{ $app->user->major ?? '-' }}</td>
                        <td>
                            <div style="font-size: 0.8rem;">
                                {{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d M Y') : '-' }}
                                <br>
                                <span style="color: #6b7280;">s/d</span>
                                <br>
                                {{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d M Y') : '-' }}
                            </div>
                        </td>
                        <td>
                            @if($app->user && $app->user->ktm)
                                <a href="{{ asset('storage/' . $app->user->ktm) }}" target="_blank" class="doc-link">
                                    <i class="fas fa-id-card"></i> Lihat
                                </a>
                            @else
                                <span style="color: #9ca3af; font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($app->cover_letter_path)
                                <a href="{{ asset('storage/' . $app->cover_letter_path) }}" target="_blank" class="doc-link">
                                    <i class="fas fa-file-pdf"></i> Lihat
                                </a>
                            @else
                                <span style="color: #9ca3af; font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($app->acceptance_letter_path)
                                <a href="{{ asset('storage/' . $app->acceptance_letter_path) }}" target="_blank" class="doc-link">
                                    <i class="fas fa-file-pdf"></i> Lihat
                                </a>
                            @elseif($app->cover_letter_path)
                                <a href="{{ route('mentor.pengajuan.acceptance-letter.form', $app->id) }}" class="btn-send-letter">
                                    <i class="fas fa-paper-plane"></i> Kirim
                                </a>
                            @else
                                <span class="btn-disabled">
                                    <i class="fas fa-ban"></i> -
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @elseif($app->status === 'accepted')
                                <span class="status-badge status-accepted">
                                    <i class="fas fa-check"></i> Diterima
                                </span>
                            @elseif($app->status === 'rejected')
                                <span class="status-badge status-rejected">
                                    <i class="fas fa-times"></i> Ditolak
                                </span>
                            @elseif($app->status === 'postponed')
                                <span class="badge badge-gray">
                                    <i class="fas fa-pause"></i> Ditunda
                                </span>
                            @elseif($app->status === 'finished')
                                <span class="status-badge status-finished">
                                    <i class="fas fa-flag-checkered"></i> Selesai
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($app->notes)
                                <span class="notes-text" title="{{ $app->notes }}">{{ $app->notes }}</span>
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td>
                            @if($app->status === 'pending' || $app->status === 'postponed')
                                <div class="action-buttons">
                                    <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}" style="display:inline">
                                        @csrf
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="btn-action accept" title="Terima">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn-action reject" data-bs-toggle="modal" data-bs-target="#tolakModal{{ $app->id }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <button type="button" class="btn-action postpone" data-bs-toggle="modal" data-bs-target="#tundaModal{{ $app->id }}" title="Tunda">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </div>
                            @else
                                <span style="color: #9ca3af; font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal Tolak --}}
                    <div class="modal fade" id="tolakModal{{ $app->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <div class="modal-header modal-header-danger">
                                        <h5 class="modal-title">
                                            <i class="fas fa-times-circle me-2"></i>Alasan Penolakan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body modal-body-custom">
                                        <div class="mb-3">
                                            <label class="form-label-custom">Alasan <span class="text-danger">*</span></label>
                                            <textarea class="form-textarea-custom" name="notes" required placeholder="Jelaskan alasan penolakan..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer modal-footer-custom">
                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-reject">
                                            <i class="fas fa-times me-1"></i> Tolak Pengajuan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tunda --}}
                    <div class="modal fade" id="tundaModal{{ $app->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('mentor.pengajuan.respon', $app->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="postponed">
                                    <div class="modal-header modal-header-secondary">
                                        <h5 class="modal-title">
                                            <i class="fas fa-pause-circle me-2"></i>Alasan Penundaan
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body modal-body-custom">
                                        <div class="mb-3">
                                            <label class="form-label-custom">Alasan <span class="text-danger">*</span></label>
                                            <textarea class="form-textarea-custom" name="notes" required placeholder="Jelaskan alasan penundaan..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer modal-footer-custom">
                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-postpone">
                                            <i class="fas fa-pause me-1"></i> Tunda Pengajuan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
