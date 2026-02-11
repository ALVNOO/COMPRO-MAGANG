{{--
    ADMIN DASHBOARD STYLES
    Creative Design 2025 - Floating Orbs, Glassmorphism, Animations
--}}

<style>
    /* ============================================
       FLOATING GRADIENT ORBS
       ============================================ */
    .floating-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
        opacity: 0.4;
    }

    .orb-admin-1 {
        width: 450px;
        height: 450px;
        background: radial-gradient(circle, rgba(238, 46, 36, 0.35) 0%, transparent 70%);
        top: -120px;
        right: -100px;
        animation: orbFloat1 12s ease-in-out infinite;
    }

    .orb-admin-2 {
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(139, 92, 246, 0.25) 0%, transparent 70%);
        bottom: 15%;
        left: -100px;
        animation: orbFloat2 16s ease-in-out infinite;
    }

    .orb-admin-3 {
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
        top: 40%;
        right: -60px;
        animation: orbFloat3 20s ease-in-out infinite;
    }

    .orb-admin-4 {
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
        bottom: -80px;
        left: 35%;
        animation: orbFloat1 18s ease-in-out infinite reverse;
    }

    @keyframes orbFloat1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        25% { transform: translate(40px, -50px) rotate(5deg); }
        50% { transform: translate(-30px, -70px) rotate(-3deg); }
        75% { transform: translate(-50px, -25px) rotate(2deg); }
    }

    @keyframes orbFloat2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(60px, 40px) scale(1.1); }
        66% { transform: translate(25px, -50px) scale(0.95); }
    }

    @keyframes orbFloat3 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-70px, 50px); }
    }

    /* Grid Pattern Overlay */
    .grid-pattern-admin {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            linear-gradient(rgba(238, 46, 36, 0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(238, 46, 36, 0.025) 1px, transparent 1px);
        background-size: 60px 60px;
        pointer-events: none;
        z-index: 0;
        animation: gridMoveAdmin 35s linear infinite;
    }

    @keyframes gridMoveAdmin {
        0% { transform: translate(0, 0); }
        100% { transform: translate(60px, 60px); }
    }

    .admin-dashboard-creative {
        position: relative;
        z-index: 1;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .hero-admin {
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 50%, #8B1A1A 100%);
        border-radius: 24px;
        padding: 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 25px 60px rgba(238, 46, 36, 0.35),
            0 0 0 1px rgba(255, 255, 255, 0.1) inset;
    }

    .hero-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
        background-size: 35px 35px;
        pointer-events: none;
    }

    .hero-glow-1 {
        position: absolute;
        top: -60%;
        right: -15%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.18) 0%, transparent 70%);
        pointer-events: none;
        animation: heroGlowPulse 8s ease-in-out infinite;
    }

    .hero-glow-2 {
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
        animation: heroGlowPulse 10s ease-in-out infinite reverse;
    }

    @keyframes heroGlowPulse {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50% { transform: scale(1.15); opacity: 0.8; }
    }

    .hero-shape-admin {
        position: absolute;
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-shape-1 {
        width: 120px;
        height: 120px;
        bottom: 20px;
        right: 25%;
        animation: shapeSpin 25s linear infinite;
    }

    .hero-shape-2 {
        width: 60px;
        height: 60px;
        top: 30px;
        right: 15%;
        animation: shapeSpin 20s linear infinite reverse;
    }

    .hero-shape-3 {
        width: 40px;
        height: 40px;
        bottom: 40%;
        right: 8%;
        animation: shapeSpin 15s linear infinite;
    }

    @keyframes shapeSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .hero-admin-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }

    .hero-admin-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .hero-admin-avatar {
        position: relative;
    }

    .hero-admin-ring {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.1));
        padding: 4px;
        animation: ringPulse 3s ease-in-out infinite;
    }

    @keyframes ringPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.3); }
        50% { box-shadow: 0 0 0 12px rgba(255,255,255,0); }
    }

    .hero-admin-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
    }

    .hero-admin-text h1 {
        font-size: 28px;
        font-weight: 800;
        color: white;
        margin: 0 0 6px 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .hero-admin-text p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
    }

    .hero-admin-stats {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 14px 22px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-stat-icon {
        width: 42px;
        height: 42px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: white;
    }

    .hero-stat-content {
        text-align: left;
    }

    .hero-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 600;
    }

    .hero-stat-value {
        font-size: 26px;
        font-weight: 800;
        color: white;
        line-height: 1.1;
    }

    .hero-stat-desc {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.8);
    }

    /* ============================================
       STATS GRID
       ============================================ */
    .stats-grid-admin {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 18px;
    }

    @media (max-width: 1280px) {
        .stats-grid-admin {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid-admin {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .stat-card-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        padding: 22px;
        position: relative;
        overflow: hidden;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        opacity: 0;
        transform: translateY(30px);
    }

    .stat-card-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .stat-card-admin:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.9) inset;
    }

    .stat-card-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }

    .stat-card-admin.red::before { background: linear-gradient(90deg, #EE2E24, #FF6B6B); }
    .stat-card-admin.blue::before { background: linear-gradient(90deg, #3B82F6, #60A5FA); }
    .stat-card-admin.amber::before { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
    .stat-card-admin.green::before { background: linear-gradient(90deg, #10B981, #34D399); }
    .stat-card-admin.purple::before { background: linear-gradient(90deg, #8B5CF6, #A78BFA); }
    .stat-card-admin.cyan::before { background: linear-gradient(90deg, #06B6D4, #22D3EE); }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .stat-card-icon.red { background: linear-gradient(135deg, #FEE2E2, #FECACA); color: #EE2E24; }
    .stat-card-icon.blue { background: linear-gradient(135deg, #DBEAFE, #BFDBFE); color: #3B82F6; }
    .stat-card-icon.amber { background: linear-gradient(135deg, #FEF3C7, #FDE68A); color: #F59E0B; }
    .stat-card-icon.green { background: linear-gradient(135deg, #D1FAE5, #A7F3D0); color: #10B981; }
    .stat-card-icon.purple { background: linear-gradient(135deg, #EDE9FE, #DDD6FE); color: #8B5CF6; }
    .stat-card-icon.cyan { background: linear-gradient(135deg, #CFFAFE, #A5F3FC); color: #06B6D4; }

    .stat-card-admin:hover .stat-card-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-card-badge {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 100px;
    }

    .stat-card-badge.active {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .stat-card-badge.pending {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
    }

    .stat-card-value {
        font-size: 36px;
        font-weight: 800;
        color: #1E293B;
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-card-desc {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
    }

    /* ============================================
       CHART CARDS
       ============================================ */
    .chart-card-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .chart-card-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .chart-card-header {
        padding: 22px 26px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, transparent 100%);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chart-card-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #EE2E24;
    }

    .chart-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }

    .chart-card-body {
        padding: 24px;
        position: relative;
        min-height: 220px;
    }

    .chart-loading-admin {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .chart-loading-admin.active {
        opacity: 1;
        visibility: visible;
    }

    .chart-loading-spinner {
        width: 36px;
        height: 36px;
        border: 3px solid rgba(238, 46, 36, 0.2);
        border-top-color: #EE2E24;
        border-radius: 50%;
        animation: chartSpin 0.8s linear infinite;
    }

    @keyframes chartSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* ============================================
       QUICK ACTIONS
       ============================================ */
    .quick-actions-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .quick-actions-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        padding: 20px;
    }

    .quick-action-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 18px 14px;
        background: linear-gradient(180deg, rgba(255,255,255,0.8), rgba(248,250,252,0.6));
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .quick-action-item:hover {
        transform: translateY(-4px) scale(1.02);
        background: linear-gradient(180deg, #FFFFFF, #F8FAFC);
        border-color: rgba(238, 46, 36, 0.15);
        box-shadow: 0 8px 24px rgba(238, 46, 36, 0.12);
    }

    .quick-action-item i {
        font-size: 22px;
        color: #EE2E24;
        transition: transform 0.3s ease;
    }

    .quick-action-item:hover i {
        transform: scale(1.15);
    }

    .quick-action-item span {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
    }

    .quick-action-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        background: linear-gradient(135deg, #EE2E24, #C41E3A);
        border-radius: 100px;
        font-size: 11px;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: badgePulse 2s ease-in-out infinite;
    }

    @keyframes badgePulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* ============================================
       ACTIVITY FEED
       ============================================ */
    .activity-feed-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .activity-feed-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .activity-feed-header {
        padding: 22px 26px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, transparent 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .activity-feed-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .activity-feed-title i {
        font-size: 18px;
        color: #EE2E24;
    }

    .activity-feed-title h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }

    .live-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #64748B;
        background: rgba(248, 250, 252, 0.8);
        padding: 6px 12px;
        border-radius: 100px;
    }

    .live-dot-admin {
        width: 8px;
        height: 8px;
        background: #10B981;
        border-radius: 50%;
        animation: livePulse 2s ease-in-out infinite;
    }

    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }

    .activity-feed-body {
        padding: 20px;
        max-height: 320px;
        overflow-y: auto;
    }

    .activity-item-admin {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px;
        margin-bottom: 10px;
        background: linear-gradient(180deg, rgba(255,255,255,0.8), rgba(248,250,252,0.5));
        border: 1px solid rgba(0, 0, 0, 0.03);
        border-radius: 14px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateX(-20px);
    }

    .activity-item-admin.visible {
        opacity: 1;
        transform: translateX(0);
    }

    .activity-item-admin:hover {
        background: rgba(255, 255, 255, 0.95);
        border-color: rgba(238, 46, 36, 0.1);
    }

    .activity-icon-admin {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .activity-icon-admin.pending {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
    }

    .activity-icon-admin.accepted {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .activity-icon-admin.rejected {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    .activity-icon-admin.finished {
        background: linear-gradient(135deg, #EDE9FE, #DDD6FE);
        color: #5B21B6;
    }

    .activity-content-admin {
        flex: 1;
        min-width: 0;
    }

    .activity-content-admin .name {
        font-size: 14px;
        font-weight: 600;
        color: #1E293B;
        margin: 0 0 2px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-content-admin .status {
        font-size: 12px;
        color: #64748B;
        margin: 0;
    }

    .activity-content-admin .status span {
        font-weight: 600;
    }

    .activity-content-admin .status span.pending { color: #F59E0B; }
    .activity-content-admin .status span.accepted { color: #10B981; }
    .activity-content-admin .status span.rejected { color: #EF4444; }
    .activity-content-admin .status span.finished { color: #8B5CF6; }

    .activity-time-admin {
        font-size: 11px;
        color: #94A3B8;
        white-space: nowrap;
    }

    .activity-empty-admin {
        text-align: center;
        padding: 40px;
        color: #94A3B8;
    }

    .activity-empty-admin i {
        font-size: 36px;
        margin-bottom: 12px;
        display: block;
    }

    /* Staggered animation delays for activity items */
    .activity-item-admin:nth-child(1) { transition-delay: 0.05s; }
    .activity-item-admin:nth-child(2) { transition-delay: 0.1s; }
    .activity-item-admin:nth-child(3) { transition-delay: 0.15s; }
    .activity-item-admin:nth-child(4) { transition-delay: 0.2s; }
    .activity-item-admin:nth-child(5) { transition-delay: 0.25s; }

    /* ============================================
       TABLE CARD
       ============================================ */
    .table-card-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .table-card-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .table-card-header {
        padding: 22px 26px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, transparent 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .table-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-card-title i {
        font-size: 18px;
        color: #EE2E24;
    }

    .table-card-title h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }

    .table-card-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #EE2E24;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .table-card-link:hover {
        gap: 10px;
    }

    .table-admin {
        width: 100%;
    }

    .table-admin thead {
        background: linear-gradient(180deg, #F8FAFC, #F1F5F9);
    }

    .table-admin th {
        padding: 14px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-admin td {
        padding: 16px 20px;
        font-size: 14px;
        color: #475569;
        border-bottom: 1px solid rgba(0, 0, 0, 0.03);
    }

    .table-admin tbody tr {
        transition: all 0.3s ease;
    }

    .table-admin tbody tr:hover {
        background: rgba(238, 46, 36, 0.03);
    }

    .table-admin tbody tr:last-child td {
        border-bottom: none;
    }

    .table-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(238, 46, 36, 0.25);
    }

    .table-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-user .name {
        font-weight: 600;
        color: #1E293B;
    }

    .table-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 12px;
        font-weight: 600;
    }

    .table-status.pending {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400E;
    }

    .table-status.accepted {
        background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
        color: #065F46;
    }

    .table-status.rejected {
        background: linear-gradient(135deg, #FEE2E2, #FECACA);
        color: #991B1B;
    }

    .table-status.finished {
        background: linear-gradient(135deg, #EDE9FE, #DDD6FE);
        color: #5B21B6;
    }

    .table-empty {
        text-align: center;
        padding: 50px 24px;
        color: #94A3B8;
    }

    .table-empty i {
        font-size: 40px;
        margin-bottom: 12px;
        display: block;
    }

    /* ============================================
       RULES SECTION
       ============================================ */
    .rules-card-admin {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow:
            0 4px 24px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.8) inset;
        overflow: hidden;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .rules-card-admin.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .rules-card-header {
        padding: 22px 26px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, transparent 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .rules-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .rules-card-title i {
        font-size: 18px;
        color: #EE2E24;
    }

    .rules-card-title h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }

    .rules-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-rules {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-rules.primary {
        background: linear-gradient(135deg, #EE2E24 0%, #C41E3A 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(238, 46, 36, 0.3);
    }

    .btn-rules.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(238, 46, 36, 0.4);
    }

    .btn-rules.secondary {
        background: linear-gradient(180deg, #F8FAFC, #F1F5F9);
        color: #475569;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .btn-rules.secondary:hover {
        background: #F1F5F9;
    }

    .rules-content {
        padding: 24px 26px;
        background: rgba(248, 250, 252, 0.5);
    }

    .rules-content p {
        font-size: 14px;
        line-height: 1.8;
        color: #475569;
        margin: 0;
    }

    .rules-empty {
        text-align: center;
        padding: 30px;
        color: #94A3B8;
    }

    .rules-empty i {
        font-size: 32px;
        margin-bottom: 10px;
        display: block;
    }

    /* ============================================
       MODAL
       ============================================ */
    .modal-backdrop-admin {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 100;
    }

    .modal-container-admin {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 101;
    }

    .modal-box-admin {
        background: white;
        border-radius: 24px;
        width: 100%;
        max-width: 560px;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
    }

    .modal-header-admin {
        padding: 22px 26px;
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.8) 0%, transparent 100%);
        border-bottom: 1px solid rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title-admin {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-title-admin i {
        font-size: 20px;
        color: #EE2E24;
    }

    .modal-title-admin h5 {
        font-size: 18px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }

    .modal-close-admin {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(248, 250, 252, 0.8);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #64748B;
    }

    .modal-close-admin:hover {
        background: #F1F5F9;
        color: #1E293B;
    }

    .modal-body-admin {
        padding: 26px;
    }

    .modal-body-admin label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 10px;
    }

    .modal-body-admin textarea {
        width: 100%;
        padding: 16px;
        border: 2px solid rgba(0, 0, 0, 0.08);
        border-radius: 14px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .modal-body-admin textarea:focus {
        outline: none;
        border-color: #EE2E24;
        box-shadow: 0 0 0 4px rgba(238, 46, 36, 0.1);
    }

    .modal-footer-admin {
        padding: 20px 26px;
        background: rgba(248, 250, 252, 0.5);
        border-top: 1px solid rgba(0, 0, 0, 0.04);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
</style>
