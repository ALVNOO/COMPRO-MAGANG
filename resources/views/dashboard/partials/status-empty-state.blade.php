{{--
    STATUS EMPTY STATE
    Shown when user has no application
--}}

<div class="info-card" style="opacity: 1; transform: none;">
    <div class="card-body empty-state">
        <div class="empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
        </div>
        <h3 class="empty-title">Belum Ada Pengajuan</h3>
        <p class="empty-text">Anda belum mengajukan permintaan magang. Mulai perjalanan karir Anda dengan mengajukan magang di PT Telkom Indonesia.</p>
        <a href="{{ route('dashboard.program') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            Ajukan Magang Sekarang
        </a>
    </div>
</div>
