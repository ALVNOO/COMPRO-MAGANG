<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\InternshipApplication;
use App\Models\DivisiAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
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
            'user_id' => $user->id,
            'date' => $today,
            'status' => $status,
            'check_in_time' => $checkInTime,
            'photo_path' => $photoPath,
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
        
        $participants = collect();
        foreach ($applications as $app) {
            $attendance = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', $filterDate)
                ->first();
            
            // Get last 7 working days (excluding Saturday and Sunday)
            $workingDays = collect();
            $currentDate = Carbon::parse($filterDate);
            $daysBack = 0;
            
            while ($workingDays->count() < 7) {
                $checkDate = $currentDate->copy()->subDays($daysBack);
                // Skip Saturday (6) and Sunday (0)
                if ($checkDate->dayOfWeek != Carbon::SATURDAY && $checkDate->dayOfWeek != Carbon::SUNDAY) {
                    $workingDays->push($checkDate->toDateString());
                }
                $daysBack++;
                // Safety check to avoid infinite loop
                if ($daysBack > 20) break;
            }
            
            // Sort working days from oldest to newest
            $workingDays = $workingDays->sort()->values();
            
            $startDate = $workingDays->first();
            $endDate = $workingDays->last();
            
            $last7Days = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->orderBy('date', 'asc')
                ->get();
            
            $participants->push([
                'user' => $app->user,
                'attendance' => $attendance,
                'last7Days' => $last7Days,
                'workingDays' => $workingDays,
            ]);
        }
        
        return view('mentor.absensi', [
            'participants' => $participants,
            'filterDate' => $filterDate,
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
        
        $participants = collect();
        foreach ($applications as $app) {
            $attendance = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', $filterDate)
                ->first();
            
            // Get last 7 working days (excluding Saturday and Sunday)
            $workingDays = collect();
            $currentDate = Carbon::parse($filterDate);
            $daysBack = 0;
            
            while ($workingDays->count() < 7) {
                $checkDate = $currentDate->copy()->subDays($daysBack);
                // Skip Saturday (6) and Sunday (0)
                if ($checkDate->dayOfWeek != Carbon::SATURDAY && $checkDate->dayOfWeek != Carbon::SUNDAY) {
                    $workingDays->push($checkDate->toDateString());
                }
                $daysBack++;
                // Safety check to avoid infinite loop
                if ($daysBack > 20) break;
            }
            
            // Sort working days from oldest to newest
            $workingDays = $workingDays->sort()->values();
            
            $startDate = $workingDays->first();
            $endDate = $workingDays->last();
            
            $last7Days = Attendance::where('user_id', $app->user_id)
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $endDate)
                ->orderBy('date', 'asc')
                ->get();
            
            $participants->push([
                'user' => $app->user,
                'application' => $app,
                'attendance' => $attendance,
                'last7Days' => $last7Days,
                'workingDays' => $workingDays,
            ]);
        }
        
        return view('attendance.admin', compact('participants', 'filterDate', 'filterDivision', 'divisions'));
    }
}
