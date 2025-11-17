<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DivisiAdmin extends Model
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

    // Relasi jika ada
    public function internshipApplications()
    {
        return $this->hasMany(InternshipApplication::class);
    }
}