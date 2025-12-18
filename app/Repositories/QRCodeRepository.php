<?php

namespace App\Repositories;

use App\Models\QRAnalytics;
use App\Models\QRCode;
use App\Models\QRCodeSetting;
use App\Models\QRScanLog;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class QRCodeRepository
{
    /**
     * Get paginated QR codes with filters.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = QRCode::query()->with(['generator', 'scanLogs']);

        // Apply filters
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('service_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('service_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['service_type'])) {
            $query->where('service_type', $filters['service_type']);
        }

        if (isset($filters['revoked'])) {
            $query->where('revoked', $filters['revoked']);
        }

        // Default ordering
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Get active QR codes.
     */
    public function getActive(): Collection
    {
        return QRCode::active()->with('generator')->get();
    }

    /**
     * Get QR codes expiring soon (within X hours).
     */
    public function getExpiringSoon(int $hours = 1): Collection
    {
        $threshold = now()->addHours($hours);

        return QRCode::where('revoked', false)
            ->where('expiration_time', '>', now())
            ->where('expiration_time', '<=', $threshold)
            ->with('generator')
            ->get();
    }

    /**
     * Get QR codes for a specific service.
     */
    public function getForService(string $date, string $serviceType): Collection
    {
        return QRCode::whereDate('service_date', $date)
            ->where('service_type', $serviceType)
            ->with('generator')
            ->get();
    }

    /**
     * Create a new QR code.
     */
    public function create(array $data): QRCode
    {
        return QRCode::create($data);
    }

    /**
     * Update a QR code.
     */
    public function update(QRCode $qrCode, array $data): bool
    {
        return $qrCode->update($data);
    }

    /**
     * Delete a QR code.
     */
    public function delete(QRCode $qrCode): bool
    {
        return $qrCode->delete();
    }

    /**
     * Get QR code by ID.
     */
    public function findById(string $id): ?QRCode
    {
        return QRCode::with(['generator', 'scanLogs', 'analytics'])->find($id);
    }

    /**
     * Get multiple QR codes by IDs.
     */
    public function findByIds(array $ids): Collection
    {
        return QRCode::with(['generator'])->whereIn('id', $ids)->get();
    }

    /**
     * Log a scan attempt.
     */
    public function logScan(array $data): QRScanLog
    {
        return QRScanLog::create($data);
    }

    /**
     * Get scan logs for a QR code.
     */
    public function getScanLogs(string $qrId, array $filters = []): Collection
    {
        $query = QRScanLog::where('qr_id', $qrId)->with('user');

        if (isset($filters['success'])) {
            $query->where('success', $filters['success']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('scan_time', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('scan_time', '<=', $filters['date_to']);
        }

        return $query->orderBy('scan_time', 'desc')->get();
    }

    /**
     * Get analytics for a QR code.
     */
    public function getAnalytics(string $qrId, ?string $date = null): ?QRAnalytics
    {
        $query = QRAnalytics::where('qr_id', $qrId);

        if ($date) {
            $query->whereDate('date', $date);
        } else {
            $query->latest();
        }

        return $query->first();
    }

    /**
     * Update or create analytics for a QR code.
     */
    public function updateAnalytics(string $qrId, string $date, array $data): QRAnalytics
    {
        return QRAnalytics::updateOrCreate(
            ['qr_id' => $qrId, 'date' => $date],
            $data
        );
    }

    /**
     * Get dashboard statistics.
     */
    public function getDashboardStatistics(): array
    {
        $today = today();

        return [
            'active_qr_codes' => QRCode::active()->count(),
            'pending_qr_codes' => QRCode::pending()->count(),
            'expired_today' => QRCode::whereDate('expiration_time', $today)->count(),
            'total_scans_today' => QRScanLog::whereDate('scan_time', $today)->count(),
            'successful_scans_today' => QRScanLog::whereDate('scan_time', $today)
                ->where('success', true)->count(),
            'unique_users_today' => QRScanLog::whereDate('scan_time', $today)
                ->where('success', true)
                ->distinct('user_id')
                ->count('user_id'),
            'average_scan_time' => QRScanLog::whereDate('scan_time', $today)
                ->where('success', true)
                ->avg('processing_time'),
            'success_rate_today' => $this->calculateSuccessRate($today),
        ];
    }

    /**
     * Calculate success rate for a specific date.
     */
    private function calculateSuccessRate(string $date): float
    {
        $total = QRScanLog::whereDate('scan_time', $date)->count();

        if ($total === 0) {
            return 0;
        }

        $successful = QRScanLog::whereDate('scan_time', $date)
            ->where('success', true)
            ->count();

        return round(($successful / $total) * 100, 2);
    }

    /**
     * Get scan statistics for a date range.
     */
    public function getScanStatistics(Carbon $startDate, Carbon $endDate): array
    {
        $scans = QRScanLog::whereBetween('scan_time', [$startDate, $endDate])->get();

        return [
            'total_scans' => $scans->count(),
            'successful_scans' => $scans->where('success', true)->count(),
            'failed_scans' => $scans->where('success', false)->count(),
            'unique_users' => $scans->where('success', true)->unique('user_id')->count(),
            'offline_syncs' => $scans->where('offline_sync', true)->count(),
            'avg_processing_time' => $scans->where('success', true)->avg('processing_time'),
            'device_breakdown' => [
                'ios' => $scans->where('device_type', 'ios')->count(),
                'android' => $scans->where('device_type', 'android')->count(),
                'web' => $scans->where('device_type', 'web')->count(),
            ],
            'error_breakdown' => $scans->where('success', false)
                ->groupBy('error_reason')
                ->map(fn($group) => $group->count())
                ->toArray(),
        ];
    }

    /**
     * Get hourly scan distribution for a specific QR code and date.
     */
    public function getHourlyScanDistribution(string $qrId, string $date): array
    {
        $scans = QRScanLog::where('qr_id', $qrId)
            ->whereDate('scan_time', $date)
            ->where('success', true)
            ->get();

        $distribution = array_fill(0, 24, 0);

        foreach ($scans as $scan) {
            $hour = (int) $scan->scan_time->format('H');
            $distribution[$hour]++;
        }

        return $distribution;
    }

    /**
     * Get recent scan activity.
     */
    public function getRecentActivity(int $limit = 20): Collection
    {
        return QRScanLog::with(['qrCode', 'user'])
            ->where('success', true)
            ->orderBy('scan_time', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if user has already scanned a specific QR code.
     */
    public function hasUserScanned(string $qrId, int $userId): bool
    {
        return QRScanLog::where('qr_id', $qrId)
            ->where('user_id', $userId)
            ->where('success', true)
            ->exists();
    }

    /**
     * Get pending offline scans.
     */
    public function getPendingOfflineScans(): Collection
    {
        return QRScanLog::where('offline_sync', true)
            ->whereNull('synced_at')
            ->get();
    }

    /**
     * Mark offline scans as synced.
     */
    public function markSynced(array $scanIds): int
    {
        return QRScanLog::whereIn('id', $scanIds)
            ->update(['synced_at' => now()]);
    }

    /**
     * Get QR code settings.
     */
    public function getSettings(): array
    {
        return QRCodeSetting::getAll();
    }

    /**
     * Get a specific setting.
     */
    public function getSetting(string $key, $default = null)
    {
        return QRCodeSetting::get($key, $default);
    }

    /**
     * Update a setting.
     */
    public function updateSetting(string $key, $value, ?int $userId = null): void
    {
        QRCodeSetting::set($key, $value, $userId);
    }

    /**
     * Generate analytics for a specific QR code and date.
     */
    public function generateAnalytics(string $qrId, string $date): QRAnalytics
    {
        $scans = QRScanLog::where('qr_id', $qrId)
            ->whereDate('scan_time', $date)
            ->get();

        $successful = $scans->where('success', true);
        $failed = $scans->where('success', false);

        $data = [
            'total_scans' => $scans->count(),
            'unique_users' => $successful->unique('user_id')->count(),
            'successful_scans' => $successful->count(),
            'failed_scans' => $failed->count(),
            'success_rate' => $scans->count() > 0
                ? round(($successful->count() / $scans->count()) * 100, 2)
                : 0,
            'avg_scan_time' => $successful->avg('processing_time'),
            'offline_syncs' => $scans->where('offline_sync', true)->count(),
            'gps_failures' => $failed->where('error_reason', QRScanLog::ERROR_GPS_FAILED)->count(),
            'duplicate_attempts' => $failed->where('error_reason', QRScanLog::ERROR_DUPLICATE)->count(),
            'error_count' => $failed->count(),
            'hourly_distribution' => $this->getHourlyScanDistribution($qrId, $date),
            'error_categories' => $failed->groupBy('error_reason')
                ->map(fn($group) => $group->count())
                ->toArray(),
            'device_breakdown' => [
                'ios' => $scans->where('device_type', 'ios')->count(),
                'android' => $scans->where('device_type', 'android')->count(),
                'web' => $scans->where('device_type', 'web')->count(),
            ],
        ];

        // Find peak time
        $hourlyDist = $data['hourly_distribution'];
        if (!empty($hourlyDist)) {
            $peakHour = array_keys($hourlyDist, max($hourlyDist))[0];
            $data['peak_time'] = Carbon::parse($date)->setHour($peakHour)->setMinute(0)->setSecond(0);
            $data['peak_scans'] = $hourlyDist[$peakHour];
        }

        return $this->updateAnalytics($qrId, $date, $data);
    }

    /**
     * Cleanup expired QR codes (update status).
     */
    public function cleanupExpired(): int
    {
        return QRCode::where('status', '!=', QRCode::STATUS_EXPIRED)
            ->where('expiration_time', '<', now())
            ->where('revoked', false)
            ->update(['status' => QRCode::STATUS_EXPIRED]);
    }

    /**
     * Auto-activate pending QR codes.
     */
    public function activatePending(): int
    {
        return QRCode::where('status', QRCode::STATUS_PENDING)
            ->where('activation_time', '<=', now())
            ->where('expiration_time', '>', now())
            ->where('revoked', false)
            ->update(['status' => QRCode::STATUS_ACTIVE]);
    }
}
