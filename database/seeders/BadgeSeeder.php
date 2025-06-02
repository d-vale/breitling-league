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
            ],
            [
                'badge' => 'aviation_expert.png',
                'name' => 'Aviation Expert',
            ],
            [
                'badge' => 'chronometre_master.png',
                'name' => 'Chronomètre Master',
            ],
            [
                'badge' => 'navitimer_specialist.png',
                'name' => 'Navitimer Specialist',
            ],
            [
                'badge' => 'superocean_expert.png',
                'name' => 'Superocean Expert',
            ],
            [
                'badge' => 'premier_connoisseur.png',
                'name' => 'Premier Connoisseur',
            ],
            [
                'badge' => 'avenger_specialist.png',
                'name' => 'Avenger Specialist',
            ],
            [
                'badge' => 'chronoliner_expert.png',
                'name' => 'Chronoliner Expert',
            ],
            [
                'badge' => 'professional_master.png',
                'name' => 'Professional Master',
            ],
            [
                'badge' => 'movement_specialist.png',
                'name' => 'Movement Specialist',
            ],
            [
                'badge' => 'innovation_pioneer.png',
                'name' => 'Innovation Pioneer',
            ],
            [
                'badge' => 'craftsmanship_expert.png',
                'name' => 'Craftsmanship Expert',
            ],
            [
                'badge' => 'limited_edition_collector.png',
                'name' => 'Limited Edition Collector',
            ],
            [
                'badge' => 'certification_master.png',
                'name' => 'Certification Master',
            ],
            [
                'badge' => 'breitling_ambassador.png',
                'name' => 'Breitling Ambassador',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
