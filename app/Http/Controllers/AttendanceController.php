<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DivisiAdmin;
use App\Models\DivisionMentor;
use App\Models\InternshipApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    /**
     * Display attendance page for peserta (student)
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get active application
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();
        
        if (!$application) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda belum memiliki pengajuan magang yang diterima.');
        }
        
        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', today())
            ->first();
        
        // Get attendance history (last 30 days)
        $attendanceHistory = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
        
        return view('attendance.index', compact('todayAttendance', 'attendanceHistory', 'application'));
    }
    
    /**
     * Handle check in for peserta
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'photo'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $user = Auth::user();
        $now = now();
        $today = $now->toDateString();

        // Check if already checked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini.'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Determine status based on check-in time
        $checkInTime = $now->format('H:i:s');
        $status = 'Hadir';
        if ($now->format('H:i') > '08:00') {
            $status = 'Terlambat';
        }

        // Upload photo
        $photoPath = $request->file('photo')->store('attendance-photos', 'public');

        // Create attendance record
        $attendance = Attendance::create([
            'user_id'   => $user->id,
            'date'      => $today,
            'status'    => $status,
            'check_in_time' => $checkInTime,
            'photo_path'    => $photoPath,
            'latitude'  => $request->filled('latitude')  ? (float) $request->latitude  : null,
            'longitude' => $request->filled('longitude') ? (float) $request->longitude : null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Check in berhasil! Status: ' . $status,
                'attendance' => $attendance
            ]);
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Check in berhasil! Status: ' . $status);
    }
    
    /**
     * Handle absent for peserta
     */
    public function absent(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
            'proof' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);

        $user = Auth::user();
        $today = today()->toDateString();

        // Check if already checked in today
        $existingAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini.'
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi hari ini.');
        }

        // Upload proof if provided
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('attendance-proofs', 'public');
        }

        // Create attendance record
        $attendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'status' => 'Absen',
            'absence_reason' => $request->reason,
            'absence_proof_path' => $proofPath,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Absen berhasil dicatat.',
                'attendance' => $attendance
            ]);
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Absen berhasil dicatat.');
    }
    
    /**
     * Display attendance page for mentor
     */
    public function mentorIndex(Request $request)
    {
        $user = Auth::user();
        
        // Get division mentor
        $divisionMentor = \App\Models\DivisionMentor::where('nik_number', $user->username)->first();
        
        if (!$divisionMentor) {
            return redirect()->route('mentor.dashboard')
                ->with('error', 'Anda tidak memiliki akses untuk melihat absensi.');
        }
        
        // Get filter date (default: today)
        $filterDate = $request->input('date', today()->toDateString());
        
        // Get participants assigned to this mentor
        $applications = InternshipApplication::where('division_mentor_id', $divisionMentor->id)
            ->where('status', 'accepted')
            ->with(['user'])
            ->get();
        
        // Compute working days ONCE (same for all participants since filterDate is shared)
        $workingDays = $this->computeWorkingDays($filterDate, 7);
        $rangeStart  = $workingDays->first();
        $rangeEnd    = $workingDays->last();

        // Batch-load ALL attendance data in 2 queries instead of N*2
        $userIds = $applications->pluck('user_id');

        $todayMap = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', $filterDate)
            ->get()->keyBy('user_id');

        $historyMap = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', '>=', $rangeStart)
            ->whereDate('date', '<=', $rangeEnd)
            ->orderBy('date', 'asc')
            ->get()->groupBy('user_id');

        $participants = $applications->map(fn($app) => [
            'user'        => $app->user,
            'attendance'  => $todayMap->get($app->user_id),
            'last7Days'   => $historyMap->get($app->user_id, collect()),
            'workingDays' => $workingDays,
        ]);

        return view('mentor.absensi', [
            'participants' => $participants,
            'filterDate'   => $filterDate,
        ]);
    }
    
    /**
     * Display attendance page for admin
     */
    public function adminIndex(Request $request)
    {
        // Get filter date and division
        $filterDate = $request->input('date', today()->toDateString());
        $filterDivision = $request->input('division_id');
        
        // Get all divisions
        $divisions = DivisiAdmin::where('is_active', true)
            ->orderBy('division_name')
            ->get();
        
        // Build query for applications
        $query = InternshipApplication::where('status', 'accepted')
            ->with(['user', 'divisionAdmin', 'divisionMentor']);
        
        if ($filterDivision) {
            $query->where('division_admin_id', $filterDivision);
        }
        
        $applications = $query->get();
        
        // Compute working days ONCE; batch-load attendance in 2 queries
        $workingDays = $this->computeWorkingDays($filterDate, 7);
        $rangeStart  = $workingDays->first();
        $rangeEnd    = $workingDays->last();

        $userIds = $applications->pluck('user_id');

        $todayMap = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', $filterDate)
            ->get()->keyBy('user_id');

        $historyMap = Attendance::whereIn('user_id', $userIds)
            ->whereDate('date', '>=', $rangeStart)
            ->whereDate('date', '<=', $rangeEnd)
            ->orderBy('date', 'asc')
            ->get()->groupBy('user_id');

        $participants = $applications->map(fn($app) => [
            'user'        => $app->user,
            'application' => $app,
            'attendance'  => $todayMap->get($app->user_id),
            'last7Days'   => $historyMap->get($app->user_id, collect()),
            'workingDays' => $workingDays,
        ]);

        return view('attendance.admin', compact('participants', 'filterDate', 'filterDivision', 'divisions'));
    }

    /**
     * Return the last N working days (Mon–Fri) ending on $filterDate, oldest first.
     * Extracted so it is computed once per request, not per participant.
     */
    private function computeWorkingDays(string $filterDate, int $count): \Illuminate\Support\Collection
    {
        $days    = collect();
        $current = Carbon::parse($filterDate);
        $back    = 0;

        while ($days->count() < $count) {
            $date = $current->copy()->subDays($back++);
            if (! $date->isWeekend()) {
                $days->push($date->toDateString());
            }
            if ($back > 30) break; // safety cap
        }

        return $days->sort()->values();
    }
}
