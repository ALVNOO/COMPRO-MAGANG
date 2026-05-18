{{--
    MENTOR PENUGASAN & PENILAIAN PAGE
    Assignment and grading management
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Penugasan & Penilaian')

@php
    $role = 'mentor';
    $pageTitle = 'Penugasan & Penilaian';
    $pageSubtitle = 'Kelola tugas dan penilaian peserta magang';

    // Calculate statistics
    $totalParticipants = $participants->count();
    $activeParticipants = $participants->filter(function($p) {
        if ($p->start_date) {
            return \Carbon\Carbon::parse($p->start_date)->lte(now());
        }
        return true;
    })->count();

    $totalTasks = 0;
    $pendingGrading = 0;
    $completedTasks = 0;

    foreach ($participants as $participant) {
        $assignments = $participant->user->assignments ?? collect();
        $totalTasks += $assignments->count();
        $completedTasks += $assignments->whereNotNull('grade')->count();

        foreach ($assignments as $assignment) {
            $hasSubmissions = $assignment->submissions && $assignment->submissions->count() > 0;
            if (($hasSubmissions || $assignment->submission_file_path) && is_null($assignment->grade) && (int) $assignment->is_revision !== 1) {
                $pendingGrading++;
            }
        }
    }
@endphp

@push('styles')
<style>
/* ============================================
   PENUGASAN PAGE STYLES
   ============================================ */

@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

/* Detail Tugas — 2-column grid */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.detail-grid-full {
    grid-column: span 2;
}

.form-label-opt {
    color: #9CA3AF;
    font-weight: 400;
    font-size: .85em;
    margin-left: .25rem;
}

@media (max-width: 640px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    .detail-grid-full {
        grid-column: span 1;
    }
}


/* Tabs Navigation */
.tabs-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    padding: 0.5rem;
    margin-bottom: 2rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tab-btn {
    flex: 1;
    min-width: 150px;
    padding: 0.875rem 1.5rem;
    border: none;
    background: transparent;
    color: #6b7280;
    font-weight: 500;
    font-size: 0.9375rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn:hover {
    background: rgba(238, 46, 36, 0.05);
    color: #1f2937;
}

.tab-btn.active {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.tab-btn .badge-count {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
}

.tab-btn.active .badge-count {
    background: rgba(255, 255, 255, 0.25);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Participants Grid */
.participants-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.25rem;
}

.participant-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.5rem;
    border: 2px solid transparent;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    cursor: pointer;
}

.participant-card:hover {
    border-color: #EE2E24;
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(238, 46, 36, 0.15);
}

.participant-card.not-started {
    opacity: 0.6;
    background: rgba(249, 250, 251, 0.95);
    cursor: not-allowed;
}

.participant-card.not-started:hover {
    border-color: transparent;
    transform: none;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
}

.participant-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.participant-avatar {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    flex-shrink: 0;
    overflow: hidden;
}

.participant-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.participant-info {
    flex: 1;
    min-width: 0;
}

/* WA inline button */
.wa-inline-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: #DCFCE7;
    color: #16A34A;
    font-size: 14px;
    text-decoration: none;
    transition: background .15s;
    vertical-align: middle;
    margin-left: 6px;
    flex-shrink: 0;
}
.wa-inline-btn:hover { background: #BBF7D0; color: #15803D; }

.participant-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 1rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.participant-nim {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.participant-start-date {
    font-size: 0.75rem;
    color: #F59E0B;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.badge-not-started {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #FEF3C7;
    color: #92400E;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    font-weight: 500;
}

.participant-stats-row {
    display: flex;
    gap: 1rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}

.participant-stat {
    flex: 1;
    text-align: center;
}

.participant-stat-value {
    display: block;
    font-size: 1.375rem;
    font-weight: 700;
    color: #EE2E24;
}

.participant-stat-label {
    display: block;
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Detail Peserta Banner */
.participant-detail-banner {
    margin-bottom: 1.25rem;
    padding: 1rem 1.25rem;
    border-radius: 16px;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 70%);
    color: #fff;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 10px 30px rgba(238, 46, 36, 0.25);
}

.participant-detail-banner-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.participant-detail-banner-text {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.participant-detail-banner-title {
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.participant-detail-banner-subtitle {
    font-size: 0.85rem;
    opacity: 0.9;
}

/* Form Card */
.form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.form-section {
    padding: 1.75rem 2rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.form-section:last-child {
    border-bottom: none;
}

.form-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.form-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    color: #EE2E24;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.form-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.form-section-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

/* Participant Selector */
.participant-selector {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1rem;
    max-height: 300px;
    overflow-y: auto;
}

.select-all-option {
    padding: 0.875rem 1rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
    border-radius: 10px;
    margin-bottom: 0.75rem;
    border: 1px solid rgba(238, 46, 36, 0.1);
}

.participant-checkbox {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.participant-checkbox:hover {
    background: rgba(238, 46, 36, 0.03);
}

.participant-checkbox.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: #f9fafb;
}

.participant-checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin-right: 0.875rem;
    cursor: pointer;
    accent-color: #EE2E24;
}

.participant-checkbox input[type="checkbox"]:disabled {
    cursor: not-allowed;
}

.participant-checkbox-label {
    font-size: 0.9375rem;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-label .required {
    color: #EE2E24;
}

.form-control, .form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 0.9375rem;
    line-height: 1.6;
    letter-spacing: 0.01em;
    transition: all 0.2s ease;
    background: white;
    color: #1f2937;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
    line-height: 1.7;
}

/* Buttons */
.btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 2rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* ── Filter bar — Semua Tugas ── */
.st-filter-bar {
    display: flex;
    align-items: flex-end;
    gap: .75rem;
    flex-wrap: wrap;
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid #E5E7EB;
    background: #fff;
}

.st-filter-item {
    display: flex;
    flex-direction: column;
    gap: .3rem;
    flex: 1;
    min-width: 160px;
}

.st-filter-label {
    font-size: .7rem;
    font-weight: 700;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .05em;
}

.st-filter-select {
    padding: .5rem .875rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    font-size: .8rem;
    color: #374151;
    background: #fff;
    cursor: pointer;
    transition: border-color .15s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    padding-right: 2.25rem;
}

.st-filter-select:focus {
    outline: none;
    border-color: #EE2E24;
}

.st-filter-right {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-left: auto;
    padding-bottom: .05rem;
}

/* ── Table — Semua Tugas ── */
.st-table {
    width: 100%;
    border-collapse: collapse;
}

.st-table thead {
    background: #F9FAFB;
    border-bottom: 1px solid #E5E7EB;
}

.st-table th {
    padding: .75rem 1rem;
    font-size: .7rem;
    font-weight: 700;
    color: #9CA3AF;
    text-transform: uppercase;
    letter-spacing: .05em;
    text-align: left;
    white-space: nowrap;
}

.st-table th.center,
.st-table td.center { text-align: center; }

.st-table td {
    padding: .875rem 1rem;
    font-size: .875rem;
    color: #374151;
    border-bottom: 1px solid #F3F4F6;
    vertical-align: middle;
}

.st-table tbody tr:last-child td { border-bottom: none; }
.st-table tbody tr:hover { background: #FAFAFA; }

/* Peserta cell */
.st-p-cell { display: flex; align-items: center; gap: .65rem; }

.st-avatar {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.st-p-name { font-size: .8rem; font-weight: 600; color: #111827; }
.st-p-nim  { font-size: .7rem; color: #9CA3AF; margin-top: .05rem; }

/* Judul + submission info */
.st-title { font-size: .8rem; font-weight: 600; color: #111827; }
.st-sub-info {
    display: flex; align-items: center; gap: .25rem;
    font-size: .7rem; color: #9CA3AF; margin-top: .2rem;
}

/* Deadline */
.st-deadline { font-size: .8rem; color: #374151; }
.st-overdue  {
    display: inline-flex; align-items: center; gap: .25rem;
    font-size: .7rem; color: #DC2626; font-weight: 600; margin-top: .2rem;
}


/* Nilai chip */
.st-nilai {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 42px;
    padding: .25rem .6rem;
    border-radius: 8px;
    font-family: ui-monospace, monospace;
    font-size: .875rem; font-weight: 700;
}
.st-nilai.high   { background: #DCFCE7; color: #15803D; }
.st-nilai.mid    { background: #FEF3C7; color: #B45309; }
.st-nilai.low    { background: #FEE2E2; color: #B91C1C; }
.st-nilai.none   { color: #D1D5DB; }

/* Action inline */
.st-actions { display: flex; align-items: center; gap: .4rem; }

.st-btn-cek {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .38rem .8rem;
    background: #EE2E24;
    color: #fff;
    border: none; border-radius: 7px;
    font-size: .75rem; font-weight: 600;
    cursor: pointer; white-space: nowrap;
    transition: background .15s;
}
.st-btn-cek:hover { background: #C41E1A; }

.st-btn-icon {
    width: 30px; height: 30px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 7px; border: 1.5px solid #E5E7EB;
    background: #fff; cursor: pointer;
    font-size: .75rem; color: #6B7280;
    transition: all .15s;
}
.st-btn-icon:hover { border-color: #EE2E24; color: #EE2E24; }
.st-btn-icon.del:hover { border-color: #DC2626; color: #DC2626; background: #FEF2F2; }


/* Action Buttons */
.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-outline {
    background: white;
    color: #EE2E24;
    border: 1.5px solid #e5e7eb;
}

.btn-outline:hover {
    border-color: #EE2E24;
    background: rgba(238, 46, 36, 0.05);
}

.btn-success {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

/* Grade Input */
.grade-input {
    width: 80px;
    padding: 0.5rem 0.75rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 0.875rem;
    font-weight: 500;
    text-align: center;
}

.grade-input:focus {
    outline: none;
    border-color: #EE2E24;
}

.feedback-input {
    width: 180px;
    padding: 0.5rem 0.75rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 0.875rem;
    letter-spacing: 0.01em;
}

.feedback-input:focus {
    outline: none;
    border-color: #EE2E24;
}

/* Submission Info */
.submission-info {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.deadline-overdue {
    color: #DC2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.grade-display {
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    font-size: 1.1rem;
    font-weight: 700;
    color: #EE2E24;
}

input[type="date"] {
    font-family: 'JetBrains Mono', 'Fira Code', monospace;
    letter-spacing: 0.02em;
}

/* Action Buttons Group */
.action-btns {
    display: flex;
    gap: 0.375rem;
    align-items: center;
}

.btn-delete {
    color: #DC2626 !important;
    border-color: rgba(220, 38, 38, 0.2) !important;
}

.btn-delete:hover {
    background: rgba(220, 38, 38, 0.08) !important;
    border-color: #DC2626 !important;
}

.btn-danger-solid {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-danger-solid:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Custom Popup Overlay */
.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 99999;
    justify-content: center;
    align-items: center;
    padding: 1rem;
    animation: popupFadeIn 0.2s ease;
}

.popup-overlay.active {
    display: flex;
}

@keyframes popupFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popupSlideIn {
    from { opacity: 0; transform: translateY(-20px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.popup-card {
    background: #fff;
    border-radius: 16px;
    width: 100%;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    animation: popupSlideIn 0.25s ease;
}

.popup-card.popup-lg {
    max-width: 700px;
}

.popup-card.popup-sm {
    max-width: 400px;
}

.popup-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.popup-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1), rgba(196, 30, 26, 0.1));
    color: #EE2E24;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.popup-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.popup-subtitle {
    font-size: 0.85rem;
    color: #6b7280;
    margin: 0;
}

.popup-close {
    margin-left: auto;
    align-self: flex-start;
    background: none;
    border: none;
    font-size: 1.25rem;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.25rem;
    line-height: 1;
    border-radius: 6px;
    transition: all 0.15s;
}

.popup-close:hover {
    color: #1f2937;
    background: rgba(0, 0, 0, 0.05);
}

.popup-body {
    padding: 1.5rem;
}

.popup-footer {
    padding: 1rem 1.5rem;
    background: #f9fafb;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 0 0 16px 16px;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.detail-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.detail-label i {
    font-size: 0.7rem;
    color: #9ca3af;
}

.detail-value {
    font-size: 0.9375rem;
    font-weight: 500;
    color: #1f2937;
}

.detail-description {
    margin-bottom: 1.25rem;
}

.detail-desc-content {
    margin-top: 0.5rem;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 10px;
    font-size: 0.9rem;
    color: #374151;
    line-height: 1.7;
    white-space: pre-wrap;
}

.detail-files {
    margin-bottom: 0.5rem;
}

.detail-files-list {
    margin-top: 0.5rem;
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Delete Modal */
.delete-icon-wrap {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: rgba(220, 38, 38, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #DC2626;
}

@media (max-width: 576px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }

    .action-btns {
        flex-direction: column;
    }
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6b7280;
}

.empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.1) 0%, rgba(196, 30, 26, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #EE2E24;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.9375rem;
    color: #6b7280;
    margin: 0;
}

/* ── Stacked Action Cell ────────────────────────── */
.action-cell {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    min-width: 112px;
}

.btn-cek-tugas {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    white-space: nowrap;
}

.btn-cek-tugas:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.action-sub-row {
    display: flex;
    gap: 0.25rem;
}

.action-sub-row .btn-action {
    flex: 1;
    justify-content: center;
}

/* ── Cek Tugas Popup ──────────────────────────────── */
.cek-popup-wrap {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 680px;
    max-height: 90vh;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.04);
    animation: popupSlideIn 0.25s ease;
    display: flex;
    flex-direction: column;
}

/* ── Header ── */
.cek-popup-header {
    background: #fff;
    border-top: 4px solid #EE2E24;
    border-bottom: 1px solid #f3f4f6;
    padding: 1.125rem 1.375rem 1rem;
    flex-shrink: 0;
}

.cek-popup-top-row {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.cek-popup-icon {
    width: 38px;
    height: 38px;
    background: rgba(238,46,36,0.08);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    color: #EE2E24;
    flex-shrink: 0;
    margin-top: 1px;
}

.cek-popup-title {
    flex: 1;
    font-size: 0.9375rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.35;
    color: #111827;
    min-width: 0;
}

.cek-close-btn {
    width: 28px;
    height: 28px;
    background: #f3f4f6;
    border: none;
    color: #6b7280;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}

.cek-close-btn:hover { background: #e5e7eb; color: #111827; }

.cek-popup-meta-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-left: calc(38px + 0.75rem);
    flex-wrap: wrap;
}

.cek-popup-peserta {
    font-size: 0.8rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 0.3rem;
    margin: 0;
}

/* ── Info chips strip ── */
.cek-info-chips {
    display: flex;
    border-bottom: 1px solid #f3f4f6;
    background: #f9fafb;
    flex-shrink: 0;
}

.cek-chip {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    padding: 0.75rem 1.125rem;
    border-right: 1px solid #f3f4f6;
}

.cek-chip:last-child { border-right: none; }

.cek-chip-label {
    font-size: 0.625rem;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.cek-chip-label i { font-size: 0.6rem; color: #d1d5db; }

.cek-chip-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: #111827;
    line-height: 1.2;
}

.cek-grade-value {
    font-size: 1.05rem;
    color: #059669;
    font-family: 'JetBrains Mono', monospace;
}

/* ── Scrollable body ── */
.cek-popup-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.125rem;
    min-height: 0;
    background: #f4f6f8;
    display: flex;
    flex-direction: column;
    gap: 0.625rem;
}

/* Section card */
.cek-section {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
}

.cek-section-header {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 0.875rem;
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.65rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.cek-section-header i { color: #EE2E24; font-size: 0.65rem; }

.cek-section-body {
    padding: 0.75rem 0.875rem;
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.cek-desc-content {
    font-size: 0.875rem;
    color: #374151;
    line-height: 1.7;
    white-space: pre-wrap;
    max-height: 110px;
    overflow-y: auto;
    margin: 0;
}

/* File rows */
.cek-file-mentor {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    background: rgba(59,130,246,0.04);
    border: 1px solid rgba(59,130,246,0.12);
    border-radius: 8px;
}

.cek-file-submission {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    border: 1px solid #f0f0f0;
    border-radius: 8px;
    background: #fafafa;
    transition: border-color 0.12s, background 0.12s;
}

.cek-file-submission:hover { border-color: #e5e7eb; background: #f3f4f6; }

.cek-file-submission-info {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.cek-file-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.15rem 0.5rem;
    border-radius: 5px;
}

.cek-file-tag-mentor  { background: rgba(59,130,246,0.08); color: #2563EB; }
.cek-file-tag-original{ background: rgba(16,185,129,0.08); color: #059669; }
.cek-file-tag-revision{ background: rgba(245,158,11,0.08); color: #D97706; }

.cek-file-submission-time {
    font-size: 0.7rem;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.cek-file-download {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.7rem;
    border-radius: 7px;
    font-size: 0.75rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
    background: #fff;
    color: #374151;
    border: 1.5px solid #e5e7eb;
}

.cek-file-download:hover { border-color: #9ca3af; color: #111827; }

.cek-file-download-original { background: rgba(16,185,129,0.05); color: #059669; border-color: rgba(16,185,129,0.2); }
.cek-file-download-original:hover { background: rgba(16,185,129,0.1); color: #047857; border-color: #059669; }

.cek-file-download-revision { background: rgba(245,158,11,0.05); color: #D97706; border-color: rgba(245,158,11,0.2); }
.cek-file-download-revision:hover { background: rgba(245,158,11,0.1); color: #B45309; border-color: #D97706; }

.cek-no-submission {
    padding: 1.25rem;
    text-align: center;
    color: #9ca3af;
    font-size: 0.84rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    flex-direction: column;
}

.cek-no-submission i { font-size: 1.5rem; color: #d1d5db; }

.cek-feedback-box {
    font-size: 0.875rem;
    color: #374151;
    line-height: 1.65;
    padding-left: 0.75rem;
    border-left: 3px solid #EE2E24;
}

/* ── Footer ── */
.cek-popup-footer {
    border-top: 1px solid #f3f4f6;
    padding: 0.875rem 1.375rem;
    background: #fff;
    border-radius: 0 0 20px 20px;
    flex-shrink: 0;
}

.cek-action-hint {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-bottom: 0.625rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.cek-action-buttons {
    display: flex;
    gap: 0.625rem;
}

.btn-cek-revisi {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.625rem 1.25rem;
    background: #FFFBEB;
    color: #B45309;
    border: 1.5px solid #FDE68A;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cek-revisi:hover {
    background: #FEF3C7;
    border-color: #F59E0B;
    transform: translateY(-1px);
}

.btn-cek-nilai {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.625rem 1.25rem;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    border: 1.5px solid transparent;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(16,185,129,0.22);
}

.btn-cek-nilai:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(16,185,129,0.35);
}

.cek-form-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.375rem;
    display: block;
}

.cek-nilai-row {
    display: flex;
    gap: 0.75rem;
    align-items: flex-end;
}

.cek-form-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    margin-top: 0.625rem;
}

.btn-cek-revisi-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.825rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 6px rgba(245,158,11,0.2);
}
.btn-cek-revisi-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245,158,11,0.35); }

.btn-cek-nilai-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.825rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 6px rgba(16,185,129,0.2);
}
.btn-cek-nilai-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16,185,129,0.35); }

.cek-graded-notice {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: rgba(16,185,129,0.05);
    border: 1px solid rgba(16,185,129,0.15);
    border-radius: 10px;
    color: #059669;
    font-size: 0.875rem;
    font-weight: 500;
}


/* Form Actions */
.form-actions {
    padding: 1.5rem 2rem;
    background: #f9fafb;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

/* Loading State */
.btn-loading {
    display: none;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 2px;
}

/* Responsive */
@media (max-width: 1024px) {
    .tabs-card {
        flex-direction: column;
    }

    .tab-btn {
        min-width: 100%;
    }
}

@media (max-width: 768px) {
    .mentor-hero {
        padding: 1.5rem;
    }

    .hero-text h1 {
        font-size: 1.5rem;
    }

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .participants-grid {
        grid-template-columns: 1fr;
    }

    .form-section {
        padding: 1.25rem;
    }

    .filter-bar {
        flex-direction: column;
    }

    .filter-group {
        min-width: 100%;
    }

    .data-table {
        display: block;
        overflow-x: auto;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-submit {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Penugasan & Penilaian"
    description="Kelola tugas dan berikan penilaian untuk peserta magang di divisi Anda"
    icon="fas fa-tasks"
    role="pembimbing"
/>

@if($participants->isEmpty())
    {{-- Empty State --}}
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>Belum Ada Peserta</h3>
        <p>Belum ada peserta magang yang diterima di divisi Anda.</p>
    </div>
@else
    {{-- Statistics Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $activeParticipants }}</div>
                    <div class="stat-label">Peserta Aktif</div>
                </div>
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-info">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $totalTasks }}</div>
                    <div class="stat-label">Total Tugas</div>
                </div>
                <div class="stat-icon stat-icon-info">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-warning">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $pendingGrading }}</div>
                    <div class="stat-label">Menunggu Dinilai</div>
                </div>
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="stat-card stat-card-success">
            <div class="stat-card-header">
                <div class="stat-meta">
                    <div class="stat-value">{{ $completedTasks }}</div>
                    <div class="stat-label">Sudah Dinilai</div>
                </div>
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="tabs-card">
        <button class="tab-btn active" data-tab="overview" onclick="switchTab('overview', this)">
            <i class="fas fa-th-large"></i> Overview Peserta
        </button>
        <button class="tab-btn" data-tab="create" onclick="switchTab('create', this)">
            <i class="fas fa-plus-circle"></i> Buat Tugas Baru
        </button>
        <button class="tab-btn" data-tab="tasks" onclick="switchTab('tasks', this)">
            <i class="fas fa-list"></i> Semua Tugas
            <span class="badge-count">{{ $totalTasks }}</span>
            @if($pendingGrading > 0)
                <span class="badge-count" style="background: rgba(245,158,11,0.25); color: #D97706;">{{ $pendingGrading }} menunggu</span>
            @endif
        </button>
    </div>

    {{-- Tab: Overview Peserta --}}
    <div id="tab-overview" class="tab-content active">
        <div class="participant-detail-banner">
            <div class="participant-detail-banner-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="participant-detail-banner-text">
                <div class="participant-detail-banner-title">Detail Peserta</div>
                <div class="participant-detail-banner-subtitle">
                    Pilih salah satu peserta untuk melihat tugas dan status penilaiannya.
                </div>
            </div>
        </div>
        <div class="participants-grid">
            @foreach($participants as $participant)
                @php
                    $totalTugas = $participant->user->assignments->count();
                    $tugasSelesai = $participant->user->assignments->where('grade', '!=', null)->count();
                    $rataRata = $participant->user->assignments->whereNotNull('grade')->avg('grade');

                    $hasStarted = true;
                    if ($participant->start_date) {
                        $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                    }
                @endphp
                <div class="participant-card {{ !$hasStarted ? 'not-started' : '' }}"
                     @if($hasStarted) onclick="viewParticipantDetail({{ $participant->user->id }})" @endif>
                    <div class="participant-header">
                        <div class="participant-avatar">
                            @if($participant->user->profile_picture)
                                <img src="{{ asset('storage/' . $participant->user->profile_picture) }}" alt="{{ $participant->user->name }}">
                            @else
                                {{ strtoupper(substr($participant->user->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="participant-info">
                            <h3 class="participant-name">
                                {{ $participant->user->name ?? '-' }}
                                @if(!$hasStarted)
                                    <span class="badge-not-started">
                                        <i class="fas fa-clock"></i> Belum Mulai
                                    </span>
                                @endif
                                @if($participant->user->phone)
                                    @php
                                        $pWaNum  = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $participant->user->phone));
                                        $pWaText = urlencode('Halo ' . $participant->user->name . ', saya ingin menghubungi Anda terkait kegiatan magang.');
                                    @endphp
                                    <a href="https://wa.me/{{ $pWaNum }}?text={{ $pWaText }}"
                                       target="_blank" rel="noopener"
                                       class="wa-inline-btn" title="WhatsApp"
                                       onclick="event.stopPropagation()">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                            </h3>
                            <p class="participant-nim">{{ $participant->user->nim ?? '-' }}</p>
                            @if(!$hasStarted && $participant->start_date)
                                <p class="participant-start-date">
                                    <i class="fas fa-calendar"></i>
                                    Mulai: {{ \Carbon\Carbon::parse($participant->start_date)->format('d M Y') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="participant-stats-row">
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $totalTugas }}</span>
                            <span class="participant-stat-label">Tugas</span>
                        </div>
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $tugasSelesai }}</span>
                            <span class="participant-stat-label">Selesai</span>
                        </div>
                        <div class="participant-stat">
                            <span class="participant-stat-value">{{ $rataRata ? number_format($rataRata, 0) : '-' }}</span>
                            <span class="participant-stat-label">Rata-rata</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Tab: Buat Tugas Baru --}}
    <div id="tab-create" class="tab-content">
        <div class="form-card">
            <form method="POST" action="{{ route('mentor.penugasan.tambah') }}" enctype="multipart/form-data" id="createTaskForm">
                @csrf

                {{-- Section 1: Pilih Peserta --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="form-section-title">1. Pilih Peserta</h3>
                            <p class="form-section-subtitle">Tentukan peserta yang akan menerima tugas</p>
                        </div>
                    </div>
                    <div class="participant-selector">
                        <div class="select-all-option">
                            <label class="participant-checkbox">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                                <span class="participant-checkbox-label">
                                    <strong>Pilih Semua Peserta</strong>
                                    <span style="color: #6b7280; font-size: 0.8rem;">(yang sudah mulai)</span>
                                </span>
                            </label>
                        </div>
                        @foreach($participants as $participant)
                            @php
                                $hasStarted = true;
                                if ($participant->start_date) {
                                    $hasStarted = \Carbon\Carbon::parse($participant->start_date)->lte(now());
                                }
                            @endphp
                            <label class="participant-checkbox {{ !$hasStarted ? 'disabled' : '' }}">
                                <input type="checkbox"
                                       name="user_ids[]"
                                       value="{{ $participant->user->id }}"
                                       class="participant-check"
                                       {{ !$hasStarted ? 'disabled' : '' }}>
                                <span class="participant-checkbox-label">
                                    {{ $participant->user->name ?? '-' }} ({{ $participant->user->nim ?? '-' }})
                                    @if(!$hasStarted)
                                        <span class="badge-not-started">
                                            <i class="fas fa-clock"></i>
                                            Belum Mulai
                                            @if($participant->start_date)
                                                - {{ \Carbon\Carbon::parse($participant->start_date)->format('d M') }}
                                            @endif
                                        </span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Section 2: Detail Tugas --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <div>
                            <h3 class="form-section-title">2. Detail Tugas</h3>
                            <p class="form-section-subtitle">Isi informasi detail tugas yang akan diberikan</p>
                        </div>
                    </div>

                    <div class="detail-grid">
                        {{-- Row 1: Jenis Tugas | Judul Tugas --}}
                        <div class="form-group">
                            <label class="form-label">Jenis Tugas <span class="required">*</span></label>
                            <select name="assignment_type" class="form-select" id="assignmentType" required>
                                <option value="">Pilih Jenis Tugas</option>
                                <option value="tugas_harian">Tugas Harian</option>
                                <option value="tugas_proyek">Tugas Proyek</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Judul Tugas <span class="required">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Masukkan judul tugas..." required>
                        </div>

                        {{-- Row 2: Deadline | File Tugas --}}
                        <div class="form-group">
                            <label class="form-label">Deadline <span class="required">*</span></label>
                            <input type="date" name="deadline" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">File Tugas <span class="form-label-opt">(Opsional)</span></label>
                            <input type="file" name="file_path" class="form-control">
                        </div>

                        {{-- Row 3: Tanggal Presentasi (full width, conditional) --}}
                        <div class="detail-grid-full" id="presentationDateGroup" style="display: none;">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Tanggal Presentasi</label>
                                <input type="date" name="presentation_date" class="form-control" id="presentationDate">
                            </div>
                        </div>

                        {{-- Row 4: Deskripsi (full width) --}}
                        <div class="detail-grid-full">
                            <div class="form-group" style="margin-bottom:0;">
                                <label class="form-label">Deskripsi Tugas</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail tugas, instruksi pengerjaan, atau kriteria penilaian..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-actions">
                    <button type="submit" class="btn-submit" id="submitTaskBtn">
                        <span class="btn-text">
                            <i class="fas fa-paper-plane"></i> Buat Tugas
                        </span>
                        <span class="btn-loading">
                            <span class="spinner-border spinner-border-sm me-2"></span> Membuat tugas...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tab: Semua Tugas --}}
    <div id="tab-tasks" class="tab-content">
        @php
            $totalTugasCount = $participants->sum(fn($p) => $p->user->assignments->count());
        @endphp
        <div class="table-card">

            {{-- Header --}}
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-list-check"></i>
                    <span>Daftar Semua Tugas</span>
                </div>
                <span class="badge badge-gray">{{ $totalTugasCount }} Tugas</span>
            </div>

            {{-- Filter bar --}}
            <div class="st-filter-bar">
                <div class="st-filter-item">
                    <span class="st-filter-label">Peserta</span>
                    <select id="filterPeserta" onchange="filterTasks()" class="st-filter-select">
                        <option value="">Semua Peserta</option>
                        @foreach($participants as $participant)
                            <option value="{{ $participant->user->id }}">{{ $participant->user->name ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="st-filter-item">
                    <span class="st-filter-label">Jenis</span>
                    <select id="filterJenis" onchange="filterTasks()" class="st-filter-select">
                        <option value="">Semua Jenis</option>
                        <option value="tugas_harian">Tugas Harian</option>
                        <option value="tugas_proyek">Tugas Proyek</option>
                    </select>
                </div>
                <div class="st-filter-item">
                    <span class="st-filter-label">Status</span>
                    <select id="filterStatus" onchange="filterTasks()" class="st-filter-select">
                        <option value="">Semua Status</option>
                        <option value="belum_dikerjakan">Belum Dikerjakan</option>
                        <option value="sudah_submit">Sudah Submit</option>
                        <option value="sudah_dinilai">Sudah Dinilai</option>
                        <option value="revisi">Revisi</option>
                    </select>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="st-table">
                    <thead>
                        <tr>
                            <th style="width:44px;" class="center">No</th>
                            <th style="min-width:160px;">Peserta</th>
                            <th>Judul Tugas</th>
                            <th style="width:100px;" class="center">Jenis</th>
                            <th style="width:110px;" class="center">Deadline</th>
                            <th style="width:130px;" class="center">Status</th>
                            <th style="width:70px;" class="center">Nilai</th>
                            <th style="width:130px;" class="center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        @php $no = 1; @endphp
                        @foreach($participants as $participant)
                            @php
                                $nameParts = explode(' ', $participant->user->name ?? 'U');
                                $initials = strtoupper(substr($nameParts[0], 0, 1))
                                          . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '');
                            @endphp
                            @foreach($participant->user->assignments as $assignment)
                                @php
                                    $hasSubmissions   = $assignment->submissions && $assignment->submissions->count() > 0;
                                    $latestSubmission = $hasSubmissions ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;

                                    $status = 'belum_dikerjakan';
                                    if ((int) $assignment->is_revision === 1) {
                                        $status = 'revisi';
                                    } elseif ($assignment->grade !== null) {
                                        $status = 'sudah_dinilai';
                                    } elseif ($hasSubmissions || $assignment->submission_file_path) {
                                        $status = 'sudah_submit';
                                    }

                                    $grade = $assignment->grade;
                                    $nilaiClass = 'none';
                                    if ($grade !== null) {
                                        $nilaiClass = $grade >= 80 ? 'high' : ($grade >= 60 ? 'mid' : 'low');
                                    }
                                @endphp
                                <tr class="task-row"
                                    data-peserta="{{ $participant->user->id }}"
                                    data-jenis="{{ $assignment->assignment_type }}"
                                    data-status="{{ $status }}">

                                    {{-- No --}}
                                    <td class="center" style="color:#9CA3AF;font-size:.8rem;">{{ $no++ }}</td>

                                    {{-- Peserta --}}
                                    <td>
                                        <div class="st-p-cell">
                                            <div class="st-avatar">{{ $initials }}</div>
                                            <div>
                                                <div class="st-p-name">{{ $participant->user->name ?? '-' }}</div>
                                                <div class="st-p-nim">{{ $participant->user->nim ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Judul --}}
                                    <td>
                                        <div class="st-title">{{ $assignment->title ?? '-' }}</div>
                                        @if($hasSubmissions)
                                            <div class="st-sub-info">
                                                <i class="fas fa-upload"></i>
                                                {{ $latestSubmission->submitted_at ? \Carbon\Carbon::parse($latestSubmission->submitted_at)->format('d/m/Y H:i') : '' }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Jenis --}}
                                    <td class="center">
                                        @if($assignment->assignment_type === 'tugas_harian')
                                            <span class="badge badge-info"><i class="fas fa-calendar-day"></i> Harian</span>
                                        @else
                                            <span class="badge badge-warning"><i class="fas fa-diagram-project"></i> Proyek</span>
                                        @endif
                                    </td>

                                    {{-- Deadline --}}
                                    <td class="center">
                                        <div class="st-deadline">
                                            {{ $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d/m/Y') : '—' }}
                                        </div>
                                        @if($assignment->deadline)
                                            @php
                                                $dl = \Carbon\Carbon::parse($assignment->deadline);
                                                $isOverdue = $dl->lt(now()) && $status === 'belum_dikerjakan';
                                            @endphp
                                            @if($isOverdue)
                                                <div class="st-overdue">
                                                    <i class="fas fa-circle-exclamation"></i> Terlambat
                                                </div>
                                            @endif
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="center">
                                        @if($status === 'revisi')
                                            <span class="status-badge status-revision_required"><i class="fas fa-rotate-left"></i> Revisi</span>
                                        @elseif($status === 'sudah_dinilai')
                                            <span class="status-badge status-graded"><i class="fas fa-check"></i> Dinilai</span>
                                        @elseif($status === 'sudah_submit')
                                            <span class="status-badge status-submitted"><i class="fas fa-clock"></i> Menunggu</span>
                                        @else
                                            <span class="status-badge status-none"><i class="fas fa-minus"></i> Belum</span>
                                        @endif
                                    </td>

                                    {{-- Nilai --}}
                                    <td class="center">
                                        @if($grade !== null)
                                            <span class="st-nilai {{ $nilaiClass }}">{{ $grade }}</span>
                                        @else
                                            <span class="st-nilai none">—</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="center">
                                        <div class="st-actions" style="justify-content:center;">
                                            <button class="st-btn-cek" onclick="viewTaskDetail({{ $assignment->id }})">
                                                <i class="fas fa-folder-open"></i> Cek
                                            </button>
                                            <button class="st-btn-icon" title="Edit" onclick="editTask({{ $assignment->id }})">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="st-btn-icon del" title="Hapus" onclick="confirmDeleteTask({{ $assignment->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endif

@endsection

@push('scripts')
{{-- Modals must be outside @section('content') to avoid stacking context issues --}}

{{-- Modal Detail Participant --}}
<div class="modal fade" id="participantDetailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" style="position: absolute; top: 1rem; right: 1rem; z-index: 10;"></button>
            <div class="modal-body" id="participantDetailContent">
                {{-- Content will be loaded here --}}
            </div>
        </div>
    </div>
</div>

{{-- Popup: Cek Tugas --}}
<div class="popup-overlay" id="taskDetailPopup">
    <div class="cek-popup-wrap">

        {{-- Header: row 1 = icon + title + close; row 2 = peserta + badge --}}
        <div class="cek-popup-header">
            <div class="cek-popup-top-row">
                <div class="cek-popup-icon"><i class="fas fa-folder-open"></i></div>
                <h5 class="cek-popup-title" id="cekTaskTitle">Cek Tugas</h5>
                <button class="cek-close-btn" onclick="closePopup('taskDetailPopup')">&times;</button>
            </div>
            <div class="cek-popup-meta-row">
                <span class="cek-popup-peserta">
                    <i class="fas fa-user-graduate" style="color:#EE2E24; font-size:.65rem;"></i>
                    <span id="cekTaskPeserta"></span>
                </span>
                <span id="cekStatusBadge"></span>
            </div>
        </div>

        {{-- Info chips strip --}}
        <div class="cek-info-chips">
            <div class="cek-chip">
                <span class="cek-chip-label"><i class="fas fa-tag"></i> Jenis</span>
                <span class="cek-chip-value" id="cekType">-</span>
            </div>
            <div class="cek-chip">
                <span class="cek-chip-label"><i class="fas fa-calendar-alt"></i> Deadline</span>
                <span class="cek-chip-value" id="cekDeadline">-</span>
            </div>
            <div class="cek-chip" id="cekGradeChip" style="display:none;">
                <span class="cek-chip-label"><i class="fas fa-star"></i> Nilai</span>
                <span class="cek-chip-value cek-grade-value" id="cekGrade">-</span>
            </div>
            <div class="cek-chip" id="cekPresentationChip" style="display:none;">
                <span class="cek-chip-label"><i class="fas fa-chalkboard"></i> Presentasi</span>
                <span class="cek-chip-value" id="cekPresentation">-</span>
            </div>
        </div>

        {{-- Scrollable body — card sections --}}
        <div class="cek-popup-body">

            {{-- Deskripsi card --}}
            <div class="cek-section">
                <div class="cek-section-header">
                    <i class="fas fa-align-left"></i> Deskripsi Tugas
                </div>
                <div class="cek-section-body">
                    <p class="cek-desc-content" id="cekDescription">-</p>
                </div>
            </div>

            {{-- File & Pengumpulan card --}}
            <div class="cek-section" id="cekFilesSection">
                <div class="cek-section-header">
                    <i class="fas fa-paperclip"></i> File &amp; Pengumpulan
                </div>
                <div class="cek-section-body">
                    {{-- Mentor file --}}
                    <div class="cek-file-mentor" id="cekMentorFile" style="display:none;">
                        <div class="cek-file-tag cek-file-tag-mentor">
                            <i class="fas fa-file-alt"></i> File dari Mentor
                        </div>
                        <a id="cekMentorFileLink" href="#" target="_blank" class="cek-file-download">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                    {{-- Student submissions (JS-populated) --}}
                    <div id="cekSubmissionsList"></div>
                    {{-- Empty state --}}
                    <div class="cek-no-submission" id="cekNoSubmission" style="display:none;">
                        <i class="fas fa-inbox"></i>
                        <span>Belum ada pengumpulan dari peserta</span>
                    </div>
                </div>
            </div>

            {{-- Feedback card --}}
            <div class="cek-section" id="cekExistingFeedbackSection" style="display:none;">
                <div class="cek-section-header">
                    <i class="fas fa-comment-alt"></i> Feedback Sebelumnya
                </div>
                <div class="cek-section-body">
                    <p class="cek-feedback-box" id="cekExistingFeedback"></p>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="cek-popup-footer">

            {{-- Default: choose action --}}
            <div id="cekDefaultActions" style="display:none;">
                <div class="cek-action-hint">
                    <i class="fas fa-circle-info"></i> Tinjau pengumpulan lalu pilih tindakan
                </div>
                <div class="cek-action-buttons">
                    <button class="btn-cek-revisi" onclick="showCekRevisiForm()">
                        <i class="fas fa-rotate-left"></i> Kirim Revisi
                    </button>
                    <button class="btn-cek-nilai" onclick="showCekNilaiForm()">
                        <i class="fas fa-check-circle"></i> Beri Penilaian
                    </button>
                </div>
            </div>

            {{-- Revision form --}}
            <div id="cekRevisiFormContainer" style="display:none;">
                <form method="POST" id="cekRevisiForm" action="#">
                    @csrf
                    <input type="hidden" name="is_revision" value="1">
                    <label class="cek-form-label">
                        <i class="fas fa-rotate-left" style="color:#D97706;"></i> Catatan Revisi
                        <span style="color:#9ca3af; font-weight:400;"> — opsional</span>
                    </label>
                    <textarea name="feedback" class="form-control" rows="2"
                        placeholder="Tuliskan catatan revisi untuk peserta..."
                        id="cekRevisiTextarea" style="min-height:64px; font-size:.875rem; resize:vertical;"></textarea>
                    <div class="cek-form-actions">
                        <button type="button" class="btn-action btn-outline btn-sm" onclick="cancelCekForm()">
                            Batal
                        </button>
                        <button type="submit" class="btn-cek-revisi-submit">
                            <i class="fas fa-paper-plane"></i> Kirim Revisi
                        </button>
                    </div>
                </form>
            </div>

            {{-- Grading form --}}
            <div id="cekNilaiFormContainer" style="display:none;">
                <form method="POST" id="cekNilaiForm" action="#">
                    @csrf
                    <div class="cek-nilai-row">
                        <div style="width:115px; flex-shrink:0;">
                            <label class="cek-form-label">Nilai (0–100) <span class="required">*</span></label>
                            <input type="number" name="grade" class="form-control" min="0" max="100" required
                                placeholder="85" id="cekNilaiInput"
                                style="text-align:center; font-weight:700; font-family:'JetBrains Mono',monospace; font-size:.9rem;">
                        </div>
                        <div style="flex:1;">
                            <label class="cek-form-label">
                                Feedback
                                <span style="color:#9ca3af; font-weight:400;">(opsional)</span>
                            </label>
                            <input type="text" name="feedback" class="form-control"
                                placeholder="Catatan atau komentar untuk peserta..."
                                id="cekNilaiFeedback" style="font-size:.875rem;">
                        </div>
                    </div>
                    <div class="cek-form-actions">
                        <button type="button" class="btn-action btn-outline btn-sm" onclick="cancelCekForm()">
                            Batal
                        </button>
                        <button type="submit" class="btn-cek-nilai-submit">
                            <i class="fas fa-save"></i> Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>

            {{-- Already graded --}}
            <div id="cekGradedNotice" style="display:none;">
                <div class="cek-graded-notice">
                    <i class="fas fa-check-circle"></i> Tugas ini sudah dinilai
                </div>
            </div>

            {{-- Waiting for submission --}}
            <div id="cekWaitingNotice" style="display:none;">
                <div class="cek-graded-notice" style="background:rgba(107,114,128,0.05); border-color:rgba(107,114,128,0.15); color:#6b7280;">
                    <i class="fas fa-clock"></i> Menunggu pengumpulan dari peserta
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Popup Edit Task --}}
<div class="popup-overlay" id="editTaskPopup">
    <div class="popup-card popup-lg">
        <div class="popup-header">
            <div class="popup-header-icon" style="background: linear-gradient(135deg, rgba(59,130,246,0.15), rgba(37,99,235,0.15)); color: #2563EB;">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h5 class="popup-title">Edit Tugas</h5>
                <p class="popup-subtitle">Perbarui detail tugas</p>
            </div>
            <button type="button" class="popup-close" onclick="closePopup('editTaskPopup')">&times;</button>
        </div>
        <form method="POST" id="editTaskForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="popup-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Tugas <span class="required">*</span></label>
                            <select name="assignment_type" class="form-select" id="editAssignmentType" required>
                                <option value="tugas_harian">Tugas Harian</option>
                                <option value="tugas_proyek">Tugas Proyek</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Judul Tugas <span class="required">*</span></label>
                            <input type="text" name="title" class="form-control" id="editTitle" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Deadline <span class="required">*</span></label>
                            <input type="date" name="deadline" class="form-control" id="editDeadline" required>
                        </div>
                    </div>
                    <div class="col-md-6" id="editPresentationDateGroup" style="display: none;">
                        <div class="form-group">
                            <label class="form-label">Tanggal Presentasi</label>
                            <input type="date" name="presentation_date" class="form-control" id="editPresentationDate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Ganti File Tugas <span style="color: #6b7280; font-weight: 400;">(Opsional)</span></label>
                            <input type="file" name="file_path" class="form-control">
                            <div id="editCurrentFile" style="margin-top: 0.5rem; font-size: 0.8rem; color: #6b7280;"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Deskripsi Tugas</label>
                            <textarea name="description" class="form-control" id="editDescription" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-footer" style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" class="btn-action btn-outline" onclick="closePopup('editTaskPopup')">Batal</button>
                <button type="submit" class="btn-submit" id="editSubmitBtn">
                    <span class="btn-text"><i class="fas fa-save"></i> Simpan Perubahan</span>
                    <span class="btn-loading"><span class="spinner-border spinner-border-sm me-2"></span> Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Popup Confirm Delete --}}
<div class="popup-overlay" id="deleteTaskPopup">
    <div class="popup-card popup-sm">
        <div class="popup-body" style="padding: 2rem; text-align: center;">
            <div class="delete-icon-wrap">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h5 style="font-weight: 600; margin-bottom: 0.5rem;">Hapus Tugas?</h5>
            <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem;">
                Tugas "<span id="deleteTaskTitle"></span>" akan dihapus permanen beserta submission-nya.
            </p>
            <form method="POST" id="deleteTaskForm">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 0.75rem; justify-content: center;">
                    <button type="button" class="btn-action btn-outline" onclick="closePopup('deleteTaskPopup')">Batal</button>
                    <button type="submit" class="btn-action btn-danger-solid">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Popup open/close helpers
function openPopup(popupId) {
    var el = document.getElementById(popupId);
    if (el) {
        el.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closePopup(popupId) {
    var el = document.getElementById(popupId);
    if (el) {
        el.classList.remove('active');
        // Only restore scroll if no other popups are open
        if (!document.querySelector('.popup-overlay.active')) {
            document.body.style.overflow = '';
        }
    }
}

// Close popup when clicking overlay background
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('popup-overlay') && e.target.classList.contains('active')) {
        closePopup(e.target.id);
    }
});

// Close popup on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var activePopup = document.querySelector('.popup-overlay.active');
        if (activePopup) {
            closePopup(activePopup.id);
        }
    }
});

// Assignment data store (safe JSON, no inline JS escaping issues)
var taskDataStore = @php
    $store = [];
    foreach ($participants as $participant) {
        foreach ($participant->user->assignments as $assignment) {
            $hasSub = $assignment->submissions && $assignment->submissions->count() > 0;
            $latestSub = $hasSub ? $assignment->submissions->sortByDesc('submitted_at')->first() : null;
            $st = 'belum_dikerjakan';
            if ((int) $assignment->is_revision === 1) { $st = 'revisi'; }
            elseif ($assignment->grade !== null) { $st = 'sudah_dinilai'; }
            elseif ($hasSub || $assignment->submission_file_path) { $st = 'sudah_submit'; }

            $store[$assignment->id] = [
                'title' => $assignment->title ?? '-',
                'peserta' => $participant->user->name ?? '-',
                'type' => $assignment->assignment_type === 'tugas_harian' ? 'Tugas Harian' : 'Tugas Proyek',
                'deadline' => $assignment->deadline ? \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') : '-',
                'presentationDate' => $assignment->presentation_date ? \Carbon\Carbon::parse($assignment->presentation_date)->format('d M Y') : '',
                'description' => $assignment->description ?? 'Tidak ada deskripsi',
                'status' => $st,
                'grade' => $assignment->grade ?? '',
                'feedback' => $assignment->feedback ?? '',
                'filePath' => $assignment->file_path ? asset('storage/' . $assignment->file_path) : '',
                'submissionPath' => $hasSub && $latestSub && $latestSub->file_path ? asset('storage/' . $latestSub->file_path) : ($assignment->submission_file_path ? asset('storage/' . $assignment->submission_file_path) : ''),
                'submittedAt' => $hasSub && $latestSub && $latestSub->submitted_at ? \Carbon\Carbon::parse($latestSub->submitted_at)->format('d M Y H:i') : '',
                'nilaiUrl' => route('mentor.penugasan.nilai', $assignment->id),
                'revisiUrl' => route('mentor.penugasan.revisi', $assignment->id),
                'submissions' => $hasSub ? $assignment->submissions->sortBy('submitted_at')->map(function($sub, $index) {
                    return [
                        'file_path' => $sub->file_path ? asset('storage/' . $sub->file_path) : '',
                        'submitted_at' => $sub->submitted_at ? \Carbon\Carbon::parse($sub->submitted_at)->format('d M Y H:i') : '',
                    ];
                })->values()->all() : [],
            ];
        }
    }
    echo json_encode($store);
@endphp;

// Tab switching
function switchTab(tabName, sourceBtn = null) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });

    // Remove active from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Show selected tab
    var targetTab = document.getElementById('tab-' + tabName);
    if (targetTab) {
        targetTab.classList.add('active');
    }

    // Activate the correct button
    if (sourceBtn) {
        sourceBtn.classList.add('active');
    } else {
        var autoBtn = document.querySelector('.tab-btn[data-tab=\"' + tabName + '\"]');
        if (autoBtn) {
            autoBtn.classList.add('active');
        }
    }
}

// Aktifkan tab Semua Tugas otomatis setelah set revisi
document.addEventListener('DOMContentLoaded', function() {
    @if(session('revision_set_assignment_id'))
        switchTab('tasks');
    @endif
});

// Select all participants (only enabled ones)
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.participant-check:not(:disabled)');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
}

// Show/hide presentation date based on task type
document.getElementById('assignmentType')?.addEventListener('change', function() {
    const presentationGroup = document.getElementById('presentationDateGroup');
    const presentationDate = document.getElementById('presentationDate');

    if (this.value === 'tugas_proyek') {
        presentationGroup.style.display = 'block';
    } else {
        presentationGroup.style.display = 'none';
        presentationDate.value = '';
    }
});

// Filter tasks
function filterTasks() {
    const filterPeserta = document.getElementById('filterPeserta').value;
    const filterJenis = document.getElementById('filterJenis').value;
    const filterStatus = document.getElementById('filterStatus').value;

    const rows = document.querySelectorAll('.task-row');

    rows.forEach(row => {
        let show = true;

        if (filterPeserta && row.dataset.peserta !== filterPeserta) {
            show = false;
        }

        if (filterJenis && row.dataset.jenis !== filterJenis) {
            show = false;
        }

        if (filterStatus && row.dataset.status !== filterStatus) {
            show = false;
        }

        row.style.display = show ? '' : 'none';
    });
}

// View participant detail
function viewParticipantDetail(userId) {
    // Switch to "Semua Tugas" tab and filter by this participant
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    document.getElementById('tab-tasks').classList.add('active');
    document.querySelectorAll('.tab-btn')[2].classList.add('active');

    // Filter by participant
    const filterPeserta = document.getElementById('filterPeserta');
    if (filterPeserta) {
        filterPeserta.value = userId;
        filterTasks();
    }
}

// Form validation and loading state
const createTaskForm = document.getElementById('createTaskForm');
const submitTaskBtn = document.getElementById('submitTaskBtn');

if (createTaskForm && submitTaskBtn) {
    let formSubmitted = false;

    createTaskForm.addEventListener('submit', function(e) {
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }

        // Validate participant selection
        const checkedBoxes = document.querySelectorAll('.participant-check:checked');
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Pilih minimal satu peserta untuk ditugaskan!');
            return false;
        }

        // Show loading state
        const btnText = submitTaskBtn.querySelector('.btn-text');
        const btnLoading = submitTaskBtn.querySelector('.btn-loading');

        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            submitTaskBtn.disabled = true;
        }

        formSubmitted = true;
        return true;
    });
}

// Current assignment ID being viewed in Cek Tugas popup
var cekCurrentAssignmentId = null;

// Cek Tugas popup
function viewTaskDetail(assignmentId) {
    var data = taskDataStore[assignmentId];
    if (!data) { alert('Data tugas tidak ditemukan.'); return; }

    cekCurrentAssignmentId = assignmentId;

    // Title & peserta
    document.getElementById('cekTaskTitle').textContent = data.title;
    document.getElementById('cekTaskPeserta').textContent = data.peserta;

    // Status badge
    var statusMap = {
        'belum_dikerjakan': '<span class="badge badge-info"><i class="fas fa-hourglass-half"></i> Belum Dikerjakan</span>',
        'sudah_submit':     '<span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Nilai</span>',
        'sudah_dinilai':    '<span class="badge badge-success"><i class="fas fa-check"></i> Dinilai</span>',
        'revisi':           '<span class="badge badge-danger"><i class="fas fa-redo"></i> Revisi</span>'
    };
    document.getElementById('cekStatusBadge').innerHTML = statusMap[data.status] || data.status;

    // Info chips
    document.getElementById('cekType').textContent = data.type;
    document.getElementById('cekDeadline').textContent = data.deadline;

    var gradeChip = document.getElementById('cekGradeChip');
    if (data.grade !== '' && data.grade !== null && data.grade !== undefined) {
        gradeChip.style.display = '';
        document.getElementById('cekGrade').textContent = data.grade;
    } else {
        gradeChip.style.display = 'none';
    }

    var presChip = document.getElementById('cekPresentationChip');
    if (data.presentationDate) {
        presChip.style.display = '';
        document.getElementById('cekPresentation').textContent = data.presentationDate;
    } else {
        presChip.style.display = 'none';
    }

    // Description
    document.getElementById('cekDescription').textContent = data.description || 'Tidak ada deskripsi.';

    // Files — mentor file
    var mentorFileEl  = document.getElementById('cekMentorFile');
    var mentorLinkEl  = document.getElementById('cekMentorFileLink');
    if (data.filePath) {
        mentorFileEl.style.display = '';
        mentorLinkEl.href = data.filePath;
    } else {
        mentorFileEl.style.display = 'none';
    }

    // Files — student submissions
    var subListEl  = document.getElementById('cekSubmissionsList');
    var noSubEl    = document.getElementById('cekNoSubmission');
    subListEl.innerHTML = '';

    var hasSubmissions = false;
    if (Array.isArray(data.submissions) && data.submissions.length > 0) {
        hasSubmissions = true;
        noSubEl.style.display = 'none';
        data.submissions.forEach(function(sub, index) {
            var isFirst  = index === 0;
            var label    = isFirst ? 'Pengumpulan Pertama' : 'Revisi ' + index;
            var tagClass = isFirst ? 'cek-file-tag-original' : 'cek-file-tag-revision';
            var dlClass  = isFirst ? 'cek-file-download-original' : 'cek-file-download-revision';
            var icon     = isFirst ? 'fa-upload' : 'fa-redo';
            var html = '<div class="cek-file-submission">'
                + '<div class="cek-file-submission-info">'
                + '<span class="cek-file-tag ' + tagClass + '"><i class="fas ' + icon + '"></i> ' + label + '</span>'
                + (sub.submitted_at ? '<span class="cek-file-submission-time"><i class="fas fa-clock"></i> ' + sub.submitted_at + '</span>' : '')
                + '</div>'
                + (sub.file_path ? '<a href="' + sub.file_path + '" target="_blank" class="cek-file-download ' + dlClass + '"><i class="fas fa-download"></i> Download</a>' : '')
                + '</div>';
            subListEl.innerHTML += html;
        });
    } else if (data.submissionPath) {
        hasSubmissions = true;
        noSubEl.style.display = 'none';
        var html = '<div class="cek-file-submission">'
            + '<div class="cek-file-submission-info">'
            + '<span class="cek-file-tag cek-file-tag-original"><i class="fas fa-upload"></i> Pengumpulan Pertama</span>'
            + (data.submittedAt ? '<span class="cek-file-submission-time"><i class="fas fa-clock"></i> ' + data.submittedAt + '</span>' : '')
            + '</div>'
            + '<a href="' + data.submissionPath + '" target="_blank" class="cek-file-download cek-file-download-original"><i class="fas fa-download"></i> Download</a>'
            + '</div>';
        subListEl.innerHTML = html;
    } else {
        noSubEl.style.display = '';
    }

    // Existing feedback
    var feedbackSection = document.getElementById('cekExistingFeedbackSection');
    if (data.feedback) {
        feedbackSection.style.display = '';
        document.getElementById('cekExistingFeedback').textContent = data.feedback;
    } else {
        feedbackSection.style.display = 'none';
    }

    // Footer logic
    var isGraded    = data.status === 'sudah_dinilai';
    var canAct      = hasSubmissions && !isGraded;

    document.getElementById('cekDefaultActions').style.display         = canAct   ? '' : 'none';
    document.getElementById('cekRevisiFormContainer').style.display    = 'none';
    document.getElementById('cekNilaiFormContainer').style.display     = 'none';
    document.getElementById('cekGradedNotice').style.display           = (isGraded && !canAct) ? '' : 'none';
    document.getElementById('cekWaitingNotice').style.display          = (!hasSubmissions && !isGraded) ? '' : 'none';

    // Set form URLs
    if (data.revisiUrl) document.getElementById('cekRevisiForm').action = data.revisiUrl;
    if (data.nilaiUrl)  document.getElementById('cekNilaiForm').action  = data.nilaiUrl;

    // Reset form fields
    document.getElementById('cekRevisiTextarea').value = '';
    document.getElementById('cekNilaiInput').value     = '';
    document.getElementById('cekNilaiFeedback').value  = '';

    openPopup('taskDetailPopup');
}

function showCekRevisiForm() {
    document.getElementById('cekDefaultActions').style.display      = 'none';
    document.getElementById('cekRevisiFormContainer').style.display = '';
    document.getElementById('cekNilaiFormContainer').style.display  = 'none';
    document.getElementById('cekRevisiTextarea').focus();
}

function showCekNilaiForm() {
    document.getElementById('cekDefaultActions').style.display      = 'none';
    document.getElementById('cekRevisiFormContainer').style.display = 'none';
    document.getElementById('cekNilaiFormContainer').style.display  = '';
    document.getElementById('cekNilaiInput').focus();
}

function cancelCekForm() {
    var data = cekCurrentAssignmentId ? taskDataStore[cekCurrentAssignmentId] : null;
    var hasSubmissions = data && ((Array.isArray(data.submissions) && data.submissions.length > 0) || !!data.submissionPath);
    var isGraded = data && data.status === 'sudah_dinilai';
    var canAct   = hasSubmissions && !isGraded;

    document.getElementById('cekDefaultActions').style.display      = canAct ? '' : 'none';
    document.getElementById('cekRevisiFormContainer').style.display = 'none';
    document.getElementById('cekNilaiFormContainer').style.display  = 'none';
}

// Edit task
function editTask(assignmentId) {
    fetch('/mentor/penugasan/' + assignmentId + '/edit', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            const data = result.data;
            document.getElementById('editTaskForm').action = '/mentor/penugasan/' + assignmentId + '/update';
            document.getElementById('editTitle').value = data.title || '';
            document.getElementById('editAssignmentType').value = data.assignment_type || 'tugas_harian';
            document.getElementById('editDeadline').value = data.deadline || '';
            document.getElementById('editDescription').value = data.description || '';

            // Presentation date
            const presGroup = document.getElementById('editPresentationDateGroup');
            const presInput = document.getElementById('editPresentationDate');
            if (data.assignment_type === 'tugas_proyek') {
                presGroup.style.display = 'block';
                presInput.value = data.presentation_date || '';
            } else {
                presGroup.style.display = 'none';
                presInput.value = '';
            }

            // Current file indicator
            const currentFile = document.getElementById('editCurrentFile');
            if (data.file_path) {
                currentFile.innerHTML = '<i class="fas fa-paperclip"></i> File saat ini: <a href="/storage/' + data.file_path + '" target="_blank">Lihat file</a>';
            } else {
                currentFile.innerHTML = '';
            }

            openPopup('editTaskPopup');
        }
    })
    .catch(error => {
        alert('Gagal memuat data tugas. Silakan coba lagi.');
    });
}

// Toggle presentation date in edit modal
document.getElementById('editAssignmentType')?.addEventListener('change', function() {
    const presGroup = document.getElementById('editPresentationDateGroup');
    const presInput = document.getElementById('editPresentationDate');
    if (this.value === 'tugas_proyek') {
        presGroup.style.display = 'block';
    } else {
        presGroup.style.display = 'none';
        presInput.value = '';
    }
});

// Edit form submit with loading
const editTaskForm = document.getElementById('editTaskForm');
if (editTaskForm) {
    let editSubmitted = false;
    editTaskForm.addEventListener('submit', function(e) {
        if (editSubmitted) { e.preventDefault(); return false; }
        const btn = document.getElementById('editSubmitBtn');
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');
        if (btnText && btnLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            btn.disabled = true;
        }
        editSubmitted = true;
    });
}

// Confirm delete task (lookup title from data store)
function confirmDeleteTask(assignmentId) {
    var data = taskDataStore[assignmentId];
    document.getElementById('deleteTaskTitle').textContent = data ? data.title : 'tugas ini';
    document.getElementById('deleteTaskForm').action = '/mentor/penugasan/' + assignmentId + '/delete';
    openPopup('deleteTaskPopup');
}
</script>
@endpush
