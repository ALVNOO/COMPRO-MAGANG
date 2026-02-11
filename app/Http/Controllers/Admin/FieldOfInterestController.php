<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FieldOfInterest;
use Illuminate\Http\Request;

class FieldOfInterestController extends Controller
{
    /**
     * Display list of fields of interest.
     */
    public function index()
    {
        $fields = FieldOfInterest::ordered()->get();

        return view('admin.fields', compact('fields'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.field-form');
    }

    /**
     * Store a new field of interest.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'division_count' => 'required|integer|min:0',
            'position_count' => 'required|integer|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        FieldOfInterest::create($request->all());

        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang peminatan berhasil ditambahkan');
    }

    /**
     * Show edit form.
     */
    public function edit(FieldOfInterest $field)
    {
        return view('admin.field-form', compact('field'));
    }

    /**
     * Update a field of interest.
     */
    public function update(Request $request, FieldOfInterest $field)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'division_count' => 'required|integer|min:0',
            'position_count' => 'required|integer|min:0',
            'duration_months' => 'nullable|integer|min:1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $field->update($request->all());

        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang peminatan berhasil diperbarui');
    }

    /**
     * Toggle field status.
     */
    public function toggle(FieldOfInterest $field)
    {
        $field->update(['is_active' => !$field->is_active]);

        $status = $field->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.fields.index')
            ->with('success', "Bidang peminatan {$field->name} berhasil {$status}");
    }

    /**
     * Delete a field of interest.
     */
    public function destroy(FieldOfInterest $field)
    {
        $field->delete();

        return redirect()->route('admin.fields.index')
            ->with('success', 'Bidang peminatan berhasil dihapus');
    }
}
