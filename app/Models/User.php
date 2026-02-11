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
        'username',
        'name',
        'email',
        'password',
        'nim',
        'university',
        'major',
        'phone',
        'ktp_number',
        'ktm',
        'profile_picture',
        'role',
        'divisi_id',
        'tour_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tour_completed' => 'boolean',
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

    // Cek apakah role wajib 2FA
    public function requiresTwoFactor()
    {
        // Semua role (termasuk admin) wajib 2FA
        return true;
    }

    // Cek apakah 2FA sudah aktif dan diverifikasi
    public function hasTwoFactorEnabled()
    {
        return !empty($this->two_factor_secret) 
            && !is_null($this->two_factor_verified_at);
    }

    // Generate secret (otomatis untuk non-admin)
    public function generateTwoFactorSecret()
    {
        $google2fa = new Google2FA();
        $this->two_factor_secret = $google2fa->generateSecretKey();
        $this->save();
    }

    // Verify code
    public function verifyTwoFactorCode($code)
    {
        if (empty($this->two_factor_secret)) return false;
        
        $google2fa = new Google2FA();
        return $google2fa->verifyKey($this->two_factor_secret, $code);
    }

    // Mark as verified
    public function markTwoFactorAsVerified()
    {
        $this->two_factor_verified_at = now();
        $this->save();
    }
}
