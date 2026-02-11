{{--
    MENTOR DASHBOARD HERO SECTION
    Welcome banner with mentor info and division details
--}}

<div class="hero-section">
    {{-- Decorative Shapes --}}
    <div class="hero-grid"></div>
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>

    <div class="hero-content">
        <div class="hero-info">
            {{-- Avatar with Ring Animation --}}
            <div class="hero-avatar">
                <div class="hero-avatar-ring">
                    <div class="hero-avatar-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="hero-text">
                <h1>Selamat Datang, {{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}!</h1>
                <p>Dashboard Pembimbing Lapangan PT Telkom Indonesia</p>
            </div>
        </div>

        @if(Auth::user()->divisi)
        <div class="hero-divisi">
            <div class="hero-divisi-item">
                <span class="hero-divisi-label">Divisi</span>
                <span class="hero-divisi-value">{{ Auth::user()->divisi->name }}</span>
            </div>
            <div class="hero-divisi-item">
                <span class="hero-divisi-label">NIPPOS</span>
                <span class="hero-divisi-value">{{ Auth::user()->divisi->nippos }}</span>
            </div>
        </div>
        @endif
    </div>
</div>
