<?php

namespace Database\Seeders;

use App\Models\Divisi;
use App\Models\InternshipApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user with rejected application
        $user = User::create([
            'username' => 'testuser',
            'password' => bcrypt('password'),
            'name' => 'Test User',
            'email' => 'test@example.com',
            'nim' => '2021001',
            'university' => 'Universitas Indonesia',
            'major' => 'Teknik Informatika',
            'phone' => '081234567891',
            'ktp_number' => '1234567890123457',
            'role' => 'peserta',
        ]);

        // Create a rejected application for testing
        $divisi = Divisi::first();
        if ($divisi) {
            InternshipApplication::create([
                'user_id' => $user->id,
                'divisi_id' => $divisi->id,
                'status' => 'revision',
                'notes' => 'Pengajuan ditolak karena kuota divisi sudah penuh. Silakan pilih divisi lain atau ajukan ulang di periode berikutnya.',
                'cover_letter_path' => 'cover_letters/sample.pdf',
            ]);
        }

        $this->command->info('Testing data seeded successfully!');
        $this->command->info('Test user credentials:');
        $this->command->info('Username: testuser');
        $this->command->info('Password: password');
    }
}
