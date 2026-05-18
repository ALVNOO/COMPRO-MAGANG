# Telkom Magang Design System

A working design system distilled from the **PT Telkom Indonesia internship management system** ("Sistem Penerimaan Magang") — a Laravel 12 application that manages the full internship lifecycle for participants ("peserta"), mentors ("pembimbing"), and admins.

This is an **internal HR / operations product**, not a marketing site. Tone is professional, Indonesian, and trust-driven. Visuals are anchored by Telkom's iconic red `#EE2E24` against neutral grays and white surfaces, with restrained glassmorphism, soft floating orb backgrounds, and Inter typography.

## Sources

- **Codebase**: [`ALVNOO/COMPRO-MAGANG`](https://github.com/ALVNOO/COMPRO-MAGANG) — Laravel 12 + TailwindCSS 4 + Bootstrap 5 + Alpine.js + Chart.js
- **Token source**: `resources/css/design-system.css` (single source of truth, 28 KB), `resources/css/public-app.css` (marketing pages), per-role CSS files (`admin-dashboard.css`, `mentor-dashboard.css`, `peserta-dashboard.css`)
- **Component source**: `resources/views/components/{ui,dashboard}/*.blade.php` — Blade components
- **Brand**: PT Telkom Indonesia, Witel Sulbagsel (Sulawesi Bagian Selatan)
- **Heritage note**: this codebase was originally developed for PT Pos Indonesia before being rebranded for Telkom. A few Pos-era image files (`PosInd_Logo.png`, Pos HQ photos) remain in the repo but are vestigial — they're **not** part of this design system.

## Products & Surfaces

The codebase delivers **one product, three role-scoped dashboards** behind a shared public marketing site:

1. **Public site** — `welcome.blade.php`, `about.blade.php`, `program.blade.php` — hero with red gradient, badges, big stats, witel info
2. **Auth flow** — login + register + mandatory Google 2FA setup/verify (split-panel: red illustration left, form right)
3. **Peserta (Participant) dashboard** — apply, upload docs, daily attendance check-in/out, logbook entries, view assignments, download certificate
4. **Mentor (Pembimbing) dashboard** — supervise interns, create assignments, grade submissions, issue certificates
5. **Admin dashboard** — applications queue, participants directory, divisions/mentors CRUD, reports + Excel/PDF export, system rules

All three dashboards share `layouts/dashboard-unified.blade.php` — same sidebar/header chrome, role-conditional CSS bundle.

---

## CONTENT FUNDAMENTALS

**Language**: Indonesian (Bahasa Indonesia). Always. English is reserved for technical labels only (e.g. `2FA`, `Dashboard`, `Logout`).

**Pronouns & formality**: Formal `Anda` (capitalized) — never `kamu`. The product talks to working professionals and university students applying to a BUMN (state-owned enterprise), so the register is polite, slightly corporate, never chummy.

> "Masukkan kredensial Anda untuk mengakses akun"
> ("Enter your credentials to access your account")

**Voice characteristics**:

- **Direct + reassuring.** Imperative verbs for actions ("Masuk", "Daftar", "Unggah Dokumen") paired with descriptive subtitles that explain what the screen does.
- **Lists feature-benefits, not features.** Login splash bullets: "Tracking Pengajuan Real-time", "Komunikasi dengan Mentor", "Kelola Dokumen & Tugas" — every item is a thing the user can do, prefixed with a noun.
- **Status labels are short Indonesian verbs**: `Menunggu`, `Diterima`, `Ditolak`, `Aktif`, `Selesai`, `Hadir`, `Terlambat`, `Izin`.
- **Numbers earn their place.** Stats are sparse and meaningful — "50+ Tahun Berdiri", "34 Provinsi Terjangkau", "150M+ Pelanggan" — never decorative.

**Casing**: Sentence case for body and subtitles. Title Case for page titles, section headings, button labels. UPPERCASE only for the `.eyebrow` (small red prefix label above section titles, tracked +0.08em).

**Punctuation**: Em-dashes uncommon; prefer commas or new sentences. No exclamation points outside of toast success messages. Question marks used in form labels asking for input ("Belum punya akun?").

**Emoji**: **None.** Anywhere. Icons come from Font Awesome 6.

**Length budgets**:

- Page subtitle: ≤ 14 words, one line
- Button label: 1–3 words
- Toast message: ≤ 12 words
- Empty-state description: ≤ 25 words

**Examples of copy in the wild**:

| Surface | Copy |
|---|---|
| Login title | "Masuk" + "Masukkan kredensial Anda untuk mengakses akun" |
| Hero (about) | "Menghubungkan Indonesia **Melalui Teknologi**" (last 2 words gradient-red) |
| Section badge | "Profil Perusahaan" / "Unit Regional" / "Program Magang" |
| Status badge | "Diterima" + green check icon |
| Empty state | "Belum ada pengajuan magang. Mulai dengan mengisi formulir." |
| Footer CTA | "Belum punya akun? Daftar sekarang" |

---

## VISUAL FOUNDATIONS

### Color philosophy

A **single hero color**: Telkom Red `#EE2E24`. Everything else is neutral gray or semantic (green / amber / red / cyan for state). Primary red is used for: primary buttons, key stats, active sidebar item, accent borders on cards, the "TELKOM" word in lockup, the eyebrow label above section titles, the gradient text-highlight in hero h1.

Red is **never** used as a background fill except for buttons and the dark sidebar's active state — and even there it's a 135° gradient `#EE2E24 → #C41E1A` paired with a red drop-shadow `0 4px 14px rgba(238,46,36,0.25)`. Solid flat red is rare.

Neutrals do all the structural work: page bg `#F9FAFB`, surface `#FFFFFF`, body text `#231F20`, muted `#9CA3AF`, borders `#E5E7EB`/`#D1D5DB`. Dark surfaces (the sidebar) use the `--gradient-dark` (`#1A1A1A → #2D2D2D`).

### Type

**Inter only.** Weights 300/400/500/600/700/800 loaded from Google Fonts. No serif, no display fallback. Headings use `letter-spacing: -0.02em` on h1, `-0.015em` on h2 — a touch of optical tightening at large sizes. Body line-height `1.5`, paragraphs `1.625`. The eyebrow label gets `letter-spacing: 0.08em` + UPPERCASE.

Font sizes follow a clean rem scale: 12, 14, 16, 18, 20, 24, 30, 36, 48 px. Never use sizes outside this scale.

### Spacing & radii

4-px-based scale: 4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96.

Radii are deliberately varied — small radii on inputs/badges, larger on cards, very large on glass cards and hero surfaces. Map:

| Element | Radius |
|---|---|
| Tag pill, inline status | `--radius-full` (9999px) — fully rounded |
| Badge, small input | `--radius-md` (8px) |
| Button, dropdown menu, alert | `--radius-lg` (12px) |
| Card, stat card, form input | `--radius-xl` (16px) |
| Hero card, glass card, modal | `--radius-2xl` (24px) — sometimes 20px in practice |

Borders are mostly invisible. Cards have a `1px solid #E5E7EB` hairline; on hover the border disappears under a stronger shadow.

### Shadow & elevation

5-rung elevation:

1. **Resting card** — `0 1px 3px rgba(0,0,0,.1), 0 1px 2px rgba(0,0,0,.06)`
2. **Card hover / dropdown** — `0 4px 6px rgba(0,0,0,.1), 0 2px 4px rgba(0,0,0,.06)`
3. **Lifted card / modal** — `0 10px 15px rgba(0,0,0,.1), 0 4px 6px rgba(0,0,0,.05)`
4. **Floating panel** — `0 20px 25px rgba(0,0,0,.1), 0 10px 10px rgba(0,0,0,.04)`
5. **Toast / alert popup** — `0 10px 40px rgba(0,0,0,.15)`

Primary buttons get a **colored shadow** — `0 4px 14px rgba(238,46,36,.25)` resting, `0 10px 25px rgba(238,46,36,.3)` on hover. This is the system's signature elevation move and the only place colored shadows appear.

### Backgrounds

The authenticated dashboard sits on a layered background you should preserve when recreating screens:

1. **Page tint**: `#F9FAFB`
2. **Floating blurred orbs** — 4 large radial-gradient circles (red, blue, green, purple) with `filter: blur(80px)`, 0.5 opacity, `floatOrb` keyframe animation (20s ease-in-out). They drift between 30px/-30px offsets and 0.95–1.05 scale.

> The animated grid (40×40px moving lines) was removed from authenticated pages — it clashed with content-heavy dashboard views. The grid remains only on the public marketing hero (`home.blade.php`).

Marketing pages (`about`, `welcome`) use bigger hero gradients and the same glassmorphism cards but without the floating orbs.

Imagery: the codebase doesn't ship Telkom-specific photography of its own (the few photo files present in `public/image/` are leftover Pos-era files and aren't used by the system). When real photography isn't available the codebase falls back to **brand-mark fallbacks**: a colored SVG icon in a 64×64 circle with the brand abbreviation underneath, gated by `onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"`. When you need imagery, source new Telkom-appropriate photography rather than reusing Pos-era files.

### Glassmorphism

The dashboard uses a measured glass effect on hero/stat/chart cards:

```
background: rgba(255, 255, 255, 0.85);
backdrop-filter: blur(20px);
border: 1px solid rgba(255, 255, 255, 0.5);
box-shadow: 0 4px 24px rgba(0,0,0,.06), inset 0 1px 0 rgba(255,255,255,.8);
border-radius: 20px;
```

Used only over the orb background. Don't stack glass on glass. The inset-top white highlight is what sells it as "glass" rather than a flat translucent card.

### Animation & motion

- **Easing**: `cubic-bezier(0.4, 0, 0.2, 1)` (the "spring" curve) for transforms, `ease` for color/opacity. Standard durations: 150ms (micro), 200ms (default), 300ms (lifts, sidebar collapse).
- **Hover lifts**: Primary buttons, cards, and stat cards translate `Y -2px` to `-4px` on hover with a shadow bump. The same lift is on every interactive surface — it's the system's tactile signature.
- **No bounce.** Spring curve only, no `cubic-bezier` overshoots, no rotations, no flips. Motion is functional.
- **Counter animation**: Stats animate from 0 to target on scroll-into-view over 1500ms with `easeOutQuart` (`1 - (1-t)^4`).
- **Toast entry**: `slideIn` keyframe — translate from `+20px` x, fade in, 300ms ease-out.
- **Auto-hide alerts**: Flash messages fade and slide out after 5s.

### Hover & press states

- **Primary button**: hover lifts -2px + brightens via `--gradient-primary-hover` + larger shadow. Disabled: 0.5 opacity, no pointer.
- **Secondary button**: hover swaps `bg-gray-50` and bumps border one step (`gray-300 → gray-400`). No lift.
- **Outline button**: hover **inverts** — transparent fill becomes solid `--color-primary`, text flips to white.
- **Ghost button**: hover gets `bg-gray-100`, text darkens to `gray-900`.
- **Card**: hover bumps shadow one rung (`sm → md`). Elevated cards translate -4px Y.
- **Sidebar nav item**: hover/active gets the full `--gradient-primary` background, white text, +4px X translate. Very tactile.
- **Dropdown item**: hover gets `bg-gray-50` and primary-red text.
- **Form input focus**: border becomes primary red + 3px rgba(238,46,36,.1) focus ring (no outline).
- **Input invalid**: red border + red focus ring.

There are **no explicit "pressed" states** — the codebase relies on the OS focus ring and the hover lift reversing on click.

### Borders & dividers

Hairline `1px solid #E5E7EB` on cards, dividers, and dropdowns. Form inputs use the next step up (`#D1D5DB`). **Accent borders** — a 4px top border in primary/success/warning/danger/info — are the system's way of categorizing cards (`.card-accent`, `.card-accent-success`, etc.). The stat-card uses a `::before` pseudo to do the same thing with `--gradient-primary`.

### Layout

- Fixed sidebar 280px wide (collapsible to 80px), dark gradient background
- Sticky top navbar 64px, `rgba(255,255,255,0.95)` + `backdrop-filter: blur(10px)`, hairline bottom border
- Content area: 32px (2rem) outer padding on desktop, 24px on tablet, 16px + 80px top on mobile
- Max content width: 1280px

### Use of transparency / blur

- **Glassmorphism cards**: `rgba(255,255,255,0.85)` + `blur(20px)`
- **Sticky navbar**: `rgba(255,255,255,0.95)` + `blur(10px)`
- **Floating orbs**: `blur(80px)`, 0.5 opacity
- **Dropdown shadow**: deep but never inside a blurred container
- **Modal backdrops**: solid `rgba(0,0,0,0.4)`, no blur

Blur is a "soften background" tool, not a decoration. Don't apply it to imagery or to any element that holds text.

---

## ICONOGRAPHY

**Font Awesome 6 (free, solid style)** is the icon system. Loaded everywhere from CDN:

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
```

Usage: `<i class="fas fa-check-circle"></i>`. Always inside a flex container with `gap-2` or `gap-3`. Icons are rendered at the surrounding font-size and inherit `currentColor`. Standard pairings:

| Concept | Icon |
|---|---|
| Pending / waiting | `fa-clock` |
| Accepted / success | `fa-check`, `fa-check-circle` |
| Rejected / error | `fa-times`, `fa-times-circle` |
| Active / running | `fa-play` |
| Finished | `fa-flag-checkered` |
| Attendance present | `fa-check-circle` |
| Attendance late | `fa-clock` |
| Attendance leave | `fa-file-alt` |
| Warning | `fa-exclamation-triangle` |
| Info | `fa-info-circle` |
| Loading | `fa-spinner` + `.animate-spin` |
| Building / company | `fa-building` |
| Division / org | `fa-sitemap` |
| Notification | `fa-bell` |

In a few hero/illustration contexts (login splash, "back to home" link, page-hero badge) the codebase hand-writes **stroke-style SVGs** with `stroke-width="2"` and `stroke="currentColor"` — these are Feather-icon-style line icons. They're decorative, not from a system. Recreate them inline when you need a large illustrative icon, but for UI controls always reach for Font Awesome.

**Emoji**: never used. Don't introduce them.

**Unicode chars as icons**: only `&times;` (`×`) on the alert close button. Everything else is Font Awesome.

**Logos** (see `assets/logos/`):

- `telkom-indonesia-logo.png` — full horizontal lockup with the red asterisk/hand mark + "Telkom Indonesia" wordmark + "the world in your hand" italic tagline. Use this on marketing pages and document headers.
- `telkom-mark.png` — just the iconic red/gray asterisk-hand mark. Use as a favicon, avatar, or in tight spaces.

---

## File index

| Path | What it is |
|---|---|
| `README.md` | This file |
| `SKILL.md` | Agent skill entry point — read this first if you're an LLM picking this up as a Claude Code skill |
| `colors_and_type.css` | Drop-in stylesheet: CSS custom properties + element styles (`h1`–`h6`, `body`, `p`, `.eyebrow`, etc.) |
| `assets/logos/` | Telkom Indonesia logos (full lockup + standalone mark) |
| `preview/*.html` | Design-system tab preview cards (type, color, spacing, components) |
| `ui_kits/web-app/` | Pixel-faithful recreation of the dashboard UI as React/JSX components, with an `index.html` clickable demo |
| `reference/css/` | Original CSS source from the Laravel app — read for the full token table and per-role styles |
| `reference/views/` | Original Blade components (`ui/*.blade.php`) and pages (`auth/login`, `admin/dashboard`, etc.) — read to copy exact markup patterns |

### UI Kits

- `ui_kits/web-app/` — the unified dashboard (sidebar + content) plus auth split-panel. Demonstrates buttons, cards, stat cards, status badges, sidebar navigation, top navbar, glass cards, and a sample applications table.

---

## Notes & caveats

- The codebase ships **two slightly diverging design-token sets**: `design-system.css` (the "source of truth", semantic colors `#059669` `#D97706` `#DC2626`) and an inline block inside `layouts/dashboard-unified.blade.php` (subtly different: `#10B981` `#F59E0B` `#EF4444`). This system uses the design-system.css values — they're the documented canon. If you spot drift in screenshots, that's why.
- **Pos Indonesia leftovers** in the source repo (`PosInd_Logo.png`, `kantor-pusat-pt-pos-indonesia.jpg`, etc.) are vestigial — the project was originally developed for PT Pos Indonesia before being rebranded for Telkom. Ignore those files; this design system is Telkom-only.
- The `welcome.blade.php` is still a barely-modified Laravel 12 starter (Instrument Sans, Tailwind 4 inline). Treat it as **not part of the system** — the canonical marketing surface is `about.blade.php`.
- Tailwind 4 + Bootstrap 5 both loaded means class names occasionally collide. The design system as documented uses **only** the bespoke classes from `design-system.css` (`.btn-primary`, `.card`, `.form-input`, etc.) — don't mix in Tailwind utility classes.
