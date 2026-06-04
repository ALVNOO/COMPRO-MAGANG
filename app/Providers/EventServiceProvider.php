<?php

namespace App\Providers;

use App\Events\ApplicationApproved;
use App\Events\ApplicationStatusChanged;
use App\Events\AssignmentGraded;
use App\Events\AssignmentSubmitted;
use App\Listeners\SendApplicationApprovedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event-to-listener mappings for the application.
     * All listeners that implement ShouldQueue run asynchronously via the queue worker.
     */
    protected $listen = [
        ApplicationApproved::class => [
            SendApplicationApprovedNotification::class,
        ],

        ApplicationStatusChanged::class => [
            // Future listeners: SendRevisionRequestedNotification, SendRejectionNotification, etc.
        ],

        AssignmentGraded::class => [
            // Future: SendAssignmentGradedNotification
        ],

        AssignmentSubmitted::class => [
            // Future: SendAssignmentSubmittedNotification (to mentor)
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
