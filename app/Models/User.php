<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    /**
     * Get the notifications for the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get unread notifications count.
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->unread()->count();
    }

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

    // Verify code with timeout and rate limiting
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

        // Check if this is a fresh session (just refreshed or first time)
        $isFreshSession = !$this->two_factor_last_used_at;

        if ($isFreshSession) {
            // For fresh sessions, use simple verification
            if ($google2fa->verifyKey($this->two_factor_secret, $code, 1)) {
                $this->updateTwoFactorTimestamp(time());
                $this->resetTwoFactorAttempts();
                return ["success" => true];
            }
        } else {
            // For existing sessions, prevent replay attacks
            $timestamp = $google2fa->verifyKeyNewer(
                $this->two_factor_secret,
                $code,
                $this->getLastTwoFactorTimestamp(),
                1,
            );

            if ($timestamp !== false) {
                $this->updateTwoFactorTimestamp($timestamp);
                $this->resetTwoFactorAttempts();
                return ["success" => true];
            }
        }

        // Code is invalid or expired
        $this->incrementTwoFactorAttempts();

        // Check if code exists but expired (using larger window)
        if ($google2fa->verifyKey($this->two_factor_secret, $code, 4)) {
            return ["success" => false, "error" => "expired"];
        }

        return ["success" => false, "error" => "invalid"];
    }

    // Mark as verified
    public function markTwoFactorAsVerified()
    {
        $this->two_factor_verified_at = now();
        $this->save();
    }

    // Get last used timestamp for 2FA
    private function getLastTwoFactorTimestamp()
    {
        return $this->two_factor_last_used_at
            ? $this->two_factor_last_used_at->timestamp
            : null;
    }

    // Update timestamp after successful verification
    private function updateTwoFactorTimestamp($timestamp)
    {
        $this->two_factor_last_used_at = now();
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

    // Get remaining time for current 2FA code (30 seconds window)
    public function getTwoFactorTimeRemaining()
    {
        if (!$this->two_factor_code_generated_at) {
            return 0;
        }

        $elapsed = now()->diffInSeconds($this->two_factor_code_generated_at);
        return max(0, 30 - $elapsed);
    }

    // Update code generation timestamp and reset attempts
    public function updateTwoFactorCodeGenerated()
    {
        $this->update([
            "two_factor_code_generated_at" => now(),
            "two_factor_last_used_at" => null, // Reset to allow fresh verification
            "two_factor_attempts" => 0,
            "two_factor_attempts_reset_at" => null,
        ]);
    }
}
