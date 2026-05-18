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
/* ── Variables & Base ───────────────────────────── */
.eval-page {
    --brand:      #EE2E24;
    --brand-dark: #B71C1C;
    --text:       #1C1917;
    --muted:      #78716C;
    --border:     rgba(0,0,0,0.07);
    --card-bg:    #FFFFFF;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 1.5rem;
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
    font-size: 1.25rem;
    font-weight: 700;
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
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .eval-grid  { grid-template-columns: 1fr; }
}

@media (max-width: 480px) {
    .stats-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Evaluasi Akhir Peserta"
    description="Dokumen evaluasi akhir peserta bimbingan Anda. Hanya dapat dilihat dan diunduh."
    icon="fas fa-file-signature"
    role="pembimbing"
/>

<div class="eval-page">

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalCount }}</div>
                    <div class="stat-label">Total Peserta</div>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $hasDocCount }}</div>
                    <div class="stat-label">Ada Dokumen</div>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-warning">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $pendingCount }}</div>
                    <div class="stat-label">Belum Ada</div>
                </div>
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
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
                                <span class="badge badge-success"><i class="fas fa-play" style="font-size:0.5rem;"></i> Aktif</span>
                            @else
                                <span class="badge badge-info"><i class="fas fa-flag-checkered" style="font-size:0.5rem;"></i> Selesai</span>
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
                                        <span class="badge badge-purple">
                                            <i class="fas fa-user"></i> Peserta
                                        </span>
                                    @elseif($fromAdmin)
                                        <span class="badge badge-warning">
                                            <i class="fas fa-shield-alt"></i> Admin
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
