<?php

namespace Database\Seeders;

use App\Models\Historique;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoriqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('isActive', true)->get();
        $quizzes = Quiz::all();

        // Créer l'historique pour chaque utilisateur
        foreach ($users as $user) {
            $this->createHistoryForUser($user, $quizzes);
        }
    }

    private function createHistoryForUser($user, $quizzes)
    {
        $userQuizCount = $this->getQuizCountForUser($user);

        // Sélectionner des quiz aléatoires (avec possibles répétitions)
        $userQuizzes = collect();
        for ($i = 0; $i < $userQuizCount; $i++) {
            $userQuizzes->push($quizzes->random());
        }

        // Créer les entrées d'historique
        foreach ($userQuizzes as $index => $quiz) {
            $this->createHistoryEntry($user, $quiz, $index, $userQuizCount);
        }
    }

    private function getQuizCountForUser($user)
    {
        // Nombre de quiz complétés basé sur le niveau
        if ($user->points >= 1200000) return rand(80, 120); // Timekeeper - très actif
        if ($user->points >= 600000) return rand(60, 90);   // Master
        if ($user->points >= 300000) return rand(45, 75);   // Diamond
        if ($user->points >= 150000) return rand(30, 60);   // Platinum
        if ($user->points >= 75000) return rand(20, 45);    // Gold
        if ($user->points >= 25000) return rand(10, 30);    // Silver
        return rand(5, 20); // Bronze
    }

    private function createHistoryEntry($user, $quiz, $index, $totalQuizzes)
    {
        // Date du quiz (plus ancien pour les premiers, plus récent pour les derniers)
        $daysAgo = $totalQuizzes - $index;
        $quizDate = Carbon::now()->subDays(rand($daysAgo, $daysAgo + 10))->subHours(rand(0, 23));

        // Type de quiz
        $quizTypes = ['Main Quest', 'Quiz Battle', 'Novelties Arena', 'Training'];
        $typeWeights = [50, 25, 15, 10]; // Probabilités
        $quizType = $this->getRandomWeighted($quizTypes, $typeWeights);

        // Points gagnés basés sur le type et la performance
        $basePoints = 1000; // Points de base par quiz
        $pointsMultiplier = $this->getPointsMultiplier($user, $quizType);
        $earnedPoints = round($basePoints * $pointsMultiplier);

        // Ajouter de la variabilité
        $earnedPoints += rand(-200, 300);
        $earnedPoints = max(100, $earnedPoints); // Minimum 100 points

        Historique::create([
            'quiz_id' => $quiz->id,
            'users_id' => $user->id,
            'points' => $earnedPoints,
            'date' => $quizDate,
            'type_quiz' => $quizType,
        ]);
    }

    private function getPointsMultiplier($user, $quizType)
    {
        $baseMultiplier = 1.0;

        // Multiplicateur basé sur l'expérience
        if ($user->points >= 300000) $baseMultiplier = 1.3; // Experts gagnent plus
        elseif ($user->points >= 150000) $baseMultiplier = 1.2;
        elseif ($user->points >= 75000) $baseMultiplier = 1.1;
        elseif ($user->points < 25000) $baseMultiplier = 0.8; // Débutants gagnent moins

        // Multiplicateur basé sur le type de quiz
        switch ($quizType) {
            case 'Quiz Battle':
                return $baseMultiplier * 1.5; // Quiz Battle rapporte plus
            case 'Novelties Arena':
                return $baseMultiplier * 2.0; // Arena rapporte le plus
            case 'Training':
                return $baseMultiplier * 0.8; // Training rapporte moins
            default: // Main Quest
                return $baseMultiplier;
        }
    }

    private function getRandomWeighted($items, $weights)
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        $currentWeight = 0;
        foreach ($items as $index => $item) {
            $currentWeight += $weights[$index];
            if ($random <= $currentWeight) {
                return $item;
            }
        }

        return $items[0]; // Fallback
    }
}
