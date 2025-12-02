<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'custom_report_id',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customReport()
    {
        return $this->belongsTo(CustomReport::class);
    }
}
