# Manual Book - Menu Mentor

## Daftar Isi
1. [Absensi Peserta Magang](#1-absensi-peserta-magang)
2. [Logbook Peserta Magang](#2-logbook-peserta-magang)
3. [Laporan Penilaian Peserta Magang](#3-laporan-penilaian-peserta-magang)

---

## 1. Absensi Peserta Magang
**URL:** `http://127.0.0.1:8000/mentor/absensi`

### Memfilter Data Absensi Berdasarkan Tanggal
1. Pada halaman Absensi Peserta Magang, temukan bagian "Filter Tanggal".
2. Klik pada input field tanggal (ikon kalender).
3. Pilih tanggal yang ingin dilihat (maksimal tanggal hari ini).
4. Klik tombol "Terapkan".
5. Data absensi akan ter-update sesuai tanggal yang dipilih.

### Melihat Ringkasan Absensi
1. Setelah memfilter tanggal, lihat kartu ringkasan di bawah filter:
   o **Total Peserta**: jumlah total peserta magang yang di-assign
   o **Hadir**: jumlah peserta yang hadir pada tanggal tersebut
   o **Terlambat**: jumlah peserta yang terlambat
   o **Absen**: jumlah peserta yang tidak hadir

### Melihat Detail Absensi Peserta
1. Scroll ke bawah untuk melihat tabel absensi.
2. Tabel menampilkan informasi:
   o **Peserta**: nama dan NIM peserta
   o **Status**: Hadir (hijau), Terlambat (kuning), Absen (merah), atau Belum (abu-abu)
   o **Waktu**: jam check-in peserta (format HH:mm) atau "-" jika belum ada
   o **Riwayat 7 Hari**: 7 kotak kecil menunjukkan status 7 hari terakhir
   o **Aksi**: tombol untuk melihat foto absensi

### Melihat Foto Absensi
1. Pada tabel absensi, klik tombol "Foto" pada kolom Aksi (hanya muncul jika peserta sudah check-in).
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

### Melihat Riwayat 7 Hari
1. Pada kolom "Riwayat 7 Hari", hover pada kotak kecil untuk melihat detail.
2. Tooltip akan menampilkan:
   o Tanggal (format: dd MMM)
   o Status kehadiran pada tanggal tersebut

---

## 2. Logbook Peserta Magang
**URL:** `http://127.0.0.1:8000/mentor/logbook`

### Melihat Ringkasan Logbook
1. Pada halaman Logbook Peserta Magang, lihat kartu ringkasan di bagian atas:
   o **Total Peserta**: jumlah total peserta magang
   o **Total Logbook**: jumlah total logbook dari semua peserta
   o **Tanggal Hari Ini**: tanggal dan bulan saat ini

### Melihat Logbook Peserta
1. Scroll ke bawah untuk melihat daftar peserta.
2. Setiap peserta ditampilkan dalam kartu yang berisi:
   o Avatar peserta (lingkaran dengan inisial)
   o Nama lengkap peserta
   o Email peserta
   o Badge jumlah logbook
   o Ikon panah bawah
3. Klik pada header kartu peserta untuk membuka/menutup daftar logbook.
4. Setelah dibuka, akan muncul daftar logbook yang berisi:
   o Kotak tanggal (merah) di kiri dengan tanggal dan bulan
   o Tanggal lengkap (contoh: "Sabtu, 20 Desember 2025")
   o Isi logbook (konten aktivitas yang ditulis peserta)

### Catatan
- Jika peserta belum memiliki logbook, akan muncul pesan "Belum Ada Logbook".
- Jika belum ada peserta yang di-assign, akan muncul pesan "Belum Ada Peserta".

---

## 3. Laporan Penilaian Peserta Magang
**URL:** `http://127.0.0.1:8000/mentor/laporan-penilaian`

### Memfilter Laporan Berdasarkan Periode
1. Pada halaman Laporan Penilaian, temukan bagian "Filter Laporan".
2. Pilih Tahun dari dropdown (default: tahun saat ini).
3. Pilih Bulan dari dropdown (default: bulan saat ini jika tahun saat ini dipilih).
4. Data laporan akan otomatis ter-update setelah memilih filter.

### Upload Laporan PDF
1. Pada tabel "Data Laporan Penilaian", temukan peserta yang belum memiliki laporan.
2. Klik tombol "Choose file" atau input file pada kolom "Upload Laporan PDF".
3. Pilih file PDF dari komputer (format: .pdf).
4. Klik tombol "Upload PDF".
5. Tunggu hingga proses upload selesai (tombol akan menampilkan "Uploading...").
6. Setelah berhasil, akan muncul notifikasi sukses.
7. Tabel akan ter-update dan menampilkan tombol Download dan Hapus.

### Download Laporan PDF
1. Pada tabel "Data Laporan Penilaian", temukan peserta yang sudah memiliki laporan (ada tombol Download).
2. Klik tombol "Download" (hijau).
3. File PDF akan terunduh ke komputer.

### Hapus Laporan
1. Pada tabel "Data Laporan Penilaian", temukan peserta yang sudah memiliki laporan.
2. Klik tombol "Hapus" (merah).
3. Konfirmasi penghapusan pada popup konfirmasi.
4. Jika dikonfirmasi, laporan akan dihapus.
5. Tabel akan ter-update dan kembali menampilkan form upload.

### Mengganti Laporan yang Sudah Ada
1. Hapus laporan yang lama terlebih dahulu (ikuti langkah "Hapus Laporan").
2. Upload laporan baru (ikuti langkah "Upload Laporan PDF").

### Catatan
- Setiap peserta hanya dapat memiliki 1 laporan per periode (bulan).
- File yang diupload harus dalam format PDF.
- Pastikan file PDF sudah benar sebelum diupload karena tidak ada fitur edit.
- Data peserta yang ditampilkan hanya peserta dengan status "accepted" yang di-assign ke mentor.

---

**Dokumen ini dibuat untuk membantu mentor dalam menggunakan sistem manajemen peserta magang.**
