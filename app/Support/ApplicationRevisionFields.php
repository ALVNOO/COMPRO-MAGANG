<?php

namespace App\Support;

use App\Models\InternshipApplication;
use App\Models\User;

class ApplicationRevisionFields
{
    public const PROFILE = 'profile';

    public const FIELD_OF_INTEREST = 'field_of_interest';

    public const DATES = 'dates';

    public const KTM = 'ktm';

    public const SURAT_PERMOHONAN = 'surat_permohonan';

    public const CV = 'cv';

    public const GOOD_BEHAVIOR = 'good_behavior';

    public const ALL = [
        self::PROFILE,
        self::FIELD_OF_INTEREST,
        self::DATES,
        self::KTM,
        self::SURAT_PERMOHONAN,
        self::CV,
        self::GOOD_BEHAVIOR,
    ];

    public const DOCUMENT_FIELDS = [
        self::KTM,
        self::SURAT_PERMOHONAN,
        self::CV,
        self::GOOD_BEHAVIOR,
    ];

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            self::PROFILE => 'Data diri (biodata)',
            self::FIELD_OF_INTEREST => 'Bidang peminatan',
            self::DATES => 'Jadwal magang',
            self::KTM => 'KTM',
            self::SURAT_PERMOHONAN => 'Surat permohonan',
            self::CV => 'CV',
            self::GOOD_BEHAVIOR => 'Surat berkelakuan baik (SKCK)',
        ];
    }

    /**
     * @return array<int, list<string>>
     */
    public static function sectionFieldMap(): array
    {
        return [
            1 => [self::PROFILE],
            2 => [self::FIELD_OF_INTEREST],
            3 => self::DOCUMENT_FIELDS,
            4 => [self::DATES],
        ];
    }

    public static function labelFor(string $field): string
    {
        return self::labels()[$field] ?? $field;
    }

    /**
     * @param  list<string>  $fields
     * @return list<int>
     */
    public static function sectionsForFields(array $fields): array
    {
        $sections = [];

        foreach (self::sectionFieldMap() as $section => $sectionFields) {
            if (array_intersect($fields, $sectionFields)) {
                $sections[] = $section;
            }
        }

        return array_values(array_unique($sections));
    }

    public static function isValidField(string $field): bool
    {
        return in_array($field, self::ALL, true);
    }

    /**
     * @param  list<string>  $fields
     */
    public static function clearApplicationDataForFields(InternshipApplication $application, array $fields): void
    {
        foreach ($fields as $field) {
            switch ($field) {
                case self::FIELD_OF_INTEREST:
                    $application->field_of_interest_id = null;
                    break;
                case self::DATES:
                    $application->start_date = null;
                    $application->end_date = null;
                    break;
                case self::KTM:
                    $application->ktm_path = null;
                    break;
                case self::SURAT_PERMOHONAN:
                    $application->surat_permohonan_path = null;
                    break;
                case self::CV:
                    $application->cv_path = null;
                    break;
                case self::GOOD_BEHAVIOR:
                    $application->good_behavior_path = null;
                    break;
            }
        }
    }

    /**
     * @return list<string>
     */
    public static function validationErrors(User $user, InternshipApplication $application): array
    {
        $fields = $application->revision_fields ?? [];
        $isRevisionMode = $application->isRevisionMode();

        if (! $isRevisionMode) {
            return self::validationErrorsForFullApplication($user, $application);
        }

        $errors = [];

        if (in_array(self::PROFILE, $fields, true) && ! self::isProfileComplete($user)) {
            $errors[] = 'Lengkapi data diri yang diminta untuk revisi.';
        }

        if (in_array(self::FIELD_OF_INTEREST, $fields, true) && ! $application->field_of_interest_id) {
            $errors[] = 'Pilih bidang peminatan.';
        }

        foreach (self::DOCUMENT_FIELDS as $doc) {
            if (! in_array($doc, $fields, true)) {
                continue;
            }

            $column = match ($doc) {
                self::KTM => 'ktm_path',
                self::SURAT_PERMOHONAN => 'surat_permohonan_path',
                self::CV => 'cv_path',
                self::GOOD_BEHAVIOR => 'good_behavior_path',
            };

            if (empty($application->{$column})) {
                $errors[] = 'Unggah ulang: '.self::labelFor($doc).'.';
            }
        }

        if (in_array(self::DATES, $fields, true) && (! $application->start_date || ! $application->end_date)) {
            $errors[] = 'Isi jadwal magang.';
        }

        return $errors;
    }

    /**
     * @return list<string>
     */
    public static function validationErrorsForFullApplication(User $user, InternshipApplication $application): array
    {
        $errors = [];

        if (! self::isProfileComplete($user)) {
            $errors[] = 'Lengkapi data diri.';
        }

        if (! $application->field_of_interest_id) {
            $errors[] = 'Pilih bidang peminatan.';
        }

        foreach (self::DOCUMENT_FIELDS as $doc) {
            $column = match ($doc) {
                self::KTM => 'ktm_path',
                self::SURAT_PERMOHONAN => 'surat_permohonan_path',
                self::CV => 'cv_path',
                self::GOOD_BEHAVIOR => 'good_behavior_path',
            };

            if (empty($application->{$column})) {
                $errors[] = 'Unggah '.self::labelFor($doc).'.';
            }
        }

        if (! $application->start_date || ! $application->end_date) {
            $errors[] = 'Isi jadwal magang.';
        }

        return $errors;
    }

    public static function isProfileComplete(User $user): bool
    {
        return (bool) ($user->name && $user->nim && $user->university && $user->major && $user->phone && $user->ktp_number);
    }

    /**
     * @param  list<string>  $fields
     * @return list<string>
     */
    public static function labelsForFields(array $fields): array
    {
        return array_values(array_map(
            fn (string $field) => self::labelFor($field),
            array_filter($fields, fn (string $f) => self::isValidField($f))
        ));
    }
}
