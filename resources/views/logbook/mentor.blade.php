@extends('layouts.mentor-dashboard')

@section('title', 'Logbook Peserta - Mentor')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header" style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); padding: 2rem; border-radius: 16px; color: white; margin-bottom: 2rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; margin-bottom: 0.5rem;">
            <i class="fas fa-book me-2"></i>
            Logbook Peserta Magang
        </h1>
        <p style="opacity: 0.9; margin-bottom: 0;">
            Pantau aktivitas harian peserta magang Anda
        </p>
    </div>

    @if($participants->count() > 0)
        <!-- Summary Card -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-users" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #000; margin-bottom: 0.25rem;">{{ $participants->count() }}</h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Total Peserta</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #198754 0%, #20c997 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-book-open" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #198754; margin-bottom: 0.25rem;">
                            {{ $participants->sum(function($p) { return $p['logbooks']->count(); }) }}
                        </h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">Total Logbook</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div class="card-body text-center">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white;">
                            <i class="fas fa-calendar-day" style="font-size: 1.5rem;"></i>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #6366F1; margin-bottom: 0.25rem;">
                            {{ \Carbon\Carbon::today()->format('d') }}
                        </h3>
                        <p style="color: #AAA5A6; margin-bottom: 0;">{{ \Carbon\Carbon::today()->locale('id')->isoFormat('MMMM Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants List -->
        <div class="participants-container">
            @foreach($participants as $index => $participant)
                <div class="participant-card" style="border: 1px solid #e9ecef; border-radius: 16px; margin-bottom: 1.5rem; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <div class="participant-header" data-target="logbook-{{ $index }}" style="background: white; padding: 1.5rem; cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: background-color 0.3s;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem;">
                                {{ strtoupper(substr($participant['user']->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #000; font-size: 1.1rem; margin-bottom: 0.25rem;">{{ $participant['user']->name }}</div>
                                <div style="font-size: 0.875rem; color: #AAA5A6;">
                                    <i class="fas fa-envelope me-1"></i>{{ $participant['user']->email }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <span style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                                <i class="fas fa-book me-1"></i>{{ $participant['logbooks']->count() }} Logbook
                            </span>
                            <i class="fas fa-chevron-down toggle-icon" style="color: #AAA5A6; transition: transform 0.3s; font-size: 1.25rem;"></i>
                        </div>
                    </div>

                    <div class="logbook-content-wrapper" id="logbook-{{ $index }}" style="display: none; background: #f8f9fa; padding: 1.5rem; border-top: 1px solid #e9ecef;">
                        @if($participant['logbooks']->count() > 0)
                            <div style="background: white; border-radius: 12px; overflow: hidden;">
                                <div style="background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; padding: 1rem 1.5rem;">
                                    <h6 style="margin: 0; font-weight: 600;">
                                        <i class="fas fa-list me-2"></i>Daftar Logbook
                                    </h6>
                                </div>
                                <div style="padding: 0;">
                                    @foreach($participant['logbooks'] as $logIdx => $logbook)
                                        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e9ecef; {{ $logIdx % 2 == 0 ? 'background: #ffffff;' : 'background: #f8f9fa;' }}">
                                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                                <div style="min-width: 60px; padding: 0.5rem 0.75rem; background: linear-gradient(135deg, #EE2E24 0%, #F60000 100%); color: white; border-radius: 8px; text-align: center;">
                                                    <div style="font-weight: 700; font-size: 1.5rem; line-height: 1;">{{ $logbook->date->format('d') }}</div>
                                                    <div style="font-size: 0.75rem; text-transform: uppercase;">{{ $logbook->date->format('M') }}</div>
                                                </div>
                                                <div style="flex: 1;">
                                                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                                        <i class="fas fa-calendar text-danger"></i>
                                                        <strong style="color: #000;">{{ $logbook->date->locale('id')->isoFormat('dddd, D MMMM Y') }}</strong>
                                                    </div>
                                                    <div style="color: #495057; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word;">{{ $logbook->content }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center;">
                                <i class="fas fa-book-open" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                                <h6 style="color: #AAA5A6; font-weight: 600;">Belum Ada Logbook</h6>
                                <p style="color: #AAA5A6; margin-bottom: 0; font-size: 0.875rem;">Peserta ini belum mengisi logbook.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="card-body" style="padding: 3rem; text-align: center;">
                <i class="fas fa-users-slash" style="font-size: 4rem; color: #dee2e6; margin-bottom: 1rem;"></i>
                <h5 style="color: #AAA5A6; font-weight: 600; margin-bottom: 0.5rem;">Belum Ada Peserta</h5>
                <p style="color: #AAA5A6; margin-bottom: 0;">Belum ada peserta magang yang di-assign ke Anda.</p>
            </div>
        </div>
    @endif
</div>

<style>
.participant-card:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
    transform: translateY(-2px);
}

.participant-header:hover {
    background-color: #f8f9fa !important;
}

.participant-header.active {
    background-color: #FEF2F2 !important;
    border-bottom: 2px solid #EE2E24 !important;
}

.participant-header.active .toggle-icon {
    transform: rotate(180deg);
    color: #EE2E24 !important;
}

.logbook-content-wrapper.show {
    display: block !important;
}
</style>

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
