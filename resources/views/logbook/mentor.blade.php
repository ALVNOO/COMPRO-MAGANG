@extends('layouts.mentor-dashboard')

@section('title', 'Logbook Peserta - Mentor')

@section('styles')
<style>
    .participant-card {
        border: 1px solid #e3e3e0;
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .participant-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .participant-header {
        background: #fff;
        padding: 1rem 1.5rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.3s;
    }
    .participant-header:hover {
        background-color: #f8f9fa;
    }
    .participant-header.active {
        background-color: #FEF2F2;
        border-bottom: 2px solid #EE2E24;
    }
    .participant-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .participant-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .participant-name {
        font-weight: 600;
        color: #1b1b18;
        margin-bottom: 0.25rem;
    }
    .participant-email {
        font-size: 0.85rem;
        color: #6c757d;
    }
    .logbook-count {
        background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .toggle-icon {
        color: #6c757d;
        transition: transform 0.3s;
    }
    .participant-header.active .toggle-icon {
        transform: rotate(180deg);
        color: #EE2E24;
    }
    .logbook-content-wrapper {
        display: none;
        background: #f8f9fa;
        padding: 1.5rem;
        border-top: 1px solid #e3e3e0;
    }
    .logbook-content-wrapper.show {
        display: block;
    }
    .logbook-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .logbook-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #e3e3e0;
    }
    .logbook-table td {
        vertical-align: middle;
    }
    .empty-logbook {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }
    .empty-logbook i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">Logbook Peserta Magang</h2>
            <p class="text-muted mb-0">Lihat logbook yang sudah diisi oleh peserta magang</p>
        </div>
    </div>

    <!-- Participants List -->
    @if($participants->count() > 0)
    <div class="participants-container">
        @foreach($participants as $index => $participant)
        <div class="participant-card">
            <div class="participant-header" data-target="logbook-{{ $index }}">
                <div class="participant-info">
                    <div class="participant-avatar">
                        {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="participant-name">{{ $participant['user']->name }}</div>
                        <div class="participant-email">{{ $participant['user']->email }}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="logbook-count">{{ $participant['logbooks']->count() }} Logbook</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>
            <div class="logbook-content-wrapper" id="logbook-{{ $index }}">
                @if($participant['logbooks']->count() > 0)
                <div class="table-responsive logbook-table">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Tanggal</th>
                                <th style="width: 80%;">Isi Logbook</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($participant['logbooks'] as $logbook)
                            <tr>
                                <td>
                                    <strong>{{ $logbook->date->format('d M Y') }}</strong>
                                </td>
                                <td>
                                    <div style="white-space: pre-wrap; word-wrap: break-word;">{{ $logbook->content }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-logbook">
                    <i class="fas fa-book-open"></i>
                    <p class="mb-0">Peserta ini belum mengisi logbook.</p>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info text-center mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada peserta yang di-assign ke Anda.
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const headers = document.querySelectorAll('.participant-header');
    
    headers.forEach(header => {
        header.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            
            // Toggle active class on header
            this.classList.toggle('active');
            
            // Toggle show class on content
            content.classList.toggle('show');
        });
    });
});
</script>
@endsection
