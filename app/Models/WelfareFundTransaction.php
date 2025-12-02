<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class WelfareFundTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_code',
        'type',
        'category',
        'description',
        'amount',
        'transaction_date',
        'case_id',
        'member_id',
        'reference_number',
        'payment_method',
        'notes',
        'recorded_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Boot method to auto-generate transaction code.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_code)) {
                $prefix = $transaction->type === 'collection' ? 'WFC' : 'WFD';
                $transaction->transaction_code = $prefix.'-'.date('Ymd').'-'.strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Relationships
     */
    public function case()
    {
        return $this->belongsTo(WelfareCase::class, 'case_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Query Scopes
     */
    public function scopeCollections($query)
    {
        return $query->where('type', 'collection');
    }

    public function scopeDisbursements($query)
    {
        return $query->where('type', 'disbursement');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
