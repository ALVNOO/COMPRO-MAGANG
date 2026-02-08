{{--
    ADMIN DASHBOARD
    Main dashboard for administrators
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Dashboard Admin')

@php
    $role = 'admin';
    $pageTitle = 'Dashboard Admin';
    $pageSubtitle = 'Kelola aplikasi magang Telkom Indonesia';
@endphp

@push('styles')
<style>
/* ============================================
   ADMIN DASHBOARD STYLES
   ============================================ */

/* Hero Section - Telkom Red Theme */
.admin-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.admin-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.hero-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hero-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 500px;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-badge-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.25);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.hero-badge-text h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.hero-badge-text p {
    font-size: 0.75rem;
    margin: 0;
    opacity: 0.85;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* Charts Section */
.charts-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .charts-grid {
        grid-template-columns: 1fr;
    }
}

.chart-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.chart-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-gray-800);
}

.chart-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.chart-title-icon.purple { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
.chart-title-icon.blue { background: linear-gradient(135deg, #3B82F6, #60A5FA); }
.chart-title-icon.green { background: linear-gradient(135deg, #10B981, #34D399); }
.chart-title-icon.red { background: linear-gradient(135deg, #EE2E24, #FF6B6B); }

.chart-container {
    position: relative;
    height: 280px;
}

/* Quick Actions */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}

.quick-action-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: white;
    position: relative;
}

.quick-action-icon .badge-count {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 20px;
    height: 20px;
    background: #EF4444;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid white;
}

.quick-action-text h4 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-gray-800);
    margin: 0 0 0.25rem 0;
}

.quick-action-text p {
    font-size: 0.8rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* Activity & Recent Table */
.content-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .content-grid-2 {
        grid-template-columns: 1fr;
    }
}

.activity-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--color-gray-50);
    border-radius: 12px;
    transition: all 0.2s;
}

.activity-item:hover {
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.activity-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.activity-icon.new { background: rgba(16, 185, 129, 0.1); color: #10B981; }
.activity-icon.pending { background: rgba(245, 158, 11, 0.1); color: #F59E0B; }
.activity-icon.approved { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
.activity-icon.rejected { background: rgba(239, 68, 68, 0.1); color: #EF4444; }

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    font-size: 0.85rem;
    color: var(--color-gray-700);
    margin: 0 0 0.25rem 0;
    line-height: 1.4;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--color-gray-500);
}

/* Recent Table */
.table-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--color-gray-100);
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--color-gray-800);
}

.view-all-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--color-primary);
    text-decoration: none;
    transition: all 0.2s;
}

.view-all-link:hover {
    gap: 0.75rem;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: var(--color-gray-50);
    padding: 0.875rem 1rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--color-gray-600);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--color-gray-100);
    font-size: 0.875rem;
    color: var(--color-gray-700);
}

.admin-table tbody tr:hover {
    background: var(--color-gray-50);
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.status-badge.accepted {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.1);
    color: #EF4444;
}

/* Division Chart */
.division-chart-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 2rem;
}

.empty-icon {
    width: 64px;
    height: 64px;
    background: var(--color-gray-100);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: var(--color-gray-400);
    font-size: 1.5rem;
}

.empty-text {
    font-size: 0.9rem;
    color: var(--color-gray-500);
    margin: 0;
}

/* Responsive Hero */
@media (max-width: 900px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }

    .hero-text {
        order: 1;
    }

    .hero-text h1 {
        justify-content: center;
    }

    .hero-badge {
        order: 2;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-shield-halved"></i>
                Panel Administrator
            </h1>
            <p>
                Kelola seluruh aktivitas magang, pantau pengajuan, dan awasi perkembangan peserta di Telkom Indonesia.
            </p>
        </div>
        @if(isset($todayRegistrations) && $todayRegistrations > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $todayRegistrations }}</h4>
                <p>Pendaftar Hari Ini</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $totalApplications ?? 0,
        'label' => 'Total Pengajuan',
        'icon' => 'fa-file-alt',
        'color' => 'purple',
        'link' => route('admin.applications')
    ])

    @include('components.dashboard.stat-card', [
        'value' => $pendingCount ?? 0,
        'label' => 'Menunggu Review',
        'icon' => 'fa-clock',
        'color' => 'warning',
        'link' => route('admin.applications')
    ])

    @include('components.dashboard.stat-card', [
        'value' => $totalParticipants ?? 0,
        'label' => 'Peserta Aktif',
        'icon' => 'fa-users',
        'color' => 'success',
        'link' => route('admin.participants')
    ])

    @include('components.dashboard.stat-card', [
        'value' => $totalMentors ?? 0,
        'label' => 'Total Mentor',
        'icon' => 'fa-user-tie',
        'color' => 'info',
        'link' => route('admin.mentors')
    ])
</div>

{{-- Quick Actions --}}
<div class="quick-actions-grid">
    <a href="{{ route('admin.applications') }}" class="quick-action-card">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #F59E0B, #FBBF24);">
            <i class="fas fa-inbox"></i>
            @if(isset($pendingCount) && $pendingCount > 0)
                <span class="badge-count">{{ $pendingCount > 9 ? '9+' : $pendingCount }}</span>
            @endif
        </div>
        <div class="quick-action-text">
            <h4>Pengajuan Magang</h4>
            <p>Review pendaftaran baru</p>
        </div>
    </a>

    <a href="{{ route('admin.participants') }}" class="quick-action-card">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #10B981, #34D399);">
            <i class="fas fa-users"></i>
        </div>
        <div class="quick-action-text">
            <h4>Daftar Peserta</h4>
            <p>Kelola peserta magang</p>
        </div>
    </a>

    <a href="{{ route('admin.mentors') }}" class="quick-action-card">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #3B82F6, #60A5FA);">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="quick-action-text">
            <h4>Monitoring Mentor</h4>
            <p>Pantau pembimbing</p>
        </div>
    </a>

    <a href="{{ route('admin.reports') }}" class="quick-action-card">
        <div class="quick-action-icon" style="background: linear-gradient(135deg, #8B5CF6, #A78BFA);">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="quick-action-text">
            <h4>Laporan</h4>
            <p>Lihat statistik lengkap</p>
        </div>
    </a>
</div>

{{-- Recent Applications Table (Full Width) --}}
<div class="table-card" style="margin-bottom: 2rem;">
    <div class="table-header">
        <div class="table-title">
            <div class="chart-title-icon purple">
                <i class="fas fa-list"></i>
            </div>
            <span>Pengajuan Terbaru</span>
        </div>
        <a href="{{ route('admin.applications') }}" class="view-all-link">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Institusi</th>
                <th>Divisi</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($recentApplications) && $recentApplications->count() > 0)
                @foreach($recentApplications->take(5) as $app)
                    <tr>
                        <td>
                            <strong>{{ Str::limit($app->user->name ?? 'N/A', 20) }}</strong>
                        </td>
                        <td>{{ Str::limit($app->user->institution ?? '-', 25) }}</td>
                        <td>{{ Str::limit($app->division->name ?? '-', 20) }}</td>
                        <td>
                            <span class="status-badge {{ $app->status }}">
                                @if($app->status === 'pending')
                                    <i class="fas fa-clock"></i> Pending
                                @elseif($app->status === 'accepted')
                                    <i class="fas fa-check"></i> Diterima
                                @elseif($app->status === 'rejected')
                                    <i class="fas fa-times"></i> Ditolak
                                @else
                                    {{ ucfirst($app->status) }}
                                @endif
                            </span>
                        </td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <p class="empty-text">Belum ada pengajuan</p>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

{{-- Charts Section --}}
<div class="charts-grid">
    {{-- Status Distribution Chart --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">
                <div class="chart-title-icon purple">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <span>Distribusi Status</span>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    {{-- Applications Over Time --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">
                <div class="chart-title-icon blue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span>Trend Pengajuan</span>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="trendChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusDistribution ?? ['pending' => 0, 'accepted' => 0, 'rejected' => 0]);
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Diterima', 'Ditolak'],
                datasets: [{
                    data: [statusData.pending || 0, statusData.accepted || 0, statusData.rejected || 0],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    hoverBackgroundColor: [
                        '#F59E0B',
                        '#10B981',
                        '#EF4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '500' }
                        }
                    }
                }
            }
        });
    }

    // Trend Chart
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        const trendData = @json($applicationsOverTime ?? []);
        const labels = trendData.map(d => d.month || d.label || '');
        const values = trendData.map(d => d.count || d.value || 0);

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pengajuan',
                    data: values,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#3B82F6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    }

});
</script>
@endpush
