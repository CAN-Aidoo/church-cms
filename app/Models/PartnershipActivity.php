<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id', 'activity_title', 'activity_type', 'description',
        'activity_date', 'participants', 'status', 'outcomes', 'coordinator_id',
    ];

    protected $casts = [
        'participants' => 'array',
        'activity_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}
