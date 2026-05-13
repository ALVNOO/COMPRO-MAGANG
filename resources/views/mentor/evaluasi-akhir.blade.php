{{-- Mentor: lihat dokumen evaluasi akhir peserta --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir Peserta')

@php
    $role = 'mentor';
    $pageTitle = 'Evaluasi Akhir';
    $pageSubtitle = 'Dokumen evaluasi akhir peserta bimbingan';

    $totalCount   = $applications->count();
    $hasDocCount  = $applications->filter(fn($a) => $a->hasFinalEvaluationDocument())->count();
    $pendingCount = $totalCount - $hasDocCount;
@endphp

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap');

/* ── Variables & Base ───────────────────────────── */
.eval-page {
    --brand:        #EE2E24;
    --brand-dark:   #B71C1C;
    --text:         #1C1917;
    --muted:        #78716C;
    --border:       rgba(0,0,0,0.07);
    --card-bg:      #FFFFFF;
    font-family: 'DM Sans', system-ui, sans-serif;
}

/* ── Hero ───────────────────────────────────────── */
.eval-hero {
    background: linear-gradient(130deg, #EE2E24 0%, #B71C1C 55%, #7F1D1D 100%);
    border-radius: 22px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.eval-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 60% 80% at 100% 0%, rgba(255,255,255,0.13) 0%, transparent 60%),
        radial-gradient(ellipse 40% 60% at 0% 100%, rgba(0,0,0,0.12) 0%, transparent 60%);
    pointer-events: none;
}

/* Decorative watermark glyph */
.eval-hero::after {
    content: '\f15b';   /* fa-file */
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    right: 2.5rem;
    bottom: -1rem;
    font-size: 8rem;
    color: rgba(255,255,255,0.06);
    pointer-events: none;
    line-height: 1;
}

.eval-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.eval-hero-text h1 {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 1.9rem;
    font-weight: 700;
    margin: 0 0 0.4rem;
    letter-spacing: -0.015em;
    line-height: 1.15;
}

.eval-hero-text p {
    font-size: 0.875rem;
    opacity: 0.8;
    margin: 0;
    max-width: 400px;
    line-height: 1.5;
}

/* Stat pills */
.eval-stats {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.eval-stat-pill {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.375rem;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 14px;
    min-width: 82px;
    backdrop-filter: blur(8px);
    transition: background 0.2s;
}

.eval-stat-pill:hover {
    background: rgba(255,255,255,0.18);
}

.eval-stat-pill .num {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    letter-spacing: -0.02em;
}

.eval-stat-pill .lbl {
    font-size: 0.68rem;
    opacity: 0.72;
    margin-top: 0.3rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    white-space: nowrap;
    font-weight: 500;
}

.eval-stat-pill.sp-green {
    background: rgba(34,197,94,0.18);
    border-color: rgba(34,197,94,0.3);
}

.eval-stat-pill.sp-dim {
    background: rgba(0,0,0,0.14);
    border-color: rgba(255,255,255,0.08);
}

/* ── Cards grid ─────────────────────────────────── */
.eval-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 1.125rem;
}

/* ── Individual card ─────────────────────────────── */
.eval-card {
    background: var(--card-bg);
    border-radius: 18px;
    border: 1.5px solid var(--border);
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    position: relative;
    transition: box-shadow 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
    animation: evalCardIn 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
}

@keyframes evalCardIn {
    from { opacity: 0; transform: translateY(16px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0)   scale(1);    }
}

.eval-card:nth-child(1) { animation-delay: 0.05s; }
.eval-card:nth-child(2) { animation-delay: 0.10s; }
.eval-card:nth-child(3) { animation-delay: 0.15s; }
.eval-card:nth-child(4) { animation-delay: 0.20s; }
.eval-card:nth-child(5) { animation-delay: 0.25s; }
.eval-card:nth-child(6) { animation-delay: 0.30s; }
.eval-card:nth-child(7) { animation-delay: 0.35s; }
.eval-card:nth-child(8) { animation-delay: 0.40s; }
.eval-card:nth-child(9) { animation-delay: 0.45s; }

.eval-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 32px rgba(0,0,0,0.10);
    border-color: rgba(238,46,36,0.22);
}

/* Left accent bar */
.eval-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 20%;
    bottom: 20%;
    width: 3px;
    border-radius: 0 3px 3px 0;
    background: linear-gradient(180deg, var(--brand) 0%, var(--brand-dark) 100%);
    opacity: 0;
    transition: opacity 0.25s ease, top 0.25s ease, bottom 0.25s ease;
}

.eval-card:hover::before {
    opacity: 1;
    top: 15%;
    bottom: 15%;
}

/* Status stamp */
.eval-stamp {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    border-width: 2px;
    border-style: solid;
    transition: transform 0.2s ease;
}

.eval-card:hover .eval-stamp {
    transform: scale(1.08);
}

.eval-stamp-has {
    background: rgba(16,185,129,0.1);
    border-color: rgba(16,185,129,0.45);
    color: #10B981;
}

.eval-stamp-none {
    background: rgba(156,163,175,0.1);
    border-color: rgba(156,163,175,0.3);
    color: #D1D5DB;
}

/* Card header */
.eval-card-head {
    padding: 1.25rem 1.25rem 0.875rem;
    padding-right: 4rem;   /* stamp clearance */
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.eval-avatar {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    font-size: 1.125rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    letter-spacing: -0.01em;
}

.eval-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.eval-card-name {
    font-size: 0.9625rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 0.2rem;
    line-height: 1.25;
}

.eval-card-nim {
    font-size: 0.795rem;
    color: #9CA3AF;
    margin: 0;
    font-variant-numeric: tabular-nums;
    letter-spacing: 0.01em;
}

/* Divider */
.eval-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent 0%, rgba(0,0,0,0.07) 20%, rgba(0,0,0,0.07) 80%, transparent 100%);
    margin: 0 1.25rem;
}

/* Card body */
.eval-card-body {
    padding: 0.875rem 1.25rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.7rem;
}

.eval-row {
    display: flex;
    gap: 0.625rem;
    align-items: flex-start;
}

.eval-row-icon {
    color: #D1D5DB;
    font-size: 0.75rem;
    width: 16px;
    flex-shrink: 0;
    margin-top: 3px;
    transition: color 0.2s;
}

.eval-card:hover .eval-row-icon {
    color: #EE2E24;
}

.eval-row-lbl {
    font-size: 0.685rem;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    font-weight: 600;
    margin-bottom: 0.15rem;
    display: block;
}

.eval-row-val {
    font-size: 0.845rem;
    color: #374151;
    font-weight: 500;
    display: block;
}

.eval-row-val.mono {
    font-variant-numeric: tabular-nums;
    font-size: 0.82rem;
    letter-spacing: 0.01em;
}

/* Status badge */
.ev-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    font-size: 0.73rem;
    font-weight: 600;
    letter-spacing: 0.01em;
}

.ev-badge-accepted  { background: rgba(16,185,129,0.1);  color: #059669; }
.ev-badge-finished  { background: rgba(59,130,246,0.1);  color: #2563EB; }

/* Document source chip */
.eval-source-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.175rem 0.55rem;
    border-radius: 5px;
    font-size: 0.7rem;
    font-weight: 600;
}

.eval-source-chip.by-participant {
    background: rgba(139,92,246,0.1);
    color: #7C3AED;
}

.eval-source-chip.by-admin {
    background: rgba(245,158,11,0.1);
    color: #B45309;
}

/* Upload timestamp */
.eval-uploaded-on {
    display: block;
    font-size: 0.72rem;
    color: #9CA3AF;
    margin-top: 0.15rem;
}

/* Card footer */
.eval-card-foot {
    padding: 0.875rem 1.25rem;
    background: #FAFAF9;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.eval-dl-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.625rem 1rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.22s ease;
    letter-spacing: 0.01em;
}

.eval-dl-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 16px rgba(238,46,36,0.38);
    color: white;
}

.eval-dl-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(238,46,36,0.25);
}

.eval-no-doc-notice {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.625rem 1rem;
    background: transparent;
    color: #C4B9B5;
    border: 1.5px dashed #E5E0DC;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 500;
    font-style: italic;
}

/* ── Empty state ─────────────────────────────────── */
.eval-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 18px;
    border: 1.5px dashed rgba(0,0,0,0.1);
    animation: evalCardIn 0.4s ease both;
}

.eval-empty-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(238,46,36,0.07) 0%, rgba(196,30,26,0.07) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.25rem;
    color: #EE2E24;
    opacity: 0.7;
}

.eval-empty h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
}

.eval-empty p {
    font-size: 0.9rem;
    color: var(--muted);
    margin: 0;
}

/* ── Responsive ─────────────────────────────────── */
@media (max-width: 768px) {
    .eval-hero { padding: 1.5rem 1.25rem; }
    .eval-hero-text h1 { font-size: 1.55rem; }
    .eval-stats { width: 100%; }
    .eval-stat-pill { flex: 1; padding: 0.625rem 0.75rem; }
    .eval-grid { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .eval-hero-inner { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')
<div class="eval-page">

    {{-- ── Hero ── --}}
    <div class="eval-hero">
        <div class="eval-hero-inner">
            <div class="eval-hero-text">
                <h1><i class="fas fa-file-signature" style="font-size:1.3rem; margin-right:0.625rem; opacity:0.85;"></i>Evaluasi Akhir</h1>
                <p>Dokumen evaluasi akhir peserta bimbingan Anda. Hanya dapat dilihat dan diunduh, tidak dapat diunggah dari sini.</p>
            </div>
            @if($totalCount > 0)
            <div class="eval-stats">
                <div class="eval-stat-pill">
                    <span class="num">{{ $totalCount }}</span>
                    <span class="lbl">Total Peserta</span>
                </div>
                <div class="eval-stat-pill sp-green">
                    <span class="num">{{ $hasDocCount }}</span>
                    <span class="lbl">Ada Dokumen</span>
                </div>
                <div class="eval-stat-pill sp-dim">
                    <span class="num">{{ $pendingCount }}</span>
                    <span class="lbl">Belum Ada</span>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Cards grid ── --}}
    <div class="eval-grid">

        @forelse($applications as $app)
            @php
                $hasDoc          = $app->hasFinalEvaluationDocument();
                $fromParticipant = !empty($app->final_evaluation_participant_path);
                $fromAdmin       = !$fromParticipant && !empty($app->final_evaluation_admin_path);
                $uploadedAt      = $fromParticipant
                    ? $app->final_evaluation_participant_uploaded_at
                    : ($fromAdmin ? $app->final_evaluation_admin_uploaded_at : null);
                $initial         = strtoupper(substr($app->user->name ?? 'U', 0, 1));
            @endphp

            <div class="eval-card">

                {{-- Status stamp ──────────────────── --}}
                <div class="eval-stamp {{ $hasDoc ? 'eval-stamp-has' : 'eval-stamp-none' }}" title="{{ $hasDoc ? 'Dokumen tersedia' : 'Belum ada dokumen' }}">
                    @if($hasDoc)
                        <i class="fas fa-check"></i>
                    @else
                        <i class="fas fa-minus"></i>
                    @endif
                </div>

                {{-- Header ────────────────────────── --}}
                <div class="eval-card-head">
                    <div class="eval-avatar">
                        @if(!empty($app->user->profile_picture))
                            <img src="{{ asset('storage/' . $app->user->profile_picture) }}" alt="{{ $app->user->name }}">
                        @else
                            {{ $initial }}
                        @endif
                    </div>
                    <div>
                        <p class="eval-card-name">{{ $app->user->name ?? '—' }}</p>
                        <p class="eval-card-nim">{{ $app->user->nim ?? '—' }}</p>
                    </div>
                </div>

                <div class="eval-divider"></div>

                {{-- Details ────────────────────────── --}}
                <div class="eval-card-body">

                    {{-- Status magang --}}
                    <div class="eval-row">
                        <i class="fas fa-dot-circle eval-row-icon" style="margin-top:2px;"></i>
                        <div>
                            <span class="eval-row-lbl">Status Magang</span>
                            @if($app->status === 'accepted')
                                <span class="ev-badge ev-badge-accepted"><i class="fas fa-circle" style="font-size:0.4rem;"></i> Aktif</span>
                            @else
                                <span class="ev-badge ev-badge-finished"><i class="fas fa-circle" style="font-size:0.4rem;"></i> Selesai</span>
                            @endif
                        </div>
                    </div>

                    {{-- Periode --}}
                    @if($app->start_date || $app->end_date)
                    <div class="eval-row">
                        <i class="fas fa-calendar-alt eval-row-icon"></i>
                        <div>
                            <span class="eval-row-lbl">Periode Magang</span>
                            <span class="eval-row-val mono">
                                {{ $app->start_date ? $app->start_date->format('d M Y') : '—' }}
                                &nbsp;&rarr;&nbsp;
                                {{ $app->end_date ? $app->end_date->format('d M Y') : '—' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Dokumen --}}
                    <div class="eval-row">
                        <i class="fas fa-file-pdf eval-row-icon"></i>
                        <div>
                            <span class="eval-row-lbl">Dokumen Evaluasi</span>
                            @if($hasDoc)
                                <div style="display:flex; align-items:center; gap:0.4rem; flex-wrap:wrap; margin-top:0.15rem;">
                                    @if($fromParticipant)
                                        <span class="eval-source-chip by-participant">
                                            <i class="fas fa-user" style="font-size:0.65rem;"></i> Peserta
                                        </span>
                                    @elseif($fromAdmin)
                                        <span class="eval-source-chip by-admin">
                                            <i class="fas fa-shield-alt" style="font-size:0.65rem;"></i> Admin
                                        </span>
                                    @endif
                                    @if($uploadedAt)
                                        <span class="eval-uploaded-on" style="display:inline; margin:0;">
                                            <i class="fas fa-clock" style="font-size:0.65rem;"></i>
                                            {{ \Carbon\Carbon::parse($uploadedAt)->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="eval-row-val" style="color:#C4B9B5; font-style:italic; font-weight:400;">Belum diunggah</span>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Footer ─────────────────────────── --}}
                <div class="eval-card-foot">
                    @if($hasDoc)
                        <a href="{{ route('mentor.evaluasi-akhir.download', $app->id) }}"
                           class="eval-dl-btn">
                            <i class="fas fa-download"></i> Unduh Dokumen
                        </a>
                    @else
                        <div class="eval-no-doc-notice">
                            <i class="fas fa-clock"></i> Dokumen belum tersedia
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="eval-empty">
                <div class="eval-empty-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <h3>Belum Ada Peserta</h3>
                <p>Tidak ada peserta bimbingan yang aktif atau telah menyelesaikan magang saat ini.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection
