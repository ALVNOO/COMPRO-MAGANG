<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Division model - consolidated from DivisiAdmin.
 * This is the primary model for divisions going forward.
 *
 * Note: This model uses the same 'divisions' table as DivisiAdmin.
 * DivisiAdmin is kept for backward compatibility during migration.
 */
class Division extends Model
{
    use SoftDeletes;

    protected $table = 'divisions';

    protected $fillable = [
        'division_name',
        'mentor_name',
        'nik_number',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Get the internship applications for the division.
     */
    public function internshipApplications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'division_admin_id');
    }

    /**
     * Get the mentors for the division.
     */
    public function mentors(): HasMany
    {
        return $this->hasMany(DivisionMentor::class, 'division_id');
    }

    /**
     * Scope to get only active divisions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order then name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('division_name');
    }

    /**
     * Get the primary mentor (first mentor).
     */
    public function getPrimaryMentorAttribute()
    {
        return $this->mentors()->first();
    }

    /**
     * Get count of active participants.
     */
    public function getActiveParticipantsCountAttribute(): int
    {
        return $this->internshipApplications()
            ->where('status', 'accepted')
            ->count();
    }

    /**
     * Get count of finished participants.
     */
    public function getFinishedParticipantsCountAttribute(): int
    {
        return $this->internshipApplications()
            ->where('status', 'finished')
            ->count();
    }

    /**
     * Get total participants (active + finished).
     */
    public function getTotalParticipantsCountAttribute(): int
    {
        return $this->internshipApplications()
            ->whereIn('status', ['accepted', 'finished'])
            ->count();
    }
}
