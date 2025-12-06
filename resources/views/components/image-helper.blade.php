{{-- Helper component for consistent image display --}}
@php
    if (empty($path)) {
        $imageUrl = '';
    } elseif (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        $imageUrl = $path;
    } else {
        $imageUrl = Storage::disk('public')->url($path);
    }
@endphp

