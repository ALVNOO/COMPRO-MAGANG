{{--
    STATUS PAGE STYLES
    Design System: Telkom Brand Colors with Creative Elements
    - Floating Orbs
    - Glassmorphism
    - Spring Animations
--}}

<style>
    /* ============================================
       STATUS PAGE - DESIGN SYSTEM 2025
       ============================================ */

    /* Design Tokens */
    :root {
        --primary: #EE2E24;
        --primary-dark: #C41E3A;
        --primary-light: #FF6B6B;
        --success: #10B981;
        --success-light: #34D399;
        --warning: #F59E0B;
        --danger: #EF4444;
        --info: #3B82F6;
        --purple: #8B5CF6;
        --cyan: #06B6D4;
        --slate-50: #F8FAFC;
        --slate-100: #F1F5F9;
        --slate-200: #E2E8F0;
        --slate-300: #CBD5E1;
        --slate-400: #94A3B8;
        --slate-500: #64748B;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1E293B;
        --slate-900: #0F172A;
        --spring-easing: cubic-bezier(0.34, 1.56, 0.64, 1);
        --smooth-easing: cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== KEYFRAME ANIMATIONS ===== */
    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(10px, -20px) scale(1.05); }
        50% { transform: translate(-5px, -10px) scale(0.95); }
        75% { transform: translate(-15px, -25px) scale(1.02); }
    }

    @keyframes gridMove {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scalePop {
        0% { transform: scale(0.8); opacity: 0; }
        70% { transform: scale(1.05); }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(238, 46, 36, 0.3), 0 4px 15px rgba(0, 0, 0, 0.1); }
        50% { box-shadow: 0 0 40px rgba(238, 46, 36, 0.5), 0 4px 20px rgba(0, 0, 0, 0.15); }
    }

    @keyframes successGlow {
        0%, 100% { box-shadow: 0 0 15px rgba(16, 185, 129, 0.3); }
        50% { box-shadow: 0 0 30px rgba(16, 185, 129, 0.5); }
    }

    @keyframes ringPulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.8); opacity: 0; }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(2deg); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes progressFill {
        from { width: 0%; }
        to { width: var(--progress-width); }
    }

    @keyframes uploadArrow {
        0%, 100% { transform: translateY(0); opacity: 1; }
        50% { transform: translateY(-8px); opacity: 0.5; }
    }

    @keyframes iconBounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* ===== PAGE CONTAINER ===== */
    .status-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #FAFBFC 0%, #F1F5F9 50%, #E8F0FE 100%);
        padding: 24px;
        position: relative;
        overflow-x: hidden;
    }

    @media (min-width: 768px) {
        .status-page { padding: 32px; }
    }

    .status-page::before {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            linear-gradient(rgba(238, 46, 36, 0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(238, 46, 36, 0.02) 1px, transparent 1px);
        background-size: 40px 40px;
        animation: gridMove 20s linear infinite;
        pointer-events: none;
        z-index: 0;
    }

    .status-page::after {
        content: '';
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
        opacity: 0.015;
        pointer-events: none;
        z-index: 0;
    }

    /* ===== FLOATING GRADIENT ORBS ===== */
    .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }

    .orb-1 {
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(238, 46, 36, 0.15) 0%, transparent 70%);
        top: -100px; right: -100px;
        animation: orbFloat 12s ease-in-out infinite;
    }

    .orb-2 {
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
        bottom: 10%; left: -100px;
        animation: orbFloat 15s ease-in-out infinite reverse;
    }

    .orb-3 {
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        top: 50%; right: 10%;
        animation: orbFloat 10s ease-in-out infinite;
        animation-delay: -5s;
    }

    .orb-4 {
        width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        bottom: -50px; right: 30%;
        animation: orbFloat 18s ease-in-out infinite;
        animation-delay: -3s;
    }

    .content-wrapper {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ===== HERO SECTION ===== */
    .hero-section {
        position: relative;
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 32px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, #8B1538 100%);
        overflow: hidden;
        opacity: 0;
        animation: fadeInUp 0.8s var(--spring-easing) forwards;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        animation: orbFloat 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: orbFloat 10s ease-in-out infinite reverse;
    }

    .hero-grid-pattern {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 30px 30px;
        animation: gridMove 15s linear infinite;
    }

    .hero-floating-shapes {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        pointer-events: none;
        overflow: hidden;
    }

    .floating-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .floating-shape:nth-child(1) { width: 20px; height: 20px; top: 20%; left: 10%; animation-delay: 0s; }
    .floating-shape:nth-child(2) { width: 15px; height: 15px; top: 60%; left: 85%; animation-delay: -2s; }
    .floating-shape:nth-child(3) { width: 25px; height: 25px; top: 70%; left: 20%; animation-delay: -4s; }
    .floating-shape:nth-child(4) { width: 12px; height: 12px; top: 30%; left: 70%; animation-delay: -1s; }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    @media (min-width: 768px) {
        .hero-content {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .hero-user { display: flex; align-items: center; gap: 20px; }

    .hero-avatar-wrapper { position: relative; }

    .hero-avatar {
        width: 80px; height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 255, 255, 0.4);
        overflow: hidden;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        transition: transform 0.3s var(--spring-easing);
    }

    .hero-avatar:hover { transform: scale(1.05); }
    .hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .hero-avatar svg { width: 36px; height: 36px; color: white; }

    .avatar-ring {
        position: absolute;
        top: -4px; left: -4px; right: -4px; bottom: -4px;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: ringPulse 2s ease-out infinite;
    }

    .avatar-ring:nth-child(2) { animation-delay: 0.5s; }

    .hero-info h1 {
        font-size: 28px;
        font-weight: 800;
        color: white;
        margin: 0 0 8px 0;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-info p {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }

    .hero-status {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border-radius: 100px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: white;
        font-size: 15px;
        font-weight: 700;
        animation: float 4s ease-in-out infinite, glowPulse 3s ease-in-out infinite;
        transition: all 0.3s var(--spring-easing);
    }

    .hero-status:hover {
        transform: translateY(-3px) scale(1.02);
        background: rgba(255, 255, 255, 0.2);
    }

    .hero-status svg { width: 20px; height: 20px; }

    .hero-status.status-accepted {
        background: rgba(16, 185, 129, 0.3);
        border-color: rgba(16, 185, 129, 0.5);
        animation: float 4s ease-in-out infinite, successGlow 3s ease-in-out infinite;
    }

    .hero-status.status-rejected {
        background: rgba(239, 68, 68, 0.3);
        border-color: rgba(239, 68, 68, 0.5);
    }

    /* ===== STEPPER ===== */
    .stepper-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.8);
        opacity: 0;
        animation: fadeInUp 0.8s var(--spring-easing) forwards;
        animation-delay: 0.15s;
        position: relative;
        overflow: hidden;
    }

    .stepper-card::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 150px; height: 150px;
        background: linear-gradient(135deg, rgba(238, 46, 36, 0.05) 0%, transparent 60%);
        border-radius: 50%;
    }

    .stepper-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 32px;
        position: relative;
    }

    .stepper-icon {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 8px 24px rgba(238, 46, 36, 0.3);
        animation: iconBounce 3s ease-in-out infinite;
    }

    .stepper-icon svg { width: 24px; height: 24px; }

    .stepper-title {
        font-size: 20px;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0;
    }

    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 0 16px;
    }

    .stepper-line {
        position: absolute;
        top: 32px;
        left: 64px;
        right: 64px;
        height: 6px;
        background: var(--slate-200);
        border-radius: 3px;
        overflow: hidden;
    }

    .stepper-line-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--success) 0%, var(--success-light) 50%, var(--primary) 100%);
        border-radius: 3px;
        position: relative;
        animation: progressFill 1.5s var(--smooth-easing) forwards;
        animation-delay: 0.5s;
        width: 0;
    }

    .stepper-line-fill::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.4) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmer 2s linear infinite;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        flex: 1;
        max-width: 120px;
    }

    .step-circle {
        width: 64px; height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        transition: all 0.4s var(--spring-easing);
        position: relative;
        cursor: pointer;
    }

    .step-circle svg { width: 24px; height: 24px; position: relative; z-index: 1; }

    .step-item.completed .step-circle {
        background: linear-gradient(135deg, var(--success) 0%, var(--success-light) 100%);
        color: white;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.35);
    }

    .step-item.completed .step-circle:hover {
        transform: scale(1.1) translateY(-3px);
        box-shadow: 0 12px 32px rgba(16, 185, 129, 0.45);
    }

    .step-item.active .step-circle {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 8px 24px rgba(238, 46, 36, 0.35);
        animation: glowPulse 2s ease-in-out infinite;
    }

    .step-item.active .step-circle::before {
        content: '';
        position: absolute;
        top: -6px; left: -6px; right: -6px; bottom: -6px;
        border: 3px solid var(--primary);
        border-radius: 50%;
        animation: ringPulse 1.5s ease-out infinite;
    }

    .step-item.active .step-circle:hover { transform: scale(1.1); }

    .step-item.pending .step-circle {
        background: var(--slate-100);
        color: var(--slate-400);
        border: 2px dashed var(--slate-300);
    }

    .step-item.pending .step-circle:hover {
        background: var(--slate-200);
        transform: scale(1.05);
    }

    .step-item.rejected .step-circle {
        background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
        color: white;
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.35);
    }

    .step-label {
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        color: var(--slate-500);
        transition: color 0.3s ease;
    }

    .step-item.completed .step-label,
    .step-item.active .step-label { color: var(--slate-800); }
    .step-item.rejected .step-label { color: var(--danger); }

    /* ===== MAIN GRID ===== */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
    }

    @media (min-width: 1024px) {
        .main-grid { grid-template-columns: 2fr 1fr; }
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* ===== INFO CARDS ===== */
    .info-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.9);
        overflow: hidden;
        transition: all 0.4s var(--spring-easing);
        opacity: 0;
        transform: translateY(30px);
    }

    .info-card.animate-visible { opacity: 1; transform: translateY(0); }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        padding: 24px 28px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
    }

    .card-icon {
        width: 52px; height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s var(--spring-easing);
        position: relative;
    }

    .card-icon::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 16px;
        background: inherit;
        filter: blur(12px);
        opacity: 0.4;
        z-index: -1;
    }

    .info-card:hover .card-icon { transform: scale(1.1) rotate(-5deg); }
    .card-icon svg { width: 24px; height: 24px; }

    .card-icon.blue { background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); }
    .card-icon.amber { background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); }
    .card-icon.red { background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%); }
    .card-icon.green { background: linear-gradient(135deg, #10B981 0%, #059669 100%); }
    .card-icon.purple { background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); }
    .card-icon.cyan { background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%); }

    .card-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0;
    }

    .card-body { padding: 28px; }

    /* ===== DATA GRID ===== */
    .data-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    @media (max-width: 640px) {
        .data-grid { grid-template-columns: 1fr; }
    }

    .data-item {
        background: linear-gradient(135deg, var(--slate-50) 0%, white 100%);
        padding: 20px;
        border-radius: 16px;
        transition: all 0.3s var(--spring-easing);
        border: 1px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .data-item::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .data-item:hover {
        background: white;
        border-color: rgba(238, 46, 36, 0.1);
        transform: translateX(4px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .data-item:hover::before { opacity: 1; }

    .data-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--slate-500);
        margin-bottom: 8px;
    }

    .data-value {
        font-size: 16px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0;
        word-break: break-word;
    }

    .data-value.highlight {
        color: var(--primary);
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== STATUS BADGES ===== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s var(--spring-easing);
    }

    .status-badge:hover { transform: scale(1.05); }
    .status-badge svg { width: 18px; height: 18px; }

    .status-badge.pending {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
    }

    .status-badge.accepted {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #065F46;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
        color: #991B1B;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }

    .status-badge.finished {
        background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
        color: #1E40AF;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    /* ===== TIMELINE ===== */
    .timeline {
        position: relative;
        padding-left: 40px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 8px;
        bottom: 8px;
        width: 3px;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light), var(--slate-200));
        border-radius: 2px;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 28px;
        opacity: 0;
        animation: slideInLeft 0.6s var(--spring-easing) forwards;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:last-child { padding-bottom: 0; }

    .timeline-dot {
        position: absolute;
        left: -40px;
        top: 4px;
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 3px solid var(--slate-300);
        transition: all 0.3s var(--spring-easing);
        z-index: 1;
    }

    .timeline-item:hover .timeline-dot { transform: scale(1.15); }
    .timeline-dot svg { width: 14px; height: 14px; }

    .timeline-dot.submitted {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-color: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(238, 46, 36, 0.3);
    }

    .timeline-dot.accepted {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        border-color: var(--success);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        animation: successGlow 2s ease-in-out infinite;
    }

    .timeline-dot.rejected {
        background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%);
        border-color: var(--danger);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .timeline-dot.finished {
        background: linear-gradient(135deg, var(--info) 0%, #2563EB 100%);
        border-color: var(--info);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .timeline-content {
        background: linear-gradient(135deg, var(--slate-50) 0%, white 100%);
        padding: 20px;
        border-radius: 16px;
        border: 1px solid transparent;
        transition: all 0.3s var(--spring-easing);
    }

    .timeline-item:hover .timeline-content {
        background: white;
        border-color: rgba(238, 46, 36, 0.1);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transform: translateX(4px);
    }

    .timeline-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0 0 6px 0;
    }

    .timeline-date {
        font-size: 13px;
        color: var(--slate-500);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .timeline-date svg { width: 16px; height: 16px; }

    /* ===== ALERT BOXES ===== */
    .alert-box {
        padding: 24px;
        border-radius: 20px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .alert-box::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
        pointer-events: none;
    }

    .alert-box.warning {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border: 1px solid rgba(252, 211, 77, 0.5);
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.15);
    }

    .alert-box.danger {
        background: linear-gradient(135deg, #FEF2F2 0%, #FEE2E2 100%);
        border: 1px solid rgba(252, 165, 165, 0.5);
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15);
    }

    .alert-box.success {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%);
        border: 1px solid rgba(110, 231, 183, 0.5);
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15);
    }

    .alert-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
        position: relative;
    }

    .alert-icon {
        width: 52px; height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        animation: iconBounce 3s ease-in-out infinite;
    }

    .alert-icon svg { width: 26px; height: 26px; }

    .alert-box.warning .alert-icon { background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%); }
    .alert-box.danger .alert-icon { background: linear-gradient(135deg, var(--danger) 0%, #DC2626 100%); }
    .alert-box.success .alert-icon { background: linear-gradient(135deg, var(--success) 0%, #059669 100%); }

    .alert-title {
        font-size: 17px;
        font-weight: 800;
        margin: 0 0 4px 0;
    }

    .alert-box.warning .alert-title { color: #92400E; }
    .alert-box.danger .alert-title { color: #991B1B; }
    .alert-box.success .alert-title { color: #065F46; }

    .alert-subtitle { font-size: 14px; margin: 0; }

    .alert-box.warning .alert-subtitle { color: #B45309; }
    .alert-box.danger .alert-subtitle { color: #B91C1C; }
    .alert-box.success .alert-subtitle { color: #047857; }

    .alert-list { padding-left: 24px; margin: 0 0 24px 0; }
    .alert-list li { padding: 8px 0; font-size: 14px; position: relative; }
    .alert-box.warning .alert-list li { color: #78350F; }
    .alert-box.danger .alert-list li { color: #7F1D1D; }

    .alert-list a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .alert-list a:hover {
        text-decoration: underline;
        color: var(--primary-dark);
    }

    /* ===== UPLOAD SECTION ===== */
    .upload-section {
        background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 50%, #BFDBFE 100%);
        border: 2px dashed #93C5FD;
        border-radius: 24px;
        padding: 32px;
        margin-top: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .upload-section:hover {
        border-color: var(--info);
        box-shadow: 0 8px 32px rgba(59, 130, 246, 0.15);
    }

    .upload-section::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 150px; height: 150px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        animation: orbFloat 8s ease-in-out infinite;
    }

    .upload-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
        position: relative;
    }

    .upload-icon {
        width: 60px; height: 60px;
        background: linear-gradient(135deg, var(--info) 0%, #2563EB 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
        animation: float 4s ease-in-out infinite;
    }

    .upload-icon svg { width: 28px; height: 28px; }

    .upload-arrows {
        position: absolute;
        top: 50%; left: 30px;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .upload-arrows span {
        display: block;
        width: 8px; height: 8px;
        border-left: 2px solid white;
        border-top: 2px solid white;
        transform: rotate(45deg);
        animation: uploadArrow 1.5s ease-in-out infinite;
    }

    .upload-arrows span:nth-child(2) { animation-delay: 0.2s; }
    .upload-arrows span:nth-child(3) { animation-delay: 0.4s; }

    .upload-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0 0 4px 0;
    }

    .upload-subtitle {
        font-size: 14px;
        color: var(--slate-500);
        margin: 0;
    }

    .upload-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .upload-item {
        background: white;
        padding: 20px;
        border-radius: 16px;
        border: 2px solid transparent;
        transition: all 0.3s var(--spring-easing);
        position: relative;
        overflow: hidden;
    }

    .upload-item::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--info) 0%, var(--primary) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .upload-item:hover {
        border-color: var(--info);
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);
    }

    .upload-item:hover::before { opacity: 1; }

    .upload-item label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 700;
        color: var(--slate-700);
        margin-bottom: 12px;
    }

    .upload-item label svg {
        width: 20px; height: 20px;
        flex-shrink: 0;
        transition: transform 0.3s var(--spring-easing);
    }

    .upload-item:hover label svg { transform: scale(1.15) rotate(-5deg); }

    .upload-item input[type="file"] {
        width: 100%;
        font-size: 13px;
        color: var(--slate-600);
    }

    .upload-item input[type="file"]::file-selector-button {
        padding: 10px 16px;
        border-radius: 10px;
        border: 2px solid var(--slate-200);
        background: var(--slate-50);
        color: var(--slate-700);
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 12px;
        transition: all 0.3s var(--spring-easing);
    }

    .upload-item input[type="file"]::file-selector-button:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
        transform: scale(1.02);
    }

    /* ===== DOWNLOAD SECTION ===== */
    .download-section {
        background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 50%, #A7F3D0 100%);
        border: 1px solid rgba(110, 231, 183, 0.5);
        border-radius: 24px;
        padding: 28px;
        margin-top: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.15);
    }

    .download-section::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
        animation: orbFloat 10s ease-in-out infinite;
    }

    .download-icon {
        width: 68px; height: 68px;
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        animation: float 5s ease-in-out infinite;
    }

    .download-icon svg { width: 32px; height: 32px; }
    .download-content { flex: 1; min-width: 200px; }

    .download-title {
        font-size: 17px;
        font-weight: 800;
        color: #065F46;
        margin: 0 0 6px 0;
    }

    .download-subtitle {
        font-size: 14px;
        color: #047857;
        margin: 0;
    }

    /* ===== CONTACT CARD ===== */
    .contact-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.9);
        overflow: hidden;
        position: sticky;
        top: 24px;
        opacity: 0;
        animation: slideInRight 0.8s var(--spring-easing) forwards;
        animation-delay: 0.4s;
    }

    .contact-header {
        background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 50%, #6D28D9 100%);
        padding: 32px;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .contact-header::before {
        content: '';
        position: absolute;
        top: -50%; right: -30%;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 60%);
        animation: orbFloat 8s ease-in-out infinite;
    }

    .contact-header svg {
        width: 56px; height: 56px;
        margin-bottom: 16px;
        animation: float 4s ease-in-out infinite;
    }

    .contact-header h3 {
        font-size: 20px;
        font-weight: 800;
        margin: 0;
        position: relative;
    }

    .contact-body { padding: 24px; }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 18px;
        background: linear-gradient(135deg, var(--slate-50) 0%, white 100%);
        border-radius: 16px;
        margin-bottom: 12px;
        transition: all 0.3s var(--spring-easing);
        border: 1px solid transparent;
    }

    .contact-item:last-child { margin-bottom: 0; }

    .contact-item:hover {
        background: white;
        border-color: rgba(139, 92, 246, 0.2);
        transform: translateX(8px);
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
    }

    .contact-item-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        transition: transform 0.3s var(--spring-easing);
    }

    .contact-item:hover .contact-item-icon { transform: scale(1.1) rotate(-5deg); }
    .contact-item-icon svg { width: 22px; height: 22px; }

    .contact-item-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--slate-500);
        margin-bottom: 4px;
    }

    .contact-item-value {
        font-size: 15px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0;
    }

    /* ===== BUTTONS ===== */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        font-size: 15px;
        font-weight: 700;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s var(--spring-easing);
        box-shadow: 0 8px 24px rgba(238, 46, 36, 0.3);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 32px rgba(238, 46, 36, 0.4);
        color: white;
    }

    .btn-primary:hover::before { left: 100%; }
    .btn-primary svg { width: 20px; height: 20px; }

    .btn-success {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 28px;
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        color: white;
        font-size: 15px;
        font-weight: 700;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s var(--spring-easing);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-success::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-success:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 12px 32px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-success:hover::before { left: 100%; }
    .btn-success svg { width: 20px; height: 20px; }

    /* ===== EMPTY STATE ===== */
    .empty-state { text-align: center; padding: 80px 32px; }

    .empty-icon {
        width: 120px; height: 120px;
        background: linear-gradient(135deg, var(--slate-100) 0%, var(--slate-200) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 32px;
        animation: float 5s ease-in-out infinite;
    }

    .empty-icon svg { width: 56px; height: 56px; color: var(--slate-400); }

    .empty-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--slate-800);
        margin: 0 0 12px 0;
    }

    .empty-text {
        font-size: 16px;
        color: var(--slate-500);
        max-width: 400px;
        margin: 0 auto 32px;
        line-height: 1.7;
    }

    /* ===== UTILITIES ===== */
    .text-end { text-align: right; }
    .mt-4 { margin-top: 16px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .stepper-wrapper { flex-wrap: wrap; justify-content: center; gap: 24px; }
        .stepper-line { display: none; }
        .step-item { flex: 0 0 auto; }
        .step-circle { width: 56px; height: 56px; }
        .hero-section { padding: 28px; }
        .hero-info h1 { font-size: 22px; }
        .hero-avatar { width: 64px; height: 64px; }
        .download-section { flex-direction: column; text-align: center; }
        .orb-1, .orb-2, .orb-3, .orb-4 { display: none; }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: var(--slate-100); border-radius: 4px; }
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover { background: var(--primary-dark); }
</style>
