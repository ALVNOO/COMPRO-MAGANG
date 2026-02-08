{{--
    ADMIN FIELDS PAGE
    Manage internship fields with modern UI
    Using unified layout with glassmorphism design
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Bidang Peminatan')

@php
    $role = 'admin';
    $pageTitle = 'Bidang Peminatan';
    $pageSubtitle = 'Kelola bidang peminatan untuk program magang';

    // Count stats
    $totalFields = $fields->count();
    $activeFields = $fields->where('is_active', true)->count();
    $totalDivisions = $fields->sum('division_count');
    $totalPositions = $fields->sum('position_count');
@endphp

@push('styles')
<style>
/* ============================================
   FIELDS PAGE STYLES
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
    text-decoration: none;
    transition: all 0.3s ease;
}

.hero-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: translateY(-2px);
    color: white;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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

.stat-icon.total { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white; }
.stat-icon.active { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.stat-icon.divisions { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
.stat-icon.positions { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }

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

/* Fields Grid */
.fields-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.field-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
}

.field-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
}

.field-card-header {
    padding: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.field-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.field-info {
    flex: 1;
    min-width: 0;
}

.field-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.field-description {
    font-size: 0.85rem;
    color: #6b7280;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.field-status {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
}

.field-status.active {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.field-status.inactive {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
}

.field-card-stats {
    padding: 0 1.5rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.field-stat {
    background: #f9fafb;
    border-radius: 10px;
    padding: 0.75rem;
    text-align: center;
}

.field-stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.125rem;
}

.field-stat-label {
    font-size: 0.7rem;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.field-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.field-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.field-action.edit {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.field-action.edit:hover {
    background: rgba(245, 158, 11, 0.2);
}

.field-action.toggle {
    background: rgba(107, 114, 128, 0.1);
    color: #6b7280;
}

.field-action.toggle:hover {
    background: rgba(107, 114, 128, 0.2);
}

.field-action.delete {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.field-action.delete:hover {
    background: rgba(239, 68, 68, 0.2);
}

/* Empty State */
.empty-state {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
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
    margin-bottom: 1.5rem;
}

.empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 100%);
    color: white;
    border-radius: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.empty-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(238, 46, 36, 0.3);
    color: white;
}

/* Toast Notification */
.toast-container {
    position: fixed;
    top: 1.5rem;
    right: 1.5rem;
    z-index: 1100;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.toast {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideIn 0.3s ease;
    max-width: 400px;
}

.toast.success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
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
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
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

    .fields-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="fields-page" x-data="fieldsManager()">
    {{-- Hero Section --}}
    <div class="admin-hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1><i class="fas fa-tags"></i> Bidang Peminatan</h1>
                <p>Kelola bidang peminatan dan posisi untuk program magang</p>
            </div>
            <a href="{{ route('admin.fields.create') }}" class="hero-btn">
                <i class="fas fa-plus"></i> Tambah Bidang
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalFields }}</h3>
                <p>Total Bidang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $activeFields }}</h3>
                <p>Bidang Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon divisions">
                <i class="fas fa-sitemap"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalDivisions }}</h3>
                <p>Total Divisi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon positions">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalPositions }}</h3>
                <p>Total Posisi</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <input
            type="text"
            class="filter-input"
            placeholder="Cari nama bidang..."
            x-model="searchQuery"
            @input="filterCards()"
        >
        <select class="filter-select" x-model="statusFilter" @change="filterCards()">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <button class="filter-btn" @click="resetFilters()">
            <i class="fas fa-sync-alt"></i> Reset
        </button>
    </div>

    {{-- Fields Grid --}}
    @if($fields->count() > 0)
    <div class="fields-grid" id="fieldsGrid">
        @foreach($fields as $field)
        <div class="field-card"
             data-name="{{ strtolower($field->name) }}"
             data-status="{{ $field->is_active ? 'active' : 'inactive' }}">
            <div class="field-card-header">
                <div class="field-icon" style="background: {{ $field->color ?? '#EE2E24' }}20; color: {{ $field->color ?? '#EE2E24' }};">
                    <i class="{{ $field->icon ?? 'fas fa-tag' }}"></i>
                </div>
                <div class="field-info">
                    <div class="field-name">
                        {{ $field->name }}
                        <span class="field-status {{ $field->is_active ? 'active' : 'inactive' }}">
                            <i class="fas {{ $field->is_active ? 'fa-check-circle' : 'fa-circle' }}"></i>
                            {{ $field->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div class="field-description">{{ $field->description ?? 'Tidak ada deskripsi' }}</div>
                </div>
            </div>

            <div class="field-card-stats">
                <div class="field-stat">
                    <div class="field-stat-value">{{ $field->division_count }}</div>
                    <div class="field-stat-label">Divisi</div>
                </div>
                <div class="field-stat">
                    <div class="field-stat-value">{{ $field->position_count }}</div>
                    <div class="field-stat-label">Posisi</div>
                </div>
                <div class="field-stat">
                    <div class="field-stat-value">{{ $field->duration_months }}</div>
                    <div class="field-stat-label">Bulan</div>
                </div>
            </div>

            <div class="field-card-footer">
                <a href="{{ route('admin.fields.edit', $field) }}" class="field-action edit" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('admin.fields.toggle', $field) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="field-action toggle" title="{{ $field->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                        <i class="fas {{ $field->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                    </button>
                </form>
                <form action="{{ route('admin.fields.delete', $field) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang peminatan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="field-action delete" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h4>Belum Ada Bidang Peminatan</h4>
        <p>Tambahkan bidang peminatan untuk program magang Anda</p>
        <a href="{{ route('admin.fields.create') }}" class="empty-btn">
            <i class="fas fa-plus"></i> Tambah Bidang Pertama
        </a>
    </div>
    @endif

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
    </div>
</div>
@endsection

@push('scripts')
<script>
function fieldsManager() {
    return {
        searchQuery: '',
        statusFilter: '',

        filterCards() {
            const cards = document.querySelectorAll('.field-card');

            cards.forEach(card => {
                const name = card.dataset.name || '';
                const status = card.dataset.status || '';

                const matchesSearch = !this.searchQuery ||
                    name.includes(this.searchQuery.toLowerCase());

                const matchesStatus = !this.statusFilter || status === this.statusFilter;

                if (matchesSearch && matchesStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        },

        resetFilters() {
            this.searchQuery = '';
            this.statusFilter = '';
            this.filterCards();
        }
    }
}
</script>
@endpush
