{{--
    ADMIN DASHBOARD ACTIVITY FEED
    Recent activity timeline

    Required variables:
    - $recentActivity: Collection of recent application activities
--}}

<div class="activity-feed-admin lg:col-span-2">
    <div class="activity-feed-header">
        <div class="activity-feed-title">
            <i class="fas fa-history"></i>
            <h3>Aktivitas Terbaru</h3>
        </div>
        <div class="live-badge">
            <span class="live-dot-admin"></span>
            <span>7 hari</span>
        </div>
    </div>
    <div class="activity-feed-body">
        @forelse($recentActivity as $activity)
        <div class="activity-item-admin">
            <div class="activity-icon-admin {{ $activity->status }}">
                @if($activity->status == 'accepted')
                    <i class="fas fa-check"></i>
                @elseif($activity->status == 'rejected')
                    <i class="fas fa-times"></i>
                @elseif($activity->status == 'finished')
                    <i class="fas fa-graduation-cap"></i>
                @else
                    <i class="fas fa-clock"></i>
                @endif
            </div>
            <div class="activity-content-admin">
                <p class="name">{{ $activity->user->name ?? 'Unknown' }}</p>
                <p class="status">
                    Status: <span class="{{ $activity->status }}">{{ ucfirst($activity->status) }}</span>
                </p>
            </div>
            <div class="activity-time-admin">
                {{ $activity->updated_at->diffForHumans() }}
            </div>
        </div>
        @empty
        <div class="activity-empty-admin">
            <i class="fas fa-inbox"></i>
            <p>Belum ada aktivitas</p>
        </div>
        @endforelse
    </div>
</div>
