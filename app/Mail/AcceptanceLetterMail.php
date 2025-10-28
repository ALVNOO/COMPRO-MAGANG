<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\InternshipApplication;

class AcceptanceLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(InternshipApplication $application, $pdfContent = null)
    {
        $this->application = $application;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Surat Penerimaan Magang - PT. Pos Indonesia (Persero)',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $user = $this->application->user;
        $divisi = $this->application->divisi;
        
        return new Content(
            view: 'emails.acceptance_letter',
            with: [
                'name' => $user->name,
                'divisi' => $divisi->name,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!$this->pdfContent) {
            return [];
        }
        
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'Surat_Penerimaan_Magang.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
