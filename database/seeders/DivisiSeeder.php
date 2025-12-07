<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DivisiAdmin;
use App\Models\DivisionMentor;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'division_name' => 'Business Service',
                'is_active' => true,
                'sort_order' => 1,
                'mentors' => [
                    [
                        'mentor_name' => 'Mentor Business Service',
                        'nik_number' => '100001',
                    ],
                ],
            ],
            [
                'division_name' => 'Government Service',
                'is_active' => true,
                'sort_order' => 2,
                'mentors' => [
                    [
                        'mentor_name' => 'Mentor Government Service',
                        'nik_number' => '100002',
                    ],
                ],
            ],
            [
                'division_name' => 'Performance & Risk Management',
                'is_active' => true,
                'sort_order' => 3,
                'mentors' => [
                    [
                        'mentor_name' => 'Mentor Performance & Risk Management',
                        'nik_number' => '100003',
                    ],
                ],
            ],
            [
                'division_name' => 'Shared Service & General Support',
                'is_active' => true,
                'sort_order' => 4,
                'mentors' => [
                    [
                        'mentor_name' => 'Mentor Shared Service & General Support',
                        'nik_number' => '100004',
                    ],
                ],
            ],
        ];

        foreach ($divisions as $divisionData) {
            $mentors = $divisionData['mentors'];
            unset($divisionData['mentors']);

            // Add mentor_name and nik_number from first mentor to division data
            if (!empty($mentors)) {
                $divisionData['mentor_name'] = $mentors[0]['mentor_name'];
                $divisionData['nik_number'] = $mentors[0]['nik_number'];
            }

            $division = DivisiAdmin::updateOrCreate(
                ['division_name' => $divisionData['division_name']],
                $divisionData
            );

            // Create mentors for this division
            foreach ($mentors as $mentorData) {
                $mentor = DivisionMentor::updateOrCreate(
                    [
                        'division_id' => $division->id,
                        'nik_number' => $mentorData['nik_number'],
                    ],
                    $mentorData
                );

                // Create or update user account for mentor
                $existingUser = \App\Models\User::where('username', $mentorData['nik_number'])->first();
                if (!$existingUser) {
                    \App\Models\User::create([
                        'username' => $mentorData['nik_number'],
                        'name' => $mentorData['mentor_name'],
                        'email' => 'mentor_' . $mentorData['nik_number'] . '@posindonesia.co.id',
                        'password' => \Illuminate\Support\Facades\Hash::make('mentor123'),
                        'role' => 'pembimbing',
                    ]);
                } else {
                    // Update existing user to sync with seeder data
                    $existingUser->update([
                        'name' => $mentorData['mentor_name'],
                        'email' => 'mentor_' . $mentorData['nik_number'] . '@posindonesia.co.id',
                        'role' => 'pembimbing',
                        'password' => \Illuminate\Support\Facades\Hash::make('mentor123'),
                    ]);
                }
            }
        }
    }
}

