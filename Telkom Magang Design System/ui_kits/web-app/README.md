# Web App UI Kit — Telkom Magang Dashboard

A pixel-faithful recreation of the **Telkom Indonesia internship management** dashboard. Built as a click-through React prototype using the design tokens in `../../colors_and_type.css`.

## What's here

```
ui_kits/web-app/
├── index.html               ← open this
├── styles.css               ← layout + chrome (sidebar, topbar, glass, stat, table)
├── Atoms.jsx                ← Btn, Badge, StatusBadge, Avatar, StatCard, Field
├── Chrome.jsx               ← Sidebar, Topbar
├── AuthScreen.jsx           ← split-panel login (red illustration left, form right)
├── DashboardScreen.jsx      ← greeting + stat grid + applications table + activity feed
├── ApplicationsScreen.jsx   ← full table with status filter chips, bulk-select, pagination
└── App.jsx                  ← screen switcher
```

## Try it

1. Open `index.html` → land on **login**.
2. Click **Masuk** (any credentials work — the form is decorative) → land on **Dashboard**.
3. Use the sidebar to navigate to **Pengajuan** for the full applications screen.
4. Click the hamburger to collapse the sidebar.
5. The other sidebar items show a placeholder page (Peserta, Divisi, Mentors, etc. aren't built — see the original Laravel views in `reference/views/`).

## What's faithful

- Telkom red `#EE2E24` primary, gradient `135° → #C41E1A`, with the signature colored shadow on primary buttons
- Inter font, 12 → 48 px scale, exact letter-spacing on headings
- Dark gradient sidebar (`180° #1A1A1A → #2D2D2D`) with active item that uses the full primary gradient + 4px X translate
- Floating-orb animated background (4 blurred orbs + 40px grid overlay)
- Glassmorphism cards (`rgba(255,255,255,.85)` + `blur(20px)` + inset white top highlight)
- Stat cards with 4px top-gradient accent
- Status badges with Indonesian labels (Menunggu, Diterima, Ditolak, Aktif, Selesai, Hadir, Terlambat, Izin, Tidak Hadir)
- Font Awesome 6 icon set (via the `_card.css` import chain)
- Indonesian copy throughout, formal `Anda`

## What's intentionally not built

- Real auth, real data — buttons no-op or change demo state only
- Mentor and participant dashboards (the admin one shown is the most layout-rich; the others reuse the same chrome with different sidebar + content)
- Charts (the real app uses Chart.js — placeholder areas only)
- Modals, dropdowns (open menus), date pickers, file uploads

If you need to copy the markup/styles for a specific page that's not in this kit, look in `reference/views/` for the original Blade template.
