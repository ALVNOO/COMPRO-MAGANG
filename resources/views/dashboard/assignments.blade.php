@extends('layouts.dashboard-unified')

@section('title', 'Penugasan & Penilaian')

@php
    $role      = 'participant';
    $pageTitle = 'Tugas';

    $totalAssignments  = $assignments->count();
    $sortedAssignments = $assignments->sortBy('created_at');

    $submittedCount = $assignments->filter(function ($a) {
        if (! $a->submitted_at) return false;
        if ((int) $a->is_revision === 1) {
            $lastSub = $a->submissions ? $a->submissions->sortByDesc('submitted_at')->first() : null;
            if (! $lastSub || ($a->updated_at && $lastSub->submitted_at < $a->updated_at)) return false;
        }
        return true;
    })->count();

    $pendingCount = $totalAssignments - $submittedCount;
    $gradedCount  = $assignments->whereNotNull('grade')->count();
    $avgGrade     = $gradedCount > 0 ? round($assignments->whereNotNull('grade')->avg('grade'), 1) : null;

    $assignmentsJson = $sortedAssignments->map(function ($a) {
        $showRevisi = false;
        if ((int) $a->is_revision === 1) {
            $lastSub = $a->submissions ? $a->submissions->sortByDesc('submitted_at')->first() : null;
            if (! $lastSub || ($a->updated_at && $lastSub->submitted_at < $a->updated_at)) $showRevisi = true;
        }
        return [
            'id'              => $a->id,
            'title'           => $a->title ?? \Illuminate\Support\Str::limit($a->description, 80),
            'description'     => $a->description,
            'assignment_type' => $a->assignment_type,
            'deadline'        => $a->deadline ? $a->deadline->format('d M Y') : null,
            'deadline_raw'    => $a->deadline ? $a->deadline->format('Y-m-d') : null,
            'deadline_passed' => $a->deadline ? $a->deadline->isPast() : false,
            'file_path'       => $a->file_path ? \Illuminate\Support\Facades\Storage::url($a->file_path) : null,
            'grade'           => $a->grade,
            'feedback'        => $a->feedback,
            'submitted_at'    => $a->submitted_at ? $a->submitted_at->format('d M Y H:i') : null,
            'needs_submit'    => ! $a->submitted_at || (int) $a->is_revision === 1,
            'is_revision'     => (int) $a->is_revision === 1 && $showRevisi,
            'submit_url'      => route('dashboard.assignments.submit', $a->id),
        ];
    })->values();

    // ── Calendar ──────────────────────────────────────────────────────────────
    $dayNamesId   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
    $monthNamesId = ['Januari','Februari','Maret','April','Mei','Juni',
                     'Juli','Agustus','September','Oktober','November','Desember'];
    $today   = \Carbon\Carbon::today();
    $calDays = collect();
    for ($i = -4; $i <= 13; $i++) {
        $day = $today->copy()->addDays($i);
        $deadlinesOnDay = $assignments->filter(function ($a) use ($day) {
            return $a->deadline && $a->deadline->copy()->startOfDay()->isSameDay($day);
        });
        $calDays->push([
            'date'      => $day,
            'isToday'   => $i === 0,
            'isWeekend' => $day->isWeekend(),
            'isPast'    => $i < 0,
            'deads'     => $deadlinesOnDay,
        ]);
    }
    $deadlineSummary = $assignments->filter(fn ($a) => $a->deadline)->sortBy('deadline')->values();
@endphp

@push('styles')
<style>
/* ── Stats ─────────────────────────────────────────────────────── */
.asgn-stats {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* ── Horizontal Calendar ────────────────────────────────────────── */
.asgn-cal-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #F0F2F5;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.cal-strip-wrap {
    overflow-x: auto;
    padding: .875rem 1.25rem .5rem;
    scrollbar-width: none;
}
.cal-strip-wrap::-webkit-scrollbar { display: none; }

.cal-strip {
    display: flex;
    gap: .3rem;
    width: max-content;
}

.cal-day-cell {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .15rem;
    width: 54px;
    padding: .45rem .25rem .4rem;
    border-radius: 12px;
    cursor: default;
    transition: background .15s;
}
.cal-day-cell:hover { background: #F8FAFC; }

.cal-dayname {
    font-size: .6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #94A3B8;
}
.cal-day-cell.is-weekend .cal-dayname { color: #CBD5E1; }
.cal-day-cell.is-past    .cal-dayname { color: #D1D5DB; }

.cal-daynum {
    width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem; font-weight: 700; color: #374151;
    border-radius: 50%;
    transition: all .15s;
}
.cal-day-cell.is-past    .cal-daynum { color: #D1D5DB; }
.cal-day-cell.is-weekend .cal-daynum { color: #CBD5E1; }
.cal-day-cell.is-today   .cal-daynum {
    background: #EE2E24;
    color: #fff;
    box-shadow: 0 4px 14px rgba(238,46,36,.32);
}
.cal-day-cell.has-deadline:not(.is-today) .cal-daynum {
    background: #FEF2F2;
    color: #DC2626;
    border: 1.5px solid #FECACA;
}

.cal-dots { display: flex; gap: .2rem; align-items: center; height: 8px; }
.cal-dots-empty { height: 8px; }
.cal-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.cal-dot.upcoming { background: #EE2E24; }
.cal-dot.overdue  { background: #94A3B8; }

/* Deadline chips row */
.cal-dl-row {
    display: flex;
    flex-wrap: wrap;
    gap: .45rem;
    padding: .625rem 1.25rem 1rem;
    border-top: 1px solid #F8FAFC;
}
.cal-dl-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .28rem .75rem;
    border-radius: 20px;
    font-size: .74rem;
    font-weight: 600;
    border: 1px solid transparent;
    white-space: nowrap;
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cal-dl-chip.overdue { background:#FEF2F2; color:#1A1A1A; border-color:#FECACA; }
.cal-dl-chip.urgent  { background:#FFFBEB; color:#1A1A1A; border-color:#FDE68A; }
.cal-dl-chip.normal  { background:#F0FDF4; color:#1A1A1A; border-color:#BBF7D0; }
.cal-dl-chip.done    { background:#F8FAFC; color:#64748B; border-color:#E2E8F0; }
.cal-dl-chip.nodl    { background:#F8FAFC; color:#94A3B8; font-style:italic; }
.cal-dl-chip i       { flex-shrink: 0; font-size: .68rem; }

/* ── Table ──────────────────────────────────────────────────────── */
.asgn-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.asgn-table thead th {
    background: #F9FAFB;
    padding: .75rem 1.125rem;
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #6B7280;
    border-bottom: 1px solid #E5E7EB;
    white-space: nowrap;
}
.asgn-table tbody td {
    padding: .875rem 1.125rem;
    font-size: .875rem;
    color: #374151;
    border-bottom: 1px solid #F3F4F6;
    vertical-align: middle;
}
.asgn-table tbody tr { cursor: pointer; transition: background .15s; }
.asgn-table tbody tr:hover { background: rgba(238,46,36,.025); }
.asgn-table tbody tr:last-child td { border-bottom: none; }

.task-title {
    font-weight: 600; color: #111827;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    max-width: 280px;
}
.type-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .65rem; border-radius: 20px;
    font-size: .72rem; font-weight: 600; white-space: nowrap;
}
.type-badge.harian { background:#BFDBFE; color:#1A1A1A; }
.type-badge.proyek { background:#DDD6FE; color:#1A1A1A; }

.dl-text         { font-size:.8rem; font-weight:500; white-space:nowrap; }
.dl-text.overdue { color:#DC2626; font-weight:700; }
.dl-text.upcoming{ color:#D97706; }
.dl-text.normal  { color:#374151; }

.btn-detail {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.35rem .75rem;
    background:#fff; color:#6B7280;
    border:1.5px solid #E5E7EB; border-radius:8px;
    font-size:.75rem; font-weight:600;
    cursor:pointer; transition:all .18s; white-space:nowrap;
    box-shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
}
.btn-detail:hover {
    border-color:#EE2E24; color:#EE2E24; background:#fff;
    box-shadow: 0 4px 14px rgba(238,46,36,.18), 0 1px 4px rgba(0,0,0,.06);
    transform: translateY(-1px);
}

.empty-center { text-align:center; padding:4rem 2rem; }
.empty-center i  { font-size:2.75rem; color:#D1D5DB; display:block; margin-bottom:1rem; }
.empty-center h4 { font-size:1rem; font-weight:600; color:#374151; margin:0 0 .35rem; }
.empty-center p  { color:#9CA3AF; font-size:.875rem; margin:0; }

/* ================================================================
   MODAL  —  Admin-style two-panel
   ================================================================ */
.pm-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15,23,42,.62);
    backdrop-filter: blur(6px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity .25s ease, visibility .25s ease;
}
.pm-overlay.show {
    opacity: 1;
    visibility: visible;
}
.pm-card {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 820px;
    height: min(90vh, 580px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: translateY(24px) scale(.97);
    transition: transform .28s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 32px 80px rgba(0,0,0,.25), 0 0 0 1px rgba(0,0,0,.06);
}
.pm-overlay.show .pm-card {
    transform: translateY(0) scale(1);
}

/* ── Header ── */
.pm-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .875rem 1.25rem;
    background: linear-gradient(135deg,#EE2E24 0%,#C41E1A 100%);
    flex-shrink: 0;
    gap: .75rem;
}
.pm-head-left {
    display: flex; align-items: center; gap: .6rem;
    min-width: 0; flex: 1;
}
.pm-head-icon {
    width: 32px; height: 32px; border-radius: 8px;
    background: rgba(255,255,255,.18);
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; color: #fff; flex-shrink: 0;
}
.pm-head-title {
    font-size: .9rem; font-weight: 700; color: #fff; margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.pm-head-chips { display:flex; align-items:center; gap:.35rem; flex-shrink:0; }
.pm-chip {
    display:inline-flex; align-items:center; gap:.25rem;
    padding:.18rem .55rem;
    background:rgba(255,255,255,.2);
    border-radius:20px;
    font-size:.68rem; font-weight:600; color:rgba(255,255,255,.92);
    white-space:nowrap;
}
.pm-chip.red   { background:rgba(0,0,0,.2); }
.pm-chip.green { background:rgba(255,255,255,.28); }
.pm-close {
    width:30px; height:30px; border-radius:8px; border:none;
    background:rgba(255,255,255,.18); color:#fff; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    font-size:.8rem; transition:background .15s; flex-shrink:0;
}
.pm-close:hover { background:rgba(255,255,255,.3); }

/* ── Two-panel body ── */
.pm-body {
    display: flex;
    flex: 1;
    overflow: hidden;
    min-height: 0;
}

/* Left: task info + description + file */
.pm-panel-left {
    width: 55%;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #F1F5F9;
    overflow-y: auto;
}
.pm-panel-left::-webkit-scrollbar { width: 3px; }
.pm-panel-left::-webkit-scrollbar-thumb { background:#E5E7EB; border-radius:2px; }

/* Right: grade + feedback + submit */
.pm-panel-right {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* Info grid */
.pm-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .5rem;
    padding: 1rem 1.125rem;
    border-bottom: 1px solid #F1F5F9;
    flex-shrink: 0;
}
.pm-info-item {
    background: #F8FAFC;
    border-radius: 9px;
    padding: .5rem .75rem;
    border: 1px solid #F1F5F9;
}
.pm-info-item.full { grid-column: 1 / -1; }
.pm-info-lbl {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .05em; color: #94A3B8;
    display: flex; align-items: center; gap: .3rem;
    margin-bottom: .2rem;
}
.pm-info-val {
    font-size: .82rem; font-weight: 600; color: #1E293B;
    display: flex; align-items: center; gap: .4rem; flex-wrap: wrap;
}
.pm-info-val.red   { color: #DC2626; }
.pm-info-val.amber { color: #D97706; }
.pm-info-val .sub  { font-size:.72rem; font-weight:400; color:#94A3B8; }

/* Sections */
.pm-section {
    padding: .875rem 1.125rem;
    border-bottom: 1px solid #F8FAFC;
}
.pm-section:last-child { border-bottom: none; }
.pm-section-lbl {
    font-size: .63rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: #94A3B8;
    margin-bottom: .45rem;
    display: flex; align-items: center; gap: .35rem;
}
.pm-section-lbl i { color: #EE2E24; font-size: .55rem; }
.pm-desc    { font-size:.875rem; color:#374151; line-height:1.7; white-space:pre-wrap; word-wrap:break-word; }
.pm-no-data { font-size:.82rem; color:#94A3B8; font-style:italic; }

.pm-file-btn {
    display:inline-flex; align-items:center; gap:.5rem;
    padding:.5rem 1rem;
    background:#EFF6FF; color:#2563EB;
    border:1.5px solid #BFDBFE; border-radius:9px;
    font-size:.8rem; font-weight:600; text-decoration:none; transition:all .18s;
}
.pm-file-btn:hover {
    background:#DBEAFE; color:#1D4ED8;
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(37,99,235,.15);
}

/* Grade section (scrollable area inside right panel) */
.pm-grade-section {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.125rem;
}
.pm-grade-section::-webkit-scrollbar { width: 3px; }
.pm-grade-section::-webkit-scrollbar-thumb { background:#E5E7EB; border-radius:2px; }

.pm-score-box {
    background:linear-gradient(135deg,#FFF1F0,#FFE4E3);
    border:1.5px solid #FECACA; border-radius:12px;
    padding:.75rem 1rem; text-align:center; min-width:72px; flex-shrink:0;
}
.pm-score-num { font-size:1.75rem; font-weight:800; color:#EE2E24; line-height:1; }
.pm-score-max { font-size:.65rem; color:#F87171; font-weight:600; }
.pm-score-empty {
    background:#F8FAFC; border:1.5px solid #E2E8F0; border-radius:12px;
    padding:.75rem 1rem; text-align:center; min-width:72px;
    font-size:.75rem; color:#94A3B8; font-style:italic;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; height:72px;
}
.pm-fb-lbl  { font-size:.62rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#94A3B8; margin-bottom:.3rem; }
.pm-fb-text { font-size:.84rem; color:#374151; line-height:1.65; }

/* Footer */
.pm-foot {
    padding:.875rem 1.125rem;
    background:#F8FAFC;
    border-top:1px solid #F1F5F9;
    flex-shrink:0;
    display:flex; align-items:center; justify-content:space-between; gap:.75rem;
}
.pm-foot-hint { font-size:.7rem; color:#94A3B8; display:flex; align-items:center; gap:.3rem; }
.pm-submit-btn {
    display:inline-flex; align-items:center; gap:.45rem;
    padding:.6rem 1.25rem;
    background:linear-gradient(135deg,#EE2E24,#C41E1A);
    color:#fff; border:none; border-radius:10px;
    font-size:.84rem; font-weight:700; cursor:pointer; transition:all .2s;
    box-shadow:0 4px 14px rgba(238,46,36,.25); flex-shrink:0;
}
.pm-submit-btn:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(238,46,36,.35); }
.pm-done-badge {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.5rem 1rem;
    background:#F0FDF4; color:#16A34A;
    border:1.5px solid #BBF7D0; border-radius:10px;
    font-size:.8rem; font-weight:700;
}

/* File selection confirm state */
.pm-foot-state {
    display: flex;
    gap: .75rem;
    width: 100%;
}
.pm-file-preview {
    display: flex; align-items: center; gap: .65rem;
    flex: 1; min-width: 0;
}
.pm-file-preview > i { font-size: 1.3rem; flex-shrink: 0; }
.pm-file-name {
    font-size: .82rem; font-weight: 600; color: #1E293B;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.pm-file-size { font-size: .7rem; color: #94A3B8; }
.pm-confirm-actions { display: flex; gap: .4rem; flex-shrink: 0; }

.pm-btn-cancel {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.46rem .85rem;
    background:#F8FAFC; color:#6B7280;
    border:1.5px solid #E5E7EB; border-radius:8px;
    font-size:.78rem; font-weight:600; cursor:pointer; transition:all .15s;
}
.pm-btn-cancel:hover { border-color:#DC2626; color:#DC2626; background:#FEF2F2; }

.pm-btn-change {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.46rem .85rem;
    background:#fff; color:#2563EB;
    border:1.5px solid #2563EB; border-radius:8px;
    font-size:.78rem; font-weight:600; cursor:pointer; transition:all .15s;
}
.pm-btn-change:hover { background:#EFF6FF; }

.pm-btn-confirm {
    display:inline-flex; align-items:center; gap:.3rem;
    padding:.46rem .85rem;
    background:linear-gradient(135deg,#EE2E24,#C41E1A);
    color:#fff; border:none; border-radius:8px;
    font-size:.78rem; font-weight:600; cursor:pointer; transition:all .18s;
    box-shadow:0 3px 10px rgba(238,46,36,.22);
}
.pm-btn-confirm:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(238,46,36,.35); }

/* ── Responsive ── */
@media (max-width:1200px) { .asgn-stats { grid-template-columns:repeat(2,1fr); } }
@media (max-width:680px) {
    .asgn-stats { grid-template-columns:repeat(2,1fr); }
    .pm-card  { height:min(96vh,700px); }
    .pm-body  { flex-direction:column; overflow-y:auto; }
    .pm-panel-left  { width:100%; border-right:none; border-bottom:1px solid #F1F5F9; overflow-y:visible; }
    .pm-panel-right { flex:none; overflow:visible; }
    .pm-grade-section { overflow-y:visible; }
}
@media (max-width:480px) {
    .asgn-stats { grid-template-columns:1fr 1fr; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Penugasan & Penilaian"
    description="Kelola tugas dan lihat penilaian dari pembimbing Anda"
    icon="fas fa-clipboard-list"
    role="peserta"
/>

{{-- Stat Cards --}}
<div class="asgn-stats">
    <div class="stat-card stat-card-info">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $totalAssignments }}</div>
                <div class="stat-label">Total Tugas</div>
            </div>
            <div class="stat-icon stat-icon-info"><i class="fas fa-list-check"></i></div>
        </div>
    </div>
    <div class="stat-card stat-card-success">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $submittedCount }}</div>
                <div class="stat-label">Sudah Dikumpulkan</div>
            </div>
            <div class="stat-icon stat-icon-success"><i class="fas fa-circle-check"></i></div>
        </div>
    </div>
    <div class="stat-card stat-card-warning">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $pendingCount }}</div>
                <div class="stat-label">Belum Dikumpulkan</div>
            </div>
            <div class="stat-icon stat-icon-warning"><i class="fas fa-hourglass-half"></i></div>
        </div>
    </div>
    <div class="stat-card stat-card-primary">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $avgGrade !== null ? $avgGrade : '—' }}</div>
                <div class="stat-label">Rata-rata Nilai</div>
            </div>
            <div class="stat-icon stat-icon-primary"><i class="fas fa-star"></i></div>
        </div>
    </div>
</div>

{{-- ── Horizontal Deadline Calendar ── --}}
<div class="asgn-cal-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-calendar-alt"></i>
            <span>Kalender Deadline</span>
        </div>
        <span style="font-size:.8rem;color:#9CA3AF;font-weight:500;">
            {{ $monthNamesId[$today->month - 1] }} {{ $today->year }}
        </span>
    </div>

    <div class="cal-strip-wrap" id="calStripWrap">
        <div class="cal-strip">
            @foreach($calDays as $calDay)
            @php
                $hasDeadline = $calDay['deads']->count() > 0;
                $dotType     = $calDay['isPast'] ? 'overdue' : 'upcoming';
                $cellClasses = implode(' ', array_filter([
                    $calDay['isToday']   ? 'is-today'   : '',
                    $hasDeadline         ? 'has-deadline': '',
                    $calDay['isPast']    ? 'is-past'    : '',
                    $calDay['isWeekend'] ? 'is-weekend' : '',
                ]));
            @endphp
            <div class="cal-day-cell {{ $cellClasses }}">
                <span class="cal-dayname">{{ $dayNamesId[$calDay['date']->dayOfWeek] }}</span>
                <span class="cal-daynum">{{ $calDay['date']->day }}</span>
                @if($hasDeadline)
                    <div class="cal-dots">
                        @for($di = 0; $di < min($calDay['deads']->count(), 3); $di++)
                            <span class="cal-dot {{ $dotType }}"></span>
                        @endfor
                    </div>
                @else
                    <div class="cal-dots-empty"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    {{-- Deadline chips --}}
    <div class="cal-dl-row">
        @php $hasAny = false; @endphp
        @foreach($deadlineSummary as $da)
        @php
            $hasAny = true;
            $showRevisi = false;
            if ((int) $da->is_revision === 1) {
                $lastSub = $da->submissions ? $da->submissions->sortByDesc('submitted_at')->first() : null;
                if (! $lastSub || ($da->updated_at && $lastSub->submitted_at < $da->updated_at)) $showRevisi = true;
            }
            $isDone   = $da->submitted_at && ! $showRevisi;
            $dl       = $da->deadline->copy()->startOfDay();
            $todayS   = \Carbon\Carbon::today();
            if ($dl->isSameDay($todayS))     $daysLeft = 0;
            elseif ($dl->isAfter($todayS))   $daysLeft = (int) $todayS->diffInDays($dl);
            else                             $daysLeft = -(int) $todayS->diffInDays($dl);
            $isOverdue  = ! $isDone && $daysLeft < 0;
            $chipClass  = $isDone ? 'done' : ($isOverdue ? 'overdue' : ($daysLeft <= 3 ? 'urgent' : 'normal'));
            $chipIcon   = $isDone ? 'fa-check-circle' : ($isOverdue ? 'fa-exclamation-triangle' : 'fa-clock');
            $chipLabel  = $isDone
                ? 'Dikumpulkan'
                : ($isOverdue
                    ? 'Terlambat '.abs($daysLeft).' hari'
                    : ($daysLeft === 0 ? 'Hari ini!' : $daysLeft.' hari lagi'));
            $daTitle    = $da->title ?? \Illuminate\Support\Str::limit($da->description, 35);
        @endphp
        <span class="cal-dl-chip {{ $chipClass }}">
            <i class="fas {{ $chipIcon }}"></i>
            {{ $daTitle }}
            <span style="opacity:.65;font-size:.68rem;">· {{ $chipLabel }}</span>
        </span>
        @endforeach
        @if(! $hasAny)
        <span class="cal-dl-chip nodl">Tidak ada deadline yang tercatat</span>
        @endif
    </div>
</div>

{{-- ── Task Table ── --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-tasks"></i>
            <span>Daftar Tugas</span>
        </div>
        <span class="badge badge-gray">{{ $totalAssignments }} tugas</span>
    </div>

    @if($totalAssignments > 0)
    <div style="overflow-x:auto;">
        <table class="asgn-table">
            <thead>
                <tr>
                    <th style="width:50px;text-align:center;">No</th>
                    <th style="text-align:left;min-width:160px;">Judul Tugas</th>
                    <th style="width:110px;text-align:center;">Jenis</th>
                    <th style="width:130px;text-align:center;">Deadline</th>
                    <th style="width:160px;text-align:center;">Status</th>
                    <th style="width:80px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($sortedAssignments as $assignment)
                @php
                    $showRevisi = false;
                    if ((int) $assignment->is_revision === 1) {
                        $lastSub = $assignment->submissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;
                        if (! $lastSub || ($assignment->updated_at && $lastSub->submitted_at < $assignment->updated_at)) {
                            $showRevisi = true;
                        }
                    }
                    $isOverdue  = $assignment->deadline && \Carbon\Carbon::parse($assignment->deadline)->isPast() && ! $assignment->submitted_at;
                    $isUpcoming = $assignment->deadline
                        && \Carbon\Carbon::parse($assignment->deadline)->diffInDays(now()) <= 3
                        && \Carbon\Carbon::parse($assignment->deadline)->isFuture();

                    if ($assignment->grade !== null) {
                        $stClass = 'status-graded';   $stIcon = 'fa-star';         $stText = 'Sudah Dinilai';
                    } elseif ($showRevisi) {
                        $stClass = 'status-revision_required'; $stIcon = 'fa-redo'; $stText = 'Perlu Revisi';
                    } elseif ($assignment->submitted_at) {
                        $stClass = 'status-submitted'; $stIcon = 'fa-check-circle'; $stText = 'Dikumpulkan';
                    } else {
                        $stClass = 'status-pending';   $stIcon = 'fa-clock';        $stText = 'Belum Dikumpulkan';
                    }
                @endphp
                <tr onclick="openPopup({{ $assignment->id }})">
                    <td style="text-align:center;font-weight:600;color:#9CA3AF;font-size:.8rem;">{{ $no++ }}</td>
                    <td><div class="task-title">{{ $assignment->title ?? Str::limit($assignment->description, 60) }}</div></td>
                    <td style="text-align:center;">
                        @if($assignment->assignment_type === 'tugas_harian')
                            <span class="type-badge harian"><i class="fas fa-calendar-day"></i> Harian</span>
                        @else
                            <span class="type-badge proyek"><i class="fas fa-project-diagram"></i> Proyek</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        @if($assignment->deadline)
                            <span class="dl-text {{ $isOverdue ? 'overdue' : ($isUpcoming ? 'upcoming' : 'normal') }}">
                                @if($isOverdue)<i class="fas fa-exclamation-triangle"></i> @endif
                                {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                            </span>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span class="status-badge {{ $stClass }}">
                            <i class="fas {{ $stIcon }}"></i> {{ $stText }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <button type="button" class="btn-detail" onclick="event.stopPropagation();openPopup({{ $assignment->id }})">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-center">
        <i class="fas fa-clipboard-list"></i>
        <h4>Belum Ada Tugas</h4>
        <p>Tugas dari pembimbing akan muncul di sini setelah diberikan.</p>
    </div>
    @endif
</div>

{{-- ================================================================
     MODAL — Admin-style two-panel
     ================================================================ --}}
<div class="pm-overlay" id="pmOverlay">
    <div class="pm-card">

        {{-- Slim header --}}
        <div class="pm-head">
            <div class="pm-head-left">
                <div class="pm-head-icon"><i class="fas fa-tasks" id="pmTypeIcon"></i></div>
                <h3 class="pm-head-title" id="pmTitle"></h3>
            </div>
            <div class="pm-head-chips" id="pmChips"></div>
            <button type="button" class="pm-close" onclick="closePopup()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Two-panel body --}}
        <div class="pm-body">

            {{-- Left: info grid + description + file --}}
            <div class="pm-panel-left">
                <div class="pm-info-grid" id="pmInfoGrid"></div>

                <div class="pm-section">
                    <div class="pm-section-lbl"><i class="fas fa-circle"></i> Deskripsi Tugas</div>
                    <div id="pmDesc"></div>
                </div>

                <div class="pm-section">
                    <div class="pm-section-lbl"><i class="fas fa-circle"></i> File Referensi</div>
                    <div id="pmFile"></div>
                </div>
            </div>

            {{-- Right: grade + feedback + submit --}}
            <div class="pm-panel-right">
                <div class="pm-grade-section">
                    <div class="pm-section-lbl" style="font-size:.63rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#94A3B8;margin-bottom:.75rem;display:flex;align-items:center;gap:.35rem;">
                        <i class="fas fa-circle" style="color:#EE2E24;font-size:.55rem;"></i> Nilai &amp; Feedback
                    </div>
                    <div id="pmGrade"></div>
                </div>
                <div class="pm-foot" id="pmFoot"></div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const _assignments = @json($assignmentsJson);
const _csrf        = '{{ csrf_token() }}';

function openPopup(id) {
    const d = _assignments.find(a => a.id === id);
    if (!d) return;

    const isHarian  = d.assignment_type === 'tugas_harian';
    const typeLabel = isHarian ? 'Harian' : 'Proyek';
    const typeIcon  = isHarian ? 'fa-calendar-day' : 'fa-project-diagram';

    // ── Header ──────────────────────────────────────────────────────
    document.getElementById('pmTypeIcon').className = 'fas ' + typeIcon;
    document.getElementById('pmTitle').textContent  = d.title || 'Tugas';

    let chips = '';
    if (d.submitted_at && !d.is_revision) chips += `<span class="pm-chip green"><i class="fas fa-check"></i> Dikumpulkan</span>`;
    if (d.is_revision)                    chips += `<span class="pm-chip red"><i class="fas fa-redo"></i> Perlu Revisi</span>`;
    if (d.deadline_passed && d.needs_submit && !d.is_revision)
                                          chips += `<span class="pm-chip red"><i class="fas fa-exclamation-triangle"></i> Terlambat</span>`;
    document.getElementById('pmChips').innerHTML = chips;

    // ── Info grid (left panel top) ───────────────────────────────
    const stMap = {
        pending:  { cls:'status-pending',           icon:'fa-clock',        lbl:'Belum Dikumpulkan' },
        submitted:{ cls:'status-submitted',         icon:'fa-check-circle', lbl:'Dikumpulkan' },
        revision: { cls:'status-revision_required', icon:'fa-redo',         lbl:'Perlu Revisi' },
        graded:   { cls:'status-graded',            icon:'fa-star',         lbl:'Sudah Dinilai' },
    };
    let stKey = 'pending';
    if (d.grade !== null) stKey = 'graded';
    else if (d.is_revision) stKey = 'revision';
    else if (d.submitted_at) stKey = 'submitted';
    const st = stMap[stKey];

    const dlValClass = (d.deadline_passed && d.needs_submit) ? 'red' : '';
    const submittedSub = d.submitted_at
        ? `<span class="sub">· Dikumpulkan ${d.submitted_at}</span>` : '';

    document.getElementById('pmInfoGrid').innerHTML = `
        <div class="pm-info-item">
            <div class="pm-info-lbl"><i class="fas ${typeIcon}"></i> Jenis Tugas</div>
            <div class="pm-info-val">${typeLabel}</div>
        </div>
        <div class="pm-info-item">
            <div class="pm-info-lbl"><i class="fas fa-calendar-alt"></i> Deadline</div>
            <div class="pm-info-val ${dlValClass}">${d.deadline || '—'}</div>
        </div>
        <div class="pm-info-item full">
            <div class="pm-info-lbl"><i class="fas fa-info-circle"></i> Status</div>
            <div class="pm-info-val">
                <span class="status-badge ${st.cls}" style="font-size:.72rem;">
                    <i class="fas ${st.icon}"></i> ${st.lbl}
                </span>
                ${submittedSub}
            </div>
        </div>`;

    // ── Description ──────────────────────────────────────────────
    document.getElementById('pmDesc').innerHTML = d.description
        ? `<div class="pm-desc">${esc(d.description)}</div>`
        : `<div class="pm-no-data">Tidak ada deskripsi tugas.</div>`;

    // ── File ─────────────────────────────────────────────────────
    document.getElementById('pmFile').innerHTML = d.file_path
        ? `<a href="${d.file_path}" target="_blank" class="pm-file-btn">
               <i class="fas fa-arrow-down"></i> Unduh File Referensi
           </a>`
        : `<span class="pm-no-data">Tidak ada file referensi.</span>`;

    // ── Grade & feedback (right panel) ───────────────────────────
    const scoreHtml = d.grade !== null
        ? `<div class="pm-score-box">
               <div class="pm-score-num">${d.grade}</div>
               <div class="pm-score-max">/100</div>
           </div>`
        : `<div class="pm-score-empty">Belum<br>dinilai</div>`;
    const fbHtml = d.feedback
        ? `<div class="pm-fb-text">${esc(d.feedback)}</div>`
        : `<div class="pm-no-data">Belum ada feedback dari pembimbing.</div>`;

    document.getElementById('pmGrade').innerHTML = `
        <div style="display:flex;gap:1rem;align-items:flex-start;">
            ${scoreHtml}
            <div style="flex:1;min-width:0;">
                <div class="pm-fb-lbl">Feedback Pembimbing</div>
                ${fbHtml}
            </div>
        </div>`;

    // ── Footer (submit / done) ───────────────────────────────────
    const foot = document.getElementById('pmFoot');
    if (d.needs_submit) {
        const pickLbl = d.is_revision
            ? '<i class="fas fa-redo"></i> Pilih File Revisi'
            : '<i class="fas fa-upload"></i> Pilih File';
        foot.innerHTML = `
            <div class="pm-foot-state" id="pmFootPick" style="align-items:center;justify-content:space-between;">
                <span class="pm-foot-hint"><i class="fas fa-info-circle"></i> PDF, DOC, DOCX · Maks. 2MB</span>
                <form id="pmSubmitForm" action="${d.submit_url}" method="POST" enctype="multipart/form-data" style="margin:0;">
                    <input type="hidden" name="_token" value="${_csrf}">
                    <label class="pm-submit-btn" style="cursor:pointer;">
                        ${pickLbl}
                        <input type="file" id="pmFileInput" name="submission_file" accept=".pdf,.doc,.docx"
                               style="display:none;" onchange="handleFileSelect(this)" required>
                    </label>
                </form>
            </div>
            <div class="pm-foot-state" id="pmFootConfirm" style="display:none;flex-direction:column;gap:.55rem;align-items:stretch;">
                <div class="pm-file-preview">
                    <i id="pmFileIcon" class="fas fa-file-alt" style="color:#6B7280;"></i>
                    <div style="min-width:0;flex:1;">
                        <div class="pm-file-name" id="pmFileName"></div>
                        <div class="pm-file-size" id="pmFileSize"></div>
                    </div>
                </div>
                <div class="pm-confirm-actions" style="justify-content:flex-end;">
                    <button type="button" class="pm-btn-cancel" onclick="cancelFileSelect()">
                        <i class="fas fa-times"></i> Batalkan
                    </button>
                    <button type="button" class="pm-btn-change" onclick="triggerFileChange()">
                        <i class="fas fa-sync-alt"></i> Ubah File
                    </button>
                    <button type="button" class="pm-btn-confirm" onclick="confirmFileSubmit()">
                        <i class="fas fa-check"></i> Kumpulkan
                    </button>
                </div>
            </div>`;
    } else {
        foot.innerHTML = `
            <div></div>
            <span class="pm-done-badge"><i class="fas fa-check-circle"></i> Tugas Sudah Dikumpulkan</span>`;
    }

    document.getElementById('pmOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closePopup() {
    document.getElementById('pmOverlay').classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('pmOverlay').addEventListener('click', function (e) {
    if (e.target === this) closePopup();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closePopup();
});

function esc(t) {
    const d = document.createElement('div');
    d.textContent = t;
    return d.innerHTML;
}

// ── File selection confirm flow ──────────────────────────────────
function handleFileSelect(input) {
    if (!input.files || !input.files.length) return;
    const file = input.files[0];
    const ext  = file.name.split('.').pop().toLowerCase();
    const iconClass = ext === 'pdf' ? 'fa-file-pdf' : 'fa-file-word';
    const iconColor = ext === 'pdf' ? '#EE2E24'     : '#2563EB';

    const icon = document.getElementById('pmFileIcon');
    icon.className  = 'fas ' + iconClass;
    icon.style.color = iconColor;
    document.getElementById('pmFileName').textContent = file.name;
    document.getElementById('pmFileSize').textContent = fmtSize(file.size);

    document.getElementById('pmFootPick').style.display    = 'none';
    document.getElementById('pmFootConfirm').style.display = 'flex';
}

function cancelFileSelect() {
    const inp = document.getElementById('pmFileInput');
    if (inp) inp.value = '';
    document.getElementById('pmFootPick').style.display    = 'flex';
    document.getElementById('pmFootConfirm').style.display = 'none';
}

function triggerFileChange() {
    const inp = document.getElementById('pmFileInput');
    if (inp) inp.click();
}

function confirmFileSubmit() {
    const form = document.getElementById('pmSubmitForm');
    if (form) form.submit();
}

function fmtSize(b) {
    if (b < 1024)    return b + ' B';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
    return (b / 1048576).toFixed(1) + ' MB';
}

// Auto-scroll calendar so today is centered
(function () {
    const wrap  = document.getElementById('calStripWrap');
    const today = wrap && wrap.querySelector('.is-today');
    if (!wrap || !today) return;
    wrap.scrollLeft = today.offsetLeft - wrap.clientWidth / 2 + today.offsetWidth / 2;
})();
</script>
@endpush
