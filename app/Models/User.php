<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use App\Traits\HasActiveApplication;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasActiveApplication;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "username",
        "name",
        "email",
        "password",
        "nim",
        "university",
        "major",
        "phone",
        "ktp_number",
        "ktm",
        "profile_picture",
        "role",
        "divisi_id",
        "tour_completed",
        "two_factor_code_generated_at",
        "two_factor_last_used_at",
        "two_factor_attempts",
        "two_factor_attempts_reset_at",
        "trusted_device_token",
        "trusted_device_expires_at",
        "device_fingerprint",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "tour_completed" => "boolean",
            "two_factor_code_generated_at" => "datetime",
            "two_factor_last_used_at" => "datetime",
            "two_factor_attempts_reset_at" => "datetime",
            "trusted_device_expires_at" => "datetime",
        ];
    }

    /**
     * Get the internship applications for the user.
     */
    public function internshipApplications()
    {
        return $this->hasMany(\App\Models\InternshipApplication::class);
    }

    /**
     * Get the assignments for the user.
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the divisi for the mentor (pembimbing).
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Get the certificates for the user.
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the attendances for the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the logbooks for the user.
     */
    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    // Notification methods are provided by the Notifiable trait
    // No need to override them here

    // Cek apakah role wajib 2FA
    public function requiresTwoFactor()
    {
        // Semua role (termasuk admin) wajib 2FA
        return true;
    }

    // Cek apakah 2FA sudah aktif dan diverifikasi
    public function hasTwoFactorEnabled()
    {
        return !empty($this->two_factor_secret) &&
            !is_null($this->two_factor_verified_at);
    }

    // Generate secret (otomatis untuk non-admin)
    public function generateTwoFactorSecret()
    {
        $google2fa = new Google2FA();
        $this->two_factor_secret = $google2fa->generateSecretKey();
        $this->save();
    }

    // Verify code - simplified without timer
    public function verifyTwoFactorCode($code)
    {
        if (empty($this->two_factor_secret)) {
            return false;
        }

        // Check if user is rate limited
        if ($this->isTwoFactorRateLimited()) {
            $retryAfter = $this->getTwoFactorRetryAfter();
            return [
                "success" => false,
                "error" => "rate_limited",
                "retry_after" => $retryAfter,
                "message" =>
                    "Terlalu banyak percobaan gagal. Coba lagi dalam " .
                    ceil($retryAfter / 60) .
                    " menit.",
            ];
        }

        $google2fa = new Google2FA();

        // Use standard Google Authenticator window (90 seconds)
        if ($google2fa->verifyKey($this->two_factor_secret, $code, 3)) {
            $this->two_factor_last_used_at = now();
            $this->resetTwoFactorAttempts();
            $this->save();
            return ["success" => true];
        }

        // Code is invalid
        $this->incrementTwoFactorAttempts();
        return ["success" => false, "error" => "invalid"];
    }

    // Mark as verified
    public function markTwoFactorAsVerified()
    {
        $this->two_factor_verified_at = now();
        $this->save();
    }

    /**
     * Reset all Two-Factor Authentication data for this user.
     *
     * Digunakan saat akun dialihkan ke orang lain (misalnya pembimbing diganti),
     * sehingga orang baru bisa melakukan setup 2FA dari awal.
     */
    public function resetTwoFactor()
    {
        $this->two_factor_secret = null;
        $this->two_factor_verified_at = null;
        $this->two_factor_code_generated_at = null;
        $this->two_factor_last_used_at = null;
        $this->two_factor_attempts = 0;
        $this->two_factor_attempts_reset_at = null;
        $this->trusted_device_token = null;
        $this->trusted_device_expires_at = null;
        $this->device_fingerprint = null;

        $this->save();
    }

    // Increment failed attempts
    private function incrementTwoFactorAttempts()
    {
        $this->increment("two_factor_attempts");

        // Set reset time if this is the first attempt in current window
        if ($this->two_factor_attempts == 1) {
            $this->two_factor_attempts_reset_at = now()->addMinutes(5);
            $this->save();
        }
    }

    // Reset failed attempts
    private function resetTwoFactorAttempts()
    {
        $this->update([
            "two_factor_attempts" => 0,
            "two_factor_attempts_reset_at" => null,
        ]);
    }

    // Check if user is rate limited
    private function isTwoFactorRateLimited()
    {
        // Allow unlimited attempts if no rate limiting is set
        if (!$this->two_factor_attempts_reset_at) {
            return false;
        }

        // Reset attempts if time window has passed
        if (now()->greaterThan($this->two_factor_attempts_reset_at)) {
            $this->resetTwoFactorAttempts();
            return false;
        }

        // Rate limit after 5 failed attempts
        return $this->two_factor_attempts >= 5 &&
            $this->two_factor_attempts_reset_at &&
            now()->lessThan($this->two_factor_attempts_reset_at);
    }

    // Get seconds until rate limit resets
    private function getTwoFactorRetryAfter()
    {
        if (!$this->two_factor_attempts_reset_at) {
            return 0;
        }

        return max(
            0,
            $this->two_factor_attempts_reset_at->diffInSeconds(now()),
        );
    }

    // ===============================================
    // TRUSTED DEVICE METHODS
    // ===============================================

    /**
     * Check if current device is trusted
     */
    public function isTrustedDevice($deviceFingerprint)
    {
        if (!$this->trusted_device_token || !$this->trusted_device_expires_at) {
            return false;
        }

        // Check if device fingerprint matches
        if ($this->device_fingerprint !== $deviceFingerprint) {
            return false;
        }

        // Check if trust hasn't expired
        if (now()->greaterThan($this->trusted_device_expires_at)) {
            $this->clearTrustedDevice();
            return false;
        }

        return true;
    }

    /**
     * Trust current device for specified duration
     */
    public function trustDevice($deviceFingerprint, $days = 1)
    {
        $this->update([
            "trusted_device_token" => Str::random(60),
            "trusted_device_expires_at" => now()->addDays($days),
            "device_fingerprint" => $deviceFingerprint,
        ]);
    }

    /**
     * Clear trusted device
     */
    public function clearTrustedDevice()
    {
        $this->update([
            "trusted_device_token" => null,
            "trusted_device_expires_at" => null,
            "device_fingerprint" => null,
        ]);
    }

    /**
     * Generate device fingerprint from request
     */
    public static function generateDeviceFingerprint($request)
    {
        $components = [
            $request->ip(),
            $request->userAgent(),
            $request->header("Accept-Language"),
            $request->header("Accept-Encoding"),
        ];

        return hash("sha256", implode("|", array_filter($components)));
    }

    /**
     * Check if user requires 2FA (considering trusted device)
     */
    public function requires2faVerification($request)
    {
        if (!$this->requiresTwoFactor()) {
            return false;
        }

        // Check if device is trusted
        $deviceFingerprint = self::generateDeviceFingerprint($request);
        if ($this->isTrustedDevice($deviceFingerprint)) {
            return false;
        }

        return true;
    }
}
