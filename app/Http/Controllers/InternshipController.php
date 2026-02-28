<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    /**
     * Display the internship program page.
     */
    public function index()
    {
        $divisis = Divisi::with('subDirektorat.direktorat')->get();
        return view('internship.index', compact('divisis'));
    }

    /**
     * Show the registration form for a specific divisi.
     */
    public function apply($divisiId)
    {
        $user = Auth::user();
        $divisi = Divisi::with('subDirektorat.direktorat')->findOrFail($divisiId);
        
        // Check if user already has any applications (pending, accepted, finished, or rejected)
        $hasAnyApplication = $user->internshipApplications()->exists();
        
        if ($hasAnyApplication) {
            // User already has applications, redirect to reapply form
            return redirect()->route('dashboard')
                ->with('info', 'Anda sudah pernah mengajukan magang sebelumnya. Silakan gunakan form pengajuan ulang.');
        }
        
        return view('internship.apply', compact('divisi'));
    }

    /**
     * Handle the submission of internship application.
     */
    public function submitApply(Request $request, $divisiId)
    {
        $user = Auth::user();
        
        // Check if user already has any applications
        $hasAnyApplication = $user->internshipApplications()->exists();
        
        if ($hasAnyApplication) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda sudah pernah mengajukan magang sebelumnya. Silakan gunakan form pengajuan ulang.');
        }
        
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
            'cover_letter' => 'required|file|mimes:pdf|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $divisi = Divisi::findOrFail($request->divisi_id);

        // Upload surat pengantar
        $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');

        InternshipApplication::create([
            'user_id' => $user->id,
            'divisi_id' => $divisi->id,
            'status' => 'pending',
            'cover_letter_path' => $coverLetterPath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('dashboard.program')->with('success', 'Pengajuan magang berhasil dikirim!');
    }
}
