<?php

namespace App\Services\Division;

use App\Models\DivisiAdmin;
use App\Models\DivisionMentor;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class DivisionService
{
    /**
     * Get all active divisions with mentors.
     */
    public function getActiveDivisions(): Collection
    {
        return DivisiAdmin::with('mentors')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('division_name')
            ->get();
    }

    /**
     * Get all divisions with mentors (including inactive).
     */
    public function getAllDivisions(): Collection
    {
        return DivisiAdmin::with('mentors')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get a single division with mentors.
     */
    public function getDivision(int $id): DivisiAdmin
    {
        return DivisiAdmin::with('mentors')->findOrFail($id);
    }

    /**
     * Create a new division with mentors.
     */
    public function createDivision(array $data): DivisiAdmin
    {
        $firstMentor = $data['mentors'][0] ?? null;

        $division = DivisiAdmin::create([
            'division_name' => $data['division_name'],
            'mentor_name' => $firstMentor['mentor_name'] ?? null,
            'nik_number' => $firstMentor['nik_number'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        // Create mentors and user accounts
        foreach ($data['mentors'] as $mentorData) {
            $this->createMentorWithAccount($division->id, $mentorData);
        }

        return $division->fresh('mentors');
    }

    /**
     * Update a division and its mentors.
     */
    public function updateDivision(int $id, array $data): DivisiAdmin
    {
        $division = DivisiAdmin::findOrFail($id);
        $firstMentor = $data['mentors'][0] ?? null;

        $division->update([
            'division_name' => $data['division_name'],
            'mentor_name' => $firstMentor['mentor_name'] ?? $division->mentor_name,
            'nik_number' => $firstMentor['nik_number'] ?? $division->nik_number,
            'is_active' => $data['is_active'] ?? $division->is_active,
            'sort_order' => $data['sort_order'] ?? $division->sort_order,
        ]);

        // Sync mentors
        $this->syncMentors($division, $data['mentors']);

        return $division->fresh('mentors');
    }

    /**
     * Toggle division active status.
     */
    public function toggleStatus(int $id): DivisiAdmin
    {
        $division = DivisiAdmin::findOrFail($id);
        $division->update(['is_active' => !$division->is_active]);

        return $division;
    }

    /**
     * Delete a division (with validation).
     */
    public function deleteDivision(int $id): bool
    {
        $division = DivisiAdmin::findOrFail($id);

        if ($division->internshipApplications()->exists()) {
            throw new \Exception("Divisi {$division->division_name} tidak dapat dihapus karena masih memiliki data terkait.");
        }

        // Delete associated mentors
        $division->mentors()->delete();

        return $division->delete();
    }

    /**
     * Create a mentor with user account.
     */
    public function createMentorWithAccount(int $divisionId, array $mentorData): DivisionMentor
    {
        $mentor = DivisionMentor::create([
            'division_id' => $divisionId,
            'mentor_name' => $mentorData['mentor_name'],
            'nik_number' => $mentorData['nik_number'],
        ]);

        // Create or update user account
        $existingUser = User::where('username', $mentorData['nik_number'])->first();

        if (!$existingUser) {
            User::create([
                'username' => $mentorData['nik_number'],
                'name' => $mentorData['mentor_name'],
                'email' => 'mentor_' . $mentorData['nik_number'] . '@telkomindonesia.co.id',
                'password' => Hash::make('mentor123'),
                'role' => 'pembimbing',
            ]);
        } else {
            $existingUser->update([
                'name' => $mentorData['mentor_name'],
                'email' => 'mentor_' . $mentorData['nik_number'] . '@telkomindonesia.co.id',
                'role' => 'pembimbing',
            ]);
        }

        return $mentor;
    }

    /**
     * Sync mentors for a division (update existing, create new, delete removed).
     */
    protected function syncMentors(DivisiAdmin $division, array $mentorsData): void
    {
        $existingMentorIds = collect($mentorsData)
            ->filter(fn($m) => isset($m['id']) && $m['id'])
            ->pluck('id');

        // Delete mentors that are not in the request
        $division->mentors()->whereNotIn('id', $existingMentorIds)->delete();

        foreach ($mentorsData as $mentorData) {
            if (isset($mentorData['id']) && $mentorData['id']) {
                // Update existing mentor
                $this->updateMentor($mentorData['id'], $division->id, $mentorData);
            } else {
                // Create new mentor
                $this->createMentorWithAccount($division->id, $mentorData);
            }
        }
    }

    /**
     * Update an existing mentor.
     */
    protected function updateMentor(int $mentorId, int $divisionId, array $mentorData): ?DivisionMentor
    {
        $mentor = DivisionMentor::where('id', $mentorId)
            ->where('division_id', $divisionId)
            ->first();

        if (!$mentor) {
            return null;
        }

        $oldNik = $mentor->nik_number;

        $mentor->update([
            'mentor_name' => $mentorData['mentor_name'],
            'nik_number' => $mentorData['nik_number'],
        ]);

        // Update user account
        $user = User::where('username', $oldNik)->first();
        if ($user) {
            $updateData = ['name' => $mentorData['mentor_name']];

            if ($oldNik !== $mentorData['nik_number']) {
                $updateData['username'] = $mentorData['nik_number'];
                $updateData['email'] = 'mentor_' . $mentorData['nik_number'] . '@telkomindonesia.co.id';
            }

            $user->update($updateData);
        }

        return $mentor;
    }

    /**
     * Get mentor by NIK (username).
     */
    public function getMentorByNik(string $nik): ?DivisionMentor
    {
        return DivisionMentor::where('nik_number', $nik)
            ->with('division')
            ->first();
    }

    /**
     * Validate NIK uniqueness.
     */
    public function validateNikUniqueness(array $nikNumbers, ?int $excludeDivisionId = null): array
    {
        $duplicates = [];

        // Check for duplicates within the array
        $nikCollection = collect($nikNumbers);
        $internalDuplicates = $nikCollection->duplicates();
        if ($internalDuplicates->isNotEmpty()) {
            $duplicates['internal'] = $internalDuplicates->values()->toArray();
        }

        // Check for existing NIKs in database
        $query = DivisionMentor::whereIn('nik_number', $nikNumbers);
        if ($excludeDivisionId) {
            $query->where('division_id', '!=', $excludeDivisionId);
        }

        $existingNiks = $query->pluck('nik_number')->toArray();
        if (!empty($existingNiks)) {
            $duplicates['existing'] = $existingNiks;
        }

        return $duplicates;
    }

    /**
     * Reset mentor password to default.
     */
    public function resetMentorPassword(int $userId): User
    {
        $mentor = User::where('id', $userId)
            ->where('role', 'pembimbing')
            ->firstOrFail();

        $mentor->update([
            'password' => Hash::make('mentor123')
        ]);

        return $mentor;
    }

    /**
     * Get all mentors with division info.
     */
    public function getAllMentors(): Collection
    {
        return DivisionMentor::with('division')->get();
    }

    /**
     * Get mentors with user accounts and pagination.
     */
    public function getMentorsWithUsersPaginated(int $perPage = 10)
    {
        $divisionMentors = DivisionMentor::with('division')->get();
        $mentors = collect();

        foreach ($divisionMentors as $divisionMentor) {
            $user = User::where('username', $divisionMentor->nik_number)
                ->where('role', 'pembimbing')
                ->first();

            if ($user) {
                $user->division_mentor = $divisionMentor;
                $user->division_admin = $divisionMentor->division;
                $mentors->push($user);
            }
        }

        // Manual pagination
        $currentPage = request()->get('page', 1);
        $items = $mentors->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $mentors->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    /**
     * Get mentor detail with participants.
     */
    public function getMentorDetail(int $userId): array
    {
        $mentor = User::findOrFail($userId);

        $divisionMentor = DivisionMentor::where('nik_number', $mentor->username)->first();
        $division = $divisionMentor ? $divisionMentor->division : null;

        $mentor->division_mentor = $divisionMentor;
        $mentor->division_admin = $division;

        $participants = $division
            ? \App\Models\InternshipApplication::where('division_admin_id', $division->id)
                ->with('user')
                ->whereIn('status', ['accepted', 'finished'])
                ->orderBy('start_date', 'desc')
                ->get()
            : collect();

        return [
            'mentor' => $mentor,
            'participants' => $participants,
        ];
    }
}
