# COMPUTING PROJECT
# SOFTWARE DESIGN DOCUMENT

**SISTEM MANAJEMEN PENERIMAAN MAGANG PT POS INDONESIA**
*(Internship Management System for PT Pos Indonesia)*

---

**Project Manager**
[Nama Lengkap] — [NIM]

**Team Members**
[Nama Lengkap] — [NIM]
[Nama Lengkap] — [NIM]
[Nama Lengkap] — [NIM]
[Nama Lengkap] — [NIM]
[Nama Lengkap] — [NIM]
[Nama Lengkap] — [NIM]

**Supervisor**
[Nama Lengkap Dosen Pembimbing]

---

**PROGRAM STUDI S-1 INFORMATIKA**
**FAKULTAS INFORMATIKA – UNIVERSITAS TELKOM**
**DESEMBER 2025**

---

## Document Version

| Versi | Tanggal | Perubahan | Penulis |
|-------|---------|-----------|---------|
| 1.0 | 21 Desember 2025 | Initial Software Design Document | [Tim Project] |
| | | | |

---

## Table of Contents

1. [Introduction](#1-introduction)
   - 1.1. [Purpose](#11-purpose)
   - 1.2. [Scope of the System](#12-scope-of-the-system)
   - 1.3. [References](#13-references)

2. [System Architecture Design](#2-system-architecture-design)
   - 2.1. [High-Level Architecture Diagram](#21-high-level-architecture-diagram)
   - 2.2. [Deployment Architecture](#22-deployment-architecture)

3. [Module Design](#3-module-design)
   - 3.1. [Module List](#31-module-list)
   - 3.2. [Module Description](#32-module-description)

4. [Class Diagram & Object Design](#4-class-diagram--object-design)
   - 4.1. [Class Diagram](#41-class-diagram)
   - 4.2. [Object Interaction](#42-object-interaction)

5. [Database Design](#5-database-design)
   - 5.1. [Entity Relationship Diagram (ERD)](#51-entity-relationship-diagram-erd)
   - 5.2. [Database Schema Definitions](#52-database-schema-definitions)

6. [User Interface Design (UI/UX)](#6-user-interface-design-uiux)
   - 6.1. [Wireframes / Mockups](#61-wireframes--mockups)
   - 6.2. [Navigation Flow](#62-navigation-flow)

7. [Data Flow & Process Flow](#7-data-flow--process-flow)
   - 7.1. [Data Flow Diagram (DFD)](#71-data-flow-diagram-dfd)
   - 7.2. [Activity Diagram](#72-activity-diagram)
   - 7.3. [State Machine Diagram](#73-state-machine-diagram)

8. [System Constraints](#8-system-constraints)

9. [Appendix](#9-appendix)

---

# 1. Introduction

## 1.1. Purpose

Dokumen Software Design Document (SDD) ini bertujuan untuk menjelaskan desain teknis dari **Sistem Manajemen Penerimaan Magang PT Pos Indonesia**. Dokumen ini menjadi panduan bagi developer dan tim teknis dalam mengimplementasikan sistem sesuai dengan spesifikasi yang telah ditentukan.

SDD ini mencakup:
- Arsitektur sistem secara keseluruhan
- Desain modul-modul utama aplikasi
- Struktur database dan relasi antar entitas
- Desain antarmuka pengguna (UI/UX)
- Alur data dan proses bisnis
- Interaksi antar komponen sistem

Dokumen ini digunakan sebagai acuan utama dalam fase implementasi dan testing, serta sebagai dokumentasi untuk maintenance sistem di masa mendatang.

## 1.2. Scope of the System

Sistem Manajemen Penerimaan Magang PT Pos Indonesia adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola seluruh siklus program magang, mulai dari pendaftaran hingga penerbitan sertifikat.

### Fungsi Utama Sistem:
- **Manajemen Pendaftaran**: Peserta magang dapat mendaftar secara online, mengunggah dokumen persyaratan (CV, KTM, surat pernyataan kelakuan baik), dan memilih bidang minat dari 14 bidang yang tersedia.
- **Review dan Persetujuan**: Admin dan pembimbing dapat meninjau aplikasi, menyetujui atau menolak, serta menugaskan peserta ke divisi dan pembimbing tertentu.
- **Manajemen Penugasan**: Pembimbing dapat membuat tugas (reguler atau presentasi), memberikan penilaian, dan meminta revisi jika diperlukan.
- **Sistem Absensi**: Peserta magang melakukan check-in harian dengan foto, atau mengajukan izin ketidakhadiran dengan bukti pendukung.
- **Logbook Harian**: Peserta magang mencatat aktivitas harian selama masa magang.
- **Pelaporan dan Sertifikasi**: Sistem menghasilkan laporan penilaian, surat keterangan selesai magang, dan sertifikat dalam format PDF.
- **Manajemen Organisasi**: Admin dapat mengelola struktur organisasi (Direktorat, Sub-Direktorat, Divisi) dan mengatur admin/pembimbing divisi.

### User Utama:
1. **Peserta Magang**: Mahasiswa yang mendaftar dan menjalani program magang
2. **Pembimbing (Mentor)**: Pegawai PT Pos Indonesia yang membimbing dan menilai peserta magang
3. **Administrator**: Pengelola sistem yang mengatur struktur organisasi, menyetujui aplikasi, dan menghasilkan laporan

### Benefit Sistem:
- **Efisiensi Proses**: Otomasi proses pendaftaran, review, dan pelaporan mengurangi beban administratif manual
- **Transparansi**: Peserta dapat memantau status aplikasi dan tugas secara real-time
- **Akuntabilitas**: Sistem absensi dan logbook memastikan kehadiran dan aktivitas peserta terdokumentasi
- **Keamanan Data**: Autentikasi Two-Factor (2FA) untuk peserta dan pembimbing, serta role-based access control
- **Pelaporan Komprehensif**: Laporan dapat diekspor dalam format PDF dan Excel untuk keperluan evaluasi
- **Skalabilitas**: Dapat menangani multiple periode magang dan ratusan peserta secara bersamaan

### Platform:
- **Tipe Aplikasi**: Web Application
- **Frontend**: Responsive web interface yang dapat diakses melalui browser (Chrome, Firefox, Safari, Edge)
- **Backend**: RESTful application berbasis Laravel framework
- **Database**: SQLite (dapat di-upgrade ke MySQL/PostgreSQL untuk production scale)
- **Deployment**: Dapat di-deploy pada shared hosting, VPS, atau cloud platform (AWS, Google Cloud, Azure)
- **Device Support**: Desktop, tablet, dan mobile devices

## 1.3. References

Dokumen dan standar yang menjadi referensi dalam pembuatan desain sistem:

1. **Dokumen Software Requirements Specification (SRS)** - Spesifikasi kebutuhan fungsional dan non-fungsional sistem
2. **Laravel 12 Documentation** - Framework documentation (https://laravel.com/docs/12.x)
3. **Bootstrap 5.3 Documentation** - UI framework guidelines (https://getbootstrap.com/docs/5.3)
4. **Tailwind CSS 4.0 Documentation** - Utility-first CSS framework (https://tailwindcss.com/docs)
5. **UML 2.5 Specification** - Unified Modeling Language untuk diagram
6. **PSR-12 Coding Standard** - PHP coding standard yang digunakan
7. **OWASP Top 10 (2023)** - Security best practices untuk web applications
8. **UU PDP (Undang-Undang Perlindungan Data Pribadi)** - Regulasi perlindungan data di Indonesia
9. **ISO/IEC 25010** - Software quality requirements and evaluation
10. **Material Design Guidelines** - UI/UX design principles

---

# 2. System Architecture Design

## 2.1. High-Level Architecture Diagram

Sistem menggunakan arsitektur **3-tier** yang terdiri dari Presentation Layer, Application Layer, dan Data Layer.

```
┌─────────────────────────────────────────────────────────────────────┐
│                        PRESENTATION LAYER                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐             │
│  │   Browser    │  │   Browser    │  │   Browser    │             │
│  │  (Peserta)   │  │ (Pembimbing) │  │   (Admin)    │             │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘             │
│         │                 │                  │                      │
│         └─────────────────┴──────────────────┘                      │
│                           │                                         │
│                    HTTPS/HTTP (Port 80/443)                         │
└───────────────────────────┼─────────────────────────────────────────┘
                            │
┌───────────────────────────┼─────────────────────────────────────────┐
│                 APPLICATION LAYER (Laravel 12)                      │
│  ┌─────────────────────────────────────────────────────┐           │
│  │                  Web Server (Apache/Nginx)          │           │
│  └────────────────────────┬────────────────────────────┘           │
│  ┌────────────────────────┼────────────────────────────┐           │
│  │              Laravel Application (PHP 8.2)          │           │
│  │  ┌─────────────┬──────────────┬──────────────┐     │           │
│  │  │   Routes    │ Middleware   │ Controllers  │     │           │
│  │  │  (web.php)  │ (Auth, 2FA)  │  (9 files)   │     │           │
│  │  └─────────────┴──────────────┴──────────────┘     │           │
│  │  ┌─────────────┬──────────────┬──────────────┐     │           │
│  │  │   Models    │   Services   │    Views     │     │           │
│  │  │(14+ files)  │(Mail, Export)│    (Blade)   │     │           │
│  │  └─────────────┴──────────────┴──────────────┘     │           │
│  └────────────────────────┬────────────────────────────┘           │
│                           │                                         │
│  ┌────────────────────────┼────────────────────────────┐           │
│  │           External Services & Libraries             │           │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐          │           │
│  │  │ DomPDF   │  │Maatwebsite│  │Google2FA │          │           │
│  │  │(PDF Gen) │  │  (Excel)  │  │  (2FA)   │          │           │
│  │  └──────────┘  └──────────┘  └──────────┘          │           │
│  └──────────────────────────────────────────────────────           │
└───────────────────────────┼─────────────────────────────────────────┘
                            │
┌───────────────────────────┼─────────────────────────────────────────┐
│                        DATA LAYER                                   │
│  ┌──────────────────────────────────────────────────┐              │
│  │           SQLite Database                        │              │
│  │  ┌─────────────┬──────────────┬──────────────┐  │              │
│  │  │   Users     │ Applications │ Assignments  │  │              │
│  │  ├─────────────┼──────────────┼──────────────┤  │              │
│  │  │ Certificates│  Attendance  │   Logbooks   │  │              │
│  │  ├─────────────┼──────────────┼──────────────┤  │              │
│  │  │  Divisions  │   Direktorat │   Fields     │  │              │
│  │  └─────────────┴──────────────┴──────────────┘  │              │
│  └──────────────────────────────────────────────────┘              │
│                                                                     │
│  ┌──────────────────────────────────────────────────┐              │
│  │           File Storage (storage/app)             │              │
│  │  • Uploaded documents (CV, KTM, certificates)    │              │
│  │  • Generated PDFs (letters, certificates)        │              │
│  │  • Attendance photos                             │              │
│  │  • Assignment files                              │              │
│  └──────────────────────────────────────────────────┘              │
└─────────────────────────────────────────────────────────────────────┘

External Components:
┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│ Email Server │      │Google Auth   │      │   Browser    │
│  (SMTP)      │◄────►│(Authenticator│◄────►│  QR Scanner  │
│ (Letters)    │      │     App)     │      │   (2FA)      │
└──────────────┘      └──────────────┘      └──────────────┘
```

### Komponen Utama:

**1. Presentation Layer (Client-Side)**
- **Browser-based Interface**: Multi-device responsive web interface
- **Frontend Technologies**: Bootstrap 5.3, Tailwind CSS 4.0, jQuery, Alpine.js, Chart.js
- **User Roles**: Peserta, Pembimbing, Admin (each with dedicated dashboards)

**2. Application Layer (Server-Side)**
- **Web Server**: Apache/Nginx serving Laravel application
- **PHP Runtime**: PHP 8.2 with Opcache for performance
- **Laravel Framework**: MVC architecture with Eloquent ORM
- **Middleware Stack**: Authentication, 2FA verification, authorization
- **Controllers**: 9 main controllers handling business logic
- **Services**: Mail service, PDF generation, Excel export
- **Queue System**: Background job processing for emails and reports

**3. Data Layer (Persistence)**
- **Database**: SQLite (portable, zero-configuration)
- **File Storage**: Local filesystem for uploaded and generated files
- **Cache**: Database-based cache for session and application cache

**4. External Services**
- **Email Server**: SMTP for sending acceptance letters
- **Google Authenticator**: TOTP-based 2FA
- **Libraries**: DomPDF (PDF generation), Maatwebsite Excel (Excel export)

## 2.2. Deployment Architecture

Sistem dapat di-deploy dengan berbagai konfigurasi sesuai kebutuhan dan skala.

### Development Environment:
```
┌─────────────────────────────────────────────────────┐
│         Developer Workstation (Local)               │
│  ┌───────────────────────────────────────────────┐  │
│  │  Laravel Sail (Docker Containers)             │  │
│  │  ┌──────────┐  ┌──────────┐  ┌──────────┐    │  │
│  │  │   PHP    │  │  SQLite  │  │   Node   │    │  │
│  │  │   8.2    │  │    DB    │  │   (Vite) │    │  │
│  │  └──────────┘  └──────────┘  └──────────┘    │  │
│  └───────────────────────────────────────────────┘  │
│                                                      │
│  Development Tools:                                 │
│  • Laravel Pail (log monitoring)                    │
│  • Laravel Pint (code formatting)                   │
│  • Vite (hot module reloading)                      │
│  • Queue listener (background jobs)                 │
└─────────────────────────────────────────────────────┘

Command: composer dev
Runs: server + queue + logs + vite concurrently
```

### Production Environment (Recommended):
```
┌─────────────────────────────────────────────────────────────────┐
│                      Cloud Platform                             │
│               (AWS/GCP/Azure/DigitalOcean)                      │
│                                                                  │
│  ┌────────────────────────────────────────────────────────┐    │
│  │               Load Balancer (HTTPS/SSL)                │    │
│  └───────────────┬────────────────┬───────────────────────┘    │
│                  │                │                             │
│      ┌───────────┴──────┐  ┌──────┴───────────┐               │
│      │  Web Server 1    │  │  Web Server 2    │ (Scalable)    │
│      │  (Nginx + PHP)   │  │  (Nginx + PHP)   │               │
│      └───────────┬──────┘  └──────┬───────────┘               │
│                  └────────────────┬───────────────────┐        │
│                                   │                   │        │
│  ┌────────────────────────────────┼──────────┐        │        │
│  │         Database Server        │          │        │        │
│  │  (MySQL/PostgreSQL for scale)  │          │        │        │
│  │  • Automated backups           │          │        │        │
│  │  • Replication (optional)      │          │        │        │
│  └────────────────────────────────┘          │        │        │
│                                               │        │        │
│  ┌────────────────────────────────────────────┘        │        │
│  │         File Storage Service                        │        │
│  │  (AWS S3 / GCP Storage / Azure Blob)                │        │
│  │  • Uploaded documents                               │        │
│  │  • Generated PDFs                                   │        │
│  │  • Attendance photos                                │        │
│  └─────────────────────────────────────────────────────┘        │
│                                                                  │
│  ┌─────────────────────────────────────────────────────┐        │
│  │         Queue Worker Service                        │        │
│  │  (Background job processing)                        │        │
│  │  • Email sending                                    │        │
│  │  • PDF generation                                   │        │
│  │  • Excel exports                                    │        │
│  └─────────────────────────────────────────────────────┘        │
│                                                                  │
│  ┌─────────────────────────────────────────────────────┐        │
│  │         Cache Service (Optional)                    │        │
│  │  (Redis/Memcached)                                  │        │
│  └─────────────────────────────────────────────────────┘        │
└─────────────────────────────────────────────────────────────────┘

External Services:
┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│   SMTP       │      │  Monitoring  │      │   Backup     │
│  Service     │      │  (New Relic, │      │   Service    │
│ (SendGrid,   │      │   Datadog)   │      │ (Automated)  │
│  Mailgun)    │      │              │      │              │
└──────────────┘      └──────────────┘      └──────────────┘
```

### CI/CD Pipeline:
```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│              │     │              │     │              │
│  Git Repo    │────►│  CI/CD       │────►│  Production  │
│  (GitHub/    │     │  (GitHub     │     │  Server      │
│   GitLab)    │     │   Actions/   │     │              │
│              │     │   GitLab CI) │     │              │
└──────────────┘     └──────────────┘     └──────────────┘
                            │
                            ▼
                     ┌──────────────┐
                     │ Automated    │
                     │ - Tests      │
                     │ - Code Style │
                     │ - Build      │
                     │ - Deploy     │
                     └──────────────┘
```

### Deployment Strategy:

**On-Premise / Self-Hosted:**
- Single VPS server (minimal configuration)
- SQLite database (sufficient for <1000 concurrent users)
- Local file storage
- Manual backup procedures
- Suitable for: Internal use, limited budget

**Cloud-Based (Recommended):**
- Multiple web servers (horizontal scaling)
- Managed database service (MySQL/PostgreSQL)
- Object storage for files (S3/GCS)
- Automated backups and disaster recovery
- CDN for static assets
- Load balancing for high availability
- Suitable for: Production, public access, high availability requirements

**Docker/Kubernetes:**
- Containerized application
- Orchestrated deployment
- Auto-scaling based on load
- Rolling updates with zero downtime
- Suitable for: Enterprise deployment, microservices architecture

### Environment Configuration:
- **Development**: Local (Laravel Sail), SQLite, debug mode ON, queue sync
- **Staging**: Cloud VPS, MySQL, debug mode ON, queue database/redis
- **Production**: Cloud cluster, PostgreSQL, debug mode OFF, queue redis, caching, HTTPS enforced

---

# 3. Module Design

## 3.1. Module List

Sistem terdiri dari 12 modul utama yang saling terintegrasi:

1. **Authentication Module** - Registrasi, login, 2FA, password reset
2. **User Management Module** - Profil pengguna, role management
3. **Application Management Module** - Pendaftaran magang, review, approval
4. **Assignment Module** - Pembuatan tugas, submission, grading
5. **Attendance Module** - Check-in harian, absensi, izin ketidakhadiran
6. **Logbook Module** - Jurnal aktivitas harian
7. **Certificate Module** - Generasi dan distribusi sertifikat
8. **Document Management Module** - Upload, storage, retrieval dokumen
9. **Organization Structure Module** - Manajemen Direktorat, Divisi, Pembimbing
10. **Field of Interest Module** - Manajemen bidang minat magang
11. **Reporting Module** - Laporan PDF/Excel, statistik, analytics
12. **Notification Module** - Email notifications, in-app alerts

## 3.2. Module Description

### Module 1: Authentication Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Authentication Module |
| **Tujuan** | Mengelola autentikasi pengguna termasuk registrasi, login, Two-Factor Authentication (2FA), dan reset password |
| **Input** | • Credentials (username/NIK, password)<br>• 2FA code (6 digits TOTP)<br>• Registration data (username, email, password, NIM, universitas, jurusan, dll)<br>• Email untuk password reset |
| **Output** | • Session token<br>• 2FA QR code (untuk setup)<br>• Success/error messages<br>• Redirect ke dashboard sesuai role |
| **Dependency** | • User Model<br>• Google2FA library<br>• Laravel Auth system<br>• Session storage<br>• Email service |
| **Class/Function** | • `AuthController::showRegisterForm()`<br>• `AuthController::register()`<br>• `AuthController::showLoginForm()`<br>• `AuthController::login()`<br>• `AuthController::setup2FA()`<br>• `AuthController::verify2FA()`<br>• `AuthController::logout()`<br>• `RequireTwoFactor` middleware |
| **Error Handling** | • Invalid credentials → Error message "Username atau password salah"<br>• Invalid 2FA code → Error message "Kode 2FA tidak valid"<br>• Registration validation errors → Form validation dengan pesan spesifik<br>• Expired session → Redirect ke login<br>• Duplicate username/email → Error message "Username/email sudah digunakan" |
| **Catatan** | • 2FA wajib untuk role 'peserta' dan 'pembimbing'<br>• Admin tidak memerlukan 2FA<br>• Pembimbing login menggunakan NIK (6 digit)<br>• Password di-hash menggunakan bcrypt<br>• Session timeout: 120 menit |

### Module 2: User Management Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | User Management Module |
| **Tujuan** | Mengelola data profil pengguna, role assignment, dan user permissions |
| **Input** | • Profile data (nama, email, phone, universitas, jurusan, NIM, KTP)<br>• Role selection (admin only)<br>• Division assignment (untuk pembimbing)<br>• User ID untuk operasi CRUD |
| **Output** | • Updated profile data<br>• User list dengan filter by role<br>• User statistics<br>• Success/error notifications |
| **Dependency** | • User Model<br>• Divisi Model<br>• InternshipApplication Model<br>• File upload service |
| **Class/Function** | • `DashboardController::showProfile()`<br>• `DashboardController::updateProfile()`<br>• `AdminController::manageUsers()`<br>• `AdminController::createMentor()`<br>• `AdminController::updateMentor()`<br>• `AdminController::deleteMentor()` |
| **Error Handling** | • Duplicate email/username → Validation error<br>• Invalid NIM format → Validation error<br>• File upload failure → Error message dengan fallback<br>• Permission denied → 403 Forbidden<br>• User not found → 404 Not Found |
| **Catatan** | • Admin dapat mengelola semua user<br>• Pembimbing hanya dapat melihat peserta di divisinya<br>• Peserta hanya dapat edit profil sendiri<br>• Soft delete untuk user (data tidak benar-benar dihapus) |

### Module 3: Application Management Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Application Management Module |
| **Tujuan** | Mengelola seluruh siklus aplikasi magang dari submission hingga acceptance/rejection |
| **Input** | • Application form data (field of interest, start/end dates)<br>• Document uploads (CV, cover letter, KTM, surat kelakuan baik)<br>• Admin review decision (approve/reject, division assignment)<br>• Mentor review decision (accept/reject)<br>• Rejection notes |
| **Output** | • Application ID dan status<br>• Acceptance letter (PDF)<br>• Rejection notification dengan alasan<br>• Application list dengan filters (status, division, period)<br>• Statistics dashboard |
| **Dependency** | • InternshipApplication Model<br>• User Model<br>• Divisi Model<br>• FieldOfInterest Model<br>• DivisionAdmin, DivisionMentor Models<br>• PDF generation service (DomPDF)<br>• Email service<br>• File storage service |
| **Class/Function** | • `InternshipController::store()` - Submit application<br>• `InternshipController::show()` - View application detail<br>• `AdminController::reviewApplication()` - Admin review<br>• `AdminController::approveApplication()` - Admin approve + assign division<br>• `AdminController::rejectApplication()` - Admin reject<br>• `MentorDashboardController::reviewApplications()` - Mentor review<br>• `MentorDashboardController::acceptApplication()` - Mentor accept + generate letter<br>• `MentorDashboardController::rejectApplication()` - Mentor reject |
| **Error Handling** | • Missing required documents → Validation error<br>• Invalid date range → Validation error<br>• Application already exists for period → Duplicate error<br>• PDF generation failure → Retry mechanism + admin notification<br>• Email send failure → Queue retry (3 attempts)<br>• Division not found → Error message |
| **Catatan** | • Workflow: Submit → Admin Review → Mentor Review → Accepted/Rejected<br>• Status: pending → accepted/rejected → finished/postponed<br>• Acceptance letter auto-generated in PDF format<br>• Email sent automatically upon acceptance<br>• Peserta dapat re-apply setelah status 'finished' atau 'rejected' |

### Module 4: Assignment Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Assignment Module |
| **Tujuan** | Mengelola pembuatan tugas oleh pembimbing, submission oleh peserta, dan grading |
| **Input** | • Assignment creation form (title, description, type, deadline, presentation_date, file)<br>• Assignment submission (file upload, keterangan)<br>• Grade (0-100) dan feedback dari pembimbing<br>• Revision request flag |
| **Output** | • Assignment list untuk peserta<br>• Submission status dan grade<br>• Feedback dari pembimbing<br>• Assignment statistics (completion rate, average grade)<br>• Notification untuk peserta (new assignment, graded) |
| **Dependency** | • Assignment Model<br>• AssignmentSubmission Model<br>• User Model<br>• InternshipApplication Model<br>• File storage service<br>• Notification service |
| **Class/Function** | • `MentorDashboardController::createAssignment()`<br>• `MentorDashboardController::storeAssignment()`<br>• `MentorDashboardController::viewSubmissions()`<br>• `MentorDashboardController::gradeSubmission()`<br>• `MentorDashboardController::requestRevision()`<br>• `DashboardController::viewAssignments()`<br>• `DashboardController::submitAssignment()`<br>• `DashboardController::downloadAssignmentFile()` |
| **Error Handling** | • File too large (>5MB) → Validation error<br>• Invalid file type → Only PDF, DOCX, PPTX allowed<br>• Submission after deadline → Warning (allow with penalty note)<br>• Duplicate submission → Overwrite previous or create new version<br>• Grade out of range → Validation error (0-100)<br>• Assignment not found → 404 error |
| **Catatan** | • Assignment types: 'regular' (tugas biasa) dan 'presentation' (tugas presentasi)<br>• Presentation type memiliki field 'presentation_date'<br>• Multiple submissions allowed (latest submission considered)<br>• Pembimbing dapat request revision (submission ulang)<br>• Notification sent on new assignment, grade published, revision request<br>• File naming convention: `assignment_{id}_{timestamp}.{ext}` |

### Module 5: Attendance Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Attendance Module |
| **Tujuan** | Mengelola presensi harian peserta magang dengan check-in foto dan pengajuan izin ketidakhadiran |
| **Input** | • Check-in request dengan foto (image capture from camera)<br>• Tanggal dan waktu check-in<br>• Absence request (alasan, bukti pendukung)<br>• Filter parameters (date range, division, user) untuk reporting |
| **Output** | • Attendance record dengan status (present/absent/excused)<br>• Photo confirmation<br>• Attendance history per peserta<br>• Attendance report (daily/weekly/monthly)<br>• Statistics (attendance rate, late arrivals, absences) |
| **Dependency** | • Attendance Model<br>• User Model<br>• InternshipApplication Model<br>• Image storage service<br>• DateTime service |
| **Class/Function** | • `AttendanceController::checkIn()` - Check-in dengan foto<br>• `AttendanceController::store()` - Simpan attendance record<br>• `AttendanceController::submitAbsence()` - Ajukan izin<br>• `AttendanceController::viewHistory()` - Lihat riwayat<br>• `AdminController::attendanceReport()` - Generate report<br>• `MentorDashboardController::viewAttendance()` - Monitor attendance |
| **Error Handling** | • Duplicate check-in (sudah check-in hari ini) → Error message<br>• Image upload failure → Retry prompt<br>• Image too large (>2MB) → Compression + validation error<br>• Invalid image format → Only JPG, PNG allowed<br>• No camera access → Error message + manual upload option<br>• Absence without proof → Warning (allow but flagged) |
| **Catatan** | • Check-in time recorded in check_in_time field<br>• Photo disimpan di storage/app/attendance_photos/<br>• Status: 'present' (hadir), 'absent' (tidak hadir tanpa keterangan), 'excused' (izin)<br>• Late arrival jika check-in > 08:30<br>• Absence request memerlukan approval dari pembimbing (future enhancement)<br>• Photo naming: `attendance_{user_id}_{date}_{timestamp}.jpg` |

### Module 6: Logbook Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Logbook Module |
| **Tujuan** | Mengelola jurnal aktivitas harian peserta magang untuk dokumentasi kegiatan dan evaluasi |
| **Input** | • Tanggal aktivitas<br>• Konten/deskripsi aktivitas harian (text area)<br>• User ID (auto from session)<br>• Filter parameters untuk viewing (date range, user) |
| **Output** | • Logbook entry tersimpan<br>• Logbook history per peserta<br>• Logbook report (PDF/Excel)<br>• Monthly summary<br>• Statistics (entry frequency, word count) |
| **Dependency** | • Logbook Model<br>• User Model<br>• InternshipApplication Model<br>• Export service (PDF/Excel) |
| **Class/Function** | • `LogbookController::index()` - View all entries<br>• `LogbookController::create()` - Form tambah entry<br>• `LogbookController::store()` - Simpan entry baru<br>• `LogbookController::edit()` - Form edit entry<br>• `LogbookController::update()` - Update entry<br>• `LogbookController::destroy()` - Hapus entry<br>• `MentorDashboardController::viewLogbooks()` - Monitor logbook peserta<br>• `AdminController::exportLogbooks()` - Export ke PDF/Excel |
| **Error Handling** | • Empty content → Validation error (min 50 characters)<br>• Duplicate entry for same date → Warning (allow multiple entries)<br>• Date in future → Validation error<br>• Content too long (>5000 chars) → Validation error<br>• Unauthorized access → 403 Forbidden |
| **Catatan** | • Minimal 1 entry per hari kerja (Senin-Jumat)<br>• Peserta dapat edit/delete entry sendiri<br>• Pembimbing hanya read-only access<br>• Admin dapat view all logbooks<br>• Logbook completion rate menjadi bagian dari penilaian<br>• Export include: date, user, content, word count |

### Module 7: Certificate Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Certificate Module |
| **Tujuan** | Mengelola generasi, penyimpanan, dan distribusi sertifikat kelulusan magang |
| **Input** | • Internship application ID<br>• Nomor sertifikat (auto-generated atau manual)<br>• Predikat (Sangat Baik, Baik, Cukup)<br>• Template data (nama, divisi, periode, achievement)<br>• Digital signature (optional) |
| **Output** | • Sertifikat dalam format PDF<br>• Certificate ID dan nomor sertifikat<br>• Download link untuk peserta<br>• Certificate archive untuk admin<br>• Verification QR code (optional) |
| **Dependency** | • Certificate Model<br>• User Model<br>• InternshipApplication Model<br>• DomPDF library<br>• QR Code library (optional)<br>• File storage service |
| **Class/Function** | • `MentorDashboardController::generateCertificate()` - Generate PDF<br>• `MentorDashboardController::uploadCertificate()` - Upload manual<br>• `DashboardController::downloadCertificate()` - Download<br>• `AdminController::viewCertificates()` - Manage all certificates<br>• `CertificateController::verify()` - Verify authenticity (future) |
| **Error Handling** | • Application not finished → Error message<br>• Certificate already exists → Overwrite confirmation<br>• PDF generation failure → Retry + error log<br>• Template not found → Fallback template<br>• Invalid predikat → Validation error<br>• Download unauthorized → 403 Forbidden |
| **Catatan** | • Certificate hanya untuk aplikasi dengan status 'finished'<br>• Nomor sertifikat format: `CERT/POSINDO/{divisi}/{tahun}/{seq}`<br>• Template blade: `resources/views/surat/certificate.blade.php`<br>• Digital signature menggunakan image overlay<br>• QR code untuk verifikasi online (future enhancement)<br>• Watermark untuk keamanan<br>• Certificate dikirim via email setelah di-generate |

### Module 8: Document Management Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Document Management Module |
| **Tujuan** | Mengelola upload, storage, retrieval, dan security dokumen-dokumen dalam sistem |
| **Input** | • File upload (CV, KTM, cover letter, surat kelakuan baik, bukti izin, dll)<br>• Document type/category<br>• Associated entity ID (user_id, application_id)<br>• Access permission settings |
| **Output** | • File path dalam storage<br>• File metadata (name, size, type, upload date)<br>• Download link dengan authorization<br>• Document preview (for PDF/images)<br>• Storage usage statistics |
| **Dependency** | • Laravel Storage facade<br>• File validation service<br>• User Model<br>• InternshipApplication Model<br>• Assignment, Attendance Models |
| **Class/Function** | • `DocumentController::upload()` - Handle file upload<br>• `DocumentController::download()` - Secure download<br>• `DocumentController::delete()` - Remove file<br>• `DocumentController::preview()` - View without download<br>• Storage helper functions (storeFile, getFileUrl, deleteFile) |
| **Error Handling** | • File size exceeds limit → Validation error dengan max size<br>• Invalid file type → List allowed types<br>• Storage full → Error message + admin notification<br>• Virus detected (if scanner enabled) → Quarantine + reject<br>• Corrupted file → Error message<br>• Unauthorized access → 403 Forbidden<br>• File not found → 404 Not Found |
| **Catatan** | • File size limits: CV/Cover Letter (2MB), KTM (1MB), Photos (2MB)<br>• Allowed types: PDF, DOCX, JPG, PNG<br>• Storage path structure: `storage/app/{category}/{user_id}/{filename}`<br>• File naming: `{original_name}_{timestamp}.{ext}`<br>• Access control: Owner only + assigned mentor + admin<br>• Automatic cleanup for rejected applications (after 30 days)<br>• Backup strategy untuk storage (daily incremental) |

### Module 9: Organization Structure Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Organization Structure Module |
| **Tujuan** | Mengelola hierarki organisasi PT Pos Indonesia (Direktorat, Sub-Direktorat, Divisi) dan assignment mentor |
| **Input** | • Direktorat data (nama)<br>• Sub-Direktorat data (nama, direktorat_id)<br>• Divisi data (nama, sub_direktorat_id, VP, NIPPOS)<br>• Division Admin data (division_name, mentor_name, NIK)<br>• Division Mentor data (division_id, mentor_name, NIK, password) |
| **Output** | • Organization hierarchy tree<br>• Division list dengan mentor assignment<br>• Mentor list per division<br>• Organization chart (visual)<br>• Statistics (jumlah divisi, mentor, capacity) |
| **Dependency** | • Direktorat Model<br>• SubDirektorat Model<br>• Divisi Model<br>• Division (DivisiAdmin) Model<br>• DivisionMentor Model<br>• User Model |
| **Class/Function** | • `AdminController::manageDirektorat()` - CRUD Direktorat<br>• `AdminController::manageSubDirektorat()` - CRUD Sub-Direktorat<br>• `AdminController::manageDivisi()` - CRUD Divisi<br>• `AdminController::manageDivisionAdmins()` - CRUD Division Admin<br>• `AdminController::manageMentors()` - CRUD Mentor<br>• `AdminController::assignMentor()` - Assign mentor to division<br>• `AdminController::organizationChart()` - Visualisasi struktur |
| **Error Handling** | • Duplicate direktorat/divisi name → Validation error<br>• Delete direktorat with existing divisions → Cascade warning<br>• Delete divisi with active interns → Prevent + error message<br>• Invalid NIK format (must 6 digits) → Validation error<br>• Mentor already assigned → Error message<br>• Circular reference → Prevention logic |
| **Catatan** | • Hierarchy: Direktorat → Sub-Direktorat → Divisi<br>• Setiap divisi dapat memiliki 1 Division Admin dan multiple Division Mentors<br>• Division Admin dapat menyetujui aplikasi<br>• Division Mentor dapat membimbing peserta<br>• Soft delete untuk semua organization entities<br>• Sort order dapat diatur untuk tampilan<br>• is_active flag untuk temporary disable division |

### Module 10: Field of Interest Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Field of Interest Module |
| **Tujuan** | Mengelola bidang minat magang yang tersedia untuk dipilih peserta saat mendaftar |
| **Input** | • Field name (nama bidang)<br>• Description (deskripsi bidang)<br>• Icon (class name untuk icon)<br>• Color (hex color untuk display)<br>• is_active (enable/disable)<br>• sort_order (urutan tampilan)<br>• Division count (jumlah divisi terkait)<br>• Position count (jumlah posisi tersedia)<br>• Duration months (durasi magang) |
| **Output** | • Field of interest list (active only untuk peserta)<br>• Field management interface (admin)<br>• Field statistics (jumlah applicant per field)<br>• Field detail page<br>• Field selection dropdown/cards |
| **Dependency** | • FieldOfInterest Model<br>• InternshipApplication Model |
| **Class/Function** | • `AdminController::manageFields()` - CRUD field of interest<br>• `AdminController::toggleFieldStatus()` - Enable/disable field<br>• `AdminController::reorderFields()` - Change sort order<br>• `InternshipController::selectField()` - Field selection by peserta<br>• `HomeController::showFields()` - Public field list |
| **Error Handling** | • Duplicate field name → Validation error<br>• Delete field with active applications → Prevent + error message<br>• Invalid color code → Validation error<br>• Invalid icon class → Warning (use default icon)<br>• Disable field with pending applications → Warning + confirmation |
| **Catatan** | • 14 predefined fields termasuk: Administrasi, Finance, HR, IT, Marketing, dll<br>• Icon menggunakan Bootstrap Icons atau Font Awesome<br>• Color untuk visual differentiation pada cards<br>• Only active fields ditampilkan ke peserta<br>• Admin dapat reorder via drag-drop (future enhancement)<br>• Statistics: applicant count per field per period |

### Module 11: Reporting Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Reporting Module |
| **Tujuan** | Menghasilkan berbagai laporan dalam format PDF dan Excel untuk keperluan evaluasi dan dokumentasi |
| **Input** | • Report type (application, attendance, logbook, performance, comprehensive)<br>• Filter parameters (date range, division, status, user)<br>• Export format (PDF/Excel)<br>• Grouping options (by division, by period, by status)<br>• Include/exclude options (dengan foto, dengan detail, summary only) |
| **Output** | • PDF report dengan formatting profesional<br>• Excel file dengan multiple sheets<br>• Statistics dan charts<br>• Summary dashboard<br>• Download link atau auto-download |
| **Dependency** | • DomPDF library (barryvdh/laravel-dompdf)<br>• Maatwebsite Excel library<br>• ReportExport class (app/Exports/ReportExport.php)<br>• All models (User, InternshipApplication, Attendance, Logbook, Assignment, Certificate)<br>• Chart.js (untuk dashboard visualizations) |
| **Class/Function** | • `AdminController::generateReport()` - Main report generation<br>• `AdminController::exportPDF()` - Export to PDF<br>• `AdminController::exportExcel()` - Export to Excel<br>• `ReportExport::collection()` - Data preparation for Excel<br>• `MentorDashboardController::divisionReport()` - Division-specific report<br>• Helper functions (formatReportData, generateCharts) |
| **Error Handling** | • No data for selected filters → Empty report message<br>• PDF generation timeout (large data) → Chunk processing<br>• Excel export memory limit → Streaming export<br>• Invalid date range → Validation error<br>• Export failure → Retry + error log + admin notification<br>• File too large → Warning + option to filter |
| **Catatan** | • PDF reports include header dengan logo PT Pos Indonesia<br>• Excel exports include: Data sheet, Summary sheet, Charts sheet<br>• Reports dapat dijadwalkan (future enhancement dengan Laravel Task Scheduling)<br>• Comprehensive report includes: Applications, Attendance, Logbook, Assignments, Certificates<br>• PDF view blade template: `resources/views/admin/reports/*.blade.php`<br>• Excel formatting: Header bold, alternating row colors, auto-width columns<br>• Reports disimpan di storage/app/reports/ dengan naming `{type}_{date}_{timestamp}.{ext}` |

### Module 12: Notification Module

| Komponen | Deskripsi |
|----------|-----------|
| **Nama Modul** | Notification Module |
| **Tujuan** | Mengelola pengiriman notifikasi via email dan in-app alerts untuk berbagai event dalam sistem |
| **Input** | • Event trigger (application approved, assignment created, deadline reminder, etc.)<br>• Recipient user ID atau email<br>• Notification type (email, in-app, atau both)<br>• Email template dan data<br>• Priority level (low, normal, high, urgent) |
| **Output** | • Email terkirim dengan template yang sesuai<br>• In-app notification badge<br>• Notification history<br>• Delivery status (sent, failed, pending)<br>• Notification preferences per user |
| **Dependency** | • Laravel Mail facade<br>• Queue system (database/redis)<br>• AcceptanceLetterMail class (app/Mail/)<br>• Email templates (resources/views/emails/)<br>• SMTP configuration<br>• User Model |
| **Class/Function** | • `NotificationController::send()` - Send notification<br>• `AcceptanceLetterMail::build()` - Build acceptance letter email<br>• `NotificationController::markAsRead()` - Mark notification read<br>• `NotificationController::viewAll()` - View notification list<br>• Queue jobs (SendEmailJob, SendReminderJob) |
| **Error Handling** | • SMTP connection failure → Queue retry (3 attempts)<br>• Invalid email address → Skip + log error<br>• Email send timeout → Queue for later<br>• Template not found → Use fallback template<br>• Attachment too large → Provide download link instead<br>• Recipient unsubscribed → Skip + update preference |
| **Catatan** | • Email events:<br>  - Application approved → Send acceptance letter PDF<br>  - Assignment created → Notification to peserta<br>  - Assignment graded → Notification to peserta<br>  - Deadline reminder → 3 days before, 1 day before<br>  - Certificate ready → Download link<br>• All emails queued for background processing<br>• Email templates menggunakan Blade dengan PT Pos Indonesia branding<br>• In-app notifications stored in database (future enhancement)<br>• Notification preferences (future: user dapat disable certain notifications)<br>• Email logging untuk audit trail |

---

# 4. Class Diagram & Object Design

## 4.1. Class Diagram

Berikut adalah Class Diagram UML yang menunjukkan struktur utama sistem, atribut, method, dan relasi antar class.

```
┌─────────────────────────────────────────────────────────┐
│                        User                             │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - username: string (unique)                             │
│ - name: string                                          │
│ - email: string (unique)                                │
│ - password: string (hashed)                             │
│ - nim: string (nullable)                                │
│ - university: string (nullable)                         │
│ - major: string (nullable)                              │
│ - phone: string (nullable)                              │
│ - ktp_number: string (nullable)                         │
│ - ktm: string (nullable, file path)                     │
│ - role: enum('peserta','pembimbing','admin')            │
│ - divisi_id: integer (FK, nullable)                     │
│ - two_factor_secret: string (nullable)                  │
│ - two_factor_verified_at: timestamp (nullable)          │
│ - remember_token: string (nullable)                     │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + register(data): User                                  │
│ + login(credentials): boolean                           │
│ + setup2FA(): string (QR code)                          │
│ + verify2FA(code): boolean                              │
│ + updateProfile(data): boolean                          │
│ + getRole(): string                                     │
│ + isDivisionMentor(): boolean                           │
│ + internshipApplications(): HasMany                     │
│ + assignments(): HasMany                                │
│ + certificates(): HasMany                               │
│ + attendances(): HasMany                                │
│ + logbooks(): HasMany                                   │
│ + divisi(): BelongsTo                                   │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                InternshipApplication                    │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - user_id: integer (FK)                                 │
│ - divisi_id: integer (FK, nullable)                     │
│ - division_admin_id: integer (FK, nullable)             │
│ - division_mentor_id: integer (FK, nullable)            │
│ - field_of_interest_id: integer (FK)                    │
│ - status: enum('pending','accepted','rejected',         │
│               'finished','postponed')                   │
│ - start_date: date (nullable)                           │
│ - end_date: date (nullable)                             │
│ - cover_letter: string (file path, nullable)            │
│ - ktm: string (file path, nullable)                     │
│ - surat_permohonan: string (file path, nullable)        │
│ - cv: string (file path, nullable)                      │
│ - good_behavior: string (file path, nullable)           │
│ - acceptance_letter_path: string (nullable)             │
│ - assessment_report_path: string (nullable)             │
│ - completion_letter_path: string (nullable)             │
│ - acceptance_letter_downloaded_at: timestamp (nullable) │
│ - notes: text (nullable, rejection reason)              │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + submit(data): InternshipApplication                   │
│ + approve(divisi_id, mentor_id): boolean                │
│ + reject(notes): boolean                                │
│ + generateAcceptanceLetter(): string (PDF path)         │
│ + markAsFinished(): boolean                             │
│ + canReApply(): boolean                                 │
│ + user(): BelongsTo                                     │
│ + divisi(): BelongsTo                                   │
│ + divisionAdmin(): BelongsTo                            │
│ + divisionMentor(): BelongsTo                           │
│ + fieldOfInterest(): BelongsTo                          │
│ + certificate(): HasOne                                 │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                     Assignment                          │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - user_id: integer (FK, peserta)                        │
│ - title: string                                         │
│ - description: text                                     │
│ - assignment_type: enum('regular','presentation')       │
│ - deadline: datetime                                    │
│ - presentation_date: date (nullable)                    │
│ - file_path: string (nullable)                          │
│ - submission_file_path: string (nullable)               │
│ - grade: decimal(5,2) (nullable)                        │
│ - submitted_at: timestamp (nullable)                    │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + create(data): Assignment                              │
│ + submit(file): boolean                                 │
│ + grade(score, feedback): boolean                       │
│ + requestRevision(): boolean                            │
│ + isLate(): boolean                                     │
│ + user(): BelongsTo                                     │
│ + submissions(): HasMany                                │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                AssignmentSubmission                     │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - assignment_id: integer (FK)                           │
│ - user_id: integer (FK)                                 │
│ - file_path: string                                     │
│ - submitted_at: timestamp                               │
│ - keterangan: text (nullable)                           │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + submit(file, notes): AssignmentSubmission             │
│ + assignment(): BelongsTo                               │
│ + user(): BelongsTo                                     │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│                    Attendance                           │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - user_id: integer (FK)                                 │
│ - date: date                                            │
│ - status: enum('present','absent','excused')            │
│ - check_in_time: time (nullable)                        │
│ - photo_path: string (nullable)                         │
│ - absence_reason: text (nullable)                       │
│ - absence_proof_path: string (nullable)                 │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + checkIn(photo): Attendance                            │
│ + submitAbsence(reason, proof): Attendance              │
│ + isLate(): boolean                                     │
│ + user(): BelongsTo                                     │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│                      Logbook                            │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - user_id: integer (FK)                                 │
│ - date: date                                            │
│ - content: text                                         │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + create(date, content): Logbook                        │
│ + update(content): boolean                              │
│ + delete(): boolean                                     │
│ + user(): BelongsTo                                     │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│                    Certificate                          │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - user_id: integer (FK)                                 │
│ - internship_application_id: integer (FK)               │
│ - certificate_path: string                              │
│ - nomor_sertifikat: string (unique)                     │
│ - predikat: enum('Sangat Baik','Baik','Cukup')          │
│ - issued_at: date                                       │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + generate(application_id, predikat): Certificate       │
│ + download(): file                                      │
│ + verify(number): boolean                               │
│ + user(): BelongsTo                                     │
│ + internshipApplication(): BelongsTo                    │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│                    Direktorat                           │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - name: string                                          │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
│ - deleted_at: timestamp (nullable, soft delete)         │
├─────────────────────────────────────────────────────────┤
│ + subDirektorats(): HasMany                             │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                  SubDirektorat                          │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - name: string                                          │
│ - direktorat_id: integer (FK)                           │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
│ - deleted_at: timestamp (nullable, soft delete)         │
├─────────────────────────────────────────────────────────┤
│ + direktorat(): BelongsTo                               │
│ + divisis(): HasMany                                    │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                      Divisi                             │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - name: string                                          │
│ - sub_direktorat_id: integer (FK)                       │
│ - vp: string (nullable)                                 │
│ - nippos: string (nullable)                             │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
│ - deleted_at: timestamp (nullable, soft delete)         │
├─────────────────────────────────────────────────────────┤
│ + subDirektorat(): BelongsTo                            │
│ + internshipApplications(): HasMany                     │
│ + users(): HasMany (pembimbing)                         │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│              Division (DivisiAdmin)                     │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - division_name: string                                 │
│ - mentor_name: string                                   │
│ - nik_number: string (6 digits)                         │
│ - is_active: boolean                                    │
│ - sort_order: integer                                   │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
│ - deleted_at: timestamp (nullable, soft delete)         │
├─────────────────────────────────────────────────────────┤
│ + divisionMentors(): HasMany                            │
└─────────────────────────────────────────────────────────┘
                       │1
                       │
                       │*
┌─────────────────────────────────────────────────────────┐
│                  DivisionMentor                         │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - division_id: integer (FK)                             │
│ - mentor_name: string                                   │
│ - nik_number: string (6 digits)                         │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + division(): BelongsTo                                 │
└─────────────────────────────────────────────────────────┘


┌─────────────────────────────────────────────────────────┐
│                 FieldOfInterest                         │
├─────────────────────────────────────────────────────────┤
│ - id: integer (PK)                                      │
│ - name: string                                          │
│ - description: text (nullable)                          │
│ - icon: string (nullable)                               │
│ - color: string (nullable)                              │
│ - is_active: boolean                                    │
│ - sort_order: integer                                   │
│ - division_count: integer (nullable)                    │
│ - position_count: integer (nullable)                    │
│ - duration_months: integer (nullable)                   │
│ - created_at: timestamp                                 │
│ - updated_at: timestamp                                 │
├─────────────────────────────────────────────────────────┤
│ + internshipApplications(): HasMany                     │
│ + toggleStatus(): boolean                               │
└─────────────────────────────────────────────────────────┘
```

### Relationship Summary:

**Composition Relationships:**
- User → InternshipApplication (1:*)
- User → Assignment (1:*)
- User → Attendance (1:*)
- User → Logbook (1:*)
- User → Certificate (1:*)
- InternshipApplication → Certificate (1:1)
- Assignment → AssignmentSubmission (1:*)

**Association Relationships:**
- User → Divisi (*:1) - pembimbing assigned to divisi
- InternshipApplication → Divisi (*:1)
- InternshipApplication → Division (*:1) - via division_admin_id
- InternshipApplication → DivisionMentor (*:1)
- InternshipApplication → FieldOfInterest (*:1)
- Direktorat → SubDirektorat (1:*)
- SubDirektorat → Divisi (1:*)
- Division → DivisionMentor (1:*)

### Key Design Patterns:

1. **Active Record Pattern**: Semua models menggunakan Eloquent ORM
2. **Repository Pattern**: Models sebagai data access layer
3. **Factory Pattern**: Untuk testing data generation
4. **Observer Pattern**: Laravel events untuk notifikasi
5. **Strategy Pattern**: Berbeda role memiliki strategy akses berbeda

## 4.2. Object Interaction

### Sequence Diagram 1: Login dengan 2FA

```
Peserta          Browser       AuthController    User Model    Google2FA    Database
   │                │                 │               │            │            │
   │  Buka halaman  │                 │               │            │            │
   │    login       │                 │               │            │            │
   ├───────────────►│                 │               │            │            │
   │                │ GET /login      │               │            │            │
   │                ├────────────────►│               │            │            │
   │                │ Return view     │               │            │            │
   │                │◄────────────────┤               │            │            │
   │                │                 │               │            │            │
   │ Input username │                 │               │            │            │
   │ & password     │                 │               │            │            │
   ├───────────────►│                 │               │            │            │
   │                │ POST /login     │               │            │            │
   │                ├────────────────►│               │            │            │
   │                │                 │ findByUsername│            │            │
   │                │                 ├──────────────►│            │            │
   │                │                 │               │ SELECT     │            │
   │                │                 │               ├───────────►│            │
   │                │                 │               │ User data  │            │
   │                │                 │               │◄───────────┤            │
   │                │                 │ User object   │            │            │
   │                │                 │◄──────────────┤            │            │
   │                │                 │               │            │            │
   │                │                 │ Verify password            │            │
   │                │                 │ (bcrypt)      │            │            │
   │                │                 ├───────────────┐            │            │
   │                │                 │               │            │            │
   │                │                 │◄──────────────┘            │            │
   │                │                 │               │            │            │
   │                │                 │ Check 2FA required         │            │
   │                │                 ├───────────────┐            │            │
   │                │                 │◄──────────────┘            │            │
   │                │                 │               │            │            │
   │                │ Redirect to 2FA │               │            │            │
   │                │◄────────────────┤               │            │            │
   │  Show 2FA page │                 │               │            │            │
   │◄───────────────┤                 │               │            │            │
   │                │                 │               │            │            │
   │ Input 6-digit  │                 │               │            │            │
   │ 2FA code       │                 │               │            │            │
   ├───────────────►│                 │               │            │            │
   │                │ POST /verify-2fa│               │            │            │
   │                ├────────────────►│               │            │            │
   │                │                 │ Verify code   │            │            │
   │                │                 ├───────────────────────────►│            │
   │                │                 │               │            │            │
   │                │                 │ Validate TOTP │            │            │
   │                │                 │               │            │◄───────────┤
   │                │                 │ Valid (true)  │            │            │
   │                │                 │◄───────────────────────────┤            │
   │                │                 │               │            │            │
   │                │                 │ Create session│            │            │
   │                │                 ├───────────────────────────────────────►│
   │                │                 │               │            │  INSERT    │
   │                │                 │               │            │  session   │
   │                │                 │◄───────────────────────────────────────┤
   │                │                 │               │            │            │
   │                │ Redirect to     │               │            │            │
   │                │ dashboard       │               │            │            │
   │                │◄────────────────┤               │            │            │
   │  Dashboard     │                 │               │            │            │
   │◄───────────────┤                 │               │            │            │
```

### Sequence Diagram 2: Pengajuan Aplikasi Magang

```
Peserta    Browser    InternshipController  Application   Divisi   FieldOfInterest  FileStorage  Database
  │           │                 │              Model       Model        Model            │          │
  │  Isi form │                 │                │           │            │              │          │
  │ aplikasi  │                 │                │           │            │              │          │
  ├──────────►│                 │                │           │            │              │          │
  │           │ POST /internship│                │           │            │              │          │
  │           │ /apply          │                │           │            │              │          │
  │           ├────────────────►│                │           │            │              │          │
  │           │                 │ Validate input │           │            │              │          │
  │           │                 ├────────────────┐           │            │              │          │
  │           │                 │◄───────────────┘           │            │              │          │
  │           │                 │                │           │            │              │          │
  │           │                 │ Check field active         │            │              │          │
  │           │                 ├────────────────────────────────────────►│              │          │
  │           │                 │                │           │  SELECT    │              │          │
  │           │                 │                │           │  is_active │              │          │
  │           │                 │◄────────────────────────────────────────┤              │          │
  │           │                 │                │           │            │              │          │
  │           │                 │ Upload CV      │           │            │              │          │
  │           │                 ├───────────────────────────────────────────────────────►│          │
  │           │                 │                │           │            │  Store file  │          │
  │           │                 │                │           │            │◄─────────────┤          │
  │           │                 │ File path      │           │            │              │          │
  │           │                 │◄───────────────────────────────────────────────────────┤          │
  │           │                 │                │           │            │              │          │
  │           │                 │ Upload other docs (KTM, cover, good_behavior)          │          │
  │           │                 ├───────────────────────────────────────────────────────►│          │
  │           │                 │ File paths     │           │            │              │          │
  │           │                 │◄───────────────────────────────────────────────────────┤          │
  │           │                 │                │           │            │              │          │
  │           │                 │ Create application         │            │              │          │
  │           │                 ├───────────────►│           │            │              │          │
  │           │                 │                │ INSERT    │            │              │          │
  │           │                 │                ├───────────────────────────────────────────────►│
  │           │                 │                │ status='pending'       │              │  INSERT │
  │           │                 │                │◄───────────────────────────────────────────────┤
  │           │                 │ Application ID │           │            │              │          │
  │           │                 │◄───────────────┤           │            │              │          │
  │           │                 │                │           │            │              │          │
  │           │ Success message │                │           │            │              │          │
  │           │ + redirect      │                │           │            │              │          │
  │           │◄────────────────┤                │           │            │              │          │
  │  Konfirmasi│                │                │           │            │              │          │
  │◄───────────┤                │                │           │            │              │          │
```

### Sequence Diagram 3: Admin Approval dan Assign Mentor

```
Admin    Browser   AdminController  Application  Division  DivisionMentor  Mail    Email
  │         │             │           Model       Model        Model      Service  Server
  │  View   │             │             │           │            │          │        │
  │ pending │             │             │           │            │          │        │
  │ apps    │             │             │           │            │          │        │
  ├────────►│             │             │           │            │          │        │
  │         │ GET /admin  │             │           │            │          │        │
  │         │ /applications│            │           │            │          │        │
  │         ├────────────►│             │           │            │          │        │
  │         │             │ Get pending │           │            │          │        │
  │         │             ├────────────►│           │            │          │        │
  │         │             │ Applications│           │            │          │        │
  │         │             │◄────────────┤           │            │          │        │
  │         │ List view   │             │           │            │          │        │
  │         │◄────────────┤             │           │            │          │        │
  │  View   │             │             │           │            │          │        │
  │  list   │             │             │           │            │          │        │
  │◄────────┤             │             │           │            │          │        │
  │         │             │             │           │            │          │        │
  │ Select  │             │             │           │            │          │        │
  │ division│             │             │           │            │          │        │
  │ & mentor│             │             │           │            │          │        │
  ├────────►│             │             │           │            │          │        │
  │         │ POST /admin │             │           │            │          │        │
  │         │ /approve    │             │           │            │          │        │
  │         ├────────────►│             │           │            │          │        │
  │         │             │ Validate    │           │            │          │        │
  │         │             │ division    │           │            │          │        │
  │         │             ├─────────────────────────►           │          │        │
  │         │             │             │  Valid    │            │          │        │
  │         │             │◄─────────────────────────┤           │          │        │
  │         │             │             │           │            │          │        │
  │         │             │ Validate mentor          │            │          │        │
  │         │             ├─────────────────────────────────────►│          │        │
  │         │             │             │           │  Valid     │          │        │
  │         │             │◄─────────────────────────────────────┤          │        │
  │         │             │             │           │            │          │        │
  │         │             │ Update application       │            │          │        │
  │         │             ├────────────►│           │            │          │        │
  │         │             │             │ UPDATE status='accepted'│          │        │
  │         │             │             │ divisi_id, mentor_id    │          │        │
  │         │             │◄────────────┤           │            │          │        │
  │         │             │             │           │            │          │        │
  │         │ Success msg │             │           │            │          │        │
  │         │◄────────────┤             │           │            │          │        │
  │  View   │             │             │           │            │          │        │
  │confirmation            │             │           │            │          │        │
  │◄────────┤             │             │           │            │          │        │
  │         │             │             │           │            │          │        │
  │         │             │ Note: Mentor will then generate acceptance letter        │
  │         │             │ and send email (separate flow)        │          │        │
```

### Sequence Diagram 4: Mentor Generate & Send Acceptance Letter

```
Mentor   Browser   MentorController  Application  DomPDF   FileStorage  Mail    SMTP
  │         │             │            Model      Library      │       Service  Server
  │  View   │             │              │          │          │         │        │
  │ accepted│             │              │          │          │         │        │
  │ apps    │             │              │          │          │         │        │
  ├────────►│             │              │          │          │         │        │
  │         │ GET /mentor │              │          │          │         │        │
  │         │ /applications│             │          │          │         │        │
  │         ├────────────►│              │          │          │         │        │
  │         │             │ Get accepted │          │          │         │        │
  │         │             │ for this div │          │          │         │        │
  │         │             ├─────────────►│          │          │         │        │
  │         │             │ Applications │          │          │         │        │
  │         │             │◄─────────────┤          │          │         │        │
  │         │ List view   │              │          │          │         │        │
  │         │◄────────────┤              │          │          │         │        │
  │  View   │             │              │          │          │         │        │
  │  list   │             │              │          │          │         │        │
  │◄────────┤             │              │          │          │         │        │
  │         │             │              │          │          │         │        │
  │ Click   │             │              │          │          │         │        │
  │ Generate│             │              │          │          │         │        │
  │ Letter  │             │              │          │          │         │        │
  ├────────►│             │              │          │          │         │        │
  │         │ POST /mentor│              │          │          │         │        │
  │         │ /generate   │              │          │          │         │        │
  │         │ -letter     │              │          │          │         │        │
  │         ├────────────►│              │          │          │         │        │
  │         │             │ Get application data    │          │         │        │
  │         │             ├─────────────►│          │          │         │        │
  │         │             │ Data (user,  │          │          │         │        │
  │         │             │ dates, field)│          │          │         │        │
  │         │             │◄─────────────┤          │          │         │        │
  │         │             │              │          │          │         │        │
  │         │             │ Render PDF template     │          │         │        │
  │         │             ├─────────────────────────►          │         │        │
  │         │             │              │  Generate│          │         │        │
  │         │             │              │  PDF     │          │         │        │
  │         │             │ PDF binary   │◄─────────┤          │         │        │
  │         │             │◄─────────────────────────┤          │         │        │
  │         │             │              │          │          │         │        │
  │         │             │ Save PDF to storage     │          │         │        │
  │         │             ├─────────────────────────────────────►        │        │
  │         │             │ File path    │          │          │         │        │
  │         │             │◄─────────────────────────────────────┤        │        │
  │         │             │              │          │          │         │        │
  │         │             │ Update application       │          │         │        │
  │         │             │ with letter_path         │          │         │        │
  │         │             ├─────────────►│          │          │         │        │
  │         │             │◄─────────────┤          │          │         │        │
  │         │             │              │          │          │         │        │
  │         │             │ Queue email with PDF attachment     │         │        │
  │         │             ├─────────────────────────────────────────────►│        │
  │         │             │              │          │          │ Send    │        │
  │         │             │              │          │          │ email   │        │
  │         │             │              │          │          │ (queue) │        │
  │         │             │              │          │          │ ├──────────────►│
  │         │             │              │          │          │ │       │  SMTP  │
  │         │             │              │          │          │ │       │◄───────┤
  │         │             │              │          │          │◄┤       │        │
  │         │             │ Success      │          │          │         │        │
  │         │             │◄─────────────────────────────────────────────┤        │
  │         │ Success msg │              │          │          │         │        │
  │         │◄────────────┤              │          │          │         │        │
  │  View   │             │              │          │          │         │        │
  │ confirmation           │              │          │          │         │        │
  │◄────────┤             │              │          │          │         │        │
```

### Sequence Diagram 5: Peserta Submit Assignment

```
Peserta  Browser  DashboardController  Assignment  Submission  FileStorage  Database
  │         │             │              Model       Model          │          │
  │  View   │             │                │           │            │          │
  │ assignments            │                │           │            │          │
  ├────────►│             │                │           │            │          │
  │         │ GET /dashboard/assignments   │           │            │          │
  │         ├────────────►│                │           │            │          │
  │         │             │ Get assignments for user  │            │          │
  │         │             ├───────────────►│           │            │          │
  │         │             │                │ SELECT    │            │          │
  │         │             │                ├───────────────────────────────────►
  │         │             │                │◄───────────────────────────────────┤
  │         │             │ Assignments    │           │            │          │
  │         │             │◄───────────────┤           │            │          │
  │         │ List view   │                │           │            │          │
  │         │◄────────────┤                │           │            │          │
  │  View   │             │                │           │            │          │
  │  list   │             │                │           │            │          │
  │◄────────┤             │                │           │            │          │
  │         │             │                │           │            │          │
  │ Select  │             │                │           │            │          │
  │ assignment│            │                │           │            │          │
  │ Upload  │             │                │           │            │          │
  │ file    │             │                │           │            │          │
  ├────────►│             │                │           │            │          │
  │         │ POST /assignments/{id}/submit│           │            │          │
  │         ├────────────►│                │           │            │          │
  │         │             │ Validate file  │           │            │          │
  │         │             ├────────────────┐           │            │          │
  │         │             │◄───────────────┘           │            │          │
  │         │             │                │           │            │          │
  │         │             │ Upload file to storage     │            │          │
  │         │             ├───────────────────────────────────────►│          │
  │         │             │ File path      │           │            │          │
  │         │             │◄───────────────────────────────────────┤          │
  │         │             │                │           │            │          │
  │         │             │ Create submission          │            │          │
  │         │             ├───────────────────────────►│            │          │
  │         │             │                │           │ INSERT     │          │
  │         │             │                │           ├────────────────────────►
  │         │             │                │           │◄────────────────────────┤
  │         │             │ Submission ID  │           │            │          │
  │         │             │◄───────────────────────────┤            │          │
  │         │             │                │           │            │          │
  │         │             │ Update assignment submitted_at         │          │
  │         │             ├───────────────►│           │            │          │
  │         │             │                │ UPDATE    │            │          │
  │         │             │                ├────────────────────────────────────►
  │         │             │                │◄────────────────────────────────────┤
  │         │             │◄───────────────┤           │            │          │
  │         │             │                │           │            │          │
  │         │             │ [Send notification to mentor (async)]  │          │
  │         │             │                │           │            │          │
  │         │ Success msg │                │           │            │          │
  │         │◄────────────┤                │           │            │          │
  │  View   │             │                │           │            │          │
  │ confirmation           │                │           │            │          │
  │◄────────┤             │                │           │            │          │
```

### Sequence Diagram 6: Check-in Attendance dengan Foto

```
Peserta  Browser  AttendanceController  Attendance  FileStorage  Database  DateTime
  │         │             │               Model         │          │        Service
  │  Click  │             │                 │           │          │          │
  │ Check-in│             │                 │           │          │          │
  ├────────►│             │                 │           │          │          │
  │         │ Activate camera              │           │          │          │
  │         ├────────────┐                 │           │          │          │
  │         │◄───────────┘                 │           │          │          │
  │  Camera │             │                 │           │          │          │
  │  active │             │                 │           │          │          │
  │◄────────┤             │                 │           │          │          │
  │         │             │                 │           │          │          │
  │ Capture │             │                 │           │          │          │
  │ photo   │             │                 │           │          │          │
  ├────────►│             │                 │           │          │          │
  │         │ POST /attendance/check-in    │           │          │          │
  │         │ (with photo blob)            │           │          │          │
  │         ├────────────►│                 │           │          │          │
  │         │             │ Validate photo  │           │          │          │
  │         │             ├────────────────┐│           │          │          │
  │         │             │◄───────────────┘│           │          │          │
  │         │             │                 │           │          │          │
  │         │             │ Get current time│           │          │          │
  │         │             ├─────────────────────────────────────────────────►│
  │         │             │ Timestamp       │           │          │          │
  │         │             │◄─────────────────────────────────────────────────┤
  │         │             │                 │           │          │          │
  │         │             │ Check duplicate (same day)  │          │          │
  │         │             ├────────────────►│           │          │          │
  │         │             │                 │ SELECT    │          │          │
  │         │             │                 ├───────────────────────►         │
  │         │             │                 │ No record │          │          │
  │         │             │                 │◄───────────────────────┤         │
  │         │             │ OK (no duplicate)           │          │          │
  │         │             │◄────────────────┤           │          │          │
  │         │             │                 │           │          │          │
  │         │             │ Upload photo to storage     │          │          │
  │         │             ├─────────────────────────────────────────►         │
  │         │             │ Photo path      │           │          │          │
  │         │             │◄─────────────────────────────────────────┤         │
  │         │             │                 │           │          │          │
  │         │             │ Create attendance record    │          │          │
  │         │             ├────────────────►│           │          │          │
  │         │             │                 │ INSERT    │          │          │
  │         │             │                 │ status='present'     │          │
  │         │             │                 │ photo_path, check_in_time       │
  │         │             │                 ├───────────────────────►         │
  │         │             │                 │◄───────────────────────┤         │
  │         │             │ Attendance ID   │           │          │          │
  │         │             │◄────────────────┤           │          │          │
  │         │             │                 │           │          │          │
  │         │ Success msg │                 │           │          │          │
  │         │ + time      │                 │           │          │          │
  │         │◄────────────┤                 │           │          │          │
  │  View   │             │                 │           │          │          │
  │ confirmation           │                 │           │          │          │
  │◄────────┤             │                 │           │          │          │
```

---

# 5. Database Design

## 5.1. Entity Relationship Diagram (ERD)

```
┌──────────────────┐
│      users       │
├──────────────────┤
│ PK id            │
│    username      │──┐
│    name          │  │
│    email         │  │
│    password      │  │
│    nim           │  │
│    university    │  │
│    major         │  │
│    phone         │  │
│    ktp_number    │  │
│    ktm           │  │
│    role          │  │
│ FK divisi_id     │──┼──────────────────────────┐
│    two_factor_   │  │                          │
│    secret        │  │                          │
│    two_factor_   │  │                          │
│    verified_at   │  │                          │
└──────────────────┘  │                          │
         │            │                          │
         │ 1          │                          │
         │            │                          │
         │ *          │                          │
┌──────────────────┐  │                          │
│ internship_      │  │                          │
│ applications     │  │                          │
├──────────────────┤  │                          │
│ PK id            │  │                          │
│ FK user_id       │──┘                          │
│ FK divisi_id     │──────────────┐              │
│ FK division_     │              │              │
│    admin_id      │──────────┐   │              │
│ FK division_     │          │   │              │
│    mentor_id     │────┐     │   │              │
│ FK field_of_     │    │     │   │              │
│    interest_id   │──┐ │     │   │              │
│    status        │  │ │     │   │              │
│    start_date    │  │ │     │   │              │
│    end_date      │  │ │     │   │              │
│    cover_letter  │  │ │     │   │              │
│    ktm           │  │ │     │   │              │
│    surat_        │  │ │     │   │              │
│    permohonan    │  │ │     │   │              │
│    cv            │  │ │     │   │              │
│    good_behavior │  │ │     │   │              │
│    acceptance_   │  │ │     │   │              │
│    letter_path   │  │ │     │   │              │
│    assessment_   │  │ │     │   │              │
│    report_path   │  │ │     │   │              │
│    completion_   │  │ │     │   │              │
│    letter_path   │  │ │     │   │              │
│    acceptance_   │  │ │     │   │              │
│    letter_       │  │ │     │   │              │
│    downloaded_at │  │ │     │   │              │
│    notes         │  │ │     │   │              │
└──────────────────┘  │ │     │   │              │
         │ 1          │ │     │   │              │
         │            │ │     │   │              │
         │ 1          │ │     │   │              │
┌──────────────────┐  │ │     │   │              │
│  certificates    │  │ │     │   │              │
├──────────────────┤  │ │     │   │              │
│ PK id            │  │ │     │   │              │
│ FK user_id       │  │ │     │   │              │
│ FK internship_   │  │ │     │   │              │
│    application_id│──┘ │     │   │              │
│    certificate_  │    │     │   │              │
│    path          │    │     │   │              │
│    nomor_        │    │     │   │              │
│    sertifikat    │    │     │   │              │
│    predikat      │    │     │   │              │
│    issued_at     │    │     │   │              │
└──────────────────┘    │     │   │              │
                        │     │   │              │
┌──────────────────┐    │     │   │              │
│ field_of_        │    │     │   │              │
│ interests        │    │     │   │              │
├──────────────────┤    │     │   │              │
│ PK id            │◄───┘     │   │              │
│    name          │          │   │              │
│    description   │          │   │              │
│    icon          │          │   │              │
│    color         │          │   │              │
│    is_active     │          │   │              │
│    sort_order    │          │   │              │
│    division_     │          │   │              │
│    count         │          │   │              │
│    position_     │          │   │              │
│    count         │          │   │              │
│    duration_     │          │   │              │
│    months        │          │   │              │
└──────────────────┘          │   │              │
                              │   │              │
┌──────────────────┐          │   │              │
│ division_mentors │          │   │              │
├──────────────────┤          │   │              │
│ PK id            │◄─────────┘   │              │
│ FK division_id   │──┐           │              │
│    mentor_name   │  │           │              │
│    nik_number    │  │           │              │
└──────────────────┘  │           │              │
                      │           │              │
┌──────────────────┐  │           │              │
│ divisions        │  │           │              │
│ (DivisiAdmin)    │  │           │              │
├──────────────────┤  │           │              │
│ PK id            │◄─┼───────────┘              │
│    division_name │  │                          │
│    mentor_name   │  │                          │
│    nik_number    │  │                          │
│    is_active     │  │                          │
│    sort_order    │  │                          │
└──────────────────┘  │                          │
                      └──────────────────┐       │
                                         │       │
┌──────────────────┐                     │       │
│    divisis       │                     │       │
├──────────────────┤                     │       │
│ PK id            │◄────────────────────┼───────┘
│ FK sub_          │                     │
│    direktorat_id │──┐                  │
│    name          │  │                  │
│    vp            │  │                  │
│    nippos        │  │                  │
└──────────────────┘  │                  │
                      │                  │
┌──────────────────┐  │                  │
│ sub_direktorats  │  │                  │
├──────────────────┤  │                  │
│ PK id            │◄─┘                  │
│ FK direktorat_id │──┐                  │
│    name          │  │                  │
└──────────────────┘  │                  │
                      │                  │
┌──────────────────┐  │                  │
│  direktorats     │  │                  │
├──────────────────┤  │                  │
│ PK id            │◄─┘                  │
│    name          │                     │
└──────────────────┘                     │
                                         │
                                         │
┌──────────────────┐                     │
│  assignments     │                     │
├──────────────────┤                     │
│ PK id            │                     │
│ FK user_id       │─────────────────────┘
│    title         │
│    description   │
│    assignment_   │
│    type          │
│    deadline      │
│    presentation_ │
│    date          │
│    file_path     │
│    submission_   │
│    file_path     │
│    grade         │
│    submitted_at  │
└──────────────────┘
         │ 1
         │
         │ *
┌──────────────────┐
│ assignment_      │
│ submissions      │
├──────────────────┤
│ PK id            │
│ FK assignment_id │──┘
│ FK user_id       │
│    file_path     │
│    submitted_at  │
│    keterangan    │
└──────────────────┘


┌──────────────────┐
│   attendances    │
├──────────────────┤
│ PK id            │
│ FK user_id       │──┐
│    date          │  │
│    status        │  │
│    check_in_time │  │
│    photo_path    │  │
│    absence_      │  │
│    reason        │  │
│    absence_      │  │
│    proof_path    │  │
└──────────────────┘  │
                      │
┌──────────────────┐  │
│    logbooks      │  │
├──────────────────┤  │
│ PK id            │  │
│ FK user_id       │──┘ (All point back to users table)
│    date          │
│    content       │
└──────────────────┘

┌──────────────────┐
│      rules       │
├──────────────────┤
│ PK id            │
│    content       │
└──────────────────┘
```

### Relationship Summary:

**One-to-Many (1:*)**
- users → internship_applications (1 peserta, many applications over time)
- users → assignments (1 peserta, many assignments)
- users → attendances (1 peserta, many attendance records)
- users → logbooks (1 peserta, many logbook entries)
- users → certificates (1 peserta, many certificates)
- direktorats → sub_direktorats
- sub_direktorats → divisis
- divisis → internship_applications
- divisis → users (pembimbing)
- field_of_interests → internship_applications
- divisions (DivisiAdmin) → division_mentors
- divisions → internship_applications (via division_admin_id)
- division_mentors → internship_applications (via division_mentor_id)
- assignments → assignment_submissions

**One-to-One (1:1)**
- internship_applications → certificates

### Cardinality Constraints:
- A user (peserta) can have multiple internship_applications but only one active at a time
- A user (pembimbing) belongs to one divisi
- An application is assigned to one divisi and one mentor
- Each application can have at most one certificate

## 5.2. Database Schema Definitions

### Table: users

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | User unique identifier |
| username | VARCHAR(255) UNIQUE NOT NULL | Username untuk login (unique) |
| name | VARCHAR(255) NOT NULL | Nama lengkap user |
| email | VARCHAR(255) UNIQUE NOT NULL | Email address (unique) |
| password | VARCHAR(255) NOT NULL | Hashed password (bcrypt) |
| nim | VARCHAR(255) NULL | Nomor Induk Mahasiswa (untuk peserta) |
| university | VARCHAR(255) NULL | Nama universitas (untuk peserta) |
| major | VARCHAR(255) NULL | Jurusan/program studi (untuk peserta) |
| phone | VARCHAR(255) NULL | Nomor telepon |
| ktp_number | VARCHAR(255) NULL | Nomor KTP |
| ktm | VARCHAR(255) NULL | File path untuk Kartu Tanda Mahasiswa |
| role | ENUM('peserta','pembimbing','admin') NOT NULL | User role |
| divisi_id | BIGINT UNSIGNED NULL | Foreign key ke divisis (untuk pembimbing) |
| two_factor_secret | TEXT NULL | Google 2FA secret key |
| two_factor_verified_at | TIMESTAMP NULL | Waktu verifikasi 2FA pertama kali |
| remember_token | VARCHAR(100) NULL | Laravel remember token |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE KEY (username)
- UNIQUE KEY (email)
- INDEX (role)
- FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL

### Table: internship_applications

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Application unique identifier |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta) |
| divisi_id | BIGINT UNSIGNED NULL | Foreign key ke divisis (assigned division) |
| division_admin_id | BIGINT UNSIGNED NULL | Foreign key ke divisions (DivisiAdmin) |
| division_mentor_id | BIGINT UNSIGNED NULL | Foreign key ke division_mentors |
| field_of_interest_id | BIGINT UNSIGNED NOT NULL | Foreign key ke field_of_interests |
| status | ENUM('pending','accepted','rejected','finished','postponed') DEFAULT 'pending' | Status aplikasi |
| start_date | DATE NULL | Tanggal mulai magang |
| end_date | DATE NULL | Tanggal selesai magang |
| cover_letter | VARCHAR(255) NULL | File path cover letter |
| ktm | VARCHAR(255) NULL | File path KTM |
| surat_permohonan | VARCHAR(255) NULL | File path surat permohonan |
| cv | VARCHAR(255) NULL | File path CV |
| good_behavior | VARCHAR(255) NULL | File path surat kelakuan baik |
| acceptance_letter_path | VARCHAR(255) NULL | File path surat penerimaan (PDF) |
| assessment_report_path | VARCHAR(255) NULL | File path laporan penilaian |
| completion_letter_path | VARCHAR(255) NULL | File path surat keterangan selesai |
| acceptance_letter_downloaded_at | TIMESTAMP NULL | Waktu download surat penerimaan |
| notes | TEXT NULL | Catatan (alasan reject, dll) |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY (divisi_id) REFERENCES divisis(id) ON DELETE SET NULL
- FOREIGN KEY (division_admin_id) REFERENCES divisions(id) ON DELETE SET NULL
- FOREIGN KEY (division_mentor_id) REFERENCES division_mentors(id) ON DELETE SET NULL
- FOREIGN KEY (field_of_interest_id) REFERENCES field_of_interests(id)
- INDEX (status)
- INDEX (start_date, end_date)

### Table: assignments

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Assignment unique identifier |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta yang ditugaskan) |
| title | VARCHAR(255) NOT NULL | Judul tugas |
| description | TEXT NOT NULL | Deskripsi tugas |
| assignment_type | ENUM('regular','presentation') DEFAULT 'regular' | Tipe tugas |
| deadline | DATETIME NOT NULL | Batas waktu pengumpulan |
| presentation_date | DATE NULL | Tanggal presentasi (jika type=presentation) |
| file_path | VARCHAR(255) NULL | File path file tugas dari pembimbing |
| submission_file_path | VARCHAR(255) NULL | File path submission dari peserta (deprecated, use submissions table) |
| grade | DECIMAL(5,2) NULL | Nilai tugas (0-100) |
| submitted_at | TIMESTAMP NULL | Waktu submit tugas |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- INDEX (deadline)
- INDEX (assignment_type)

### Table: assignment_submissions

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Submission unique identifier |
| assignment_id | BIGINT UNSIGNED NOT NULL | Foreign key ke assignments |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta) |
| file_path | VARCHAR(255) NOT NULL | File path submission |
| submitted_at | TIMESTAMP DEFAULT CURRENT_TIMESTAMP | Waktu submit |
| keterangan | TEXT NULL | Keterangan/notes dari peserta |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- INDEX (submitted_at)

### Table: certificates

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Certificate unique identifier |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta) |
| internship_application_id | BIGINT UNSIGNED NOT NULL | Foreign key ke internship_applications |
| certificate_path | VARCHAR(255) NOT NULL | File path sertifikat PDF |
| nomor_sertifikat | VARCHAR(255) UNIQUE NOT NULL | Nomor sertifikat (format: CERT/POSINDO/{divisi}/{tahun}/{seq}) |
| predikat | ENUM('Sangat Baik','Baik','Cukup') NOT NULL | Predikat kelulusan |
| issued_at | DATE NOT NULL | Tanggal penerbitan |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- UNIQUE KEY (nomor_sertifikat)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- FOREIGN KEY (internship_application_id) REFERENCES internship_applications(id) ON DELETE CASCADE
- INDEX (issued_at)

### Table: attendances

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Attendance unique identifier |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta) |
| date | DATE NOT NULL | Tanggal absensi |
| status | ENUM('present','absent','excused') NOT NULL | Status kehadiran |
| check_in_time | TIME NULL | Waktu check-in |
| photo_path | VARCHAR(255) NULL | File path foto check-in |
| absence_reason | TEXT NULL | Alasan tidak hadir |
| absence_proof_path | VARCHAR(255) NULL | File path bukti ketidakhadiran |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- UNIQUE KEY (user_id, date) - Prevent duplicate check-in same day
- INDEX (date)
- INDEX (status)

### Table: logbooks

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Logbook unique identifier |
| user_id | BIGINT UNSIGNED NOT NULL | Foreign key ke users (peserta) |
| date | DATE NOT NULL | Tanggal aktivitas |
| content | TEXT NOT NULL | Konten/deskripsi aktivitas harian |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
- INDEX (user_id, date)
- INDEX (date)

### Table: direktorats

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Direktorat unique identifier |
| name | VARCHAR(255) NOT NULL | Nama direktorat |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |
| deleted_at | TIMESTAMP NULL | Soft delete timestamp |

**Indexes:**
- PRIMARY KEY (id)
- INDEX (name)

### Table: sub_direktorats

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Sub-Direktorat unique identifier |
| name | VARCHAR(255) NOT NULL | Nama sub-direktorat |
| direktorat_id | BIGINT UNSIGNED NOT NULL | Foreign key ke direktorats |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |
| deleted_at | TIMESTAMP NULL | Soft delete timestamp |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (direktorat_id) REFERENCES direktorats(id) ON DELETE CASCADE
- INDEX (name)

### Table: divisis

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Divisi unique identifier |
| name | VARCHAR(255) NOT NULL | Nama divisi |
| sub_direktorat_id | BIGINT UNSIGNED NOT NULL | Foreign key ke sub_direktorats |
| vp | VARCHAR(255) NULL | Nama VP divisi |
| nippos | VARCHAR(255) NULL | NIPPOS VP |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |
| deleted_at | TIMESTAMP NULL | Soft delete timestamp |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (sub_direktorat_id) REFERENCES sub_direktorats(id) ON DELETE CASCADE
- INDEX (name)

### Table: divisions (DivisiAdmin)

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Division unique identifier |
| division_name | VARCHAR(255) NOT NULL | Nama divisi |
| mentor_name | VARCHAR(255) NOT NULL | Nama admin divisi |
| nik_number | VARCHAR(6) NOT NULL | NIK admin (6 digit) |
| is_active | BOOLEAN DEFAULT TRUE | Status aktif divisi |
| sort_order | INTEGER DEFAULT 0 | Urutan tampilan |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |
| deleted_at | TIMESTAMP NULL | Soft delete timestamp |

**Indexes:**
- PRIMARY KEY (id)
- INDEX (division_name)
- INDEX (is_active)
- INDEX (sort_order)

### Table: division_mentors

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Division Mentor unique identifier |
| division_id | BIGINT UNSIGNED NOT NULL | Foreign key ke divisions |
| mentor_name | VARCHAR(255) NOT NULL | Nama pembimbing |
| nik_number | VARCHAR(6) NOT NULL | NIK pembimbing (6 digit) |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- FOREIGN KEY (division_id) REFERENCES divisions(id) ON DELETE CASCADE
- INDEX (nik_number)

### Table: field_of_interests

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Field unique identifier |
| name | VARCHAR(255) NOT NULL | Nama bidang minat |
| description | TEXT NULL | Deskripsi bidang |
| icon | VARCHAR(255) NULL | Icon class (Bootstrap Icons/Font Awesome) |
| color | VARCHAR(7) NULL | Warna (hex code, e.g., #FF5733) |
| is_active | BOOLEAN DEFAULT TRUE | Status aktif (tampil atau tidak) |
| sort_order | INTEGER DEFAULT 0 | Urutan tampilan |
| division_count | INTEGER NULL | Jumlah divisi terkait |
| position_count | INTEGER NULL | Jumlah posisi tersedia |
| duration_months | INTEGER NULL | Durasi magang (bulan) |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)
- INDEX (is_active)
- INDEX (sort_order)

### Table: rules

| Field | Type | Description |
|-------|------|-------------|
| id | BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY | Rule unique identifier |
| content | TEXT NOT NULL | Konten aturan sistem |
| created_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan record |
| updated_at | TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY (id)

### System Tables (Laravel Framework)

**sessions** - Menyimpan session data
**cache** - Cache storage
**cache_locks** - Cache locking
**jobs** - Queue jobs
**job_batches** - Batch job tracking
**failed_jobs** - Failed queue jobs
**password_reset_tokens** - Password reset tokens

---

# 6. User Interface Design (UI/UX)

## 6.1. Wireframes / Mockups

Sistem memiliki 3 dashboard utama yang disesuaikan dengan role pengguna: Peserta, Pembimbing, dan Admin.

### 6.1.1. Landing Page (Public)

**Deskripsi:**
Halaman publik yang dapat diakses tanpa login. Menampilkan informasi tentang program magang PT Pos Indonesia dan bidang-bidang minat yang tersedia.

**Komponen Utama:**
- **Header Navigation**: Logo PT Pos Indonesia, Menu (Beranda, Tentang, Bidang Minat, Login, Daftar)
- **Hero Section**: Banner utama dengan tagline "Bergabunglah dengan Program Magang PT Pos Indonesia"
- **Field of Interest Cards**: Grid cards menampilkan 14 bidang minat dengan icon dan warna yang berbeda:
  - Administrasi Umum & Tata Usaha (blue)
  - Finance, Accounting & Tax (green)
  - Human Resources (purple)
  - Digital Business & Strategy (cyan)
  - IT, Data & Information System (indigo)
  - Legal & Compliance (red)
  - Network & Infrastructure (orange)
  - Marketing, Communication & Branding (pink)
  - dll.
- **Call-to-Action Buttons**: "Daftar Sekarang", "Pelajari Lebih Lanjut"
- **Footer**: Contact info, social media, copyright

**Layout:**
```
┌────────────────────────────────────────────────────────────┐
│  [Logo PT Pos]    Beranda  Tentang  Bidang  [Login] [Daftar]│
├────────────────────────────────────────────────────────────┤
│                                                            │
│         BERGABUNGLAH DENGAN PROGRAM MAGANG                 │
│              PT POS INDONESIA                              │
│                                                            │
│         [Daftar Sekarang]  [Pelajari Lebih Lanjut]        │
│                                                            │
├────────────────────────────────────────────────────────────┤
│                  BIDANG MINAT MAGANG                       │
│                                                            │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐      │
│  │ [Icon]  │  │ [Icon]  │  │ [Icon]  │  │ [Icon]  │      │
│  │ Admin   │  │ Finance │  │   HR    │  │   IT    │      │
│  │ Umum    │  │         │  │         │  │         │      │
│  └─────────┘  └─────────┘  └─────────┘  └─────────┘      │
│                                                            │
│  [... 10 cards lainnya dalam grid responsive ...]         │
│                                                            │
├────────────────────────────────────────────────────────────┤
│  Contact: info@posindonesia.co.id  │  © 2025 PT Pos       │
└────────────────────────────────────────────────────────────┘
```

### 6.1.2. Login Page

**Deskripsi:**
Halaman login dengan 2FA verification untuk peserta dan pembimbing.

**Komponen:**
- Form login (username/NIK + password)
- Remember me checkbox
- Link ke halaman register (untuk peserta)
- Link forgot password
- Setelah login berhasil → halaman 2FA verification (input 6-digit code)

**Layout:**
```
┌────────────────────────────────────┐
│        [Logo PT Pos Indonesia]     │
│                                    │
│      LOGIN KE SISTEM MAGANG        │
│                                    │
│  ┌──────────────────────────────┐  │
│  │ Username / NIK               │  │
│  └──────────────────────────────┘  │
│                                    │
│  ┌──────────────────────────────┐  │
│  │ Password                     │  │
│  └──────────────────────────────┘  │
│                                    │
│  ☐ Remember Me                     │
│                                    │
│      [Login]                       │
│                                    │
│  Belum punya akun? [Daftar di sini]│
│  [Lupa Password?]                  │
└────────────────────────────────────┘

(After successful credential validation)

┌────────────────────────────────────┐
│     VERIFIKASI TWO-FACTOR AUTH     │
│                                    │
│ Masukkan kode 6-digit dari         │
│ Google Authenticator App           │
│                                    │
│  ┌───┬───┬───┬───┬───┬───┐        │
│  │ X │ X │ X │ X │ X │ X │        │
│  └───┴───┴───┴───┴───┴───┘        │
│                                    │
│      [Verify]                      │
│                                    │
│  [Kembali ke Login]                │
└────────────────────────────────────┘
```

### 6.1.3. Registration Page (Peserta Only)

**Deskripsi:**
Form registrasi untuk peserta magang baru.

**Komponen:**
- Personal info (nama, email, phone)
- Account info (username, password)
- Academic info (NIM, universitas, jurusan)
- KTP number
- Upload KTM (Kartu Tanda Mahasiswa)
- Terms & conditions checkbox

**Layout:**
```
┌────────────────────────────────────────────┐
│         REGISTRASI PESERTA MAGANG          │
│                                            │
│  INFORMASI AKUN                            │
│  ┌─────────────────────────────────────┐   │
│  │ Username *                          │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Email *                             │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Password *                          │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  INFORMASI PRIBADI                         │
│  ┌─────────────────────────────────────┐   │
│  │ Nama Lengkap *                      │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Nomor Telepon *                     │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Nomor KTP *                         │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  INFORMASI AKADEMIK                        │
│  ┌─────────────────────────────────────┐   │
│  │ NIM *                               │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Nama Universitas *                  │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Program Studi / Jurusan *           │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  UPLOAD DOKUMEN                            │
│  Upload KTM (Kartu Tanda Mahasiswa)        │
│  [Browse...] [Filename.jpg]                │
│                                            │
│  ☐ Saya setuju dengan syarat dan ketentuan │
│                                            │
│      [Daftar]      [Batal]                 │
└────────────────────────────────────────────┘
```

### 6.1.4. Dashboard Peserta

**Deskripsi:**
Dashboard utama untuk peserta magang. Menampilkan status aplikasi, tugas, absensi, dan navigasi ke fitur-fitur.

**Komponen:**
- **Top Bar**: Welcome message, notification icon, profile menu
- **Sidebar Navigation**: Dashboard, Aplikasi Magang, Tugas, Absensi, Logbook, Sertifikat, Profil, Logout
- **Main Content Area**:
  - Status Card (status aplikasi: pending/accepted/rejected/finished)
  - Statistics Cards (Total Tugas, Tugas Selesai, Attendance Rate)
  - Recent Assignments Table
  - Quick Actions (Check-in, Upload Assignment, Add Logbook)

**Layout:**
```
┌─────────┬──────────────────────────────────────────────────────┐
│ [LOGO]  │ Welcome, [Nama Peserta]      [🔔] [Profile ▼]      │
├─────────┼──────────────────────────────────────────────────────┤
│         │                                                      │
│ 📊 Dash │  STATUS APLIKASI MAGANG                             │
│         │  ┌───────────────────────────────────────────────┐  │
│ 📝 Aplikasi  │ Status: ACCEPTED ✓                         │  │
│ Magang  │  │ Divisi: IT & Data Management                  │  │
│         │  │ Pembimbing: Budi Santoso                      │  │
│ 📋 Tugas │  │ Periode: 01 Jan 2025 - 31 Mar 2025          │  │
│         │  └───────────────────────────────────────────────┘  │
│ ✅ Absensi                                                   │
│         │  STATISTIK                                          │
│ 📖 Logbook │ ┌──────────┐ ┌──────────┐ ┌──────────┐         │
│         │  │ Total    │ │ Tugas    │ │ Tingkat  │         │
│ 🎓 Sertifikat│ Tugas: 8│ │ Selesai: │ │ Absensi: │         │
│         │  │          │ │    6     │ │   95%    │         │
│ 👤 Profil│  └──────────┘ └──────────┘ └──────────┘         │
│         │                                                      │
│ 🚪 Logout│  TUGAS TERBARU                                     │
│         │  ┌────────────────────────────────────────────────┐ │
│         │  │ Judul         │ Deadline    │ Status   │ Aksi │ │
│         │  ├────────────────────────────────────────────────┤ │
│         │  │ Analisis Data │ 25 Dec 2025 │ Pending  │[Upload]│
│         │  │ Presentasi UI │ 28 Dec 2025 │ Submitted│[View]│ │
│         │  └────────────────────────────────────────────────┘ │
│         │                                                      │
│         │  QUICK ACTIONS                                      │
│         │  [Check-in Absensi] [Upload Tugas] [Tambah Logbook]│
└─────────┴──────────────────────────────────────────────────────┘
```

### 6.1.5. Application Form (Peserta)

**Deskripsi:**
Form pengajuan aplikasi magang oleh peserta.

**Komponen:**
- Field of interest selection (dropdown atau card selection)
- Tanggal mulai dan selesai magang
- Upload documents:
  - CV (PDF, max 2MB)
  - Cover Letter (PDF, max 2MB)
  - KTM (JPG/PNG, max 1MB)
  - Surat Kelakuan Baik (PDF, max 2MB)
- Submit button

**Layout:**
```
┌────────────────────────────────────────────┐
│    FORMULIR PENGAJUAN MAGANG               │
│                                            │
│  PILIH BIDANG MINAT *                      │
│  ┌─────────────────────────────────────┐   │
│  │ ▼ Pilih Bidang Minat                │   │
│  └─────────────────────────────────────┘   │
│  (Dropdown: Administrasi, Finance, HR, IT, dll)
│                                            │
│  PERIODE MAGANG                            │
│  Tanggal Mulai *    Tanggal Selesai *      │
│  ┌──────────────┐  ┌──────────────┐        │
│  │ 📅 DD/MM/YYYY│  │ 📅 DD/MM/YYYY│        │
│  └──────────────┘  └──────────────┘        │
│                                            │
│  UPLOAD DOKUMEN PERSYARATAN                │
│  ┌─────────────────────────────────────┐   │
│  │ CV (PDF, max 2MB) *                 │   │
│  │ [Browse...] [filename.pdf] ✓        │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Cover Letter (PDF, max 2MB) *       │   │
│  │ [Browse...] [No file selected]      │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ KTM (JPG/PNG, max 1MB) *            │   │
│  │ [Browse...] [No file selected]      │   │
│  └─────────────────────────────────────┘   │
│  ┌─────────────────────────────────────┐   │
│  │ Surat Kelakuan Baik (PDF, max 2MB)* │   │
│  │ [Browse...] [No file selected]      │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  ☐ Saya menyatakan bahwa data yang saya    │
│     berikan adalah benar dan dapat          │
│     dipertanggungjawabkan                   │
│                                            │
│      [Submit Aplikasi]    [Batal]          │
└────────────────────────────────────────────┘
```

### 6.1.6. Attendance Check-in Page (Peserta)

**Deskripsi:**
Halaman untuk check-in absensi dengan foto selfie.

**Komponen:**
- Camera preview (live feed dari webcam/camera)
- Capture button
- Preview hasil foto
- Submit button
- Riwayat absensi (tabel)
- Form pengajuan izin (jika tidak bisa hadir)

**Layout:**
```
┌────────────────────────────────────────────┐
│           ABSENSI HARIAN                   │
│                                            │
│  Tanggal: Jumat, 21 Desember 2025          │
│                                            │
│  FOTO CHECK-IN                             │
│  ┌─────────────────────────────────────┐   │
│  │                                     │   │
│  │      [Camera Live Preview]          │   │
│  │                                     │   │
│  │         (Your face here)            │   │
│  │                                     │   │
│  └─────────────────────────────────────┘   │
│                                            │
│        [📷 Capture Photo]                  │
│                                            │
│  (After capture)                           │
│  ┌─────────────────────────────────────┐   │
│  │    [Preview of captured photo]      │   │
│  └─────────────────────────────────────┘   │
│                                            │
│     [✓ Submit Check-in]  [🔄 Retake]       │
│                                            │
├────────────────────────────────────────────┤
│  RIWAYAT ABSENSI (7 Hari Terakhir)         │
│  ┌────────────────────────────────────┐    │
│  │ Tanggal  │ Status  │ Waktu │ Foto │    │
│  ├────────────────────────────────────┤    │
│  │ 20 Dec   │ Hadir   │ 08:15 │ [👁]│    │
│  │ 19 Dec   │ Hadir   │ 08:22 │ [👁]│    │
│  │ 18 Dec   │ Izin    │   -   │  -  │    │
│  └────────────────────────────────────┘    │
│                                            │
│  [Ajukan Izin Ketidakhadiran]              │
└────────────────────────────────────────────┘
```

### 6.1.7. Dashboard Pembimbing

**Deskripsi:**
Dashboard untuk pembimbing mengelola peserta magang di divisinya.

**Komponen:**
- **Top Bar**: Welcome, notifications, profile
- **Sidebar**: Dashboard, Aplikasi, Tugas, Absensi, Logbook, Laporan, Sertifikat
- **Main Content**:
  - Statistics cards (Total Peserta, Aplikasi Pending, Tugas Belum Dinilai)
  - Pending applications table
  - Recent submissions
  - Quick actions (Buat Tugas, Review Aplikasi, Generate Sertifikat)

**Layout:**
```
┌──────────┬─────────────────────────────────────────────────────┐
│ [LOGO]   │ Welcome, Pembimbing [Nama]   [🔔] [Profile ▼]     │
├──────────┼─────────────────────────────────────────────────────┤
│          │                                                     │
│ 📊 Dashboard STATISTIK DIVISI                                 │
│          │ ┌──────────┐ ┌──────────┐ ┌──────────┐            │
│ 📝 Review│ │ Peserta  │ │ Aplikasi │ │  Tugas   │            │
│ Aplikasi │ │ Aktif: 12│ │ Pending:3│ │ Belum    │            │
│          │ │          │ │          │ │ Dinilai:5│            │
│ 📋 Kelola│ └──────────┘ └──────────┘ └──────────┘            │
│ Tugas    │                                                     │
│          │ APLIKASI MENUNGGU REVIEW                            │
│ ✅ Monitor│┌─────────────────────────────────────────────────┐ │
│ Absensi  ││ Nama      │ Univ     │ Bidang │ Tanggal │ Aksi ││ │
│          │├─────────────────────────────────────────────────┤ │
│ 📖 Logbook│ Andi      │ Telkom U │ IT     │ 20 Dec  │[Review]│
│ Peserta  ││ Budi      │ ITB      │ Finance│ 19 Dec  │[Review]│
│          │└─────────────────────────────────────────────────┘ │
│ 📊 Laporan                                                     │
│          │ SUBMISSION TUGAS TERBARU                            │
│ 🎓 Generate│┌────────────────────────────────────────────────┐ │
│ Sertifikat │ Peserta  │ Tugas        │ Submitted │ Aksi  ││ │
│          │├────────────────────────────────────────────────┤ │
│ 🚪 Logout││ Citra    │ UI Analysis  │ 21 Dec    │[Grade]││ │
│          ││ Dani     │ Data Report  │ 20 Dec    │[Grade]││ │
│          │└────────────────────────────────────────────────┘ │
│          │                                                     │
│          │ QUICK ACTIONS                                       │
│          │ [Buat Tugas Baru] [Review Aplikasi] [Lihat Absensi]│
└──────────┴─────────────────────────────────────────────────────┘
```

### 6.1.8. Review Application (Pembimbing)

**Deskripsi:**
Halaman detail aplikasi untuk review dan approval oleh pembimbing.

**Komponen:**
- Informasi peserta (nama, universitas, NIM, kontak)
- Field of interest yang dipilih
- Periode magang
- Preview dokumen yang diupload (CV, cover letter, KTM, surat kelakuan baik)
- Accept/Reject buttons
- Form catatan (untuk rejection reason)
- Generate acceptance letter button (setelah accept)

**Layout:**
```
┌────────────────────────────────────────────────────────┐
│         REVIEW APLIKASI MAGANG                         │
│                                                        │
│  INFORMASI PESERTA                                     │
│  Nama         : Andi Wijaya                            │
│  NIM          : 1234567890                             │
│  Universitas  : Universitas Telkom                     │
│  Jurusan      : Informatika                            │
│  Email        : andi.wijaya@email.com                  │
│  Phone        : 08123456789                            │
│                                                        │
│  INFORMASI MAGANG                                      │
│  Bidang Minat : IT, Data & Information System          │
│  Periode      : 01 Jan 2025 - 31 Mar 2025             │
│  Durasi       : 3 bulan                                │
│                                                        │
│  DOKUMEN PERSYARATAN                                   │
│  ┌──────────────────────────────────────────────────┐  │
│  │ ✓ CV                     [Download] [Preview]   │  │
│  │ ✓ Cover Letter           [Download] [Preview]   │  │
│  │ ✓ KTM                    [Download] [Preview]   │  │
│  │ ✓ Surat Kelakuan Baik    [Download] [Preview]   │  │
│  └──────────────────────────────────────────────────┘  │
│                                                        │
│  KEPUTUSAN                                             │
│  ┌──────────────────────────────────────────────────┐  │
│  │ Catatan (Opsional):                              │  │
│  │ ┌──────────────────────────────────────────────┐ │  │
│  │ │                                              │ │  │
│  │ └──────────────────────────────────────────────┘ │  │
│  └──────────────────────────────────────────────────┘  │
│                                                        │
│    [✓ Terima Aplikasi]   [✗ Tolak Aplikasi]  [Kembali]│
│                                                        │
│  (After acceptance)                                    │
│    [📄 Generate & Send Acceptance Letter]             │
└────────────────────────────────────────────────────────┘
```

### 6.1.9. Create Assignment (Pembimbing)

**Deskripsi:**
Form pembuatan tugas baru untuk peserta.

**Komponen:**
- Pilih peserta (dropdown atau multi-select)
- Judul tugas
- Deskripsi tugas (rich text editor)
- Tipe tugas (Regular / Presentation)
- Deadline
- Tanggal presentasi (jika tipe presentation)
- Upload file tugas (opsional)

**Layout:**
```
┌────────────────────────────────────────────┐
│         BUAT TUGAS BARU                    │
│                                            │
│  PILIH PESERTA *                           │
│  ☐ Semua Peserta                           │
│  ┌─────────────────────────────────────┐   │
│  │ ☐ Andi Wijaya                       │   │
│  │ ☐ Budi Santoso                      │   │
│  │ ☐ Citra Dewi                        │   │
│  │ ... (scrollable list)               │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  INFORMASI TUGAS                           │
│  Judul Tugas *                             │
│  ┌─────────────────────────────────────┐   │
│  │                                     │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  Deskripsi Tugas *                         │
│  ┌─────────────────────────────────────┐   │
│  │ [Rich Text Editor]                  │   │
│  │                                     │   │
│  │                                     │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  Tipe Tugas *                              │
│  ○ Regular      ○ Presentation             │
│                                            │
│  Deadline *                                │
│  ┌──────────────┐  ┌──────────────┐        │
│  │ 📅 DD/MM/YYYY│  │ 🕐 HH:MM     │        │
│  └──────────────┘  └──────────────┘        │
│                                            │
│  (If Presentation selected)                │
│  Tanggal Presentasi                        │
│  ┌──────────────┐                          │
│  │ 📅 DD/MM/YYYY│                          │
│  └──────────────┘                          │
│                                            │
│  Upload File Tugas (Opsional)              │
│  [Browse...] [No file selected]            │
│                                            │
│      [Buat Tugas]      [Batal]             │
└────────────────────────────────────────────┘
```

### 6.1.10. Dashboard Admin

**Deskripsi:**
Dashboard administrator untuk mengelola seluruh sistem.

**Komponen:**
- **Top Bar**: Welcome, notifications, profile
- **Sidebar Navigation**: Dashboard, Aplikasi, Peserta, Pembimbing, Divisi, Bidang Minat, Laporan, Pengaturan
- **Main Content**:
  - Overall statistics (Total Aplikasi, Total Peserta, Total Pembimbing, Total Divisi)
  - Charts (Application trend, Field of interest distribution)
  - Recent applications
  - Quick actions (Approve Application, Add Mentor, Generate Report)

**Layout:**
```
┌──────────┬─────────────────────────────────────────────────────┐
│ [LOGO]   │ Welcome, Admin            [🔔] [Profile ▼]        │
├──────────┼─────────────────────────────────────────────────────┤
│          │                                                     │
│ 📊 Dashboarddata│ STATISTIK KESELURUHAN                                │
│          │ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐
│ 📝 Aplikasi│ Total    │ │  Total   │ │  Total   │ │  Total   │
│          │ │ Aplikasi │ │ Peserta  │ │Pembimbing│ │  Divisi  │
│ 👥 Kelola│ │   245    │ │   189    │ │    28    │ │    14    │
│ Peserta  │ └──────────┘ └──────────┘ └──────────┘ └──────────┘
│          │                                                     │
│ 👨‍💼 Kelola│ APPLICATION TREND (Chart)                          │
│ Pembimbing│┌───────────────────────────────────────────────┐   │
│          ││ [Bar/Line Chart menunjukkan trend aplikasi]   │   │
│ 🏢 Kelola││ per bulan                                      │   │
│ Divisi   │└───────────────────────────────────────────────┘   │
│          │                                                     │
│ 🎯 Bidang│ APLIKASI TERBARU                                    │
│ Minat    │┌─────────────────────────────────────────────────┐ │
│          ││ Nama    │ Univ   │ Bidang │ Status │ Aksi     ││ │
│ 📊 Laporan│├────────────────────────────────────────────────┤ │
│          ││ Andi    │ Telkom │ IT     │ Pending │[Approve]││ │
│ ⚙️  Pengatur││ Budi  │ ITB    │Finance │ Pending │[Approve]││ │
│ an       │└─────────────────────────────────────────────────┘ │
│          │                                                     │
│ 🚪 Logout│ QUICK ACTIONS                                       │
│          │ [Approve Aplikasi] [Tambah Pembimbing] [Laporan]   │
└──────────┴─────────────────────────────────────────────────────┘
```

### 6.1.11. Manage Divisions (Admin)

**Deskripsi:**
Halaman pengelolaan struktur organisasi (Direktorat, Sub-Direktorat, Divisi).

**Komponen:**
- Tabs untuk Direktorat, Sub-Direktorat, Divisi
- CRUD table untuk setiap entitas
- Hierarchical view (tree structure)
- Add/Edit/Delete actions
- Assign mentor to division

**Layout:**
```
┌────────────────────────────────────────────────────────┐
│         KELOLA STRUKTUR ORGANISASI                     │
│                                                        │
│  [Direktorat] [Sub-Direktorat] [Divisi]               │
│                                                        │
│  DAFTAR DIVISI                     [+ Tambah Divisi]   │
│  ┌──────────────────────────────────────────────────┐  │
│  │ Nama Divisi          │ Sub-Dir  │ Mentor │ Aksi │  │
│  ├──────────────────────────────────────────────────┤  │
│  │ IT & Data Management │ IT Ops   │ Budi   │[✏️][🗑]│  │
│  │ Finance & Accounting │ Finance  │ Citra  │[✏️][🗑]│  │
│  │ HR & Organization    │ HR       │ Dani   │[✏️][🗑]│  │
│  │ Marketing & Comm     │ Marketing│ Eka    │[✏️][🗑]│  │
│  │ ... (20+ divisions)                              │  │
│  └──────────────────────────────────────────────────┘  │
│                                                        │
│  HIERARKI ORGANISASI                                   │
│  📁 Direktorat Teknologi & Operasi                     │
│    └─ 📂 Sub-Direktorat IT Operations                 │
│        ├─ 📄 IT & Data Management (Mentor: Budi)      │
│        └─ 📄 Network & Infrastructure (Mentor: Fani)  │
│    └─ 📂 Sub-Direktorat Digital Business              │
│        └─ 📄 Digital Strategy (Mentor: Gani)          │
│  📁 Direktorat Keuangan                                │
│    └─ 📂 Sub-Direktorat Finance                       │
│        └─ 📄 Finance & Accounting (Mentor: Citra)     │
└────────────────────────────────────────────────────────┘
```

### 6.1.12. Reports Page (Admin)

**Deskripsi:**
Halaman generate laporan dengan berbagai filter.

**Komponen:**
- Report type selection (Application, Attendance, Logbook, Comprehensive)
- Filter options:
  - Date range (dari tanggal - sampai tanggal)
  - Division filter
  - Status filter
  - Year/Period filter
- Export format (PDF / Excel)
- Preview button
- Download button

**Layout:**
```
┌────────────────────────────────────────────┐
│         GENERATE LAPORAN                   │
│                                            │
│  TIPE LAPORAN *                            │
│  ○ Laporan Aplikasi                        │
│  ○ Laporan Absensi                         │
│  ○ Laporan Logbook                         │
│  ○ Laporan Komprehensif                    │
│                                            │
│  FILTER                                    │
│  Periode                                   │
│  Dari: [📅 DD/MM/YYYY] Sampai: [📅 DD/MM/YYYY]
│                                            │
│  Divisi                                    │
│  ┌─────────────────────────────────────┐   │
│  │ ▼ Semua Divisi                      │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  Status                                    │
│  ☐ Pending  ☐ Accepted  ☐ Rejected        │
│  ☐ Finished ☐ Postponed                    │
│                                            │
│  Tahun                                     │
│  ┌─────────────────────────────────────┐   │
│  │ ▼ 2025                              │   │
│  └─────────────────────────────────────┘   │
│                                            │
│  FORMAT EXPORT *                           │
│  ○ PDF      ○ Excel                        │
│                                            │
│  [👁️ Preview]  [⬇️ Download]  [Batal]      │
└────────────────────────────────────────────┘
```

## 6.2. Navigation Flow

### 6.2.1. Peserta Navigation Flow

```
                     ┌──────────────┐
                     │ Landing Page │
                     └──────┬───────┘
                            │
                ┌───────────┴───────────┐
                │                       │
         ┌──────▼──────┐         ┌─────▼──────┐
         │   Login     │         │  Register  │
         └──────┬──────┘         └─────┬──────┘
                │                      │
                │ ◄────────────────────┘
                │
         ┌──────▼──────┐
         │ 2FA Verify  │
         └──────┬──────┘
                │
         ┌──────▼──────────┐
         │ Dashboard       │
         │ (Peserta)       │
         └──────┬──────────┘
                │
    ┌───────────┼───────────┬───────────┬───────────┐
    │           │           │           │           │
┌───▼────┐  ┌──▼──────┐ ┌──▼──────┐ ┌──▼──────┐ ┌─▼────┐
│Aplikasi│  │  Tugas  │ │ Absensi │ │ Logbook │ │Profil│
│ Magang │  │         │ │         │ │         │ │      │
└───┬────┘  └──┬──────┘ └──┬──────┘ └──┬──────┘ └──────┘
    │           │           │           │
┌───▼────────┐ │      ┌────▼─────┐     │
│Submit Form │ │      │Check-in  │     │
└───┬────────┘ │      │w/ Photo  │     │
    │           │      └──────────┘     │
┌───▼─────────┐│                       │
│View Status  ││                       │
│Download     ││                       │
│Letter       ││                       │
└─────────────┘│                       │
               │                       │
          ┌────▼──────┐           ┌────▼──────┐
          │View Tugas │           │Add Entry  │
          │Submit     │           │Edit Entry │
          │Download   │           │View       │
          └───────────┘           └───────────┘
```

### 6.2.2. Pembimbing Navigation Flow

```
         ┌──────────────┐
         │    Login     │
         │  (NIK+Pass)  │
         └──────┬───────┘
                │
         ┌──────▼──────┐
         │ 2FA Verify  │
         └──────┬──────┘
                │
         ┌──────▼──────────────┐
         │ Dashboard           │
         │ (Pembimbing)        │
         └──────┬──────────────┘
                │
    ┌───────────┼───────────┬────────────┬───────────┐
    │           │           │            │           │
┌───▼────┐  ┌──▼──────┐ ┌──▼────────┐ ┌─▼──────┐ ┌─▼──────┐
│Review  │  │ Kelola  │ │  Monitor  │ │Logbook │ │Laporan │
│Aplikasi│  │  Tugas  │ │  Absensi  │ │Peserta │ │        │
└───┬────┘  └──┬──────┘ └───────────┘ └────────┘ └────────┘
    │           │
┌───▼─────────┐│
│View Detail  ││
│Accept/Reject││
│Generate     ││
│Letter       ││
└─────────────┘│
               │
          ┌────▼──────┐
          │Create     │
          │Assignment │
          ├───────────┤
          │Grade      │
          │Submission │
          ├───────────┤
          │Request    │
          │Revision   │
          └───────────┘
```

### 6.2.3. Admin Navigation Flow

```
         ┌──────────────┐
         │    Login     │
         │ (No 2FA)     │
         └──────┬───────┘
                │
         ┌──────▼──────────────┐
         │ Dashboard (Admin)   │
         └──────┬──────────────┘
                │
    ┌───────────┼───────────┬────────────┬──────────┬────────┐
    │           │           │            │          │        │
┌───▼────┐  ┌──▼──────┐ ┌──▼────────┐ ┌─▼──────┐ ┌▼──────┐ ┌▼──────┐
│Approve │  │ Kelola  │ │  Kelola   │ │ Kelola │ │Bidang │ │Laporan│
│Aplikasi│  │ Peserta │ │Pembimbing │ │ Divisi │ │ Minat │ │       │
└───┬────┘  └──┬──────┘ └───┬───────┘ └───┬────┘ └───┬───┘ └───┬───┘
    │           │            │             │          │         │
┌───▼─────────┐│       ┌────▼─────┐  ┌────▼──────┐  │    ┌────▼─────┐
│Assign       ││       │Add       │  │Add Divisi │  │    │Generate  │
│Division +   ││       │Mentor    │  │Add Sub-Dir│  │    │PDF/Excel │
│Mentor       ││       │Reset Pass│  │Add Direkt │  │    │          │
└─────────────┘│       │Assign    │  │Manage     │  │    └──────────┘
               │       │Division  │  │Hierarchy  │  │
          ┌────▼──────┐└──────────┘  └───────────┘  │
          │View All   │                             │
          │Edit       │                        ┌────▼──────┐
          │Delete     │                        │Enable/    │
          │Upload Docs│                        │Disable    │
          └───────────┘                        │Reorder    │
                                               │Edit       │
                                               └───────────┘
```

---

# 7. Data Flow & Process Flow

## 7.1. Data Flow Diagram (DFD)

### 7.1.1. DFD Level 0 (Context Diagram)

```
                              ┌──────────────────────┐
                              │                      │
                    ┌────────►│  Sistem Manajemen    │◄──────────┐
                    │         │  Magang PT Pos       │           │
    ┌───────────────┴──┐      │  Indonesia           │      ┌────┴───────────┐
    │                  │      │                      │      │                │
    │  Peserta Magang  │      └──────────┬───────────┘      │  Pembimbing    │
    │                  │                 │                  │                │
    └──────────────────┘                 │                  └────────────────┘
           │                             │                         │
           │ • Registrasi                │ • Dashboard Stats       │ • Review Aplikasi
           │ • Aplikasi Magang           │ • Reports               │ • Buat Tugas
           │ • Upload Dokumen            │ • Notifikasi            │ • Grade Tugas
           │ • Submit Tugas              │                         │ • Generate Letter
           │ • Check-in Absensi          │                         │ • Upload Sertifikat
           │ • Isi Logbook               │                         │
           │ • Download Sertifikat       │                         │
           │                             │                         │
           ▼                             ▼                         ▼
    ┌──────────────────┐        ┌────────────────┐        ┌────────────────┐
    │  Data Peserta    │        │  Data Sistem   │        │ Data Pembimbing│
    │  Data Aplikasi   │        │  Data Laporan  │        │ Data Penilaian │
    │  Data Tugas      │        │                │        │                │
    │  Data Absensi    │        │                │        │                │
    │  Data Logbook    │        │                │        │                │
    │  Data Sertifikat │        │                │        │                │
    └──────────────────┘        └────────────────┘        └────────────────┘
                                        ▲
                                        │
                                        │
                                  ┌─────┴──────┐
                                  │            │
                                  │   Admin    │
                                  │            │
                                  └────────────┘
                                        │
                                        │ • Approve Aplikasi
                                        │ • Kelola Organisasi
                                        │ • Kelola Pembimbing
                                        │ • Generate Laporan
                                        │ • Manage Fields
                                        ▼
                               ┌─────────────────┐
                               │  Data Master    │
                               │  • Divisi       │
                               │  • Direktorat   │
                               │  • Fields       │
                               │  • Users        │
                               └─────────────────┘
```

### 7.1.2. DFD Level 1 - Proses Utama

```
┌──────────┐                                              ┌──────────┐
│ Peserta  │                                              │Pembimbing│
└────┬─────┘                                              └────┬─────┘
     │                                                         │
     │ Registrasi Data                                         │
     ▼                                                         │
┌────────────────────┐                                        │
│ 1.0                │          ┌──────────────┐             │
│ Authentication     │◄────────►│ D1: users    │             │
│ & Registration     │          └──────────────┘             │
└────────┬───────────┘                                        │
         │ User Authenticated                                 │
         │                                                    │
         ▼                                                    │
┌────────────────────┐          ┌──────────────┐             │
│ 2.0                │◄────────►│ D2: internship_            │
│ Manajemen          │          │ applications │◄────────────┤
│ Aplikasi Magang    │          └──────────────┘             │
└────────┬───────────┘                 ▲                     │
         │                             │                     │
         │ Aplikasi Data               │ Approval Data       │
         │                             │                     │
         ▼                             │                     │
┌────────────────────┐          ┌──────┴──────┐              │
│ 3.0                │◄────────►│ D3: field_of│              │
│ Manajemen          │          │ interests   │              │
│ Dokumen            │          └─────────────┘              │
└────────┬───────────┘                                        │
         │                                                    │
         │ Upload Files                                       │
         │                                                    │
         ▼                                                    │
┌────────────────────┐          ┌──────────────┐             │
│ 4.0                │◄────────►│ D4: file     │             │
│ File Storage       │          │ storage      │             │
└────────────────────┘          └──────────────┘             │
         │                                                    │
         │ Tugas Data                                         │
         │                                                    │
         ▼                                                    ▼
┌────────────────────┐          ┌──────────────┐   ┌─────────────────┐
│ 5.0                │◄────────►│ D5:          │◄──│ Create Tugas    │
│ Manajemen Tugas    │          │ assignments  │   │ Grade Tugas     │
└────────┬───────────┘          └──────────────┘   └─────────────────┘
         │                                                    │
         │ Attendance Data                                    │
         │                                                    │
         ▼                                                    │
┌────────────────────┐          ┌──────────────┐             │
│ 6.0                │◄────────►│ D6:          │             │
│ Manajemen Absensi  │          │ attendances  │             │
└────────┬───────────┘          └──────────────┘             │
         │                                                    │
         │ Logbook Data                                       │
         │                                                    │
         ▼                                                    │
┌────────────────────┐          ┌──────────────┐             │
│ 7.0                │◄────────►│ D7: logbooks │             │
│ Manajemen Logbook  │          └──────────────┘             │
└────────┬───────────┘                                        │
         │                                                    │
         │ Cert Request                                       │
         │                                                    │
         ▼                                                    ▼
┌────────────────────┐          ┌──────────────┐   ┌─────────────────┐
│ 8.0                │◄────────►│ D8:          │◄──│ Generate Cert   │
│ Manajemen          │          │ certificates │   └─────────────────┘
│ Sertifikat         │          └──────────────┘             │
└────────────────────┘                 │                     │
         │                             │                     │
         │ Cert Download               │                     │
         │                             │                     │
         ▼                             │                     │
┌──────────┐                           │              ┌──────┴─────┐
│ Peserta  │                           │              │ Pembimbing │
└──────────┘                           │              └────────────┘
                                       │
                                       ▼
                              ┌─────────────────┐
                              │      Admin      │
                              └─────────────────┘
                                       │
                                       │
                                       ▼
                              ┌─────────────────┐
                              │ 9.0             │
                              │ Reporting &     │
                              │ Analytics       │
                              └─────────────────┘
                                       │
                                       ▼
                              ┌─────────────────┐
                              │ PDF/Excel       │
                              │ Export          │
                              └─────────────────┘
```

### 7.1.3. DFD Level 2 - Proses Aplikasi Magang (2.0)

```
┌──────────┐                                              ┌──────────┐
│ Peserta  │                                              │  Admin   │
└────┬─────┘                                              └────┬─────┘
     │                                                         │
     │ Application Data                                        │
     │ + Documents                                             │
     ▼                                                         │
┌────────────────────┐                                        │
│ 2.1                │          ┌──────────────┐             │
│ Submit Application │─────────►│ D2.1:        │             │
│                    │          │ applications │             │
└────────────────────┘          │ (pending)    │             │
                                └──────┬───────┘             │
                                       │                     │
                                       │ Pending Apps        │
                                       ▼                     │
                                ┌──────────────────┐         │
                                │ 2.2              │◄────────┤
                                │ Admin Review     │         │
                                │ & Assign         │         │
                                └──────┬───────────┘         │
                                       │                     │
                                       │ Assigned Apps       │
                                       ▼                     │
                                ┌──────────────┐             │
                                │ D2.2:        │             │
                                │ applications │             │
                                │ (assigned)   │             │
                                └──────┬───────┘             │
                                       │                     │
                                       │ Assigned Apps       │
                                       ▼                     │
┌──────────┐                    ┌──────────────────┐         │
│Pembimbing│◄───────────────────│ 2.3              │         │
└────┬─────┘                    │ Mentor Review    │         │
     │                          │ & Decision       │         │
     │                          └──────┬───────────┘         │
     │ Accept/Reject                   │                     │
     │                                 │                     │
     ▼                                 ▼                     │
┌────────────────────┐          ┌──────────────┐             │
│ 2.4                │─────────►│ D2.3:        │             │
│ Generate           │          │ applications │             │
│ Acceptance Letter  │          │ (accepted)   │             │
└────────┬───────────┘          └──────────────┘             │
         │                                                    │
         │ PDF + Email                                        │
         │                                                    │
         ▼                                                    │
┌────────────────────┐          ┌──────────────┐             │
│ 2.5                │─────────►│ D2.4:        │             │
│ Send Notification  │          │ notification │             │
│ (Email)            │          │ queue        │             │
└────────────────────┘          └──────────────┘             │
         │                                                    │
         │ Email Sent                                         │
         ▼                                                    │
┌──────────┐                                          ┌──────┴─────┐
│ Peserta  │                                          │   Admin    │
└──────────┘                                          └────────────┘
```

## 7.2. Activity Diagram

### 7.2.1. Activity Diagram - Login dengan 2FA

```
┌─────────────────────────────────────────────────────────────────┐
│                     LOGIN DENGAN 2FA                            │
└─────────────────────────────────────────────────────────────────┘

    [Start]
       │
       ▼
 ┌───────────────┐
 │ Buka Halaman  │
 │    Login      │
 └───────┬───────┘
         │
         ▼
 ┌───────────────────────┐
 │ Input Username/NIK    │
 │ & Password            │
 └───────┬───────────────┘
         │
         ▼
 ┌───────────────────────┐
 │ Submit Form           │
 └───────┬───────────────┘
         │
         ▼
    ◇───────────◇
   /  Credentials \     No
  <   Valid?       >─────────┐
   \             /            │
    ◇───────────◇             │
         │ Yes                │
         ▼                    ▼
    ◇───────────◇      ┌──────────────┐
   /   User Has  \     │ Show Error   │
  <    2FA Setup? >    │ "Invalid     │
   \             /     │ Credentials" │
    ◇───────────◇      └──────┬───────┘
         │ Yes │ No            │
         │     │               │
         │     ▼               │
         │ ┌─────────────┐    │
         │ │ Setup 2FA   │    │
         │ │ Show QR     │    │
         │ │ Code        │    │
         │ └─────┬───────┘    │
         │       │            │
         ▼       ▼            │
 ┌─────────────────────┐      │
 │ Redirect to 2FA     │      │
 │ Verification Page   │      │
 └─────────┬───────────┘      │
           │                  │
           ▼                  │
 ┌─────────────────────┐      │
 │ Input 6-Digit       │      │
 │ 2FA Code            │      │
 └─────────┬───────────┘      │
           │                  │
           ▼                  │
 ┌─────────────────────┐      │
 │ Verify Code         │      │
 └─────────┬───────────┘      │
           │                  │
           ▼                  │
      ◇─────────◇             │
     /  Code      \     No    │
    <   Valid?    >───────────┤
     \           /             │
      ◇─────────◇              │
           │ Yes               │
           ▼                   │
 ┌─────────────────────┐       │
 │ Create Session      │       │
 │ Set Auth Cookie     │       │
 └─────────┬───────────┘       │
           │                   │
           ▼                   │
      ◇─────────◇              │
     /   User     \             │
    <    Role?    >             │
     \           /              │
      ◇─────────◇               │
      │    │    │               │
Peserta  Pemb  Admin            │
      │    │    │               │
      ▼    ▼    ▼               │
   ┌────┬────┬────┐             │
   │ Dashboard   │              │
   │ Peserta/    │              │
   │ Pemb/Admin  │              │
   └─────┬───────┘              │
         │                      │
         ▼                      │
      [End]◄────────────────────┘
```

### 7.2.2. Activity Diagram - Submit Aplikasi Magang

```
┌─────────────────────────────────────────────────────────────────┐
│              SUBMIT APLIKASI MAGANG (PESERTA)                   │
└─────────────────────────────────────────────────────────────────┘

    [Start]
       │
       ▼
 ┌───────────────────┐
 │ Akses Menu        │
 │ Aplikasi Magang   │
 └───────┬───────────┘
         │
         ▼
    ◇──────────◇
   /  Sudah Ada  \      Yes
  <   Aplikasi    >────────────┐
   \ Aktif?      /              │
    ◇──────────◇                │
         │ No                   │
         ▼                      ▼
 ┌───────────────────┐   ┌──────────────┐
 │ Tampilkan Form    │   │ Show Error   │
 │ Aplikasi Baru     │   │ "Aplikasi    │
 └───────┬───────────┘   │  Sudah Ada"  │
         │               └──────┬───────┘
         ▼                      │
 ┌───────────────────────┐      │
 │ Pilih Field of        │      │
 │ Interest              │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Input Tanggal Mulai   │      │
 │ & Tanggal Selesai     │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Upload CV             │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Upload Cover Letter   │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Upload KTM            │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Upload Surat          │      │
 │ Kelakuan Baik         │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
 ┌───────────────────────┐      │
 │ Submit Form           │      │
 └───────┬───────────────┘      │
         │                      │
         ▼                      │
    ◇──────────◇                │
   / Validasi   \      No       │
  <  Berhasil?  >───────────────┤
   \           /                 │
    ◇──────────◇                 │
         │ Yes                   │
         ▼                       │
 ┌───────────────────────┐       │
 │ Simpan Aplikasi       │       │
 │ Status: PENDING       │       │
 └───────┬───────────────┘       │
         │                       │
         ▼                       │
 ┌───────────────────────┐       │
 │ Upload Dokumen ke     │       │
 │ File Storage          │       │
 └───────┬───────────────┘       │
         │                       │
         ▼                       │
 ┌───────────────────────┐       │
 │ Show Success Message  │       │
 │ "Aplikasi Berhasil    │       │
 │  Disubmit"            │       │
 └───────┬───────────────┘       │
         │                       │
         ▼                       │
 ┌───────────────────────┐       │
 │ Redirect ke           │       │
 │ Dashboard             │       │
 └───────┬───────────────┘       │
         │                       │
         ▼                       │
      [End]◄─────────────────────┘
```

### 7.2.3. Activity Diagram - Review & Approve Aplikasi (Admin + Mentor)

```
┌─────────────────────────────────────────────────────────────────┐
│        REVIEW & APPROVE APLIKASI (ADMIN + MENTOR)               │
└─────────────────────────────────────────────────────────────────┘

        Admin Lane                    Pembimbing Lane
    ┌──────────────┐                ┌────────────────┐
    │              │                │                │
    │   [Start]    │                │                │
    │      │       │                │                │
    │      ▼       │                │                │
    │ ┌─────────┐  │                │                │
    │ │ View    │  │                │                │
    │ │ Pending │  │                │                │
    │ │ Apps    │  │                │                │
    │ └────┬────┘  │                │                │
    │      │       │                │                │
    │      ▼       │                │                │
    │ ┌─────────┐  │                │                │
    │ │ Select  │  │                │                │
    │ │ App to  │  │                │                │
    │ │ Review  │  │                │                │
    │ └────┬────┘  │                │                │
    │      │       │                │                │
    │      ▼       │                │                │
    │ ┌──────────┐ │                │                │
    │ │ View App │ │                │                │
    │ │ Details  │ │                │                │
    │ │ & Docs   │ │                │                │
    │ └────┬─────┘ │                │                │
    │      │       │                │                │
    │      ▼       │                │                │
    │  ◇────────◇  │                │                │
    │ / Approve? \ │                │                │
    │<  atau      >│                │                │
    │ \ Reject?  / │                │                │
    │  ◇────────◇  │                │                │
    │   │      │   │                │                │
    │ Reject Approve               │                │
    │   │      │   │                │                │
    │   │      ▼   │                │                │
    │   │ ┌────────┐                │                │
    │   │ │ Pilih  │                │                │
    │   │ │ Divisi │                │                │
    │   │ │ & Mentor                │                │
    │   │ └────┬───┘                │                │
    │   │      │   │                │                │
    │   │      ▼   │                │                │
    │   │ ┌────────┐                │                │
    │   │ │ Update │                │                │
    │   │ │ Status:│                │                │
    │   │ │ACCEPTED│                │                │
    │   │ │ Assign │                │                │
    │   │ │Division│                │                │
    │   │ └────┬───┘                │                │
    │   │      │   │                │    [Notif]     │
    │   │      └───┼────────────────┼────────►       │
    │   │          │                │        │       │
    │   ▼          │                │        ▼       │
    │ ┌────────┐   │                │   ┌─────────┐  │
    │ │ Input  │   │                │   │ Lihat   │  │
    │ │ Alasan │   │                │   │ Aplikasi│  │
    │ │ Reject │   │                │   │ Assigned│  │
    │ └────┬───┘   │                │   └────┬────┘  │
    │      │       │                │        │       │
    │      ▼       │                │        ▼       │
    │ ┌────────┐   │                │   ┌─────────┐  │
    │ │ Update │   │                │   │ Review  │  │
    │ │ Status:│   │                │   │ Details │  │
    │ │REJECTED│   │                │   │ & Docs  │  │
    │ └────┬───┘   │                │   └────┬────┘  │
    │      │       │                │        │       │
    │      └───┬───┘                │        ▼       │
    │          │                    │    ◇────────◇  │
    │          ▼                    │   / Accept?  \ │
    │    ┌─────────┐                │  <  atau     > │
    │    │  Send   │                │   \ Reject? /  │
    │    │ Notif   │                │    ◇────────◇  │
    │    │ ke      │                │     │      │   │
    │    │ Peserta │                │   Reject Accept │
    │    └────┬────┘                │     │      │   │
    │         │                     │     │      ▼   │
    │         ▼                     │     │  ┌───────┐
    │      [End]                    │     │  │Generate│
    │                               │     │  │Accept- │
    │                               │     │  │ance    │
    │                               │     │  │Letter  │
    │                               │     │  │(PDF)   │
    │                               │     │  └───┬───┘
    │                               │     │      │   │
    │                               │     │      ▼   │
    │                               │     │  ┌───────┐
    │                               │     │  │ Send  │
    │                               │     │  │ Email │
    │                               │     │  │ with  │
    │                               │     │  │ PDF   │
    │                               │     │  └───┬───┘
    │                               │     │      │   │
    │                               │     ▼      ▼   │
    │                               │  ┌──────────┐  │
    │                               │  │  Send    │  │
    │                               │  │  Notif   │  │
    │                               │  │ Rejected │  │
    │                               │  └────┬─────┘  │
    │                               │       │        │
    │                               │       ▼        │
    │                               │    [End]       │
    │                               │                │
    └───────────────────────────────┴────────────────┘
```

### 7.2.4. Activity Diagram - Check-in Absensi

```
┌─────────────────────────────────────────────────────────────────┐
│                   CHECK-IN ABSENSI (PESERTA)                    │
└─────────────────────────────────────────────────────────────────┘

    [Start]
       │
       ▼
 ┌───────────────────┐
 │ Akses Menu        │
 │ Absensi           │
 └───────┬───────────┘
         │
         ▼
    ◇──────────◇
   /  Sudah      \      Yes
  <   Check-in    >────────────┐
   \ Hari Ini?   /              │
    ◇──────────◇                │
         │ No                   │
         ▼                      ▼
 ┌───────────────────┐   ┌──────────────┐
 │ Click Button      │   │ Show Error   │
 │ "Check-in"        │   │ "Sudah       │
 └───────┬───────────┘   │  Check-in"   │
         │               └──────┬───────┘
         ▼                      │
    ◇──────────◇                │
   /  Izinkan    \     No        │
  <   Akses       >──────────────┤
   \ Kamera?     /                │
    ◇──────────◇                 │
         │ Yes                   │
         ▼                       │
 ┌───────────────────┐            │
 │ Aktifkan Kamera   │            │
 │ (Live Preview)    │            │
 └───────┬───────────┘            │
         │                       │
         ▼                       │
 ┌───────────────────┐            │
 │ Peserta Posisi    │            │
 │ Wajah di Frame    │            │
 └───────┬───────────┘            │
         │                       │
         ▼                       │
 ┌───────────────────┐            │
 │ Click "Capture    │            │
 │ Photo"            │            │
 └───────┬───────────┘            │
         │                       │
         ▼                       │
 ┌───────────────────┐            │
 │ Tampilkan Preview │            │
 │ Foto              │            │
 └───────┬───────────┘            │
         │                       │
         ▼                       │
    ◇──────────◇                 │
   /  Foto OK?  \      No        │
  <    atau      >────────────┐   │
   \ Retake?    /             │   │
    ◇──────────◇              │   │
         │ OK                 │   │
         ▼                    ▼   │
 ┌───────────────────┐  ┌─────────┐
 │ Click "Submit     │  │ Retake  │
 │ Check-in"         │  │ Photo   │
 └───────┬───────────┘  └────┬────┘
         │                   │    │
         ▼                   │    │
 ┌───────────────────┐       │    │
 │ Upload Foto ke    │       │    │
 │ Storage           │       │    │
 └───────┬───────────┘       │    │
         │                   │    │
         ▼                   │    │
 ┌───────────────────┐       │    │
 │ Get Current Time  │       │    │
 └───────┬───────────┘       │    │
         │                   │    │
         ▼                   │    │
 ┌───────────────────┐       │    │
 │ Simpan Attendance │       │    │
 │ Record:           │       │    │
 │ - date: today     │       │    │
 │ - status: present │       │    │
 │ - check_in_time   │       │    │
 │ - photo_path      │       │    │
 └───────┬───────────┘       │    │
         │                   │    │
         ▼                   │    │
    ◇──────────◇             │    │
   /  Terlambat? \    Yes    │    │
  <   (>08:30)    >───────┐  │    │
   \            /          │  │    │
    ◇──────────◇           │  │    │
         │ No              │  │    │
         │                 ▼  │    │
         │          ┌──────────┐   │
         │          │ Set Flag │   │
         │          │ "Terlambat"  │
         │          └─────┬────┘   │
         │                │    │   │
         ▼                ▼    │   │
 ┌───────────────────┐         │   │
 │ Show Success      │         │   │
 │ Message:          │         │   │
 │ "Check-in Sukses" │         │   │
 │ + waktu check-in  │         │   │
 └───────┬───────────┘         │   │
         │                     │   │
         ▼                     │   │
      [End]◄───────────────────┴───┘
```

## 7.3. State Machine Diagram

### 7.3.1. State Machine - Internship Application

```
┌────────────────────────────────────────────────────────────┐
│         STATE MACHINE: INTERNSHIP APPLICATION              │
└────────────────────────────────────────────────────────────┘

                        [Submit Application]
                                 │
                                 ▼
                        ┌────────────────┐
                        │                │
                        │    PENDING     │
                        │                │
                        └────┬───────────┘
                             │
                ┌────────────┴────────────┐
                │                         │
        [Admin Approve]           [Admin/Mentor Reject]
        + Assign Division                 │
                │                         │
                ▼                         ▼
        ┌────────────────┐        ┌────────────────┐
        │                │        │                │
        │    ACCEPTED    │        │    REJECTED    │
        │                │        │                │
        └────┬───────────┘        └────────────────┘
             │                            │
             │                            │
    [Pembimbing Generate               [Can Re-apply]
     Acceptance Letter]                   │
             │                            │
             ▼                            ▼
    ┌────────────────┐              [Submit New
    │  Letter Sent   │               Application]
    └────┬───────────┘                   │
         │                                │
         │                                ▼
    [Internship Period                Back to
     Starts & Runs]                   PENDING
         │
         │
    [End Date Reached]
         │
         ▼
┌────────────────┐
│                │
│    FINISHED    │
│                │
└────┬───────────┘
     │
     │
[Pembimbing Upload:
 - Assessment Report
 - Completion Letter
 - Certificate]
     │
     ▼
┌────────────────┐
│ Certificate    │
│ Issued         │
└────────────────┘
     │
     │
[Peserta Download
 Certificate]
     │
     ▼
┌────────────────┐
│                │
│   COMPLETED    │
│  (End State)   │
│                │
└────────────────┘


Alternative Flow:

┌────────────────┐
│                │
│    ACCEPTED    │
│                │
└────┬───────────┘
     │
     │
[Special Case:
 Postpone Request]
     │
     ▼
┌────────────────┐
│                │
│   POSTPONED    │
│                │
└────┬───────────┘
     │
     │
[New Dates Set]
     │
     ▼
Back to ACCEPTED
```

### 7.3.2. State Machine - Assignment

```
┌────────────────────────────────────────────────────────────┐
│              STATE MACHINE: ASSIGNMENT                     │
└────────────────────────────────────────────────────────────┘

            [Pembimbing Creates Assignment]
                         │
                         ▼
                ┌────────────────┐
                │                │
                │    CREATED     │
                │  (Not Started) │
                │                │
                └────┬───────────┘
                     │
                     │
            [Peserta Views Assignment]
                     │
                     ▼
                ┌────────────────┐
                │                │
                │   IN PROGRESS  │
                │  (Not Submitted)│
                │                │
                └────┬───────────┘
                     │
                ┌────┴────┐
                │         │
   [Deadline Passed]  [Peserta Submit]
    No Submission         │
                │         │
                ▼         ▼
        ┌────────────────┐
        │                │
        │   SUBMITTED    │
        │  (Waiting for  │
        │    Grading)    │
        │                │
        └────┬───────────┘
             │
             │
    [Pembimbing Reviews]
             │
      ┌──────┴──────┐
      │             │
[Needs Revision]  [Grade Assigned]
      │             │
      ▼             ▼
┌────────────┐  ┌────────────────┐
│            │  │                │
│  REVISION  │  │     GRADED     │
│  REQUESTED │  │   (Complete)   │
│            │  │                │
└────┬───────┘  └────────────────┘
     │                  │
     │                  │
[Peserta Resubmit]     [End State]
     │
     ▼
Back to SUBMITTED


Overdue State:

┌────────────────┐
│  IN PROGRESS   │
└────┬───────────┘
     │
     │
[Deadline Passed
 No Submission]
     │
     ▼
┌────────────────┐
│                │
│    OVERDUE     │
│  (Late Submit  │
│   Allowed)     │
│                │
└────┬───────────┘
     │
     │
[Late Submission]
     │
     ▼
┌────────────────┐
│   SUBMITTED    │
│   (Late)       │
│ [Penalty Flag] │
└────────────────┘
```

### 7.3.3. State Machine - User Account (2FA Status)

```
┌────────────────────────────────────────────────────────────┐
│         STATE MACHINE: USER ACCOUNT (2FA)                  │
└────────────────────────────────────────────────────────────┘

            [User Registers]
                  │
                  ▼
          ┌────────────────┐
          │                │
          │   REGISTERED   │
          │   (No 2FA)     │
          │                │
          └────┬───────────┘
               │
               │
    [First Login - Role Check]
               │
        ┌──────┴──────┐
        │             │
    [Admin Role]  [Peserta/Pembimbing]
        │             │
        ▼             ▼
┌────────────┐  ┌────────────────┐
│            │  │                │
│   ACTIVE   │  │  PENDING 2FA   │
│ (No 2FA    │  │    SETUP       │
│  Required) │  │                │
│            │  └────┬───────────┘
└────────────┘       │
                     │
            [Setup 2FA - Scan QR]
                     │
                     ▼
             ┌────────────────┐
             │                │
             │ 2FA CONFIGURED │
             │ (Not Verified) │
             │                │
             └────┬───────────┘
                  │
                  │
         [Verify 2FA Code]
                  │
           ┌──────┴──────┐
           │             │
      [Valid Code]  [Invalid Code]
           │             │
           ▼             │
    ┌────────────┐       │
    │            │       │
    │   ACTIVE   │       │
    │ (2FA       │       │
    │  Verified) │       │
    │            │       │
    └────────────┘       │
           │             │
           │             ▼
           │      Retry Verification
           │             │
           │             │
           │      [Max Attempts]
           │             │
           │             ▼
           │      ┌────────────┐
           │      │            │
           │      │  LOCKED    │
           │      │ (Account   │
           │      │  Suspended)│
           │      │            │
           │      └────────────┘
           │             │
           │             │
           │      [Admin Unlock]
           │             │
           │             │
           └─────────────┘


Subsequent Logins:

┌────────────┐
│   ACTIVE   │
│ (2FA)      │
└────┬───────┘
     │
     │
[Each Login Requires
 2FA Verification]
     │
     ▼
┌────────────────┐
│ 2FA Required   │
│ for Access     │
└────────────────┘
```

---

# 8. System Constraints

Sistem Manajemen Penerimaan Magang PT Pos Indonesia memiliki beberapa batasan dan constraint yang diterapkan pada implementasi:

## 8.1. Hardware Constraints

**Server Requirements (Minimum for Production):**
- **CPU**: 2 vCPU cores (Intel Xeon atau AMD EPYC)
- **RAM**: 4 GB minimum, 8 GB recommended
- **Storage**: 50 GB SSD minimum, 100 GB recommended (untuk file storage)
- **Network**: 100 Mbps connection minimum, 1 Gbps recommended

**Client Requirements (End Users):**
- **Desktop/Laptop**: Any modern computer with browser (2 GB RAM minimum)
- **Mobile Devices**: Android 8.0+ atau iOS 12+ untuk mobile access
- **Camera**: Webcam atau smartphone camera untuk attendance check-in
- **Internet**: Minimum 2 Mbps untuk smooth operation, 5 Mbps recommended

**Bandwidth Considerations:**
- Peak usage: Estimasi 50-100 concurrent users
- Average file upload size: 2-5 MB per document
- Daily data transfer: Approximately 5-10 GB

## 8.2. Software Version Constraints

**Backend Requirements:**
- **PHP**: Version 8.2 or higher (required by Laravel 12)
- **Database**: SQLite 3.x (development), MySQL 8.0+ atau PostgreSQL 14+ (production recommended)
- **Web Server**: Apache 2.4+ dengan mod_rewrite, atau Nginx 1.18+
- **Composer**: Version 2.5+

**Frontend Requirements:**
- **Browsers Supported**:
  - Google Chrome 100+
  - Mozilla Firefox 95+
  - Safari 15+
  - Microsoft Edge 100+
  - Opera 85+
- **Mobile Browsers**: Chrome Mobile, Safari Mobile (latest versions)
- **JavaScript**: ES6+ support required

**Third-Party Libraries Fixed Versions:**
- Laravel Framework: 12.0
- Bootstrap: 5.3.8
- Tailwind CSS: 4.0
- jQuery: 3.7.1
- Alpine.js: 3.15.3
- Chart.js: 4.5.1
- DomPDF: 3.1
- Maatwebsite Excel: 3.1
- Google2FA: 9.0

**Note**: Version upgrades harus melalui testing terlebih dahulu karena potential breaking changes.

## 8.3. Regulatory Constraints (UU PDP - Undang-Undang Perlindungan Data Pribadi)

**Data Privacy Compliance:**

1. **Personal Data Collection**:
   - Hanya mengumpulkan data yang necessary untuk proses magang
   - Explicit consent required saat registrasi (checkbox syarat & ketentuan)
   - Data yang dikumpulkan: Nama, Email, Phone, NIM, KTP, Universitas, Jurusan

2. **Data Storage & Security**:
   - Password di-hash menggunakan bcrypt (tidak disimpan plain text)
   - 2FA mandatory untuk non-admin users (enhanced security)
   - File dokumen disimpan dengan access control (hanya owner, assigned mentor, dan admin yang dapat akses)
   - Database backup encrypted
   - Session timeout: 120 menit (automatic logout untuk keamanan)

3. **Data Access & Transparency**:
   - User dapat melihat data pribadi mereka sendiri (profil page)
   - User dapat update data pribadi (dengan validasi)
   - Admin access logged untuk audit trail (future enhancement)

4. **Data Retention**:
   - Aplikasi yang ditolak: Data retained selama 30 hari, kemudian dihapus
   - Aplikasi yang diterima: Data retained selama program + 1 tahun untuk keperluan arsip
   - Soft delete untuk user accounts (data tidak langsung dihapus dari database)

5. **Data Sharing**:
   - Data peserta TIDAK dibagikan ke pihak ketiga
   - Data hanya accessible oleh: Peserta sendiri, Pembimbing assigned, dan Admin
   - Acceptance letter dan certificate dapat di-download oleh peserta

6. **User Rights**:
   - Right to access: User dapat view data pribadi
   - Right to rectification: User dapat update data jika ada kesalahan
   - Right to erasure: User dapat request penghapusan data (melalui admin)
   - Right to data portability: Export data dalam format PDF/Excel (future enhancement)

## 8.4. Budget & Time Constraints

**Development Timeline Constraints:**
- Project development: 3-4 bulan (design + implementation + testing)
- Testing phase: 2 minggu minimum
- Deployment & training: 1 minggu
- Post-launch support: Ongoing

**Budget Constraints:**
- **Development**: Internal team (no external vendor)
- **Infrastructure**:
  - Development: Free (Laravel Sail, local SQLite)
  - Production: Budget-friendly cloud hosting (DigitalOcean, AWS Lightsail, ~$50-100/month)
- **Third-Party Services**:
  - Email: Free tier SMTP (Gmail SMTP atau SendGrid free tier)
  - SSL Certificate: Free (Let's Encrypt)
  - Monitoring: Free tier (optional)

**Scalability Constraints (Budget-Driven):**
- Current architecture supports up to 500 concurrent users
- Database: SQLite untuk development, harus migrate ke MySQL/PostgreSQL untuk production scale
- File storage: Local storage untuk small scale, migrate ke cloud storage (S3) jika file volume > 50 GB

## 8.5. Performance Constraints

**Response Time Requirements:**
- Page load time: < 3 seconds (average)
- API response time: < 1 second untuk read operations
- File upload: Max 2 MB per file, upload time < 10 seconds
- PDF generation: < 5 seconds per document
- Excel export: < 10 seconds untuk report dengan < 1000 records

**Concurrency Constraints:**
- Max concurrent users: 100 (dengan current server spec)
- Max concurrent file uploads: 20
- Database connection pool: 50 connections

**File Size Limits:**
- CV, Cover Letter: Max 2 MB
- KTM: Max 1 MB
- Surat Kelakuan Baik: Max 2 MB
- Assignment submission: Max 5 MB
- Attendance photo: Max 2 MB
- Total storage per user: ~20 MB average

## 8.6. Security Constraints

**Authentication & Authorization:**
- Password minimum length: 8 characters
- Password must contain: uppercase, lowercase, number
- 2FA mandatory untuk peserta dan pembimbing
- Session expiry: 120 menit inactivity
- Max login attempts: 5 (account locked after)

**File Upload Security:**
- Allowed file types: PDF, DOCX, PPTX, JPG, PNG only
- File validation: MIME type checking
- Virus scanning: Recommended (future enhancement dengan ClamAV)
- Storage path: Outside web root untuk security

**Data Transmission:**
- HTTPS enforced untuk production
- CSRF protection pada semua forms
- SQL injection prevention via Eloquent ORM (parameterized queries)
- XSS prevention via Blade template escaping

## 8.7. Deployment Constraints

**Deployment Environment:**
- Production harus menggunakan HTTPS/SSL
- Environment variables harus disimpan di .env file (tidak di version control)
- Database credentials tidak boleh hardcoded
- Debug mode MUST be OFF di production

**Backup Requirements:**
- Database backup: Daily (automated)
- File storage backup: Weekly
- Backup retention: 30 hari minimum
- Disaster recovery plan: Restore dalam < 4 jam

## 8.8. Maintenance Constraints

**System Maintenance Windows:**
- Scheduled maintenance: Weekend (Sabtu/Minggu)
- Notification: Users diberi notifikasi 48 jam sebelum maintenance
- Maximum downtime: 2 jam per maintenance window

**Update Constraints:**
- Framework updates (Laravel): Quarterly review, apply jika ada security patches
- Library updates: Monthly review
- Security patches: Apply immediately (dalam 24 jam)
- Breaking changes: Require full regression testing

## 8.9. Browser & Device Compatibility Constraints

**Tidak Didukung:**
- Internet Explorer (all versions) - deprecated
- Browsers lebih dari 2 tahun versi outdated
- Android < 8.0
- iOS < 12

**Limited Functionality:**
- Camera check-in: Requires device dengan camera support
- Offline mode: Tidak tersedia (requires internet connection)
- Low bandwidth (<1 Mbps): Degraded performance, file uploads may fail

## 8.10. Business Logic Constraints

**Application Rules:**
- Satu peserta hanya bisa memiliki 1 aplikasi aktif pada satu waktu
- Minimal durasi magang: 1 bulan
- Maksimal durasi magang: 6 bulan
- Peserta dapat re-apply setelah status 'finished' atau 'rejected'

**Assignment Rules:**
- Deadline minimum: 1 hari dari tanggal pembuatan
- Maksimal file size submission: 5 MB
- Late submission allowed dengan penalty flag
- Grade range: 0-100

**Attendance Rules:**
- Check-in hanya bisa dilakukan 1 kali per hari
- Check-in time window: 06:00 - 18:00 WIB
- Late threshold: 08:30 WIB
- Foto wajib untuk setiap check-in

**Certificate Rules:**
- Sertifikat hanya di-issue untuk status 'finished'
- Nomor sertifikat unique dan auto-generated
- Predikat based on performance assessment

---

# 9. Appendix

## 9.1. Glossary / Istilah

| Istilah | Definisi |
|---------|----------|
| **2FA (Two-Factor Authentication)** | Metode autentikasi dua langkah menggunakan password dan TOTP code dari Google Authenticator |
| **Acceptance Letter** | Surat penerimaan magang yang di-generate dalam format PDF setelah aplikasi disetujui |
| **Admin** | User dengan role 'admin', memiliki akses penuh ke seluruh sistem |
| **Assessment Report** | Laporan penilaian kinerja peserta magang yang diupload oleh pembimbing |
| **Assignment** | Tugas yang diberikan pembimbing kepada peserta magang |
| **Attendance** | Catatan kehadiran peserta magang dengan check-in foto |
| **Blade** | Template engine Laravel untuk rendering views |
| **Certificate** | Sertifikat kelulusan yang diterbitkan setelah peserta menyelesaikan program magang |
| **Check-in** | Proses absensi harian dengan mengupload foto selfie |
| **Completion Letter** | Surat keterangan selesai magang |
| **Direktorat** | Level tertinggi dalam hierarki organisasi PT Pos Indonesia |
| **Division** | Entitas administratif yang merepresentasikan admin divisi |
| **Division Admin** | Admin yang bertanggung jawab atas satu divisi tertentu |
| **Division Mentor** | Pembimbing yang di-assign ke divisi tertentu |
| **Divisi** | Unit organisasi dalam struktur PT Pos Indonesia |
| **DomPDF** | Library PHP untuk generate PDF dari HTML |
| **Eloquent ORM** | Object-Relational Mapping library Laravel untuk database operations |
| **Field of Interest** | Bidang minat magang yang dapat dipilih peserta (14 fields available) |
| **Good Behavior Certificate** | Surat keterangan kelakuan baik yang harus diupload peserta saat apply |
| **Internship Application** | Pengajuan/aplikasi magang oleh peserta |
| **KTM** | Kartu Tanda Mahasiswa, identitas mahasiswa yang wajib diupload |
| **Laravel** | PHP framework yang digunakan untuk backend sistem |
| **Logbook** | Jurnal aktivitas harian peserta magang |
| **Maatwebsite Excel** | Library Laravel untuk export data ke Excel format |
| **Mentor** | Sinonim untuk Pembimbing |
| **Middleware** | Layer yang memproses HTTP request sebelum mencapai controller |
| **Migration** | File yang mendefinisikan struktur database (schema) dalam Laravel |
| **Model** | Class yang merepresentasikan tabel database dalam Eloquent ORM |
| **NIK** | Nomor Induk Karyawan (6 digit), digunakan pembimbing untuk login |
| **NIM** | Nomor Induk Mahasiswa, identitas unik mahasiswa |
| **NIPPOS** | Nomor Induk Pegawai PT Pos Indonesia |
| **Pembimbing** | User dengan role 'pembimbing', membimbing dan menilai peserta magang |
| **Peserta** | User dengan role 'peserta', mahasiswa yang mengikuti program magang |
| **Predikat** | Penilaian akhir untuk sertifikat (Sangat Baik, Baik, Cukup) |
| **Queue** | Sistem antrian untuk background jobs (email sending, PDF generation) |
| **Seeder** | File untuk mengisi database dengan data awal/dummy |
| **Session** | Data sementara yang disimpan server untuk tracking user login |
| **Soft Delete** | Penghapusan data dengan menandai deleted_at timestamp (data tidak benar-benar dihapus) |
| **Sub-Direktorat** | Level menengah dalam hierarki organisasi, di bawah Direktorat |
| **Submission** | Pengumpulan tugas oleh peserta |
| **TOTP** | Time-based One-Time Password, algoritma untuk 2FA code |
| **Vite** | Build tool untuk frontend assets (JS, CSS) |

## 9.2. Acronyms

| Acronym | Kepanjangan | Keterangan |
|---------|-------------|------------|
| **2FA** | Two-Factor Authentication | Autentikasi dua faktor |
| **API** | Application Programming Interface | Interface untuk komunikasi antar aplikasi |
| **BPMN** | Business Process Model and Notation | Notasi standar untuk diagram proses bisnis |
| **CRUD** | Create, Read, Update, Delete | Operasi dasar database |
| **CSRF** | Cross-Site Request Forgery | Jenis serangan web security |
| **CSS** | Cascading Style Sheets | Bahasa styling untuk web |
| **CSV** | Comma-Separated Values | Format file data |
| **DFD** | Data Flow Diagram | Diagram aliran data dalam sistem |
| **DOM** | Document Object Model | Representasi struktur HTML |
| **ERD** | Entity Relationship Diagram | Diagram relasi antar entitas database |
| **FK** | Foreign Key | Kunci asing dalam database |
| **HTML** | HyperText Markup Language | Bahasa markup untuk web pages |
| **HTTP** | HyperText Transfer Protocol | Protocol komunikasi web |
| **HTTPS** | HTTP Secure | HTTP dengan enkripsi SSL/TLS |
| **IDE** | Integrated Development Environment | Software untuk development |
| **JS** | JavaScript | Bahasa pemrograman client-side |
| **JSON** | JavaScript Object Notation | Format pertukaran data |
| **JWT** | JSON Web Token | Token untuk autentikasi |
| **MVC** | Model-View-Controller | Architectural pattern |
| **ORM** | Object-Relational Mapping | Teknik mapping object ke database |
| **PDF** | Portable Document Format | Format dokumen universal |
| **PHP** | PHP: Hypertext Preprocessor | Bahasa pemrograman server-side |
| **PK** | Primary Key | Kunci utama dalam database |
| **QR** | Quick Response | Jenis barcode 2D |
| **RBAC** | Role-Based Access Control | Kontrol akses berbasis role |
| **REST** | Representational State Transfer | Architectural style untuk API |
| **SDK** | Software Development Kit | Tools untuk development |
| **SDD** | Software Design Document | Dokumen desain software (dokumen ini) |
| **SMTP** | Simple Mail Transfer Protocol | Protocol untuk email |
| **SQL** | Structured Query Language | Bahasa query database |
| **SRS** | Software Requirements Specification | Dokumen spesifikasi kebutuhan |
| **SSL** | Secure Sockets Layer | Protocol enkripsi (deprecated, diganti TLS) |
| **TLS** | Transport Layer Security | Protocol enkripsi untuk HTTPS |
| **UI** | User Interface | Antarmuka pengguna |
| **UML** | Unified Modeling Language | Bahasa standar untuk diagram sistem |
| **URL** | Uniform Resource Locator | Alamat web resource |
| **UU PDP** | Undang-Undang Perlindungan Data Pribadi | Regulasi data privacy Indonesia |
| **UX** | User Experience | Pengalaman pengguna |
| **VPS** | Virtual Private Server | Server virtual untuk hosting |
| **XSS** | Cross-Site Scripting | Jenis serangan web security |

## 9.3. References & Documentation Links

**Framework & Libraries:**
1. Laravel 12 Documentation: https://laravel.com/docs/12.x
2. Bootstrap 5.3 Documentation: https://getbootstrap.com/docs/5.3/
3. Tailwind CSS 4.0 Documentation: https://tailwindcss.com/docs
4. Alpine.js Documentation: https://alpinejs.dev/
5. Chart.js Documentation: https://www.chartjs.org/docs/
6. DomPDF Documentation: https://github.com/barryvdh/laravel-dompdf
7. Maatwebsite Excel: https://docs.laravel-excel.com/
8. Google2FA: https://github.com/antonioribeiro/google2fa

**Standards & Best Practices:**
9. PSR-12 Coding Standard: https://www.php-fig.org/psr/psr-12/
10. UML 2.5 Specification: https://www.omg.org/spec/UML/
11. OWASP Top 10: https://owasp.org/www-project-top-ten/
12. Material Design Guidelines: https://material.io/design

**Regulatory:**
13. UU PDP (Indonesia): https://www.dpr.go.id/ (Undang-Undang No. 27 Tahun 2022)

**Deployment & DevOps:**
14. Docker Documentation: https://docs.docker.com/
15. Nginx Documentation: https://nginx.org/en/docs/
16. Let's Encrypt: https://letsencrypt.org/docs/

## 9.4. Database Schema Export

Untuk detail lengkap database schema, lihat migration files di:
- `database/migrations/` (36+ migration files)

Contoh key migrations:
- `create_users_table.php`
- `create_internship_applications_table.php`
- `create_assignments_table.php`
- `create_attendances_table.php`
- `create_logbooks_table.php`
- `create_certificates_table.php`
- `create_direktorats_table.php`
- `create_sub_direktorats_table.php`
- `create_divisis_table.php`
- `create_field_of_interests_table.php`

## 9.5. API Endpoints (Internal Use)

Sistem ini menggunakan traditional web routes (bukan RESTful API). Untuk detail routes, lihat:
- `routes/web.php` (185 lines, semua route definitions)

Key route groups:
- `/` - Public routes
- `/login`, `/register` - Authentication routes
- `/dashboard/*` - Peserta dashboard routes
- `/mentor/*` - Pembimbing routes
- `/admin/*` - Admin routes

## 9.6. Sample Data & Seeders

Untuk populate database dengan sample data, jalankan seeders:
```bash
php artisan db:seed
```

Available seeders:
- `DirektoratSeeder.php` - Organizational structure
- `DivisiSeeder.php` - Divisions
- `FieldOfInterestSeeder.php` - 14 predefined fields
- `MentorUserSeeder.php` - Sample mentors
- `UserSeeder.php` - Sample users (admin, peserta)

## 9.7. Environment Configuration

Key environment variables (`.env` file):

```env
APP_NAME="Sistem Magang PT Pos"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://magang.posindonesia.co.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=magang_pos
DB_USERNAME=root
DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@posindonesia.co.id
MAIL_PASSWORD=secret
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@posindonesia.co.id
MAIL_FROM_NAME="${APP_NAME}"

SESSION_LIFETIME=120
```

## 9.8. Testing Guidelines

**Unit Testing:**
- Framework: PHPUnit
- Location: `tests/Unit/`
- Run: `php artisan test`

**Feature Testing:**
- Location: `tests/Feature/`
- Test authentication, CRUD operations, file uploads

**Manual Testing Checklist:**
1. Registration & Login (2FA flow)
2. Application submission (all document uploads)
3. Admin review & approval
4. Mentor acceptance & letter generation
5. Assignment creation & submission
6. Attendance check-in with photo
7. Logbook entries
8. Certificate generation
9. Report exports (PDF/Excel)
10. Email notifications

## 9.9. Deployment Checklist

**Pre-Deployment:**
- [ ] Run all tests (`php artisan test`)
- [ ] Code style check (`./vendor/bin/pint`)
- [ ] Update `.env` dengan production values
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Configure mail settings
- [ ] Setup SSL certificate
- [ ] Database migration ready

**Deployment Steps:**
1. Clone repository ke production server
2. `composer install --optimize-autoloader --no-dev`
3. `npm install && npm run build`
4. `cp .env.example .env` (edit dengan production values)
5. `php artisan key:generate`
6. `php artisan migrate --force`
7. `php artisan db:seed` (jika perlu seed initial data)
8. `php artisan config:cache`
9. `php artisan route:cache`
10. `php artisan view:cache`
11. Set proper file permissions
12. Configure web server (Nginx/Apache)
13. Setup queue worker (`php artisan queue:work`)
14. Setup cron job untuk scheduled tasks

**Post-Deployment:**
- [ ] Test login functionality
- [ ] Test file upload/download
- [ ] Test email sending
- [ ] Test PDF generation
- [ ] Monitor logs (`storage/logs/laravel.log`)
- [ ] Setup monitoring (optional: New Relic, Datadog)

## 9.10. Troubleshooting Guide

**Common Issues:**

1. **File Upload Fails**
   - Check `upload_max_filesize` dan `post_max_size` di php.ini
   - Check storage folder permissions (755)
   - Check disk space

2. **PDF Generation Fails**
   - Check font files di `storage/fonts/`
   - Check memory limit di php.ini (minimum 256MB)
   - Check DomPDF config

3. **Email Not Sending**
   - Check SMTP credentials di `.env`
   - Check firewall blocking port 587/465
   - Check queue worker running (`php artisan queue:work`)

4. **2FA QR Code Not Showing**
   - Check QR Code library installed (`simplesoftwareio/simple-qrcode`)
   - Check GD library enabled di PHP

5. **Session Expired Too Fast**
   - Check `SESSION_LIFETIME` di `.env`
   - Check session driver (database recommended)

## 9.11. Contact & Support

**Development Team:**
- Project Manager: [Nama] - [Email]
- Lead Developer: [Nama] - [Email]
- Frontend Developer: [Nama] - [Email]
- Backend Developer: [Nama] - [Email]

**PT Pos Indonesia Stakeholders:**
- IT Department Contact: [Nama] - [Email]
- HR Department Contact: [Nama] - [Email]

**Documentation Maintained By:**
- [Nama Tim]
- Last Updated: 21 Desember 2025

---

## END OF SOFTWARE DESIGN DOCUMENT

**Document Version: 1.0**
**Date: 21 Desember 2025**

**Approval Signatures:**

Project Manager: _________________________ Date: __________

Lead Developer: __________________________ Date: __________

Supervisor: ______________________________ Date: __________

---

**© 2025 PT Pos Indonesia - Sistem Manajemen Penerimaan Magang**

