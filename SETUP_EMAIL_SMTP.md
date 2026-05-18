# Setup Konfigurasi Email SMTP

Dokumen ini menjelaskan cara mengonfigurasi email SMTP agar fitur **reset 2FA via email** (dan fitur email lainnya) bisa berfungsi.

---

## Pilihan Layanan Email

| Layanan | Gratis | Batas | Cocok untuk |
|---|---|---|---|
| **Gmail SMTP** | Ya | 500 email/hari | Development & produksi skala kecil |
| **Mailtrap** | Ya | 1.000 email/bulan | Testing/development (email tidak benar-benar terkirim) |
| **Resend** | Ya | 3.000 email/bulan | Produksi skala kecil-menengah |
| Mailgun | Berbayar | — | Produksi skala besar |
| SendGrid | Berbayar | — | Produksi skala besar |

**Rekomendasi untuk project ini: Gmail SMTP** — gratis, mudah, tidak perlu daftar layanan baru.

---

## Cara Setup Gmail SMTP

### Langkah 1 — Siapkan akun Gmail pengirim

Gunakan akun Gmail yang akan menjadi pengirim semua email dari sistem. Disarankan membuat akun khusus, contoh:

```
noreply.magang.telkom@gmail.com
```

> Akun ini hanya sebagai **pengirim**. Pengguna tetap menerima email di inbox masing-masing.

### Langkah 2 — Aktifkan 2-Step Verification

1. Login ke akun Gmail pengirim
2. Buka [myaccount.google.com](https://myaccount.google.com)
3. Pilih **Security** di menu kiri
4. Cari **2-Step Verification** → klik dan aktifkan

> Langkah ini wajib dilakukan sebelum bisa membuat App Password.

### Langkah 3 — Buat App Password

1. Masih di halaman Security, cari **App passwords**
   - Jika tidak muncul, pastikan 2-Step Verification sudah aktif
2. Klik **App passwords**
3. Pada dropdown "Select app" pilih **Mail**
4. Pada dropdown "Select device" pilih **Other (Custom name)** → isi `Sistem Magang`
5. Klik **Generate**
6. Akan muncul kode 16 karakter seperti: `xxxx xxxx xxxx xxxx`
7. **Catat kode ini** — hanya ditampilkan sekali

### Langkah 4 — Isi konfigurasi di file `.env`

Buka file `.env` di root project, cari bagian `MAIL_*` dan isi seperti berikut:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply.magang.telkom@gmail.com
MAIL_PASSWORD=xxxxxxxxxxxxxxxxxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply.magang.telkom@gmail.com
MAIL_FROM_NAME="Sistem Magang Telkom"
```

> Ganti `noreply.magang.telkom@gmail.com` dengan email pengirim yang sudah disiapkan.
> Ganti `xxxxxxxxxxxxxxxxxxxx` dengan App Password dari Langkah 3 (tanpa spasi).

### Langkah 5 — Clear cache dan test

```bash
php artisan config:clear
php artisan cache:clear
```

Untuk test apakah email berfungsi, bisa jalankan perintah ini di terminal:

```bash
php artisan tinker
```

Lalu di dalam tinker:

```php
Mail::raw('Test email dari Sistem Magang', fn($m) => $m->to('email_tujuan@gmail.com')->subject('Test'));
```

Jika tidak ada error, email berhasil terkirim.

---

## Catatan Penting

- **Jangan commit file `.env` ke git** — file ini berisi kredensial sensitif dan sudah ada di `.gitignore`
- App Password berbeda dengan password Gmail biasa — jangan tertukar
- Jika App Password bocor, segera hapus di pengaturan Google dan buat yang baru
- Limit Gmail: **500 email/hari** — cukup untuk skala project magang

---

## Fitur yang Membutuhkan Email

Setelah konfigurasi SMTP selesai, fitur berikut akan aktif:

| Fitur | Trigger |
|---|---|
| Reset 2FA | Pengguna klik "Tidak bisa akses authenticator?" di halaman verifikasi 2FA |
| Surat Penerimaan | Admin kirim surat penerimaan ke peserta |
