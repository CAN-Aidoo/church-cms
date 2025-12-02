<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'message',
        'available_variables',
        'category',
        'is_active',
    ];

    protected $casts = [
        'available_variables' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Render template with variables.
     */
    public function render(array $variables = []): string
    {
        return $this->replaceVariables($this->message, $variables);
    }

    /**
     * Replace template variables.
     */
    protected function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }

        return $content;
    }

    /**
     * Get template by slug.
     */
    public static function getBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->where('is_active', true)->first();
    }

    /**
     * Get message length.
     */
    public function getMessageLengthAttribute(): int
    {
        return strlen($this->message);
    }

    /**
     * Calculate SMS segments needed.
     */
    public function getSegmentsAttribute(): int
    {
        $length = $this->message_length;

        if ($length <= 160) {
            return 1;
        }

        // Multi-part SMS segments are 153 characters each
        return (int) ceil($length / 153);
    }

    /**
     * Check if message exceeds single SMS.
     */
    public function isMultipart(): bool
    {
        return $this->message_length > 160;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
