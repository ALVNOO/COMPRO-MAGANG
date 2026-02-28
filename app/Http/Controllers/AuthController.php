<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLogin()
    {
        return view("auth.login");
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        // Cek apakah input adalah NIK (6 digit angka) untuk mentor
        $isNIK = preg_match('/^[0-9]{6}$/', $request->username);

        if ($isNIK) {
            // Cari user dengan NIK sebagai username atau ktp_number
            $user = User::where(function ($query) use ($request) {
                $query
                    ->where("username", $request->username)
                    ->orWhere("ktp_number", $request->username);
            })
                ->where("role", "pembimbing")
                ->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();

                // Pembimbing: Cek 2FA
                // Jika belum setup, paksa ke setup
                if (!$user->hasTwoFactorEnabled()) {
                    return redirect()
                        ->route("2fa.setup")
                        ->with(
                            "info",
                            "Anda wajib mengaktifkan 2FA untuk pertama kali login",
                        );
                }

                // Check if device is trusted or need 2FA verification
                if (
                    $user->requires2faVerification($request) &&
                    !session("2fa_verified")
                ) {
                    return redirect()->route("2fa.verify");
                }

                // Sudah verified, ke dashboard mentor
                return $this->redirectToDashboard($user);
            }
        } else {
            // Login normal dengan username
            $credentials = $request->only("username", "password");

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $user = Auth::user();

                // Semua role: cek 2FA
                // Jika belum setup, paksa ke setup
                if (
                    $user->requiresTwoFactor() &&
                    !$user->hasTwoFactorEnabled()
                ) {
                    return redirect()
                        ->route("2fa.setup")
                        ->with(
                            "info",
                            "Anda wajib mengaktifkan 2FA untuk pertama kali login",
                        );
                }

                // Check if device is trusted or need 2FA verification
                if (
                    $user->requires2faVerification($request) &&
                    !session("2fa_verified")
                ) {
                    return redirect()->route("2fa.verify");
                }

                // Sudah verified atau tidak membutuhkan 2FA, ke dashboard masing-masing
                return $this->redirectToDashboard($user);
            }
        }

        return back()
            ->withErrors([
                "username" => "Username atau password salah.",
            ])
            ->withInput($request->only("username"));
    }

    /**
     * Display the registration form.
     */
    public function showRegister()
    {
        return view("auth.register");
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $request->validate(
            [
                "email" => "required|email|unique:users,email",
                "password" => "required|min:8|confirmed",
            ],
            [
                "email.required" => "Email wajib diisi.",
                "email.email" => "Format email tidak valid.",
                "email.unique" => "Email sudah terdaftar.",
                "password.required" => "Password wajib diisi.",
                "password.min" => "Password minimal 8 karakter.",
                "password.confirmed" => "Konfirmasi password tidak sesuai.",
            ],
        );

        // Create user with minimal data (email + password only)
        // Other data will be filled in pre-acceptance page
        $user = User::create([
            "username" => $request->email,
            "name" => null,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "nim" => null,
            "university" => null,
            "major" => null,
            "phone" => null,
            "ktp_number" => null,
            "ktm" => null,
            "role" => "peserta",
        ]);

        // Generate 2FA secret Otomatis untuk peserta
        $user->generateTwoFactorSecret();

        // Create internship application (divisi_id akan di-assign oleh admin setelah diterima)
        // start_date dan end_date di-set null agar user mengisi sendiri di pre-acceptance
        InternshipApplication::create([
            "user_id" => $user->id,
            "divisi_id" => null,
            "status" => "pending",
            "cover_letter_path" => null,
            "start_date" => null,
            "end_date" => null,
        ]);

        // Auto login
        Auth::login($user);

        // Redirect ke pre-acceptance untuk melengkapi data
        return redirect()
            ->route("dashboard.pre-acceptance")
            ->with(
                "success",
                "Registrasi berhasil! Silakan lengkapi data diri dan dokumen Anda.",
            );
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Clear trusted device if "logout from all devices" or similar action
        if ($request->has("clear_trusted_device")) {
            $user->clearTrustedDevice();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget("2fa_verified"); // Hapus verifikasi 2FA

        return redirect("/");
    }

    /**
     * Show 2FA setup form (Hanya untuk non-admin)
     */
    public function setup2fa()
    {
        $user = Auth::user();

        // Generate secret jika belum ada
        if (empty($user->two_factor_secret)) {
            $user->generateTwoFactorSecret();
        }

        // Generate QR Code
        $google2fa = new Google2FA();
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config("app.name"),
            $user->email,
            $user->two_factor_secret,
        );

        return view("auth.2fa-setup", compact("qrCodeUrl"));
    }

    /**
     * Verify and enable 2FA
     */
    public function enable2fa(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "code" => "required|numeric|digits:6",
        ]);

        $result = $user->verifyTwoFactorCode($request->code);

        if (is_array($result) && $result["success"]) {
            $user->markTwoFactorAsVerified();
            return redirect($this->getDashboardUrl($user))->with(
                "success",
                "2FA berhasil diaktifkan! Silakan login kembali.",
            );
        }

        // Handle different error types
        if (is_array($result)) {
            $errorMessage = match ($result["error"]) {
                "expired"
                    => "Kode verifikasi sudah kedaluwarsa. Kode 2FA hanya berlaku 30 detik.",
                "rate_limited" => isset($result["message"])
                    ? $result["message"]
                    : "Terlalu banyak percobaan gagal.",
                "invalid"
                    => "Kode verifikasi tidak valid. Pastikan kode yang dimasukkan benar.",
                default => "Terjadi kesalahan dalam verifikasi kode.",
            };
            return back()
                ->withErrors(["code" => $errorMessage])
                ->with("error_type", $result["error"]);
        }

        return back()->withErrors(["code" => "Kode tidak valid"]);
    }

    /**
     * Show 2FA verification form
     */
    public function show2faVerify(Request $request)
    {
        $user = Auth::user();

        // Jika role tidak wajib 2FA, langsung ke dashboard
        if (!$user->requiresTwoFactor()) {
            return redirect($this->getDashboardUrl($user));
        }

        // Check if device is trusted first
        if (!$user->requires2faVerification($request)) {
            session(["2fa_verified" => true]);
            return redirect()->intended($this->getDashboardUrl($user));
        }

        return view("auth.2fa-verify");
    }

    /**
     * Verify 2FA code during login
     */
    public function verify2fa(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "code" => "required|numeric|digits:6",
        ]);

        $result = $user->verifyTwoFactorCode($request->code);

        if (is_array($result) && $result["success"]) {
            session(["2fa_verified" => true]);

            // Trust device if "remember device" is checked
            if ($request->has("remember_device")) {
                $deviceFingerprint = User::generateDeviceFingerprint($request);
                $user->trustDevice($deviceFingerprint, 1); // Trust for 1 day
            }

            return redirect()->intended($this->getDashboardUrl($user));
        }

        // Handle different error types
        if (is_array($result)) {
            $errorMessage = match ($result["error"]) {
                "expired"
                    => "Kode verifikasi sudah kedaluwarsa. Kode 2FA hanya berlaku 30 detik.",
                "rate_limited" => isset($result["message"])
                    ? $result["message"]
                    : "Terlalu banyak percobaan gagal.",
                "invalid"
                    => "Kode verifikasi tidak valid. Pastikan kode yang dimasukkan benar.",
                default => "Terjadi kesalahan dalam verifikasi kode.",
            };
            return back()
                ->withErrors(["code" => $errorMessage])
                ->with("error_type", $result["error"]);
        }

        return back()->withErrors(["code" => "Kode tidak valid"]);
    }

    /**
     * Clear trusted device for current user
     */
    public function clearTrustedDevice(Request $request)
    {
        $user = Auth::user();

        if ($user->trusted_device_token) {
            $user->clearTrustedDevice();

            return redirect()
                ->back()
                ->with(
                    "success",
                    "Perangkat terpercaya telah dihapus. Anda akan diminta verifikasi 2FA pada login berikutnya.",
                );
        }

        return redirect()
            ->back()
            ->with("info", "Tidak ada perangkat terpercaya yang terdaftar.");
    }

    /**
     * Get dashboard URL based on role
     */
    private function getDashboardUrl($user)
    {
        return match ($user->role) {
            "admin" => "/admin/dashboard",
            "pembimbing" => "/mentor/dashboard",
            default => "/dashboard",
        };
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private function redirectToDashboard($user)
    {
        return redirect($this->getDashboardUrl($user));
    }

    /**
     * Show the form for changing password.
     */
    public function showChangePasswordForm()
    {
        return view("auth.change-password");
    }

    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        $request->validate(
            [
                "current_password" => "required",
                "new_password" =>
                    "required|min:6|confirmed|different:current_password",
            ],
            [
                "new_password.different" =>
                    "Password baru tidak boleh sama dengan password lama.",
            ],
        );

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with("error", "Password lama tidak sesuai.");
        }

        $user->update([
            "password" => Hash::make($request->new_password),
        ]);

        return back()->with("success", "Password berhasil diubah.");
    }
}
