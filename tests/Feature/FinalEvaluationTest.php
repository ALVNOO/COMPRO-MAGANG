<?php

namespace Tests\Feature;

use App\Models\InternshipApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FinalEvaluationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_certificate_without_final_evaluation(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe1', 'Admin', 'a@example.com', 'admin');
        $participant = $this->createUser('pstfe1', 'Peserta', 'p@example.com', 'peserta');

        $divisionId = $this->createDivision('Div X', 'Mentor', '999001');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '999002');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');
        $application->update([
            'end_date' => now()->subDay(),
        ]);

        $file = UploadedFile::fake()->create('cert.pdf', 200, 'application/pdf');

        $response = $this->actingAs($admin)->post(
            route('admin.participants.upload-certificate', $participant->id),
            ['certificate' => $file]
        );

        $response->assertRedirect(route('admin.participants'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('certificates', ['user_id' => $participant->id]);
    }

    public function test_participant_cannot_download_certificate_without_final_evaluation(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe1b', 'Admin', 'a1b@example.com', 'admin');
        $participant = $this->createUser('pstfe1b', 'Peserta', 'p1b@example.com', 'peserta');

        $divisionId = $this->createDivision('Div Xb', 'Mentor', '998001');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '998002');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');
        $application->update(['end_date' => now()->subDay()]);

        $file = UploadedFile::fake()->create('cert.pdf', 200, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.participants.upload-certificate', $participant->id),
            ['certificate' => $file]
        )->assertSessionHas('success');

        $certificate = \App\Models\Certificate::where('user_id', $participant->id)->firstOrFail();

        $this->actingAs($participant)->get(
            route('dashboard.certificates.download', $certificate->id)
        )->assertRedirect(route('dashboard.certificates'))
            ->assertSessionHas('error');
    }

    public function test_participant_cannot_download_completion_letter_without_final_evaluation(): void
    {
        Storage::fake('public');

        $participant = $this->createUser('pstfe1c', 'Peserta', 'p1c@example.com', 'peserta');

        $divisionId = $this->createDivision('Div Xc', 'Mentor', '997001');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '997002');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');
        $path = 'completion_letters/test.pdf';
        Storage::disk('public')->put($path, '%PDF-1.4 fake');
        $application->update([
            'end_date' => now()->subDay(),
            'completion_letter_path' => $path,
        ]);

        $this->actingAs($participant)->get(
            route('dashboard.certificates.download-completion-letter')
        )->assertRedirect(route('dashboard.certificates'))
            ->assertSessionHas('error');
    }

    public function test_admin_can_upload_certificate_after_participant_uploads_final_evaluation(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe2', 'Admin', 'a2@example.com', 'admin');
        $participant = $this->createUser('pstfe2', 'Peserta Dua', 'p2@example.com', 'peserta');

        $divisionId = $this->createDivision('Div Y', 'Mentor', '999003');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '999004');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');
        $application->update(['end_date' => now()->subDay()]);

        $evalPdf = UploadedFile::fake()->create('eval.pdf', 300, 'application/pdf');
        $this->actingAs($participant)->post(
            route('dashboard.final-evaluation.upload'),
            ['final_evaluation' => $evalPdf]
        )->assertRedirect(route('dashboard.final-evaluation'));

        $application->refresh();
        $this->assertNotNull($application->final_evaluation_participant_path);

        $certFile = UploadedFile::fake()->create('cert.pdf', 200, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.participants.upload-certificate', $participant->id),
            ['certificate' => $certFile]
        )->assertRedirect(route('admin.participants'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('certificates', ['user_id' => $participant->id]);
    }

    public function test_admin_can_upload_certificate_after_admin_final_evaluation_upload(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe3', 'Admin', 'a3@example.com', 'admin');
        $participant = $this->createUser('pstfe3', 'Peserta Tiga', 'p3@example.com', 'peserta');

        $divisionId = $this->createDivision('Div Z', 'Mentor', '999005');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '999006');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');
        $application->update(['end_date' => now()->subDay()]);

        $adminEval = UploadedFile::fake()->create('eval-admin.pdf', 300, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.final-evaluation.upload', $application->id),
            ['final_evaluation_admin' => $adminEval]
        )->assertRedirect(route('admin.final-evaluation.index'))
            ->assertSessionHas('success');

        $application->refresh();
        $this->assertNotNull($application->final_evaluation_admin_path);

        $certFile = UploadedFile::fake()->create('cert.pdf', 200, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.participants.upload-certificate', $participant->id),
            ['certificate' => $certFile]
        )->assertSessionHas('success');
    }

    public function test_mentor_can_download_participant_final_evaluation(): void
    {
        Storage::fake('public');

        $participant = $this->createUser('pstfe4', 'Peserta Empat', 'p4@example.com', 'peserta');
        $mentorUser = $this->createUser('999007', 'Mentor Empat', 'm4@example.com', 'pembimbing');

        $divisionId = $this->createDivision('Div W', 'Mentor', '999008');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor Empat', '999007');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');

        $path = 'final_evaluations/participant/test.pdf';
        Storage::disk('public')->put($path, '%PDF-1.4 fake');
        $application->update([
            'final_evaluation_participant_path' => $path,
            'final_evaluation_participant_uploaded_at' => now(),
        ]);

        $this->actingAs($mentorUser)->get(
            route('mentor.evaluasi-akhir.download', $application->id)
        )->assertOk();
    }

    public function test_admin_cannot_upload_final_evaluation_after_participant_uploaded(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe5', 'Admin Lima', 'a5@example.com', 'admin');
        $participant = $this->createUser('pstfe5', 'Peserta Lima', 'p5@example.com', 'peserta');

        $divisionId = $this->createDivision('Div Q', 'Mentor', '999010');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '999011');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');

        $evalPdf = UploadedFile::fake()->create('eval-p.pdf', 100, 'application/pdf');
        $this->actingAs($participant)->post(
            route('dashboard.final-evaluation.upload'),
            ['final_evaluation' => $evalPdf]
        )->assertSessionHas('success');

        $adminEval = UploadedFile::fake()->create('eval-a.pdf', 100, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.final-evaluation.upload', $application->id),
            ['final_evaluation_admin' => $adminEval]
        )->assertRedirect(route('admin.final-evaluation.index'))
            ->assertSessionHas('error');

        $application->refresh();
        $this->assertNull($application->final_evaluation_admin_path);
    }

    public function test_participant_cannot_upload_final_evaluation_after_admin_uploaded(): void
    {
        Storage::fake('public');

        $admin = $this->createUser('admfe6', 'Admin Enam', 'a6@example.com', 'admin');
        $participant = $this->createUser('pstfe6', 'Peserta Enam', 'p6@example.com', 'peserta');

        $divisionId = $this->createDivision('Div R', 'Mentor', '999012');
        $mentorId = $this->createDivisionMentor($divisionId, 'Mentor', '999013');
        $application = $this->createInternshipApplication($participant->id, $divisionId, $mentorId, 'accepted');

        $adminEval = UploadedFile::fake()->create('eval-a2.pdf', 100, 'application/pdf');
        $this->actingAs($admin)->post(
            route('admin.final-evaluation.upload', $application->id),
            ['final_evaluation_admin' => $adminEval]
        )->assertSessionHas('success');

        $evalPdf = UploadedFile::fake()->create('eval-p2.pdf', 100, 'application/pdf');
        $this->actingAs($participant)->post(
            route('dashboard.final-evaluation.upload'),
            ['final_evaluation' => $evalPdf]
        )->assertRedirect(route('dashboard.final-evaluation'))
            ->assertSessionHas('error');

        $application->refresh();
        $this->assertNull($application->final_evaluation_participant_path);
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
            'name' => 'Direktorat Testing '.uniqid(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $subDirektoratId = DB::table('sub_direktorats')->insertGetId([
            'name' => 'Sub Direktorat Testing '.uniqid(),
            'direktorat_id' => $direktoratId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $divisiId = DB::table('divisis')->insertGetId([
            'name' => 'Divisi Legacy '.uniqid(),
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
            'start_date' => now()->subMonth(),
            'end_date' => now()->addMonth(),
        ]);
    }
}
