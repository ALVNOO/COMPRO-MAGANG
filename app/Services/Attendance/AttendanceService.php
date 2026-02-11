<?php

namespace App\Services\Attendance;

use App\Models\Attendance;
use App\Models\User;
use App\Models\InternshipApplication;
use App\Traits\CalculatesWorkingDays;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AttendanceService
{
    use CalculatesWorkingDays;

    /**
     * Get today's attendance for a user.
     */
    public function getTodayAttendance(int $userId): ?Attendance
    {
        return Attendance::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();
    }

    /**
     * Get attendance history for a user.
     */
    public function getAttendanceHistory(int $userId, int $limit = 30): Collection
    {
        return Attendance::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if user can check in today.
     */
    public function canCheckIn(int $userId): bool
    {
        return !$this->getTodayAttendance($userId);
    }

    /**
     * Determine attendance status based on check-in time.
     */
    public function determineStatus(Carbon $checkInTime): string
    {
        if ($checkInTime->format('H:i') > '08:00') {
            return 'Terlambat';
        }

        return 'Hadir';
    }

    /**
     * Create a check-in record.
     */
    public function checkIn(int $userId, string $photoPath): Attendance
    {
        $now = now();

        return Attendance::create([
            'user_id' => $userId,
            'date' => $now->toDateString(),
            'status' => $this->determineStatus($now),
            'check_in_time' => $now->format('H:i:s'),
            'photo_path' => $photoPath,
        ]);
    }

    /**
     * Create an absence record.
     */
    public function markAbsent(int $userId, string $reason, ?string $proofPath = null): Attendance
    {
        return Attendance::create([
            'user_id' => $userId,
            'date' => today()->toDateString(),
            'status' => 'Absen',
            'absence_reason' => $reason,
            'absence_proof_path' => $proofPath,
        ]);
    }

    /**
     * Get participant attendance data for mentor view.
     */
    public function getParticipantsAttendanceForMentor(int $mentorId, string $filterDate): Collection
    {
        $applications = InternshipApplication::where('division_mentor_id', $mentorId)
            ->where('status', 'accepted')
            ->with(['user'])
            ->get();

        return $this->buildParticipantsAttendanceData($applications, $filterDate);
    }

    /**
     * Get participant attendance data for admin view.
     */
    public function getParticipantsAttendanceForAdmin(string $filterDate, ?int $divisionId = null): Collection
    {
        $query = InternshipApplication::where('status', 'accepted')
            ->with(['user', 'divisionAdmin', 'divisionMentor']);

        if ($divisionId) {
            $query->where('division_admin_id', $divisionId);
        }

        $applications = $query->get();

        return $this->buildParticipantsAttendanceData($applications, $filterDate, true);
    }

    /**
     * Build participants attendance data with last 7 working days.
     */
    protected function buildParticipantsAttendanceData(Collection $applications, string $filterDate, bool $includeApplication = false): Collection
    {
        $participants = collect();
        $currentDate = Carbon::parse($filterDate);
        $workingDays = $this->getWorkingDays($currentDate, 7);

        $startDate = $workingDays->first();
        $endDate = $workingDays->last();

        foreach ($applications as $app) {
            $attendance = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', $filterDate)
                ->first();

            $last7Days = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->orderBy('date', 'asc')
                ->get();

            $data = [
                'user' => $app->user,
                'attendance' => $attendance,
                'last7Days' => $last7Days,
                'workingDays' => $workingDays,
            ];

            if ($includeApplication) {
                $data['application'] = $app;
            }

            $participants->push($data);
        }

        return $participants;
    }

    /**
     * Get attendance statistics for a user.
     */
    public function getAttendanceStats(int $userId, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $query = Attendance::where('user_id', $userId);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $attendances = $query->get();

        return [
            'total' => $attendances->count(),
            'hadir' => $attendances->where('status', 'Hadir')->count(),
            'terlambat' => $attendances->where('status', 'Terlambat')->count(),
            'absen' => $attendances->where('status', 'Absen')->count(),
        ];
    }

    /**
     * Get attendance percentage for a user.
     */
    public function getAttendancePercentage(int $userId, Carbon $startDate, Carbon $endDate): float
    {
        $totalWorkingDays = $this->countWorkingDays($startDate, $endDate);

        if ($totalWorkingDays === 0) {
            return 0;
        }

        $presentDays = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->count();

        return round(($presentDays / $totalWorkingDays) * 100, 2);
    }

    /**
     * Get today's attendance summary for mentor.
     */
    public function getTodayAttendanceSummaryForMentor(int $mentorId): array
    {
        $applications = InternshipApplication::where('division_mentor_id', $mentorId)
            ->where('status', 'accepted')
            ->get();

        $userIds = $applications->pluck('user_id');

        $todayAttendances = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', today())
            ->get();

        return [
            'total_participants' => $userIds->count(),
            'checked_in' => $todayAttendances->whereIn('status', ['Hadir', 'Terlambat'])->count(),
            'absent' => $todayAttendances->where('status', 'Absen')->count(),
            'not_checked_in' => $userIds->count() - $todayAttendances->count(),
        ];
    }
}
