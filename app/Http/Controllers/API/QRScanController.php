<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\QRCodeRepository;
use App\Services\QRManagementService;
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

            if (! $qrCode) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (! $qrCode) {
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function activeService(Request $request)
    {
        $date = $request->input('date', today());
        $serviceType = $request->input('service_type');

        $qrCodes = $this->repository->getForService($date, $serviceType);

        // Filter only active codes
        $active = $qrCodes->filter(fn ($qr) => $qr->isActive() && ! $qr->revoked);

        return response()->json([
            'success' => true,
            'data' => $active->map(fn ($qr) => [
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

    /**
     * Process a QR code scan (PWA scanner endpoint).
     * This is the main endpoint used by the PWA scanner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string',
            'scanned_at' => 'nullable|date',
            'location' => 'nullable|array',
            'location.latitude' => 'required_with:location|numeric',
            'location.longitude' => 'required_with:location|numeric',
            'location.accuracy' => 'nullable|numeric',
            'location.timestamp' => 'nullable|integer',
            'device_info' => 'nullable|array',
            'device_info.userAgent' => 'nullable|string',
            'device_info.platform' => 'nullable|string',
            'device_info.online' => 'nullable|boolean',
        ]);

        $scanData = [
            'user_id' => auth()->id(),
            'location' => $validated['location'] ?? null,
            'device_id' => $validated['device_info']['userAgent'] ?? $request->header('User-Agent'),
            'device_type' => $this->detectDeviceType($request),
            'ip_address' => $request->ip(),
            'offline_sync' => !($validated['device_info']['online'] ?? true),
            'scanned_at' => $validated['scanned_at'] ?? now(),
        ];

        try {
            $result = $this->qrService->validateAndProcessScan($validated['qr_code'], $scanData);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'QR code processed successfully',
                    'data' => $result['data'] ?? null,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['error'] ?? 'Failed to process QR code',
                    'errors' => $result['errors'] ?? [],
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('QR Scan Process Error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing the QR code',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }

    /**
     * Batch sync offline QR scans (PWA scanner endpoint).
     * This endpoint is called by the service worker to sync offline scans.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchSync(Request $request)
    {
        $validated = $request->validate([
            'scans' => 'required|array',
            'scans.*.qr_code' => 'required|string',
            'scans.*.scanned_at' => 'required|date',
            'scans.*.location' => 'nullable|array',
            'scans.*.location.latitude' => 'required_with:scans.*.location|numeric',
            'scans.*.location.longitude' => 'required_with:scans.*.location|numeric',
            'scans.*.device_info' => 'nullable|array',
            'scans.*.queued_at' => 'nullable|date',
        ]);

        $results = [];
        $successCount = 0;
        $failCount = 0;

        foreach ($validated['scans'] as $index => $scan) {
            $scanData = [
                'user_id' => auth()->id(),
                'location' => $scan['location'] ?? null,
                'device_id' => $scan['device_info']['userAgent'] ?? $request->header('User-Agent'),
                'device_type' => $this->detectDeviceType($request),
                'ip_address' => $request->ip(),
                'offline_sync' => true,
                'scanned_at' => $scan['scanned_at'],
                'queued_at' => $scan['queued_at'] ?? null,
            ];

            try {
                $result = $this->qrService->validateAndProcessScan($scan['qr_code'], $scanData);

                if ($result['success']) {
                    $successCount++;
                    $results[] = [
                        'index' => $index,
                        'success' => true,
                        'message' => 'Synced successfully',
                    ];
                } else {
                    $failCount++;
                    $results[] = [
                        'index' => $index,
                        'success' => false,
                        'message' => $result['error'] ?? 'Failed to sync',
                    ];
                }
            } catch (\Exception $e) {
                $failCount++;
                $results[] = [
                    'index' => $index,
                    'success' => false,
                    'message' => $e->getMessage(),
                ];

                \Log::error('Batch Sync Error', [
                    'user_id' => auth()->id(),
                    'scan_index' => $index,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Synced {$successCount} of " . count($validated['scans']) . ' scans',
            'synced' => $successCount,
            'failed' => $failCount,
            'total' => count($validated['scans']),
            'results' => $results,
        ], 200);
    }

    /**
     * Get scanner configuration for the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function config(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'config' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'permissions' => [
                    'can_scan_attendance' => in_array($user->role, ['admin', 'pastor', 'staff']),
                    'can_scan_payment' => in_array($user->role, ['admin', 'pastor', 'staff']),
                    'can_scan_equipment' => in_array($user->role, ['admin', 'pastor', 'staff']),
                    'can_scan_member' => in_array($user->role, ['admin', 'pastor', 'staff']),
                ],
                'settings' => [
                    'enable_gps' => true,
                    'enable_sound' => true,
                    'enable_vibration' => true,
                    'fps' => 10,
                    'qrbox_size' => 250,
                    'offline_mode' => true,
                    'auto_sync' => true,
                ],
                'endpoints' => [
                    'process' => route('api.qr-scan.process'),
                    'batch_sync' => route('api.qr-scan.batch-sync'),
                    'validate' => route('api.qr-scan.validate'),
                    'history' => route('api.qr-scan.history'),
                ],
            ],
        ]);
    }

    /**
     * Preview/validate a QR code without processing it.
     * Returns detailed information for user confirmation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => 'required|string',
        ]);

        try {
            // Decode QR code
            $decoded = app(\App\Services\QRSecurityService::class)->decode($validated['qr_code']);
            $qrCode = $this->repository->findById($decoded['id']);

            if (!$qrCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR code not found',
                    'error' => 'invalid_qr',
                ], 404);
            }

            // Check status
            if ($qrCode->revoked) {
                return response()->json([
                    'success' => false,
                    'message' => 'This QR code has been revoked and is no longer valid',
                    'error' => 'revoked',
                ], 400);
            }

            if ($qrCode->isExpired()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This QR code has expired',
                    'error' => 'expired',
                    'expired_at' => $qrCode->expiration_time,
                ], 400);
            }

            if ($qrCode->isPending()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This QR code is not yet active',
                    'error' => 'pending',
                    'activation_time' => $qrCode->activation_time,
                ], 400);
            }

            // Check if already scanned
            $hasScanned = $this->repository->hasUserScanned($qrCode->id, auth()->id());

            // Return preview information
            return response()->json([
                'success' => true,
                'message' => 'QR code is valid',
                'data' => [
                    'type' => $qrCode->type,
                    'type_label' => ucwords(str_replace('_', ' ', $qrCode->type)),
                    'service_date' => $qrCode->service_date,
                    'service_type' => $qrCode->service_type,
                    'location_required' => $qrCode->location_required,
                    'already_scanned' => $hasScanned,
                    'can_rescan' => !$hasScanned || $qrCode->allow_multiple,
                    'expires_at' => $qrCode->expiration_time,
                    'description' => $this->getQRDescription($qrCode),
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('QR Preview Error', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code format',
                'error' => 'decode_error',
            ], 400);
        }
    }

    /**
     * Detect device type from request.
     *
     * @return string
     */
    private function detectDeviceType(Request $request): string
    {
        $userAgent = $request->header('User-Agent', '');

        if (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) {
            return 'ios';
        } elseif (stripos($userAgent, 'Android') !== false) {
            return 'android';
        } else {
            return 'web';
        }
    }

    /**
     * Get human-readable description for QR code.
     *
     * @param  \App\Models\QRCode  $qrCode
     * @return string
     */
    private function getQRDescription($qrCode): string
    {
        $descriptions = [
            'service_attendance' => 'Check in for ' . ($qrCode->service_type ?? 'service') . ' on ' . $qrCode->service_date->format('M d, Y'),
            'member_registration' => 'Member registration QR code',
            'visitor_registration' => 'Visitor registration QR code',
            'payment' => 'Payment QR code for offerings/tithes',
            'equipment' => 'Equipment tracking QR code',
            'program_registration' => 'Event/Program registration QR code',
        ];

        return $descriptions[$qrCode->type] ?? 'General QR code';
    }
}
