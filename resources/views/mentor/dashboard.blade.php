@extends('layouts.dashboard-unified')
@section('title', 'Dashboard Pembimbing Lapangan')
@php $role = 'mentor'; @endphp

@push('styles')
<style>
/* Stats */
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.5rem; margin-bottom:2rem; }
@media(max-width:1200px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px) {.stats-grid{grid-template-columns:1fr;}}

/* Today's Focus panels */
.focus-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem; margin-bottom:2rem; }
@media(max-width:1024px){.focus-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:640px) {.focus-grid{grid-template-columns:1fr;}}

.focus-panel {
    background:rgba(255,255,255,0.9);
    backdrop-filter:blur(20px);
    border-radius:16px;
    padding:1.25rem 1.5rem;
    border:1px solid rgba(0,0,0,0.05);
    box-shadow:0 4px 20px rgba(0,0,0,0.04);
}

.focus-panel-head {
    display:flex; align-items:center; gap:.6rem;
    margin-bottom:.9rem;
    padding-bottom:.75rem;
    border-bottom:1px solid var(--color-gray-100);
}

.focus-panel-icon {
    width:32px; height:32px; border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    font-size:.82rem; color:white; flex-shrink:0;
}
.focus-panel-icon.red    { background:linear-gradient(135deg,#EF4444,#F87171); }
.focus-panel-icon.amber  { background:linear-gradient(135deg,#F59E0B,#FBBF24); }
.focus-panel-icon.blue   { background:linear-gradient(135deg,#3B82F6,#60A5FA); }

.focus-panel-title { font-size:.875rem; font-weight:700; color:var(--color-gray-700); }
.focus-panel-count { margin-left:auto; font-size:.8rem; font-weight:700; padding:2px 9px; border-radius:100px; }
.focus-count-red   { background:#FEE2E2; color:#1A1A1A; }
.focus-count-amber { background:#FEF3C7; color:#1A1A1A; }
.focus-count-blue  { background:#DBEAFE; color:#1A1A1A; }

.focus-list { display:flex; flex-direction:column; gap:5px; max-height:130px; overflow-y:auto; }
.focus-list-item {
    display:flex; align-items:center; gap:7px;
    font-size:.8rem; color:var(--color-gray-600); padding:4px 0;
}
.focus-av {
    width:24px; height:24px; border-radius:6px;
    background:linear-gradient(135deg,#EE2E24,#C41E3A);
    color:white; font-size:.6rem; font-weight:700;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.focus-photo {
    width:24px; height:24px; border-radius:6px;
    object-fit:cover; flex-shrink:0;
}
.focus-empty { font-size:.8rem; color:var(--color-gray-400); text-align:center; padding:.6rem 0; }

.pres-item { flex-direction:column; align-items:flex-start; gap:2px; }
.pres-badge { padding:1px 7px; border-radius:100px; font-size:.68rem; font-weight:700; }
.pres-soon   { background:#FEE2E2; color:#1A1A1A; }
.pres-coming { background:#FEF3C7; color:#1A1A1A; }
.pres-meta   { font-size:.73rem; color:var(--color-gray-400); }

/* Charts area */
.charts-grid { display:grid; grid-template-columns:1.5fr 1fr; gap:1.5rem; margin-bottom:2rem; }
@media(max-width:1024px){.charts-grid{grid-template-columns:1fr;}}

.chart-card {
    background:rgba(255,255,255,0.9); backdrop-filter:blur(20px);
    border-radius:20px; padding:1.5rem;
    border:1px solid rgba(0,0,0,0.05); box-shadow:0 4px 24px rgba(0,0,0,0.05);
}
.chart-card.no-pad { padding:0; overflow:hidden; }

.chart-header {
    display:flex; justify-content:space-between; align-items:center;
    margin-bottom:1.25rem; padding-bottom:1rem;
    border-bottom:1px solid var(--color-gray-100);
}
.chart-card.no-pad .chart-header { margin:0; padding:1.25rem 1.5rem; border-bottom:1px solid var(--color-gray-100); }

.chart-title {
    display:flex; align-items:center; gap:.7rem;
    font-size:1rem; font-weight:600; color:var(--color-gray-800); margin:0;
}
.chart-title-icon {
    width:34px; height:34px; border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    color:white; font-size:.82rem; flex-shrink:0;
}
.chart-title-icon.green  { background:linear-gradient(135deg,#10B981,#34D399); }
.chart-title-icon.purple { background:linear-gradient(135deg,#8B5CF6,#A78BFA); }
.chart-title-icon.blue   { background:linear-gradient(135deg,#3B82F6,#60A5FA); }
.chart-title-icon.amber  { background:linear-gradient(135deg,#F59E0B,#FBBF24); }

.chart-container { position:relative; height:260px; }

.chart-legend { display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
.chart-legend-item { display:flex; align-items:center; gap:5px; font-size:.72rem; color:var(--color-gray-500); font-weight:500; }
.chart-legend-dot  { width:10px; height:10px; border-radius:3px; }

/* Grading queue table */
.grade-btn {
    display:inline-flex; align-items:center; gap:4px;
    padding:4px 10px; border-radius:8px;
    background:linear-gradient(135deg,#EE2E24,#C41E3A);
    color:white; font-size:.72rem; font-weight:600;
    text-decoration:none; transition:opacity .2s;
    white-space:nowrap;
}
.grade-btn:hover { opacity:.85; color:white; }

.participant-av {
    width:32px; height:32px; border-radius:8px;
    background:linear-gradient(135deg,#EE2E24,#C41E3A);
    color:white; font-size:.68rem; font-weight:700;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}

.view-all-link {
    display:flex; align-items:center; gap:.5rem;
    font-size:.82rem; font-weight:500; color:var(--color-primary);
    text-decoration:none; transition:gap .2s;
}
.view-all-link:hover { gap:.75rem; }

/* Grading queue scrollable body */
.grade-queue-body { max-height:320px; overflow-y:auto; }
.grade-queue-row {
    display:flex; align-items:center; gap:.75rem;
    padding:.6rem 1.5rem; border-bottom:1px solid rgba(0,0,0,0.04);
    transition:background .15s;
}
.grade-queue-row:last-child { border-bottom:none; }
.grade-queue-row:hover { background:rgba(0,0,0,0.02); }
.grade-queue-info { flex:1; min-width:0; }
.grade-queue-title { font-size:.8rem; font-weight:600; color:var(--color-gray-700); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.grade-queue-meta  { font-size:.72rem; color:var(--color-gray-400); }
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Dashboard Pembimbing"
    description="Monitor kehadiran & aktivitas harian peserta magang"
    icon="fas fa-chalkboard-teacher"
    role="pembimbing"
/>

{{-- ── Stat Cards ── --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', ['value'=>$activeParticipants??0,             'label'=>'Peserta Aktif',   'icon'=>'fa-users',           'color'=>'success','link'=>route('mentor.penugasan')])
    @include('components.dashboard.stat-card', ['value'=>$totalAssignments??0,               'label'=>'Total Tugas',     'icon'=>'fa-clipboard-list',  'color'=>'info',   'link'=>route('mentor.penugasan')])
    @include('components.dashboard.stat-card', ['value'=>$attendanceStats['present']??0,     'label'=>'Hadir Hari Ini',  'icon'=>'fa-calendar-check',  'color'=>'primary'])
    @include('components.dashboard.stat-card', ['value'=>$assignmentsToGrade??0,             'label'=>'Perlu Dinilai',   'icon'=>'fa-clock',           'color'=>'warning','link'=>route('mentor.penugasan')])
</div>

{{-- ── Today's Focus ── --}}
<div class="focus-grid">

    {{-- Tidak Hadir --}}
    @php
        $absentList = $participantOverview->filter(fn($p) => $p['att_status'] === 'Absen');
        $tidakHadir = $absentList->pluck('name');
    @endphp
    <div class="focus-panel">
        <div class="focus-panel-head">
            <div class="focus-panel-icon red"><i class="fas fa-times"></i></div>
            <span class="focus-panel-title">Tidak Hadir Hari Ini</span>
            <span class="focus-panel-count focus-count-red">{{ $tidakHadir->count() }}</span>
        </div>
        @if($tidakHadir->isEmpty())
            <p class="focus-empty"><i class="fas fa-check-circle" style="color:#10B981;margin-right:4px;"></i>Semua hadir</p>
        @else
            <div class="focus-list">
                @foreach($tidakHadir as $name)
                    <div class="focus-list-item">
                        <div class="focus-av">{{ strtoupper(substr($name,0,1)) }}</div>
                        {{ $name }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Belum Submit Logbook (with profile photo) --}}
    <div class="focus-panel">
        <div class="focus-panel-head">
            <div class="focus-panel-icon amber"><i class="fas fa-book"></i></div>
            <span class="focus-panel-title">Belum Submit Logbook</span>
            <span class="focus-panel-count focus-count-amber">{{ $noLogbookToday->count() }}</span>
        </div>
        @if($noLogbookToday->isEmpty())
            <p class="focus-empty"><i class="fas fa-check-circle" style="color:#10B981;margin-right:4px;"></i>Semua sudah submit</p>
        @else
            <div class="focus-list">
                @foreach($noLogbookToday as $person)
                    <div class="focus-list-item">
                        @if(!empty($person['photo']))
                            <img src="{{ Storage::url($person['photo']) }}"
                                 class="focus-photo"
                                 alt="{{ $person['name'] }}"
                                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            <div class="focus-av" style="background:linear-gradient(135deg,#F59E0B,#D97706);display:none;">{{ strtoupper(substr($person['name'],0,1)) }}</div>
                        @else
                            <div class="focus-av" style="background:linear-gradient(135deg,#F59E0B,#D97706);">{{ strtoupper(substr($person['name'],0,1)) }}</div>
                        @endif
                        {{ $person['name'] }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Presentasi Mendatang (7 hari) --}}
    <div class="focus-panel">
        <div class="focus-panel-head">
            <div class="focus-panel-icon blue"><i class="fas fa-chalkboard"></i></div>
            <span class="focus-panel-title">Presentasi Mendatang</span>
            <span class="focus-panel-count focus-count-blue">{{ $upcomingPresentations->count() }}</span>
        </div>
        @if($upcomingPresentations->isEmpty())
            <p class="focus-empty">Tidak ada jadwal presentasi dalam 7 hari</p>
        @else
            <div class="focus-list">
                @foreach($upcomingPresentations->take(4) as $pres)
                    @php $daysLeft = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($pres->presentation_date)->startOfDay(), false); @endphp
                    <div class="focus-list-item pres-item">
                        <div style="display:flex;align-items:center;gap:6px;width:100%;">
                            <span class="pres-badge {{ $daysLeft <= 1 ? 'pres-soon' : 'pres-coming' }}">
                                {{ $daysLeft <= 0 ? 'Hari ini' : ($daysLeft == 1 ? 'Besok' : $daysLeft.' hari') }}
                            </span>
                            <span style="font-size:.78rem;font-weight:600;color:var(--color-gray-700);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ Str::limit($pres->title, 28) }}
                            </span>
                        </div>
                        <span class="pres-meta" style="padding-left:2px;">{{ Str::limit($pres->user->name ?? '-', 25) }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- ── Charts: Antrian Penilaian (left) + Aktivitas Harian (right) ── --}}
<div class="charts-grid">

    {{-- Antrian Penilaian (table, replaces attendance chart) --}}
    <div class="chart-card no-pad">
        <div class="chart-header">
            <h5 class="chart-title">
                <div class="chart-title-icon amber"><i class="fas fa-clock"></i></div>
                Antrian Penilaian
                @if(($assignmentsToGrade ?? 0) > 0)
                    <span style="background:#FEF3C7;color:#1A1A1A;font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:100px;margin-left:4px;">{{ $assignmentsToGrade }}</span>
                @endif
            </h5>
            <a href="{{ route('mentor.penugasan') }}" class="view-all-link" style="font-size:.75rem;">
                Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($pendingGradeList->isEmpty())
            <div style="text-align:center;padding:3rem 1rem;color:var(--color-gray-400);">
                <i class="fas fa-check-circle" style="font-size:2rem;color:#10B981;display:block;margin-bottom:.4rem;"></i>
                <p style="font-size:.82rem;margin:0;">Semua tugas sudah dinilai.</p>
            </div>
        @else
            <div class="grade-queue-body">
                @foreach($pendingGradeList as $assignment)
                    @php $ini = collect(explode(' ', $assignment->user->name ?? 'U'))->take(2)->map(fn($w) => strtoupper($w[0]))->implode(''); @endphp
                    <div class="grade-queue-row">
                        <div class="participant-av">{{ $ini }}</div>
                        <div class="grade-queue-info">
                            <div class="grade-queue-title">{{ Str::limit($assignment->title, 35) }}</div>
                            <div class="grade-queue-meta">{{ Str::limit($assignment->user->name ?? '-', 22) }} &middot; {{ $assignment->updated_at?->diffForHumans() ?? '—' }}</div>
                        </div>
                        <a href="{{ route('mentor.penugasan') }}" class="grade-btn">
                            <i class="fas fa-pen"></i> Nilai
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Aktivitas Harian 7 Hari (dual line) --}}
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">
                <div class="chart-title-icon purple"><i class="fas fa-pen-to-square"></i></div>
                Aktivitas Harian 7 Hari
            </h5>
        </div>
        <div class="chart-container"><canvas id="activityTrendChart"></canvas></div>
        <div class="chart-legend">
            <div class="chart-legend-item"><div class="chart-legend-dot" style="background:#8B5CF6;"></div>Logbook</div>
            <div class="chart-legend-item"><div class="chart-legend-dot" style="background:#3B82F6;"></div>Kumpul Tugas</div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Inter','Segoe UI',sans-serif";
    Chart.defaults.color = '#64748B';

    const actData = @json($activityTrend);
    const labels  = actData.map(d => d.label);

    new Chart(document.getElementById('activityTrendChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label:'Logbook', data:actData.map(d=>d.logbook),
                    borderColor:'#8B5CF6', backgroundColor:'rgba(139,92,246,.12)',
                    tension:.4, fill:true, borderWidth:2.5,
                    pointBackgroundColor:'#8B5CF6', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:4,
                },
                {
                    label:'Kumpul Tugas', data:actData.map(d=>d.tugas),
                    borderColor:'#3B82F6', backgroundColor:'rgba(59,130,246,.08)',
                    tension:.4, fill:true, borderWidth:2.5,
                    pointBackgroundColor:'#3B82F6', pointBorderColor:'#fff', pointBorderWidth:2, pointRadius:4,
                },
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            animation:{duration:900,easing:'easeOutQuart'},
            plugins:{
                legend:{display:false},
                tooltip:{
                    backgroundColor:'rgba(15,23,42,.95)',padding:12,cornerRadius:10,
                    callbacks:{label:ctx=>`${ctx.dataset.label}: ${ctx.raw}`}
                }
            },
            scales:{
                x:{grid:{display:false},ticks:{font:{size:10}}},
                y:{beginAtZero:true,ticks:{stepSize:1,precision:0,font:{size:10}},grid:{color:'rgba(0,0,0,.04)',drawBorder:false}}
            }
        }
    });
});
</script>
@endpush
