<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MentorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $pendingApplications = $divisi
            ? $divisi->internshipApplications()->where('status', 'pending')->count()
            : 0;
        $activeParticipants = $divisi
            ? $divisi->internshipApplications()
                ->where('status', 'accepted')
                ->where(function($q) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->count()
            : 0;
        $assignmentsToGrade = $divisi
            ? \App\Models\Assignment::whereHas('user.internshipApplications', function($q) use ($divisi) {
                $q->where('divisi_id', $divisi->id)->where('status', 'accepted');
            })->whereNotNull('submission_file_path')->whereNull('grade')->count()
            : 0;
        $pengajuanBaru = $divisi
            ? $divisi->internshipApplications()->where('status', 'pending')->count()
            : 0;
        $tugasBaruDiupload = $divisi
            ? \App\Models\Assignment::whereHas('user.internshipApplications', function($q) use ($divisi) {
                $q->where('divisi_id', $divisi->id)->where('status', 'accepted');
            })->whereNotNull('submission_file_path')->whereNull('grade')->count()
            : 0;
        return view('mentor.dashboard', [
            'pendingApplications' => $pendingApplications,
            'activeParticipants' => $activeParticipants,
            'assignmentsToGrade' => $assignmentsToGrade,
            'pengajuanBaru' => $pengajuanBaru,
            'tugasBaruDiupload' => $tugasBaruDiupload,
        ]);
    }

    public function pengajuan()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $applications = $divisi ? $divisi->internshipApplications()->with('user')->orderBy('created_at', 'desc')->get() : collect();
        return view('mentor.pengajuan', [
            'applications' => $applications
        ]);
    }

    public function penugasan()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $acceptedParticipants = $divisi
            ? \App\Models\InternshipApplication::with(['user.assignments' => function($q) { $q->orderBy('created_at', 'desc'); }])
                ->where('divisi_id', $divisi->id)
                ->where('status', 'accepted')
                ->get()
            : collect();
        return view('mentor.penugasan', [
            'participants' => $acceptedParticipants
        ]);
    }

    public function sertifikat()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $participants = $divisi
            ? \App\Models\InternshipApplication::with(['user.assignments', 'user.certificates'])
                ->where('divisi_id', $divisi->id)
                ->whereIn('status', ['accepted', 'finished'])
                ->get()
            : collect();
        
        // Update otomatis status menjadi finished jika end_date sudah lewat
        $participants->each(function($p) {
            if ($p->status === 'accepted' && $p->end_date && now()->isAfter($p->end_date)) {
                $p->status = 'finished';
                $p->save();
            }
        });
        
        // Tambahkan status selesai magang (hanya berdasarkan end_date)
        $participants = $participants->map(function($p) {
            $assignments = $p->user->assignments;
            $isEndDatePassed = $p->end_date && now()->isAfter($p->end_date);
            $allAssignmentsGraded = $assignments->count() > 0 && $assignments->every(fn($a) => $a->grade !== null);
            $noRevision = $assignments->count() > 0 && $assignments->every(fn($a) => $a->is_revision !== 1);
            // Syarat upload: semua tugas dinilai/feedback dan tidak ada tugas status revisi
            $p->can_upload_certificate = $allAssignmentsGraded && $noRevision;
            $p->is_completed = $isEndDatePassed;
            $p->all_assignments_graded = $allAssignmentsGraded;
            return $p;
        });
        
        return view('mentor.sertifikat', [
            'participants' => $participants
        ]);
    }

    public function profil()
    {
        $user = Auth::user();
        $divisi = $user->divisi;
        $subdirektorat = $divisi ? $divisi->subDirektorat : null;
        $direktorat = $subdirektorat ? $subdirektorat->direktorat : null;
        return view('mentor.profil', [
            'user' => $user,
            'divisi' => $divisi,
            'subdirektorat' => $subdirektorat,
            'direktorat' => $direktorat
        ]);
    }

    public function responPengajuan(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,postponed',
            'notes' => 'required_if:status,rejected,postponed',
        ], [
            'notes.required_if' => 'Alasan wajib diisi untuk penolakan atau penundaan.'
        ]);

        $application = \App\Models\InternshipApplication::findOrFail($id);
        // Pastikan hanya pembimbing divisi terkait yang bisa merespon
        if (Auth::user()->divisi_id !== $application->divisi_id) {
            abort(403);
        }
        $application->status = $request->status;
        $application->notes = $request->status === 'accepted' ? null : $request->notes;
        $application->save();

        // Set divisi_id user jika diterima
        if ($request->status === 'accepted') {
            $application->user->divisi_id = $application->divisi_id;
            $application->user->save();
        }

        return redirect()->route('mentor.pengajuan')->with('success', 'Respon pengajuan berhasil disimpan.');
    }

    public function tambahPenugasan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'assignment_type' => 'required|in:tugas_harian,tugas_proyek',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,zip|max:4096',
            'online_text' => 'nullable|string',
        ]);
        // Cek apakah peserta sudah mulai magang
        $application = \App\Models\InternshipApplication::where('user_id', $request->user_id)
            ->where('status', 'accepted')
            ->latest('start_date')
            ->first();
        if (!$application || ($application->start_date && \Carbon\Carbon::parse($application->start_date)->gt(now()))) {
            return redirect()->back()->with('error', 'Penugasan hanya dapat diberikan setelah peserta mulai periode magang.');
        }
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'assignment_type' => $request->assignment_type,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'online_text' => $request->online_text,
        ];
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('assignments', 'public');
        }
        \App\Models\Assignment::create($data);
        return redirect()->route('mentor.penugasan')->with('success', 'Penugasan berhasil ditambahkan.');
    }

    public function beriNilaiPenugasan(Request $request, $assignmentId)
    {
        $assignment = \App\Models\Assignment::findOrFail($assignmentId);
        $user = Auth::user();
        if (!$assignment->user || $assignment->user->divisi_id !== $user->divisi_id) {
            abort(403);
        }
        // Jika revisi diizinkan, hanya feedback yang bisa diinput
        if ($assignment->is_revision === 1) {
            $request->validate([
                'feedback' => 'required|string',
            ]);
            $assignment->feedback = $request->feedback;
            // Nilai tidak diubah
        } else {
            $request->validate([
                'grade' => 'required|numeric|min:0|max:100',
                'feedback' => 'nullable|string',
            ]);
            $assignment->grade = $request->grade;
            $assignment->feedback = $request->feedback;
        }
        $assignment->save();
        return redirect()->route('mentor.penugasan')
            ->with('success', 'Penilaian tugas berhasil disimpan.')
            ->with('feedback_saved_assignment_id', $assignment->id);
    }

    public function setRevisiPenugasan(Request $request, $assignmentId)
    {
        $request->validate([
            'is_revision' => 'required|in:0,1',
        ]);
        $assignment = \App\Models\Assignment::findOrFail($assignmentId);
        $user = Auth::user();
        if (!$assignment->user || $assignment->user->divisi_id !== $user->divisi_id) {
            abort(403);
        }
        $assignment->is_revision = $request->is_revision;
        $assignment->save();
        return redirect()->route('mentor.penugasan')->with('success', 'Status revisi tugas berhasil diperbarui.');
    }

    public function uploadSertifikat(Request $request, $userId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:4096',
        ]);
        $user = \App\Models\User::findOrFail($userId);
        // Simpan file
        $path = $request->file('certificate')->store('certificates', 'public');
        // Update/insert certificate
        $certificate = $user->certificates->first();
        if ($certificate) {
            $certificate->certificate_path = $path;
            $certificate->issued_at = now();
            $certificate->save();
        } else {
            $user->certificates()->create([
                'certificate_path' => $path,
                'issued_at' => now(),
            ]);
        }
        return redirect()->route('mentor.sertifikat')->with('success', 'Sertifikat berhasil diupload.');
    }

    public function showAcceptanceLetterForm($id)
    {
        $application = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->findOrFail($id);
        // Pastikan hanya mentor divisi terkait yang bisa akses
        if (Auth::user()->divisi_id !== $application->divisi_id) {
            abort(403);
        }
        // Hanya bisa jika sudah ada surat pengantar dan belum ada surat penerimaan
        if (!$application->cover_letter_path || $application->acceptance_letter_path) {
            return redirect()->route('mentor.pengajuan')->with('error', 'Surat Penerimaan hanya bisa dikirim jika Surat Pengantar sudah diupload dan belum pernah dikirim.');
        }
        return view('mentor.acceptance_letter_form', compact('application'));
    }

    public function previewAcceptanceLetter(Request $request, $id)
    {
        $application = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->findOrFail($id);
        if (Auth::user()->divisi_id !== $application->divisi_id) {
            abort(403);
        }
        $data = $this->getAcceptanceLetterData($request, $application);
        $pdf = Pdf::loadView('surat.surat_penerimaan', $data)->setPaper('A4', 'portrait');
        return $pdf->stream('Surat_Penerimaan.pdf');
    }

    public function sendAcceptanceLetter(Request $request, $id)
    {
        $application = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->findOrFail($id);
        if (Auth::user()->divisi_id !== $application->divisi_id) {
            abort(403);
        }
        if ($application->acceptance_letter_path) {
            return redirect()->route('mentor.pengajuan')->with('error', 'Surat Penerimaan sudah pernah dikirim.');
        }
        $data = $this->getAcceptanceLetterData($request, $application);
        $pdf = Pdf::loadView('surat.surat_penerimaan', $data)->setPaper('A4', 'portrait');
        $filename = 'surat_penerimaan_' . $application->id . '_' . time() . '.pdf';
        $path = 'acceptance_letters/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());
        $application->acceptance_letter_path = $path;
        $application->save();
        return redirect()->route('mentor.pengajuan')->with('success', 'Surat Penerimaan berhasil dikirim dan dapat diunduh oleh peserta.');
    }

    public function showCertificateForm($userId)
    {
        $user = \App\Models\User::with(['certificates', 'internshipApplications' => function($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }, 'divisi'])->findOrFail($userId);
        $application = $user->internshipApplications->sortByDesc('end_date')->first();
        if (!$application) abort(404);
        return view('mentor.certificate_form', compact('user', 'application'));
    }

    public function previewCertificate(Request $request, $userId)
    {
        $user = \App\Models\User::with(['certificates', 'internshipApplications' => function($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }, 'divisi'])->findOrFail($userId);
        $application = $user->internshipApplications->sortByDesc('end_date')->first();
        if (!$application) abort(404);
        $data = $this->getCertificateData($request, $user, $application);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.sertifikat', $data)->setPaper('A4', 'landscape');
        return $pdf->stream('Sertifikat.pdf');
    }

    public function sendCertificate(Request $request, $userId)
    {
        $user = \App\Models\User::with(['certificates', 'internshipApplications' => function($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }, 'divisi'])->findOrFail($userId);
        $application = $user->internshipApplications->sortByDesc('end_date')->first();
        if (!$application) abort(404);
        $data = $this->getCertificateData($request, $user, $application);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.sertifikat', $data)->setPaper('A4', 'landscape');
        $filename = 'sertifikat_' . $user->id . '_' . time() . '.pdf';
        $path = 'certificates/' . $filename;
        Storage::disk('public')->put($path, $pdf->output());
        $user->certificates()->create([
            'certificate_path' => $path,
            'issued_at' => now(),
            'nomor_sertifikat' => $request->input('nomor_sertifikat'),
            'predikat' => $request->input('predikat'),
        ]);
        return redirect()->route('mentor.sertifikat')->with('success', 'Sertifikat berhasil dikirim dan dapat diunduh oleh peserta.');
    }

    private function getAcceptanceLetterData(Request $request, $application)
    {
        $user = $application->user;
        $divisi = $application->divisi;
        $subdirektorat = $divisi->subDirektorat;
        $direktorat = $subdirektorat->direktorat;
        $qrData = json_encode([
            'type' => 'internship_data',
            'nama' => $user->name,
            'nim' => $user->nim,
            'universitas' => $user->university,
            'jurusan' => $user->major,
            'divisi' => $divisi->name,
            'tanggal_mulai' => $application->start_date,
            'tanggal_selesai' => $application->end_date,
            'ktm' => $user->ktm,
        ]);
        
        // Format data dengan prefix yang menghindari interpretasi sebagai nomor telepon
        $qrText = "PESERTA MAGANG PT POS INDONESIA\n\nNama: " . $user->name . "\nID Mahasiswa: " . $user->nim . "\nUniversitas: " . $user->university . "\nDivisi: " . $divisi->name . "\n\nData ini valid dan dapat diverifikasi.";
        $qrSvg = QrCode::format('svg')->size(400)->margin(10)->backgroundColor(0, 0, 0, 0)->generate($qrText);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
        return [
            'nomor_surat_penerimaan' => $request->input('nomor_surat_penerimaan'),
            'nomor_surat_pengantar' => $request->input('nomor_surat_pengantar'),
            'tanggal_surat_pengantar' => \Carbon\Carbon::parse($request->input('tanggal_surat_pengantar'))->locale('id')->isoFormat('D MMMM Y'),
            'tujuan_surat' => $request->input('tujuan_surat'),
            'tanggal_surat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'asal_surat' => $user->university,
            'divisi_mengeluarkan_surat' => $divisi->name,
            'nama_peserta' => $user->name,
            'nim' => $user->nim,
            'jurusan' => $user->major,
            'jabatan' => $divisi->vp ? 'VP ' . str_replace('Divisi ', '', $divisi->name) : '',
            'nama_pic' => $divisi->vp,
            'nippos' => $divisi->nippos,
            'start_date' => \Carbon\Carbon::parse($application->start_date)->locale('id')->isoFormat('D MMMM Y'),
            'end_date' => \Carbon\Carbon::parse($application->end_date)->locale('id')->isoFormat('D MMMM Y'),
            'ktm' => $user->ktm,
            'qr_base64' => $qrBase64,
        ];
    }

    private function getCertificateData(Request $request, $user, $application)
    {
        // Generate QR Code for certificate
        $qrData = json_encode([
            'type' => 'certificate_data',
            'nama' => $user->name,
            'nim' => $user->nim,
            'universitas' => $user->university,
            'jurusan' => $user->major,
            'divisi' => $user->divisi ? $user->divisi->name : '',
            'tanggal_mulai' => $application->start_date,
            'tanggal_selesai' => $application->end_date,
            'predikat' => $request->input('predikat'),
            'ktm' => $user->ktm,
        ]);
        
        // Format data dengan prefix yang menghindari interpretasi sebagai nomor telepon
        $qrText = "SERTIFIKAT MAGANG PT POS INDONESIA\n\nNama: " . $user->name . "\nID Mahasiswa: " . $user->nim . "\nUniversitas: " . $user->university . "\nDivisi: " . ($user->divisi ? $user->divisi->name : '') . "\nPredikat: " . $request->input('predikat') . "\n\nSertifikat ini valid dan dapat diverifikasi.";
        $qrSvg = QrCode::format('svg')->size(400)->margin(10)->backgroundColor(0, 0, 0, 0)->generate($qrText);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
        
        return [
            'nomor_sertifikat' => $request->input('nomor_sertifikat'),
            'predikat' => $request->input('predikat'),
            'nama' => $user->name,
            'universitas' => $user->university,
            'jurusan' => $user->major,
            'nim' => $user->nim,
            'start_date' => \Carbon\Carbon::parse($application->start_date)->locale('id')->isoFormat('D MMMM Y'),
            'end_date' => \Carbon\Carbon::parse($application->end_date)->locale('id')->isoFormat('D MMMM Y'),
            'nama_pic' => $user->divisi ? $user->divisi->vp : '',
            'nippos' => $user->divisi ? $user->divisi->nippos : '',
            'jabatan' => $user->divisi ? 'VP ' . str_replace('Divisi ', '', $user->divisi->name) : '',
            'tanggal_sertifikat' => now()->locale('id')->isoFormat('D MMMM Y'),
            'qr_base64' => $qrBase64,
        ];
    }
} 