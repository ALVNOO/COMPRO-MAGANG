# Feature: Contact Widget di Top Navbar

> Status: **Belum diimplementasi** — desain sudah ada di showcase (`#topnav`)
> Preview: `Telkom Magang Design System/showcase.html` → section "Top Navbar"

---

## Deskripsi Fitur

Widget kecil di sisi kanan top navbar yang memungkinkan pengguna langsung menghubungi kontak relevan mereka via WhatsApp atau email — tanpa perlu membuka halaman profil terlebih dahulu.

| Role | Widget yang tampil | Data dari |
|------|-------------------|-----------|
| **Peserta** | Kontak Mentor | `activeApplication->mentor` |
| **Mentor** | Kontak Admin | profil admin (yang ditunjuk / utama) |
| **Admin** | Tidak ada widget | — |

---

## Tampilan Widget

```
┌────────────────────────────────────┐
│ [foto]  KONTAK MENTOR   [WA] [✉️] │
│         Budi Santoso               │
└────────────────────────────────────┘
```

- Foto: profile picture mentor/admin (fallback ke inisial dengan gradient)
- Tombol WA: membuka `https://wa.me/{nomor}?text=...` di tab baru
- Tombol Email: membuka `mailto:{email}`
- Widget hanya muncul jika nomor WA atau email tersedia (tidak null)
- Jika keduanya tidak ada → widget disembunyikan sepenuhnya

---

## Perubahan Database yang Diperlukan

### 1. Tambah kolom `phone` ke tabel `users`

```php
// Migration baru:
Schema::table('users', function (Blueprint $table) {
    $table->string('phone', 20)->nullable()->after('email');
});
```

Kolom `phone` digunakan sebagai nomor WhatsApp (format: `08XXXXXXXXXX` atau `628XXXXXXXXXX`).

> Cek dulu: mungkin sudah ada kolom telepon di tabel lain (profile, dll).

---

## Perubahan di Profil Admin

Admin perlu bisa mengisi nomor WhatsApp dan email kontak di halaman profilnya.

**View:** `resources/views/admin/profile.blade.php` *(buat jika belum ada)*

**Field yang perlu ditambahkan di form profil admin:**
- Nomor WhatsApp (`phone`)
- Email (sudah ada di `users.email`)
- Foto profil (`profile_picture`) — sudah ada?

---

## Perubahan di Profil Mentor

Mentor sudah memiliki halaman profil (`mentor/profil.blade.php`). Tambahkan field:
- Nomor WhatsApp (`users.phone`)
- Email sudah ada (`users.email`)
- Foto profil sudah ada (`users.profile_picture`)

---

## Implementasi di Header Component

File: `resources/views/components/dashboard/header.blade.php`

### Logika kondisional:

```php
@php
    $contactWidget = null;

    if (Auth::user()->role === 'peserta') {
        $activeApp = Auth::user()->activeApplication;
        if ($activeApp && $activeApp->mentor) {
            $mentor = $activeApp->mentor;
            $contactWidget = [
                'label'   => 'Kontak Mentor',
                'name'    => $mentor->name,
                'photo'   => $mentor->profile_picture,
                'phone'   => $mentor->phone,
                'email'   => $mentor->email,
            ];
        }
    } elseif (Auth::user()->role === 'pembimbing') {
        // Ambil admin utama — bisa dari tabel users role=admin pertama,
        // atau dari setting/config yang menyimpan "admin kontak utama"
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            $contactWidget = [
                'label'   => 'Kontak Admin',
                'name'    => $admin->name,
                'photo'   => $admin->profile_picture,
                'phone'   => $admin->phone,
                'email'   => $admin->email,
            ];
        }
    }
@endphp
```

### HTML widget (tambahkan di `.header-right` sebelum notification bell):

```blade
@if($contactWidget && ($contactWidget['phone'] || $contactWidget['email']))
<div class="contact-widget">
    <div class="contact-photo">
        @if($contactWidget['photo'])
            <img src="{{ asset('storage/' . $contactWidget['photo']) }}"
                 alt="{{ $contactWidget['name'] }}">
        @else
            @php
                $initials = collect(explode(' ', $contactWidget['name']))
                    ->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
            @endphp
            <div class="contact-initials">{{ $initials }}</div>
        @endif
    </div>
    <div class="contact-meta">
        <div class="contact-tag">{{ $contactWidget['label'] }}</div>
        <div class="contact-name">{{ Str::limit($contactWidget['name'], 18) }}</div>
    </div>
    <div class="contact-actions">
        @if($contactWidget['phone'])
            @php
                $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $contactWidget['phone']));
                $waText   = urlencode('Halo, saya ' . Auth::user()->name . ' ingin bertanya mengenai magang.');
            @endphp
            <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}"
               target="_blank" rel="noopener"
               class="contact-btn contact-wa" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
        @endif
        @if($contactWidget['email'])
            <a href="mailto:{{ $contactWidget['email'] }}"
               class="contact-btn contact-mail" title="Email">
                <i class="fas fa-envelope"></i>
            </a>
        @endif
    </div>
</div>
@endif
```

---

## CSS yang Perlu Ditambahkan

Tambahkan ke `resources/css/design-system.css` (atau ke inline style di header component):

```css
.contact-widget { display:flex; align-items:center; gap:10px; padding:5px 12px 5px 6px; background:var(--color-gray-50); border:1px solid var(--color-gray-200); border-radius:12px; }
.contact-photo  { width:34px; height:34px; border-radius:8px; overflow:hidden; flex-shrink:0; }
.contact-photo img { width:100%; height:100%; object-fit:cover; display:block; }
.contact-initials { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; color:#fff; background: var(--gradient-primary); }
.contact-meta   { min-width:0; }
.contact-tag    { font-size:10px; color:var(--color-gray-500); font-weight:600; letter-spacing:.05em; text-transform:uppercase; line-height:1; margin-bottom:3px; }
.contact-name   { font-size:13px; font-weight:600; color:var(--color-gray-900); white-space:nowrap; line-height:1; }
.contact-actions { display:flex; gap:4px; margin-left:4px; }
.contact-btn    { width:30px; height:30px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:15px; text-decoration:none; transition:background .15s; flex-shrink:0; }
.contact-wa     { background:#DCFCE7; color:#16A34A; }
.contact-wa:hover { background:#BBF7D0; }
.contact-mail   { background:#DBEAFE; color:#2563EB; }
.contact-mail:hover { background:#BFDBFE; }

@media (max-width: 768px) {
    .contact-widget { display: none; } /* sembunyikan di mobile, atau pindahkan ke drawer */
}
```

---

## Urutan Implementasi

1. **Migration** — tambah kolom `phone` ke tabel `users`
2. **Form profil mentor** — tambah field WhatsApp di `mentor/profil.blade.php`
3. **Form profil admin** — buat/update halaman profil admin dengan field WA + email
4. **CSS** — tambahkan contact widget styles ke `design-system.css`
5. **Header component** — tambahkan logika + HTML widget di `header.blade.php`
6. **Test** — pastikan link WA terbuka dengan format nomor benar, widget tersembunyi jika data kosong

---

## Catatan Tambahan

- Format nomor WA: strip karakter non-digit, ganti awalan `0` dengan `62`
- Jika ada beberapa admin, pertimbangkan kolom `is_main_contact` di tabel users, atau simpan ID admin kontak utama di `app/config` / settings table
- Pre-fill pesan WA agar lebih kontekstual (misal: "Halo Pak Budi, saya Ahmad peserta magang divisi X ingin bertanya tentang...")
- Widget disembunyikan di layar mobile (`max-width: 768px`) — pertimbangkan versi mobile: tombol WA/email di footer atau di halaman profil mentor
