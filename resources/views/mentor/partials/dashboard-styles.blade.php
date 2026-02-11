{{--
    MENTOR DASHBOARD STYLES
    Creative Design 2025 - Floating Orbs, Glassmorphism, Animations
--}}

<style>
    :root {
        --primary: #EE2E24;
        --primary-dark: #C41E3A;
        --primary-light: #FF6B6B;
        --success: #10B981;
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
    }

    /* Background */
    .mentor-dashboard {
        min-height: 100vh;
        background: linear-gradient(180deg, var(--slate-50) 0%, #FFFFFF 50%, var(--slate-50) 100%);
        padding: 24px;
        position: relative;
        overflow-x: hidden;
    }

    @media (min-width: 768px) {
        .mentor-dashboard { padding: 32px; }
    }

    /* Floating Gradient Orbs */
    .floating-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
        opacity: 0.5;
    }

    .orb-1 {
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(238, 46, 36, 0.3) 0%, transparent 70%);
        top: -100px; right: -100px;
        animation: orbFloat1 12s ease-in-out infinite;
    }

    .orb-2 {
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.25) 0%, transparent 70%);
        bottom: 20%; left: -80px;
        animation: orbFloat2 15s ease-in-out infinite;
    }

    .orb-3 {
        width: 250px; height: 250px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
        top: 50%; right: -50px;
        animation: orbFloat3 18s ease-in-out infinite;
    }

    .orb-4 {
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        bottom: -100px; left: 30%;
        animation: orbFloat1 20s ease-in-out infinite reverse;
    }

    @keyframes orbFloat1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(30px, -40px) rotate(5deg); }
        50% { transform: translate(-20px, -60px) rotate(-3deg); }
        75% { transform: translate(-40px, -20px) rotate(2deg); }
    }

    @keyframes orbFloat2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(50px, 30px) scale(1.1); }
        66% { transform: translate(20px, -40px) scale(0.95); }
    }

    @keyframes orbFloat3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-60px, 40px); }
    }

    /* Grid Pattern */
    .grid-pattern {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            linear-gradient(rgba(238, 46, 36, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(238, 46, 36, 0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
        z-index: 0;
        animation: gridMove 30s linear infinite;
    }

    @keyframes gridMove {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .content-container {
        position: relative;
        z-index: 1;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 50%, #8B1A1A 100%);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(238, 46, 36, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        pointer-events: none;
        animation: heroGlow 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%; left: -10%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        pointer-events: none;
        animation: heroGlow 10s ease-in-out infinite reverse;
    }

    @keyframes heroGlow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 0.8; }
    }

    .hero-grid {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 30px 30px;
        pointer-events: none;
        opacity: 0.5;
    }

    .hero-shape {
        position: absolute;
        pointer-events: none;
        opacity: 0.1;
    }

    .hero-shape-1 {
        width: 80px; height: 80px;
        border: 3px solid white;
        border-radius: 50%;
        top: 20px; right: 15%;
        animation: shapeFloat 6s ease-in-out infinite;
    }

    .hero-shape-2 {
        width: 40px; height: 40px;
        background: white;
        border-radius: 8px;
        bottom: 30px; right: 25%;
        transform: rotate(45deg);
        animation: shapeFloat 8s ease-in-out infinite reverse;
    }

    .hero-shape-3 {
        width: 60px; height: 60px;
        border: 2px solid white;
        top: 50%; right: 8%;
        transform: rotate(15deg);
        animation: shapeRotate 12s linear infinite;
    }

    @keyframes shapeFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    @keyframes shapeRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .hero-content {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .hero-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .hero-avatar { position: relative; flex-shrink: 0; }

    .hero-avatar-ring {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, rgba(255,255,255,0.8) 0deg, rgba(255,255,255,0.2) 120deg, rgba(255,255,255,0.8) 240deg, rgba(255,255,255,0.2) 360deg);
        padding: 4px;
        animation: ringRotate 8s linear infinite;
    }

    @keyframes ringRotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .hero-avatar-inner {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .hero-avatar-inner svg {
        width: 36px; height: 36px;
        color: white;
    }

    .hero-text h1 {
        font-size: 26px;
        font-weight: 800;
        color: white;
        margin: 0 0 6px 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .hero-text p {
        font-size: 14px;
        color: rgba(255,255,255,0.85);
        margin: 0;
    }

    .hero-divisi {
        background: rgba(255,255,255,0.12);
        backdrop-filter: blur(20px);
        padding: 16px 24px;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.2);
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .hero-divisi:hover {
        transform: translateY(-4px);
        background: rgba(255,255,255,0.18);
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .hero-divisi-item { display: flex; flex-direction: column; gap: 4px; }

    .hero-divisi-label {
        font-size: 11px;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }

    .hero-divisi-value {
        font-size: 15px;
        font-weight: 700;
        color: white;
    }

    /* Alert Card */
    .alert-card {
        background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 16px;
        padding: 18px 24px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 18px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(245, 158, 11, 0.15);
        animation: alertSlideIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes alertSlideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .alert-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(251, 191, 36, 0.2) 50%, transparent 100%);
        animation: alertGlow 3s ease-in-out infinite;
    }

    @keyframes alertGlow {
        0%, 100% { transform: translateX(-100%); }
        50% { transform: translateX(100%); }
    }

    .alert-icon {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
        animation: iconPulse 2s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }

    .alert-icon svg { width: 24px; height: 24px; color: white; }

    .alert-content { flex: 1; position: relative; z-index: 1; }

    .alert-title {
        font-size: 15px;
        font-weight: 700;
        color: #92400E;
        margin: 0 0 4px 0;
    }

    .alert-desc {
        font-size: 13px;
        color: #B45309;
        margin: 0;
    }

    .alert-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%);
        border-radius: 10px;
        color: white;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);
        position: relative;
        z-index: 1;
    }

    .alert-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.45);
        color: white;
    }

    .alert-btn svg { width: 16px; height: 16px; transition: transform 0.3s ease; }
    .alert-btn:hover svg { transform: translateX(4px); }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
    }

    .stat-card.visible { opacity: 1; transform: translateY(0); }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 150px; height: 150px;
        border-radius: 50%;
        opacity: 0.08;
        transition: all 0.5s ease;
    }

    .stat-card.green::before { background: linear-gradient(90deg, var(--success), #34D399); }
    .stat-card.green::after { background: var(--success); }
    .stat-card.amber::before { background: linear-gradient(90deg, var(--warning), #FBBF24); }
    .stat-card.amber::after { background: var(--warning); }
    .stat-card.blue::before { background: linear-gradient(90deg, var(--info), #60A5FA); }
    .stat-card.blue::after { background: var(--info); }
    .stat-card.purple::before { background: linear-gradient(90deg, var(--purple), #A78BFA); }
    .stat-card.purple::after { background: var(--purple); }
    .stat-card.cyan::before { background: linear-gradient(90deg, var(--cyan), #22D3EE); }
    .stat-card.cyan::after { background: var(--cyan); }
    .stat-card.red::before { background: linear-gradient(90deg, var(--primary), #F87171); }
    .stat-card.red::after { background: var(--primary); }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.9) inset;
    }

    .stat-card:hover::after { transform: scale(1.5); opacity: 0.12; }

    .stat-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 18px;
    }

    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
    .stat-icon svg { width: 24px; height: 24px; color: white; }

    .stat-icon.green { background: linear-gradient(135deg, var(--success) 0%, #059669 100%); }
    .stat-icon.amber { background: linear-gradient(135deg, var(--warning) 0%, #D97706 100%); }
    .stat-icon.blue { background: linear-gradient(135deg, var(--info) 0%, #2563EB 100%); }
    .stat-icon.purple { background: linear-gradient(135deg, var(--purple) 0%, #7C3AED 100%); }
    .stat-icon.cyan { background: linear-gradient(135deg, var(--cyan) 0%, #0891B2 100%); }
    .stat-icon.red { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); }

    .stat-label {
        font-size: 11px;
        color: var(--slate-400);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 800;
        color: var(--slate-800);
        line-height: 1;
        margin-bottom: 6px;
        font-variant-numeric: tabular-nums;
    }

    .stat-desc {
        font-size: 13px;
        color: var(--slate-500);
        font-weight: 500;
    }

    .stat-card.has-pending .stat-icon { animation: iconShake 0.5s ease-in-out infinite; }

    @keyframes iconShake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-3deg); }
        75% { transform: rotate(3deg); }
    }

    /* Charts */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    @media (max-width: 1024px) { .charts-grid { grid-template-columns: 1fr; } }

    .chart-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .chart-card.visible { opacity: 1; transform: translateY(0); }

    .chart-card:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.9) inset;
    }

    .chart-header {
        padding: 24px 28px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 14px;
        background: linear-gradient(180deg, rgba(255,255,255,0.5) 0%, transparent 100%);
    }

    .chart-icon {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(238, 46, 36, 0.3);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .chart-card:hover .chart-icon { transform: rotate(-5deg) scale(1.05); }
    .chart-icon svg { width: 22px; height: 22px; color: white; }

    .chart-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0;
    }

    .chart-body { padding: 24px 28px; position: relative; }

    .chart-loading {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .chart-loading.active { opacity: 1; pointer-events: auto; }

    .chart-loading-spinner {
        width: 40px; height: 40px;
        border: 3px solid var(--slate-200);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* Activity Card */
    .activity-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        margin-bottom: 28px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .activity-card.visible { opacity: 1; transform: translateY(0); }

    .activity-header {
        padding: 24px 28px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        position: relative;
        overflow: hidden;
    }

    .activity-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
        background-size: 20px 20px;
        pointer-events: none;
    }

    .activity-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 1;
    }

    .activity-header-icon {
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .activity-header-icon svg { width: 22px; height: 22px; color: white; }
    .activity-header-title { color: white; }
    .activity-header-title h4 { font-size: 17px; font-weight: 700; margin: 0; }
    .activity-header-title p { font-size: 13px; color: rgba(255,255,255,0.7); margin: 0; }

    .live-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: rgba(255,255,255,0.15);
        border-radius: 100px;
        position: relative;
        z-index: 1;
    }

    .live-dot {
        width: 8px; height: 8px;
        background: #4ADE80;
        border-radius: 50%;
        animation: livePulse 2s ease-in-out infinite;
    }

    @keyframes livePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); transform: scale(1); }
        50% { box-shadow: 0 0 0 8px rgba(74, 222, 128, 0); transform: scale(1.1); }
    }

    .live-text { font-size: 12px; font-weight: 600; color: white; letter-spacing: 0.5px; }

    .activity-body { padding: 0; max-height: 450px; overflow-y: auto; }

    .activity-body::-webkit-scrollbar { width: 6px; }
    .activity-body::-webkit-scrollbar-track { background: var(--slate-100); }
    .activity-body::-webkit-scrollbar-thumb { background: var(--slate-300); border-radius: 3px; }
    .activity-body::-webkit-scrollbar-thumb:hover { background: var(--slate-400); }

    .activity-item {
        display: flex;
        gap: 16px;
        padding: 20px 28px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateX(-20px);
    }

    .activity-item.visible { opacity: 1; transform: translateX(0); }
    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: rgba(238, 46, 36, 0.03); }

    .activity-item.new {
        background: linear-gradient(90deg, rgba(74, 222, 128, 0.1) 0%, transparent 100%);
        animation: newItemGlow 2s ease-out;
    }

    @keyframes newItemGlow {
        from { background: linear-gradient(90deg, rgba(74, 222, 128, 0.3) 0%, transparent 100%); }
        to { background: linear-gradient(90deg, rgba(74, 222, 128, 0.1) 0%, transparent 100%); }
    }

    .activity-avatar {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(238, 46, 36, 0.25);
    }

    .activity-avatar svg { width: 22px; height: 22px; color: white; }
    .activity-content { flex: 1; min-width: 0; }
    .activity-name { font-size: 15px; font-weight: 600; color: var(--slate-800); margin: 0 0 4px 0; }

    .activity-desc {
        font-size: 13px;
        color: var(--slate-500);
        margin: 0 0 6px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-time {
        font-size: 12px;
        color: var(--slate-400);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .activity-time svg { width: 14px; height: 14px; }

    .activity-badge {
        padding: 8px 14px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
        align-self: center;
        transition: all 0.3s ease;
    }

    .activity-badge.graded {
        background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
        color: #065F46;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .activity-badge.pending {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #92400E;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {
        0%, 100% { box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2); }
        50% { box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4); }
    }

    .activity-empty { text-align: center; padding: 60px 24px; color: var(--slate-400); }

    .activity-empty-icon {
        width: 80px; height: 80px;
        background: var(--slate-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .activity-empty-icon svg { width: 40px; height: 40px; color: var(--slate-400); }
    .activity-empty p { font-size: 14px; margin: 0; }

    /* Quick Actions */
    .quick-actions-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .quick-actions-card.visible { opacity: 1; transform: translateY(0); }

    .quick-actions-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions-title svg { width: 22px; height: 22px; color: var(--primary); }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    @media (max-width: 768px) { .quick-actions-grid { grid-template-columns: repeat(2, 1fr); } }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        padding: 28px 20px;
        background: linear-gradient(180deg, var(--slate-50) 0%, white 100%);
        border: 2px solid var(--slate-100);
        border-radius: 16px;
        color: var(--slate-700);
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }

    .quick-action-btn::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .quick-action-btn:hover::before { opacity: 1; }

    .quick-action-btn:hover {
        border-color: var(--primary);
        color: white;
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(238, 46, 36, 0.3);
    }

    .quick-action-btn svg {
        width: 32px; height: 32px;
        position: relative;
        z-index: 1;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .quick-action-btn:hover svg { transform: scale(1.15) rotate(-5deg); }

    .quick-action-btn span {
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    /* Action Cards */
    .action-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    @media (max-width: 1024px) { .action-cards-grid { grid-template-columns: 1fr; } }

    .action-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 28px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        opacity: 0;
        transform: translateY(30px);
    }

    .action-card.visible { opacity: 1; transform: translateY(0); }

    .action-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
    }

    .action-card::after {
        content: '';
        position: absolute;
        bottom: -30%; right: -20%;
        width: 200px; height: 200px;
        border-radius: 50%;
        opacity: 0.05;
        transition: all 0.5s ease;
    }

    .action-card.red::before { background: linear-gradient(90deg, var(--primary), var(--primary-dark)); }
    .action-card.red::after { background: var(--primary); }
    .action-card.green::before { background: linear-gradient(90deg, var(--success), #34D399); }
    .action-card.green::after { background: var(--success); }
    .action-card.purple::before { background: linear-gradient(90deg, var(--purple), #A78BFA); }
    .action-card.purple::after { background: var(--purple); }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(255, 255, 255, 0.9) inset;
    }

    .action-card:hover::after { transform: scale(1.5); opacity: 0.1; }

    .action-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        position: relative;
        z-index: 1;
    }

    .action-card-icon {
        width: 54px; height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .action-card:hover .action-card-icon { transform: scale(1.1) rotate(-5deg); }
    .action-card-icon svg { width: 26px; height: 26px; color: white; }

    .action-card-icon.red {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        box-shadow: 0 8px 20px rgba(238, 46, 36, 0.3);
    }

    .action-card-icon.green {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .action-card-icon.purple {
        background: linear-gradient(135deg, var(--purple) 0%, #7C3AED 100%);
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
    }

    .action-card-title h4 { font-size: 17px; font-weight: 700; color: var(--slate-800); margin: 0 0 4px 0; }
    .action-card-title p { font-size: 13px; color: var(--slate-500); margin: 0; }

    .action-card-desc {
        font-size: 14px;
        color: var(--slate-500);
        line-height: 1.7;
        margin-bottom: 22px;
        position: relative;
        z-index: 1;
    }

    .action-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: white;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        z-index: 1;
    }

    .action-card-btn:hover { transform: translateY(-3px); color: white; }
    .action-card-btn svg { width: 18px; height: 18px; transition: transform 0.3s ease; }
    .action-card-btn:hover svg { transform: translateX(4px); }

    .action-card-btn.red {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        box-shadow: 0 4px 15px rgba(238, 46, 36, 0.35);
    }
    .action-card-btn.red:hover { box-shadow: 0 8px 25px rgba(238, 46, 36, 0.45); }

    .action-card-btn.green {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
    }
    .action-card-btn.green:hover { box-shadow: 0 8px 25px rgba(16, 185, 129, 0.45); }

    .action-card-btn.purple {
        background: linear-gradient(135deg, var(--purple) 0%, #7C3AED 100%);
        box-shadow: 0 4px 15px rgba(139, 92, 246, 0.35);
    }
    .action-card-btn.purple:hover { box-shadow: 0 8px 25px rgba(139, 92, 246, 0.45); }

    /* Staggered Animations */
    .stat-card:nth-child(1) { transition-delay: 0.05s; }
    .stat-card:nth-child(2) { transition-delay: 0.1s; }
    .stat-card:nth-child(3) { transition-delay: 0.15s; }
    .stat-card:nth-child(4) { transition-delay: 0.2s; }
    .stat-card:nth-child(5) { transition-delay: 0.25s; }
    .stat-card:nth-child(6) { transition-delay: 0.3s; }
    .stat-card:nth-child(7) { transition-delay: 0.35s; }
    .stat-card:nth-child(8) { transition-delay: 0.4s; }

    .activity-item:nth-child(1) { transition-delay: 0.1s; }
    .activity-item:nth-child(2) { transition-delay: 0.15s; }
    .activity-item:nth-child(3) { transition-delay: 0.2s; }
    .activity-item:nth-child(4) { transition-delay: 0.25s; }
    .activity-item:nth-child(5) { transition-delay: 0.3s; }

    .action-card:nth-child(1) { transition-delay: 0.1s; }
    .action-card:nth-child(2) { transition-delay: 0.2s; }
    .action-card:nth-child(3) { transition-delay: 0.3s; }
</style>
