<?php

namespace App\Services\Application;

use App\Models\InternshipApplication;
use App\Models\User;
use App\Models\DivisiAdmin;
use App\Models\DivisionMentor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class InternshipApplicationService
{
    /**
     * Get active applications (accepted or finished) for a user.
     */
    public function getActiveApplications(User $user): Collection
    {
        return $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->with(['divisionAdmin', 'divisionMentor', 'fieldOfInterest'])
            ->get();
    }

    /**
     * Get the current active application for a user.
     */
    public function getActiveApplication(User $user): ?InternshipApplication
    {
        return $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->with(['divisionAdmin', 'divisionMentor', 'fieldOfInterest'])
            ->latest()
            ->first();
    }

    /**
     * Get pending application for a user.
     */
    public function getPendingApplication(User $user): ?InternshipApplication
    {
        return $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();
    }

    /**
     * Get the latest application regardless of status.
     */
    public function getLatestApplication(User $user, array $statuses = []): ?InternshipApplication
    {
        $query = $user->internshipApplications()
            ->with(['divisionAdmin', 'divisionMentor', 'fieldOfInterest']);

        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }

        return $query->latest()->first();
    }

    /**
     * Approve an application with division and mentor assignment.
     */
    public function approveApplication(int $applicationId, int $divisionId, ?int $mentorId = null): InternshipApplication
    {
        $application = InternshipApplication::findOrFail($applicationId);

        $application->division_admin_id = $divisionId;
        $application->division_mentor_id = $mentorId;
        $application->status = 'accepted';
        $application->notes = null; // Clear rejection notes if any
        $application->save();

        return $application->fresh(['divisionAdmin', 'divisionMentor', 'user']);
    }

    /**
     * Reject an application with optional notes.
     */
    public function rejectApplication(int $applicationId, ?string $notes = null): InternshipApplication
    {
        $application = InternshipApplication::findOrFail($applicationId);

        $application->status = 'rejected';
        $application->notes = $notes;
        $application->save();

        return $application->fresh(['user']);
    }

    /**
     * Postpone an application with notes.
     */
    public function postponeApplication(int $applicationId, ?string $notes = null): InternshipApplication
    {
        $application = InternshipApplication::findOrFail($applicationId);

        $application->status = 'postponed';
        $application->notes = $notes;
        $application->save();

        return $application->fresh(['user']);
    }

    /**
     * Update expired applications to finished status.
     * Call this when a user accesses their dashboard.
     */
    public function updateExpiredApplications(User $user): void
    {
        $user->internshipApplications()
            ->where('status', 'accepted')
            ->whereNotNull('end_date')
            ->where('end_date', '<', Carbon::today())
            ->update(['status' => 'finished']);
    }

    /**
     * Get all pending applications with related data.
     */
    public function getPendingApplications(): Collection
    {
        return InternshipApplication::with(['user', 'fieldOfInterest'])
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    /**
     * Get applications by status with pagination.
     */
    public function getApplicationsByStatus(string $status, int $perPage = 10)
    {
        return InternshipApplication::with(['user', 'divisionAdmin', 'divisionMentor', 'fieldOfInterest'])
            ->where('status', $status)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get accepted participants for a specific division.
     */
    public function getParticipantsByDivision(int $divisionId): Collection
    {
        return InternshipApplication::where('division_admin_id', $divisionId)
            ->whereIn('status', ['accepted', 'finished'])
            ->with(['user', 'divisionMentor'])
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Get accepted participants for a specific mentor.
     */
    public function getParticipantsByMentor(int $mentorId): Collection
    {
        return InternshipApplication::where('division_mentor_id', $mentorId)
            ->whereIn('status', ['accepted', 'finished'])
            ->with(['user', 'divisionAdmin'])
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Check if application is complete (all required documents uploaded).
     */
    public function isApplicationComplete(InternshipApplication $application): array
    {
        $missing = [];

        if (!$application->ktm_path) {
            $missing[] = 'KTM (Kartu Tanda Mahasiswa)';
        }
        if (!$application->surat_permohonan_path) {
            $missing[] = 'Surat Permohonan';
        }
        if (!$application->cv_path) {
            $missing[] = 'CV';
        }

        return [
            'is_complete' => empty($missing),
            'missing_documents' => $missing,
        ];
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStats(): array
    {
        $totalParticipants = User::where('role', 'peserta')
            ->whereHas('internshipApplications', function ($q) {
                $q->where('status', 'accepted');
            })
            ->count();

        $totalApplications = InternshipApplication::count();
        $totalFinishedParticipants = InternshipApplication::where('status', 'finished')->count();
        $pendingApplications = InternshipApplication::where('status', 'pending')->count();

        return [
            'total_participants' => $totalParticipants,
            'total_applications' => $totalApplications,
            'total_finished' => $totalFinishedParticipants,
            'pending_applications' => $pendingApplications,
        ];
    }

    /**
     * Get recent pending applications.
     */
    public function getRecentPendingApplications(int $limit = 10): Collection
    {
        return InternshipApplication::with(['user', 'divisi'])
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark acceptance letter as downloaded.
     */
    public function markAcceptanceLetterDownloaded(int $applicationId): InternshipApplication
    {
        $application = InternshipApplication::findOrFail($applicationId);
        $application->acceptance_letter_downloaded_at = now();
        $application->save();

        return $application;
    }

    /**
     * Update application document path.
     */
    public function updateDocumentPath(int $applicationId, string $documentType, string $path): InternshipApplication
    {
        $application = InternshipApplication::findOrFail($applicationId);

        $validDocuments = [
            'acceptance_letter' => 'acceptance_letter_path',
            'completion_letter' => 'completion_letter_path',
            'assessment_report' => 'assessment_report_path',
            'ktm' => 'ktm_path',
            'surat_permohonan' => 'surat_permohonan_path',
            'cv' => 'cv_path',
            'good_behavior' => 'good_behavior_path',
            'cover_letter' => 'cover_letter_path',
        ];

        if (!isset($validDocuments[$documentType])) {
            throw new \InvalidArgumentException("Invalid document type: {$documentType}");
        }

        $column = $validDocuments[$documentType];
        $application->$column = $path;
        $application->save();

        return $application;
    }
}
