<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'display_name',
        'thumbnail_paths',
        'download_count',
    ];

    protected $casts = [
        'thumbnail_paths' => 'array',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
