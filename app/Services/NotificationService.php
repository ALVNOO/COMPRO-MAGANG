<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user.
     */
    public static function create(User $user, string $type, string $title, string $message, string $icon = 'info', ?string $link = null, ?array $data = null)
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'link' => $link,
            'data' => $data,
        ]);
    }

    /**
     * Create notification for assignment created.
     */
    public static function assignmentCreated(User $user, $assignment)
    {
        return self::create(
            $user,
            'assignment_created',
            'Tugas baru telah diberikan',
            "Anda mendapat tugas baru: {$assignment->title}",
            'success',
            route('dashboard.assignments'),
            ['assignment_id' => $assignment->id]
        );
    }

    /**
     * Create notification for assignment graded.
     */
    public static function assignmentGraded(User $user, $assignment)
    {
        return self::create(
            $user,
            'assignment_graded',
            'Tugas telah dinilai',
            "Tugas '{$assignment->title}' telah dinilai dengan nilai {$assignment->grade}",
            'success',
            route('dashboard.assignments'),
            ['assignment_id' => $assignment->id, 'grade' => $assignment->grade]
        );
    }

    /**
     * Create notification for attendance reminder.
     */
    public static function attendanceReminder(User $user)
    {
        return self::create(
            $user,
            'attendance_reminder',
            'Absensi hari ini belum diisi',
            'Jangan lupa untuk mengisi absensi hari ini',
            'info',
            route('attendance.index')
        );
    }

    /**
     * Create notification for deadline warning.
     */
    public static function deadlineWarning(User $user, $assignment)
    {
        $daysLeft = now()->diffInDays($assignment->deadline, false);
        $message = $daysLeft > 0 
            ? "Deadline tugas '{$assignment->title}' tinggal {$daysLeft} hari lagi"
            : "Deadline tugas '{$assignment->title}' sudah lewat";

        return self::create(
            $user,
            'deadline_warning',
            $daysLeft > 0 ? 'Deadline tugas mendekat' : 'Deadline tugas terlambat',
            $message,
            'warning',
            route('dashboard.assignments'),
            ['assignment_id' => $assignment->id, 'days_left' => $daysLeft]
        );
    }

    /**
     * Create notification for mentor when assignment is submitted.
     */
    public static function assignmentSubmitted(User $mentor, $assignment, $participantName)
    {
        // Reload assignment untuk mendapatkan jumlah submission terbaru
        $assignment->refresh();
        $submissionCount = $assignment->submissions()->count();
        $isRevision = $submissionCount > 1;
        
        $message = $isRevision
            ? "{$participantName} telah mengumpulkan ulang tugas: {$assignment->title}"
            : "{$participantName} telah mengumpulkan tugas: {$assignment->title}";

        return self::create(
            $mentor,
            'assignment_submitted',
            $isRevision ? 'Tugas Dikumpulkan Ulang' : 'Tugas Baru Dikumpulkan',
            $message,
            'info',
            route('mentor.penugasan'),
            ['assignment_id' => $assignment->id, 'participant_name' => $participantName, 'is_revision' => $isRevision]
        );
    }
}

