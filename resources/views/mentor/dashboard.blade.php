@extends('layouts.mentor-dashboard')

@section('title', 'Dashboard Pembimbing Lapangan - PT Telkom Indonesia')

@push('styles')
<style>
    :root {
        --telkom-red: #EE2E24;
        --telkom-red-bright: #EE2B24;
        --telkom-red-pure: #F60000;
        --telkom-black: #000000;
        --telkom-gray: #AAA5A6;
        --gradient-primary: linear-gradient(135deg, #EE2E24 0%, #F60000 100%);
        --gradient-secondary: linear-gradient(135deg, #000000 0%, #AAA5A6 100%);
        --gradient-accent: linear-gradient(135deg, #EE2B24 0%, #EE2E24 100%);
        --gradient-card: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        --shadow-soft: 0 10px 30px rgba(0,0,0,0.1);
        --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Welcome Section */
    .welcome-section {
        background: var(--gradient-primary);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-soft);
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .divisi-info {
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        backdrop-filter: blur(10px);
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-soft);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-hover);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        transition: var(--transition);
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
    }

    .stat-icon.active {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
        color: white;
    }

    .stat-icon.tasks {
        background: linear-gradient(135deg, #fd7e14 0%, #ff6b35 100%);
        color: white;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--telkom-gray);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-description {
        font-size: 0.8rem;
        color: var(--telkom-gray);
        opacity: 0.8;
    }

    /* Action Cards */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .action-card {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-soft);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-accent);
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .action-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        margin-right: 1rem;
    }

    .action-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--telkom-black);
        margin-bottom: 0.25rem;
    }

    .action-subtitle {
        font-size: 0.85rem;
        color: var(--telkom-gray);
    }

    .action-description {
        color: var(--telkom-gray);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .action-button {
        background: var(--gradient-primary);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(238, 46, 36, 0.2);
    }

    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(238, 46, 36, 0.4);
        color: white;
        filter: brightness(1.1);
    }

    /* Notification Cards */
    .notification-card {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--shadow-soft);
        border-left: 4px solid;
        transition: var(--transition);
    }

    .notification-card:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-hover);
    }

    .notification-card.info {
        border-left-color: #0dcaf0;
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.05) 0%, rgba(13, 202, 240, 0.02) 100%);
    }

    .notification-card.warning {
        border-left-color: #ffc107;
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.05) 0%, rgba(255, 193, 7, 0.02) 100%);
    }

    .notification-header {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .notification-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 1rem;
    }

    .notification-icon.info {
        background: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }

    .notification-icon.warning {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .notification-title {
        font-weight: 600;
        color: var(--telkom-black);
        margin-bottom: 0;
    }

    .notification-text {
        color: var(--telkom-gray);
        margin-bottom: 0.75rem;
    }

    .notification-link {
        color: var(--telkom-red);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: var(--transition);
    }

    .notification-link:hover {
        color: var(--telkom-red-pure);
        text-decoration: underline;
    }

    /* Quick Actions */
    .quick-actions {
        background: var(--gradient-card);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
    }

    .quick-actions-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--telkom-black);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .quick-action-btn {
        background: white;
        border: 2px solid rgba(238, 46, 36, 0.1);
        color: var(--telkom-red);
        padding: 1rem;
        border-radius: 12px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        font-weight: 500;
    }

    .quick-action-btn:hover {
        background: var(--gradient-primary);
        color: white;
        border-color: var(--telkom-red);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(238, 46, 36, 0.3);
    }

    .quick-action-icon {
        font-size: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .welcome-section {
            padding: 1.5rem;
        }

        .welcome-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .actions-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card,
        .action-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-slide-up {
        animation: slideInUp 0.6s ease-out;
    }

    .animate-fade-left {
        animation: fadeInLeft 0.6s ease-out;
    }

    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }
</style>
@endpush

@section('content')
<div class="animate-fade-left">
    <!-- Welcome Section -->
    <div class="welcome-section animate-slide-up">
        <div class="welcome-content">
            <h1 class="welcome-title">Selamat Datang, {{ Auth::user()->divisi && Auth::user()->divisi->vp ? Auth::user()->divisi->vp : Auth::user()->name }}!</h1>
            <p class="welcome-subtitle">Dashboard Pembimbing Lapangan PT Telkom Indonesia</p>
            
            @if(Auth::user()->divisi)
            <div class="divisi-info">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Divisi:</strong> {{ Auth::user()->divisi->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>NIPPOS:</strong> {{ Auth::user()->divisi->nippos }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Notifications -->
    @if($tugasBaruDiupload > 0)
        <div class="notification-card warning animate-slide-up animate-delay-2">
            <div class="notification-header">
                <div class="notification-icon warning">
                    <i class="fas fa-tasks"></i>
                </div>
                <h5 class="notification-title">Tugas Baru Dikirim</h5>
            </div>
            <p class="notification-text">
                <strong>{{ $tugasBaruDiupload }} tugas baru</strong> telah di-upload peserta dan menunggu penilaian.
            </p>
            <a href="{{ route('mentor.penugasan') }}" class="notification-link">
                <i class="fas fa-arrow-right me-1"></i>Lihat Tugas
            </a>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card animate-slide-up animate-delay-1">
            <div class="stat-icon active">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $activeParticipants }}</div>
            <div class="stat-label">Peserta Aktif</div>
            <div class="stat-description">Sedang menjalani program magang</div>
        </div>

        <div class="stat-card animate-slide-up animate-delay-3">
            <div class="stat-icon tasks">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-number">{{ $assignmentsToGrade }}</div>
            <div class="stat-label">Tugas Harus Dinilai</div>
            <div class="stat-description">Menunggu penilaian dari Anda</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions animate-slide-up animate-delay-4">
        <h3 class="quick-actions-title">
            <i class="fas fa-bolt"></i>
            Akses Cepat
        </h3>
        <div class="quick-actions-grid">
            <a href="{{ route('mentor.penugasan') }}" class="quick-action-btn">
                <i class="fas fa-tasks quick-action-icon"></i>
                <span>Penugasan</span>
            </a>
            <a href="{{ route('mentor.profil') }}" class="quick-action-btn">
                <i class="fas fa-user quick-action-icon"></i>
                <span>Profil</span>
            </a>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="actions-grid">
        <div class="action-card animate-slide-up animate-delay-1">
            <div class="action-header">
                <div class="action-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h4 class="action-title">Penugasan & Penilaian</h4>
                    <p class="action-subtitle">Kelola tugas peserta</p>
                </div>
            </div>
            <p class="action-description">
                Berikan tugas kepada peserta magang dan nilai hasil pekerjaan mereka. 
                Pantau perkembangan belajar peserta.
            </p>
            <a href="{{ route('mentor.penugasan') }}" class="action-button">
                <i class="fas fa-plus"></i>
                Berikan Penugasan
            </a>
        </div>
    </div>
</div>

<!-- JavaScript for enhanced interactivity -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate numbers on scroll
    const animateNumbers = () => {
        const statNumbers = document.querySelectorAll('.stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.textContent);
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        entry.target.textContent = Math.floor(current);
                    }, 30);
                    observer.unobserve(entry.target);
                }
            });
        });
        
        statNumbers.forEach(number => observer.observe(number));
    };

    animateNumbers();

    // Add hover effects to cards
    const cards = document.querySelectorAll('.stat-card, .action-card, .notification-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states to action buttons
    document.querySelectorAll('.action-button, .quick-action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            this.style.pointerEvents = 'none';
            
            // Reset after navigation (this will be overridden by page navigation)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            }, 2000);
        });
    });
});
</script>
@endsection 