<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FileUploadService
{
    /**
     * Allowed MIME types for images
     */
    private const ALLOWED_IMAGE_MIMES = [
        'image/jpeg',
        'image/png',
        'image/jpg',
        'image/gif',
        'image/webp',
    ];

    /**
     * Allowed MIME types for documents
     */
    private const ALLOWED_DOCUMENT_MIMES = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    /**
     * Upload and validate a file securely.
     *
     * @param  string  $type  'image' or 'document'
     * @param  int  $maxSize  Maximum size in KB
     * @return string The stored file path
     *
     * @throws ValidationException
     */
    public function uploadFile(UploadedFile $file, string $directory, string $type = 'image', int $maxSize = 2048): string
    {
        // Validate file size (convert KB to bytes)
        if ($file->getSize() > ($maxSize * 1024)) {
            throw ValidationException::withMessages([
                'file' => ["File size exceeds maximum allowed size of {$maxSize}KB."],
            ]);
        }

        // Validate MIME type by checking actual file content
        $this->validateMimeType($file, $type);

        // Generate secure random filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40).'.'.$extension;

        // Store file with random filename
        $path = $file->storeAs($directory, $filename, 'public');

        if (! $path) {
            throw ValidationException::withMessages([
                'file' => ['Failed to upload file. Please try again.'],
            ]);
        }

        return $path;
    }

    /**
     * Validate MIME type by checking file content (not just extension).
     *
     * @throws ValidationException
     */
    private function validateMimeType(UploadedFile $file, string $type): void
    {
        // Get MIME type from file content
        $mimeType = $file->getMimeType();

        $allowedMimes = $type === 'image'
            ? self::ALLOWED_IMAGE_MIMES
            : self::ALLOWED_DOCUMENT_MIMES;

        if (! in_array($mimeType, $allowedMimes)) {
            throw ValidationException::withMessages([
                'file' => ['Invalid file type. Only '.implode(', ', $allowedMimes).' are allowed.'],
            ]);
        }

        // Additional validation: Check file content (magic bytes)
        if ($type === 'image') {
            $this->validateImageContent($file);
        }
    }

    /**
     * Validate image file by checking magic bytes.
     *
     * @throws ValidationException
     */
    private function validateImageContent(UploadedFile $file): void
    {
        $handle = fopen($file->getRealPath(), 'rb');
        if (! $handle) {
            throw ValidationException::withMessages([
                'file' => ['Unable to read file for validation.'],
            ]);
        }

        $bytes = fread($handle, 12);
        fclose($handle);

        // Check for image magic bytes
        $validSignatures = [
            'JPEG' => ["\xFF\xD8\xFF"],
            'PNG' => ["\x89\x50\x4E\x47\x0D\x0A\x1A\x0A"],
            'GIF' => ["\x47\x49\x46\x38"],
            'WEBP' => ["\x52\x49\x46\x46"], // RIFF header (simplified check)
        ];

        $isValid = false;
        foreach ($validSignatures as $signature) {
            if (substr($bytes, 0, strlen($signature[0])) === $signature[0]) {
                $isValid = true;
                break;
            }
        }

        if (! $isValid) {
            throw ValidationException::withMessages([
                'file' => ['File content does not match declared image type.'],
            ]);
        }
    }

    /**
     * Delete a file securely.
     */
    public function deleteFile(string $path): bool
    {
        if (empty($path)) {
            return false;
        }

        // Prevent directory traversal
        if (strpos($path, '..') !== false) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }
}
