<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Division\DivisionService;

class MentorController extends Controller
{
    public function __construct(
        protected DivisionService $divisionService
    ) {}

    /**
     * Display list of mentors.
     */
    public function index()
    {
        $mentors = $this->divisionService->getMentorsWithUsersPaginated(10);

        return view('admin.mentors', compact('mentors'));
    }

    /**
     * Show mentor detail.
     */
    public function show($id)
    {
        $data = $this->divisionService->getMentorDetail($id);

        return view('admin.mentor-detail', [
            'mentor' => $data['mentor'],
            'participants' => $data['participants'],
        ]);
    }

    /**
     * Reset mentor password.
     */
    public function resetPassword($id)
    {
        $mentor = $this->divisionService->resetMentorPassword($id);

        return redirect()->route('admin.mentors.index')
            ->with('success', 'Password pembimbing ' . $mentor->name . ' berhasil direset menjadi "mentor123"');
    }
}
