<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InternshipApplication;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else if (Auth::user()->role === 'pembimbing') {
                return redirect()->intended('/mentor/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    /**
     * Display the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'email' => 'required|email|unique:users,email',
            'ktp_number' => 'nullable|regex:/^[0-9]{16}$/',
        ], [
            'ktp_number.regex' => 'NIK (No.KTP) harus terdiri dari 16 digit angka.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.'
        ]);

        // Create user
        $user = User::create([
            'username' => $request->email, // Use email as username
            'name' => $request->name ?? null,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim ?? null,
            'university' => $request->university ?? null,
            'major' => $request->major ?? null,
            'phone' => $request->phone ?? null,
            'ktp_number' => $request->ktp_number ?? null,
            'ktm' => null, // Will be uploaded later
            'role' => 'peserta',
        ]);

        // Get a random divisi
        $divisi = Divisi::inRandomOrder()->first();

        // Create internship application
        InternshipApplication::create([
            'user_id' => $user->id,
            'divisi_id' => $divisi->id,
            'status' => 'pending',
            'cover_letter_path' => null,
            'start_date' => now()->addDays(7), // Default start date
            'end_date' => now()->addMonths(6), // Default end date
        ]);

        // Auto login after registration
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil! Pengajuan magang Anda telah dikirim.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show the form for changing password.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed|different:current_password',
        ], [
            'new_password.different' => 'Password baru tidak boleh sama dengan password lama.'
        ]);

        $user = \App\Models\User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
