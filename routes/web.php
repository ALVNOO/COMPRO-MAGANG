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

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/program', [HomeController::class, 'program'])->name('program');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2FA routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/2fa/setup', [AuthController::class, 'setup2fa'])->name('2fa.setup');
    Route::post('/2fa/enable', [AuthController::class, 'enable2fa'])->name('2fa.enable');
    Route::get('/2fa/verify', [AuthController::class, 'show2faVerify'])->name('2fa.verify');
    Route::post('/2fa/verify', [AuthController::class, 'verify2fa'])->name('2fa.verify.post');
});

// Internship routes
Route::get('/internship', [InternshipController::class, 'index'])->name('internship.index');
Route::get('/internship/apply/{divisi}', [InternshipController::class, 'apply'])->name('internship.apply');
Route::post('/internship/apply/{divisi}', [InternshipController::class, 'submitApply'])->name('internship.apply');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pre-acceptance', [DashboardController::class, 'preAcceptance'])->name('dashboard.pre-acceptance');
    Route::post('/dashboard/pre-acceptance/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.pre-acceptance.profile');
    Route::post('/dashboard/pre-acceptance/documents', [DashboardController::class, 'uploadDocuments'])->name('dashboard.pre-acceptance.documents');
    Route::post('/dashboard/pre-acceptance/dates', [DashboardController::class, 'updateDates'])->name('dashboard.pre-acceptance.dates');
    Route::post('/dashboard/pre-acceptance/complete', [DashboardController::class, 'completeApplication'])->name('dashboard.pre-acceptance.complete');
    Route::get('/dashboard/status', [DashboardController::class, 'status'])->name('dashboard.status');
    Route::post('/dashboard/status/acknowledge', [DashboardController::class, 'acknowledgePersyaratanTambahan'])->name('dashboard.status.acknowledge');
    Route::post('/dashboard/status/upload-additional', [DashboardController::class, 'submitAdditionalDocuments'])->name('dashboard.status.upload-additional');
    Route::get('/dashboard/assignments', [DashboardController::class, 'assignments'])->name('dashboard.assignments');
    Route::post('/dashboard/assignments/{id}/submit', [DashboardController::class, 'submitAssignment'])->name('dashboard.assignments.submit');
    Route::get('/dashboard/certificates', [DashboardController::class, 'certificates'])->name('dashboard.certificates');
    Route::get('/dashboard/certificates/{id}/download', [DashboardController::class, 'downloadCertificate'])->name('dashboard.certificates.download');
    Route::get('/dashboard/program', [DashboardController::class, 'program'])->name('dashboard.program');
    
    // Re-application routes
    Route::get('/dashboard/reapply', [DashboardController::class, 'reapply'])->name('dashboard.reapply');
    Route::post('/dashboard/reapply', [DashboardController::class, 'submitReapply'])->name('dashboard.submit-reapply');

    // Profile routes
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

    // Tour guide route
    Route::post('/dashboard/tour/complete', [DashboardController::class, 'completeTour'])->name('dashboard.tour.complete');

    // Attendance routes (Peserta)
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
    Route::post('/attendance/absent', [AttendanceController::class, 'absent'])->name('attendance.absent');
    
    // Logbook routes (Peserta)
    Route::get('/logbook', [LogbookController::class, 'index'])->name('logbook.index');
    Route::post('/logbook', [LogbookController::class, 'store'])->name('logbook.store');
    Route::put('/logbook/{id}', [LogbookController::class, 'update'])->name('logbook.update');
    Route::delete('/logbook/{id}', [LogbookController::class, 'destroy'])->name('logbook.destroy');
    
    // Change password routes
    Route::get('/dashboard/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/dashboard/change-password', [AuthController::class, 'changePassword'])->name('password.update');
    Route::post('/dashboard/status/download-acceptance', [DashboardController::class, 'downloadAcceptanceLetterFlag'])->name('dashboard.status.download-acceptance');
    Route::get('/dashboard/acceptance-letter/download', [DashboardController::class, 'downloadAcceptanceLetter'])->name('dashboard.acceptance-letter.download');
});

// Mentor (Pembimbing) dashboard routes
Route::middleware(['auth'])->prefix('mentor')->group(function () {
    // Dashboard utama pembimbing
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
    // Menu pengajuan magang
    Route::get('/pengajuan', [MentorDashboardController::class, 'pengajuan'])->name('mentor.pengajuan');
    Route::post('/pengajuan/{id}/respon', [MentorDashboardController::class, 'responPengajuan'])->name('mentor.pengajuan.respon');
    // Surat Penerimaan
    Route::get('/pengajuan/{id}/acceptance-letter', [MentorDashboardController::class, 'showAcceptanceLetterForm'])->name('mentor.pengajuan.acceptance-letter.form');
    Route::post('/pengajuan/{id}/acceptance-letter/preview', [MentorDashboardController::class, 'previewAcceptanceLetter'])->name('mentor.pengajuan.acceptance-letter.preview');
    Route::post('/pengajuan/{id}/acceptance-letter/send', [MentorDashboardController::class, 'sendAcceptanceLetter'])->name('mentor.pengajuan.acceptance-letter.send');
    // Menu penugasan dan penilaian
    Route::get('/penugasan', [MentorDashboardController::class, 'penugasan'])->name('mentor.penugasan');
    Route::post('/penugasan/tambah', [MentorDashboardController::class, 'tambahPenugasan'])->name('mentor.penugasan.tambah');
    Route::get('/penugasan/{assignment}/edit', [MentorDashboardController::class, 'editPenugasan'])->name('mentor.penugasan.edit');
    Route::put('/penugasan/{assignment}/update', [MentorDashboardController::class, 'updatePenugasan'])->name('mentor.penugasan.update');
    Route::delete('/penugasan/{assignment}/delete', [MentorDashboardController::class, 'deletePenugasan'])->name('mentor.penugasan.delete');
    Route::post('/penugasan/{assignment}/nilai', [MentorDashboardController::class, 'beriNilaiPenugasan'])->name('mentor.penugasan.nilai');
    Route::post('/penugasan/{assignment}/revisi', [MentorDashboardController::class, 'setRevisiPenugasan'])->name('mentor.penugasan.revisi');
    // Menu sertifikat
    Route::get('/sertifikat', [MentorDashboardController::class, 'sertifikat'])->name('mentor.sertifikat');
    Route::post('/sertifikat/{user}/upload', [MentorDashboardController::class, 'uploadSertifikat'])->name('mentor.sertifikat.upload');
    Route::get('/sertifikat/{user}/form', [MentorDashboardController::class, 'showCertificateForm'])->name('mentor.sertifikat.form');
    Route::post('/sertifikat/{user}/preview', [MentorDashboardController::class, 'previewCertificate'])->name('mentor.sertifikat.preview');
    Route::post('/sertifikat/{user}/send', [MentorDashboardController::class, 'sendCertificate'])->name('mentor.sertifikat.send');
    // Menu profil
    Route::get('/profil', [MentorDashboardController::class, 'profil'])->name('mentor.profil');
    // Menu absensi
    Route::get('/absensi', [AttendanceController::class, 'mentorIndex'])->name('mentor.absensi');
    // Menu logbook
    Route::get('/logbook', [LogbookController::class, 'mentorIndex'])->name('mentor.logbook');
    // Menu laporan penilaian
    Route::get('/laporan-penilaian', [MentorDashboardController::class, 'laporanPenilaian'])->name('mentor.laporan-penilaian');
    Route::get('/laporan-penilaian/data', [MentorDashboardController::class, 'getLaporanPenilaianData'])->name('mentor.laporan-penilaian.data');
    Route::get('/laporan-penilaian/years', [MentorDashboardController::class, 'getLaporanPenilaianYears'])->name('mentor.laporan-penilaian.years');
    Route::get('/laporan-penilaian/periods', [MentorDashboardController::class, 'getLaporanPenilaianPeriods'])->name('mentor.laporan-penilaian.periods');
    Route::post('/laporan-penilaian/{applicationId}/upload', [MentorDashboardController::class, 'uploadLaporanPenilaian'])->name('mentor.laporan-penilaian.upload');
    Route::get('/laporan-penilaian/{applicationId}/download', [MentorDashboardController::class, 'downloadLaporanPenilaian'])->name('mentor.laporan-penilaian.download');
    Route::delete('/laporan-penilaian/{applicationId}/delete', [MentorDashboardController::class, 'deleteLaporanPenilaian'])->name('mentor.laporan-penilaian.delete');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [AttendanceController::class, 'adminIndex'])->name('attendance');
    Route::get('/logbook', [LogbookController::class, 'adminIndex'])->name('logbook');
    Route::get('/logbook/mentors', [LogbookController::class, 'getMentorsByDivision'])->name('logbook.mentors');
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('applications.approve');
    Route::post('/applications/{id}/reject', [AdminController::class, 'rejectApplication'])->name('applications.reject');
    Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
    Route::post('/participants/{applicationId}/upload-acceptance-letter', [AdminController::class, 'uploadAcceptanceLetter'])->name('participants.upload-acceptance-letter');
    Route::get('/participants/{applicationId}/download-assessment-report', [AdminController::class, 'downloadAssessmentReport'])->name('participants.download-assessment-report');
    Route::post('/participants/{applicationId}/upload-completion-letter', [AdminController::class, 'uploadCompletionLetter'])->name('participants.upload-completion-letter');
    Route::post('/participants/{userId}/upload-certificate', [AdminController::class, 'uploadCertificate'])->name('participants.upload-certificate');
    Route::get('/divisions', [AdminController::class, 'divisions'])->name('divisions');
    Route::get('/mentors', [AdminController::class, 'mentors'])->name('mentors');
    Route::get('/mentor/{id}', [AdminController::class, 'mentorDetail'])->name('mentor.detail');

    // Direktorat CRUD
    Route::post('/direktorat', [AdminController::class, 'storeDirektorat'])->name('direktorat.store');
    Route::put('/direktorat/{id}', [AdminController::class, 'updateDirektorat'])->name('direktorat.update');
    Route::delete('/direktorat/{id}', [AdminController::class, 'deleteDirektorat'])->name('direktorat.delete');
    // Subdirektorat CRUD
    Route::post('/subdirektorat', [AdminController::class, 'storeSubdirektorat'])->name('subdirektorat.store');
    Route::put('/subdirektorat/{id}', [AdminController::class, 'updateSubdirektorat'])->name('subdirektorat.update');
    Route::delete('/subdirektorat/{id}', [AdminController::class, 'deleteSubdirektorat'])->name('subdirektorat.delete');
    // Divisi CRUD
    Route::post('/divisi', [AdminController::class, 'storeDivisi'])->name('divisi.store');
    Route::put('/divisi/{id}', [AdminController::class, 'updateDivisi'])->name('divisi.update');
    Route::delete('/divisi/{id}', [AdminController::class, 'deleteDivisi'])->name('divisi.delete');
    
    // Mentor management
    Route::post('/mentor/{id}/reset-password', [AdminController::class, 'resetMentorPassword'])->name('mentor.reset-password');
    
    // Rules management
    Route::get('/rules', [AdminController::class, 'editRules'])->name('rules.edit');
    Route::post('/rules', [AdminController::class, 'updateRules'])->name('rules.update');
    
    // Field of Interest management
    Route::get('/fields', [AdminController::class, 'fields'])->name('fields');
    Route::get('/fields/create', [AdminController::class, 'createField'])->name('fields.create');
    Route::post('/fields', [AdminController::class, 'storeField'])->name('fields.store');
    Route::get('/fields/{field}/edit', [AdminController::class, 'editField'])->name('fields.edit');
    Route::put('/fields/{field}', [AdminController::class, 'updateField'])->name('fields.update');
    Route::patch('/fields/{field}/toggle', [AdminController::class, 'toggleFieldStatus'])->name('fields.toggle');
    Route::delete('/fields/{field}', [AdminController::class, 'deleteField'])->name('fields.delete');
    
    // Report peserta magang
    Route::get('/reports', [AdminController::class, 'report'])->name('reports');
    Route::get('/reports/data', [AdminController::class, 'getReportData'])->name('reports.data');
    Route::get('/reports/years', [AdminController::class, 'getReportYears'])->name('reports.years');
    Route::get('/reports/periods', [AdminController::class, 'getReportPeriods'])->name('reports.periods');
    Route::get('/reports/export/pdf', [AdminController::class, 'exportReportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', [AdminController::class, 'exportReportExcel'])->name('reports.export.excel');
    Route::get('/reports/classifications', [AdminController::class, 'getReportClassifications'])->name('reports.classifications');

   // Divisions (Menu BARU) - SATU FILE BLADE
Route::get('/divisions', [AdminController::class, 'indexDivisions'])->name('divisions.index');
Route::get('/divisions/create', [AdminController::class, 'createDivision'])->name('divisions.create');
Route::post('/divisions', [AdminController::class, 'storeDivision'])->name('divisions.store');
Route::get('/divisions/{id}/edit', [AdminController::class, 'editDivision'])->name('divisions.edit');
Route::put('/divisions/{id}', [AdminController::class, 'updateDivision'])->name('divisions.update');
Route::patch('/divisions/{id}/toggle', [AdminController::class, 'toggleDivision'])->name('divisions.toggle');
Route::delete('/divisions/{id}', [AdminController::class, 'destroyDivision'])->name('divisions.destroy');
});