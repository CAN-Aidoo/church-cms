<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'service_date',
        'service_type',
        'status',
        'notes',
        'recorded_by',
        'recorded_at',
        'check_in_method',
        'qr_code_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'service_date' => 'date',
        'recorded_at' => 'datetime',
    ];

    /**
     * Get the member this attendance record belongs to.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user who recorded this attendance.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Get the QR code used for this attendance.
     */
    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QRCode::class, 'qr_code_id');
    }

    /**
     * Scope query to only present records.
     */
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    /**
     * Scope query to only absent records.
     */
    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    /**
     * Scope query by service type.
     */
    public function scopeServiceType($query, string $type)
    {
        return $query->where('service_type', $type);
    }

    /**
     * Scope query by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('service_date', [$startDate, $endDate]);
    }

    /**
     * Scope query for today's attendance.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('service_date', today());
    }

    /**
     * Scope query for this week's attendance.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('service_date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    /**
     * Scope query for this month's attendance.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('service_date', now()->month)
            ->whereYear('service_date', now()->year);
    }
}
