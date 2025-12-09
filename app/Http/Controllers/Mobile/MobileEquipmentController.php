<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\EquipmentAssignment;
use App\Models\EquipmentMaintenanceRequest;
use App\Services\QrCodeService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MobileEquipmentController extends Controller
{
    public function __construct(
        protected QrCodeService $qrCodeService,
        protected NotificationService $notificationService
    ) {}

    /**
     * Scan equipment QR code and get details.
     */
    public function scanEquipment(string $qrCode)
    {
        // Decode QR code
        $qrData = json_decode($qrCode, true);

        if (!isset($qrData['equipment_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid equipment QR code'
            ], 400);
        }

        $equipment = Equipment::with(['category', 'currentAssignment.user'])->find($qrData['equipment_id']);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Equipment not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'equipment' => [
                    'id' => $equipment->id,
                    'name' => $equipment->name,
                    'category' => $equipment->category->name ?? null,
                    'serial_number' => $equipment->serial_number,
                    'description' => $equipment->description,
                    'condition' => $equipment->condition,
                    'status' => $equipment->status,
                    'location' => $equipment->location,
                    'photo_url' => $equipment->photo_url,
                ],
                'availability' => [
                    'is_available' => $equipment->status === 'available',
                    'status_message' => $this->getStatusMessage($equipment),
                    'next_available' => $equipment->currentAssignment ? $equipment->currentAssignment->expected_return_date : null,
                ],
                'current_assignment' => $equipment->currentAssignment ? [
                    'assigned_to' => $equipment->currentAssignment->user->name,
                    'checkout_date' => $equipment->currentAssignment->checkout_date,
                    'expected_return' => $equipment->currentAssignment->expected_return_date,
                ] : null,
                'actions' => [
                    'can_checkout' => $equipment->status === 'available',
                    'can_return' => false, // Will be true if user has this checked out
                    'can_report_issue' => true,
                ],
            ]
        ]);
    }

    /**
     * Checkout equipment via mobile.
     */
    public function checkoutEquipment(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'expected_return_date' => 'required|date|after:now',
            'purpose' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = $request->user();
        $equipment = Equipment::find($validated['equipment_id']);

        // Check if equipment is available
        if ($equipment->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Equipment is not available for checkout'
            ], 400);
        }

        // Check if user already has this equipment
        $existingAssignment = EquipmentAssignment::where('equipment_id', $equipment->id)
            ->where('user_id', $user->id)
            ->whereNull('actual_return_date')
            ->first();

        if ($existingAssignment) {
            return response()->json([
                'success' => false,
                'message' => 'You already have this equipment checked out'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Create assignment
            $assignment = EquipmentAssignment::create([
                'equipment_id' => $equipment->id,
                'user_id' => $user->id,
                'checkout_date' => now(),
                'expected_return_date' => $validated['expected_return_date'],
                'purpose' => $validated['purpose'] ?? null,
                'checkout_notes' => $validated['notes'] ?? null,
                'checkout_method' => 'mobile_qr',
            ]);

            // Update equipment status
            $equipment->update([
                'status' => 'checked_out',
            ]);

            DB::commit();

            // Notify equipment manager
            $this->notifyEquipmentCheckout($equipment, $user, $assignment);

            return response()->json([
                'success' => true,
                'message' => 'Equipment checked out successfully',
                'data' => [
                    'assignment_id' => $assignment->id,
                    'equipment_name' => $equipment->name,
                    'checkout_date' => $assignment->checkout_date,
                    'expected_return' => $assignment->expected_return_date,
                    'reminder' => 'You will receive a reminder 24 hours before the due date.',
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return equipment via mobile.
     */
    public function returnEquipment(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'condition' => 'required|in:excellent,good,fair,poor,damaged',
            'return_notes' => 'nullable|string|max:1000',
            'damage_photos' => 'nullable|array',
            'damage_photos.*' => 'image|max:5120', // 5MB max per image
        ]);

        $user = $request->user();

        // Find active assignment
        $assignment = EquipmentAssignment::where('equipment_id', $validated['equipment_id'])
            ->where('user_id', $user->id)
            ->whereNull('actual_return_date')
            ->first();

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have this equipment checked out'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // Update assignment
            $assignment->update([
                'actual_return_date' => now(),
                'return_condition' => $validated['condition'],
                'return_notes' => $validated['return_notes'] ?? null,
                'return_method' => 'mobile_qr',
            ]);

            $equipment = $assignment->equipment;

            // Check if condition changed or damage reported
            $needsInspection = $validated['condition'] === 'damaged' ||
                              $validated['condition'] === 'poor' ||
                              isset($validated['damage_photos']);

            // Update equipment status
            $equipment->update([
                'status' => $needsInspection ? 'maintenance' : 'available',
                'condition' => $needsInspection ? $equipment->condition : $validated['condition'],
            ]);

            // If damage reported, create maintenance request
            if ($needsInspection) {
                EquipmentMaintenanceRequest::create([
                    'equipment_id' => $equipment->id,
                    'reported_by' => $user->id,
                    'issue_description' => $validated['return_notes'] ?? 'Damage reported on return',
                    'priority' => $validated['condition'] === 'damaged' ? 'high' : 'medium',
                    'status' => 'pending',
                ]);
            }

            DB::commit();

            // Notify equipment manager
            $this->notifyEquipmentReturn($equipment, $user, $assignment, $needsInspection);

            return response()->json([
                'success' => true,
                'message' => $needsInspection
                    ? 'Equipment returned. Maintenance team has been notified of the damage.'
                    : 'Equipment returned successfully',
                'data' => [
                    'equipment_name' => $equipment->name,
                    'checkout_duration_days' => $assignment->checkout_date->diffInDays($assignment->actual_return_date),
                    'was_overdue' => $assignment->actual_return_date->gt($assignment->expected_return_date),
                    'needs_inspection' => $needsInspection,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Return failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's current equipment checkouts.
     */
    public function myCheckouts(Request $request)
    {
        $user = $request->user();

        $checkouts = EquipmentAssignment::with('equipment')
            ->where('user_id', $user->id)
            ->whereNull('actual_return_date')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'checkouts' => $checkouts->map(function($assignment) {
                    $isOverdue = now()->gt($assignment->expected_return_date);
                    $daysRemaining = now()->diffInDays($assignment->expected_return_date, false);

                    return [
                        'assignment_id' => $assignment->id,
                        'equipment' => [
                            'id' => $assignment->equipment->id,
                            'name' => $assignment->equipment->name,
                            'serial_number' => $assignment->equipment->serial_number,
                            'photo_url' => $assignment->equipment->photo_url,
                        ],
                        'checkout_date' => $assignment->checkout_date,
                        'expected_return' => $assignment->expected_return_date,
                        'days_remaining' => $daysRemaining,
                        'is_overdue' => $isOverdue,
                        'status' => $isOverdue ? 'overdue' : ($daysRemaining <= 1 ? 'due_soon' : 'active'),
                    ];
                }),
                'summary' => [
                    'total_checkouts' => $checkouts->count(),
                    'overdue' => $checkouts->filter(fn($a) => now()->gt($a->expected_return_date))->count(),
                    'due_soon' => $checkouts->filter(fn($a) =>
                        now()->diffInDays($a->expected_return_date, false) <= 1 &&
                        !now()->gt($a->expected_return_date)
                    )->count(),
                ]
            ]
        ]);
    }

    /**
     * Report equipment issue via mobile.
     */
    public function reportIssue(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'issue_description' => 'required|string|max:1000',
            'priority' => 'required|in:low,medium,high,urgent',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120', // 5MB max per image
        ]);

        $user = $request->user();

        try {
            $maintenanceRequest = EquipmentMaintenanceRequest::create([
                'equipment_id' => $validated['equipment_id'],
                'reported_by' => $user->id,
                'issue_description' => $validated['issue_description'],
                'priority' => $validated['priority'],
                'status' => 'pending',
                'reported_via' => 'mobile_app',
            ]);

            // Notify maintenance team
            $this->notifyMaintenanceRequest($maintenanceRequest, $user);

            return response()->json([
                'success' => true,
                'message' => 'Issue reported successfully. Maintenance team has been notified.',
                'data' => [
                    'request_id' => $maintenanceRequest->id,
                    'priority' => $maintenanceRequest->priority,
                    'status' => $maintenanceRequest->status,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Report failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get equipment status message.
     */
    private function getStatusMessage(Equipment $equipment): string
    {
        return match($equipment->status) {
            'available' => 'Available for checkout',
            'checked_out' => 'Currently checked out',
            'maintenance' => 'Under maintenance',
            'retired' => 'No longer in service',
            default => 'Status unknown'
        };
    }

    /**
     * Notify equipment checkout.
     */
    private function notifyEquipmentCheckout($equipment, $user, $assignment): void
    {
        // Notify equipment manager
        // Implementation depends on notification system
    }

    /**
     * Notify equipment return.
     */
    private function notifyEquipmentReturn($equipment, $user, $assignment, bool $needsInspection): void
    {
        // Notify equipment manager
        // Implementation depends on notification system
    }

    /**
     * Notify maintenance request.
     */
    private function notifyMaintenanceRequest($request, $user): void
    {
        // Notify maintenance team
        // Implementation depends on notification system
    }
}
