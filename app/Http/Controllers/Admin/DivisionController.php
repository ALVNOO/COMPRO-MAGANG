<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Division\DivisionService;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function __construct(
        protected DivisionService $divisionService
    ) {}

    /**
     * Display list of divisions.
     */
    public function index()
    {
        $divisions = $this->divisionService->getAllDivisions();
        $view_mode = 'index';
        $division = null;

        return view('admin.divisions-admin', compact('divisions', 'view_mode', 'division'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $divisions = $this->divisionService->getAllDivisions();
        $view_mode = 'create';
        $division = null;

        return view('admin.divisions-admin', compact('divisions', 'view_mode', 'division'));
    }

    /**
     * Store a new division.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
            'mentors' => 'required|array|min:1',
            'mentors.*.mentor_name' => 'required|string|max:255',
            'mentors.*.nik_number' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // Validate unique NIK
        $nikNumbers = collect($request->mentors)->pluck('nik_number')->toArray();
        $duplicates = $this->divisionService->validateNikUniqueness($nikNumbers);

        if (!empty($duplicates['internal'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['mentors' => 'NIK mentor tidak boleh duplikat.']);
        }

        if (!empty($duplicates['existing'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['mentors' => 'NIK ' . implode(', ', $duplicates['existing']) . ' sudah digunakan.']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['mentors'] = $request->mentors;

        $this->divisionService->createDivision($validated);

        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil ditambahkan!');
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $division = $this->divisionService->getDivision($id);
        $divisions = $this->divisionService->getAllDivisions();
        $view_mode = 'edit';

        return view('admin.divisions-admin', compact('divisions', 'view_mode', 'division'));
    }

    /**
     * Update a division.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'division_name' => 'required|string|max:255',
            'mentors' => 'required|array|min:1',
            'mentors.*.mentor_name' => 'required|string|max:255',
            'mentors.*.nik_number' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0'
        ]);

        // Validate unique NIK (excluding current division)
        $nikNumbers = collect($request->mentors)->pluck('nik_number')->toArray();
        $duplicates = $this->divisionService->validateNikUniqueness($nikNumbers, $id);

        if (!empty($duplicates['internal'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['mentors' => 'NIK mentor tidak boleh duplikat.']);
        }

        if (!empty($duplicates['existing'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['mentors' => 'NIK ' . implode(', ', $duplicates['existing']) . ' sudah digunakan di divisi lain.']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['mentors'] = $request->mentors;

        $this->divisionService->updateDivision($id, $validated);

        return redirect()->route('admin.divisions.index')
            ->with('success', 'Divisi berhasil diperbarui!');
    }

    /**
     * Toggle division status.
     */
    public function toggle($id)
    {
        $division = $this->divisionService->toggleStatus($id);

        $status = $division->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Divisi {$division->division_name} berhasil {$status}");
    }

    /**
     * Delete a division.
     */
    public function destroy($id)
    {
        try {
            $this->divisionService->deleteDivision($id);
            return redirect()->back()->with('success', 'Divisi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
