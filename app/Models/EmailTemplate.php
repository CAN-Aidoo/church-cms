<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'subject',
        'body_html',
        'body_text',
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
    public function render(array $variables = []): array
    {
        $subject = $this->replaceVariables($this->subject, $variables);
        $bodyHtml = $this->replaceVariables($this->body_html, $variables);
        $bodyText = $this->body_text ? $this->replaceVariables($this->body_text, $variables) : null;

        return [
            'subject' => $subject,
            'body_html' => $bodyHtml,
            'body_text' => $bodyText,
        ];
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
