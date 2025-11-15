<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Direktorat;
use App\Models\SubDirektorat;
use App\Models\Divisi;
use App\Models\InternshipApplication;
use App\Models\FieldOfInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Mail\AcceptanceLetterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalParticipants = User::where('role', 'peserta')
            ->whereHas('internshipApplications', function($q) {
                $q->where('status', 'accepted');
            })
            ->count();
        $totalApplications = InternshipApplication::count();
        $totalFinishedParticipants = InternshipApplication::where('status', 'finished')->count();
        $recentApplications = InternshipApplication::with(['user', 'divisi'])
            ->latest()
            ->take(10)
            ->get();
        $divisions = Divisi::withCount(['internshipApplications' => function($q) {
            $q->whereIn('status', ['accepted', 'finished']);
        }])->get();
        $rule = \App\Models\Rule::first();
        return view('admin.dashboard', compact('totalParticipants', 'totalApplications', 'totalFinishedParticipants', 'recentApplications', 'divisions', 'rule'));
    }

    public function applications()
    {
        $applications = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->latest()->get();
        return view('admin.applications', compact('applications'));
    }

    public function participants()
    {
        $participants = User::where('role', 'peserta')
            ->with(['internshipApplications.divisi', 'certificates', 'assignments'])
            ->get();
        return view('admin.participants', compact('participants'));
    }

    public function divisions()
    {
        $direktorats = Direktorat::with('subDirektorats.divisis')->get();
        return view('admin.divisions', compact('direktorats'));
    }

    public function mentors()
    {
        $mentors = User::where('role', 'pembimbing')
            ->whereNotNull('divisi_id')
            ->with([
                'divisi.subDirektorat.direktorat',
                'divisi.internshipApplications.user.certificates',
                'divisi.internshipApplications.user.assignments',
            ])
            ->whereHas('divisi')
            ->paginate(10); // ubah jadi paginasi 10 per halaman

        return view('admin.mentors', compact('mentors'));
    }

    public function mentorDetail($id)
    {
        $mentor = User::with([
            'divisi.subDirektorat.direktorat',
            'divisi.internshipApplications.user.certificates',
            'divisi.internshipApplications.user.assignments'
        ])->findOrFail($id);
        
        $participants = ($mentor->divisi)
            ? $mentor->divisi->internshipApplications()
                ->with('user')
                ->whereIn('status', ['accepted', 'finished'])
                ->orderBy('start_date', 'desc')
                ->get()
            : collect();
            
        return view('admin.mentor-detail', compact('mentor', 'participants'));
    }

    /**
     * Tampilkan halaman report peserta magang
     */
    public function report()
    {
        return view('admin.reports');
    }

    /**
     * Ambil data report peserta magang berdasarkan filter
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReportData(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $now = now();

        $query = 
            \App\Models\InternshipApplication::query()
            ->whereIn('status', ['accepted', 'finished']) // Perbaikan: tampilkan peserta sedang dan sudah selesai
            ->whereNotNull('start_date')
            ->with(['user.certificates', 'divisi.subDirektorat.direktorat']);

        // Filter periode
        if ($year && $month) {
            // Filter bulan spesifik dalam tahun
            $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
            $end = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
        } elseif ($year) {
            // Filter tahun saja (semua bulan dalam tahun tersebut)
            $start = \Carbon\Carbon::create($year, 1, 1)->startOfYear();
            $end = \Carbon\Carbon::create($year, 12, 31)->endOfYear();
        } else {
            // Default ke bulan saat ini
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
        }
        
        // Perbaikan: tampilkan peserta jika ada overlap antara periode magang dan periode yang dipilih
        $query->where(function($q) use ($start, $end) {
            $q->where(function($sub) use ($start, $end) {
                $sub->whereDate('start_date', '<=', $end->toDateString())
                     ->where(function($sub2) use ($start) {
                         $sub2->whereNull('end_date')
                               ->orWhereDate('end_date', '>=', $start->toDateString());
                     });
            });
        });

        $applications = $query->orderBy('start_date', 'asc')->get();

        // Data peserta detail
        $peserta = $applications->map(function($app, $i) {
            $user = $app->user;
            $certificate = $user && $user->certificates ? $user->certificates->sortByDesc('issued_at')->first() : null;
            return [
                'no' => $i+1,
                'nama' => $user->name ?? '-',
                'universitas' => $user->university ?? '-',
                'jurusan' => $user->major ?? '-',
                'nim' => $user->nim ?? '-',
                'tanggal_mulai' => $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-',
                'tanggal_berakhir' => $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-',
                'divisi' => $app->divisi->name ?? '-',
                'subdirektorat' => $app->divisi->subDirektorat->name ?? '-',
                'direktorat' => $app->divisi->subDirektorat->direktorat->name ?? '-',
                'predikat' => $certificate && $certificate->predikat ? $certificate->predikat : '-',
            ];
        })->toArray();

        return response()->json([
            'data' => $peserta
        ]);
    }

    /**
     * Ambil data periode bulanan untuk dropdown dinamis
     */
    public function getReportPeriods(Request $request)
    {
        $data = [];

        // Gunakan start_date untuk menentukan periode yang lebih akurat
        $minDate = \App\Models\InternshipApplication::whereNotNull('start_date')->min('start_date');
        $maxDate = \App\Models\InternshipApplication::whereNotNull('start_date')->max('start_date');
        
        // Jika tidak ada data, gunakan tahun saat ini sebagai default
        $currentYear = date('Y');
        $minYear = $minDate ? date('Y', strtotime($minDate)) : $currentYear;
        $maxYear = $maxDate ? date('Y', strtotime($maxDate)) : $currentYear;
        
        // Pastikan minimal ada tahun saat ini
        if ($minYear > $currentYear) {
            $minYear = $currentYear;
        }
        if ($maxYear < $currentYear) {
            $maxYear = $currentYear;
        }

        // Hanya return data bulanan
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        for ($y = $minYear; $y <= $maxYear; $y++) {
            foreach ($months as $num => $name) {
                $data[] = [ 'value' => sprintf('%02d', $num).'-'.$y, 'label' => $name.' '.$y ];
            }
        }
        
        return response()->json(['data' => $data]);
    }

    /**
     * Ambil data tahun untuk dropdown dinamis
     */
    public function getReportYears(Request $request)
    {
        $data = [];

        // Gunakan start_date untuk menentukan periode yang lebih akurat
        $minDate = \App\Models\InternshipApplication::whereNotNull('start_date')->min('start_date');
        $maxDate = \App\Models\InternshipApplication::whereNotNull('start_date')->max('start_date');
        
        // Jika tidak ada data, gunakan tahun saat ini sebagai default
        $currentYear = date('Y');
        $minYear = $minDate ? date('Y', strtotime($minDate)) : $currentYear;
        $maxYear = $maxDate ? date('Y', strtotime($maxDate)) : $currentYear;
        
        // Pastikan minimal ada tahun saat ini
        if ($minYear > $currentYear) {
            $minYear = $currentYear;
        }
        if ($maxYear < $currentYear) {
            $maxYear = $currentYear;
        }

        // Generate list tahun dari minYear sampai maxYear (dari yang terbaru ke yang terlama)
        for ($y = $maxYear; $y >= $minYear; $y--) {
            $data[] = [ 'value' => $y, 'label' => $y ];
        }
        
        return response()->json(['data' => $data]);
    }

    /**
     * Export report peserta magang ke PDF
     */
    public function exportReportPdf(Request $request)
    {
        // Buat request baru dengan parameter yang benar (hanya period, year, month)
        $exportRequest = new Request([
            'period' => 'bulanan',
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ]);
        
        $data = $this->getReportData($exportRequest)->getData(true)['data'];
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report_pdf', [
            'data' => $data,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('report_peserta_magang.pdf');
    }

    /**
     * Export report peserta magang ke Excel
     */
    public function exportReportExcel(Request $request)
    {
        // Buat request baru dengan parameter yang benar (hanya period, year, month)
        $exportRequest = new Request([
            'period' => 'bulanan',
            'year' => $request->input('year'),
            'month' => $request->input('month'),
        ]);
        
        $data = $this->getReportData($exportRequest)->getData(true)['data'];
        $export = new \App\Exports\ReportExport($data);
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'report_peserta_magang.xlsx');
    }

    public function editRules()
    {
        $rule = \App\Models\Rule::first();
        return view('admin.rules', compact('rule'));
    }

    public function updateRules(Request $request)
    {
        $request->validate(['content' => 'required']);
        $rule = \App\Models\Rule::first();
        if (!$rule) {
            $rule = \App\Models\Rule::create(['content' => $request->content]);
        } else {
            $rule->update(['content' => $request->content]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Peraturan berhasil diperbarui!');
    }

    // Direktorat CRUD Methods
    public function storeDirektorat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name'
        ]);

        Direktorat::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateDirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name,' . $id
        ]);

        $direktorat = Direktorat::findOrFail($id);
        $direktorat->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDirektorat($id)
    {
        $direktorat = Direktorat::findOrFail($id);
        
        // Check if direktorat has subdirektorats
        if ($direktorat->subDirektorats()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Direktorat "' . $direktorat->name . '" karena masih memiliki subdirektorat');
        }
        
        $direktoratName = $direktorat->name;
        $direktorat->delete();

        return redirect()->route('admin.divisions')->with('success', 'Direktorat "' . $direktoratName . '" berhasil dihapus');
    }

    // SubDirektorat CRUD Methods
    public function storeSubdirektorat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'direktorat_id' => 'required|exists:direktorats,id'
        ]);

        SubDirektorat::create([
            'name' => $request->name,
            'direktorat_id' => $request->direktorat_id
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateSubdirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'direktorat_id' => 'required|exists:direktorats,id'
        ]);

        $subdirektorat = SubDirektorat::findOrFail($id);
        
        // Only update the name, keep the original direktorat_id
        $subdirektorat->update([
            'name' => $request->name
            // direktorat_id is kept unchanged for security
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteSubdirektorat($id)
    {
        $subdirektorat = SubDirektorat::findOrFail($id);
        
        // Check if subdirektorat has divisis
        if ($subdirektorat->divisis()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Subdirektorat "' . $subdirektorat->name . '" karena masih memiliki divisi');
        }
        
        $subdirektoratName = $subdirektorat->name;
        $subdirektorat->delete();

        return redirect()->route('admin.divisions')->with('success', 'Subdirektorat "' . $subdirektoratName . '" berhasil dihapus');
    }

    // Divisi CRUD Methods
    public function storeDivisi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_direktorat_id' => 'required|exists:sub_direktorats,id',
            'vp' => 'required|string|max:255',
            'nippos' => 'required|string|max:255'
        ]);

        // Create the divisi
        $divisi = Divisi::create([
            'name' => $request->name,
            'sub_direktorat_id' => $request->sub_direktorat_id,
            'vp' => $request->vp,
            'nippos' => $request->nippos
        ]);

        // Create user pembimbing for this divisi
        $username = 'mentor_' . strtolower(str_replace(' ', '_', $request->name));
        $email = $username . '@posindonesia.co.id';
        
        // Check if username already exists, if so, add number
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '_' . $counter;
            $email = $username . '@posindonesia.co.id';
            $counter++;
        }

        User::create([
            'username' => $username,
            'name' => $request->vp,
            'email' => $email,
            'password' => bcrypt('mentor123'),
            'role' => 'pembimbing',
            'divisi_id' => $divisi->id
        ]);

        return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $request->name . '" berhasil ditambahkan dan user pembimbing telah dibuat dengan username: ' . $username);
    }

    public function updateDivisi(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_direktorat_id' => 'required|exists:sub_direktorats,id',
            'vp' => 'required|string|max:255',
            'nippos' => 'required|string|max:255'
        ]);

        $divisi = Divisi::findOrFail($id);
        $oldVpName = $divisi->vp;
        $oldDivisiName = $divisi->name;
        
        // Only update divisi-specific fields, keep sub_direktorat_id unchanged
        $divisi->update([
            'name' => $request->name,
            'vp' => $request->vp,
            'nippos' => $request->nippos
            // sub_direktorat_id is kept unchanged for security
        ]);

        // Get pembimbing user for this divisi
        $pembimbing = User::where('divisi_id', $divisi->id)
                         ->where('role', 'pembimbing')
                         ->first();
        
        if ($pembimbing) {
            $updateData = [];
            
            // Update VP name if changed
            if ($oldVpName !== $request->vp) {
                $updateData['name'] = $request->vp;
            }
            
            // Update username if divisi name changed
            if ($oldDivisiName !== $request->name) {
                $newUsername = 'mentor_' . strtolower(str_replace(' ', '_', $request->name));
                $newEmail = $newUsername . '@posindonesia.co.id';
                
                // Check if new username already exists, if so, add number
                $originalUsername = $newUsername;
                $counter = 1;
                while (User::where('username', $newUsername)->where('id', '!=', $pembimbing->id)->exists()) {
                    $newUsername = $originalUsername . '_' . $counter;
                    $newEmail = $newUsername . '@posindonesia.co.id';
                    $counter++;
                }
                
                $updateData['username'] = $newUsername;
                $updateData['email'] = $newEmail;
            }
            
            // Update pembimbing if there are changes
            if (!empty($updateData)) {
                $pembimbing->update($updateData);
            }
        }

        return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);
        
        // Check if divisi has internship applications
        if ($divisi->internshipApplications()->count() > 0) {
            return redirect()->route('admin.divisions')->with('error', 'Tidak dapat menghapus Divisi "' . $divisi->name . '" karena masih memiliki pengajuan magang');
        }
        
        // Delete pembimbing user for this divisi
        $pembimbing = User::where('divisi_id', $divisi->id)
                         ->where('role', 'pembimbing')
                         ->first();
        
        $divisiName = $divisi->name;
        $pembimbingName = $pembimbing ? $pembimbing->name : null;
        
        if ($pembimbing) {
            $pembimbing->delete();
        }
        
        $divisi->delete();

        if ($pembimbing) {
            return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $divisiName . '" dan user pembimbing "' . $pembimbingName . '" berhasil dihapus');
        } else {
            return redirect()->route('admin.divisions')->with('success', 'Divisi "' . $divisiName . '" berhasil dihapus');
        }
    }

    public function resetMentorPassword($id)
    {
        $mentor = User::where('id', $id)
                     ->where('role', 'pembimbing')
                     ->firstOrFail();
        
        $mentor->update([
            'password' => Hash::make('mentor123')
        ]);

        return redirect()->route('admin.mentors')->with('success', 'Password pembimbing ' . $mentor->name . ' berhasil direset menjadi "mentor123"');
    }

    public function sendAcceptanceLetter($id)
    {
        $application = InternshipApplication::with(['user', 'divisi.subDirektorat.direktorat'])->findOrFail($id);
        
        // Check if acceptance letter already exists
        if ($application->acceptance_letter_path) {
            // Get existing PDF
            $pdfPath = storage_path('app/public/' . $application->acceptance_letter_path);
            if (file_exists($pdfPath)) {
                $pdfContent = file_get_contents($pdfPath);
            } else {
                return redirect()->route('admin.applications')->with('error', 'File surat penerimaan tidak ditemukan.');
            }
        } else {
            // Generate new acceptance letter
            $data = $this->getAcceptanceLetterDataForAdmin($application);
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
            
            return redirect()->route('admin.applications')->with('success', 'Surat penerimaan magang berhasil dikirim ke email peserta: ' . $application->user->email);
        } catch (\Exception $e) {
            return redirect()->route('admin.applications')->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    private function getAcceptanceLetterDataForAdmin($application)
    {
        $user = $application->user;
        $divisi = $application->divisi;
        $subdirektorat = $divisi->subDirektorat;
        $direktorat = $subdirektorat->direktorat;
        
        // Format data with prefix to avoid phone number interpretation
        $qrText = "PESERTA MAGANG PT POS INDONESIA\n\nNama: " . $user->name . "\nID Mahasiswa: " . $user->nim . "\nUniversitas: " . $user->university . "\nDivisi: " . $divisi->name . "\n\nData ini valid dan dapat diverifikasi.";
        $qrSvg = QrCode::format('svg')->size(400)->margin(10)->backgroundColor(0, 0, 0, 0)->generate($qrText);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
        
        // Get default values - you may want to customize these
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
            'nama_pic' => $divisi->vp,
            'nippos' => $divisi->nippos,
            'start_date' => $application->start_date ? \Carbon\Carbon::parse($application->start_date)->locale('id')->isoFormat('D MMMM Y') : '-',
            'end_date' => $application->end_date ? \Carbon\Carbon::parse($application->end_date)->locale('id')->isoFormat('D MMMM Y') : '-',
            'ktm' => $user->ktm,
            'qr_base64' => $qrBase64,
        ];
    }

    // Field of Interest Management
    public function fields()
    {
        $fields = FieldOfInterest::ordered()->get();
        return view('admin.fields', compact('fields'));
    }

    public function createField()
    {
        return view('admin.field-form');
    }

    public function storeField(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'division_count' => 'required|integer|min:0',
            'position_count' => 'required|integer|min:0',
            'duration_months' => 'required|integer|min:1',
            'sort_order' => 'required|integer|min:0',
        ]);

        FieldOfInterest::create($request->all());

        return redirect()->route('admin.fields')->with('success', 'Bidang peminatan berhasil ditambahkan');
    }

    public function editField(FieldOfInterest $field)
    {
        return view('admin.field-form', compact('field'));
    }

    public function updateField(Request $request, FieldOfInterest $field)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'division_count' => 'required|integer|min:0',
            'position_count' => 'required|integer|min:0',
            'duration_months' => 'required|integer|min:1',
            'sort_order' => 'required|integer|min:0',
        ]);

        $field->update($request->all());

        return redirect()->route('admin.fields')->with('success', 'Bidang peminatan berhasil diperbarui');
    }

    public function toggleFieldStatus(FieldOfInterest $field)
    {
        $field->update(['is_active' => !$field->is_active]);
        
        $status = $field->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.fields')->with('success', "Bidang peminatan {$field->name} berhasil {$status}");
    }

    public function deleteField(FieldOfInterest $field)
    {
        $field->delete();
        return redirect()->route('admin.fields')->with('success', 'Bidang peminatan berhasil dihapus');
    }
} 