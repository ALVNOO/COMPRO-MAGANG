<style>
/* ==========================================
   STATUS PAGE — v4 Redesign
   Prefix: sp-
   ========================================== */

/* --- Reset & Tokens --- */
.sp {
    --red: #EE2E24;
    --red-l: #FEF2F2;
    --red-d: #B91C1C;
    --green: #059669;
    --green-l: #ECFDF5;
    --amber: #D97706;
    --amber-l: #FFFBEB;
    --blue: #2563EB;
    --blue-l: #EFF6FF;
    --purple: #7C3AED;
    --purple-l: #F5F3FF;
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
    --r: 12px;
    --r-lg: 16px;

    max-width: 100%;
    margin: -2rem;
    margin-bottom: 0;
    padding: 2rem;
    padding-bottom: 0;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: var(--slate-700);
    line-height: 1.5;
}
.sp *, .sp *::before, .sp *::after { box-sizing: border-box; }
.sp h1, .sp h2, .sp h3, .sp h4, .sp p { margin: 0; }

/* --- Animations --- */
@keyframes sp-up {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes sp-scale {
    from { opacity: 0; transform: scale(.95); }
    to { opacity: 1; transform: scale(1); }
}
@keyframes sp-fill {
    from { width: 0; }
    to { width: var(--fill); }
}
@keyframes sp-dot {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.4); opacity: .5; }
}
@keyframes sp-shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.sp-anim { animation: sp-up .5s cubic-bezier(.16,1,.3,1) both; }
.sp-anim-1 { animation-delay: .05s; }
.sp-anim-2 { animation-delay: .1s; }
.sp-anim-3 { animation-delay: .15s; }
.sp-anim-4 { animation-delay: .2s; }

/* ==========================================
   HERO BANNER
   ========================================== */
.sp-hero {
    position: relative;
    background: linear-gradient(135deg, #1E293B 0%, #0F172A 60%, #1a1033 100%);
    border-radius: var(--r-lg);
    padding: 28px 28px 24px;
    margin-bottom: 12px;
    overflow: hidden;
}
.sp-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(238,46,36,.15) 0%, transparent 70%);
    pointer-events: none;
}
.sp-hero::after {
    content: '';
    position: absolute;
    bottom: -40%;
    left: -10%;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(37,99,235,.1) 0%, transparent 70%);
    pointer-events: none;
}

.sp-hero-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.sp-hero-user {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.sp-hero-avatar {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(255,255,255,.1);
    border: 2px solid rgba(255,255,255,.15);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sp-hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
.sp-hero-avatar svg { width: 26px; height: 26px; color: rgba(255,255,255,.5); }

.sp-hero-name {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}
.sp-hero-meta {
    font-size: 14px;
    color: rgba(255,255,255,.55);
    margin-top: 3px;
}

/* Status badge */
.sp-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .2px;
    flex-shrink: 0;
}
.sp-badge svg { width: 15px; height: 15px; }
.sp-badge-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: currentColor;
    animation: sp-dot 2s ease-in-out infinite;
}

.sp-badge-pending { background: rgba(217,119,6,.15); color: #FBBF24; }
.sp-badge-accepted { background: rgba(5,150,105,.15); color: #34D399; }
.sp-badge-rejected { background: rgba(239,68,68,.15); color: #F87171; }
.sp-badge-finished { background: rgba(37,99,235,.15); color: #60A5FA; }

/* Progress bar (in hero) */
.sp-progress {
    display: flex;
    align-items: center;
    gap: 0;
    margin-top: 24px;
    position: relative;
    z-index: 1;
}

.sp-prog-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.sp-prog-bar {
    position: absolute;
    top: 15px;
    left: 50%;
    right: -50%;
    height: 2px;
    background: rgba(255,255,255,.1);
}
.sp-prog-step:last-child .sp-prog-bar { display: none; }

.sp-prog-bar-fill {
    height: 100%;
    background: var(--green);
    border-radius: 1px;
    transition: width .8s cubic-bezier(.16,1,.3,1);
}

.sp-prog-dot {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.3);
    border: 2px solid rgba(255,255,255,.1);
    position: relative;
    z-index: 2;
    transition: all .4s ease;
}

.sp-prog-step.done .sp-prog-dot {
    background: var(--green);
    color: #fff;
    border-color: var(--green);
    box-shadow: 0 0 12px rgba(5,150,105,.3);
}
.sp-prog-step.done .sp-prog-bar-fill { width: 100%; }

.sp-prog-step.active .sp-prog-dot {
    background: var(--red);
    color: #fff;
    border-color: var(--red);
    box-shadow: 0 0 12px rgba(238,46,36,.3);
}

.sp-prog-step.fail .sp-prog-dot {
    background: #EF4444;
    color: #fff;
    border-color: #EF4444;
}

.sp-prog-label {
    font-size: 11px;
    font-weight: 600;
    color: rgba(255,255,255,.35);
    margin-top: 8px;
    text-align: center;
    letter-spacing: .3px;
    text-transform: uppercase;
}
.sp-prog-step.done .sp-prog-label,
.sp-prog-step.active .sp-prog-label { color: rgba(255,255,255,.7); }
.sp-prog-step.fail .sp-prog-label { color: #F87171; }

/* ==========================================
   STATS ROW
   ========================================== */
.sp-notice {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fefce8;
    border: 1px solid #fde68a;
    border-radius: var(--r);
    padding: 14px 18px;
    margin-bottom: 12px;
}
.sp-notice-icon {
    flex-shrink: 0;
    width: 22px;
    height: 22px;
    color: #d97706;
}
.sp-notice-icon svg { width: 22px; height: 22px; }
.sp-notice-text {
    font-size: 14px;
    font-weight: 500;
    color: #92400e;
    line-height: 1.4;
}

/* ==========================================
   ALERT BANNER
   ========================================== */
.sp-alert {
    display: flex;
    gap: 12px;
    padding: 14px 18px;
    border-radius: var(--r);
    margin-bottom: 12px;
    align-items: flex-start;
}

.sp-alert-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sp-alert-icon svg { width: 16px; height: 16px; }

.sp-alert-body { min-width: 0; flex: 1; }
.sp-alert-title {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
}
.sp-alert-desc {
    font-size: 13px;
    line-height: 1.5;
}

.sp-alert-amber {
    background: #FFFBEB;
    border: 1px solid #FDE68A;
}
.sp-alert-amber .sp-alert-icon { background: var(--amber); color: white; }
.sp-alert-amber .sp-alert-title { color: #92400E; }
.sp-alert-amber .sp-alert-desc { color: #A16207; }

.sp-alert-red {
    background: #FEF2F2;
    border: 1px solid #FECACA;
}
.sp-alert-red .sp-alert-icon { background: #EF4444; color: white; }
.sp-alert-red .sp-alert-title { color: #991B1B; }
.sp-alert-red .sp-alert-desc { color: #B91C1C; }

.sp-alert-green {
    background: #ECFDF5;
    border: 1px solid #A7F3D0;
}
.sp-alert-green .sp-alert-icon { background: var(--green); color: white; }
.sp-alert-green .sp-alert-title { color: #065F46; }
.sp-alert-green .sp-alert-desc { color: #047857; }

/* ==========================================
   SECTION GRID
   ========================================== */
.sp-grid {
    display: grid;
    gap: 12px;
}
.sp-grid-2 { grid-template-columns: 1fr 1fr; }
.sp-grid-3 { grid-template-columns: 1fr 1fr 1fr; }
.sp-grid-sidebar { grid-template-columns: 1fr 340px; }
.sp-grid-wide { grid-template-columns: 1.2fr .8fr; }

@media (max-width: 768px) {
    .sp-grid-2,
    .sp-grid-3,
    .sp-grid-sidebar,
    .sp-grid-wide { grid-template-columns: 1fr; }
}

/* ==========================================
   CARD
   ========================================== */
.sp-card {
    background: #fff;
    border: 1px solid var(--slate-100);
    border-radius: var(--r);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color .2s, box-shadow .2s;
}
.sp-card:hover {
    border-color: var(--slate-200);
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}

.sp-card-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 18px;
    border-bottom: 1px solid var(--slate-100);
}

.sp-card-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sp-card-icon svg { width: 18px; height: 18px; }

.sp-ci-blue { background: var(--blue-l); color: var(--blue); }
.sp-ci-green { background: var(--green-l); color: var(--green); }
.sp-ci-red { background: var(--red-l); color: var(--red); }
.sp-ci-amber { background: var(--amber-l); color: var(--amber); }
.sp-ci-purple { background: var(--purple-l); color: var(--purple); }

.sp-card-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--slate-800);
}
.sp-card-sub {
    font-size: 12px;
    color: var(--slate-400);
    margin-top: 1px;
}

.sp-card-body {
    padding: 16px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.sp-card-footer {
    padding: 12px 18px;
    background: var(--slate-50);
    border-top: 1px solid var(--slate-100);
}

/* ==========================================
   DATA TABLE (Biodata)
   ========================================== */
.sp-data {
    flex: 1;
}

.sp-data-row {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px dashed var(--slate-100);
}
.sp-data-row:last-child { border-bottom: none; }

.sp-data-label {
    font-size: 13px;
    color: var(--slate-400);
    font-weight: 500;
    flex-shrink: 0;
    min-width: 100px;
}

.sp-data-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--slate-800);
    text-align: right;
    word-break: break-word;
}
.sp-data-value.muted { color: var(--slate-400); font-weight: 400; }

/* ==========================================
   PLACEMENT CARD (Accepted)
   ========================================== */
.sp-placement {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    margin-bottom: 14px;
}

@media (max-width: 600px) {
    .sp-placement { grid-template-columns: 1fr; }
}

.sp-place-item {
    background: var(--slate-50);
    border-radius: 10px;
    padding: 14px;
}
.sp-place-item-main {
    grid-column: 1 / -1;
    background: linear-gradient(135deg, var(--red), var(--red-d));
    color: #fff;
}
.sp-place-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    opacity: .6;
}
.sp-place-item-main .sp-place-label { color: rgba(255,255,255,.7); }
.sp-place-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--slate-800);
    margin-top: 4px;
}
.sp-place-item-main .sp-place-value {
    font-size: 20px;
    color: #fff;
}

/* ==========================================
   FIELD OF INTEREST
   ========================================== */
.sp-field {
    background: linear-gradient(135deg, var(--slate-50), #fff);
    border: 1px solid var(--slate-100);
    border-radius: 10px;
    padding: 16px;
    flex: 1;
}
.sp-field-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--slate-400);
}
.sp-field-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--red);
    margin-top: 4px;
}
.sp-field-desc {
    font-size: 13px;
    color: var(--slate-500);
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed var(--slate-200);
    line-height: 1.6;
}

/* ==========================================
   TIMELINE
   ========================================== */
.sp-timeline {
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    padding-left: 20px;
    flex: 1;
}
.sp-timeline::before {
    content: '';
    position: absolute;
    left: 4px;
    top: 5px;
    bottom: 5px;
    width: 2px;
    background: var(--slate-100);
    border-radius: 1px;
}

.sp-tl-item {
    position: relative;
    padding: 8px 0;
}
.sp-tl-item:first-child { padding-top: 0; }
.sp-tl-item:last-child { padding-bottom: 0; }

.sp-tl-dot {
    position: absolute;
    left: -20px;
    top: 10px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
}
.sp-tl-item:first-child .sp-tl-dot { top: 2px; }

.sp-tl-dot.red { background: var(--red); box-shadow: 0 0 0 2px var(--red); }
.sp-tl-dot.green { background: var(--green); box-shadow: 0 0 0 2px var(--green); }
.sp-tl-dot.blue { background: var(--blue); box-shadow: 0 0 0 2px var(--blue); }
.sp-tl-dot.amber { background: var(--amber); box-shadow: 0 0 0 2px var(--amber); }

.sp-tl-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--slate-700);
}
.sp-tl-date {
    font-size: 12px;
    color: var(--slate-400);
    margin-top: 2px;
}

/* ==========================================
   CONTACT SECTION
   ========================================== */
.sp-contacts {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.sp-contact {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--slate-600);
    font-weight: 500;
}
.sp-contact-icon {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    background: var(--slate-50);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sp-contact-icon svg { width: 14px; height: 14px; color: var(--slate-400); }

/* ==========================================
   EMPTY STATE
   ========================================== */
.sp-empty {
    text-align: center;
    padding: 60px 24px;
    background: #fff;
    border: 1px solid var(--slate-100);
    border-radius: var(--r-lg);
}
.sp-empty-icon {
    width: 72px; height: 72px;
    background: var(--slate-50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}
.sp-empty-icon svg { width: 32px; height: 32px; color: var(--slate-300); }

.sp-empty h2 {
    font-size: 18px;
    font-weight: 700;
    color: var(--slate-800);
    margin-bottom: 6px;
}
.sp-empty p {
    font-size: 13px;
    color: var(--slate-400);
    max-width: 340px;
    margin: 0 auto 20px;
    line-height: 1.6;
}

/* ==========================================
   BUTTONS
   ========================================== */
.sp-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s ease;
}
.sp-btn svg { width: 16px; height: 16px; }

.sp-btn-red {
    background: var(--red);
    color: white;
}
.sp-btn-red:hover {
    background: var(--red-d);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(238,46,36,.2);
    color: white;
}

.sp-btn-outline {
    background: transparent;
    color: var(--slate-600);
    border: 1px solid var(--slate-200);
}
.sp-btn-outline:hover {
    background: var(--slate-50);
    border-color: var(--slate-300);
    color: var(--slate-700);
}

/* ==========================================
   INTERNSHIP DATE RANGE
   ========================================== */
.sp-date-range {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--slate-50);
    border-radius: 8px;
    padding: 10px 14px;
    margin-top: 10px;
}
.sp-date-range svg { width: 18px; height: 18px; color: var(--slate-400); flex-shrink: 0; }
.sp-date-label { font-size: 12px; color: var(--slate-400); font-weight: 500; }
.sp-date-value { font-size: 14px; font-weight: 600; color: var(--slate-700); }
.sp-date-sep {
    width: 16px;
    height: 1px;
    background: var(--slate-300);
    flex-shrink: 0;
}

/* ==========================================
   LEGACY COMPAT
   Sub-partials: requirements, upload, download
   ========================================== */
.alert-box {
    padding: 18px;
    border-radius: var(--r);
    margin-top: 16px;
}
.alert-box::before { display: none; }
.alert-box.warning { background: #FFFBEB; border: 1px solid #FDE68A; }
.alert-box.danger { background: #FEF2F2; border: 1px solid #FECACA; }
.alert-box.success { background: #ECFDF5; border: 1px solid #A7F3D0; }

.alert-header { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }

.alert-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}
.alert-icon svg { width: 16px; height: 16px; }
.alert-box.warning .alert-icon { background: var(--amber); }
.alert-box.danger .alert-icon { background: #EF4444; }
.alert-box.success .alert-icon { background: var(--green); }

.alert-title { font-size: 13px; font-weight: 700; margin: 0 0 2px; }
.alert-box.warning .alert-title { color: #92400E; }
.alert-box.danger .alert-title { color: #991B1B; }
.alert-box.success .alert-title { color: #065F46; }

.alert-subtitle { font-size: 12px; margin: 0; }
.alert-box.warning .alert-subtitle { color: #B45309; }
.alert-box.danger .alert-subtitle { color: #B91C1C; }
.alert-box.success .alert-subtitle { color: #047857; }

.alert-list { padding-left: 20px; margin: 0 0 14px; }
.alert-list li { padding: 3px 0; font-size: 12px; }
.alert-box.warning .alert-list li { color: #78350F; }

.alert-list a { color: var(--red); font-weight: 600; text-decoration: none; }
.alert-list a:hover { text-decoration: underline; }
.alert-body-text { font-size: 13px; line-height: 1.6; margin: 8px 0 0; }

/* Upload */
.upload-section {
    background: white;
    border: 1px solid var(--slate-200);
    border-radius: var(--r);
    padding: 18px;
    margin-top: 16px;
}
.upload-section::before { display: none; }

.upload-header { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }

.upload-icon {
    width: 36px; height: 36px;
    background: var(--blue);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}
.upload-icon svg { width: 18px; height: 18px; }
.upload-arrows { display: none; }

.upload-title { font-size: 14px; font-weight: 700; color: var(--slate-800); margin: 0; }
.upload-subtitle { font-size: 11px; color: var(--slate-400); margin: 2px 0 0; }

.upload-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 8px;
}

.upload-item {
    background: var(--slate-50);
    padding: 12px;
    border-radius: 8px;
    border: 1px solid transparent;
    transition: border-color .2s;
}
.upload-item::before { display: none; }
.upload-item:hover { border-color: var(--slate-200); }

.upload-item label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 600; color: var(--slate-700);
    margin-bottom: 6px;
}
.upload-item label svg { width: 14px; height: 14px; flex-shrink: 0; }

.upload-item input[type="file"] { width: 100%; font-size: 11px; color: var(--slate-600); }
.upload-item input[type="file"]::file-selector-button {
    padding: 5px 10px; border-radius: 6px;
    border: 1px solid var(--slate-200); background: white;
    color: var(--slate-700); font-size: 10px; font-weight: 600;
    cursor: pointer; margin-right: 6px; transition: all .2s;
}
.upload-item input[type="file"]::file-selector-button:hover {
    background: var(--red); border-color: var(--red); color: white;
}

/* Download */
.download-section {
    background: #ECFDF5;
    border: 1px solid #A7F3D0;
    border-radius: var(--r);
    padding: 14px 18px;
    margin-top: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.download-section::before { display: none; }

.download-icon {
    width: 40px; height: 40px;
    background: var(--green);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: white; flex-shrink: 0;
}
.download-icon svg { width: 20px; height: 20px; }
.download-content { flex: 1; min-width: 140px; }
.download-title { font-size: 13px; font-weight: 700; color: #065F46; margin: 0 0 2px; }
.download-subtitle { font-size: 11px; color: #047857; margin: 0; }

.btn-primary {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: var(--red); color: white;
    font-size: 12px; font-weight: 600; border: none; border-radius: 8px;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.btn-primary:hover { background: var(--red-d); color: white; }
.btn-primary svg { width: 14px; height: 14px; }

.btn-success {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; background: var(--green); color: white;
    font-size: 12px; font-weight: 600; border: none; border-radius: 8px;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.btn-success:hover { opacity: .9; color: white; }
.btn-success svg { width: 14px; height: 14px; }

.text-end { text-align: right; }
.mt-4 { margin-top: 16px; }

/* ==========================================
   RESPONSIVE
   ========================================== */
@media (max-width: 768px) {
    .sp {
        margin: -1.5rem;
        margin-bottom: 0;
        padding: 1.5rem;
        padding-bottom: 0;
    }
}
@media (max-width: 640px) {
    .sp {
        margin: -1rem;
        margin-bottom: 0;
        padding: 1rem;
        padding-bottom: 0;
    }
    .sp-hero { padding: 20px; }
    .sp-hero-name { font-size: 17px; }
    .sp-hero-avatar { width: 44px; height: 44px; border-radius: 12px; }
    .sp-prog-dot { width: 24px; height: 24px; font-size: 10px; }
    .sp-prog-label { font-size: 9px; }
    .sp-placement { grid-template-columns: 1fr; }
    .download-section { flex-direction: column; text-align: center; }
}
</style>
