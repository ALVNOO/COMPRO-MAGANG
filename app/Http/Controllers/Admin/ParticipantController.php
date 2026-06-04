<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\DivisionMentor;
use App\Models\InternshipApplication;
use App\Models\User;
use App\Services\Application\InternshipApplicationService;
use App\Services\Document\FileUploadService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function __construct(
        protected InternshipApplicationService $applicationService,
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Display list of participants (only those with accepted or finished applications).
     */
    public function index()
    {
        $participants = User::where('role', 'peserta')
            ->whereHas('internshipApplications', function ($query) {
                $query->whereIn('status', ['accepted', 'finished']);
            })
            ->with([
                'internshipApplications' => function ($query) {
                    // Load divisionAdmin WITHOUT .mentors — mentors are pre-loaded below
                    // via a single grouped query instead of once per participant.
                    $query->whereIn('status', ['accepted', 'finished'])
                        ->with(['divisionAdmin', 'divisionMentor']);
                },
                'certificates',
                'assignments',
            ])
            ->get();

        // Pre-load mentors for each division in ONE query grouped by division_id.
        // This replaces the N redundant mentor loads that happened when participants
        // shared the same division (divisionAdmin.mentors eager-loaded per participant).
        $divisionIds    = $participants->flatMap->internshipApplications->pluck('division_admin_id')->unique()->filter();
        $mentorsByDivision = \App\Models\DivisionMentor::whereIn('division_id', $divisionIds)
            ->get()->groupBy('division_id');

        $adminHqEmail = Auth::user()->headquarters_email;

        return view('admin.participants', compact('participants', 'mentorsByDivision', 'adminHqEmail'));
    }

    /**
     * Upload acceptance letter for an application.
     */
    public function uploadAcceptanceLetter(Request $request, $applicationId)
    {
        $request->validate([
            'acceptance_letter' => 'required|file|mimes:pdf|max:10240',
        ]);

        $application = InternshipApplication::findOrFail($applicationId);

        $path = $this->fileUploadService->uploadAcceptanceLetter(
            $request->file('acceptance_letter'),
            $application->acceptance_letter_path
        );

        $application->acceptance_letter_path = $path;
        $application->save();

        return redirect()->route('admin.participants')
            ->with('success', 'Surat penerimaan berhasil diupload.');
    }

    /**
     * Download assessment report.
     */
    public function downloadAssessmentReport($applicationId)
    {
        $application = InternshipApplication::findOrFail($applicationId);

        if (! $application->assessment_report_path || ! $this->fileUploadService->exists($application->assessment_report_path)) {
            return redirect()->route('admin.participants')
                ->with('error', 'File laporan tidak ditemukan.');
        }

        return $this->fileUploadService->download(
            $application->assessment_report_path,
            'Laporan_Penilaian_'.$application->user->name.'.pdf'
        );
    }

    /**
     * Upload completion letter for an application.
     */
    public function uploadCompletionLetter(Request $request, $applicationId)
    {
        $request->validate([
            'completion_letter' => 'required|file|mimes:pdf|max:10240',
        ]);

        $application = InternshipApplication::findOrFail($applicationId);

        $path = $this->fileUploadService->uploadCompletionLetter(
            $request->file('completion_letter'),
            $application->completion_letter_path
        );

        $application->completion_letter_path = $path;
        $application->save();

        return redirect()->route('admin.participants')
            ->with('success', 'Surat keterangan selesai magang berhasil diupload.');
    }

    /**
     * Upload location permission letter for an application.
     */
    public function uploadLocationPermissionLetter(Request $request, $applicationId)
    {
        $request->validate([
            'location_permission_letter' => 'required|file|mimes:pdf|max:10240',
        ]);

        $application = InternshipApplication::findOrFail($applicationId);

        $path = $this->fileUploadService->uploadLocationPermissionLetter(
            $request->file('location_permission_letter'),
            $application->location_permission_letter_path
        );

        $application->location_permission_letter_path = $path;
        $application->save();

        return redirect()->route('admin.participants')
            ->with('success', 'Surat izin masuk lokasi berhasil diupload.');
    }

    /**
     * Upload integrity pact document for an application.
     */
    public function uploadIntegrityPact(Request $request, $applicationId)
    {
        $request->validate([
            'integrity_pact' => 'required|file|mimes:pdf|max:10240',
        ]);

        $application = InternshipApplication::findOrFail($applicationId);

        $path = $this->fileUploadService->uploadIntegrityPact(
            $request->file('integrity_pact'),
            $application->integrity_pact_path
        );

        $application->integrity_pact_path = $path;
        $application->save();

        return redirect()->route('admin.participants')
            ->with('success', 'Pakta integritas berhasil diupload.');
    }

    /**
     * Upload certificate for a user.
     */
    public function uploadCertificate(Request $request, $userId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:10240',
        ]);

        $user = User::findOrFail($userId);

        $application = InternshipApplication::where('user_id', $userId)
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        // Find or create certificate record
        $certificate = Certificate::where('user_id', $userId)->first();

        if ($certificate) {
            // Delete old file if exists
            $this->fileUploadService->delete($certificate->certificate_path);
        } else {
            // Create new certificate
            $certificate = new Certificate;
            $certificate->user_id = $userId;

            if ($application) {
                $certificate->internship_application_id = $application->id;
            }
        }

        // Upload new file
        $path = $this->fileUploadService->uploadCertificate($request->file('certificate'));
        $certificate->certificate_path = $path;
        $certificate->issued_at = now();
        $certificate->save();

        return redirect()->route('admin.participants')
            ->with('success', 'Sertifikat berhasil diupload.');
    }

    /**
     * Change mentor assignment for accepted participant.
     */
    public function changeMentor(Request $request, $applicationId)
    {
        $request->validate([
            'division_mentor_id' => 'required|exists:division_mentors,id',
            'transfer_reason' => 'nullable|string|max:1000',
        ]);

        $application = InternshipApplication::with(['user', 'divisionMentor', 'divisionAdmin'])
            ->findOrFail($applicationId);

        if ($application->status !== 'accepted') {
            return redirect()->route('admin.participants')
                ->with('error', 'Penggantian mentor hanya dapat dilakukan untuk peserta dengan status accepted.');
        }

        if ($application->division_mentor_id === null) {
            return redirect()->route('admin.participants')
                ->with('error', 'Peserta yang belum memiliki mentor tidak dapat menggunakan form penggantian mentor.');
        }

        $newMentor = DivisionMentor::findOrFail($request->division_mentor_id);
        if ((int) $newMentor->division_id !== (int) $application->division_admin_id) {
            return redirect()->route('admin.participants')
                ->with('error', 'Mentor pengganti wajib berasal dari divisi yang sama.');
        }

        if ((int) $application->division_mentor_id === (int) $newMentor->id) {
            return redirect()->route('admin.participants')
                ->with('error', 'Mentor yang dipilih sama dengan mentor saat ini.');
        }

        $oldMentor = $application->divisionMentor;
        $oldMentorId = $application->division_mentor_id;

        DB::transaction(function () use ($application, $newMentor, $oldMentor, $oldMentorId, $request) {
            $application->division_mentor_id = $newMentor->id;
            $application->save();

            DB::table('mentor_transfer_histories')->insert([
                'internship_application_id' => $application->id,
                'old_division_mentor_id' => $oldMentorId,
                'new_division_mentor_id' => $newMentor->id,
                'changed_by_admin_id' => Auth::id(),
                'reason' => $request->transfer_reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $participant = $application->user;
            $oldMentorUser = $oldMentor
                ? User::where('username', $oldMentor->nik_number)->where('role', 'pembimbing')->first()
                : null;
            $newMentorUser = User::where('username', $newMentor->nik_number)->where('role', 'pembimbing')->first();

            NotificationService::create(
                $participant,
                'mentor_changed',
                'Mentor magang Anda diperbarui',
                'Admin mengganti mentor Anda menjadi '.$newMentor->mentor_name.'.',
                'info',
                route('dashboard.program'),
                [
                    'application_id' => $application->id,
                    'old_mentor_id' => $oldMentorId,
                    'new_mentor_id' => $newMentor->id,
                ]
            );

            if ($oldMentorUser) {
                NotificationService::create(
                    $oldMentorUser,
                    'mentor_reassigned',
                    'Peserta dialihkan ke mentor lain',
                    'Peserta '.$participant->name.' telah dialihkan ke mentor lain oleh admin.',
                    'warning',
                    route('mentor.dashboard'),
                    ['application_id' => $application->id]
                );
            }

            if ($newMentorUser) {
                NotificationService::create(
                    $newMentorUser,
                    'mentor_reassigned',
                    'Peserta baru dialihkan ke Anda',
                    'Peserta '.$participant->name.' telah dialihkan ke Anda oleh admin.',
                    'success',
                    route('mentor.dashboard'),
                    ['application_id' => $application->id]
                );
            }
        });

        return redirect()->route('admin.participants')
            ->with('success', 'Mentor peserta berhasil diperbarui tanpa mengubah progres magang.');
    }

    /**
     * Record that the HQ email was initiated (mailto opened + docs downloaded by browser).
     */
    public function sendHeadquartersEmail(Request $request, $applicationId)
    {
        $application = InternshipApplication::findOrFail($applicationId);
        $application->headquarters_email_sent_at = now();
        $application->save();

        return response()->json([
            'success' => true,
            'sent_at' => $application->headquarters_email_sent_at->format('d M Y, H:i'),
        ]);
    }

    /**
     * Generate a pre-filled .eml draft file as fallback for clients that need manual sending.
     */
    public function downloadHqEmailDraft(Request $request, $applicationId)
    {
        $admin = Auth::user();

        if (empty($admin->headquarters_email)) {
            return redirect()->route('admin.participants')
                ->with('error', 'Email kantor pusat belum dikonfigurasi. Silakan isi di halaman Profil Admin.');
        }

        $application = InternshipApplication::with(['user', 'divisionAdmin', 'divisionMentor'])
            ->findOrFail($applicationId);

        $user    = $application->user;
        $to      = $admin->headquarters_email;
        $cc      = $user->email ?? '';
        $subject = 'Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel';

        $htmlBody = view('emails.headquarters_internship', [
            'participantName'    => $user->name,
            'participantNim'     => $user->nim ?? '-',
            'participantFaculty' => $user->major ?? '-',
            'participantUniv'    => $user->university ?? '-',
            'mentorName'         => $application->divisionMentor->mentor_name ?? '-',
            'mentorNik'          => $application->divisionMentor->nik_number ?? '-',
            'startDate'          => $application->start_date?->translatedFormat('d F Y') ?? '-',
            'endDate'            => $application->end_date?->translatedFormat('d F Y') ?? '-',
            'divisionName'       => $application->divisionAdmin->division_name ?? '-',
        ])->render();

        $boundary       = 'boundary_' . md5(uniqid());
        $date           = now()->format('D, d M Y H:i:s O');
        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        // ── MIME envelope ─────────────────────────────────────────────
        $eml  = "MIME-Version: 1.0\r\n";
        $eml .= "Date: {$date}\r\n";
        $eml .= "To: {$to}\r\n";
        if ($cc) {
            $eml .= "CC: {$cc}\r\n";
        }
        $eml .= "Subject: {$encodedSubject}\r\n";
        $eml .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
        $eml .= "\r\n";

        // ── HTML body part ────────────────────────────────────────────
        $eml .= "--{$boundary}\r\n";
        $eml .= "Content-Type: text/html; charset=UTF-8\r\n";
        $eml .= "Content-Transfer-Encoding: base64\r\n";
        $eml .= "\r\n";
        $eml .= chunk_split(base64_encode($htmlBody), 76, "\r\n");

        // ── Attachment parts ──────────────────────────────────────────
        $safeName = str_replace([' ', '/', '\\'], '_', $user->name ?? 'Peserta');
        $docs = [
            'surat_permohonan_path' => "Surat_Permohonan_{$safeName}.pdf",
            'cv_path'               => "Curriculum_Vitae_{$safeName}.pdf",
            'good_behavior_path'    => "Surat_Berperilaku_Baik_{$safeName}.pdf",
            'ktm_path'              => "KTP_KTM_{$safeName}.pdf",
        ];

        foreach ($docs as $field => $filename) {
            $path = $application->$field;
            if ($path && Storage::disk('public')->exists($path)) {
                $content = Storage::disk('public')->get($path);
                $eml .= "--{$boundary}\r\n";
                $eml .= "Content-Type: application/pdf\r\n";
                $eml .= "Content-Transfer-Encoding: base64\r\n";
                $eml .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n";
                $eml .= "\r\n";
                $eml .= chunk_split(base64_encode($content), 76, "\r\n");
            }
        }

        $eml .= "--{$boundary}--\r\n";

        // Record that the draft was prepared
        $application->headquarters_email_sent_at = now();
        $application->save();

        $downloadName = "Permohonan_PKL_{$safeName}.eml";

        return response($eml, 200, [
            'Content-Type'        => 'message/rfc822',
            'Content-Disposition' => "attachment; filename=\"{$downloadName}\"",
            'Content-Length'      => strlen($eml),
            'Cache-Control'       => 'no-store',
        ]);
    }
}
