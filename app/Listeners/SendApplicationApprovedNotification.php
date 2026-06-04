<?php

namespace App\Listeners;

use App\Events\ApplicationApproved;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendApplicationApprovedNotification implements ShouldQueue
{
    public int $tries = 3;

    public function handle(ApplicationApproved $event): void
    {
        $app = $event->application;

        NotificationService::create(
            $app->user,
            'application_approved',
            'Pengajuan magang diterima!',
            'Selamat! Pengajuan magang Anda telah diterima. Silakan lengkapi profil dan dokumen Anda.',
            'success',
            route('dashboard'),
            ['application_id' => $app->id]
        );
    }
}
