@extends('layouts.dashboard-unified')

@section('title', 'Ganti Password')

@php
    $role = match(auth()->user()->role) {
        'admin'      => 'admin',
        'pembimbing' => 'mentor',
        default      => 'participant',
    };
@endphp

@push('styles')
<style>
.cp-wrap {
    max-width: 520px;
    margin: 0 auto;
}

.cp-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    overflow: hidden;
}

.cp-head {
    background: linear-gradient(160deg, #1F2937 0%, #111827 100%);
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    overflow: hidden;
}

.cp-head::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 60%; height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,.06) 0%, transparent 70%);
}

.cp-head-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #fff;
    flex-shrink: 0;
    position: relative; z-index: 1;
}

.cp-head-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 .2rem;
    position: relative; z-index: 1;
}

.cp-head-sub {
    font-size: .8rem;
    color: rgba(255,255,255,.6);
    margin: 0;
    position: relative; z-index: 1;
}

.cp-body { padding: 1.75rem 2rem; }

/* Fields */
.cp-field { margin-bottom: 1.125rem; }
.cp-field:last-of-type { margin-bottom: 0; }

.cp-label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .45rem;
}

.cp-input-wrap { position: relative; }

.cp-input {
    width: 100%;
    padding: .75rem 2.75rem .75rem 2.75rem;
    border: 1.5px solid #E5E7EB;
    border-radius: 10px;
    font-size: .875rem;
    background: #F9FAFB;
    color: #111827;
    transition: all .18s;
    box-sizing: border-box;
}

.cp-input:focus {
    outline: none;
    border-color: #374151;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(55,65,81,.07);
}

.cp-input.is-invalid { border-color: #EF4444; background: #FEF2F2; }
.cp-input.is-valid   { border-color: #22C55E; background: #F0FDF4; }

.cp-icon-left {
    position: absolute;
    left: .9rem; top: 50%;
    transform: translateY(-50%);
    color: #9CA3AF; font-size: .85rem;
}

.cp-toggle {
    position: absolute;
    right: .9rem; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    color: #9CA3AF; font-size: .85rem;
    cursor: pointer; padding: 0;
    transition: color .15s;
}

.cp-toggle:hover { color: #374151; }

.cp-error { font-size: .76rem; color: #DC2626; margin-top: .3rem; }

/* Strength bar */
.strength-wrap { margin-top: .5rem; }

.strength-bar {
    height: 3px;
    border-radius: 2px;
    background: #E5E7EB;
    overflow: hidden;
}

.strength-fill {
    height: 100%;
    border-radius: 2px;
    transition: all .3s;
    width: 0%;
}

.strength-fill.weak   { background: #EF4444; }
.strength-fill.medium { background: #F59E0B; }
.strength-fill.strong { background: #22C55E; }

.strength-text {
    font-size: .72rem;
    color: #9CA3AF;
    margin-top: .3rem;
}

.strength-text.weak   { color: #EF4444; }
.strength-text.medium { color: #D97706; }
.strength-text.strong { color: #16A34A; }

/* Submit button */
.cp-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    width: 100%;
    padding: .8rem;
    background: #1F2937;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: .9rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
    margin-top: 1.375rem;
}

.cp-submit:hover { background: #111827; }

/* Back link */
.cp-back {
    text-align: center;
    margin-top: 1rem;
    font-size: .8rem;
    color: #6B7280;
}

.cp-back a {
    color: #EE2E24;
    text-decoration: none;
    font-weight: 600;
}

.cp-back a:hover { text-decoration: underline; }

/* Divider between fields */
.cp-divider {
    height: 1px;
    background: #F3F4F6;
    margin: 1.25rem 0;
}
</style>
@endpush

@section('content')

<x-dashboard.page-context-bar
    title="Ganti Password"
    description="Perbarui kata sandi akun Anda"
    icon="fas fa-lock"
    :role="$role"
/>

<div class="cp-wrap">
    <div class="cp-card">

        {{-- Header --}}
        <div class="cp-head">
            <div class="cp-head-icon"><i class="fas fa-key"></i></div>
            <div>
                <h3 class="cp-head-title">Ubah Kata Sandi</h3>
                <p class="cp-head-sub">Gunakan password yang kuat dan unik</p>
            </div>
        </div>

        {{-- Body --}}
        <div class="cp-body">

            @if(session('success'))
                <div class="alert alert-compact alert-success" style="margin-bottom:1.25rem;">
                    <div class="alert-icon-box"><i class="fas fa-check"></i></div>
                    <div class="alert-content"><div class="alert-title">{{ session('success') }}</div></div>
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="alert alert-compact alert-danger" style="margin-bottom:1.25rem;">
                    <div class="alert-icon-box"><i class="fas fa-times"></i></div>
                    <div class="alert-content">
                        <div class="alert-title">
                            {{ session('error') ?? $errors->first() }}
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" id="cpForm">
                @csrf

                {{-- Current password --}}
                <div class="cp-field">
                    <label class="cp-label" for="current_password">Password Saat Ini</label>
                    <div class="cp-input-wrap">
                        <i class="fas fa-lock cp-icon-left"></i>
                        <input type="password" id="current_password" name="current_password"
                               class="cp-input @error('current_password') is-invalid @enderror"
                               placeholder="Masukkan password lama" required autocomplete="current-password">
                        <button type="button" class="cp-toggle" onclick="togglePwd('current_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <div class="cp-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="cp-divider"></div>

                {{-- New password --}}
                <div class="cp-field">
                    <label class="cp-label" for="new_password">Password Baru</label>
                    <div class="cp-input-wrap">
                        <i class="fas fa-key cp-icon-left"></i>
                        <input type="password" id="new_password" name="new_password"
                               class="cp-input @error('new_password') is-invalid @enderror"
                               placeholder="Masukkan password baru" required autocomplete="new-password">
                        <button type="button" class="cp-toggle" onclick="togglePwd('new_password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <div class="cp-error">{{ $message }}</div>
                    @enderror
                    <div class="strength-wrap" id="strengthWrap" style="display:none;">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                    </div>
                </div>

                {{-- Confirm password --}}
                <div class="cp-field">
                    <label class="cp-label" for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <div class="cp-input-wrap">
                        <i class="fas fa-check cp-icon-left"></i>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               class="cp-input"
                               placeholder="Ulangi password baru" required autocomplete="new-password">
                        <button type="button" class="cp-toggle" onclick="togglePwd('new_password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="cp-submit">
                    <i class="fas fa-check"></i> Perbarui Password
                </button>
            </form>

            <div class="cp-back">
                <a href="javascript:history.back()"><i class="fas fa-arrow-left" style="font-size:.7rem;"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const newPwd    = document.getElementById('new_password');
    const confirmPwd = document.getElementById('new_password_confirmation');
    const fill      = document.getElementById('strengthFill');
    const text      = document.getElementById('strengthText');
    const wrap      = document.getElementById('strengthWrap');

    newPwd.addEventListener('input', function () {
        const v = this.value;
        if (!v) { wrap.style.display = 'none'; return; }
        wrap.style.display = 'block';

        let score = 0;
        if (v.length >= 8)  score++;
        if (v.length >= 12) score++;
        if (/[a-z]/.test(v)) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;

        fill.className = 'strength-fill';
        text.className = 'strength-text';

        if (score <= 2) {
            fill.style.width = '33%'; fill.classList.add('weak');
            text.textContent = 'Password lemah'; text.classList.add('weak');
        } else if (score <= 4) {
            fill.style.width = '66%'; fill.classList.add('medium');
            text.textContent = 'Password sedang'; text.classList.add('medium');
        } else {
            fill.style.width = '100%'; fill.classList.add('strong');
            text.textContent = 'Password kuat'; text.classList.add('strong');
        }
    });

    confirmPwd.addEventListener('input', function () {
        if (!this.value) { this.classList.remove('is-valid', 'is-invalid'); return; }
        if (this.value === newPwd.value) {
            this.classList.remove('is-invalid'); this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid'); this.classList.add('is-invalid');
        }
    });
});
</script>
@endpush
