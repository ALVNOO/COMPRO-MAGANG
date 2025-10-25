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
            ->get()
            ->filter(function($mentor) {
                return $mentor->divisi !== null;
            });

        return view('admin.mentors', compact('mentors'));
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
        $groupBy = $request->input('group_by', 'direktorat');
        $period = $request->input('period', 'mingguan');
        $classification = $request->input('classification', 'all');
        $year = $request->input('year');
        $month = $request->input('month');
        $week = $request->input('week');
        $now = now();

        $query = 
            \App\Models\InternshipApplication::query()
            ->whereIn('status', ['accepted', 'finished']) // Perbaikan: tampilkan peserta sedang dan sudah selesai
            ->whereNotNull('start_date')
            ->with(['user.certificates', 'divisi.subDirektorat.direktorat']);

        // Filter periode
        if ($period === 'mingguan' && $week) {
            $start = \Carbon\Carbon::parse($week);
            $end = (clone $start)->addDays(6);
        } elseif ($period === 'bulanan' && $year && $month) {
            $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
            $end = \Carbon\Carbon::create($year, $month, 1)->endOfMonth();
        } elseif ($period === 'tahunan' && $year) {
            $start = \Carbon\Carbon::create($year, 1, 1)->startOfYear();
            $end = \Carbon\Carbon::create($year, 1, 1)->endOfYear();
        } else {
            if ($period === 'mingguan') {
                $start = $now->copy()->startOfWeek();
                $end = $now->copy()->endOfWeek();
            } elseif ($period === 'bulanan') {
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
            } else { // tahunan
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
            }
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

        // Filter klasifikasi
        if ($classification !== 'all') {
            if ($groupBy === 'direktorat') {
                $query->whereHas('divisi.subDirektorat.direktorat', function($q) use ($classification) {
                    $q->where('id', $classification);
                });
            } elseif ($groupBy === 'subdirektorat') {
                $query->whereHas('divisi.subDirektorat', function($q) use ($classification) {
                    $q->where('id', $classification);
                });
            } else { // divisi
                $query->whereHas('divisi', function($q) use ($classification) {
                    $q->where('id', $classification);
                });
            }
        }

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
     * Ambil data klasifikasi (direktorat, subdirektorat, divisi) untuk dropdown dinamis
     */
    public function getReportClassifications(Request $request)
    {
        $groupBy = $request->input('group_by', 'direktorat');
        if ($groupBy === 'direktorat') {
            $items = \App\Models\Direktorat::orderBy('name')->get(['id', 'name']);
        } elseif ($groupBy === 'subdirektorat') {
            $items = \App\Models\SubDirektorat::orderBy('name')->get(['id', 'name']);
        } else {
            $items = \App\Models\Divisi::orderBy('name')->get(['id', 'name']);
        }
        return response()->json([
            'data' => $items
        ]);
    }

    /**
     * Ambil data periode detail (tahun, bulan, minggu) untuk dropdown dinamis
     */
    public function getReportPeriods(Request $request)
    {
        $period = $request->input('period', 'tahunan');
        $year = $request->input('year');
        $data = [];

        $minDate = \App\Models\InternshipApplication::min('created_at');
        $maxDate = \App\Models\InternshipApplication::max('created_at');
        if (!$minDate || !$maxDate) {
            return response()->json(['data' => []]);
        }
        $minYear = date('Y', strtotime($minDate));
        $maxYear = date('Y', strtotime($maxDate));

        if ($period === 'tahunan') {
            for ($y = $minYear; $y <= $maxYear; $y++) {
                $data[] = [ 'value' => $y, 'label' => $y ];
            }
        } elseif ($period === 'bulanan') {
            for ($y = $minYear; $y <= $maxYear; $y++) {
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                foreach ($months as $num => $name) {
                    $data[] = [ 'value' => sprintf('%02d', $num).'-'.$y, 'label' => $name.' '.$y ];
                }
            }
        } elseif ($period === 'mingguan') {
            for ($y = $minYear; $y <= $maxYear; $y++) {
                $start = new \DateTime("first monday of January $y");
                $end = new \DateTime("last sunday of December $y");
                while ($start <= $end) {
                    $weekStart = clone $start;
                    $weekEnd = (clone $start)->modify('+6 days');
                    if ($weekEnd->format('Y') > $y) break;
                    $data[] = [
                        'value' => $weekStart->format('Y-m-d'),
                        'label' => $weekStart->format('d M Y') . ' - ' . $weekEnd->format('d M Y')
                    ];
                    $start->modify('+7 days');
                }
            }
        }
        return response()->json(['data' => $data, 'minYear' => $minYear, 'maxYear' => $maxYear]);
    }

    /**
     * Export report peserta magang ke PDF
     */
    public function exportReportPdf(Request $request)
    {
        $data = $this->getReportData($request)->getData(true)['data'];
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
        $data = $this->getReportData($request)->getData(true)['data'];
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