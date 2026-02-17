<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\NotificationController;

// New Admin Controllers (refactored)
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ParticipantController as AdminParticipantController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\MentorController as AdminMentorController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\FieldOfInterestController as AdminFieldOfInterestController;
use App\Http\Controllers\Admin\RuleController as AdminRuleController;
use App\Http\Controllers\Admin\LegacyDivisionController as AdminLegacyDivisionController;

// Public routes
Route::get("/", [HomeController::class, "index"])->name("home");
Route::get("/about", [HomeController::class, "about"])->name("about");
Route::get("/program", [HomeController::class, "program"])->name("program");

// Auth routes
Route::get("/login", [AuthController::class, "showLogin"])->name("login");
Route::post("/login", [AuthController::class, "login"]);
Route::get("/register", [AuthController::class, "showRegister"])->name(
    "register",
);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/logout", [AuthController::class, "logout"])->name("logout");

// 2FA routes (require authentication)
Route::middleware("auth")->group(function () {
    Route::get("/2fa/setup", [AuthController::class, "setup2fa"])->name(
        "2fa.setup",
    );
    Route::post("/2fa/enable", [AuthController::class, "enable2fa"])->name(
        "2fa.enable",
    );
    Route::get("/2fa/verify", [AuthController::class, "show2faVerify"])->name(
        "2fa.verify",
    );
    Route::post("/2fa/verify", [AuthController::class, "verify2fa"])->name(
        "2fa.verify.post",
    );
    Route::post("/2fa/refresh", [AuthController::class, "refresh2fa"])->name(
        "2fa.refresh",
    );
});

// Internship routes
Route::get("/internship", [InternshipController::class, "index"])->name(
    "internship.index",
);
Route::get("/internship/apply/{divisi}", [
    InternshipController::class,
    "apply",
])->name("internship.apply");
Route::post("/internship/apply/{divisi}", [
    InternshipController::class,
    "submitApply",
])->name("internship.apply");

// Protected routes (require authentication)
Route::middleware("auth")->group(function () {
    // Dashboard routes
    Route::get("/dashboard", [DashboardController::class, "index"])->name(
        "dashboard",
    );
    Route::get("/dashboard/pre-acceptance", [
        DashboardController::class,
        "preAcceptance",
    ])->name("dashboard.pre-acceptance");
    Route::post("/dashboard/pre-acceptance/profile", [
        DashboardController::class,
        "updateProfile",
    ])->name("dashboard.pre-acceptance.profile");
    Route::post("/dashboard/pre-acceptance/documents", [
        DashboardController::class,
        "uploadDocuments",
    ])->name("dashboard.pre-acceptance.documents");
    Route::post("/dashboard/pre-acceptance/dates", [
        DashboardController::class,
        "updateDates",
    ])->name("dashboard.pre-acceptance.dates");
    Route::post("/dashboard/pre-acceptance/field", [
        DashboardController::class,
        "updateFieldOfInterest",
    ])->name("dashboard.pre-acceptance.field");
    Route::post("/dashboard/pre-acceptance/complete", [
        DashboardController::class,
        "completeApplication",
    ])->name("dashboard.pre-acceptance.complete");
    Route::post("/dashboard/pre-acceptance/profile-picture", [
        DashboardController::class,
        "uploadProfilePicture",
    ])->name("dashboard.pre-acceptance.profile-picture");
    Route::delete("/dashboard/pre-acceptance/profile-picture", [
        DashboardController::class,
        "removeProfilePicture",
    ])->name("dashboard.pre-acceptance.profile-picture.remove");
    Route::get("/dashboard/status", [
        DashboardController::class,
        "status",
    ])->name("dashboard.status");
    Route::post("/dashboard/status/acknowledge", [
        DashboardController::class,
        "acknowledgePersyaratanTambahan",
    ])->name("dashboard.status.acknowledge");
    Route::post("/dashboard/status/upload-additional", [
        DashboardController::class,
        "submitAdditionalDocuments",
    ])->name("dashboard.status.upload-additional");
    Route::get("/dashboard/assignments", [
        DashboardController::class,
        "assignments",
    ])->name("dashboard.assignments");
    Route::post("/dashboard/assignments/{id}/submit", [
        DashboardController::class,
        "submitAssignment",
    ])->name("dashboard.assignments.submit");
    Route::get("/dashboard/certificates", [
        DashboardController::class,
        "certificates",
    ])->name("dashboard.certificates");
    Route::get("/dashboard/certificates/{id}/download", [
        DashboardController::class,
        "downloadCertificate",
    ])->name("dashboard.certificates.download");
    Route::get("/dashboard/program", [
        DashboardController::class,
        "program",
    ])->name("dashboard.program");

    // Re-application routes
    Route::get("/dashboard/reapply", [
        DashboardController::class,
        "reapply",
    ])->name("dashboard.reapply");
    Route::post("/dashboard/reapply", [
        DashboardController::class,
        "submitReapply",
    ])->name("dashboard.submit-reapply");

    // Profile routes
    Route::get("/dashboard/profile", [
        DashboardController::class,
        "profile",
    ])->name("dashboard.profile");
    
    // Notifications
    Route::prefix("notifications")->name("notifications.")->group(function () {
        Route::get("/", [NotificationController::class, "index"])->name("index");
        Route::get("/unread-count", [NotificationController::class, "unreadCount"])->name("unread-count");
        Route::get("/recent", [NotificationController::class, "recent"])->name("recent");
        Route::post("/{id}/read", [NotificationController::class, "markAsRead"])->name("read");
        Route::post("/mark-all-read", [NotificationController::class, "markAllAsRead"])->name("mark-all-read");
        Route::delete("/{id}", [NotificationController::class, "destroy"])->name("destroy");
    });

    // Tour guide route
    Route::post("/dashboard/tour/complete", [
        DashboardController::class,
        "completeTour",
    ])->name("dashboard.tour.complete");

    // Attendance routes (Peserta)
    Route::get("/attendance", [AttendanceController::class, "index"])->name(
        "attendance.index",
    );
    Route::post("/attendance/check-in", [
        AttendanceController::class,
        "checkIn",
    ])->name("attendance.check-in");
    Route::post("/attendance/absent", [
        AttendanceController::class,
        "absent",
    ])->name("attendance.absent");

    // Logbook routes (Peserta)
    Route::get("/logbook", [LogbookController::class, "index"])->name(
        "logbook.index",
    );
    Route::post("/logbook", [LogbookController::class, "store"])->name(
        "logbook.store",
    );
    Route::put("/logbook/{id}", [LogbookController::class, "update"])->name(
        "logbook.update",
    );
    Route::delete("/logbook/{id}", [LogbookController::class, "destroy"])->name(
        "logbook.destroy",
    );

    // Change password routes
    Route::get("/dashboard/change-password", [
        AuthController::class,
        "showChangePasswordForm",
    ])->name("password.change");
    Route::post("/dashboard/change-password", [
        AuthController::class,
        "changePassword",
    ])->name("password.update");
    Route::post("/dashboard/status/download-acceptance", [
        DashboardController::class,
        "downloadAcceptanceLetterFlag",
    ])->name("dashboard.status.download-acceptance");
    Route::get("/dashboard/acceptance-letter/download", [
        DashboardController::class,
        "downloadAcceptanceLetter",
    ])->name("dashboard.acceptance-letter.download");
});

// Mentor (Pembimbing) dashboard routes
Route::middleware(["auth"])
    ->prefix("mentor")
    ->group(function () {
        // Dashboard utama pembimbing
        Route::get("/dashboard", [
            MentorDashboardController::class,
            "index",
        ])->name("mentor.dashboard");
        // Menu pengajuan magang
        Route::get("/pengajuan", [
            MentorDashboardController::class,
            "pengajuan",
        ])->name("mentor.pengajuan");
        Route::post("/pengajuan/{id}/respon", [
            MentorDashboardController::class,
            "responPengajuan",
        ])->name("mentor.pengajuan.respon");
        // Surat Penerimaan
        Route::get("/pengajuan/{id}/acceptance-letter", [
            MentorDashboardController::class,
            "showAcceptanceLetterForm",
        ])->name("mentor.pengajuan.acceptance-letter.form");
        Route::post("/pengajuan/{id}/acceptance-letter/preview", [
            MentorDashboardController::class,
            "previewAcceptanceLetter",
        ])->name("mentor.pengajuan.acceptance-letter.preview");
        Route::post("/pengajuan/{id}/acceptance-letter/send", [
            MentorDashboardController::class,
            "sendAcceptanceLetter",
        ])->name("mentor.pengajuan.acceptance-letter.send");
        // Menu penugasan dan penilaian
        Route::get("/penugasan", [
            MentorDashboardController::class,
            "penugasan",
        ])->name("mentor.penugasan");
        Route::post("/penugasan/tambah", [
            MentorDashboardController::class,
            "tambahPenugasan",
        ])->name("mentor.penugasan.tambah");
        Route::get("/penugasan/{assignment}/edit", [
            MentorDashboardController::class,
            "editPenugasan",
        ])->name("mentor.penugasan.edit");
        Route::put("/penugasan/{assignment}/update", [
            MentorDashboardController::class,
            "updatePenugasan",
        ])->name("mentor.penugasan.update");
        Route::delete("/penugasan/{assignment}/delete", [
            MentorDashboardController::class,
            "deletePenugasan",
        ])->name("mentor.penugasan.delete");
        Route::post("/penugasan/{assignment}/nilai", [
            MentorDashboardController::class,
            "beriNilaiPenugasan",
        ])->name("mentor.penugasan.nilai");
        Route::post("/penugasan/{assignment}/revisi", [
            MentorDashboardController::class,
            "setRevisiPenugasan",
        ])->name("mentor.penugasan.revisi");
        // Menu sertifikat
        Route::get("/sertifikat", [
            MentorDashboardController::class,
            "sertifikat",
        ])->name("mentor.sertifikat");
        Route::post("/sertifikat/{user}/upload", [
            MentorDashboardController::class,
            "uploadSertifikat",
        ])->name("mentor.sertifikat.upload");
        Route::get("/sertifikat/{user}/form", [
            MentorDashboardController::class,
            "showCertificateForm",
        ])->name("mentor.sertifikat.form");
        Route::post("/sertifikat/{user}/preview", [
            MentorDashboardController::class,
            "previewCertificate",
        ])->name("mentor.sertifikat.preview");
        Route::post("/sertifikat/{user}/send", [
            MentorDashboardController::class,
            "sendCertificate",
        ])->name("mentor.sertifikat.send");
        // Menu profil
        Route::get("/profil", [
            MentorDashboardController::class,
            "profil",
        ])->name("mentor.profil");
        // Menu absensi
        Route::get("/absensi", [
            AttendanceController::class,
            "mentorIndex",
        ])->name("mentor.absensi");
        // Menu logbook
        Route::get("/logbook", [LogbookController::class, "mentorIndex"])->name(
            "mentor.logbook",
        );
        // Menu laporan penilaian
        Route::get("/laporan-penilaian", [
            MentorDashboardController::class,
            "laporanPenilaian",
        ])->name("mentor.laporan-penilaian");
        Route::get("/laporan-penilaian/data", [
            MentorDashboardController::class,
            "getLaporanPenilaianData",
        ])->name("mentor.laporan-penilaian.data");
        Route::get("/laporan-penilaian/years", [
            MentorDashboardController::class,
            "getLaporanPenilaianYears",
        ])->name("mentor.laporan-penilaian.years");
        Route::get("/laporan-penilaian/periods", [
            MentorDashboardController::class,
            "getLaporanPenilaianPeriods",
        ])->name("mentor.laporan-penilaian.periods");
        Route::post("/laporan-penilaian/{applicationId}/upload", [
            MentorDashboardController::class,
            "uploadLaporanPenilaian",
        ])->name("mentor.laporan-penilaian.upload");
        Route::get("/laporan-penilaian/{applicationId}/download", [
            MentorDashboardController::class,
            "downloadLaporanPenilaian",
        ])->name("mentor.laporan-penilaian.download");
        Route::delete("/laporan-penilaian/{applicationId}/delete", [
            MentorDashboardController::class,
            "deleteLaporanPenilaian",
        ])->name("mentor.laporan-penilaian.delete");
    });

Route::middleware(["auth"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        // ==========================================
        // NEW REFACTORED CONTROLLERS
        // ==========================================

        // Dashboard
        Route::get("/dashboard", [
            AdminDashboardController::class,
            "index",
        ])->name("dashboard");

        // Attendance & Logbook (using existing controllers)
        Route::get("/attendance", [
            AttendanceController::class,
            "adminIndex",
        ])->name("attendance");
        Route::get("/logbook", [LogbookController::class, "adminIndex"])->name(
            "logbook",
        );
        Route::get("/logbook/mentors", [
            LogbookController::class,
            "getMentorsByDivision",
        ])->name("logbook.mentors");

        // Applications
        Route::get("/applications", [
            AdminApplicationController::class,
            "index",
        ])->name("applications");
        Route::post("/applications/{id}/approve", [
            AdminApplicationController::class,
            "approve",
        ])->name("applications.approve");
        Route::post("/applications/{id}/reject", [
            AdminApplicationController::class,
            "reject",
        ])->name("applications.reject");
        Route::post("/applications/{id}/send-acceptance-letter", [
            AdminApplicationController::class,
            "sendAcceptanceLetter",
        ])->name("applications.send-acceptance-letter");

        // Participants
        Route::get("/participants", [
            AdminParticipantController::class,
            "index",
        ])->name("participants");
        Route::post("/participants/{applicationId}/upload-acceptance-letter", [
            AdminParticipantController::class,
            "uploadAcceptanceLetter",
        ])->name("participants.upload-acceptance-letter");
        Route::get("/participants/{applicationId}/download-assessment-report", [
            AdminParticipantController::class,
            "downloadAssessmentReport",
        ])->name("participants.download-assessment-report");
        Route::post("/participants/{applicationId}/upload-completion-letter", [
            AdminParticipantController::class,
            "uploadCompletionLetter",
        ])->name("participants.upload-completion-letter");
        Route::post("/participants/{userId}/upload-certificate", [
            AdminParticipantController::class,
            "uploadCertificate",
        ])->name("participants.upload-certificate");

        // Mentors
        Route::get("/mentors", [AdminMentorController::class, "index"])->name(
            "mentors",
        );
        Route::get("/mentor/{id}", [
            AdminMentorController::class,
            "show",
        ])->name("mentor.detail");
        Route::post("/mentor/{id}/reset-password", [
            AdminMentorController::class,
            "resetPassword",
        ])->name("mentor.reset-password");

        // Rules
        Route::get("/rules", [AdminRuleController::class, "edit"])->name(
            "rules.edit",
        );
        Route::post("/rules", [AdminRuleController::class, "update"])->name(
            "rules.update",
        );

        // Fields of Interest
        Route::get("/fields", [
            AdminFieldOfInterestController::class,
            "index",
        ])->name("fields");
        Route::get("/fields/create", [
            AdminFieldOfInterestController::class,
            "create",
        ])->name("fields.create");
        Route::post("/fields", [
            AdminFieldOfInterestController::class,
            "store",
        ])->name("fields.store");
        Route::get("/fields/{field}/edit", [
            AdminFieldOfInterestController::class,
            "edit",
        ])->name("fields.edit");
        Route::put("/fields/{field}", [
            AdminFieldOfInterestController::class,
            "update",
        ])->name("fields.update");
        Route::patch("/fields/{field}/toggle", [
            AdminFieldOfInterestController::class,
            "toggle",
        ])->name("fields.toggle");
        Route::delete("/fields/{field}", [
            AdminFieldOfInterestController::class,
            "destroy",
        ])->name("fields.delete");

        // Reports
        Route::get("/reports", [AdminReportController::class, "index"])->name(
            "reports",
        );
        Route::get("/reports/data", [
            AdminReportController::class,
            "getData",
        ])->name("reports.data");
        Route::get("/reports/years", [
            AdminReportController::class,
            "getYears",
        ])->name("reports.years");
        Route::get("/reports/periods", [
            AdminReportController::class,
            "getPeriods",
        ])->name("reports.periods");
        Route::get("/reports/export/pdf", [
            AdminReportController::class,
            "exportPdf",
        ])->name("reports.export.pdf");
        Route::get("/reports/export/excel", [
            AdminReportController::class,
            "exportExcel",
        ])->name("reports.export.excel");
        Route::get("/reports/summary", [
            AdminReportController::class,
            "getSummary",
        ])->name("reports.summary");

        // Divisions (NEW structure using DivisiAdmin/Division)
        Route::get("/divisions", [
            AdminDivisionController::class,
            "index",
        ])->name("divisions.index");
        Route::get("/divisions-list", [
            AdminDivisionController::class,
            "index",
        ])->name("divisions"); // Backward compatibility alias
        Route::get("/divisions/create", [
            AdminDivisionController::class,
            "create",
        ])->name("divisions.create");
        Route::post("/divisions", [
            AdminDivisionController::class,
            "store",
        ])->name("divisions.store");
        Route::get("/divisions/{id}/edit", [
            AdminDivisionController::class,
            "edit",
        ])->name("divisions.edit");
        Route::put("/divisions/{id}", [
            AdminDivisionController::class,
            "update",
        ])->name("divisions.update");
        Route::patch("/divisions/{id}/toggle", [
            AdminDivisionController::class,
            "toggle",
        ])->name("divisions.toggle");
        Route::delete("/divisions/{id}", [
            AdminDivisionController::class,
            "destroy",
        ])->name("divisions.destroy");

        // ==========================================
        // LEGACY ROUTES (Old Direktorat/SubDirektorat/Divisi structure)
        // These will be deprecated after full migration
        // ==========================================
        Route::get("/legacy-divisions", [
            AdminLegacyDivisionController::class,
            "index",
        ])->name("legacy-divisions.index");

        // Direktorat CRUD (Legacy)
        Route::post("/direktorat", [
            AdminLegacyDivisionController::class,
            "storeDirektorat",
        ])->name("direktorat.store");
        Route::put("/direktorat/{id}", [
            AdminLegacyDivisionController::class,
            "updateDirektorat",
        ])->name("direktorat.update");
        Route::delete("/direktorat/{id}", [
            AdminLegacyDivisionController::class,
            "deleteDirektorat",
        ])->name("direktorat.delete");

        // Subdirektorat CRUD (Legacy)
        Route::post("/subdirektorat", [
            AdminLegacyDivisionController::class,
            "storeSubdirektorat",
        ])->name("subdirektorat.store");
        Route::put("/subdirektorat/{id}", [
            AdminLegacyDivisionController::class,
            "updateSubdirektorat",
        ])->name("subdirektorat.update");
        Route::delete("/subdirektorat/{id}", [
            AdminLegacyDivisionController::class,
            "deleteSubdirektorat",
        ])->name("subdirektorat.delete");

        // Divisi CRUD (Legacy)
        Route::post("/divisi", [
            AdminLegacyDivisionController::class,
            "storeDivisi",
        ])->name("divisi.store");
        Route::put("/divisi/{id}", [
            AdminLegacyDivisionController::class,
            "updateDivisi",
        ])->name("divisi.update");
        Route::delete("/divisi/{id}", [
            AdminLegacyDivisionController::class,
            "deleteDivisi",
        ])->name("divisi.delete");
    });
