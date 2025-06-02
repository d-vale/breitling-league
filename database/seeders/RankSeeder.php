<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            [
                'name' => 'Bronze',
                'min_points' => 0,
            ],
            [
                'name' => 'Silver',
                'min_points' => 25001,
            ],
            [
                'name' => 'Gold',
                'min_points' => 75001,
            ],
            [
                'name' => 'Platinum',
                'min_points' => 150001,
            ],
            [
                'name' => 'Diamond',
                'min_points' => 300001,
            ],
            [
                'name' => 'Master',
                'min_points' => 600001,
            ],
            [
                'name' => 'Timekeeper',
                'min_points' => 1200001,
            ],
        ];

        foreach ($ranks as $rank) {
            Rank::create($rank);
        }
    }
}
