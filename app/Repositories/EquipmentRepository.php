<?php

namespace App\Repositories;

use App\Models\Equipment;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EquipmentRepository
{
    /**
     * Get paginated equipment with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Equipment::query();

        // Apply category filter
        if (isset($filters['category']) && $filters['category'] !== '') {
            $query->where('category', $filters['category']);
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Apply condition filter
        if (isset($filters['condition']) && $filters['condition'] !== '') {
            $query->where('condition', $filters['condition']);
        }

        // Apply location filter
        if (isset($filters['location']) && $filters['location'] !== '') {
            $query->where('location', 'like', "%{$filters['location']}%");
        }

        // Apply date range filter
        if (isset($filters['date_from'])) {
            $query->where('purchase_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('purchase_date', '<=', $filters['date_to']);
        }

        // Apply search filter
        if (isset($filters['search']) && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Find equipment by ID.
     */
    public function findById(int $id): ?Equipment
    {
        return Equipment::find($id);
    }

    /**
     * Create equipment.
     */
    public function create(array $data): Equipment
    {
        return Equipment::create($data);
    }

    /**
     * Update equipment.
     */
    public function update(Equipment $equipment, array $data): bool
    {
        return $equipment->update($data);
    }

    /**
     * Delete equipment.
     */
    public function delete(Equipment $equipment): bool
    {
        return $equipment->delete();
    }

    /**
     * Get equipment statistics.
     */
    public function getStatistics(array $filters = []): array
    {
        $query = Equipment::query();

        // Apply date range
        if (isset($filters['date_from'])) {
            $query->where('purchase_date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to'])) {
            $query->where('purchase_date', '<=', $filters['date_to']);
        }

        $total = (clone $query)->count();
        $activeCount = (clone $query)->where('member_status', 'active')->count();
        $maintenanceCount = (clone $query)->where('status', 'maintenance')->count();
        $retiredCount = (clone $query)->where('status', 'retired')->count();

        $totalValue = (clone $query)->sum('purchase_price');
        $averageAge = (clone $query)->avg(DB::raw('DATEDIFF(NOW(), purchase_date) / 365'));

        // Condition breakdown
        $excellentCount = (clone $query)->where('condition', 'excellent')->count();
        $goodCount = (clone $query)->where('condition', 'good')->count();
        $fairCount = (clone $query)->where('condition', 'fair')->count();
        $poorCount = (clone $query)->where('condition', 'poor')->count();

        return [
            'total_equipment' => $total,
            'active_equipment' => $activeCount,
            'in_maintenance' => $maintenanceCount,
            'retired_equipment' => $retiredCount,
            'total_value' => $totalValue,
            'average_age' => round($averageAge, 1),
            'by_condition' => [
                'excellent' => $excellentCount,
                'good' => $goodCount,
                'fair' => $fairCount,
                'poor' => $poorCount,
            ],
        ];
    }

    /**
     * Get equipment by category.
     */
    public function getByCategory(string $category): Collection
    {
        return Equipment::where('category', $category)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get equipment by status.
     */
    public function getByStatus(string $status): Collection
    {
        return Equipment::where('status', $status)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get equipment requiring maintenance.
     */
    public function getRequiringMaintenance(): Collection
    {
        return Equipment::where(function ($query) {
            // Equipment in maintenance status
            $query->where('status', 'maintenance')
                // OR equipment needing service (last service > 6 months ago)
                ->orWhere(function ($q) {
                    $q->whereNotNull('last_service_date')
                        ->where('last_service_date', '<=', now()->subMonths(6));
                })
                // OR equipment never serviced that's older than 1 year
                ->orWhere(function ($q) {
                    $q->whereNull('last_service_date')
                        ->where('purchase_date', '<=', now()->subYear());
                });
        })
            ->orderBy('last_service_date', 'asc')
            ->get();
    }

    /**
     * Get category breakdown.
     */
    public function getCategoryBreakdown(): array
    {
        $breakdown = Equipment::select('category', DB::raw('COUNT(*) as count'), DB::raw('SUM(purchase_price) as total_value'))
            ->groupBy('category')
            ->get();

        $result = [];
        foreach ($breakdown as $item) {
            $result[$item->category] = [
                'count' => $item->count,
                'total_value' => $item->total_value,
            ];
        }

        return $result;
    }

    /**
     * Get equipment by location.
     */
    public function getByLocation(string $location): Collection
    {
        return Equipment::where('location', 'like', "%{$location}%")
            ->orderBy('name')
            ->get();
    }

    /**
     * Get recent additions.
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Equipment::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Schedule maintenance.
     */
    public function scheduleMaintenance(Equipment $equipment, Carbon $scheduledDate, string $description): bool
    {
        return $equipment->update([
            'next_service_date' => $scheduledDate,
            'maintenance_notes' => ($equipment->maintenance_notes ? $equipment->maintenance_notes."\n" : '')
                .now()->format('Y-m-d').': Maintenance scheduled for '.$scheduledDate->format('Y-m-d').' - '.$description,
        ]);
    }

    /**
     * Record maintenance.
     */
    public function recordMaintenance(Equipment $equipment, array $data): bool
    {
        $maintenanceRecord = [
            'last_service_date' => $data['service_date'] ?? now(),
            'maintenance_notes' => ($equipment->maintenance_notes ? $equipment->maintenance_notes."\n" : '')
                .now()->format('Y-m-d').': '.($data['notes'] ?? 'Service performed'),
        ];

        // Update condition if provided
        if (isset($data['condition'])) {
            $maintenanceRecord['condition'] = $data['condition'];
        }

        // Calculate next service date (6 months from now by default)
        if (isset($data['next_service_months'])) {
            $maintenanceRecord['next_service_date'] = now()->addMonths($data['next_service_months']);
        } else {
            $maintenanceRecord['next_service_date'] = now()->addMonths(6);
        }

        // If equipment was in maintenance, set back to active
        if ($equipment->status === 'maintenance') {
            $maintenanceRecord['status'] = 'active';
        }

        return $equipment->update($maintenanceRecord);
    }

    /**
     * Mark as retired.
     */
    public function markAsRetired(Equipment $equipment, ?string $reason = null): bool
    {
        return $equipment->update([
            'status' => 'retired',
            'maintenance_notes' => ($equipment->maintenance_notes ? $equipment->maintenance_notes."\n" : '')
                .now()->format('Y-m-d').': Retired - '.($reason ?? 'No reason provided'),
        ]);
    }

    /**
     * Get equipment value by category.
     */
    public function getValueByCategory(): array
    {
        $values = Equipment::select('category', DB::raw('SUM(purchase_price) as total_value'))
            ->groupBy('category')
            ->get();

        $result = [];
        foreach ($values as $item) {
            $result[$item->category] = $item->total_value;
        }

        return $result;
    }

    /**
     * Get depreciation report.
     */
    public function getDepreciationReport(): array
    {
        $equipment = Equipment::where('status', '!=', 'retired')
            ->get();

        $totalOriginalValue = 0;
        $totalCurrentValue = 0;

        foreach ($equipment as $item) {
            $age = $item->purchase_date ? $item->purchase_date->diffInYears(now()) : 0;
            $depreciationRate = 0.15; // 15% per year
            $currentValue = $item->purchase_price * pow(1 - $depreciationRate, $age);

            $totalOriginalValue += $item->purchase_price;
            $totalCurrentValue += $currentValue;
        }

        return [
            'total_original_value' => $totalOriginalValue,
            'total_current_value' => $totalCurrentValue,
            'total_depreciation' => $totalOriginalValue - $totalCurrentValue,
            'depreciation_percentage' => $totalOriginalValue > 0
                ? round((($totalOriginalValue - $totalCurrentValue) / $totalOriginalValue) * 100, 2)
                : 0,
        ];
    }

    /**
     * Export equipment.
     */
    public function export(array $filters = []): Collection
    {
        $query = Equipment::query();

        // Apply filters (same as getPaginated but without pagination)
        if (isset($filters['category']) && $filters['category'] !== '') {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['condition']) && $filters['condition'] !== '') {
            $query->where('condition', $filters['condition']);
        }

        return $query->orderBy('category')->orderBy('name')->get();
    }

    /**
     * Get maintenance schedule.
     */
    public function getMaintenanceSchedule(int $months = 3): Collection
    {
        $endDate = now()->addMonths($months);

        return Equipment::where('status', 'active')
            ->whereNotNull('next_service_date')
            ->where('next_service_date', '<=', $endDate)
            ->orderBy('next_service_date', 'asc')
            ->get();
    }

    /**
     * Search equipment.
     */
    public function search(string $query, int $limit = 10): Collection
    {
        return Equipment::where('name', 'like', "%{$query}%")
            ->orWhere('serial_number', 'like', "%{$query}%")
            ->orWhere('model', 'like', "%{$query}%")
            ->limit($limit)
            ->get();
    }

    /**
     * Get warranty expiring soon.
     */
    public function getWarrantyExpiringSoon(int $months = 3): Collection
    {
        $endDate = now()->addMonths($months);

        return Equipment::whereNotNull('warranty_expiry')
            ->where('warranty_expiry', '>', now())
            ->where('warranty_expiry', '<=', $endDate)
            ->where('status', '!=', 'retired')
            ->orderBy('warranty_expiry', 'asc')
            ->get();
    }
}
