# SOFTWARE REQUIREMENTS SPECIFICATION (SRS)
## SISTEM MANAJEMEN MAGANG BERBASIS WEB

---

## 1. INTRODUCTION

### 1.1. Purpose

Dokumen Software Requirements Specification (SRS) ini dibuat untuk mendokumentasikan spesifikasi kebutuhan perangkat lunak dari Sistem Manajemen Magang Berbasis Web. Dokumen ini menjelaskan secara detail fungsi-fungsi yang harus dimiliki oleh sistem, karakteristik pengguna, lingkungan operasi, dan persyaratan fungsional serta non-fungsional yang harus dipenuhi oleh sistem.

Sistem ini dikembangkan untuk mengatasi permasalahan manajemen program magang yang masih dilakukan secara manual atau semi-digital di PT Telkom Indonesia (Witel Sulbagsel). Sistem ini ditujukan untuk mengotomatisasi dan meningkatkan efisiensi seluruh proses administrasi program magang, mulai dari pengajuan magang hingga penerbitan sertifikat.

Target pengguna utama sistem ini meliputi:
- **Administrator Sistem (Admin)**: Staf administrasi yang bertanggung jawab mengelola keseluruhan sistem dan data peserta magang
- **Pembimbing/Mentor**: Pembimbing yang bertanggung jawab membimbing peserta magang di divisi masing-masing
- **Peserta Magang**: Mahasiswa yang mengikuti program magang di organisasi

Dokumen ini akan digunakan sebagai acuan oleh tim pengembang dalam proses implementasi sistem, oleh tim QA/tester dalam menyusun test cases, dan oleh stakeholder untuk memahami kemampuan dan batasan sistem yang akan dikembangkan.

### 1.2. Intended Readers

Dokumen SRS ini ditujukan untuk berbagai pihak yang terlibat dalam pengembangan dan penggunaan sistem, yaitu:

- **Project Manager**: Untuk memahami scope dan requirement sistem dalam mengelola proyek dan mengalokasikan resources
- **System Analyst**: Sebagai acuan utama dalam menganalisis kebutuhan dan merancang solusi teknis
- **Developer**: Sebagai panduan dalam mengimplementasikan fitur-fitur sistem sesuai dengan spesifikasi yang telah ditetapkan
- **QA/Tester**: Untuk menyusun test plan, test cases, dan melakukan pengujian sistem berdasarkan requirement yang didefinisikan
- **Stakeholder**: Untuk memahami kemampuan, fungsi, dan batasan sistem yang akan dikembangkan
- **Business Analyst**: Untuk memastikan sistem memenuhi kebutuhan bisnis organisasi
- **Technical Writer**: Untuk menyusun dokumentasi pengguna berdasarkan requirement yang ada

### 1.3. Scope of the System

Sistem Manajemen Magang Berbasis Web adalah aplikasi web yang dirancang untuk mengelola seluruh siklus program magang secara terintegrasi dan terdigitalisasi. Sistem ini dibangun menggunakan framework Laravel dengan arsitektur MVC (Model-View-Controller) yang memungkinkan pemisahan yang jelas antara logika bisnis, presentasi, dan data.

Fungsi utama sistem meliputi: (1) manajemen pengajuan magang secara online dengan upload dokumen persyaratan, (2) tracking status pengajuan secara real-time dengan notifikasi otomatis, (3) manajemen dokumen terpusat untuk menyimpan dan mengelola dokumen-dokumen penting seperti CV, KTM, surat permohonan, surat keterangan baik, surat penerimaan, dan sertifikat, (4) sistem manajemen penugasan yang memungkinkan pembimbing memberikan tugas kepada peserta dan melakukan penilaian, (5) sistem absensi digital dengan fitur check-in menggunakan foto dan pencatatan waktu otomatis, (6) modul logbook digital untuk mencatat aktivitas harian peserta magang, (7) sistem otomatisasi pembuatan dokumen untuk surat penerimaan magang dan sertifikat, dan (8) sistem pelaporan yang dapat menghasilkan laporan peserta magang dalam format PDF dan Excel.

User utama sistem terdiri dari Administrator Sistem yang mengelola keseluruhan sistem dan melakukan approval/rejection pengajuan magang, Pembimbing/Mentor yang membimbing peserta magang dan melakukan penilaian, serta Peserta Magang yang mengajukan magang dan mengikuti program magang.

Dengan adanya sistem ini, organisasi dapat memperoleh berbagai manfaat, antara lain: (1) peningkatan efisiensi operasional dengan mengurangi waktu proses administrasi magang dari rata-rata 2-3 minggu menjadi maksimal 1 minggu, (2) peningkatan kualitas program magang melalui proses yang lebih cepat, transparan, dan terstruktur, (3) peningkatan akurasi data melalui sistem terpusat dan terdigitalisasi dengan target akurasi mencapai 95%, (4) peningkatan transparansi dengan memberikan visibilitas yang jelas kepada semua stakeholder mengenai status dan progress program magang secara real-time, (5) peningkatan kepatuhan administratif dengan memastikan semua dokumen dan proses sesuai dengan standar dan regulasi yang berlaku, dan (6) pengurangan biaya operasional melalui digitalisasi proses dengan target penghematan biaya operasional hingga 30%.

---

## 2. OVERALL DESCRIPTION

### 2.1. Product Perspective

Sistem Manajemen Magang Berbasis Web merupakan sistem **standalone** yang beroperasi secara independen tanpa memerlukan integrasi dengan sistem eksternal lainnya. Sistem ini dibangun sebagai aplikasi web yang dapat diakses melalui browser dan tidak memerlukan instalasi khusus di sisi client.

Meskipun sistem ini standalone, sistem memiliki beberapa dependensi eksternal untuk fungsi-fungsi tertentu, yaitu: (1) **File Storage System** untuk menyimpan dokumen-dokumen yang diunggah oleh pengguna, dan (2) **PDF Generation Library** (DomPDF) dan **Excel Export Library** (Maatwebsite Excel) untuk menghasilkan laporan.

Sistem ini dapat diintegrasikan dengan sistem eksternal di masa depan melalui API, namun integrasi tersebut tidak termasuk dalam scope pengembangan saat ini. Sistem dirancang dengan arsitektur yang modular sehingga memungkinkan penambahan fitur atau integrasi dengan sistem lain di kemudian hari tanpa mengganggu fungsi-fungsi yang sudah ada.

**Diagram Konteks Sistem:**

```
                    ┌─────────────────────────────────┐
                    │                                 │
                    │   Sistem Manajemen Magang       │
                    │         (Web Application)        │
                    │                                 │
                    └─────────────────────────────────┘
                              │         │         │
                              │         │         │
                    ┌─────────┘         │         └─────────┐
                    │                   │                   │
                    ▼                   ▼                   ▼
                    ┌──────────────┐   ┌──────────────┐
                    │   File       │   │   Database   │
                    │   Storage    │   │   (SQLite/   │
                    │              │   │   MySQL)     │
                    └──────────────┘   └──────────────┘
                    │
                    │
                    ▼
            ┌──────────────┐
            │   Users      │
            │  (Browser)   │
            └──────────────┘
```

### 2.2. Product Functions

Sistem Manajemen Magang Berbasis Web menyediakan fungsi-fungsi utama berikut:

1. **Manajemen Autentikasi dan Pengguna**
   - Sistem registrasi dan login pengguna dengan validasi
   - Manajemen role pengguna (Admin, Mentor/Pembimbing, Peserta)
   - Two-Factor Authentication (2FA) untuk Mentor dan Peserta
   - Manajemen profil pengguna
   - Reset password dan perubahan password

2. **Manajemen Organisasi**
   - Manajemen divisi
   - Manajemen bidang peminatan (Field of Interest)
   - Manajemen pembimbing per divisi

3. **Manajemen Pengajuan Magang**
   - Form pengajuan magang online
   - Upload dokumen persyaratan (CV, KTM, Surat Permohonan, Surat Keterangan Baik)
   - Tracking status pengajuan secara real-time
   - Proses approval/rejection oleh Admin
   - Notifikasi status pengajuan dalam aplikasi
   - Fitur pengajuan ulang untuk peserta yang pernah mengajukan sebelumnya

4. **Manajemen Dokumen**
   - Upload dan download dokumen
   - Penyimpanan dokumen terpusat
   - Preview dokumen
   - Upload surat penerimaan magang (Acceptance Letter) oleh Admin
   - Upload sertifikat magang oleh Admin
   - Upload dokumen tambahan jika diperlukan

5. **Manajemen Penugasan dan Penilaian**
   - Pembuatan penugasan oleh Mentor
   - Pengumpulan tugas oleh Peserta
   - Penilaian dan feedback oleh Mentor
   - Sistem revisi tugas
   - Notifikasi deadline tugas
   - Tracking status penugasan

6. **Sistem Absensi Digital**
   - Check-in dengan foto dan timestamp otomatis
   - Absensi dengan alasan dan bukti dokumen
   - Monitoring absensi oleh Mentor dan Admin
   - Laporan absensi per periode
   - Statistik kehadiran

7. **Logbook Digital**
   - Pencatatan aktivitas harian peserta
   - Review logbook oleh Mentor
   - Filter dan pencarian logbook berdasarkan tanggal
   - Edit dan hapus entri logbook
   - Export logbook ke PDF (jika diperlukan)

8. **Sistem Pelaporan**
   - Laporan peserta magang dengan filter berdasarkan periode, divisi, dan status
   - Laporan penilaian oleh Mentor
   - Export laporan ke PDF dan Excel
   - Dashboard statistik dan analitik
   - Grafik dan visualisasi data

9. **Manajemen Sertifikat**
   - Pembuatan sertifikat dengan template otomatis
   - Upload sertifikat oleh admin/pembimbing
   - Download sertifikat oleh peserta
   - Tracking download sertifikat

10. **Dashboard dan Monitoring**
    - Dashboard khusus untuk setiap role (Admin, Mentor, Peserta)
    - Statistik real-time
    - Grafik dan visualisasi data
    - Notifikasi dan alert
    - Overview status pengajuan, penugasan, absensi, dan logbook

### 2.3. User Classes and Characteristics

Sistem ini memiliki tiga kelas pengguna utama dengan karakteristik dan kebutuhan yang berbeda:

**1. Administrator Sistem (Admin)**
- **Definisi**: Staf administrasi yang bertanggung jawab mengelola keseluruhan sistem dan data peserta magang
- **Karakteristik**: 
  - Memiliki akses penuh terhadap semua fitur dan data dalam sistem
  - Tidak wajib menggunakan Two-Factor Authentication (2FA)
  - Memiliki pengetahuan teknis yang lebih baik dibandingkan pengguna lain
- **Fungsi Utama**:
  - Mengelola divisi
  - Mengelola bidang peminatan (Field of Interest)
  - Melakukan approval/rejection pengajuan magang
  - Mengelola data peserta dan pembimbing
  - Membuat dan mengunduh laporan peserta magang
  - Mengelola aturan dan konfigurasi sistem
  - Melihat statistik dan dashboard analitik
  - Mengelola absensi dan logbook semua peserta
  - Mengunggah surat penerimaan dan sertifikat

**2. Pembimbing/Mentor**
- **Definisi**: Pembimbing yang bertanggung jawab membimbing peserta magang di divisi masing-masing
- **Karakteristik**:
  - Wajib menggunakan Two-Factor Authentication (2FA) untuk keamanan akun
  - Hanya dapat melihat dan mengelola data peserta yang menjadi bimbingannya
  - Memiliki akses terbatas terhadap fitur administrasi
- **Fungsi Utama**:
  - Memberikan penugasan kepada peserta magang
  - Melakukan penilaian terhadap tugas peserta
  - Memantau absensi dan logbook peserta
  - Membuat laporan penilaian peserta
  - Melihat dashboard dan statistik peserta bimbingannya

**3. Peserta Magang**
- **Definisi**: Mahasiswa yang mengikuti program magang di organisasi
- **Karakteristik**:
  - Wajib menggunakan Two-Factor Authentication (2FA) untuk keamanan akun
  - Hanya dapat melihat dan mengelola data miliknya sendiri
  - Memiliki pengetahuan teknis yang bervariasi
- **Fungsi Utama**:
  - Mengajukan magang ke divisi yang diinginkan
  - Mengunggah dokumen persyaratan
  - Melihat status pengajuan magang
  - Menerima dan mengerjakan penugasan
  - Melakukan check-in absensi harian
  - Mencatat logbook aktivitas harian
  - Mengunduh surat penerimaan dan sertifikat
  - Melihat dashboard dan statistik pribadi

### 2.4. Operating Environment

Sistem Manajemen Magang Berbasis Web dirancang untuk beroperasi dalam lingkungan berikut:

**Platform Aplikasi:**
- **Tipe**: Web Application (Browser-based)
- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: HTML5, CSS3, JavaScript, Laravel Blade Template Engine
- **Backend**: PHP 8.2 atau lebih tinggi
- **Database**: SQLite (development), MySQL 5.7+ atau PostgreSQL 10+ (production)

**Sistem Operasi Server:**
- Linux (Ubuntu 20.04+, CentOS 7+, atau distribusi Linux lainnya)
- Windows Server 2016+ (untuk development/testing)
- macOS (untuk development)

**Web Server:**
- Apache 2.4+ dengan mod_rewrite enabled
- Nginx 1.18+ (alternatif)
- PHP-FPM untuk optimalisasi performa

**Browser yang Didukung:**
- Google Chrome (versi terbaru dan 2 versi sebelumnya)
- Mozilla Firefox (versi terbaru dan 2 versi sebelumnya)
- Microsoft Edge (versi terbaru dan 2 versi sebelumnya)
- Safari (versi terbaru untuk macOS dan iOS)
- Opera (versi terbaru)

**Responsive Design:**
- Desktop: Resolusi minimal 1024x768 pixels
- Tablet: Resolusi 768x1024 pixels (portrait) dan 1024x768 pixels (landscape)
- Mobile: Resolusi minimal 320x568 pixels (iPhone SE) hingga 414x896 pixels (iPhone 11 Pro Max)

**Hosting Requirements:**
- **Minimum**: 
  - CPU: 2 cores
  - RAM: 2GB
  - Storage: 20GB (termasuk database dan file storage)
  - Bandwidth: 100GB/bulan
- **Recommended**:
  - CPU: 4 cores
  - RAM: 4GB
  - Storage: 50GB
  - Bandwidth: 500GB/bulan

**Dependencies Eksternal:**
- **File Storage**: Local file system atau cloud storage (opsional untuk production)
- **PDF Generation**: DomPDF library (barryvdh/laravel-dompdf) untuk generate laporan
- **Excel Export**: Maatwebsite Excel library (maatwebsite/excel) untuk export laporan
- **Two-Factor Authentication**: Google2FA library (pragmarx/google2fa)
- **QR Code**: SimpleSoftwareIO QR Code library

**Requirements AI/ML:**
- Sistem ini tidak menggunakan teknologi Artificial Intelligence atau Machine Learning dalam implementasinya.

**Network Requirements:**
- Koneksi internet stabil untuk akses aplikasi
- HTTPS enabled untuk keamanan data (SSL/TLS certificate)
- Firewall configuration untuk melindungi server dari akses tidak sah

### 2.5. Design and Implementation Constraints

Sistem Manajemen Magang Berbasis Web dikembangkan dengan berbagai batasan dan constraint sebagai berikut:

**1. Regulasi dan Compliance:**
- Sistem harus mematuhi **Undang-Undang Perlindungan Data Pribadi (UU PDP)** Indonesia terkait pengelolaan data pribadi peserta magang
- Sistem harus mengimplementasikan prinsip-prinsip keamanan data sesuai dengan standar keamanan informasi
- Dokumen yang dihasilkan harus sesuai dengan format dan standar yang berlaku di organisasi
- Sistem harus menyediakan audit trail untuk tracking perubahan data penting

**2. Hardware/Software Constraints:**
- Sistem harus dapat berjalan pada server dengan spesifikasi minimum yang telah ditetapkan
- Sistem tidak memerlukan hardware khusus atau perangkat tambahan
- Sistem harus kompatibel dengan berbagai browser modern tanpa memerlukan plugin tambahan
- Sistem tidak memerlukan instalasi software khusus di sisi client

**3. Framework dan Technology Stack:**
- Sistem harus dibangun menggunakan **Laravel Framework versi 12** atau lebih tinggi
- Sistem harus menggunakan **PHP versi 8.2** atau lebih tinggi
- Sistem harus menggunakan **Blade Template Engine** untuk rendering view
- Sistem harus menggunakan **Eloquent ORM** untuk interaksi database
- Sistem harus menggunakan **Composer** untuk dependency management

**4. Aturan Keamanan:**
- Semua password harus di-hash menggunakan algoritma bcrypt atau argon2
- Sistem harus mengimplementasikan **CSRF protection** untuk semua form submission
- Sistem harus mengimplementasikan **XSS protection** melalui input validation dan output escaping
- Sistem harus mengimplementasikan **SQL injection protection** melalui penggunaan parameterized queries
- Sistem harus menggunakan **HTTPS** untuk semua komunikasi antara client dan server
- Sistem harus mengimplementasikan **session management** yang aman dengan timeout otomatis
- Sistem harus mengimplementasikan **rate limiting** untuk mencegah brute force attack
- Data sensitif harus dienkripsi saat disimpan di database

**5. Database Constraints:**
- Database harus mendukung foreign key constraints untuk menjaga integritas data
- Database harus mendukung transactions untuk operasi yang memerlukan atomicity
- Sistem harus menggunakan migration untuk version control database schema

**6. File Upload Constraints:**
- Ukuran maksimal file upload adalah **2MB** per file
- Format file yang diterima untuk dokumen: PDF, JPG, PNG
- Sistem harus memvalidasi tipe file dan ukuran file sebelum menyimpan
- Sistem harus melakukan scanning untuk mencegah upload file berbahaya

**7. Performance Constraints:**
- Sistem harus dapat menangani minimal **100 pengguna aktif secara bersamaan** tanpa penurunan performa yang signifikan
- Response time untuk halaman umum harus kurang dari **2 detik**
- Response time untuk generate laporan harus kurang dari **10 detik** untuk data hingga 1000 record
- Sistem harus menggunakan caching untuk meningkatkan performa

**8. Browser Compatibility:**
- Sistem harus mendukung browser modern (Chrome, Firefox, Edge, Safari) versi terbaru dan 2 versi sebelumnya
- Sistem tidak perlu mendukung browser lama seperti Internet Explorer
- Sistem harus menggunakan responsive design untuk kompatibilitas dengan berbagai ukuran layar

**9. Accessibility Constraints:**
- Sistem harus mengikuti prinsip-prinsip dasar accessibility (WCAG 2.1 Level A)
- Sistem harus dapat digunakan dengan keyboard navigation
- Sistem harus memiliki kontras warna yang cukup untuk readability

**10. Integration Constraints:**
- Sistem tidak terintegrasi dengan sistem eksternal seperti sistem HR, sistem akademik kampus, atau sistem payroll
- Sistem tidak terintegrasi dengan sistem komunikasi real-time seperti chat atau video conference
- Sistem tidak menggunakan API eksternal untuk fungsi-fungsi utama

### 2.6. Assumptions and Dependencies

**Assumptions (Asumsi):**

1. **Infrastruktur dan Teknologi:**
   - Server hosting memiliki spesifikasi yang memadai dan dapat diakses secara stabil
   - Internet connection tersedia dan stabil untuk akses aplikasi
   - Browser pengguna mendukung JavaScript dan fitur-fitur modern HTML5/CSS3

2. **Pengguna:**
   - Pengguna memiliki pengetahuan dasar dalam menggunakan aplikasi web dan browser
   - Pengguna (Mentor dan Peserta) memiliki smartphone atau aplikasi authenticator untuk Two-Factor Authentication
   - Pengguna memahami bahasa Indonesia sebagai bahasa utama sistem

3. **Data dan Konten:**
   - Data divisi sudah tersedia atau dapat diinput oleh Admin
   - Template surat penerimaan dan sertifikat sudah tersedia dan sesuai dengan format organisasi
   - Data awal seperti bidang peminatan (Field of Interest) dapat diinput oleh Admin

4. **Proses Bisnis:**
   - Proses approval/rejection pengajuan magang mengikuti alur yang telah ditetapkan organisasi
   - Periode magang sudah ditentukan dan dapat diinput oleh peserta atau admin
   - Pembimbing sudah ditetapkan untuk setiap divisi sebelum sistem digunakan

5. **Keamanan:**
   - Server hosting memiliki konfigurasi keamanan yang memadai (firewall, SSL certificate)
   - Backup data dilakukan secara berkala oleh administrator server
   - Pengguna akan menjaga kerahasiaan kredensial login dan kode 2FA mereka

**Dependencies (Ketergantungan):**

1. **Dependencies Teknis:**
   - **Laravel Framework 12+**: Framework utama untuk pengembangan aplikasi
   - **PHP 8.2+**: Bahasa pemrograman yang digunakan
   - **Composer**: Package manager untuk PHP dependencies
   - **Database (SQLite/MySQL/PostgreSQL)**: Untuk penyimpanan data
   - **Web Server (Apache/Nginx)**: Untuk menjalankan aplikasi web
   - **DomPDF (barryvdh/laravel-dompdf)**: Library untuk generate PDF laporan
   - **Maatwebsite Excel (maatwebsite/excel)**: Library untuk export Excel laporan
   - **Google2FA (pragmarx/google2fa)**: Library untuk Two-Factor Authentication
   - **SimpleSoftwareIO QR Code**: Library untuk generate QR code untuk 2FA

2. **Dependencies Eksternal:**
   - **File Storage System**: Local file system atau cloud storage untuk menyimpan dokumen
   - **SSL/TLS Certificate**: Untuk mengaktifkan HTTPS (dapat menggunakan Let's Encrypt atau certificate berbayar)

3. **Dependencies Operasional:**
   - **Administrator Server**: Untuk setup, maintenance, dan monitoring server
   - **Network Infrastructure**: Koneksi internet yang stabil untuk akses aplikasi
   - **Backup System**: Sistem backup untuk data dan file storage

4. **Dependencies Data:**
   - Data divisi harus tersedia sebelum sistem dapat digunakan secara penuh
   - Data pembimbing harus diinput sebelum proses pengajuan magang dapat dilakukan

Jika salah satu dependencies tidak tersedia atau tidak berfungsi dengan baik, sistem mungkin tidak dapat beroperasi secara optimal atau beberapa fitur mungkin tidak dapat digunakan.

---

## 3. SYSTEM REQUIREMENTS

### 3.1. Functional Requirements

Sistem Manajemen Magang Berbasis Web dipecah menjadi beberapa feature utama, dan setiap feature memiliki daftar functional requirements sebagai berikut:

#### Feature 1: Authentication dan User Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-01 | System shall allow users to register using email, username, name, NIM, university, major, phone, and password | Sistem harus menyediakan form registrasi yang memungkinkan pengguna mendaftar dengan mengisi data pribadi dan kredensial login. Password harus memiliki minimal 8 karakter. | High | - |
| FR-02 | System shall validate email format and uniqueness during registration | Sistem harus memvalidasi format email dan memastikan email belum terdaftar sebelumnya. | High | FR-01 |
| FR-03 | System shall allow users to login using username/email and password | Sistem harus menyediakan form login yang memungkinkan pengguna masuk menggunakan username atau email beserta password. | High | FR-01 |
| FR-04 | System shall require Two-Factor Authentication (2FA) for Mentor and Peserta roles | Sistem harus mewajibkan Mentor dan Peserta untuk mengaktifkan dan menggunakan 2FA saat login. Admin tidak wajib menggunakan 2FA. | High | FR-03 |
| FR-05 | System shall generate QR code for 2FA setup | Sistem harus menghasilkan QR code yang dapat di-scan menggunakan aplikasi authenticator (Google Authenticator, Authy, dll) untuk setup 2FA. | High | FR-04 |
| FR-06 | System shall verify 2FA code during login | Sistem harus memverifikasi kode 2FA yang dimasukkan pengguna saat login menggunakan aplikasi authenticator. | High | FR-04 |
| FR-07 | System shall allow users to change password | Sistem harus menyediakan fitur untuk mengubah password dengan validasi password lama dan konfirmasi password baru. | Medium | FR-03 |
| FR-08 | System shall allow users to reset password via email | Sistem harus menyediakan fitur reset password yang mengirimkan link reset password ke email pengguna. | Medium | FR-01 |
| FR-09 | System shall manage user roles (Admin, Mentor, Peserta) | Sistem harus dapat mengelola role pengguna dan memberikan akses sesuai dengan role masing-masing. | High | FR-01 |
| FR-10 | System shall allow users to view and edit their profile | Sistem harus menyediakan halaman profil dimana pengguna dapat melihat dan mengedit data pribadi mereka. | Medium | FR-03 |
| FR-11 | System shall enforce session timeout after inactivity | Sistem harus secara otomatis logout pengguna setelah periode inactivity tertentu (misalnya 30 menit) untuk keamanan. | Medium | FR-03 |
| FR-12 | System shall prevent concurrent login from multiple devices | Sistem harus mencegah pengguna login dari multiple device secara bersamaan dengan session yang sama. | Low | FR-03 |

#### Feature 2: Organization Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-13 | Admin shall be able to create, read, update, and delete Divisi | Sistem harus menyediakan CRUD operations untuk mengelola Divisi oleh Admin. | High | FR-09 |
| FR-14 | Admin shall be able to manage Field of Interest (Bidang Peminatan) | Sistem harus menyediakan CRUD operations untuk mengelola bidang peminatan yang dapat dipilih peserta saat pengajuan magang. | High | FR-09 |
| FR-15 | Admin shall be able to assign Mentor to Divisi | Sistem harus memungkinkan Admin untuk menetapkan pembimbing (Mentor) ke divisi tertentu. | High | FR-13, FR-09 |

#### Feature 3: Internship Application Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-20 | Peserta shall be able to view list of available Divisi | Sistem harus menampilkan daftar divisi yang tersedia untuk pengajuan magang dengan informasi lengkap. | High | FR-13 |
| FR-21 | Peserta shall be able to apply for internship to a Divisi | Sistem harus menyediakan form pengajuan magang yang memungkinkan peserta memilih divisi dan mengisi data pengajuan. | High | FR-20 |
| FR-22 | Peserta shall be able to upload required documents (CV, KTM, Surat Permohonan, Surat Keterangan Baik) | Sistem harus memungkinkan peserta mengunggah dokumen persyaratan dengan validasi format (PDF, JPG, PNG) dan ukuran maksimal 2MB. | High | FR-21 |
| FR-23 | System shall validate document format and size before upload | Sistem harus memvalidasi format file (PDF, JPG, PNG) dan ukuran file (maksimal 2MB) sebelum menyimpan dokumen. | High | FR-22 |
| FR-24 | Peserta shall be able to track application status (diterima atau ditolak) | Sistem harus menampilkan status pengajuan magang secara real-time kepada peserta dengan indikator visual yang jelas. | High | FR-21 |
| FR-25 | Admin shall be able to approve or reject internship applications | Sistem harus memungkinkan Admin untuk melakukan approval atau rejection terhadap pengajuan magang dengan menambahkan catatan jika diperlukan. | High | FR-21 |
| FR-26 | System shall send in-app notification when application status changes | Sistem harus mengirimkan notifikasi dalam aplikasi kepada peserta ketika status pengajuan magang berubah (diterima atau ditolak). | High | FR-25 |
| FR-28 | Peserta shall be able to reapply for internship if previous application was rejected | Sistem harus memungkinkan peserta yang pengajuannya ditolak untuk mengajukan ulang magang ke divisi yang sama atau berbeda. | Medium | FR-21 |
| FR-29 | System shall prevent multiple active applications from the same user | Sistem harus mencegah peserta mengajukan lebih dari satu pengajuan aktif dalam waktu bersamaan. | Medium | FR-21 |
| FR-30 | Peserta shall be able to update application dates (start_date, end_date) | Sistem harus memungkinkan peserta mengupdate tanggal mulai dan akhir magang sebelum pengajuan disetujui. | Medium | FR-21 |
| FR-31 | System shall allow upload of additional documents if requested | Sistem harus memungkinkan peserta mengunggah dokumen tambahan jika diminta oleh Admin atau Mentor. | Medium | FR-22 |

#### Feature 4: Document Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-32 | System shall store uploaded documents securely | Sistem harus menyimpan dokumen yang diunggah dengan aman di file storage dengan nama file yang unik. | High | FR-22 |
| FR-33 | Peserta shall be able to download their uploaded documents | Sistem harus memungkinkan peserta mengunduh dokumen yang telah mereka unggah. | Medium | FR-32 |
| FR-34 | Admin and Mentor shall be able to view and download applicant documents | Sistem harus memungkinkan Admin dan Mentor melihat dan mengunduh dokumen peserta untuk keperluan review. | High | FR-32 |
| FR-35 | Admin shall be able to upload Acceptance Letter (Surat Penerimaan) | Sistem harus memungkinkan Admin mengunggah surat penerimaan magang yang telah dibuat secara manual. | High | FR-25 |
| FR-36 | Peserta shall be able to download Acceptance Letter | Sistem harus memungkinkan peserta mengunduh surat penerimaan magang setelah diunggah oleh Admin. | High | FR-35 |
| FR-38 | System shall track when Acceptance Letter is downloaded | Sistem harus mencatat waktu ketika surat penerimaan diunduh oleh peserta untuk tracking purposes. | Low | FR-37 |
| FR-39 | Mentor shall be able to upload Assessment Report (Laporan Penilaian) | Sistem harus memungkinkan Mentor mengunggah laporan penilaian peserta dalam format PDF. | Medium | FR-25 |
| FR-40 | Mentor shall be able to upload Completion Letter (Surat Selesai Magang) | Sistem harus memungkinkan Mentor mengunggah surat selesai magang dalam format PDF. | Medium | FR-25 |

#### Feature 5: Assignment Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-41 | Mentor shall be able to create assignments for their mentees | Sistem harus memungkinkan Mentor membuat penugasan untuk peserta yang menjadi bimbingannya (dengan status diterima) dengan mengisi judul, deskripsi, dan deadline. | High | FR-25 |
| FR-42 | Mentor shall be able to edit and delete assignments | Sistem harus memungkinkan Mentor mengedit dan menghapus penugasan yang telah dibuat sebelum peserta mengumpulkan tugas. | Medium | FR-41 |
| FR-43 | System shall send in-app notification when new assignment is created | Sistem harus mengirimkan notifikasi dalam aplikasi kepada peserta ketika Mentor membuat penugasan baru. | High | FR-41 |
| FR-44 | Peserta shall be able to view list of assignments | Sistem harus menampilkan daftar penugasan yang diberikan Mentor kepada peserta dengan status (pending, submitted, graded). | High | FR-41 |
| FR-45 | Peserta shall be able to submit assignment with file upload | Sistem harus memungkinkan peserta mengumpulkan tugas dengan mengunggah file sebelum deadline. | High | FR-44 |
| FR-46 | System shall validate assignment submission deadline | Sistem harus memvalidasi bahwa pengumpulan tugas dilakukan sebelum deadline yang ditentukan. | High | FR-45 |
| FR-47 | Mentor shall be able to grade assignments (0-100) | Sistem harus memungkinkan Mentor memberikan nilai terhadap tugas yang dikumpulkan peserta dalam skala 0-100. | High | FR-45 |
| FR-48 | Mentor shall be able to provide feedback on assignments | Sistem harus memungkinkan Mentor memberikan feedback atau komentar terhadap tugas yang dikumpulkan peserta. | High | FR-47 |
| FR-49 | Mentor shall be able to request revision for submitted assignments | Sistem harus memungkinkan Mentor meminta revisi terhadap tugas yang telah dikumpulkan, yang akan mengubah status tugas menjadi "revision needed". | Medium | FR-45 |
| FR-50 | Peserta shall be able to resubmit assignment after revision request | Sistem harus memungkinkan peserta mengumpulkan ulang tugas setelah diminta revisi oleh Mentor. | Medium | FR-49 |
| FR-51 | System shall send in-app notification when assignment is graded | Sistem harus mengirimkan notifikasi dalam aplikasi kepada peserta ketika Mentor memberikan nilai terhadap tugas mereka. | Medium | FR-47 |

#### Feature 6: Attendance Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-53 | Peserta shall be able to check-in with photo upload | Sistem harus memungkinkan peserta melakukan check-in harian dengan mengunggah foto sebagai bukti kehadiran. | High | FR-25 |
| FR-54 | System shall automatically record check-in timestamp | Sistem harus secara otomatis mencatat waktu check-in ketika peserta melakukan check-in. | High | FR-53 |
| FR-55 | System shall prevent multiple check-ins on the same day | Sistem harus mencegah peserta melakukan check-in lebih dari sekali dalam satu hari yang sama. | High | FR-53 |
| FR-56 | Peserta shall be able to mark absence with reason | Sistem harus memungkinkan peserta menandai absensi dengan alasan jika tidak dapat hadir. | High | FR-25 |
| FR-57 | Peserta shall be able to upload supporting document for absence | Sistem harus memungkinkan peserta mengunggah dokumen pendukung (surat sakit, surat izin, dll) saat menandai absensi. | Medium | FR-56 |
| FR-58 | Mentor shall be able to view attendance records of their mentees | Sistem harus menampilkan catatan absensi peserta kepada Mentor untuk monitoring kehadiran. | High | FR-53, FR-56 |
| FR-59 | Admin shall be able to view attendance records of all participants | Sistem harus menampilkan catatan absensi semua peserta kepada Admin untuk monitoring keseluruhan. | High | FR-53, FR-56 |
| FR-60 | System shall generate attendance statistics | Sistem harus menghasilkan statistik kehadiran seperti total hari kerja, total kehadiran, total absensi, dan persentase kehadiran. | Medium | FR-53, FR-56 |
| FR-61 | System shall allow filtering attendance by date range | Sistem harus memungkinkan filtering catatan absensi berdasarkan rentang tanggal tertentu. | Medium | FR-58, FR-59 |

#### Feature 7: Logbook Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-62 | Peserta shall be able to create logbook entries | Sistem harus memungkinkan peserta membuat entri logbook untuk mencatat aktivitas harian selama magang. | High | FR-25 |
| FR-63 | Peserta shall be able to edit logbook entries | Sistem harus memungkinkan peserta mengedit entri logbook yang telah dibuat. | Medium | FR-62 |
| FR-64 | Peserta shall be able to delete logbook entries | Sistem harus memungkinkan peserta menghapus entri logbook yang telah dibuat. | Medium | FR-62 |
| FR-65 | System shall automatically record logbook entry date | Sistem harus secara otomatis mencatat tanggal entri logbook ketika peserta membuat entri baru. | High | FR-62 |
| FR-66 | Mentor shall be able to view logbook entries of their mentees | Sistem harus menampilkan entri logbook peserta kepada Mentor untuk review aktivitas harian. | High | FR-62 |
| FR-67 | Admin shall be able to view logbook entries of all participants | Sistem harus menampilkan entri logbook semua peserta kepada Admin untuk monitoring keseluruhan. | High | FR-62 |
| FR-68 | System shall allow filtering logbook by date range | Sistem harus memungkinkan filtering entri logbook berdasarkan rentang tanggal tertentu. | Medium | FR-66, FR-67 |
| FR-69 | System shall allow searching logbook by keyword | Sistem harus memungkinkan pencarian entri logbook berdasarkan kata kunci dalam konten logbook. | Low | FR-66, FR-67 |

#### Feature 8: Certificate Management

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-70 | Admin shall be able to upload certificate for participants | Sistem harus memungkinkan Admin mengunggah sertifikat untuk peserta yang telah menyelesaikan magang. | High | FR-25 |
| FR-71 | Peserta shall be able to download their certificate | Sistem harus memungkinkan peserta mengunduh sertifikat mereka setelah diunggah oleh Admin. | High | FR-70 |
| FR-72 | System shall track certificate upload date | Sistem harus mencatat tanggal upload sertifikat untuk tracking purposes. | Low | FR-70 |

#### Feature 9: Reporting

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-77 | Admin shall be able to generate participant report | Sistem harus memungkinkan Admin membuat laporan peserta magang dengan filter berdasarkan periode, divisi, dan status. | High | FR-09 |
| FR-78 | System shall export participant report to PDF format | Sistem harus dapat mengekspor laporan peserta magang ke format PDF yang dapat diunduh. | High | FR-77 |
| FR-79 | System shall export participant report to Excel format | Sistem harus dapat mengekspor laporan peserta magang ke format Excel (XLSX) yang dapat diunduh. | High | FR-77 |
| FR-80 | Mentor shall be able to generate assessment report | Sistem harus memungkinkan Mentor membuat laporan penilaian untuk peserta bimbingannya. | Medium | FR-47 |
| FR-81 | Mentor shall be able to upload assessment report as PDF | Sistem harus memungkinkan Mentor mengunggah laporan penilaian dalam format PDF. | Medium | FR-80 |
| FR-82 | Mentor shall be able to download assessment report | Sistem harus memungkinkan Mentor mengunduh laporan penilaian yang telah dibuat. | Medium | FR-81 |
| FR-83 | System shall generate report within 10 seconds for up to 1000 records | Sistem harus dapat menghasilkan laporan dalam waktu maksimal 10 detik untuk data hingga 1000 record. | Medium | FR-77, FR-78, FR-79 |

#### Feature 10: Dashboard and Analytics

| ID | Requirement | Description | Priority | Dependency |
|---|---|---|---|---|
| FR-84 | System shall provide separate dashboard for each user role | Sistem harus menyediakan dashboard yang berbeda untuk Admin, Mentor, dan Peserta sesuai dengan kebutuhan masing-masing role. | High | FR-09 |
| FR-85 | Admin dashboard shall display overall statistics | Dashboard Admin harus menampilkan statistik keseluruhan seperti total pengajuan, total peserta aktif, total divisi, dll. | High | FR-84 |
| FR-86 | Mentor dashboard shall display statistics of their mentees | Dashboard Mentor harus menampilkan statistik peserta bimbingannya seperti jumlah penugasan, rata-rata nilai, tingkat kehadiran, dll. | High | FR-84 |
| FR-87 | Peserta dashboard shall display personal statistics | Dashboard Peserta harus menampilkan statistik pribadi seperti status pengajuan, jumlah penugasan, tingkat kehadiran, dll. | High | FR-84 |
| FR-88 | System shall display real-time data on dashboard | Dashboard harus menampilkan data real-time yang selalu ter-update sesuai dengan data terbaru dalam sistem. | Medium | FR-84 |
| FR-89 | System shall display charts and graphs for statistics | Sistem harus menampilkan grafik dan visualisasi data untuk statistik seperti grafik batang, pie chart, line chart, dll. | Medium | FR-85, FR-86, FR-87 |
| FR-90 | System shall display recent activities and notifications | Dashboard harus menampilkan aktivitas terbaru dan notifikasi penting untuk pengguna. | Medium | FR-84 |

---

### 3.2. Non-Functional Requirements (NFR)

#### 3.2.1. Performance Requirements

Sistem Manajemen Magang Berbasis Web harus memenuhi persyaratan performa berikut:

**Response Time:**
- Sistem harus memberikan response time kurang dari **2 detik** untuk halaman umum seperti dashboard, list data, dan form input
- Sistem harus memberikan response time kurang dari **3 detik** untuk operasi yang melibatkan query kompleks seperti laporan dengan filter
- Sistem harus memberikan response time kurang dari **10 detik** untuk generate laporan PDF/Excel dengan data hingga 1000 record
- Sistem harus memberikan response time kurang dari **5 detik** untuk upload dokumen dengan ukuran maksimal 2MB
- Sistem harus memberikan response time kurang dari **1 detik** untuk update status pengajuan dan operasi sederhana lainnya

**Throughput:**
- Sistem harus dapat menangani minimal **100 request per detik** untuk operasi umum
- Sistem harus dapat memproses minimal **50 upload file per menit** tanpa penurunan performa yang signifikan

**Concurrent Users:**
- Sistem harus dapat menangani minimal **100 pengguna aktif secara bersamaan** tanpa penurunan performa yang signifikan
- Sistem harus dapat menangani minimal **500 pengguna terdaftar** dalam database
- Sistem harus dapat menangani minimal **1000 pengajuan magang aktif** dalam satu waktu

**Scalability:**
- Sistem harus dirancang dengan arsitektur yang dapat di-scale secara horizontal jika diperlukan di masa depan
- Sistem harus menggunakan caching mechanism untuk meningkatkan performa pada data yang sering diakses
- Sistem harus menggunakan database indexing untuk mengoptimalkan query performance

**Resource Usage:**
- Sistem harus menggunakan memory maksimal **512MB** per request untuk operasi normal
- Sistem harus menggunakan CPU maksimal **50%** pada server dengan 4 cores untuk operasi normal
- Sistem harus mengoptimalkan penggunaan bandwidth dengan kompresi file dan caching static resources

#### 3.2.2. Security Requirements

Sistem Manajemen Magang Berbasis Web harus mengimplementasikan berbagai aspek keamanan sebagai berikut:

**Authentication & Authorization:**
- Sistem harus mengimplementasikan **authentication** yang aman menggunakan username/email dan password dengan hashing menggunakan bcrypt atau argon2
- Sistem harus mengimplementasikan **Two-Factor Authentication (2FA)** untuk Mentor dan Peserta menggunakan aplikasi authenticator (Google Authenticator, Authy, dll)
- Sistem harus mengimplementasikan **role-based access control (RBAC)** untuk membatasi akses pengguna berdasarkan role mereka (Admin, Mentor, Peserta)
- Sistem harus mengimplementasikan **session management** yang aman dengan session timeout setelah periode inactivity (30 menit)
- Sistem harus mengimplementasikan **password policy** yang mengharuskan password minimal 8 karakter
- Sistem harus mengimplementasikan **account lockout** setelah beberapa kali percobaan login yang gagal (misalnya 5 kali) untuk mencegah brute force attack

**Encryption:**
- Sistem harus menggunakan **HTTPS (SSL/TLS)** untuk semua komunikasi antara client dan server
- Sistem harus mengenkripsi data sensitif seperti password menggunakan hashing algorithm yang kuat (bcrypt atau argon2)
- Sistem harus mengenkripsi data sensitif yang disimpan di database jika diperlukan
- Sistem harus menggunakan **CSRF token** untuk melindungi form submission dari Cross-Site Request Forgery attack

**Data Protection:**
- Sistem harus mengimplementasikan **input validation** dan **sanitization** untuk mencegah XSS (Cross-Site Scripting) attack
- Sistem harus menggunakan **parameterized queries** atau **Eloquent ORM** untuk mencegah SQL injection attack
- Sistem harus mengimplementasikan **file upload validation** untuk mencegah upload file berbahaya atau malicious files
- Sistem harus membatasi akses file upload hanya untuk pengguna yang berwenang
- Sistem harus menyimpan file upload di lokasi yang aman di luar web root jika memungkinkan

**Logging:**
- Sistem harus mencatat **audit log** untuk aktivitas penting seperti login, logout, perubahan data penting, approval/rejection pengajuan, dll
- Sistem harus mencatat **error log** untuk tracking error dan exception yang terjadi dalam sistem
- Sistem harus menyimpan log dengan format yang dapat dibaca dan dianalisis
- Sistem harus menyimpan log untuk periode minimal 90 hari untuk keperluan audit

**Compliance:**
- Sistem harus mematuhi **Undang-Undang Perlindungan Data Pribadi (UU PDP)** Indonesia terkait pengelolaan data pribadi
- Sistem harus mengimplementasikan prinsip-prinsip keamanan data sesuai dengan standar keamanan informasi
- Sistem harus menyediakan mekanisme untuk pengguna mengakses dan menghapus data pribadi mereka sesuai dengan hak mereka
- Sistem harus mengimplementasikan **data retention policy** untuk menentukan berapa lama data disimpan dalam sistem

**Security Best Practices:**
- Sistem harus mengimplementasikan **rate limiting** untuk mencegah abuse dan DDoS attack
- Sistem harus mengimplementasikan **security headers** seperti X-Frame-Options, X-Content-Type-Options, dll
- Sistem harus melakukan **regular security updates** untuk dependencies dan framework yang digunakan
- Sistem harus mengimplementasikan **secure coding practices** untuk mencegah vulnerability umum

#### 3.2.3. Usability Requirements

Sistem Manajemen Magang Berbasis Web harus memenuhi persyaratan usability berikut:

**UI/UX Guidelines:**
- Sistem harus memiliki **user interface yang intuitif dan mudah digunakan** dengan navigasi yang jelas dan konsisten
- Sistem harus menggunakan **terminologi yang konsisten** di seluruh aplikasi untuk menghindari kebingungan pengguna
- Sistem harus menyediakan **feedback yang jelas** kepada pengguna untuk setiap aksi yang dilakukan (success message, error message, dll)
- Sistem harus menyediakan **loading indicator** untuk operasi yang memerlukan waktu lama
- Sistem harus menyediakan **confirmation dialog** untuk aksi yang bersifat destructive (delete, reject, dll)
- Sistem harus menggunakan **warna dan icon yang konsisten** untuk memberikan visual feedback kepada pengguna
- Sistem harus menyediakan **breadcrumb navigation** untuk membantu pengguna memahami lokasi mereka dalam aplikasi
- Sistem harus menyediakan **search functionality** untuk membantu pengguna menemukan data dengan cepat

**Accessibility Standards:**
- Sistem harus mengikuti prinsip-prinsip dasar **WCAG 2.1 Level A** untuk accessibility
- Sistem harus dapat digunakan dengan **keyboard navigation** tanpa memerlukan mouse
- Sistem harus memiliki **kontras warna yang cukup** (minimal 4.5:1 untuk teks normal) untuk readability
- Sistem harus menyediakan **alt text** untuk gambar yang penting
- Sistem harus menggunakan **semantic HTML** untuk meningkatkan accessibility
- Sistem harus dapat digunakan dengan **screen reader** untuk pengguna dengan gangguan penglihatan

**Responsive Design:**
- Sistem harus **responsive** dan dapat diakses dengan baik pada berbagai ukuran layar (desktop, tablet, mobile)
- Sistem harus mengoptimalkan layout untuk **mobile devices** dengan ukuran layar minimal 320x568 pixels
- Sistem harus menggunakan **touch-friendly interface** untuk mobile devices dengan ukuran button minimal 44x44 pixels
- Sistem harus mengoptimalkan **file size dan loading time** untuk mobile devices dengan koneksi internet yang lebih lambat

**User Guidance:**
- Sistem harus menyediakan **help text atau tooltip** untuk field yang memerlukan penjelasan
- Sistem harus menyediakan **validation message yang jelas** untuk membantu pengguna memperbaiki error
- Sistem harus menyediakan **user manual atau documentation** untuk membantu pengguna memahami cara menggunakan sistem
- Sistem harus menyediakan **FAQ (Frequently Asked Questions)** untuk menjawab pertanyaan umum pengguna

**Error Handling:**
- Sistem harus menampilkan **error message yang user-friendly** dan dapat dipahami oleh pengguna non-teknis
- Sistem harus memberikan **saran untuk mengatasi error** jika memungkinkan
- Sistem harus menghindari menampilkan **technical error message** yang dapat membingungkan pengguna

#### 3.2.4. Reliability Requirements

Sistem Manajemen Magang Berbasis Web harus memenuhi persyaratan reliability berikut:

**Availability:**
- Sistem harus memiliki **uptime minimal 99%** (sekitar 7.2 jam downtime per bulan)
- Sistem harus dapat diakses **24/7** kecuali untuk maintenance schedule yang telah diumumkan sebelumnya
- Sistem harus memiliki **redundancy mechanism** untuk mencegah single point of failure jika memungkinkan
- Sistem harus menyediakan **maintenance mode page** yang informatif saat sistem sedang dalam maintenance

**Fault Tolerance:**
- Sistem harus dapat menangani **error gracefully** tanpa crash atau menampilkan error page yang tidak user-friendly
- Sistem harus mengimplementasikan **error handling** yang comprehensive untuk menangani berbagai jenis error
- Sistem harus dapat **recover dari error** secara otomatis jika memungkinkan
- Sistem harus mencatat error untuk analisis dan perbaikan di masa depan

**Data Integrity:**
- Sistem harus menggunakan **database transactions** untuk operasi yang memerlukan atomicity (semua berhasil atau semua gagal)
- Sistem harus menggunakan **foreign key constraints** untuk menjaga integritas relasi data
- Sistem harus mengimplementasikan **data validation** di level application dan database untuk mencegah data yang tidak valid
- Sistem harus menggunakan **database backup** secara berkala untuk mencegah kehilangan data

**Backup & Recovery:**
- Sistem harus melakukan **backup database** secara otomatis minimal sekali per hari
- Sistem harus melakukan **backup file storage** (dokumen yang diunggah) secara berkala
- Sistem harus menyimpan **backup di lokasi yang berbeda** dari server utama untuk mencegah kehilangan data akibat disaster
- Sistem harus memiliki **recovery procedure** yang terdokumentasi untuk restore data dari backup
- Sistem harus dapat melakukan **point-in-time recovery** jika memungkinkan untuk mengembalikan data ke kondisi tertentu

**Monitoring:**
- Sistem harus memiliki **monitoring mechanism** untuk tracking uptime, performance, dan error
- Sistem harus mengirimkan **alert** kepada administrator jika terjadi error kritis atau downtime
- Sistem harus mencatat **performance metrics** untuk analisis dan optimasi di masa depan

#### 3.2.5. Maintainability Requirements

Sistem Manajemen Magang Berbasis Web harus memenuhi persyaratan maintainability berikut:

**Coding Standards:**
- Sistem harus mengikuti **PSR-12 coding standard** untuk PHP code
- Sistem harus menggunakan **Laravel coding conventions** dan best practices
- Sistem harus menggunakan **consistent naming convention** untuk variable, function, class, dan file
- Sistem harus menggunakan **meaningful variable and function names** yang menjelaskan tujuan mereka
- Sistem harus menghindari **code duplication** dengan menggunakan reusable functions atau classes

**Documentation:**
- Sistem harus memiliki **code comments** yang menjelaskan logika kompleks atau business rules penting
- Sistem harus memiliki **API documentation** jika terdapat API endpoints
- Sistem harus memiliki **database documentation** yang menjelaskan struktur database dan relasi antar tabel
- Sistem harus memiliki **deployment documentation** yang menjelaskan cara deploy aplikasi ke production
- Sistem harus memiliki **user manual** yang menjelaskan cara menggunakan sistem untuk setiap role pengguna

**Modularity:**
- Sistem harus dirancang dengan **modular architecture** yang memungkinkan pengembangan dan maintenance yang mudah
- Sistem harus menggunakan **separation of concerns** dengan memisahkan logic, presentation, dan data access layer
- Sistem harus menggunakan **Laravel MVC pattern** dengan benar untuk memisahkan concerns
- Sistem harus menggunakan **service classes** untuk business logic yang kompleks

**Version Control:**
- Sistem harus menggunakan **version control system** (Git) untuk tracking perubahan code
- Sistem harus menggunakan **meaningful commit messages** yang menjelaskan perubahan yang dilakukan
- Sistem harus menggunakan **branching strategy** yang jelas untuk development, testing, dan production

**Testing:**
- Sistem harus memiliki **unit tests** untuk critical business logic
- Sistem harus memiliki **integration tests** untuk testing interaksi antar modul
- Sistem harus memiliki **test documentation** yang menjelaskan cara menjalankan tests

**Dependency Management:**
- Sistem harus menggunakan **Composer** untuk mengelola PHP dependencies dengan version locking
- Sistem harus menggunakan **package.json** untuk mengelola JavaScript dependencies jika diperlukan
- Sistem harus mendokumentasikan **dependencies dan versinya** untuk memudahkan setup environment baru

#### 3.2.6. Portability Requirements

Sistem Manajemen Magang Berbasis Web harus memenuhi persyaratan portability berikut:

**Multi-platform Support:**
- Sistem harus dapat berjalan pada **multiple operating systems** untuk server (Linux, Windows Server, macOS untuk development)
- Sistem harus dapat diakses melalui **multiple web browsers** (Chrome, Firefox, Edge, Safari) tanpa memerlukan plugin khusus
- Sistem harus **responsive** dan dapat diakses dengan baik pada **multiple devices** (desktop, tablet, mobile)

**Database Portability:**
- Sistem harus menggunakan **database abstraction layer** (Eloquent ORM) yang memungkinkan migrasi ke database lain (SQLite, MySQL, PostgreSQL)
- Sistem harus menggunakan **database migrations** untuk version control database schema
- Sistem harus menghindari penggunaan **database-specific features** yang tidak portable

**Configuration Management:**
- Sistem harus menggunakan **environment configuration** (.env file) untuk mengelola konfigurasi yang berbeda antara development, testing, dan production
- Sistem harus menghindari **hardcoded configuration** dalam code
- Sistem harus menyediakan **configuration documentation** yang menjelaskan konfigurasi yang diperlukan

**Deployment Portability:**
- Sistem harus dapat di-deploy pada **various hosting environments** (shared hosting, VPS, cloud hosting) dengan konfigurasi yang sesuai
- Sistem harus menyediakan **deployment documentation** yang menjelaskan requirement dan steps untuk deployment
- Sistem harus menggunakan **standard deployment tools** dan practices

**Framework Dependency:**
- Sistem bergantung pada **Laravel Framework** yang harus diinstall pada server target
- Sistem bergantung pada **PHP 8.2+** yang harus tersedia pada server target
- Sistem harus mendokumentasikan **server requirements** dengan jelas untuk memudahkan deployment

---

## 4. EXTERNAL INTERFACE REQUIREMENTS

Bagian ini menjelaskan berbagai interface eksternal yang diperlukan oleh sistem untuk beroperasi dengan baik, termasuk user interface, hardware interface, software interface, dan communication interface.

### 4.1. User Interface

Sistem Manajemen Magang Berbasis Web menggunakan antarmuka pengguna berbasis web yang diakses melalui browser. Sistem ini menggunakan Laravel Blade Template Engine untuk rendering view dan mengikuti prinsip responsive design untuk kompatibilitas dengan berbagai ukuran layar.

**Landing Page (Home Page):**
Landing page merupakan halaman utama yang dapat diakses oleh pengunjung tanpa perlu login. Halaman ini menampilkan informasi umum tentang program magang, organisasi, dan fitur-fitur utama sistem. Landing page memiliki navigasi yang jelas menuju halaman About, Program, Login, dan Register. Desain landing page menggunakan layout yang clean dan modern dengan call-to-action yang jelas untuk mendorong pengunjung melakukan registrasi atau login. Halaman ini juga menampilkan informasi kontak dan alamat organisasi jika diperlukan.

**Login Page:**
Halaman login menyediakan form untuk autentikasi pengguna dengan input username/email dan password. Halaman ini memiliki validasi client-side dan server-side untuk memastikan data yang dimasukkan valid. Setelah login berhasil, pengguna akan diarahkan ke halaman setup 2FA jika mereka adalah Mentor atau Peserta yang belum mengaktifkan 2FA, atau langsung ke dashboard sesuai dengan role mereka. Halaman login juga menyediakan link untuk registrasi bagi pengguna baru dan link untuk reset password bagi pengguna yang lupa password. Desain halaman login menggunakan form yang sederhana dan user-friendly dengan pesan error yang jelas jika terjadi kesalahan autentikasi.

**Dashboard:**
Sistem menyediakan dashboard yang berbeda untuk setiap role pengguna dengan desain yang disesuaikan dengan kebutuhan masing-masing role. Dashboard Admin menampilkan statistik keseluruhan sistem seperti total pengajuan magang, total peserta aktif, total divisi, grafik distribusi pengajuan per divisi, dan aktivitas terbaru. Dashboard Mentor menampilkan statistik peserta bimbingannya seperti jumlah penugasan yang diberikan, rata-rata nilai peserta, tingkat kehadiran peserta, dan daftar peserta yang memerlukan perhatian. Dashboard Peserta menampilkan statistik pribadi seperti status pengajuan magang, jumlah penugasan yang diterima, tingkat kehadiran, progress logbook, dan notifikasi penting. Semua dashboard menggunakan card-based layout dengan icon dan warna yang konsisten untuk memudahkan navigasi dan pemahaman informasi. Dashboard juga menyediakan quick access menu ke fitur-fitur utama yang sering digunakan.

**Halaman-halaman Lainnya:**
Sistem memiliki berbagai halaman lainnya seperti halaman registrasi, halaman pengajuan magang, halaman penugasan, halaman absensi, halaman logbook, halaman sertifikat, dan halaman laporan. Semua halaman menggunakan layout yang konsisten dengan sidebar navigation untuk role yang memiliki dashboard, header dengan informasi pengguna dan logout button, dan footer dengan informasi copyright. Sistem menggunakan responsive design sehingga semua halaman dapat diakses dengan baik pada desktop, tablet, dan mobile device.

### 4.2. Hardware Interface

Sistem Manajemen Magang Berbasis Web tidak memerlukan interface dengan hardware khusus, sensor, atau perangkat IoT karena sistem ini merupakan aplikasi web murni yang berjalan di server dan diakses melalui browser. Sistem tidak memiliki koneksi langsung dengan perangkat keras seperti scanner, printer, atau perangkat input/output lainnya.

Sistem hanya memerlukan perangkat standar yang umum digunakan untuk mengakses aplikasi web, yaitu:
- **Server Hardware**: Server dengan spesifikasi minimum yang telah ditetapkan (CPU, RAM, Storage) untuk menjalankan aplikasi web dan database
- **Client Hardware**: Perangkat pengguna (desktop, laptop, tablet, smartphone) dengan browser yang mendukung untuk mengakses aplikasi web
- **Network Infrastructure**: Koneksi internet yang stabil untuk komunikasi antara client dan server

Sistem tidak memerlukan driver khusus atau instalasi software tambahan di sisi client karena semua interaksi dilakukan melalui browser web standar.

### 4.3. Software Interface

Sistem Manajemen Magang Berbasis Web memiliki beberapa interface dengan software eksternal dan library yang diperlukan untuk operasional sistem:


**Database Server Interface:**
Sistem menggunakan database abstraction layer melalui Laravel Eloquent ORM untuk berinteraksi dengan database server. Sistem mendukung berbagai database server termasuk SQLite (untuk development), MySQL 5.7+, MariaDB, dan PostgreSQL 10+. Interface dengan database menggunakan PDO (PHP Data Objects) untuk koneksi dan query execution. Sistem menggunakan database migrations untuk version control schema database dan seeders untuk data awal. Database interface harus mendukung transactions untuk operasi yang memerlukan atomicity, foreign key constraints untuk menjaga integritas data, dan indexing untuk optimasi performa query.

**PDF Generation Library Interface:**
Sistem mengintegrasikan dengan DomPDF library (barryvdh/laravel-dompdf) untuk menghasilkan laporan dalam format PDF. Interface dengan DomPDF menggunakan Laravel service provider dan facade untuk memudahkan penggunaan. Sistem menggunakan Blade template untuk membuat layout laporan PDF yang kemudian di-render menjadi PDF menggunakan DomPDF. Library ini harus dapat menghasilkan PDF dengan ukuran file yang optimal dan waktu generate maksimal 10 detik untuk laporan dengan konten hingga 1000 record.

**Excel Export Library Interface:**
Sistem mengintegrasikan dengan Maatwebsite Excel library (maatwebsite/excel) untuk mengekspor data ke format Excel (XLSX). Interface dengan library ini menggunakan Laravel service provider dan collection untuk memproses data sebelum diekspor. Sistem menggunakan library ini untuk mengekspor laporan peserta magang dengan berbagai filter dan format kolom yang dapat dikustomisasi. Library harus dapat mengekspor data hingga 1000 record dalam waktu maksimal 10 detik.

**Two-Factor Authentication Library Interface:**
Sistem mengintegrasikan dengan Google2FA library (pragmarx/google2fa) untuk implementasi Two-Factor Authentication. Interface dengan library ini digunakan untuk generate secret key, generate QR code untuk setup 2FA, dan verify kode 2FA yang dimasukkan pengguna. Sistem juga menggunakan SimpleSoftwareIO QR Code library untuk generate QR code yang dapat di-scan menggunakan aplikasi authenticator seperti Google Authenticator atau Authy. Library ini harus dapat generate dan verify kode 2FA dengan akurasi tinggi dan waktu response yang cepat.

**File Storage Interface:**
Sistem menggunakan Laravel Filesystem untuk interface dengan file storage system. Sistem dapat menggunakan local file storage atau cloud storage (seperti AWS S3, Google Cloud Storage) melalui Laravel Filesystem abstraction. Interface ini digunakan untuk menyimpan dan mengambil dokumen yang diunggah oleh pengguna seperti CV, KTM, surat permohonan, dan file tugas. File storage interface harus dapat menangani upload file dengan ukuran maksimal 2MB per file dan format PDF, JPG, PNG.

**Tidak Ada Integrasi dengan:**
- Payment gateway (sistem tidak memiliki modul pembayaran)
- API eksternal untuk fungsi utama (sistem standalone)
- AI models atau machine learning services (sistem tidak menggunakan AI/ML)
- Sistem HR eksternal atau sistem akademik kampus
- Sistem komunikasi real-time seperti chat atau video conference

### 4.4. Communication Interface

Sistem Manajemen Magang Berbasis Web menggunakan berbagai protokol komunikasi untuk interaksi antara komponen sistem dan dengan pengguna:

**HTTP/HTTPS Protocol:**
Sistem menggunakan protokol HTTP (Hypertext Transfer Protocol) dan HTTPS (HTTP Secure) untuk komunikasi antara web browser client dan web server. Semua komunikasi harus menggunakan HTTPS dengan SSL/TLS encryption untuk keamanan data. Sistem menggunakan metode HTTP standar seperti GET untuk mengambil data, POST untuk mengirim data (form submission, file upload), PUT untuk update data, dan DELETE untuk menghapus data. Sistem mengimplementasikan RESTful routing pattern meskipun tidak sepenuhnya REST API, dengan URL yang meaningful dan HTTP methods yang sesuai.


**Database Protocol:**
Sistem menggunakan berbagai protokol database tergantung pada database server yang digunakan:
- **SQLite**: Menggunakan file-based protocol untuk SQLite database
- **MySQL/MariaDB**: Menggunakan MySQL protocol melalui PDO dengan port default 3306
- **PostgreSQL**: Menggunakan PostgreSQL protocol melalui PDO dengan port default 5432

Semua koneksi database menggunakan parameterized queries melalui Eloquent ORM untuk keamanan dan portability.

**Tidak Menggunakan:**
- **WebSocket**: Sistem tidak menggunakan WebSocket untuk komunikasi real-time. Notifikasi dilakukan melalui in-app notification yang di-refresh secara periodik.
- **REST API External**: Sistem tidak menyediakan REST API untuk integrasi dengan sistem eksternal dalam scope pengembangan saat ini, meskipun arsitektur memungkinkan penambahan API di masa depan.
- **GraphQL**: Sistem tidak menggunakan GraphQL untuk data fetching.
- **gRPC**: Sistem tidak menggunakan gRPC untuk inter-service communication.

**Session Management:**
Sistem menggunakan HTTP session untuk mengelola state pengguna setelah login. Session disimpan di server-side (file-based atau database) dan menggunakan session cookie yang aman untuk identifikasi. Sistem mengimplementasikan CSRF protection menggunakan CSRF token yang di-generate untuk setiap form submission.

**File Upload Protocol:**
Sistem menggunakan HTTP POST dengan multipart/form-data encoding untuk upload file dari client ke server. File diupload melalui form submission dan diproses oleh Laravel request handler dengan validasi format dan ukuran file sebelum disimpan ke file storage.

---

## 5. APPENDIX

Bagian appendix ini berisi lampiran-lampiran yang mendukung dokumen SRS dan memberikan informasi tambahan yang relevan untuk pengembangan dan penggunaan sistem.

### 5.1. Glossary (Glosarium)

**Acceptance Letter**: Surat penerimaan magang yang dikeluarkan oleh Mentor setelah pengajuan magang diterima.

**Admin**: Administrator sistem yang memiliki akses penuh untuk mengelola keseluruhan sistem.

**Assignment**: Penugasan yang diberikan oleh Mentor kepada Peserta magang.

**Attendance**: Absensi atau kehadiran peserta magang yang dicatat melalui sistem.

**Certificate**: Sertifikat magang yang diberikan kepada peserta setelah menyelesaikan program magang.

**Divisi**: Unit organisasi yang menerima peserta magang.

**Field of Interest**: Bidang peminatan yang dapat dipilih peserta saat mengajukan magang.

**Internship Application**: Pengajuan magang yang dilakukan oleh peserta untuk mengikuti program magang.

**Logbook**: Catatan aktivitas harian peserta magang selama mengikuti program.

**Mentor/Pembimbing**: Pembimbing yang bertanggung jawab membimbing peserta magang di divisi masing-masing.

**Peserta**: Mahasiswa yang mengikuti program magang.

**Two-Factor Authentication (2FA)**: Metode autentikasi dua faktor menggunakan aplikasi authenticator untuk meningkatkan keamanan akun.

### 5.2. Acronyms and Abbreviations

- **2FA**: Two-Factor Authentication
- **API**: Application Programming Interface
- **BRS**: Business Requirement Specification
- **CRUD**: Create, Read, Update, Delete
- **CSRF**: Cross-Site Request Forgery
- **CV**: Curriculum Vitae
- **ERD**: Entity Relationship Diagram
- **FAQ**: Frequently Asked Questions
- **GDPR**: General Data Protection Regulation
- **HTTPS**: Hypertext Transfer Protocol Secure
- **KTM**: Kartu Tanda Mahasiswa
- **MVC**: Model-View-Controller
- **NFR**: Non-Functional Requirements
- **ORM**: Object-Relational Mapping
- **PDF**: Portable Document Format
- **PHP**: Hypertext Preprocessor
- **PSR**: PHP Standards Recommendations
- **QA**: Quality Assurance
- **RBAC**: Role-Based Access Control
- **REST**: Representational State Transfer
- **SDD**: Software Design Document
- **SMTP**: Simple Mail Transfer Protocol
- **SRS**: Software Requirements Specification
- **SQL**: Structured Query Language
- **SSL**: Secure Sockets Layer
- **TLS**: Transport Layer Security
- **UI**: User Interface
- **UX**: User Experience
- **UU PDP**: Undang-Undang Perlindungan Data Pribadi
- **WCAG**: Web Content Accessibility Guidelines
- **XLSX**: Excel Open XML Spreadsheet
- **XSS**: Cross-Site Scripting

### 5.3. References

1. Laravel Documentation. (2024). *Laravel - The PHP Framework for Web Artisans*. Retrieved from https://laravel.com/docs

2. IEEE Computer Society. (2024). *IEEE Software Engineering Standards*. Retrieved from https://www.computer.org/

3. OWASP Foundation. (2024). *OWASP Top 10 - The Ten Most Critical Web Application Security Risks*. Retrieved from https://owasp.org/www-project-top-ten/

4. W3C. (2024). *Web Content Accessibility Guidelines (WCAG) 2.1*. Retrieved from https://www.w3.org/WAI/WCAG21/quickref/

5. DomPDF Documentation. (2024). *Laravel DomPDF - PDF generation for Laravel*. Retrieved from https://github.com/barryvdh/laravel-dompdf

6. Maatwebsite Excel Documentation. (2024). *Laravel Excel - Supercharged Excel exports and imports in Laravel*. Retrieved from https://docs.laravel-excel.com/

7. Google2FA Documentation. (2024). *Google2FA - Two Factor Authentication Package for Laravel*. Retrieved from https://github.com/antonioribeiro/google2fa

8. PHP The Right Way. (2024). *PHP: The Right Way*. Retrieved from https://phptherightway.com/

9. Undang-Undang Republik Indonesia Nomor 27 Tahun 2022 tentang Perlindungan Data Pribadi.

10. PROPOSAL.md - Dokumen proposal proyek Sistem Manajemen Magang Berbasis Web.

### 5.4. Document History

| Version | Date | Author | Description |
|---------|------|--------|-------------|
| 1.0 | 2024 | System Analyst | Initial version of SRS document |

### 5.5. Change Log

Perubahan yang dilakukan pada dokumen SRS ini akan dicatat dalam tabel berikut:

| Version | Date | Section | Change Description |
|---------|------|---------|-------------------|
| 1.0 | 2024 | All | Initial creation of SRS document with all sections |

### 5.6. Related Documents

Dokumen-dokumen terkait yang mendukung pengembangan sistem ini:

1. **PROPOSAL.md**: Dokumen proposal proyek yang menjelaskan latar belakang, tujuan, scope, dan metodologi pengembangan sistem.

2. **Business Requirement Specification (BRS)**: Dokumen yang menjelaskan kebutuhan bisnis dari sistem (jika tersedia).

3. **Software Design Document (SDD)**: Dokumen desain perangkat lunak yang menjelaskan arsitektur sistem, database design, dan UI/UX design (akan dibuat setelah SRS).

4. **User Manual**: Panduan penggunaan sistem untuk setiap role pengguna (akan dibuat setelah implementasi).

5. **Technical Documentation**: Dokumentasi teknis yang menjelaskan setup, deployment, dan maintenance sistem (akan dibuat setelah implementasi).

### 5.7. Approval

Dokumen SRS ini harus disetujui oleh:

- [ ] Project Manager
- [ ] System Analyst
- [ ] Stakeholder/Client
- [ ] Technical Lead

**Tanda Tangan dan Tanggal:**

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Project Manager | | | |
| System Analyst | | | |
| Stakeholder | | | |
| Technical Lead | | | |

---

**Dokumen SRS ini dapat diperbarui sesuai dengan perkembangan proyek dan feedback dari stakeholder.**

