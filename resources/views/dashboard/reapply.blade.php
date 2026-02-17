{{--
    REAPPLY PAGE - Ajukan Ulang Magang
    Modern glassmorphism design with unified layout
--}}

@extends('layouts.dashboard-unified')

@section('title', 'Ajukan Ulang Magang - PT Telkom Indonesia')

@php
    $role = 'participant';
    $pageTitle = 'Ajukan Ulang';
    $latestApplication = $user->internshipApplications()->latest()->first();
@endphp

@push('styles')
<style>
/* ============================================
   REAPPLY PAGE STYLES
   ============================================ */

/* Hero Section */
.reapply-hero {
    background: linear-gradient(135deg, #EE2E24 0%, #C41E1A 50%, #9B1B1B 100%);
    border-radius: 24px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    color: white;
    text-align: center;
}

.reapply-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(ellipse, rgba(255,255,255,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.reapply-hero-content {
    position: relative;
    z-index: 1;
}

.hero-icon-wrap {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
}

.hero-icon-wrap i {
    font-size: 2rem;
    color: white;
}

.reapply-hero h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.35rem;
}

.reapply-hero .hero-subtitle {
    font-size: 0.95rem;
    opacity: 0.9;
}

/* Content Layout */
.reapply-content {
    max-width: 820px;
    margin: 0 auto;
}

/* Glassmorphism Card */
.glass-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.glass-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.glass-card-header .header-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.glass-card-header .header-icon.red {
    background: rgba(238, 46, 36, 0.1);
    color: #EE2E24;
}

.glass-card-header .header-icon.blue {
    background: rgba(59, 130, 246, 0.1);
    color: #3B82F6;
}

.glass-card-header .header-icon.amber {
    background: rgba(245, 158, 11, 0.1);
    color: #F59E0B;
}

.glass-card-header .header-icon.green {
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
}

.glass-card-header h5 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

.glass-card-body {
    padding: 1.5rem;
}

/* User Info Grid */
.user-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
}

.user-info-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    border-radius: 12px;
    transition: background 0.2s;
}

.user-info-item:hover {
    background: #f3f4f6;
}

.user-info-item .info-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(238, 46, 36, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    flex-shrink: 0;
}

.user-info-item .info-icon i {
    font-size: 0.8rem;
    color: #EE2E24;
}

.user-info-item .info-label {
    font-size: 0.75rem;
    color: #9ca3af;
    font-weight: 500;
    line-height: 1.2;
}

.user-info-item .info-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 600;
    line-height: 1.3;
}

/* Form Styling */
.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 600;
    color: #374151;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.form-group label i {
    color: #EE2E24;
    font-size: 0.85rem;
}

.form-group label .required-star {
    color: #EF4444;
    font-weight: 700;
}

.form-group .form-control,
.form-group .form-select {
    border: 1px solid #d1d5db;
    border-radius: 12px;
    padding: 0.7rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.3s, box-shadow 0.3s;
    background-color: #fff;
}

.form-group .form-control:focus,
.form-group .form-select:focus {
    border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238, 46, 36, 0.1);
}

.form-group .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23374151' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 14px 10px;
    padding-right: 2.5rem;
}

.form-group .invalid-feedback {
    font-size: 0.8rem;
    margin-top: 0.35rem;
}

.date-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Submit Buttons */
.btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.8rem 1.5rem;
    background: linear-gradient(135deg, #EE2E24, #C41E1A);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(238, 46, 36, 0.25);
    cursor: pointer;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(238, 46, 36, 0.35);
    color: white;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.7rem 1.5rem;
    background: transparent;
    color: #6b7280;
    border: 1.5px solid #d1d5db;
    border-radius: 14px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 0.75rem;
}

.btn-back:hover {
    border-color: #EE2E24;
    color: #EE2E24;
    background: rgba(238, 46, 36, 0.04);
}

/* Previous Application Card */
.prev-app-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.prev-app-header.rejected {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.08), rgba(245, 158, 11, 0.03));
}

.prev-app-header.accepted {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(16, 185, 129, 0.03));
}

.prev-app-header.finished {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.08), rgba(59, 130, 246, 0.03));
}

.prev-app-header.default {
    background: linear-gradient(135deg, rgba(107, 114, 128, 0.08), rgba(107, 114, 128, 0.03));
}

.prev-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
}

.prev-info-item {
    display: flex;
    align-items: flex-start;
    padding: 0.75rem 1rem;
    background: #f9fafb;
    border-radius: 12px;
}

.prev-info-item .item-label {
    font-size: 0.8rem;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.15rem;
}

.prev-info-item .item-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 500;
}

.prev-notes-card {
    margin-top: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
}

.prev-notes-card.rejection {
    background: rgba(239, 68, 68, 0.06);
    border: 1px solid rgba(239, 68, 68, 0.12);
}

.prev-notes-card.success {
    background: rgba(16, 185, 129, 0.06);
    border: 1px solid rgba(16, 185, 129, 0.12);
}

.prev-notes-card.info {
    background: rgba(59, 130, 246, 0.06);
    border: 1px solid rgba(59, 130, 246, 0.12);
}

.prev-notes-card.muted {
    background: rgba(107, 114, 128, 0.06);
    border: 1px solid rgba(107, 114, 128, 0.12);
}

.prev-notes-card .notes-title {
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.35rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.prev-notes-card .notes-text {
    font-size: 0.85rem;
    line-height: 1.6;
    margin: 0;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.85rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.78rem;
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.12);
    color: #dc2626;
}

.status-badge.accepted {
    background: rgba(16, 185, 129, 0.15);
    color: #059669;
}

.status-badge.finished {
    background: rgba(59, 130, 246, 0.12);
    color: #2563eb;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

/* Alert Styling */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.875rem;
}

.alert-modern.success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.alert-modern.danger {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.alert-modern i {
    margin-top: 0.1rem;
    font-size: 1rem;
}

.alert-modern ul {
    margin: 0;
    padding-left: 1.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .reapply-hero {
        padding: 2rem 1.5rem;
    }

    .reapply-hero h2 {
        font-size: 1.35rem;
    }

    .hero-icon-wrap {
        width: 64px;
        height: 64px;
    }

    .hero-icon-wrap i {
        font-size: 1.5rem;
    }

    .user-info-grid,
    .date-grid,
    .prev-info-grid {
        grid-template-columns: 1fr;
    }

    .glass-card-body {
        padding: 1.25rem;
    }
}
</style>
@endpush

@section('content')

{{-- Success/Error Alerts --}}
@if(session('success'))
    <div class="alert-modern success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="alert-modern danger">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- Hero Section --}}
<div class="reapply-hero">
    <div class="reapply-hero-content">
        <div class="hero-icon-wrap">
            <i class="fas fa-redo-alt"></i>
        </div>
        <h2>Ajukan Ulang Magang</h2>
        <p class="hero-subtitle">Formulir pengajuan ulang program magang PT Telkom Indonesia</p>
    </div>
</div>

<div class="reapply-content">
    {{-- User Info Card --}}
    <div class="glass-card">
        <div class="glass-card-header">
            <div class="header-icon blue">
                <i class="fas fa-user-circle"></i>
            </div>
            <h5>Informasi Akun</h5>
        </div>
        <div class="glass-card-body">
            <div class="user-info-grid">
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <div>
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="info-label">NIM</div>
                        <div class="info-value">{{ $user->nim }}</div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <div>
                        <div class="info-label">Universitas</div>
                        <div class="info-value">{{ $user->university }}</div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <div class="info-label">Jurusan</div>
                        <div class="info-value">{{ $user->major }}</div>
                    </div>
                </div>
                <div class="user-info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="info-label">No HP</div>
                        <div class="info-value">{{ $user->phone }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="glass-card">
        <div class="glass-card-header">
            <div class="header-icon red">
                <i class="fas fa-edit"></i>
            </div>
            <h5>Formulir Pengajuan Ulang</h5>
        </div>
        <div class="glass-card-body">
            <form method="POST" action="{{ route('dashboard.submit-reapply') }}">
                @csrf

                <div class="form-group">
                    <label for="divisi_id">
                        <i class="fas fa-sitemap"></i> Pilih Divisi
                        <span class="required-star">*</span>
                    </label>
                    <select class="form-select @error('divisi_id') is-invalid @enderror" id="divisi_id" name="divisi_id" required>
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisis as $divisi)
                            <option value="{{ $divisi->id }}"
                                {{ (old('divisi_id') == $divisi->id || ($selectedDivisi && $selectedDivisi->id == $divisi->id)) ? 'selected' : '' }}>
                                {{ $divisi->subDirektorat->direktorat->name }} - {{ $divisi->subDirektorat->name }} - {{ $divisi->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('divisi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="date-grid">
                    <div class="form-group">
                        <label for="start_date">
                            <i class="fas fa-calendar-plus"></i> Tanggal Mulai
                            <span class="required-star">*</span>
                        </label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                               id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date">
                            <i class="fas fa-calendar-check"></i> Tanggal Selesai
                            <span class="required-star">*</span>
                        </label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                               id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="margin-top: 0.5rem;">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Ajukan Permintaan Magang
                    </button>
                    <a href="{{ route('dashboard.program') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Program Magang
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Previous Application Card --}}
    @if($latestApplication)
    <div class="glass-card">
        @php
            $statusClass = 'default';
            $statusIcon = 'fas fa-clock';
            $statusLabel = ucfirst($latestApplication->status);
            $headerIconColor = 'amber';

            if($latestApplication->status == 'rejected') {
                $statusClass = 'rejected';
                $statusIcon = 'fas fa-exclamation-triangle';
                $statusLabel = 'Ditolak';
                $headerIconColor = 'amber';
            } elseif($latestApplication->status == 'accepted') {
                $statusClass = 'accepted';
                $statusIcon = 'fas fa-check-circle';
                $statusLabel = 'Diterima';
                $headerIconColor = 'green';
            } elseif($latestApplication->status == 'finished') {
                $statusClass = 'finished';
                $statusIcon = 'fas fa-trophy';
                $statusLabel = 'Selesai';
                $headerIconColor = 'blue';
            }
        @endphp

        <div class="prev-app-header {{ $statusClass }}">
            <div class="header-icon {{ $headerIconColor }}" style="width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">
                <i class="{{ $statusIcon }}"></i>
            </div>
            <h5 style="margin:0;font-size:1rem;font-weight:600;color:#1f2937;">
                Pengajuan Sebelumnya
                <span class="status-badge {{ $statusClass }}" style="margin-left: 0.5rem;">
                    <i class="{{ $statusIcon }}"></i> {{ $statusLabel }}
                </span>
            </h5>
        </div>

        <div class="glass-card-body">
            <div class="prev-info-grid">
                <div class="prev-info-item">
                    <div>
                        <div class="item-label">Divisi</div>
                        <div class="item-value">{{ $latestApplication->divisi->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="prev-info-item">
                    <div>
                        <div class="item-label">Tanggal Pengajuan</div>
                        <div class="item-value">{{ $latestApplication->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                @if($latestApplication->start_date && $latestApplication->end_date)
                <div class="prev-info-item">
                    <div>
                        <div class="item-label">Tanggal Mulai</div>
                        <div class="item-value">
                            @if(is_string($latestApplication->start_date))
                                {{ \Carbon\Carbon::parse($latestApplication->start_date)->format('d M Y') }}
                            @else
                                {{ $latestApplication->start_date->format('d M Y') }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="prev-info-item">
                    <div>
                        <div class="item-label">Tanggal Selesai</div>
                        <div class="item-value">
                            @if(is_string($latestApplication->end_date))
                                {{ \Carbon\Carbon::parse($latestApplication->end_date)->format('d M Y') }}
                            @else
                                {{ $latestApplication->end_date->format('d M Y') }}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Contextual Notes --}}
            @if($latestApplication->status == 'rejected' && $latestApplication->notes)
                <div class="prev-notes-card rejection">
                    <div class="notes-title" style="color: #dc2626;">
                        <i class="fas fa-exclamation-circle"></i> Alasan Penolakan
                    </div>
                    <p class="notes-text" style="color: #7f1d1d;">{{ $latestApplication->notes }}</p>
                </div>
            @elseif($latestApplication->status == 'accepted')
                <div class="prev-notes-card success">
                    <div class="notes-title" style="color: #059669;">
                        <i class="fas fa-check-circle"></i> Status
                    </div>
                    <p class="notes-text" style="color: #065f46;">Pengajuan Anda telah diterima. Silakan selesaikan persyaratan tambahan.</p>
                </div>
            @elseif($latestApplication->status == 'finished')
                <div class="prev-notes-card info">
                    <div class="notes-title" style="color: #2563eb;">
                        <i class="fas fa-trophy"></i> Status
                    </div>
                    <p class="notes-text" style="color: #1e3a5f;">Selamat! Anda telah menyelesaikan program magang sebelumnya.</p>
                </div>
            @else
                <div class="prev-notes-card muted">
                    <div class="notes-title" style="color: #6b7280;">
                        <i class="fas fa-clock"></i> Status
                    </div>
                    <p class="notes-text" style="color: #4b5563;">Pengajuan Anda sedang dalam proses review.</p>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Auto-select divisi if coming from program page
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const divisiId = urlParams.get('divisi');

    if (divisiId) {
        const divisiSelect = document.getElementById('divisi_id');
        if (divisiSelect) {
            divisiSelect.value = divisiId;
        }
    }

    // Client-side validation for dates
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (startDateInput && endDateInput) {
        // Set minimum date for start_date to tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        startDateInput.min = tomorrow.toISOString().split('T')[0];

        // Update end_date minimum when start_date changes
        startDateInput.addEventListener('change', function() {
            if (this.value) {
                const startDate = new Date(this.value);
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.min = nextDay.toISOString().split('T')[0];

                // If end_date is before start_date, clear it
                if (endDateInput.value && endDateInput.value <= this.value) {
                    endDateInput.value = '';
                }
            }
        });
    }
});
</script>
@endpush

@endsection
