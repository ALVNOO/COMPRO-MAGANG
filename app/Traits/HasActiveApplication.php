<?php

namespace App\Traits;

use App\Models\InternshipApplication;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasActiveApplication
{
    /**
     * Get active internship applications (accepted or finished).
     */
    public function activeApplications(): HasMany
    {
        return $this->internshipApplications()
            ->whereIn('status', ['accepted', 'finished']);
    }

    /**
     * Get the current active application.
     */
    public function getActiveApplicationAttribute(): ?InternshipApplication
    {
        return $this->activeApplications()
            ->with(['divisionAdmin', 'divisionMentor', 'fieldOfInterest'])
            ->latest()
            ->first();
    }

    /**
     * Get the pending application if exists.
     */
    public function getPendingApplicationAttribute(): ?InternshipApplication
    {
        return $this->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();
    }

    /**
     * Get the latest application regardless of status.
     */
    public function getLatestApplicationAttribute(): ?InternshipApplication
    {
        return $this->internshipApplications()
            ->with(['divisionAdmin', 'divisionMentor', 'fieldOfInterest'])
            ->latest()
            ->first();
    }

    /**
     * Check if user has an active internship.
     */
    public function hasActiveInternship(): bool
    {
        return $this->activeApplications()->exists();
    }

    /**
     * Check if user has a pending application.
     */
    public function hasPendingApplication(): bool
    {
        return $this->internshipApplications()
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Check if user can apply for internship.
     * Can apply if no pending or active applications.
     */
    public function canApplyForInternship(): bool
    {
        return !$this->hasPendingApplication() && !$this->hasActiveInternship();
    }

    /**
     * Check if user can reapply after rejection (1 month cooldown).
     */
    public function canReapplyForInternship(): bool
    {
        if ($this->hasPendingApplication() || $this->hasActiveInternship()) {
            return false;
        }

        $lastRejected = $this->internshipApplications()
            ->where('status', 'rejected')
            ->latest()
            ->first();

        if (!$lastRejected) {
            return true;
        }

        return $lastRejected->updated_at->addMonth()->isPast();
    }

    /**
     * Get the reapply eligible date (1 month after last rejection).
     */
    public function getReapplyDateAttribute(): ?\Carbon\Carbon
    {
        $lastRejected = $this->internshipApplications()
            ->where('status', 'rejected')
            ->latest()
            ->first();

        return $lastRejected ? $lastRejected->updated_at->addMonth() : null;
    }
}
