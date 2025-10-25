<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldOfInterest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'is_active',
        'sort_order',
        'division_count',
        'position_count',
        'duration_months'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'division_count' => 'integer',
        'position_count' => 'integer',
        'duration_months' => 'integer'
    ];

    // Relationship with divisions (if needed)
    public function divisions()
    {
        return $this->hasMany(Divisi::class, 'field_of_interest_id');
    }

    // Scope for active fields
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered fields
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
