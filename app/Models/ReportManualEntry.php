<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportManualEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'universitas',
        'jurusan',
        'nim',
        'tanggal_mulai',
        'tanggal_berakhir',
        'divisi',
        'judul_proyek',
        'nilai',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'nilai' => 'decimal:1',
    ];
}
