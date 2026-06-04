<?php

namespace App\Services\Document;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default_upload_disk', 'public');
    }

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
        $fullFilename = $filename.'.'.$extension;

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
     * Upload a PDF document, verifying both MIME type and magic bytes.
     * Prevents MIME-type spoofing where a non-PDF file has a .pdf extension.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadPdf(UploadedFile $file, string $directory, ?string $existingPath = null): string
    {
        $this->assertValidPdf($file);

        return $this->uploadAndReplace($file, $directory, $existingPath);
    }

    /**
     * Verify the uploaded file is a genuine PDF.
     *
     * getMimeType() uses PHP's Fileinfo extension which reads the actual file
     * magic bytes — not the client-supplied Content-Type header — so this
     * correctly rejects executables, scripts, or images with a .pdf extension.
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    private function assertValidPdf(UploadedFile $file): void
    {
        if ($file->getMimeType() !== 'application/pdf') {
            abort(422, 'File harus berformat PDF yang valid (konten file tidak sesuai).');
        }
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
        if (! $path) {
            return false;
        }

        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get the URL for a file.
     */
    public function getUrl(?string $path): ?string
    {
        if (! $path) {
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
        if (! $this->exists($path)) {
            throw new \Exception('File tidak ditemukan.');
        }

        return Storage::disk($this->disk)->download($path, $name);
    }

    /**
     * Get file contents.
     */
    public function getContents(string $path): string
    {
        if (! $this->exists($path)) {
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
        return $this->uploadPdf($file, 'acceptance_letters', $existingPath);
    }

    public function uploadCompletionLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'completion_letters', $existingPath);
    }

    public function uploadLocationPermissionLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'location_permission_letters', $existingPath);
    }

    public function uploadIntegrityPact(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'integrity_pacts', $existingPath);
    }

    /**
     * @param  string  $kind  "participant" or "admin"
     */
    public function uploadFinalEvaluation(UploadedFile $file, string $kind, ?string $existingPath = null): string
    {
        $dir = $kind === 'admin' ? 'final_evaluations/admin' : 'final_evaluations/participant';

        return $this->uploadPdf($file, $dir, $existingPath);
    }

    public function uploadCertificate(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'certificates', $existingPath);
    }

    public function uploadAssessmentReport(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'assessment_reports', $existingPath);
    }

    public function uploadKtm(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'ktm', $existingPath);
    }

    public function uploadCv(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'cv', $existingPath);
    }

    public function uploadSuratPermohonan(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'surat_permohonan', $existingPath);
    }

    public function uploadGoodBehavior(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'good_behavior', $existingPath);
    }

    public function uploadCoverLetter(UploadedFile $file, ?string $existingPath = null): string
    {
        return $this->uploadPdf($file, 'cover_letters', $existingPath);
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
