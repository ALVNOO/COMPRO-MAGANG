{{--
    MENTOR DASHBOARD ALERT NOTIFICATION
    Shows when there are new assignments to grade

    Required variables:
    - $tugasBaruDiupload: Number of new assignments uploaded
--}}

@if($tugasBaruDiupload > 0)
<div class="alert-card">
    <div class="alert-icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
    </div>
    <div class="alert-content">
        <h5 class="alert-title">{{ $tugasBaruDiupload }} Tugas Baru Dikirim</h5>
        <p class="alert-desc">Peserta telah mengumpulkan tugas dan menunggu penilaian Anda</p>
    </div>
    <a href="{{ route('mentor.penugasan') }}" class="alert-btn">
        Lihat Tugas
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
    </a>
</div>
@endif
