# Admin Panel Redesign Progress

Dokumen ini mencatat semua halaman admin yang sudah di-redesign menggunakan Telkom Magang Design System.

---

## Status Overview

| Halaman | Route | Status | Catatan |
|---|---|---|---|
| Dashboard | `/admin/dashboard` | ✅ Selesai | Stats, recent activity |
| Profil Admin | `/admin/profile` | ✅ Selesai | Photo upload, info cards |
| Aplikasi | `/admin/applications` | ✅ Selesai | Table + filter + approve/reject |
| Peserta | `/admin/participants` | ✅ Selesai | Table + document upload |
| Divisi (Baru) | `/admin/divisions` | ✅ Selesai | Flat structure, mentor chips, Alpine modal |
| Divisi (Legacy) | `/admin/legacy-divisions` | ✅ Selesai | Tree 3-level, semua 7 modal |
| Pembimbing | `/admin/mentors` | ✅ Selesai | Table + detail modal |
| Detail Pembimbing | `/admin/mentor/{id}` | ✅ Selesai | Card layout |
| Bidang Minat | `/admin/fields` | ✅ Selesai | Table + inline form |
| Peraturan | `/admin/rules` | ✅ Selesai | Rich text |
| Evaluasi Akhir | `/admin/final-evaluation` | ✅ Selesai | Stats strip + upload per peserta |
| Absensi | `/admin/attendance` | ✅ Selesai | 7-day strip + bug fix hari sebelum magang |
| Logbook | `/admin/logbook` | ✅ Selesai | Master-detail layout |
| Laporan | `/admin/reports` | ✅ Selesai | Chart + export |

## Mentor Pages

| Halaman | Route | Status | Catatan |
|---|---|---|---|
| Laporan Penilaian | `/mentor/laporan-penilaian` | ✅ Selesai | Hero + stat pills + table + Alpine delete modal |

---

## Detail Perubahan Per Halaman

### 1. Header & Sidebar
- **File:** `resources/views/components/dashboard/header.blade.php`
- **File:** `resources/views/components/dashboard/sidebar.blade.php`
- User dropdown menu dengan CSS class `ud-*` dan `user-dropdown-*`
- Alpine.js `x-data` untuk toggle dropdown

### 2. Dashboard Admin (`/admin/dashboard`)
- **File:** `resources/views/admin/dashboard.blade.php`
- Stats cards: Total Peserta, Aktif, Menunggu, Selesai
- Recent activity feed

### 3. Profil Admin (`/admin/profile`)
- **File:** `resources/views/admin/profile.blade.php`
- **Controller:** `app/Http/Controllers/Admin/DashboardController.php`
- **Routes:** `admin.profile.picture` (POST), `admin.profile.picture.remove` (DELETE)
- Layout 2 kolom: foto card kiri + info cards kanan
- Upload/remove foto profil
- Password section dihapus (pindah ke `/dashboard/change-password`)

### 4. Ganti Password (`/dashboard/change-password`)
- **File:** `resources/views/auth/change-password.blade.php`
- Switched dari `layouts.dashboard` ke `layouts.dashboard-unified`
- Password strength bar (weak/medium/strong)
- Show/hide toggle per field
- Real-time konfirmasi validation

### 5. Aplikasi (`/admin/applications`)
- **File:** `resources/views/admin/applications.blade.php`
- Filter bar: status, tanggal, search
- Status badges dengan warna semantik

### 6. Peserta (`/admin/participants`)
- **File:** `resources/views/admin/participants.blade.php`
- Table dengan document upload inline
- Change mentor modal

### 7. Divisi — Struktur Baru (`/admin/divisions`)
- **File:** `resources/views/admin/divisions-admin.blade.php`
- **Controller:** `app/Http/Controllers/Admin/DivisionController.php`
- Stats: Total Divisi, Divisi Aktif, Total Pembimbing
- Mentor chips (nama + NIK badge monospace)
- Delete pakai Alpine modal (bukan `confirm()`)
- Create/Edit modal dengan dynamic mentor management
- CSS namespace: `da-*`

### 8. Divisi — Struktur Legacy (`/admin/legacy-divisions`)
- **File:** `resources/views/admin/divisions.blade.php`
- **Controller:** `app/Http/Controllers/Admin/LegacyDivisionController.php`
- Tree 3-level: Direktorat → SubDirektorat → Divisi
- 7 modal CRUD (create/edit/delete per level)
- Action icon buttons 30px dengan warna semantik
- `addslashes()` pada string PHP di Alpine onclick

### 9. Pembimbing (`/admin/mentors`)
- **File:** `resources/views/admin/mentors.blade.php`
- Avatar initials, divisi chip, status badge

### 10. Detail Pembimbing (`/admin/mentor/{id}`)
- **File:** `resources/views/admin/mentor-detail.blade.php`
- Card layout: profil + stats + peserta list

### 11. Bidang Minat (`/admin/fields`)
- **File:** `resources/views/admin/fields.blade.php`
- **File:** `resources/views/admin/field-form.blade.php`
- Toggle aktif/nonaktif inline

### 12. Peraturan (`/admin/rules`)
- **File:** `resources/views/admin/rules.blade.php`
- Rich text display

### 13. Evaluasi Akhir (`/admin/final-evaluation`)
- **File:** `resources/views/admin/final-evaluation.blade.php`
- Stats strip: Total / Sudah Ada / Menunggu
- Source badge: Oleh Peserta (green) / Oleh Admin (blue) / Belum Ada (gray)
- Upload locked jika peserta sudah unggah
- JS `updateFileName(id, input)` untuk live filename preview
- CSS namespace: `fe-*`

### 14. Absensi (`/admin/attendance`)
- **File:** `resources/views/attendance/admin.blade.php`
- **Bug fix:** Hari sebelum `start_date` atau setelah `end_date` tampilkan `pra` badge (abu-abu `—`) bukan ✗
- Legend strip 4 kondisi di atas tabel
- Stats: Hadir / Terlambat / Tidak Hadir / Belum Absen
- Filter redesign (flat white, `att-filter` class)

### 15. Logbook (`/admin/logbook`)
- **File:** `resources/views/logbook/admin.blade.php`
- Master-detail layout: left sidebar (300px) + right detail panel
- Left: participant list dengan search client-side, avatar, count badge
- Right: logbook entries dengan date column (day/number/month) + content
- Pure vanilla JS (bukan Alpine): `selectParticipant(idx, el)`
- First participant auto-selected on load

---

## Design System Classes yang Digunakan

```css
/* Table */
.admin-table, .table-card, .table-header, .table-title

/* Status */
.status-badge, .status-active, .status-pending, .status-finished, .status-rejected

/* Badges */
.badge, .badge-gray, .badge-green, .badge-red, .badge-blue

/* Buttons */
.ctx-btn, .ctx-btn-secondary, .ctx-cta

/* Context Bar */
x-dashboard.page-context-bar

/* Alerts */
.alert, .alert-compact, .alert-success, .alert-danger
```

---

## Bug Fixes

| Bug | File | Fix |
|---|---|---|
| Dropdown CSS hilang | `header.blade.php` | Tambah CSS `ud-*` dan `user-dropdown-*` |
| Kolom DB tidak ada (`final_evaluation_admin_path`) | Migration | Jalankan `php artisan migrate` |
| Hari sebelum magang tampil ✗ | `attendance/admin.blade.php` | Cek `start_date`/`end_date` vs hari di strip |
| Wrong file diedit untuk `/admin/divisions` | — | Route maps ke `divisions-admin.blade.php`, bukan `divisions.blade.php` |

---

## Catatan untuk Testing

- Semua halaman menggunakan `@extends('layouts.dashboard-unified')` dengan `$role = 'admin'`
- Alpine.js modal delete: pastikan `x-data` di elemen wrapper
- `addslashes()` wajib untuk string PHP di dalam Alpine `@click` attribute
- Jalankan `php artisan view:clear` setelah perubahan besar pada view
