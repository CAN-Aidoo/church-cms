<?php

namespace App\Http\Controllers;

use App\Repositories\QRCodeRepository;
use App\Services\QRManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QRManagementController extends Controller
{
    public function __construct(
        private QRManagementService $qrService,
        private QRCodeRepository $repository
    ) {
        // Use sanctum for API routes, session auth for web routes
        $this->middleware(['auth', 'role:admin,pastor']);
    }

    /**
     * Display QR management dashboard.
     */
    public function dashboard()
    {
        $stats = $this->qrService->getDashboardStatistics();
        $activeQRCodes = $this->repository->getActive();
        $expiringSoon = $this->repository->getExpiringSoon(1);

        return view('qr-management.dashboard', compact('stats', 'activeQRCodes', 'expiringSoon'));
    }

    /**
     * Display QR code generation form.
     */
    public function create()
    {
        $settings = $this->qrService->getSettings();

        return view('qr-management.create', compact('settings'));
    }

    /**
     * Generate a new QR code.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:SERVICE_ATTENDANCE,EVENT_REGISTRATION,PAYMENT,CHECK_IN,VISITOR_REGISTRATION,EQUIPMENT_CHECKOUT,VERIFICATION',
            'service_date' => 'nullable|date',
            'service_type' => 'nullable|string',
            'service_time' => 'nullable|date_format:H:i',
            'activation_time' => 'nullable|date',
            'expiration_time' => 'nullable|date|after:activation_time',
            'location_required' => 'boolean',
            'location_radius' => 'nullable|integer|min:10|max:1000',
            'max_scans' => 'nullable|integer|min:1',
            'allow_family' => 'boolean',
            'requires_verification' => 'boolean',
            'offline_allowed' => 'boolean',
            'metadata' => 'nullable|array',
        ]);

        try {
            $result = $this->qrService->generateQRCode($validated);

            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate QR code', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate QR code. Please try again.',
            ], 400);
        }
    }

    /**
     * Display QR codes list with filters.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'status', 'date_from', 'date_to', 'service_type']);
        $qrCodes = $this->repository->getPaginated($filters, 20);

        return view('qr-management.index', compact('qrCodes', 'filters'));
    }

    /**
     * Display QR code details.
     */
    public function show(string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (! $qrCode) {
            abort(404);
        }

        $scanLogs = $this->repository->getScanLogs($id, ['limit' => 50]);
        $analytics = $this->qrService->getQRAnalytics($id);

        return view('qr-management.show', compact('qrCode', 'scanLogs', 'analytics'));
    }

    /**
     * Revoke a QR code.
     */
    public function revoke(string $id)
    {
        try {
            $this->qrService->revokeQRCode($id);

            return response()->json([
                'success' => true,
                'message' => 'QR code revoked successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to revoke QR code', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to revoke QR code. Please try again.',
            ], 400);
        }
    }

    /**
     * Extend QR code expiration.
     */
    public function extend(Request $request, string $id)
    {
        $validated = $request->validate([
            'minutes' => 'required|integer|min:1|max:1440',
        ]);

        try {
            $this->qrService->extendQRCode($id, $validated['minutes']);

            return response()->json([
                'success' => true,
                'message' => 'QR code expiration extended',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to extend QR code', ['id' => $id, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to extend QR code expiration. Please try again.',
            ], 400);
        }
    }

    /**
     * Display analytics dashboard.
     */
    public function analytics(Request $request)
    {
        $stats = $this->qrService->getDashboardStatistics();
        $dateRange = [
            'start' => $request->input('start_date', now()->subDays(7)),
            'end' => $request->input('end_date', now()),
        ];

        $scanStats = $this->repository->getScanStatistics(
            \Carbon\Carbon::parse($dateRange['start']),
            \Carbon\Carbon::parse($dateRange['end'])
        );

        $recentActivity = $this->repository->getRecentActivity(20);

        return view('qr-management.analytics', compact('stats', 'scanStats', 'recentActivity', 'dateRange'));
    }

    /**
     * Get QR analytics for a specific code (AJAX).
     */
    public function getAnalytics(string $id, Request $request)
    {
        $date = $request->input('date', today());
        $analytics = $this->qrService->getQRAnalytics($id, $date);

        return response()->json($analytics);
    }

    /**
     * Display settings page.
     */
    public function settings()
    {
        $settings = $this->qrService->getSettings();

        return view('qr-management.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'required',
        ]);

        try {
            foreach ($validated['settings'] as $setting) {
                $this->qrService->updateSetting($setting['key'], $setting['value']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update QR settings', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings. Please try again.',
            ], 400);
        }
    }

    /**
     * Display print preview for QR codes.
     */
    public function printPreview(Request $request)
    {
        $qrIds = explode(',', $request->input('qr_ids'));
        $qrCodes = $this->repository->findByIds($qrIds);

        return view('qr-management.print', compact('qrCodes'));
    }

    /**
     * Get scan logs for a QR code (AJAX).
     */
    public function scanLogs(string $id, Request $request)
    {
        $filters = $request->only(['success', 'date_from', 'date_to']);
        $logs = $this->repository->getScanLogs($id, $filters);

        return response()->json($logs);
    }

    /**
     * Export QR analytics to CSV.
     */
    public function exportAnalytics(Request $request)
    {
        $dateRange = [
            'start' => $request->input('start_date', now()->subDays(30)),
            'end' => $request->input('end_date', now()),
        ];

        $stats = $this->repository->getScanStatistics(
            \Carbon\Carbon::parse($dateRange['start']),
            \Carbon\Carbon::parse($dateRange['end'])
        );

        $filename = 'qr-analytics-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($stats) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Metric', 'Value']);

            // Data
            fputcsv($file, ['Total Scans', $stats['total_scans']]);
            fputcsv($file, ['Successful Scans', $stats['successful_scans']]);
            fputcsv($file, ['Failed Scans', $stats['failed_scans']]);
            fputcsv($file, ['Unique Users', $stats['unique_users']]);
            fputcsv($file, ['Offline Syncs', $stats['offline_syncs']]);
            fputcsv($file, ['Avg Processing Time (ms)', round($stats['avg_processing_time'], 2)]);

            fputcsv($file, []);
            fputcsv($file, ['Device Breakdown', '']);
            foreach ($stats['device_breakdown'] as $device => $count) {
                fputcsv($file, [ucfirst($device), $count]);
            }

            fputcsv($file, []);
            fputcsv($file, ['Error Breakdown', '']);
            foreach ($stats['error_breakdown'] as $error => $count) {
                fputcsv($file, [$error, $count]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate batch QR codes for a service.
     */
    public function generateBatch(Request $request)
    {
        $validated = $request->validate([
            'service_date' => 'required|date',
            'service_type' => 'required|string',
            'service_time' => 'required|date_format:H:i',
            'count' => 'required|integer|min:1|max:10',
        ]);

        try {
            $qrCodes = [];

            for ($i = 0; $i < $validated['count']; $i++) {
                $config = [
                    'type' => 'SERVICE_ATTENDANCE',
                    'service_date' => $validated['service_date'],
                    'service_type' => $validated['service_type'],
                    'service_time' => $validated['service_time'],
                    'location_required' => true,
                    'offline_allowed' => true,
                ];

                $qrCodes[] = $this->qrService->generateQRCode($config);
            }

            return response()->json([
                'success' => true,
                'data' => $qrCodes,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to generate batch QR codes', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate QR codes. Please try again.',
            ], 400);
        }
    }

    /**
     * Download QR code image.
     */
    public function downloadImage(string $id, Request $request)
    {
        try {
            $size = $request->input('size', 300);
            $image = $this->qrService->generateQRImageBinary($id, $size);

            return response($image, 200)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="qr-'.$id.'.png"');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Display QR code image inline.
     */
    public function displayImage(string $id, Request $request)
    {
        try {
            $size = $request->input('size', 300);
            $image = $this->qrService->generateQRImageBinary($id, $size);

            return response($image, 200)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=3600');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Show edit form for QR code.
     */
    public function edit(string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (! $qrCode) {
            abort(404);
        }

        // Only allow editing of active or scheduled QR codes
        if (!in_array($qrCode['status'], ['active', 'scheduled'])) {
            return redirect()->route('qr-management.show', $id)
                ->with('error', 'Only active or scheduled QR codes can be edited.');
        }

        return view('qr-management.edit', compact('qrCode'));
    }

    /**
     * Update QR code.
     */
    public function update(Request $request, string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (! $qrCode) {
            abort(404);
        }

        // Only allow updating of active or scheduled QR codes
        if (!in_array($qrCode['status'], ['active', 'scheduled'])) {
            return redirect()->route('qr-management.show', $id)
                ->with('error', 'Only active or scheduled QR codes can be updated.');
        }

        $validated = $request->validate([
            'expiration_time' => 'nullable|date|after:now',
            'max_scans' => 'nullable|integer|min:1',
            'location_required' => 'boolean',
            'location_radius' => 'nullable|integer|min:10|max:1000',
            'metadata' => 'nullable|array',
        ]);

        try {
            $this->repository->update($id, $validated);

            return redirect()->route('qr-management.show', $id)
                ->with('success', 'QR code updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update QR code', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Failed to update QR code. Please try again.');
        }
    }

    /**
     * Delete QR code.
     */
    public function destroy(string $id)
    {
        $qrCode = $this->repository->findById($id);

        if (! $qrCode) {
            abort(404);
        }

        // Only allow deletion of expired or revoked QR codes
        if (!in_array($qrCode['status'], ['expired', 'revoked'])) {
            return redirect()->back()
                ->with('error', 'Only expired or revoked QR codes can be deleted. Please revoke active QR codes first.');
        }

        try {
            $this->repository->delete($id);

            return redirect()->route('qr-management.index')
                ->with('success', 'QR code deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete QR code', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'Failed to delete QR code. Please try again.');
        }
    }
}
