{{-- Admin: kelola evaluasi akhir --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir')

@php
    $role = 'admin';
    $pageTitle = 'Evaluasi Akhir';
    $pageSubtitle = 'Satu dokumen evaluasi akhir per pengajuan (peserta atau admin, saling eksklusif). PDF maksimal 2 MB.';
@endphp

@push('styles')
<style>
.fea-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    color: #fff;
}
.fea-card {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.06);
    overflow: hidden;
}
</style>
@endpush

@section('content')
<div class="fea-hero">
    <h1 class="h4 mb-2"><i class="fas fa-file-signature me-2"></i>Evaluasi Akhir</h1>
    <p class="mb-0 opacity-90">Unduh dokumen yang ada, atau unggah jika belum ada (tombol Unggah nonaktif jika peserta sudah mengunggah).</p>
</div>

<div class="fea-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Peserta</th>
                    <th>Pengajuan</th>
                    <th>Dokumen</th>
                    <th>Unggah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participants as $userRow)
                    @php
                        $app = $userRow->internshipApplications->first();
                    @endphp
                    @if($app)
                    <tr>
                        <td>
                            <strong>{{ $userRow->name }}</strong><br>
                            <span class="text-muted small">{{ $userRow->nim ?? '—' }}</span>
                        </td>
                        <td><span class="badge bg-secondary">#{{ $app->id }} {{ $app->status }}</span></td>
                        <td>
                            @if($app->finalEvaluationDocumentPath())
                                <a href="{{ route('admin.final-evaluation.download', $app->id) }}" class="btn btn-sm btn-outline-danger">Unduh</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="min-width: 200px;">
                            @if($app->final_evaluation_participant_path)
                                <button type="button" class="btn btn-sm btn-secondary w-100" disabled title="Peserta sudah mengunggah dokumen evaluasi akhir.">
                                    <i class="fas fa-upload me-1"></i>Unggah
                                </button>
                            @else
                                <form method="POST" action="{{ route('admin.final-evaluation.upload', $app->id) }}" enctype="multipart/form-data" class="d-flex flex-column gap-2">
                                    @csrf
                                    <input type="file" name="final_evaluation_admin" class="form-control form-control-sm" accept="application/pdf,.pdf" required>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-upload me-1"></i>Unggah (maks. 2 MB)
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
