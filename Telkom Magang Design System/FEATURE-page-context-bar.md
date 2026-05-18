# Feature: Page Context Bar — Pengganti Hero Sections

> Status: **Desain selesai di showcase** (`#page-ctx`) — belum diimplementasi ke aplikasi
> Preview: `Telkom Magang Design System/showcase.html` → section "Page Context Bar"

---

## Latar Belakang

Setiap halaman dashboard sebelumnya memiliki **hero section besar** (~160–200px) yang menampilkan ulang judul halaman yang sudah tertera di sticky header. Ini redundan dan memakan ruang layar yang bisa dipakai konten.

**Solusi:** Ganti hero section dengan **Page Context Bar** — komponen slim ~80px yang memuat:
- Judul + deskripsi singkat halaman
- Quick stats relevan (opsional)
- CTA button (opsional)
- Role color accent (merah untuk admin, biru untuk mentor, hijau untuk peserta)

---

## Komponen yang Perlu Dibuat

### Blade Component Baru

**File:** `resources/views/components/dashboard/page-context-bar.blade.php`

```blade
@props([
    'title'       => '',
    'description' => null,
    'icon'        => null,
    'role'        => 'peserta',   {{-- 'admin' | 'pembimbing' | 'peserta' --}}
    'stats'       => [],          {{-- [['val'=>'12','label'=>'Peserta Aktif'], ...] --}}
    'cta'         => null,        {{-- ['label'=>'Tambah', 'href'=>'#', 'icon'=>'fas fa-plus'] --}}
])

@php
    $roleClass = match($role) {
        'admin'      => 'ctx-admin',
        'pembimbing' => 'ctx-mentor',
        default      => 'ctx-peserta',
    };
@endphp

<div class="page-ctx {{ $roleClass }}">
    <div class="ctx-body">
        @if($icon)
            <div class="ctx-icon">
                <i class="{{ $icon }}"></i>
            </div>
        @endif
        <div>
            <div class="ctx-title">{{ $title }}</div>
            @if($description)
                <div class="ctx-desc">{{ $description }}</div>
            @endif
        </div>
    </div>

    <div style="display:flex; align-items:center; gap:1.5rem;">
        @if(count($stats))
            <div class="ctx-stats">
                @foreach($stats as $stat)
                    <div class="ctx-stat">
                        <div class="ctx-stat-val">{{ $stat['val'] }}</div>
                        <div class="ctx-stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($cta)
            <a href="{{ $cta['href'] }}" class="ctx-cta">
                @if(isset($cta['icon']))<i class="{{ $cta['icon'] }}"></i>@endif
                {{ $cta['label'] }}
            </a>
        @endif
    </div>
</div>
```

---

## CSS yang Perlu Ditambahkan

Tambahkan ke `resources/css/design-system.css`:

```css
/* ── Page Context Bar ─────────────────────────────────────── */
.page-ctx {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-4);
    padding: var(--space-4) var(--space-6);
    background: var(--color-white);
    border-radius: var(--radius-xl);
    border: 1px solid var(--color-gray-200);
    border-left: 4px solid transparent;
    box-shadow: var(--shadow-sm);
    margin-bottom: var(--space-6);
    flex-wrap: wrap;
}
.ctx-admin   { border-left-color: var(--color-primary); }
.ctx-mentor  { border-left-color: #0891B2; }
.ctx-peserta { border-left-color: var(--color-success); }

.ctx-body  { display: flex; align-items: center; gap: var(--space-3); }
.ctx-icon  { width: 40px; height: 40px; border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; font-size: var(--text-lg); flex-shrink: 0; }
.ctx-admin   .ctx-icon { background: rgba(238,46,36,.1);  color: var(--color-primary); }
.ctx-mentor  .ctx-icon { background: rgba(8,145,178,.1);  color: #0891B2; }
.ctx-peserta .ctx-icon { background: var(--color-success-light); color: var(--color-success); }

.ctx-title  { font-size: var(--text-lg); font-weight: var(--font-semibold); color: var(--color-gray-900); line-height: 1.3; }
.ctx-desc   { font-size: var(--text-sm); color: var(--color-gray-500); margin-top: 2px; }

.ctx-stats     { display: flex; gap: var(--space-4); }
.ctx-stat      { text-align: center; }
.ctx-stat-val  { font-size: var(--text-lg); font-weight: var(--font-bold); color: var(--color-gray-900); line-height: 1.2; }
.ctx-stat-label { font-size: var(--text-xs); color: var(--color-gray-500); font-weight: var(--font-medium); }

.ctx-cta { display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-4); border-radius: var(--radius-lg); font-size: var(--text-sm); font-weight: var(--font-semibold); text-decoration: none; transition: all .15s; background: var(--gradient-primary); color: var(--color-white); }
.ctx-cta:hover { filter: brightness(1.08); transform: translateY(-1px); }
.ctx-mentor  .ctx-cta { background: linear-gradient(135deg, #0891B2, #0E7490); }
.ctx-peserta .ctx-cta { background: var(--gradient-success); }

@media (max-width: 768px) {
    .page-ctx { flex-direction: column; align-items: flex-start; }
    .ctx-stats { display: none; }
}
```

---

## Perubahan per Halaman

### Admin (7 halaman)

| Halaman | View | Hapus | Tambah Context Bar |
|---------|------|-------|-------------------|
| Dashboard | `admin/dashboard.blade.php` | `admin-hero` section | `title="Dashboard Admin"` + 4 stat |
| Peserta | `admin/participants/index.blade.php` | hero jika ada | `title="Daftar Peserta"` + stat total |
| Pengajuan | `admin/applications/index.blade.php` | hero jika ada | `title="Pengajuan Masuk"` + stat pending |
| Divisi | `admin/divisions/index.blade.php` | hero jika ada | `title="Manajemen Divisi"` |
| Mentor | `admin/mentors/index.blade.php` | hero jika ada | `title="Daftar Mentor"` |
| Laporan | `admin/reports/index.blade.php` | hero jika ada | `title="Laporan & Ekspor"` + CTA ekspor |
| Pengaturan | `admin/rules/index.blade.php` | hero jika ada | `title="Aturan Sistem"` |

### Mentor/Pembimbing (7 halaman)

| Halaman | View | Hapus | Tambah Context Bar |
|---------|------|-------|-------------------|
| Dashboard | `mentor/dashboard.blade.php` | `mentor-hero` / `dashboard-hero.blade.php` | `role="pembimbing"` + stat peserta aktif |
| Peserta Saya | `mentor/peserta.blade.php` | hero jika ada | `title="Peserta Saya"` |
| Absensi | `mentor/absensi.blade.php` | hero jika ada | `title="Rekap Absensi"` |
| Logbook | `mentor/logbook.blade.php` | hero jika ada | `title="Logbook Peserta"` |
| Tugas | `mentor/tugas.blade.php` | hero jika ada | `title="Tugas & Penilaian"` |
| Sertifikat | `mentor/sertifikat.blade.php` | hero jika ada | `title="Sertifikat"` |
| Profil | `mentor/profil.blade.php` | hero jika ada | `title="Profil Saya"` |

### Peserta (7 halaman)

| Halaman | View | Hapus | Tambah Context Bar |
|---------|------|-------|-------------------|
| Dashboard | `dashboard/*.blade.php` | `status-hero` section | `role="peserta"` + status badge |
| Absensi | `attendance/*.blade.php` | hero jika ada | `title="Absensi Harian"` + stat hadir |
| Logbook | `logbook/*.blade.php` | hero jika ada | `title="Logbook Harian"` |
| Tugas | `dashboard/tugas.blade.php` | hero jika ada | `title="Tugas Saya"` |
| Dokumen | `dashboard/dokumen.blade.php` | hero jika ada | `title="Dokumen Saya"` |
| Profil | `dashboard/profil.blade.php` | hero jika ada | `title="Profil Saya"` |
| Sertifikat | `dashboard/sertifikat.blade.php` | hero jika ada | `title="Sertifikat"` |

---

## Contoh Penggunaan di View

```blade
{{-- Di admin/dashboard.blade.php --}}
<x-dashboard.page-context-bar
    title="Dashboard Admin"
    description="Ringkasan sistem magang PT Telkom Indonesia"
    icon="fas fa-gauge-high"
    role="admin"
    :stats="[
        ['val' => $totalPeserta,  'label' => 'Total Peserta'],
        ['val' => $totalPending,  'label' => 'Menunggu Review'],
        ['val' => $totalMentor,   'label' => 'Mentor Aktif'],
    ]"
    :cta="['label' => 'Tambah Peserta', 'href' => route('admin.participants.create'), 'icon' => 'fas fa-plus']"
/>
```

```blade
{{-- Di mentor/dashboard.blade.php, ganti dashboard-hero partial --}}
<x-dashboard.page-context-bar
    title="Dashboard Pembimbing"
    description="Pantau dan bimbing peserta magang di divisi Anda"
    icon="fas fa-chalkboard-teacher"
    role="pembimbing"
    :stats="[
        ['val' => $pesertaAktif, 'label' => 'Peserta Aktif'],
        ['val' => $tugasBelumDinilai, 'label' => 'Tugas Pending'],
    ]"
/>
```

```blade
{{-- Di dashboard peserta (status-hero replacement) --}}
<x-dashboard.page-context-bar
    title="Dashboard Peserta"
    description="Pantau status dan aktivitas magang Anda"
    icon="fas fa-gauge"
    role="peserta"
/>
```

---

## Urutan Implementasi

1. **Tambah CSS** ke `resources/css/design-system.css`
2. **Buat Blade component** `resources/views/components/dashboard/page-context-bar.blade.php`
3. **Admin dashboard** — hapus `admin-hero`, tambah context bar
4. **Mentor dashboard** — hapus `dashboard-hero.blade.php` include, tambah context bar
5. **Peserta dashboard** — hapus `status-hero.blade.php` include, tambah context bar
6. **Halaman lain** — cek satu per satu apakah ada hero section, ganti jika ada
7. **Hapus CSS hero** yang tidak terpakai dari `mentor/partials/dashboard-styles.blade.php` dan `admin/partials/dashboard-styles.blade.php`

---

## Catatan

- Header component (`header.blade.php`) masih menampilkan **page-title** — setelah context bar ditambah, pertimbangkan menghapus `page-title` dari header agar tidak duplikat. Atau biarkan header title sebagai breadcrumb-style nama singkat, dan context bar sebagai deskripsi lengkap.
- Jika halaman tidak punya data dinamis untuk stat, cukup hilangkan prop `:stats`.
- `dashboard-hero.blade.php` (mentor) dan `status-hero.blade.php` (peserta) bisa dihapus sepenuhnya setelah semua halaman sudah pakai context bar.
