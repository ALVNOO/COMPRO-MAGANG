@extends('errors.layout')

@section('code', '429')
@section('title', 'Terlalu Banyak Permintaan')

@section('body')
<div class="error-code">429</div>
<div class="error-icon">⏱️</div>
<h1 class="error-title">Terlalu Banyak Permintaan</h1>
<p class="error-desc">
    Anda telah mengirimkan terlalu banyak permintaan dalam waktu singkat.
    Tunggu sebentar lalu coba lagi — sistem kami menjaga keamanan
    semua pengguna.
</p>
<div class="actions">
    <a href="javascript:location.reload()" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>
        Coba Lagi
    </a>
    <a href="{{ url('/') }}" class="btn-ghost">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Beranda
    </a>
</div>
@endsection
