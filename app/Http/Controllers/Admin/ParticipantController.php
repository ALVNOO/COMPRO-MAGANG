<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Certificate;
use App\Models\InternshipApplication;
use App\Services\Application\InternshipApplicationService;
use App\Services\Document\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function __construct(
        protected InternshipApplicationService $applicationService,
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Display list of participants.
     */
    public function index()
    {
        $participants = User::where('role', 'peserta')
            ->with([
                'internshipApplications' => function ($query) {
                    $query->whereIn('status', ['accepted', 'rejected', 'finished'])
                        ->with('divisionAdmin');
                },
                'certificates',
                'assignments'
            ])
            ->get();

        return view('admin.participants', compact('participants'));
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

        if (!$application->assessment_report_path || !$this->fileUploadService->exists($application->assessment_report_path)) {
            return redirect()->route('admin.participants')
                ->with('error', 'File laporan tidak ditemukan.');
        }

        return $this->fileUploadService->download(
            $application->assessment_report_path,
            'Laporan_Penilaian_' . $application->user->name . '.pdf'
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
     * Upload certificate for a user.
     */
    public function uploadCertificate(Request $request, $userId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:10240',
        ]);

        $user = User::findOrFail($userId);

        // Find or create certificate record
        $certificate = Certificate::where('user_id', $userId)->first();

        if ($certificate) {
            // Delete old file if exists
            $this->fileUploadService->delete($certificate->certificate_path);
        } else {
            // Create new certificate
            $certificate = new Certificate();
            $certificate->user_id = $userId;

            // Get internship application that is accepted
            $application = InternshipApplication::where('user_id', $userId)
                ->whereIn('status', ['accepted', 'finished'])
                ->latest()
                ->first();

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
}
