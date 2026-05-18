<?php

namespace App\Http\View\Composers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SystemAlertsComposer
{
    public function compose(View $view): void
    {
        if (! Auth::check()) {
            $view->with('systemAlertsData', []);

            return;
        }

        $user = Auth::user();

        $alerts = match ($user->role) {
            'peserta'    => $this->pesertaAlerts($user),
            'pembimbing' => $this->pembimbingAlerts($user),
            'admin'      => $this->adminAlerts(),
            default      => [],
        };

        $view->with('systemAlertsData', $alerts);
    }

    private function pesertaAlerts($user): array
    {
        $alerts = [];

        $application = $user->internshipApplications()
            ->where('status', 'accepted')
            ->latest()
            ->first();

        $isActive = $application
            && $application->start_date
            && $application->end_date
            && now()->startOfDay()->gte(Carbon::parse($application->start_date)->startOfDay())
            && now()->startOfDay()->lte(Carbon::parse($application->end_date)->startOfDay());

        if ($isActive && ! now()->isWeekend()) {
            if (! $user->attendances()->whereDate('date', today())->exists()) {
                $alerts[] = [
                    'id'      => 'sys-absen-today',
                    'message' => 'Jangan lupa absen kehadiran hari ini!',
                    'icon'    => 'warning',
                    'is_read' => false,
                    'time_ago' => 'Hari ini',
                    'link'    => route('attendance.index'),
                ];
            }

            if (! \App\Models\Logbook::where('user_id', $user->id)->whereDate('date', today())->exists()) {
                $alerts[] = [
                    'id'      => 'sys-logbook-today',
                    'message' => 'Logbook harian belum diisi, isi sekarang!',
                    'icon'    => 'info',
                    'is_read' => false,
                    'time_ago' => 'Hari ini',
                    'link'    => route('logbook.index'),
                ];
            }
        }

        // Tugas baru (7 hari terakhir, belum dikumpulkan, bukan revisi)
        $newAssignments = $user->assignments()
            ->where('created_at', '>=', now()->subDays(7))
            ->whereDoesntHave('submissions', fn ($q) => $q->where('user_id', $user->id))
            ->where(fn ($q) => $q->whereNull('is_revision')->orWhere('is_revision', 0))
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($newAssignments as $assignment) {
            $alerts[] = [
                'id'      => 'sys-new-task-'.$assignment->id,
                'message' => 'Tugas baru: '.$assignment->title,
                'icon'    => 'info',
                'is_read' => false,
                'time_ago' => $assignment->created_at->locale('id')->diffForHumans(),
                'link'    => route('dashboard.assignments'),
            ];
        }

        // Tugas yang perlu direvisi
        $revisionAssignments = $user->assignments()
            ->where('is_revision', 1)
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($revisionAssignments as $assignment) {
            $alerts[] = [
                'id'      => 'sys-revisi-'.$assignment->id,
                'message' => 'Revisi tugas: '.$assignment->title,
                'icon'    => 'warning',
                'is_read' => false,
                'time_ago' => $assignment->updated_at->locale('id')->diffForHumans(),
                'link'    => route('dashboard.assignments'),
            ];
        }

        return $alerts;
    }

    private function pembimbingAlerts($user): array
    {
        $alerts = [];
        $divisionMentor = \App\Models\DivisionMentor::where('nik_number', $user->username)->first();

        if (! $divisionMentor) {
            return $alerts;
        }

        // Tugas yang perlu dinilai
        $assignmentsToGrade = \App\Models\Assignment::whereHas('user.internshipApplications', function ($q) use ($divisionMentor) {
            $q->where('division_mentor_id', $divisionMentor->id)->where('status', 'accepted');
        })->whereNotNull('submission_file_path')->whereNull('grade')->count();

        if ($assignmentsToGrade > 0) {
            $alerts[] = [
                'id'      => 'sys-grade',
                'message' => 'Ada '.$assignmentsToGrade.' tugas peserta menunggu penilaian Anda.',
                'icon'    => 'warning',
                'is_read' => false,
                'time_ago' => 'Sekarang',
                'link'    => route('mentor.penugasan'),
            ];
        }

        // Presentasi mendatang (7 hari ke depan)
        $upcomingPresentations = \App\Models\Assignment::whereHas('user.internshipApplications', function ($q) use ($divisionMentor) {
            $q->where('division_mentor_id', $divisionMentor->id)->where('status', 'accepted');
        })->where('assignment_type', 'tugas_proyek')
            ->whereNotNull('presentation_date')
            ->whereBetween('presentation_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->with('user')->orderBy('presentation_date')->limit(3)->get();

        foreach ($upcomingPresentations as $pres) {
            $alerts[] = [
                'id'      => 'sys-pres-'.$pres->id,
                'message' => ($pres->user->name ?? '-').' — Presentasi '.Carbon::parse($pres->presentation_date)->locale('id')->isoFormat('D MMM'),
                'icon'    => 'info',
                'is_read' => false,
                'time_ago' => Carbon::parse($pres->presentation_date)->locale('id')->diffForHumans(),
                'link'    => route('mentor.penugasan'),
            ];
        }

        // Aktivitas terbaru peserta (3 hari terakhir)
        $participantUserIds = \App\Models\InternshipApplication::where('division_mentor_id', $divisionMentor->id)
            ->where('status', 'accepted')->pluck('user_id');

        if ($participantUserIds->isNotEmpty()) {
            $logbookItems = \App\Models\Logbook::whereIn('user_id', $participantUserIds)
                ->where('date', '>=', now()->subDays(3))->with('user')
                ->orderByDesc('date')->limit(5)->get()
                ->map(fn ($l) => [
                    'id'      => 'sys-act-log-'.$l->id,
                    'message' => ($l->user->name ?? '-').': Submit logbook harian',
                    'icon'    => 'info',
                    'is_read' => false,
                    'time_ago' => Carbon::parse($l->date)->locale('id')->diffForHumans(),
                    'link'    => route('mentor.logbook'),
                    '_sort'   => Carbon::parse($l->date)->timestamp,
                ]);

            $submissionItems = \App\Models\AssignmentSubmission::whereIn('user_id', $participantUserIds)
                ->where('submitted_at', '>=', now()->subDays(3))
                ->with(['user', 'assignment'])->orderByDesc('submitted_at')->limit(5)->get()
                ->map(fn ($s) => [
                    'id'      => 'sys-act-sub-'.$s->id,
                    'message' => ($s->user->name ?? '-').': Mengumpulkan — '.\Illuminate\Support\Str::limit($s->assignment->title ?? '-', 40),
                    'icon'    => 'success',
                    'is_read' => false,
                    'time_ago' => Carbon::parse($s->submitted_at)->locale('id')->diffForHumans(),
                    'link'    => route('mentor.penugasan'),
                    '_sort'   => Carbon::parse($s->submitted_at)->timestamp,
                ]);

            $feed = $logbookItems->merge($submissionItems)
                ->sortByDesc('_sort')->take(5)
                ->map(fn ($item) => array_diff_key($item, ['_sort' => '']))
                ->values();

            foreach ($feed as $item) {
                $alerts[] = $item;
            }
        }

        return $alerts;
    }

    private function adminAlerts(): array
    {
        $alerts = [];

        $pendingCount = \App\Models\InternshipApplication::where('status', 'pending')->count();
        if ($pendingCount > 0) {
            $alerts[] = [
                'id'      => 'sys-pending-apps',
                'message' => 'Ada '.$pendingCount.' pengajuan magang menunggu ditinjau.',
                'icon'    => 'warning',
                'is_read' => false,
                'time_ago' => 'Sekarang',
                'link'    => route('admin.applications'),
            ];
        }

        return $alerts;
    }
}
