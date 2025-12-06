<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImageUrl
{
    /**
     * Get the full URL for an image path.
     * Works with both relative paths and full paths.
     */
    protected function getImageUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        // If path already starts with http, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Use Storage facade for paths stored in public disk
        return Storage::disk('public')->url($path);
    }
}
