# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 internship management system ("Magang" means internship in Indonesian) that handles the complete internship lifecycle: applications, acceptance, assignments, attendance tracking, logbook entries, and certificate generation.

**Tech Stack:**
- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Vite with multiple entry points, React components, TailwindCSS 4.0, Bootstrap 5, Alpine.js, Chart.js
- Authentication: Custom auth with mandatory Google 2FA for all users
- PDF Generation: barryvdh/laravel-dompdf
- Excel Exports: maatwebsite/excel
- QR Codes: simplesoftwareio/simple-qrcode, bacon/bacon-qr-code

## Development Commands

**Start development environment:**
```bash
composer dev
```
This runs concurrently: server, queue worker, logs (pail), and vite dev server.

**Build assets:**
```bash
npm run build
```

**Run tests:**
```bash
composer test
# or directly:
php artisan test
```

**Run a specific test:**
```bash
php artisan test --filter TestName
```

**Code formatting (Laravel Pint):**
```bash
vendor/bin/pint
```

**Database migrations:**
```bash
php artisan migrate
php artisan migrate:fresh --seed  # Fresh start with seeders
```

## Architecture & Key Concepts

### Role-Based System

The application has three primary user roles (stored in `users.role`):

1. **Admin** - Full system access, manages applications, divisions, mentors, reports
2. **Pembimbing (Mentor)** - Supervises interns in their division, creates assignments, issues certificates
3. **Peserta (Participant/Intern)** - Applies for internships, submits assignments, tracks attendance

### Authentication & Security

- **Two-Factor Authentication (2FA)**: Mandatory for all users using Google Authenticator (pragmarx/google2fa)
- Rate limiting on 2FA verification (5 attempts per 5-minute window)
- Replay attack prevention for 2FA codes
- User model includes methods: `requiresTwoFactor()`, `hasTwoFactorEnabled()`, `verifyTwoFactorCode()`

### Internship Application Workflow

Applications progress through statuses: `pending` → `accepted` → `finished` (or `rejected`)

**Key models:**
- `InternshipApplication` - Main application record with relationships to User, Division, Mentor, Admin
- `User` with `HasActiveApplication` trait provides: `activeApplications()`, `getActiveApplicationAttribute()`, `canApplyForInternship()`

**Pre-acceptance phase:** After initial acceptance, participants must complete their profile, upload documents (KTP, KTM, CV, motivation letter), and set internship dates before final confirmation.

### Division Structure (Migration in Progress)

**Legacy structure (being phased out):**
- Direktorat → SubDirektorat → Divisi (3-level hierarchy)

**New structure:**
- `Division` (flat structure with DivisionAdmin and DivisionMentor pivot tables)
- Migration files: `2026_01_31_133527_consolidate_divisions_structure.php`
- Admin controllers have both new (`Admin\DivisionController`) and legacy (`Admin\LegacyDivisionController`) implementations

When working with divisions, prefer the new `Division` model over the legacy `Divisi`/`Direktorat`/`SubDirektorat` structure.

### Controller Organization

**Refactored Admin Controllers (use these):**
Located in `app/Http/Controllers/Admin/`:
- `DashboardController` - Admin dashboard
- `ApplicationController` - Manage internship applications
- `ParticipantController` - Manage accepted participants
- `DivisionController` - Division management (new structure)
- `MentorController` - Mentor management
- `ReportController` - Analytics and exports
- `FieldOfInterestController` - Manage fields of interest
- `RuleController` - System rules/policies
- `LegacyDivisionController` - Legacy division structure (deprecated)

**Other Controllers:**
- `AuthController` - Login, registration, 2FA setup/verification
- `DashboardController` - Participant dashboard and actions
- `MentorDashboardController` - Mentor-specific dashboard and actions
- `AttendanceController` - Check-in/out, absence tracking (role-specific methods: `index`, `mentorIndex`, `adminIndex`)
- `LogbookController` - Daily activity logs (role-specific methods)
- `InternshipController` - Public application submission
- `NotificationController` - In-app notification system

### Frontend Structure

**Vite Entry Points** (defined in `vite.config.js`):
- `resources/css/design-system.css` - Design tokens and variables
- `resources/css/ux-utilities.css` - Animations and UX helpers
- `resources/css/app.css` - Main authenticated app styles
- `resources/js/app.js` - Main app JavaScript
- `resources/css/public-app.css` - Public pages (home, about)
- `resources/js/public-app.js` - Public pages JavaScript
- `resources/css/mentor-dashboard.css` - Mentor-specific styles
- `resources/js/mentor-dashboard.js` - Mentor dashboard JS
- `resources/css/admin-dashboard.css` - Admin-specific styles
- `resources/js/admin-dashboard.js` - Admin dashboard JS
- `resources/css/peserta-dashboard.css` - Participant-specific styles
- `resources/js/peserta-dashboard.js` - Participant dashboard JS

**Views Structure:**
- `resources/views/admin/` - Admin panel views
- `resources/views/mentor/` - Mentor dashboard views
- `resources/views/dashboard/` - Participant dashboard views
- `resources/views/auth/` - Login, registration, 2FA
- `resources/views/attendance/` - Attendance tracking
- `resources/views/logbook/` - Logbook entries
- `resources/views/components/` - Reusable Blade components
- `resources/views/layouts/` - Layout templates

### Key Features & Modules

**Assignments:**
- Mentors create assignments for their participants
- Types: regular assignments and final presentations
- Submissions tracked via `AssignmentSubmission` model
- Statuses: pending, submitted, graded, revision_required

**Certificates:**
- Generated as PDFs using dompdf
- Issued by mentors upon completion
- Stored in `storage/app/public/certificates/`

**Attendance:**
- Daily check-in/check-out system
- Absence requests with notes
- Tracked per user and internship application

**Logbook:**
- Daily activity logs by participants
- Reviewed by mentors
- CRUD operations: create, update, delete

**Reports:**
- Admin analytics dashboard
- Exportable to PDF and Excel
- Filters by year, period, division
- Assessment reports uploaded by mentors

**Notifications:**
- In-app notification system
- Real-time unread count
- Mark as read/unread functionality
- Auto-cleanup of old notifications

### Database Conventions

- SQLite for testing (`:memory:`)
- Migrations follow Laravel conventions
- Pivot tables use singular model names: `division_admin`, `division_mentor`
- Foreign keys follow `model_id` pattern
- Enum columns for status fields (e.g., application status, assignment status)

### File Storage

**Public disk** (`storage/app/public/`):
- `certificates/` - Generated certificates
- `documents/` - Application documents (KTP, KTM, CV)
- `assignments/` - Assignment submissions
- `acceptance_letters/` - Generated acceptance letters
- `profile_pictures/` - User profile images

Always use `Storage::disk('public')` for these files and ensure they're accessible via `php artisan storage:link`.

## Important Patterns & Conventions

### Using Active Application Trait

The `HasActiveApplication` trait on User model provides convenient methods:

```php
$user->activeApplication; // Latest accepted/finished application
$user->pendingApplication; // Latest pending application
$user->hasActiveInternship(); // Boolean check
$user->canApplyForInternship(); // Can apply if no pending/active
```

### Route Naming

- Public routes: `home`, `about`, `program`
- Auth routes: `login`, `register`, `logout`, `2fa.*`
- Participant routes: `dashboard.*`, `attendance.*`, `logbook.*`
- Mentor routes: `mentor.*`
- Admin routes: `admin.*`

All authenticated routes are wrapped in `auth` middleware.

### Middleware

- `auth` - Requires authentication
- `AdminMiddleware` - Restricts access to admin role
- `RequireTwoFactor` - Ensures 2FA is completed (if applicable)

### Testing

- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Uses SQLite in-memory database
- Run full suite with `composer test` or `php artisan test`

## Common Tasks

**Add a new migration:**
```bash
php artisan make:migration create_something_table
```

**Create a new controller:**
```bash
php artisan make:controller SomethingController
```

**Create a new model with migration:**
```bash
php artisan make:model Something -m
```

**Clear application cache:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Generate a new PDF:**
Use `Barryvdh\DomPDF\Facade\Pdf` facade - see `MentorDashboardController::previewCertificate()` for examples.

**Export to Excel:**
Create an export class in `app/Exports/` extending `Maatwebsite\Excel\Concerns\FromCollection` - see `ReportExport.php` for reference.

## Code Style

This project uses Laravel Pint for code formatting. Run `vendor/bin/pint` before committing to ensure consistent code style.