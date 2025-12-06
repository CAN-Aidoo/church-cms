<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class StorageHelper
{
    /**
     * Get the public URL for a stored file.
     * Handles both old format (full paths) and new format (relative paths).
     */
    public static function url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // If path already starts with storage/, use asset helper
        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        // Use Storage facade for paths stored in public disk
        return Storage::url($path);
    }

    /**
     * Check if a file exists in storage.
     */
    public static function exists(?string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }
}
