<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id', 'type', 'category', 'description', 'amount',
        'transaction_date', 'reference_number', 'recorded_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function scopeInflows($query)
    {
        return $query->where('type', 'inflow');
    }

    public function scopeOutflows($query)
    {
        return $query->where('type', 'outflow');
    }
}
