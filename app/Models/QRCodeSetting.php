<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRCodeSetting extends Model
{
    use HasFactory;

    protected $table = 'qr_code_settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
        'updated_by',
    ];

    /**
     * Get the user who last updated this setting.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the typed value based on setting_type.
     */
    public function getTypedValueAttribute()
    {
        return match ($this->setting_type) {
            'integer' => (int) $this->setting_value,
            'boolean' => filter_var($this->setting_value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->setting_value, true),
            default => $this->setting_value,
        };
    }

    /**
     * Get a setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('setting_key', $key)->first();

        return $setting ? $setting->typed_value : $default;
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value, ?int $userId = null): void
    {
        $setting = static::firstOrNew(['setting_key' => $key]);

        // Determine type
        $type = 'string';
        if (is_int($value)) {
            $type = 'integer';
        } elseif (is_bool($value)) {
            $type = 'boolean';
            $value = $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            $type = 'json';
            $value = json_encode($value);
        }

        $setting->setting_value = $value;
        $setting->setting_type = $type;
        $setting->updated_by = $userId ?? auth()->id();
        $setting->save();
    }

    /**
     * Get all settings as key-value array.
     */
    public static function getAll(): array
    {
        return static::all()->pluck('typed_value', 'setting_key')->toArray();
    }
}
