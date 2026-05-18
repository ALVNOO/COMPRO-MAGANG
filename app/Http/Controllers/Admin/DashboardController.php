<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Rule;
use App\Models\User;
use App\Models\InternshipApplication;
use App\Services\Application\InternshipApplicationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function __construct(
        protected InternshipApplicationService $applicationService
    ) {}

    public function profile()
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function updateBiodata(Request $request)
    {
        $request->validateWithBag('biodata', [
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('admin.profile')
            ->with('biodata_success', 'Nomor WhatsApp berhasil diperbarui.');
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'profile_picture.required' => 'File foto harus dipilih.',
            'profile_picture.image'    => 'File harus berupa gambar.',
            'profile_picture.mimes'    => 'Format file harus JPG, JPEG, atau PNG.',
            'profile_picture.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profile-pictures', 'public');
        $user->profile_picture = $path;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto profil berhasil diperbarui.']);
        }

        return redirect()->route('admin.profile')
            ->with('photo_success', 'Foto profil berhasil diperbarui.');
    }

    public function removeProfilePicture(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Foto profil berhasil dihapus.']);
        }

        return redirect()->route('admin.profile')
            ->with('photo_success', 'Foto profil berhasil dihapus.');
    }

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
        $totalMentors = User::where('role', 'pembimbing')->count();

        // Applications per status for pie chart
        $statusDistribution = [
            'pending' => $pendingCount,
            'accepted' => $acceptedCount,
            'rejected' => $rejectedCount,
            'finished' => $finishedCount,
        ];

        // Active participants per division (new structure)
        $activePerDivision = InternshipApplication::select('division_admin_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'accepted')
            ->whereNotNull('division_admin_id')
            ->groupBy('division_admin_id')
            ->with('divisionAdmin')
            ->get()
            ->map(fn($item) => [
                'name'  => $item->divisionAdmin->division_name ?? '—',
                'count' => (int) $item->total,
            ])
            ->sortByDesc('count')
            ->take(8)
            ->values();

        // Applications per division for bar chart (legacy fallback)
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
            'activePerDivision' => $activePerDivision,
            'applicationsPerDivision' => $applicationsPerDivision,
            'recentActivity' => $recentActivity,
        ]);
    }
}
