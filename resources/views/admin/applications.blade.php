{{--
    ADMIN APPLICATIONS PAGE
    Manage internship applications with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Pengajuan Magang')

@php
    $role = 'admin';
    $pageTitle = 'Pengajuan Magang';
    $pageSubtitle = 'Kelola pengajuan magang dari peserta';

    // Count stats
    $totalCount = $applications->count();
    $pendingCount = $applications->where('status', 'pending')->count();
    $acceptedCount = $applications->where('status', 'accepted')->count();
    $rejectedCount = $applications->where('status', 'rejected')->count();
@endphp

@push('styles')
<style>
/* ============================================
   APPLICATIONS PAGE STYLES
   ============================================ */

/* Hero Section */
.admin-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
}

.admin-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.hero-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.hero-text p {
    font-size: 1rem;
    opacity: 0.9;
    max-width: 500px;
    margin: 0;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
}

.hero-badge-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.25);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.hero-badge-text h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.2;
}

.hero-badge-text p {
    font-size: 0.75rem;
    margin: 0;
    opacity: 0.85;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
}

/* Filter Bar */
.filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1.25rem;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.filter-input {
    flex: 1;
    min-width: 200px;
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.filter-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.filter-select {
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    min-width: 150px;
    background: white;
    cursor: pointer;
}

.filter-select:focus {
    outline: none;
    border-color: #EE2E24;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

/* Table Card */
.table-card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.table-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--color-gray-100, #f3f4f6);
}

.table-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
}

.table-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
}

.table-count {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 400;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: #f9fafb;
    padding: 0.875rem 1rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.admin-table td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.875rem;
    color: #374151;
}

.admin-table tbody tr:hover {
    background: #f9fafb;
}

.admin-table tbody tr:last-child td {
    border-bottom: none;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.status-badge.accepted {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.status-badge.rejected {
    background: rgba(217, 119, 6, 0.1);
    color: #D97706;
}

.status-badge.finished {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

/* Action Buttons */
.action-btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    transition: all 0.2s;
    border: none;
}

.action-btn.review {
    background: linear-gradient(135deg, #3B82F6, #60A5FA);
    color: white;
}

.action-btn.review:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.action-btn.approve {
    background: linear-gradient(135deg, #10B981, #34D399);
    color: white;
}

.action-btn.approve:hover {
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.action-btn.reject {
    background: linear-gradient(135deg, #EF4444, #F87171);
    color: white;
}

.action-btn.reject:hover {
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #9ca3af;
    font-size: 2rem;
}

.empty-text {
    font-size: 1rem;
    color: #6b7280;
    margin: 0;
}

/* ============================================
   REDESIGNED MODAL — NO-SCROLL TWO-PANEL LAYOUT
   ============================================ */

/* Modal Overlay */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(6px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

/* Modal Shell — wide, fixed height, NO overflow */
.modal-content {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 860px;
    height: min(92vh, 640px);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transform: translateY(24px) scale(0.97);
    transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 32px 80px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0,0,0,0.06);
}

.modal-overlay.show .modal-content {
    transform: translateY(0) scale(1);
}

/* Modal Header — slim accent bar */
.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.875rem 1.25rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    flex-shrink: 0;
}

.modal-header h3 {
    font-size: 0.95rem;
    font-weight: 700;
    color: white;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    letter-spacing: 0.01em;
}

.modal-header h3 i {
    opacity: 0.85;
    font-size: 0.85rem;
}

.modal-close {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: none;
    background: rgba(255,255,255,0.18);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    transition: background 0.15s;
    flex-shrink: 0;
}

.modal-close:hover {
    background: rgba(255,255,255,0.30);
}

/* Modal Body — two-panel flex, fills remaining height */
.modal-body {
    display: flex;
    flex: 1;
    overflow: hidden;
    min-height: 0;
}

/* LEFT PANEL — applicant profile + details */
.modal-panel-left {
    width: 52%;
    padding: 1.125rem 1.25rem;
    border-right: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
    overflow: hidden;
    flex-shrink: 0;
}

/* RIGHT PANEL — actions / status */
.modal-panel-right {
    flex: 1;
    padding: 1.125rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
    overflow: hidden;
    min-width: 0;
}

/* Applicant Identity Row */
.applicant-identity {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding-bottom: 0.875rem;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
}

.applicant-avatar {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid #f1f5f9;
}

.applicant-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.applicant-avatar .placeholder-icon {
    font-size: 1.75rem;
    color: #94a3b8;
}

.applicant-name-block h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 0.3rem 0;
    line-height: 1.2;
}

.applicant-name-block .badge-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.35rem;
}

/* Compact Info List */
.detail-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    flex-shrink: 0;
}

.detail-item {
    background: #f8fafc;
    border-radius: 9px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #f1f5f9;
}

.detail-item .di-label {
    font-size: 0.68rem;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    display: block;
    margin-bottom: 0.15rem;
}

.detail-item .di-value {
    font-size: 0.82rem;
    color: #1e293b;
    font-weight: 500;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Period Strip */
.period-strip {
    display: flex;
    align-items: center;
    gap: 0;
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-radius: 10px;
    border: 1px solid #bbf7d0;
    flex-shrink: 0;
    overflow: hidden;
}

.ps-date-block {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.5rem 0.625rem;
    gap: 0.1rem;
}

.ps-date-block .ps-label {
    font-size: 0.6rem;
    font-weight: 700;
    color: #4ade80;
    text-transform: uppercase;
    letter-spacing: 0.07em;
}

.ps-date-block .ps-date {
    font-size: 0.78rem;
    font-weight: 700;
    color: #14532d;
    white-space: nowrap;
}

.ps-arrow {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    flex-shrink: 0;
    color: #4ade80;
    font-size: 0.7rem;
}

.ps-divider {
    width: 1px;
    height: 32px;
    background: #bbf7d0;
    flex-shrink: 0;
}


/* Duration Label */
.duration-label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    font-size: 0.72rem;
    font-weight: 700;
    color: #4ade80;
    letter-spacing: 0.04em;
    margin-top: -0.25rem;
    flex-shrink: 0;
}

.duration-label i { font-size: 0.65rem; }

/* Documents Row */
.docs-section {
    flex-shrink: 0;
}

.docs-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.docs-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
}

.doc-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.65rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 7px;
    font-size: 0.76rem;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.15s;
}

.doc-chip:hover {
    border-color: #EE2E24;
    color: #EE2E24;
    background: #fff5f5;
    transform: translateY(-1px);
}

.doc-chip i {
    font-size: 0.7rem;
    color: #EE2E24;
}

/* ── RIGHT PANEL CONTENTS ── */

/* Action Tabs */
.action-tabs {
    display: flex;
    gap: 0.375rem;
    background: #f8fafc;
    border-radius: 10px;
    padding: 0.25rem;
    flex-shrink: 0;
    border: 1px solid #f1f5f9;
}

.action-tab {
    flex: 1;
    padding: 0.5rem;
    border: none;
    border-radius: 7px;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    background: transparent;
    color: #64748b;
    transition: all 0.18s;
}

.action-tab.active-approve {
    background: white;
    color: #059669;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.action-tab.active-revisi {
    background: white;
    color: #d97706;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.action-tab.active-reject {
    background: white;
    color: #dc2626;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.action-tab:hover:not(.active-approve):not(.active-revisi):not(.active-reject) {
    background: rgba(255,255,255,0.6);
    color: #475569;
}

/* Panel Revisi */
.panel-revisi {
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    height: 100%;
    box-sizing: border-box;
}

.panel-revisi .form-field select,
.panel-revisi .form-field textarea {
    border-color: #fcd34d;
}

.panel-revisi .form-field select:focus,
.panel-revisi .form-field textarea:focus {
    border-color: #d97706;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
}

/* Permanently rejected status badge */
.status-badge.permanently_rejected {
    background: rgba(127, 29, 29, 0.1);
    color: #7f1d1d;
}

/* Tolak total btn */
.btn-permanent-reject {
    width: 100%;
    padding: 0.65rem;
    background: linear-gradient(135deg, #7f1d1d, #991b1b);
    border: none;
    border-radius: 9px;
    font-size: 0.85rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    flex-shrink: 0;
    letter-spacing: 0.01em;
}

.btn-permanent-reject:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(127, 29, 29, 0.4);
}

/* Revisi btn */
.btn-revisi {
    width: 100%;
    padding: 0.65rem;
    background: linear-gradient(135deg, #D97706, #B45309);
    border: none;
    border-radius: 9px;
    font-size: 0.85rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    flex-shrink: 0;
    letter-spacing: 0.01em;
}

.btn-revisi:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(217, 119, 6, 0.35);
}

/* Tab Panels */
.tab-panels {
    flex: 1;
    min-height: 0;
    position: relative;
}

.tab-panel {
    position: absolute;
    inset: 0;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.18s ease;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tab-panel.visible {
    opacity: 1;
    pointer-events: auto;
}

/* Panel inner forms */
.panel-approve {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    height: 100%;
    box-sizing: border-box;
}

.panel-reject {
    background: #fff5f5;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    height: 100%;
    box-sizing: border-box;
}

.form-field label {
    display: block;
    font-size: 0.76rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 0.35rem;
}

.form-field select,
.form-field textarea {
    width: 100%;
    padding: 0.6rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.84rem;
    background: white;
    box-sizing: border-box;
    transition: border-color 0.15s, box-shadow 0.15s;
}

.form-field select:focus {
    outline: none;
    border-color: #10B981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-field textarea {
    resize: none;
    flex: 1;
    min-height: 0;
}

.form-field textarea:focus {
    outline: none;
    border-color: #EF4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Info-only right panel (accepted/rejected/finished) */
.status-info-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
}

.status-info-panel .si-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
}

.status-info-panel .si-icon.accepted  { background: #d1fae5; color: #059669; }
.status-info-panel .si-icon.rejected  { background: #fee2e2; color: #dc2626; }
.status-info-panel .si-icon.finished  { background: #dbeafe; color: #2563eb; }

.status-info-panel .si-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.rejection-note {
    background: #fff1f2;
    border: 1px solid #fecaca;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    font-size: 0.84rem;
    color: #7f1d1d;
    line-height: 1.5;
    width: 100%;
    text-align: left;
    box-sizing: border-box;
}

/* Submit Buttons */
.btn-approve {
    width: 100%;
    padding: 0.65rem;
    background: linear-gradient(135deg, #10B981, #059669);
    border: none;
    border-radius: 9px;
    font-size: 0.85rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    flex-shrink: 0;
    letter-spacing: 0.01em;
}

.btn-approve:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
}

.btn-reject {
    width: 100%;
    padding: 0.65rem;
    background: linear-gradient(135deg, #EF4444, #DC2626);
    border: none;
    border-radius: 9px;
    font-size: 0.85rem;
    font-weight: 700;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s;
    flex-shrink: 0;
    letter-spacing: 0.01em;
}

.btn-reject:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
}

/* Status Badge unchanged */

/* Responsive — stack on small screens */
@media (max-width: 680px) {
    .modal-content { height: min(96vh, 700px); }
    .modal-body { flex-direction: column; overflow-y: auto; }
    .modal-panel-left { width: 100%; border-right: none; border-bottom: 1px solid #f1f5f9; }
    .modal-panel-right { flex: none; }
    .tab-panels { height: 320px; position: relative; }
}

/* Responsive Hero */
@media (max-width: 768px) {
    .hero-content {
        flex-direction: column;
        text-align: center;
    }
    .hero-text h1 {
        justify-content: center;
        font-size: 1.5rem;
    }
}

/* Responsive Table */
@media (max-width: 768px) {
    .admin-table {
        display: block;
        overflow-x: auto;
    }
}
</style>
@endpush

@section('content')
{{-- Hero Section --}}
<div class="admin-hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>
                <i class="fas fa-inbox"></i>
                Pengajuan Magang
            </h1>
            <p>Review dan kelola pengajuan magang dari peserta</p>
        </div>
        @if($pendingCount > 0)
        <div class="hero-badge">
            <div class="hero-badge-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="hero-badge-text">
                <h4>{{ $pendingCount }}</h4>
                <p>Menunggu Review</p>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    @include('components.dashboard.stat-card', [
        'value' => $totalCount,
        'label' => 'Total Pengajuan',
        'icon' => 'fa-file-alt',
        'color' => 'primary',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $pendingCount,
        'label' => 'Menunggu Review',
        'icon' => 'fa-clock',
        'color' => 'warning',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $acceptedCount,
        'label' => 'Diterima',
        'icon' => 'fa-check-circle',
        'color' => 'success',
        'link' => '#'
    ])

    @include('components.dashboard.stat-card', [
        'value' => $rejectedCount,
        'label' => 'Ditolak',
        'icon' => 'fa-times-circle',
        'color' => 'danger',
        'link' => '#'
    ])
</div>

{{-- Filter Bar --}}
<div class="filter-bar" x-data="{ search: '', status: '' }">
    <input type="text"
           x-model="search"
           placeholder="Cari nama, NIM, atau institusi..."
           class="filter-input"
           @input="filterTable()">
    <select x-model="status" class="filter-select" @change="filterTable()">
        <option value="">Semua Status</option>
        <option value="pending">Pending</option>
        <option value="accepted">Diterima</option>
        <option value="rejected">Revisi</option>
        <option value="permanently_rejected">Ditolak Permanen</option>
        <option value="finished">Selesai</option>
    </select>
    <button type="button" class="filter-btn" @click="filterTable()">
        <i class="fas fa-search"></i> Cari
    </button>
</div>

{{-- Applications Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <div class="table-title-icon">
                <i class="fas fa-list"></i>
            </div>
            <span>Daftar Pengajuan <span class="table-count">({{ $totalCount }} data)</span></span>
        </div>
    </div>

    @if($applications->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="empty-text">Belum ada pengajuan magang</p>
        </div>
    @else
        <table class="admin-table" id="applicationsTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Institusi</th>
                    <th>Bidang Peminatan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $index => $app)
                <tr data-name="{{ strtolower($app->user->name ?? '') }}"
                    data-nim="{{ strtolower($app->user->nim ?? '') }}"
                    data-institution="{{ strtolower($app->user->university ?? '') }}"
                    data-status="{{ $app->status }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $app->user->name ?? '-' }}</strong>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $app->user->nim ?? '-' }}</div>
                        @if($app->user && $app->user->internshipApplications()->where('status', 'rejected')->exists())
                            <span style="display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; padding: 2px 8px; background: rgba(245, 158, 11, 0.1); color: #D97706; font-size: 0.7rem; font-weight: 600; border-radius: 6px;">
                                <i class="fas fa-redo" style="font-size: 0.6rem;"></i> Pendaftar Ulang
                            </span>
                        @endif
                    </td>
                    <td>{{ Str::limit($app->user->university ?? '-', 25) }}</td>
                    <td>{{ $app->fieldOfInterest->name ?? '-' }}</td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="status-badge {{ $app->status }}">
                            @if($app->status === 'pending')
                                <i class="fas fa-clock"></i> Pending
                            @elseif($app->status === 'accepted')
                                <i class="fas fa-check"></i> Diterima
                            @elseif($app->status === 'rejected')
                                <i class="fas fa-redo"></i> Revisi
                            @elseif($app->status === 'permanently_rejected')
                                <i class="fas fa-ban"></i> Ditolak Permanen
                            @elseif($app->status === 'finished')
                                <i class="fas fa-check-double"></i> Selesai
                            @else
                                {{ ucfirst($app->status) }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <button type="button"
                                class="action-btn review"
                                onclick="openDetailModal({{ $app->id }})"
                                title="Lihat Detail">
                            <i class="fas fa-eye"></i> Review
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- Detail Modal --}}
<div class="modal-overlay" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-user"></i> <span id="modalTitle">Detail Pengajuan</span></h3>
            <button type="button" class="modal-close" onclick="closeDetailModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
            {{-- Content will be loaded dynamically --}}
        </div>
    </div>
</div>

{{-- Hidden data for JavaScript --}}
@php
$applicationsJson = $applications->map(function($app) {
    return [
        'id' => $app->id,
        'status' => $app->status,
        'notes' => $app->notes,
        'user' => [
            'name' => $app->user->name ?? '-',
            'nim' => $app->user->nim ?? '-',
            'university' => $app->user->university ?? '-',
            'major' => $app->user->major ?? '-',
            'phone' => $app->user->phone ?? '-',
            'ktp_number' => $app->user->ktp_number ?? '-',
            'profile_picture' => $app->user->profile_picture ? asset('storage/' . $app->user->profile_picture) : null,
            'is_reapplicant' => $app->user->internshipApplications()->where('status', 'rejected')->exists(),
        ],
        'field' => $app->fieldOfInterest->name ?? '-',
        'start_date' => $app->start_date ? \Carbon\Carbon::parse($app->start_date)->format('d M Y') : '-',
        'end_date' => $app->end_date ? \Carbon\Carbon::parse($app->end_date)->format('d M Y') : '-',
        'duration_label' => (function() use ($app) {
            if (!$app->start_date || !$app->end_date) return '-';
            $start  = \Carbon\Carbon::parse($app->start_date);
            $end    = \Carbon\Carbon::parse($app->end_date);
            $months = (int) $start->diffInMonths($end);
            $days   = $start->copy()->addMonths($months)->diffInDays($end);
            $parts  = [];
            if ($months > 0) $parts[] = "{$months} Bulan";
            if ($days   > 0) $parts[] = "{$days} Hari";
            return implode(' ', $parts) ?: '0 Hari';
        })(),
        'documents' => [
            'ktm' => $app->ktm_path ? asset('storage/' . $app->ktm_path) : null,
            'cv' => $app->cv_path ? asset('storage/' . $app->cv_path) : null,
            'surat' => $app->surat_permohonan_path ? asset('storage/' . $app->surat_permohonan_path) : null,
            'skck' => $app->good_behavior_path ? asset('storage/' . $app->good_behavior_path) : null,
        ],
        'approve_url' => route('admin.applications.approve', $app->id),
        'reject_url' => route('admin.applications.reject', $app->id),
        'permanent_reject_url' => route('admin.applications.permanent-reject', $app->id),
    ];
})->keyBy('id');

$divisionsJson = $divisions->map(function($div) {
    return [
        'id' => $div->id,
        'name' => $div->division_name,
        'mentors' => $div->mentors->map(function($mentor) {
            return ['id' => $mentor->id, 'name' => $mentor->mentor_name];
        })
    ];
});
@endphp

<script>
const applicationsData = @json($applicationsJson);
const divisions = @json($divisionsJson);
const csrfToken = '{{ csrf_token() }}';
</script>
@endsection

@push('scripts')
<script>
// Filter functionality
function filterTable() {
    const searchInput = document.querySelector('.filter-input');
    const statusSelect = document.querySelector('.filter-select');
    const rows = document.querySelectorAll('#applicationsTable tbody tr');

    const search = searchInput.value.toLowerCase();
    const status = statusSelect.value;

    rows.forEach(row => {
        const name = row.dataset.name || '';
        const nim = row.dataset.nim || '';
        const institution = row.dataset.institution || '';
        const rowStatus = row.dataset.status || '';

        const matchesSearch = name.includes(search) || nim.includes(search) || institution.includes(search);
        const matchesStatus = !status || rowStatus === status;

        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

// Modal functionality — two-panel no-scroll layout
function openDetailModal(appId) {
    const app = applicationsData[appId];
    if (!app) return;

    const modal = document.getElementById('detailModal');
    const modalBody = document.getElementById('modalBody');
    const modalTitle = document.getElementById('modalTitle');

    modalTitle.textContent = app.user.name;

    // ── Status badge HTML helper
    const statusBadge = () => {
        const map = {
            pending:              ['fa-clock',        'Pending'],
            accepted:             ['fa-check',        'Diterima'],
            rejected:             ['fa-redo',         'Revisi'],
            permanently_rejected: ['fa-ban',          'Ditolak Permanen'],
            finished:             ['fa-check-double', 'Selesai'],
        };
        const [icon, label] = map[app.status] || ['fa-circle', app.status];
        return `<span class="status-badge ${app.status}"><i class="fas ${icon}"></i> ${label}</span>`;
    };

    // ── Documents chips
    const docMap = [
        { key: 'ktm',   label: 'KTM' },
        { key: 'cv',    label: 'CV' },
        { key: 'surat', label: 'Surat' },
        { key: 'skck',  label: 'SKCK' },
    ];
    const docChips = docMap
        .filter(d => app.documents[d.key])
        .map(d => `<a href="${app.documents[d.key]}" target="_blank" class="doc-chip"><i class="fas fa-file-pdf"></i>${d.label}</a>`)
        .join('');

    // ── LEFT PANEL
    const leftPanel = `
        <div class="modal-panel-left">
            <div class="applicant-identity">
                <div class="applicant-avatar">
                    ${app.user.profile_picture
                        ? `<img src="${app.user.profile_picture}" alt="Foto">`
                        : `<i class="fas fa-user placeholder-icon"></i>`}
                </div>
                <div class="applicant-name-block">
                    <h4>${app.user.name}</h4>
                    <div class="badge-row">
                        ${statusBadge()}
                        ${app.user.is_reapplicant
                            ? `<span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(245,158,11,0.1);color:#D97706;font-size:0.68rem;font-weight:700;border-radius:5px;"><i class="fas fa-redo" style="font-size:0.6rem;"></i>Ulang</span>`
                            : ''}
                    </div>
                </div>
            </div>

            <div class="detail-list">
                <div class="detail-item">
                    <span class="di-label"><i class="fas fa-id-card" style="margin-right:3px;"></i>NIM/NIP</span>
                    <span class="di-value">${app.user.nim}</span>
                </div>
                <div class="detail-item">
                    <span class="di-label"><i class="fas fa-phone" style="margin-right:3px;"></i>No. HP</span>
                    <span class="di-value">${app.user.phone}</span>
                </div>
                <div class="detail-item" style="grid-column: 1/-1;">
                    <span class="di-label"><i class="fas fa-university" style="margin-right:3px;"></i>Institusi</span>
                    <span class="di-value">${app.user.university}</span>
                </div>
                <div class="detail-item">
                    <span class="di-label"><i class="fas fa-graduation-cap" style="margin-right:3px;"></i>Jurusan</span>
                    <span class="di-value">${app.user.major}</span>
                </div>
                <div class="detail-item">
                    <span class="di-label"><i class="fas fa-fingerprint" style="margin-right:3px;"></i>NIK</span>
                    <span class="di-value">${app.user.ktp_number}</span>
                </div>
                <div class="detail-item" style="grid-column: 1/-1;">
                    <span class="di-label"><i class="fas fa-tag" style="margin-right:3px;"></i>Bidang Peminatan</span>
                    <span class="di-value">${app.field}</span>
                </div>
            </div>

            <div class="period-strip">
                <div class="ps-date-block">
                    <span class="ps-label">Mulai</span>
                    <span class="ps-date">${app.start_date}</span>
                </div>
                <div class="ps-arrow"><i class="fas fa-arrow-right"></i></div>
                <div class="ps-divider"></div>
                <div class="ps-date-block">
                    <span class="ps-label">Selesai</span>
                    <span class="ps-date">${app.end_date}</span>
                </div>
            </div>
            ${app.duration_label && app.duration_label !== '-' ? `
            <div class="duration-label">
                <i class="fas fa-hourglass-half"></i> Durasi: ${app.duration_label}
            </div>` : ''}

            <div class="docs-section">
                <div class="docs-label"><i class="fas fa-folder-open"></i> Dokumen</div>
                <div class="docs-row">
                    ${docChips || '<span style="font-size:0.78rem;color:#94a3b8;">Tidak ada dokumen</span>'}
                </div>
            </div>
        </div>
    `;

    // ── RIGHT PANEL — build based on status
    let rightPanel = '';

    if (app.status === 'pending') {
        rightPanel = `
            <div class="modal-panel-right">
                <div class="action-tabs">
                    <button class="action-tab active-approve" onclick="switchTab('approve', ${appId})" id="tabApprove${appId}">
                        <i class="fas fa-check-circle"></i> Terima
                    </button>
                    <button class="action-tab" onclick="switchTab('revisi', ${appId})" id="tabRevisi${appId}">
                        <i class="fas fa-redo"></i> Revisi
                    </button>
                    <button class="action-tab" onclick="switchTab('reject', ${appId})" id="tabReject${appId}">
                        <i class="fas fa-ban"></i> Tolak
                    </button>
                </div>

                <div class="tab-panels">
                    <div class="tab-panel visible" id="panelApprove${appId}">
                        <div class="panel-approve" style="display:flex;flex-direction:column;gap:0.75rem;">
                            <form action="${app.approve_url}" method="POST" style="display:flex;flex-direction:column;gap:0.75rem;flex:1;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <div class="form-field">
                                    <label>Pilih Divisi <span style="color:#EF4444;">*</span></label>
                                    <select name="divisi_id" required onchange="updateMentors(this, ${appId})">
                                        <option value="">-- Pilih Divisi --</option>
                                        ${divisions.map(d => `<option value="${d.id}">${d.name}</option>`).join('')}
                                    </select>
                                </div>
                                <div class="form-field" id="mentorGroup${appId}" style="display:none;">
                                    <label>Pilih Mentor <span style="color:#94a3b8;">(Opsional)</span></label>
                                    <select name="division_mentor_id" id="mentorSelect${appId}">
                                        <option value="">-- Pilih Mentor --</option>
                                    </select>
                                </div>
                                <div style="flex:1;"></div>
                                <button type="submit" class="btn-approve">
                                    <i class="fas fa-check"></i> Konfirmasi Penerimaan
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="tab-panel" id="panelRevisi${appId}">
                        <div class="panel-revisi" style="display:flex;flex-direction:column;gap:0.75rem;">
                            <div style="font-size:0.75rem;color:#92400e;background:rgba(217,119,6,0.08);border-radius:8px;padding:0.5rem 0.75rem;border:1px solid #fde68a;">
                                <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                                Peserta masih dapat mendaftar ulang setelah revisi.
                            </div>
                            <form action="${app.reject_url}" method="POST" style="display:flex;flex-direction:column;gap:0.75rem;flex:1;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <div class="form-field" style="display:flex;flex-direction:column;flex:1;">
                                    <label>Catatan Revisi <span style="color:#94a3b8;">(Opsional)</span></label>
                                    <textarea name="notes" placeholder="Tuliskan catatan untuk peserta..." style="flex:1;min-height:60px;border-color:#fcd34d;"></textarea>
                                </div>
                                <button type="submit" class="btn-revisi">
                                    <i class="fas fa-redo"></i> Kirim Revisi
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="tab-panel" id="panelReject${appId}">
                        <div class="panel-reject" style="display:flex;flex-direction:column;gap:0.75rem;">
                            <div style="font-size:0.75rem;color:#7f1d1d;background:rgba(127,29,29,0.07);border-radius:8px;padding:0.5rem 0.75rem;border:1px solid #fca5a5;">
                                <i class="fas fa-exclamation-triangle" style="margin-right:4px;"></i>
                                Peserta <strong>tidak dapat</strong> mendaftar ulang setelah ditolak permanen.
                            </div>
                            <form action="${app.permanent_reject_url}" method="POST" style="display:flex;flex-direction:column;gap:0.75rem;flex:1;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <div class="form-field" style="display:flex;flex-direction:column;flex:1;">
                                    <label>Alasan Penolakan <span style="color:#94a3b8;">(Opsional)</span></label>
                                    <textarea name="notes" placeholder="Masukkan alasan penolakan permanen..." style="flex:1;min-height:60px;"></textarea>
                                </div>
                                <button type="submit" class="btn-permanent-reject">
                                    <i class="fas fa-ban"></i> Tolak Permanen
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        // Non-pending: show status info panel
        const iconMap = {
            accepted:             { cls: 'accepted',  icon: 'fa-check-circle',   msg: 'Pengajuan telah diterima' },
            rejected:             { cls: 'rejected',  icon: 'fa-redo',           msg: 'Dikembalikan untuk revisi' },
            permanently_rejected: { cls: 'rejected',  icon: 'fa-ban',            msg: 'Ditolak permanen' },
            finished:             { cls: 'finished',  icon: 'fa-flag-checkered', msg: 'Magang telah selesai' },
        };
        const si = iconMap[app.status] || { cls: '', icon: 'fa-info-circle', msg: app.status };

        rightPanel = `
            <div class="modal-panel-right">
                <div class="status-info-panel">
                    <div class="si-icon ${si.cls}"><i class="fas ${si.icon}"></i></div>
                    <div class="si-label">${si.msg}</div>
                    ${(app.status === 'rejected' || app.status === 'permanently_rejected') && app.notes
                        ? `<div class="rejection-note"><strong>Catatan:</strong> ${app.notes}</div>`
                        : ''}
                </div>
            </div>
        `;
    }

    modalBody.innerHTML = leftPanel + rightPanel;
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

// Tab switcher for pending modal (3 tabs: approve / revisi / reject)
function switchTab(tab, appId) {
    const tabApprove = document.getElementById('tabApprove' + appId);
    const tabRevisi  = document.getElementById('tabRevisi'  + appId);
    const tabReject  = document.getElementById('tabReject'  + appId);
    const panelApprove = document.getElementById('panelApprove' + appId);
    const panelRevisi  = document.getElementById('panelRevisi'  + appId);
    const panelReject  = document.getElementById('panelReject'  + appId);

    // Reset all
    tabApprove.className = 'action-tab';
    tabRevisi.className  = 'action-tab';
    tabReject.className  = 'action-tab';
    panelApprove.classList.remove('visible');
    panelRevisi.classList.remove('visible');
    panelReject.classList.remove('visible');

    if (tab === 'approve') {
        tabApprove.className = 'action-tab active-approve';
        panelApprove.classList.add('visible');
    } else if (tab === 'revisi') {
        tabRevisi.className = 'action-tab active-revisi';
        panelRevisi.classList.add('visible');
    } else {
        tabReject.className = 'action-tab active-reject';
        panelReject.classList.add('visible');
    }
}

function closeDetailModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

function updateMentors(select, appId) {
    const divisionId = select.value;
    const mentorGroup = document.getElementById('mentorGroup' + appId);
    const mentorSelect = document.getElementById('mentorSelect' + appId);

    if (!divisionId) {
        mentorGroup.style.display = 'none';
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>';
        return;
    }

    const division = divisions.find(d => d.id == divisionId);
    if (division && division.mentors && division.mentors.length > 0) {
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>' +
            division.mentors.map(m => `<option value="${m.id}">${m.name}</option>`).join('');
        mentorGroup.style.display = 'block';
    } else {
        mentorGroup.style.display = 'none';
        mentorSelect.innerHTML = '<option value="">-- Pilih Mentor --</option>';
    }
}

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDetailModal();
    }
});

// Close modal on overlay click
document.getElementById('detailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDetailModal();
    }
});
</script>
@endpush
