<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildrensEventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'childrens_event_id',
        'child_id',
        'registration_date',
        'amount_paid',
        'payment_status',
        'special_requirements',
        'emergency_contact',
        'status',
        'registered_by',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'amount_paid' => 'decimal:2',
        'emergency_contact' => 'array',
    ];

    /**
     * Relationships
     */
    public function event()
    {
        return $this->belongsTo(ChildrensEvent::class, 'childrens_event_id');
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    /**
     * Get outstanding balance.
     */
    public function getOutstandingBalanceAttribute(): float
    {
        return max(0, $this->event->registration_fee - $this->amount_paid);
    }

    /**
     * Check if fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->amount_paid >= $this->event->registration_fee;
    }

    /**
     * Confirm registration.
     */
    public function confirm(): self
    {
        $this->update(['status' => 'confirmed']);

        return $this;
    }

    /**
     * Mark as attended.
     */
    public function markAttended(): self
    {
        $this->update(['status' => 'attended']);

        return $this;
    }

    /**
     * Cancel registration.
     */
    public function cancel(): self
    {
        $this->update(['status' => 'cancelled']);
        $this->event->decrementRegisteredCount();

        return $this;
    }

    /**
     * Record payment.
     */
    public function recordPayment(float $amount): self
    {
        $newTotal = $this->amount_paid + $amount;
        $paymentStatus = $newTotal >= $this->event->registration_fee ? 'paid' :
                        ($newTotal > 0 ? 'partial' : 'unpaid');

        $this->update([
            'amount_paid' => $newTotal,
            'payment_status' => $paymentStatus,
        ]);

        return $this;
    }

    /**
     * Query Scopes
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeAttended($query)
    {
        return $query->where('status', 'attended');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    public function scopePartiallyPaid($query)
    {
        return $query->where('payment_status', 'partial');
    }

    public function scopeFullyPaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
}
