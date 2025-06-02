<?php

namespace Database\Seeders;

use App\Models\Novelty;
use App\Models\Badge;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoveltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = Badge::all();

        $novelties = [
            [
                'badge_id' => $badges->where('name', 'Heritage Specialist')->first()->id,
                'formation' => 'https://formation.breitling.com/heritage-fundamentals',
                'end_bonustime' => Carbon::now()->addDays(21),
                'date_release' => Carbon::now()->subDays(7),
            ],
            [
                'badge_id' => $badges->where('name', 'Aviation Expert')->first()->id,
                'formation' => 'https://formation.breitling.com/aviation-excellence',
                'end_bonustime' => Carbon::now()->addDays(14),
                'date_release' => Carbon::now()->subDays(3),
            ],
            [
                'badge_id' => $badges->where('name', 'Chronomètre Master')->first()->id,
                'formation' => 'https://formation.breitling.com/chronometer-precision',
                'end_bonustime' => Carbon::now()->addDays(18),
                'date_release' => Carbon::now()->subDays(5),
            ],
            [
                'badge_id' => $badges->where('name', 'Navitimer Specialist')->first()->id,
                'formation' => 'https://formation.breitling.com/navitimer-mastery',
                'end_bonustime' => Carbon::now()->addDays(20),
                'date_release' => Carbon::now()->subDays(2),
            ],
            [
                'badge_id' => $badges->where('name', 'Superocean Expert')->first()->id,
                'formation' => 'https://formation.breitling.com/superocean-depths',
                'end_bonustime' => Carbon::now()->addDays(16),
                'date_release' => Carbon::now()->subDays(10),
            ],
            [
                'badge_id' => $badges->where('name', 'Premier Connoisseur')->first()->id,
                'formation' => 'https://formation.breitling.com/premier-elegance',
                'end_bonustime' => Carbon::now()->addDays(22),
                'date_release' => Carbon::now()->subDays(1),
            ],
            [
                'badge_id' => $badges->where('name', 'Avenger Specialist')->first()->id,
                'formation' => 'https://formation.breitling.com/avenger-robustness',
                'end_bonustime' => Carbon::now()->addDays(15),
                'date_release' => Carbon::now()->subDays(8),
            ],
            [
                'badge_id' => $badges->where('name', 'Chronoliner Expert')->first()->id,
                'formation' => 'https://formation.breitling.com/chronoliner-travel',
                'end_bonustime' => Carbon::now()->addDays(19),
                'date_release' => Carbon::now()->subDays(4),
            ],
            [
                'badge_id' => $badges->where('name', 'Professional Master')->first()->id,
                'formation' => 'https://formation.breitling.com/professional-instruments',
                'end_bonustime' => Carbon::now()->addDays(17),
                'date_release' => Carbon::now()->subDays(6),
            ],
            [
                'badge_id' => $badges->where('name', 'Movement Specialist')->first()->id,
                'formation' => 'https://formation.breitling.com/movement-mechanics',
                'end_bonustime' => Carbon::now()->addDays(21),
                'date_release' => Carbon::now()->subDays(9),
            ],
            [
                'badge_id' => $badges->where('name', 'Innovation Pioneer')->first()->id,
                'formation' => 'https://formation.breitling.com/innovation-future',
                'end_bonustime' => Carbon::now()->addDays(23),
                'date_release' => Carbon::now()->subDays(12),
            ],
            [
                'badge_id' => $badges->where('name', 'Craftsmanship Expert')->first()->id,
                'formation' => 'https://formation.breitling.com/craftsmanship-art',
                'end_bonustime' => Carbon::now()->addDays(14),
                'date_release' => Carbon::now()->subDays(11),
            ],
            [
                'badge_id' => $badges->where('name', 'Limited Edition Collector')->first()->id,
                'formation' => 'https://formation.breitling.com/limited-editions',
                'end_bonustime' => Carbon::now()->addDays(20),
                'date_release' => Carbon::now()->subDays(15),
            ],
            [
                'badge_id' => $badges->where('name', 'Certification Master')->first()->id,
                'formation' => 'https://formation.breitling.com/certification-standards',
                'end_bonustime' => Carbon::now()->addDays(18),
                'date_release' => Carbon::now()->subDays(13),
            ],
            [
                'badge_id' => $badges->where('name', 'Breitling Ambassador')->first()->id,
                'formation' => 'https://formation.breitling.com/brand-ambassador',
                'end_bonustime' => Carbon::now()->addDays(25),
                'date_release' => Carbon::now()->subDays(20),
            ],
        ];

        foreach ($novelties as $novelty) {
            Novelty::create($novelty);
        }
    }
}
