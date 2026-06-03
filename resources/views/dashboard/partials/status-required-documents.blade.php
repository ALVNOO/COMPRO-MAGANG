{{--
    STATUS REQUIRED DOCUMENTS
    Upload Surat Penerimaan, Surat Izin Masuk Lokasi, dan Pakta Integritas sebelum Siap Magang
--}}

@php
    $hasAcceptanceUploaded = $application->hasStoredDocument($application->acceptance_letter_path);
    $hasLocationUploaded = $application->hasStoredDocument($application->location_permission_letter_path);
    $hasIntegrityUploaded = $application->hasStoredDocument($application->integrity_pact_path);
    $allRequiredDocsCollected = $application->hasPreInternshipDocumentsCollected();
    $uploadedCount = (int) $hasAcceptanceUploaded + (int) $hasLocationUploaded + (int) $hasIntegrityUploaded;
@endphp

<div class="sp-req-docs sp-anim sp-anim-5">
    <div class="sp-req-docs-head">
        <div class="sp-req-docs-head-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <h3 class="sp-req-docs-title">Pengumpulan Dokumen Wajib</h3>
            <p class="sp-req-docs-sub">Unggah ketiga dokumen berikut (format PDF, maks. 2 MB) sebelum melanjutkan ke dashboard magang.</p>
        </div>
        <div class="sp-req-docs-progress" aria-label="Progres pengumpulan dokumen">
            <span class="sp-req-docs-progress-count">{{ $uploadedCount }}/3</span>
            <span class="sp-req-docs-progress-label">terkumpul</span>
        </div>
    </div>

    <div class="sp-req-docs-grid">
        {{-- Surat Penerimaan --}}
        <div class="sp-req-doc-card {{ $hasAcceptanceUploaded ? 'is-done' : '' }}">
            <div class="sp-req-doc-card-top">
                <div class="sp-req-doc-icon {{ $hasAcceptanceUploaded ? 'done' : 'pending' }}">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div class="sp-req-doc-info">
                    <div class="sp-req-doc-name">Surat Penerimaan</div>
                    <div class="sp-req-doc-status">
                        @if($hasAcceptanceUploaded)
                            <i class="fas fa-check-circle"></i> Sudah diunggah
                        @else
                            <i class="fas fa-clock"></i> Belum diunggah
                        @endif
                    </div>
                </div>
            </div>
            @if($hasAcceptanceUploaded)
                <a href="{{ asset('storage/' . $application->acceptance_letter_path) }}" target="_blank" rel="noopener" class="sp-req-doc-view">
                    <i class="fas fa-eye"></i> Lihat dokumen
                </a>
            @endif
            <form method="POST" action="{{ route('dashboard.status.upload-acceptance-letter') }}" enctype="multipart/form-data" class="sp-req-doc-form">
                @csrf
                <label class="sp-req-doc-file">
                    <input type="file" name="acceptance_letter" accept=".pdf,application/pdf" {{ $hasAcceptanceUploaded ? '' : 'required' }}>
                    <span class="sp-req-doc-file-btn"><i class="fas fa-file-pdf"></i> {{ $hasAcceptanceUploaded ? 'Ganti file' : 'Pilih PDF' }}</span>
                </label>
                <button type="submit" class="sp-req-doc-submit">
                    <i class="fas fa-upload"></i> Unggah
                </button>
            </form>
        </div>

        {{-- Surat Izin Masuk Lokasi --}}
        <div class="sp-req-doc-card {{ $hasLocationUploaded ? 'is-done' : '' }}">
            <div class="sp-req-doc-card-top">
                <div class="sp-req-doc-icon {{ $hasLocationUploaded ? 'done' : 'pending' }}">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="sp-req-doc-info">
                    <div class="sp-req-doc-name">Surat Izin Masuk Lokasi</div>
                    <div class="sp-req-doc-status">
                        @if($hasLocationUploaded)
                            <i class="fas fa-check-circle"></i> Sudah diunggah
                        @else
                            <i class="fas fa-clock"></i> Belum diunggah
                        @endif
                    </div>
                </div>
            </div>
            @if($hasLocationUploaded)
                <a href="{{ asset('storage/' . $application->location_permission_letter_path) }}" target="_blank" rel="noopener" class="sp-req-doc-view">
                    <i class="fas fa-eye"></i> Lihat dokumen
                </a>
            @endif
            <form method="POST" action="{{ route('dashboard.status.upload-location-permission-letter') }}" enctype="multipart/form-data" class="sp-req-doc-form">
                @csrf
                <label class="sp-req-doc-file">
                    <input type="file" name="location_permission_letter" accept=".pdf,application/pdf" {{ $hasLocationUploaded ? '' : 'required' }}>
                    <span class="sp-req-doc-file-btn"><i class="fas fa-file-pdf"></i> {{ $hasLocationUploaded ? 'Ganti file' : 'Pilih PDF' }}</span>
                </label>
                <button type="submit" class="sp-req-doc-submit">
                    <i class="fas fa-upload"></i> Unggah
                </button>
            </form>
        </div>

        {{-- Pakta Integritas --}}
        <div class="sp-req-doc-card {{ $hasIntegrityUploaded ? 'is-done' : '' }}">
            <div class="sp-req-doc-card-top">
                <div class="sp-req-doc-icon {{ $hasIntegrityUploaded ? 'done' : 'pending' }}">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="sp-req-doc-info">
                    <div class="sp-req-doc-name">Pakta Integritas</div>
                    <div class="sp-req-doc-status">
                        @if($hasIntegrityUploaded)
                            <i class="fas fa-check-circle"></i> Sudah diunggah
                        @else
                            <i class="fas fa-clock"></i> Belum diunggah
                        @endif
                    </div>
                </div>
            </div>
            @if($hasIntegrityUploaded)
                <a href="{{ asset('storage/' . $application->integrity_pact_path) }}" target="_blank" rel="noopener" class="sp-req-doc-view">
                    <i class="fas fa-eye"></i> Lihat dokumen
                </a>
            @endif
            <form method="POST" action="{{ route('dashboard.status.upload-integrity-pact') }}" enctype="multipart/form-data" class="sp-req-doc-form">
                @csrf
                <label class="sp-req-doc-file">
                    <input type="file" name="integrity_pact" accept=".pdf,application/pdf" {{ $hasIntegrityUploaded ? '' : 'required' }}>
                    <span class="sp-req-doc-file-btn"><i class="fas fa-file-pdf"></i> {{ $hasIntegrityUploaded ? 'Ganti file' : 'Pilih PDF' }}</span>
                </label>
                <button type="submit" class="sp-req-doc-submit">
                    <i class="fas fa-upload"></i> Unggah
                </button>
            </form>
        </div>
    </div>

    @unless($allRequiredDocsCollected)
        <p class="sp-req-docs-warning">
            <i class="fas fa-info-circle"></i>
            Tombol <strong>Siap Magang</strong> akan aktif setelah ketiga dokumen di atas berhasil diunggah.
        </p>
    @endunless
</div>
