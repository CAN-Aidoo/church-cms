<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnershipAgreement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partner_id', 'agreement_title', 'terms_conditions', 'financial_commitment',
        'deliverables', 'reporting_requirements', 'start_date', 'end_date',
        'duration_months', 'auto_renew', 'status', 'document_path', 'created_by',
    ];

    protected $casts = [
        'deliverables' => 'array',
        'reporting_requirements' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'financial_commitment' => 'decimal:2',
        'auto_renew' => 'boolean',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activate(): self
    {
        $this->update(['status' => 'active']);

        return $this;
    }

    public function terminate(): self
    {
        $this->update(['status' => 'terminated']);

        return $this;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active'); // Corrected from member_status
    }

    public function scopeExpiring($query, int $days = 30)
    {
        return $query->where('end_date', '<=', now()->addDays($days))->where('status', 'active'); // Corrected from member_status
    }
}
