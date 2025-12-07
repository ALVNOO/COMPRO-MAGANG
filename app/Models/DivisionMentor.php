<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionMentor extends Model
{
    protected $fillable = [
        'division_id',
        'mentor_name',
        'nik_number'
    ];

    /**
     * Get the division that owns the mentor.
     */
    public function division()
    {
        return $this->belongsTo(DivisiAdmin::class, 'division_id');
    }

    /**
     * Get the internship applications assigned to this mentor.
     */
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class, 'division_mentor_id');
    }
}
