<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DivisionMentor;
use Illuminate\Support\Facades\Hash;

class MentorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua mentor dari division_mentors
        $mentors = DivisionMentor::all();
        
        foreach ($mentors as $mentor) {
            // Cek apakah user dengan NIK ini sudah ada
            $existingUser = User::where('username', $mentor->nik_number)->first();
            
            if (!$existingUser) {
                // Buat user baru untuk mentor
                User::create([
                    'username' => $mentor->nik_number,
                    'name' => $mentor->mentor_name,
                    'email' => 'mentor_' . $mentor->nik_number . '@posindonesia.co.id',
                    'password' => Hash::make('mentor123'),
                    'role' => 'pembimbing',
                    // NIK tidak diassign sebagai ktp_number karena berbeda
                ]);
            } else {
                // Update user yang sudah ada - sync dengan data mentor terbaru
                $existingUser->update([
                    'name' => $mentor->mentor_name,
                    'email' => 'mentor_' . $mentor->nik_number . '@posindonesia.co.id',
                    'role' => 'pembimbing',
                    'password' => Hash::make('mentor123'), // Reset password ke default
                ]);
            }
        }
    }
}
