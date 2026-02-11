{{--
    ADMIN DASHBOARD HERO SECTION
    Welcome banner with admin info and today's stats

    Required variables:
    - $todayRegistrations: Number of registrations today (default: 0)
--}}

<div class="hero-admin">
    {{-- Decorative Glow Effects --}}
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    {{-- Decorative Shapes --}}
    <div class="hero-shape-admin hero-shape-1"></div>
    <div class="hero-shape-admin hero-shape-2"></div>
    <div class="hero-shape-admin hero-shape-3"></div>

    <div class="hero-admin-content">
        <div class="hero-admin-info">
            {{-- Avatar with Animated Ring --}}
            <div class="hero-admin-avatar">
                <div class="hero-admin-ring">
                    <div class="hero-admin-inner">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>

            {{-- Welcome Text --}}
            <div class="hero-admin-text">
                <h1>Welcome back, Admin!</h1>
                <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </div>

        {{-- Today's Stats --}}
        <div class="hero-admin-stats">
            <div class="hero-stat-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="hero-stat-content">
                <div class="hero-stat-label">Hari Ini</div>
                <div class="hero-stat-value" data-target="{{ $todayRegistrations ?? 0 }}">+0</div>
                <div class="hero-stat-desc">Registrasi Baru</div>
            </div>
        </div>
    </div>
</div>
