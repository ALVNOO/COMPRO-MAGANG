{{--
    STATUS PLACEMENT CARD
    Displays placement details for accepted applications

    Required variables:
    - $application: Application model with divisi, status, dates, etc.
--}}

<div class="info-card" data-animate>
    <div class="card-header">
        <div class="card-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h4 class="card-title">Detail Penempatan Magang</h4>
            <p class="card-subtitle">Informasi divisi dan penempatan Anda</p>
        </div>
    </div>
    <div class="card-body">
        {{-- Status & Date row --}}
        <div class="status-info-row">
            @if($application->status == 'accepted')
                <span class="status-badge accepted">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Diterima
                </span>
            @elseif($application->status == 'finished')
                <span class="status-badge finished">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Selesai
                </span>
            @endif

            <div class="status-date-chip">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Diajukan: {{ $application->created_at->format('d M Y, H:i') }}</span>
            </div>

            @if($application->updated_at != $application->created_at)
                <div class="status-date-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Update: {{ $application->updated_at->format('d M Y, H:i') }}</span>
                </div>
            @endif
        </div>

        {{-- Placement Details Grid --}}
        <div class="data-grid">
            <div class="data-item">
                <div class="data-item-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <div class="data-label">Divisi</div>
                    <p class="data-value highlight">{{ $application->divisi->name ?? '-' }}</p>
                </div>
            </div>
            <div class="data-item">
                <div class="data-item-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
                <div>
                    <div class="data-label">Sub Direktorat</div>
                    <p class="data-value">{{ $application->divisi->subDirektorat->name ?? '-' }}</p>
                </div>
            </div>
            <div class="data-item full-width">
                <div class="data-item-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div>
                    <div class="data-label">Direktorat</div>
                    <p class="data-value">{{ $application->divisi->subDirektorat->direktorat->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Additional Requirements Section --}}
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
</div>
