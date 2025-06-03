<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RankSeeder::class,          // Doit être en premier pour les relations
            UserSeeder::class,          // Utilisateurs de base
            BadgeSeeder::class,         // Badges avant les novelties
            NoveltySeeder::class,       // Nouveautés qui dépendent des badges
            QuizQuestionSeeder::class,  // Dépend des nouveautés
            HistoriqueSeeder::class,    // Historiques après utilisateurs
            NoveltiesArenaSeeder::class, // Dépend des nouveautés
            NoveltySeeder::class,       // Nouveautés supplémentaires
            UserBadgesSeeder::class,    // Relations utilisateurs-badges
            QuizBattlesSeeder::class,   // Batailles de quiz
        ]);
    }
}
