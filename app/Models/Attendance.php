<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'status',
        'check_in_time',
        'photo_path',
        'absence_reason',
        'absence_proof_path',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
    ];

    /**
     * Get the user that owns the attendance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
