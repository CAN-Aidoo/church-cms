<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'metric_type',
        'metric_name',
        'metric_date',
        'period',
        'value',
        'metadata',
    ];

    protected $casts = [
        'metric_date' => 'date',
        'value' => 'decimal:2',
        'metadata' => 'array',
    ];

    /**
     * Record a metric.
     */
    public static function record(
        string $metricType,
        string $metricName,
        float $value,
        ?Carbon $date = null,
        string $period = 'daily',
        ?array $metadata = null
    ): self {
        return self::updateOrCreate(
            [
                'metric_type' => $metricType,
                'metric_name' => $metricName,
                'metric_date' => $date ?? now()->toDateString(),
                'period' => $period,
            ],
            [
                'value' => $value,
                'metadata' => $metadata,
            ]
        );
    }

    /**
     * Get metrics for a type and date range.
     */
    public static function getMetrics(
        string $metricType,
        ?Carbon $startDate = null,
        ?Carbon $endDate = null
    ): \Illuminate\Database\Eloquent\Collection {
        $query = self::where('metric_type', $metricType);

        if ($startDate) {
            $query->where('metric_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('metric_date', '<=', $endDate);
        }

        return $query->orderBy('metric_date')->get();
    }

    /**
     * Get growth metrics.
     */
    public static function getGrowthMetrics(int $days = 30): array
    {
        $endDate = now();
        $startDate = now()->subDays($days);

        $metrics = self::where('metric_type', 'growth')
            ->whereBetween('metric_date', [$startDate, $endDate])
            ->get();

        return [
            'member_growth' => $metrics->where('metric_name', 'member_count')->pluck('value', 'metric_date')->toArray(),
            'attendance_growth' => $metrics->where('metric_name', 'attendance_rate')->pluck('value', 'metric_date')->toArray(),
            'financial_growth' => $metrics->where('metric_name', 'giving_amount')->pluck('value', 'metric_date')->toArray(),
        ];
    }

    /**
     * Get engagement score for date.
     */
    public static function getEngagementScore(?Carbon $date = null): float
    {
        $date = $date ?? now();

        $attendanceRate = self::where('metric_type', 'engagement')
            ->where('metric_name', 'attendance_rate')
            ->where('metric_date', $date->toDateString())
            ->value('value') ?? 0;

        $participationRate = self::where('metric_type', 'engagement')
            ->where('metric_name', 'participation_rate')
            ->where('metric_date', $date->toDateString())
            ->value('value') ?? 0;

        $givingRate = self::where('metric_type', 'engagement')
            ->where('metric_name', 'giving_rate')
            ->where('metric_date', $date->toDateString())
            ->value('value') ?? 0;

        // Weighted average: 40% attendance, 30% participation, 30% giving
        return ($attendanceRate * 0.4) + ($participationRate * 0.3) + ($givingRate * 0.3);
    }

    /**
     * Query Scopes
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('metric_type', $type);
    }

    public function scopeByName($query, string $name)
    {
        return $query->where('metric_name', $name);
    }

    public function scopeByPeriod($query, string $period)
    {
        return $query->where('period', $period);
    }

    public function scopeDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('metric_date', [$startDate, $endDate]);
    }
}
