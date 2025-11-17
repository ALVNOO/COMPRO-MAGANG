@extends('layouts.mentor-dashboard')

@section('title', 'Absensi - Mentor Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">
            <i class="fas fa-calendar-check text-primary me-2"></i>
            Absensi Peserta Magang
        </h1>
    </div>

    @if($participants->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Belum ada peserta magang yang diterima di divisi Anda.
        </div>
    @else
        <div class="row">
            @foreach($participants as $participant)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i>
                                    {{ $participant->user->name }}
                                </h6>
                                <span class="badge bg-light text-dark">
                                    {{ $participant->user->nim }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted d-block">Universitas</small>
                                <strong>{{ $participant->user->university ?? '-' }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Jurusan</small>
                                <strong>{{ $participant->user->major ?? '-' }}</strong>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">Periode Magang</small>
                                <strong>
                                    @if($participant->start_date && $participant->end_date)
                                        {{ \Carbon\Carbon::parse($participant->start_date)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($participant->end_date)->format('d M Y') }}
                                    @else
                                        Belum ditentukan
                                    @endif
                                </strong>
                            </div>
                            <hr>
                            <div class="text-center">
                                <p class="text-muted mb-2">
                                    <small>Fitur absensi akan segera tersedia</small>
                                </p>
                                <button class="btn btn-sm btn-outline-primary" disabled>
                                    <i class="fas fa-calendar-check me-1"></i>
                                    Lihat Absensi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border: none;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush
@endsection

