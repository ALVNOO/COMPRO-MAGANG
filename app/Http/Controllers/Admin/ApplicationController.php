<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DivisiAdmin;
use App\Models\InternshipApplication;
use App\Mail\AcceptanceLetterMail;
use App\Services\Application\InternshipApplicationService;
use App\Services\Document\FileUploadService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ApplicationController extends Controller
{
    public function __construct(
        protected InternshipApplicationService $applicationService,
        protected FileUploadService $fileUploadService
    ) {}

    /**
     * Display pending applications.
     */
    public function index()
    {
        $applications = $this->applicationService->getPendingApplications();
        $divisions = DivisiAdmin::with('mentors')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('division_name')
            ->get();

        return view('admin.applications', compact('applications', 'divisions'));
    }

    /**
     * Approve an application.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisions,id',
            'division_mentor_id' => 'nullable|exists:division_mentors,id',
        ]);

        $this->applicationService->approveApplication(
            $id,
            $request->divisi_id,
            $request->division_mentor_id
        );

        return redirect()->route('admin.applications')
            ->with('success', 'Pengajuan magang berhasil diterima.');
    }

    /**
     * Reject an application.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        $this->applicationService->rejectApplication($id, $request->notes);

        return redirect()->route('admin.applications')
            ->with('success', 'Pengajuan magang berhasil ditolak.');
    }

    /**
     * Send acceptance letter via email.
     */
    public function sendAcceptanceLetter($id)
    {
        $application = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])
            ->findOrFail($id);

        // Check if acceptance letter already exists
        if ($application->acceptance_letter_path) {
            $pdfPath = storage_path('app/public/' . $application->acceptance_letter_path);
            if (file_exists($pdfPath)) {
                $pdfContent = file_get_contents($pdfPath);
            } else {
                return redirect()->route('admin.applications')
                    ->with('error', 'File surat penerimaan tidak ditemukan.');
            }
        } else {
            // Generate new acceptance letter
            $data = $this->getAcceptanceLetterData($application);
            $pdf = Pdf::loadView('surat.surat_penerimaan', $data)->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            // Save the PDF
            $filename = 'surat_penerimaan_' . $application->id . '_' . time() . '.pdf';
            $path = 'acceptance_letters/' . $filename;
            Storage::disk('public')->put($path, $pdfContent);

            // Update application
            $application->acceptance_letter_path = $path;
            $application->save();
        }

        // Send email
        try {
            Mail::to($application->user->email)->send(new AcceptanceLetterMail($application, $pdfContent));

            return redirect()->route('admin.applications')
                ->with('success', 'Surat penerimaan magang berhasil dikirim ke email peserta: ' . $application->user->email);
        } catch (\Exception $e) {
            return redirect()->route('admin.applications')
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    /**
     * Get data for acceptance letter PDF.
     */
    private function getAcceptanceLetterData($application): array
    {
        $user = $application->user;
        $divisi = $application->divisi;

        // Get division admin data if available
        $divisionAdmin = null;
        if ($application->divisi_id) {
            $divisionAdmin = DivisiAdmin::where('division_name', 'like', '%' . $divisi->name . '%')->first();
        }

        // Generate QR code
        $qrText = "PESERTA MAGANG PT POS INDONESIA\n\nNama: " . $user->name .
            "\nID Mahasiswa: " . $user->nim .
            "\nUniversitas: " . $user->university .
            "\nDivisi: " . $divisi->name .
            "\n\nData ini valid dan dapat diverifikasi.";

        $qrSvg = QrCode::format('svg')
            ->size(400)
            ->margin(10)
            ->backgroundColor(0, 0, 0, 0)
            ->generate($qrText);

        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $nomorSurat = 'NOMOR-' . str_pad($application->id, 6, '0', STR_PAD_LEFT) . '/POS/V/' . date('Y');

        return [
            'nomor_surat_penerimaan' => $nomorSurat,
            'nomor_surat_pengantar' => $user->university ?? 'N/A',
            'tanggal_surat_pengantar' => now()->locale('id')->isoFormat('D MMMM Y'),
            'tujuan_surat' => $user->university ?? 'Universitas',
            'tanggal_surat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'asal_surat' => $user->university,
            'divisi_mengeluarkan_surat' => $divisi->name,
            'nama_peserta' => $user->name,
            'nim' => $user->nim,
            'jurusan' => $user->major,
            'jabatan' => $divisi->vp ? 'VP ' . str_replace('Divisi ', '', $divisi->name) : '',
            'nama_pic' => $divisi->vp ?? ($divisionAdmin ? $divisionAdmin->mentor_name : ''),
            'nippos' => $divisi->nippos ?? '',
            'start_date' => $application->start_date
                ? \Carbon\Carbon::parse($application->start_date)->locale('id')->isoFormat('D MMMM Y')
                : '-',
            'end_date' => $application->end_date
                ? \Carbon\Carbon::parse($application->end_date)->locale('id')->isoFormat('D MMMM Y')
                : '-',
            'ktm' => $user->ktm,
            'qr_base64' => $qrBase64,
        ];
    }
}
