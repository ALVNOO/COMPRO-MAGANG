<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use App\Models\User;
use App\Services\Document\FileUploadService;
use Illuminate\Http\Request;

class FinalEvaluationController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Daftar peserta dan status dokumen evaluasi akhir.
     */
    public function index()
    {
        $participants = User::where('role', 'peserta')
            ->whereHas('internshipApplications', function ($query) {
                $query->whereIn('status', ['accepted', 'finished']);
            })
            ->with([
                'internshipApplications' => function ($query) {
                    $query->whereIn('status', ['accepted', 'finished'])
                        ->with(['divisionMentor', 'divisionAdmin'])
                        ->latest();
                },
            ])
            ->orderBy('name')
            ->get();

        return view('admin.final-evaluation', compact('participants'));
    }

    /**
     * Admin mengunggah salinan evaluasi akhir untuk pengajuan tertentu.
     */
    public function uploadForApplication(Request $request, int $applicationId)
    {
        $application = InternshipApplication::with('user')->findOrFail($applicationId);

        if (! in_array($application->status, ['accepted', 'finished'], true)) {
            return redirect()->route('admin.final-evaluation.index')
                ->with('error', 'Hanya pengajuan diterima/selesai yang dapat menerima dokumen evaluasi akhir.');
        }

        if (! empty($application->final_evaluation_participant_path)) {
            return redirect()->route('admin.final-evaluation.index')
                ->with('error', 'Peserta sudah mengunggah evaluasi akhir. Admin tidak dapat mengunggah dokumen untuk pengajuan ini.');
        }

        $request->validate([
            'final_evaluation_admin' => 'required|file|mimes:pdf|max:2048',
        ]);

        $path = $this->fileUploadService->uploadFinalEvaluation(
            $request->file('final_evaluation_admin'),
            'admin',
            $application->final_evaluation_admin_path
        );

        $application->final_evaluation_admin_path = $path;
        $application->final_evaluation_admin_uploaded_at = now();
        $application->save();

        return redirect()->route('admin.final-evaluation.index')
            ->with('success', 'Dokumen evaluasi akhir berhasil diunggah untuk peserta: '.$application->user->name);
    }

    public function download(int $applicationId)
    {
        $application = InternshipApplication::findOrFail($applicationId);
        $path = $application->finalEvaluationDocumentPath();

        if (! $path || ! $this->fileUploadService->exists($path)) {
            return redirect()->route('admin.final-evaluation.index')
                ->with('error', 'File evaluasi akhir tidak tersedia.');
        }

        $application->load('user');

        return $this->fileUploadService->download(
            $path,
            'Evaluasi_Akhir_'.str_replace(' ', '_', $application->user->name).'.pdf'
        );
    }
}
