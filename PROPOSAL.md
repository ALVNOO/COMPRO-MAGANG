# PROPOSAL COMPUTING PROJECT
## SISTEM MANAJEMEN MAGANG BERBASIS WEB

---

## 1. BACKGROUND (LATAR BELAKANG)

Program magang merupakan salah satu bentuk kerjasama antara institusi pendidikan dengan dunia industri yang memiliki peran strategis dalam meningkatkan kompetensi mahasiswa melalui pengalaman praktis di lingkungan kerja profesional. Dalam konteks organisasi besar seperti PT Telkom Indonesia (Witel Sulbagsel), program magang menjadi bagian penting dari strategi pengembangan sumber daya manusia dan kontribusi terhadap dunia pendidikan.

Berdasarkan observasi dan studi pendahuluan, proses manajemen magang yang masih dilakukan secara manual atau semi-digital menghadapi berbagai tantangan operasional. Permasalahan utama yang ditemukan di lapangan meliputi: (1) proses pengajuan magang yang masih menggunakan dokumen fisik dan email, menyebabkan keterlambatan dalam proses verifikasi dan persetujuan; (2) kesulitan dalam tracking status pengajuan magang secara real-time, baik bagi peserta maupun pihak manajemen; (3) manajemen dokumen yang tidak terpusat, menyebabkan risiko kehilangan dokumen dan kesulitan dalam audit; (4) proses penilaian dan monitoring peserta magang yang masih menggunakan spreadsheet atau dokumen terpisah, menyulitkan pembimbing dalam memberikan feedback yang tepat waktu; (5) sistem absensi yang masih manual, memungkinkan adanya ketidakakuratan dalam pencatatan kehadiran; (6) pembuatan sertifikat dan laporan yang memerlukan waktu lama karena proses manual.

Menurut penelitian yang dilakukan oleh Smith & Johnson (2022) dalam jurnal "Digital Transformation in Human Resource Management", implementasi sistem manajemen berbasis web dapat mengurangi waktu proses administrasi hingga 40% dan meningkatkan akurasi data hingga 95%. Selain itu, studi dari International Journal of Information Management menunjukkan bahwa digitalisasi proses magang dapat meningkatkan kepuasan peserta hingga 35% dan efisiensi manajemen hingga 50%.

Relevansi proyek ini sangat tinggi mengingat kebutuhan organisasi untuk meningkatkan efisiensi operasional, meningkatkan kualitas pengalaman peserta magang, dan memastikan kepatuhan terhadap standar administrasi yang berlaku. Sistem ini akan memberikan nilai tambah bagi semua stakeholder, termasuk peserta magang, pembimbing, administrator, dan manajemen organisasi.

---

## 2. PROBLEM STATEMENT (RUMUSAN MASALAH)

Masalah inti yang ingin diselesaikan oleh proyek ini adalah belum adanya sistem manajemen magang yang terintegrasi dan terdigitalisasi untuk mengelola seluruh siklus program magang mulai dari proses pengajuan hingga penerbitan sertifikat. Kondisi ini menyebabkan inefisiensi dalam proses administrasi, kesulitan dalam monitoring dan evaluasi peserta magang, serta risiko kesalahan dalam pengelolaan dokumen dan data. Sistem yang ada saat ini masih bersifat manual atau menggunakan tools yang tidak terintegrasi, sehingga memerlukan waktu yang lama untuk menyelesaikan proses-proses administratif, sulit untuk melakukan tracking status pengajuan secara real-time, dan tidak adanya mekanisme otomatisasi untuk pembuatan dokumen resmi seperti surat penerimaan dan sertifikat. Selain itu, proses penilaian, absensi, dan logbook masih dilakukan secara terpisah, menyulitkan pembimbing dalam memberikan bimbingan yang komprehensif dan tepat waktu kepada peserta magang.

---

## 3. OBJECTIVES (TUJUAN PROYEK)

### 3.1. Tujuan Utama
Mengembangkan sistem manajemen magang berbasis web yang terintegrasi untuk mengotomatisasi dan meningkatkan efisiensi seluruh proses administrasi program magang, mulai dari pengajuan magang hingga penerbitan sertifikat, dengan target mengurangi waktu proses administrasi sebesar 40% dan meningkatkan akurasi data hingga 95%.

### 3.2. Tujuan Khusus
1. **Mengembangkan modul manajemen pengajuan magang** yang memungkinkan peserta untuk mengajukan magang secara online dengan upload dokumen yang terstruktur, dengan target waktu pengajuan dapat diselesaikan dalam waktu maksimal 15 menit per peserta.

2. **Mengimplementasikan sistem tracking status pengajuan** yang memberikan notifikasi real-time kepada peserta mengenai status pengajuan mereka (diterima atau ditolak), dengan target response time kurang dari 1 detik untuk update status.

3. **Membangun modul manajemen dokumen terpusat** yang dapat menyimpan dan mengelola dokumen-dokumen penting seperti CV, KTM, surat permohonan, surat keterangan baik, surat penerimaan, dan sertifikat, dengan kapasitas penyimpanan minimal 10GB dan dukungan format PDF, JPG, PNG.

4. **Mengembangkan sistem manajemen penugasan** yang memungkinkan pembimbing untuk memberikan tugas kepada peserta, peserta dapat mengumpulkan tugas, dan pembimbing dapat memberikan penilaian serta feedback, dengan target waktu respon penilaian maksimal 3 hari kerja.

5. **Mengimplementasikan sistem absensi digital** dengan fitur check-in menggunakan foto dan pencatatan waktu otomatis, serta fitur absensi dengan alasan, dengan target akurasi pencatatan absensi 100%.

6. **Membangun modul logbook digital** yang memungkinkan peserta untuk mencatat aktivitas harian selama magang dan dapat di-review oleh pembimbing, dengan target peserta dapat membuat minimal 1 entri logbook per hari kerja.

7. **Mengembangkan modul manajemen dokumen** yang memungkinkan admin mengunggah surat penerimaan magang dan sertifikat secara manual, dengan target waktu upload dokumen maksimal 2 menit per dokumen.

8. **Mengimplementasikan sistem pelaporan** yang dapat menghasilkan laporan peserta magang dalam format PDF dan Excel dengan filter berdasarkan periode, divisi, dan status, dengan target waktu generate laporan maksimal 10 detik.

9. **Mengembangkan sistem autentikasi multi-faktor** menggunakan Two-Factor Authentication (2FA) untuk meningkatkan keamanan akun pengguna, dengan target tingkat keamanan mencapai 99% pencegahan akses tidak sah.

10. **Membangun dashboard analitik** untuk administrator dan pembimbing yang menampilkan statistik dan grafik terkait program magang, dengan target data dapat di-update secara real-time.

---

## 4. SCOPE AND LIMITATIONS (RUANG LINGKUP DAN BATASAN)

### 4.1. Ruang Lingkup Proyek

Proyek ini mencakup pengembangan sistem manajemen magang berbasis web dengan modul-modul berikut:

1. **Modul Autentikasi dan Manajemen Pengguna**
   - Sistem login dan registrasi pengguna
   - Manajemen role pengguna (Admin, Pembimbing/Mentor, Peserta)
   - Two-Factor Authentication (2FA) untuk Mentor dan Peserta
   - Manajemen profil pengguna

2. **Modul Manajemen Organisasi**
   - Manajemen divisi
   - Manajemen bidang peminatan (Field of Interest)
   - Manajemen pembimbing per divisi

3. **Modul Pengajuan Magang**
   - Form pengajuan magang online
   - Upload dokumen persyaratan (CV, KTM, Surat Permohonan, Surat Keterangan Baik)
   - Tracking status pengajuan
   - Proses approval/rejection oleh Admin

4. **Modul Manajemen Dokumen**
   - Penyimpanan dan pengelolaan dokumen peserta
   - Upload dan download dokumen
   - Upload surat penerimaan magang (Acceptance Letter) oleh Admin
   - Upload sertifikat magang oleh Admin

5. **Modul Penugasan dan Penilaian**
   - Pembuatan penugasan oleh pembimbing
   - Pengumpulan tugas oleh peserta
   - Penilaian dan feedback oleh pembimbing
   - Sistem revisi tugas

6. **Modul Absensi**
   - Check-in dengan foto dan timestamp
   - Absensi dengan alasan dan bukti dokumen
   - Monitoring absensi oleh pembimbing dan admin
   - Laporan absensi

7. **Modul Logbook**
   - Pencatatan aktivitas harian peserta
   - Review logbook oleh pembimbing
   - Filter dan pencarian logbook

8. **Modul Pelaporan**
   - Laporan peserta magang (PDF dan Excel)
   - Laporan penilaian oleh pembimbing
   - Dashboard statistik dan analitik
   - Export data

9. **Modul Manajemen Sertifikat**
   - Upload sertifikat oleh admin
   - Download sertifikat oleh peserta

### 4.2. Batasan Proyek

Proyek ini memiliki batasan-batasan berikut:

1. **Integrasi Sistem Eksternal**: Sistem tidak mencakup integrasi dengan sistem eksternal seperti sistem payroll, sistem HR perusahaan, atau sistem akademik kampus.

2. **Pembayaran**: Sistem tidak mencakup modul pembayaran atau pengelolaan biaya magang.

3. **Komunikasi Real-time**: Sistem tidak mencakup fitur chat atau komunikasi real-time antar pengguna. Komunikasi dilakukan melalui notifikasi sistem dalam aplikasi.

4. **Mobile Application**: Sistem hanya dikembangkan sebagai aplikasi web responsive, tidak mencakup pengembangan aplikasi mobile native (iOS/Android).

5. **Video Conference**: Sistem tidak mencakup integrasi dengan platform video conference untuk meeting virtual.

6. **Machine Learning/AI**: Sistem tidak menggunakan teknologi machine learning atau artificial intelligence untuk rekomendasi atau prediksi.

7. **Multi-language**: Sistem hanya mendukung bahasa Indonesia, tidak mencakup fitur multi-language.

8. **Cloud Storage Eksternal**: Sistem menggunakan storage lokal/server, tidak mencakup integrasi dengan cloud storage eksternal seperti Google Drive atau Dropbox.

9. **Sistem Notifikasi Push**: Sistem hanya menggunakan notifikasi dalam aplikasi, tidak mencakup email notification atau push notification untuk mobile device.

10. **Backup Otomatis**: Sistem tidak mencakup modul backup otomatis ke cloud, backup dilakukan secara manual oleh administrator server.

---

## 5. BUSINESS REQUIREMENT SPECIFICATION (BRS)

### 5.1. Business Goals

Tujuan utama proyek ini bagi organisasi adalah:

1. **Meningkatkan Efisiensi Operasional**: Mengurangi waktu yang dibutuhkan untuk proses administrasi magang dari rata-rata 2-3 minggu menjadi maksimal 1 minggu, sehingga dapat menghemat waktu staf administrasi hingga 40%.

2. **Meningkatkan Kualitas Program Magang**: Memberikan pengalaman yang lebih baik bagi peserta magang melalui proses yang lebih cepat, transparan, dan terstruktur, dengan target meningkatkan tingkat kepuasan peserta hingga 35%.

3. **Meningkatkan Akurasi Data**: Mengurangi kesalahan dalam pencatatan data dan dokumen melalui sistem terpusat dan terdigitalisasi, dengan target akurasi data mencapai 95%.

4. **Meningkatkan Transparansi**: Memberikan visibilitas yang jelas kepada semua stakeholder mengenai status dan progress program magang secara real-time.

5. **Meningkatkan Kepatuhan Administratif**: Memastikan semua dokumen dan proses sesuai dengan standar dan regulasi yang berlaku melalui sistem yang terstruktur dan terdokumentasi.

6. **Mengurangi Biaya Operasional**: Mengurangi penggunaan kertas dan biaya administrasi melalui digitalisasi proses, dengan target penghematan biaya operasional hingga 30%.

### 5.2. Stakeholders

Stakeholder utama dalam sistem ini meliputi:

1. **Administrator Sistem (Admin)**
   - Bertanggung jawab atas manajemen keseluruhan sistem
   - Mengelola divisi dan bidang peminatan
   - Melakukan approval/rejection pengajuan magang
   - Mengelola data peserta dan pembimbing
   - Membuat laporan dan statistik
   - Mengelola aturan dan konfigurasi sistem
   - Mengunggah surat penerimaan magang dan sertifikat

2. **Pembimbing/Mentor**
   - Memberikan penugasan kepada peserta magang
   - Melakukan penilaian terhadap tugas peserta
   - Memantau absensi dan logbook peserta
   - Membuat laporan penilaian peserta

3. **Peserta Magang**
   - Mengajukan magang ke divisi yang diinginkan
   - Mengunggah dokumen persyaratan
   - Melihat status pengajuan magang
   - Menerima dan mengerjakan penugasan
   - Melakukan check-in absensi harian
   - Mencatat logbook aktivitas harian
   - Mengunduh surat penerimaan dan sertifikat

### 5.3. Business Process Description

#### 5.3.1. Proses Bisnis AS-IS (Saat Ini)

**Proses Pengajuan Magang:**
1. Peserta mengunduh formulir pengajuan dari website atau email
2. Peserta mengisi formulir secara manual
3. Peserta mengumpulkan dokumen persyaratan (CV, KTM, Surat Permohonan, Surat Keterangan Baik)
4. Peserta mengirimkan formulir dan dokumen melalui email atau datang langsung ke kantor
5. Staf administrasi menerima dan memverifikasi dokumen secara manual
6. Staf administrasi menginput data ke spreadsheet atau database sederhana
7. Staf administrasi mengirimkan pengajuan ke pembimbing untuk review
8. Pembimbing meninjau pengajuan melalui email atau dokumen fisik
9. Pembimbing memberikan respon melalui email atau dokumen fisik
10. Staf administrasi mengupdate status pengajuan secara manual
11. Staf administrasi mengirimkan notifikasi ke peserta melalui email atau telepon

**Proses Monitoring Peserta Magang:**
1. Peserta mencatat absensi secara manual di buku absensi
2. Peserta mencatat logbook aktivitas di buku atau dokumen Word
3. Pembimbing memberikan tugas melalui email atau dokumen fisik
4. Peserta mengumpulkan tugas melalui email
5. Pembimbing menilai tugas secara manual dan memberikan feedback melalui email
6. Pembimbing membuat laporan penilaian secara manual menggunakan dokumen Word/Excel

**Proses Penerbitan Dokumen:**
1. Staf administrasi membuat surat penerimaan secara manual menggunakan template Word
2. Staf administrasi mencetak dan menandatangani surat penerimaan
3. Surat dikirimkan ke peserta melalui pos atau email (scan)
4. Setelah magang selesai, pembimbing membuat laporan penilaian secara manual
5. Staf administrasi membuat sertifikat secara manual menggunakan template
6. Sertifikat dicetak dan ditandatangani
7. Sertifikat diberikan kepada peserta secara langsung atau melalui pos

#### 5.3.2. Proses Bisnis TO-BE (Yang Diusulkan)

**Proses Pengajuan Magang:**
1. Peserta melakukan registrasi dan login ke sistem
2. Peserta memilih divisi dan bidang peminatan yang diinginkan
3. Peserta mengisi form pengajuan online di sistem
4. Peserta mengunggah dokumen persyaratan langsung ke sistem
5. Sistem secara otomatis memvalidasi format dan kelengkapan dokumen
6. Sistem mengirimkan notifikasi ke Admin terkait pengajuan baru
7. Admin melakukan verifikasi dan review dokumen melalui sistem
8. Admin memberikan keputusan (diterima/ditolak) melalui sistem dengan catatan
9. Sistem secara otomatis mengupdate status pengajuan
10. Sistem mengirimkan notifikasi dalam aplikasi ke peserta mengenai status pengajuan
11. Jika diterima, Admin dapat mengunggah surat penerimaan magang

**Proses Monitoring Peserta Magang:**
1. Peserta melakukan check-in absensi harian melalui sistem dengan upload foto
2. Sistem mencatat waktu check-in secara otomatis
3. Peserta mencatat logbook aktivitas harian melalui form online di sistem
4. Pembimbing dapat melihat absensi dan logbook peserta secara real-time melalui dashboard
5. Pembimbing membuat penugasan melalui sistem dengan deadline yang ditentukan
6. Sistem mengirimkan notifikasi ke peserta terkait penugasan baru
7. Peserta mengunggah tugas yang telah dikerjakan ke sistem
8. Pembimbing menilai tugas melalui sistem dengan memberikan nilai dan feedback
9. Sistem mengirimkan notifikasi ke peserta terkait hasil penilaian
10. Pembimbing dapat membuat laporan penilaian melalui sistem yang dapat di-export ke PDF/Excel

**Proses Penerbitan Dokumen:**
1. Admin mengunggah surat penerimaan magang yang telah dibuat secara manual ke sistem
2. Surat dapat diunduh langsung oleh peserta dalam format PDF
3. Setelah magang selesai, pembimbing membuat laporan penilaian melalui sistem
4. Admin mengunggah sertifikat magang yang telah dibuat secara manual ke sistem
5. Sertifikat dapat diunduh langsung oleh peserta dalam format PDF

### 5.4. High-Level Business Requirements

1. **Sistem harus dapat mengurangi waktu proses pengajuan magang** dari rata-rata 2-3 minggu menjadi maksimal 1 minggu, dengan mengurangi waktu tunggu pada setiap tahap proses.

2. **Sistem harus menyediakan dashboard real-time** untuk semua stakeholder yang menampilkan informasi terkini mengenai status pengajuan, absensi, penugasan, dan progress peserta magang.

3. **Sistem harus dapat menyimpan dan mengelola dokumen** dengan kapasitas minimal 10GB dan mendukung format PDF, JPG, PNG dengan ukuran maksimal 2MB per file.

4. **Sistem harus menyediakan notifikasi otomatis** dalam aplikasi kepada pengguna terkait update status pengajuan, penugasan baru, deadline tugas, dan update penting lainnya.

5. **Sistem harus dapat menghasilkan laporan** dalam format PDF dan Excel dengan waktu generate maksimal 10 detik untuk laporan dengan data hingga 1000 record.

6. **Sistem harus menyediakan sistem autentikasi yang aman** dengan Two-Factor Authentication (2FA) untuk Mentor dan Peserta untuk mencegah akses tidak sah.

7. **Sistem harus dapat mengotomatisasi pembuatan dokumen** seperti surat penerimaan dan sertifikat dengan waktu pembuatan maksimal 5 menit per dokumen.

8. **Sistem harus menyediakan fitur pencarian dan filter** yang memungkinkan pengguna untuk mencari data berdasarkan berbagai kriteria seperti nama, divisi, periode, dan status.

9. **Sistem harus dapat menangani minimal 100 pengguna aktif secara bersamaan** tanpa penurunan performa yang signifikan.

10. **Sistem harus dapat diakses melalui web browser** dengan dukungan untuk browser modern (Chrome, Firefox, Safari, Edge) dan responsive untuk berbagai ukuran layar.

### 5.5. Business Rules

1. **Aturan Pengajuan Magang:**
   - Peserta hanya dapat mengajukan magang ke satu divisi dalam satu periode
   - Peserta yang sudah pernah mengajukan magang sebelumnya harus menggunakan form pengajuan ulang
   - Semua dokumen persyaratan harus diunggah sebelum pengajuan dapat diselesaikan
   - Format dokumen yang diterima: PDF untuk surat permohonan, CV, surat keterangan baik; PDF/JPG/PNG untuk KTM
   - Ukuran maksimal setiap dokumen adalah 2MB

2. **Aturan Status Pengajuan:**
   - Status pengajuan hanya dapat berupa: diterima (accepted) atau ditolak (rejected)
   - Hanya Admin yang dapat melakukan approval/rejection pengajuan magang
   - Admin dapat memberikan catatan saat melakukan approval/rejection

3. **Aturan Penugasan:**
   - Pembimbing dapat membuat penugasan untuk peserta yang statusnya accepted
   - Setiap penugasan harus memiliki deadline
   - Peserta dapat mengumpulkan tugas sebelum deadline
   - Pembimbing dapat memberikan nilai dalam skala 0-100
   - Pembimbing dapat meminta revisi tugas yang telah dikumpulkan

4. **Aturan Absensi:**
   - Peserta harus melakukan check-in setiap hari kerja
   - Check-in harus dilakukan dengan upload foto
   - Waktu check-in dicatat secara otomatis oleh sistem
   - Peserta dapat melakukan absensi dengan alasan jika tidak dapat hadir
   - Absensi dengan alasan harus disertai bukti dokumen (jika diperlukan)

5. **Aturan Logbook:**
   - Peserta harus membuat logbook minimal 1 kali per hari kerja
   - Logbook harus berisi deskripsi aktivitas yang dilakukan
   - Pembimbing dapat melihat dan memberikan komentar pada logbook

6. **Aturan Sertifikat:**
   - Sertifikat hanya dapat diunggah oleh Admin untuk peserta yang telah menyelesaikan magang
   - Sertifikat harus diunggah dalam format PDF

7. **Aturan Autentikasi:**
   - Mentor dan Peserta wajib menggunakan Two-Factor Authentication (2FA)
   - Admin tidak wajib menggunakan 2FA
   - Password harus memiliki minimal 8 karakter

8. **Aturan Akses Data:**
   - Peserta hanya dapat melihat data miliknya sendiri
   - Pembimbing hanya dapat melihat data peserta yang menjadi bimbingannya
   - Admin dapat melihat semua data dalam sistem

9. **Aturan Periode Magang:**
   - Tanggal mulai magang harus sebelum tanggal akhir magang
   - Periode magang minimum adalah 1 bulan
   - Periode magang maksimum adalah 12 bulan

10. **Aturan Laporan:**
    - Laporan hanya dapat di-generate oleh Admin dan Pembimbing
    - Laporan dapat di-filter berdasarkan periode, divisi, dan status
    - Laporan dapat di-export dalam format PDF dan Excel

---

## 6. METHODOLOGY

### 6.1. Metode Pengembangan Perangkat Lunak

Proyek ini menggunakan metodologi **Agile dengan pendekatan Scrum** untuk pengembangan perangkat lunak. Metodologi ini dipilih karena:

1. **Fleksibilitas**: Memungkinkan perubahan requirement selama proses pengembangan
2. **Iterative Development**: Pengembangan dilakukan dalam sprint-sprint pendek (2-3 minggu) dengan deliverable yang dapat diuji pada setiap akhir sprint
3. **Collaboration**: Meningkatkan kolaborasi antara tim pengembang dan stakeholder
4. **Early Feedback**: Memungkinkan stakeholder untuk memberikan feedback sejak awal pengembangan

**Sprint Planning:**
- Setiap sprint berdurasi 2-3 minggu
- Setiap sprint menghasilkan fitur yang dapat diuji dan di-deploy
- Daily standup meeting untuk update progress dan blocker

**Sprint Review:**
- Demo fitur yang telah dikembangkan kepada stakeholder
- Gathering feedback untuk improvement

**Sprint Retrospective:**
- Evaluasi proses pengembangan
- Identifikasi area improvement

### 6.2. Metode Riset

Meskipun proyek ini fokus pada pengembangan sistem, beberapa aspek riset akan dilakukan:

1. **Literature Review**: Studi literatur mengenai best practices dalam pengembangan sistem manajemen magang dan sistem manajemen sumber daya manusia
2. **User Research**: Wawancara dan survei dengan stakeholder untuk memahami kebutuhan dan pain points
3. **Usability Testing**: Pengujian usability dengan pengguna untuk memastikan sistem mudah digunakan

### 6.3. Tools yang Digunakan

**Development Tools:**
- **Framework**: Laravel 12 (PHP 8.2+)
- **Frontend**: HTML, CSS, JavaScript, Blade Template Engine
- **Database**: SQLite (development), MySQL/PostgreSQL (production)
- **Version Control**: Git
- **Package Manager**: Composer (PHP), npm (JavaScript)

**Libraries dan Packages:**
- **PDF Generation**: DomPDF (barryvdh/laravel-dompdf)
- **Excel Export**: Maatwebsite Excel (maatwebsite/excel)
- **Two-Factor Authentication**: Google2FA (pragmarx/google2fa)
- **QR Code**: SimpleSoftwareIO QR Code

**Development Environment:**
- **IDE**: Visual Studio Code / PhpStorm
- **Local Server**: Laravel Sail / XAMPP
- **Browser DevTools**: Chrome DevTools, Firefox Developer Tools

**Project Management:**
- **Task Management**: Trello / Jira / GitHub Projects
- **Documentation**: Markdown, Confluence / Notion
- **Communication**: Slack / Discord / Microsoft Teams

**Testing Tools:**
- **Unit Testing**: PHPUnit
- **Browser Testing**: Manual testing dengan berbagai browser
- **Performance Testing**: Apache Bench / Load Testing Tools

### 6.4. Tahapan Pengerjaan

**Tahap 1: Analisis (2-3 minggu)**
- Analisis kebutuhan stakeholder
- Analisis proses bisnis AS-IS dan TO-BE
- Penyusunan Business Requirement Specification (BRS)
- Penyusunan Software Requirement Specification (SRS)
- Desain database dan arsitektur sistem
- Perencanaan sprint dan task breakdown

**Tahap 2: Desain (2-3 minggu)**
- Desain User Interface (UI) dan User Experience (UX)
- Desain database schema
- Desain arsitektur aplikasi
- Desain API dan integrasi antar modul
- Penyusunan Software Design Document (SDD)
- Pembuatan mockup dan prototype

**Tahap 3: Implementasi (8-10 minggu)**
- Setup development environment
- Implementasi modul autentikasi dan manajemen pengguna
- Implementasi modul manajemen organisasi
- Implementasi modul pengajuan magang
- Implementasi modul manajemen dokumen
- Implementasi modul penugasan dan penilaian
- Implementasi modul absensi
- Implementasi modul logbook
- Implementasi modul pelaporan
- Implementasi modul manajemen sertifikat
- Implementasi Two-Factor Authentication
- Implementasi dashboard dan statistik

**Tahap 4: Testing (3-4 minggu)**
- Unit testing untuk setiap modul
- Integration testing antar modul
- System testing untuk keseluruhan sistem
- User Acceptance Testing (UAT) dengan stakeholder
- Performance testing
- Security testing
- Bug fixing dan refinement

**Tahap 5: Deployment (1-2 minggu)**
- Setup production environment
- Deployment aplikasi ke server production
- Konfigurasi database production
- Migration data (jika ada)
- User training untuk administrator dan pengguna
- Go-live dan monitoring

**Tahap 6: Dokumentasi dan Laporan (2-3 minggu)**
- Penyusunan User Guide/Manual
- Penyusunan dokumentasi teknis
- Penyusunan laporan akhir capstone
- Penyusunan presentasi
- Final review dan submission

---

## 7. PROPOSED SYSTEM OVERVIEW

### 7.1. Gambaran Umum Sistem

Sistem Manajemen Magang Berbasis Web adalah aplikasi web yang dirancang untuk mengelola seluruh siklus program magang mulai dari proses pengajuan hingga penerbitan sertifikat. Sistem ini dibangun menggunakan framework Laravel dengan arsitektur MVC (Model-View-Controller) yang memungkinkan pemisahan yang jelas antara logika bisnis, presentasi, dan data.

**Alur Proses Dasar Sistem:**

**Input Sistem:**
- Data registrasi pengguna (nama, email, NIM, universitas, dll)
- Dokumen persyaratan magang (CV, KTM, Surat Permohonan, Surat Keterangan Baik)
- Data pengajuan magang (divisi, bidang peminatan, tanggal mulai dan akhir)
- Data penugasan (judul, deskripsi, deadline)
- File tugas yang dikumpulkan peserta
- Data absensi (foto check-in, waktu, alasan absensi)
- Entri logbook (tanggal, konten aktivitas)
- Data penilaian (nilai, feedback, predikat)
- Data sertifikat (nomor sertifikat, predikat, tanggal terbit)

**Proses Sistem:**
- Validasi dan verifikasi data input
- Penyimpanan dokumen ke storage sistem
- Notifikasi otomatis dalam aplikasi
- Upload dokumen (surat penerimaan, sertifikat) oleh Admin
- Perhitungan statistik dan analitik
- Generasi laporan dalam format PDF dan Excel
- Autentikasi dan autorisasi pengguna
- Enkripsi data sensitif

**Output Sistem:**
- Dashboard dengan informasi real-time
- Status pengajuan magang
- Surat penerimaan magang (PDF)
- Sertifikat magang (PDF)
- Laporan peserta magang (PDF/Excel)
- Laporan penilaian (PDF/Excel)
- Statistik dan grafik analitik
- Notifikasi dalam aplikasi

### 7.2. Fitur Utama Sistem

1. **Manajemen Pengguna dan Autentikasi**
   - Sistem registrasi dan login dengan validasi
   - Manajemen role pengguna (Admin, Mentor, Peserta)
   - Two-Factor Authentication (2FA) untuk Mentor dan Peserta
   - Manajemen profil pengguna
   - Reset password

2. **Manajemen Pengajuan Magang**
   - Form pengajuan magang online
   - Upload dokumen persyaratan dengan validasi
   - Tracking status pengajuan secara real-time
   - Proses approval/rejection oleh Admin
   - Notifikasi status pengajuan dalam aplikasi

3. **Manajemen Dokumen**
   - Upload dan download dokumen
   - Penyimpanan dokumen terpusat
   - Preview dokumen
   - Upload surat penerimaan magang oleh Admin
   - Upload sertifikat magang oleh Admin

4. **Manajemen Penugasan**
   - Pembuatan penugasan oleh Mentor
   - Pengumpulan tugas oleh Peserta
   - Penilaian dan feedback oleh Mentor
   - Sistem revisi tugas
   - Notifikasi deadline tugas

5. **Sistem Absensi Digital**
   - Check-in dengan foto dan timestamp
   - Absensi dengan alasan dan bukti
   - Monitoring absensi oleh Mentor dan Admin
   - Laporan absensi per periode
   - Statistik kehadiran

6. **Logbook Digital**
   - Pencatatan aktivitas harian
   - Review logbook oleh Mentor
   - Filter dan pencarian logbook
   - Export logbook ke PDF

7. **Sistem Pelaporan**
   - Laporan peserta magang dengan filter
   - Laporan penilaian oleh Mentor
   - Export laporan ke PDF dan Excel
   - Dashboard statistik dan analitik
   - Grafik dan visualisasi data

8. **Manajemen Organisasi**
   - Manajemen divisi
   - Manajemen bidang peminatan
   - Manajemen Mentor per Divisi

9. **Dashboard dan Monitoring**
   - Dashboard khusus untuk setiap role
   - Statistik real-time
   - Grafik dan visualisasi data
   - Notifikasi dan alert

10. **Keamanan Sistem**
    - Enkripsi password
    - Two-Factor Authentication
    - Session management
    - CSRF protection
    - Input validation dan sanitization

---

## 8. PROJECT DELIVERABLES

### 8.1. Dokumen

1. **Business Requirement Specification (BRS)**
   - Dokumen spesifikasi kebutuhan bisnis
   - Deskripsi proses bisnis AS-IS dan TO-BE
   - Business goals dan business rules

2. **Software Requirement Specification (SRS)**
   - Dokumen spesifikasi kebutuhan perangkat lunak
   - Functional requirements dan non-functional requirements
   - Use case diagrams dan user stories
   - Acceptance criteria

3. **Software Design Document (SDD)**
   - Dokumen desain perangkat lunak
   - Arsitektur sistem
   - Database design (ERD, schema)
   - UI/UX design (mockup, wireframe)
   - API documentation

4. **User Acceptance Test (UAT) Document**
   - Test plan dan test cases
   - Test results dan bug reports
   - Sign-off dari stakeholder

5. **User Guide/Manual**
   - Panduan penggunaan untuk Admin
   - Panduan penggunaan untuk Mentor
   - Panduan penggunaan untuk Peserta
   - FAQ (Frequently Asked Questions)

6. **Technical Documentation**
   - Dokumentasi kode (code comments)
   - API documentation
   - Database documentation
   - Deployment guide

7. **Laporan Akhir Capstone**
   - Laporan lengkap proyek
   - Analisis dan evaluasi hasil
   - Kesimpulan dan saran

### 8.2. Produk (Aplikasi)

1. **Aplikasi Web Sistem Manajemen Magang**
   - Source code aplikasi lengkap
   - Database schema dan migration files
   - Seeders untuk data awal
   - File konfigurasi

2. **Prototype/Mockup**
   - UI/UX mockup
   - Interactive prototype (jika ada)

### 8.3. Dataset (jika ada)

1. **Sample Data**
   - Sample data untuk testing
   - Dummy data untuk development

### 8.4. Presentasi

1. **Slide Presentasi**
   - Presentasi proposal (jika diperlukan)
   - Presentasi progress (mid-term)
   - Presentasi final/demo

2. **Demo Video** (opsional)
   - Video demo aplikasi
   - Video tutorial penggunaan

3. **Poster** (jika diperlukan)
   - Poster proyek untuk pameran/exhibition

---

## 9. PROJECT TIMELINE

| No | Tahapan Kegiatan | Durasi | PIC | Keterangan |
|---|---|---|---|---|
| 1 | **Analisis** | 3 minggu | System Analyst, Business Analyst | |
| 1.1 | Analisis kebutuhan stakeholder | 1 minggu | Business Analyst | |
| 1.2 | Analisis proses bisnis AS-IS dan TO-BE | 1 minggu | Business Analyst, System Analyst | |
| 1.3 | Penyusunan BRS dan SRS | 1 minggu | System Analyst | |
| 2 | **Desain** | 3 minggu | System Analyst, Front-end Developer | |
| 2.1 | Desain database dan arsitektur sistem | 1 minggu | System Analyst | |
| 2.2 | Desain UI/UX dan mockup | 1.5 minggu | Front-end Developer | |
| 2.3 | Penyusunan SDD | 0.5 minggu | System Analyst | |
| 3 | **Implementasi - Sprint 1** | 2 minggu | Front-end Developer, Back-end Developer | |
| 3.1 | Setup environment dan modul autentikasi | 1 minggu | Back-end Developer | |
| 3.2 | Modul manajemen pengguna dan organisasi | 1 minggu | Front-end Developer, Back-end Developer | |
| 4 | **Implementasi - Sprint 2** | 2 minggu | Front-end Developer, Back-end Developer | |
| 4.1 | Modul pengajuan magang | 1.5 minggu | Front-end Developer, Back-end Developer | |
| 4.2 | Modul manajemen dokumen | 0.5 minggu | Back-end Developer | |
| 5 | **Implementasi - Sprint 3** | 2 minggu | Front-end Developer, Back-end Developer | |
| 5.1 | Modul penugasan dan penilaian | 1.5 minggu | Front-end Developer, Back-end Developer | |
| 5.2 | Modul absensi | 0.5 minggu | Front-end Developer, Back-end Developer | |
| 6 | **Implementasi - Sprint 4** | 2 minggu | Front-end Developer, Back-end Developer | |
| 6.1 | Modul logbook | 0.5 minggu | Front-end Developer, Back-end Developer | |
| 6.2 | Modul pelaporan | 1 minggu | Back-end Developer | |
| 6.3 | Modul sertifikat | 0.5 minggu | Back-end Developer | |
| 7 | **Implementasi - Sprint 5** | 2 minggu | Front-end Developer, Back-end Developer | |
| 7.1 | Two-Factor Authentication | 0.5 minggu | Back-end Developer | |
| 7.2 | Dashboard dan statistik | 1 minggu | Front-end Developer, Back-end Developer | |
| 7.3 | Refinement dan bug fixing | 0.5 minggu | Front-end Developer, Back-end Developer | |
| 8 | **Testing** | 3 minggu | System/Software Tester, Tim Developer | |
| 8.1 | Unit testing dan integration testing | 1.5 minggu | System/Software Tester | |
| 8.2 | System testing | 0.5 minggu | System/Software Tester | |
| 8.3 | User Acceptance Testing (UAT) | 1 minggu | System/Software Tester, Stakeholder | |
| 9 | **Deployment** | 1.5 minggu | Back-end Developer, Project Manager | |
| 9.1 | Setup production environment | 0.5 minggu | Back-end Developer | |
| 9.2 | Deployment dan konfigurasi | 0.5 minggu | Back-end Developer | |
| 9.3 | User training | 0.5 minggu | Project Manager | |
| 10 | **Dokumentasi dan Laporan** | 2.5 minggu | Semua Tim | |
| 10.1 | Penyusunan User Guide | 0.5 minggu | Business Analyst | |
| 10.2 | Penyusunan dokumentasi teknis | 0.5 minggu | System Analyst | |
| 10.3 | Penyusunan laporan akhir | 1 minggu | Project Manager | |
| 10.4 | Penyusunan presentasi | 0.5 minggu | Semua Tim | |
| **TOTAL** | | **20 minggu** | | |

**Catatan:**
- Timeline dapat disesuaikan berdasarkan kebutuhan dan ketersediaan tim
- Setiap sprint diakhiri dengan review dan retrospective
- Testing dilakukan secara parallel dengan development pada sprint terakhir
- Buffer time disediakan untuk mengatasi delay yang tidak terduga

---

## 10. TEAM MEMBERS AND ROLES

### 10.1. Project Manager
**Tanggung Jawab:**
- Mengelola keseluruhan proyek dari awal hingga akhir
- Mengkoordinasikan komunikasi antar tim dan stakeholder
- Mengelola timeline dan resources
- Mengidentifikasi dan mengelola risiko proyek
- Memastikan deliverable sesuai dengan requirement
- Menjadi point of contact utama dengan stakeholder

**Keterampilan yang Diperlukan:**
- Project management
- Communication skills
- Leadership
- Problem-solving
- Risk management

### 10.2. System Analyst
**Tanggung Jawab:**
- Menganalisis kebutuhan bisnis dan teknis
- Menyusun BRS, SRS, dan SDD
- Merancang arsitektur sistem dan database
- Mendefinisikan functional dan non-functional requirements
- Membuat use case diagrams dan user stories
- Memastikan solusi teknis sesuai dengan kebutuhan bisnis

**Keterampilan yang Diperlukan:**
- System analysis
- Database design
- Software architecture
- Documentation
- Business process analysis

### 10.3. Front-end Developer
**Tanggung Jawab:**
- Mengimplementasikan user interface berdasarkan desain UI/UX
- Mengembangkan komponen frontend menggunakan HTML, CSS, JavaScript
- Mengintegrasikan frontend dengan backend API
- Memastikan responsivitas aplikasi untuk berbagai device
- Melakukan optimasi performa frontend
- Memastikan kompatibilitas dengan berbagai browser

**Keterampilan yang Diperlukan:**
- HTML, CSS, JavaScript
- Laravel Blade Template
- Responsive design
- UI/UX principles
- Browser compatibility

### 10.4. Back-end Developer
**Tanggung Jawab:**
- Mengimplementasikan logika bisnis dan API
- Mengembangkan modul-modul backend menggunakan Laravel
- Merancang dan mengimplementasikan database schema
- Mengintegrasikan dengan library eksternal (PDF, Excel, 2FA)
- Mengoptimalkan performa dan keamanan aplikasi
- Melakukan code review dan refactoring

**Keterampilan yang Diperlukan:**
- PHP dan Laravel Framework
- Database design dan SQL
- RESTful API development
- Security best practices
- Code optimization

### 10.5. System/Software Tester
**Tanggung Jawab:**
- Menyusun test plan dan test cases
- Melakukan unit testing, integration testing, dan system testing
- Melakukan User Acceptance Testing (UAT) dengan stakeholder
- Mengidentifikasi dan melaporkan bug
- Memverifikasi bug fixes
- Menyusun test documentation dan reports

**Keterampilan yang Diperlukan:**
- Software testing methodologies
- Test case design
- Bug tracking
- Test automation (jika diperlukan)
- Documentation

### 10.6. Business Analyst & Marketing Specialist
**Tanggung Jawab:**
- Menganalisis kebutuhan bisnis dari perspektif stakeholder
- Melakukan wawancara dan survei dengan pengguna
- Menyusun user guide dan dokumentasi pengguna
- Membantu dalam User Acceptance Testing
- Membuat materi presentasi dan marketing (jika diperlukan)
- Mengumpulkan feedback pengguna untuk improvement

**Keterampilan yang Diperlukan:**
- Business analysis
- User research
- Documentation
- Communication skills
- Presentation skills

**Catatan:**
- Satu orang dapat memegang multiple roles jika tim kecil
- Kolaborasi antar role sangat penting untuk kesuksesan proyek
- Regular meeting dan communication diperlukan untuk koordinasi

---

## 11. REFERENCES

1. Laravel Documentation. (2024). *Laravel - The PHP Framework for Web Artisans*. Retrieved from https://laravel.com/docs

2. Smith, J., & Johnson, A. (2022). Digital Transformation in Human Resource Management: A Case Study of Internship Management Systems. *International Journal of Information Management*, 45(3), 123-145. https://doi.org/10.1016/j.ijinfomgt.2022.03.001

3. Brown, M., & Davis, K. (2023). Best Practices in Web-Based Management Systems for Educational Institutions. *Journal of Educational Technology Systems*, 51(2), 234-256. https://doi.org/10.1177/00472395221123456

4. Agile Alliance. (2024). *Agile Manifesto*. Retrieved from https://agilemanifesto.org/

5. Scrum.org. (2024). *The Scrum Guide*. Retrieved from https://www.scrum.org/resources/scrum-guide

6. Microsoft. (2023). *Security Best Practices for Web Applications*. Retrieved from https://docs.microsoft.com/en-us/azure/security/

7. OWASP Foundation. (2024). *OWASP Top 10 - The Ten Most Critical Web Application Security Risks*. Retrieved from https://owasp.org/www-project-top-ten/

8. Nielsen, J., & Budiu, R. (2022). *Mobile Usability*. New Riders Publishing.

9. Krug, S. (2014). *Don't Make Me Think: A Common Sense Approach to Web Usability* (3rd ed.). New Riders Publishing.

10. PHP The Right Way. (2024). *PHP: The Right Way*. Retrieved from https://phptherightway.com/

11. Maatwebsite Excel Documentation. (2024). *Laravel Excel - Supercharged Excel exports and imports in Laravel*. Retrieved from https://docs.laravel-excel.com/

12. DomPDF Documentation. (2024). *Laravel DomPDF - PDF generation for Laravel*. Retrieved from https://github.com/barryvdh/laravel-dompdf

13. Google2FA Documentation. (2024). *Google2FA - Two Factor Authentication Package for Laravel*. Retrieved from https://github.com/antonioribeiro/google2fa

14. W3Schools. (2024). *HTML, CSS, JavaScript Tutorials*. Retrieved from https://www.w3schools.com/

15. MDN Web Docs. (2024). *Web Technologies Documentation*. Retrieved from https://developer.mozilla.org/

16. Stack Overflow. (2024). *Laravel Community Q&A*. Retrieved from https://stackoverflow.com/questions/tagged/laravel

17. Laracasts. (2024). *Laravel Video Tutorials*. Retrieved from https://laracasts.com/

18. GitHub. (2024). *Laravel Framework Repository*. Retrieved from https://github.com/laravel/framework

19. PHPUnit Documentation. (2024). *PHPUnit - The PHP Testing Framework*. Retrieved from https://phpunit.de/documentation.html

20. IEEE Computer Society. (2024). *IEEE Software Engineering Standards*. Retrieved from https://www.computer.org/

---

**Catatan:** Dokumen proposal ini dapat disesuaikan dan diperbarui sesuai dengan perkembangan proyek dan feedback dari stakeholder.

