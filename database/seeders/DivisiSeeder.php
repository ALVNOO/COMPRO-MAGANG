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
                        'nik_number' => '1000000000000001',
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
                        'nik_number' => '1000000000000002',
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
                        'nik_number' => '1000000000000003',
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
                        'nik_number' => '1000000000000004',
                    ],
                ],
            ],
        ];

        foreach ($divisions as $divisionData) {
            $mentors = $divisionData['mentors'];
            unset($divisionData['mentors']);

            $division = DivisiAdmin::updateOrCreate(
                ['division_name' => $divisionData['division_name']],
                $divisionData
            );

            // Create mentors for this division
            foreach ($mentors as $mentorData) {
                DivisionMentor::updateOrCreate(
                    [
                        'division_id' => $division->id,
                        'nik_number' => $mentorData['nik_number'],
                    ],
                    $mentorData
                );
            }
        }
    }
}

