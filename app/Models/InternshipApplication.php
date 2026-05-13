<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'divisi_id',
        'division_admin_id',
        'division_mentor_id',
        'field_of_interest_id',
        'status',
        'cover_letter_path',
        'ktm_path',
        'surat_permohonan_path',
        'cv_path',
        'good_behavior_path',
        'notes',
        'start_date',
        'end_date',
        'assessment_report_path',
        'completion_letter_path',
        'location_permission_letter_path',
        'integrity_pact_path',
        'acceptance_letter_path',
        'acceptance_letter_downloaded_at',
        'dashboard_entered_at',
        'final_evaluation_participant_path',
        'final_evaluation_participant_uploaded_at',
        'final_evaluation_admin_path',
        'final_evaluation_admin_uploaded_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'final_evaluation_participant_uploaded_at' => 'datetime',
        'final_evaluation_admin_uploaded_at' => 'datetime',
    ];

    /**
     * Whether a final evaluation PDF exists (uploaded by participant and/or admin).
     */
    public function hasFinalEvaluationDocument(): bool
    {
        return ! empty($this->final_evaluation_participant_path)
            || ! empty($this->final_evaluation_admin_path);
    }

    /**
     * Path to the stored final evaluation PDF (participant upload takes precedence if both exist).
     */
    public function finalEvaluationDocumentPath(): ?string
    {
        if (! empty($this->final_evaluation_participant_path)) {
            return $this->final_evaluation_participant_path;
        }
        if (! empty($this->final_evaluation_admin_path)) {
            return $this->final_evaluation_admin_path;
        }

        return null;
    }

    /**
     * Get the user that owns the internship application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the divisi that owns the internship application (old structure).
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Get the division admin that owns the internship application (new structure).
     */
    public function divisionAdmin()
    {
        return $this->belongsTo(DivisiAdmin::class, 'division_admin_id');
    }

    public function fieldOfInterest()
    {
        return $this->belongsTo(FieldOfInterest::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Get the division mentor assigned to this application.
     */
    public function divisionMentor()
    {
        return $this->belongsTo(DivisionMentor::class, 'division_mentor_id');
    }
}
