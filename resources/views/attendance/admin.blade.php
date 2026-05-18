{{--
    ADMIN ATTENDANCE PAGE
    Monitor daily attendance of interns
    Using unified layout with design system
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Absensi Harian')

@php
    use Carbon\Carbon;
    $role = 'admin';

    $hadirCount    = collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Hadir')->count();
    $absenCount    = collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Absen')->count();
    $terlambatCount= collect($participants)->filter(fn($p) => $p['attendance'] && $p['attendance']->status == 'Terlambat')->count();
    $belumAbsen    = collect($participants)->filter(fn($p) => !$p['attendance'])->count();
    $today         = Carbon::today();
@endphp

@push('styles')
<style>
/* ── Stats grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
}

/* ── Filter bar ── */
.att-filter {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    padding: 1rem 1.375rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-end;
    gap: 1rem;
    flex-wrap: wrap;
}

.att-filter-group {
    display: flex;
    flex-direction: column;
    gap: .35rem;
}

.att-filter-group label {
    font-size: .72rem;
    font-weight: 600;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.att-filter-group select,
.att-filter-group input[type="date"] {
    padding: .6rem .9rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: .875rem;
    background: #F9FAFB;
    color: #111827;
    min-width: 170px;
    transition: border-color .15s;
}

.att-filter-group select:focus,
.att-filter-group input[type="date"]:focus {
    outline: none;
    border-color: #EE2E24;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(238,46,36,.07);
}

.att-filter-actions {
    display: flex;
    gap: .5rem;
    margin-left: auto;
    align-items: flex-end;
}

.att-btn-reset {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .6rem 1rem;
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
.att-btn-reset:hover { background: #E5E7EB; color: #111827; }


/* ── Participant cell ── */
.att-user { display: flex; align-items: center; gap: .65rem; text-align: left; }
.att-user-avatar {
    width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; font-size: .7rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.att-user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 9px; }
.att-user-info { display: flex; flex-direction: column; gap: .15rem; }
.att-user .att-name  { font-size: .875rem; font-weight: 600; color: #111827; }
.att-user .att-meta  { font-size: .75rem;  color: #9CA3AF; }

/* ── 7-day strip ── */
.seven-days {
    display: flex;
    gap: .3rem;
    justify-content: center;
}

.day-dot {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .2rem;
}

.day-dot-date {
    font-size: .62rem;
    color: #9CA3AF;
    font-weight: 500;
    line-height: 1;
}

.day-dot-badge {
    width: 26px; height: 26px;
    border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700;
    border: 1.5px solid transparent;
}

.day-dot-badge.hadir     { background: #DCFCE7; color: #16A34A; border-color: #86EFAC; }
.day-dot-badge.terlambat { background: #FEF9C3; color: #B45309; border-color: #FCD34D; }
.day-dot-badge.absen     { background: #FEE2E2; color: #DC2626; border-color: #FCA5A5; }
.day-dot-badge.pra       { background: #F3F4F6; color: #D1D5DB; border-color: #E5E7EB; }

/* Legend pill */
.strip-legend {
    display: inline-flex;
    align-items: center;
    gap: .875rem;
    flex-wrap: wrap;
    padding: .375rem .75rem;
    background: #F9FAFB;
    border-radius: 8px;
    font-size: .7rem;
    color: #6B7280;
    margin-bottom: .5rem;
}

.strip-legend span { display: flex; align-items: center; gap: .3rem; font-weight: 500; }
.strip-legend .dot { width: 10px; height: 10px; border-radius: 3px; }

/* ── Waktu check-in ── */
.checkin-time { font-size: .85rem; font-weight: 600; color: #111827; }
.checkin-empty { color: #D1D5DB; font-size: .85rem; }

/* ── Photo button ── */
.btn-photo {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .4rem .875rem;
    background: #DBEAFE; color: #1D4ED8;
    border: 1.5px solid #93C5FD;
    border-radius: 8px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .15s; border: none;
}
.btn-photo:hover { background: #BFDBFE; }

.no-photo {
    display: inline-flex; align-items: center; gap: .35rem;
    font-size: .78rem; color: #D1D5DB;
}

/* ── Empty state ── */
.empty-state { text-align: center; padding: 4rem 2rem; }
.empty-state i { font-size: 3rem; color: #D1D5DB; display: block; margin-bottom: 1rem; }
.empty-state h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.empty-state p  { color: #9CA3AF; font-size: .85rem; margin: 0; }

/* ── Photo modal ── */
.photo-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    z-index: 1000; padding: 1rem;
}

.photo-modal {
    background: #fff;
    border-radius: 20px;
    max-width: 760px; width: 100%;
    max-height: 90vh; overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.2);
}

.photo-modal-head {
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff;
    padding: 1.125rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between;
}

.photo-modal-head h3 {
    font-size: 1rem; font-weight: 700; margin: 0;
    display: flex; align-items: center; gap: .5rem;
}

.photo-modal-close {
    width: 32px; height: 32px;
    background: rgba(255,255,255,.2);
    border: none; border-radius: 8px;
    color: #fff; cursor: pointer; font-size: .9rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s;
}
.photo-modal-close:hover { background: rgba(255,255,255,.35); }

.photo-modal-body {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1.5rem; padding: 1.5rem;
    overflow-y: auto; max-height: calc(90vh - 120px);
}

.photo-modal-img {
    border-radius: 12px; overflow: hidden; background: #F9FAFB;
}
.photo-modal-img img { width: 100%; display: block; }

.photo-modal-info { display: flex; flex-direction: column; gap: .875rem; }

.pm-detail label {
    font-size: .7rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: .05em; color: #9CA3AF; display: block; margin-bottom: .25rem;
}
.pm-detail .pm-val { font-size: .9rem; font-weight: 500; color: #111827; }

.photo-modal-foot {
    padding: .875rem 1.5rem;
    border-top: 1px solid #E5E7EB;
    display: flex; justify-content: flex-end;
}

.btn-close-pm {
    padding: .55rem 1.25rem;
    background: #F3F4F6; color: #374151;
    border: none; border-radius: 10px;
    font-size: .875rem; font-weight: 500;
    cursor: pointer; transition: background .15s;
}
.btn-close-pm:hover { background: #E5E7EB; }

/* Responsive */
@media (max-width: 1024px) {
    .photo-modal-body { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
    .att-filter { flex-direction: column; align-items: stretch; }
    .att-filter-actions { margin-left: 0; }
    .att-filter-group select,
    .att-filter-group input[type="date"] { min-width: 0; width: 100%; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Absensi Harian"
    description="Pantau kehadiran peserta magang — {{ Carbon::parse($filterDate)->translatedFormat('l, d F Y') }}"
    icon="fas fa-clipboard-check"
    role="admin"
/>

{{-- Stats --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $hadirCount,
        'label' => 'Hadir',
        'icon'  => 'fa-user-check',
        'color' => 'success',
    ])
    @include('components.dashboard.stat-card', [
        'value' => $terlambatCount,
        'label' => 'Terlambat',
        'icon'  => 'fa-clock',
        'color' => 'warning',
    ])
    @include('components.dashboard.stat-card', [
        'value' => $absenCount,
        'label' => 'Tidak Hadir',
        'icon'  => 'fa-user-xmark',
        'color' => 'danger',
    ])
    @include('components.dashboard.stat-card', [
        'value' => $belumAbsen,
        'label' => 'Belum Absen',
        'icon'  => 'fa-circle-question',
        'color' => 'info',
    ])
</div>

{{-- Filter --}}
<form id="attFilterForm" method="GET" action="{{ route('admin.attendance') }}" class="att-filter">
    <div class="att-filter-group">
        <label>Divisi</label>
        <select name="division_id" id="att_division">
            <option value="">Semua Divisi</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                    {{ $division->division_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="att-filter-group">
        <label>Tanggal</label>
        <input type="date" name="date" value="{{ $filterDate }}" required>
    </div>
    <div class="att-filter-actions">
        <a href="{{ route('admin.attendance') }}" class="att-btn-reset">
            <i class="fas fa-rotate-left"></i> Reset
        </a>
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-list"></i>
            <span>Data Absensi — {{ Carbon::parse($filterDate)->format('d M Y') }}</span>
        </div>
        <span class="badge badge-gray">{{ count($participants) }} Peserta</span>
    </div>

    @if(count($participants) > 0)

    {{-- 7-day strip legend --}}
    <div style="padding: .75rem 1.25rem 0;">
        <div class="strip-legend">
            <span><span class="dot" style="background:#DCFCE7;border:1.5px solid #86EFAC;"></span>Hadir</span>
            <span><span class="dot" style="background:#FEF9C3;border:1.5px solid #FCD34D;"></span>Terlambat</span>
            <span><span class="dot" style="background:#FEE2E2;border:1.5px solid #FCA5A5;"></span>Tidak Hadir</span>
            <span><span class="dot" style="background:#F3F4F6;border:1.5px solid #E5E7EB;"></span>Sebelum / Di Luar Masa Magang</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peserta</th>
                    <th>Status Hari Ini</th>
                    <th style="text-align:center;">7 Hari Kerja Terakhir</th>
                    <th style="text-align:center;">Check-in</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $index => $participant)
                @php
                    $internshipStart = $participant['application']->start_date
                        ? Carbon::parse($participant['application']->start_date)->startOfDay()
                        : null;
                    $internshipEnd = $participant['application']->end_date
                        ? Carbon::parse($participant['application']->end_date)->endOfDay()
                        : null;

                    $workingDays = $participant['workingDays'] ?? collect();
                    if ($workingDays->isEmpty()) {
                        $currentDate = Carbon::parse($filterDate);
                        $daysBack = 0;
                        while ($workingDays->count() < 7) {
                            $checkDate = $currentDate->copy()->subDays($daysBack);
                            if (!in_array($checkDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                                $workingDays->push($checkDate->toDateString());
                            }
                            $daysBack++;
                            if ($daysBack > 20) break;
                        }
                        $workingDays = $workingDays->sort()->values();
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>

                    {{-- Participant info --}}
                    <td style="text-align:left;">
                        @php
                            $uName   = $participant['user']->name;
                            $uParts  = explode(' ', $uName);
                            $uInit   = strtoupper(substr($uParts[0], 0, 1)) . (isset($uParts[1]) ? strtoupper(substr($uParts[1], 0, 1)) : '');
                        @endphp
                        <div class="att-user">
                            <div class="att-user-avatar">
                                @if($participant['user']->profile_picture)
                                    <img src="{{ asset('storage/' . $participant['user']->profile_picture) }}" alt="{{ $uName }}">
                                @else
                                    {{ $uInit }}
                                @endif
                            </div>
                            <div class="att-user-info">
                                <span class="att-name">{{ $uName }}</span>
                                <span class="att-meta">{{ $participant['user']->email }}</span>
                                @if($participant['application']->divisionAdmin)
                                    <span class="att-meta">
                                        <i class="fas fa-building" style="font-size:.65rem;"></i>
                                        {{ $participant['application']->divisionAdmin->division_name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Today status --}}
                    <td>
                        @if($participant['attendance'])
                            @php $todayStatus = $participant['attendance']->status; @endphp
                            @if($todayStatus === 'Hadir')
                                <span class="status-badge status-active"><i class="fas fa-check-circle"></i> Hadir</span>
                            @elseif($todayStatus === 'Terlambat')
                                <span class="status-badge status-pending"><i class="fas fa-clock"></i> Terlambat</span>
                            @elseif($todayStatus === 'Absen')
                                <span class="status-badge" style="background:#FEE2E2;color:#DC2626;border-color:#FCA5A5;">
                                    <i class="fas fa-times-circle"></i> Absen
                                </span>
                            @endif
                        @else
                            <span class="status-badge" style="background:#F3F4F6;color:#9CA3AF;border-color:#E5E7EB;">
                                <i class="fas fa-minus"></i> Belum
                            </span>
                        @endif
                    </td>

                    {{-- 7-day strip --}}
                    <td>
                        <div class="seven-days">
                            @foreach($workingDays as $workDate)
                                @php
                                    $dayCarbon  = Carbon::parse($workDate);
                                    $dateStr    = is_string($workDate) ? $workDate : $workDate->toDateString();
                                    $dayRecord  = $participant['last7Days']->first(fn($a) => $a->date->toDateString() === $dateStr);

                                    // Is this day outside the participant's internship period?
                                    $isPraStart = $internshipStart && $dayCarbon->lt($internshipStart);
                                    $isPascaEnd = $internshipEnd  && $dayCarbon->gt($internshipEnd);
                                    $isOutside  = $isPraStart || $isPascaEnd;
                                @endphp
                                <div class="day-dot">
                                    <span class="day-dot-date">{{ $dayCarbon->format('d') }}</span>
                                    @if($isOutside)
                                        {{-- Day is outside internship period — show neutral --}}
                                        <span class="day-dot-badge pra" title="{{ $isPraStart ? 'Sebelum tanggal mulai magang' : 'Setelah tanggal selesai magang' }}">—</span>
                                    @elseif($dayRecord)
                                        @if($dayRecord->status === 'Hadir')
                                            <span class="day-dot-badge hadir" title="Hadir">✓</span>
                                        @elseif($dayRecord->status === 'Terlambat')
                                            <span class="day-dot-badge terlambat" title="Terlambat">L</span>
                                        @else
                                            <span class="day-dot-badge absen" title="Tidak Hadir">✗</span>
                                        @endif
                                    @else
                                        {{-- Inside internship period but no record --}}
                                        <span class="day-dot-badge absen" title="Tidak Hadir">✗</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </td>

                    {{-- Check-in time --}}
                    <td style="text-align:center;">
                        @if($participant['attendance'] && $participant['attendance']->check_in_time)
                            <span class="checkin-time">
                                {{ Carbon::parse($participant['attendance']->check_in_time)->format('H:i') }}
                            </span>
                        @else
                            <span class="checkin-empty">—</span>
                        @endif
                    </td>

                    {{-- Photo action --}}
                    <td style="text-align:center;">
                        @if($participant['attendance'] && $participant['attendance']->photo_path)
                            <button type="button" class="btn-photo"
                                onclick="openPhotoModal(
                                    '{{ addslashes($participant['user']->name) }}',
                                    '{{ asset('storage/' . $participant['attendance']->photo_path) }}',
                                    '{{ $participant['attendance']->status }}',
                                    '{{ $participant['attendance']->check_in_time ? Carbon::parse($participant['attendance']->check_in_time)->format('H:i') : '-' }}',
                                    '{{ addslashes($participant['attendance']->absence_reason ?? '') }}',
                                    {{ $participant['attendance']->latitude ?? 'null' }},
                                    {{ $participant['attendance']->longitude ?? 'null' }}
                                )">
                                <i class="fas fa-image"></i> Lihat Foto
                            </button>
                        @else
                            <span class="no-photo"><i class="fas fa-image"></i> Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-clipboard-list"></i>
        <h4>Tidak Ada Data</h4>
        <p>Belum ada peserta aktif untuk filter yang dipilih</p>
    </div>
    @endif
</div>

{{-- Photo Modal --}}
<div id="photoModal" class="photo-modal-overlay" style="display:none;">
    <div class="photo-modal">
        <div class="photo-modal-head">
            <h3><i class="fas fa-camera"></i> Foto Absensi — <span id="pm-name"></span></h3>
            <button class="photo-modal-close" onclick="closePhotoModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="photo-modal-body">
            <div class="photo-modal-img">
                <img id="pm-photo" src="" alt="Foto Absensi">
            </div>
            <div class="photo-modal-info">
                <div class="pm-detail">
                    <label>Status</label>
                    <div class="pm-val" id="pm-status"></div>
                </div>
                <div class="pm-detail">
                    <label>Waktu Check-in</label>
                    <div class="pm-val" id="pm-time"></div>
                </div>
                <div class="pm-detail">
                    <label>Lokasi</label>
                    <div class="pm-val" id="pm-location"></div>
                </div>
                <div class="pm-detail">
                    <label>Keterangan</label>
                    <div class="pm-val" id="pm-reason"></div>
                </div>
            </div>
        </div>
        <div class="photo-modal-foot">
            <button class="btn-close-pm" onclick="closePhotoModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('attFilterForm');
    // Auto-submit on division or date change
    const div  = document.getElementById('att_division');
    const date = form ? form.querySelector('input[name="date"]') : null;
    if (div)  div.addEventListener('change',  () => form.submit());
    if (date) date.addEventListener('change', () => form.submit());
});

function openPhotoModal(name, photo, status, time, reason, lat, lng) {
    document.getElementById('pm-name').textContent   = name;
    document.getElementById('pm-photo').src          = photo;
    document.getElementById('pm-time').textContent   = time;
    document.getElementById('pm-reason').textContent = reason || '-';

    const statusMap = {
        'Hadir'    : '<span class="status-badge status-active"><i class="fas fa-check-circle"></i> Hadir</span>',
        'Terlambat': '<span class="status-badge status-pending"><i class="fas fa-clock"></i> Terlambat</span>',
        'Absen'    : '<span class="status-badge" style="background:#FEE2E2;color:#DC2626;border-color:#FCA5A5;"><i class="fas fa-times-circle"></i> Absen</span>',
    };
    document.getElementById('pm-status').innerHTML = statusMap[status] || status;

    const locEl = document.getElementById('pm-location');
    if (lat && lng) {
        locEl.innerHTML = `<a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank" rel="noopener"
            style="display:inline-flex;align-items:center;gap:.35rem;color:#3b82f6;font-weight:600;text-decoration:none;">
            <i class="fas fa-map-marker-alt"></i> Buka di Google Maps
        </a>`;
    } else {
        locEl.textContent = 'Tidak tersedia';
    }

    document.getElementById('photoModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) closePhotoModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closePhotoModal();
});
</script>
@endpush
