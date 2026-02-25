<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\ChildrensMinistryController;
use App\Http\Controllers\CounsellingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MessagingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PWAController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServicePlanningController;
use App\Http\Controllers\ServiceUnitController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShepherdController;
use App\Http\Controllers\SmsBroadcastController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WelfareController;
use App\Http\Controllers\Mobile\MobileRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Health Check Route (Railway deployment - returns quickly without database)
Route::get('/up', function () {
    return response('OK', 200);
});

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes (Authentication) - with rate limiting
Route::middleware(['guest', 'throttle:5,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:3,1');

    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:3,1');
});

// ============================================================================
// WEB APP AUTHENTICATED ROUTES (ADMIN & PASTOR ONLY)
// ============================================================================
// All routes below are restricted to admin and pastor roles only.
// Members, workers, and leaders should use the mobile app.

Route::middleware(['auth', 'web.admin'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard - Admin & Pastor Only
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/quick-action-data', [DashboardController::class, 'getQuickActionData'])->name('dashboard.quick-action-data');

    // Profile Routes - Admin & Pastor Only
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Notification Routes - Admin & Pastor Only
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('notifications/delete-all-read', [NotificationController::class, 'deleteAllRead'])->name('notifications.delete-all-read');
    Route::get('notifications/preferences', [NotificationController::class, 'preferences'])->name('notifications.preferences');
    Route::put('notifications/preferences', [NotificationController::class, 'updatePreferences'])->name('notifications.update-preferences');

    // Member Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Member statistics and export
        Route::get('members/statistics', [MemberController::class, 'statistics'])->name('members.statistics');
        Route::get('members/export', [MemberController::class, 'export'])->name('members.export');
        Route::get('members/search', [MemberController::class, 'search'])->name('members.search');

        // Member CRUD
        Route::resource('members', MemberController::class);

        // Member actions
        Route::post('members/bulk-action', [MemberController::class, 'bulkAction'])->name('members.bulk-action');
        Route::delete('members/{member}/photo', [MemberController::class, 'deletePhoto'])->name('members.delete-photo');

        // Member QR Code routes
        Route::post('members/{member}/generate-qr', [MemberController::class, 'generateQR'])->name('members.generate-qr');
        Route::post('members/{member}/regenerate-qr', [MemberController::class, 'regenerateQR'])->name('members.regenerate-qr');
        Route::post('members/bulk-generate-qr', [MemberController::class, 'bulkGenerateQR'])->name('members.bulk-generate-qr');
        Route::post('members/print-qr-cards', [MemberController::class, 'printQRCards'])->name('members.print-qr-cards');
        Route::get('members/print-cards', [MemberController::class, 'showPrintableCards'])->name('members.show-print-cards');
        Route::get('members/{member}/download-qr', [MemberController::class, 'downloadQR'])->name('members.download-qr');
        Route::get('members/{member}/qr-image', [MemberController::class, 'showQRImage'])->name('members.qr-image');
        Route::post('members/export-qr-cards-pdf', [MemberController::class, 'exportQRCardsPdf'])->name('members.export-qr-cards-pdf');
    });

    // Attendance Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Attendance list and reports
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/mark', [AttendanceController::class, 'mark'])->name('attendance.mark');
        Route::post('attendance/bulk', [AttendanceController::class, 'bulkStore'])->name('attendance.bulk');
        Route::get('attendance/reports', [AttendanceController::class, 'reports'])->name('attendance.reports');
        Route::get('attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
        Route::get('attendance/leaderboard', [AttendanceController::class, 'leaderboard'])->name('attendance.leaderboard');
        Route::get('attendance/live', [AttendanceController::class, 'live'])->name('attendance.live');

        // Attendance CRUD
        Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::get('attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    });

    // Finance/Transaction Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Transaction list and reports
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/reports', [TransactionController::class, 'reports'])->name('transactions.reports');
        Route::get('transactions/export', [TransactionController::class, 'export'])->name('transactions.export');

        // Transaction CRUD
        Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
        Route::get('transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::delete('transactions/{transaction}/receipt', [TransactionController::class, 'deleteReceipt'])->name('transactions.deleteReceipt');
    });

    // Transaction Approval & Admin - Pastor and Admin only
    Route::middleware(['role:admin,pastor'])->group(function () {
        Route::get('transactions/pending', [TransactionController::class, 'pending'])->name('transactions.pending');
        Route::post('transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::post('transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
    });

    // Transaction Delete - Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Visitor Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Visitor list and special views
        Route::get('visitors', [VisitorController::class, 'index'])->name('visitors.index');
        Route::get('visitors/eligible', [VisitorController::class, 'eligible'])->name('visitors.eligible');
        Route::get('visitors/follow-up', [VisitorController::class, 'followUp'])->name('visitors.followUp');
        Route::get('visitors/reports', [VisitorController::class, 'reports'])->name('visitors.reports');
        Route::get('visitors/export', [VisitorController::class, 'export'])->name('visitors.export');
        Route::get('visitors/search', [VisitorController::class, 'search'])->name('visitors.search');

        // Visitor CRUD
        Route::get('visitors/create', [VisitorController::class, 'create'])->name('visitors.create');
        Route::post('visitors', [VisitorController::class, 'store'])->name('visitors.store');
        Route::get('visitors/{visitor}', [VisitorController::class, 'show'])->name('visitors.show');
        Route::get('visitors/{visitor}/edit', [VisitorController::class, 'edit'])->name('visitors.edit');
        Route::put('visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
        Route::delete('visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');

        // Visitor actions
        Route::post('visitors/{visitor}/record-visit', [VisitorController::class, 'recordVisit'])->name('visitors.recordVisit');
        Route::get('visitors/{visitor}/convert', [VisitorController::class, 'convertForm'])->name('visitors.convert.form');
        Route::post('visitors/{visitor}/convert', [VisitorController::class, 'convert'])->name('visitors.convert');
        Route::post('visitors/{visitor}/mark-inactive', [VisitorController::class, 'markInactive'])->name('visitors.markInactive');
    });

    // SMS Broadcast Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        Route::get('sms', [SmsBroadcastController::class, 'index'])->name('sms.index');
        Route::get('sms/create', [SmsBroadcastController::class, 'create'])->name('sms.create');
        Route::post('sms', [SmsBroadcastController::class, 'store'])->name('sms.store');
        Route::get('sms/{broadcast}', [SmsBroadcastController::class, 'show'])->name('sms.show');
        Route::get('sms/{broadcast}/edit', [SmsBroadcastController::class, 'edit'])->name('sms.edit');
        Route::put('sms/{broadcast}', [SmsBroadcastController::class, 'update'])->name('sms.update');
        Route::delete('sms/{broadcast}', [SmsBroadcastController::class, 'destroy'])->name('sms.destroy');
        Route::post('sms/{broadcast}/send', [SmsBroadcastController::class, 'send'])->name('sms.send');
        Route::get('sms/{broadcast}/status', [SmsBroadcastController::class, 'status'])->name('sms.status');
    });

    // Equipment Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Equipment list and reports
        Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
        Route::get('equipment/maintenance', [EquipmentController::class, 'maintenance'])->name('equipment.maintenance');
        Route::get('equipment/reports', [EquipmentController::class, 'reports'])->name('equipment.reports');
        Route::get('equipment/export', [EquipmentController::class, 'export'])->name('equipment.export');

        // Equipment CRUD
        Route::get('equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
        Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
        Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
        Route::get('equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
        Route::put('equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
        Route::delete('equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

        // Maintenance actions
        Route::get('equipment/{equipment}/maintenance-form', [EquipmentController::class, 'maintenanceForm'])->name('equipment.maintenance.form');
        Route::post('equipment/{equipment}/maintenance', [EquipmentController::class, 'recordMaintenance'])->name('equipment.maintenance.record');
        Route::post('equipment/{equipment}/schedule-maintenance', [EquipmentController::class, 'scheduleMaintenance'])->name('equipment.maintenance.schedule');
    });

    // Shepherd/Small Groups Routes - Pastor and Admin only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Shepherd list and analytics
        Route::get('shepherds', [ShepherdController::class, 'index'])->name('shepherds.index');
        Route::get('shepherds/analytics', [ShepherdController::class, 'analytics'])->name('shepherds.analytics');
        Route::get('shepherds/export', [ShepherdController::class, 'export'])->name('shepherds.export');
        Route::post('shepherds/auto-assign', [ShepherdController::class, 'autoAssign'])->name('shepherds.auto-assign');

        // Shepherd CRUD
        Route::get('shepherds/create', [ShepherdController::class, 'create'])->name('shepherds.create');
        Route::post('shepherds', [ShepherdController::class, 'store'])->name('shepherds.store');
        Route::get('shepherds/{shepherd}', [ShepherdController::class, 'show'])->name('shepherds.show');
        Route::get('shepherds/{shepherd}/edit', [ShepherdController::class, 'edit'])->name('shepherds.edit');
        Route::put('shepherds/{shepherd}', [ShepherdController::class, 'update'])->name('shepherds.update');
        Route::delete('shepherds/{shepherd}', [ShepherdController::class, 'destroy'])->name('shepherds.destroy');

        // Flock management
        Route::get('shepherds/{shepherd}/manage-flock', [ShepherdController::class, 'manageFlock'])->name('shepherds.manage-flock');
        Route::post('shepherds/{shepherd}/assign-member', [ShepherdController::class, 'assignMember'])->name('shepherds.assign-member');
        Route::post('shepherds/{shepherd}/unassign-member', [ShepherdController::class, 'unassignMember'])->name('shepherds.unassign-member');

        // Visitations
        Route::get('shepherds/{shepherd}/visitations', [ShepherdController::class, 'visitations'])->name('shepherds.visitations');
        Route::get('shepherds/{shepherd}/create-visitation', [ShepherdController::class, 'createVisitation'])->name('shepherds.create-visitation');
        Route::post('shepherds/{shepherd}/visitations', [ShepherdController::class, 'storeVisitation'])->name('shepherds.store-visitation');

        // Meetings
        Route::get('shepherds/{shepherd}/meetings', [ShepherdController::class, 'meetings'])->name('shepherds.meetings');
        Route::get('shepherds/{shepherd}/create-meeting', [ShepherdController::class, 'createMeeting'])->name('shepherds.create-meeting');
        Route::post('shepherds/{shepherd}/meetings', [ShepherdController::class, 'storeMeeting'])->name('shepherds.store-meeting');

        // Reports
        Route::get('shepherds/{shepherd}/reports', [ShepherdController::class, 'reports'])->name('shepherds.reports');
    });

    // Service Units Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Service unit list and analytics
        Route::get('service-units', [ServiceUnitController::class, 'index'])->name('service-units.index');
        Route::get('service-units/analytics', [ServiceUnitController::class, 'analytics'])->name('service-units.analytics');
        Route::get('service-units/export', [ServiceUnitController::class, 'export'])->name('service-units.export');

        // Service unit CRUD
        Route::get('service-units/create', [ServiceUnitController::class, 'create'])->name('service-units.create');
        Route::post('service-units', [ServiceUnitController::class, 'store'])->name('service-units.store');
        Route::get('service-units/{serviceUnit}', [ServiceUnitController::class, 'show'])->name('service-units.show');
        Route::get('service-units/{serviceUnit}/edit', [ServiceUnitController::class, 'edit'])->name('service-units.edit');
        Route::put('service-units/{serviceUnit}', [ServiceUnitController::class, 'update'])->name('service-units.update');
        Route::delete('service-units/{serviceUnit}', [ServiceUnitController::class, 'destroy'])->name('service-units.destroy');

        // Member management
        Route::get('service-units/{serviceUnit}/manage-members', [ServiceUnitController::class, 'manageMembers'])->name('service-units.manage-members');
        Route::post('service-units/{serviceUnit}/add-member', [ServiceUnitController::class, 'addMember'])->name('service-units.add-member');
        Route::delete('service-units/{serviceUnit}/remove-member', [ServiceUnitController::class, 'removeMember'])->name('service-units.remove-member');

        // Duty rosters
        Route::get('service-units/{serviceUnit}/duty-rosters', [ServiceUnitController::class, 'dutyRosters'])->name('service-units.duty-rosters');
        Route::get('service-units/{serviceUnit}/create-duty-roster', [ServiceUnitController::class, 'createDutyRoster'])->name('service-units.create-duty-roster');
        Route::post('service-units/{serviceUnit}/duty-rosters', [ServiceUnitController::class, 'storeDutyRoster'])->name('service-units.store-duty-roster');
        Route::put('duty-rosters/{dutyRoster}/publish', [ServiceUnitController::class, 'publishDutyRoster'])->name('service-units.publish-duty-roster');
    });

    // Programs Module - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Program listing and viewing
        Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('programs/create', [ProgramController::class, 'create'])->name('programs.create');
        Route::post('programs', [ProgramController::class, 'store'])->name('programs.store');
        Route::get('programs/{program}', [ProgramController::class, 'show'])->name('programs.show');
        Route::get('programs/{program}/edit', [ProgramController::class, 'edit'])->name('programs.edit');
        Route::put('programs/{program}', [ProgramController::class, 'update'])->name('programs.update');
        Route::delete('programs/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');

        // Program status actions
        Route::post('programs/{program}/publish', [ProgramController::class, 'publish'])->name('programs.publish');
        Route::post('programs/{program}/start', [ProgramController::class, 'start'])->name('programs.start');
        Route::post('programs/{program}/complete', [ProgramController::class, 'complete'])->name('programs.complete');
        Route::post('programs/{program}/cancel', [ProgramController::class, 'cancel'])->name('programs.cancel');

        // Registration management
        Route::get('programs/{program}/registrations', [ProgramController::class, 'manageRegistrations'])->name('programs.manage-registrations');
        Route::post('programs/registrations/{registration}/check-in', [ProgramController::class, 'checkIn'])->name('programs.check-in');

        // Session management
        Route::get('programs/{program}/sessions', [ProgramController::class, 'manageSessions'])->name('programs.manage-sessions');
        Route::post('programs/{program}/sessions', [ProgramController::class, 'storeSession'])->name('programs.store-session');
        Route::put('programs/sessions/{session}', [ProgramController::class, 'updateSession'])->name('programs.update-session');
        Route::delete('programs/sessions/{session}', [ProgramController::class, 'destroySession'])->name('programs.destroy-session');

        // Analytics
        Route::get('programs/{program}/analytics', [ProgramController::class, 'analytics'])->name('programs.analytics');

        // Program QR Code routes
        Route::post('programs/{program}/generate-registration-qr', [ProgramController::class, 'generateRegistrationQR'])->name('programs.generate-registration-qr');
        Route::post('programs/{program}/generate-checkin-qr', [ProgramController::class, 'generateCheckInQR'])->name('programs.generate-checkin-qr');
        Route::post('programs/{program}/regenerate-registration-qr', [ProgramController::class, 'regenerateRegistrationQR'])->name('programs.regenerate-registration-qr');
        Route::post('programs/{program}/regenerate-checkin-qr', [ProgramController::class, 'regenerateCheckInQR'])->name('programs.regenerate-checkin-qr');
        Route::post('programs/{program}/toggle-qr-registration', [ProgramController::class, 'toggleQRRegistration'])->name('programs.toggle-qr-registration');
        Route::post('programs/{program}/toggle-qr-checkin', [ProgramController::class, 'toggleQRCheckIn'])->name('programs.toggle-qr-checkin');
        Route::get('programs/{program}/download-registration-qr', [ProgramController::class, 'downloadRegistrationQR'])->name('programs.download-registration-qr');
        Route::get('programs/{program}/download-checkin-qr', [ProgramController::class, 'downloadCheckInQR'])->name('programs.download-checkin-qr');
        Route::get('programs/{program}/registration-qr-image', [ProgramController::class, 'showRegistrationQRImage'])->name('programs.registration-qr-image');
        Route::get('programs/{program}/checkin-qr-image', [ProgramController::class, 'showCheckInQRImage'])->name('programs.checkin-qr-image');
        Route::get('programs/{program}/print-registration-qr', [ProgramController::class, 'printRegistrationQRPoster'])->name('programs.print-registration-qr');
        Route::get('programs/{program}/print-checkin-qr', [ProgramController::class, 'printCheckInQRPoster'])->name('programs.print-checkin-qr');
        Route::post('programs/{program}/export-qr-poster-pdf', [ProgramController::class, 'exportQRPosterPdf'])->name('programs.export-qr-poster-pdf');
    });

    // Note: Program registration for members is available via Mobile API only
    // See routes/api.php line 186: Route::post('/programs/{program}/register')

    // Service Planning Module - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Service schedule listing and calendar
        Route::get('services', [ServicePlanningController::class, 'index'])->name('services.index');
        Route::get('services/calendar', [ServicePlanningController::class, 'calendar'])->name('services.calendar');
        Route::get('services/sermon-library', [ServicePlanningController::class, 'sermonLibrary'])->name('services.sermon-library');

        // Service schedule CRUD
        Route::get('services/create', [ServicePlanningController::class, 'create'])->name('services.create');
        Route::post('services', [ServicePlanningController::class, 'store'])->name('services.store');
        Route::get('services/{service}', [ServicePlanningController::class, 'show'])->name('services.show');
        Route::get('services/{service}/edit', [ServicePlanningController::class, 'edit'])->name('services.edit');
        Route::put('services/{service}', [ServicePlanningController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [ServicePlanningController::class, 'destroy'])->name('services.destroy');

        // Service status actions
        Route::post('services/{service}/publish', [ServicePlanningController::class, 'publish'])->name('services.publish');
        Route::post('services/{service}/start', [ServicePlanningController::class, 'start'])->name('services.start');
        Route::post('services/{service}/complete', [ServicePlanningController::class, 'complete'])->name('services.complete');
        Route::post('services/{service}/cancel', [ServicePlanningController::class, 'cancel'])->name('services.cancel');

        // Duplicate service
        Route::post('services/{service}/duplicate', [ServicePlanningController::class, 'duplicate'])->name('services.duplicate');

        // Worship plan management
        Route::get('services/{service}/worship-plan', [ServicePlanningController::class, 'manageWorshipPlan'])->name('services.worship-plan');
        Route::post('services/{service}/worship-plan', [ServicePlanningController::class, 'storeWorshipPlanItem'])->name('services.store-worship-item');
        Route::put('services/worship-plan/{item}', [ServicePlanningController::class, 'updateWorshipPlanItem'])->name('services.update-worship-item');
        Route::delete('services/worship-plan/{item}', [ServicePlanningController::class, 'destroyWorshipPlanItem'])->name('services.destroy-worship-item');
        Route::post('services/{service}/worship-plan/reorder', [ServicePlanningController::class, 'reorderWorshipPlan'])->name('services.reorder-worship-plan');

        // Volunteer management
        Route::get('services/{service}/volunteers', [ServicePlanningController::class, 'manageVolunteers'])->name('services.volunteers');
        Route::post('services/{service}/volunteers', [ServicePlanningController::class, 'assignVolunteer'])->name('services.assign-volunteer');
        Route::put('services/volunteers/{volunteer}', [ServicePlanningController::class, 'updateVolunteer'])->name('services.update-volunteer');
        Route::delete('services/volunteers/{volunteer}', [ServicePlanningController::class, 'removeVolunteer'])->name('services.remove-volunteer');
        Route::post('services/volunteers/{volunteer}/confirm', [ServicePlanningController::class, 'confirmVolunteer'])->name('services.confirm-volunteer');
    });

    // Prayer Request System - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Prayer dashboard and management
        Route::get('prayer', [PrayerController::class, 'index'])->name('prayer.index');
        Route::get('prayer/analytics', [PrayerController::class, 'analytics'])->name('prayer.analytics');

        // Prayer management actions
        Route::post('prayer/{prayerRequest}/assign', [PrayerController::class, 'assign'])->name('prayer.assign');
        Route::post('prayer/{prayerRequest}/add-update', [PrayerController::class, 'addUpdate'])->name('prayer.add-update');
        Route::post('prayer/{prayerRequest}/mark-answered', [PrayerController::class, 'markAnswered'])->name('prayer.mark-answered');

        // Testimonies management
        Route::get('prayer/testimonies', [PrayerController::class, 'testimonies'])->name('prayer.testimonies');
        Route::post('prayer/testimonies/{testimony}/approve', [PrayerController::class, 'approveTestimony'])->name('prayer.approve-testimony');
    });

    // Note: Prayer requests for members are available via Mobile API only
    // See routes/api.php lines 189-207 for prayer request endpoints

    // Birthday & Anniversary Automation - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Dashboard and main views
        Route::get('birthdays', [BirthdayController::class, 'index'])->name('birthdays.index');
        Route::get('birthdays/calendar', [BirthdayController::class, 'calendar'])->name('birthdays.calendar');
        Route::get('birthdays/history', [BirthdayController::class, 'history'])->name('birthdays.history');
        Route::get('birthdays/milestones', [BirthdayController::class, 'milestones'])->name('birthdays.milestones');
        Route::get('birthdays/announcements', [BirthdayController::class, 'announcements'])->name('birthdays.announcements');

        // Milestone actions
        Route::post('birthdays/milestones/{milestone}/recognize', [BirthdayController::class, 'recognizeMilestone'])->name('birthdays.recognize-milestone');
        Route::post('birthdays/announcements/{announcement}/display', [BirthdayController::class, 'markAnnouncementDisplayed'])->name('birthdays.mark-announcement-displayed');

        // Settings (Admin only)
        Route::middleware(['role:admin'])->group(function () {
            Route::get('birthdays/settings', [BirthdayController::class, 'settings'])->name('birthdays.settings');
            Route::put('birthdays/settings/{eventType}', [BirthdayController::class, 'updateSettings'])->name('birthdays.update-settings');
            Route::post('birthdays/process', [BirthdayController::class, 'processBirthdays'])->name('birthdays.process');
            Route::post('birthdays/retry-failed', [BirthdayController::class, 'retryFailed'])->name('birthdays.retry-failed');
        });
    });

    // Reports Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Main dashboard
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // Custom report builder
        Route::get('reports/builder', [ReportController::class, 'builder'])->name('reports.builder');
        Route::post('reports/custom', [ReportController::class, 'storeCustomReport'])->name('reports.custom.store');
        Route::get('reports/custom/{report}', [ReportController::class, 'showCustomReport'])->name('reports.custom.show');
        Route::get('reports/custom/{report}/edit', [ReportController::class, 'editCustomReport'])->name('reports.custom.edit');
        Route::put('reports/custom/{report}', [ReportController::class, 'updateCustomReport'])->name('reports.custom.update');
        Route::delete('reports/custom/{report}', [ReportController::class, 'deleteCustomReport'])->name('reports.custom.delete');
        Route::post('reports/custom/{report}/duplicate', [ReportController::class, 'duplicateCustomReport'])->name('reports.custom.duplicate');
        Route::post('reports/custom/{report}/favorite', [ReportController::class, 'toggleFavorite'])->name('reports.custom.favorite');

        // Standard reports
        Route::get('reports/membership', [ReportController::class, 'membershipReports'])->name('reports.membership.roster');
        Route::get('reports/membership/new', [ReportController::class, 'membershipReports'])->name('reports.membership.new');
        Route::get('reports/membership/demographics', [ReportController::class, 'membershipReports'])->name('reports.membership.demographics');
        Route::get('reports/membership/birthdays', [ReportController::class, 'membershipReports'])->name('reports.membership.birthdays');

        Route::get('reports/financial', [ReportController::class, 'financialReports'])->name('reports.financial.income');
        Route::get('reports/financial/expenses', [ReportController::class, 'financialReports'])->name('reports.financial.expenses');
        Route::get('reports/financial/cash-flow', [ReportController::class, 'financialReports'])->name('reports.financial.cash-flow');
        Route::get('reports/financial/giving', [ReportController::class, 'financialReports'])->name('reports.financial.giving');

        Route::get('reports/attendance', [ReportController::class, 'attendanceReports'])->name('reports.attendance.summary');

        // QR Analytics - Staff and above
        Route::get('qr-analytics', [\App\Http\Controllers\QRAnalyticsController::class, 'index'])->name('qr-analytics.index');
        Route::post('qr-analytics/export', [\App\Http\Controllers\QRAnalyticsController::class, 'export'])->name('qr-analytics.export');

        // QR Scan History Reports
        Route::get('reports/qr-scans', [ReportController::class, 'qrScanHistory'])->name('reports.qr-scans');
        Route::post('reports/qr-scans/export', [ReportController::class, 'exportQRScanHistory'])->name('reports.qr-scans.export');
        Route::get('reports/attendance/trends', [ReportController::class, 'attendanceReports'])->name('reports.attendance.trends');
        Route::get('reports/attendance/absentees', [ReportController::class, 'attendanceReports'])->name('reports.attendance.absentees');

        Route::get('reports/program', [ReportController::class, 'programReports'])->name('reports.program.performance');
        Route::get('reports/program/impact', [ReportController::class, 'programReports'])->name('reports.program.impact');

        // Analytics dashboard
        Route::get('reports/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');

        // Report schedules
        Route::get('reports/schedules', [ReportController::class, 'schedules'])->name('reports.schedules');
        Route::post('reports/schedules', [ReportController::class, 'storeSchedule'])->name('reports.schedules.store');
        Route::put('reports/schedules/{schedule}', [ReportController::class, 'updateSchedule'])->name('reports.schedules.update');
        Route::delete('reports/schedules/{schedule}', [ReportController::class, 'deleteSchedule'])->name('reports.schedules.delete');

        // Report executions
        Route::get('reports/executions', [ReportController::class, 'executions'])->name('reports.executions');
        Route::get('reports/executions/{execution}/download', [ReportController::class, 'downloadExecution'])->name('reports.executions.download');
        Route::delete('reports/executions/{execution}', [ReportController::class, 'deleteExecution'])->name('reports.executions.delete');

        // Export actions
        Route::post('reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::post('reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
        Route::post('reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
    });

    // Children's Ministry Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Dashboard
        Route::get('childrens-ministry', [ChildrensMinistryController::class, 'index'])->name('childrens-ministry.index');

        // Children management
        Route::get('childrens-ministry/children', [ChildrensMinistryController::class, 'children'])->name('childrens-ministry.children');
        Route::get('childrens-ministry/children/{child}', [ChildrensMinistryController::class, 'showChild'])->name('childrens-ministry.children.show');

        // Check-in/Check-out
        Route::get('childrens-ministry/checkin', [ChildrensMinistryController::class, 'checkinInterface'])->name('childrens-ministry.checkin');
        Route::post('childrens-ministry/checkin', [ChildrensMinistryController::class, 'processCheckin'])->name('childrens-ministry.checkin.process');
        Route::post('childrens-ministry/checkout/{checkin}', [ChildrensMinistryController::class, 'processCheckout'])->name('childrens-ministry.checkout.process');

        // Curriculum
        Route::get('childrens-ministry/curriculum', [ChildrensMinistryController::class, 'curriculumLessons'])->name('childrens-ministry.curriculum');
        Route::get('childrens-ministry/curriculum/create', [ChildrensMinistryController::class, 'createLesson'])->name('childrens-ministry.curriculum.create');
        Route::post('childrens-ministry/curriculum', [ChildrensMinistryController::class, 'storeLesson'])->name('childrens-ministry.curriculum.store');
        Route::get('childrens-ministry/curriculum/{lesson}', [ChildrensMinistryController::class, 'showLesson'])->name('childrens-ministry.curriculum.show');
        Route::get('childrens-ministry/curriculum/{lesson}/edit', [ChildrensMinistryController::class, 'editLesson'])->name('childrens-ministry.curriculum.edit');
        Route::put('childrens-ministry/curriculum/{lesson}', [ChildrensMinistryController::class, 'updateLesson'])->name('childrens-ministry.curriculum.update');
        Route::delete('childrens-ministry/curriculum/{lesson}', [ChildrensMinistryController::class, 'deleteLesson'])->name('childrens-ministry.curriculum.delete');
        Route::post('childrens-ministry/curriculum/{lesson}/publish', [ChildrensMinistryController::class, 'publishLesson'])->name('childrens-ministry.curriculum.publish');

        // Events
        Route::get('childrens-ministry/events', [ChildrensMinistryController::class, 'events'])->name('childrens-ministry.events');
        Route::get('childrens-ministry/events/create', [ChildrensMinistryController::class, 'createEvent'])->name('childrens-ministry.events.create');
        Route::post('childrens-ministry/events', [ChildrensMinistryController::class, 'storeEvent'])->name('childrens-ministry.events.store');
        Route::get('childrens-ministry/events/{event}', [ChildrensMinistryController::class, 'showEvent'])->name('childrens-ministry.events.show');
        Route::put('childrens-ministry/events/{event}', [ChildrensMinistryController::class, 'updateEvent'])->name('childrens-ministry.events.update');
        Route::post('childrens-ministry/events/{event}/register', [ChildrensMinistryController::class, 'registerForEvent'])->name('childrens-ministry.events.register');
        Route::post('childrens-ministry/events/{event}/publish', [ChildrensMinistryController::class, 'publishEvent'])->name('childrens-ministry.events.publish');
        Route::post('childrens-ministry/events/{event}/start', [ChildrensMinistryController::class, 'startEvent'])->name('childrens-ministry.events.start');
        Route::post('childrens-ministry/events/{event}/complete', [ChildrensMinistryController::class, 'completeEvent'])->name('childrens-ministry.events.complete');
        Route::delete('childrens-ministry/events/{event}', [ChildrensMinistryController::class, 'destroyEvent'])->name('childrens-ministry.events.destroy');

        // Reports
        Route::get('childrens-ministry/reports', [ChildrensMinistryController::class, 'reports'])->name('childrens-ministry.reports');
    });

    // Settings Routes - Admin only
    Route::middleware(['role:admin'])->group(function () {
        // Main settings dashboard
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');

        // General settings
        Route::put('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.update-general');

        // Email templates
        Route::get('settings/email-templates', [SettingsController::class, 'emailTemplates'])->name('settings.email-templates');
        Route::get('settings/email-templates/{template}/edit', [SettingsController::class, 'editEmailTemplate'])->name('settings.edit-email-template');
        Route::put('settings/email-templates/{template}', [SettingsController::class, 'updateEmailTemplate'])->name('settings.update-email-template');

        // Audit logs
        Route::get('settings/audit-logs', [SettingsController::class, 'auditLogs'])->name('settings.audit-logs');

        // Backups
        Route::get('settings/backups', [SettingsController::class, 'backups'])->name('settings.backups');
        Route::post('settings/backups', [SettingsController::class, 'createBackup'])->name('settings.create-backup');
        Route::get('settings/backups/{backup}/download', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
        Route::delete('settings/backups/{backup}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');

        // System information
        Route::get('settings/system-info', [SettingsController::class, 'systemInfo'])->name('settings.system-info');

        // Clear cache
        Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    });

    // Counselling Routes - Pastor and above
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Dashboard
        Route::get('counselling', [CounsellingController::class, 'index'])->name('counselling.index');

        // Counsellors
        Route::get('counselling/counsellors', [CounsellingController::class, 'counsellors'])->name('counselling.counsellors');
        Route::get('counselling/counsellors/create', [CounsellingController::class, 'createCounsellor'])->name('counselling.counsellors.create');
        Route::post('counselling/counsellors', [CounsellingController::class, 'storeCounsellor'])->name('counselling.counsellors.store');
        Route::get('counselling/counsellors/{counsellor}', [CounsellingController::class, 'showCounsellor'])->name('counselling.counsellors.show');
        Route::put('counselling/counsellors/{counsellor}', [CounsellingController::class, 'updateCounsellor'])->name('counselling.counsellors.update');
        Route::post('counselling/counsellors/{counsellor}/activate', [CounsellingController::class, 'activateCounsellor'])->name('counselling.counsellors.activate');
        Route::post('counselling/counsellors/{counsellor}/deactivate', [CounsellingController::class, 'deactivateCounsellor'])->name('counselling.counsellors.deactivate');
        Route::delete('counselling/counsellors/{counsellor}', [CounsellingController::class, 'destroyCounsellor'])->name('counselling.counsellors.destroy');

        // Sessions
        Route::get('counselling/sessions', [CounsellingController::class, 'sessions'])->name('counselling.sessions');
        Route::get('counselling/sessions/create', [CounsellingController::class, 'createSession'])->name('counselling.sessions.create');
        Route::post('counselling/sessions', [CounsellingController::class, 'storeSession'])->name('counselling.sessions.store');
        Route::get('counselling/sessions/{session}', [CounsellingController::class, 'showSession'])->name('counselling.sessions.show');
        Route::put('counselling/sessions/{session}', [CounsellingController::class, 'updateSession'])->name('counselling.sessions.update');
        Route::post('counselling/sessions/{session}/confirm', [CounsellingController::class, 'confirmSession'])->name('counselling.sessions.confirm');
        Route::post('counselling/sessions/{session}/start', [CounsellingController::class, 'startSession'])->name('counselling.sessions.start');
        Route::post('counselling/sessions/{session}/complete', [CounsellingController::class, 'completeSession'])->name('counselling.sessions.complete');
        Route::post('counselling/sessions/{session}/cancel', [CounsellingController::class, 'cancelSession'])->name('counselling.sessions.cancel');
        Route::post('counselling/sessions/{session}/reschedule', [CounsellingController::class, 'rescheduleSession'])->name('counselling.sessions.reschedule');
        Route::delete('counselling/sessions/{session}', [CounsellingController::class, 'destroySession'])->name('counselling.sessions.destroy');
        Route::get('counselling/available-counsellors', [CounsellingController::class, 'getAvailableCounsellors'])->name('counselling.available-counsellors');

        // Cases
        Route::get('counselling/cases', [CounsellingController::class, 'cases'])->name('counselling.cases');
        Route::get('counselling/cases/create', [CounsellingController::class, 'createCase'])->name('counselling.cases.create');
        Route::post('counselling/cases', [CounsellingController::class, 'storeCase'])->name('counselling.cases.store');
        Route::get('counselling/cases/{case}', [CounsellingController::class, 'showCase'])->name('counselling.cases.show');
        Route::put('counselling/cases/{case}', [CounsellingController::class, 'updateCase'])->name('counselling.cases.update');
        Route::post('counselling/cases/{case}/activate', [CounsellingController::class, 'activateCase'])->name('counselling.cases.activate');
        Route::post('counselling/cases/{case}/hold', [CounsellingController::class, 'holdCase'])->name('counselling.cases.hold');
        Route::post('counselling/cases/{case}/close', [CounsellingController::class, 'closeCase'])->name('counselling.cases.close');
        Route::delete('counselling/cases/{case}', [CounsellingController::class, 'destroyCase'])->name('counselling.cases.destroy');

        // Resources
        Route::get('counselling/resources', [CounsellingController::class, 'resources'])->name('counselling.resources');
        Route::get('counselling/resources/create', [CounsellingController::class, 'createResource'])->name('counselling.resources.create');
        Route::post('counselling/resources', [CounsellingController::class, 'storeResource'])->name('counselling.resources.store');
        Route::get('counselling/resources/{resource}', [CounsellingController::class, 'showResource'])->name('counselling.resources.show');
        Route::put('counselling/resources/{resource}', [CounsellingController::class, 'updateResource'])->name('counselling.resources.update');
        Route::delete('counselling/resources/{resource}', [CounsellingController::class, 'destroyResource'])->name('counselling.resources.destroy');
        Route::get('counselling/resources/{resource}/download', [CounsellingController::class, 'downloadResource'])->name('counselling.resources.download');

        // Reports
        Route::get('counselling/reports', [CounsellingController::class, 'reports'])->name('counselling.reports');
    });

    // Welfare Routes - Pastor and above
    Route::middleware(['role:admin,pastor'])->group(function () {
        // Dashboard
        Route::get('welfare', [WelfareController::class, 'index'])->name('welfare.index');

        // Cases
        Route::get('welfare/cases', [WelfareController::class, 'cases'])->name('welfare.cases');
        Route::get('welfare/cases/create', [WelfareController::class, 'createCase'])->name('welfare.cases.create');
        Route::post('welfare/cases', [WelfareController::class, 'storeCase'])->name('welfare.cases.store');
        Route::get('welfare/cases/{case}', [WelfareController::class, 'showCase'])->name('welfare.cases.show');
        Route::put('welfare/cases/{case}', [WelfareController::class, 'updateCase'])->name('welfare.cases.update');
        Route::post('welfare/cases/{case}/under-review', [WelfareController::class, 'markUnderReview'])->name('welfare.cases.under-review');
        Route::post('welfare/cases/{case}/verify', [WelfareController::class, 'verifyCase'])->name('welfare.cases.verify');
        Route::post('welfare/cases/{case}/reject-verification', [WelfareController::class, 'rejectVerification'])->name('welfare.cases.reject-verification');
        Route::post('welfare/cases/{case}/approve', [WelfareController::class, 'approveCase'])->name('welfare.cases.approve');
        Route::post('welfare/cases/{case}/reject', [WelfareController::class, 'rejectCase'])->name('welfare.cases.reject');
        Route::post('welfare/cases/{case}/close', [WelfareController::class, 'closeCase'])->name('welfare.cases.close');
        Route::delete('welfare/cases/{case}', [WelfareController::class, 'destroyCase'])->name('welfare.cases.destroy');

        // Programs
        Route::get('welfare/programs', [WelfareController::class, 'programs'])->name('welfare.programs');
        Route::get('welfare/programs/create', [WelfareController::class, 'createProgram'])->name('welfare.programs.create');
        Route::post('welfare/programs', [WelfareController::class, 'storeProgram'])->name('welfare.programs.store');
        Route::get('welfare/programs/{program}', [WelfareController::class, 'showProgram'])->name('welfare.programs.show');
        Route::put('welfare/programs/{program}', [WelfareController::class, 'updateProgram'])->name('welfare.programs.update');
        Route::post('welfare/programs/{program}/activate', [WelfareController::class, 'activateProgram'])->name('welfare.programs.activate');
        Route::post('welfare/programs/{program}/pause', [WelfareController::class, 'pauseProgram'])->name('welfare.programs.pause');
        Route::post('welfare/programs/{program}/complete', [WelfareController::class, 'completeProgram'])->name('welfare.programs.complete');
        Route::delete('welfare/programs/{program}', [WelfareController::class, 'destroyProgram'])->name('welfare.programs.destroy');

        // Fund Transactions
        Route::get('welfare/fund-transactions', [WelfareController::class, 'fundTransactions'])->name('welfare.fund-transactions');
        Route::post('welfare/fund-transactions', [WelfareController::class, 'recordTransaction'])->name('welfare.record-transaction');

        // Reports
        Route::get('welfare/reports', [WelfareController::class, 'reports'])->name('welfare.reports');
    });

    // Note: Messaging for members is available via Mobile API only
    // See routes/api.php lines 254-267 for messaging endpoints

    // Media Team Routes - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::get('content', [MediaController::class, 'content'])->name('content');
        Route::post('content', [MediaController::class, 'storeContent'])->name('content.store');
        Route::post('content/{content}/publish', [MediaController::class, 'publishContent'])->name('content.publish');
        Route::get('streams', [MediaController::class, 'streams'])->name('streams');
        Route::post('streams', [MediaController::class, 'storeStream'])->name('streams.store');
        Route::get('team', [MediaController::class, 'teamMembers'])->name('team');

        // Content CRUD routes
        Route::get('content/{content}', [MediaController::class, 'showContent'])->name('content.show');
        Route::get('content/{content}/edit', [MediaController::class, 'editContent'])->name('content.edit');
        Route::put('content/{content}', [MediaController::class, 'updateContent'])->name('content.update');
        Route::delete('content/{content}', [MediaController::class, 'destroyContent'])->name('content.destroy');

        // Stream CRUD routes
        Route::get('streams/{stream}', [MediaController::class, 'showStream'])->name('streams.show');
        Route::get('streams/{stream}/edit', [MediaController::class, 'editStream'])->name('streams.edit');
        Route::put('streams/{stream}', [MediaController::class, 'updateStream'])->name('streams.update');
        Route::delete('streams/{stream}', [MediaController::class, 'destroyStream'])->name('streams.destroy');
    });

    // Partnerships Routes - Pastor and above
    Route::middleware(['role:admin,pastor'])->prefix('partnerships')->name('partnerships.')->group(function () {
        Route::get('/', [PartnershipController::class, 'index'])->name('index');
        Route::get('partners', [PartnershipController::class, 'partners'])->name('partners');
        Route::post('partners', [PartnershipController::class, 'storePartner'])->name('partners.store');
        Route::get('agreements', [PartnershipController::class, 'agreements'])->name('agreements');
        Route::post('agreements', [PartnershipController::class, 'storeAgreement'])->name('agreements.store');
        Route::post('agreements/{agreement}/activate', [PartnershipController::class, 'activateAgreement'])->name('agreements.activate');

        // Partner CRUD routes
        Route::get('partners/{partner}', [PartnershipController::class, 'showPartner'])->name('partners.show');
        Route::get('partners/{partner}/edit', [PartnershipController::class, 'editPartner'])->name('partners.edit');
        Route::put('partners/{partner}', [PartnershipController::class, 'updatePartner'])->name('partners.update');
        Route::delete('partners/{partner}', [PartnershipController::class, 'destroyPartner'])->name('partners.destroy');

        // Agreement CRUD routes
        Route::get('agreements/{agreement}', [PartnershipController::class, 'showAgreement'])->name('agreements.show');
        Route::get('agreements/{agreement}/edit', [PartnershipController::class, 'editAgreement'])->name('agreements.edit');
        Route::put('agreements/{agreement}', [PartnershipController::class, 'updateAgreement'])->name('agreements.update');
        Route::delete('agreements/{agreement}', [PartnershipController::class, 'destroyAgreement'])->name('agreements.destroy');
    });

    // Note: Basic QR code generation for members is available via Mobile API
    // See routes/api.php lines 324-341 for QR scan endpoints
    // See routes/api.php line 376 for personal QR generation

    // QR Code Management System (Comprehensive) - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->prefix('qr-management')->name('qr-management.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\QRManagementController::class, 'dashboard'])->name('dashboard');

        // QR Code CRUD
        Route::get('/', [App\Http\Controllers\QRManagementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\QRManagementController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\QRManagementController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\QRManagementController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [App\Http\Controllers\QRManagementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [App\Http\Controllers\QRManagementController::class, 'update'])->name('update');
        Route::delete('/{id}', [App\Http\Controllers\QRManagementController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/revoke', [App\Http\Controllers\QRManagementController::class, 'revoke'])->name('revoke');
        Route::post('/{id}/extend', [App\Http\Controllers\QRManagementController::class, 'extend'])->name('extend');

        // Analytics
        Route::get('/analytics/overview', [App\Http\Controllers\QRManagementController::class, 'analytics'])->name('analytics');

        // Settings
        Route::get('/settings/view', [App\Http\Controllers\QRManagementController::class, 'settings'])->name('settings');

        // Print
        Route::get('/print/preview', [App\Http\Controllers\QRManagementController::class, 'printPreview'])->name('print');

        // Image endpoints
        Route::get('/{id}/image', [App\Http\Controllers\QRManagementController::class, 'displayImage'])->name('image');
        Route::get('/{id}/download', [App\Http\Controllers\QRManagementController::class, 'downloadImage'])->name('download');
    });

    // Note: PWA Scanner for members is available via Mobile routes
    // See lines 745-749 for mobile PWA scanner routes
});

// ============================================================================
// END OF WEB APP ROUTES (ADMIN & PASTOR ONLY)
// ============================================================================

// ============================================================================
// PWA PUBLIC ROUTES (NO AUTH REQUIRED)
// ============================================================================

// PWA Offline and Status Routes (accessible without authentication)
Route::prefix('pwa')->name('pwa.')->group(function () {
    Route::get('/offline', [App\Http\Controllers\PWAController::class, 'offline'])->name('offline');
    Route::get('/status', [App\Http\Controllers\PWAController::class, 'status'])->name('status');
});

// ============================================================================
// MOBILE WEB API ROUTES (Session-based, must be in web.php)
// ============================================================================

// CSRF Cookie endpoint for SPA authentication
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

// Mobile web authentication endpoints (session-based, returns JSON)
Route::prefix('api/v1')->group(function () {
    // Login endpoint
    Route::post('/login-mobile', [AuthController::class, 'mobileLogin'])->middleware('throttle:5,1');

    // Authenticated endpoints
    Route::middleware(['auth'])->group(function () {
        Route::get('/user', function (Request $request) {
            return response()->json($request->user()->load('member'));
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Mobile registration endpoints (session-based)
Route::prefix('api/mobile/v1')->group(function () {
    Route::post('/verify-otp', [MobileRegistrationController::class, 'verifyOtp']);
});

// ============================================================================
// MOBILE PWA ROUTES (OUTSIDE AUTH MIDDLEWARE)
// ============================================================================

// Mobile Public Routes (NO authentication required - accessible to everyone)
Route::prefix('mobile')->name('mobile.')->group(function () {
    // Mobile home - redirects based on auth status
    Route::get('/', function () {
        return view('mobile.home');
    })->name('home');

    // Authentication pages
    Route::get('/login', function () {
        return view('mobile.login');
    })->name('login');
    Route::get('/register', function () {
        return view('mobile.register');
    })->name('register');

    // Public registration and check-in (QR Code accessible)
    Route::get('/checkin', function () {
        return view('mobile.checkin');
    })->name('checkin');
    Route::get('/check-in', function () {
        return view('mobile.checkin');
    })->name('check-in');
    Route::get('/service-checkin', function () {
        return view('mobile.service-checkin');
    })->name('service-checkin');
    Route::get('/visitor-register', function () {
        return view('mobile.visitor-register');
    })->name('visitor-register');
    Route::get('/member-register', function () {
        return view('mobile.member-register');
    })->name('member-register');

    // Public giving and payment
    Route::get('/give', function () {
        return view('mobile.give');
    })->name('give');
    Route::get('/payment', function () {
        return view('mobile.payment');
    })->name('payment');
    Route::get('/payment-success', function () {
        return view('mobile.payment-success');
    })->name('payment-success');

    // Public equipment and program pages
    Route::get('/equipment/{id}', function ($id) {
        return view('mobile.equipment', ['id' => $id]);
    })->name('equipment');
    Route::get('/program-register/{program}', function ($program) {
        return view('mobile.program-register', ['program' => $program]);
    })->name('program-register');

    // Public church info
    Route::get('/church-info', function () {
        return view('mobile.church-info');
    })->name('church-info');
});

// Mobile Authenticated Routes (protected by Laravel session auth)
Route::prefix('mobile')->name('mobile.')->middleware(['auth'])->group(function () {
    // Core member features
    Route::get('/dashboard', function () {
        return view('mobile.dashboard');
    })->name('dashboard');
    Route::get('/profile', function () {
        return view('mobile.profile');
    })->name('profile');
    Route::get('/profile-edit', function () {
        return view('mobile.profile-edit');
    })->name('profile-edit');
    Route::get('/settings', function () {
        return view('mobile.settings');
    })->name('settings');

    // Giving features (authenticated)
    Route::get('/giving', function () {
        return view('mobile.giving');
    })->name('giving');
    Route::get('/giving-history', function () {
        return view('mobile.giving-history');
    })->name('giving-history');

    // Events & Programs
    Route::get('/events', function () {
        return view('mobile.events');
    })->name('events');
    Route::get('/event-details/{id}', function ($id) {
        return view('mobile.event-details', ['id' => $id]);
    })->name('event-details');
    Route::get('/event-register/{id}', function ($id) {
        return view('mobile.event-register', ['id' => $id]);
    })->name('event-register');

    // Announcements
    Route::get('/announcements', function () {
        return view('mobile.announcements');
    })->name('announcements');

    // Attendance
    Route::get('/attendance', function () {
        return view('mobile.attendance');
    })->name('attendance');
    Route::get('/attendance-history', function () {
        return view('mobile.attendance-history');
    })->name('attendance-history');

    // Children's Ministry
    Route::get('/children-ministry', function () {
        return view('mobile.children-ministry');
    })->name('children-ministry');

    // Equipment Management
    Route::get('/equipment-management', function () {
        return view('mobile.equipment-management');
    })->name('equipment-management');

    // Shepherd Tools - Accessible to all authenticated users (API will filter based on shepherd assignment)
    Route::prefix('shepherd')->name('shepherd.')->group(function () {
        Route::get('/dashboard', function () {
            return view('mobile.shepherd.dashboard');
        })->name('dashboard');
        Route::get('/record-visit', function () {
            return view('mobile.shepherd.record-visit');
        })->name('record-visit');
        Route::get('/visit-history', function () {
            return view('mobile.shepherd.visit-history');
        })->name('visit-history');
        Route::get('/message-flock', function () {
            return view('mobile.shepherd.message-flock');
        })->name('message-flock');
        Route::get('/performance', function () {
            return view('mobile.shepherd.performance');
        })->name('performance');
    });

    // Service Unit Tools - Accessible to all authenticated users (API will filter based on unit assignment)
    Route::prefix('service-unit')->name('service-unit.')->group(function () {
        Route::get('/dashboard', function () {
            return view('mobile.service-unit.dashboard');
        })->name('dashboard');
        Route::get('/manage', function () {
            return view('mobile.service-unit.manage');
        })->name('manage');
        Route::get('/roster', function () {
            return view('mobile.service-unit.roster');
        })->name('roster');
        Route::get('/duty-tasks', function () {
            return view('mobile.service-unit.duty-tasks');
        })->name('duty-tasks');
    });

    // Ministry Units & ID Card
    Route::get('/ministry', fn() => view('mobile.ministry'))->name('ministry');
    Route::get('/id-card', fn() => view('mobile.id-card'))->name('id-card');
});
