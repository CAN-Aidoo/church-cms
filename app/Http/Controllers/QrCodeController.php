<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Program;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService
    ) {}

    /**
     * Display QR code management dashboard.
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_checkins_today' => \App\Models\Attendance::whereDate('service_date', today())->count(),
            'active_service_codes' => \Illuminate\Support\Facades\Cache::get('active_service_qr_count', 0),
            'registrations_today' => \App\Models\Visitor::whereDate('created_at', today())->count(),
        ];

        return view('qr-codes.index', compact('stats'));
    }

    /**
     * Generate and display service check-in QR code.
     */
    public function serviceQrCode(Request $request)
    {
        $serviceDate = $request->input('service_date', now()->format('Y-m-d'));
        $serviceType = $request->input('service_type', 'sunday_first');

        $qrData = $this->qrCodeService->generateServiceCheckInCode($serviceDate, $serviceType);

        // Track active service codes
        \Illuminate\Support\Facades\Cache::increment('active_service_qr_count');

        return view('qr-codes.service', [
            'qrData' => $qrData,
            'serviceDate' => $serviceDate,
            'serviceType' => $serviceType,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Display member registration QR code.
     */
    public function memberRegistration()
    {
        $qrData = $this->qrCodeService->generateMemberRegistrationCode();

        return view('qr-codes.member-registration', [
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Display visitor registration QR code.
     */
    public function visitorRegistration()
    {
        $qrData = $this->qrCodeService->generateVisitorRegistrationCode();

        return view('qr-codes.visitor-registration', [
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Generate payment QR code.
     */
    public function payment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'nullable|numeric|min:0',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $qrData = $this->qrCodeService->generatePaymentCode([
            'amount' => $validated['amount'] ?? null,
            'category' => $validated['category'] ?? 'offering',
            'description' => $validated['description'] ?? 'Offering',
        ]);

        return view('qr-codes.payment', [
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
            'amount' => $validated['amount'] ?? null,
            'category' => $validated['category'] ?? 'offering',
        ]);
    }

    /**
     * Display equipment tracking QR code.
     */
    public function equipment(Equipment $equipment)
    {
        $qrData = $this->qrCodeService->generateEquipmentCode($equipment);

        return view('qr-codes.equipment', [
            'equipment' => $equipment,
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Generate program registration QR code.
     */
    public function programRegistration(Program $program)
    {
        $qrData = $this->qrCodeService->generateProgramRegistrationCode($program);

        return view('qr-codes.program-registration', [
            'program' => $program,
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Generate personal member QR code (for authenticated members).
     */
    public function personal()
    {
        $member = Auth::user()->member;

        if (! $member) {
            return redirect()->back()->with('error', 'Member profile not found.');
        }

        $qrData = $this->qrCodeService->generateMemberCheckInCode($member);

        return view('qr-codes.personal', [
            'member' => $member,
            'qrData' => $qrData,
            'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
        ]);
    }

    /**
     * Bulk download QR codes for members.
     */
    public function bulkDownload(Request $request)
    {
        $validated = $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
        ]);

        $members = \App\Models\Member::whereIn('id', $validated['member_ids'])->get();
        $qrCodes = [];

        foreach ($members as $member) {
            $qrData = $this->qrCodeService->generateMemberCheckInCode($member);
            $qrCodes[] = [
                'member' => $member,
                'qrData' => $qrData,
                'qrImageUrl' => $this->qrCodeService->generateQrImageUrl($qrData['data']),
            ];
        }

        return view('qr-codes.bulk-download', compact('qrCodes'));
    }
}
