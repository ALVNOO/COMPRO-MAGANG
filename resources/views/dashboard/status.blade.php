@extends('layouts.dashboard-unified')

@section('title', 'Status Pengajuan - PT Telkom Indonesia')

@php
    $role = 'participant';
    $pageTitle = 'Status Pengajuan';
@endphp

@push('styles')
    @include('dashboard.partials.status-styles')
@endpush

@section('content')
<div class="sp">
    @if($application)
        @php
            $isAccepted = in_array($application->status, ['accepted', 'finished']);
            $isPending = $application->status == 'pending';
            $isRejected = $application->status == 'rejected';
            $isFinished = $application->status == 'finished';

            $currentStep = 1;
            if($isPending) $currentStep = 2;
            if($isAccepted) $currentStep = 3;
            if($isFinished) $currentStep = 4;
            if($isRejected) $currentStep = -1;

            // Calculate dates
            $hasStartDate = $application->start_date && $application->end_date;
        @endphp

        {{-- HERO BANNER --}}
        <div class="sp-hero sp-anim">
            <div class="sp-hero-top">
                <div class="sp-hero-user">
                    <div class="sp-hero-avatar">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="sp-hero-name">{{ $user->name ?? '-' }}</h1>
                        <p class="sp-hero-meta">{{ $user->nim ?? '' }}@if($user->nim && $user->university) &middot; @endif{{ $user->university ?? '' }}</p>
                    </div>
                </div>
                <div class="sp-badge sp-badge-{{ $application->status }}">
                    @if($isPending)
                        <span class="sp-badge-dot"></span> Menunggu Review
                    @elseif($isAccepted && !$isFinished)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Diterima
                    @elseif($isRejected)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg> Ditolak
                    @elseif($isFinished)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg> Selesai
                    @endif
                </div>
            </div>

            {{-- Progress Steps --}}
            <div class="sp-progress">
                <div class="sp-prog-step {{ $currentStep >= 1 ? 'done' : '' }}">
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $currentStep >= 2 && !$isRejected ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">1</div>
                    <span class="sp-prog-label">Pengajuan</span>
                </div>
                <div class="sp-prog-step {{ $currentStep >= 2 && !$isRejected ? 'done' : '' }} {{ $isPending ? 'active' : '' }} {{ $isRejected ? 'fail' : '' }}">
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $currentStep >= 3 ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">{{ $isRejected ? '✕' : '2' }}</div>
                    <span class="sp-prog-label">{{ $isRejected ? 'Ditolak' : 'Review' }}</span>
                </div>
                <div class="sp-prog-step {{ $currentStep >= 3 ? 'done' : '' }} {{ $isAccepted && !$isFinished ? 'active' : '' }}">
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $isFinished ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">3</div>
                    <span class="sp-prog-label">Diterima</span>
                </div>
                <div class="sp-prog-step {{ $isFinished ? 'done' : '' }}">
                    <div class="sp-prog-dot">4</div>
                    <span class="sp-prog-label">Selesai</span>
                </div>
            </div>
        </div>

        {{-- INFO NOTICE --}}
        <div class="sp-notice sp-anim sp-anim-1">
            <div class="sp-notice-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="sp-notice-text">
                Periksa halaman ini secara berkala untuk melihat pembaruan status penerimaan Anda.
            </div>
        </div>

        @if(!$isAccepted)
            {{-- ===== PENDING / REJECTED STATE ===== --}}

            @if($isRejected)
                <div class="sp-alert sp-alert-red sp-anim sp-anim-2">
                    <div class="sp-alert-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="sp-alert-body">
                        <div class="sp-alert-title">Pengajuan Ditolak</div>
                        <div class="sp-alert-desc">{{ $application->notes ?? 'Hubungi admin untuk informasi lebih lanjut.' }}</div>
                    </div>
                </div>
            @endif

            {{-- Info Grid --}}
            <div class="sp-grid sp-grid-wide sp-anim sp-anim-3">
                {{-- Biodata --}}
                <div class="sp-card">
                    <div class="sp-card-head">
                        <div class="sp-card-icon sp-ci-blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="sp-card-title">Data Pemohon</div>
                            <div class="sp-card-sub">Identitas dan informasi akademik</div>
                        </div>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-data">
                            <div class="sp-data-row">
                                <span class="sp-data-label">Nama Lengkap</span>
                                <span class="sp-data-value">{{ $user->name ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">NIM</span>
                                <span class="sp-data-value">{{ $user->nim ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Email</span>
                                <span class="sp-data-value">{{ $user->email ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Telepon</span>
                                <span class="sp-data-value">{{ $user->phone ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Universitas</span>
                                <span class="sp-data-value">{{ $user->university ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Jurusan</span>
                                <span class="sp-data-value">{{ $user->major ?? '-' }}</span>
                            </div>
                            @if($user->ktp_number)
                            <div class="sp-data-row">
                                <span class="sp-data-label">No. KTP</span>
                                <span class="sp-data-value">{{ $user->ktp_number }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Field + Timeline + Contact --}}
                <div class="sp-card">
                    <div class="sp-card-head">
                        <div class="sp-card-icon sp-ci-amber">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="sp-card-title">Detail Pengajuan</div>
                            <div class="sp-card-sub">Peminatan dan riwayat</div>
                        </div>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-field">
                            <div class="sp-field-label">Bidang Peminatan</div>
                            <div class="sp-field-value">{{ $application->fieldOfInterest->name ?? 'Belum dipilih' }}</div>
                            @if($application->fieldOfInterest && $application->fieldOfInterest->description)
                                <div class="sp-field-desc">{{ $application->fieldOfInterest->description }}</div>
                            @endif
                        </div>

                        <div class="sp-timeline" style="margin-top: 16px;">
                            <div class="sp-tl-item">
                                <div class="sp-tl-dot red"></div>
                                <div>
                                    <div class="sp-tl-title">Pengajuan Dikirim</div>
                                    <div class="sp-tl-date">{{ $application->created_at->format('d M Y, H:i') }} WIB</div>
                                </div>
                            </div>
                            @if($isRejected)
                                <div class="sp-tl-item">
                                    <div class="sp-tl-dot amber"></div>
                                    <div>
                                        <div class="sp-tl-title">Pengajuan Ditolak</div>
                                        <div class="sp-tl-date">{{ $application->updated_at->format('d M Y, H:i') }} WIB</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sp-card-footer">
                        <div class="sp-contacts">
                            <div class="sp-contact">
                                <div class="sp-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <span>hr@telkom.co.id</span>
                            </div>
                            <div class="sp-contact">
                                <div class="sp-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <span>(021) 789-0123</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- ===== ACCEPTED / FINISHED STATE ===== --}}

            {{-- Placement Card --}}
            <div class="sp-card sp-anim sp-anim-2">
                <div class="sp-card-head">
                    <div class="sp-card-icon sp-ci-green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <div class="sp-card-title">Penempatan Magang</div>
                        <div class="sp-card-sub">Divisi dan lokasi penempatan</div>
                    </div>
                </div>
                <div class="sp-card-body">
                    <div class="sp-placement">
                        <div class="sp-place-item sp-place-item-main">
                            <div class="sp-place-label">Divisi Penempatan</div>
                            <div class="sp-place-value">{{ $application->divisi->name ?? '-' }}</div>
                        </div>
                        <div class="sp-place-item">
                            <div class="sp-place-label">Sub Direktorat</div>
                            <div class="sp-place-value">{{ $application->divisi->subDirektorat->name ?? '-' }}</div>
                        </div>
                        <div class="sp-place-item">
                            <div class="sp-place-label">Direktorat</div>
                            <div class="sp-place-value">{{ $application->divisi->subDirektorat->direktorat->name ?? '-' }}</div>
                        </div>
                    </div>

                    @if($hasStartDate)
                        <div class="sp-date-range">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <div>
                                <div class="sp-date-label">Periode Magang</div>
                                <div class="sp-date-value">{{ $application->start_date->format('d M Y') }} <span style="color:var(--slate-400);font-weight:400;">&ndash;</span> {{ $application->end_date->format('d M Y') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Additional Requirements --}}
                @if($application->status == 'accepted')
                    @if(!$application->acknowledged_additional_requirements)
                        @include('dashboard.partials.status-requirements-alert')
                    @elseif(
                        !$application->cover_letter_path ||
                        !$application->foto_nametag_path ||
                        !$application->screenshot_pospay_path ||
                        !$application->foto_prangko_prisma_path ||
                        !$application->ss_follow_ig_museum_path ||
                        !$application->ss_follow_ig_posindonesia_path ||
                        !$application->ss_subscribe_youtube_path
                    )
                        @include('dashboard.partials.status-upload-section')
                    @endif
                @endif

                {{-- Acceptance Letter Download --}}
                @if($application->acceptance_letter_path && is_null($application->acceptance_letter_downloaded_at))
                    @include('dashboard.partials.status-download-section')
                @endif
            </div>

            {{-- Biodata + Timeline Grid --}}
            <div class="sp-grid sp-grid-wide sp-anim sp-anim-3">
                {{-- Biodata --}}
                <div class="sp-card">
                    <div class="sp-card-head">
                        <div class="sp-card-icon sp-ci-blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <div class="sp-card-title">Data Peserta</div>
                            <div class="sp-card-sub">Informasi identitas</div>
                        </div>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-data">
                            <div class="sp-data-row">
                                <span class="sp-data-label">Nama</span>
                                <span class="sp-data-value">{{ $user->name ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">NIM</span>
                                <span class="sp-data-value">{{ $user->nim ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Email</span>
                                <span class="sp-data-value">{{ $user->email ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Telepon</span>
                                <span class="sp-data-value">{{ $user->phone ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Universitas</span>
                                <span class="sp-data-value">{{ $user->university ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Jurusan</span>
                                <span class="sp-data-value">{{ $user->major ?? '-' }}</span>
                            </div>
                            <div class="sp-data-row">
                                <span class="sp-data-label">Peminatan</span>
                                <span class="sp-data-value">{{ $application->fieldOfInterest->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline + Contact --}}
                <div class="sp-card">
                    <div class="sp-card-head">
                        <div class="sp-card-icon sp-ci-purple">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="sp-card-title">Riwayat & Kontak</div>
                            <div class="sp-card-sub">Timeline pengajuan</div>
                        </div>
                    </div>
                    <div class="sp-card-body">
                        <div class="sp-timeline">
                            <div class="sp-tl-item">
                                <div class="sp-tl-dot red"></div>
                                <div>
                                    <div class="sp-tl-title">Pengajuan Dikirim</div>
                                    <div class="sp-tl-date">{{ $application->created_at->format('d M Y, H:i') }} WIB</div>
                                </div>
                            </div>
                            <div class="sp-tl-item">
                                <div class="sp-tl-dot green"></div>
                                <div>
                                    <div class="sp-tl-title">Diterima</div>
                                    <div class="sp-tl-date">{{ $application->updated_at->format('d M Y, H:i') }} WIB</div>
                                </div>
                            </div>
                            @if($hasStartDate)
                                <div class="sp-tl-item">
                                    <div class="sp-tl-dot blue"></div>
                                    <div>
                                        <div class="sp-tl-title">Mulai Magang</div>
                                        <div class="sp-tl-date">{{ $application->start_date->format('d M Y') }}</div>
                                    </div>
                                </div>
                            @endif
                            @if($isFinished)
                                <div class="sp-tl-item">
                                    <div class="sp-tl-dot amber"></div>
                                    <div>
                                        <div class="sp-tl-title">Magang Selesai</div>
                                        <div class="sp-tl-date">{{ $application->end_date ? $application->end_date->format('d M Y') : $application->updated_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sp-card-footer">
                        <div class="sp-contacts">
                            <div class="sp-contact">
                                <div class="sp-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <span>hr@telkom.co.id</span>
                            </div>
                            <div class="sp-contact">
                                <div class="sp-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <span>(021) 789-0123</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    @else
        {{-- Empty State --}}
        <div class="sp-empty sp-anim">
            <div class="sp-empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
            </div>
            <h2>Belum Ada Pengajuan</h2>
            <p>Anda belum memiliki pengajuan magang yang terdaftar di sistem.</p>
            <a href="{{ route('dashboard.program') }}" class="sp-btn sp-btn-red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Buat Pengajuan
            </a>
        </div>
    @endif
</div>

@push('scripts')
    @include('dashboard.partials.status-scripts')
@endpush
@endsection
