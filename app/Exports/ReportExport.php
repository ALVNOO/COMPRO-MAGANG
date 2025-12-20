<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Peserta',
            'Universitas/Sekolah',
            'Jurusan',
            'NIM',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Divisi',
        ];
    }
} 