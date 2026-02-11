{{--
    ADMIN DASHBOARD QUICK ACTIONS
    Fast access navigation grid

    Required variables:
    - $pendingCount: Number of pending applications (for badge)
--}}

<div class="quick-actions-admin">
    <div class="chart-card-header">
        <div class="chart-card-icon">
            <i class="fas fa-bolt"></i>
        </div>
        <h3 class="chart-card-title">Akses Cepat</h3>
    </div>
    <div class="quick-actions-grid">
        <a href="{{ route('admin.applications') }}" class="quick-action-item">
            @if($pendingCount > 0)
            <span class="quick-action-badge">{{ $pendingCount }}</span>
            @endif
            <i class="fas fa-inbox"></i>
            <span>Pengajuan</span>
        </a>

        <a href="{{ route('admin.participants') }}" class="quick-action-item">
            <i class="fas fa-users"></i>
            <span>Peserta</span>
        </a>

        <a href="{{ route('admin.mentors') }}" class="quick-action-item">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Mentor</span>
        </a>

        <a href="{{ route('admin.legacy-divisions.index') }}" class="quick-action-item">
            <i class="fas fa-building"></i>
            <span>Divisi</span>
        </a>

        <a href="{{ route('admin.reports') }}" class="quick-action-item">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ route('admin.fields') }}" class="quick-action-item">
            <i class="fas fa-tags"></i>
            <span>Peminatan</span>
        </a>
    </div>
</div>
