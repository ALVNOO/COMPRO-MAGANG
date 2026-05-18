{{-- Admin: kelola evaluasi akhir --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir')

@php
    $role = 'admin';

    $totalCount    = $participants->filter(fn($u) => $u->internshipApplications->first())->count();
    $hasDocCount   = $participants->filter(fn($u) => $u->internshipApplications->first()?->hasFinalEvaluationDocument())->count();
    $emptyDocCount = $totalCount - $hasDocCount;
@endphp

@push('styles')
<style>
/* ── Stats grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

/* ── Source badge inside table ── */
.doc-source {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .25rem .65rem;
    border-radius: 9999px;
    font-size: .72rem;
    font-weight: 700;
    border: 1.5px solid transparent;
}

.doc-source.by-peserta { background: #DCFCE7; color: #1A1A1A; border-color: #86EFAC; }
.doc-source.by-admin   { background: #DBEAFE; color: #1A1A1A; border-color: #93C5FD; }
.doc-source.none       { background: #F3F4F6; color: #1A1A1A; border-color: #D1D5DB; }

/* ── Inline upload form ── */
.upload-form { display: flex; align-items: center; gap: .5rem; }

.file-label {
    flex: 1;
    display: flex;
    align-items: center;
    gap: .5rem;
    padding: .45rem .75rem;
    border: 1.5px dashed #D1D5DB;
    border-radius: 8px;
    font-size: .75rem;
    color: #6B7280;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
    overflow: hidden;
    min-width: 0;
}

.file-label:hover { border-color: #EE2E24; color: #EE2E24; }
.file-label i { flex-shrink: 0; }

.file-name-display {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 110px;
}

.btn-upload-sm {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .45rem .875rem;
    background: #EE2E24;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: .75rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-upload-sm:hover { background: #C41E1A; }

/* Locked state */
.upload-locked {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .45rem .75rem;
    background: #F9FAFB;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    font-size: .75rem;
    color: #9CA3AF;
    font-weight: 600;
}

/* Download button */
.btn-dl {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .4rem .8rem;
    background: #fff;
    color: #374151;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    font-size: .75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .15s;
    white-space: nowrap;
}

.btn-dl:hover { border-color: #EE2E24; color: #EE2E24; }

/* Participant cell */
.p-cell { display: flex; align-items: center; gap: .75rem; }

.p-avatar {
    width: 34px; height: 34px;
    border-radius: 9px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff;
    font-size: .7rem;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.p-avatar img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 9px;
}

.p-name  { font-size: .875rem; font-weight: 600; color: #111827; }
.p-nim   { font-size: .72rem;  color: #9CA3AF; margin-top: .1rem; }

/* Empty state */
.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state i { font-size: 3rem; color: #D1D5DB; margin-bottom: 1rem; display: block; }
.empty-state h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.empty-state p  { color: #9CA3AF; font-size: .85rem; margin: 0; }

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr 1fr; }
    .stats-grid .stat-card:last-child { grid-column: span 2; }
    .upload-form { flex-direction: column; align-items: stretch; }
    .file-name-display { max-width: none; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Evaluasi Akhir"
    description="Unduh atau unggah dokumen evaluasi akhir per peserta. Admin tidak bisa unggah jika peserta sudah mengunggah."
    icon="fas fa-file-signature"
    role="admin"
/>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-compact alert-success" style="margin-bottom:1.25rem;">
        <div class="alert-icon-box"><i class="fas fa-check"></i></div>
        <div class="alert-content"><div class="alert-title">{{ session('success') }}</div></div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-compact alert-danger" style="margin-bottom:1.25rem;">
        <div class="alert-icon-box"><i class="fas fa-times"></i></div>
        <div class="alert-content"><div class="alert-title">{{ session('error') }}</div></div>
    </div>
@endif

{{-- Stats --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $totalCount,
        'label' => 'Total Peserta',
        'icon'  => 'fa-users',
        'color' => 'primary',
    ])
    @include('components.dashboard.stat-card', [
        'value' => $hasDocCount,
        'label' => 'Sudah Ada Dokumen',
        'icon'  => 'fa-file-circle-check',
        'color' => 'success',
    ])
    @include('components.dashboard.stat-card', [
        'value' => $emptyDocCount,
        'label' => 'Menunggu Dokumen',
        'icon'  => 'fa-file-circle-xmark',
        'color' => 'warning',
    ])
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-list"></i>
            <span>Daftar Dokumen Evaluasi</span>
        </div>
        <span class="badge badge-gray">{{ $totalCount }} Peserta</span>
    </div>

    @if($totalCount > 0)
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Divisi</th>
                    <th>Status</th>
                    <th>Dokumen</th>
                    <th>Unggah Admin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $userRow)
                    @php
                        $app      = $userRow->internshipApplications->first();
                        $nameParts = explode(' ', $userRow->name);
                        $initials  = strtoupper(substr($nameParts[0], 0, 1))
                                   . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '');

                        $hasPeserta = !empty($app->final_evaluation_participant_path);
                        $hasAdmin   = !empty($app->final_evaluation_admin_path);
                        $hasDoc     = $hasPeserta || $hasAdmin;
                    @endphp
                    @if($app)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- Participant --}}
                        <td style="text-align:left;">
                            <div class="p-cell">
                                <div class="p-avatar">
                                    @if($userRow->profile_picture)
                                        <img src="{{ asset('storage/' . $userRow->profile_picture) }}" alt="{{ $userRow->name }}">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div>
                                    <div class="p-name">{{ $userRow->name }}</div>
                                    <div class="p-nim">{{ $userRow->nim ?? '—' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Division --}}
                        <td>
                            <span style="font-size:.8rem;color:#374151;">
                                {{ $app->divisionAdmin->division_name ?? $app->divisionMentor->division_name ?? '—' }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($app->status === 'accepted')
                                <span class="status-badge status-active">
                                    <i class="fas fa-circle-dot"></i> Aktif
                                </span>
                            @elseif($app->status === 'finished')
                                <span class="status-badge status-finished">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                            @else
                                <span class="status-badge status-pending">{{ ucfirst($app->status) }}</span>
                            @endif
                        </td>

                        {{-- Document status --}}
                        <td style="text-align:center;">
                            @if($hasPeserta)
                                <div style="display:inline-flex;flex-direction:column;gap:.4rem;align-items:center;">
                                    <span class="doc-source by-peserta">
                                        <i class="fas fa-user"></i> Oleh Peserta
                                    </span>
                                    <a href="{{ route('admin.final-evaluation.download', $app->id) }}" class="btn-dl">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                </div>
                            @elseif($hasAdmin)
                                <div style="display:inline-flex;flex-direction:column;gap:.4rem;align-items:center;">
                                    <span class="doc-source by-admin">
                                        <i class="fas fa-user-shield"></i> Oleh Admin
                                    </span>
                                    <a href="{{ route('admin.final-evaluation.download', $app->id) }}" class="btn-dl">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                </div>
                            @else
                                <span class="doc-source none">
                                    <i class="fas fa-minus"></i> Belum Ada
                                </span>
                            @endif
                        </td>

                        {{-- Upload action --}}
                        <td style="min-width:220px;">
                            @if($hasPeserta)
                                <div class="upload-locked">
                                    <i class="fas fa-lock"></i> Peserta sudah unggah
                                </div>
                            @else
                                <form method="POST"
                                      action="{{ route('admin.final-evaluation.upload', $app->id) }}"
                                      enctype="multipart/form-data"
                                      id="fe-form-{{ $app->id }}">
                                    @csrf
                                    <input type="file"
                                           name="final_evaluation_admin"
                                           id="fe-file-{{ $app->id }}"
                                           accept="application/pdf,.pdf"
                                           required
                                           style="display:none;"
                                           onchange="updateFileName({{ $app->id }}, this)">
                                    <div class="upload-form">
                                        <label for="fe-file-{{ $app->id }}" class="file-label">
                                            <i class="fas fa-paperclip"></i>
                                            <span class="file-name-display" id="fe-name-{{ $app->id }}">Pilih PDF…</span>
                                        </label>
                                        <button type="submit" class="btn-upload-sm">
                                            <i class="fas fa-upload"></i> Unggah
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-folder-open"></i>
        <h4>Belum Ada Peserta</h4>
        <p>Tidak ada peserta dengan status diterima atau selesai</p>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function updateFileName(id, input) {
    const label = document.getElementById('fe-name-' + id);
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
    }
}
</script>
@endpush
