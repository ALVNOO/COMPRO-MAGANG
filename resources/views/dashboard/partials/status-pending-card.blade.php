{{--
    STATUS PENDING/REJECTED CARD
    Displays current status for pending or rejected applications

    Required variables:
    - $application: Application model with status, notes, created_at
--}}

<div class="info-card" data-animate>
    <div class="card-header">
        <div class="card-icon red">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h4 class="card-title">Status Pengajuan</h4>
    </div>
    <div class="card-body">
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 16px; margin-bottom: 20px;">
            @if($application->status == 'pending')
                <span class="status-badge pending">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Menunggu Review
                </span>
            @elseif($application->status == 'rejected')
                <span class="status-badge rejected">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ditolak
                </span>
            @endif

            <div class="data-item" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--primary)">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span style="font-size: 14px; color: var(--slate-600); font-weight: 600;">Diajukan: {{ $application->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        @if($application->status == 'rejected' && $application->notes)
            <div class="alert-box danger">
                <div class="alert-header">
                    <div class="alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h5 class="alert-title">Alasan Penolakan</h5>
                        <p class="alert-subtitle">Informasi dari admin</p>
                    </div>
                </div>
                <p style="color: #7F1D1D; margin: 0; font-size: 15px; line-height: 1.7;">{{ $application->notes }}</p>
            </div>
        @endif
    </div>
</div>
