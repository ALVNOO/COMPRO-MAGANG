@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="space-y-8">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-1 text-[#000000] border-b-4 border-[#B91C1C] inline-block pb-1 pr-6">Daftar Peserta Magang</h2>
        <p class="text-sm text-[#000000]">Kelola data peserta magang yang telah diterima</p>
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
            <table class="min-w-full text-sm text-left">
                <thead class="bg-[#FFF2F2] border-b border-[#e3e3e0]">
                    <tr>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Nama Peserta</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">KTM</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Email</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">No HP</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Divisi</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Judul Tugas</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Status Tugas</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Sertifikat</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Persyaratan Tambahan</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Start Date</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">End Date</th>
                        <th class="px-4 py-2 font-bold text-[#B91C1C]">Surat Penerimaan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $row = 1; @endphp
                    @foreach($participants as $peserta)
                        @foreach($peserta->internshipApplications->where('status', 'accepted') as $app)
                            <tr class="even:bg-[#FDFDFC] border-b border-[#e3e3e0] hover:bg-[#FFF2F2] transition-colors">
                                <td class="px-4 py-2">{{ $row++ }}</td>
                                <td class="px-4 py-2 font-medium">{{ $peserta->name }}</td>
                                <td class="px-4 py-2">
                                    @if($peserta->ktm)
                                        <a href="{{ asset('storage/' . $peserta->ktm) }}" target="_blank" class="inline-block px-3 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-sm">Lihat KTM</a>
                                    @else
                                        <span class="text-[#706f6c]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $peserta->email ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $peserta->phone ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $app->divisi->name ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if($peserta->assignments && $peserta->assignments->count() > 0)
                                        @foreach($peserta->assignments as $i => $tugas)
                                            <div class="pb-2">
                                                {{ $tugas->title ?? '-' }}
                                            </div>
                                            @if($i < $peserta->assignments->count() - 1)
                                                <hr class="my-1">
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-[#706f6c]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if($peserta->assignments && $peserta->assignments->count() > 0)
                                        @foreach($peserta->assignments as $i => $tugas)
                                            <div class="pb-2">
                                                @if($tugas->is_revision == 1)
                                                    <span class="text-yellow-600" title="Sedang Revisi"><i class="fas fa-edit"></i></span>
                                                @elseif($tugas->submitted_at)
                                                    <span class="text-green-600" title="Sudah Mengumpulkan"><i class="fas fa-check-circle"></i></span>
                                                @else
                                                    <span class="text-red-600" title="Belum Mengumpulkan"><i class="fas fa-times-circle"></i></span>
                                                @endif
                                            </div>
                                            @if($i < $peserta->assignments->count() - 1)
                                                <hr class="my-1">
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-[#706f6c]">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                    @endphp
                                    @if($hasCertificate)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <ul class="mb-0 space-y-1" style="list-style: none; padding-left: 0;">
                                        @if($app->cover_letter_path)
                                            <li><a href="{{ asset('storage/' . $app->cover_letter_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Surat Pengantar Kampus</a></li>
                                        @endif
                                        @if($app->foto_nametag_path)
                                            <li><a href="{{ asset('storage/' . $app->foto_nametag_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Foto Name Tag</a></li>
                                        @endif
                                        @if($app->screenshot_pospay_path)
                                            <li><a href="{{ asset('storage/' . $app->screenshot_pospay_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Screenshot aplikasi PosPay</a></li>
                                        @endif
                                        @if($app->foto_prangko_prisma_path)
                                            <li><a href="{{ asset('storage/' . $app->foto_prangko_prisma_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Foto Prangko Prisma</a></li>
                                        @endif
                                        @if($app->ss_follow_ig_museum_path)
                                            <li><a href="{{ asset('storage/' . $app->ss_follow_ig_museum_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Screenshot follow IG museumposindonesia</a></li>
                                        @endif
                                        @if($app->ss_follow_ig_posindonesia_path)
                                            <li><a href="{{ asset('storage/' . $app->ss_follow_ig_posindonesia_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Screenshot follow IG posindonesia.ig</a></li>
                                        @endif
                                        @if($app->ss_subscribe_youtube_path)
                                            <li><a href="{{ asset('storage/' . $app->ss_subscribe_youtube_path) }}" target="_blank" class="inline-block px-2 py-1 rounded-sm border border-[#B91C1C] text-[#B91C1C] font-medium hover:bg-[#B91C1C] hover:text-white transition text-xs">Screenshot subscribe Youtube</a></li>
                                        @endif
                                        @if(!$app->cover_letter_path && !$app->foto_nametag_path && !$app->screenshot_pospay_path && !$app->foto_prangko_prisma_path && !$app->ss_follow_ig_museum_path && !$app->ss_follow_ig_posindonesia_path && !$app->ss_subscribe_youtube_path)
                                            <li><span class="text-[#706f6c]">-</span></li>
                                        @endif
                                    </ul>
                                </td>
                                <td class="px-4 py-2">{{ $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d-m-Y') : '-' }}</td>
                                <td class="px-4 py-2">{{ $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d-m-Y') : '-' }}</td>
                                <td class="px-4 py-2">
                                    @if($app->acceptance_letter_path)
                                        <span class="text-green-600"><i class="fas fa-check-circle"></i></span>
                                    @else
                                        <span class="text-red-600"><i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    @if($row === 1)
                        <tr><td colspan="13" class="text-center py-8 text-[#706f6c]">Tidak ada peserta magang berstatus accepted.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 