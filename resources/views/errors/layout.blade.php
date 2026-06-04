<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('code') — @yield('title') | Telkom Internship</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --red:   #EE2E24;
    --red-d: #C41E1A;
    --red-l: rgba(238,46,36,.08);
    --ink:   #1A1A1A;
    --mute:  #6B7280;
    --border:#E5E7EB;
    --bg:    #F9FAFB;
}

body {
    font-family: 'Inter', system-ui, sans-serif;
    background: var(--bg);
    color: var(--ink);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    overflow: hidden;
}

/* subtle dot-grid background */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px);
    background-size: 28px 28px;
    opacity: .45;
    pointer-events: none;
}

/* top brand stripe */
.stripe {
    position: fixed;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--red) 0%, #FF6B35 50%, var(--red) 100%);
    background-size: 200% 100%;
    animation: shimmer 3s linear infinite;
}
@keyframes shimmer { 0%{background-position:0 0} 100%{background-position:200% 0} }

.card {
    position: relative;
    background: #fff;
    border-radius: 24px;
    border: 1px solid var(--border);
    box-shadow: 0 4px 6px rgba(0,0,0,.04), 0 20px 60px rgba(0,0,0,.07);
    padding: 3.5rem 3rem;
    max-width: 520px;
    width: 100%;
    text-align: center;
    animation: rise .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes rise { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }

.logo {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    margin-bottom: 2.5rem;
    text-decoration: none;
}
.logo-mark {
    width: 36px; height: 36px;
    background: var(--red);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
}
.logo-mark svg { width: 20px; height: 20px; fill: #fff; }
.logo-text {
    font-size: .95rem;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -.01em;
}

.error-code {
    font-size: 7rem;
    font-weight: 900;
    letter-spacing: -.05em;
    line-height: 1;
    background: linear-gradient(135deg, var(--red) 0%, #FF6B35 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: .5rem;
}

.error-icon {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: var(--red-l);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 1.75rem;
}

.error-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--ink);
    margin-bottom: .625rem;
}

.error-desc {
    font-size: .95rem;
    color: var(--mute);
    line-height: 1.65;
    margin-bottom: 2rem;
}

.actions {
    display: flex;
    gap: .75rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.5rem;
    background: var(--red);
    color: #fff;
    border-radius: 10px;
    font-size: .9rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .15s, transform .15s;
    border: none;
    cursor: pointer;
}
.btn-primary:hover { background: var(--red-d); transform: translateY(-1px); }

.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 1.5rem;
    background: transparent;
    color: var(--mute);
    border-radius: 10px;
    font-size: .9rem;
    font-weight: 500;
    text-decoration: none;
    border: 1.5px solid var(--border);
    transition: all .15s;
    cursor: pointer;
}
.btn-ghost:hover { border-color: var(--red); color: var(--red); background: var(--red-l); }

.divider {
    height: 1px;
    background: var(--border);
    margin: 2rem 0;
}

.footer-note {
    font-size: .78rem;
    color: var(--mute);
}

@media (max-width: 480px) {
    .card { padding: 2.5rem 1.5rem; }
    .error-code { font-size: 5rem; }
}
</style>
</head>
<body>
<div class="stripe"></div>
<div class="card">
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-mark">
            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <span class="logo-text">Telkom Internship</span>
    </a>

    @yield('body')

    <div class="divider"></div>
    <p class="footer-note">Butuh bantuan? Hubungi admin sistem.</p>
</div>
</body>
</html>
