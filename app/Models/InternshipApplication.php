<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'divisi_id',
        'field_of_interest_id',
        'status',
        'cover_letter_path',
        'ktm_path',
        'surat_permohonan_path',
        'cv_path',
        'good_behavior_path',
        'notes',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the internship application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the divisi that owns the internship application.
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function fieldOfInterest()
    {
        return $this->belongsTo(FieldOfInterest::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
