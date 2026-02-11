{{--
    MENTOR DASHBOARD ACTIVITY TIMELINE
    Recent submissions feed

    Required variables:
    - $recentSubmissions: Collection of recent assignment submissions
--}}

<div class="activity-card">
    <div class="activity-header">
        <div class="activity-header-left">
            <div class="activity-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="activity-header-title">
                <h4>Aktivitas Terbaru</h4>
                <p>7 hari terakhir</p>
            </div>
        </div>
        <div class="live-indicator">
            <span class="live-dot"></span>
            <span class="live-text">Live</span>
        </div>
    </div>
    <div class="activity-body">
        @if($recentSubmissions->isEmpty())
            <div class="activity-empty">
                <div class="activity-empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <p>Belum ada aktivitas dalam 7 hari terakhir</p>
            </div>
        @else
            @foreach($recentSubmissions as $index => $submission)
                @php
                    $latestSubmission = $submission->submissions->first();
                    $submittedAt = $latestSubmission ? $latestSubmission->submitted_at : null;
                    $isNew = $submittedAt && \Carbon\Carbon::parse($submittedAt)->diffInHours(now()) < 6;
                @endphp
                <div class="activity-item {{ $isNew ? 'new' : '' }}">
                    <div class="activity-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                    </div>
                    <div class="activity-content">
                        <h6 class="activity-name">{{ $submission->user->name }}</h6>
                        <p class="activity-desc">Mengumpulkan: {{ $submission->title }}</p>
                        <span class="activity-time">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $submittedAt ? \Carbon\Carbon::parse($submittedAt)->diffForHumans() : '-' }}
                        </span>
                    </div>
                    @if($submission->grade)
                        <span class="activity-badge graded">{{ $submission->grade }}</span>
                    @else
                        <span class="activity-badge pending">Belum Dinilai</span>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
