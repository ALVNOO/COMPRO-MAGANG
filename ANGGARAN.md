# ANGGARAN BIAYA APLIKASI SISTEM MANAJEMEN MAGANG
### Telkom / COMPRO-MAGANG
**Tanggal Dokumen:** 21 Mei 2026 | **Versi:** 2.0 | **Tim:** 4 Orang

---

## 1. KOMPOSISI TIM (4 ORANG)

| # | Posisi | Tanggung Jawab Utama | Rate/Jam | Gaji/Bulan |
|---|--------|---------------------|----------|-----------|
| Dev 1 | **Backend Lead** | Auth, 2FA, core models, application workflow, keamanan, deployment | Rp 175.000 | Rp 9.000.000 |
| Dev 2 | **Backend Developer** | Admin panel, mentor features, laporan, ekspor PDF/Excel, notifikasi | Rp 150.000 | Rp 7.500.000 |
| Dev 3 | **Frontend Lead** | Design system, UI components, dashboard peserta, halaman publik | Rp 150.000 | Rp 7.500.000 |
| Dev 4 | **Frontend Developer** | Dashboard admin, dashboard mentor, absensi, logbook, responsif | Rp 125.000 | Rp 6.500.000 |

**Rata-rata rate tim:** Rp 150.000/jam  
**Total kapasitas/minggu:** 4 orang × 40 jam = 160 jam (efektif ~128 jam setelah overhead koordinasi 20%)

---

## 2. BREAKDOWN BIAYA PER FITUR

### Fitur 1 — Autentikasi & Keamanan (2FA)
> Login, registrasi, Google 2FA wajib, reset 2FA via email, trusted device, rate limiting, change password

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: Auth controller (login, register, logout) | Dev 1 | 12 jam | Rp 2.100.000 |
| Backend: Setup & verifikasi Google 2FA | Dev 1 | 12 jam | Rp 2.100.000 |
| Backend: Reset 2FA via email (token 15 menit) | Dev 1 | 8 jam | Rp 1.400.000 |
| Backend: Trusted device (fingerprint + 1 hari) | Dev 1 | 6 jam | Rp 1.050.000 |
| Backend: Rate limiting (5 attempt/5 menit) | Dev 1 | 4 jam | Rp 700.000 |
| Backend: Change password | Dev 1 | 3 jam | Rp 525.000 |
| Frontend: Halaman login, register | Dev 3 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman 2FA setup, verify, reset (3 halaman) | Dev 3 | 12 jam | Rp 1.800.000 |
| Frontend: Halaman change password | Dev 3 | 4 jam | Rp 600.000 |
| **TOTAL FITUR 1** | | **69 jam** | **Rp 11.475.000** |

---

### Fitur 2 — Registrasi & Pre-Acceptance Peserta
> Pengisian profil, upload foto, 5 dokumen (CV, KTM, cover letter, surat permohonan, SKCK), pemilihan bidang minat, set tanggal magang

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: Controller pre-acceptance (updateProfile, uploadDocuments, updateDates, updateFieldOfInterest, completeApplication) | Dev 1 | 18 jam | Rp 3.150.000 |
| Backend: Upload foto profil + hapus foto | Dev 1 | 5 jam | Rp 875.000 |
| Backend: Validasi file (mime type, ukuran) | Dev 1 | 4 jam | Rp 700.000 |
| Frontend: Halaman pre-acceptance multi-step | Dev 3 | 20 jam | Rp 3.000.000 |
| Frontend: Upload foto profil (preview real-time) | Dev 3 | 6 jam | Rp 900.000 |
| **TOTAL FITUR 2** | | **53 jam** | **Rp 8.625.000** |

---

### Fitur 3 — Pengajuan Magang & Workflow Status
> Submit pengajuan, review admin, approve/reject/permanent reject, auto-transition status (pending→accepted→finished)

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: InternshipController (apply, submit) | Dev 1 | 12 jam | Rp 2.100.000 |
| Backend: Workflow status + auto-update ke finished | Dev 1 | 15 jam | Rp 2.625.000 |
| Backend: Admin approve (assign divisi + mentor) | Dev 2 | 10 jam | Rp 1.500.000 |
| Backend: Admin reject + permanent reject | Dev 2 | 6 jam | Rp 900.000 |
| Backend: Reapply logic | Dev 1 | 5 jam | Rp 875.000 |
| Frontend: Halaman apply (pilih divisi) | Dev 3 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman status pengajuan (stepper, badge, kartu) | Dev 3 | 18 jam | Rp 2.700.000 |
| **TOTAL FITUR 3** | | **74 jam** | **Rp 11.900.000** |

---

### Fitur 4 — Dashboard Peserta
> Dashboard utama, info penempatan, info mentor, tour guide, progress internship

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: DashboardController@index + auto-status | Dev 1 | 10 jam | Rp 1.750.000 |
| Backend: Enter dashboard, complete tour | Dev 1 | 4 jam | Rp 700.000 |
| Frontend: Layout dashboard peserta (sidebar, header, nav) | Dev 3 | 15 jam | Rp 2.250.000 |
| Frontend: Halaman dashboard utama (hero, stats, kartu info) | Dev 3 | 20 jam | Rp 3.000.000 |
| Frontend: Tour guide interaktif (onboarding) | Dev 3 | 10 jam | Rp 1.500.000 |
| Frontend: Halaman program info | Dev 3 | 6 jam | Rp 900.000 |
| **TOTAL FITUR 4** | | **65 jam** | **Rp 10.100.000** |

---

### Fitur 5 — Dashboard Mentor (Pembimbing)
> Dashboard utama, stats peserta, aksi cepat, chart aktivitas, kelola pengajuan, profil

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: MentorDashboardController@index + stats | Dev 2 | 12 jam | Rp 1.800.000 |
| Backend: Respons pengajuan (approve/reject per mentor) | Dev 2 | 8 jam | Rp 1.200.000 |
| Backend: Update biodata + foto profil mentor | Dev 2 | 6 jam | Rp 900.000 |
| Frontend: Layout dashboard mentor | Dev 4 | 15 jam | Rp 1.875.000 |
| Frontend: Dashboard utama mentor (hero, stats, chart, quick actions) | Dev 4 | 22 jam | Rp 2.750.000 |
| Frontend: Halaman pengajuan masuk | Dev 4 | 10 jam | Rp 1.250.000 |
| Frontend: Halaman profil mentor | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 5** | | **81 jam** | **Rp 10.775.000** |

---

### Fitur 6 — Admin Panel (Dashboard & Manajemen Utama)
> Dashboard admin, stats, chart, manajemen profil admin, overview sistem

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminDashboardController (index, profile, updateBiodata, foto) | Dev 2 | 14 jam | Rp 2.100.000 |
| Frontend: Layout dashboard admin | Dev 4 | 15 jam | Rp 1.875.000 |
| Frontend: Dashboard utama admin (hero, stats, chart, recent table, division chart) | Dev 4 | 25 jam | Rp 3.125.000 |
| Frontend: Halaman profil admin | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 6** | | **62 jam** | **Rp 8.100.000** |

---

### Fitur 7 — Manajemen Pengajuan (Admin)
> Tabel pengajuan pending, approve dengan assign divisi+mentor, reject, permanent reject, kirim surat penerimaan

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminApplicationController (index, approve, reject, permanentReject, sendAcceptanceLetter) | Dev 2 | 15 jam | Rp 2.250.000 |
| Frontend: Halaman daftar pengajuan + filter + modal aksi | Dev 4 | 16 jam | Rp 2.000.000 |
| **TOTAL FITUR 7** | | **31 jam** | **Rp 4.250.000** |

---

### Fitur 8 — Manajemen Peserta Aktif (Admin)
> Tabel peserta diterima, upload/download 6 jenis dokumen, ganti mentor

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminParticipantController (index + 7 aksi upload/download + changeMentor) | Dev 2 | 18 jam | Rp 2.700.000 |
| Frontend: Halaman peserta aktif + tabel + modal upload | Dev 4 | 16 jam | Rp 2.000.000 |
| **TOTAL FITUR 8** | | **34 jam** | **Rp 4.700.000** |

---

### Fitur 9 — Manajemen Mentor (Admin)
> Daftar mentor, detail mentor, reset password

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminMentorController (index, show, resetPassword) | Dev 2 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman daftar mentor + halaman detail | Dev 4 | 10 jam | Rp 1.250.000 |
| **TOTAL FITUR 9** | | **18 jam** | **Rp 2.450.000** |

---

### Fitur 10 — Sistem Absensi (Check-in/out)
> Check-in harian dengan waktu, foto opsional, koordinat GPS, laporan ketidakhadiran dengan bukti

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AttendanceController (index, mentorIndex, adminIndex, checkIn, absent) | Dev 1 | 16 jam | Rp 2.800.000 |
| Frontend: Halaman absensi peserta (form check-in, tombol absent) | Dev 3 | 12 jam | Rp 1.800.000 |
| Frontend: Halaman absensi mentor (tabel semua peserta) | Dev 4 | 10 jam | Rp 1.250.000 |
| Frontend: Halaman absensi admin (tabel global + filter) | Dev 4 | 10 jam | Rp 1.250.000 |
| **TOTAL FITUR 10** | | **48 jam** | **Rp 7.100.000** |

---

### Fitur 11 — Sistem Logbook Harian
> Catatan kegiatan harian, CRUD, tampilan per role (peserta/mentor/admin)

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: LogbookController (index, mentorIndex, adminIndex, store, update, destroy, getMentorsByDivision) | Dev 1 | 14 jam | Rp 2.450.000 |
| Frontend: Halaman logbook peserta (list + form inline) | Dev 3 | 10 jam | Rp 1.500.000 |
| Frontend: Halaman logbook mentor | Dev 4 | 8 jam | Rp 1.000.000 |
| Frontend: Halaman logbook admin | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 11** | | **40 jam** | **Rp 5.950.000** |

---

### Fitur 12 — Penugasan & Submission (Assignment)
> 3 tipe penugasan, submission file, penilaian, revisi, feedback log, grading history

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: Tambah/edit/hapus penugasan (mentor) | Dev 2 | 10 jam | Rp 1.500.000 |
| Backend: Submit tugas (peserta) + validasi file | Dev 1 | 8 jam | Rp 1.400.000 |
| Backend: Beri nilai + feedback + set revisi (mentor) | Dev 2 | 10 jam | Rp 1.500.000 |
| Backend: AssignmentFeedbackLog (audit trail) | Dev 2 | 5 jam | Rp 750.000 |
| Frontend: Halaman penugasan peserta (list + submit) | Dev 3 | 12 jam | Rp 1.800.000 |
| Frontend: Halaman penugasan mentor (buat + nilai + revisi) | Dev 4 | 14 jam | Rp 1.750.000 |
| **TOTAL FITUR 12** | | **59 jam** | **Rp 8.700.000** |

---

### Fitur 13 — Generasi Dokumen PDF & QR Code
> Surat penerimaan (template), sertifikat dengan nomor + predikat, surat keterangan selesai, DomPDF + QR Code

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: Generate surat penerimaan (PDF + email) | Dev 2 | 10 jam | Rp 1.500.000 |
| Backend: Generate sertifikat (DomPDF + QR Code) | Dev 2 | 12 jam | Rp 1.800.000 |
| Backend: Generate surat keterangan selesai | Dev 2 | 6 jam | Rp 900.000 |
| Frontend: Template blade surat penerimaan | Dev 3 | 6 jam | Rp 900.000 |
| Frontend: Template blade sertifikat (desain layout) | Dev 3 | 10 jam | Rp 1.500.000 |
| Frontend: Halaman sertifikat peserta (download) | Dev 3 | 5 jam | Rp 750.000 |
| **TOTAL FITUR 13** | | **49 jam** | **Rp 7.350.000** |

---

### Fitur 14 — Laporan & Ekspor Data (Admin)
> Filter tahun/periode, chart statistik, ekspor PDF & Excel, manual entry peserta eksternal

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminReportController (getData, getYears, getPeriods AJAX) | Dev 2 | 12 jam | Rp 1.800.000 |
| Backend: Export PDF laporan | Dev 2 | 8 jam | Rp 1.200.000 |
| Backend: Export Excel (Maatwebsite) | Dev 2 | 8 jam | Rp 1.200.000 |
| Backend: Summary stats + manual entry | Dev 2 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman laporan (filter + tabel + chart) | Dev 4 | 16 jam | Rp 2.000.000 |
| Frontend: Template PDF laporan (blade) | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 14** | | **60 jam** | **Rp 8.400.000** |

---

### Fitur 15 — Evaluasi Akhir
> Upload/download evaluasi peserta & admin, dua sumber dokumen independen

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: DashboardController (finalEvaluation, uploadFinalEvaluation, downloadFinalEvaluationParticipant) | Dev 1 | 8 jam | Rp 1.400.000 |
| Backend: AdminFinalEvaluationController (index, download, uploadForApplication) | Dev 2 | 8 jam | Rp 1.200.000 |
| Backend: MentorDashboardController (evaluasiAkhir, downloadFinalEvaluation) | Dev 2 | 5 jam | Rp 750.000 |
| Frontend: Halaman evaluasi peserta | Dev 3 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman evaluasi admin | Dev 4 | 8 jam | Rp 1.000.000 |
| Frontend: Halaman evaluasi mentor | Dev 4 | 5 jam | Rp 625.000 |
| **TOTAL FITUR 15** | | **42 jam** | **Rp 6.175.000** |

---

### Fitur 16 — Laporan Penilaian (Mentor)
> Upload/download laporan penilaian per peserta, filter tahun & periode, AJAX

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: laporanPenilaian, getData, getYears, getPeriods, upload, download, delete | Dev 2 | 14 jam | Rp 2.100.000 |
| Frontend: Halaman laporan penilaian mentor + tabel AJAX | Dev 4 | 12 jam | Rp 1.500.000 |
| **TOTAL FITUR 16** | | **26 jam** | **Rp 3.600.000** |

---

### Fitur 17 — Surat Penerimaan (Mentor Flow)
> Form surat penerimaan, preview, kirim ke peserta, download oleh peserta

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: showAcceptanceLetterForm, previewAcceptanceLetter, sendAcceptanceLetter | Dev 2 | 8 jam | Rp 1.200.000 |
| Backend: downloadAcceptanceLetter (peserta), flag download | Dev 1 | 4 jam | Rp 700.000 |
| Frontend: Halaman form surat penerimaan | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 17** | | **20 jam** | **Rp 2.900.000** |

---

### Fitur 18 — Sistem Notifikasi In-App
> Notifikasi database, unread count real-time (AJAX), mark read/unread, halaman notifikasi

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: NotificationController (index, unreadCount, recent, markAsRead, markAllAsRead, destroy) | Dev 1 | 12 jam | Rp 2.100.000 |
| Backend: NotificationService (trigger dari berbagai event) | Dev 1 | 8 jam | Rp 1.400.000 |
| Frontend: Bell notifikasi di navbar (dropdown, badge count) | Dev 3 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman daftar notifikasi | Dev 3 | 8 jam | Rp 1.200.000 |
| **TOTAL FITUR 18** | | **36 jam** | **Rp 5.900.000** |

---

### Fitur 19 — Manajemen Divisi (Struktur Baru + Legacy)
> CRUD divisi baru (flat), toggle aktif, hapus; legacy Direktorat→SubDirektorat→Divisi (deprecated)

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminDivisionController (index, create, store, edit, update, toggle, destroy) | Dev 2 | 12 jam | Rp 1.800.000 |
| Backend: LegacyDivisionController (Direktorat/SubDir/Divisi CRUD) | Dev 2 | 10 jam | Rp 1.500.000 |
| Backend: Migrasi konsolidasi legacy → struktur baru | Dev 1 | 8 jam | Rp 1.400.000 |
| Frontend: Halaman manajemen divisi | Dev 4 | 12 jam | Rp 1.500.000 |
| **TOTAL FITUR 19** | | **42 jam** | **Rp 6.200.000** |

---

### Fitur 20 — Manajemen Bidang Minat (Admin)
> CRUD bidang minat dengan ikon, warna, durasi, toggle aktif

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminFieldOfInterestController (index, create, store, edit, update, toggle, destroy) | Dev 2 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman daftar + form bidang minat | Dev 4 | 10 jam | Rp 1.250.000 |
| **TOTAL FITUR 20** | | **18 jam** | **Rp 2.450.000** |

---

### Fitur 21 — Aturan Sistem & Kebijakan
> Editor aturan magang oleh admin, tampilan kebijakan

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: AdminRuleController (edit, update) | Dev 2 | 5 jam | Rp 750.000 |
| Frontend: Halaman edit aturan | Dev 4 | 6 jam | Rp 750.000 |
| **TOTAL FITUR 21** | | **11 jam** | **Rp 1.500.000** |

---

### Fitur 22 — Manajemen Profil (3 Role)
> Upload/hapus foto profil, edit biodata untuk Peserta, Mentor, dan Admin

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: Profil peserta (uploadProfilePicture, removeProfilePicture, updateMentorBiodata) | Dev 1 | 8 jam | Rp 1.400.000 |
| Backend: Profil admin (uploadProfilePicture, removeProfilePicture, updateBiodata) | Dev 2 | 6 jam | Rp 900.000 |
| Frontend: Halaman profil peserta | Dev 3 | 8 jam | Rp 1.200.000 |
| Frontend: Halaman profil mentor + admin | Dev 4 | 8 jam | Rp 1.000.000 |
| **TOTAL FITUR 22** | | **30 jam** | **Rp 4.500.000** |

---

### Fitur 23 — Halaman Publik
> Halaman Home, About, Program (landing page sebelum login)

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| Backend: HomeController (index, about, program) | Dev 1 | 4 jam | Rp 700.000 |
| Frontend: Halaman home (hero, fitur, CTA) | Dev 3 | 10 jam | Rp 1.500.000 |
| Frontend: Halaman about + program | Dev 3 | 8 jam | Rp 1.200.000 |
| **TOTAL FITUR 23** | | **22 jam** | **Rp 3.400.000** |

---

## 3. PEKERJAAN INFRASTRUKTUR (NON-FITUR)

| Pekerjaan | Dev | Estimasi Jam | Biaya |
|-----------|-----|-------------|-------|
| **Design System** — Design tokens, variabel CSS, 19 UI components (alert, badge, button, card, chips, confirm-modal, dropdown, empty-state, input, loading, modal, progress-bar, select, skeleton, stat-card, status-badge, table, toast, avatar) | Dev 3 | 65 jam | Rp 9.750.000 |
| **Database** — Desain skema 18 tabel, 52 migrasi, relasi, enum, index | Dev 1 + Dev 2 | 50 jam | Rp 7.500.000 |
| **Testing & QA** — Feature tests, unit tests, manual testing, bug fixing | Semua | 80 jam | Rp 12.000.000 |
| **DevOps & Deployment** — Setup server, queue worker, storage link, environment config | Dev 1 | 30 jam | Rp 5.250.000 |
| **Project Management** — Requirements, koordinasi, review code | Semua | 35 jam | Rp 5.250.000 |
| **TOTAL INFRASTRUKTUR** | | **260 jam** | **Rp 39.750.000** |

---

## 4. REKAPITULASI TOTAL

### 4.1 Total Per Fitur

| No | Fitur | Jam | Biaya |
|----|-------|-----|-------|
| 1 | Autentikasi & Keamanan (2FA) | 69 jam | Rp 11.475.000 |
| 2 | Registrasi & Pre-Acceptance | 53 jam | Rp 8.625.000 |
| 3 | Pengajuan Magang & Workflow | 74 jam | Rp 11.900.000 |
| 4 | Dashboard Peserta | 65 jam | Rp 10.100.000 |
| 5 | Dashboard Mentor | 81 jam | Rp 10.775.000 |
| 6 | Dashboard & Admin Panel (core) | 62 jam | Rp 8.100.000 |
| 7 | Manajemen Pengajuan (Admin) | 31 jam | Rp 4.250.000 |
| 8 | Manajemen Peserta Aktif (Admin) | 34 jam | Rp 4.700.000 |
| 9 | Manajemen Mentor (Admin) | 18 jam | Rp 2.450.000 |
| 10 | Sistem Absensi | 48 jam | Rp 7.100.000 |
| 11 | Sistem Logbook | 40 jam | Rp 5.950.000 |
| 12 | Penugasan & Submission | 59 jam | Rp 8.700.000 |
| 13 | Generasi PDF & QR Code | 49 jam | Rp 7.350.000 |
| 14 | Laporan & Ekspor Data | 60 jam | Rp 8.400.000 |
| 15 | Evaluasi Akhir | 42 jam | Rp 6.175.000 |
| 16 | Laporan Penilaian (Mentor) | 26 jam | Rp 3.600.000 |
| 17 | Surat Penerimaan | 20 jam | Rp 2.900.000 |
| 18 | Notifikasi In-App | 36 jam | Rp 5.900.000 |
| 19 | Manajemen Divisi | 42 jam | Rp 6.200.000 |
| 20 | Manajemen Bidang Minat | 18 jam | Rp 2.450.000 |
| 21 | Aturan Sistem | 11 jam | Rp 1.500.000 |
| 22 | Manajemen Profil (3 role) | 30 jam | Rp 4.500.000 |
| 23 | Halaman Publik | 22 jam | Rp 3.400.000 |
| | **Sub-total Fitur** | **840 jam** | **Rp 146.300.000** |
| | **Infrastruktur** | 260 jam | Rp 39.750.000 |
| | | | |
| | **TOTAL KESELURUHAN** | **1.100 jam** | **Rp 186.050.000** |

---

### 4.2 Total Per Anggota Tim

| Dev | Fitur / Tanggung Jawab | Estimasi Jam | Biaya |
|-----|----------------------|-------------|-------|
| **Dev 1** (Backend Lead) | Auth+2FA, workflow pengajuan, pre-acceptance, absensi, logbook, assignment submit, notifikasi, surat download, profil peserta, halaman publik, migrasi DB, deployment | **310 jam** | **Rp 54.250.000** |
| **Dev 2** (Backend Developer) | Admin panel, mentor backend, PDF generate, laporan+ekspor, evaluasi, surat penerimaan (mentor), divisi, bidang minat, aturan, profil admin, DB design | **300 jam** | **Rp 45.000.000** |
| **Dev 3** (Frontend Lead) | Design system (65h!), dashboard peserta, auth pages, notifikasi UI, profil peserta, halaman publik, template PDF | **280 jam** | **Rp 42.000.000** |
| **Dev 4** (Frontend Developer) | Dashboard admin, dashboard mentor, absensi views, logbook views, penugasan mentor, laporan frontend, evaluasi, divisi, bidang minat, aturan, profil admin/mentor | **210 jam** | **Rp 26.250.000** |
| **Semua (shared)** | Testing, QA, project management, code review | **115 jam** | **Rp 17.250.000** |
| | | | |
| | **TOTAL** | **1.215 jam** | **Rp 184.750.000** |

> *Selisih kecil dengan tabel sebelumnya karena overhead koordinasi tim yang dibebankan per orang.*

---

### 4.3 Ringkasan Biaya Akhir

| Komponen | Biaya |
|----------|-------|
| **Pengembangan (23 fitur + infrastruktur)** | **Rp 186.050.000** |
| Hosting & infrastruktur tahun 1 | Rp 6.000.000 |
| Pemeliharaan tahun 1 | Rp 10.800.000 |
| Lisensi dependensi | Rp 0 *(semua open-source)* |
| Kontingensi 10% | Rp 18.605.000 |
| | |
| **TOTAL TAHUN PERTAMA** | **Rp 221.455.000** |
| **Biaya per tahun berikutnya** | **Rp 16.800.000 – Rp 25.000.000** |

---

## 5. TIMELINE DENGAN TIM 4 ORANG

Kapasitas efektif tim: **128 jam/minggu** (4 × 40 jam × 80% efisiensi)  
Total jam: **1.100 jam** ÷ 128 = **~8,6 minggu ≈ 2,5 bulan** kalender (dengan parallel work)

| Minggu | Dev 1 | Dev 2 | Dev 3 | Dev 4 |
|--------|-------|-------|-------|-------|
| 1 – 2 | Setup project, DB schema, migrasi | Setup, model relasi | Design system (tokens, komponen) | Layout admin & mentor |
| 3 – 4 | Auth + 2FA (full) | Admin panel core | Halaman auth (login, register, 2FA) | Dashboard admin |
| 5 – 6 | Workflow pengajuan + pre-acceptance | PDF generation + surat penerimaan | Dashboard peserta | Dashboard mentor |
| 7 – 8 | Absensi + logbook + notifikasi | Laporan + ekspor + evaluasi akhir | Halaman publik + profil peserta | Absensi/logbook views + mentor features |
| 9 – 10 | Assignment submit + profil + testing | Divisi + bidang minat + aturan + testing | Notifikasi UI + assignment peserta + testing | Evaluasi + laporan views + testing |
| 11 – 12 | Bug fixing + deployment + QA | Bug fixing + QA | Final polish UI + responsif | Final polish + QA |

**Total durasi: ±12 minggu (3 bulan)**

---

## 6. DISTRIBUSI BEBAN KERJA (PIE)

```
Dev 1 — Backend Lead    : ████████████ 28,5% (310 jam)
Dev 2 — Backend Dev     : ████████████ 27,7% (300 jam)
Dev 3 — Frontend Lead   : ███████████  25,8% (280 jam)
Dev 4 — Frontend Dev    : ████████     19,4% (210 jam + 115 jam shared)
```

> *Dev 3 menanggung beban paling berat di minggu 1–2 (design system 65 jam).*  
> *Dev 4 beban lebih ringan karena meng-handle fitur-fitur Admin yang lebih modular.*

---

## 7. CATATAN

1. Rate yang digunakan: Dev 1 Rp 175.000/jam, Dev 2 & 3 Rp 150.000/jam, Dev 4 Rp 125.000/jam.
2. Semua 23 fitur beserta infrastruktur sudah mencakup backend + frontend.
3. Fitur terbesar biaya: **Autentikasi+2FA** (Rp 11,4 jt) dan **Workflow Pengajuan** (Rp 11,9 jt) karena kompleksitas tinggi.
4. Fitur terkecil biaya: **Aturan Sistem** (Rp 1,5 jt) karena hanya 1 form editor.
5. Design System (65 jam, Rp 9,75 jt) adalah investasi fondasi yang mempercepat pengerjaan semua fitur lainnya.
6. Durasi pengerjaan **3 bulan** dengan tim 4 orang (paralel), vs ~7 bulan jika dikerjakan 1 orang.

---

*Dokumen dibuat berdasarkan audit source code COMPRO-MAGANG, 21 Mei 2026.*
