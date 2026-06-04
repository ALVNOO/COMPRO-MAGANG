<?php

namespace App\Observers;

use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Cache;

class InternshipApplicationObserver
{
    private function bustDashboardCache(): void
    {
        Cache::forget('admin.dashboard.stats');
        Cache::forget('admin.divisions.withcount');
    }

    public function created(InternshipApplication $internshipApplication): void
    {
        $this->bustDashboardCache();
    }

    public function updated(InternshipApplication $internshipApplication): void
    {
        $this->bustDashboardCache();
    }

    public function deleted(InternshipApplication $internshipApplication): void
    {
        $this->bustDashboardCache();
    }
}
