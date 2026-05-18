@extends('layouts.dashboard-unified')

@section('title', 'Logbook Magang')

@php
    use Carbon\Carbon;
    $role      = 'participant';
    $pageTitle = 'Logbook';

    $totalLogbooks  = $logbooks->total();
    $thisMonthCount = $logbooks->getCollection()
        ->filter(fn($l) => $l->date->month === now()->month && $l->date->year === now()->year)
        ->count();
    $todayExists = $logbooks->getCollection()->contains(fn($l) => $l->date->isToday());
@endphp

@push('styles')
<style>
/* ── Stats ── */
.lb-stats {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* ── Card wrapper ── */
.lb-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    overflow: hidden;
}

/* Card header */
.lb-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: .875rem 1.25rem;
    border-bottom: 1px solid #F3F4F6;
}
.lb-card-title {
    font-size: .875rem; font-weight: 700; color: #111827;
    display: flex; align-items: center; gap: .5rem;
}
.lb-card-title i { color: #EE2E24; }

/* Add button */
.lb-add-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.125rem;
    background: linear-gradient(135deg,#EE2E24,#C41E1A);
    color: #fff; border: none; border-radius: 10px;
    font-size: .82rem; font-weight: 700;
    cursor: pointer; transition: all .18s;
    box-shadow: 0 3px 10px rgba(238,46,36,.25);
}
.lb-add-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 16px rgba(238,46,36,.35); }

/* ── Inline add panel ── */
.lb-add-panel {
    display: none;
    border-bottom: 1px solid #E5E7EB;
    background: #FFFBF9;
}
.lb-add-panel.open { display: block; }

.lb-add-inner {
    display: grid;
    grid-template-columns: 130px 1fr;
}

.lb-add-date-col {
    padding: 1rem 1.125rem;
    border-right: 1px solid #F3F4F6;
    display: flex; flex-direction: column; gap: .4rem;
}
.lb-add-date-lbl {
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .05em; color: #9CA3AF;
}
.lb-date-input {
    width: 100%;
    padding: .5rem .65rem;
    border: 1.5px solid #E5E7EB; border-radius: 9px;
    font-size: .82rem; color: #1E293B; background: #fff;
    font-family: ui-monospace, monospace;
    transition: border-color .15s;
}
.lb-date-input:focus {
    outline: none; border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238,46,36,.08);
}

.lb-add-content-col {
    padding: .875rem 1.25rem;
    display: flex; flex-direction: column; gap: .75rem;
}
.lb-textarea {
    width: 100%; min-height: 100px;
    padding: .65rem .875rem;
    border: 1.5px solid #E5E7EB; border-radius: 10px;
    font-size: .875rem; color: #374151; line-height: 1.7;
    resize: vertical; font-family: inherit;
    transition: border-color .15s;
}
.lb-textarea:focus {
    outline: none; border-color: #EE2E24;
    box-shadow: 0 0 0 3px rgba(238,46,36,.08);
}
.lb-add-actions {
    display: flex; gap: .5rem; justify-content: flex-end;
}

/* ── Shared button styles ── */
.lb-btn-save {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .5rem 1.125rem;
    background: linear-gradient(135deg,#EE2E24,#C41E1A);
    color: #fff; border: none; border-radius: 9px;
    font-size: .8rem; font-weight: 700; cursor: pointer; transition: all .18s;
    box-shadow: 0 3px 10px rgba(238,46,36,.2);
}
.lb-btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(238,46,36,.32); }
.lb-btn-save:disabled { opacity:.65; cursor:not-allowed; transform:none; }

.lb-btn-cancel {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .5rem 1rem;
    background: #fff; color: #6B7280;
    border: 1.5px solid #E5E7EB; border-radius: 9px;
    font-size: .8rem; font-weight: 600; cursor: pointer; transition: all .15s;
}
.lb-btn-cancel:hover { border-color: #9CA3AF; color: #374151; }

/* ── Logbook rows — same pattern as admin/mentor ── */
.lb-row {
    display: grid;
    grid-template-columns: 130px 1fr;
    border-bottom: 1px solid #F9FAFB;
}
.lb-row:last-child { border-bottom: none; }

.lb-row-date {
    padding: 1rem 1.125rem;
    border-right: 1px solid #F3F4F6;
    background: #FAFAFA;
    display: flex; flex-direction: column; gap: .2rem;
    flex-shrink: 0;
    align-items: center; justify-content: center; text-align: center;
}
.lb-row-day      { font-size: .72rem; font-weight: 700; color: #374151; }
.lb-row-date-num { font-size: 1.5rem; font-weight: 700; color: #EE2E24; line-height: 1; }
.lb-row-month    { font-size: .7rem; color: #9CA3AF; }

/* Edit mode: date column */
.lb-row-date-edit {
    padding: .875rem 1.125rem;
    border-right: 1px solid #F3F4F6;
    background: rgba(238,46,36,.03);
    display: flex; align-items: flex-start;
    flex-shrink: 0;
}

.lb-row-body {
    padding: .875rem 1.25rem;
    display: flex; flex-direction: column; gap: .5rem;
    min-width: 0;
}

.lb-row-content {
    font-size: .875rem; color: #374151; line-height: 1.65;
    white-space: pre-wrap; word-break: break-word;
    flex: 1;
}

/* Content + actions side-by-side row */
.lb-content-row {
    display: flex; align-items: flex-start; gap: .75rem;
}

/* Row action buttons */
.lb-row-actions {
    display: flex; gap: .4rem; align-items: center; flex-shrink: 0;
}
.lb-icon-btn {
    width: 30px; height: 30px;
    border-radius: 7px; border: none;
    cursor: pointer; transition: all .18s;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .75rem;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
}
.lb-icon-btn.edit { background: #fff; color: #D97706; border: 1.5px solid #FDE68A; }
.lb-icon-btn.edit:hover {
    background: #FFFBEB; border-color: #D97706;
    transform: translateY(-1px); box-shadow: 0 3px 10px rgba(217,119,6,.18);
}
.lb-icon-btn.del  { background: #fff; color: #DC2626; border: 1.5px solid #FECACA; }
.lb-icon-btn.del:hover {
    background: #FEF2F2; border-color: #DC2626;
    transform: translateY(-1px); box-shadow: 0 3px 10px rgba(220,38,38,.18);
}
.lb-icon-btn.save { background: #EE2E24; color: #fff; border: none; box-shadow: 0 2px 8px rgba(238,46,36,.25); }
.lb-icon-btn.save:hover { background: #C41E1A; transform: translateY(-1px); }
.lb-icon-btn.cancel-edit { background: #F3F4F6; color: #6B7280; border: 1.5px solid #E5E7EB; }
.lb-icon-btn.cancel-edit:hover { background: #E5E7EB; }

/* Inline delete confirm */
.lb-del-confirm {
    display: none;
    align-items: center;
    gap: .5rem;
    padding: .4rem .65rem;
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 9px;
    font-size: .78rem;
}
.lb-del-confirm span { color: #DC2626; font-weight: 600; }
.lb-del-confirm-yes {
    padding: .28rem .75rem;
    background: #DC2626; color: #fff;
    border: none; border-radius: 7px;
    font-size: .75rem; font-weight: 700; cursor: pointer;
    transition: background .15s;
}
.lb-del-confirm-yes:hover { background: #B91C1C; }
.lb-del-confirm-no {
    padding: .28rem .65rem;
    background: #fff; color: #6B7280;
    border: 1.5px solid #E5E7EB; border-radius: 7px;
    font-size: .75rem; font-weight: 600; cursor: pointer;
    transition: all .15s;
}
.lb-del-confirm-no:hover { border-color: #9CA3AF; }

/* Empty state */
.lb-empty { text-align: center; padding: 4rem 2rem; }
.lb-empty i  { font-size: 2.5rem; color: #D1D5DB; display: block; margin-bottom: 1rem; }
.lb-empty h4 { font-size: 1rem; font-weight: 600; color: #374151; margin: 0 0 .35rem; }
.lb-empty p  { color: #9CA3AF; font-size: .875rem; margin: 0; }

/* Error strip */
.lb-err {
    display: none;
    margin: 0 1.25rem .75rem;
    padding: .55rem .875rem;
    background: #FEF2F2; border: 1px solid #FECACA; border-radius: 9px;
    font-size: .8rem; color: #DC2626; font-weight: 500;
}

/* Responsive */
@media (max-width:1200px) { .lb-stats { grid-template-columns: repeat(3,1fr); } }
@media (max-width:640px)  {
    .lb-stats { grid-template-columns: repeat(2,1fr); }
    .lb-row, .lb-add-inner { grid-template-columns: 95px 1fr; }
    .lb-add-date-col { padding: .75rem .875rem; }
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Logbook Magang"
    description="Catat aktivitas harian magang Anda di PT Telkom Indonesia"
    icon="fas fa-book-open"
    role="peserta"
/>

{{-- Stat Cards --}}
<div class="lb-stats">
    <div class="stat-card stat-card-primary">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $totalLogbooks }}</div>
                <div class="stat-label">Total Logbook</div>
            </div>
            <div class="stat-icon stat-icon-primary"><i class="fas fa-book"></i></div>
        </div>
    </div>
    <div class="stat-card stat-card-info">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $thisMonthCount }}</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
            <div class="stat-icon stat-icon-info"><i class="fas fa-calendar-week"></i></div>
        </div>
    </div>
    <div class="stat-card {{ $todayExists ? 'stat-card-success' : 'stat-card-warning' }}">
        <div class="stat-card-header">
            <div class="stat-meta">
                <div class="stat-value">{{ $todayExists ? 'Sudah' : 'Belum' }}</div>
                <div class="stat-label">Logbook Hari Ini</div>
            </div>
            <div class="stat-icon {{ $todayExists ? 'stat-icon-success' : 'stat-icon-warning' }}">
                <i class="fas {{ $todayExists ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
            </div>
        </div>
    </div>
</div>

{{-- Logbook Card --}}
<div class="lb-card">

    {{-- Header --}}
    <div class="lb-card-head">
        <div class="lb-card-title">
            <i class="fas fa-list"></i> Catatan Harian
        </div>
        <div style="display:flex;align-items:center;gap:.75rem;">
            @if($totalLogbooks > 0)
                <span class="badge badge-gray">{{ $totalLogbooks }} entri</span>
            @endif
            <button type="button" class="lb-add-btn" id="btnOpenAdd">
                <i class="fas fa-plus"></i> Logbook Baru
            </button>
        </div>
    </div>

    {{-- Inline add form (hidden by default) --}}
    <div class="lb-add-panel" id="addPanel">
        <div id="addErrBox" class="lb-err"></div>
        <div class="lb-add-inner">
            <div class="lb-add-date-col">
                <span class="lb-add-date-lbl">Tanggal</span>
                <input type="date" id="addDate" class="lb-date-input" required>
            </div>
            <div class="lb-add-content-col">
                <textarea id="addContent" class="lb-textarea"
                          placeholder="Tulis aktivitas Anda hari ini…"></textarea>
                <div class="lb-add-actions">
                    <button type="button" class="lb-btn-cancel" id="btnCancelAdd">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="lb-btn-save" id="btnSaveAdd">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Logbook rows --}}
    @if($logbooks->count() > 0)

        <div id="lbList">
        @foreach($logbooks as $logbook)
        @php
            $lbDate = Carbon::parse($logbook->date);
        @endphp
        <div class="lb-row" id="row-{{ $logbook->id }}" data-id="{{ $logbook->id }}">

            {{-- Date column — view mode --}}
            <div class="lb-row-date view-date">
                <div class="lb-row-day">{{ $lbDate->locale('id')->isoFormat('dddd') }}</div>
                <div class="lb-row-date-num">{{ $lbDate->format('d') }}</div>
                <div class="lb-row-month">{{ $lbDate->locale('id')->isoFormat('MMM YYYY') }}</div>
            </div>

            {{-- Date column — edit mode --}}
            <div class="lb-row-date-edit edit-date" style="display:none;">
                <input type="date" class="lb-date-input edit-date-input"
                       value="{{ $logbook->date->format('Y-m-d') }}" style="width:110px;">
            </div>

            {{-- Content column --}}
            <div class="lb-row-body">

                {{-- View mode --}}
                <div class="view-content">
                    <div class="lb-content-row">
                        <div class="lb-row-content">{{ $logbook->content }}</div>
                        <div class="lb-row-actions">
                            <button type="button" class="lb-icon-btn edit btn-edit" title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="lb-icon-btn del btn-del-trigger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    {{-- Inline delete confirm --}}
                    <div class="lb-del-confirm del-confirm">
                        <span>Hapus logbook ini?</span>
                        <button type="button" class="lb-del-confirm-yes btn-del-confirm">Hapus</button>
                        <button type="button" class="lb-del-confirm-no btn-del-cancel">Batal</button>
                    </div>
                </div>

                {{-- Edit mode --}}
                <div class="edit-content" style="display:none;">
                    <div id="editErr-{{ $logbook->id }}" class="lb-err" style="margin:0 0 .5rem;"></div>
                    <textarea class="lb-textarea edit-textarea">{{ $logbook->content }}</textarea>
                    <div class="lb-row-actions" style="margin-top:.25rem;">
                        <button type="button" class="lb-icon-btn save btn-save-edit" title="Simpan">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" class="lb-icon-btn cancel-edit btn-cancel-edit" title="Batal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
        </div>

        @if($logbooks->hasPages())
        <div style="padding:1.125rem 1.375rem;border-top:1px solid #F3F4F6;">
            {{ $logbooks->links() }}
        </div>
        @endif

    @else
        <div class="lb-empty" id="emptyState">
            <i class="fas fa-book-open"></i>
            <h4>Belum Ada Logbook</h4>
            <p>Klik "Logbook Baru" untuk mulai mencatat aktivitas harian Anda.</p>
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
const _csrf     = '{{ csrf_token() }}';
const _storeUrl = '{{ route("logbook.store") }}';

// ── Add panel ────────────────────────────────────────────────────
const addPanel  = document.getElementById('addPanel');
const btnOpen   = document.getElementById('btnOpenAdd');
const btnCancel = document.getElementById('btnCancelAdd');
const btnSave   = document.getElementById('btnSaveAdd');
const addDate   = document.getElementById('addDate');
const addContent= document.getElementById('addContent');
const addErrBox = document.getElementById('addErrBox');

btnOpen.addEventListener('click', function () {
    addPanel.classList.toggle('open');
    if (addPanel.classList.contains('open')) {
        addDate.value    = new Date().toISOString().split('T')[0];
        addContent.value = '';
        addErrBox.style.display = 'none';
        addContent.focus();
        btnOpen.innerHTML = '<i class="fas fa-times"></i> Tutup';
    } else {
        btnOpen.innerHTML = '<i class="fas fa-plus"></i> Logbook Baru';
    }
});

btnCancel.addEventListener('click', function () {
    addPanel.classList.remove('open');
    btnOpen.innerHTML = '<i class="fas fa-plus"></i> Logbook Baru';
});

btnSave.addEventListener('click', async function () {
    const date    = addDate.value;
    const content = addContent.value.trim();
    if (!date || !content) {
        showErr(addErrBox, 'Tanggal dan isi logbook wajib diisi.');
        return;
    }
    addErrBox.style.display = 'none';
    const orig = setLoading(btnSave, 'Menyimpan…');
    try {
        const res  = await post(_storeUrl, { date, content });
        const data = await res.json();
        if (res.ok && data.success) { location.reload(); }
        else { showErr(addErrBox, data.message || 'Gagal menyimpan.'); resetBtn(btnSave, orig); }
    } catch { showErr(addErrBox, 'Gagal terhubung ke server.'); resetBtn(btnSave, orig); }
});

// ── Inline edit & delete (event delegation) ──────────────────────
document.addEventListener('click', async function (e) {

    // Open edit mode
    if (e.target.closest('.btn-edit')) {
        const row = e.target.closest('.lb-row');
        closeAllEdits(row);
        row.querySelector('.view-date').style.display  = 'none';
        row.querySelector('.edit-date').style.display  = 'flex';
        row.querySelector('.view-content').style.display = 'none';
        row.querySelector('.edit-content').style.display = 'flex';
        row.querySelector('.edit-content').style.flexDirection = 'column';
        row.querySelector('.edit-textarea').focus();
        const errEl = row.querySelector('.lb-err');
        if (errEl) errEl.style.display = 'none';
    }

    // Cancel edit
    if (e.target.closest('.btn-cancel-edit')) {
        const row = e.target.closest('.lb-row');
        resetRow(row);
    }

    // Save edit
    if (e.target.closest('.btn-save-edit')) {
        const row     = e.target.closest('.lb-row');
        const id      = row.dataset.id;
        const dateVal = row.querySelector('.edit-date-input').value;
        const content = row.querySelector('.edit-textarea').value.trim();
        const errEl   = row.querySelector('[id^="editErr-"]');
        if (!dateVal || !content) { showErr(errEl, 'Tanggal dan isi wajib diisi.'); return; }
        if (errEl) errEl.style.display = 'none';
        const saveBtn = e.target.closest('.btn-save-edit');
        const orig    = setLoading(saveBtn, '');
        try {
            const res  = await post(`/logbook/${id}`, { date: dateVal, content }, 'PUT');
            const data = await res.json();
            if (res.ok && data.success) { location.reload(); }
            else { showErr(errEl, data.message || 'Gagal menyimpan.'); resetBtn(saveBtn, orig); }
        } catch { showErr(errEl, 'Gagal terhubung.'); resetBtn(saveBtn, orig); }
    }

    // Show delete confirm
    if (e.target.closest('.btn-del-trigger')) {
        const row    = e.target.closest('.lb-row');
        const actions= row.querySelector('.lb-row-actions');
        const confirm= row.querySelector('.del-confirm');
        actions.style.display  = 'none';
        confirm.style.display  = 'flex';
    }

    // Cancel delete
    if (e.target.closest('.btn-del-cancel')) {
        const row    = e.target.closest('.lb-row');
        row.querySelector('.lb-row-actions').style.display = 'flex';
        row.querySelector('.del-confirm').style.display    = 'none';
    }

    // Confirm delete
    if (e.target.closest('.btn-del-confirm')) {
        const row = e.target.closest('.lb-row');
        const id  = row.dataset.id;
        const btn = e.target.closest('.btn-del-confirm');
        btn.disabled    = true;
        btn.textContent = '…';
        try {
            const res  = await fetch(`/logbook/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': _csrf, 'Accept': 'application/json' },
            });
            const data = await res.json();
            if (res.ok && data.success) { location.reload(); }
            else { btn.disabled = false; btn.textContent = 'Hapus'; }
        } catch { btn.disabled = false; btn.textContent = 'Hapus'; }
    }
});

// ── Helpers ──────────────────────────────────────────────────────
function resetRow(row) {
    row.querySelector('.view-date').style.display    = '';
    row.querySelector('.edit-date').style.display    = 'none';
    row.querySelector('.view-content').style.display = '';
    row.querySelector('.edit-content').style.display = 'none';
}

function closeAllEdits(except) {
    document.querySelectorAll('.lb-row').forEach(r => {
        if (r !== except) resetRow(r);
    });
}

function showErr(el, msg) {
    if (!el) return;
    el.textContent    = msg;
    el.style.display  = 'block';
}

function setLoading(btn, msg) {
    const orig = btn.innerHTML;
    btn.disabled  = true;
    btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${msg}`;
    return orig;
}

function resetBtn(btn, orig) {
    btn.disabled  = false;
    btn.innerHTML = orig;
}

async function post(url, body, method = 'POST') {
    return fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': _csrf,
            'Accept': 'application/json',
        },
        body: JSON.stringify(body),
    });
}
</script>
@endpush
