<?php

namespace App\Mail;

use App\Models\InternshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class HeadquartersInternshipMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [60, 300];
    public int $timeout = 120;

    public InternshipApplication $application;

    public function __construct(InternshipApplication $application)
    {
        $this->application = $application;
    }

    public function envelope(): Envelope
    {
        $participantEmail = $this->application->user->email ?? null;

        return new Envelope(
            subject: 'Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel',
            cc: $participantEmail ? [$participantEmail] : [],
        );
    }

    public function content(): Content
    {
        $app  = $this->application;
        $user = $app->user;

        return new Content(
            view: 'emails.headquarters_internship',
            with: [
                'participantName'    => $user->name,
                'participantNim'     => $user->nim ?? '-',
                'participantFaculty' => $user->major ?? '-',
                'participantUniv'    => $user->university ?? '-',
                'mentorName'         => $app->divisionMentor->mentor_name ?? '-',
                'mentorNik'          => $app->divisionMentor->nik_number ?? '-',
                'startDate'          => $app->start_date ? $app->start_date->translatedFormat('d F Y') : '-',
                'endDate'            => $app->end_date   ? $app->end_date->translatedFormat('d F Y')   : '-',
                'divisionName'       => $app->divisionAdmin->division_name ?? '-',
            ],
        );
    }

    public function attachments(): array
    {
        $app   = $this->application;
        $name  = str_replace(' ', '_', $app->user->name ?? 'Peserta');
        $list  = [];

        $docs = [
            'surat_permohonan_path' => "Surat_Permohonan_{$name}.pdf",
            'cv_path'               => "Curriculum_Vitae_{$name}.pdf",
            'good_behavior_path'    => "Surat_Berperilaku_Baik_{$name}.pdf",
            'ktm_path'              => "KTP_KTM_{$name}.pdf",
        ];

        $disk = config('filesystems.default_upload_disk', 'public');

        foreach ($docs as $field => $filename) {
            $path = $app->$field;
            if ($path && Storage::disk($disk)->exists($path)) {
                $list[] = Attachment::fromStorageDisk($disk, $path)
                    ->as($filename)
                    ->withMime('application/pdf');
            }
        }

        return $list;
    }
}
