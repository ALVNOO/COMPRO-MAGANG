{{-- Evaluasi akhir peserta (unggah PDF) --}}
@extends('layouts.dashboard-unified')

@section('title', 'Evaluasi Akhir')

@php
    $role      = 'participant';
    $pageTitle = 'Evaluasi Akhir';
@endphp

@push('styles')
<style>
/* ── Layout ── */
.fev-top-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    margin-bottom: 1.25rem;
    align-items: start;
}

/* ── Status card ── */
.fev-status {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
}

.fev-status-head {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.5rem;
}

.fev-status-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; flex-shrink: 0;
}
.fev-status-icon.done    { background: #DCFCE7; color: #16A34A; }
.fev-status-icon.pending { background: #FEF9C3; color: #D97706; }
.fev-status-icon.empty   { background: #FEE2E2; color: #EE2E24; }

.fev-status-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: .2rem; }
.fev-status-sub   { font-size: .825rem; color: #6B7280; }


.fev-status-footer {
    padding: .875rem 1.5rem;
    background: #F9FAFB;
    border-top: 1px solid #F3F4F6;
    display: flex; align-items: center; gap: .75rem; flex-wrap: wrap;
    font-size: .8rem; color: #374151;
}

/* ── Upload card ── */
.fev-upload {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.fev-upload-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: .875rem 1.25rem;
    border-bottom: 1px solid #F3F4F6;
}

.fev-upload-title {
    font-size: .875rem; font-weight: 700; color: #111827;
    display: flex; align-items: center; gap: .5rem;
}
.fev-upload-title i { color: #EE2E24; }

.fev-upload-body { padding: 1.5rem 1.25rem; }

/* Drop zone */
.fev-dropzone {
    border: 2px dashed #E5E7EB; border-radius: 12px;
    padding: 2.5rem 1.25rem; text-align: center;
    cursor: pointer; transition: all .2s; background: #FAFAFA;
}
.fev-dropzone:hover, .fev-dropzone.drag-over {
    border-color: #EE2E24; background: rgba(238,46,36,.03);
}

.fev-dz-icon {
    width: 56px; height: 56px; border-radius: 14px;
    background: rgba(238,46,36,.08); color: #EE2E24;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; margin: 0 auto .875rem;
    transition: transform .2s;
}
.fev-dropzone:hover .fev-dz-icon { transform: scale(1.08); }

.fev-dropzone h4 { font-size: .9rem; font-weight: 700; color: #374151; margin: 0 0 .3rem; }
.fev-dropzone p  { font-size: .78rem; color: #9CA3AF; margin: 0 0 1.125rem; }

.fev-pick-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .575rem 1.375rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; border: none; border-radius: 10px;
    font-size: .825rem; font-weight: 700; cursor: pointer;
    box-shadow: 0 3px 10px rgba(238,46,36,.25); transition: all .18s;
}
.fev-pick-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(238,46,36,.35); }

/* File preview */
.fev-file-preview {
    display: none;
    align-items: center; gap: .875rem;
    padding: .875rem 1rem;
    background: #F8FAFC; border: 1.5px solid #E2E8F0;
    border-radius: 12px; margin-bottom: .875rem;
}
.fev-file-icon  { font-size: 2rem; flex-shrink: 0; }
.fev-file-name  { font-size: .875rem; font-weight: 600; color: #1E293B; word-break: break-all; }
.fev-file-size  { font-size: .75rem; color: #9CA3AF; margin-top: .1rem; }

.fev-confirm-row {
    display: none; gap: .5rem; justify-content: flex-end;
}

.fev-btn-cancel {
    padding: .5rem .875rem;
    background: #fff; color: #6B7280;
    border: 1.5px solid #E5E7EB; border-radius: 8px;
    font-size: .8rem; font-weight: 600; cursor: pointer; transition: all .15s;
}
.fev-btn-cancel:hover { border-color: #9CA3AF; }

.fev-btn-change {
    padding: .5rem .875rem;
    background: #fff; color: #2563EB;
    border: 1.5px solid #2563EB; border-radius: 8px;
    font-size: .8rem; font-weight: 600; cursor: pointer; transition: all .15s;
}
.fev-btn-change:hover { background: #EFF6FF; }

.fev-btn-submit {
    padding: .5rem 1.375rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff; border: none; border-radius: 8px;
    font-size: .8rem; font-weight: 700; cursor: pointer;
    box-shadow: 0 2px 8px rgba(238,46,36,.25); transition: all .18s;
    display: inline-flex; align-items: center; gap: .4rem;
}
.fev-btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(238,46,36,.35); }

/* Admin locked */
.fev-locked {
    display: flex; align-items: flex-start; gap: .875rem;
    padding: 1.125rem 1.25rem;
    background: #F0FDF4; border: 1.5px solid #86EFAC; border-radius: 12px;
}
.fev-locked-icon {
    width: 36px; height: 36px; border-radius: 9px;
    background: #DCFCE7; color: #16A34A;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem; flex-shrink: 0;
}
.fev-locked p { font-size: .85rem; color: #166534; margin: 0; line-height: 1.55; }

/* Download button */
.fev-dl-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .5rem 1.125rem;
    background: #fff; color: #1E293B;
    border: 1.5px solid #E5E7EB; border-radius: 10px;
    font-size: .82rem; font-weight: 600; text-decoration: none;
    box-shadow: 0 1px 3px rgba(0,0,0,.08); transition: all .18s;
    flex-shrink: 0;
}
.fev-dl-btn:hover {
    border-color: #EE2E24; color: #EE2E24;
    box-shadow: 0 3px 10px rgba(238,46,36,.15);
    transform: translateY(-1px);
}

/* Validation error */
.fev-err {
    padding: .625rem .875rem;
    background: #FEF2F2; border: 1px solid #FECACA; border-radius: 9px;
    font-size: .8rem; color: #DC2626; font-weight: 500;
    margin-bottom: 1rem;
    display: flex; align-items: center; gap: .5rem;
}

/* ── Info card ── */
.fev-info {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
    height: 100%;
}

/* ── Responsive ── */
@media (max-width: 768px) {
    .fev-top-grid { grid-template-columns: 1fr; }
}

.fev-info-head {
    display: flex; align-items: center; gap: .5rem;
    padding: .875rem 1.25rem; border-bottom: 1px solid #F3F4F6;
    font-size: .875rem; font-weight: 700; color: #111827;
}
.fev-info-head i { color: #EE2E24; }

.fev-info-body { padding: 1rem 1.25rem; display: flex; flex-direction: column; gap: .625rem; }

.fev-info-item {
    display: flex; align-items: flex-start; gap: .75rem;
    font-size: .825rem; color: #4B5563; line-height: 1.55;
}
.fev-info-item i { font-size: .65rem; margin-top: .35rem; flex-shrink: 0; color: #EE2E24; }
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Evaluasi Akhir"
    description="Unggah dokumen evaluasi akhir magang Anda. Diperlukan untuk mengaktifkan unduh sertifikat."
    icon="fas fa-file-signature"
    role="peserta"
/>

{{-- Flash messages --}}
@if(session('success'))
<div class="fev-err" style="background:#F0FDF4;border-color:#86EFAC;color:#15803D;">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="fev-err"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif
@if($errors->has('final_evaluation'))
<div class="fev-err"><i class="fas fa-exclamation-circle"></i> {{ $errors->first('final_evaluation') }}</div>
@endif

@if(!$application)

{{-- ── No application ── --}}
<div class="fev-status" style="margin-bottom:1.25rem;">
    <div class="fev-status-head">
        <div class="fev-status-icon empty"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="fev-status-title">Tidak Ada Pengajuan Aktif</div>
            <div class="fev-status-sub">Anda belum memiliki pengajuan magang yang diterima.</div>
        </div>
    </div>
</div>

@else
@php
    $hasDoc          = $application->hasFinalEvaluationDocument();
    $adminDone       = !empty($application->final_evaluation_admin_path);
    $participantDone = !empty($application->final_evaluation_participant_path);
    $uploadedAt      = $application->final_evaluation_participant_uploaded_at
                    ?? $application->final_evaluation_admin_uploaded_at;
    $docPath         = $application->finalEvaluationDocumentPath();
@endphp

{{-- ── Row 1: Status (kiri) + Info (kanan) ── --}}
<div class="fev-top-grid">

    {{-- Status Card --}}
    <div class="fev-status">
        <div class="fev-status-head">
            <div class="fev-status-icon {{ $hasDoc ? 'done' : 'pending' }}">
                <i class="fas {{ $hasDoc ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div class="fev-status-title">
                    {{ $hasDoc ? 'Dokumen Tersedia' : 'Dokumen Belum Diunggah' }}
                </div>
                <div class="fev-status-sub">
                    @if($hasDoc)
                        Diunggah oleh <strong>{{ $adminDone ? 'Admin' : 'Anda' }}</strong>
                        @if($uploadedAt)
                            &mdash; {{ $uploadedAt->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
                        @endif
                    @else
                        Silakan unggah dokumen evaluasi akhir di bawah ini
                    @endif
                </div>
            </div>
            @if($hasDoc)
                <span class="badge badge-success" style="flex-shrink:0;"><i class="fas fa-check"></i> Terpenuhi</span>
            @endif
        </div>
        @if($hasDoc && $docPath)
        <div class="fev-status-footer">
            <i class="fas fa-info-circle" style="color:#EE2E24;"></i>
            <span>Persyaratan untuk unduh sertifikat telah terpenuhi.</span>
            <a href="{{ route('dashboard.final-evaluation.download') }}" class="fev-dl-btn" style="margin-left:auto;">
                <i class="fas fa-download"></i> Unduh
            </a>
        </div>
        @elseif(!$hasDoc)
        <div class="fev-status-footer">
            <i class="fas fa-exclamation-triangle" style="color:#D97706;"></i>
            <span>Tanpa dokumen ini, unduh sertifikat tidak aktif.</span>
        </div>
        @endif
    </div>

    {{-- Info Card --}}
    <div class="fev-info">
        <div class="fev-info-head">
            <i class="fas fa-circle-info"></i> Informasi
        </div>
        <div class="fev-info-body">
            <div class="fev-info-item">
                <i class="fas fa-circle"></i>
                <span>Diperlukan sebagai syarat tambahan untuk <strong>mengaktifkan unduh sertifikat</strong> dan surat selesai magang.</span>
            </div>
            <div class="fev-info-item">
                <i class="fas fa-circle"></i>
                <span>Format <strong>PDF</strong>, ukuran maksimal <strong>2 MB</strong>.</span>
            </div>
            <div class="fev-info-item">
                <i class="fas fa-circle"></i>
                <span>Jika Admin sudah mengunggah dokumen untuk Anda, tombol unggah dari akun peserta dinonaktifkan otomatis.</span>
            </div>
            <div class="fev-info-item">
                <i class="fas fa-circle"></i>
                <span>Mengunggah file baru akan menggantikan dokumen sebelumnya.</span>
            </div>
        </div>
    </div>

</div>

{{-- ── Row 2: Upload Card (full width) ── --}}
<div class="fev-upload">
    <div class="fev-upload-head">
        <div class="fev-upload-title">
            <i class="fas fa-cloud-upload-alt"></i>
            {{ $hasDoc && !$adminDone ? 'Ganti Dokumen' : 'Unggah Dokumen' }}
        </div>
        @if($hasDoc && !$adminDone)
            <span style="font-size:.75rem;color:#9CA3AF;">File baru akan menggantikan dokumen sebelumnya</span>
        @endif
    </div>
    <div class="fev-upload-body">
        @if($adminDone)
            <div class="fev-locked">
                <div class="fev-locked-icon"><i class="fas fa-lock"></i></div>
                <p>Dokumen evaluasi akhir sudah diunggah oleh <strong>Admin</strong> untuk pengajuan ini. Unggahan dari akun peserta dinonaktifkan.</p>
            </div>
        @else
            <form method="POST" action="{{ route('dashboard.final-evaluation.upload') }}"
                  enctype="multipart/form-data" id="fevForm">
                @csrf
                <input type="file" id="fevFileInput" name="final_evaluation"
                       accept="application/pdf,.pdf" style="display:none;">

                {{-- Drop zone (initial) --}}
                <div class="fev-dropzone" id="fevDropzone">
                    <div class="fev-dz-icon"><i class="fas fa-file-pdf"></i></div>
                    <h4>Pilih atau seret file PDF ke sini</h4>
                    <p>Format PDF &middot; Maksimal 2 MB</p>
                    <button type="button" class="fev-pick-btn" onclick="document.getElementById('fevFileInput').click()">
                        <i class="fas fa-folder-open"></i> Pilih File
                    </button>
                </div>

                {{-- File preview (after selection) --}}
                <div class="fev-file-preview" id="fevFilePreview">
                    <i class="fas fa-file-pdf fev-file-icon" style="color:#EE2E24;"></i>
                    <div style="flex:1;min-width:0;">
                        <div class="fev-file-name" id="fevFileName"></div>
                        <div class="fev-file-size" id="fevFileSize"></div>
                    </div>
                </div>

                <div class="fev-confirm-row" id="fevConfirmRow">
                    <button type="button" class="fev-btn-cancel" onclick="fevCancel()">Batalkan</button>
                    <button type="button" class="fev-btn-change" onclick="document.getElementById('fevFileInput').click()">Ubah File</button>
                    <button type="submit" class="fev-btn-submit">
                        <i class="fas fa-cloud-upload-alt"></i> Simpan
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

@endif
@endsection

@push('scripts')
<script>
(function () {
    const input      = document.getElementById('fevFileInput');
    const dropzone   = document.getElementById('fevDropzone');
    const preview    = document.getElementById('fevFilePreview');
    const confirmRow = document.getElementById('fevConfirmRow');
    const fileName   = document.getElementById('fevFileName');
    const fileSize   = document.getElementById('fevFileSize');

    if (!input) return;

    function fmtSize(b) {
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
        return (b / 1048576).toFixed(1) + ' MB';
    }

    function showFile(file) {
        fileName.textContent = file.name;
        fileSize.textContent = fmtSize(file.size);
        dropzone.style.display   = 'none';
        preview.style.display    = 'flex';
        confirmRow.style.display = 'flex';
    }

    input.addEventListener('change', function () {
        if (this.files[0]) showFile(this.files[0]);
    });

    // Drag & drop
    if (dropzone) {
        dropzone.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON') return;
        });
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropzone.classList.add('drag-over');
        });
        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('drag-over');
        });
        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file && file.type === 'application/pdf') {
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                showFile(file);
            }
        });
    }

    window.fevCancel = function () {
        input.value = '';
        dropzone.style.display   = '';
        preview.style.display    = 'none';
        confirmRow.style.display = 'none';
    };
})();
</script>
@endpush
