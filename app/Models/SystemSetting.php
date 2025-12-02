<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_encrypted',
        'is_public',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Get setting value with type casting.
     */
    public function getValueAttribute($value)
    {
        // Decrypt if encrypted
        if ($this->is_encrypted && $value) {
            $value = Crypt::decryptString($value);
        }

        // Cast to appropriate type
        return match ($this->type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'json' => json_decode($value, true),
            'array' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Set setting value with encryption if needed.
     */
    public function setValueAttribute($value)
    {
        // Convert arrays/objects to JSON
        if (in_array($this->type, ['json', 'array']) && is_array($value)) {
            $value = json_encode($value);
        }

        // Encrypt if needed
        if ($this->is_encrypted && $value) {
            $value = Crypt::encryptString($value);
        }

        $this->attributes['value'] = $value;
    }

    /**
     * Get setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = 'system_setting_'.$key;

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting by key.
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        // Clear cache
        Cache::forget('system_setting_'.$key);

        return $setting;
    }

    /**
     * Get all settings by group.
     */
    public static function getByGroup(string $group): array
    {
        return self::where('group', $group)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Clear all settings cache.
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }
}
