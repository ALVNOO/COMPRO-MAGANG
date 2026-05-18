@extends('layouts.dashboard-unified')

@section('title', 'Profil Admin')

@php
    $role = 'admin';
    $names = explode(' ', $user->name ?? 'Admin');
    $initials = strtoupper(substr($names[0], 0, 1)) . (isset($names[1]) ? strtoupper(substr($names[1], 0, 1)) : '');
@endphp

@push('styles')
<style>
/* ── Profile Page ── */
.profile-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.5rem;
    align-items: start;
}

/* Left column — photo card */
.photo-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    overflow: hidden;
}

.photo-card-top {
    background: linear-gradient(160deg, #EE2E24 0%, #9B1C1C 100%);
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.photo-card-top::before {
    content: '';
    position: absolute;
    top: -40%; right: -30%;
    width: 80%; height: 80%;
    background: radial-gradient(circle, rgba(255,255,255,.15) 0%, transparent 70%);
}

.avatar-ring {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,.6);
    background: rgba(255,255,255,.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    overflow: hidden;
    position: relative;
    z-index: 1;
    margin-bottom: .875rem;
}

.avatar-ring img { width: 100%; height: 100%; object-fit: cover; }

.photo-name {
    font-size: .9375rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    margin-bottom: .4rem;
    position: relative; z-index: 1;
}

.photo-role {
    display: inline-flex;
    align-items: center;
    padding: .2rem .65rem;
    background: rgba(255,255,255,.2);
    border: 1px solid rgba(255,255,255,.35);
    border-radius: 9999px;
    font-size: .68rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: .04em;
    text-transform: uppercase;
    position: relative; z-index: 1;
}

.photo-card-actions {
    padding: 1rem 1.25rem;
    display: flex;
    flex-direction: column;
    gap: .625rem;
}

.btn-photo-upload {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .625rem;
    background: #EE2E24;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    width: 100%;
}

.btn-photo-upload:hover { background: #C41E1A; }

.btn-photo-remove {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .55rem;
    background: #fff;
    color: #6B7280;
    border: 1px solid #E5E7EB;
    border-radius: 10px;
    font-size: .78rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    width: 100%;
}

.btn-photo-remove:hover { background: #FEF2F2; color: #DC2626; border-color: #FCA5A5; }

.photo-hint {
    font-size: .7rem;
    color: #9CA3AF;
    text-align: center;
    padding: 0 1.25rem .75rem;
    line-height: 1.4;
}

/* Right column — info + form cards */
.info-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    overflow: hidden;
    margin-bottom: 1.25rem;
}

.info-card:last-child { margin-bottom: 0; }

.card-head {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #F3F4F6;
}

.card-head-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(238,46,36,.08);
    color: #EE2E24;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .9rem;
    flex-shrink: 0;
}

.card-head-icon.dark {
    background: #F3F4F6;
    color: #374151;
}

.card-head-title {
    font-size: .9rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.card-head-sub {
    font-size: .75rem;
    color: #9CA3AF;
    margin: .1rem 0 0;
}

.card-body { padding: 1.5rem; }

/* Read-only info rows */
.ro-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .75rem 0;
    border-bottom: 1px solid #F9FAFB;
}

.ro-row:last-child { border-bottom: none; padding-bottom: 0; }
.ro-row:first-child { padding-top: 0; }

.ro-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #F9FAFB;
    border: 1px solid #E5E7EB;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6B7280;
    font-size: .8rem;
    flex-shrink: 0;
}

.ro-label {
    font-size: .7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #9CA3AF;
    margin-bottom: .15rem;
}

.ro-value {
    font-size: .875rem;
    font-weight: 600;
    color: #111827;
}

/* Form */
.form-field { margin-bottom: 1.125rem; }
.form-field:last-of-type { margin-bottom: 0; }

.f-label {
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .45rem;
    display: block;
}

.f-wrap { position: relative; }

.f-input {
    width: 100%;
    padding: .75rem 1rem .75rem 2.75rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: .875rem;
    background: #F9FAFB;
    color: #111827;
    transition: all .18s;
    box-sizing: border-box;
}

.f-input:focus {
    outline: none;
    border-color: #EE2E24;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(238,46,36,.07);
}

.f-input.is-invalid { border-color: #EF4444; background: #FEF2F2; }

.f-icon {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF;
    font-size: .85rem;
}

.f-error { font-size: .76rem; color: #DC2626; margin-top: .3rem; }

.btn-save {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    padding: .65rem 1.5rem;
    background: #EE2E24;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: .85rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    margin-top: 1rem;
}

.btn-save:hover { background: #C41E1A; }

/* Security action links */
.sec-links { display: flex; gap: .875rem; flex-wrap: wrap; }

.sec-link {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .75rem 1.125rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 12px;
    text-decoration: none;
    color: #374151;
    font-size: .85rem;
    font-weight: 600;
    transition: all .15s;
    flex: 1;
    min-width: 160px;
}

.sec-link i { font-size: .9rem; color: #9CA3AF; }
.sec-link:hover { border-color: #EE2E24; color: #EE2E24; background: #FEF2F2; }
.sec-link:hover i { color: #EE2E24; }

@media (max-width: 860px) {
    .profile-layout { grid-template-columns: 1fr; }
}

/* ── Crop Dialog ── */
.crop-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(3px);
    display: flex; align-items: center; justify-content: center;
    z-index: 9999; padding: 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .25s, visibility .25s;
}
.crop-overlay.show { opacity: 1; visibility: visible; }

.crop-dialog {
    background: #fff; border-radius: 16px;
    width: 100%; max-width: 620px; max-height: 90vh;
    overflow: hidden;
    transform: scale(.94) translateY(12px);
    transition: transform .25s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 20px 50px rgba(0,0,0,.18);
}
.crop-overlay.show .crop-dialog { transform: scale(1) translateY(0); }

.crop-dialog-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.125rem 1.5rem; border-bottom: 1px solid #F3F4F6;
}
.crop-dialog-head h3 { font-size: .95rem; font-weight: 700; color: #111827; margin: 0; }

.crop-close {
    width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
    background: #F3F4F6; border: none; border-radius: 8px;
    cursor: pointer; color: #6B7280; font-size: .85rem; transition: all .15s;
}
.crop-close:hover { background: #E5E7EB; color: #111827; }

.crop-dialog-body {
    display: flex; gap: 1.25rem;
    padding: 1.25rem 1.5rem; background: #F9FAFB;
    overflow-y: auto; max-height: calc(90vh - 130px);
}
.crop-canvas-wrap {
    flex: 1; border-radius: 10px; overflow: hidden; background: #E5E7EB; max-height: 340px;
}
.crop-canvas-wrap img { display: block; max-width: 100%; }

.crop-preview-col {
    display: flex; flex-direction: column; align-items: center; gap: .625rem;
    background: #fff; border-radius: 10px; padding: 1rem;
    border: 1px solid #E5E7EB; flex-shrink: 0;
}
.crop-preview-label {
    font-size: .65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #9CA3AF;
}
.crop-preview-circle {
    width: 96px; height: 96px; border-radius: 50%; overflow: hidden;
    border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,.1); background: #F3F4F6;
}

.crop-dialog-foot {
    display: flex; align-items: center; justify-content: space-between;
    padding: .875rem 1.5rem; border-top: 1px solid #F3F4F6; background: #fff;
}
.crop-tools { display: flex; gap: .375rem; }
.crop-tool {
    width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
    background: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 8px;
    cursor: pointer; color: #6B7280; font-size: .82rem; transition: all .15s;
}
.crop-tool:hover { border-color: #EE2E24; color: #EE2E24; background: #FEF2F2; }
.crop-actions { display: flex; gap: .5rem; }
.crop-btn-cancel {
    padding: .55rem 1rem; background: #fff; border: 1.5px solid #E5E7EB;
    border-radius: 8px; font-size: .8rem; font-weight: 600; color: #374151;
    cursor: pointer; transition: background .15s;
}
.crop-btn-cancel:hover { background: #F3F4F6; }
.crop-btn-apply {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .55rem 1.125rem; background: #EE2E24; border: none;
    border-radius: 8px; font-size: .8rem; font-weight: 600; color: #fff;
    cursor: pointer; transition: background .15s;
}
.crop-btn-apply:hover { background: #C41E1A; }
.crop-btn-apply:disabled { opacity: .65; cursor: not-allowed; }

/* Cropper.js circular overrides */
.cropper-view-box, .cropper-face { border-radius: 50%; }
.cropper-view-box { outline: 2px solid #EE2E24; outline-offset: -2px; }
.cropper-modal { background: rgba(0,0,0,.3) !important; opacity: 1 !important; }
.cropper-bg { background-image: none !important; }
.cropper-dashed { border-color: rgba(255,255,255,.4); }
.cropper-center { opacity: 0; }
.cropper-point { background: #EE2E24; width: 9px; height: 9px; border-radius: 50%; }
.cropper-line { background: #EE2E24; opacity: .2; }
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Profil Admin"
    description="Kelola foto, informasi kontak, dan keamanan akun"
    icon="fas fa-user-shield"
    role="admin"
/>

@if(session('photo_success'))
    <div class="alert alert-compact alert-success" style="margin-bottom:1rem;">
        <div class="alert-icon-box"><i class="fas fa-check"></i></div>
        <div class="alert-content"><div class="alert-title">{{ session('photo_success') }}</div></div>
    </div>
@endif

<div class="profile-layout">

    {{-- Left: Photo Card --}}
    <div class="photo-card">
        <div class="photo-card-top">
            <div class="avatar-ring">
                @if($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                @else
                    {{ $initials }}
                @endif
            </div>
            <div class="photo-name">{{ $user->name }}</div>
            <span class="photo-role">Administrator</span>
        </div>

        <div class="photo-card-actions">
            <input type="file" id="photoInput" accept="image/jpg,image/jpeg,image/png" style="display:none;">
            <button type="button" class="btn-photo-upload" onclick="document.getElementById('photoInput').click()">
                <i class="fas fa-camera"></i>
                {{ $user->profile_picture ? 'Ganti Foto' : 'Unggah Foto' }}
            </button>
            @if($user->profile_picture)
            <button type="button" class="btn-photo-remove" id="btnRemovePhoto">
                <i class="fas fa-trash-alt"></i> Hapus Foto
            </button>
            @endif
        </div>
        <p class="photo-hint">JPG, JPEG, atau PNG · Maks. 2 MB</p>
    </div>

    {{-- Right: Info + Edit Cards --}}
    <div>
        {{-- Account Info (read-only) --}}
        <div class="info-card">
            <div class="card-head">
                <div class="card-head-icon"><i class="fas fa-user-circle"></i></div>
                <div>
                    <div class="card-head-title">Informasi Akun</div>
                    <div class="card-head-sub">Data akun tidak dapat diubah</div>
                </div>
            </div>
            <div class="card-body">
                <div class="ro-row">
                    <div class="ro-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="ro-label">Nama Lengkap</div>
                        <div class="ro-value">{{ $user->name }}</div>
                    </div>
                </div>
                <div class="ro-row">
                    <div class="ro-icon"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="ro-label">Email</div>
                        <div class="ro-value">{{ $user->email }}</div>
                    </div>
                </div>
                <div class="ro-row">
                    <div class="ro-icon"><i class="fas fa-id-badge"></i></div>
                    <div>
                        <div class="ro-label">Username</div>
                        <div class="ro-value">{{ $user->username }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Form --}}
        <div class="info-card">
            <div class="card-head">
                <div class="card-head-icon"><i class="fab fa-whatsapp"></i></div>
                <div>
                    <div class="card-head-title">Nomor WhatsApp</div>
                    <div class="card-head-sub">Ditampilkan kepada pembimbing sebagai kontak admin</div>
                </div>
            </div>
            <div class="card-body">
                @if(session('biodata_success'))
                    <div class="alert alert-compact alert-success" style="margin-bottom:1rem;">
                        <div class="alert-icon-box"><i class="fas fa-check"></i></div>
                        <div class="alert-content"><div class="alert-title">{{ session('biodata_success') }}</div></div>
                    </div>
                @endif
                @if($errors->biodata->any())
                    <div class="alert alert-compact alert-danger" style="margin-bottom:1rem;">
                        <div class="alert-icon-box"><i class="fas fa-times"></i></div>
                        <div class="alert-content"><div class="alert-title">{{ $errors->biodata->first() }}</div></div>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.biodata') }}">
                    @csrf
                    <div class="form-field">
                        <label class="f-label" for="phone">Nomor WhatsApp</label>
                        <div class="f-wrap">
                            <input type="text" id="phone" name="phone"
                                   class="f-input @if($errors->biodata->has('phone')) is-invalid @endif"
                                   placeholder="Contoh: 081234567890"
                                   value="{{ old('phone', $user->phone) }}">
                            <i class="fas fa-phone f-icon"></i>
                        </div>
                        @if($errors->biodata->has('phone'))
                            <div class="f-error">{{ $errors->biodata->first('phone') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-check"></i> Simpan
                    </button>
                </form>
            </div>
        </div>

        {{-- Security Links --}}
        <div class="info-card">
            <div class="card-head">
                <div class="card-head-icon dark"><i class="fas fa-shield-halved"></i></div>
                <div>
                    <div class="card-head-title">Keamanan Akun</div>
                    <div class="card-head-sub">Password dan autentikasi dua faktor</div>
                </div>
            </div>
            <div class="card-body">
                <div class="sec-links">
                    <a href="{{ route('password.change') }}" class="sec-link">
                        <i class="fas fa-lock"></i>
                        <div>
                            <div style="font-size:.85rem;font-weight:600;">Ganti Password</div>
                            <div style="font-size:.72rem;color:#9CA3AF;font-weight:400;margin-top:.1rem;">Ubah kata sandi akun</div>
                        </div>
                    </a>
                    <a href="{{ route('2fa.setup') }}" class="sec-link">
                        <i class="fas fa-mobile-screen"></i>
                        <div>
                            <div style="font-size:.85rem;font-weight:600;">Autentikasi 2FA</div>
                            <div style="font-size:.72rem;color:#9CA3AF;font-weight:400;margin-top:.1rem;">Kelola Google Authenticator</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Crop Dialog --}}
<div class="crop-overlay" id="cropOverlay">
    <div class="crop-dialog">
        <div class="crop-dialog-head">
            <h3>Sesuaikan Foto Profil</h3>
            <button type="button" class="crop-close" id="cropClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="crop-dialog-body">
            <div class="crop-canvas-wrap">
                <img id="cropImage" src="" alt="crop">
            </div>
            <div class="crop-preview-col">
                <div class="crop-preview-label">Preview</div>
                <div class="crop-preview-circle" id="cropPreviewCircle"></div>
            </div>
        </div>
        <div class="crop-dialog-foot">
            <div class="crop-tools">
                <button type="button" class="crop-tool" data-action="rotate-left" title="Putar kiri"><i class="fas fa-rotate-left"></i></button>
                <button type="button" class="crop-tool" data-action="rotate-right" title="Putar kanan"><i class="fas fa-rotate-right"></i></button>
                <button type="button" class="crop-tool" data-action="zoom-in" title="Perbesar"><i class="fas fa-magnifying-glass-plus"></i></button>
                <button type="button" class="crop-tool" data-action="zoom-out" title="Perkecil"><i class="fas fa-magnifying-glass-minus"></i></button>
                <button type="button" class="crop-tool" data-action="reset" title="Reset"><i class="fas fa-arrows-rotate"></i></button>
            </div>
            <div class="crop-actions">
                <button type="button" class="crop-btn-cancel" id="cropCancel">Batal</button>
                <button type="button" class="crop-btn-apply" id="cropApply"><i class="fas fa-check"></i> Terapkan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('photoInput');
    const btnRemove  = document.getElementById('btnRemovePhoto');
    const overlay    = document.getElementById('cropOverlay');
    const cropImg    = document.getElementById('cropImage');
    const closeBtn   = document.getElementById('cropClose');
    const cancelBtn  = document.getElementById('cropCancel');
    const applyBtn   = document.getElementById('cropApply');
    let cropper = null;

    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        if (!['image/jpeg','image/jpg','image/png'].includes(file.type)) {
            alert('Format harus JPG atau PNG.'); this.value = ''; return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran maksimal 2 MB.'); this.value = ''; return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            cropImg.src = e.target.result;
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
            cropImg.onload = function () {
                if (cropper) cropper.destroy();
                cropper = new Cropper(cropImg, {
                    aspectRatio: 1, viewMode: 1, dragMode: 'move',
                    autoCropArea: 0.85, restore: false, guides: true,
                    center: true, highlight: false, background: false,
                    cropBoxMovable: true, cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                    preview: '#cropPreviewCircle',
                });
            };
        };
        reader.readAsDataURL(file);
        this.value = '';
    });

    function closeDialog() {
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        if (cropper) { cropper.destroy(); cropper = null; }
        cropImg.src = '';
    }

    closeBtn.addEventListener('click', closeDialog);
    cancelBtn.addEventListener('click', closeDialog);
    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeDialog(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeDialog(); });

    document.querySelectorAll('.crop-tool[data-action]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!cropper) return;
            const a = this.dataset.action;
            if (a === 'rotate-left')  cropper.rotate(-90);
            if (a === 'rotate-right') cropper.rotate(90);
            if (a === 'zoom-in')      cropper.zoom(.1);
            if (a === 'zoom-out')     cropper.zoom(-.1);
            if (a === 'reset')        cropper.reset();
        });
    });

    applyBtn.addEventListener('click', function () {
        if (!cropper) return;
        applyBtn.disabled = true;
        applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        cropper.getCroppedCanvas({ width: 400, height: 400 }).toBlob(function (blob) {
            const file = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
            const fd = new FormData();
            fd.append('profile_picture', file);
            fd.append('_token', '{{ csrf_token() }}');
            fetch('{{ route("admin.profile.picture") }}', {
                method: 'POST', body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => { if (d.success) location.reload(); else { alert(d.message || 'Gagal mengunggah.'); applyBtn.disabled = false; applyBtn.innerHTML = '<i class="fas fa-check"></i> Terapkan'; }})
            .catch(() => { alert('Terjadi kesalahan.'); applyBtn.disabled = false; applyBtn.innerHTML = '<i class="fas fa-check"></i> Terapkan'; });
            closeDialog();
        }, 'image/jpeg', 0.9);
    });

    if (btnRemove) {
        btnRemove.addEventListener('click', function () {
            if (!confirm('Hapus foto profil?')) return;
            btnRemove.disabled = true;
            fetch('{{ route("admin.profile.picture.remove") }}', {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(d => { if (d.success) location.reload(); else { alert(d.message || 'Gagal.'); btnRemove.disabled = false; }})
            .catch(() => { alert('Terjadi kesalahan.'); btnRemove.disabled = false; });
        });
    }
});
</script>
@endpush
