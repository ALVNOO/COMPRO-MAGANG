{{--
    STATUS TIMELINE CARD
    Shows application timeline/history

    Required variables:
    - $application: Application model with status, created_at, updated_at
--}}

<div class="info-card" data-animate>
    <div class="card-header">
        <div class="card-icon cyan">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h4 class="card-title">Timeline Pengajuan</h4>
    </div>
    <div class="card-body">
        <div class="timeline">
            {{-- Submitted --}}
            <div class="timeline-item">
                <div class="timeline-dot submitted">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </div>
                <div class="timeline-content">
                    <h6 class="timeline-title">Pengajuan Dikirim</h6>
                    <p class="timeline-date">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $application->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            {{-- Status Update (if not pending) --}}
            @if($application->status != 'pending')
                <div class="timeline-item">
                    <div class="timeline-dot {{ $application->status == 'accepted' || $application->status == 'finished' ? 'accepted' : ($application->status == 'rejected' ? 'rejected' : '') }}">
                        @if($application->status == 'accepted' || $application->status == 'finished')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @elseif($application->status == 'rejected')
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif
                    </div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">
                            @if($application->status == 'accepted' || $application->status == 'finished')
                                Pengajuan Diterima
                            @elseif($application->status == 'rejected')
                                Pengajuan Ditolak
                            @elseif($application->status == 'postponed')
                                Pengajuan Ditunda
                            @endif
                        </h6>
                        <p class="timeline-date">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $application->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Finished --}}
            @if($application->status == 'finished')
                <div class="timeline-item">
                    <div class="timeline-dot finished">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Magang Selesai</h6>
                        <p class="timeline-date">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $application->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
