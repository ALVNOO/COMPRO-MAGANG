<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Direktorat;
use App\Models\SubDirektorat;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Legacy controller for old Direktorat/SubDirektorat/Divisi structure.
 * This will be deprecated after full migration to DivisiAdmin.
 */
class LegacyDivisionController extends Controller
{
    /**
     * Display old divisions structure.
     */
    public function index()
    {
        $direktorats = Direktorat::with('subDirektorats.divisis')->get();

        return view('admin.divisions', compact('direktorats'));
    }

    // ==========================================
    // Direktorat CRUD
    // ==========================================

    public function storeDirektorat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name'
        ]);

        Direktorat::create(['name' => $request->name]);

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Direktorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateDirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:direktorats,name,' . $id
        ]);

        $direktorat = Direktorat::findOrFail($id);
        $direktorat->update(['name' => $request->name]);

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Direktorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDirektorat($id)
    {
        $direktorat = Direktorat::findOrFail($id);

        if ($direktorat->subDirektorats()->count() > 0) {
            return redirect()->route('admin.legacy-divisions.index')
                ->with('error', 'Tidak dapat menghapus Direktorat "' . $direktorat->name . '" karena masih memiliki subdirektorat');
        }

        $name = $direktorat->name;
        $direktorat->delete();

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Direktorat "' . $name . '" berhasil dihapus');
    }

    // ==========================================
    // SubDirektorat CRUD
    // ==========================================

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

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Subdirektorat "' . $request->name . '" berhasil ditambahkan');
    }

    public function updateSubdirektorat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'direktorat_id' => 'required|exists:direktorats,id'
        ]);

        $subdirektorat = SubDirektorat::findOrFail($id);
        $subdirektorat->update(['name' => $request->name]);

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Subdirektorat "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteSubdirektorat($id)
    {
        $subdirektorat = SubDirektorat::findOrFail($id);

        if ($subdirektorat->divisis()->count() > 0) {
            return redirect()->route('admin.legacy-divisions.index')
                ->with('error', 'Tidak dapat menghapus Subdirektorat "' . $subdirektorat->name . '" karena masih memiliki divisi');
        }

        $name = $subdirektorat->name;
        $subdirektorat->delete();

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Subdirektorat "' . $name . '" berhasil dihapus');
    }

    // ==========================================
    // Divisi CRUD
    // ==========================================

    public function storeDivisi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_direktorat_id' => 'required|exists:sub_direktorats,id',
            'vp' => 'required|string|max:255',
            'nippos' => 'required|string|max:255'
        ]);

        $divisi = Divisi::create([
            'name' => $request->name,
            'sub_direktorat_id' => $request->sub_direktorat_id,
            'vp' => $request->vp,
            'nippos' => $request->nippos
        ]);

        // Create mentor user
        $username = 'mentor_' . strtolower(str_replace(' ', '_', $request->name));
        $email = $username . '@posindonesia.co.id';

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

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Divisi "' . $request->name . '" berhasil ditambahkan dan user pembimbing telah dibuat dengan username: ' . $username);
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

        $divisi->update([
            'name' => $request->name,
            'vp' => $request->vp,
            'nippos' => $request->nippos
        ]);

        // Update mentor user
        $pembimbing = User::where('divisi_id', $divisi->id)
            ->where('role', 'pembimbing')
            ->first();

        if ($pembimbing) {
            $updateData = [];

            if ($oldVpName !== $request->vp) {
                $updateData['name'] = $request->vp;
            }

            if ($oldDivisiName !== $request->name) {
                $newUsername = 'mentor_' . strtolower(str_replace(' ', '_', $request->name));
                $newEmail = $newUsername . '@posindonesia.co.id';

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

            if (!empty($updateData)) {
                $pembimbing->update($updateData);
            }
        }

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Divisi "' . $request->name . '" berhasil diperbarui');
    }

    public function deleteDivisi($id)
    {
        $divisi = Divisi::findOrFail($id);

        if ($divisi->internshipApplications()->count() > 0) {
            return redirect()->route('admin.legacy-divisions.index')
                ->with('error', 'Tidak dapat menghapus Divisi "' . $divisi->name . '" karena masih memiliki pengajuan magang');
        }

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
            return redirect()->route('admin.legacy-divisions.index')
                ->with('success', 'Divisi "' . $divisiName . '" dan user pembimbing "' . $pembimbingName . '" berhasil dihapus');
        }

        return redirect()->route('admin.legacy-divisions.index')
            ->with('success', 'Divisi "' . $divisiName . '" berhasil dihapus');
    }
}
