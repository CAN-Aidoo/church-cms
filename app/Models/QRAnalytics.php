<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRAnalytics extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'qr_analytics';

    protected $fillable = [
        'qr_id',
        'date',
        'total_scans',
        'unique_users',
        'successful_scans',
        'failed_scans',
        'success_rate',
        'avg_scan_time',
        'peak_time',
        'peak_scans',
        'error_count',
        'offline_syncs',
        'gps_failures',
        'duplicate_attempts',
        'hourly_distribution',
        'error_categories',
        'device_breakdown',
    ];

    protected $casts = [
        'date' => 'date',
        'peak_time' => 'datetime',
        'total_scans' => 'integer',
        'unique_users' => 'integer',
        'successful_scans' => 'integer',
        'failed_scans' => 'integer',
        'success_rate' => 'decimal:2',
        'avg_scan_time' => 'integer',
        'peak_scans' => 'integer',
        'error_count' => 'integer',
        'offline_syncs' => 'integer',
        'gps_failures' => 'integer',
        'duplicate_attempts' => 'integer',
        'hourly_distribution' => 'array',
        'error_categories' => 'array',
        'device_breakdown' => 'array',
    ];

    /**
     * Get the QR code for this analytics record.
     */
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class, 'qr_id');
    }

    /**
     * Calculate success rate.
     */
    public function calculateSuccessRate(): float
    {
        if ($this->total_scans === 0) {
            return 0;
        }

        return round(($this->successful_scans / $this->total_scans) * 100, 2);
    }

    /**
     * Get hourly scan distribution as formatted array.
     */
    public function getHourlyChartData(): array
    {
        $hours = $this->hourly_distribution ?? [];
        $labels = [];
        $data = [];

        for ($i = 0; $i < 24; $i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $labels[] = $hour;
            $data[] = $hours[$i] ?? 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get error categories breakdown.
     */
    public function getErrorBreakdown(): array
    {
        return $this->error_categories ?? [];
    }

    /**
     * Get device breakdown (iOS, Android, Web).
     */
    public function getDeviceStats(): array
    {
        return $this->device_breakdown ?? [
            'ios' => 0,
            'android' => 0,
            'web' => 0,
        ];
    }

    /**
     * Scopes
     */
    public function scopeForQR($query, string $qrId)
    {
        return $query->where('qr_id', $qrId);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeLatest($query, int $days = 7)
    {
        return $query->where('date', '>=', now()->subDays($days))
            ->orderBy('date', 'desc');
    }
}
