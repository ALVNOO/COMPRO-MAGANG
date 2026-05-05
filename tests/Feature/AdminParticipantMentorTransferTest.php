<?php

namespace Tests\Feature;

use App\Models\InternshipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminParticipantMentorTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_transfer_mentor_for_accepted_participant_and_persist_history_and_notifications(): void
    {
        $admin = $this->createUser('admin01', 'Admin', 'admin@example.com', 'admin');
        $participant = $this->createUser('peserta01', 'Peserta Satu', 'peserta@example.com', 'peserta');

        $divisionA = $this->createDivision('Divisi A', 'Mentor Utama', '111111');
        $mentorOld = $this->createDivisionMentor($divisionA, 'Mentor Lama', '222222');
        $mentorNew = $this->createDivisionMentor($divisionA, 'Mentor Baru', '333333');

        $this->createUser('222222', 'Mentor Lama', 'mentor-lama@example.com', 'pembimbing');
        $this->createUser('333333', 'Mentor Baru', 'mentor-baru@example.com', 'pembimbing');

        $application = $this->createInternshipApplication($participant->id, $divisionA, $mentorOld, 'accepted');

        $response = $this->actingAs($admin)->post(route('admin.participants.change-mentor', $application->id), [
            'division_mentor_id' => $mentorNew,
            'transfer_reason' => 'Mentor lama sedang cuti panjang.',
        ]);

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('internship_applications', [
            'id' => $application->id,
            'division_mentor_id' => $mentorNew,
        ]);

        $this->assertDatabaseHas('mentor_transfer_histories', [
            'internship_application_id' => $application->id,
            'old_division_mentor_id' => $mentorOld,
            'new_division_mentor_id' => $mentorNew,
            'changed_by_admin_id' => $admin->id,
            'reason' => 'Mentor lama sedang cuti panjang.',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $participant->id,
            'type' => 'mentor_changed',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => User::where('username', '222222')->firstOrFail()->id,
            'type' => 'mentor_reassigned',
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => User::where('username', '333333')->firstOrFail()->id,
            'type' => 'mentor_reassigned',
        ]);
    }

    public function test_transfer_fails_when_participant_status_is_not_accepted(): void
    {
        $admin = $this->createUser('admin02', 'Admin Dua', 'admin2@example.com', 'admin');
        $participant = $this->createUser('peserta02', 'Peserta Dua', 'peserta2@example.com', 'peserta');

        $divisionA = $this->createDivision('Divisi B', 'Mentor Divisi B', '444444');
        $mentorOld = $this->createDivisionMentor($divisionA, 'Mentor Lama B', '555555');
        $mentorNew = $this->createDivisionMentor($divisionA, 'Mentor Baru B', '666666');

        $application = $this->createInternshipApplication($participant->id, $divisionA, $mentorOld, 'finished');

        $response = $this->actingAs($admin)->post(route('admin.participants.change-mentor', $application->id), [
            'division_mentor_id' => $mentorNew,
        ]);

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('internship_applications', [
            'id' => $application->id,
            'division_mentor_id' => $mentorOld,
            'status' => 'finished',
        ]);

        $this->assertDatabaseCount('mentor_transfer_histories', 0);
    }

    public function test_transfer_fails_when_new_mentor_is_from_different_division(): void
    {
        $admin = $this->createUser('admin03', 'Admin Tiga', 'admin3@example.com', 'admin');
        $participant = $this->createUser('peserta03', 'Peserta Tiga', 'peserta3@example.com', 'peserta');

        $divisionA = $this->createDivision('Divisi C', 'Mentor Divisi C', '777777');
        $divisionB = $this->createDivision('Divisi D', 'Mentor Divisi D', '888888');

        $mentorOld = $this->createDivisionMentor($divisionA, 'Mentor Lama C', '999999');
        $mentorDifferentDivision = $this->createDivisionMentor($divisionB, 'Mentor Divisi Lain', '101010');

        $application = $this->createInternshipApplication($participant->id, $divisionA, $mentorOld, 'accepted');

        $response = $this->actingAs($admin)->post(route('admin.participants.change-mentor', $application->id), [
            'division_mentor_id' => $mentorDifferentDivision,
        ]);

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('internship_applications', [
            'id' => $application->id,
            'division_mentor_id' => $mentorOld,
        ]);
        $this->assertDatabaseCount('mentor_transfer_histories', 0);
    }

    public function test_transfer_fails_when_new_mentor_is_same_as_current_mentor(): void
    {
        $admin = $this->createUser('admin04', 'Admin Empat', 'admin4@example.com', 'admin');
        $participant = $this->createUser('peserta04', 'Peserta Empat', 'peserta4@example.com', 'peserta');

        $divisionA = $this->createDivision('Divisi E', 'Mentor Divisi E', '111112');
        $mentor = $this->createDivisionMentor($divisionA, 'Mentor Sama', '121212');

        $application = $this->createInternshipApplication($participant->id, $divisionA, $mentor, 'accepted');

        $response = $this->actingAs($admin)->post(route('admin.participants.change-mentor', $application->id), [
            'division_mentor_id' => $mentor,
        ]);

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('internship_applications', [
            'id' => $application->id,
            'division_mentor_id' => $mentor,
        ]);
        $this->assertDatabaseCount('mentor_transfer_histories', 0);
    }

    public function test_transfer_fails_when_participant_has_no_current_mentor(): void
    {
        $admin = $this->createUser('admin05', 'Admin Lima', 'admin5@example.com', 'admin');
        $participant = $this->createUser('peserta05', 'Peserta Lima', 'peserta5@example.com', 'peserta');

        $divisionA = $this->createDivision('Divisi F', 'Mentor Divisi F', '131313');
        $mentorNew = $this->createDivisionMentor($divisionA, 'Mentor Baru F', '141414');

        $application = $this->createInternshipApplication($participant->id, $divisionA, null, 'accepted');

        $response = $this->actingAs($admin)->post(route('admin.participants.change-mentor', $application->id), [
            'division_mentor_id' => $mentorNew,
        ]);

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('internship_applications', [
            'id' => $application->id,
            'division_mentor_id' => null,
        ]);
        $this->assertDatabaseCount('mentor_transfer_histories', 0);
    }

    private function createUser(string $username, string $name, string $email, string $role): User
    {
        return User::create([
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => $role,
        ]);
    }

    private function createDivision(string $divisionName, string $mentorName, string $nikNumber): int
    {
        return (int) DB::table('divisions')->insertGetId([
            'division_name' => $divisionName,
            'mentor_name' => $mentorName,
            'nik_number' => $nikNumber,
            'is_active' => true,
            'sort_order' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createDivisionMentor(int $divisionId, string $mentorName, string $nikNumber): int
    {
        return (int) DB::table('division_mentors')->insertGetId([
            'division_id' => $divisionId,
            'mentor_name' => $mentorName,
            'nik_number' => $nikNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createInternshipApplication(int $participantId, int $divisionId, ?int $mentorId, string $status): InternshipApplication
    {
        $direktoratId = DB::table('direktorats')->insertGetId([
            'name' => 'Direktorat Testing ' . uniqid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subDirektoratId = DB::table('sub_direktorats')->insertGetId([
            'name' => 'Sub Direktorat Testing ' . uniqid(),
            'direktorat_id' => $direktoratId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $divisiId = DB::table('divisis')->insertGetId([
            'name' => 'Divisi Legacy ' . uniqid(),
            'sub_direktorat_id' => $subDirektoratId,
            'vp' => 'PIC',
            'nippos' => '123456789',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return InternshipApplication::create([
            'user_id' => $participantId,
            'divisi_id' => $divisiId,
            'division_admin_id' => $divisionId,
            'division_mentor_id' => $mentorId,
            'status' => $status,
        ]);
    }
}
