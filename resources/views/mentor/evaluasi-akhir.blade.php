{{-- Mentor: lihat dokumen evaluasi akhir peserta --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir Peserta')

@php
    $role = 'mentor';
    $pageTitle = 'Evaluasi Akhir';
    $pageSubtitle = 'Lihat dan unduh dokumen evaluasi akhir peserta bimbingan Anda (hanya baca).';
@endphp

@push('styles')
<style>
.ea-table-wrap { background: rgba(255,255,255,0.95); border-radius: 20px; border: 1px solid rgba(0,0,0,0.06); overflow: hidden; }
.ea-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
}
</style>
@endpush

@section('content')
<div class="ea-hero">
    <h1 class="h4 mb-2"><i class="fas fa-file-signature me-2"></i>Evaluasi Akhir Peserta</h1>
    <p class="mb-0 opacity-90">Anda tidak dapat mengunggah dari sini; hanya melihat dan mengunduh dokumen yang sudah tersedia.</p>
</div>

<div class="ea-table-wrap">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Peserta</th>
                    <th>Status magang</th>
                    <th>Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>
                            <strong>{{ $app->user->name }}</strong><br>
                            <span class="text-muted small">{{ $app->user->nim ?? '—' }}</span>
                        </td>
                        <td><span class="badge bg-secondary">{{ $app->status }}</span></td>
                        <td>
                            @if($app->finalEvaluationDocumentPath())
                                <a href="{{ route('mentor.evaluasi-akhir.download', $app->id) }}" class="btn btn-sm btn-outline-danger">Unduh</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Tidak ada peserta bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
