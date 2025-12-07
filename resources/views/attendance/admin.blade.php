@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Daily Attendance</h2>
        <p class="text-sm text-[#000000]">Pantau absensi peserta magang</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.attendance') }}" class="row g-3">
            <div class="col-md-4">
                <label for="division_id" class="form-label">Filter Divisi</label>
                <select class="form-select" id="division_id" name="division_id">
                    <option value="">Semua Divisi</option>
                    @foreach($divisions as $division)
                        <option value="{{ $division->id }}" {{ $filterDivision == $division->id ? 'selected' : '' }}>
                            {{ $division->division_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label">Filter Tanggal</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $filterDate }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Filter
                </button>
                <a href="{{ route('admin.attendance') }}" class="btn btn-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-calendar-check text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Absensi - {{ \Carbon\Carbon::parse($filterDate)->format('d M Y') }}</h5>
        </div>
        <div class="p-6">
            @if($participants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 25%;">Nama Peserta Magang</th>
                            <th style="width: 15%;" class="text-center">Status</th>
                            <th style="width: 35%;" class="text-center">Status 7 Hari Terakhir</th>
                            <th style="width: 20%;" class="text-center">Log</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $index => $participant)
                        <tr>
                            <td class="align-middle text-center">{{ $index + 1 }}</td>
                            <td class="align-middle">
                                <strong>{{ $participant['user']->name }}</strong><br>
                                <small class="text-muted">{{ $participant['user']->email }}</small><br>
                                @if($participant['application']->divisionAdmin)
                                    <small class="text-muted">{{ $participant['application']->divisionAdmin->division_name }}</small>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($participant['attendance'])
                                    @if($participant['attendance']->status == 'Hadir')
                                        <button class="btn btn-sm btn-success" disabled>✓ PRESENT</button>
                                    @elseif($participant['attendance']->status == 'Absen')
                                        <button class="btn btn-sm btn-warning" disabled>✗ ABSENT</button>
                                    @elseif($participant['attendance']->status == 'Terlambat')
                                        <button class="btn btn-sm btn-warning" disabled>LATE</button>
                                    @endif
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>-</button>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if(isset($participant['workingDays']))
                                        @foreach($participant['workingDays'] as $workDate)
                                            @php
                                                $checkDate = \Carbon\Carbon::parse($workDate);
                                                $dayAttendance = $participant['last7Days']->firstWhere('date', $workDate);
                                            @endphp
                                            <div class="text-center" style="min-width: 30px;">
                                                <small class="d-block text-muted">{{ $checkDate->format('d') }}</small>
                                                @if($dayAttendance)
                                                    @if($dayAttendance->status == 'Hadir')
                                                        <span class="badge bg-success">✓</span>
                                                    @elseif($dayAttendance->status == 'Absen')
                                                        <span class="badge bg-warning">✗</span>
                                                    @elseif($dayAttendance->status == 'Terlambat')
                                                        <span class="badge bg-warning">L</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        @php
                                            $workingDays = collect();
                                            $currentDate = \Carbon\Carbon::parse($filterDate);
                                            $daysBack = 0;
                                            while ($workingDays->count() < 7) {
                                                $checkDate = $currentDate->copy()->subDays($daysBack);
                                                if ($checkDate->dayOfWeek != \Carbon\Carbon::SATURDAY && $checkDate->dayOfWeek != \Carbon\Carbon::SUNDAY) {
                                                    $workingDays->push($checkDate);
                                                }
                                                $daysBack++;
                                                if ($daysBack > 20) break;
                                            }
                                            $workingDays = $workingDays->reverse()->values();
                                        @endphp
                                        @foreach($workingDays as $checkDate)
                                            @php
                                                $dayAttendance = $participant['last7Days']->firstWhere('date', $checkDate->toDateString());
                                            @endphp
                                            <div class="text-center" style="min-width: 30px;">
                                                <small class="d-block text-muted">{{ $checkDate->format('d') }}</small>
                                                @if($dayAttendance)
                                                    @if($dayAttendance->status == 'Hadir')
                                                        <span class="badge bg-success">✓</span>
                                                    @elseif($dayAttendance->status == 'Absen')
                                                        <span class="badge bg-warning">✗</span>
                                                    @elseif($dayAttendance->status == 'Terlambat')
                                                        <span class="badge bg-warning">L</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @if($participant['attendance'] && $participant['attendance']->check_in_time)
                                    <small>{{ \Carbon\Carbon::parse($participant['attendance']->check_in_time)->format('H:i:s') }}</small>
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada data absensi untuk filter yang dipilih.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

