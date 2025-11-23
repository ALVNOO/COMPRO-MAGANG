@extends('layouts.admin-dashboard')

@section('admin-content')
<style>
    .compact-table {
        font-size: 13px;
        table-layout: auto;
    }
    .compact-table input[type="file"] {
        font-size: 12px;
        padding: 3px;
        width: 100%;
        max-width: 120px;
    }
    .compact-table button {
        font-size: 12px;
        padding: 4px 8px;
        min-width: auto;
    }
    .compact-table th,
    .compact-table td {
        padding: 8px 4px !important;
        vertical-align: middle;
    }
    .compact-table .divisi-cell {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .compact-table .email-cell {
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .compact-table form {
        margin: 0;
    }
    .compact-table a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        min-height: 28px;
        padding: 4px 6px;
    }
</style>
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Daftar Peserta Magang</h2>
        <p class="text-sm text-[#000000]">Kelola data pengajuan magang yang sudah diproses (diterima / ditolak)</p>
    </div>
    
    <!-- Status Legend -->
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-xl p-6 mb-6">
        <h5 class="text-lg font-bold text-[#B91C1C] mb-4 flex items-center gap-2">
            <i class="fas fa-info-circle"></i> Keterangan Status
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center gap-2">
                <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                <span class="text-sm">Sudah mengumpulkan tugas / Sudah menerima sertifikat</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                <span class="text-sm">Belum mengumpulkan tugas / Belum menerima sertifikat</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-yellow-600"><i class="fas fa-edit"></i></span>
                <span class="text-sm">Sedang revisi tugas</span>
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-[#e3e3e0] rounded-lg shadow-2xl relative z-10 transform transition-all duration-300 hover:shadow-3xl">
        <div class="border-b border-[#e3e3e0] px-6 py-4 flex items-center gap-2 relative">
            <div class="absolute left-6 right-6 -bottom-1 h-1 bg-gradient-to-r from-[#B91C1C] via-[#B91C1C] to-[#B91C1C] rounded opacity-60"></div>
            <i class="fas fa-users text-[#B91C1C]"></i>
            <h5 class="text-lg font-bold mb-0 text-[#B91C1C]">Data Peserta Magang</h5>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left compact-table">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">No</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Nama</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">KTM</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Email</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">HP</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Divisi</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Start</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">End</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Surat Penerimaan</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Laporan</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Sertifikat</th>
                        <th class="px-2 py-2 font-bold text-[#B91C1C]">Surat Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @php $row = 1; @endphp
                    @foreach($participants as $peserta)
                        @foreach($peserta->internshipApplications as $app)
                            <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                                <td class="px-2 py-2">{{ $row++ }}</td>
                                <td class="px-2 py-2 font-medium">{{ $peserta->name }}</td>
                                <td class="px-2 py-2">
                                    @if($peserta->ktm)
                                        <a href="{{ asset('storage/' . $peserta->ktm) }}" target="_blank" class="inline-block px-2 py-1 rounded border border-[#B91C1C] text-[#B91C1C] hover:bg-[#B91C1C] hover:text-white transition">Lihat</a>
                                    @else
                                        <span class="text-[#706f6c]">-</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2 email-cell" title="{{ $peserta->email ?? '-' }}">{{ Str::limit($peserta->email ?? '-', 25) }}</td>
                                <td class="px-2 py-2">{{ $peserta->phone ?? '-' }}</td>
                                <td class="px-2 py-2 divisi-cell" title="{{ $app->divisi->name ?? '-' }}">{{ Str::limit($app->divisi->name ?? '-', 20) }}</td>
                                <td class="px-2 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                                <td class="px-2 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                                <td class="px-2 py-2">
                                    <div class="flex flex-col gap-1.5">
                                        @if($app->acceptance_letter_path)
                                            <a href="{{ asset('storage/' . $app->acceptance_letter_path) }}" target="_blank" class="inline-flex items-center justify-center px-2 py-1 rounded border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('admin.participants.upload-acceptance-letter', $app->id) }}" enctype="multipart/form-data" class="flex flex-col gap-1">
                                            @csrf
                                            <input type="file" name="acceptance_letter" accept=".pdf" class="text-xs py-1" required>
                                            <button type="submit" class="px-2 py-1 bg-[#B91C1C] text-white rounded hover:bg-[#9a1616] transition">
                                                <i class="fas fa-upload"></i> Upload
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-2 py-2">
                                    @if($app->assessment_report_path)
                                        <a href="{{ route('admin.participants.download-assessment-report', $app->id) }}" class="inline-flex items-center justify-center px-2 py-1 rounded border border-[#B91C1C] text-[#B91C1C] hover:bg-[#B91C1C] hover:text-white transition" title="Download Laporan PDF">
                                            <i class="fas fa-download"></i> Download PDF
                                        </a>
                                    @else
                                        <span class="text-[#706f6c] text-xs">Belum ada laporan</span>
                                    @endif
                                </td>
                                <td class="px-2 py-2">
                                    <div class="flex flex-col gap-1.5">
                                        @php
                                            $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                            $certificate = $hasCertificate ? $peserta->certificates->first() : null;
                                        @endphp
                                        @if($certificate && $certificate->certificate_path)
                                            <a href="{{ asset('storage/' . $certificate->certificate_path) }}" target="_blank" class="inline-flex items-center justify-center px-2 py-1 rounded border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('admin.participants.upload-certificate', $peserta->id) }}" enctype="multipart/form-data" class="flex flex-col gap-1">
                                            @csrf
                                            <input type="file" name="certificate" accept=".pdf" class="text-xs py-1" required>
                                            <button type="submit" class="px-2 py-1 bg-[#B91C1C] text-white rounded hover:bg-[#9a1616] transition">
                                                <i class="fas fa-upload"></i> Upload
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-2 py-2">
                                    <div class="flex flex-col gap-1.5">
                                        @if(!empty($app->completion_letter_path))
                                            <a href="{{ asset('storage/' . $app->completion_letter_path) }}" target="_blank" class="inline-flex items-center justify-center px-2 py-1 rounded border border-[#16a34a] text-[#16a34a] hover:bg-[#16a34a] hover:text-white transition">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('admin.participants.upload-completion-letter', $app->id) }}" enctype="multipart/form-data" class="flex flex-col gap-1">
                                            @csrf
                                            <input type="file" name="completion_letter" accept=".pdf" class="text-xs py-1" required>
                                            <button type="submit" class="px-2 py-1 bg-[#B91C1C] text-white rounded hover:bg-[#9a1616] transition">
                                                <i class="fas fa-upload"></i> Upload
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if($row === 1)
                        <tr><td colspan="12" class="text-center py-8 text-[#706f6c]">Tidak ada peserta magang yang sudah diproses.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 