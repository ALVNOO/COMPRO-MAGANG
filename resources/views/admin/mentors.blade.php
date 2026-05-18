{{--
    ADMIN MENTORS PAGE
    Monitor and manage field mentors
    Using unified layout with design system
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Monitoring Pembimbing')

@php
    use Carbon\Carbon;
    $role = 'admin';
    $pageTitle = 'Monitoring Pembimbing';
    $pageSubtitle = 'Pantau kinerja pembimbing dan peserta magang';

    $totalMentors = $mentors->total();
    $activeMentors = 0;
    $totalMentees = 0;

    foreach($mentors as $mentor) {
        $divisionMentor = $mentor->division_mentor ?? null;
        if ($divisionMentor) {
            $count = \App\Models\InternshipApplication::where('division_mentor_id', $divisionMentor->id)
                ->whereIn('status', ['accepted', 'finished'])
                ->where(function($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->count();
            $totalMentees += $count;
            if ($count > 0) $activeMentors++;
        }
    }
@endphp

@push('styles')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

/* Filter Bar */
.filter-bar {
    background: #fff;
    border-radius: 16px;
    padding: 1rem 1.5rem;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-field {
    position: relative;
    flex: 1;
    min-width: 220px;
}

.search-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-size: 0.82rem;
    pointer-events: none;
}

.filter-input {
    width: 100%;
    padding: 0.6rem 1rem 0.6rem 2.25rem;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    font-size: 0.875rem;
    background: #F9FAFB;
    transition: all 0.2s;
    outline: none;
    color: #111827;
}

.filter-input:focus {
    border-color: #EE2E24;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(238,46,36,0.08);
}

/* Mentor Cell */
.mentor-info {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.mentor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: 0.875rem;
    flex-shrink: 0;
    overflow: hidden;
}

.mentor-avatar img {
    width: 100%; height: 100%; object-fit: cover;
}

.mentor-details { display: flex; flex-direction: column; gap: 0.1rem; }

.mentor-name {
    font-weight: 600;
    color: #111827;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s;
}

.mentor-name:hover { color: #EE2E24; }

.mentor-username { font-size: 0.72rem; color: #9CA3AF; }

.mentor-email {
    font-size: 0.85rem;
    color: #6B7280;
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Pagination */
.pagination-wrapper {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #E5E7EB;
    display: flex;
    justify-content: center;
}

/* Empty State */
.empty-state { padding: 4rem 2rem; text-align: center; }

.empty-icon {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: #FEE4E2;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 1.75rem; color: #EE2E24;
}

.empty-state h4 { font-size: 1rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem; }
.empty-state p { font-size: 0.875rem; color: #6B7280; margin: 0; }

/* Reset Password Modal */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active { opacity: 1; visibility: visible; }

.modal-container {
    background: #fff;
    border-radius: 20px;
    max-width: 480px; width: 100%;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s ease;
}

.modal-overlay.active .modal-container { transform: scale(1) translateY(0); }

.modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #E5E7EB;
    display: flex; align-items: center; justify-content: space-between;
}

.modal-title {
    font-size: 1.05rem; font-weight: 600; color: #111827;
    display: flex; align-items: center; gap: 0.625rem;
}

.modal-title i { color: #D97706; }

.modal-close {
    width: 32px; height: 32px;
    border-radius: 8px; border: none;
    background: #F3F4F6; color: #6B7280;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}

.modal-close:hover { background: #E5E7EB; color: #374151; }

.modal-body { padding: 1.5rem; }

.warning-box {
    background: #FFFBEB;
    border: 1px solid #FCD34D;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: flex-start; gap: 0.75rem;
}

.warning-box i { color: #D97706; font-size: 1.1rem; flex-shrink: 0; margin-top: 0.1rem; }
.warning-box-text { font-size: 0.875rem; color: #92400E; }
.warning-box-text strong { display: block; margin-bottom: 0.25rem; }

.reset-info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 0.625rem 0;
    border-bottom: 1px solid #F3F4F6;
}

.reset-info-row:last-child { border-bottom: none; }
.reset-info-label { font-size: 0.8rem; color: #6B7280; }
.reset-info-value { font-size: 0.875rem; font-weight: 500; color: #374151; }

.reset-info-value code {
    background: #F3F4F6;
    padding: 0.2rem 0.5rem;
    border-radius: 5px;
    font-family: monospace;
    font-size: 0.8rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #E5E7EB;
    display: flex; justify-content: flex-end; gap: 0.75rem;
}

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .filter-bar { flex-direction: column; }
    .search-field { width: 100%; }
    .mentor-email { max-width: 150px; }
}
</style>
@endpush

@section('content')
<div class="mentors-page" x-data="mentorsManager()">

    <x-dashboard.page-context-bar
        title="Monitoring Pembimbing"
        description="Pantau kinerja pembimbing lapangan dan peserta yang dibimbing"
        icon="fas fa-user-tie"
        role="admin"
    />

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalMentors }}</div>
                    <div class="stat-label">Total Pembimbing</div>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $activeMentors }}</div>
                    <div class="stat-label">Pembimbing Aktif</div>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-info">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalMentees }}</div>
                    <div class="stat-label">Total Peserta Dibimbing</div>
                </div>
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <div class="search-field">
            <i class="fas fa-search search-icon"></i>
            <input
                type="text"
                class="filter-input"
                placeholder="Cari nama atau email pembimbing..."
                x-model="searchQuery"
                @input="filterTable()"
            >
        </div>
        <button class="btn btn-secondary" @click="resetFilters()">
            <i class="fas fa-rotate-right"></i> Reset
        </button>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-user-tie"></i>
                <span>Data Pembimbing Lapangan</span>
            </div>
            <span style="font-size:0.8rem;color:#9CA3AF;">Halaman {{ $mentors->currentPage() }} dari {{ $mentors->lastPage() }}</span>
        </div>

        @if($mentors->count() > 0)
        <div class="overflow-x-auto">
            <table class="mentors-table">
                <thead>
                    <tr>
                        <th style="width:55px;">No</th>
                        <th>Pembimbing</th>
                        <th>Email</th>
                        <th style="width:140px;">Peserta</th>
                        <th style="width:190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="mentorsTableBody">
                    @foreach($mentors as $mentor)
                    @php
                        $divisionMentor = $mentor->division_mentor ?? null;
                        $participant = $divisionMentor
                            ? \App\Models\InternshipApplication::where('division_mentor_id', $divisionMentor->id)
                                ->whereIn('status', ['accepted', 'finished'])
                                ->where(function($q) { $q->whereNull('end_date')->orWhere('end_date', '>=', now()); })
                                ->get()
                            : collect();
                        $participantCount = $participant->count();
                        $mentorName = $divisionMentor->mentor_name ?? $mentor->name;
                        $parts = explode(' ', $mentorName);
                        $initials = strtoupper(substr($parts[0], 0, 1)) . (isset($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) : '');
                    @endphp
                    <tr class="mentor-row"
                        data-name="{{ strtolower($mentorName) }}"
                        data-email="{{ strtolower($mentor->email) }}">
                        <td>{{ $loop->iteration + ($mentors->currentPage() - 1) * $mentors->perPage() }}</td>
                        <td>
                            <div class="mentor-info">
                                <div class="mentor-avatar">
                                    @if($mentor->profile_picture)
                                        <img src="{{ asset('storage/' . $mentor->profile_picture) }}" alt="{{ $mentorName }}">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="mentor-details">
                                    <a href="{{ route('admin.mentor.detail', $mentor->id) }}" class="mentor-name">
                                        {{ $mentorName }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="mentor-email" title="{{ $mentor->email }}">{{ $mentor->email }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $participantCount > 0 ? 'badge-success' : 'badge-gray' }}">
                                <i class="fas fa-users"></i> {{ $participantCount }} Peserta
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:0.5rem;">
                                <a href="{{ route('admin.mentor.detail', $mentor->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <button
                                    class="btn btn-sm btn-warning"
                                    @click="openResetModal({{ json_encode([
                                        'id' => $mentor->id,
                                        'name' => $mentorName,
                                        'username' => $mentor->username,
                                    ]) }})"
                                >
                                    <i class="fas fa-key"></i> Reset
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $mentors->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <h4>Belum Ada Pembimbing</h4>
            <p>Pembimbing akan dibuat otomatis ketika Anda menambahkan divisi baru</p>
        </div>
        @endif
    </div>

    {{-- Reset Password Modal --}}
    <div class="modal-overlay" :class="{ 'active': showResetModal }" @click.self="closeResetModal()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-key"></i>
                    <span>Reset Password Pembimbing</span>
                </div>
                <button class="modal-close" @click="closeResetModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="'/admin/mentor/' + selectedMentor?.id + '/reset-password'" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="warning-box">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="warning-box-text">
                            <strong>Perhatian!</strong>
                            Password akan direset menjadi "mentor123"
                        </div>
                    </div>
                    <div>
                        <div class="reset-info-row">
                            <span class="reset-info-label">Nama Pembimbing</span>
                            <span class="reset-info-value" x-text="selectedMentor?.name"></span>
                        </div>
                        <div class="reset-info-row">
                            <span class="reset-info-label">Username</span>
                            <span class="reset-info-value"><code x-text="selectedMentor?.username"></code></span>
                        </div>
                        <div class="reset-info-row">
                            <span class="reset-info-label">Password Baru</span>
                            <span class="reset-info-value"><code>mentor123</code></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeResetModal()">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast --}}
    <div class="toast-container">
        @if(session('success'))
        <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="toast-icon-box"><i class="fas fa-check"></i></div>
            <div class="toast-body"><div class="toast-title">{{ session('success') }}</div></div>
            <button class="toast-close" @click="show = false"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div class="toast toast-danger" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="toast-icon-box"><i class="fas fa-times"></i></div>
            <div class="toast-body"><div class="toast-title">{{ session('error') }}</div></div>
            <button class="toast-close" @click="show = false"><i class="fas fa-times"></i></button>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function mentorsManager() {
    return {
        searchQuery: '',
        showResetModal: false,
        selectedMentor: null,

        filterTable() {
            const rows = document.querySelectorAll('.mentor-row');
            rows.forEach(row => {
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';
                const match = !this.searchQuery ||
                    name.includes(this.searchQuery.toLowerCase()) ||
                    email.includes(this.searchQuery.toLowerCase());
                row.style.display = match ? '' : 'none';
            });
        },

        resetFilters() {
            this.searchQuery = '';
            this.filterTable();
        },

        openResetModal(mentor) {
            this.selectedMentor = mentor;
            this.showResetModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeResetModal() {
            this.showResetModal = false;
            this.selectedMentor = null;
            document.body.style.overflow = '';
        }
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const mgr = document.querySelector('[x-data]')?.__x?.$data;
        if (mgr?.showResetModal) mgr.closeResetModal();
    }
});
</script>
@endpush
