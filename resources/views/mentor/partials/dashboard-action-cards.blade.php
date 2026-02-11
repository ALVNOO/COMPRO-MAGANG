{{--
    MENTOR DASHBOARD ACTION CARDS
    Main feature cards with descriptions
--}}

<div class="action-cards-grid">
    {{-- Assignments & Grading --}}
    <div class="action-card red">
        <div class="action-card-header">
            <div class="action-card-icon red">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div class="action-card-title">
                <h4>Penugasan & Penilaian</h4>
                <p>Kelola tugas peserta</p>
            </div>
        </div>
        <p class="action-card-desc">Berikan tugas kepada peserta magang dan nilai hasil pekerjaan mereka. Pantau perkembangan belajar peserta.</p>
        <a href="{{ route('mentor.penugasan') }}" class="action-card-btn red">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Berikan Penugasan
        </a>
    </div>

    {{-- Attendance Management --}}
    <div class="action-card green">
        <div class="action-card-header">
            <div class="action-card-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="action-card-title">
                <h4>Kelola Absensi</h4>
                <p>Pantau kehadiran peserta</p>
            </div>
        </div>
        <p class="action-card-desc">Monitor kehadiran harian peserta magang. Lihat riwayat absensi dan laporan keterlambatan.</p>
        <a href="{{ route('mentor.absensi') }}" class="action-card-btn green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Lihat Absensi
        </a>
    </div>

    {{-- Certificates --}}
    <div class="action-card purple">
        <div class="action-card-header">
            <div class="action-card-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div class="action-card-title">
                <h4>Sertifikat & Penilaian</h4>
                <p>Kelola sertifikat peserta</p>
            </div>
        </div>
        <p class="action-card-desc">Generate sertifikat untuk peserta yang telah menyelesaikan program magang. Buat laporan penilaian akhir.</p>
        <a href="{{ route('mentor.sertifikat') }}" class="action-card-btn purple">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            Kelola Sertifikat
        </a>
    </div>
</div>
