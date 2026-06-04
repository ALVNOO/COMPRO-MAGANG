@extends('errors.layout')

@section('code', '503')
@section('title', 'Sedang dalam Pemeliharaan')

@section('body')
<div class="error-code" style="font-size:5.5rem;">503</div>
<div class="error-icon">🔧</div>
<h1 class="error-title">Sedang dalam Pemeliharaan</h1>
<p class="error-desc">
    Sistem sedang dalam proses pemeliharaan terjadwal untuk meningkatkan
    kualitas layanan. Kami akan segera kembali online.
    Mohon maaf atas ketidaknyamanannya.
</p>

@if(isset($retryAfter))
<div style="display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;
            background:rgba(238,46,36,.06);border:1px solid rgba(238,46,36,.2);
            border-radius:8px;font-size:.85rem;color:#C41E1A;margin-bottom:1.5rem;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
    </svg>
    Coba lagi dalam {{ $retryAfter }} detik
</div>
@endif

<div class="actions">
    <a href="javascript:location.reload()" class="btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 005.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 013.51 15"/></svg>
        Refresh Halaman
    </a>
</div>
@endsection
