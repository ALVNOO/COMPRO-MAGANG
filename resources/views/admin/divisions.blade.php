{{--
    ADMIN DIVISIONS PAGE
    Manage organizational structure with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Kelola Divisi')

@php
    $role = 'admin';
    $pageTitle = 'Kelola Divisi';
    $pageSubtitle = 'Kelola struktur organisasi dan divisi perusahaan';

    // Count stats
    $totalDirektorats = $direktorats->count();
    $totalSubdirektorats = $direktorats->sum(fn($d) => $d->subDirektorats->count());
    $totalDivisis = $direktorats->sum(fn($d) => $d->subDirektorats->sum(fn($s) => $s->divisis->count()));
@endphp

@push('styles')
<style>
/* ============================================
   DIVISIONS PAGE STYLES
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

.hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hero-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1.25rem;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.stat-icon.direktorat { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; }
.stat-icon.subdirektorat { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.stat-icon.divisi { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }

.stat-content h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: #1f2937;
    line-height: 1.2;
}

.stat-content p {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}

/* Accordion Container */
.accordion-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.accordion-header-bar {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, rgba(238, 46, 36, 0.03) 0%, rgba(255, 255, 255, 0) 100%);
}

.accordion-header-bar i {
    color: #EE2E24;
}

.accordion-header-bar h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

/* Direktorat Level */
.direktorat-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.direktorat-item:last-child {
    border-bottom: none;
}

.direktorat-header {
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
}

.direktorat-header:hover {
    background: rgba(238, 46, 36, 0.02);
}

.direktorat-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.direktorat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.direktorat-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.direktorat-badge {
    font-size: 0.75rem;
    color: #6b7280;
}

.direktorat-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn-sm {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.action-btn-sm.add {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.action-btn-sm.add:hover {
    background: rgba(34, 197, 94, 0.2);
}

.action-btn-sm.edit {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.action-btn-sm.edit:hover {
    background: rgba(245, 158, 11, 0.2);
}

.action-btn-sm.delete {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.action-btn-sm.delete:hover {
    background: rgba(239, 68, 68, 0.2);
}

.chevron-icon {
    transition: transform 0.3s ease;
    color: #9ca3af;
}

.direktorat-item.expanded .chevron-icon {
    transform: rotate(180deg);
}

.direktorat-content {
    display: none;
    padding: 0 1.5rem 1rem;
}

.direktorat-item.expanded .direktorat-content {
    display: block;
}

/* Subdirektorat Level */
.subdirektorat-item {
    margin-bottom: 0.75rem;
    background: #f9fafb;
    border-radius: 12px;
    overflow: hidden;
}

.subdirektorat-header {
    padding: 0.875rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: all 0.2s ease;
}

.subdirektorat-header:hover {
    background: rgba(0, 0, 0, 0.02);
}

.subdirektorat-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.subdirektorat-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.8rem;
}

.subdirektorat-name {
    font-size: 0.9rem;
    font-weight: 500;
    color: #374151;
}

.subdirektorat-content {
    display: none;
    padding: 0 1rem 1rem;
}

.subdirektorat-item.expanded .subdirektorat-content {
    display: block;
}

/* Divisi Table */
.divisi-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.divisi-table th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.7rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: #f3f4f6;
    border-bottom: 1px solid #e5e7eb;
}

.divisi-table td {
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}

.divisi-table tr:last-child td {
    border-bottom: none;
}

.divisi-name {
    font-weight: 500;
    color: #1f2937;
}

.mentor-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.mentor-badge.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.mentor-badge.inactive {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.mentor-info {
    font-size: 0.7rem;
    color: #9ca3af;
    margin-top: 0.25rem;
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
    max-width: 480px;
    width: 100%;
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
}

.form-group {
    margin-bottom: 1rem;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.info-box {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 10px;
    padding: 0.875rem;
    margin-bottom: 1rem;
    font-size: 0.85rem;
    color: #1e40af;
}

.info-box i {
    margin-right: 0.5rem;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.modal-btn {
    padding: 0.625rem 1.25rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
}

.modal-btn.cancel {
    background: #f3f4f6;
    color: #4b5563;
}

.modal-btn.cancel:hover {
    background: #e5e7eb;
}

.modal-btn.primary {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
}

.modal-btn.primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
}

.modal-btn.danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.modal-btn.danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(156, 163, 175, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.5rem;
    color: #9ca3af;
}

.empty-state p {
    font-size: 0.9rem;
    color: #6b7280;
}

/* Toast */
.toast-container {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 1100;
}

.toast {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease;
}

.toast.success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: white;
}

.toast.error {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.toast-close {
    margin-left: auto;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 6px;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: white;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(100%); }
    to { opacity: 1; transform: translateX(0); }
}

/* Responsive */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
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

    .direktorat-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .divisi-table {
        font-size: 0.8rem;
    }
}
</style>
@endpush

@section('content')
<div class="divisions-page" x-data="divisionsManager()">
    {{-- Hero Section --}}
    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><i class="fas fa-sitemap"></i> Kelola Struktur Organisasi</h1>
                <p>Kelola direktorat, subdirektorat, dan divisi perusahaan</p>
            </div>
            <button class="hero-btn" @click="openAddDirektoratModal()">
                <i class="fas fa-plus"></i> Tambah Direktorat
            </button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon direktorat">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalDirektorats }}</h3>
                <p>Direktorat</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon subdirektorat">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalSubdirektorats }}</h3>
                <p>Subdirektorat</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon divisi">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalDivisis }}</h3>
                <p>Divisi</p>
            </div>
        </div>
    </div>

    {{-- Accordion Container --}}
    <div class="accordion-container">
        <div class="accordion-header-bar">
            <i class="fas fa-folder-tree"></i>
            <h3>Struktur Organisasi</h3>
        </div>

        @if($direktorats->count() > 0)
            @foreach($direktorats as $direktorat)
            <div class="direktorat-item" x-data="{ expanded: false }">
                <div class="direktorat-header" @click="expanded = !expanded">
                    <div class="direktorat-title">
                        <div class="direktorat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <div class="direktorat-name">{{ $direktorat->name }}</div>
                            <div class="direktorat-badge">{{ $direktorat->subDirektorats->count() }} Subdirektorat</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="direktorat-actions" @click.stop>
                            <button class="action-btn-sm add" title="Tambah Subdirektorat"
                                    @click="openAddSubdirektoratModal({{ $direktorat->id }}, '{{ $direktorat->name }}')">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="action-btn-sm edit" title="Edit Direktorat"
                                    @click="openEditDirektoratModal({{ $direktorat->id }}, '{{ $direktorat->name }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn-sm delete" title="Hapus Direktorat"
                                    @click="openDeleteModal('Direktorat', '{{ $direktorat->name }}', '{{ route('admin.direktorat.delete', $direktorat->id) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <i class="fas fa-chevron-down chevron-icon" :class="{ 'rotate-180': expanded }"></i>
                    </div>
                </div>
                <div class="direktorat-content" x-show="expanded" x-transition>
                    @if($direktorat->subDirektorats->count() > 0)
                        @foreach($direktorat->subDirektorats as $sub)
                        <div class="subdirektorat-item" x-data="{ subExpanded: false }">
                            <div class="subdirektorat-header" @click="subExpanded = !subExpanded">
                                <div class="subdirektorat-title">
                                    <div class="subdirektorat-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div>
                                        <div class="subdirektorat-name">{{ $sub->name }}</div>
                                        <div class="direktorat-badge">{{ $sub->divisis->count() }} Divisi</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="direktorat-actions" @click.stop>
                                        <button class="action-btn-sm add" title="Tambah Divisi"
                                                @click="openAddDivisiModal({{ $sub->id }}, '{{ $sub->name }}')">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="action-btn-sm edit" title="Edit Subdirektorat"
                                                @click="openEditSubdirektoratModal({{ $sub->id }}, '{{ $sub->name }}', {{ $sub->direktorat_id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn-sm delete" title="Hapus Subdirektorat"
                                                @click="openDeleteModal('Subdirektorat', '{{ $sub->name }}', '{{ route('admin.subdirektorat.delete', $sub->id) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <i class="fas fa-chevron-down chevron-icon" :class="{ 'rotate-180': subExpanded }"></i>
                                </div>
                            </div>
                            <div class="subdirektorat-content" x-show="subExpanded" x-transition>
                                @if($sub->divisis->count() > 0)
                                <table class="divisi-table">
                                    <thead>
                                        <tr>
                                            <th>Divisi</th>
                                            <th>VP</th>
                                            <th>NIPPOS</th>
                                            <th>Pembimbing</th>
                                            <th style="width: 100px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sub->divisis as $divisi)
                                        @php
                                            $pembimbing = \App\Models\User::where('divisi_id', $divisi->id)
                                                                        ->where('role', 'pembimbing')
                                                                        ->first();
                                        @endphp
                                        <tr>
                                            <td><span class="divisi-name">{{ $divisi->name }}</span></td>
                                            <td>{{ $divisi->vp }}</td>
                                            <td>{{ $divisi->nippos }}</td>
                                            <td>
                                                @if($pembimbing)
                                                <div>
                                                    <span class="mentor-badge active">
                                                        <i class="fas fa-user-check"></i> {{ $pembimbing->username }}
                                                    </span>
                                                    <div class="mentor-info">
                                                        Password: mentor123
                                                    </div>
                                                </div>
                                                @else
                                                <span class="mentor-badge inactive">
                                                    <i class="fas fa-user-times"></i> Belum ada
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-1">
                                                    <button class="action-btn-sm edit" title="Edit Divisi"
                                                            @click="openEditDivisiModal({{ $divisi->id }}, '{{ $divisi->name }}', '{{ $divisi->vp }}', '{{ $divisi->nippos }}', {{ $divisi->sub_direktorat_id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="action-btn-sm delete" title="Hapus Divisi"
                                                            @click="openDeleteModal('Divisi', '{{ $divisi->name }}', '{{ route('admin.divisi.delete', $divisi->id) }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <p>Belum ada divisi di subdirektorat ini</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <p>Belum ada subdirektorat di direktorat ini</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-state" style="padding: 4rem 2rem;">
            <div class="empty-icon" style="width: 80px; height: 80px; font-size: 2rem; background: rgba(238, 46, 36, 0.1); color: #EE2E24;">
                <i class="fas fa-sitemap"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Belum Ada Struktur Organisasi</h4>
            <p>Mulai dengan menambahkan direktorat pertama</p>
        </div>
        @endif
    </div>

    {{-- Add Direktorat Modal --}}
    <div class="modal-overlay" :class="{ 'active': showAddDirektoratModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-building"></i>
                    <span>Tambah Direktorat</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.direktorat.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Direktorat</label>
                        <input type="text" name="name" class="form-input" placeholder="Masukkan nama direktorat" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Direktorat Modal --}}
    <div class="modal-overlay" :class="{ 'active': showEditDirektoratModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-edit"></i>
                    <span>Edit Direktorat</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="'/admin/direktorat/' + editDirektoratId" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Direktorat</label>
                        <input type="text" name="name" class="form-input" x-model="editDirektoratName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Subdirektorat Modal --}}
    <div class="modal-overlay" :class="{ 'active': showAddSubdirektoratModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-layer-group"></i>
                    <span>Tambah Subdirektorat</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.subdirektorat.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        Menambah subdirektorat ke: <strong x-text="parentDirektoratName"></strong>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Subdirektorat</label>
                        <input type="text" name="name" class="form-input" placeholder="Masukkan nama subdirektorat" required>
                    </div>
                    <input type="hidden" name="direktorat_id" x-model="parentDirektoratId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Subdirektorat Modal --}}
    <div class="modal-overlay" :class="{ 'active': showEditSubdirektoratModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-edit"></i>
                    <span>Edit Subdirektorat</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="'/admin/subdirektorat/' + editSubdirektoratId" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Subdirektorat</label>
                        <input type="text" name="name" class="form-input" x-model="editSubdirektoratName" required>
                    </div>
                    <input type="hidden" name="direktorat_id" x-model="editSubdirektoratParentId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Divisi Modal --}}
    <div class="modal-overlay" :class="{ 'active': showAddDivisiModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-users-cog"></i>
                    <span>Tambah Divisi</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.divisi.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        User pembimbing akan dibuat otomatis dengan:<br>
                        • Username: mentor_[nama_divisi]<br>
                        • Password: mentor123
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Divisi</label>
                        <input type="text" name="name" class="form-input" placeholder="Masukkan nama divisi" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama VP</label>
                        <input type="text" name="vp" class="form-input" placeholder="Masukkan nama VP" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIPPOS</label>
                        <input type="text" name="nippos" class="form-input" placeholder="Masukkan NIPPOS" required>
                    </div>
                    <input type="hidden" name="sub_direktorat_id" x-model="parentSubdirektoratId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Divisi Modal --}}
    <div class="modal-overlay" :class="{ 'active': showEditDivisiModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-edit"></i>
                    <span>Edit Divisi</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="'/admin/divisi/' + editDivisiId" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Divisi</label>
                        <input type="text" name="name" class="form-input" x-model="editDivisiName" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama VP</label>
                        <input type="text" name="vp" class="form-input" x-model="editDivisiVp" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIPPOS</label>
                        <input type="text" name="nippos" class="form-input" x-model="editDivisiNippos" required>
                    </div>
                    <input type="hidden" name="sub_direktorat_id" x-model="editDivisiSubId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal-overlay" :class="{ 'active': showDeleteModal }" @click.self="closeAllModals()">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i>
                    <span>Konfirmasi Hapus</span>
                </div>
                <button class="modal-close" @click="closeAllModals()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p style="font-size: 0.95rem; color: #374151;">
                        Apakah Anda yakin ingin menghapus <strong x-text="deleteType"></strong> "<strong x-text="deleteName"></strong>"?
                    </p>
                    <p style="font-size: 0.85rem; color: #6b7280; margin-top: 0.5rem;">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn cancel" @click="closeAllModals()">Batal</button>
                    <button type="submit" class="modal-btn danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Toast Notifications --}}
    <div class="toast-container">
        @if(session('success'))
        <div class="toast success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button class="toast-close" @click="show = false">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="toast error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="toast-close" @click="show = false">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function divisionsManager() {
    return {
        // Add Direktorat
        showAddDirektoratModal: false,

        // Edit Direktorat
        showEditDirektoratModal: false,
        editDirektoratId: null,
        editDirektoratName: '',

        // Add Subdirektorat
        showAddSubdirektoratModal: false,
        parentDirektoratId: null,
        parentDirektoratName: '',

        // Edit Subdirektorat
        showEditSubdirektoratModal: false,
        editSubdirektoratId: null,
        editSubdirektoratName: '',
        editSubdirektoratParentId: null,

        // Add Divisi
        showAddDivisiModal: false,
        parentSubdirektoratId: null,
        parentSubdirektoratName: '',

        // Edit Divisi
        showEditDivisiModal: false,
        editDivisiId: null,
        editDivisiName: '',
        editDivisiVp: '',
        editDivisiNippos: '',
        editDivisiSubId: null,

        // Delete
        showDeleteModal: false,
        deleteType: '',
        deleteName: '',
        deleteUrl: '',

        openAddDirektoratModal() {
            this.showAddDirektoratModal = true;
            document.body.style.overflow = 'hidden';
        },

        openEditDirektoratModal(id, name) {
            this.editDirektoratId = id;
            this.editDirektoratName = name;
            this.showEditDirektoratModal = true;
            document.body.style.overflow = 'hidden';
        },

        openAddSubdirektoratModal(direktoratId, direktoratName) {
            this.parentDirektoratId = direktoratId;
            this.parentDirektoratName = direktoratName;
            this.showAddSubdirektoratModal = true;
            document.body.style.overflow = 'hidden';
        },

        openEditSubdirektoratModal(id, name, parentId) {
            this.editSubdirektoratId = id;
            this.editSubdirektoratName = name;
            this.editSubdirektoratParentId = parentId;
            this.showEditSubdirektoratModal = true;
            document.body.style.overflow = 'hidden';
        },

        openAddDivisiModal(subId, subName) {
            this.parentSubdirektoratId = subId;
            this.parentSubdirektoratName = subName;
            this.showAddDivisiModal = true;
            document.body.style.overflow = 'hidden';
        },

        openEditDivisiModal(id, name, vp, nippos, subId) {
            this.editDivisiId = id;
            this.editDivisiName = name;
            this.editDivisiVp = vp;
            this.editDivisiNippos = nippos;
            this.editDivisiSubId = subId;
            this.showEditDivisiModal = true;
            document.body.style.overflow = 'hidden';
        },

        openDeleteModal(type, name, url) {
            this.deleteType = type;
            this.deleteName = name;
            this.deleteUrl = url;
            this.showDeleteModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeAllModals() {
            this.showAddDirektoratModal = false;
            this.showEditDirektoratModal = false;
            this.showAddSubdirektoratModal = false;
            this.showEditSubdirektoratModal = false;
            this.showAddDivisiModal = false;
            this.showEditDivisiModal = false;
            this.showDeleteModal = false;
            document.body.style.overflow = '';
        }
    }
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const manager = document.querySelector('[x-data]')?.__x?.$data;
        if (manager) {
            manager.closeAllModals();
        }
    }
});
</script>
@endpush
