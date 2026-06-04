@extends('errors.layout')

@section('code', '403')
@section('title', 'Akses Ditolak')

@section('body')
<div class="error-code">403</div>
<div class="error-icon">🔒</div>
<h1 class="error-title">Akses Ditolak</h1>
<p class="error-desc">
    Anda tidak memiliki izin untuk mengakses halaman ini.
    Pastikan Anda login dengan akun yang sesuai,
    atau hubungi administrator jika Anda merasa ini adalah kesalahan.
</p>
<div class="actions">
    <a href="{{ url('/') }}" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Kembali ke Beranda
    </a>
    @auth
    <a href="{{ url()->previous() }}" class="btn-ghost">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Halaman Sebelumnya
    </a>
    @else
    <a href="{{ route('login') }}" class="btn-ghost">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
        Login
    </a>
    @endauth
</div>
@endsection
