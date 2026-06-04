@extends('errors.layout')

@section('code', '404')
@section('title', 'Halaman Tidak Ditemukan')

@section('body')
<div class="error-code">404</div>
<div class="error-icon">🔍</div>
<h1 class="error-title">Halaman Tidak Ditemukan</h1>
<p class="error-desc">
    Halaman yang Anda cari mungkin sudah dipindahkan, dihapus,
    atau alamat URL yang dimasukkan tidak tepat.
</p>
<div class="actions">
    <a href="{{ url('/') }}" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Kembali ke Beranda
    </a>
    <a href="javascript:history.back()" class="btn-ghost">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Halaman Sebelumnya
    </a>
</div>
@endsection
