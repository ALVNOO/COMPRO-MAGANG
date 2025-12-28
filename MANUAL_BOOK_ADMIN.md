# Manual Book - Menu Admin

## Daftar Isi
1. [Dashboard](#1-dashboard)
2. [Pengajuan Magang](#2-pengajuan-magang)
3. [Daftar Peserta Magang](#3-daftar-peserta-magang)
4. [Monitoring Pembimbing](#4-monitoring-pembimbing)
5. [Absensi](#5-absensi)
6. [Logbook](#6-logbook)
7. [Laporan Peserta Magang](#7-laporan-peserta-magang)
8. [Kelola Divisi](#8-kelola-divisi)
9. [Kelola Bidang Peminatan](#9-kelola-bidang-peminatan)

---

## 1. Dashboard
**URL:** `http://127.0.0.1:8000/admin/dashboard`

### Melihat Ringkasan Statistik
1. Pada halaman Dashboard, lihat kartu ringkasan di bagian atas:
   o **Total Peserta Magang**: jumlah total peserta yang diterima
   o **Total Pengajuan Magang**: jumlah total pengajuan magang
   o **Total Peserta Selesai**: jumlah peserta yang sudah menyelesaikan magang

### Melihat Pengajuan Magang Terbaru
1. Scroll ke bawah untuk melihat tabel "Pengajuan Magang Terbaru".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Peserta
   o Divisi
   o Status (Pending, Accepted, Rejected, Finished)
   o Tanggal Pengajuan
   o Start Date
   o End Date

### Melihat dan Mengelola Peraturan
1. Scroll ke bagian "Peraturan Saat Ini".
2. Klik tombol "Buka" untuk melihat isi peraturan.
3. Klik tombol "Edit Peraturan" untuk mengubah peraturan.
4. Pada modal edit:
   o Edit isi peraturan pada textarea
   o Klik "Simpan" untuk menyimpan perubahan
   o Klik "Batal" untuk membatalkan

---

## 2. Pengajuan Magang
**URL:** `http://127.0.0.1:8000/admin/applications`

### Melihat Daftar Pengajuan Magang
1. Pada halaman Pengajuan Magang, scroll untuk melihat tabel "Data Pengajuan Magang".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Lengkap
   o NIM
   o Asal Kampus
   o Jurusan
   o No HP Aktif
   o NIK
   o Bidang Peminatan
   o Tanggal Mulai
   o Tanggal Selesai
   o Dokumen (KTM, SBB, PG, CV)
   o Aksi (Terima/Tolak)

### Melihat Dokumen Pengajuan
1. Pada kolom "Dokumen", klik tombol dokumen yang ingin dilihat:
   o **KTM**: Kartu Tanda Mahasiswa
   o **SBB**: Surat Berkelakuan Baik
   o **PG**: Surat Permohonan
   o **CV**: Curriculum Vitae
2. Dokumen akan terbuka di tab baru.

### Menerima Pengajuan Magang
1. Pada kolom "Aksi", klik tombol hijau (checkmark) untuk pengajuan dengan status "Pending".
2. Form akan muncul untuk memilih:
   o **Pilih Divisi**: pilih divisi dari dropdown (wajib)
   o **Pilih Mentor**: pilih mentor dari dropdown (opsional, muncul setelah memilih divisi)
3. Klik "Terima" untuk menerima pengajuan.
4. Klik "Batal" untuk membatalkan.

### Menolak Pengajuan Magang
1. Pada kolom "Aksi", klik tombol merah (X) untuk pengajuan dengan status "Pending".
2. Form akan muncul untuk mengisi:
   o **Alasan Penolakan**: isi alasan penolakan (opsional)
3. Klik "Tolak" untuk menolak pengajuan.
4. Klik "Batal" untuk membatalkan.

---

## 3. Daftar Peserta Magang
**URL:** `http://127.0.0.1:8000/admin/participants`

### Melihat Daftar Peserta Magang
1. Scroll ke bawah untuk melihat tabel "Data Peserta Magang".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama
   o KTM (tombol untuk melihat dokumen)
   o Email
   o HP
   o Divisi
   o Start Date
   o End Date
   o Surat Penerimaan
   o Laporan
   o Sertifikat
   o Surat Selesai

### Upload Surat Penerimaan
1. Pada kolom "Surat Penerimaan", klik "Choose file".
2. Pilih file PDF dari komputer.
3. Klik tombol "Upload".
4. File akan ter-upload dan tombol download akan muncul.

### Download Laporan Penilaian
1. Pada kolom "Laporan", jika sudah ada laporan, klik tombol "Download PDF".
2. File PDF laporan akan terunduh ke komputer.

### Upload Sertifikat
1. Pada kolom "Sertifikat", klik "Choose file".
2. Pilih file PDF dari komputer.
3. Klik tombol "Upload".
4. File akan ter-upload dan tombol download akan muncul.

### Upload Surat Selesai
1. Pada kolom "Surat Selesai", klik "Choose file".
2. Pilih file PDF dari komputer.
3. Klik tombol "Upload".
4. File akan ter-upload dan tombol download akan muncul.

---

## 4. Monitoring Pembimbing
**URL:** `http://127.0.0.1:8000/admin/mentors`

### Melihat Daftar Pembimbing
1. Pada halaman Monitoring Pembimbing, scroll untuk melihat tabel "Data Pembimbing dan Peserta Magang".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Pembimbing (dapat diklik untuk melihat detail)
   o Email
   o Peserta Magang (jumlah peserta yang di-assign)
   o Aksi (Reset Password)

### Melihat Detail Pembimbing
1. Klik pada nama pembimbing pada kolom "Nama Pembimbing".
2. Halaman detail akan menampilkan informasi lengkap pembimbing dan peserta yang di-assign.

### Reset Password Pembimbing
1. Pada kolom "Aksi", klik tombol "Reset Password".
2. Modal konfirmasi akan muncul.
3. Baca peringatan bahwa password akan direset menjadi "mentor123".
4. Klik "Reset Password" untuk mengonfirmasi.
5. Klik "Batal" untuk membatalkan.

---

## 5. Absensi
**URL:** `http://127.0.0.1:8000/admin/attendance`

### Memfilter Data Absensi
1. Pada bagian filter, pilih:
   o **Filter Divisi**: pilih divisi dari dropdown (default: Semua Divisi)
   o **Filter Tanggal**: pilih tanggal dari date picker
2. Klik tombol "Filter" untuk menerapkan filter.
3. Klik tombol "Reset" untuk menghapus filter.

### Melihat Data Absensi
1. Setelah memfilter, scroll ke bawah untuk melihat tabel "Data Absensi".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Peserta Magang (nama, email, divisi)
   o Status (PRESENT, ABSENT, LATE, atau -)
   o Status 7 Hari Terakhir (badge untuk setiap hari)
   o Log (waktu check-in)
   o Aksi (tombol untuk melihat foto)

### Melihat Foto Absensi
1. Pada kolom "Aksi", klik tombol "Lihat Foto" (hanya muncul jika ada foto).
2. Modal akan muncul menampilkan:
   o Foto absensi peserta
   o Status kehadiran
   o Waktu check-in
   o Keterangan (jika ada)
3. Tutup modal dengan:
   o Klik tombol "Tutup"
   o Klik ikon X di pojok kanan atas
   o Klik di luar area modal
   o Tekan tombol Escape

---

## 6. Logbook
**URL:** `http://127.0.0.1:8000/admin/logbook`

### Memfilter Logbook
1. Pada bagian filter, pilih:
   o **Filter Divisi**: pilih divisi dari dropdown (default: All Divisi)
   o **Filter Pembimbing**: pilih mentor dari dropdown (default: All Mentor)
2. Klik tombol "Filter" untuk menerapkan filter.
3. Klik tombol "Reset" untuk menghapus filter.

### Melihat Logbook Peserta
1. Setelah memfilter, scroll ke bawah untuk melihat "Daftar Peserta Magang".
2. Setiap peserta ditampilkan dalam kartu yang berisi:
   o Avatar peserta (lingkaran dengan inisial)
   o Nama lengkap peserta
   o Email peserta
   o Divisi
   o Pembimbing
   o Badge jumlah logbook
   o Ikon panah bawah
3. Klik pada header kartu peserta untuk membuka/menutup daftar logbook.
4. Setelah dibuka, akan muncul tabel logbook yang berisi:
   o Tanggal logbook
   o Isi logbook (konten aktivitas yang ditulis peserta)

---

## 7. Laporan Peserta Magang
**URL:** `http://127.0.0.1:8000/admin/reports`

### Memfilter Laporan Berdasarkan Periode
1. Pada bagian "Filter Laporan", pilih:
   o **Tahun**: pilih tahun dari dropdown (default: tahun saat ini)
   o **Bulan**: pilih bulan dari dropdown (default: bulan saat ini jika tahun saat ini dipilih)
2. Data laporan akan otomatis ter-update setelah memilih filter.

### Melihat Data Laporan
1. Setelah memfilter, scroll ke bawah untuk melihat tabel "Data Laporan".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Peserta
   o Universitas/Sekolah
   o Jurusan
   o NIM
   o Tanggal Mulai
   o Tanggal Berakhir
   o Divisi

### Export Laporan ke PDF
1. Setelah memfilter periode, klik tombol "Export PDF".
2. File PDF akan terunduh ke komputer dengan data sesuai filter yang dipilih.

### Export Laporan ke Excel
1. Setelah memfilter periode, klik tombol "Export Excel".
2. File Excel akan terunduh ke komputer dengan data sesuai filter yang dipilih.

---

## 8. Kelola Bidang Peminatan
**URL:** `http://127.0.0.1:8000/admin/fields`

### Melihat Daftar Bidang Peminatan
1. Pada halaman Kelola Bidang Peminatan, scroll untuk melihat tabel "Bidang Peminatan".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Bidang
   o Deskripsi
   o Icon
   o Divisi (jumlah divisi)
   o Posisi (jumlah posisi)
   o Durasi (dalam bulan)
   o Status (Aktif/Nonaktif)
   o Urutan
   o Aksi (Edit, Aktifkan/Nonaktifkan, Hapus)

### Menambah Bidang Peminatan
1. Klik tombol "Tambah Bidang Peminatan" di bagian atas tabel.
2. Pada halaman form, isi:
   o **Nama Bidang**: masukkan nama bidang peminatan
   o **Deskripsi**: masukkan deskripsi bidang
   o **Icon**: pilih icon (opsional)
   o **Warna Icon**: pilih warna icon (opsional)
   o **Durasi**: masukkan durasi dalam bulan
   o **Status**: pilih Aktif atau Nonaktif
   o **Urutan**: masukkan urutan tampil
3. Klik "Simpan" untuk menyimpan.
4. Klik "Batal" untuk membatalkan.

### Mengedit Bidang Peminatan
1. Pada kolom "Aksi", klik tombol edit (ikon pensil).
2. Pada halaman form, edit informasi yang diinginkan.
3. Klik "Simpan" untuk menyimpan perubahan.
4. Klik "Batal" untuk membatalkan.

### Mengaktifkan/Nonaktifkan Bidang Peminatan
1. Pada kolom "Aksi", klik tombol aktifkan/nonaktifkan (ikon mata).
2. Status bidang peminatan akan berubah sesuai aksi yang dipilih.

### Menghapus Bidang Peminatan
1. Pada kolom "Aksi", klik tombol hapus (ikon trash).
2. Konfirmasi penghapusan pada popup.
3. Jika dikonfirmasi, bidang peminatan akan dihapus.

---

## 9. Kelola Divisi
**URL:** `http://127.0.0.1:8000/admin/divisions`

### Melihat Daftar Divisi
1. Pada halaman Kelola Divisi, scroll untuk melihat tabel "Data Divisi".
2. Tabel menampilkan informasi:
   o Nomor urut
   o Nama Divisi
   o Mentor (nama mentor dan NIK, bisa lebih dari satu mentor per divisi)
   o Status (Aktif/Nonaktif)
   o Aksi (Edit, Nonaktifkan/Aktifkan, Hapus)

### Menambah Divisi
1. Klik tombol "+ Tambah Divisi" di bagian atas tabel.
2. Pada halaman form, isi:
   o **Nama Divisi**: masukkan nama divisi (wajib)
   o **Mentor**: 
     - Masukkan **Nama Mentor** (wajib)
     - Masukkan **NIK** (6 digit, wajib)
     - Klik "Tambah Mentor" untuk menambah mentor lain (opsional, bisa lebih dari satu)
     - Klik ikon trash untuk menghapus mentor (minimal harus ada 1 mentor)
   o **Urutan Tampil**: masukkan urutan tampil (opsional)
   o **Aktifkan Divisi**: centang checkbox untuk mengaktifkan divisi
3. Klik "Simpan" untuk menyimpan.
4. Klik "Kembali" untuk membatalkan dan kembali ke daftar.

### Mengedit Divisi
1. Pada kolom "Aksi", klik tombol "Edit" (ikon pensil).
2. Pada halaman form, edit informasi yang diinginkan:
   o **Nama Divisi**: ubah nama divisi
   o **Mentor**: edit atau tambah/hapus mentor
   o **Urutan Tampil**: ubah urutan tampil
   o **Aktifkan Divisi**: centang/uncentang untuk mengubah status
3. Klik "Update" untuk menyimpan perubahan.
4. Klik "Kembali" untuk membatalkan.

### Mengaktifkan/Nonaktifkan Divisi
1. Pada kolom "Aksi", klik tombol "Nonaktifkan" (ikon mata tertutup) untuk divisi yang aktif.
2. Atau klik tombol "Aktifkan" (ikon mata) untuk divisi yang nonaktif.
3. Status divisi akan berubah sesuai aksi yang dipilih.

### Menghapus Divisi
1. Pada kolom "Aksi", klik tombol "Hapus" (ikon trash).
2. Konfirmasi penghapusan pada popup.
3. Jika dikonfirmasi, divisi akan dihapus.

---

**Dokumen ini dibuat untuk membantu admin dalam menggunakan sistem manajemen peserta magang.**
