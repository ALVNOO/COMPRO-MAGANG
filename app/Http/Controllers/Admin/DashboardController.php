<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Rule;
use App\Models\User;
use App\Models\InternshipApplication;
use App\Services\Application\InternshipApplicationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        protected InternshipApplicationService $applicationService
    ) {}

    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $stats = $this->applicationService->getDashboardStats();
        $recentApplications = $this->applicationService->getRecentPendingApplications(10);

        $divisions = Divisi::withCount(['internshipApplications' => function ($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }])->get();

        $rule = Rule::first();

        // Additional statistics for enhanced dashboard
        $pendingCount = InternshipApplication::where('status', 'pending')->count();
        $acceptedCount = InternshipApplication::where('status', 'accepted')->count();
        $rejectedCount = InternshipApplication::where('status', 'rejected')->count();
        $finishedCount = InternshipApplication::where('status', 'finished')->count();

        // Today's registrations
        $todayRegistrations = User::where('role', 'peserta')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Active mentors (mentors with active participants)
        $activeMentors = Divisi::whereHas('internshipApplications', function($q) {
            $q->where('status', 'accepted');
        })->count();

        // Total mentors
        $totalMentors = User::where('role', 'mentor')->count();

        // Applications per status for pie chart
        $statusDistribution = [
            'pending' => $pendingCount,
            'accepted' => $acceptedCount,
            'rejected' => $rejectedCount,
            'finished' => $finishedCount,
        ];

        // Applications over last 30 days for line chart
        $applicationsOverTime = InternshipApplication::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->map(function($item) {
            return [
                'date' => Carbon::parse($item->date)->format('d M'),
                'count' => $item->count
            ];
        });

        // Applications per division for bar chart
        $applicationsPerDivision = Divisi::withCount('internshipApplications')
            ->orderByDesc('internship_applications_count')
            ->limit(10)
            ->get()
            ->map(function($divisi) {
                return [
                    'name' => $divisi->name,
                    'count' => $divisi->internship_applications_count
                ];
            });

        // Recent activity (last 7 days)
        $recentActivity = InternshipApplication::with('user')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'totalParticipants' => $stats['total_participants'],
            'totalApplications' => $stats['total_applications'],
            'totalFinishedParticipants' => $stats['total_finished'],
            'recentApplications' => $recentApplications,
            'divisions' => $divisions,
            'rule' => $rule,
            // New data for enhanced dashboard
            'pendingCount' => $pendingCount,
            'acceptedCount' => $acceptedCount,
            'rejectedCount' => $rejectedCount,
            'finishedCount' => $finishedCount,
            'todayRegistrations' => $todayRegistrations,
            'activeMentors' => $activeMentors,
            'totalMentors' => $totalMentors,
            'statusDistribution' => $statusDistribution,
            'applicationsOverTime' => $applicationsOverTime,
            'applicationsPerDivision' => $applicationsPerDivision,
            'recentActivity' => $recentActivity,
        ]);
    }
}
