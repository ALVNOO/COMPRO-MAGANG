<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadsFiles
{
    /**
     * Upload a file to the specified directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $disk
     * @return string The stored file path
     */
    protected function uploadFile(UploadedFile $file, string $directory, string $disk = 'public'): string
    {
        return $file->store($directory, $disk);
    }

    /**
     * Upload a file with a custom filename.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $filename
     * @param string $disk
     * @return string The stored file path
     */
    protected function uploadFileAs(UploadedFile $file, string $directory, string $filename, string $disk = 'public'): string
    {
        $extension = $file->getClientOriginalExtension();
        $fullFilename = $filename . '.' . $extension;

        return $file->storeAs($directory, $fullFilename, $disk);
    }

    /**
     * Upload a file and replace existing file if provided.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $existingPath
     * @param string $disk
     * @return string The stored file path
     */
    protected function uploadAndReplace(UploadedFile $file, string $directory, ?string $existingPath = null, string $disk = 'public'): string
    {
        // Delete existing file if exists
        if ($existingPath) {
            $this->deleteFile($existingPath, $disk);
        }

        return $this->uploadFile($file, $directory, $disk);
    }

    /**
     * Delete a file if it exists.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    protected function deleteFile(?string $path, string $disk = 'public'): bool
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Check if a file exists.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    protected function fileExists(?string $path, string $disk = 'public'): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk($disk)->exists($path);
    }

    /**
     * Get the URL for a file.
     *
     * @param string|null $path
     * @param string $disk
     * @return string|null
     */
    protected function getFileUrl(?string $path, string $disk = 'public'): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($disk)->url($path);
    }

    /**
     * Get the full path for a file.
     *
     * @param string $path
     * @param string $disk
     * @return string
     */
    protected function getFullPath(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->path($path);
    }

    /**
     * Generate a unique filename.
     *
     * @param UploadedFile $file
     * @param string|null $prefix
     * @return string
     */
    protected function generateUniqueFilename(UploadedFile $file, ?string $prefix = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);

        if ($prefix) {
            return "{$prefix}_{$timestamp}_{$random}.{$extension}";
        }

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Validate file type against allowed extensions.
     *
     * @param UploadedFile $file
     * @param array $allowedExtensions
     * @return bool
     */
    protected function isAllowedFileType(UploadedFile $file, array $allowedExtensions): bool
    {
        $extension = strtolower($file->getClientOriginalExtension());
        return in_array($extension, array_map('strtolower', $allowedExtensions));
    }

    /**
     * Get file size in human readable format.
     *
     * @param string $path
     * @param string $disk
     * @return string
     */
    protected function getFileSize(string $path, string $disk = 'public'): string
    {
        $bytes = Storage::disk($disk)->size($path);

        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }
}
