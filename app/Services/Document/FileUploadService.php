<?php

namespace App\Services\Document;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected string $disk = 'public';

    /**
     * Upload a file to the specified directory.
     */
    public function upload(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, $this->disk);
    }

    /**
     * Upload a file with a custom filename.
     */
    public function uploadAs(UploadedFile $file, string $directory, string $filename): string
    {
        $extension = $file->getClientOriginalExtension();
        $fullFilename = $filename . '.' . $extension;

        return $file->storeAs($directory, $fullFilename, $this->disk);
    }

    /**
     * Upload a file and replace existing file if provided.
     */
    public function uploadAndReplace(UploadedFile $file, string $directory, ?string $existingPath = null): string
    {
        if ($existingPath) {
            $this->delete($existingPath);
        }

        return $this->upload($file, $directory);
    }

    /**
     * Delete a file if it exists.
     */
    public function delete(?string $path): bool
    {
        if ($path && Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * Check if a file exists.
     */
    public function exists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get the URL for a file.
     */
    public function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Get the full path for a file.
     */
    public function getFullPath(string $path): string
    {
        return Storage::disk($this->disk)->path($path);
    }

    /**
     * Download a file.
     */
    public function download(string $path, ?string $name = null)
    {
        if (!$this->exists($path)) {
            throw new \Exception('File tidak ditemukan.');
        }

        return Storage::disk($this->disk)->download($path, $name);
    }

    /**
     * Get file contents.
     */
    public function getContents(string $path): string
    {
        if (!$this->exists($path)) {
            throw new \Exception('File tidak ditemukan.');
        }

        return Storage::disk($this->disk)->get($path);
    }

    /**
     * Store file contents.
     */
    public function putContents(string $path, string $contents): bool
    {
        return Storage::disk($this->disk)->put($path, $contents);
    }

    /**
     * Generate a unique filename.
     */
    public function generateUniqueFilename(UploadedFile $file, ?string $prefix = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);

        if ($prefix) {
            return "{$prefix}_{$timestamp}_{$random}.{$extension}";
        }

        return "{$timestamp}_{$random}.{$extension}";
    }

    // ==========================================
    // Application Document Specific Methods
    // ==========================================

    /**
     * Upload acceptance letter.
     */
    public function uploadAcceptanceLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'acceptance_letters', $existingPath);
    }

    /**
     * Upload completion letter.
     */
    public function uploadCompletionLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'completion_letters', $existingPath);
    }

    /**
     * Upload certificate.
     */
    public function uploadCertificate(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'certificates', $existingPath);
    }

    /**
     * Upload assessment report.
     */
    public function uploadAssessmentReport(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'assessment_reports', $existingPath);
    }

    /**
     * Upload KTM (Kartu Tanda Mahasiswa).
     */
    public function uploadKtm(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'ktm', $existingPath);
    }

    /**
     * Upload CV.
     */
    public function uploadCv(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'cv', $existingPath);
    }

    /**
     * Upload Surat Permohonan.
     */
    public function uploadSuratPermohonan(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'surat_permohonan', $existingPath);
    }

    /**
     * Upload Good Behavior Certificate (SKCK).
     */
    public function uploadGoodBehavior(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'good_behavior', $existingPath);
    }

    /**
     * Upload Cover Letter.
     */
    public function uploadCoverLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadAndReplace($file, 'cover_letters', $existingPath);
    }

    // ==========================================
    // Attendance Specific Methods
    // ==========================================

    /**
     * Upload attendance photo.
     */
    public function uploadAttendancePhoto(UploadedFile $file): string
    {
        return $this->upload($file, 'attendance-photos');
    }

    /**
     * Upload attendance proof (for absence).
     */
    public function uploadAttendanceProof(UploadedFile $file): string
    {
        return $this->upload($file, 'attendance-proofs');
    }

    // ==========================================
    // Assignment Specific Methods
    // ==========================================

    /**
     * Upload assignment file.
     */
    public function uploadAssignmentFile(UploadedFile $file): string
    {
        return $this->upload($file, 'assignments');
    }

    /**
     * Upload assignment submission file.
     */
    public function uploadSubmissionFile(UploadedFile $file): string
    {
        return $this->upload($file, 'submissions');
    }

    /**
     * Set the disk to use.
     */
    public function setDisk(string $disk): self
    {
        $this->disk = $disk;
        return $this;
    }
}
