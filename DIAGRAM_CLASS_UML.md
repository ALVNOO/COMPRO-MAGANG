# Class Diagram UML
## Sistem Penerimaan Magang - PT Telkom Indonesia

Diagram ini menunjukkan struktur class dengan atribut, method, dan relasi (inheritance, association, aggregation, composition).

---

## Class Diagram UML - Main Models

```mermaid
classDiagram
    class Model {
        <<abstract>>
        +timestamps: timestamp
        +fillable: array
        +hidden: array
        +casts: array
        +find(id)
        +create(data)
        +update(data)
        +delete()
        +save()
    }
    
    class User {
        -id: bigint
        -username: string
        -email: string
        -password: string
        -name: string
        -nim: string
        -university: string
        -major: string
        -phone: string
        -ktp_number: string
        -ktm: string
        -role: enum
        -divisi_id: bigint
        -two_factor_secret: string
        -two_factor_verified_at: timestamp
        -tour_completed: boolean
        -created_at: timestamp
        -updated_at: timestamp
        +internshipApplications()
        +assignments()
        +divisi()
        +certificates()
        +attendances()
        +logbooks()
        +requiresTwoFactor()
        +hasTwoFactorEnabled()
        +generateTwoFactorSecret()
        +verifyTwoFactorCode(code)
        +markTwoFactorAsVerified()
    }
    
    class InternshipApplication {
        -id: bigint
        -user_id: bigint
        -divisi_id: bigint
        -division_admin_id: bigint
        -division_mentor_id: bigint
        -field_of_interest_id: bigint
        -status: enum
        -cover_letter_path: string
        -ktm_path: string
        -surat_permohonan_path: string
        -cv_path: string
        -good_behavior_path: string
        -acceptance_letter_path: string
        -assessment_report_path: string
        -completion_letter_path: string
        -start_date: date
        -end_date: date
        -notes: text
        -acceptance_letter_downloaded_at: timestamp
        -created_at: timestamp
        -updated_at: timestamp
        +user()
        +divisi()
        +divisionAdmin()
        +divisionMentor()
        +fieldOfInterest()
        +certificate()
    }
    
    class Assignment {
        -id: bigint
        -user_id: bigint
        -title: string
        -assignment_type: enum
        -description: text
        -deadline: date
        -presentation_date: date
        -file_path: string
        -submission_file_path: string
        -grade: integer
        -is_revision: boolean
        -feedback: text
        -submitted_at: timestamp
        -created_at: timestamp
        -updated_at: timestamp
        +user()
        +submissions()
    }
    
    class AssignmentSubmission {
        -id: bigint
        -assignment_id: bigint
        -user_id: bigint
        -file_path: string
        -submitted_at: timestamp
        -keterangan: string
        -created_at: timestamp
        -updated_at: timestamp
        +assignment()
        +user()
    }
    
    class Attendance {
        -id: bigint
        -user_id: bigint
        -date: date
        -status: enum
        -check_in_time: time
        -photo_path: string
        -absence_reason: text
        -absence_proof_path: string
        -created_at: timestamp
        -updated_at: timestamp
        +user()
    }
    
    class Logbook {
        -id: bigint
        -user_id: bigint
        -date: date
        -content: text
        -created_at: timestamp
        -updated_at: timestamp
        +user()
    }
    
    class Certificate {
        -id: bigint
        -user_id: bigint
        -internship_application_id: bigint
        -certificate_path: string
        -nomor_sertifikat: string
        -predikat: string
        -issued_at: timestamp
        -created_at: timestamp
        -updated_at: timestamp
        +user()
        +internshipApplication()
    }
    
    class Divisi {
        -id: bigint
        -name: string
        -sub_direktorat_id: bigint
        -vp: string
        -nippos: string
        -created_at: timestamp
        -updated_at: timestamp
        +subDirektorat()
        +internshipApplications()
        +mentors()
        +pembimbing()
    }
    
    class DivisionMentor {
        -id: bigint
        -division_id: bigint
        -mentor_name: string
        -nik_number: string
        -created_at: timestamp
        -updated_at: timestamp
        +division()
        +internshipApplications()
    }
    
    class DivisiAdmin {
        -id: bigint
        -division_name: string
        -mentor_name: string
        -nik_number: string
        -is_active: boolean
        -sort_order: integer
        -created_at: timestamp
        -updated_at: timestamp
        -deleted_at: timestamp
        +internshipApplications()
        +mentors()
    }
    
    class FieldOfInterest {
        -id: bigint
        -name: string
        -description: text
        -icon: string
        -color: string
        -is_active: boolean
        -sort_order: integer
        -division_count: integer
        -position_count: integer
        -duration_months: integer
        -created_at: timestamp
        -updated_at: timestamp
        +divisions()
        +scopeActive(query)
        +scopeOrdered(query)
    }
    
    class Direktorat {
        -id: bigint
        -name: string
        -created_at: timestamp
        -updated_at: timestamp
        +subDirektorats()
    }
    
    class SubDirektorat {
        -id: bigint
        -name: string
        -direktorat_id: bigint
        -created_at: timestamp
        -updated_at: timestamp
        +direktorat()
        +divisis()
    }
    
    class Rule {
        -id: bigint
        -content: text
        -created_at: timestamp
        -updated_at: timestamp
    }
    
    %% Inheritance
    Model <|-- User
    Model <|-- InternshipApplication
    Model <|-- Assignment
    Model <|-- AssignmentSubmission
    Model <|-- Attendance
    Model <|-- Logbook
    Model <|-- Certificate
    Model <|-- Divisi
    Model <|-- DivisionMentor
    Model <|-- DivisiAdmin
    Model <|-- FieldOfInterest
    Model <|-- Direktorat
    Model <|-- SubDirektorat
    Model <|-- Rule
    
    %% Association (Many-to-One / One-to-Many)
    User "1" --> "*" InternshipApplication : has many
    User "1" --> "*" Assignment : has many
    User "1" --> "*" AssignmentSubmission : has many
    User "1" --> "*" Attendance : has many
    User "1" --> "*" Logbook : has many
    User "1" --> "*" Certificate : has many
    User "*" --> "1" Divisi : belongs to
    
    InternshipApplication "*" --> "1" User : belongs to
    InternshipApplication "*" --> "1" Divisi : belongs to
    InternshipApplication "*" --> "1" DivisiAdmin : belongs to
    InternshipApplication "*" --> "1" DivisionMentor : belongs to
    InternshipApplication "*" --> "1" FieldOfInterest : belongs to
    InternshipApplication "1" --> "*" Certificate : has many
    
    Assignment "*" --> "1" User : belongs to
    Assignment "1" --> "*" AssignmentSubmission : has many
    
    AssignmentSubmission "*" --> "1" Assignment : belongs to
    AssignmentSubmission "*" --> "1" User : belongs to
    
    Attendance "*" --> "1" User : belongs to
    Logbook "*" --> "1" User : belongs to
    
    Certificate "*" --> "1" User : belongs to
    Certificate "*" --> "1" InternshipApplication : belongs to
    
    Divisi "*" --> "1" SubDirektorat : belongs to
    Divisi "1" --> "*" InternshipApplication : has many
    Divisi "1" --> "*" User : has many (mentors)
    
    DivisionMentor "*" --> "1" DivisiAdmin : belongs to
    DivisionMentor "1" --> "*" InternshipApplication : has many
    
    DivisiAdmin "1" --> "*" InternshipApplication : has many
    DivisiAdmin "1" --> "*" DivisionMentor : has many
    
    SubDirektorat "*" --> "1" Direktorat : belongs to
    SubDirektorat "1" --> "*" Divisi : has many
    
    Direktorat "1" --> "*" SubDirektorat : has many
    
    FieldOfInterest "1" --> "*" InternshipApplication : has many
```

---

## Class Diagram UML - Controllers

```mermaid
classDiagram
    class Controller {
        <<abstract>>
        +middleware()
        +validate()
        +authorize()
    }
    
    class AuthController {
        +showLogin()
        +login(request)
        +showRegister()
        +register(request)
        +logout(request)
        +setup2fa()
        +enable2fa(request)
        +show2faVerify()
        +verify2fa(request)
        +showChangePasswordForm()
        +changePassword(request)
        -getDashboardUrl(user)
        -redirectToDashboard(user)
    }
    
    class DashboardController {
        +index()
        +preAcceptance()
        +updateProfile(request)
        +uploadDocuments(request)
        +updateDates(request)
        +completeApplication(request)
        +status()
        +acknowledgePersyaratanTambahan(request)
        +submitAdditionalDocuments(request)
        +assignments()
        +submitAssignment(request, id)
        +certificates()
        +downloadCertificate(id)
        +program()
        +reapply()
        +submitReapply(request)
        +profile()
        +completeTour(request)
        +downloadAcceptanceLetterFlag(request)
        +downloadAcceptanceLetter()
    }
    
    class MentorDashboardController {
        +index()
        +pengajuan()
        +responPengajuan(request, id)
        +showAcceptanceLetterForm(id)
        +previewAcceptanceLetter(request, id)
        +sendAcceptanceLetter(request, id)
        +penugasan()
        +tambahPenugasan(request)
        +editPenugasan(assignment)
        +updatePenugasan(request, assignment)
        +deletePenugasan(assignment)
        +beriNilaiPenugasan(request, assignment)
        +setRevisiPenugasan(request, assignment)
        +sertifikat()
        +uploadSertifikat(request, user)
        +showCertificateForm(user)
        +previewCertificate(request, user)
        +sendCertificate(request, user)
        +profil()
        +laporanPenilaian()
        +getLaporanPenilaianData(request)
        +uploadLaporanPenilaian(request, applicationId)
        -getAcceptanceLetterData(request, application)
        -getCertificateData(request, user, application)
    }
    
    class AdminController {
        +dashboard()
        +applications()
        +approveApplication(request, id)
        +rejectApplication(request, id)
        +participants()
        +uploadAcceptanceLetter(request, applicationId)
        +downloadAssessmentReport(applicationId)
        +uploadCompletionLetter(request, applicationId)
        +uploadCertificate(request, userId)
        +divisions()
        +indexDivisions()
        +createDivision()
        +storeDivision(request)
        +editDivision(id)
        +updateDivision(request, id)
        +toggleDivision(request, id)
        +destroyDivision(id)
        +mentors()
        +mentorDetail(id)
        +resetMentorPassword(request, id)
        +editRules()
        +updateRules(request)
        +fields()
        +createField()
        +storeField(request)
        +editField(field)
        +updateField(request, field)
        +toggleFieldStatus(request, field)
        +deleteField(field)
        +report()
        +getReportData(request)
        +exportReportPdf(request)
        +exportReportExcel(request)
        +direktoratStore(request)
        +direktoratUpdate(request, id)
        +direktoratDelete(id)
    }
    
    class AttendanceController {
        +index()
        +checkIn(request)
        +absent(request)
        +mentorIndex()
        +adminIndex()
    }
    
    class LogbookController {
        +index()
        +store(request)
        +update(request, id)
        +destroy(id)
        +mentorIndex()
        +adminIndex()
        +getMentorsByDivision(request)
    }
    
    class HomeController {
        +index()
        +about()
        +program()
    }
    
    class InternshipController {
        +index()
        +apply(divisi)
        +submitApply(request, divisi)
    }
    
    %% Inheritance
    Controller <|-- AuthController
    Controller <|-- DashboardController
    Controller <|-- MentorDashboardController
    Controller <|-- AdminController
    Controller <|-- AttendanceController
    Controller <|-- LogbookController
    Controller <|-- HomeController
    Controller <|-- InternshipController
    
    %% Dependencies (uses)
    AuthController ..> User : uses
    DashboardController ..> InternshipApplication : uses
    DashboardController ..> Assignment : uses
    DashboardController ..> Certificate : uses
    MentorDashboardController ..> InternshipApplication : uses
    MentorDashboardController ..> Assignment : uses
    MentorDashboardController ..> Certificate : uses
    AdminController ..> InternshipApplication : uses
    AdminController ..> User : uses
    AdminController ..> DivisiAdmin : uses
    AttendanceController ..> Attendance : uses
    LogbookController ..> Logbook : uses
    InternshipController ..> InternshipApplication : uses
```

---

## Class Diagram - Relationships Detail

### Composition Relationship (Strong Ownership)
- **User** ◄◆ **InternshipApplication**: Jika User dihapus, InternshipApplication juga dihapus (CASCADE)
- **User** ◄◆ **Assignment**: Jika User dihapus, Assignment juga dihapus
- **User** ◄◆ **Certificate**: Jika User dihapus, Certificate juga dihapus
- **Assignment** ◄◆ **AssignmentSubmission**: Jika Assignment dihapus, AssignmentSubmission juga dihapus

### Aggregation Relationship (Weak Ownership)
- **Divisi** ◄◇ **User** (mentors): User bisa exist tanpa Divisi
- **FieldOfInterest** ◄◇ **InternshipApplication**: InternshipApplication bisa exist tanpa FieldOfInterest

### Association Relationship (Reference)
- **InternshipApplication** ── **DivisionMentor**: Reference relationship
- **Direktorat** ── **SubDirektorat**: Hierarchical relationship
- **SubDirektorat** ── **Divisi**: Hierarchical relationship

---

## Class Diagram dengan Relasi Lengkap

```mermaid
classDiagram
    class User {
        +id
        +username
        +email
        +password
        +role
        +internshipApplications()* InternshipApplication
        +assignments()* Assignment
        +certificates()* Certificate
        +attendances()* Attendance
        +logbooks()* Logbook
    }
    
    class InternshipApplication {
        +id
        +user_id
        +status
        +user() User
        +divisionMentor() DivisionMentor
        +certificate() Certificate
    }
    
    class Assignment {
        +id
        +user_id
        +title
        +grade
        +user() User
        +submissions()* AssignmentSubmission
    }
    
    class Certificate {
        +id
        +user_id
        +certificate_path
        +user() User
        +internshipApplication() InternshipApplication
    }
    
    class DivisionMentor {
        +id
        +division_id
        +mentor_name
        +internshipApplications()* InternshipApplication
    }
    
    %% Composition (Strong - filled diamond)
    User "1" ◄◆ "*" InternshipApplication : creates
    User "1" ◄◆ "*" Assignment : receives
    User "1" ◄◆ "*" Certificate : receives
    Assignment "1" ◄◆ "*" AssignmentSubmission : contains
    
    %% Aggregation (Weak - empty diamond)
    DivisionMentor "1" ◄◇ "*" InternshipApplication : supervises
    
    %% Association (Simple line)
    User "1" ── "*" Certificate : owns
    InternshipApplication "1" ── "*" Certificate : generates
```

---

**Keterangan Relasi:**

1. **Inheritance (◄──)**: Semua Model mewarisi dari Eloquent Model
2. **Composition (◄◆)**: Strong ownership, jika parent dihapus, child juga dihapus
3. **Aggregation (◄◇)**: Weak ownership, child bisa exist tanpa parent
4. **Association (──)**: Simple reference relationship
5. **Dependency (..>)**: Controller menggunakan Model

---

**Dibuat**: 2024  
**Versi**: 1.0  
**Sistem**: Penerimaan Magang PT Telkom Indonesia

