<?php

namespace App\Services;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Notify mentor when a participant submits an assignment.
     */
    public static function assignmentSubmitted(User $mentorUser, Assignment $assignment, string $participantName)
    {
        $data = [
            'message' => "{$participantName} telah mengumpulkan penugasan: {$assignment->title}",
            'type' => 'assignment_submitted',
            'assignment_id' => $assignment->id,
            'assignment_title' => $assignment->title,
            'participant_name' => $participantName,
        ];

        return static::createNotification($mentorUser, 'assignment_submitted', $data);
    }

    /**
     * Notify participant when mentor creates a new assignment.
     */
    public static function assignmentCreated(User $user, Assignment $assignment)
    {
        $data = [
            'message' => "Penugasan baru: {$assignment->title}",
            'type' => 'assignment_created',
            'assignment_id' => $assignment->id,
            'assignment_title' => $assignment->title,
            'deadline' => $assignment->deadline?->toIso8601String(),
        ];

        return static::createNotification($user, 'assignment_created', $data);
    }

    /**
     * Create a database notification for the given user.
     */
    protected static function createNotification(User $user, string $type, array $data)
    {
        $id = (string) Str::uuid();
        $now = now();

        DB::table('notifications')->insert([
            'id' => $id,
            'type' => $type,
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->getKey(),
            'data' => json_encode($data),
            'read_at' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return (object) [
            'id' => $id,
            'type' => $type,
            'data' => $data,
        ];
    }
}
