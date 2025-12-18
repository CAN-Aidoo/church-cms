<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\QRManagementService;
use App\Repositories\QRCodeRepository;
use Illuminate\Http\Request;

class QRScanController extends Controller
{
    public function __construct(
        private QRManagementService $qrService,
        private QRCodeRepository $repository
    ) {
        $this->middleware('auth:sanctum')->except(['validate']);
    }

    /**
     * Validate and process a QR code scan.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function scan(Request $request)
    {
        $validated = $request->validate([
            'qr_data' => 'required|string',
            'location' => 'nullable|array',
            'location.latitude' => 'required_with:location|numeric',
            'location.longitude' => 'required_with:location|numeric',
            'location.accuracy' => 'nullable|numeric',
            'device_id' => 'required|string',
            'device_type' => 'required|in:ios,android,web',
            'offline_sync' => 'boolean',
        ]);

        $scanData = [
            'user_id' => auth()->id(),
            'location' => $validated['location'] ?? null,
            'device_id' => $validated['device_id'],
            'device_type' => $validated['device_type'],
            'ip_address' => $request->ip(),
            'offline_sync' => $validated['offline_sync'] ?? false,
        ];

        try {
            $result = $this->qrService->validateAndProcessScan($validated['qr_data'], $scanData);

            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate QR code without processing (check if valid).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateQr(Request $request)
    {
        $validated = $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            $decoded = app(QRSecurityService::class)->decode($validated['qr_data']);
            $qrCode = $this->repository->findById($decoded['id']);

            if (!$qrCode) {
                return response()->json([
                    'valid' => false,
                    'error' => 'QR code not found',
                ], 404);
            }

            if ($qrCode->revoked) {
                return response()->json([
                    'valid' => false,
                    'error' => 'QR code has been revoked',
                ]);
            }

            if ($qrCode->isExpired()) {
                return response()->json([
                    'valid' => false,
                    'error' => 'QR code has expired',
                ]);
            }

            if ($qrCode->isPending()) {
                return response()->json([
                    'valid' => false,
                    'error' => 'QR code is not yet active',
                ]);
            }

            return response()->json([
                'valid' => true,
                'qr_code' => [
                    'id' => $qrCode->id,
                    'type' => $qrCode->type,
                    'service_date' => $qrCode->service_date,
                    'service_type' => $qrCode->service_type,
                    'activation_time' => $qrCode->activation_time,
                    'expiration_time' => $qrCode->expiration_time,
                    'location_required' => $qrCode->location_required,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Get user's scan history.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function history(Request $request)
    {
        $userId = auth()->id();
        $limit = $request->input('limit', 20);

        $scans = \DB::table('qr_scan_logs')
            ->join('qr_codes', 'qr_scan_logs.qr_id', '=', 'qr_codes.id')
            ->where('qr_scan_logs.user_id', $userId)
            ->select([
                'qr_scan_logs.id',
                'qr_scan_logs.scan_time',
                'qr_scan_logs.success',
                'qr_scan_logs.error_reason',
                'qr_scan_logs.scan_result',
                'qr_codes.type',
                'qr_codes.service_date',
                'qr_codes.service_type',
            ])
            ->orderBy('scan_time', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $scans,
        ]);
    }

    /**
     * Sync offline scans.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncOffline(Request $request)
    {
        $validated = $request->validate([
            'scans' => 'required|array',
            'scans.*.qr_data' => 'required|string',
            'scans.*.scan_time' => 'required|date',
            'scans.*.location' => 'nullable|array',
            'scans.*.device_id' => 'required|string',
            'scans.*.device_type' => 'required|in:ios,android,web',
        ]);

        $results = [];
        $successCount = 0;
        $failCount = 0;

        foreach ($validated['scans'] as $scan) {
            $scanData = [
                'user_id' => auth()->id(),
                'location' => $scan['location'] ?? null,
                'device_id' => $scan['device_id'],
                'device_type' => $scan['device_type'],
                'ip_address' => $request->ip(),
                'offline_sync' => true,
            ];

            try {
                $result = $this->qrService->validateAndProcessScan($scan['qr_data'], $scanData);

                if ($result['success']) {
                    $successCount++;
                } else {
                    $failCount++;
                }

                $results[] = $result;
            } catch (\Exception $e) {
                $failCount++;
                $results[] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'synced' => $successCount,
            'failed' => $failCount,
            'results' => $results,
        ]);
    }

    /**
     * Get QR code information by ID.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'error' => 'QR code not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $qrCode->id,
                'type' => $qrCode->type,
                'service_date' => $qrCode->service_date,
                'service_type' => $qrCode->service_type,
                'activation_time' => $qrCode->activation_time,
                'expiration_time' => $qrCode->expiration_time,
                'status' => $qrCode->status,
                'location_required' => $qrCode->location_required,
                'allow_family' => $qrCode->allow_family,
                'offline_allowed' => $qrCode->offline_allowed,
            ],
        ]);
    }

    /**
     * Check if user has already scanned a QR code.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasScanned(Request $request, string $id)
    {
        $userId = auth()->id();
        $hasScanned = $this->repository->hasUserScanned($id, $userId);

        return response()->json([
            'has_scanned' => $hasScanned,
        ]);
    }

    /**
     * Get active QR codes for current service.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeService(Request $request)
    {
        $date = $request->input('date', today());
        $serviceType = $request->input('service_type');

        $qrCodes = $this->repository->getForService($date, $serviceType);

        // Filter only active codes
        $active = $qrCodes->filter(fn($qr) => $qr->isActive() && !$qr->revoked);

        return response()->json([
            'success' => true,
            'data' => $active->map(fn($qr) => [
                'id' => $qr->id,
                'type' => $qr->type,
                'service_date' => $qr->service_date,
                'service_type' => $qr->service_type,
                'expiration_time' => $qr->expiration_time,
            ])->values(),
        ]);
    }

    /**
     * Report a problematic QR code.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request, string $id)
    {
        $validated = $request->validate([
            'issue' => 'required|string|max:500',
            'details' => 'nullable|string|max:1000',
        ]);

        // Log the report
        \Log::warning('QR Code Issue Reported', [
            'qr_id' => $id,
            'user_id' => auth()->id(),
            'issue' => $validated['issue'],
            'details' => $validated['details'] ?? null,
        ]);

        // Optionally create a support ticket or notification

        return response()->json([
            'success' => true,
            'message' => 'Issue reported successfully',
        ]);
    }
}
