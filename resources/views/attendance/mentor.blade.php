@extends('layouts.mentor-dashboard')

@section('title', 'Absensi Peserta Magang - Mentor Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); padding: 2rem; border-radius: 16px; color: white; margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; margin-bottom: 0.5rem;">
            <i class="fas fa-calendar-check me-2"></i>
            Absensi Peserta Magang
        </h1>
        <p style="opacity: 0.9; margin-bottom: 0;">
            Pantau kehadiran peserta magang Anda
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($participants->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada peserta magang yang diterima di divisi Anda.
        </div>
    @else
        <!-- Date Filter Section -->
        <div class="card mb-4" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="card-body" style="padding: 1.5rem;">
                <form method="GET" action="{{ route('mentor.absensi') }}" class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label" style="font-weight: 600; color: #000;">
                            <i class="fas fa-calendar me-2 text-danger"></i>Filter Tanggal
                        </label>
                        <input type="date" name="date" class="form-control" value="{{ $filterDate ?? today()->toDateString() }}" max="{{ today()->toDateString() }}" style="border-radius: 12px; border: 2px solid #EE2E24;">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 12px; font-weight: 600; padding: 0.75rem;">
                            <i class="fas fa-filter me-2"></i>Terapkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            @php
                $totalParticipants = $participants->count();
                $presentCount = 0;
                $lateCount = 0;
                $absentCount = 0;

                foreach($participants as $participant) {
                    if($participant['attendance']) {
                        if($participant['attendance']->status === 'Hadir') $presentCount++;
                        elseif($participant['attendance']->status === 'Terlambat') $lateCount++;
                        elseif($participant['attendance']->status === 'Absen') $absentCount++;
                    }
                }
            @endphp

            <!-- Total Participants -->
            <div class="col-md-3 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-users" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 0.25rem;">{{ $totalParticipants }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Total Peserta</p>
                    </div>
                </div>
            </div>

            <!-- Present -->
            <div class="col-md-3 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #198754 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-user-check" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #198754; margin-bottom: 0.25rem;">{{ $presentCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Hadir</p>
                    </div>
                </div>
            </div>

            <!-- Late -->
            <div class="col-md-3 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-clock" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #ffc107; margin-bottom: 0.25rem;">{{ $lateCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Terlambat</p>
                    </div>
                </div>
            </div>

            <!-- Absent -->
            <div class="col-md-3 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-user-times" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #dc3545; margin-bottom: 0.25rem;">{{ $absentCount }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Absen</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white;">
                            <tr>
                                <th style="padding: 1.25rem; border: none;">Peserta</th>
                                <th style="padding: 1.25rem; border: none; text-align: center;">Status Hari Ini</th>
                                <th style="padding: 1.25rem; border: none; text-align: center;">Waktu Check-in</th>
                                <th style="padding: 1.25rem; border: none; text-align: center;">Riwayat 7 Hari</th>
                                <th style="padding: 1.25rem; border: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participants as $participant)
                                @php
                                    $todayAttendance = $participant['attendance'];
                                @endphp
                                <tr>
                                    <!-- Participant Info -->
                                    <td style="padding: 1.25rem;">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.25rem;">
                                                {{ strtoupper(substr($participant['user']->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: #000; margin-bottom: 0.25rem;">{{ $participant['user']->name ?? '-' }}</div>
                                                <div style="font-size: 0.875rem; color: #AAA5A6;">{{ $participant['user']->nim ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Status Today -->
                                    <td style="padding: 1.25rem; text-align: center;">
                                        @if($todayAttendance)
                                            @if($todayAttendance->status === 'Hadir')
                                                <span class="badge" style="background: #198754; color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                                                    <i class="fas fa-check-circle me-1"></i>Hadir
                                                </span>
                                            @elseif($todayAttendance->status === 'Terlambat')
                                                <span class="badge" style="background: #ffc107; color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                                                    <i class="fas fa-clock me-1"></i>Terlambat
                                                </span>
                                            @else
                                                <span class="badge" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                                                    <i class="fas fa-times-circle me-1"></i>Absen
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge" style="background: #AAA5A6; color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600;">
                                                <i class="fas fa-minus-circle me-1"></i>Belum Absen
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Check-in Time -->
                                    <td style="padding: 1.25rem; text-align: center;">
                                        <span style="font-weight: 600; color: #000;">
                                            {{ $todayAttendance ? \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') : '-' }}
                                        </span>
                                    </td>

                                    <!-- 7-Day History -->
                                    <td style="padding: 1.25rem;">
                                        <div class="d-flex justify-content-center gap-1">
                                            @foreach($participant['workingDays'] as $day)
                                                @php
                                                    $dayAttendance = $participant['last7Days']->where('date', $day)->first();
                                                    $bgColor = '#e9ecef'; // Default grey
                                                    $icon = 'minus';
                                                    $tooltip = \Carbon\Carbon::parse($day)->format('d M');

                                                    if($dayAttendance) {
                                                        if($dayAttendance->status === 'Hadir') {
                                                            $bgColor = '#198754';
                                                            $icon = 'check';
                                                            $tooltip .= ' - Hadir';
                                                        } elseif($dayAttendance->status === 'Terlambat') {
                                                            $bgColor = '#ffc107';
                                                            $icon = 'clock';
                                                            $tooltip .= ' - Terlambat';
                                                        } else {
                                                            $bgColor = '#dc3545';
                                                            $icon = 'times';
                                                            $tooltip .= ' - Absen';
                                                        }
                                                    } else {
                                                        $tooltip .= ' - Tidak ada data';
                                                    }
                                                @endphp
                                                <div title="{{ $tooltip }}" style="width: 32px; height: 32px; background: {{ $bgColor }}; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer;" data-bs-toggle="tooltip">
                                                    <i class="fas fa-{{ $icon }}" style="font-size: 0.75rem;"></i>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td style="padding: 1.25rem; text-align: center;">
                                        @if($todayAttendance && $todayAttendance->photo_path)
                                            <button onclick="showPhoto('{{ $participant['user']->name }}', '{{ asset('storage/' . $todayAttendance->photo_path) }}', '{{ $todayAttendance->status }}', '{{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}', '{{ $todayAttendance->keterangan ?? '' }}')" class="btn btn-sm" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 8px; padding: 0.5rem 1rem; font-weight: 600;">
                                                <i class="fas fa-image me-1"></i>Lihat Foto
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled style="border-radius: 8px; padding: 0.5rem 1rem;">
                                                <i class="fas fa-image me-1"></i>Tidak Ada Foto
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 16px 16px 0 0; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-camera me-2"></i>
                    Foto Absensi - <span id="modalName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <img id="modalPhoto" src="" alt="Foto Absensi" class="img-fluid" style="border-radius: 12px; width: 100%; height: auto;">
                    </div>
                    <div class="col-md-5">
                        <h6 style="font-weight: 600; color: #000; margin-bottom: 1rem;">Detail Absensi</h6>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Status</label>
                            <div id="modalStatus"></div>
                        </div>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Waktu Check-in</label>
                            <div style="font-weight: 600; color: #000;" id="modalTime"></div>
                        </div>
                        <div class="mb-3">
                            <label style="color: #AAA5A6; font-size: 0.875rem; display: block; margin-bottom: 0.25rem;">Keterangan</label>
                            <div style="color: #000;" id="modalReason"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show photo modal
function showPhoto(name, photo, status, time, reason) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalPhoto').src = photo;
    document.getElementById('modalTime').textContent = time;
    document.getElementById('modalReason').textContent = reason || '-';

    // Set status badge
    let statusBadge = '';
    if(status === 'Hadir') {
        statusBadge = '<span class="badge" style="background: #198754; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-check-circle me-1"></i>Hadir</span>';
    } else if(status === 'Terlambat') {
        statusBadge = '<span class="badge" style="background: #ffc107; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-clock me-1"></i>Terlambat</span>';
    } else {
        statusBadge = '<span class="badge" style="background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 8px;"><i class="fas fa-times-circle me-1"></i>Absen</span>';
    }
    document.getElementById('modalStatus').innerHTML = statusBadge;

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('photoModal'));
    modal.show();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
