<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'transaction_type',
        'amount',
        'currency',
        'category',
        'sub_category',
        'description',
        'payment_method',
        'reference_number',
        'receipt_url',
        'receipt_notes',
        'transaction_date',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the member associated with this transaction.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the user who created this transaction.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved this transaction.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope query to only income transactions.
     */
    public function scopeIncome($query)
    {
        return $query->whereIn('transaction_type', ['tithe', 'offering', 'donation', 'other_income']);
    }

    /**
     * Scope query to only expense transactions.
     */
    public function scopeExpense($query)
    {
        return $query->where('transaction_type', 'expense');
    }

    /**
     * Scope query by transaction type.
     */
    public function scopeType($query, string $type)
    {
        return $query->where('transaction_type', $type);
    }

    /**
     * Scope query by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope query to only completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['completed', 'reconciled']);
    }

    /**
     * Scope query to only pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope query by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    /**
     * Scope query for this month's transactions.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year);
    }

    /**
     * Scope query for this year's transactions.
     */
    public function scopeThisYear($query)
    {
        return $query->whereYear('transaction_date', now()->year);
    }

    /**
     * Check if transaction is income.
     */
    public function isIncome(): bool
    {
        return in_array($this->transaction_type, ['tithe', 'offering', 'donation', 'other_income']);
    }

    /**
     * Check if transaction is expense.
     */
    public function isExpense(): bool
    {
        return $this->transaction_type === 'expense';
    }

    /**
     * Check if transaction requires approval.
     */
    public function requiresApproval(): bool
    {
        return $this->amount >= config('church.dual_approval_amount', 5000);
    }

    /**
     * Approve the transaction.
     */
    public function approve(User $approver): bool
    {
        return $this->update([
            'status' => 'completed',
            'approved_by' => $approver->id,
            'approved_at' => now(),
        ]);
    }

    /**
     * Get formatted amount with currency.
     */
    public function getFormattedAmountAttribute(): string
    {
        return $this->currency.' '.number_format($this->amount, 2);
    }
}
