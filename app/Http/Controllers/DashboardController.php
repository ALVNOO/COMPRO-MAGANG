<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Direktorat;
use App\Models\FieldOfInterest;
use App\Models\InternshipApplication;
use App\Models\User;
use App\Services\Document\FileUploadService;
use App\Support\ApplicationRevisionFields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display the participant dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Update otomatis status menjadi finished jika end_date sudah lewat
        $user->internshipApplications()
            ->where('status', 'accepted')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'finished']);

        if ($user->role === 'pembimbing') {
            return redirect('/mentor/dashboard');
        }

        // Eager load relationships untuk menghindari N+1 query
        $user->load([
            'assignments',
            'certificates',
            'attendances',
            'internshipApplications.divisi.subDirektorat.direktorat',
        ]);

        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat')
            ->whereIn('status', ['pending', 'accepted', 'finished'])
            ->latest()
            ->first();
        if (! $application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat')
                ->latest()
                ->first();
        }

        // Check if user has pending application yang belum lengkap
        // Redirect ke pre-acceptance hanya jika aplikasi pending dan belum lengkap (belum ada field_of_interest_id atau dokumen belum lengkap)
        if ($application && $application->status === 'pending') {
            $profileComplete = (bool) ($user->name && $user->nim && $user->university && $user->major && $user->phone && $user->ktp_number);
            $documentsComplete = (bool) ($application->ktm_path && $application->surat_permohonan_path && $application->cv_path && $application->good_behavior_path);
            $fieldOfInterestSelected = (bool) $application->field_of_interest_id;

            // Jika belum lengkap, redirect ke pre-acceptance
            if (! $profileComplete || ! $documentsComplete || ! $fieldOfInterestSelected) {
                return redirect()->route('dashboard.pre-acceptance');
            }

            // Jika sudah lengkap tapi masih pending, redirect ke status pengajuan (bukan dashboard)
            return redirect()->route('dashboard.status');
        }

        // Jika belum diterima (rejected, dll) atau tidak ada aplikasi, redirect ke status
        if (! $application || ! in_array($application->status, ['accepted', 'finished'])) {
            return redirect()->route('dashboard.status');
        }

        // Jika accepted tapi belum pernah "masuk dashboard", redirect ke status (tampilkan selamat + mentor info)
        // Menggunakan kolom database agar persisten setelah logout/login ulang
        if ($application->status === 'accepted' && ! $application->dashboard_entered_at) {
            return redirect()->route('dashboard.status');
        }

        // Hitung progress magang dan hari tersisa
        $progressMagang = 0;
        $hariTersisa = 0;
        $attendanceRate = 0;

        if ($application && $application->start_date && $application->end_date) {
            // Normalize dates to start of day to avoid time-component errors
            $startDate = \Carbon\Carbon::parse($application->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($application->end_date)->startOfDay();
            $today = now()->startOfDay();

            $totalDays = $startDate->diffInDays($endDate);
            $daysPassed = $startDate->diffInDays($today);

            if ($totalDays > 0) {
                $progressMagang = min(100, max(0, round(($daysPassed / $totalDays) * 100)));
            }

            $hariTersisa = max(0, (int) $today->diffInDays($endDate, false));

            // Jika sudah selesai
            if ($today->isAfter($endDate)) {
                $progressMagang = 100;
                $hariTersisa = 0;
            }

            // Persentase kehadiran = jumlah hari hadir (Hadir/Terlambat) / lama hari kerja magang
            $periodEnd = $today->isAfter($endDate) ? $endDate : $today;
            $totalWorkingDays = 0;
            $cursor = $startDate->copy();
            while ($cursor->lte($periodEnd)) {
                if ($cursor->dayOfWeek !== \Carbon\Carbon::SATURDAY && $cursor->dayOfWeek !== \Carbon\Carbon::SUNDAY) {
                    $totalWorkingDays++;
                }
                $cursor->addDay();
            }
            $attendanceCount = $user->attendances()
                ->whereDate('date', '>=', $startDate)
                ->whereDate('date', '<=', $periodEnd)
                ->whereIn('status', ['Hadir', 'Terlambat'])
                ->count();
            $attendanceRate = $totalWorkingDays > 0
                ? min(100, (int) round(($attendanceCount / $totalWorkingDays) * 100))
                : 0;
        }

        // Hanya tampilkan dashboard jika status accepted atau finished
        return view('dashboard.index', compact('user', 'application', 'progressMagang', 'hariTersisa', 'attendanceRate'));
    }

    /**
     * Display the application status.
     */
    public function status()
    {
        $user = Auth::user();
        // Update otomatis status menjadi finished jika end_date sudah lewat
        $user->internshipApplications()
            ->where('status', 'accepted')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'finished']);
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat', 'fieldOfInterest', 'divisionMentor.division', 'divisionAdmin')
            ->whereIn('status', ['pending', 'accepted', 'finished', 'revision', 'rejected', 'permanently_rejected'])
            ->latest()
            ->first();
        if (! $application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat', 'fieldOfInterest', 'divisionMentor.division', 'divisionAdmin')
                ->latest()
                ->first();
        }

        // Load mentor user data (phone, email) if application has a mentor assigned
        $mentorUser = null;
        if ($application && $application->divisionMentor) {
            $mentorUser = \App\Models\User::where('username', $application->divisionMentor->nik_number)
                ->where('role', 'pembimbing')
                ->first();
        }

        return view('dashboard.status', compact('user', 'application', 'mentorUser'));
    }

    /**
     * Display assignments and grades.
     */
    public function assignments()
    {
        $user = Auth::user();
        $assignments = $user->assignments()
            ->with('submissions')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil pengajuan terbaru yang statusnya pending/accepted/finished
        $application = $user->internshipApplications()
            ->with('divisi.subDirektorat.direktorat', 'divisionMentor')
            ->whereIn('status', ['pending', 'accepted', 'finished'])
            ->latest()
            ->first();
        if (! $application) {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat', 'divisionMentor')
                ->latest()
                ->first();
        }

        $mentorUser = null;
        if ($application && $application->divisionMentor) {
            $mentorUser = \App\Models\User::where('username', $application->divisionMentor->nik_number)
                ->where('role', 'pembimbing')
                ->first();
        }

        return view('dashboard.assignments', compact('user', 'assignments', 'application', 'mentorUser'));
    }

    /**
     * Submit assignment.
     */
    public function submitAssignment(Request $request, $id)
    {
        $request->validate([
            'submission_file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'online_text' => 'nullable|string',
        ]);

        $assignment = Assignment::findOrFail($id);
        if ($assignment->user_id !== Auth::id()) {
            abort(403);
        }

        // Hitung jumlah submission sebelum membuat submission baru
        $submissionCount = $assignment->submissions()->count();
        $isRevision = $submissionCount > 0;

        $data = [
            'submitted_at' => now(),
        ];
        if ($request->hasFile('submission_file')) {
            $filePath = $request->file('submission_file')->store('assignments', 'public');
            $data['submission_file_path'] = $filePath;
            // Simpan ke tabel assignment_submissions
            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'user_id' => Auth::id(),
                'file_path' => $filePath,
                'submitted_at' => now(),
                'keterangan' => 'Kumpul tugas'.($isRevision ? ' (Revisi)' : ''),
            ]);
        }
        if ($request->filled('online_text')) {
            $data['online_text'] = $request->online_text;
        }
        $assignment->update($data);
        // Jika assignment sebelumnya status revisi, reset is_revision setelah submit revisi
        if ((int) $assignment->is_revision === 1) {
            $assignment->is_revision = null;
            $assignment->save();
        }

        // Buat notifikasi untuk mentor bahwa tugas telah dikumpulkan
        try {
            // Reload assignment untuk mendapatkan data terbaru termasuk submissions
            $assignment->refresh();

            // Cari internship application untuk mendapatkan mentor
            $application = \App\Models\InternshipApplication::where('user_id', $assignment->user_id)
                ->where('status', 'accepted')
                ->with('divisionMentor')
                ->orderBy('start_date', 'desc')
                ->first();

            if ($application && $application->divisionMentor) {
                // Cari user mentor berdasarkan nik_number
                $mentorUser = \App\Models\User::where('username', $application->divisionMentor->nik_number)
                    ->where('role', 'pembimbing')
                    ->first();

                if ($mentorUser) {
                    $participantName = Auth::user()->name;
                    \App\Services\NotificationService::assignmentSubmitted(
                        $mentorUser,
                        $assignment,
                        $participantName
                    );
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Error creating notification for mentor: '.$e->getMessage());
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Display certificates and completion letter (surat selesai) after internship period.
     * Admin may upload files anytime; peserta can preview listing but download only after evaluasi akhir.
     */
    public function certificates()
    {
        $user = Auth::user();
        $certificates = collect();
        $completionLetterPath = null;
        $eligible = false;

        $latestApp = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        if ($latestApp) {
            if ($latestApp->end_date && now()->isAfter(\Carbon\Carbon::parse($latestApp->end_date))) {
                $eligible = true;
            } elseif ($latestApp->status === 'finished') {
                $eligible = true;
            }
        }

        $documentsUnlocked = $latestApp && $latestApp->hasFinalEvaluationDocument();

        if ($eligible && $latestApp) {
            $certificates = $user->certificates()->orderBy('created_at', 'desc')->get();
            $completionLetterPath = $latestApp->completion_letter_path;
        }

        $finalEvaluationRequired = $eligible && $latestApp && ! $documentsUnlocked;

        return view('dashboard.certificates', compact(
            'user',
            'certificates',
            'finalEvaluationRequired',
            'documentsUnlocked',
            'completionLetterPath',
            'eligible',
        ));
    }

    /**
     * Download certificate.
     */
    public function downloadCertificate($id)
    {
        $certificate = Certificate::findOrFail($id);

        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $latestApp = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        if (! $latestApp || ! $latestApp->hasFinalEvaluationDocument()) {
            return redirect()->route('dashboard.certificates')
                ->with('error', 'Unggah dokumen evaluasi akhir terlebih dahulu untuk mengunduh sertifikat (unggah sendiri atau melalui admin).');
        }

        if (Storage::disk('public')->exists($certificate->certificate_path)) {
            $filename = 'Sertifikat_'.str_replace(' ', '_', $user->name).'_'.$user->nim.'.pdf';

            return Storage::disk('public')->download($certificate->certificate_path, $filename);
        }

        abort(404);
    }

    /**
     * Download surat keterangan selesai magang (PDF) — sama syarat unduh seperti sertifikat (evaluasi akhir).
     */
    public function downloadCompletionLetter()
    {
        $user = Auth::user();
        $latestApp = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        if (! $latestApp || ! $latestApp->hasFinalEvaluationDocument()) {
            return redirect()->route('dashboard.certificates')
                ->with('error', 'Anda harus memiliki dokumen evaluasi akhir sebelum dapat mengunduh surat selesai magang.');
        }

        if (! $latestApp->completion_letter_path || ! Storage::disk('public')->exists($latestApp->completion_letter_path)) {
            abort(404);
        }

        $filename = 'Surat_Selesai_Magang_'.str_replace(' ', '_', $user->name).'_'.$user->nim.'.pdf';

        return Storage::disk('public')->download($latestApp->completion_letter_path, $filename);
    }

    /**
     * Form unggah evaluasi akhir (PDF).
     */
    public function finalEvaluation()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        return view('dashboard.final-evaluation', compact('user', 'application'));
    }

    /**
     * Simpan PDF evaluasi akhir peserta.
     */
    public function uploadFinalEvaluation(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        if (! $application) {
            return redirect()->route('dashboard.status')
                ->with('error', 'Tidak ada pengajuan magang yang aktif untuk mengunggah evaluasi akhir.');
        }

        if (! empty($application->final_evaluation_admin_path)) {
            return redirect()->route('dashboard.final-evaluation')
                ->with('error', 'Dokumen evaluasi akhir sudah diunggah oleh admin. Peserta tidak dapat mengunggah file dari akun ini.');
        }

        $request->validate([
            'final_evaluation' => 'required|file|mimes:pdf|max:2048',
        ]);

        /** @var FileUploadService $files */
        $files = app(FileUploadService::class);
        $path = $files->uploadFinalEvaluation(
            $request->file('final_evaluation'),
            'participant',
            $application->final_evaluation_participant_path
        );

        $application->final_evaluation_participant_path = $path;
        $application->final_evaluation_participant_uploaded_at = now();
        $application->save();

        return redirect()->route('dashboard.final-evaluation')
            ->with('success', 'Dokumen evaluasi akhir berhasil diunggah.');
    }

    /**
     * Unduh dokumen evaluasi akhir (sumber peserta atau admin).
     */
    public function downloadFinalEvaluationParticipant()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();

        $path = $application?->finalEvaluationDocumentPath();

        if (! $application || ! $path) {
            abort(404);
        }

        /** @var FileUploadService $files */
        $files = app(FileUploadService::class);
        if (! $files->exists($path)) {
            abort(404);
        }

        return $files->download(
            $path,
            'Evaluasi_Akhir_'.str_replace(' ', '_', $user->name).'.pdf'
        );
    }

    /**
     * Display internship program.
     */
    public function program()
    {
        $user = Auth::user();
        $direktorats = Direktorat::with(['subDirektorats.divisis'])->get();

        // Check if user has any accepted or finished applications
        $hasAccepted = (bool) $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->exists();

        // Check if user has any finished applications (completed internships)
        $hasFinished = (bool) $user->internshipApplications()
            ->where('status', 'finished')
            ->exists();

        $hasCertificate = (bool) $user->certificates()->exists();

        return view('dashboard.program', compact('user', 'direktorats', 'hasAccepted', 'hasFinished', 'hasCertificate'));
    }

    /**
     * Handle re-application: create new pending application and redirect to pre-acceptance.
     * Profile data stays filled (from user model), but field of interest, documents,
     * and dates need to be filled again.
     */
    public function reapply(Request $request)
    {
        $user = Auth::user();

        if (! $user->canReapplyForInternship()) {
            return redirect()->route('dashboard.status')
                ->with('error', 'Anda tidak dapat merevisi pengajuan saat ini.');
        }

        $existingPending = $user->internshipApplications()
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            return redirect()->route('dashboard.pre-acceptance');
        }

        $application = $user->internshipApplications()
            ->whereIn('status', ['revision', 'rejected'])
            ->latest()
            ->first();

        if (! $application) {
            return redirect()->route('dashboard.status')
                ->with('error', 'Tidak ada pengajuan yang perlu direvisi.');
        }

        $application->status = 'pending';
        $application->save();

        return redirect()->route('dashboard.pre-acceptance')
            ->with('info', 'Silakan perbaiki bagian yang diminta admin, lalu kirim ulang pengajuan Anda.');
    }

    public function acknowledgePersyaratanTambahan(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();
        if ($application) {
            $application->acknowledged_additional_requirements = true;
            $application->save();
        }

        return redirect()->route('dashboard.status');
    }

    public function submitAdditionalDocuments(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->latest()
            ->first();
        if (! $application) {
            return redirect()->route('dashboard.status')->with('error', 'Tidak ada pengajuan yang diterima.');
        }
        $request->validate([
            'cover_letter' => 'required|file|mimes:pdf|max:2048',
            'foto_nametag' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'screenshot_pospay' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_prangko_prisma' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_follow_ig_museum' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_follow_ig_posindonesia' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ss_subscribe_youtube' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // Upload files
        $application->cover_letter_path = $request->file('cover_letter')->store('cover_letters', 'public');
        $application->foto_nametag_path = $request->file('foto_nametag')->store('additional_docs', 'public');
        $application->screenshot_pospay_path = $request->file('screenshot_pospay')->store('additional_docs', 'public');
        $application->foto_prangko_prisma_path = $request->file('foto_prangko_prisma')->store('additional_docs', 'public');
        $application->ss_follow_ig_museum_path = $request->file('ss_follow_ig_museum')->store('additional_docs', 'public');
        $application->ss_follow_ig_posindonesia_path = $request->file('ss_follow_ig_posindonesia')->store('additional_docs', 'public');
        $application->ss_subscribe_youtube_path = $request->file('ss_subscribe_youtube')->store('additional_docs', 'public');
        $application->save();

        return redirect()->route('dashboard.status')->with('success', 'Dokumen tambahan berhasil dikumpulkan!');
    }

    public function downloadAcceptanceLetter()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()->whereIn('status', ['accepted', 'finished'])->latest()->first();
        if ($application && $application->acceptance_letter_path && Storage::disk('public')->exists($application->acceptance_letter_path)) {
            $filename = 'Surat Penerimaan_'.str_replace(' ', '_', $user->name).'_'.$user->nim.'.pdf';

            return Storage::disk('public')->download($application->acceptance_letter_path, $filename);
        }
        abort(404);
    }

    public function downloadAcceptanceLetterFlag(Request $request)
    {
        $user = auth()->user();
        $application = $user->internshipApplications()->where('status', 'accepted')->latest()->first();
        if ($application) {
            $application->acceptance_letter_downloaded_at = now();
            $application->save();
        }
        session(['download_acceptance_letter' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Display profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        $application = null;
        $divisionMentor = null;
        $mentorParticipants = collect();
        $adminStats = null;

        if ($user->role === 'peserta') {
            $application = $user->internshipApplications()
                ->with('divisi.subDirektorat.direktorat', 'fieldOfInterest', 'divisionAdmin', 'divisionMentor')
                ->whereIn('status', ['pending', 'accepted', 'finished'])
                ->latest()
                ->first();
        } elseif ($user->role === 'pembimbing') {
            $divisionMentor = \App\Models\DivisionMentor::where('nik_number', $user->username)
                ->with('division')
                ->first();
            if ($divisionMentor) {
                $mentorParticipants = InternshipApplication::where('division_mentor_id', $divisionMentor->id)
                    ->where('status', 'accepted')
                    ->with('user')
                    ->get();
            }
        } elseif ($user->role === 'admin') {
            $adminStats = [
                'total_participants' => InternshipApplication::where('status', 'accepted')->count(),
                'total_mentors' => \App\Models\DivisionMentor::count(),
                'total_divisions' => \App\Models\DivisiAdmin::where('is_active', true)->count(),
                'pending_applications' => InternshipApplication::where('status', 'pending')->count(),
            ];
        }

        return view('dashboard.profile', compact('user', 'application', 'divisionMentor', 'mentorParticipants', 'adminStats'));
    }

    /**
     * Update mentor biodata (phone/email) from profile page.
     */
    public function updateMentorBiodata(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'pembimbing') {
            abort(403);
        }

        $request->validateWithBag('biodata', [
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('dashboard.profile')->with('biodata_success', 'Biodata kontak berhasil diperbarui.');
    }

    /**
     * Display pre-acceptance page for pending applications.
     */
    public function preAcceptance()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $application) {
            return redirect()->route('dashboard');
        }

        $fields = FieldOfInterest::active()->ordered()->get();

        $revisionMode = $application->isRevisionMode();
        $revisionFields = $revisionMode ? ($application->revision_fields ?? []) : [];
        $revisionFieldLabels = ApplicationRevisionFields::labelsForFields($revisionFields);
        $revisionSections = ApplicationRevisionFields::sectionsForFields($revisionFields);

        return view('dashboard.pre-acceptance', compact(
            'user',
            'application',
            'fields',
            'revisionMode',
            'revisionFields',
            'revisionFieldLabels',
            'revisionSections'
        ));
    }

    /**
     * Mark acceptance as viewed and enter dashboard.
     */
    public function enterDashboard()
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->where('status', 'accepted')
            ->latest()
            ->first();

        if (! $application) {
            return redirect()->route('dashboard.status')
                ->with('error', 'Tidak ada pengajuan magang yang diterima.');
        }

        if ($application->dashboard_entered_at) {
            return redirect()->route('dashboard');
        }

        if (! $application->hasPreInternshipDocumentsCollected()) {
            return redirect()->route('dashboard.status')
                ->with('error', 'Unggah Surat Penerimaan, Surat Izin Masuk Lokasi, dan Pakta Integritas terlebih dahulu sebelum melanjutkan.');
        }

        $application->dashboard_entered_at = now();
        $application->save();

        return redirect()->route('dashboard');
    }

    /**
     * Upload Surat Penerimaan (peserta) pada halaman status.
     */
    public function uploadStatusAcceptanceLetter(Request $request)
    {
        return $this->uploadPreInternshipDocument(
            $request,
            'acceptance_letter',
            'uploadAcceptanceLetter',
            'acceptance_letter_path',
            'Surat Penerimaan berhasil diunggah.'
        );
    }

    /**
     * Upload Surat Izin Masuk Lokasi (peserta) pada halaman status.
     */
    public function uploadStatusLocationPermissionLetter(Request $request)
    {
        return $this->uploadPreInternshipDocument(
            $request,
            'location_permission_letter',
            'uploadLocationPermissionLetter',
            'location_permission_letter_path',
            'Surat Izin Masuk Lokasi berhasil diunggah.'
        );
    }

    /**
     * Upload Pakta Integritas (peserta) pada halaman status.
     */
    public function uploadStatusIntegrityPact(Request $request)
    {
        return $this->uploadPreInternshipDocument(
            $request,
            'integrity_pact',
            'uploadIntegrityPact',
            'integrity_pact_path',
            'Pakta Integritas berhasil diunggah.'
        );
    }

    /**
     * @param  'uploadAcceptanceLetter'|'uploadLocationPermissionLetter'|'uploadIntegrityPact'  $uploadMethod
     */
    private function uploadPreInternshipDocument(
        Request $request,
        string $inputName,
        string $uploadMethod,
        string $pathAttribute,
        string $successMessage
    ) {
        $application = Auth::user()
            ->internshipApplications()
            ->where('status', 'accepted')
            ->latest()
            ->first();

        if (! $application) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada pengajuan magang yang diterima.'], 422);
            }
            return redirect()->route('dashboard.status')
                ->with('error', 'Tidak ada pengajuan magang yang diterima.');
        }

        if ($application->dashboard_entered_at) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Dokumen tidak dapat diubah setelah Anda masuk ke dashboard magang.'], 422);
            }
            return redirect()->route('dashboard.status')
                ->with('error', 'Dokumen tidak dapat diubah setelah Anda masuk ke dashboard magang.');
        }

        $request->validate([
            $inputName => 'required|file|mimes:pdf|max:2048',
        ]);

        /** @var FileUploadService $files */
        $files = app(FileUploadService::class);
        $path = $files->{$uploadMethod}(
            $request->file($inputName),
            $application->{$pathAttribute}
        );

        $application->{$pathAttribute} = $path;
        $application->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'url'     => asset('storage/' . $path),
            ]);
        }

        return redirect()->route('dashboard.status')->with('success', $successMessage);
    }

    /**
     * Update user profile data.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $application = $user->internshipApplications()->where('status', 'pending')->latest()->first();
        if ($application?->isRevisionMode() && ! $application->isFieldEditable(ApplicationRevisionFields::PROFILE)) {
            return $this->revisionFieldDeniedResponse($request);
        }

        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'nim' => 'nullable|string|max:50|unique:users,nim,'.$user->id,
                'university' => 'nullable|string|max:255',
                'major' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'ktp_number' => 'nullable|regex:/^[0-9]{0,16}$/',
            ], [
                'ktp_number.regex' => 'NIK (No.KTP) harus terdiri dari maksimal 16 digit angka.',
                'nim.unique' => 'NIM yang dimasukkan sudah digunakan.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'nim' => $request->nim ?? $user->nim,
            'university' => $request->university ?? $user->university,
            'major' => $request->major ?? $user->major,
            'phone' => $request->phone ?? $user->phone,
            'ktp_number' => $request->ktp_number ?? $user->ktp_number,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data diri berhasil disimpan!',
            ]);
        }

        return back()->with('success', 'Data diri berhasil diperbarui!');
    }

    /**
     * Upload documents for pre-acceptance.
     */
    public function uploadDocuments(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        // Jika belum ada application, buat baru
        if (! $application) {
            $application = InternshipApplication::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        // Validasi untuk upload per file
        $fieldName = $request->input('field_name');
        $validationRules = [];

        if ($fieldName === 'ktm') {
            $validationRules = ['file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'];
        } elseif (in_array($fieldName, ['surat_permohonan', 'cv', 'good_behavior'])) {
            $validationRules = ['file' => 'required|file|mimes:pdf|max:2048'];
        } else {
            // Fallback untuk upload semua dokumen sekaligus
            $validationRules = [
                'ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'surat_permohonan' => 'nullable|file|mimes:pdf|max:2048',
                'cv' => 'nullable|file|mimes:pdf|max:2048',
                'good_behavior' => 'nullable|file|mimes:pdf|max:2048',
            ];
        }

        try {
            $request->validate($validationRules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        if ($fieldName && $application->isRevisionMode() && ! $application->isFieldEditable($fieldName)) {
            return $this->revisionFieldDeniedResponse($request);
        }

        // Upload file individual
        if ($fieldName && $request->hasFile('file')) {
            $file = $request->file('file');
            $path = '';

            $uploadDisk = config('filesystems.default_upload_disk', 'public');
            switch ($fieldName) {
                case 'ktm':
                    $path = $file->store('documents/ktm', $uploadDisk);
                    $application->ktm_path = $path;
                    break;
                case 'surat_permohonan':
                    $path = $file->store('documents/surat_permohonan', $uploadDisk);
                    $application->surat_permohonan_path = $path;
                    break;
                case 'cv':
                    $path = $file->store('documents/cv', $uploadDisk);
                    $application->cv_path = $path;
                    break;
                case 'good_behavior':
                    $path = $file->store('documents/good_behavior', $uploadDisk);
                    $application->good_behavior_path = $path;
                    break;
            }

            $application->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil diunggah!',
                    'filename' => basename($path),
                ]);
            }

            return back()->with('success', 'File berhasil diunggah!');
        }

        // Upload semua file sekaligus (fallback)
        $uploadDisk = config('filesystems.default_upload_disk', 'public');
        if ($request->hasFile('ktm')) {
            $application->ktm_path = $request->file('ktm')->store('documents/ktm', $uploadDisk);
        }
        if ($request->hasFile('surat_permohonan')) {
            $application->surat_permohonan_path = $request->file('surat_permohonan')->store('documents/surat_permohonan', $uploadDisk);
        }
        if ($request->hasFile('cv')) {
            $application->cv_path = $request->file('cv')->store('documents/cv', $uploadDisk);
        }
        if ($request->hasFile('good_behavior')) {
            $application->good_behavior_path = $request->file('good_behavior')->store('documents/good_behavior', $uploadDisk);
        }

        $application->save();

        return back()->with('success', 'Dokumen berhasil diunggah!');
    }

    /**
     * Update dates for pre-acceptance.
     */
    public function updateDates(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($application?->isRevisionMode() && ! $application->isFieldEditable(ApplicationRevisionFields::DATES)) {
            return $this->revisionFieldDeniedResponse($request);
        }

        // Jika belum ada application, buat baru
        if (! $application) {
            $application = InternshipApplication::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        try {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai magang wajib diisi.',
                'start_date.after_or_equal' => 'Tanggal mulai magang tidak boleh di masa lalu.',
                'end_date.required' => 'Tanggal selesai magang wajib diisi.',
                'end_date.after' => 'Tanggal selesai magang harus setelah tanggal mulai.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        $application->start_date = $request->start_date;
        $application->end_date = $request->end_date;
        $application->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Jadwal magang berhasil disimpan!',
            ]);
        }

        return back()->with('success', 'Waktu magang berhasil disimpan!');
    }

    /**
     * Update field of interest selection.
     */
    public function updateFieldOfInterest(Request $request)
    {
        $user = Auth::user();
        $application = $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $application) {
            $application = InternshipApplication::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }

        if ($application->isRevisionMode() && ! $application->isFieldEditable(ApplicationRevisionFields::FIELD_OF_INTEREST)) {
            return $this->revisionFieldDeniedResponse($request);
        }

        try {
            $request->validate([
                'field_of_interest_id' => 'required|exists:field_of_interests,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        $application->field_of_interest_id = $request->field_of_interest_id;
        $application->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Bidang minat berhasil disimpan!',
            ]);
        }

        return back()->with('success', 'Bidang minat berhasil disimpan!');
    }

    /**
     * Complete application: create application dengan status pending
     */
    public function completeApplication(Request $request)
    {
        $user = Auth::user();

        // Cek apakah sudah ada application pending
        $existingApplication = $user->internshipApplications()
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (! $existingApplication) {
            return back()->with('error', 'Pengajuan tidak ditemukan.');
        }

        if (! $existingApplication->isRevisionMode()) {
            $request->validate([
                'field_of_interest_id' => 'required|exists:field_of_interests,id',
            ], [
                'field_of_interest_id.required' => 'Silakan pilih bidang peminatan terlebih dahulu.',
            ]);

            $existingApplication->field_of_interest_id = $request->field_of_interest_id;
            $existingApplication->save();
        }

        $validationErrors = ApplicationRevisionFields::validationErrors($user, $existingApplication->fresh());
        if ($validationErrors !== []) {
            return back()->with('error', $validationErrors[0]);
        }

        $wasRevision = $existingApplication->isRevisionMode();
        $existingApplication->revision_fields = null;
        $existingApplication->status = 'pending';
        $existingApplication->save();

        $message = $wasRevision
            ? 'Revisi pengajuan Anda telah dikirim ulang. Silakan tunggu review admin.'
            : 'Pengajuan magang Anda telah dikirim! Silakan tunggu konfirmasi admin. Anda dapat melihat status di menu Status Pengajuan.';

        return redirect()->route('dashboard.status')->with('success', $message);
    }

    /**
     * Mark tour as completed for the user.
     */
    public function completeTour()
    {
        $user = Auth::user();
        $user->tour_completed = true;
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Upload profile picture (optional).
     */
    public function uploadProfilePicture(Request $request)
    {
        $user = Auth::user();

        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ], [
                'profile_picture.required' => 'File foto profil harus dipilih.',
                'profile_picture.image' => 'File harus berupa gambar.',
                'profile_picture.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
                'profile_picture.max' => 'Ukuran file maksimal 2MB.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->validator->errors()->first(),
                ], 422);
            }
            throw $e;
        }

        $uploadDisk = config('filesystems.default_upload_disk', 'public');

        // Hapus foto profil lama jika ada
        if ($user->profile_picture) {
            Storage::disk($uploadDisk)->delete($user->profile_picture);
        }

        // Simpan foto profil baru
        $path = $request->file('profile_picture')->store('profile-pictures', $uploadDisk);
        $user->profile_picture = $path;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil diunggah!',
                'path' => asset('storage/'.$path),
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diunggah!');
    }

    /**
     * Remove profile picture.
     */
    public function removeProfilePicture(Request $request)
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!',
            ]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus!');
    }

    /**
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function revisionFieldDeniedResponse(Request $request)
    {
        $message = 'Bagian ini tidak perlu direvisi.';

        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 403);
        }

        return back()->with('error', $message);
    }
}
