<?php

namespace Database\Seeders;

use App\Models\QuizBattle;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuizBattlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('isActive', true)->get();
        $quizzes = Quiz::all();

        $battles = [
            // Bataille terminée - Sarah vs Marcus (Diamond tier)
            [
                'user_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Aviation Excellence')->first()->id,
                'bet_points' => 10000,
                'date_posted' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->subDays(4),
            ],

            // Bataille terminée - Elena vs Thomas (Platinum tier)
            [
                'user_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Innovation & Future')->first()->id,
                'bet_points' => 8000,
                'date_posted' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->subDays(2),
            ],

            // Bataille terminée - Marie vs David (Gold tier)
            [
                'user_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'david.thompson@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Limited Editions & Collectibles')->first()->id,
                'bet_points' => 6000,
                'date_posted' => Carbon::now()->subDays(7),
                'end_date' => Carbon::now()->subDays(6),
            ],

            // Bataille terminée - James vs Lisa (Silver tier)
            [
                'user_id' => $users->where('email', 'james.miller@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'lisa.anderson@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'lisa.anderson@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Premier Elegance')->first()->id,
                'bet_points' => 4000,
                'date_posted' => Carbon::now()->subDays(4),
                'end_date' => Carbon::now()->subDays(3),
            ],

            // Bataille en cours - Marcus vs Elena (cross-tier battle)
            [
                'user_id' => $users->where('email', 'marcus.weber@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->id,
                'winner_id' => null, // Pas encore terminé
                'quiz_id' => $quizzes->where('name', 'Movement Mechanics')->first()->id,
                'bet_points' => 12000,
                'date_posted' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addHours(22), // Se termine bientôt
            ],

            // Bataille en cours - David vs Anna (Gold tier)
            [
                'user_id' => $users->where('email', 'david.thompson@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'anna.kowalski@breitling.com')->first()->id,
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Breitling Heritage & History')->first()->id,
                'bet_points' => 7000,
                'date_posted' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(2),
            ],

            // Défi ouvert - Roberto attend un challenger (Silver tier)
            [
                'user_id' => $users->where('email', 'roberto.silva@breitling.com')->first()->id,
                'user_challenger_id' => null, // Pas encore accepté
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Professional Instruments')->first()->id,
                'bet_points' => 5000,
                'date_posted' => Carbon::now()->subHours(12),
                'end_date' => Carbon::now()->addDays(3),
            ],

            // Défi ouvert - Sophie attend un challenger (Bronze tier)
            [
                'user_id' => $users->where('email', 'sophie.martin@breitling.com')->first()->id,
                'user_challenger_id' => null,
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Breitling Heritage & History')->first()->id,
                'bet_points' => 3000,
                'date_posted' => Carbon::now()->subHours(6),
                'end_date' => Carbon::now()->addDays(3),
            ],

            // Bataille ancienne terminée - Thomas vs Sarah
            [
                'user_id' => $users->where('email', 'thomas.chen@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Chronometer Precision')->first()->id,
                'bet_points' => 9000,
                'date_posted' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->subDays(14),
            ],

            // Bataille expirée - Yuki vs Michael (Bronze tier) - non acceptée à temps
            [
                'user_id' => $users->where('email', 'yuki.tanaka@breitling.com')->first()->id,
                'user_challenger_id' => null, // Jamais accepté
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Breitling Heritage & History')->first()->id,
                'bet_points' => 2000,
                'date_posted' => Carbon::now()->subDays(4),
                'end_date' => Carbon::now()->subDay(), // Expiré hier
            ],

            // Bataille high-stakes entre top players
            [
                'user_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'sarah.johnson@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'admin@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Brand Ambassador Mastery')->first()->id,
                'bet_points' => 25000, // Gros enjeu
                'date_posted' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(9),
            ],

            // Défi ouvert récent - Marie (Gold tier)
            [
                'user_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->id,
                'user_challenger_id' => null,
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Craftsmanship & Art')->first()->id,
                'bet_points' => 8000,
                'date_posted' => Carbon::now()->subHours(2),
                'end_date' => Carbon::now()->addDays(3),
            ],

            // Bataille entre utilisateurs Silver
            [
                'user_id' => $users->where('email', 'lisa.anderson@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'roberto.silva@breitling.com')->first()->id,
                'winner_id' => $users->where('email', 'lisa.anderson@breitling.com')->first()->id,
                'quiz_id' => $quizzes->where('name', 'Premier Elegance')->first()->id,
                'bet_points' => 4500,
                'date_posted' => Carbon::now()->subDays(8),
                'end_date' => Carbon::now()->subDays(7),
            ],

            // Bataille en cours - Elena vs Marie (cross-tier)
            [
                'user_id' => $users->where('email', 'elena.rodriguez@breitling.com')->first()->id,
                'user_challenger_id' => $users->where('email', 'marie.dubois@breitling.com')->first()->id,
                'winner_id' => null,
                'quiz_id' => $quizzes->where('name', 'Superocean Depths')->first()->id,
                'bet_points' => 9000,
                'date_posted' => Carbon::now()->subHours(18),
                'end_date' => Carbon::now()->addDays(2)->addHours(6),
            ],
        ];

        foreach ($battles as $battleData) {
            QuizBattle::create($battleData);
        }
    }
}
