{{--
    ADMIN DASHBOARD STATS GRID
    Overview statistics cards

    Required variables:
    - $totalParticipants: Total active participants
    - $totalApplications: Total applications
    - $pendingCount: Pending applications
    - $acceptedCount: Accepted applications
    - $totalFinishedParticipants: Finished participants
    - $totalMentors: Total mentors (default: 0)
--}}

<div class="stats-grid-admin">
    {{-- Total Peserta Aktif --}}
    <div class="stat-card-admin red">
        <div class="stat-card-header">
            <div class="stat-card-icon red">
                <i class="fas fa-users"></i>
            </div>
            <span class="stat-card-badge active">Aktif</span>
        </div>
        <div class="stat-card-value" data-target="{{ $totalParticipants }}">0</div>
        <div class="stat-card-desc">Peserta Aktif</div>
    </div>

    {{-- Total Pengajuan --}}
    <div class="stat-card-admin blue">
        <div class="stat-card-header">
            <div class="stat-card-icon blue">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
        <div class="stat-card-value" data-target="{{ $totalApplications }}">0</div>
        <div class="stat-card-desc">Total Pengajuan</div>
    </div>

    {{-- Pending --}}
    <div class="stat-card-admin amber">
        <div class="stat-card-header">
            <div class="stat-card-icon amber">
                <i class="fas fa-clock"></i>
            </div>
            @if($pendingCount > 0)
            <span class="stat-card-badge pending">Review</span>
            @endif
        </div>
        <div class="stat-card-value" data-target="{{ $pendingCount }}">0</div>
        <div class="stat-card-desc">Menunggu</div>
    </div>

    {{-- Accepted --}}
    <div class="stat-card-admin green">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-card-value" data-target="{{ $acceptedCount }}">0</div>
        <div class="stat-card-desc">Diterima</div>
    </div>

    {{-- Finished --}}
    <div class="stat-card-admin purple">
        <div class="stat-card-header">
            <div class="stat-card-icon purple">
                <i class="fas fa-graduation-cap"></i>
            </div>
        </div>
        <div class="stat-card-value" data-target="{{ $totalFinishedParticipants }}">0</div>
        <div class="stat-card-desc">Selesai</div>
    </div>

    {{-- Mentors --}}
    <div class="stat-card-admin cyan">
        <div class="stat-card-header">
            <div class="stat-card-icon cyan">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="stat-card-value" data-target="{{ $totalMentors ?? 0 }}">0</div>
        <div class="stat-card-desc">Total Mentor</div>
    </div>
</div>
