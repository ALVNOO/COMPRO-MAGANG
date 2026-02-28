# ERD Draw.io Reference Guide
## Sistem Penerimaan Magang - PT Telkom Indonesia

File ini berisi referensi lengkap untuk membuat ERD di draw.io.

---

## Cara Cepat: Import Mermaid ke Draw.io

### Step 1: Convert Mermaid ke Gambar
1. Buka https://mermaid.live/
2. Copy kode Mermaid dari file `ERD_PENERIMAAN_MAGANG.md` (bagian Diagram ERD)
3. Paste ke editor
4. Download sebagai PNG atau SVG

### Step 2: Import ke Draw.io
1. Buka https://app.diagrams.net/
2. File → Import from → Device
3. Pilih gambar yang sudah di-download
4. Gunakan sebagai background reference
5. Buat entity dan relasi sesuai gambar

---

## Format Entity Lengkap untuk Draw.io

Gunakan format ini saat membuat entity di draw.io. Buat shape **Rectangle** atau **Table** dan isi dengan struktur berikut:

### 1. USERS
```
┌─────────────────────┐
│      USERS          │
├─────────────────────┤
│ id (PK)             │
│ username (UK)       │
│ email (UK)          │
│ name                │
│ password            │
│ role (enum)         │
│ nim                 │
│ university          │
│ major               │
│ phone               │
│ ktp_number          │
│ ktm                 │
│ divisi_id (FK)      │
│ two_factor_secret   │
│ two_factor_verified │
│ tour_completed      │
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

### 2. INTERNSHIP_APPLICATIONS
```
┌──────────────────────────────┐
│  INTERNSHIP_APPLICATIONS     │
├──────────────────────────────┤
│ id (PK)                      │
│ user_id (FK)                 │
│ divisi_id (FK, nullable)     │
│ division_admin_id (FK)       │
│ division_mentor_id (FK)      │
│ field_of_interest_id (FK)    │
│ status (enum)                │
│ cover_letter_path            │
│ ktm_path                     │
│ surat_permohonan_path        │
│ cv_path                      │
│ good_behavior_path           │
│ acceptance_letter_path       │
│ assessment_report_path       │
│ completion_letter_path       │
│ start_date                   │
│ end_date                     │
│ notes                        │
│ acceptance_letter_downloaded │
│ created_at                   │
│ updated_at                   │
└──────────────────────────────┘
```

### 3. ASSIGNMENTS
```
┌──────────────────────┐
│    ASSIGNMENTS       │
├──────────────────────┤
│ id (PK)              │
│ user_id (FK)         │
│ title                │
│ assignment_type      │
│ description          │
│ deadline             │
│ presentation_date    │
│ file_path            │
│ submission_file_path │
│ grade                │
│ is_revision          │
│ feedback             │
│ submitted_at         │
│ created_at           │
│ updated_at           │
└──────────────────────┘
```

### 4. ASSIGNMENT_SUBMISSIONS
```
┌──────────────────────────┐
│ ASSIGNMENT_SUBMISSIONS   │
├──────────────────────────┤
│ id (PK)                  │
│ assignment_id (FK)       │
│ user_id (FK)             │
│ file_path                │
│ submitted_at             │
│ keterangan               │
│ created_at               │
│ updated_at               │
└──────────────────────────┘
```

### 5. ATTENDANCES
```
┌─────────────────────┐
│    ATTENDANCES      │
├─────────────────────┤
│ id (PK)             │
│ user_id (FK)        │
│ date                │
│ status (enum)       │
│ check_in_time       │
│ photo_path          │
│ absence_reason      │
│ absence_proof_path  │
│ created_at          │
│ updated_at          │
│ UNIQUE(user_id,date)│
└─────────────────────┘
```

### 6. LOGBOOKS
```
┌──────────────┐
│   LOGBOOKS   │
├──────────────┤
│ id (PK)      │
│ user_id (FK) │
│ date         │
│ content      │
│ created_at   │
│ updated_at   │
│ UNIQUE(uid,  │
│         date)│
└──────────────┘
```

### 7. CERTIFICATES
```
┌──────────────────────────┐
│     CERTIFICATES         │
├──────────────────────────┤
│ id (PK)                  │
│ user_id (FK)             │
│ internship_application_id│
│ certificate_path         │
│ nomor_sertifikat         │
│ predikat                 │
│ issued_at                │
│ created_at               │
│ updated_at               │
└──────────────────────────┘
```

### 8. DIVISIONS
```
┌─────────────────┐
│   DIVISIONS     │
├─────────────────┤
│ id (PK)         │
│ division_name   │
│ mentor_name     │
│ nik_number (UK) │
│ is_active       │
│ sort_order      │
│ created_at      │
│ updated_at      │
│ deleted_at      │
└─────────────────┘
```

### 9. DIVISION_MENTORS
```
┌──────────────────────┐
│  DIVISION_MENTORS    │
├──────────────────────┤
│ id (PK)              │
│ division_id (FK)     │
│ mentor_name          │
│ nik_number           │
│ created_at           │
│ updated_at           │
└──────────────────────┘
```

### 10. DIVISIS (Struktur Lama)
```
┌──────────────────┐
│     DIVISIS      │
├──────────────────┤
│ id (PK)          │
│ name             │
│ sub_direktorat_id│
│ vp               │
│ nippos           │
│ created_at       │
│ updated_at       │
└──────────────────┘
```

### 11. SUB_DIREKTORATS
```
┌──────────────────┐
│ SUB_DIREKTORATS  │
├──────────────────┤
│ id (PK)          │
│ name             │
│ direktorat_id    │
│ created_at       │
│ updated_at       │
└──────────────────┘
```

### 12. DIREKTORATS
```
┌──────────────┐
│ DIREKTORATS  │
├──────────────┤
│ id (PK)      │
│ name         │
│ created_at   │
│ updated_at   │
└──────────────┘
```

### 13. FIELD_OF_INTERESTS
```
┌─────────────────────┐
│ FIELD_OF_INTERESTS  │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ description         │
│ icon                │
│ color               │
│ is_active           │
│ sort_order          │
│ division_count      │
│ position_count      │
│ duration_months     │
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

### 14. RULES
```
┌─────────┐
│  RULES  │
├─────────┤
│ id (PK) │
│ content │
│ created │
│ updated │
└─────────┘
```

---

## Mapping Relasi untuk Draw.io

Gunakan connector dengan label cardinality berikut:

### Relasi One-to-Many (1:N)
```
[Entity 1] ──────1───────N───────> [Entity 2]
```

### Relasi Many-to-One (N:1)
```
[Entity 1] ──────N───────1───────> [Entity 2]
```

### Daftar Relasi Lengkap:

1. **USERS** ──(1)──>──(N)──> **INTERNSHIP_APPLICATIONS**
   - Label: "mengajukan"

2. **USERS** ──(1)──>──(N)──> **ASSIGNMENTS**
   - Label: "menerima"

3. **USERS** ──(1)──>──(N)──> **ASSIGNMENT_SUBMISSIONS**
   - Label: "mengumpulkan"

4. **USERS** ──(1)──>──(N)──> **ATTENDANCES**
   - Label: "melakukan"

5. **USERS** ──(1)──>──(N)──> **LOGBOOKS**
   - Label: "menulis"

6. **USERS** ──(1)──>──(N)──> **CERTIFICATES**
   - Label: "menerima"

7. **USERS** ──(N)──>──(1)──> **DIVISIS**
   - Label: "terhubung_dengan"

8. **DIVISIS** ──(N)──>──(1)──> **SUB_DIREKTORATS**
   - Label: "bagian_dari"

9. **SUB_DIREKTORATS** ──(N)──>──(1)──> **DIREKTORATS**
   - Label: "bagian_dari"

10. **DIVISIONS** ──(1)──>──(N)──> **DIVISION_MENTORS**
    - Label: "memiliki"

11. **DIVISION_MENTORS** ──(1)──>──(N)──> **INTERNSHIP_APPLICATIONS**
    - Label: "membimbing"

12. **DIVISIONS** ──(1)──>──(N)──> **INTERNSHIP_APPLICATIONS**
    - Label: "menampung"

13. **FIELD_OF_INTERESTS** ──(1)──>──(N)──> **INTERNSHIP_APPLICATIONS**
    - Label: "dipilih"

14. **INTERNSHIP_APPLICATIONS** ──(1)──>──(N)──> **CERTIFICATES**
    - Label: "menghasilkan"

15. **ASSIGNMENTS** ──(1)──>──(N)──> **ASSIGNMENT_SUBMISSIONS**
    - Label: "memiliki"

---

## Recommended Layout untuk Draw.io

Gunakan layout grid berikut untuk penempatan entity:

```
┌─────────────────────────────────────────────────────────┐
│                    TOP ROW                              │
│  [DIREKTORATS] → [SUB_DIREKTORATS] → [DIVISIS]         │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   MIDDLE ROW                            │
│  [DIVISIONS] → [DIVISION_MENTORS]                       │
│  [FIELD_OF_INTERESTS]                                   │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   CENTER ROW (MAIN)                     │
│                                                          │
│  [USERS] → [INTERNSHIP_APPLICATIONS] → [CERTIFICATES]  │
│     ↓              ↓                                     │
│     └──────────────┘                                     │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   BOTTOM ROW                            │
│  [ASSIGNMENTS] → [ASSIGNMENT_SUBMISSIONS]               │
│  [ATTENDANCES]                                          │
│  [LOGBOOKS]                                             │
│  [RULES] (standalone, bisa di pojok)                    │
└─────────────────────────────────────────────────────────┘
```

### Tips Layout:
1. Letakkan **USERS** di tengah kiri (core entity)
2. Letakkan **INTERNSHIP_APPLICATIONS** di tengah (hub utama)
3. Hierarki organisasi (DIREKTORATS → SUB_DIREKTORATS → DIVISIS) di atas
4. Struktur baru (DIVISIONS → DIVISION_MENTORS) di tengah atas
5. Transaction entities (ASSIGNMENTS, ATTENDANCES, LOGBOOKS) di bawah
6. RULES bisa diletakkan terpisah di pojok

---

## Color Scheme (Opsional)

Gunakan warna berikut untuk grouping visual:

| Entity Type | Color Code | Contoh Entity |
|-------------|------------|---------------|
| Core Entities | #dae8fc (Light Blue) | USERS, INTERNSHIP_APPLICATIONS |
| Transaction Entities | #d5e8d4 (Light Green) | ASSIGNMENTS, ATTENDANCES, LOGBOOKS |
| Configuration Entities | #fff2cc (Light Yellow) | DIVISIONS, FIELD_OF_INTERESTS |
| Hierarchy Entities | #ffe6cc (Light Orange) | DIREKTORATS, SUB_DIREKTORATS, DIVISIS |
| Standalone | #f8cecc (Light Red) | RULES |

### Cara Set Color di Draw.io:
1. Pilih shape/entity
2. Klik ikon "Fill" di toolbar
3. Pilih warna sesuai kategori

---

## Export dari Draw.io

Setelah selesai membuat diagram:

1. **Save sebagai Draw.io Format:**
   - File → Save As → .drawio format
   - Untuk edit di kemudian hari

2. **Export sebagai Gambar:**
   - File → Export as → PNG
   - Pilih resolution tinggi (300 DPI) untuk kualitas terbaik
   - Atau export sebagai SVG untuk editing lebih lanjut

3. **Export sebagai PDF:**
   - File → Export as → PDF
   - Cocok untuk dokumentasi

---

## Quick Reference Card

Simpan card ini saat membuat diagram:

### Cardinality Symbols:
- `1` = One
- `N` atau `*` = Many (Multiple)
- `0..1` = Zero or One (Optional)
- `1..N` = One or Many

### Foreign Key Notation:
- `(FK)` = Foreign Key
- `(PK)` = Primary Key
- `(UK)` = Unique Key

### Common Attributes:
- `created_at` = Timestamp creation (ada di semua tabel)
- `updated_at` = Timestamp update (ada di semua tabel)
- `nullable` = Bisa kosong/null
- `enum` = Hanya nilai tertentu yang valid

---

**Happy Diagramming!** 🎨
















