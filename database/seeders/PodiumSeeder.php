<?php

namespace Database\Seeders;

use App\Models\Podium;
use App\Models\User;
use App\Models\Novelty;
use App\Models\NoveltiesArena;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PodiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('isActive', true)->get();

        // Podium pour "Heritage Specialist" - Terminée
        $heritageNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Heritage Specialist');
        })->first();

        if ($heritageNovelty) {
            $this->createPodiumForNovelty($heritageNovelty, [
                [
                    'user_email' => 'admin@breitling.com',
                    'position' => 1,
                    'score' => 98, // Score parfait ou presque
                    'points_awarded' => 50000, // 1ère place
                    'time_total_seconds' => 285,
                    'completed_at' => Carbon::now()->subDays(5)->addHours(2),
                ],
                [
                    'user_email' => 'sarah.johnson@breitling.com',
                    'position' => 2,
                    'score' => 95,
                    'points_awarded' => 30000, // 2ème place
                    'time_total_seconds' => 310,
                    'completed_at' => Carbon::now()->subDays(5)->addHours(3),
                ],
                [
                    'user_email' => 'marcus.weber@breitling.com',
                    'position' => 3,
                    'score' => 92,
                    'points_awarded' => 20000, // 3ème place
                    'time_total_seconds' => 295,
                    'completed_at' => Carbon::now()->subDays(4)->addHours(1),
                ],
                [
                    'user_email' => 'anna.kowalski@breitling.com',
                    'position' => 4,
                    'score' => 88,
                    'points_awarded' => 0,
                    'time_total_seconds' => 340,
                    'completed_at' => Carbon::now()->subDays(4)->addHours(4),
                ],
                [
                    'user_email' => 'david.thompson@breitling.com',
                    'position' => 5,
                    'score' => 85,
                    'points_awarded' => 0,
                    'time_total_seconds' => 365,
                    'completed_at' => Carbon::now()->subDays(4)->addHours(6),
                ],
                [
                    'user_email' => 'james.miller@breitling.com',
                    'position' => 6,
                    'score' => 78,
                    'points_awarded' => 0,
                    'time_total_seconds' => 425,
                    'completed_at' => Carbon::now()->subDays(3)->addHours(2),
                ],
                [
                    'user_email' => 'sophie.martin@breitling.com',
                    'position' => 7,
                    'score' => 72,
                    'points_awarded' => 0,
                    'time_total_seconds' => 480,
                    'completed_at' => Carbon::now()->subDays(3)->addHours(5),
                ],
                [
                    'user_email' => 'yuki.tanaka@breitling.com',
                    'position' => 8,
                    'score' => 68,
                    'points_awarded' => 0,
                    'time_total_seconds' => 520,
                    'completed_at' => Carbon::now()->subDays(3)->addHours(8),
                ],
            ], $users);
        }

        // Podium pour "Limited Edition Collector" - Ancienne arena terminée
        $limitedNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Limited Edition Collector');
        })->first();

        if ($limitedNovelty) {
            $this->createPodiumForNovelty($limitedNovelty, [
                [
                    'user_email' => 'marie.dubois@breitling.com',
                    'position' => 1,
                    'score' => 96, // Marie, experte collectionneuse
                    'points_awarded' => 50000,
                    'time_total_seconds' => 320,
                    'completed_at' => Carbon::now()->subDays(15)->addHours(3),
                ],
                [
                    'user_email' => 'marcus.weber@breitling.com',
                    'position' => 2,
                    'score' => 93,
                    'points_awarded' => 30000,
                    'time_total_seconds' => 335,
                    'completed_at' => Carbon::now()->subDays(15)->addHours(5),
                ],
                [
                    'user_email' => 'admin@breitling.com',
                    'position' => 3,
                    'score' => 90,
                    'points_awarded' => 20000,
                    'time_total_seconds' => 310,
                    'completed_at' => Carbon::now()->subDays(14)->addHours(2),
                ],
                [
                    'user_email' => 'anna.kowalski@breitling.com',
                    'position' => 4,
                    'score' => 87,
                    'points_awarded' => 0,
                    'time_total_seconds' => 380,
                    'completed_at' => Carbon::now()->subDays(14)->addHours(6),
                ],
            ], $users);
        }

        // Podium pour une arena fictive plus ancienne - "Professional Master"
        $professionalNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Professional Master');
        })->first();

        if ($professionalNovelty) {
            $this->createPodiumForNovelty($professionalNovelty, [
                [
                    'user_email' => 'sarah.johnson@breitling.com',
                    'position' => 1,
                    'score' => 94,
                    'points_awarded' => 50000,
                    'time_total_seconds' => 298,
                    'completed_at' => Carbon::now()->subDays(35)->addHours(4),
                ],
                [
                    'user_email' => 'thomas.chen@breitling.com',
                    'position' => 2,
                    'score' => 91,
                    'points_awarded' => 30000,
                    'time_total_seconds' => 315,
                    'completed_at' => Carbon::now()->subDays(35)->addHours(6),
                ],
                [
                    'user_email' => 'david.thompson@breitling.com',
                    'position' => 3,
                    'score' => 89,
                    'points_awarded' => 20000,
                    'time_total_seconds' => 342,
                    'completed_at' => Carbon::now()->subDays(34)->addHours(1),
                ],
                [
                    'user_email' => 'elena.rodriguez@breitling.com',
                    'position' => 4,
                    'score' => 85,
                    'points_awarded' => 0,
                    'time_total_seconds' => 355,
                    'completed_at' => Carbon::now()->subDays(34)->addHours(3),
                ],
                [
                    'user_email' => 'admin@breitling.com',
                    'position' => 5,
                    'score' => 83,
                    'points_awarded' => 0,
                    'time_total_seconds' => 290,
                    'completed_at' => Carbon::now()->subDays(34)->addHours(7),
                ],
            ], $users);
        }

        // Podium pour "Movement Specialist" - Arena moyennement ancienne
        $movementNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Movement Specialist');
        })->first();

        if ($movementNovelty) {
            $this->createPodiumForNovelty($movementNovelty, [
                [
                    'user_email' => 'marcus.weber@breitling.com',
                    'position' => 1,
                    'score' => 97, // Marcus, expert mouvements
                    'points_awarded' => 50000,
                    'time_total_seconds' => 275,
                    'completed_at' => Carbon::now()->subDays(25)->addHours(2),
                ],
                [
                    'user_email' => 'thomas.chen@breitling.com',
                    'position' => 2,
                    'score' => 93,
                    'points_awarded' => 30000,
                    'time_total_seconds' => 295,
                    'completed_at' => Carbon::now()->subDays(25)->addHours(4),
                ],
                [
                    'user_email' => 'admin@breitling.com',
                    'position' => 3,
                    'score' => 92,
                    'points_awarded' => 20000,
                    'time_total_seconds' => 288,
                    'completed_at' => Carbon::now()->subDays(24)->addHours(1),
                ],
                [
                    'user_email' => 'anna.kowalski@breitling.com',
                    'position' => 4,
                    'score' => 86,
                    'points_awarded' => 0,
                    'time_total_seconds' => 320,
                    'completed_at' => Carbon::now()->subDays(24)->addHours(5),
                ],
            ], $users);
        }
    }

    /**
     * Créer le podium pour une novelty donnée
     */
    private function createPodiumForNovelty(Novelty $novelty, array $participants, $users): void
    {
        foreach ($participants as $participant) {
            $user = $users->where('email', $participant['user_email'])->first();

            if ($user) {
                Podium::create([
                    'novelties_id' => $novelty->id,
                    'user_id' => $user->id,
                    'position' => $participant['position'],
                    'score' => $participant['score'],
                    'points_awarded' => $participant['points_awarded'],
                    'time_total_seconds' => $participant['time_total_seconds'],
                    'completed_at' => $participant['completed_at'],
                ]);

                // Ajouter les points gagnés à l'utilisateur si c'est un gagnant
                if ($participant['points_awarded'] > 0) {
                    $user->increment('points', $participant['points_awarded']);
                }
            }
        }
    }
}
