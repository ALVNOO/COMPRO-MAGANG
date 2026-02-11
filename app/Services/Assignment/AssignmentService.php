<?php

namespace App\Services\Assignment;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\InternshipApplication;
use App\Models\DivisionMentor;
use Illuminate\Database\Eloquent\Collection;

class AssignmentService
{
    /**
     * Get assignments for a user.
     */
    public function getAssignmentsForUser(int $userId): Collection
    {
        return Assignment::where('user_id', $userId)
            ->orderBy('deadline', 'asc')
            ->get();
    }

    /**
     * Get assignments created by a mentor for their participants.
     */
    public function getAssignmentsForMentor(DivisionMentor $mentor): Collection
    {
        return Assignment::whereHas('user.internshipApplications', function ($q) use ($mentor) {
            $q->where('division_mentor_id', $mentor->id)
                ->where('status', 'accepted');
        })->with(['user', 'submissions'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get assignment with submissions.
     */
    public function getAssignmentWithSubmissions(int $assignmentId): Assignment
    {
        return Assignment::with(['user', 'submissions'])
            ->findOrFail($assignmentId);
    }

    /**
     * Create a new assignment.
     */
    public function createAssignment(array $data): Assignment
    {
        return Assignment::create([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'assignment_type' => $data['assignment_type'] ?? 'task',
            'description' => $data['description'],
            'deadline' => $data['deadline'],
            'presentation_date' => $data['presentation_date'] ?? null,
            'file_path' => $data['file_path'] ?? null,
        ]);
    }

    /**
     * Update an assignment.
     */
    public function updateAssignment(int $assignmentId, array $data): Assignment
    {
        $assignment = Assignment::findOrFail($assignmentId);

        $assignment->update([
            'title' => $data['title'] ?? $assignment->title,
            'assignment_type' => $data['assignment_type'] ?? $assignment->assignment_type,
            'description' => $data['description'] ?? $assignment->description,
            'deadline' => $data['deadline'] ?? $assignment->deadline,
            'presentation_date' => $data['presentation_date'] ?? $assignment->presentation_date,
            'file_path' => $data['file_path'] ?? $assignment->file_path,
        ]);

        return $assignment;
    }

    /**
     * Delete an assignment.
     */
    public function deleteAssignment(int $assignmentId): bool
    {
        $assignment = Assignment::findOrFail($assignmentId);
        return $assignment->delete();
    }

    /**
     * Submit an assignment.
     */
    public function submitAssignment(int $assignmentId, string $filePath, ?string $notes = null): AssignmentSubmission
    {
        $assignment = Assignment::findOrFail($assignmentId);

        // Update assignment submitted_at if first submission
        if (!$assignment->submitted_at) {
            $assignment->update([
                'submission_file_path' => $filePath,
                'submitted_at' => now(),
            ]);
        }

        // Create submission record
        return AssignmentSubmission::create([
            'assignment_id' => $assignmentId,
            'file_path' => $filePath,
            'notes' => $notes,
            'submitted_at' => now(),
        ]);
    }

    /**
     * Grade an assignment.
     */
    public function gradeAssignment(int $assignmentId, string $grade, ?string $feedback = null): Assignment
    {
        $assignment = Assignment::findOrFail($assignmentId);

        $assignment->update([
            'grade' => $grade,
        ]);

        // Update latest submission with feedback if provided
        if ($feedback) {
            $latestSubmission = $assignment->submissions()->latest()->first();
            if ($latestSubmission) {
                $latestSubmission->update(['feedback' => $feedback]);
            }
        }

        return $assignment;
    }

    /**
     * Request revision for an assignment.
     */
    public function requestRevision(int $assignmentId, string $feedback): Assignment
    {
        $assignment = Assignment::findOrFail($assignmentId);

        $assignment->update([
            'grade' => 'revision',
        ]);

        // Update latest submission with revision feedback
        $latestSubmission = $assignment->submissions()->latest()->first();
        if ($latestSubmission) {
            $latestSubmission->update([
                'feedback' => $feedback,
                'status' => 'revision_requested',
            ]);
        }

        return $assignment;
    }

    /**
     * Get pending assignments (not submitted, deadline not passed).
     */
    public function getPendingAssignments(int $userId): Collection
    {
        return Assignment::where('user_id', $userId)
            ->whereNull('submitted_at')
            ->where('deadline', '>=', today())
            ->orderBy('deadline', 'asc')
            ->get();
    }

    /**
     * Get overdue assignments (not submitted, deadline passed).
     */
    public function getOverdueAssignments(int $userId): Collection
    {
        return Assignment::where('user_id', $userId)
            ->whereNull('submitted_at')
            ->where('deadline', '<', today())
            ->orderBy('deadline', 'asc')
            ->get();
    }

    /**
     * Get graded assignments.
     */
    public function getGradedAssignments(int $userId): Collection
    {
        return Assignment::where('user_id', $userId)
            ->whereNotNull('grade')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Get assignment statistics for a user.
     */
    public function getAssignmentStats(int $userId): array
    {
        $assignments = Assignment::where('user_id', $userId)->get();

        return [
            'total' => $assignments->count(),
            'submitted' => $assignments->whereNotNull('submitted_at')->count(),
            'graded' => $assignments->whereNotNull('grade')->count(),
            'pending' => $assignments->whereNull('submitted_at')->where('deadline', '>=', today())->count(),
            'overdue' => $assignments->whereNull('submitted_at')->where('deadline', '<', today())->count(),
        ];
    }

    /**
     * Get recent submissions for mentor view.
     */
    public function getRecentSubmissionsForMentor(DivisionMentor $mentor, int $limit = 10): Collection
    {
        return AssignmentSubmission::whereHas('assignment.user.internshipApplications', function ($q) use ($mentor) {
            $q->where('division_mentor_id', $mentor->id)
                ->where('status', 'accepted');
        })->with(['assignment.user'])
            ->orderBy('submitted_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get assignments needing grading for mentor.
     */
    public function getAssignmentsNeedingGrading(DivisionMentor $mentor): Collection
    {
        return Assignment::whereHas('user.internshipApplications', function ($q) use ($mentor) {
            $q->where('division_mentor_id', $mentor->id)
                ->where('status', 'accepted');
        })->whereNotNull('submitted_at')
            ->whereNull('grade')
            ->with(['user', 'submissions'])
            ->orderBy('submitted_at', 'asc')
            ->get();
    }
}
