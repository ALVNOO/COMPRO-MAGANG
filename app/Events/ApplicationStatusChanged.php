<?php

namespace App\Events;

use App\Models\InternshipApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly InternshipApplication $application,
        public readonly string $newStatus,
        public readonly ?string $notes = null,
    ) {}
}
