<?php

namespace Database\Seeders;

use App\Models\NoveltiesArena;
use App\Models\User;
use App\Models\Novelty;
use App\Models\Quiz;
use App\Models\Rank;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoveltiesArenaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('isActive', true)->get();
        $novelties = Novelty::all();
        $quizzes = Quiz::all();
        $ranks = Rank::all();

        // Arena pour "Heritage Specialist" - Terminée
        $heritageNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Heritage Specialist');
        })->first();

        $heritageQuiz = $quizzes->where('name', 'Breitling Heritage & History')->first();

        $heritageParticipants = [
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'admin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(25),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(23),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(21),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'anna.kowalski@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'anna.kowalski@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'david.thompson@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'david.thompson@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(18),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'james.miller@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'james.miller@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'sophie.martin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'sophie.martin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(12),
                'end_date' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => $users->where('email', 'yuki.tanaka@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'yuki.tanaka@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(4),
            ],
        ];

        foreach ($heritageParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $heritageNovelty->id,
                'quiz_id' => $heritageQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }

        // Arena pour "Aviation Expert" - En cours
        $aviationNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Aviation Expert');
        })->first();

        $aviationQuiz = $quizzes->where('name', 'Aviation Excellence')->first();

        $aviationParticipants = [
            [
                'user_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(11),
            ],
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'admin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(8),
                'end_date' => Carbon::now()->addDays(11),
            ],
            [
                'user_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(6),
                'end_date' => Carbon::now()->addDays(11),
            ],
            [
                'user_id' => $users->where('email', 'david.thompson@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'david.thompson@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(4),
                'end_date' => Carbon::now()->addDays(11),
            ],
            [
                'user_id' => $users->where('email', 'james.miller@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'james.miller@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(11),
            ],
        ];

        foreach ($aviationParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $aviationNovelty->id,
                'quiz_id' => $aviationQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }

        // Arena pour "Superocean Expert" - En cours
        $superoceanNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Superocean Expert');
        })->first();

        $superoceanQuiz = $quizzes->where('name', 'Superocean Depths')->first();

        $superoceanParticipants = [
            [
                'user_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(16),
            ],
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'admin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->addDays(16),
            ],
            [
                'user_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(16),
            ],
        ];

        foreach ($superoceanParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $superoceanNovelty->id,
                'quiz_id' => $superoceanQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }

        // Arena pour "Navitimer Specialist" - Récemment ouverte
        $navitimerNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Navitimer Specialist');
        })->first();

        $navitimerQuiz = $quizzes->where('name', 'Navitimer Mastery')->first();

        $navitimerParticipants = [
            [
                'user_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(20),
            ],
            [
                'user_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subHours(12),
                'end_date' => Carbon::now()->addDays(20),
            ],
        ];

        foreach ($navitimerParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $navitimerNovelty->id,
                'quiz_id' => $navitimerQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }

        // Arena pour "Innovation Pioneer" - Très récente
        $innovationNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Innovation Pioneer');
        })->first();

        $innovationQuiz = $quizzes->where('name', 'Innovation & Future')->first();

        $innovationParticipants = [
            [
                'user_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subHours(6),
                'end_date' => Carbon::now()->addDays(23),
            ],
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'admin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subHours(2),
                'end_date' => Carbon::now()->addDays(23),
            ],
        ];

        foreach ($innovationParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $innovationNovelty->id,
                'quiz_id' => $innovationQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }

        // Arena pour "Limited Edition Collector" - Ancienne, terminée
        $limitedNovelty = Novelty::whereHas('badge', function ($query) {
            $query->where('name', 'Limited Edition Collector');
        })->first();

        $limitedQuiz = $quizzes->where('name', 'Limited Editions & Collectibles')->first();

        $limitedParticipants = [
            [
                'user_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(35),
                'end_date' => Carbon::now()->subDays(14),
            ],
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'admin@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(32),
                'end_date' => Carbon::now()->subDays(14),
            ],
            [
                'user_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(14),
            ],
            [
                'user_id' => $users->where('email', 'anna.kowalski@breitling.com')->first()->id,
                'rank_id' => $users->where('email', 'anna.kowalski@breitling.com')->first()->rank_id,
                'start_date' => Carbon::now()->subDays(28),
                'end_date' => Carbon::now()->subDays(14),
            ],
        ];

        foreach ($limitedParticipants as $participant) {
            NoveltiesArena::create([
                'user_id' => $participant['user_id'],
                'novelties_id' => $limitedNovelty->id,
                'quiz_id' => $limitedQuiz->id,
                'rank_id' => $participant['rank_id'],
                'start_date' => $participant['start_date'],
                'end_date' => $participant['end_date'],
            ]);
        }
    }
}
