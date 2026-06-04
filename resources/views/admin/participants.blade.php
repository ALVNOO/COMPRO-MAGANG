{{--
    ADMIN PARTICIPANTS PAGE
    Manage accepted internship participants with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Daftar Peserta')

@php
    $role = 'admin';
    $pageTitle = 'Daftar Peserta Magang';
    $pageSubtitle = 'Kelola data peserta magang yang sudah diterima';

    // Count stats
    $totalParticipants = 0;
    $activeParticipants = 0;
    $completedParticipants = 0;
    $incompleteDocuments = 0;

    foreach($participants as $peserta) {
        foreach($peserta->internshipApplications as $app) {
            $totalParticipants++;

            $now = \Carbon\Carbon::now();
            $startDate = $app->start_date ? \Carbon\Carbon::parse($app->start_date) : null;
            $endDate = $app->end_date ? \Carbon\Carbon::parse($app->end_date) : null;

            if ($startDate && $endDate) {
                if ($now->between($startDate, $endDate)) {
                    $activeParticipants++;
                } elseif ($now->gt($endDate)) {
                    $completedParticipants++;
                }
            }

            // Check incomplete documents
            $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
            if (!$app->acceptance_letter_path || !$hasCertificate || !$app->completion_letter_path) {
                $incompleteDocuments++;
            }
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   PARTICIPANTS PAGE STYLES
   ============================================ */

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}


/* Legend Box */
.legend-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
}

.legend-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.legend-items {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.legend-item i.fa-check-circle { color: #22c55e; }
.legend-item i.fa-times-circle { color: #ef4444; }
.legend-item i.fa-edit { color: #f59e0b; }

/* Filter Bar */
.filter-bar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-input {
    flex: 1;
    min-width: 200px;
    padding: 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white;
    transition: all 0.2s ease;
}

.filter-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-select {
    padding: 0.625rem 2rem 0.625rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    background: white url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") right 0.5rem center/1.5em 1.5em no-repeat;
    cursor: pointer;
    transition: all 0.2s ease;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-btn {
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.participants-table {
    width: 100%;
    border-collapse: collapse;
}

/* Pastikan header tetap tengah meski ada stylesheet global (.table th, dll.) */
table.participants-table > thead > tr > th {
    text-align: center !important;
}

.participants-table td {
    padding: 1rem 0.75rem;
    font-size: 0.875rem;
    color: #374151;
    border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    vertical-align: middle;
    text-align: center;
}

/* No, Divisi, Periode, Status, Dokumen, Aksi: isi tengah; Peserta (kolom 2): tetap kiri */
.participants-table tbody td:nth-child(1),
.participants-table tbody td:nth-child(3),
.participants-table tbody td:nth-child(4),
.participants-table tbody td:nth-child(5),
.participants-table tbody td:nth-child(6),
.participants-table tbody td:nth-child(7) {
    text-align: center;
}

.participants-table tbody td:nth-child(2) {
    text-align: left;
}

.participants-table tbody td:nth-child(4) .period-info {
    text-align: center;
}

.participants-table tbody td:nth-child(6) .doc-status {
    justify-content: center;
}

.participants-table tbody tr {
    transition: all 0.2s ease;
}

.participants-table tbody tr:hover {
    background: rgba(238, 46, 36, 0.02);
}

.participant-name {
    font-weight: 600;
    color: #1f2937;
}

.participant-email {
    font-size: 0.75rem;
    color: #6b7280;
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.division-badge {
    display: inline-flex;
    padding: 0.25rem 0.625rem;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: #4f46e5;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.period-info {
    font-size: 0.8rem;
    color: #6b7280;
}

.period-info .dates {
    font-weight: 500;
    color: #374151;
}


/* Document Status */
.doc-status {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.doc-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: all 0.2s ease;
}

.doc-icon.available {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    cursor: pointer;
}

.doc-icon.available:hover {
    background: rgba(34, 197, 94, 0.2);
    transform: scale(1.05);
}

.doc-icon.missing {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

/* Action Buttons */
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    gap: 0.375rem;
}

.action-btn.primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.action-btn.secondary {
    background: rgba(107, 114, 128, 0.1);
    color: #4b5563;
}

.action-btn.secondary:hover {
    background: rgba(107, 114, 128, 0.2);
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(238, 46, 36, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: #EE2E24;
}

.empty-state h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9rem;
    color: #6b7280;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-container {
    background: white;
    border-radius: 20px;
    max-width: 1080px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s ease;
}

.modal-overlay.active .modal-container {
    transform: scale(1) translateY(0);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-title i {
    color: #EE2E24;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: #f3f4f6;
    color: #6b7280;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #e5e7eb;
    color: #374151;
}

.modal-body {
    padding: 1.5rem;
    min-width: 0;
}

.modal-body-layout {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.modal-top-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 1.25rem;
    align-items: stretch;
}

.modal-panel {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.modal-panel .modal-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-bottom: 0;
    min-height: 100%;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.modal-panel-info .info-rows {
    flex: 1;
    justify-content: space-between;
}

.modal-panel-docs .doc-grid {
    flex: 1;
    align-content: start;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.5rem;
}

.modal-bottom-row {
    padding-top: 0.25rem;
    border-top: 1px solid #e5e7eb;
}

.modal-bottom-row .modal-section {
    margin-bottom: 0;
}

.modal-bottom-row .upload-form {
    margin-top: 0;
}

.modal-panel-docs .doc-item.doc-item-card {
    gap: 0.4rem;
    padding: 0.55rem 0.6rem;
}

.modal-panel-docs .doc-item-header {
    gap: 0.5rem;
    align-items: flex-start;
}

.modal-panel-docs .doc-item-icon {
    width: 30px;
    height: 30px;
    font-size: 0.75rem;
    flex-shrink: 0;
}

.modal-panel-docs .doc-item-name {
    font-size: 0.76rem;
    line-height: 1.3;
}

.modal-panel-docs .doc-item-status {
    font-size: 0.68rem;
}

.modal-panel-docs .doc-item-muted-note {
    font-size: 0.64rem;
    line-height: 1.3;
}

.modal-panel-docs .doc-item-upload-row.doc-upload-compact {
    gap: 0.3rem;
}

.modal-panel-docs .doc-upload-pick {
    min-height: 1.85rem;
    padding: 0.2rem 0.35rem;
}

.modal-panel-docs .doc-upload-pick-text {
    font-size: 0.65rem;
}

.modal-panel-docs .doc-upload-send {
    min-height: 1.85rem;
    font-size: 0.75rem;
}

.modal-panel-docs .action-btn.secondary {
    padding: 0.35rem 0.45rem;
    font-size: 0.72rem;
    flex-shrink: 0;
}

.modal-section {
    margin-bottom: 1.5rem;
}

.modal-section:last-child {
    margin-bottom: 0;
}

.modal-section-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.75rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.info-rows {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-label {
    font-size: 0.75rem;
    color: #9ca3af;
}

.info-value {
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
}

.doc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    min-width: 0;
}

.doc-grid > * {
    min-width: 0;
}

.doc-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: #f9fafb;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.doc-item.doc-item-card {
    flex-direction: column;
    align-items: stretch;
    gap: 0.65rem;
    min-width: 0;
    overflow: hidden;
}

.doc-item-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 0;
}

.doc-item-card .doc-item-info {
    flex: 1;
    min-width: 0;
}

/* Kompak: tanpa input file native lebar di samping tombol */
.doc-item-upload-row.doc-upload-compact {
    display: grid;
    grid-template-columns: 1fr 2.25rem;
    gap: 0.35rem;
    align-items: stretch;
    min-width: 0;
}

.doc-upload-pick {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 0;
    min-height: 2.1rem;
    padding: 0.25rem 0.4rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: border-color 0.15s ease, background 0.15s ease;
}

.doc-upload-pick:hover {
    border-color: #d1d5db;
    background: #fafafa;
}

.doc-upload-pick-input {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
    font-size: 0;
}

.doc-upload-pick-label {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.doc-upload-pick-text {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    pointer-events: none;
    font-size: 0.72rem;
    font-weight: 500;
    color: #4b5563;
    min-width: 0;
    width: 100%;
}

.doc-upload-pick-text .fa-file-pdf {
    color: #EE2E24;
    flex-shrink: 0;
    font-size: 0.8rem;
}

.doc-upload-send {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    min-height: 2.1rem;
    padding: 0;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: #fff;
    cursor: pointer;
    font-size: 0.85rem;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.doc-upload-send:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(238, 46, 36, 0.28);
}

.doc-item-muted-note {
    font-size: 0.72rem;
    color: #9ca3af;
    line-height: 1.35;
    margin: 0;
}

.doc-item:hover {
    background: #f3f4f6;
}

.doc-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.doc-item-icon.has-file {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.doc-item-icon.no-file {
    background: rgba(156, 163, 175, 0.1);
    color: #9ca3af;
}

.doc-item-info {
    flex: 1;
}

.doc-item-name {
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
}

.doc-item-status {
    font-size: 0.7rem;
    color: #9ca3af;
}

.upload-form {
    margin-top: 1rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 12px;
}

.upload-form-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
}

.upload-form-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.upload-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.85rem;
    background: white;
}

.upload-btn {
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: all 0.2s ease;
}

.upload-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .hero-content {
        flex-direction: column;
        align-items: flex-start;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .filter-bar {
        flex-direction: column;
    }

    .filter-input,
    .filter-select {
        width: 100%;
    }

    .legend-items {
        flex-direction: column;
        gap: 0.5rem;
    }

    .participants-table {
        font-size: 0.8rem;
    }

    .participants-table th,
    .participants-table td {
        padding: 0.75rem 0.5rem;
    }

    .info-grid,
    .info-row,
    .doc-grid {
        grid-template-columns: 1fr;
    }

    .modal-container {
        max-width: 600px;
    }

    .modal-top-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .modal-panel .modal-section {
        min-height: auto;
    }

    .modal-panel-info .info-rows {
        justify-content: flex-start;
    }
}
</style>
@endpush

@section('content')
<div class="participants-page" x-data="participantsManager()"
     x-init="adminHqEmail = {{ json_encode($adminHqEmail ?? '') }}">
    <x-dashboard.page-context-bar
        title="Daftar Peserta Magang"
        description="Kelola data dan dokumen peserta magang yang sudah diterima"
        icon="fas fa-users"
        role="admin"
    />

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalParticipants }}</div>
                    <div class="stat-label">Total Peserta</div>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $activeParticipants }}</div>
                    <div class="stat-label">Sedang Magang</div>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-info">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $completedParticipants }}</div>
                    <div class="stat-label">Selesai Magang</div>
                </div>
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-warning">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $incompleteDocuments }}</div>
                    <div class="stat-label">Dokumen Belum Lengkap</div>
                </div>
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-file-circle-exclamation"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Legend --}}
    <div class="legend-box">
        <div class="legend-title">
            <i class="fas fa-info-circle"></i> Keterangan Status Dokumen
        </div>
        <div class="legend-items">
            <div class="legend-item">
                <i class="fas fa-check-circle"></i>
                <span>Dokumen tersedia / sudah diunggah</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-times-circle"></i>
                <span>Dokumen belum tersedia</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-edit"></i>
                <span>Dokumen sedang direvisi</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-paper-plane" style="color:#3b82f6;"></i>
                <span>Email ke pusat sudah dikirim</span>
            </div>
            <div class="legend-item">
                <i class="fas fa-paper-plane" style="color:#d1d5db;"></i>
                <span>Email ke pusat belum dikirim</span>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            type="text"
            class="filter-input"
            placeholder="Cari nama, email, atau divisi..."
            x-model="searchQuery"
            @input="filterTable()"
        >
        <x-ui.chips>
            <button type="button" class="chip" :class="{ active: statusFilter === '' }" @click="statusFilter = ''; filterTable()">Semua</button>
            <button type="button" class="chip" :class="{ active: statusFilter === 'active' }" @click="statusFilter = 'active'; filterTable()">Aktif</button>
            <button type="button" class="chip" :class="{ active: statusFilter === 'completed' }" @click="statusFilter = 'completed'; filterTable()">Selesai</button>
            <button type="button" class="chip" :class="{ active: statusFilter === 'upcoming' }" @click="statusFilter = 'upcoming'; filterTable()">Belum Mulai</button>
        </x-ui.chips>
        <select class="filter-select" x-model="docFilter" @change="filterTable()">
            <option value="">Semua Dokumen</option>
            <option value="complete">Lengkap</option>
            <option value="incomplete">Belum Lengkap</option>
        </select>
        <button class="filter-btn" @click="resetFilters()">
            <i class="fas fa-sync-alt"></i> Reset
        </button>
    </div>

    {{-- Table Card --}}
    <div class="table-card">
        <div class="table-header">
            <div class="table-title">
                <i class="fas fa-table"></i>
                <span>Data Peserta Magang</span>
            </div>
            <span class="text-sm text-gray-500" x-text="'Menampilkan ' + visibleCount + ' dari ' + totalCount + ' peserta'"></span>
        </div>

        <div class="overflow-x-auto">
            <table class="participants-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>Divisi</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="participantsTableBody">
                    @php $row = 1; @endphp
                    @foreach($participants as $peserta)
                        @foreach($peserta->internshipApplications as $app)
                            @php
                                $now = \Carbon\Carbon::now();
                                $startDate = $app->start_date ? \Carbon\Carbon::parse($app->start_date) : null;
                                $endDate = $app->end_date ? \Carbon\Carbon::parse($app->end_date) : null;

                                $status = 'upcoming';
                                $statusLabel = 'Belum Mulai';
                                if ($startDate && $endDate) {
                                    if ($now->between($startDate, $endDate)) {
                                        $status = 'active';
                                        $statusLabel = 'Aktif';
                                    } elseif ($now->gt($endDate)) {
                                        $status = 'completed';
                                        $statusLabel = 'Selesai';
                                    }
                                }

                                $hasCertificate = $peserta->certificates && $peserta->certificates->count() > 0;
                                $certificate = $hasCertificate ? $peserta->certificates->first() : null;
                                $isDocComplete = $app->acceptance_letter_path && $hasCertificate && $app->completion_letter_path;
                                $divMentors    = $app->division_admin_id
                                    ? ($mentorsByDivision[$app->division_admin_id] ?? collect())
                                    : collect();
                                $mentorOptions = $divMentors->map(fn($mentor) => [
                                    'id'   => $mentor->id,
                                    'name' => $mentor->mentor_name,
                                ])->values()->toArray();
                            @endphp
                            <tr class="participant-row"
                                data-name="{{ strtolower($peserta->name) }}"
                                data-email="{{ strtolower($peserta->email ?? '') }}"
                                data-division="{{ strtolower($app->divisionAdmin->division_name ?? '') }}"
                                data-status="{{ $status }}"
                                data-doc="{{ $isDocComplete ? 'complete' : 'incomplete' }}">
                                <td>{{ $row++ }}</td>
                                <td>
                                    <div class="participant-name">{{ $peserta->name }}</div>
                                    <div class="participant-email" title="{{ $peserta->email }}">{{ $peserta->email }}</div>
                                </td>
                                <td>
                                    <span class="division-badge" title="{{ $app->divisionAdmin->division_name ?? '-' }}">
                                        {{ Str::limit($app->divisionAdmin->division_name ?? '-', 20) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="period-info">
                                        <div class="dates">
                                            {{ $startDate ? $startDate->format('d M Y') : '-' }}
                                        </div>
                                        <div class="text-xs text-gray-400">s/d {{ $endDate ? $endDate->format('d M Y') : '-' }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($status === 'active')
                                    <span class="status-badge status-active">
                                        <i class="fas fa-circle"></i> {{ $statusLabel }}
                                    </span>
                                    @elseif($status === 'completed')
                                    <span class="status-badge status-finished">
                                        <i class="fas fa-check-circle"></i> {{ $statusLabel }}
                                    </span>
                                    @else
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> {{ $statusLabel }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="doc-status">
                                        {{-- 1. Surat Penerimaan (diunggah peserta) --}}
                                        @if($app->hasStoredDocument($app->acceptance_letter_path))
                                            <a href="{{ asset('storage/' . $app->acceptance_letter_path) }}" target="_blank" rel="noopener" class="doc-icon available" title="Lihat Surat Penerimaan">
                                                <i class="fas fa-file-signature"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Surat Penerimaan belum diunggah">
                                                <i class="fas fa-file-signature"></i>
                                            </span>
                                        @endif

                                        {{-- 2. Surat Izin Masuk Lokasi (diunggah peserta) --}}
                                        @if($app->hasStoredDocument($app->location_permission_letter_path))
                                            <a href="{{ asset('storage/' . $app->location_permission_letter_path) }}" target="_blank" rel="noopener" class="doc-icon available" title="Lihat Surat Izin Masuk Lokasi">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Surat Izin Masuk Lokasi belum diunggah">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </span>
                                        @endif

                                        {{-- 3. Pakta Integritas (diunggah peserta) --}}
                                        @if($app->hasStoredDocument($app->integrity_pact_path))
                                            <a href="{{ asset('storage/' . $app->integrity_pact_path) }}" target="_blank" rel="noopener" class="doc-icon available" title="Lihat Pakta Integritas">
                                                <i class="fas fa-file-contract"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Pakta Integritas belum diunggah">
                                                <i class="fas fa-file-contract"></i>
                                            </span>
                                        @endif

                                        {{-- 4. Laporan Penilaian --}}
                                        @if($app->assessment_report_path)
                                            <a href="{{ route('admin.participants.download-assessment-report', $app->id) }}" class="doc-icon available" title="Laporan Penilaian">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Laporan Penilaian belum ada">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                        @endif

                                        {{-- 5. Surat Selesai --}}
                                        @if(!empty($app->completion_letter_path))
                                            <a href="{{ asset('storage/' . $app->completion_letter_path) }}" target="_blank" class="doc-icon available" title="Surat Selesai">
                                                <i class="fas fa-file-circle-check"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Surat Selesai belum ada">
                                                <i class="fas fa-file-circle-check"></i>
                                            </span>
                                        @endif

                                        {{-- 6. Sertifikat --}}
                                        @if($certificate && $certificate->certificate_path)
                                            <a href="{{ asset('storage/' . $certificate->certificate_path) }}" target="_blank" class="doc-icon available" title="Sertifikat">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                        @else
                                            <span class="doc-icon missing" title="Sertifikat belum ada">
                                                <i class="fas fa-certificate"></i>
                                            </span>
                                        @endif

                                        {{-- 7. Email Kantor Pusat --}}
                                        @if($app->headquarters_email_sent_at)
                                            <span class="doc-icon" data-hq-email-icon="{{ $app->id }}" data-sent="1"
                                                  style="background:rgba(59,130,246,.1);color:#3b82f6;"
                                                  title="Email ke pusat sudah dikirim: {{ $app->headquarters_email_sent_at->format('d M Y H:i') }}">
                                                <i class="fas fa-paper-plane"></i>
                                            </span>
                                        @else
                                            <span class="doc-icon missing" data-hq-email-icon="{{ $app->id }}" data-sent="0"
                                                  title="Email ke pusat belum dikirim">
                                                <i class="fas fa-paper-plane"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button
                                        class="action-btn primary"
                                        @click="openModal({{ json_encode([
                                            'id' => $app->id,
                                            'userId' => $peserta->id,
                                            'name' => $peserta->name,
                                            'nim' => $peserta->nim,
                                            'email' => $peserta->email,
                                            'phone' => $peserta->phone,
                                            'university' => $peserta->university,
                                            'major' => $peserta->major,
                                            'division' => $app->divisionAdmin->division_name ?? '-',
                                            'startDate' => $startDate ? $startDate->format('d M Y') : '-',
                                            'endDate' => $endDate ? $endDate->format('d M Y') : '-',
                                            'status' => $statusLabel,
                                            'isAccepted' => $app->status === 'accepted',
                                            'hasMentor' => (bool)$app->division_mentor_id,
                                            'currentMentorId' => $app->division_mentor_id,
                                            'currentMentorName' => $app->divisionMentor->mentor_name ?? '-',
                                            'mentorOptions' => $mentorOptions,
                                            'hasAcceptance' => $app->hasStoredDocument($app->acceptance_letter_path),
                                            'acceptancePath' => $app->acceptance_letter_path,
                                            'hasReport' => (bool)$app->assessment_report_path,
                                            'reportPath' => $app->assessment_report_path,
                                            'hasCertificate' => $hasCertificate,
                                            'certificatePath' => $certificate ? $certificate->certificate_path : null,
                                            'hasCompletion' => (bool)$app->completion_letter_path,
                                            'completionPath' => $app->completion_letter_path,
                                            'hasLocationPermission' => $app->hasStoredDocument($app->location_permission_letter_path),
                                            'locationPermissionPath' => $app->location_permission_letter_path,
                                            'hasIntegrityPact' => $app->hasStoredDocument($app->integrity_pact_path),
                                            'integrityPactPath' => $app->integrity_pact_path,
                                            'hqEmailSent' => (bool)$app->headquarters_email_sent_at,
                                            'hqEmailSentAt' => $app->headquarters_email_sent_at ? $app->headquarters_email_sent_at->format('d M Y, H:i') : null,
                                            'nim' => $peserta->nim ?? '-',
                                            'major' => $peserta->major ?? '-',
                                            'university' => $peserta->university ?? '-',
                                            'mentorNik' => $app->divisionMentor->nik_number ?? '-',
                                            'hasSuratPermohonan' => !empty($app->surat_permohonan_path),
                                            'suratPermohonanUrl' => $app->surat_permohonan_path ? asset('storage/'.$app->surat_permohonan_path) : null,
                                            'hasCv' => !empty($app->cv_path),
                                            'cvUrl' => $app->cv_path ? asset('storage/'.$app->cv_path) : null,
                                            'hasGoodBehavior' => !empty($app->good_behavior_path),
                                            'goodBehaviorUrl' => $app->good_behavior_path ? asset('storage/'.$app->good_behavior_path) : null,
                                            'hasKtm' => !empty($app->ktm_path),
                                            'ktmUrl' => $app->ktm_path ? asset('storage/'.$app->ktm_path) : null,
                                        ]) }})"
                                    >
                                        <i class="fas fa-folder-open"></i> Kelola
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            {{-- Empty State --}}
            @if($totalParticipants === 0)
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <h4>Belum Ada Peserta</h4>
                <p>Peserta magang yang diterima akan muncul di sini</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal-overlay" :class="{ 'active': showModal }" @click.self="closeModal()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-user"></i>
                    <span x-text="selectedParticipant?.name || 'Detail Peserta'"></span>
                </div>
                <button class="modal-close" @click="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-body-layout">
                    <div class="modal-top-row">
                        {{-- Informasi Peserta --}}
                        <div class="modal-panel modal-panel-info">
                            <div class="modal-section">
                                <div class="modal-section-title">Informasi Peserta</div>
                                <div class="info-rows">
                                    <div class="info-row">
                                        <div class="info-item">
                                            <span class="info-label">Nama</span>
                                            <span class="info-value" x-text="selectedParticipant?.name || '-'"></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">NIM</span>
                                            <span class="info-value" x-text="selectedParticipant?.nim || '-'"></span>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-item">
                                            <span class="info-label">No. Telepon</span>
                                            <span class="info-value" x-text="selectedParticipant?.phone || '-'"></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Email</span>
                                            <span class="info-value" x-text="selectedParticipant?.email || '-'"></span>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-item">
                                            <span class="info-label">Institusi</span>
                                            <span class="info-value" x-text="selectedParticipant?.university || '-'"></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Jurusan</span>
                                            <span class="info-value" x-text="selectedParticipant?.major || '-'"></span>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-item">
                                            <span class="info-label">Divisi</span>
                                            <span class="info-value" x-text="selectedParticipant?.division || '-'"></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Nama Mentor</span>
                                            <span class="info-value" x-text="selectedParticipant?.currentMentorName || '-'"></span>
                                        </div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-item">
                                            <span class="info-label">Tanggal Mulai</span>
                                            <span class="info-value" x-text="selectedParticipant?.startDate || '-'"></span>
                                        </div>
                                        <div class="info-item">
                                            <span class="info-label">Tanggal Selesai</span>
                                            <span class="info-value" x-text="selectedParticipant?.endDate || '-'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Status Dokumen --}}
                        <div class="modal-panel modal-panel-docs">
                            <div class="modal-section">
                                <div class="modal-section-title">Status Dokumen</div>
                                <div class="doc-grid">
                                    {{-- Surat Penerimaan (diunggah peserta) --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasAcceptance ? 'has-file' : 'no-file'">
                                                <i class="fas fa-file-signature"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Surat Penerimaan</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasAcceptance ? 'Sudah diunggah' : 'Belum diunggah'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasAcceptance">
                                                <a :href="'/storage/' + selectedParticipant?.acceptancePath" target="_blank" rel="noopener" class="action-btn secondary" title="Lihat dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <p class="doc-item-muted-note">File ini diunggah oleh peserta magang.</p>
                                    </div>

                                    {{-- Surat Izin Masuk Lokasi (diunggah peserta) --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasLocationPermission ? 'has-file' : 'no-file'">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Surat Izin Masuk Lokasi</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasLocationPermission ? 'Sudah diunggah' : 'Belum diunggah'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasLocationPermission">
                                                <a :href="'/storage/' + selectedParticipant?.locationPermissionPath" target="_blank" rel="noopener" class="action-btn secondary" title="Lihat dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <p class="doc-item-muted-note">File ini diunggah oleh peserta magang.</p>
                                    </div>

                                    {{-- Pakta Integritas (diunggah peserta) --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasIntegrityPact ? 'has-file' : 'no-file'">
                                                <i class="fas fa-file-contract"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Pakta Integritas</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasIntegrityPact ? 'Sudah diunggah' : 'Belum diunggah'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasIntegrityPact">
                                                <a :href="'/storage/' + selectedParticipant?.integrityPactPath" target="_blank" rel="noopener" class="action-btn secondary" title="Lihat dokumen">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <p class="doc-item-muted-note">File ini diunggah oleh peserta magang.</p>
                                    </div>

                                    {{-- Laporan Penilaian (hanya unduh; unggah dari dashboard mentor) --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasReport ? 'has-file' : 'no-file'">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Laporan Penilaian</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasReport ? 'Sudah diunggah' : 'Belum diunggah'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasReport">
                                                <a :href="'/admin/participants/' + selectedParticipant?.id + '/download-assessment-report'" class="action-btn secondary" title="Unduh">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <p class="doc-item-muted-note">File ini diunggah oleh mentor dari dashboard mentor.</p>
                                    </div>

                                    {{-- Sertifikat --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasCertificate ? 'has-file' : 'no-file'">
                                                <i class="fas fa-certificate"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Sertifikat</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasCertificate ? 'Tersedia' : 'Belum ada'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasCertificate">
                                                <a :href="'/storage/' + selectedParticipant?.certificatePath" target="_blank" class="action-btn secondary" title="Unduh">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <form :action="'/admin/participants/' + selectedParticipant?.userId + '/upload-certificate'" method="POST" enctype="multipart/form-data" class="doc-item-upload-row doc-upload-compact">
                                            @csrf
                                            <label class="doc-upload-pick">
                                                <input type="file" name="certificate" accept=".pdf" class="doc-upload-pick-input" required>
                                                <span class="doc-upload-pick-text"><i class="fas fa-file-pdf"></i> <span class="doc-upload-pick-label" data-doc-upload-label>Pilih PDF</span></span>
                                            </label>
                                            <button type="submit" class="doc-upload-send" title="Unggah" aria-label="Unggah PDF"><i class="fas fa-upload"></i></button>
                                        </form>
                                    </div>

                                    {{-- Surat Selesai --}}
                                    <div class="doc-item doc-item-card">
                                        <div class="doc-item-header">
                                            <div class="doc-item-icon" :class="selectedParticipant?.hasCompletion ? 'has-file' : 'no-file'">
                                                <i class="fas fa-file-circle-check"></i>
                                            </div>
                                            <div class="doc-item-info">
                                                <div class="doc-item-name">Surat Selesai</div>
                                                <div class="doc-item-status" x-text="selectedParticipant?.hasCompletion ? 'Tersedia' : 'Belum ada'"></div>
                                            </div>
                                            <template x-if="selectedParticipant?.hasCompletion">
                                                <a :href="'/storage/' + selectedParticipant?.completionPath" target="_blank" class="action-btn secondary" title="Unduh">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </template>
                                        </div>
                                        <form :action="'/admin/participants/' + selectedParticipant?.id + '/upload-completion-letter'" method="POST" enctype="multipart/form-data" class="doc-item-upload-row doc-upload-compact">
                                            @csrf
                                            <label class="doc-upload-pick">
                                                <input type="file" name="completion_letter" accept=".pdf" class="doc-upload-pick-input" required>
                                                <span class="doc-upload-pick-text"><i class="fas fa-file-pdf"></i> <span class="doc-upload-pick-label" data-doc-upload-label>Pilih PDF</span></span>
                                            </label>
                                            <button type="submit" class="doc-upload-send" title="Unggah" aria-label="Unggah PDF"><i class="fas fa-upload"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Penggantian Mentor --}}
                    <div class="modal-bottom-row" x-show="selectedParticipant?.isAccepted && selectedParticipant?.hasMentor" x-cloak>
                        <div class="modal-section">
                            <div class="modal-section-title">Penggantian Mentor (Satu Divisi)</div>
                            <div class="upload-form">
                                <div class="upload-form-title">
                                    <i class="fas fa-user-tie me-2"></i>
                                    Mentor Saat Ini: <span x-text="selectedParticipant?.currentMentorName || '-'"></span>
                                </div>
                                <form :action="'/admin/participants/' + selectedParticipant?.id + '/change-mentor'" method="POST">
                                    @csrf
                                    <div style="display: grid; gap: 0.75rem;">
                                        <select name="division_mentor_id" class="upload-input" required>
                                            <option value="">-- Pilih Mentor Pengganti --</option>
                                            <template x-for="mentor in (selectedParticipant?.mentorOptions || [])" :key="mentor.id">
                                                <option :value="mentor.id" :selected="mentor.id === selectedParticipant?.currentMentorId" x-text="mentor.name"></option>
                                            </template>
                                        </select>
                                        <textarea
                                            name="transfer_reason"
                                            class="upload-input"
                                            rows="3"
                                            placeholder="Alasan penggantian mentor (opsional)"
                                            style="resize: vertical;"
                                        ></textarea>
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" class="upload-btn">
                                                <i class="fas fa-exchange-alt"></i> Simpan Perubahan Mentor
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kirim Email Kantor Pusat --}}
                <div class="modal-section">
                    <div class="modal-section-title">Kirim Email ke Kantor Pusat</div>
                    <div style="border:1.5px solid rgba(59,130,246,.2);border-radius:14px;overflow:hidden;">

                        {{-- ── Status bar ── --}}
                        <div style="display:flex;align-items:center;gap:.75rem;padding:.875rem 1rem;background:rgba(59,130,246,.04);border-bottom:1px solid rgba(59,130,246,.1);">
                            <div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.85rem;flex-shrink:0;"
                                 :style="selectedParticipant?.hqEmailSent ? 'background:rgba(59,130,246,.12);color:#3b82f6;' : 'background:rgba(156,163,175,.1);color:#9ca3af;'">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:.85rem;font-weight:700;color:#1f2937;"
                                     x-text="selectedParticipant?.hqEmailSent ? 'Email sudah pernah dikirim' : 'Belum dikirim ke kantor pusat'">
                                </div>
                                <div style="font-size:.72rem;color:#6b7280;" x-show="selectedParticipant?.hqEmailSent">
                                    Terakhir: <span x-text="selectedParticipant?.hqEmailSentAt"></span>
                                </div>
                            </div>
                        </div>

                        <div style="padding:.875rem 1rem;">

                            {{-- ── Warning: no HQ email ── --}}
                            <template x-if="!adminHqEmail">
                                <div style="display:flex;align-items:center;gap:.5rem;padding:.625rem .875rem;background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;margin-bottom:.875rem;">
                                    <i class="fas fa-exclamation-triangle" style="color:#d97706;font-size:.8rem;flex-shrink:0;"></i>
                                    <span style="font-size:.8rem;color:#92400e;">Email kantor pusat belum dikonfigurasi.
                                        <a href="{{ route('admin.profile') }}" style="font-weight:700;color:#b45309;text-decoration:underline;">Isi di Profil Admin</a>
                                    </span>
                                </div>
                            </template>

                            <template x-if="adminHqEmail">
                                <div>
                                    {{-- ── Email header preview ── --}}
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:.875rem 1rem;margin-bottom:.75rem;font-size:.8rem;">
                                        <div style="display:grid;grid-template-columns:52px 1fr;gap:.35rem .625rem;line-height:1.4;">
                                            <span style="color:#9ca3af;font-weight:600;text-transform:uppercase;font-size:.67rem;padding-top:.15rem;">Kepada</span>
                                            <span style="color:#1e40af;font-weight:700;" x-text="adminHqEmail"></span>

                                            <span style="color:#9ca3af;font-weight:600;text-transform:uppercase;font-size:.67rem;padding-top:.15rem;">CC</span>
                                            <span style="color:#374151;" x-text="selectedParticipant?.email || '-'"></span>

                                            <span style="color:#9ca3af;font-weight:600;text-transform:uppercase;font-size:.67rem;padding-top:.15rem;">Subjek</span>
                                            <span style="color:#374151;">Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel</span>
                                        </div>

                                        <div style="height:1px;background:#e2e8f0;margin:.625rem 0;"></div>

                                        {{-- Body summary --}}
                                        <div style="color:#6b7280;font-size:.78rem;line-height:1.6;">
                                            <div style="margin-bottom:.3rem;"><em>Dengan hormat, Menindaklanjuti pengajuan mahasiswa PKL…</em></div>
                                            <div><strong style="color:#374151;" x-text="selectedParticipant?.name?.toUpperCase()"></strong>
                                                &nbsp;/ NIM. <span x-text="selectedParticipant?.nim || '-'"></span></div>
                                            <div x-text="(selectedParticipant?.major || '-') + ' — ' + (selectedParticipant?.university || '-')"></div>
                                            <div>Mentor: <strong style="color:#374151;" x-text="selectedParticipant?.currentMentorName?.toUpperCase() || '-'"></strong>
                                                &nbsp;/ NIK. <span x-text="selectedParticipant?.mentorNik || '-'"></span></div>
                                            <div x-text="'Periode: ' + (selectedParticipant?.startDate||'-') + ' s.d. ' + (selectedParticipant?.endDate||'-')"></div>
                                        </div>
                                    </div>

                                    {{-- ── Dokumen — otomatis diunduh ke browser ── --}}
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:.875rem 1rem;margin-bottom:.875rem;">
                                        <div style="font-size:.75rem;font-weight:700;color:#374151;margin-bottom:.5rem;display:flex;align-items:center;gap:.4rem;">
                                            <i class="fas fa-download" style="color:#6b7280;"></i>
                                            Dokumen yang akan diunduh otomatis
                                        </div>
                                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.3rem .5rem;margin-bottom:.625rem;">
                                            <div style="display:flex;align-items:center;gap:.4rem;"
                                                 :style="selectedParticipant?.hasSuratPermohonan ? 'color:#16a34a;' : 'color:#9ca3af;'">
                                                <i :class="selectedParticipant?.hasSuratPermohonan ? 'fas fa-file-pdf' : 'fas fa-times-circle'" style="font-size:.8rem;flex-shrink:0;"></i>
                                                <span style="font-size:.77rem;">Surat Permohonan</span>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:.4rem;"
                                                 :style="selectedParticipant?.hasCv ? 'color:#16a34a;' : 'color:#9ca3af;'">
                                                <i :class="selectedParticipant?.hasCv ? 'fas fa-file-pdf' : 'fas fa-times-circle'" style="font-size:.8rem;flex-shrink:0;"></i>
                                                <span style="font-size:.77rem;">Curriculum Vitae</span>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:.4rem;"
                                                 :style="selectedParticipant?.hasGoodBehavior ? 'color:#16a34a;' : 'color:#9ca3af;'">
                                                <i :class="selectedParticipant?.hasGoodBehavior ? 'fas fa-file-pdf' : 'fas fa-times-circle'" style="font-size:.8rem;flex-shrink:0;"></i>
                                                <span style="font-size:.77rem;">Surat Berperilaku Baik</span>
                                            </div>
                                            <div style="display:flex;align-items:center;gap:.4rem;"
                                                 :style="selectedParticipant?.hasKtm ? 'color:#16a34a;' : 'color:#9ca3af;'">
                                                <i :class="selectedParticipant?.hasKtm ? 'fas fa-file-pdf' : 'fas fa-times-circle'" style="font-size:.8rem;flex-shrink:0;"></i>
                                                <span style="font-size:.77rem;">KTP / KTM</span>
                                            </div>
                                        </div>
                                        <div style="font-size:.72rem;color:#1e40af;background:#eff6ff;border-radius:7px;padding:.45rem .625rem;display:flex;align-items:flex-start;gap:.35rem;">
                                            <i class="fas fa-circle-info" style="flex-shrink:0;margin-top:.1rem;"></i>
                                            <span>Email client terbuka otomatis dan dokumen mulai terunduh. <strong>Drag file dari download bar → ke jendela email → klik Kirim.</strong></span>
                                        </div>
                                    </div>

                                    {{-- ── Success flash ── --}}
                                    <div x-show="hqEmailJustSent" x-cloak
                                         style="display:flex;align-items:flex-start;gap:.5rem;padding:.625rem .875rem;background:#ecfdf5;border:1px solid #6ee7b7;border-radius:8px;margin-bottom:.75rem;">
                                        <i class="fas fa-check-circle" style="color:#059669;font-size:.9rem;flex-shrink:0;margin-top:.1rem;"></i>
                                        <div style="font-size:.8rem;color:#065f46;line-height:1.5;">
                                            Email client sudah terbuka &amp; dokumen sedang diunduh.<br>
                                            <strong>Drag dari download bar → email → Kirim.</strong>
                                        </div>
                                    </div>

                                    {{-- ── Main action button ── --}}
                                    <div style="display:flex;justify-content:flex-end;">
                                        <button
                                            type="button"
                                            class="upload-btn"
                                            style="background:linear-gradient(135deg,#3b82f6 0%,#1d4ed8 100%);gap:.5rem;padding:.6rem 1.25rem;"
                                            @click="sendHqEmail(selectedParticipant)"
                                        >
                                            <i class="fas fa-paper-plane"></i>
                                            <span x-text="selectedParticipant?.hqEmailSent ? 'Kirim Ulang Email' : 'Buka Email &amp; Unduh Lampiran'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>

                        </div>{{-- end padding div --}}
                    </div>{{-- end border card --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function participantsManager() {
    return {
        searchQuery: '',
        statusFilter: '',
        docFilter: '',
        showModal: false,
        selectedParticipant: null,
        visibleCount: 0,
        totalCount: 0,
        adminHqEmail: '',
        hqEmailJustSent: false,

        init() {
            const rows = document.querySelectorAll('.participant-row');
            this.totalCount = rows.length;
            this.visibleCount = rows.length;

            this.$el.addEventListener('change', (e) => {
                const inp = e.target;
                if (!(inp instanceof HTMLInputElement) || !inp.classList.contains('doc-upload-pick-input')) {
                    return;
                }
                const lbl = inp.closest('.doc-upload-pick')?.querySelector('[data-doc-upload-label]');
                if (!lbl) return;
                const file = inp.files?.[0];
                if (!file) { lbl.textContent = 'Pilih PDF'; return; }
                lbl.textContent = file.name.length > 16 ? `${file.name.slice(0, 14)}…` : file.name;
            });
        },

        filterTable() {
            const rows = document.querySelectorAll('.participant-row');
            let visible = 0;
            rows.forEach(row => {
                const name     = row.dataset.name     || '';
                const email    = row.dataset.email    || '';
                const division = row.dataset.division || '';
                const status   = row.dataset.status   || '';
                const doc      = row.dataset.doc      || '';

                const matchesSearch = !this.searchQuery ||
                    name.includes(this.searchQuery.toLowerCase()) ||
                    email.includes(this.searchQuery.toLowerCase()) ||
                    division.includes(this.searchQuery.toLowerCase());
                const matchesStatus = !this.statusFilter || status === this.statusFilter;
                const matchesDoc    = !this.docFilter    || doc === this.docFilter;

                if (matchesSearch && matchesStatus && matchesDoc) {
                    row.style.display = ''; visible++;
                } else {
                    row.style.display = 'none';
                }
            });
            this.visibleCount = visible;
        },

        resetFilters() {
            this.searchQuery = ''; this.statusFilter = ''; this.docFilter = '';
            this.filterTable();
        },

        openModal(participant) {
            this.$el.querySelectorAll('.doc-upload-pick-input').forEach((inp) => {
                inp.value = '';
                const lbl = inp.closest('.doc-upload-pick')?.querySelector('[data-doc-upload-label]');
                if (lbl) lbl.textContent = 'Pilih PDF';
            });
            this.selectedParticipant = participant;
            this.hqEmailJustSent = false;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.showModal = false;
            this.selectedParticipant = null;
            this.hqEmailJustSent = false;
            document.body.style.overflow = '';
        },

        buildMailtoBody(p) {
            return `Dengan hormat,

Menindaklanjuti pengajuan mahasiswa PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel, dengan ini kami ajukan permohonan mahasiswa PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel berlokasi di Kantor Telkom Witel Sulbagsel, Jl. Balaikota No.4, Kec. Ujung Pandang, Makassar, Sulawesi Selatan. Terlampir nama yang kami ajukan sbb:

NO  | PESERTA                                                                          | MENTOR                                    | PERIODE PKL                              | LOKASI PKL
1.  | ${(p.name||'').toUpperCase()} / NIM. ${p.nim||'-'}, ${p.major||'-'}, ${p.university||'-'} | ${(p.currentMentorName||'-').toUpperCase()} / NIK. ${p.mentorNik||'-'} | ${p.startDate||'-'} s.d. ${p.endDate||'-'} | ${p.division||'-'} - Telkom Witel Sulbagsel

Berikut kami lampirkan berkas permohonan mahasiswa berupa :
- Surat Permohonan
- Curriculum Vitae
- Surat Berperilaku Baik dari Kampus
- KTP/KTM

Demikian Surat Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel ini kami sampaikan. Mohon untuk dapat ditindaklanjuti (diijinkan/tidak diijinkan) terkait permohonan PKL yang kami ajukan. Atas perhatian bapak/ibu kami ucapkan terima kasih.

Salam hormat,
Finance & Human Capital SSGS - Telkom Witel Sulbagsel`;
        },

        triggerDownload(url, filename, delayMs) {
            setTimeout(() => {
                const a = document.createElement('a');
                a.href     = url;
                a.download = filename;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }, delayMs);
        },

        async sendHqEmail(p) {
            if (!this.adminHqEmail || !p) return;

            // 1. Open email client via mailto: (To + CC + Subject + Body pre-filled)
            const subject = 'Permohonan PKL di PT. Telkom Indonesia (Persero) Wilayah Sulbagsel';
            const mailto  = `mailto:${encodeURIComponent(this.adminHqEmail)}`
                          + `?cc=${encodeURIComponent(p.email || '')}`
                          + `&subject=${encodeURIComponent(subject)}`
                          + `&body=${encodeURIComponent(this.buildMailtoBody(p))}`;
            window.location.href = mailto;

            // 2. Auto-download each available document one by one (staggered so browser handles them)
            const safeName = (p.name || 'Peserta').replace(/\s+/g, '_');
            let delay = 800; // start after mailto has a moment to fire
            const docs = [
                { has: p.hasSuratPermohonan, url: p.suratPermohonanUrl, name: `Surat_Permohonan_${safeName}.pdf` },
                { has: p.hasCv,              url: p.cvUrl,              name: `Curriculum_Vitae_${safeName}.pdf` },
                { has: p.hasGoodBehavior,    url: p.goodBehaviorUrl,    name: `Surat_Berperilaku_Baik_${safeName}.pdf` },
                { has: p.hasKtm,             url: p.ktmUrl,             name: `KTP_KTM_${safeName}.pdf` },
            ];
            docs.forEach(doc => {
                if (doc.has && doc.url) {
                    this.triggerDownload(doc.url, doc.name, delay);
                    delay += 700; // stagger each download by 700 ms
                }
            });

            // 3. Show success feedback immediately
            this.hqEmailJustSent = true;

            // 4. Record timestamp via AJAX (background, non-blocking)
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
                const res  = await fetch(`/admin/participants/${p.id}/send-headquarters-email`, {
                    method:  'POST',
                    headers: {
                        'X-CSRF-TOKEN':     csrf,
                        'Accept':           'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const data = await res.json();
                if (data.success) {
                    this.selectedParticipant.hqEmailSent   = true;
                    this.selectedParticipant.hqEmailSentAt = data.sent_at;
                    const icon = document.querySelector(`[data-hq-email-icon="${p.id}"]`);
                    if (icon) {
                        icon.className        = 'doc-icon';
                        icon.style.background = 'rgba(59,130,246,.1)';
                        icon.style.color      = '#3b82f6';
                        icon.setAttribute('data-sent', '1');
                        icon.title = 'Email ke pusat sudah dikirim: ' + data.sent_at;
                    }
                }
            } catch (e) {
                // silently ignore — mailto already opened & downloads triggered
            }
        },
    }
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const manager = document.querySelector('[x-data]')?.__x?.$data;
        if (manager?.showModal) {
            manager.closeModal();
        }
    }
});
</script>
@endpush
