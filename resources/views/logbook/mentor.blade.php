{{--
    MENTOR LOGBOOK PAGE — master-detail layout
    Left: sticky participant list | Right: selected participant's logbooks + WA shortcut
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Logbook Peserta Magang')

@php
    use Carbon\Carbon;
    $role = 'mentor';

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

/* ── Master-detail layout ── */
.lb-master-detail {
    display: grid;
    grid-template-columns: 280px 1fr;
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
    top: 80px;
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

/* Participant item */
.lb-p-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem;
    cursor: pointer;
    border-bottom: 1px solid #F9FAFB;
    transition: background .12s;
    user-select: none;
}
.lb-p-item:hover  { background: #FEF9F9; }
.lb-p-item.active { background: #FEF2F2; border-right: 3px solid #EE2E24; }

.lb-p-avatar {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; font-size: .8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}
.lb-p-item.active .lb-p-avatar { background: linear-gradient(135deg, #C41E1A, #9B1C1C); }

.lb-p-info { flex: 1; min-width: 0; }
.lb-p-name { font-size: .8rem; font-weight: 600; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.lb-p-sub  { font-size: .7rem; color: #9CA3AF; margin-top: .1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.lb-p-right { display: flex; align-items: center; gap: .375rem; flex-shrink: 0; }

.lb-p-badge {
    min-width: 22px; height: 22px;
    border-radius: 9999px;
    background: #F3F4F6; color: #9CA3AF;
    font-size: .65rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    padding: 0 .4rem;
}
.lb-p-item.active .lb-p-badge { background: #EE2E24; color: #fff; }

.lb-p-wa {
    width: 20px; height: 20px;
    background: #DCFCE7; color: #16A34A;
    border-radius: 5px;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem;
}

.lb-no-results {
    padding: 2rem 1rem; text-align: center;
    font-size: .8rem; color: #9CA3AF; display: none;
}

/* ── Right: detail panel ── */
.lb-detail-panel { min-width: 0; }

/* Detail header */
.lb-detail-header {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 1.125rem;
    flex-wrap: wrap;
}

.lb-detail-avatar {
    width: 52px; height: 52px; border-radius: 13px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; font-size: 1.25rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}

.lb-detail-info { flex: 1; min-width: 0; }
.lb-detail-name { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: .35rem; }

.lb-detail-chips { display: flex; flex-wrap: wrap; gap: .4rem; align-items: center; }

.lb-chip {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .25rem .65rem;
    border-radius: 9999px; border: 1.5px solid transparent;
    font-size: .72rem; font-weight: 600;
}
.lb-chip.nim   { background: #F3F4F6; color: #374151; border-color: #E5E7EB; }
.lb-chip.count { background: #DCFCE7; color: #15803D; border-color: #86EFAC; }

/* WA button (pill) in detail header */
.lb-wa-btn {
    display: inline-flex; align-items: center; gap: .375rem;
    padding: .4rem 1rem;
    background: #DCFCE7; color: #16A34A;
    border: 1.5px solid #86EFAC;
    border-radius: 9999px;
    font-size: .8rem; font-weight: 600;
    text-decoration: none; transition: all .15s;
    white-space: nowrap; flex-shrink: 0;
}
.lb-wa-btn:hover { background: #BBF7D0; color: #15803D; border-color: #4ADE80; transform: translateY(-1px); }

.lb-detail-count { margin-left: auto; flex-shrink: 0; text-align: right; }
.lb-detail-count-num { font-size: 1.875rem; font-weight: 700; color: #EE2E24; line-height: 1; }
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
    grid-template-columns: 120px 1fr;
    border-bottom: 1px solid #F9FAFB;
}
.lb-row:last-child { border-bottom: none; }

.lb-row-date {
    padding: 1rem 1.125rem;
    border-right: 1px solid #F3F4F6;
    background: #FAFAFA;
    display: flex; flex-direction: column; gap: .2rem;
    align-items: center; justify-content: center; text-align: center;
}
.lb-row-day      { font-size: .72rem; font-weight: 700; color: #374151; }
.lb-row-date-num { font-size: 1.5rem; font-weight: 700; color: #EE2E24; line-height: 1; }
.lb-row-month    { font-size: .7rem; color: #9CA3AF; }

.lb-row-content {
    padding: 1rem 1.25rem;
    font-size: .875rem; color: #374151; line-height: 1.65;
    white-space: pre-wrap; word-break: break-word;
}

/* Empty states */
.lb-empty { text-align: center; padding: 3.5rem 2rem; }
.lb-empty i  { font-size: 2.5rem; color: #E5E7EB; display: block; margin-bottom: .875rem; }
.lb-empty h4 { font-size: .95rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.lb-empty p  { font-size: .8rem; color: #9CA3AF; margin: 0; }

.lb-main-empty {
    background: #fff; border-radius: 16px; border: 1px solid #E5E7EB;
    text-align: center; padding: 5rem 2rem;
}
.lb-main-empty i  { font-size: 3rem; color: #E5E7EB; display: block; margin-bottom: 1rem; }
.lb-main-empty h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.lb-main-empty p  { font-size: .85rem; color: #9CA3AF; margin: 0; }

/* Responsive */
@media (max-width: 900px) {
    .lb-master-detail { grid-template-columns: 1fr; }
    .lb-list-panel { position: static; max-height: 300px; }
    .lb-stats { grid-template-columns: 1fr 1fr; }
    .lb-stats .lb-stat:last-child { grid-column: span 2; }
}

@media (max-width: 640px) {
    .lb-stats { grid-template-columns: 1fr; }
    .lb-row { grid-template-columns: 95px 1fr; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Logbook Peserta Magang"
    description="Pantau catatan harian peserta Anda — pilih nama di kiri untuk melihat logbook"
    icon="fas fa-book-open"
    role="pembimbing"
/>

{{-- Stats --}}
<div class="lb-stats">
    <div class="lb-stat">
        <div class="lb-stat-icon red"><i class="fas fa-users"></i></div>
        <div>
            <div class="lb-stat-val">{{ $totalParticipants }}</div>
            <div class="lb-stat-lbl">Peserta Binaan</div>
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

{{-- Master-detail --}}
@if($participants->count() > 0)
<div class="lb-master-detail">

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
                $pInit  = strtoupper(substr($pNames[0], 0, 1))
                        . (isset($pNames[1]) ? strtoupper(substr($pNames[1], 0, 1)) : '');
                $lbCount = $participant['logbooks']->count();
                $hasWa   = !empty($participant['user']->phone);
            @endphp
            <div class="lb-p-item {{ $idx === 0 ? 'active' : '' }}"
                 data-idx="{{ $idx }}"
                 data-name="{{ strtolower($participant['user']->name) }}"
                 onclick="selectParticipant({{ $idx }}, this)">
                <div class="lb-p-avatar">
                    @if($participant['user']->profile_picture)
                        <img src="{{ asset('storage/' . $participant['user']->profile_picture) }}"
                             alt="{{ $participant['user']->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ $pInit }}
                    @endif
                </div>
                <div class="lb-p-info">
                    <div class="lb-p-name">{{ $participant['user']->name }}</div>
                    <div class="lb-p-sub">{{ $participant['user']->nim ?? $participant['user']->email }}</div>
                </div>
                <div class="lb-p-right">
                    @if($hasWa)
                        <span class="lb-p-wa" title="Ada nomor WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </span>
                    @endif
                    <span class="lb-p-badge">{{ $lbCount }}</span>
                </div>
            </div>
            @endforeach
            <div class="lb-no-results" id="lbNoResults">
                <i class="fas fa-magnifying-glass" style="font-size:1.2rem;color:#D1D5DB;display:block;margin-bottom:.5rem;"></i>
                Tidak ditemukan
            </div>
        </div>
    </div>

    {{-- Right: detail panels --}}
    <div class="lb-detail-panel" id="lbDetailPanel">
        @foreach($participants as $idx => $participant)
        @php
            $pNames2  = explode(' ', $participant['user']->name);
            $pInit2   = strtoupper(substr($pNames2[0], 0, 1))
                      . (isset($pNames2[1]) ? strtoupper(substr($pNames2[1], 0, 1)) : '');
            $lbCount2 = $participant['logbooks']->count();

            $phone    = $participant['user']->phone ?? null;
            $waNum    = $phone ? preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $phone)) : null;
            $waText   = urlencode('Halo ' . $participant['user']->name . ', saya ingin menghubungi Anda terkait kegiatan magang.');
        @endphp
        <div class="lb-detail-section" id="lb-detail-{{ $idx }}"
             style="{{ $idx !== 0 ? 'display:none;' : '' }}">

            {{-- Participant info header --}}
            <div class="lb-detail-header">
                <div class="lb-detail-avatar">
                    @if($participant['user']->profile_picture)
                        <img src="{{ asset('storage/' . $participant['user']->profile_picture) }}"
                             alt="{{ $participant['user']->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ $pInit2 }}
                    @endif
                </div>
                <div class="lb-detail-info">
                    <div class="lb-detail-name">{{ $participant['user']->name }}</div>
                    <div class="lb-detail-chips">
                        @if($participant['user']->nim)
                            <span class="lb-chip nim">
                                <i class="fas fa-id-card"></i> {{ $participant['user']->nim }}
                            </span>
                        @endif
                        <span class="lb-chip count">
                            <i class="fas fa-book"></i> {{ $lbCount2 }} logbook
                        </span>
                        @if($waNum)
                            <a href="https://wa.me/{{ $waNum }}?text={{ $waText }}"
                               target="_blank" rel="noopener"
                               class="lb-wa-btn"
                               onclick="event.stopPropagation()">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        @endif
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
    <h4>Belum Ada Peserta</h4>
    <p>Belum ada peserta magang yang di-assign ke Anda</p>
</div>
@endif

@endsection

@push('scripts')
<script>
function selectParticipant(idx, el) {
    document.querySelectorAll('.lb-p-item').forEach(i => i.classList.remove('active'));
    el.classList.add('active');

    document.querySelectorAll('.lb-detail-section').forEach(s => s.style.display = 'none');
    const detail = document.getElementById('lb-detail-' + idx);
    if (detail) detail.style.display = '';

    // On mobile scroll detail into view
    const panel = document.getElementById('lbDetailPanel');
    if (panel) panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function filterParticipants(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.lb-p-item[data-name]');
    let visible = 0;

    items.forEach(item => {
        const name = item.getAttribute('data-name') || '';
        const show = !q || name.includes(q);
        item.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('lbNoResults').style.display = visible === 0 ? 'block' : 'none';
}
</script>
@endpush
