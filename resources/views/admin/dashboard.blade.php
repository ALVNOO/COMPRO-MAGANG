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

/* Recent apps table: header semua tengah, isi kolom Nama kiri & bisa wrap */
#recentAppsTable thead th {
    text-align: center !important;
}
#recentAppsTable tbody td {
    text-align: center !important;
}
#recentAppsTable tbody td:first-child {
    text-align: left !important;
    white-space: normal;
    word-break: break-word;
    min-width: 120px;
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
<x-dashboard.page-context-bar
    title="Dashboard Admin"
    description="Kelola seluruh aktivitas magang dan pantau perkembangan peserta"
    icon="fas fa-gauge-high"
    role="admin"
/>

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
    <table class="admin-table" id="recentAppsTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Institusi</th>
                <th>Bidang / Divisi</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($recentApplications) && $recentApplications->count() > 0)
                @foreach($recentApplications->take(5) as $app)
                    <tr>
                        <td>
                            <strong>{{ $app->user->name ?? 'N/A' }}</strong>
                        </td>
                        <td>{{ Str::limit($app->user->university ?? '-', 25) }}</td>
                        <td>{{ Str::limit($app->divisionAdmin->division_name ?? $app->fieldOfInterest->name ?? $app->divisi->name ?? '-', 20) }}</td>
                        <td>
                            <span class="status-badge status-{{ $app->status }}">
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

    {{-- Active Participants per Division --}}
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">
                <div class="chart-title-icon green">
                    <i class="fas fa-building-user"></i>
                </div>
                <span>Peserta Aktif per Divisi</span>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="divisionChart"></canvas>
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

    // Division Bar Chart
    const divisionCtx = document.getElementById('divisionChart');
    if (divisionCtx) {
        const divData = @json($activePerDivision ?? []);
        const divLabels = divData.map(d => d.name);
        const divValues = divData.map(d => d.count);

        new Chart(divisionCtx, {
            type: 'bar',
            data: {
                labels: divLabels,
                datasets: [{
                    label: 'Peserta Aktif',
                    data: divValues,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    hoverBackgroundColor: '#10B981',
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} peserta aktif`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { size: 11 } },
                        grid: { color: 'rgba(0,0,0,0.04)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10 },
                            maxRotation: 30,
                            callback: function(val, idx) {
                                const label = divLabels[idx] || '';
                                return label.length > 14 ? label.slice(0, 13) + '…' : label;
                            }
                        }
                    }
                }
            }
        });
    }

});
</script>
@endpush
