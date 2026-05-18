<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $resetUrl;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->resetUrl = route('2fa.reset.confirm', ['token' => $token]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Two-Factor Authentication - Sistem Magang',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.2fa_reset',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
