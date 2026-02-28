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
            if($isRejected) $currentStep = 3;
            if($isFinished) $currentStep = 4;

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
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $currentStep >= 2 ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">1</div>
                    <span class="sp-prog-label">Pengajuan</span>
                </div>
                <div class="sp-prog-step {{ $currentStep >= 2 ? 'done' : '' }} {{ $isPending ? 'active' : '' }}">
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $currentStep >= 3 ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">2</div>
                    <span class="sp-prog-label">Review</span>
                </div>
                <div class="sp-prog-step {{ $currentStep >= 3 && !$isRejected ? 'done' : '' }} {{ ($isAccepted && !$isFinished) ? 'active' : '' }} {{ $isRejected ? 'fail' : '' }}">
                    <div class="sp-prog-bar"><div class="sp-prog-bar-fill" style="width: {{ $isFinished ? '100' : '0' }}%"></div></div>
                    <div class="sp-prog-dot">{{ $isRejected ? '✕' : '3' }}</div>
                    <span class="sp-prog-label">Status</span>
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
                @php
                    $canReapply = $user->canReapplyForInternship();
                @endphp
                <div class="sp-rejection-card sp-anim sp-anim-2">
                    <div class="sp-rejection-header">
                        <div class="sp-rejection-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="sp-rejection-title">Pengajuan Magang Ditolak</h3>
                            <p class="sp-rejection-date">Ditolak pada {{ $application->updated_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="sp-rejection-reason">
                        <div class="sp-rejection-reason-label">Alasan Penolakan</div>
                        <div class="sp-rejection-reason-text">{{ $application->notes ?? 'Tidak ada alasan yang diberikan. Hubungi admin untuk informasi lebih lanjut.' }}</div>
                    </div>

                    <div class="sp-rejection-reapply">
                        @if($canReapply)
                            <div class="sp-reapply-ready">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Anda sudah dapat mendaftar kembali</span>
                            </div>
                            <form method="POST" action="{{ route('dashboard.reapply') }}">
                                @csrf
                                <button type="submit" class="sp-btn sp-btn-red">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Daftar Kembali
                                </button>
                            </form>
                        @endif
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

            {{-- Congratulation + Mentor Card --}}
            @if($application->divisionMentor)
            <div class="sp-congrats-card sp-anim sp-anim-3">
                <div class="sp-congrats-confetti">
                    <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                </div>
                <div class="sp-congrats-header">
                    <div class="sp-congrats-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h3 class="sp-congrats-title">Selamat, {{ $user->name }}!</h3>
                        <p class="sp-congrats-desc">Anda resmi diterima dalam program magang PT Telkom Indonesia. Berikut adalah mentor yang akan membimbing Anda selama program magang berlangsung.</p>
                    </div>
                </div>

                <div class="sp-mentor-card">
                    <div class="sp-mentor-avatar">
                        @if($mentorUser && $mentorUser->profile_picture)
                            <img src="{{ asset('storage/' . $mentorUser->profile_picture) }}" alt="{{ $application->divisionMentor->mentor_name }}">
                        @else
                            <span class="sp-mentor-initials">{{ strtoupper(substr($application->divisionMentor->mentor_name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="sp-mentor-info">
                        <h4 class="sp-mentor-name">{{ $application->divisionMentor->mentor_name }}</h4>
                        <span class="sp-mentor-role">Pembimbing Lapangan</span>
                        <div class="sp-mentor-details">
                            <div class="sp-mentor-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span><strong>Divisi:</strong> {{ $application->divisionMentor->division->division_name ?? '-' }}</span>
                            </div>
                            <div class="sp-mentor-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span><strong>Telepon:</strong> {{ $mentorUser && $mentorUser->phone ? $mentorUser->phone : 'Belum tersedia' }}</span>
                            </div>
                            <div class="sp-mentor-detail">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span><strong>Email:</strong> {{ $mentorUser && $mentorUser->email ? $mentorUser->email : 'Belum tersedia' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Placement Card --}}
            <div class="sp-card sp-anim sp-anim-3">
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
                            <div class="sp-place-value">{{ $application->divisionMentor->division->division_name ?? ($application->divisionAdmin->division_name ?? '-') }}</div>
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

                {{-- Acceptance Letter Download --}}
                @if($application->acceptance_letter_path && is_null($application->acceptance_letter_downloaded_at))
                    @include('dashboard.partials.status-download-section')
                @endif
            </div>

            {{-- Biodata + Timeline Grid --}}
            <div class="sp-grid sp-grid-wide sp-anim sp-anim-4">
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
                                <span>{{ $mentorUser->email ?? 'hr@telkom.co.id' }}</span>
                            </div>
                            @if($mentorUser && $mentorUser->phone)
                            <div class="sp-contact">
                                <div class="sp-contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <span>{{ $mentorUser->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Siap Magang Button (at the very bottom, only for accepted users who haven't entered dashboard) --}}
            @if($isAccepted && !$isFinished && !$application->dashboard_entered_at)
            <div class="sp-siap-magang sp-anim sp-anim-5">
                <form method="POST" action="{{ route('dashboard.enter') }}">
                    @csrf
                    <button type="submit" class="sp-btn-siap-magang">
                        <span class="sp-btn-siap-bg"></span>
                        <span class="sp-btn-siap-content">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Siap Magang
                        </span>
                    </button>
                </form>
                <p class="sp-siap-hint">Klik tombol di atas untuk membuka akses penuh ke dashboard magang Anda</p>
            </div>
            @endif

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
