<?php

namespace App\Events;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignmentSubmitted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Assignment $assignment,
        public readonly User $participant,
    ) {}
}
