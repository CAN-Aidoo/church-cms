<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRScanLog extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'qr_scan_logs';

    protected $fillable = [
        'qr_id',
        'user_id',
        'scan_time',
        'location_latitude',
        'location_longitude',
        'location_accuracy',
        'distance_from_church',
        'device_id',
        'device_type',
        'ip_address',
        'success',
        'error_reason',
        'processing_time',
        'offline_sync',
        'synced_at',
        'scan_result',
        'metadata',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
        'synced_at' => 'datetime',
        'location_latitude' => 'decimal:7',
        'location_longitude' => 'decimal:7',
        'location_accuracy' => 'decimal:2',
        'distance_from_church' => 'integer',
        'processing_time' => 'integer',
        'success' => 'boolean',
        'offline_sync' => 'boolean',
        'metadata' => 'array',
    ];

    // Scan Results
    const RESULT_CHECK_IN_SUCCESS = 'CHECK_IN_SUCCESS';

    const RESULT_ATTENDANCE_MARKED = 'ATTENDANCE_MARKED';

    const RESULT_EVENT_REGISTERED = 'EVENT_REGISTERED';

    const RESULT_PAYMENT_PROCESSED = 'PAYMENT_PROCESSED';

    const RESULT_VERIFIED = 'VERIFIED';

    // Error Reasons
    const ERROR_EXPIRED = 'QR_EXPIRED';

    const ERROR_NOT_ACTIVE = 'QR_NOT_ACTIVE';

    const ERROR_GPS_FAILED = 'GPS_VERIFICATION_FAILED';

    const ERROR_DUPLICATE = 'DUPLICATE_SCAN';

    const ERROR_MAX_SCANS = 'MAX_SCANS_REACHED';

    const ERROR_INVALID_SIGNATURE = 'INVALID_SIGNATURE';

    const ERROR_REVOKED = 'QR_REVOKED';

    /**
     * Get the QR code that was scanned.
     */
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class, 'qr_id');
    }

    /**
     * Get the user who scanned.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location as an array.
     */
    public function getLocationAttribute(): ?array
    {
        if (is_null($this->location_latitude) || is_null($this->location_longitude)) {
            return null;
        }

        return [
            'lat' => (float) $this->location_latitude,
            'lng' => (float) $this->location_longitude,
            'accuracy' => (float) $this->location_accuracy,
        ];
    }

    /**
     * Check if scan was successful.
     */
    public function isSuccessful(): bool
    {
        return $this->success === true;
    }

    /**
     * Check if scan was from offline mode.
     */
    public function isOfflineSync(): bool
    {
        return $this->offline_sync === true;
    }

    /**
     * Mark as synced (for offline scans).
     */
    public function markSynced(): void
    {
        $this->update([
            'synced_at' => now(),
        ]);
    }

    /**
     * Scopes
     */
    public function scopeSuccessful($query)
    {
        return $query->where('success', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('success', false);
    }

    public function scopeOffline($query)
    {
        return $query->where('offline_sync', true);
    }

    public function scopePendingSync($query)
    {
        return $query->where('offline_sync', true)
            ->whereNull('synced_at');
    }

    public function scopeForQR($query, string $qrId)
    {
        return $query->where('qr_id', $qrId);
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scan_time', today());
    }

    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('scan_time', [$startDate, $endDate]);
    }

    public function scopeByResult($query, string $result)
    {
        return $query->where('scan_result', $result);
    }

    public function scopeByDeviceType($query, string $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }
}
