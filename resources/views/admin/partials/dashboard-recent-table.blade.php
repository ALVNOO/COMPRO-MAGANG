{{--
    ADMIN DASHBOARD RECENT APPLICATIONS TABLE
    Table showing recent pending applications

    Required variables:
    - $recentApplications: Collection of recent applications
--}}

<div class="table-card-admin">
    <div class="table-card-header">
        <div class="table-card-title">
            <i class="fas fa-clock"></i>
            <h3>Pengajuan Terbaru Menunggu Review</h3>
        </div>
        <a href="{{ route('admin.applications') }}" class="table-card-link">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peserta</th>
                    <th>Divisi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Periode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentApplications as $i => $app)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <div class="table-user">
                            <div class="table-avatar">
                                {{ substr($app->user->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="name">{{ $app->user->name ?? '-' }}</span>
                        </div>
                    </td>
                    <td>{{ $app->divisi->name ?? '-' }}</td>
                    <td>
                        <span class="table-status {{ $app->status }}">
                            @if($app->status=='pending')<i class="fas fa-clock text-xs mr-1"></i>@endif
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                    <td class="text-xs">
                        @if($app->start_date && $app->end_date)
                            {{ \Carbon\Carbon::parse($app->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($app->end_date)->format('d/m/y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="table-empty">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada pengajuan yang menunggu review</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
