# Manual Book - Menu Peserta Magang

## Daftar Isi
1. [Dashboard](#1-dashboard)
2. [Absensi](#2-absensi)
3. [Penugasan & Penilaian](#3-penugasan--penilaian)
4. [Logbook](#4-logbook)
5. [Sertifikat](#5-sertifikat)
6. [Profil](#6-profil)

---

## 1. Dashboard
**URL:** `http://127.0.0.1:8000/dashboard`

### Melihat Ringkasan Statistik
1. Pada halaman Dashboard, lihat kartu ringkasan di bagian atas:
   o **Tugas Selesai**: jumlah tugas yang sudah selesai dan dinilai (dengan persentase dari total tugas)
   o **Tugas Perlu Revisi**: jumlah tugas yang memerlukan revisi
   o **Hari Magang Tersisa**: sisa hari magang dengan tanggal mulai dan tanggal selesai

### Melihat Kalender Magang
1. Scroll ke bagian "Kalender Magang".
2. Kalender menampilkan:
   o Periode magang (background biru)
   o Deadline tugas (event merah)
   o Tanggal mulai dan akhir magang
3. Klik pada event tugas untuk langsung menuju halaman Tugas.
4. Gunakan tombol navigasi (prev/next) untuk melihat bulan lain.
5. Klik "Hari Ini" untuk kembali ke bulan saat ini.

### Melihat Tugas Terbaru
1. Scroll ke bagian "Tugas Terbaru".
2. Daftar menampilkan tugas terbaru dengan:
   o Deskripsi tugas
   o Status (Selesai, Perlu Revisi, atau Pending)
   o Tanggal dibuat dan deadline
3. Klik "→ Lihat Semua" untuk melihat semua tugas di halaman Tugas.

### Melihat Notifikasi
1. Jika ada notifikasi, akan muncul alert di bagian atas halaman:
   o **Tugas Baru**: notifikasi jika ada tugas baru yang diberikan
   o **Tugas Dinilai**: notifikasi jika tugas sudah dinilai
   o **Sertifikat Baru**: notifikasi jika sudah ada sertifikat yang tersedia
   o **Revisi Tugas**: notifikasi jika ada tugas yang perlu direvisi
   o **Reminder Absensi**: notifikasi untuk melakukan check-in jika belum absensi hari ini

---

## 2. Absensi
**URL:** `http://127.0.0.1:8000/attendance`

### Melihat Status Absensi Hari Ini
1. Pada halaman Absensi, lihat bagian "Absensi Hari Ini".
2. Jika sudah melakukan absensi, akan menampilkan:
   o Status kehadiran (Hadir, Terlambat, atau Absen)
   o Waktu check-in
   o Foto absensi (jika check-in)
   o Alasan (jika absen)

### Check In
1. Jika belum melakukan absensi, klik tombol "Check In" (hijau).
2. Pada modal, klik tombol "Buka Kamera".
3. Berikan izin akses kamera jika diminta.
4. Posisikan wajah di depan kamera.
5. Klik tombol "Ambil Foto" untuk mengambil foto selfie.
6. Klik "Ambil Ulang" jika foto tidak sesuai.
7. Klik "Check In" untuk menyelesaikan absensi.
8. Klik "Batal" untuk membatalkan.

**Catatan:**
- Jika check-in dilakukan setelah jam 08:00, status akan otomatis menjadi "Terlambat".
- Foto selfie wajib diambil sebagai bukti kehadiran.

### Absen
1. Jika tidak bisa hadir, klik tombol "Absen" (merah).
2. Pada modal, isi:
   o **Alasan Absen**: jelaskan alasan tidak bisa hadir (wajib)
   o **Bukti**: upload file bukti jika ada (opsional, format: PDF, JPG, PNG, maksimal 2MB)
3. Klik "Submit Absen" untuk mengirim.
4. Klik "Batal" untuk membatalkan.

### Melihat Riwayat Absensi
1. Scroll ke bawah untuk melihat bagian "Riwayat Absensi (30 Hari Terakhir)".
2. Tabel menampilkan:
   o Tanggal absensi
   o Status (Hadir, Terlambat, atau Absen)
   o Waktu check-in (jika ada)
   o Keterangan/alasan (jika ada)

---

## 3. Penugasan & Penilaian
**URL:** `http://127.0.0.1:8000/dashboard/assignments`

### Melihat Daftar Tugas
1. Pada halaman Penugasan & Penilaian, scroll untuk melihat tabel "Daftar Tugas".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Deskripsi Tugas (dengan tanggal dibuat)
   o Deadline
   o File Tugas (tombol download jika ada)
   o Status Pengumpulan (Belum dikumpulkan, Sudah dikumpulkan, atau Belum dikumpulkan (Revisi))
   o Nilai (jika sudah dinilai, format: X/10)
   o Feedback dari mentor
   o Aksi (Kumpulkan, Kumpulkan Ulang, atau Selesai)

### Download File Tugas
1. Pada kolom "File Tugas", jika ada file, klik tombol "Download".
2. File tugas akan terunduh ke komputer.

### Mengumpulkan Tugas
1. Pada kolom "Aksi", klik tombol "Kumpulkan" untuk tugas yang belum dikumpulkan.
2. Pada modal, lihat deskripsi tugas.
3. Jika ada field "Online Text", isi teks online (opsional).
4. Upload file tugas:
   o Klik "Choose file" atau input file
   o Pilih file dari komputer (format: PDF, DOC, DOCX, maksimal 2MB)
5. Klik "Kumpulkan Tugas" untuk mengirim.
6. Klik "Batal" untuk membatalkan.

### Mengumpulkan Ulang Tugas (Revisi)
1. Jika tugas perlu direvisi, pada kolom "Aksi" akan muncul tombol "Kumpulkan Ulang".
2. Klik tombol "Kumpulkan Ulang".
3. Pada modal, lihat feedback dari mentor.
4. Upload file tugas yang sudah direvisi.
5. Jika ada field "Online Text", isi teks online yang sudah direvisi (opsional).
6. Klik "Kumpulkan Ulang" untuk mengirim.
7. Klik "Batal" untuk membatalkan.

### Melihat Nilai dan Feedback
1. Setelah tugas dinilai, nilai akan muncul pada kolom "Nilai" (format: X/10).
2. Feedback dari mentor akan muncul pada kolom "Feedback".
3. Jika tugas sudah selesai dan dinilai, kolom "Aksi" akan menampilkan "✓ Selesai".

---

## 4. Logbook
**URL:** `http://127.0.0.1:8000/logbook`

### Melihat Daftar Logbook
1. Pada halaman Logbook, scroll untuk melihat tabel "Daftar Logbook".
2. Tabel menampilkan:
   o Tanggal logbook
   o Isi Logbook (konten aktivitas)
   o Aksi (Edit, Hapus)

### Menambah Logbook
1. Klik tombol "+ Tambah Logbook" di bagian atas halaman.
2. Atau gunakan baris kosong di bawah tabel (jika tersedia).
3. Isi form:
   o **Tanggal**: pilih tanggal dari date picker (wajib)
   o **Isi Logbook**: tulis aktivitas harian Anda (wajib)
4. Klik tombol "Simpan" (ikon checkmark hijau) untuk menyimpan.
5. Klik tombol "Batal" (ikon X abu-abu) untuk membatalkan.

### Mengedit Logbook
1. Pada kolom "Aksi", klik tombol edit (ikon pensil kuning).
2. Pada modal, edit:
   o **Tanggal**: ubah tanggal jika perlu
   o **Isi Logbook**: edit konten aktivitas
3. Klik "Simpan Perubahan" untuk menyimpan.
4. Klik "Batal" untuk membatalkan.

### Menghapus Logbook
1. Pada kolom "Aksi", klik tombol hapus (ikon trash merah).
2. Konfirmasi penghapusan pada popup.
3. Jika dikonfirmasi, logbook akan dihapus.

---

## 5. Sertifikat
**URL:** `http://127.0.0.1:8000/dashboard/certificates`

### Melihat Sertifikat yang Tersedia
1. Pada halaman Sertifikat Magang, jika sudah ada sertifikat, akan ditampilkan dalam kartu.
2. Setiap kartu menampilkan:
   o Preview sertifikat (jika ada)
   o Tanggal diterbitkan
   o Tombol "Download Sertifikat"

### Download Sertifikat
1. Jika sudah ada sertifikat, klik tombol "Download Sertifikat".
2. File PDF sertifikat akan terunduh ke komputer.

### Melihat Informasi Sertifikat
1. Scroll ke bawah untuk melihat bagian "Informasi Sertifikat".
2. Bagian ini menampilkan:
   o **Syarat Mendapatkan Sertifikat**:
     - Pengajuan magang diterima
     - Menyelesaikan semua tugas yang diberikan
     - Mengikuti program magang dengan baik
     - Mendapatkan penilaian positif dari pembimbing
   o **Manfaat Sertifikat**:
     - Bukti pengalaman kerja di BUMN
     - Menambah nilai CV dan portofolio
     - Kesempatan bergabung sebagai karyawan
     - Networking dengan profesional

### Jika Belum Ada Sertifikat
1. Jika belum ada sertifikat, akan muncul pesan "Belum Ada Sertifikat".
2. Klik "Lihat Tugas" untuk melihat tugas yang perlu diselesaikan.
3. Klik "Status Pengajuan" untuk melihat status pengajuan magang.

---

## 6. Profil
**URL:** `http://127.0.0.1:8000/dashboard/profile`

### Melihat Informasi Pribadi
1. Pada bagian atas halaman, lihat banner profil yang menampilkan:
   o Avatar
   o Nama lengkap
   o Email
2. Scroll ke bawah untuk melihat kartu "Biodata / Informasi Peserta" yang berisi:
   o Nama
   o Email
   o NIM
   o No HP
   o Universitas
   o Jurusan
   o NIK (No.KTP)

### Melihat Status Pengajuan Magang
1. Pada kartu "Status Pengajuan Magang", lihat informasi:
   o Divisi Penempatan (jika sudah diterima)
   o Mentor (jika sudah diterima)
   o Bidang Peminatan
   o Status (Diterima, Ditolak, Pending, atau Finished)
   o Tanggal Pengajuan
   o Tanggal Mulai (jika sudah diterima)
   o Tanggal Selesai (jika sudah diterima)

### Mengubah Password
1. Scroll ke bagian "Pengaturan Akun".
2. Klik tombol "Ubah Password".
3. Pada modal, isi:
   o **Password Lama**: masukkan password saat ini (wajib)
   o **Password Baru**: masukkan password baru (wajib, minimal 8 karakter)
   o **Konfirmasi Password Baru**: masukkan ulang password baru (wajib)
4. Klik "Simpan Password" untuk menyimpan.
5. Klik "Batal" untuk membatalkan.

---

**Dokumen ini dibuat untuk membantu peserta magang dalam menggunakan sistem manajemen peserta magang.**
