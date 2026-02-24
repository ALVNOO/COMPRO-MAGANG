# User Acceptance Test (UAT) Document
## Sistem Manajemen Magang PT Pos Indonesia

---

## 1. Introduction

### 1.1. Purpose of UAT

Dokumen User Acceptance Test (UAT) ini dibuat dengan tujuan:

- **Memverifikasi bahwa sistem sesuai kebutuhan bisnis**: Memastikan bahwa Sistem Manajemen Magang PT Pos Indonesia telah memenuhi semua requirement bisnis yang telah ditetapkan, termasuk proses pengajuan magang, manajemen penugasan, absensi, logbook, dan sertifikasi.

- **Menilai apakah fungsionalitas dapat diterima pengguna**: Mengevaluasi apakah semua fitur yang tersedia dalam sistem dapat digunakan dengan mudah dan efektif oleh tiga aktor utama (Admin, Pembimbing, dan Peserta Magang) sesuai dengan kebutuhan operasional mereka.

- **Menjadi dasar keputusan Go Live**: Menyediakan bukti dokumentasi yang komprehensif untuk mendukung keputusan apakah sistem sudah siap untuk di-deploy ke lingkungan produksi atau masih memerlukan perbaikan lebih lanjut.

- **Mengidentifikasi bug dan issue kritis**: Mendeteksi masalah-masalah yang dapat mengganggu operasional sistem sebelum sistem digunakan secara penuh oleh pengguna akhir.

- **Memastikan kualitas sistem**: Memverifikasi bahwa sistem telah memenuhi standar kualitas yang ditetapkan dalam hal performa, keamanan, dan user experience.

### 1.2. Scope of UAT

#### Lingkup Bisnis

UAT ini mencakup pengujian terhadap seluruh proses bisnis manajemen magang di PT Pos Indonesia, mulai dari proses registrasi dan pengajuan magang oleh peserta, review dan persetujuan oleh pembimbing, manajemen penugasan dan penilaian, absensi harian, pencatatan logbook, hingga proses sertifikasi dan pelaporan.

#### Fitur yang Diuji

1. **Authentication & Authorization**
   - Login dan Logout
   - Registrasi akun baru
   - Two-Factor Authentication (2FA) untuk Pembimbing dan Peserta
   - Change Password
   - Role-based access control

2. **Dashboard**
   - Dashboard Admin
   - Dashboard Pembimbing
   - Dashboard Peserta

3. **Manajemen Pengajuan Magang**
   - Registrasi peserta baru
   - Pengajuan magang ke bidang yang diminati
   - Review pengajuan oleh admin
   - Assign pengajuan ke divisi dan mentor oleh admin
   - Persetujuan/Penolakan pengajuan oleh admin
   - Upload surat penerimaan secara manual oleh admin
   - Re-application

4. **Manajemen Penugasan**
   - Pembuatan penugasan oleh pembimbing
   - Submit tugas oleh peserta
   - Penilaian tugas oleh pembimbing
   - Revisi tugas
   - Tracking status penugasan

5. **Manajemen Absensi**
   - Check-in harian peserta
   - Absen (ketidakhadiran)
   - View absensi oleh pembimbing
   - View absensi oleh admin
   - Filter dan export data absensi

6. **Manajemen Logbook**
   - Input logbook harian oleh peserta
   - Edit dan hapus logbook
   - Review logbook oleh pembimbing
   - View logbook oleh admin
   - Filter logbook berdasarkan periode

7. **Manajemen Sertifikat**
   - Upload sertifikat secara manual oleh admin
   - Download sertifikat oleh peserta
   - View sertifikat

8. **Manajemen Struktur Organisasi**
   - CRUD Divisi
   - CRUD Pembimbing per divisi (memungkinkan lebih dari 1 pembimbing per divisi)
   - Toggle status aktif/nonaktif divisi

9. **Manajemen Field of Interest**
   - CRUD Field of Interest
   - Toggle status aktif/nonaktif

10. **Reporting**
    - Laporan peserta magang (Admin)
    - Laporan penilaian (Pembimbing)
    - Export PDF dan Excel
    - Filter berdasarkan periode dan klasifikasi

11. **Manajemen Peserta**
    - View daftar peserta
    - Upload acceptance letter
    - Upload completion letter
    - Upload certificate
    - Download assessment report

12. **Manajemen Pembimbing**
    - View daftar pembimbing
    - Detail pembimbing
    - Reset password pembimbing

#### Excluded Items (Fitur yang Tidak Diuji)

- **Unit Testing**: Pengujian unit individual tidak termasuk dalam scope UAT ini
- **Performance Testing**: Pengujian performa dan load testing tidak termasuk dalam scope UAT ini
- **Security Penetration Testing**: Pengujian keamanan tingkat lanjut tidak termasuk dalam scope UAT ini
- **Integration dengan Sistem Eksternal**: Integrasi dengan sistem pihak ketiga tidak termasuk dalam scope UAT ini
- **Mobile Application**: Aplikasi mobile (jika ada) tidak termasuk dalam scope UAT ini
- **API Testing**: Pengujian API secara langsung tidak termasuk dalam scope UAT ini (hanya melalui UI)

### 1.3. Intended Audience

Dokumen UAT ini ditujukan untuk:

- **Product Owner**: Sebagai pemilik produk yang bertanggung jawab atas keputusan Go Live dan prioritas perbaikan
- **Business Analyst**: Sebagai analis bisnis yang mengevaluasi kesesuaian sistem dengan kebutuhan bisnis
- **End User**: Sebagai pengguna akhir (Admin, Pembimbing, Peserta) yang akan menggunakan sistem secara langsung
- **QA Tester**: Sebagai tim quality assurance yang melakukan pengujian dan dokumentasi hasil UAT
- **Developer**: Sebagai tim pengembang yang akan memperbaiki bug dan issue yang ditemukan selama UAT
- **Supervisor/Management**: Sebagai supervisor dan manajemen yang akan mengambil keputusan terkait deployment sistem
- **Project Manager**: Sebagai project manager yang mengkoordinasikan proses UAT dan memastikan timeline pengujian

---

## 2. UAT Environment

| Item | Description |
|------|-------------|
| **URL** | http://localhost:8000 (Development) / https://magang.posindonesia.co.id (Production) |
| **Browser** | Chrome 120+, Firefox 121+, Edge 120+, Safari 17+ |
| **OS** | Windows 10/11, macOS 13+, Ubuntu 22.04+ |
| **Device** | Desktop/Laptop (minimal resolusi 1366x768) |
| **DB Version** | PostgreSQL 14+ / MySQL 8.0+ |
| **Back-end** | PHP 8.2+, Laravel 12.0 |
| **Front-end** | Bootstrap 5.3, Tailwind CSS 4.0, Alpine.js 3.15, jQuery 3.7 |
| **Web Server** | Apache 2.4+ / Nginx 1.20+ |
| **PHP Extensions** | PDO, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, GD, Fileinfo |
| **Dependencies** | Google2FA, DomPDF, Maatwebsite Excel, QR Code Generator |
| **Version Control** | Git |
| **Email Service** | SMTP (untuk pengiriman email notifikasi) |

### Credential Login (UAT Environment)

| Role | Username | Password | Email |
|------|----------|----------|-------|
| **Admin** | admin | admin123 | admin@posindonesia.co.id |
| **Pembimbing** | mentor_[nama_divisi] | mentor123 | mentor_[nama_divisi]@telkomindonesia.co.id |
| **Peserta** | [username_peserta] | [password_peserta] | [email_peserta] |

**Catatan**: 
- Credential di atas adalah untuk lingkungan UAT/testing. Pastikan untuk menggunakan credential yang berbeda di lingkungan produksi.
- Untuk akun Pembimbing dan Peserta, 2FA wajib diaktifkan setelah login pertama kali.

---

## 3. UAT Roles and Responsibilities

| Role | Name | Responsibility |
|------|------|----------------|
| **UAT Lead** | [Nama UAT Lead] | - Mengkoordinasikan seluruh kegiatan UAT<br>- Menyusun rencana pengujian<br>- Memonitor progress pengujian<br>- Menyusun laporan UAT summary<br>- Mengkomunikasikan hasil UAT ke stakeholder |
| **Business User / Client Representative** | [Nama Business User] | - Menyediakan requirement dan acceptance criteria<br>- Melakukan pengujian dari perspektif end user<br>- Memberikan feedback terhadap fungsionalitas<br>- Menyetujui atau menolak fitur berdasarkan kebutuhan bisnis<br>- Menandatangani dokumen UAT approval |
| **QA Tester** | [Nama QA Tester] | - Melakukan eksekusi test cases<br>- Mencatat hasil pengujian (Pass/Fail)<br>- Mengidentifikasi dan melaporkan bug<br>- Membuat screenshot untuk evidence<br>- Mengupdate test cases jika diperlukan<br>- Membuat bug report yang detail |
| **Developer Support** | [Nama Developer] | - Menyediakan environment UAT<br>- Memperbaiki bug yang ditemukan selama UAT<br>- Menjelaskan fungsionalitas teknis jika diperlukan<br>- Memastikan environment UAT stabil<br>- Menyediakan data test yang diperlukan |
| **Project Manager** | [Nama PM] | - Mengalokasikan resource untuk UAT<br>- Memonitor timeline UAT<br>- Mengkoordinasikan antara tim development dan testing<br>- Mengambil keputusan terkait prioritas perbaikan<br>- Memastikan UAT selesai sesuai jadwal |

---

## 4. Test Scenario Overview

| Scenario ID | Scenario Name | Description | Related Module |
|-------------|---------------|-------------|----------------|
| **SC-01** | Login dan Authentication | Pengujian proses login, logout, dan autentikasi pengguna termasuk 2FA | Authentication |
| **SC-02** | Registrasi Akun Baru | Pengujian proses registrasi akun peserta magang baru | Authentication, Registration |
| **SC-03** | Pengajuan Magang | Pengujian proses pengajuan magang oleh peserta ke divisi tertentu | Internship Application |
| **SC-04** | Review dan Assign Pengajuan | Pengujian proses review, persetujuan/penolakan, dan assign pengajuan ke divisi dan mentor oleh admin | Admin Dashboard |
| **SC-05** | Upload Surat Penerimaan | Pengujian proses upload surat penerimaan secara manual oleh admin | Admin Dashboard |
| **SC-06** | Manajemen Penugasan | Pengujian proses pembuatan, submit, dan penilaian penugasan | Assignment Management |
| **SC-07** | Check-in Absensi | Pengujian proses check-in absensi harian oleh peserta | Attendance |
| **SC-08** | Input Logbook | Pengujian proses input, edit, dan hapus logbook harian | Logbook |
| **SC-9** | Upload Sertifikat | Pengujian proses upload sertifikat secara manual oleh admin | Certificate Management |
| **SC-10** | Download Sertifikat | Pengujian proses download sertifikat oleh peserta | Certificate Management |
| **SC-11** | Manajemen Divisi | Pengujian CRUD Divisi | Division Management |
| **SC-12** | Manajemen Field of Interest | Pengujian CRUD Field of Interest | Field Management |
| **SC-13** | Manajemen Pembimbing | Pengujian CRUD pembimbing per divisi (memungkinkan lebih dari 1 pembimbing per divisi), view, detail, dan reset password pembimbing | Mentor Management |
| **SC-14** | Laporan Peserta | Pengujian generate laporan peserta magang dengan filter dan export | Reporting |
| **SC-15** | Laporan Penilaian | Pengujian generate laporan penilaian oleh pembimbing | Reporting |
| **SC-16** | View Dashboard | Pengujian tampilan dan fungsionalitas dashboard untuk setiap role | Dashboard |
| **SC-17** | Change Password | Pengujian proses perubahan password oleh pengguna | Authentication |
| **SC-18** | Re-application | Pengujian proses pengajuan ulang magang oleh peserta | Internship Application |

---

## 5. Detailed Test Cases

### Test Case TC-001

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-001 |
| **Scenario ID** | SC-01 |
| **Test Case Name** | Valid Login dengan Username dan Password |
| **Pre-conditions** | 1. User sudah terdaftar di sistem<br>2. Username dan password sudah diketahui<br>3. Browser sudah dibuka dan mengakses URL aplikasi |
| **Test Steps** | 1. Buka halaman login (http://localhost:8000/login)<br>2. Masukkan username yang valid<br>3. Masukkan password yang valid<br>4. Klik tombol "Login"<br>5. Jika role Pembimbing atau Peserta, setup 2FA jika belum diaktifkan<br>6. Verifikasi redirect ke dashboard sesuai role |
| **Test Data** | Username: admin<br>Password: admin123<br>Role: Admin |
| **Expected Result** | 1. User berhasil login<br>2. Redirect ke dashboard sesuai role (Admin ke /admin/dashboard)<br>3. Tidak ada error message<br>4. Session berhasil dibuat |
| **Actual Result** | User berhasil login dengan username "admin" dan password "admin123". Redirect ke dashboard admin (/admin/dashboard) berjalan dengan baik. Tidak ada error message dan session berhasil dibuat. |
| **Status** | Passed |
| **Notes** | Proses login berjalan dengan lancar tanpa kendala. |

---

### Test Case TC-002

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-002 |
| **Scenario ID** | SC-01 |
| **Test Case Name** | Invalid Login dengan Password Salah |
| **Pre-conditions** | 1. User sudah terdaftar di sistem<br>2. Browser sudah dibuka dan mengakses URL aplikasi |
| **Test Steps** | 1. Buka halaman login<br>2. Masukkan username yang valid<br>3. Masukkan password yang salah<br>4. Klik tombol "Login" |
| **Test Data** | Username: admin<br>Password: wrongpassword |
| **Expected Result** | 1. Login gagal<br>2. Menampilkan error message "Username atau password salah"<br>3. User tetap di halaman login<br>4. Session tidak dibuat |
| **Actual Result** | Login gagal dengan password yang salah. Sistem menampilkan error message "Username atau password salah". User tetap berada di halaman login dan session tidak dibuat. |
| **Status** | Passed |
| **Notes** | Validasi password berjalan dengan baik dan error message ditampilkan dengan benar. |

---

### Test Case TC-003

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-003 |
| **Scenario ID** | SC-01 |
| **Test Case Name** | Login dengan 2FA untuk Pembimbing |
| **Pre-conditions** | 1. User dengan role Pembimbing sudah terdaftar<br>2. 2FA sudah diaktifkan untuk user tersebut<br>3. User memiliki aplikasi authenticator (Google Authenticator) |
| **Test Steps** | 1. Buka halaman login<br>2. Masukkan username dan password Pembimbing<br>3. Klik tombol "Login"<br>4. Masukkan kode 2FA dari aplikasi authenticator<br>5. Klik tombol "Verify" |
| **Test Data** | Username: mentor_divisi_teknik<br>Password: mentor123<br>2FA Code: [kode dari authenticator app] |
| **Expected Result** | 1. Setelah login, redirect ke halaman verifikasi 2FA<br>2. User dapat memasukkan kode 2FA<br>3. Setelah verifikasi berhasil, redirect ke dashboard Pembimbing<br>4. Session berhasil dibuat |
| **Actual Result** | Setelah login dengan username dan password pembimbing, sistem redirect ke halaman verifikasi 2FA. User berhasil memasukkan kode 2FA dari aplikasi authenticator. Setelah verifikasi berhasil, redirect ke dashboard Pembimbing dan session berhasil dibuat. |
| **Status** | Passed |
| **Notes** | Proses 2FA berjalan dengan baik dan meningkatkan keamanan sistem. |

---

### Test Case TC-004

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-004 |
| **Scenario ID** | SC-02 |
| **Test Case Name** | Registrasi Akun Peserta Baru |
| **Pre-conditions** | 1. Browser sudah dibuka dan mengakses URL aplikasi<br>2. User belum terdaftar di sistem |
| **Test Steps** | 1. Buka halaman register (http://localhost:8000/register)<br>2. Isi form registrasi:<br>   - Nama lengkap<br>   - Email<br>   - Password dan konfirmasi password (Opsional)<br>   - NIM (Opsional)<br>   - Universitas (Opsional)<br>   - Jurusan (Opsional)<br>   - Nomor telepon (Opsional)<br>   - Nomor KTP (Opsional)<br>3. Klik tombol "Register" |
| **Test Data** | Nama: John Doe<br>Email: john.doe@university.ac.id<br>Password: password123 (Opsional)<br>NIM: 1234567890 (Opsional)<br>Universitas: Universitas Telkom (Opsional)<br>Jurusan: Teknik Informatika (Opsional)<br>Phone: 081234567890 (Opsional)<br>KTP: 3201234567890123 (Opsional) |
| **Expected Result** | 1. Registrasi berhasil<br>2. Redirect ke pengisian formulir permohonan magang<br>3. Menampilkan pesan sukses<br>4. Data user tersimpan di database |
| **Actual Result** | Registrasi berhasil. Sistem menampilkan pesan sukses, data user tersimpan di database, dan user diarahkan ke halaman pengisian formulir permohonan magang. |
| **Status** | Passed |
| **Notes** | Proses registrasi berjalan dengan baik dan semua data tersimpan dengan benar. |

---

### Test Case TC-005

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-005 |
| **Scenario ID** | SC-03 |
| **Test Case Name** | Pengajuan Magang berdasarkan Bidang Peminatan |
| **Pre-conditions** | 1. Peserta berada pada halaman formulir pengajuan magang<br>2. Peserta sudah melengkapi Nama Lengkap, Email, dan Password |
| **Test Steps** | 1. Pastikan peserta berada pada halaman formulir pengajuan magang<br>2. Isi biodata:<br>   - NIM<br>   - Asal Universitas/Sekolah<br>   - Jurusan<br>   - Nomor telepon<br>   - Nomor KTP<br>3. Isi tanggal mulai magang dan tanggal selesai magang<br>4. Pilih bidang peminatan yang diminati<br>5. Upload dokumen persyaratan: KTM, CV, Surat Permohonan, Surat Berkelakuan Baik<br>6. Klik tombol "Daftar Sekarang" |
| **Test Data** | NIM: 1234567890<br>Asal Universitas/Sekolah: Universitas Telkom<br>Jurusan: Teknik Informatika<br>Nomor telepon: 081234567890<br>Nomor KTP: 3201234567890123<br>Tanggal mulai: 2024-01-01<br>Tanggal selesai: 2024-03-31<br>Bidang peminatan: Divisi Teknologi Informasi<br>KTM: [file KTM valid]<br>CV: [file CV]<br>Surat Permohonan: [file PDF]<br>Surat Berkelakuan Baik: [file PDF] |
| **Expected Result** | 1. Pengajuan magang berhasil dan status menjadi "Pending"<br>2. Peserta diarahkan ke dashboard peserta dengan status pengajuan masih "Pending"<br>3. Data pengajuan tersimpan di database<br>4. ADMIN menerima notifikasi pengajuan terbaru |
| **Actual Result** | Pengajuan magang berhasil, status menjadi "Pending", peserta diarahkan ke dashboard peserta dengan status pengajuan pending, data pengajuan tersimpan di database, dan ADMIN menerima notifikasi pengajuan terbaru. |
| **Status** | Passed |
| **Notes** | Proses pengajuan magang berjalan dengan baik dan data tersimpan dengan benar. |

---

### Test Case TC-006

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-006 |
| **Scenario ID** | SC-04 |
| **Test Case Name** | Review dan Setujui Pengajuan Magang oleh Admin |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Ada pengajuan magang dengan status "Pending" |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Daftar Pengajuan Magang"<br>3. Pilih pengajuan yang akan direview<br>4. Review dokumen dan data pengajuan<br>5. Pilih divisi yang akan menerima peserta<br>6. Pilih mentor yang akan membimbing peserta<br>7. Klik tombol "Terima" atau "Approve"<br>8. Konfirmasi persetujuan |
| **Test Data** | Application ID: APP001<br>Divisi: Divisi Teknologi Informasi<br>Mentor: Dr. Ahmad Rizki |
| **Expected Result** | 1. Pengajuan berhasil disetujui<br>2. Status pengajuan berubah menjadi "Accepted"<br>3. Pengajuan ter-assign ke divisi dan mentor yang dipilih<br>4. Peserta menerima notifikasi persetujuan<br>5. Data tersimpan di database dengan benar |
| **Actual Result** | Pengajuan berhasil disetujui dan ter-assign ke divisi serta mentor yang dipilih. Status berubah menjadi "Accepted" dan peserta menerima notifikasi. |
| **Status** | Passed |
| **Notes** | Proses assign divisi dan mentor berjalan dengan baik. |

---

### Test Case TC-007

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-007 |
| **Scenario ID** | SC-04 |
| **Test Case Name** | Tolak Pengajuan Magang oleh Admin |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Ada pengajuan magang dengan status "Pending" |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Pengajuan" atau "Applications"<br>3. Pilih pengajuan yang akan ditolak<br>4. Klik tombol "Tolak" atau "Reject"<br>5. Isi alasan penolakan<br>6. Konfirmasi penolakan |
| **Test Data** | Application ID: APP002<br>Reason: "Dokumen tidak lengkap" |
| **Expected Result** | 1. Pengajuan berhasil ditolak<br>2. Status pengajuan berubah menjadi "Rejected"<br>3. Alasan penolakan tersimpan<br>4. Peserta menerima notifikasi penolakan<br>5. Peserta dapat melihat alasan penolakan di dashboard |
| **Actual Result** | Pengajuan berhasil ditolak dengan status "Rejected". Alasan penolakan tersimpan dan peserta menerima notifikasi. |
| **Status** | Passed |
| **Notes** | Proses penolakan berjalan dengan baik dan alasan penolakan dapat dilihat oleh peserta. |

---

### Test Case TC-008

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-008 |
| **Scenario ID** | SC-06 |
| **Test Case Name** | Upload Surat Penerimaan oleh Admin |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Ada pengajuan yang sudah disetujui (status "Accepted") |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Daftar Peserta"<br>3. Pilih peserta yang pengajuannya sudah disetujui<br>4. Klik "Upload Surat Penerimaan"<br>5. Pilih file PDF surat penerimaan<br>6. Klik tombol "Upload" |
| **Test Data** | Application ID: APP001<br>File: surat_penerimaan.pdf |
| **Expected Result** | 1. Surat penerimaan berhasil diupload<br>2. File tersimpan di storage sistem<br>3. File dapat dilihat dan didownload<br>4. Peserta dapat download surat di menu profil peserta<br>5. File tersimpan dengan format yang benar |
| **Actual Result** | Surat penerimaan berhasil diupload dan tersimpan di sistem. Peserta dapat melihat dan mendownload surat di menu profil peserta mereka. |
| **Status** | Passed |
| **Notes** | Upload surat penerimaan dilakukan secara manual oleh admin melalui menu Peserta. |

---

### Test Case TC-010

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-010 |
| **Scenario ID** | SC-07 |
| **Test Case Name** | Buat Penugasan Baru oleh Pembimbing |
| **Pre-conditions** | 1. User sudah login sebagai Pembimbing<br>2. Ada peserta yang aktif di divisi pembimbing tersebut |
| **Test Steps** | 1. Login sebagai Pembimbing<br>2. Buka menu "Penugasan & Penilaian "<br>3. Klik tombol "Buat Tugas Baru"<br>4. Isi form penugasan:<br>   - Pilih peserta<br>   - Pilih jenis tugas<br>   - Judul penugasan<br>   - Deskripsi<br>   - Deadline<br>   - File pendukung (opsional)<br>   - Tanggal Presentasi (untuk Tugas Proyek)<br>5. Klik tombol "Simpan" |
| **Test Data** | Peserta: John Doe<br>Jenis Tugas: Tugas harian<br>Judul: Analisis Sistem Informasi<br>Deskripsi: "Buat analisis sistem informasi yang digunakan di divisi"<br>Deadline: 2024-02-15<br>File: [file pendukung opsional] |
| **Expected Result** | 1. Penugasan berhasil dibuat<br>2. Status penugasan "Assigned"<br>3. Peserta menerima notifikasi penugasan baru<br>4. Penugasan muncul di dashboard peserta<br>5. Data tersimpan di database |
| **Actual Result** | Penugasan berhasil dibuat dengan judul "Analisis Sistem Informasi" untuk peserta John Doe. Status penugasan menjadi "Assigned". Peserta menerima notifikasi penugasan baru dan penugasan muncul di dashboard peserta. Data tersimpan di database dengan benar. |
| **Status** | Passed |
| **Notes** | Proses pembuatan penugasan berjalan dengan baik dan notifikasi terkirim dengan benar. |

---

### Test Case TC-011

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-011 |
| **Scenario ID** | SC-07 |
| **Test Case Name** | Submit Tugas oleh Peserta |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Ada penugasan yang belum disubmit<br>3. Peserta sudah menyelesaikan tugas |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Tugas"<br>3. Pilih penugasan yang akan disubmit<br>4. Klik tombol "Submit Tugas"<br>5. Upload file jawaban<br>6. Klik tombol "Submit" |
| **Test Data** | Assignment ID: [ID penugasan]<br>File Jawaban: [file PDF/doc hasil tugas]<br>Notes: "Tugas sudah selesai dikerjakan" |
| **Expected Result** | 1. Tugas berhasil disubmit<br>2. Status penugasan berubah menjadi "Submitted"<br>3. File tersimpan di storage<br>4. Pembimbing menerima notifikasi<br>5. Pembimbing dapat melihat dan menilai tugas |
| **Actual Result** | Tugas berhasil disubmit dengan file jawaban dan catatan. Status penugasan berubah menjadi "Submitted". File tersimpan di storage dengan benar. Pembimbing menerima notifikasi dan dapat melihat serta menilai tugas. |
| **Status** | Passed |
| **Notes** | Proses submit tugas berjalan dengan baik dan file tersimpan dengan benar. |

---

### Test Case TC-012

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-012 |
| **Scenario ID** | SC-07 |
| **Test Case Name** | Beri Nilai Tugas oleh Pembimbing |
| **Pre-conditions** | 1. User sudah login sebagai Pembimbing<br>2. Ada tugas yang sudah disubmit oleh peserta |
| **Test Steps** | 1. Login sebagai Pembimbing<br>2. Buka menu "Penugasan & Penilaian"<br>3. Pilih tugas yang sudah disubmit<br>4. Review file jawaban<br>5. Klik tombol "Beri Nilai"<br>6. Masukkan nilai (0-10)<br>7. Isi feedback (opsional)<br>8. Klik tombol "Simpan" |
| **Test Data** | Assignment ID: [ID penugasan]<br>Nilai: 85<br>Feedback: "Hasil bagus, namun perlu perbaikan pada bagian analisis" |
| **Expected Result** | 1. Nilai berhasil disimpan<br>2. Status penugasan berubah menjadi "Graded"<br>3. Peserta menerima notifikasi nilai<br>4. Peserta dapat melihat nilai dan feedback di dashboard |
| **Actual Result** | Nilai 85 berhasil disimpan dengan feedback yang diberikan. Status penugasan berubah menjadi "Graded". Peserta menerima notifikasi nilai dan dapat melihat nilai serta feedback di dashboard mereka. |
| **Status** | Passed |
| **Notes** | Proses pemberian nilai berjalan dengan baik dan feedback tersimpan dengan benar. |

---

### Test Case TC-013

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-013 |
| **Scenario ID** | SC-07 |
| **Test Case Name** | Set Tugas untuk Revisi |
| **Pre-conditions** | 1. User sudah login sebagai Pembimbing<br>2. Ada tugas yang sudah disubmit |
| **Test Steps** | 1. Login sebagai Pembimbing<br>2. Buka menu "Penugasan"<br>3. Pilih tugas yang akan direvisi<br>4. Klik tombol "Set Revisi"<br>5. Isi catatan revisi<br>6. Klik tombol "Simpan" |
| **Test Data** | Assignment ID: [ID penugasan]<br>Revision Notes: "Perlu perbaikan pada bagian kesimpulan dan tambahkan referensi" |
| **Expected Result** | 1. Status penugasan berubah menjadi "Revision Required"<br>2. Peserta menerima notifikasi revisi<br>3. Peserta dapat melihat catatan revisi<br>4. Peserta dapat submit ulang setelah revisi |
| **Actual Result** | Status penugasan berhasil diubah menjadi "Revision Required" dengan catatan revisi yang jelas. Peserta menerima notifikasi revisi dan dapat melihat catatan revisi di dashboard. Peserta dapat melakukan submit ulang setelah melakukan revisi. |
| **Status** | Passed |
| **Notes** | Proses set revisi berjalan dengan baik dan peserta dapat melihat catatan revisi dengan jelas. |

---

### Test Case TC-014

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-014 |
| **Scenario ID** | SC-08 |
| **Test Case Name** | Check-in Absensi Harian |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Pengajuan sudah diterima dan peserta aktif<br>3. Belum melakukan check-in hari ini |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Absensi"<br>3. Klik tombol "Check-in"<br>4. Ambil gambar melalui pop-up kamera<br>5. Klik tombol "Kirim absensi" |
| **Test Data** | Date: [tanggal hari ini]<br>Time: [waktu check-in]<br>Foto absensi: [file foto] |
| **Expected Result** | 1. Check-in berhasil<br>2. Data absensi tersimpan dengan status "Present"<br>3. Waktu check-in tercatat<br>4. Menampilkan konfirmasi sukses<br>5. Data absensi muncul di daftar absensi |
| **Actual Result** | Check-in berhasil dilakukan dan data absensi tersimpan dengan status "Present". Waktu check-in tercatat dengan akurat. Sistem menampilkan konfirmasi sukses dan data absensi muncul di daftar absensi. |
| **Status** | Passed |
| **Notes** | Proses check-in berjalan dengan baik dan waktu tercatat dengan akurat. |

---

### Test Case TC-015

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-015 |
| **Scenario ID** | SC-08 |
| **Test Case Name** | Absen (Ketidakhadiran) |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Peserta tidak hadir pada hari tertentu |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Absensi"<br>3. Klik tombol "Absen" atau "Absent"<br>4. Isi alasan ketidakhadiran<br>5. Upload bukti ketidakhadiran<br>6. Klik tombol "Submit" |
| **Test Data** | Date: 2024-01-20<br>Reason: "Sakit"<br>Bukti ketidakhadiran: [file bukti] |
| **Expected Result** | 1. Absen berhasil dicatat<br>2. Status absensi "Absent"<br>3. Alasan tersimpan<br>4. Data muncul di daftar absensi<br>5. Pembimbing dapat melihat absensi |
| **Actual Result** | Absen berhasil dicatat dengan status "Absent" dan alasan "Sakit" tersimpan dengan benar. Data muncul di daftar absensi dan pembimbing dapat melihat absensi tersebut. |
| **Status** | Passed |
| **Notes** | Proses pencatatan absen berjalan dengan baik dan alasan tersimpan dengan benar. |

---

### Test Case TC-016

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-016 |
| **Scenario ID** | SC-09 |
| **Test Case Name** | Input Logbook Harian |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Peserta aktif magang |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Logbook"<br>3. Klik tombol "Tambah Logbook" atau "Add Entry"<br>4. Isi form logbook:<br>   - Tanggal<br>   - Aktivitas yang dilakukan<br>5. Klik tombol "Simpan" |
| **Test Data** | Date: 2024-01-15<br>Aktivitas: "Mempelajari sistem informasi perusahaan"<br> |
| **Expected Result** | 1. Logbook berhasil disimpan<br>2. Data muncul di daftar logbook<br>3. Pembimbing dapat melihat logbook<br>4. Data tersimpan di database |
| **Actual Result** | Logbook harian berhasil disimpan dengan data aktivitas yang lengkap. Data muncul di daftar logbook dan pembimbing dapat melihat logbook tersebut. Data tersimpan di database dengan benar. |
| **Status** | Passed |
| **Notes** | Proses input logbook berjalan dengan baik dan data tersimpan dengan lengkap. |

---

### Test Case TC-017

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-017 |
| **Scenario ID** | SC-09 |
| **Test Case Name** | Edit Logbook |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Ada logbook yang sudah dibuat sebelumnya |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Logbook"<br>3. Pilih logbook yang akan diedit<br>4. Klik tombol "Edit"<br>5. Ubah data yang diperlukan<br>6. Klik tombol "Simpan" |
| **Test Data** | Logbook ID: [ID logbook]<br>Updated Aktivitas: "Mempelajari sistem informasi dan membuat dokumentasi" |
| **Expected Result** | 1. Logbook berhasil diupdate<br>2. Perubahan tersimpan<br>3. Data terupdate di daftar logbook |
| **Actual Result** | Logbook berhasil diupdate dengan perubahan aktivitas yang baru. Perubahan tersimpan dengan benar dan data terupdate di daftar logbook. |
| **Status** | Passed |
| **Notes** | Proses edit logbook berjalan dengan baik dan perubahan tersimpan dengan benar. |

---

### Test Case TC-018

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-018 |
| **Scenario ID** | SC-10 |
| **Test Case Name** | Upload Sertifikat oleh Admin |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Peserta sudah menyelesaikan periode magang |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Daftar Peserta Magang"<br>3. Pilih peserta yang akan diberikan sertifikat<br>4. Klik "Upload Sertifikat" atau "Upload Certificate"<br>5. Pilih file PDF sertifikat<br>6. Klik tombol "Upload" |
| **Test Data** | User ID: USR001<br>File: sertifikat_magang.pdf |
| **Expected Result** | 1. Sertifikat berhasil diupload<br>2. File sertifikat tersimpan di sistem<br>3. File dapat dilihat dan didownload<br>4. Peserta dapat download sertifikat dari dashboard<br>5. Format sertifikat sesuai standar |
| **Actual Result** | Sertifikat berhasil diupload dan tersimpan di sistem. Peserta dapat melihat dan mendownload sertifikat dari dashboard mereka. |
| **Status** | Passed |
| **Notes** | Upload sertifikat dilakukan secara manual oleh admin melalui menu Peserta. |

---

### Test Case TC-019

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-019 |
| **Scenario ID** | SC-11 |
| **Test Case Name** | Download Sertifikat oleh Peserta |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Sertifikat sudah diupload oleh admin<br>3. Peserta sudah mengakhiri masa magang |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Sertifikat" atau "Certificates"<br>3. Pilih sertifikat yang akan didownload<br>4. Klik tombol "Download" |
| **Test Data** | Certificate ID: CERT001 |
| **Expected Result** | 1. File sertifikat berhasil didownload<br>2. File dalam format PDF<br>3. File dapat dibuka dan dicetak<br>4. Isi sertifikat sesuai dengan data peserta |
| **Actual Result** | File sertifikat berhasil didownload dalam format PDF. File dapat dibuka dan dicetak dengan benar. |
| **Status** | Passed |
| **Notes** | Download sertifikat berjalan dengan baik dan file dapat diakses dengan benar. |

---

### Test Case TC-020

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-020 |
| **Scenario ID** | SC-12 |
| **Test Case Name** | Tambah Divisi Baru |
| **Pre-conditions** | 1. User sudah login sebagai Admin |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Divisi" atau "Divisions"<br>3. Klik "Tambah Divisi"<br>4. Isi form:<br>   - Nama Divisi<br>   - Tambahkan minimal 1 pembimbing (nama dan NIK)<br>   - Status aktif/nonaktif (opsional)<br>   - Sort order (opsional)<br>5. Klik tombol "Simpan" |
| **Test Data** | Nama Divisi: Divisi Pengembangan Sistem<br>Pembimbing 1: Nama: Dr. Ahmad Rizki, NIK: 123456<br>Pembimbing 2: Nama: Dr. Siti Nurhaliza, NIK: 234567 |
| **Expected Result** | 1. Divisi berhasil ditambahkan<br>2. Data tersimpan di database<br>3. Divisi muncul di daftar<br>4. Pembimbing terdaftar untuk divisi tersebut<br>5. Dapat digunakan untuk pengajuan magang |
| **Actual Result** | Divisi berhasil ditambahkan dengan nama "Divisi Pengembangan Sistem". Dua pembimbing berhasil ditambahkan ke divisi tersebut. Divisi muncul di daftar dan dapat digunakan untuk pengajuan magang. |
| **Status** | Passed |
| **Notes** | Sistem memungkinkan lebih dari 1 pembimbing per divisi. Semua pembimbing berhasil terdaftar dengan benar. |

---

### Test Case TC-021

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-021 |
| **Scenario ID** | SC-12 |
| **Test Case Name** | Edit Divisi dan Tambah Pembimbing |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Ada divisi yang sudah dibuat sebelumnya |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Divisi"<br>3. Pilih divisi yang akan diedit<br>4. Klik tombol "Edit"<br>5. Ubah nama divisi atau tambah pembimbing baru<br>6. Klik tombol "Simpan" |
| **Test Data** | Divisi ID: DIV001<br>Nama Divisi Baru: Divisi Teknologi Informasi dan Komunikasi<br>Pembimbing Baru: Nama: Dr. Budi Santoso, NIK: 345678 |
| **Expected Result** | 1. Divisi berhasil diupdate<br>2. Pembimbing baru berhasil ditambahkan<br>3. Data tersimpan di database<br>4. Perubahan muncul di daftar |
| **Actual Result** | Divisi berhasil diupdate dengan nama baru. Pembimbing baru berhasil ditambahkan ke divisi tersebut. Semua perubahan tersimpan dengan benar. |
| **Status** | Passed |
| **Notes** | Sistem memungkinkan penambahan pembimbing baru ke divisi yang sudah ada. |

---

### Test Case TC-022

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-022 |
| **Scenario ID** | SC-13 |
| **Test Case Name** | Tambah Field of Interest Baru |
| **Pre-conditions** | 1. User sudah login sebagai Admin |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Field of Interest" atau "Fields"<br>3. Klik "Tambah Field"<br>4. Isi form:<br>   - Nama Field<br>   - Deskripsi (opsional)<br>5. Klik tombol "Simpan" |
| **Test Data** | Nama Field: Data Science<br>Deskripsi: "Bidang minat untuk data science dan machine learning" |
| **Expected Result** | 1. Field of Interest berhasil ditambahkan<br>2. Data tersimpan di database<br>3. Field muncul di daftar dengan status aktif<br>4. Dapat digunakan dalam registrasi |
| **Actual Result** | Field of Interest "Data Science" berhasil ditambahkan dengan deskripsi yang lengkap. Data tersimpan di database dan field muncul di daftar dengan status aktif. Field dapat digunakan dalam proses registrasi peserta baru. |
| **Status** | Passed |
| **Notes** | Proses penambahan Field of Interest berjalan dengan baik dan dapat digunakan dalam registrasi. |

---

### Test Case TC-023

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-023 |
| **Scenario ID** | SC-15 |
| **Test Case Name** | Generate Laporan Peserta dengan Filter |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Ada data peserta magang di sistem |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Reports" atau "Laporan"<br>3. Pilih filter:<br>   - Tahun<br>   - Periode<br>   - Divisi<br>4. Klik tombol "Generate Report" atau "Tampilkan" |
| **Test Data** | Tahun: 2024<br>Periode: Semester 1<br>Divisi: Semua Divisi<br>Status: Semua Status |
| **Expected Result** | 1. Laporan berhasil di-generate<br>2. Data sesuai dengan filter yang dipilih<br>3. Tabel menampilkan data peserta<br>4. Data dapat di-export ke PDF atau Excel |
| **Actual Result** | Laporan peserta magang berhasil di-generate dengan filter tahun 2024, semester 1, semua divisi, dan semua status. Data yang ditampilkan sesuai dengan filter yang dipilih. Tabel menampilkan data peserta dengan lengkap dan data dapat di-export ke PDF atau Excel. |
| **Status** | Passed |
| **Notes** | Fitur generate laporan dengan filter berjalan dengan baik dan data yang ditampilkan akurat. |

---

### Test Case TC-024

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-024 |
| **Scenario ID** | SC-15 |
| **Test Case Name** | Export Laporan ke PDF |
| **Pre-conditions** | 1. User sudah login sebagai Admin<br>2. Laporan sudah di-generate |
| **Test Steps** | 1. Login sebagai Admin<br>2. Buka menu "Reports"<br>3. Generate laporan dengan filter tertentu<br>4. Klik tombol "Export PDF" |
| **Test Data** | Filter: Tahun 2024, Semua Divisi |
| **Expected Result** | 1. File PDF berhasil di-generate<br>2. File berhasil didownload<br>3. Format PDF sesuai standar<br>4. Data lengkap dan dapat dibaca |
| **Actual Result** | File PDF laporan berhasil di-generate dan didownload dengan format yang sesuai standar. Data dalam PDF lengkap dan dapat dibaca dengan baik. Format PDF rapi dan profesional. |
| **Status** | Passed |
| **Notes** | Fitur export ke PDF berjalan dengan baik dan format sesuai standar. |

---

### Test Case TC-025

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-025 |
| **Scenario ID** | SC-17 |
| **Test Case Name** | View Dashboard Admin |
| **Pre-conditions** | 1. User sudah login sebagai Admin |
| **Test Steps** | 1. Login sebagai Admin<br>2. Redirect ke dashboard admin (/admin/dashboard)<br>3. Verifikasi tampilan dashboard |
| **Test Data** | Role: Admin |
| **Expected Result** | 1. Dashboard menampilkan:<br>   - Statistik peserta<br>   - Statistik pengajuan<br>   - Menu navigasi<br>   - Data terbaru<br>2. Semua menu dapat diakses<br>3. Data real-time dan akurat |
| **Actual Result** | Dashboard admin menampilkan statistik peserta dan pengajuan dengan lengkap. Menu navigasi dapat diakses dengan baik dan data terbaru ditampilkan. Semua menu dapat diakses dan data yang ditampilkan real-time dan akurat. |
| **Status** | Passed |
| **Notes** | Dashboard admin berfungsi dengan baik dan menampilkan informasi yang diperlukan. |

---

### Test Case TC-026

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-026 |
| **Scenario ID** | SC-18 |
| **Test Case Name** | Change Password |
| **Pre-conditions** | 1. User sudah login |
| **Test Steps** | 1. Login sebagai user<br>2. Buka menu "Profil"<br>3. Masukkan password lama<br>4. Masukkan password baru<br>5. Konfirmasi password baru<br>6. Klik tombol "Update" atau "Simpan" |
| **Test Data** | Current Password: [password lama]<br>New Password: newpassword123<br>Confirm Password: newpassword123 |
| **Expected Result** | 1. Password berhasil diubah<br>2. Menampilkan pesan sukses<br>3. User dapat login dengan password baru<br>4. User tidak dapat login dengan password lama |
| **Actual Result** | Password berhasil diubah dari password lama ke "newpassword123". Sistem menampilkan pesan sukses. User dapat login dengan password baru dan tidak dapat login lagi dengan password lama. |
| **Status** | Passed |
| **Notes** | Proses perubahan password berjalan dengan baik dan keamanan terjaga. |

---

### Test Case TC-027

| Field | Value |
|-------|-------|
| **Test Case ID** | TC-027 |
| **Scenario ID** | SC-19 |
| **Test Case Name** | Re-application Magang |
| **Pre-conditions** | 1. User sudah login sebagai Peserta<br>2. Peserta pernah mengajukan magang sebelumnya (ditolak atau selesai) |
| **Test Steps** | 1. Login sebagai Peserta<br>2. Buka menu "Re-apply" atau "Ajukan Ulang"<br>3. Pilih bidang peminatan baru atau bidang peminatan yang sama<br>4. Isi form pengajuan ulang<br>5. Upload dokumen yang diperlukan<br>6. Klik tombol "Submit" |
| **Test Data** | Bidang: Digital Bisnis<br>KTM: [file KTM baru]<br>CV: [file CV]<br>Surat Permohonan: [file PDF]<br>Surat Berkelakuan Baik: [file PDF]<br>Start Date: 2024-07-01<br>End Date: 2024-09-30 |
| **Expected Result** | 1. Pengajuan ulang berhasil<br>2. Status menjadi "Pending"<br>3. Data pengajuan baru tersimpan<br>4. Pembimbing menerima notifikasi |
| **Actual Result** | Pengajuan ulang magang berhasil dilakukan dengan bidang peminatan dan dokumen permohonan yang baru. Status pengajuan menjadi "Pending". Data pengajuan baru tersimpan di database dan admin menerima notifikasi pengajuan baru. |
| **Status** | Passed |
| **Notes** | Proses re-application berjalan dengan baik dan peserta dapat mengajukan magang ulang setelah pengajuan sebelumnya ditolak atau selesai. |

---

## 6. UAT Summary Report

### 6.1. Test Execution Summary

| Metric | Value |
|--------|-------|
| **Total Test Cases** | 27 |
| **Test Cases Executed** | 27 |
| **Test Cases Passed** | 27 |
| **Test Cases Failed** | 0 |
| **Test Cases Blocked** | 0 |
| **Pass Rate** | 100% |
| **Fail Rate** | 0% |
| **UAT Start Date** | 15 Januari 2024 |
| **UAT End Date** | 25 Januari 2024 |
| **Duration** | 10 hari |

### 6.2. Test Results by Module

| Module | Total TC | Passed | Failed | Blocked | Pass Rate |
|--------|----------|--------|--------|---------|-----------|
| **Authentication** | 3 | 3 | 0 | 0 | 100% |
| **Registration** | 1 | 1 | 0 | 0 | 100% |
| **Internship Application** | 3 | 3 | 0 | 0 | 100% |
| **Assignment Management** | 4 | 4 | 0 | 0 | 100% |
| **Attendance** | 2 | 2 | 0 | 0 | 100% |
| **Logbook** | 2 | 2 | 0 | 0 | 100% |
| **Certificate Management** | 2 | 2 | 0 | 0 | 100% |
| **Division Management** | 2 | 2 | 0 | 0 | 100% |
| **Field Management** | 1 | 1 | 0 | 0 | 100% |
| **Reporting** | 2 | 2 | 0 | 0 | 100% |
| **Dashboard** | 1 | 1 | 0 | 0 | 100% |
| **Other Features** | 4 | 4 | 0 | 0 | 100% |
| **TOTAL** | 27 | 27 | 0 | 0 | 100% |

### 6.3. Critical Issues Found

| Issue ID | Description | Severity | Module | Status | Assigned To |
|----------|-------------|----------|--------|--------|-------------|
| - | Tidak ada critical issues ditemukan | - | - | - | - |

**Severity Levels:**
- **Critical**: Issue yang menghalangi fungsi utama sistem, harus diperbaiki sebelum Go Live
- **High**: Issue yang mempengaruhi fungsi penting, harus diperbaiki segera
- **Medium**: Issue yang mempengaruhi beberapa fitur, dapat diperbaiki setelah Go Live
- **Low**: Issue minor, dapat diperbaiki dalam maintenance

### 6.4. High Priority Issues

| Issue ID | Description | Severity | Module | Status | Assigned To |
|----------|-------------|----------|--------|--------|-------------|
| - | Tidak ada high priority issues ditemukan | - | - | - | - |

### 6.5. Medium and Low Priority Issues

| Issue ID | Description | Severity | Module | Status | Assigned To |
|----------|-------------|----------|--------|--------|-------------|
| - | Tidak ada medium/low priority issues ditemukan | - | - | - | - |

### 6.6. Risks Identified

| Risk ID | Risk Description | Impact | Probability | Mitigation Plan |
|---------|------------------|--------|-------------|-----------------|
| RISK-001 | Potensi beban tinggi pada server saat banyak peserta melakukan check-in bersamaan | Medium | Low | Implementasi queue system dan monitoring performa server secara berkala |
| RISK-002 | Risiko kehilangan data jika backup tidak dilakukan secara rutin | High | Low | Implementasi automated backup harian dan testing restore procedure secara berkala |

### 6.7. Recommendations

Berdasarkan hasil pengujian UAT yang telah dilakukan, berikut adalah rekomendasi terkait keputusan terhadap sistem:

#### 6.7.1. Rekomendasi Utama

**A. Sistem Siap untuk Go Live (Production Ready)**
- Semua test cases critical dan high priority telah passed
- Tidak ada critical issues yang menghalangi operasional
- Sistem telah memenuhi semua requirement bisnis utama
- User acceptance telah diberikan oleh Business User/Client Representative

**B. Sistem Belum Siap - Perlu Perbaikan**
- Masih terdapat critical issues yang belum diperbaiki
- Pass rate masih di bawah threshold yang ditetapkan (misalnya < 90%)
- Masih ada fungsi utama yang tidak berjalan dengan baik
- Perlu dilakukan perbaikan dan UAT ulang sebelum Go Live

**C. Sistem Siap dengan Catatan (Conditional Go Live)**
- Sistem secara umum sudah siap, namun ada beberapa medium/low priority issues
- Critical dan high priority issues sudah diperbaiki
- Perlu dibuat action plan untuk perbaikan issues yang tersisa
- Dapat Go Live dengan monitoring ketat dan perbaikan berkelanjutan

**D. Perlu UAT Lanjutan**
- Masih ada area yang belum teruji dengan baik
- Perlu pengujian tambahan untuk fitur tertentu
- Perlu pengujian dengan data volume besar atau skenario khusus

#### 6.7.2. Action Items

| Action Item | Description | Priority | Assigned To | Due Date | Status |
|-------------|-------------|----------|-------------|----------|--------|
| ACT-001 | Implementasi automated backup harian untuk database | High | IT Team | 30 Januari 2024 | Done |
| ACT-002 | Setup monitoring performa server dan alerting system | Medium | IT Team | 5 Februari 2024 | In Progress |
| ACT-003 | Siapkan dokumentasi user manual untuk Admin, Pembimbing, dan Peserta | Medium | Documentation Team | 10 Februari 2024 | In Progress |

#### 6.7.3. Next Steps

1. **Jika Sistem Siap Go Live:**
   - Lakukan final review dengan stakeholder
   - Siapkan deployment plan
   - Siapkan user training (jika diperlukan)
   - Siapkan monitoring dan support plan
   - Tentukan tanggal Go Live

2. **Jika Sistem Perlu Perbaikan:**
   - Prioritaskan perbaikan critical issues
   - Lakukan retest untuk issues yang sudah diperbaiki
   - Lakukan UAT ulang untuk area yang bermasalah
   - Update dokumen UAT setelah perbaikan

3. **Jika Perlu UAT Lanjutan:**
   - Identifikasi area yang perlu pengujian tambahan
   - Buat test cases tambahan
   - Jadwalkan UAT lanjutan
   - Lakukan pengujian sesuai jadwal

### 6.8. Sign-off

| Role | Name | Signature | Date | Approval Status |
|------|------|-----------|------|-----------------|
| **UAT Lead** | Tim UAT | [ ] | 25 Januari 2024 | Approved |
| **Business User / Client Representative** | PT Pos Indonesia | [ ] | 26 Januari 2024 | Approved |
| **Project Manager** | Project Manager | [ ] | 26 Januari 2024 | Approved |
| **QA Lead** | QA Team Lead | [ ] | 25 Januari 2024 | Approved |

**Notes:**
- Approval dari Business User/Client Representative adalah mandatory untuk Go Live
- Jika ada rejection, harus dijelaskan alasan dan action plan

---

## Appendix

### A. Glossary

| Term | Definition |
|------|------------|
| **UAT** | User Acceptance Test - Pengujian yang dilakukan oleh end user untuk memverifikasi bahwa sistem sesuai kebutuhan |
| **2FA** | Two-Factor Authentication - Autentikasi dua faktor untuk meningkatkan keamanan |
| **Go Live** | Tahap dimana sistem di-deploy ke lingkungan produksi dan digunakan oleh pengguna akhir |
| **Critical Issue** | Masalah yang menghalangi fungsi utama sistem |
| **Pass Rate** | Persentase test cases yang berhasil passed dari total test cases yang dijalankan |

### B. References

- Requirement Document Sistem Manajemen Magang PT Pos Indonesia
- Technical Specification Document
- User Manual / User Guide
- Previous UAT Documents (jika ada)

### C. Change Log

| Version | Date | Author | Description |
|--------|------|--------|-------------|
| 1.0 | 15 Januari 2024 | Tim UAT | Initial UAT Document |
| 1.1 | 25 Januari 2024 | Tim UAT | Revisi sesuai dengan aplikasi aktual - Update proses review pengajuan oleh admin, upload sertifikat dan surat penerimaan oleh admin, struktur divisi |

---

**Document Control:**
- **Document Version**: 1.1
- **Last Updated**: 25 Januari 2024
- **Next Review Date**: 25 Februari 2024
- **Status**: Final

