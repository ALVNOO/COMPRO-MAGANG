<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [10, 30];
    public int $timeout = 30;

    public function __construct(
        private readonly int $userId,
        private readonly string $type,
        private readonly string $title,
        private readonly string $message,
        private readonly string $icon = 'info',
        private readonly ?string $link = null,
        private readonly ?array $data = null,
    ) {}

    public function handle(): void
    {
        Notification::create([
            'user_id' => $this->userId,
            'type'    => $this->type,
            'title'   => $this->title,
            'message' => $this->message,
            'icon'    => $this->icon,
            'link'    => $this->link,
            'data'    => $this->data,
        ]);
    }
}
