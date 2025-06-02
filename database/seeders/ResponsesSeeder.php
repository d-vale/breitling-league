<?php

namespace Database\Seeders;

use App\Models\Response;
use App\Models\User;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ResponsesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('isActive', true)->get();
        $questions = Question::with('choices')->get();

        // Simuler des réponses pour différents utilisateurs
        $this->createUserResponses($users, $questions);
    }

    private function createUserResponses($users, $questions)
    {
        foreach ($users as $user) {
            // Nombre de questions répondues basé sur le niveau de l'utilisateur
            $questionsToAnswer = $this->getQuestionsCountForUser($user);
            $selectedQuestions = $questions->random($questionsToAnswer);

            foreach ($selectedQuestions as $question) {
                $this->createResponseForUserQuestion($user, $question);
            }
        }
    }

    private function getQuestionsCountForUser($user)
    {
        // Nombre de questions basé sur les points/rang de l'utilisateur
        if ($user->points >= 1200000) return 75; // Timekeeper - très actif
        if ($user->points >= 600000) return 65;  // Master
        if ($user->points >= 300000) return 55;  // Diamond
        if ($user->points >= 150000) return 45;  // Platinum
        if ($user->points >= 75000) return 35;   // Gold
        if ($user->points >= 25000) return 25;   // Silver
        return 15; // Bronze
    }

    private function createResponseForUserQuestion($user, $question)
    {
        $choices = $question->choices;
        $correctChoice = $choices->where('correcte', true)->first();

        // Probabilité de réponse correcte basée sur l'expérience de l'utilisateur
        $correctProbability = $this->getCorrectProbabilityForUser($user);
        $isCorrect = (rand(1, 100) <= $correctProbability);

        // Temps de réponse basé sur la complexité et l'expérience
        $responseTime = $this->generateResponseTime($user, $isCorrect);

        $startTime = Carbon::now()->subDays(rand(1, 30))->subMinutes(rand(1, 60));
        $endTime = $startTime->copy()->addSeconds($responseTime);

        Response::create([
            'user_id' => $user->id,
            'questions_id' => $question->id,
            'time_question_start' => $startTime,
            'time_question_end' => $endTime,
            'correcte' => $isCorrect,
        ]);
    }

    private function getCorrectProbabilityForUser($user)
    {
        // Probabilité de réponse correcte basée sur les points
        if ($user->points >= 1200000) return 95; // Timekeeper - expert
        if ($user->points >= 600000) return 90;  // Master
        if ($user->points >= 300000) return 85;  // Diamond
        if ($user->points >= 150000) return 80;  // Platinum
        if ($user->points >= 75000) return 75;   // Gold
        if ($user->points >= 25000) return 65;   // Silver
        return 55; // Bronze - débutant
    }

    private function generateResponseTime($user, $isCorrect)
    {
        // Temps de base en secondes
        $baseTime = 30;

        // Modificateur basé sur l'expérience (plus expérimenté = plus rapide)
        $experienceModifier = 1.0;
        if ($user->points >= 300000) $experienceModifier = 0.6; // Très rapide
        elseif ($user->points >= 150000) $experienceModifier = 0.7; // Rapide
        elseif ($user->points >= 75000) $experienceModifier = 0.8; // Moyennement rapide
        elseif ($user->points >= 25000) $experienceModifier = 0.9; // Légèrement plus rapide
        else $experienceModifier = 1.2; // Plus lent (débutant)

        // Les bonnes réponses sont généralement plus rapides
        $correctnessModifier = $isCorrect ? 0.8 : 1.3;

        // Ajouter de la variabilité
        $randomness = rand(70, 130) / 100; // Entre 0.7 et 1.3

        $finalTime = $baseTime * $experienceModifier * $correctnessModifier * $randomness;

        // Limites min/max
        return max(5, min(180, round($finalTime)));
    }
}
