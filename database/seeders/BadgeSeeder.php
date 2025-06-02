<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'badge' => 'heritage_specialist.png',
                'name' => 'Heritage Specialist',
                'date_obtained' => null,
            ],
            [
                'badge' => 'aviation_expert.png',
                'name' => 'Aviation Expert',
                'date_obtained' => null,
            ],
            [
                'badge' => 'chronometre_master.png',
                'name' => 'Chronomètre Master',
                'date_obtained' => null,
            ],
            [
                'badge' => 'navitimer_specialist.png',
                'name' => 'Navitimer Specialist',
                'date_obtained' => null,
            ],
            [
                'badge' => 'superocean_expert.png',
                'name' => 'Superocean Expert',
                'date_obtained' => null,
            ],
            [
                'badge' => 'premier_connoisseur.png',
                'name' => 'Premier Connoisseur',
                'date_obtained' => null,
            ],
            [
                'badge' => 'avenger_specialist.png',
                'name' => 'Avenger Specialist',
                'date_obtained' => null,
            ],
            [
                'badge' => 'chronoliner_expert.png',
                'name' => 'Chronoliner Expert',
                'date_obtained' => null,
            ],
            [
                'badge' => 'professional_master.png',
                'name' => 'Professional Master',
                'date_obtained' => null,
            ],
            [
                'badge' => 'movement_specialist.png',
                'name' => 'Movement Specialist',
                'date_obtained' => null,
            ],
            [
                'badge' => 'innovation_pioneer.png',
                'name' => 'Innovation Pioneer',
                'date_obtained' => null,
            ],
            [
                'badge' => 'craftsmanship_expert.png',
                'name' => 'Craftsmanship Expert',
                'date_obtained' => null,
            ],
            [
                'badge' => 'limited_edition_collector.png',
                'name' => 'Limited Edition Collector',
                'date_obtained' => null,
            ],
            [
                'badge' => 'certification_master.png',
                'name' => 'Certification Master',
                'date_obtained' => null,
            ],
            [
                'badge' => 'breitling_ambassador.png',
                'name' => 'Breitling Ambassador',
                'date_obtained' => null,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
