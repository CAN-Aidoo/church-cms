<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QRCode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'qr_codes';

    protected $fillable = [
        'type',
        'church_id',
        'service_date',
        'service_type',
        'activation_time',
        'expiration_time',
        'location_required',
        'location_latitude',
        'location_longitude',
        'location_radius',
        'generated_by',
        'generated_at',
        'status',
        'revoked',
        'revoked_by',
        'revoked_at',
        'max_scans',
        'allow_family',
        'requires_verification',
        'offline_allowed',
        'metadata',
    ];

    protected $casts = [
        'service_date' => 'date',
        'activation_time' => 'datetime',
        'expiration_time' => 'datetime',
        'generated_at' => 'datetime',
        'revoked_at' => 'datetime',
        'location_required' => 'boolean',
        'location_latitude' => 'decimal:7',
        'location_longitude' => 'decimal:7',
        'location_radius' => 'integer',
        'max_scans' => 'integer',
        'allow_family' => 'boolean',
        'requires_verification' => 'boolean',
        'offline_allowed' => 'boolean',
        'revoked' => 'boolean',
        'metadata' => 'array',
    ];

    // QR Code Types
    const TYPE_SERVICE_ATTENDANCE = 'SERVICE_ATTENDANCE';
    const TYPE_EVENT_REGISTRATION = 'EVENT_REGISTRATION';
    const TYPE_PAYMENT = 'PAYMENT';
    const TYPE_CHECK_IN = 'CHECK_IN';
    const TYPE_VISITOR_REGISTRATION = 'VISITOR_REGISTRATION';
    const TYPE_EQUIPMENT_CHECKOUT = 'EQUIPMENT_CHECKOUT';
    const TYPE_VERIFICATION = 'VERIFICATION';

    // Statuses
    const STATUS_PENDING = 'PENDING';
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_EXPIRED = 'EXPIRED';
    const STATUS_REVOKED = 'REVOKED';

    /**
     * Get the user who generated this QR code.
     */
    public function generator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Get the user who revoked this QR code.
     */
    public function revoker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    /**
     * Get all scan logs for this QR code.
     */
    public function scanLogs(): HasMany
    {
        return $this->hasMany(QRScanLog::class, 'qr_id');
    }

    /**
     * Get all analytics for this QR code.
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(QRAnalytics::class, 'qr_id');
    }

    /**
     * Check if QR code is currently active.
     */
    public function isActive(): bool
    {
        if ($this->revoked) {
            return false;
        }

        $now = now();

        return $now->greaterThanOrEqualTo($this->activation_time)
            && $now->lessThanOrEqualTo($this->expiration_time);
    }

    /**
     * Check if QR code is expired.
     */
    public function isExpired(): bool
    {
        return now()->greaterThan($this->expiration_time);
    }

    /**
     * Check if QR code is pending activation.
     */
    public function isPending(): bool
    {
        return now()->lessThan($this->activation_time);
    }

    /**
     * Revoke this QR code.
     */
    public function revoke(?int $userId = null): void
    {
        $this->update([
            'status' => self::STATUS_REVOKED,
            'revoked' => true,
            'revoked_by' => $userId ?? auth()->id(),
            'revoked_at' => now(),
        ]);
    }

    /**
     * Extend the expiration time.
     */
    public function extend(int $minutes): void
    {
        $this->update([
            'expiration_time' => $this->expiration_time->addMinutes($minutes),
        ]);
    }

    /**
     * Get total scans for this QR code.
     */
    public function getTotalScansAttribute(): int
    {
        return $this->scanLogs()->where('success', true)->count();
    }

    /**
     * Get unique users who scanned this QR code.
     */
    public function getUniqueUsersAttribute(): int
    {
        return $this->scanLogs()
            ->where('success', true)
            ->distinct('user_id')
            ->count('user_id');
    }

    /**
     * Get success rate percentage.
     */
    public function getSuccessRateAttribute(): float
    {
        $total = $this->scanLogs()->count();

        if ($total === 0) {
            return 0;
        }

        $successful = $this->scanLogs()->where('success', true)->count();

        return round(($successful / $total) * 100, 2);
    }

    /**
     * Check if max scans reached.
     */
    public function hasReachedMaxScans(): bool
    {
        if (is_null($this->max_scans)) {
            return false; // Unlimited scans
        }

        return $this->total_scans >= $this->max_scans;
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
            'radius' => $this->location_radius,
        ];
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('revoked', false)
            ->where('activation_time', '<=', now())
            ->where('expiration_time', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expiration_time', '<', now());
    }

    public function scopePending($query)
    {
        return $query->where('activation_time', '>', now());
    }

    public function scopeRevoked($query)
    {
        return $query->where('revoked', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('service_date', $date);
    }

    public function scopeForService($query, string $serviceType)
    {
        return $query->where('service_type', $serviceType);
    }
}
