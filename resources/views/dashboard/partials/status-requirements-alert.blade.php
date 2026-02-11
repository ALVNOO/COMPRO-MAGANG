{{--
    STATUS REQUIREMENTS ALERT
    Shows additional requirements that need to be acknowledged
--}}

<div class="alert-box warning" style="margin-top: 24px;">
    <div class="alert-header">
        <div class="alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div>
            <h5 class="alert-title">Persyaratan Tambahan</h5>
            <p class="alert-subtitle">Harap lengkapi persyaratan berikut</p>
        </div>
    </div>
    <ol class="alert-list">
        <li>Siapkan berkas pengajuan/permohonan dalam format PDF</li>
        <li>Pastikan sudah install aplikasi PosPay (screenshot aplikasi)</li>
        <li>Buat Prangko Prisma di loket Kantor Pos</li>
        <li>Lengkapi informasi dengan lengkap dan benar untuk pengiriman form Name Tag</li>
        <li>Link Name Tag: <a href="https://www.canva.com/design/DAF--E97Wqg/1d-ph6OCvDsncMRtKqbgXw/edit?utm_content=DAF--E97Wqg&utm_campaign=designshare&utm_medium=link2&utm_source=sharebutton" target="_blank">Klik di sini</a></li>
    </ol>
    <form method="POST" action="{{ route('dashboard.status.acknowledge') }}">
        @csrf
        <button type="submit" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Saya Mengerti
        </button>
    </form>
</div>
