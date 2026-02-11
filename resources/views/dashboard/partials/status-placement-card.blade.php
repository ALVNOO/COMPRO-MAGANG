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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h4 class="card-title">Detail Penempatan Magang</h4>
    </div>
    <div class="card-body">
        <div class="data-grid">
            <div class="data-item">
                <div class="data-label">Divisi</div>
                <p class="data-value highlight">{{ $application->divisi->name ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Sub Direktorat</div>
                <p class="data-value">{{ $application->divisi->subDirektorat->name ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Direktorat</div>
                <p class="data-value">{{ $application->divisi->subDirektorat->direktorat->name ?? '-' }}</p>
            </div>
            <div class="data-item">
                <div class="data-label">Status</div>
                <p class="data-value">
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
                </p>
            </div>
            <div class="data-item">
                <div class="data-label">Tanggal Pengajuan</div>
                <p class="data-value">{{ $application->created_at->format('d M Y, H:i') }}</p>
            </div>
            @if($application->updated_at != $application->created_at)
            <div class="data-item">
                <div class="data-label">Terakhir Diupdate</div>
                <p class="data-value">{{ $application->updated_at->format('d M Y, H:i') }}</p>
            </div>
            @endif
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
