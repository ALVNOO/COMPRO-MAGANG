{{--
    STATUS PROGRESS STEPPER
    Shows application progress through steps: Pengajuan -> Review -> Diterima -> Selesai

    Required variables:
    - $currentStep: int (1-4, or -1 for rejected)
    - $progressPercent: int (0-100)
    - $isPending, $isAccepted, $isRejected, $isFinished: boolean status flags
--}}

<div class="stepper-card">
    <div class="stepper-header">
        <div class="stepper-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
        </div>
        <h3 class="stepper-title">Progress Pengajuan</h3>
    </div>
    <div class="stepper-wrapper">
        <div class="stepper-line">
            <div class="stepper-line-fill" style="--progress-width: {{ $progressPercent }}%"></div>
        </div>

        <!-- Step 1: Pengajuan -->
        <div class="step-item completed">
            <div class="step-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </div>
            <span class="step-label">Pengajuan</span>
        </div>

        <!-- Step 2: Review -->
        <div class="step-item {{ $isPending ? 'active' : ($currentStep > 1 || $isRejected ? 'completed' : 'pending') }} {{ $isRejected ? 'rejected' : '' }}">
            <div class="step-circle">
                @if($isRejected)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                @endif
            </div>
            <span class="step-label">{{ $isRejected ? 'Ditolak' : 'Review' }}</span>
        </div>

        <!-- Step 3: Diterima -->
        <div class="step-item {{ $isAccepted && !$isFinished ? 'active' : ($currentStep > 2 && !$isRejected ? 'completed' : 'pending') }}">
            <div class="step-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="step-label">Diterima</span>
        </div>

        <!-- Step 4: Selesai -->
        <div class="step-item {{ $isFinished ? 'completed' : 'pending' }}">
            <div class="step-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <span class="step-label">Selesai</span>
        </div>
    </div>
</div>
