<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Show rules edit form.
     */
    public function edit()
    {
        $rule = Rule::first();

        return view('admin.rules', compact('rule'));
    }

    /**
     * Update rules.
     */
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $rule = Rule::first();

        if (!$rule) {
            Rule::create(['content' => $request->content]);
        } else {
            $rule->update(['content' => $request->content]);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Peraturan berhasil diperbarui!');
    }
}
