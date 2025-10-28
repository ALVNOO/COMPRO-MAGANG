<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FieldOfInterest;

class FieldOfInterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Administration',
                'description' => 'Kelola administrasi perusahaan, koordinasi operasional, dan dukungan manajerial untuk kelancaran bisnis.',
                'icon' => 'fas fa-building',
                'color' => '#EE2E24',
                'sort_order' => 1,
                'division_count' => 5,
                'position_count' => 45,
                'duration_months' => 6,
                'is_active' => 1
            ],
            [
                'name' => 'Finance',
                'description' => 'Kelola keuangan perusahaan, analisis investasi, dan strategi keuangan yang mendukung pertumbuhan bisnis.',
                'icon' => 'fas fa-calculator',
                'color' => '#EE2E24',
                'sort_order' => 2,
                'division_count' => 6,
                'position_count' => 55,
                'duration_months' => 6
            ],
            [
                'name' => 'Human Capital',
                'description' => 'Kembangkan talenta terbaik, kelola SDM, dan ciptakan lingkungan kerja yang produktif dan inovatif.',
                'icon' => 'fas fa-user-tie',
                'color' => '#EE2E24',
                'sort_order' => 3,
                'division_count' => 4,
                'position_count' => 40,
                'duration_months' => 6
            ],
            [
                'name' => 'Digital Business',
                'description' => 'Eksplorasi strategi bisnis digital, analisis data, dan inovasi yang mengubah cara perusahaan beroperasi.',
                'icon' => 'fas fa-chart-line',
                'color' => '#EE2E24',
                'sort_order' => 4,
                'division_count' => 6,
                'position_count' => 80,
                'duration_months' => 6
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Kembangkan strategi pemasaran digital, kampanye online, dan branding yang efektif di era digital.',
                'icon' => 'fas fa-bullhorn',
                'color' => '#EE2E24',
                'sort_order' => 5,
                'division_count' => 5,
                'position_count' => 60,
                'duration_months' => 6
            ],
            [
                'name' => 'Customer Service',
                'description' => 'Tingkatkan pengalaman pelanggan melalui layanan prima, analisis kebutuhan, dan solusi yang berpusat pada pelanggan.',
                'icon' => 'fas fa-headset',
                'color' => '#EE2E24',
                'sort_order' => 6,
                'division_count' => 4,
                'position_count' => 50,
                'duration_months' => 6
            ],
            [
                'name' => 'Legal',
                'description' => 'Pelajari aspek hukum bisnis, compliance, dan perlindungan hukum untuk operasional perusahaan.',
                'icon' => 'fas fa-gavel',
                'color' => '#EE2E24',
                'sort_order' => 7,
                'division_count' => 3,
                'position_count' => 25,
                'duration_months' => 6
            ],
            [
                'name' => 'Information Technology (IT)',
                'description' => 'Kembangkan keahlian dalam pengembangan software, sistem informasi, dan solusi teknologi yang mendukung bisnis digital.',
                'icon' => 'fas fa-laptop-code',
                'color' => '#EE2E24',
                'sort_order' => 8,
                'division_count' => 12,
                'position_count' => 150,
                'duration_months' => 6
            ],
            [
                'name' => 'Design & Creative',
                'description' => 'Kembangkan kreativitas dalam desain visual, UI/UX, dan konten kreatif yang menarik dan efektif.',
                'icon' => 'fas fa-palette',
                'color' => '#EE2E24',
                'sort_order' => 9,
                'division_count' => 4,
                'position_count' => 35,
                'duration_months' => 6
            ],
            [
                'name' => 'Data & Analytics',
                'description' => 'Analisis data bisnis, business intelligence, dan insights yang mendukung pengambilan keputusan strategis.',
                'icon' => 'fas fa-chart-bar',
                'color' => '#EE2E24',
                'sort_order' => 10,
                'division_count' => 5,
                'position_count' => 45,
                'duration_months' => 6
            ],
            [
                'name' => 'Network & Telecommunications',
                'description' => 'Pelajari teknologi jaringan, infrastruktur telekomunikasi, dan sistem komunikasi yang menghubungkan Indonesia.',
                'icon' => 'fas fa-broadcast-tower',
                'color' => '#EE2E24',
                'sort_order' => 11,
                'division_count' => 8,
                'position_count' => 100,
                'duration_months' => 6
            ],
            [
                'name' => 'Collection Management',
                'description' => 'Kelola pengumpulan data, arsip, dan dokumentasi untuk mendukung efisiensi operasional dan analisis strategis.',
                'icon' => 'fas fa-folder-open',
                'color' => '#EE2E24',
                'sort_order' => 12,
                'division_count' => 4,
                'position_count' => 35,
                'duration_months' => 6
            ],
            [
                'name' => 'Asset Management',
                'description' => 'Kelola aset perusahaan secara efektif, optimasi penggunaan sumber daya, dan strategi investasi aset untuk nilai maksimal.',
                'icon' => 'fas fa-cubes',
                'color' => '#EE2E24',
                'sort_order' => 13,
                'division_count' => 5,
                'position_count' => 40,
                'duration_months' => 6
            ],
            [
                'name' => 'Corporate Social Responsibility (CSR)',
                'description' => 'Kembangkan program sosial dan lingkungan yang berdampak positif bagi masyarakat dan lingkungan sekitar.',
                'icon' => 'fas fa-hands-helping',
                'color' => '#EE2E24',
                'sort_order' => 14,
                'division_count' => 3,
                'position_count' => 25,
                'duration_months' => 6
            ]
        ];

        foreach ($fields as $field) {
            // Add is_active if not set
            if (!isset($field['is_active'])) {
                $field['is_active'] = 1;
            }
            
            // Use updateOrCreate to prevent duplicates based on name
            FieldOfInterest::updateOrCreate(
                ['name' => $field['name']], // Match by name
                $field // Update or create with these values
            );
        }
    }
}
