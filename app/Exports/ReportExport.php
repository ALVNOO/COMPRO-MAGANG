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
        return collect($this->data)->map(function (array $row) {
            return [
                $row['no'] ?? '',
                $row['nama'] ?? '',
                $row['universitas'] ?? '',
                $row['jurusan'] ?? '',
                $row['nim'] ?? '',
                $row['tanggal_mulai'] ?? '',
                $row['tanggal_berakhir'] ?? '',
                $row['divisi'] ?? '',
                $row['judul_proyek'] ?? '',
                $row['nilai'] ?? '',
            ];
        })->all();
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
            'Judul Proyek',
            'Nilai',
        ];
    }
}
