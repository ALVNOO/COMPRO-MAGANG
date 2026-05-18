{{-- ADMIN DIVISIONS PAGE — Redesigned with design system --}}

@extends('layouts.dashboard-unified')

@section('title', 'Kelola Divisi')

@php
    $role = 'admin';
    $totalDirektorats    = $direktorats->count();
    $totalSubdirektorats = $direktorats->sum(fn($d) => $d->subDirektorats->count());
    $totalDivisis        = $direktorats->sum(fn($d) => $d->subDirektorats->sum(fn($s) => $s->divisis->count()));
@endphp

@push('styles')
<style>
/* ── Stats ── */
.dv-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.dv-stat {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    padding: 1.125rem 1.375rem;
    display: flex; align-items: center; gap: 1rem;
}

.dv-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.dv-stat-icon.indigo { background: rgba(99,102,241,.1); color: #6366F1; }
.dv-stat-icon.green  { background: rgba(22,163,74,.1);  color: #16A34A; }
.dv-stat-icon.red    { background: rgba(238,46,36,.1);  color: #EE2E24; }

.dv-stat-val { font-size: 1.625rem; font-weight: 700; color: #111827; line-height: 1; margin-bottom: .2rem; }
.dv-stat-lbl { font-size: .75rem; color: #6B7280; font-weight: 500; }

/* ── Tree container ── */
.dv-tree {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* ── Direktorat card ── */
.dv-dir-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
}

.dv-dir-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.375rem;
    cursor: pointer;
    transition: background .12s;
    user-select: none;
}

.dv-dir-head:hover { background: #FAFAFA; }

.dv-dir-left { display: flex; align-items: center; gap: .875rem; }

.dv-dir-icon {
    width: 40px; height: 40px; border-radius: 11px;
    background: linear-gradient(135deg, #6366F1, #4F46E5);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .95rem; flex-shrink: 0;
}

.dv-dir-name { font-size: .9375rem; font-weight: 700; color: #111827; }
.dv-dir-sub  { font-size: .72rem; color: #9CA3AF; margin-top: .1rem; }

.dv-dir-right { display: flex; align-items: center; gap: .5rem; }

/* Action icon buttons */
.dv-icon-btn {
    width: 30px; height: 30px; border-radius: 8px;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem; transition: all .12s;
}

.dv-icon-btn.add  { background: #DCFCE7; color: #16A34A; }
.dv-icon-btn.add:hover  { background: #BBF7D0; }
.dv-icon-btn.edit { background: #FEF9C3; color: #B45309; }
.dv-icon-btn.edit:hover { background: #FDE68A; }
.dv-icon-btn.del  { background: #FEE2E2; color: #DC2626; }
.dv-icon-btn.del:hover  { background: #FECACA; }

.dv-chevron {
    color: #9CA3AF; font-size: .8rem;
    transition: transform .2s; margin-left: .25rem;
}

/* Direktorat body */
.dv-dir-body {
    border-top: 1px solid #F3F4F6;
    padding: 1rem 1.375rem;
    background: #FAFAFA;
    display: flex; flex-direction: column; gap: .75rem;
}

/* ── Subdirektorat card ── */
.dv-sub-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
}

.dv-sub-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: .75rem 1.125rem;
    cursor: pointer;
    transition: background .12s;
    user-select: none;
}

.dv-sub-head:hover { background: #F9FAFB; }

.dv-sub-left { display: flex; align-items: center; gap: .75rem; }

.dv-sub-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, #22C55E, #16A34A);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .78rem; flex-shrink: 0;
}

.dv-sub-name { font-size: .875rem; font-weight: 600; color: #374151; }
.dv-sub-meta { font-size: .7rem; color: #9CA3AF; margin-top: .1rem; }

.dv-sub-right { display: flex; align-items: center; gap: .4rem; }

/* Sub body */
.dv-sub-body {
    border-top: 1px solid #F3F4F6;
}

/* ── Divisi table ── */
.dv-divisi-table {
    width: 100%;
    border-collapse: collapse;
}

.dv-divisi-table th {
    padding: .625rem 1rem;
    text-align: left;
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #9CA3AF;
    background: #F9FAFB;
    border-bottom: 1px solid #F3F4F6;
}

.dv-divisi-table td {
    padding: .75rem 1rem;
    font-size: .8rem;
    color: #374151;
    border-bottom: 1px solid #F9FAFB;
    vertical-align: middle;
}

.dv-divisi-table tbody tr:last-child td { border-bottom: none; }
.dv-divisi-table tbody tr:hover td { background: #FAFAFA; }

.dv-divisi-name { font-weight: 600; color: #111827; }

.dv-mentor-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .2rem .6rem;
    border-radius: 9999px; font-size: .72rem; font-weight: 600;
    border: 1.5px solid transparent;
}

.dv-mentor-badge.has    { background: #DCFCE7; color: #15803D; border-color: #86EFAC; }
.dv-mentor-badge.none   { background: #F3F4F6; color: #9CA3AF; border-color: #E5E7EB; }

.dv-action-group { display: flex; gap: .35rem; justify-content: flex-end; }

/* ── Empty states ── */
.dv-empty {
    padding: 2.5rem 1rem; text-align: center;
}

.dv-empty i { font-size: 2rem; color: #E5E7EB; display: block; margin-bottom: .75rem; }
.dv-empty p { font-size: .8rem; color: #9CA3AF; margin: 0; }

/* ── Modal ── */
.dv-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 1000;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .2s, visibility .2s;
}

.dv-modal-overlay.active { opacity: 1; visibility: visible; }

.dv-modal {
    background: #fff;
    border-radius: 18px;
    max-width: 460px; width: 100%;
    box-shadow: 0 20px 50px rgba(0,0,0,.15);
    transform: translateY(16px) scale(.97);
    transition: transform .2s;
    overflow: hidden;
}

.dv-modal-overlay.active .dv-modal { transform: translateY(0) scale(1); }

.dv-modal-head {
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid #F3F4F6;
    display: flex; align-items: center; justify-content: space-between;
}

.dv-modal-title {
    display: flex; align-items: center; gap: .625rem;
    font-size: .9375rem; font-weight: 700; color: #111827;
}

.dv-modal-title-icon {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; flex-shrink: 0;
}
.dv-modal-title-icon.red    { background: rgba(238,46,36,.1); color: #EE2E24; }
.dv-modal-title-icon.indigo { background: rgba(99,102,241,.1);color: #6366F1; }
.dv-modal-title-icon.green  { background: rgba(22,163,74,.1); color: #16A34A; }
.dv-modal-title-icon.amber  { background: rgba(217,119,6,.1); color: #D97706; }
.dv-modal-title-icon.danger { background: rgba(239,68,68,.1); color: #DC2626; }

.dv-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    border: none; background: #F3F4F6; color: #6B7280;
    cursor: pointer; font-size: .85rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .12s;
}
.dv-modal-close:hover { background: #E5E7EB; }

.dv-modal-body { padding: 1.375rem 1.5rem; }

.dv-info-box {
    background: #EFF6FF; border: 1.5px solid #BFDBFE;
    border-radius: 10px; padding: .75rem 1rem;
    font-size: .8rem; color: #1E40AF; margin-bottom: 1rem;
    line-height: 1.5;
}

.dv-info-box i { margin-right: .4rem; }

.dv-form-field { margin-bottom: 1rem; }
.dv-form-field:last-child { margin-bottom: 0; }

.dv-form-label {
    display: block; font-size: .8rem; font-weight: 600;
    color: #374151; margin-bottom: .4rem;
}

.dv-form-input {
    width: 100%; padding: .7rem .9rem;
    border: 1.5px solid #E5E7EB; border-radius: 10px;
    font-size: .875rem; background: #F9FAFB; color: #111827;
    transition: border-color .15s; box-sizing: border-box;
}
.dv-form-input:focus { outline: none; border-color: #EE2E24; background: #fff; box-shadow: 0 0 0 3px rgba(238,46,36,.07); }

.dv-modal-foot {
    padding: .875rem 1.5rem;
    border-top: 1px solid #F3F4F6;
    display: flex; justify-content: flex-end; gap: .625rem;
}

.dv-modal-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .625rem 1.25rem; border: none; border-radius: 10px;
    font-size: .875rem; font-weight: 600; cursor: pointer; transition: all .15s;
}
.dv-modal-btn.cancel  { background: #F3F4F6; color: #374151; border: 1px solid #E5E7EB; }
.dv-modal-btn.cancel:hover  { background: #E5E7EB; }
.dv-modal-btn.primary { background: #EE2E24; color: #fff; }
.dv-modal-btn.primary:hover { background: #C41E1A; }
.dv-modal-btn.danger  { background: #DC2626; color: #fff; }
.dv-modal-btn.danger:hover  { background: #B91C1C; }

@media (max-width: 640px) {
    .dv-stats { grid-template-columns: 1fr 1fr; }
    .dv-stats .dv-stat:last-child { grid-column: span 2; }
    .dv-divisi-table th:nth-child(2),
    .dv-divisi-table td:nth-child(2),
    .dv-divisi-table th:nth-child(3),
    .dv-divisi-table td:nth-child(3) { display: none; }
}
</style>
@endpush

@section('content')
<div x-data="divisionsManager()">

<x-dashboard.page-context-bar
    title="Struktur Organisasi"
    description="Kelola direktorat, subdirektorat, dan divisi perusahaan"
    icon="fas fa-sitemap"
    role="admin"
>
    <button class="ctx-cta" @click="openAddDirektoratModal()">
        <i class="fas fa-plus"></i> Tambah Direktorat
    </button>
</x-dashboard.page-context-bar>

{{-- Alerts --}}
@if(session('success'))
    <div class="alert alert-compact alert-success" style="margin-bottom:1.25rem;">
        <div class="alert-icon-box"><i class="fas fa-check"></i></div>
        <div class="alert-content"><div class="alert-title">{{ session('success') }}</div></div>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-compact alert-danger" style="margin-bottom:1.25rem;">
        <div class="alert-icon-box"><i class="fas fa-times"></i></div>
        <div class="alert-content"><div class="alert-title">{{ session('error') }}</div></div>
    </div>
@endif

{{-- Stats --}}
<div class="dv-stats">
    <div class="dv-stat">
        <div class="dv-stat-icon indigo"><i class="fas fa-building-columns"></i></div>
        <div>
            <div class="dv-stat-val">{{ $totalDirektorats }}</div>
            <div class="dv-stat-lbl">Direktorat</div>
        </div>
    </div>
    <div class="dv-stat">
        <div class="dv-stat-icon green"><i class="fas fa-layer-group"></i></div>
        <div>
            <div class="dv-stat-val">{{ $totalSubdirektorats }}</div>
            <div class="dv-stat-lbl">Subdirektorat</div>
        </div>
    </div>
    <div class="dv-stat">
        <div class="dv-stat-icon red"><i class="fas fa-sitemap"></i></div>
        <div>
            <div class="dv-stat-val">{{ $totalDivisis }}</div>
            <div class="dv-stat-lbl">Divisi</div>
        </div>
    </div>
</div>

{{-- Tree --}}
@if($direktorats->count() > 0)
<div class="dv-tree">
    @foreach($direktorats as $direktorat)
    <div class="dv-dir-card" x-data="{ open: false }">

        {{-- Direktorat header --}}
        <div class="dv-dir-head" @click="open = !open">
            <div class="dv-dir-left">
                <div class="dv-dir-icon"><i class="fas fa-building-columns"></i></div>
                <div>
                    <div class="dv-dir-name">{{ $direktorat->name }}</div>
                    <div class="dv-dir-sub">{{ $direktorat->subDirektorats->count() }} Subdirektorat · {{ $direktorat->subDirektorats->sum(fn($s) => $s->divisis->count()) }} Divisi</div>
                </div>
            </div>
            <div class="dv-dir-right">
                <div @click.stop>
                    <button class="dv-icon-btn add" title="Tambah Subdirektorat"
                            @click="openAddSubdirektoratModal({{ $direktorat->id }}, '{{ addslashes($direktorat->name) }}')">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="dv-icon-btn edit" title="Edit Direktorat"
                            @click="openEditDirektoratModal({{ $direktorat->id }}, '{{ addslashes($direktorat->name) }}')">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button class="dv-icon-btn del" title="Hapus Direktorat"
                            @click="openDeleteModal('Direktorat', '{{ addslashes($direktorat->name) }}', '{{ route('admin.direktorat.delete', $direktorat->id) }}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <i class="fas fa-chevron-down dv-chevron" :style="open ? 'transform:rotate(180deg)' : ''"></i>
            </div>
        </div>

        {{-- Direktorat body --}}
        <div class="dv-dir-body" x-show="open" x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
            @if($direktorat->subDirektorats->count() > 0)
                @foreach($direktorat->subDirektorats as $sub)
                <div class="dv-sub-card" x-data="{ subOpen: false }">

                    {{-- Subdirektorat header --}}
                    <div class="dv-sub-head" @click="subOpen = !subOpen">
                        <div class="dv-sub-left">
                            <div class="dv-sub-icon"><i class="fas fa-layer-group"></i></div>
                            <div>
                                <div class="dv-sub-name">{{ $sub->name }}</div>
                                <div class="dv-sub-meta">{{ $sub->divisis->count() }} Divisi</div>
                            </div>
                        </div>
                        <div class="dv-sub-right">
                            <div @click.stop>
                                <button class="dv-icon-btn add" title="Tambah Divisi"
                                        @click="openAddDivisiModal({{ $sub->id }}, '{{ addslashes($sub->name) }}')">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="dv-icon-btn edit" title="Edit Subdirektorat"
                                        @click="openEditSubdirektoratModal({{ $sub->id }}, '{{ addslashes($sub->name) }}', {{ $sub->direktorat_id }})">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="dv-icon-btn del" title="Hapus Subdirektorat"
                                        @click="openDeleteModal('Subdirektorat', '{{ addslashes($sub->name) }}', '{{ route('admin.subdirektorat.delete', $sub->id) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <i class="fas fa-chevron-down dv-chevron" :style="subOpen ? 'transform:rotate(180deg)' : ''"></i>
                        </div>
                    </div>

                    {{-- Subdirektorat body: divisi table --}}
                    <div class="dv-sub-body" x-show="subOpen"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        @if($sub->divisis->count() > 0)
                        <table class="dv-divisi-table">
                            <thead>
                                <tr>
                                    <th>Nama Divisi</th>
                                    <th>VP</th>
                                    <th>NIPPOS</th>
                                    <th>Pembimbing</th>
                                    <th style="text-align:right;">Aksi</th>
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
                                    <td><span class="dv-divisi-name">{{ $divisi->name }}</span></td>
                                    <td>{{ $divisi->vp ?? '—' }}</td>
                                    <td>{{ $divisi->nippos ?? '—' }}</td>
                                    <td>
                                        @if($pembimbing)
                                            <span class="dv-mentor-badge has">
                                                <i class="fas fa-user-check"></i> {{ $pembimbing->name }}
                                            </span>
                                        @else
                                            <span class="dv-mentor-badge none">
                                                <i class="fas fa-user-slash"></i> Belum ada
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dv-action-group">
                                            <button class="dv-icon-btn edit" title="Edit Divisi"
                                                    @click="openEditDivisiModal({{ $divisi->id }}, '{{ addslashes($divisi->name) }}', '{{ addslashes($divisi->vp ?? '') }}', '{{ addslashes($divisi->nippos ?? '') }}', {{ $divisi->sub_direktorat_id }})">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button class="dv-icon-btn del" title="Hapus Divisi"
                                                    @click="openDeleteModal('Divisi', '{{ addslashes($divisi->name) }}', '{{ route('admin.divisi.delete', $divisi->id) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="dv-empty">
                            <i class="fas fa-sitemap"></i>
                            <p>Belum ada divisi — klik <strong>+</strong> di atas untuk menambahkan</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
            <div class="dv-empty">
                <i class="fas fa-layer-group"></i>
                <p>Belum ada subdirektorat — klik <strong>+</strong> di header untuk menambahkan</p>
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

@else
<div class="table-card" style="text-align:center;padding:5rem 2rem;">
    <i class="fas fa-sitemap" style="font-size:3rem;color:#E5E7EB;display:block;margin-bottom:1rem;"></i>
    <h4 style="font-size:1rem;font-weight:600;color:#374151;margin:0 0 .375rem;">Belum Ada Struktur Organisasi</h4>
    <p style="font-size:.85rem;color:#9CA3AF;margin:0;">Mulai dengan menambahkan direktorat pertama</p>
</div>
@endif

{{-- ════════════════════════════ MODALS ════════════════════════════ --}}

{{-- Add Direktorat --}}
<div class="dv-modal-overlay" :class="{ 'active': showAddDirektoratModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon indigo"><i class="fas fa-building-columns"></i></div>
                Tambah Direktorat
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.direktorat.store') }}" method="POST">
            @csrf
            <div class="dv-modal-body">
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Direktorat</label>
                    <input type="text" name="name" class="dv-form-input" placeholder="Masukkan nama direktorat" required>
                </div>
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Direktorat --}}
<div class="dv-modal-overlay" :class="{ 'active': showEditDirektoratModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon amber"><i class="fas fa-pen"></i></div>
                Edit Direktorat
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form :action="'/admin/direktorat/' + editDirektoratId" method="POST">
            @csrf @method('PUT')
            <div class="dv-modal-body">
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Direktorat</label>
                    <input type="text" name="name" class="dv-form-input" x-model="editDirektoratName" required>
                </div>
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Add Subdirektorat --}}
<div class="dv-modal-overlay" :class="{ 'active': showAddSubdirektoratModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon green"><i class="fas fa-layer-group"></i></div>
                Tambah Subdirektorat
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.subdirektorat.store') }}" method="POST">
            @csrf
            <div class="dv-modal-body">
                <div class="dv-info-box">
                    <i class="fas fa-info-circle"></i>
                    Menambah ke direktorat: <strong x-text="parentDirektoratName"></strong>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Subdirektorat</label>
                    <input type="text" name="name" class="dv-form-input" placeholder="Masukkan nama subdirektorat" required>
                </div>
                <input type="hidden" name="direktorat_id" x-model="parentDirektoratId">
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Subdirektorat --}}
<div class="dv-modal-overlay" :class="{ 'active': showEditSubdirektoratModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon amber"><i class="fas fa-pen"></i></div>
                Edit Subdirektorat
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form :action="'/admin/subdirektorat/' + editSubdirektoratId" method="POST">
            @csrf @method('PUT')
            <div class="dv-modal-body">
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Subdirektorat</label>
                    <input type="text" name="name" class="dv-form-input" x-model="editSubdirektoratName" required>
                </div>
                <input type="hidden" name="direktorat_id" x-model="editSubdirektoratParentId">
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Add Divisi --}}
<div class="dv-modal-overlay" :class="{ 'active': showAddDivisiModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon red"><i class="fas fa-sitemap"></i></div>
                Tambah Divisi
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('admin.divisi.store') }}" method="POST">
            @csrf
            <div class="dv-modal-body">
                <div class="dv-info-box">
                    <i class="fas fa-circle-info"></i>
                    Menambah divisi ke subdirektorat: <strong x-text="parentSubdirektoratName"></strong><br>
                    Akun pembimbing akan dibuat otomatis dengan username <em>mentor_[nama_divisi]</em>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Divisi</label>
                    <input type="text" name="name" class="dv-form-input" placeholder="Masukkan nama divisi" required>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama VP</label>
                    <input type="text" name="vp" class="dv-form-input" placeholder="Masukkan nama VP" required>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">NIPPOS</label>
                    <input type="text" name="nippos" class="dv-form-input" placeholder="Masukkan NIPPOS" required>
                </div>
                <input type="hidden" name="sub_direktorat_id" x-model="parentSubdirektoratId">
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Divisi --}}
<div class="dv-modal-overlay" :class="{ 'active': showEditDivisiModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon amber"><i class="fas fa-pen"></i></div>
                Edit Divisi
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form :action="'/admin/divisi/' + editDivisiId" method="POST">
            @csrf @method('PUT')
            <div class="dv-modal-body">
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama Divisi</label>
                    <input type="text" name="name" class="dv-form-input" x-model="editDivisiName" required>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">Nama VP</label>
                    <input type="text" name="vp" class="dv-form-input" x-model="editDivisiVp" required>
                </div>
                <div class="dv-form-field">
                    <label class="dv-form-label">NIPPOS</label>
                    <input type="text" name="nippos" class="dv-form-input" x-model="editDivisiNippos" required>
                </div>
                <input type="hidden" name="sub_direktorat_id" x-model="editDivisiSubId">
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn primary"><i class="fas fa-check"></i> Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirm --}}
<div class="dv-modal-overlay" :class="{ 'active': showDeleteModal }" @click.self="closeAllModals()">
    <div class="dv-modal">
        <div class="dv-modal-head">
            <div class="dv-modal-title">
                <div class="dv-modal-title-icon danger"><i class="fas fa-triangle-exclamation"></i></div>
                Konfirmasi Hapus
            </div>
            <button class="dv-modal-close" @click="closeAllModals()"><i class="fas fa-times"></i></button>
        </div>
        <form :action="deleteUrl" method="POST">
            @csrf @method('DELETE')
            <div class="dv-modal-body">
                <p style="font-size:.9rem;color:#374151;margin:0 0 .5rem;">
                    Yakin ingin menghapus <strong x-text="deleteType"></strong>
                    "<strong x-text="deleteName"></strong>"?
                </p>
                <p style="font-size:.8rem;color:#9CA3AF;margin:0;">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="dv-modal-foot">
                <button type="button" class="dv-modal-btn cancel" @click="closeAllModals()">Batal</button>
                <button type="submit" class="dv-modal-btn danger"><i class="fas fa-trash"></i> Hapus</button>
            </div>
        </form>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection

@push('scripts')
<script>
function divisionsManager() {
    return {
        showAddDirektoratModal: false,
        showEditDirektoratModal: false, editDirektoratId: null, editDirektoratName: '',
        showAddSubdirektoratModal: false, parentDirektoratId: null, parentDirektoratName: '',
        showEditSubdirektoratModal: false, editSubdirektoratId: null, editSubdirektoratName: '', editSubdirektoratParentId: null,
        showAddDivisiModal: false, parentSubdirektoratId: null, parentSubdirektoratName: '',
        showEditDivisiModal: false, editDivisiId: null, editDivisiName: '', editDivisiVp: '', editDivisiNippos: '', editDivisiSubId: null,
        showDeleteModal: false, deleteType: '', deleteName: '', deleteUrl: '',

        openAddDirektoratModal()     { this.showAddDirektoratModal = true;    this._lock(); },
        openEditDirektoratModal(id, name) { this.editDirektoratId = id; this.editDirektoratName = name; this.showEditDirektoratModal = true; this._lock(); },
        openAddSubdirektoratModal(id, name) { this.parentDirektoratId = id; this.parentDirektoratName = name; this.showAddSubdirektoratModal = true; this._lock(); },
        openEditSubdirektoratModal(id, name, pid) { this.editSubdirektoratId = id; this.editSubdirektoratName = name; this.editSubdirektoratParentId = pid; this.showEditSubdirektoratModal = true; this._lock(); },
        openAddDivisiModal(id, name) { this.parentSubdirektoratId = id; this.parentSubdirektoratName = name; this.showAddDivisiModal = true; this._lock(); },
        openEditDivisiModal(id, name, vp, nippos, subId) { this.editDivisiId = id; this.editDivisiName = name; this.editDivisiVp = vp; this.editDivisiNippos = nippos; this.editDivisiSubId = subId; this.showEditDivisiModal = true; this._lock(); },
        openDeleteModal(type, name, url) { this.deleteType = type; this.deleteName = name; this.deleteUrl = url; this.showDeleteModal = true; this._lock(); },

        closeAllModals() {
            this.showAddDirektoratModal = this.showEditDirektoratModal =
            this.showAddSubdirektoratModal = this.showEditSubdirektoratModal =
            this.showAddDivisiModal = this.showEditDivisiModal = this.showDeleteModal = false;
            document.body.style.overflow = '';
        },

        _lock() { document.body.style.overflow = 'hidden'; },
    }
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const el = document.querySelector('[x-data]');
        if (el && el._x_dataStack) el._x_dataStack[0].closeAllModals();
    }
});
</script>
@endpush
