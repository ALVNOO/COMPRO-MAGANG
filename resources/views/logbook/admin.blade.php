{{--
    ADMIN LOGBOOK PAGE — master-detail layout
    Left: sticky participant list | Right: selected participant's logbooks
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Logbook Peserta')

@php
    use Carbon\Carbon;
    $role = 'admin';

    $totalParticipants = $participants->count();
    $totalLogbooks     = $participants->sum(fn($p) => $p['logbooks']->count());
    $avgLogbooks       = $totalParticipants > 0 ? round($totalLogbooks / $totalParticipants, 1) : 0;
@endphp

@push('styles')
<style>
/* ── Stats ── */
.lb-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.lb-stat {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    padding: 1.125rem 1.375rem;
    display: flex; align-items: center; gap: 1rem;
}

.lb-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.lb-stat-icon.red   { background: rgba(238,46,36,.1); color: #EE2E24; }
.lb-stat-icon.blue  { background: rgba(37,99,235,.1);  color: #2563EB; }
.lb-stat-icon.green { background: rgba(22,163,74,.1);  color: #16A34A; }

.lb-stat-val { font-size: 1.625rem; font-weight: 700; color: #111827; line-height: 1; margin-bottom: .2rem; }
.lb-stat-lbl { font-size: .75rem; color: #6B7280; font-weight: 500; }

/* ── Filter bar ── */
.lb-filter {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    padding: .875rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: flex-end; gap: .875rem; flex-wrap: wrap;
}

.lb-filter-group { display: flex; flex-direction: column; gap: .3rem; }

.lb-filter-group label {
    font-size: .7rem; font-weight: 600; color: #9CA3AF;
    text-transform: uppercase; letter-spacing: .05em;
}

.lb-filter-group select {
    padding: .575rem .875rem;
    border: 1.5px solid #E5E7EB; border-radius: 10px;
    font-size: .875rem; background: #F9FAFB; color: #111827;
    min-width: 190px; transition: border-color .15s;
}

.lb-filter-group select:focus {
    outline: none; border-color: #EE2E24;
    background: #fff; box-shadow: 0 0 0 3px rgba(238,46,36,.07);
}

.lb-filter-actions {
    display: flex;
    gap: .5rem;
    margin-left: auto;
    align-items: flex-end;
}

.lb-btn-reset {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .575rem 1rem;
    background: #F3F4F6;
    color: #374151;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: .875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all .15s;
    white-space: nowrap;
}
.lb-btn-reset:hover { background: #E5E7EB; color: #111827; }

/* ── Master-detail layout ── */
.lb-master-detail {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 1.25rem;
    align-items: start;
}

/* ── Left: participant list panel ── */
.lb-list-panel {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
    position: sticky;
    top: 80px; /* below header */
    max-height: calc(100vh - 100px);
    display: flex; flex-direction: column;
}

.lb-list-header {
    padding: .875rem 1rem;
    border-bottom: 1px solid #F3F4F6;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}

.lb-list-title { font-size: .85rem; font-weight: 700; color: #111827; }
.lb-list-count { font-size: .72rem; color: #9CA3AF; }

/* Client-side search in left panel */
.lb-list-search {
    padding: .625rem 1rem;
    border-bottom: 1px solid #F3F4F6;
    flex-shrink: 0;
}

.lb-search-input {
    width: 100%;
    padding: .525rem .75rem .525rem 2.25rem;
    border: 1.5px solid #E5E7EB; border-radius: 9px;
    font-size: .8rem; background: #F9FAFB; color: #111827;
    transition: border-color .15s; box-sizing: border-box;
}

.lb-search-input:focus { outline: none; border-color: #EE2E24; background: #fff; }

.lb-search-wrap { position: relative; }
.lb-search-icon { position: absolute; left: .7rem; top: 50%; transform: translateY(-50%); color: #9CA3AF; font-size: .78rem; }

.lb-list-scroll { overflow-y: auto; flex: 1; }

/* Participant item in left panel */
.lb-p-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #F9FAFB;
    transition: background .12s;
    user-select: none;
}

.lb-p-item:hover { background: #FEF9F9; }
.lb-p-item.active { background: #FEF2F2; border-right: 3px solid #EE2E24; }

.lb-p-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; font-size: .8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}

.lb-p-avatar img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.lb-p-item.active .lb-p-avatar {
    background: linear-gradient(135deg, #C41E1A, #9B1C1C);
}

.lb-p-info { flex: 1; min-width: 0; }
.lb-p-name { font-size: .8rem; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lb-p-sub  { font-size: .7rem; color: #9CA3AF; margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.lb-p-badge {
    flex-shrink: 0;
    min-width: 22px; height: 22px;
    border-radius: 9999px;
    background: #F3F4F6; color: #9CA3AF;
    font-size: .65rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    padding: 0 .4rem;
}

.lb-p-item.active .lb-p-badge { background: #EE2E24; color: #fff; }

.lb-no-results {
    padding: 2rem 1rem; text-align: center;
    font-size: .8rem; color: #9CA3AF;
    display: none;
}

/* ── Right: detail panel ── */
.lb-detail-panel { min-width: 0; }

/* Detail header card */
.lb-detail-header {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1.25rem;
}

.lb-detail-avatar {
    width: 56px; height: 56px; border-radius: 14px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; font-size: 1.3rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.lb-detail-name { font-size: 1.05rem; font-weight: 700; color: #111827; margin-bottom: .375rem; }

.lb-detail-chips { display: flex; flex-wrap: wrap; gap: .4rem; }

.lb-chip {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .25rem .65rem;
    border-radius: 9999px; border: 1.5px solid transparent;
    font-size: .72rem; font-weight: 600;
}

.lb-chip.div    { background: #DBEAFE; color: #1D4ED8; border-color: #93C5FD; }
.lb-chip.mentor { background: #F3E8FF; color: #7E22CE; border-color: #C4B5FD; }
.lb-chip.count  { background: #DCFCE7; color: #15803D; border-color: #86EFAC; }

.lb-detail-count {
    margin-left: auto; flex-shrink: 0;
    text-align: right;
}

.lb-detail-count-num { font-size: 2rem; font-weight: 700; color: #EE2E24; line-height: 1; }
.lb-detail-count-lbl { font-size: .72rem; color: #9CA3AF; }

/* Logbook table card */
.lb-table-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
}

.lb-table-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: .875rem 1.25rem;
    border-bottom: 1px solid #F3F4F6;
}

.lb-table-card-title { font-size: .875rem; font-weight: 700; color: #111827; display: flex; align-items: center; gap: .5rem; }
.lb-table-card-title i { color: #EE2E24; }

/* Logbook rows */
.lb-row {
    display: grid;
    grid-template-columns: 130px 1fr;
    border-bottom: 1px solid #F9FAFB;
}

.lb-row:last-child { border-bottom: none; }

.lb-row-date {
    padding: 1rem 1.25rem;
    border-right: 1px solid #F3F4F6;
    background: #FAFAFA;
    display: flex; flex-direction: column; gap: .25rem;
    align-items: center; justify-content: center; text-align: center;
}

.lb-row-day  { font-size: .75rem; font-weight: 700; color: #374151; }
.lb-row-date-num { font-size: 1.5rem; font-weight: 700; color: #EE2E24; line-height: 1; }
.lb-row-month { font-size: .7rem; color: #9CA3AF; }

.lb-row-content {
    padding: 1rem 1.25rem;
    font-size: .875rem; color: #374151; line-height: 1.65;
    white-space: pre-wrap; word-break: break-word;
}

/* Empty states */
.lb-empty {
    text-align: center; padding: 3.5rem 2rem;
}

.lb-empty i { font-size: 2.5rem; color: #E5E7EB; display: block; margin-bottom: .875rem; }
.lb-empty h4 { font-size: .95rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.lb-empty p  { font-size: .8rem; color: #9CA3AF; margin: 0; }

/* Welcome state (nothing selected) */
.lb-welcome {
    background: #fff; border-radius: 16px; border: 1px solid #E5E7EB;
    text-align: center; padding: 5rem 2rem;
}
.lb-welcome i { font-size: 3rem; color: #F3F4F6; display: block; margin-bottom: 1rem; }
.lb-welcome h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .375rem; }
.lb-welcome p  { font-size: .85rem; color: #9CA3AF; margin: 0; }

/* Main empty */
.lb-main-empty {
    background: #fff; border-radius: 16px; border: 1px solid #E5E7EB;
    text-align: center; padding: 5rem 2rem;
}
.lb-main-empty i { font-size: 3rem; color: #E5E7EB; display: block; margin-bottom: 1rem; }
.lb-main-empty h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.lb-main-empty p  { font-size: .85rem; color: #9CA3AF; margin: 0; }

/* Responsive */
@media (max-width: 900px) {
    .lb-master-detail { grid-template-columns: 1fr; }
    .lb-list-panel { position: static; max-height: 320px; }
}

@media (max-width: 640px) {
    .lb-stats { grid-template-columns: 1fr 1fr; }
    .lb-stats .lb-stat:last-child { grid-column: span 2; }
    .lb-filter { flex-direction: column; align-items: stretch; }
    .lb-filter-actions { margin-left: 0; }
    .lb-filter-group select { min-width: 0; }
    .lb-row { grid-template-columns: 100px 1fr; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Logbook Peserta"
    description="Pantau catatan harian peserta magang — pilih peserta di kiri untuk melihat logbook"
    icon="fas fa-book-open"
    role="admin"
/>

{{-- Stats --}}
<div class="lb-stats">
    <div class="lb-stat">
        <div class="lb-stat-icon red"><i class="fas fa-users"></i></div>
        <div>
            <div class="lb-stat-val">{{ $totalParticipants }}</div>
            <div class="lb-stat-lbl">Peserta Aktif</div>
        </div>
    </div>
    <div class="lb-stat">
        <div class="lb-stat-icon blue"><i class="fas fa-book"></i></div>
        <div>
            <div class="lb-stat-val">{{ $totalLogbooks }}</div>
            <div class="lb-stat-lbl">Total Logbook</div>
        </div>
    </div>
    <div class="lb-stat">
        <div class="lb-stat-icon green"><i class="fas fa-chart-line"></i></div>
        <div>
            <div class="lb-stat-val">{{ $avgLogbooks }}</div>
            <div class="lb-stat-lbl">Rata-rata per Peserta</div>
        </div>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.logbook') }}" id="lbFilterForm" class="lb-filter">
    <div class="lb-filter-group">
        <label>Divisi</label>
        <select name="division_id" id="lb_division">
            <option value="">Semua Divisi</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                    {{ $division->division_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="lb-filter-group">
        <label>Pembimbing</label>
        <select name="mentor_id" id="lb_mentor">
            <option value="">Semua Pembimbing</option>
            @foreach($mentors as $mentor)
                <option value="{{ $mentor->id }}" {{ $filterMentor == $mentor->id ? 'selected' : '' }}>
                    {{ $mentor->mentor_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="lb-filter-actions">
        <a href="{{ route('admin.logbook') }}" class="lb-btn-reset">
            <i class="fas fa-rotate-left"></i> Reset
        </a>
    </div>
</form>

{{-- Master-detail --}}
@if($participants->count() > 0)
<div class="lb-master-detail" id="lbMasterDetail">

    {{-- Left: participant list --}}
    <div class="lb-list-panel">
        <div class="lb-list-header">
            <span class="lb-list-title">Peserta</span>
            <span class="lb-list-count">{{ $totalParticipants }} orang</span>
        </div>
        <div class="lb-list-search">
            <div class="lb-search-wrap">
                <i class="fas fa-magnifying-glass lb-search-icon"></i>
                <input type="text" class="lb-search-input" id="lbSearch"
                       placeholder="Cari nama peserta…"
                       oninput="filterParticipants(this.value)">
            </div>
        </div>
        <div class="lb-list-scroll" id="lbListScroll">
            @foreach($participants as $idx => $participant)
            @php
                $pNames = explode(' ', $participant['user']->name);
                $pInit  = strtoupper(substr($pNames[0], 0, 1)) . (isset($pNames[1]) ? strtoupper(substr($pNames[1], 0, 1)) : '');
                $divName    = $participant['application']->divisionAdmin->division_name ?? null;
                $mentorName = $participant['application']->divisionMentor->mentor_name  ?? null;
                $lbCount    = $participant['logbooks']->count();
            @endphp
            <div class="lb-p-item {{ $idx === 0 ? 'active' : '' }}"
                 data-idx="{{ $idx }}"
                 data-name="{{ strtolower($participant['user']->name) }}"
                 onclick="selectParticipant({{ $idx }}, this)">
                <div class="lb-p-avatar">
                    @if($participant['user']->profile_picture)
                        <img src="{{ asset('storage/' . $participant['user']->profile_picture) }}" alt="{{ $participant['user']->name }}">
                    @else
                        {{ $pInit }}
                    @endif
                </div>
                <div class="lb-p-info">
                    <div class="lb-p-name">{{ $participant['user']->name }}</div>
                    <div class="lb-p-sub">
                        @if($mentorName){{ $mentorName }}@elseif($divName){{ $divName }}@else—@endif
                    </div>
                </div>
                <div class="lb-p-badge">{{ $lbCount }}</div>
            </div>
            @endforeach
            <div class="lb-no-results" id="lbNoResults">
                <i class="fas fa-magnifying-glass" style="font-size:1.25rem;color:#D1D5DB;display:block;margin-bottom:.5rem;"></i>
                Tidak ditemukan
            </div>
        </div>
    </div>

    {{-- Right: detail panels --}}
    <div class="lb-detail-panel" id="lbDetailPanel">
        @foreach($participants as $idx => $participant)
        @php
            $pNames2  = explode(' ', $participant['user']->name);
            $pInit2   = strtoupper(substr($pNames2[0], 0, 1)) . (isset($pNames2[1]) ? strtoupper(substr($pNames2[1], 0, 1)) : '');
            $divName2    = $participant['application']->divisionAdmin->division_name    ?? null;
            $mentorName2 = $participant['application']->divisionMentor->mentor_name    ?? null;
            $lbCount2    = $participant['logbooks']->count();
        @endphp
        <div class="lb-detail-section" id="lb-detail-{{ $idx }}"
             style="{{ $idx !== 0 ? 'display:none;' : '' }}">

            {{-- Participant info header --}}
            <div class="lb-detail-header">
                <div class="lb-detail-avatar">{{ $pInit2 }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="lb-detail-name">{{ $participant['user']->name }}</div>
                    <div class="lb-detail-chips">
                        @if($divName2)
                            <span class="lb-chip div"><i class="fas fa-building"></i>{{ $divName2 }}</span>
                        @endif
                        @if($mentorName2)
                            <span class="lb-chip mentor"><i class="fas fa-user-tie"></i>{{ $mentorName2 }}</span>
                        @endif
                        <span class="lb-chip count"><i class="fas fa-book"></i>{{ $lbCount2 }} logbook</span>
                    </div>
                </div>
                <div class="lb-detail-count">
                    <div class="lb-detail-count-num">{{ $lbCount2 }}</div>
                    <div class="lb-detail-count-lbl">Logbook</div>
                </div>
            </div>

            {{-- Logbook list --}}
            <div class="lb-table-card">
                <div class="lb-table-card-head">
                    <div class="lb-table-card-title">
                        <i class="fas fa-list"></i> Catatan Harian
                    </div>
                    @if($lbCount2 > 0)
                        <span class="badge badge-gray">{{ $lbCount2 }} entri</span>
                    @endif
                </div>

                @if($lbCount2 > 0)
                    @foreach($participant['logbooks'] as $logbook)
                    @php
                        $lbDate = $logbook->date ? Carbon::parse($logbook->date) : null;
                    @endphp
                    <div class="lb-row">
                        <div class="lb-row-date">
                            @if($lbDate)
                                <div class="lb-row-day">{{ $lbDate->locale('id')->isoFormat('dddd') }}</div>
                                <div class="lb-row-date-num">{{ $lbDate->format('d') }}</div>
                                <div class="lb-row-month">{{ $lbDate->locale('id')->isoFormat('MMM YYYY') }}</div>
                            @else
                                <div class="lb-row-day">—</div>
                            @endif
                        </div>
                        <div class="lb-row-content">{{ $logbook->content ?? '-' }}</div>
                    </div>
                    @endforeach
                @else
                    <div class="lb-empty">
                        <i class="fas fa-book-open"></i>
                        <h4>Belum Ada Logbook</h4>
                        <p>Peserta ini belum mengisi catatan harian</p>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

</div>
@else
<div class="lb-main-empty">
    <i class="fas fa-book"></i>
    <h4>Tidak Ada Data</h4>
    <p>Belum ada peserta aktif yang cocok dengan filter yang dipilih</p>
</div>
@endif

@endsection

@push('scripts')
<script>
function selectParticipant(idx, el) {
    // Deactivate all list items
    document.querySelectorAll('.lb-p-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');

    // Hide all detail sections
    document.querySelectorAll('.lb-detail-section').forEach(s => s.style.display = 'none');
    const detail = document.getElementById('lb-detail-' + idx);
    if (detail) detail.style.display = '';

    // Scroll detail panel to top
    document.getElementById('lbDetailPanel').scrollTop = 0;
}

function filterParticipants(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.lb-p-item[data-name]');
    let visible = 0;

    items.forEach(item => {
        const name = item.getAttribute('data-name') || '';
        if (!q || name.includes(q)) {
            item.style.display = '';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('lbNoResults').style.display = visible === 0 ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', function () {
    // Division change → fetch mentors then submit
    const divSel  = document.getElementById('lb_division');
    const mentSel = document.getElementById('lb_mentor');
    const form    = document.getElementById('lbFilterForm');

    if (divSel) {
        divSel.addEventListener('change', function () {
            const divId = this.value;
            const currentMentor = '{{ $filterMentor }}';

            fetch(`{{ route('admin.logbook.mentors') }}?division_id=${divId}`)
                .then(r => r.json())
                .then(data => {
                    mentSel.innerHTML = '<option value="">Semua Pembimbing</option>';
                    data.mentors.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = m.mentor_name;
                        if (m.id == currentMentor) opt.selected = true;
                        mentSel.appendChild(opt);
                    });
                    form.submit();
                })
                .catch(() => form.submit());
        });
    }

    // Auto-submit when mentor dropdown changes
    if (mentSel) {
        mentSel.addEventListener('change', () => form.submit());
    }
});
</script>
@endpush
