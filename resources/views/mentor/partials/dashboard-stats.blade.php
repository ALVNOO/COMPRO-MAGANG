{{--
    MENTOR DASHBOARD STATS GRID
    Overview statistics cards

    Required variables:
    - $activeParticipants: Number of active participants
    - $totalAssignments: Total assignments
    - $completedAssignments: Completed assignments
    - $assignmentsToGrade: Assignments pending grading
    - $averageGrade: Average grade
    - $completionRate: Completion rate percentage
    - $attendanceStats: Array with 'present', 'late', 'absent' keys
--}}

<div class="stats-grid">
    {{-- Active Participants --}}
    <div class="stat-card green" data-count="{{ $activeParticipants }}">
        <div class="stat-header">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="stat-label">Aktif</span>
        </div>
        <div class="stat-value" data-target="{{ $activeParticipants }}">0</div>
        <div class="stat-desc">Peserta Aktif</div>
    </div>

    {{-- Total Assignments --}}
    <div class="stat-card blue" data-count="{{ $totalAssignments }}">
        <div class="stat-header">
            <div class="stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-value" data-target="{{ $totalAssignments }}">0</div>
        <div class="stat-desc">Total Tugas</div>
    </div>

    {{-- Completed Assignments --}}
    <div class="stat-card green" data-count="{{ $completedAssignments }}">
        <div class="stat-header">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="stat-label">Selesai</span>
        </div>
        <div class="stat-value" data-target="{{ $completedAssignments }}">0</div>
        <div class="stat-desc">Tugas Selesai</div>
    </div>

    {{-- Assignments to Grade --}}
    <div class="stat-card amber {{ $assignmentsToGrade > 0 ? 'has-pending' : '' }}" data-count="{{ $assignmentsToGrade }}">
        <div class="stat-header">
            <div class="stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-value" data-target="{{ $assignmentsToGrade }}">0</div>
        <div class="stat-desc">Perlu Dinilai</div>
    </div>

    {{-- Average Grade --}}
    <div class="stat-card purple" data-count="{{ $averageGrade }}">
        <div class="stat-header">
            <div class="stat-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <span class="stat-label">Rata-rata</span>
        </div>
        <div class="stat-value" data-target="{{ $averageGrade }}" data-decimal="true">0</div>
        <div class="stat-desc">Nilai Rata-Rata</div>
    </div>

    {{-- Completion Rate --}}
    <div class="stat-card cyan" data-count="{{ $completionRate }}">
        <div class="stat-header">
            <div class="stat-icon cyan">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <span class="stat-label">Rate</span>
        </div>
        <div class="stat-value" data-target="{{ $completionRate }}" data-suffix="%">0%</div>
        <div class="stat-desc">Tingkat Penyelesaian</div>
    </div>

    {{-- Present Today --}}
    <div class="stat-card green" data-count="{{ $attendanceStats['present'] }}">
        <div class="stat-header">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <span class="stat-label">Hari Ini</span>
        </div>
        <div class="stat-value" data-target="{{ $attendanceStats['present'] }}">0</div>
        <div class="stat-desc">Hadir Hari Ini</div>
    </div>

    {{-- Late/Absent --}}
    <div class="stat-card amber {{ ($attendanceStats['late'] + $attendanceStats['absent']) > 0 ? 'has-pending' : '' }}" data-count="{{ $attendanceStats['late'] + $attendanceStats['absent'] }}">
        <div class="stat-header">
            <div class="stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <span class="stat-label">Perhatian</span>
        </div>
        <div class="stat-value" data-target="{{ $attendanceStats['late'] + $attendanceStats['absent'] }}">0</div>
        <div class="stat-desc">Terlambat/Absen</div>
    </div>
</div>
