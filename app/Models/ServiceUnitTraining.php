<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceUnitTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_unit_id',
        'training_title',
        'training_date',
        'training_time',
        'location',
        'trainer',
        'description',
        'materials',
        'attendance_count',
        'conducted_by',
        'notes',
        'status',
    ];

    protected $casts = [
        'training_date' => 'date',
        'training_time' => 'datetime',
    ];

    /**
     * Get the service unit this training belongs to.
     */
    public function serviceUnit(): BelongsTo
    {
        return $this->belongsTo(ServiceUnit::class);
    }

    /**
     * Get the member who conducted the training.
     */
    public function conductor(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'conducted_by');
    }
}
