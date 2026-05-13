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
     * Can apply if no pending or active applications, and not permanently rejected.
     */
    public function canApplyForInternship(): bool
    {
        if ($this->hasPendingApplication() || $this->hasActiveInternship()) {
            return false;
        }

        return !$this->isPermanentlyRejected();
    }

    /**
     * Check if user is permanently rejected (cannot reapply ever).
     */
    public function isPermanentlyRejected(): bool
    {
        return $this->internshipApplications()
            ->where('status', 'permanently_rejected')
            ->exists();
    }

    /**
     * Check if user can reapply after rejection (1 month cooldown).
     */
    public function canReapplyForInternship(): bool
    {
        // User dapat mengajukan ulang selama:
        // - Tidak ada pengajuan pending, dan
        // - Tidak sedang memiliki pengajuan dengan status accepted, dan
        // - Tidak di-blacklist (permanently_rejected)
        if ($this->hasPendingApplication() || $this->isPermanentlyRejected()) {
            return false;
        }

        $hasAccepted = $this->internshipApplications()
            ->where('status', 'accepted')
            ->exists();

        return !$hasAccepted;
    }

    /**
     * Get the reapply eligible date (1 month after last rejection).
     */
    public function getReapplyDateAttribute(): ?\Carbon\Carbon
    {
        // Cooldown 1 bulan setelah penolakan sudah dihapus.
        // Method ini dikembalikan null untuk kompatibilitas ke belakang.
        return null;
    }
}
