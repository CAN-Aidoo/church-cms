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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServicePlanningController;
use App\Http\Controllers\ServiceUnitController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShepherdController;
use App\Http\Controllers\SmsBroadcastController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WelfareController;
use App\Http\Controllers\Mobile\MobileCheckInController;
use App\Http\Controllers\Mobile\MobileChildrensController;
use App\Http\Controllers\Mobile\MobileContentController;
use App\Http\Controllers\Mobile\MobileEquipmentController;
use App\Http\Controllers\Mobile\MobilePaymentController;
use App\Http\Controllers\Mobile\MobileRegistrationController;
use App\Http\Controllers\Mobile\MobileServiceUnitController;
use App\Http\Controllers\Mobile\MobileShepherdController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes (No Authentication)
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/login', [AuthController::class, 'apiLogin'])->middleware('throttle:5,1');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:3,1');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:3,1');
});

// Authenticated API Routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user()->load('member');
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/charts', [DashboardController::class, 'charts']);
    Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);

    // Notifications - All users
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unread']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{notification}', [NotificationController::class, 'destroy']);
        Route::get('/preferences', [NotificationController::class, 'preferences']);
        Route::put('/preferences', [NotificationController::class, 'updatePreferences']);
    });

    // Member Portal API - All authenticated users (self-service)
    Route::prefix('my')->group(function () {
        Route::get('/profile', [MemberController::class, 'getMyProfile']);
        Route::put('/profile', [MemberController::class, 'updateMyProfile']);
        Route::get('/attendance', [MemberController::class, 'getMyAttendance']);
        Route::get('/contributions', [MemberController::class, 'getMyContributions']);
        Route::get('/programs', [MemberController::class, 'getMyPrograms']);
        Route::get('/ministry', [MemberController::class, 'getMyMinistry']);
        Route::get('/shepherd', [MemberController::class, 'getMyShepherd']);
        Route::get('/family', [MemberController::class, 'getMyFamily']);
        Route::get('/documents', [MemberController::class, 'getMyDocuments']);
        Route::get('/documents/{documentId}/download', [MemberController::class, 'downloadDocument'])->name('api.member.documents.download');
        Route::get('/upcoming-events', [MemberController::class, 'getMyUpcomingEvents']);
    });

    // Members API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'index']);
        Route::post('/', [MemberController::class, 'store']);
        Route::get('/search', [MemberController::class, 'search']);
        Route::get('/statistics', [MemberController::class, 'statistics']);
        Route::get('/export', [MemberController::class, 'export']);
        Route::get('/{member}', [MemberController::class, 'show']);
        Route::put('/{member}', [MemberController::class, 'update']);
        Route::delete('/{member}', [MemberController::class, 'destroy']);
        Route::post('/{member}/photo', [MemberController::class, 'uploadPhoto']);
        Route::delete('/{member}/photo', [MemberController::class, 'deletePhoto']);
        Route::post('/bulk-action', [MemberController::class, 'bulkAction']);
    });

    // Attendance API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index']);
        Route::post('/', [AttendanceController::class, 'store']);
        Route::post('/bulk', [AttendanceController::class, 'bulkStore']);
        Route::get('/reports', [AttendanceController::class, 'reports']);
        Route::get('/leaderboard', [AttendanceController::class, 'leaderboard']);
        Route::get('/export', [AttendanceController::class, 'export']);
        Route::get('/{attendance}', [AttendanceController::class, 'show']);
        Route::put('/{attendance}', [AttendanceController::class, 'update']);
        Route::delete('/{attendance}', [AttendanceController::class, 'destroy']);
    });

    // Transactions API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('/', [TransactionController::class, 'store']);
        Route::get('/reports', [TransactionController::class, 'reports']);
        Route::get('/export', [TransactionController::class, 'export']);
        Route::get('/pending', [TransactionController::class, 'pending'])->middleware(['role:admin,pastor']);
        Route::get('/{transaction}', [TransactionController::class, 'show']);
        Route::put('/{transaction}', [TransactionController::class, 'update']);
        Route::post('/{transaction}/approve', [TransactionController::class, 'approve'])->middleware(['role:admin,pastor']);
        Route::post('/{transaction}/reject', [TransactionController::class, 'reject'])->middleware(['role:admin,pastor']);
        Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->middleware(['role:admin']);

        // Financial Dashboard Analytics
        Route::get('/analytics/dashboard-summary', [TransactionController::class, 'getDashboardSummary']);
        Route::get('/analytics/cash-flow', [TransactionController::class, 'getCashFlow']);
        Route::get('/analytics/budget-analysis', [TransactionController::class, 'getBudgetAnalysis']);
        Route::get('/analytics/giving-analytics', [TransactionController::class, 'getGivingAnalytics']);
        Route::get('/analytics/expense-analytics', [TransactionController::class, 'getExpenseAnalytics']);
        Route::get('/analytics/forecasting', [TransactionController::class, 'getForecasting']);
    });

    // Visitors API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('visitors')->group(function () {
        Route::get('/', [VisitorController::class, 'index']);
        Route::post('/', [VisitorController::class, 'store']);
        Route::get('/eligible', [VisitorController::class, 'eligible']);
        Route::get('/follow-up', [VisitorController::class, 'followUp']);
        Route::get('/reports', [VisitorController::class, 'reports']);
        Route::get('/{visitor}', [VisitorController::class, 'show']);
        Route::put('/{visitor}', [VisitorController::class, 'update']);
        Route::delete('/{visitor}', [VisitorController::class, 'destroy']);
        Route::post('/{visitor}/record-visit', [VisitorController::class, 'recordVisit']);
        Route::post('/{visitor}/convert', [VisitorController::class, 'convert']);
    });

    // SMS Broadcast API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('sms')->group(function () {
        Route::get('/', [SmsBroadcastController::class, 'index']);
        Route::post('/', [SmsBroadcastController::class, 'store']);
        Route::get('/{broadcast}', [SmsBroadcastController::class, 'show']);
        Route::post('/{broadcast}/send', [SmsBroadcastController::class, 'send']);
        Route::get('/{broadcast}/status', [SmsBroadcastController::class, 'status']);

        // Enhanced SMS features
        Route::get('/templates/list', [SmsBroadcastController::class, 'getTemplates']);
        Route::post('/preview', [SmsBroadcastController::class, 'previewMessage']);
        Route::get('/stats/delivery', [SmsBroadcastController::class, 'deliveryStats']);
        Route::post('/validate/phones', [SmsBroadcastController::class, 'validatePhones']);
        Route::post('/message/info', [SmsBroadcastController::class, 'getMessageInfo']);
    });

    // Programs API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('programs')->group(function () {
        Route::get('/', [ProgramController::class, 'index']);
        Route::post('/', [ProgramController::class, 'store']);
        Route::get('/{program}', [ProgramController::class, 'show']);
        Route::put('/{program}', [ProgramController::class, 'update']);
        Route::delete('/{program}', [ProgramController::class, 'destroy']);
        Route::post('/{program}/publish', [ProgramController::class, 'publish']);
        Route::post('/{program}/start', [ProgramController::class, 'start']);
        Route::post('/{program}/complete', [ProgramController::class, 'complete']);
        Route::post('/{program}/cancel', [ProgramController::class, 'cancel']);
        Route::get('/{program}/registrations', [ProgramController::class, 'manageRegistrations']);
        Route::post('/registrations/{registration}/check-in', [ProgramController::class, 'checkIn']);
        Route::get('/{program}/analytics', [ProgramController::class, 'analytics']);
    });

    // Program Registration - All authenticated users
    Route::post('/programs/{program}/register', [ProgramController::class, 'register']);

    // Prayer Requests API
    Route::prefix('prayer')->group(function () {
        // All authenticated users can create and view prayer requests
        Route::get('/wall', [PrayerController::class, 'prayerWall']);
        Route::get('/my-requests', [PrayerController::class, 'myRequests']);
        Route::post('/', [PrayerController::class, 'store']);
        Route::get('/{prayerRequest}', [PrayerController::class, 'show']);
        Route::put('/{prayerRequest}', [PrayerController::class, 'update']);
        Route::delete('/{prayerRequest}', [PrayerController::class, 'destroy']);

        // Staff and above
        Route::middleware(['role:admin,pastor,staff'])->group(function () {
            Route::get('/', [PrayerController::class, 'index']);
            Route::get('/analytics', [PrayerController::class, 'analytics']);
            Route::post('/{prayerRequest}/assign', [PrayerController::class, 'assign']);
            Route::post('/{prayerRequest}/add-update', [PrayerController::class, 'addUpdate']);
            Route::post('/{prayerRequest}/mark-answered', [PrayerController::class, 'markAnswered']);
            Route::get('/testimonies', [PrayerController::class, 'testimonies']);
        });
    });

    // Birthdays API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('birthdays')->group(function () {
        Route::get('/', [BirthdayController::class, 'index']);
        Route::get('/calendar', [BirthdayController::class, 'calendar']);
        Route::get('/history', [BirthdayController::class, 'history']);
        Route::get('/milestones', [BirthdayController::class, 'milestones']);
        Route::post('/milestones/{milestone}/recognize', [BirthdayController::class, 'recognizeMilestone']);

        // Advanced automation features
        Route::get('/analytics', [BirthdayController::class, 'analytics']);
        Route::get('/upcoming-celebrations', [BirthdayController::class, 'upcomingCelebrations']);
        Route::post('/generate-announcements', [BirthdayController::class, 'generateAnnouncements']);
        Route::post('/test-workflow', [BirthdayController::class, 'testWorkflow']);
        Route::get('/schedule-preview', [BirthdayController::class, 'schedulePreview']);
        Route::post('/bulk-schedule', [BirthdayController::class, 'bulkSchedule']);
        Route::get('/recognition-suggestions', [BirthdayController::class, 'recognitionSuggestions']);

        // Admin only
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/process', [BirthdayController::class, 'processBirthdays']);
            Route::post('/retry-failed', [BirthdayController::class, 'retryFailed']);
        });
    });

    // Reports API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::get('/analytics', [ReportController::class, 'analytics']);
        Route::post('/custom', [ReportController::class, 'storeCustomReport']);
        Route::get('/custom/{report}', [ReportController::class, 'showCustomReport']);
        Route::put('/custom/{report}', [ReportController::class, 'updateCustomReport']);
        Route::delete('/custom/{report}', [ReportController::class, 'deleteCustomReport']);

        // Advanced reporting features
        Route::post('/preview', [ReportController::class, 'previewReport']);
        Route::get('/fields', [ReportController::class, 'getAvailableFields']);
        Route::get('/operators', [ReportController::class, 'getFilterOperators']);
        Route::post('/validate', [ReportController::class, 'validateReportConfig']);

        Route::post('/export/pdf', [ReportController::class, 'exportPdf']);
        Route::post('/export/excel', [ReportController::class, 'exportExcel']);
        Route::post('/export/csv', [ReportController::class, 'exportCsv']);
    });

    // Messaging API - All authenticated users
    Route::prefix('messaging')->group(function () {
        Route::get('/conversations', [MessagingController::class, 'index']);
        Route::post('/direct', [MessagingController::class, 'startDirectConversation']);
        Route::post('/groups', [MessagingController::class, 'createGroup']);
        Route::get('/conversations/{conversation}', [MessagingController::class, 'showConversation']);
        Route::get('/conversations/{conversation}/messages', [MessagingController::class, 'getMessages']);
        Route::post('/conversations/{conversation}/messages', [MessagingController::class, 'sendMessage']);
        Route::post('/conversations/{conversation}/mark-read', [MessagingController::class, 'markAsRead']);
        Route::put('/messages/{message}', [MessagingController::class, 'editMessage']);
        Route::delete('/messages/{message}', [MessagingController::class, 'deleteMessage']);
        Route::post('/messages/{message}/reactions', [MessagingController::class, 'reactToMessage']);
        Route::post('/messages/{message}/star', [MessagingController::class, 'starMessage']);
        Route::get('/search', [MessagingController::class, 'search']);
    });

    // Shepherds API - Pastor and Admin only
    Route::middleware(['role:admin,pastor'])->prefix('shepherds')->group(function () {
        Route::get('/', [ShepherdController::class, 'index']);
        Route::post('/', [ShepherdController::class, 'store']);
        Route::get('/analytics', [ShepherdController::class, 'analytics']);
        Route::post('/auto-assign', [ShepherdController::class, 'autoAssign']);
        Route::get('/{shepherd}', [ShepherdController::class, 'show']);
        Route::put('/{shepherd}', [ShepherdController::class, 'update']);
        Route::delete('/{shepherd}', [ShepherdController::class, 'destroy']);
        Route::post('/{shepherd}/assign-member', [ShepherdController::class, 'assignMember']);
        Route::post('/{shepherd}/unassign-member', [ShepherdController::class, 'unassignMember']);
    });

    // Service Units API - Staff and above
    Route::middleware(['role:admin,pastor,staff'])->prefix('service-units')->group(function () {
        Route::get('/', [ServiceUnitController::class, 'index']);
        Route::post('/', [ServiceUnitController::class, 'store']);
        Route::get('/analytics', [ServiceUnitController::class, 'analytics']);
        Route::get('/{serviceUnit}', [ServiceUnitController::class, 'show']);
        Route::put('/{serviceUnit}', [ServiceUnitController::class, 'update']);
        Route::delete('/{serviceUnit}', [ServiceUnitController::class, 'destroy']);
        Route::post('/{serviceUnit}/add-member', [ServiceUnitController::class, 'addMember']);
        Route::delete('/{serviceUnit}/remove-member', [ServiceUnitController::class, 'removeMember']);
    });

    // Settings API - Admin only
    Route::middleware(['role:admin'])->prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index']);
        Route::put('/general', [SettingsController::class, 'updateGeneral']);
        Route::get('/email-templates', [SettingsController::class, 'emailTemplates']);
        Route::put('/email-templates/{template}', [SettingsController::class, 'updateEmailTemplate']);
        Route::get('/audit-logs', [SettingsController::class, 'auditLogs']);
        Route::get('/system-info', [SettingsController::class, 'systemInfo']);
        Route::post('/clear-cache', [SettingsController::class, 'clearCache']);
    });

    // QR Code Management API - Admin and Pastor only
    Route::middleware(['role:admin,pastor'])->prefix('qr-management')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\QRManagementController::class, 'dashboard']);
        Route::get('/', [App\Http\Controllers\QRManagementController::class, 'index']);
        Route::get('/create', [App\Http\Controllers\QRManagementController::class, 'create']);
        Route::post('/', [App\Http\Controllers\QRManagementController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\QRManagementController::class, 'show']);
        Route::post('/{id}/revoke', [App\Http\Controllers\QRManagementController::class, 'revoke']);
        Route::post('/{id}/extend', [App\Http\Controllers\QRManagementController::class, 'extend']);
        Route::get('/analytics/overview', [App\Http\Controllers\QRManagementController::class, 'analytics']);
        Route::get('/{id}/analytics', [App\Http\Controllers\QRManagementController::class, 'getAnalytics']);
        Route::get('/{id}/scan-logs', [App\Http\Controllers\QRManagementController::class, 'scanLogs']);
        Route::get('/settings/view', [App\Http\Controllers\QRManagementController::class, 'settings']);
        Route::put('/settings/update', [App\Http\Controllers\QRManagementController::class, 'updateSettings']);
        Route::get('/print/preview', [App\Http\Controllers\QRManagementController::class, 'printPreview']);
        Route::get('/export/analytics', [App\Http\Controllers\QRManagementController::class, 'exportAnalytics']);
        Route::post('/batch/generate', [App\Http\Controllers\QRManagementController::class, 'generateBatch']);
    });

    // QR Code Scan API - All authenticated users
    Route::prefix('qr-scan')->group(function () {
        Route::post('/scan', [App\Http\Controllers\API\QRScanController::class, 'scan']);
        Route::post('/validate', [App\Http\Controllers\API\QRScanController::class, 'validateQr']);
        Route::get('/history', [App\Http\Controllers\API\QRScanController::class, 'history']);
        Route::post('/sync-offline', [App\Http\Controllers\API\QRScanController::class, 'syncOffline']);
        Route::get('/{id}/info', [App\Http\Controllers\API\QRScanController::class, 'info']);
        Route::get('/{id}/has-scanned', [App\Http\Controllers\API\QRScanController::class, 'hasScanned']);
        Route::get('/active-service', [App\Http\Controllers\API\QRScanController::class, 'activeService']);
        Route::post('/{id}/report', [App\Http\Controllers\API\QRScanController::class, 'report']);
    });
});

// Mobile API Routes
Route::prefix('mobile/v1')->group(function () {
    // PUBLIC MOBILE ROUTES (No Authentication Required)

    // Mobile Registration & Authentication
    Route::post('/register/member', [MobileRegistrationController::class, 'registerMember']);
    Route::post('/register/visitor', [MobileRegistrationController::class, 'registerVisitor']);
    Route::post('/verify-otp', [MobileRegistrationController::class, 'verifyOtp']);
    Route::post('/resend-otp', [MobileRegistrationController::class, 'resendOtp']);

    // QR Code Check-in (Public)
    Route::post('/check-in/member', [MobileCheckInController::class, 'memberCheckIn']);
    Route::post('/check-in/service', [MobileCheckInController::class, 'serviceCheckIn']);
    Route::post('/check-in/family', [MobileCheckInController::class, 'familyCheckIn']);

    // AUTHENTICATED MOBILE ROUTES (Requires Token)
    Route::middleware(['auth:sanctum'])->group(function () {
        // Registration Status
        Route::get('/registration/status', [MobileRegistrationController::class, 'checkStatus']);

        // QR Code Generation
        Route::get('/qr-code/personal', [MobileCheckInController::class, 'generatePersonalQr']);

        // Mobile Payment
        Route::post('/payment/initiate', [MobilePaymentController::class, 'initiatePayment']);
        Route::post('/payment/verify', [MobilePaymentController::class, 'verifyPayment']);
        Route::get('/payment/qr-details', [MobilePaymentController::class, 'getPaymentQrDetails']);
        Route::post('/payment/recurring/setup', [MobilePaymentController::class, 'setupRecurringPayment']);
        Route::get('/payment/history', [MobilePaymentController::class, 'paymentHistory']);

        // Equipment Management (Mobile)
        Route::get('/equipment/scan/{qrCode}', [MobileEquipmentController::class, 'scanEquipment']);
        Route::post('/equipment/checkout', [MobileEquipmentController::class, 'checkoutEquipment']);
        Route::post('/equipment/return', [MobileEquipmentController::class, 'returnEquipment']);
        Route::get('/equipment/my-checkouts', [MobileEquipmentController::class, 'myCheckouts']);
        Route::post('/equipment/report-issue', [MobileEquipmentController::class, 'reportIssue']);

        // Shepherd Mobile Tools
        Route::prefix('shepherd')->group(function () {
            Route::get('/flock', [MobileShepherdController::class, 'getMyFlock']);
            Route::post('/visit/record', [MobileShepherdController::class, 'recordVisit']);
            Route::get('/visit/history', [MobileShepherdController::class, 'visitHistory']);
            Route::post('/flock/message', [MobileShepherdController::class, 'messageFlock']);
            Route::get('/performance', [MobileShepherdController::class, 'getPerformanceDashboard']);
        });

    // Service Unit Leader Routes
    Route::prefix('service-unit')->group(function () {
        Route::get('/my-units', [MobileServiceUnitController::class, 'getMyUnits']);
        
        // Leader Management Routes
        Route::get('/{serviceUnit}/details', [MobileServiceUnitController::class, 'show']);
        Route::get('/{serviceUnit}/members', [MobileServiceUnitController::class, 'getMembers']);
        Route::post('/{serviceUnit}/members', [MobileServiceUnitController::class, 'addMember']);
        Route::get('/{serviceUnit}/rosters', [MobileServiceUnitController::class, 'getRosters']);
        Route::post('/{serviceUnit}/rosters', [MobileServiceUnitController::class, 'createRoster']);
    });

    // Children's Ministry Mobile
    Route::prefix('children')->group(function () {
            Route::post('/check-in', [MobileChildrensController::class, 'checkIn']);
            Route::post('/check-out', [MobileChildrensController::class, 'checkOut']);
            Route::get('/my-children', [MobileChildrensController::class, 'getMyChildren']);
            Route::post('/security-code/generate', [MobileChildrensController::class, 'generateSecurityCode']);
            Route::post('/incident/report', [MobileChildrensController::class, 'reportIncident']);
            Route::get('/attendance-history', [MobileChildrensController::class, 'getChildAttendanceHistory']);
        });

        // Announcements & Public Info
        Route::get('/announcements', [MobileContentController::class, 'getAnnouncements']);
        Route::get('/service-times', [MobileContentController::class, 'getServiceTimes']);
        Route::get('/church-info', [MobileContentController::class, 'getChurchInfo']);
        Route::get('/events/upcoming', [MobileContentController::class, 'getUpcomingEvents']);
        Route::get('/events/{eventId}', [MobileContentController::class, 'getEventDetails']);
        Route::get('/search', [MobileContentController::class, 'search']);
    });

    // Payment Callback (Webhook from Payment Gateway)
    Route::post('/payment/callback', [MobilePaymentController::class, 'paymentCallback'])->name('api.mobile.payment.callback');
});
