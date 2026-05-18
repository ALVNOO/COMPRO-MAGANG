{{-- ADMIN DIVISIONS PAGE (new flat structure) — Redesigned --}}

@extends('layouts.dashboard-unified')

@section('title', 'Kelola Divisi')

@php
    $role = 'admin';
    $totalDivisions  = $divisions->count();
    $activeDivisions = $divisions->where('is_active', true)->count();
    $totalMentors    = $divisions->sum(fn($d) => $d->mentors ? $d->mentors->count() : 0);
@endphp

@push('styles')
<style>
/* ── Stats ── */
.da-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.da-stat {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #E5E7EB;
    padding: 1.125rem 1.375rem;
    display: flex; align-items: center; gap: 1rem;
}

.da-stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.da-stat-icon.red   { background: rgba(238,46,36,.1); color: #EE2E24; }
.da-stat-icon.green { background: rgba(22,163,74,.1);  color: #16A34A; }
.da-stat-icon.blue  { background: rgba(37,99,235,.1);  color: #2563EB; }

.da-stat-val { font-size: 1.625rem; font-weight: 700; color: #111827; line-height: 1; margin-bottom: .2rem; }
.da-stat-lbl { font-size: .75rem; color: #6B7280; font-weight: 500; }

/* ── Mentor chips in table ── */
.mentor-chips { display: flex; flex-direction: column; gap: .4rem; }

.mentor-chip {
    display: inline-flex; align-items: center; gap: .5rem;
    font-size: .8rem;
}

.mentor-chip-name { font-weight: 600; color: #374151; }

.mentor-chip-nik {
    font-size: .7rem; font-weight: 700;
    background: #F3F4F6; color: #6B7280;
    border: 1px solid #E5E7EB;
    padding: .1rem .45rem; border-radius: 5px;
    font-family: ui-monospace, monospace;
}

/* ── Modal ── */
.da-modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 1000;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .2s, visibility .2s;
}

.da-modal-overlay.active { opacity: 1; visibility: visible; }

.da-modal {
    background: #fff;
    border-radius: 18px;
    width: 100%; max-width: 560px;
    max-height: 92vh; overflow-y: auto;
    box-shadow: 0 20px 50px rgba(0,0,0,.14);
    transform: translateY(14px) scale(.97);
    transition: transform .2s;
}

.da-modal-overlay.active .da-modal { transform: translateY(0) scale(1); }

.da-modal-head {
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid #F3F4F6;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; background: #fff; z-index: 1;
}

.da-modal-title {
    display: flex; align-items: center; gap: .625rem;
    font-size: .9375rem; font-weight: 700; color: #111827;
}

.da-modal-title-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: rgba(238,46,36,.1); color: #EE2E24;
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
}

.da-modal-close {
    width: 30px; height: 30px; border-radius: 8px;
    border: none; background: #F3F4F6; color: #6B7280;
    cursor: pointer; font-size: .85rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .12s;
}
.da-modal-close:hover { background: #E5E7EB; }

.da-modal-body { padding: 1.375rem 1.5rem; }

.da-form-field { margin-bottom: 1.125rem; }
.da-form-field:last-child { margin-bottom: 0; }

.da-form-label {
    display: block; font-size: .8rem; font-weight: 600;
    color: #374151; margin-bottom: .4rem;
}

.da-form-label .req { color: #EE2E24; }

.da-form-input {
    width: 100%; padding: .7rem .9rem;
    border: 1.5px solid #E5E7EB; border-radius: 10px;
    font-size: .875rem; background: #F9FAFB; color: #111827;
    transition: border-color .15s; box-sizing: border-box;
}
.da-form-input:focus { outline: none; border-color: #EE2E24; background: #fff; box-shadow: 0 0 0 3px rgba(238,46,36,.07); }

.da-form-error { font-size: .75rem; color: #DC2626; margin-top: .3rem; }

/* Mentors section */
.da-mentors-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .75rem;
}

.da-mentors-label { font-size: .8rem; font-weight: 600; color: #374151; }

.da-add-mentor-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .375rem .75rem;
    background: #DCFCE7; color: #16A34A;
    border: none; border-radius: 8px;
    font-size: .75rem; font-weight: 600;
    cursor: pointer; transition: background .12s;
}
.da-add-mentor-btn:hover { background: #BBF7D0; }

.da-mentors-list { display: flex; flex-direction: column; gap: .625rem; }

.da-mentor-row {
    background: #F9FAFB; border: 1.5px solid #E5E7EB;
    border-radius: 10px; padding: .875rem;
}

.da-mentor-row-grid {
    display: grid; grid-template-columns: 1fr 120px 30px;
    gap: .625rem; align-items: end;
}

.da-remove-mentor {
    width: 30px; height: 30px; border-radius: 7px;
    border: none; background: #FEE2E2; color: #DC2626;
    cursor: pointer; font-size: .75rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .12s; flex-shrink: 0;
}
.da-remove-mentor:hover { background: #FECACA; }

/* Active checkbox */
.da-checkbox-row {
    display: flex; align-items: center; gap: .75rem;
    padding: .875rem 1rem;
    background: #F9FAFB; border: 1.5px solid #E5E7EB;
    border-radius: 10px;
}

.da-checkbox-row input[type="checkbox"] { width: 17px; height: 17px; accent-color: #EE2E24; cursor: pointer; }
.da-checkbox-row label { font-size: .875rem; color: #374151; cursor: pointer; font-weight: 500; }

.da-modal-foot {
    padding: .875rem 1.5rem;
    border-top: 1px solid #F3F4F6;
    display: flex; justify-content: flex-end; gap: .625rem;
    position: sticky; bottom: 0; background: #fff;
}

.da-modal-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .625rem 1.25rem; border: none; border-radius: 10px;
    font-size: .875rem; font-weight: 600; cursor: pointer; transition: all .15s;
}
.da-modal-btn.cancel  { background: #F3F4F6; color: #374151; border: 1px solid #E5E7EB; }
.da-modal-btn.cancel:hover  { background: #E5E7EB; }
.da-modal-btn.primary { background: #EE2E24; color: #fff; }
.da-modal-btn.primary:hover { background: #C41E1A; }

/* Delete confirm modal */
.da-confirm-modal {
    max-width: 420px;
}

@media (max-width: 640px) {
    .da-stats { grid-template-columns: 1fr 1fr; }
    .da-stats .da-stat:last-child { grid-column: span 2; }
    .da-mentor-row-grid { grid-template-columns: 1fr 1fr; }
    .da-mentor-row-grid .da-remove-mentor { grid-column: span 2; width: 100%; height: 32px; }
}
</style>
@endpush

@section('content')

@php
    $initialMentors = old('mentors') ?? [['id' => null, 'mentor_name' => '', 'nik_number' => '']];
@endphp

<div x-data="divisionsManager()"
     data-initial-show-modal="{{ $errors->any() ? 'true' : 'false' }}"
     data-initial-form-mode="{{ old('form_mode', 'create') }}"
     data-initial-division-id="{{ old('division_id') }}"
     data-initial-division-name="{{ old('division_name') }}"
     data-initial-is-active="{{ old('is_active', 1) ? 'true' : 'false' }}"
     data-initial-mentors='@json($initialMentors)'>

<x-dashboard.page-context-bar
    title="Kelola Divisi"
    description="Kelola divisi dan pembimbing untuk program magang PT Telkom Indonesia"
    icon="fas fa-sitemap"
    role="admin"
>
    <button class="ctx-cta" @click="openModal('create')">
        <i class="fas fa-plus"></i> Tambah Divisi
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
<div class="da-stats">
    <div class="da-stat">
        <div class="da-stat-icon red"><i class="fas fa-sitemap"></i></div>
        <div>
            <div class="da-stat-val">{{ $totalDivisions }}</div>
            <div class="da-stat-lbl">Total Divisi</div>
        </div>
    </div>
    <div class="da-stat">
        <div class="da-stat-icon green"><i class="fas fa-circle-check"></i></div>
        <div>
            <div class="da-stat-val">{{ $activeDivisions }}</div>
            <div class="da-stat-lbl">Divisi Aktif</div>
        </div>
    </div>
    <div class="da-stat">
        <div class="da-stat-icon blue"><i class="fas fa-user-tie"></i></div>
        <div>
            <div class="da-stat-val">{{ $totalMentors }}</div>
            <div class="da-stat-lbl">Total Pembimbing</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-header">
        <div class="table-title">
            <i class="fas fa-list"></i>
            <span>Daftar Divisi</span>
        </div>
        <span class="badge badge-gray">{{ $totalDivisions }} Divisi</span>
    </div>

    @if($divisions->count() > 0)
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Divisi</th>
                    <th>Pembimbing</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($divisions as $index => $division)
                @php
                    $divisionPayload = [
                        'id'            => $division->id,
                        'division_name' => $division->division_name,
                        'is_active'     => (bool) $division->is_active,
                        'mentors'       => $division->mentors
                            ? $division->mentors->map(fn($m) => [
                                'id'          => $m->id,
                                'mentor_name' => $m->mentor_name,
                                'nik_number'  => $m->nik_number,
                            ])->values()->toArray()
                            : [],
                    ];
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td style="text-align:left;">
                        <span style="font-size:.875rem;font-weight:600;color:#111827;">{{ $division->division_name }}</span>
                    </td>

                    <td style="text-align:left;">
                        @if($division->mentors && $division->mentors->count() > 0)
                            <div class="mentor-chips">
                                @foreach($division->mentors as $mentor)
                                <div class="mentor-chip">
                                    <i class="fas fa-user-tie" style="color:#9CA3AF;font-size:.72rem;"></i>
                                    <span class="mentor-chip-name">{{ $mentor->mentor_name }}</span>
                                    <span class="mentor-chip-nik">{{ $mentor->nik_number }}</span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <span style="color:#D1D5DB;font-size:.8rem;">Belum ada pembimbing</span>
                        @endif
                    </td>

                    <td>
                        @if($division->is_active)
                            <span class="status-badge status-active"><i class="fas fa-circle-dot"></i> Aktif</span>
                        @else
                            <span class="status-badge" style="background:#F3F4F6;color:#9CA3AF;border-color:#E5E7EB;">
                                <i class="fas fa-circle-minus"></i> Nonaktif
                            </span>
                        @endif
                    </td>

                    <td>
                        <div style="display:flex;gap:.375rem;justify-content:center;flex-wrap:wrap;">
                            {{-- Edit --}}
                            <button class="btn btn-sm btn-warning"
                                    @click='openEditModal(@json($divisionPayload))'>
                                <i class="fas fa-pen"></i> Edit
                            </button>

                            {{-- Toggle status --}}
                            <form action="{{ route('admin.divisions.toggle', $division) }}" method="POST" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="fas {{ $division->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    {{ $division->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            {{-- Delete --}}
                            <button class="btn btn-sm btn-danger"
                                    @click="openDeleteConfirm({{ $division->id }}, '{{ addslashes($division->division_name) }}', '{{ route('admin.divisions.destroy', $division) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align:center;padding:4rem 2rem;">
        <i class="fas fa-sitemap" style="font-size:3rem;color:#E5E7EB;display:block;margin-bottom:1rem;"></i>
        <h4 style="font-size:1rem;font-weight:600;color:#374151;margin:0 0 .375rem;">Belum Ada Divisi</h4>
        <p style="font-size:.85rem;color:#9CA3AF;margin:0;">Klik <strong>Tambah Divisi</strong> untuk memulai</p>
    </div>
    @endif
</div>

{{-- ══ Create / Edit Modal ══ --}}
<div class="da-modal-overlay" :class="{ 'active': showModal }" @click.self="closeModal()">
    <div class="da-modal">
        <div class="da-modal-head">
            <div class="da-modal-title">
                <div class="da-modal-title-icon"><i class="fas fa-sitemap"></i></div>
                <span x-text="modalMode === 'create' ? 'Tambah Divisi Baru' : 'Edit Divisi'"></span>
            </div>
            <button class="da-modal-close" @click="closeModal()"><i class="fas fa-times"></i></button>
        </div>

        <form :action="formAction" method="POST" @submit="handleSubmit">
            @csrf
            <input type="hidden" name="_method" x-bind:value="modalMode === 'edit' ? 'PUT' : 'POST'">
            <input type="hidden" name="form_mode" x-model="modalMode">
            <input type="hidden" name="division_id" x-model="selectedDivisionId">

            <div class="da-modal-body">
                {{-- Division name --}}
                <div class="da-form-field">
                    <label class="da-form-label">Nama Divisi <span class="req">*</span></label>
                    <input type="text" name="division_name" class="da-form-input"
                           x-model="formData.division_name"
                           placeholder="Contoh: IT & Digital" required>
                    @error('division_name')
                        <div class="da-form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mentors --}}
                <div class="da-form-field">
                    <div class="da-mentors-head">
                        <span class="da-mentors-label">Pembimbing <span class="req">*</span></span>
                        <button type="button" class="da-add-mentor-btn" @click="addMentor()">
                            <i class="fas fa-plus"></i> Tambah Pembimbing
                        </button>
                    </div>
                    <div class="da-mentors-list">
                        <template x-for="(mentor, index) in formData.mentors" :key="index">
                            <div class="da-mentor-row">
                                <input type="hidden" :name="'mentors[' + index + '][id]'" x-model="mentor.id">
                                <div class="da-mentor-row-grid">
                                    <div class="da-form-field" style="margin:0;">
                                        <label class="da-form-label">Nama <span class="req">*</span></label>
                                        <input type="text" :name="'mentors[' + index + '][mentor_name]'"
                                               class="da-form-input" x-model="mentor.mentor_name"
                                               placeholder="Nama lengkap" required>
                                    </div>
                                    <div class="da-form-field" style="margin:0;">
                                        <label class="da-form-label">NIK <span class="req">*</span></label>
                                        <input type="text" :name="'mentors[' + index + '][nik_number]'"
                                               class="da-form-input" x-model="mentor.nik_number"
                                               placeholder="6 digit" maxlength="6" pattern="[0-9]{6}" required>
                                    </div>
                                    <button type="button" class="da-remove-mentor"
                                            @click="removeMentor(index)"
                                            x-show="formData.mentors.length > 1"
                                            title="Hapus pembimbing ini">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    @error('mentors')
                        <div class="da-form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Active toggle --}}
                <div class="da-checkbox-row">
                    <input type="checkbox" id="da_is_active" name="is_active" value="1"
                           x-model="formData.is_active">
                    <label for="da_is_active">Aktifkan divisi ini</label>
                </div>
            </div>

            <div class="da-modal-foot">
                <button type="button" class="da-modal-btn cancel" @click="closeModal()">Batal</button>
                <button type="submit" class="da-modal-btn primary">
                    <i class="fas fa-check"></i>
                    <span x-text="modalMode === 'create' ? 'Simpan' : 'Update'"></span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ Delete Confirm Modal ══ --}}
<div class="da-modal-overlay" :class="{ 'active': showDeleteModal }" @click.self="closeDeleteModal()">
    <div class="da-modal da-confirm-modal">
        <div class="da-modal-head">
            <div class="da-modal-title">
                <div class="da-modal-title-icon" style="background:rgba(220,38,38,.1);color:#DC2626;">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                Konfirmasi Hapus
            </div>
            <button class="da-modal-close" @click="closeDeleteModal()"><i class="fas fa-times"></i></button>
        </div>
        <form :action="deleteUrl" method="POST">
            @csrf @method('DELETE')
            <div class="da-modal-body">
                <p style="font-size:.9rem;color:#374151;margin:0 0 .4rem;">
                    Yakin ingin menghapus divisi "<strong x-text="deleteName"></strong>"?
                </p>
                <p style="font-size:.8rem;color:#9CA3AF;margin:0;">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="da-modal-foot">
                <button type="button" class="da-modal-btn cancel" @click="closeDeleteModal()">Batal</button>
                <button type="submit" class="da-modal-btn primary" style="background:#DC2626;">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>

</div>{{-- end x-data --}}
@endsection

@push('scripts')
<script>
function divisionsManager() {
    const rootEl = document.querySelector('[x-data="divisionsManager()"]');
    const dataset = rootEl ? rootEl.dataset : {};

    let mentors = [];
    try { mentors = JSON.parse(dataset.initialMentors || '[]'); } catch(e) {}
    if (!Array.isArray(mentors) || mentors.length === 0) {
        mentors = [{ id: null, mentor_name: '', nik_number: '' }];
    }

    return {
        showModal: dataset.initialShowModal === 'true',
        modalMode: dataset.initialFormMode || 'create',
        selectedDivisionId: dataset.initialDivisionId ? Number(dataset.initialDivisionId) : null,
        formData: {
            division_name: dataset.initialDivisionName || '',
            is_active: dataset.initialIsActive === 'true',
            mentors: mentors,
        },

        showDeleteModal: false,
        deleteName: '',
        deleteUrl: '',

        get formAction() {
            return this.modalMode === 'create'
                ? '{{ route("admin.divisions.store") }}'
                : '/admin/divisions/' + this.selectedDivisionId;
        },

        openModal(mode) {
            this.modalMode = mode;
            if (mode === 'create') this.resetForm();
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },

        openEditModal(division) {
            this.modalMode = 'edit';
            this.selectedDivisionId = division.id;
            this.formData = {
                division_name: division.division_name,
                is_active: division.is_active,
                mentors: division.mentors.length > 0
                    ? division.mentors.map(m => ({ id: m.id, mentor_name: m.mentor_name, nik_number: m.nik_number }))
                    : [{ id: null, mentor_name: '', nik_number: '' }],
            };
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeModal() {
            this.showModal = false;
            this.resetForm();
            document.body.style.overflow = '';
        },

        resetForm() {
            this.selectedDivisionId = null;
            this.formData = { division_name: '', is_active: true, mentors: [{ id: null, mentor_name: '', nik_number: '' }] };
        },

        addMentor()         { this.formData.mentors.push({ id: null, mentor_name: '', nik_number: '' }); },
        removeMentor(index) { if (this.formData.mentors.length > 1) this.formData.mentors.splice(index, 1); },
        handleSubmit()      { return true; },

        openDeleteConfirm(id, name, url) {
            this.deleteName = name;
            this.deleteUrl  = url;
            this.showDeleteModal = true;
            document.body.style.overflow = 'hidden';
        },

        closeDeleteModal() {
            this.showDeleteModal = false;
            document.body.style.overflow = '';
        },
    };
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const el = document.querySelector('[x-data="divisionsManager()"]');
        if (el && el._x_dataStack) {
            const data = el._x_dataStack[0];
            data.closeModal();
            data.closeDeleteModal();
        }
    }
});
</script>
@endpush
