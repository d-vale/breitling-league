<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Choice;
use App\Models\Response;
use App\Models\Historique;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class QuizController extends Controller
{
    /**
     * Retourne un quiz aléatoire avec ses questions et choix
     */
    public function getNewQuiz(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Sélectionner un quiz aléatoire
            $quiz = Quiz::with([
                'questions.choices' => function ($query) {
                    // Mélanger les choix pour éviter que la bonne réponse soit toujours en première position
                    $query->inRandomOrder();
                },
                'questions.novelty.badge'
            ])->inRandomOrder()->first();

            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun quiz disponible',
                ], 404);
            }

            // Mélanger les questions pour plus de variété
            $questions = $quiz->questions->shuffle();

            $formattedQuiz = [
                'quiz_id' => $quiz->id,
                'name' => $quiz->name,
                'description' => $quiz->description,
                'total_questions' => $questions->count(),
                'points_per_question' => 1000, // Points standard par question
                'questions' => $questions->map(function ($question) {
                    return [
                        'question_id' => $question->id,
                        'texte' => $question->texte,
                        'novelty' => [
                            'id' => $question->novelty->id,
                            'formation' => $question->novelty->formation,
                            'badge' => [
                                'id' => $question->novelty->badge->id,
                                'name' => $question->novelty->badge->name,
                                'badge' => $question->novelty->badge->badge,
                            ]
                        ],
                        'choices' => $question->choices->map(function ($choice) {
                            return [
                                'choice_id' => $choice->id,
                                'texte' => $choice->texte,
                                // On ne renvoie pas si c'est correct ou non, c'est au frontend de le découvrir
                            ];
                        })
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedQuiz,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du quiz',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retourne les 10 premiers quiz de placement
     */
    public function getPlacementQuiz(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Récupérer les 10 premiers quiz (quiz de placement)
            $quizzes = Quiz::with([
                'questions.choices' => function ($query) {
                    $query->inRandomOrder();
                },
                'questions.novelty.badge'
            ])
                ->orderBy('id', 'asc')
                ->limit(10)
                ->get();

            if ($quizzes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun quiz de placement disponible',
                ], 404);
            }

            $formattedQuizzes = $quizzes->map(function ($quiz) {
                return [
                    'quiz_id' => $quiz->id,
                    'name' => $quiz->name,
                    'description' => $quiz->description,
                    'total_questions' => $quiz->questions->count(),
                    'max_points' => 8000, // Points maximum par quiz de placement
                    'questions' => $quiz->questions->map(function ($question) {
                        return [
                            'question_id' => $question->id,
                            'texte' => $question->texte,
                            'novelty' => [
                                'id' => $question->novelty->id,
                                'formation' => $question->novelty->formation,
                                'badge' => [
                                    'id' => $question->novelty->badge->id,
                                    'name' => $question->novelty->badge->name,
                                    'badge' => $question->novelty->badge->badge,
                                ]
                            ],
                            'choices' => $question->choices->map(function ($choice) {
                                return [
                                    'choice_id' => $choice->id,
                                    'texte' => $choice->texte,
                                ];
                            })
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'placement_quizzes' => $formattedQuizzes,
                    'total_quizzes' => $formattedQuizzes->count(),
                    'instructions' => 'Complétez les 10 quiz de placement pour déterminer votre rang initial. Chaque quiz peut rapporter jusqu\'à 8,000 points.',
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des quiz de placement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Enregistre la réponse d'un utilisateur à une question
     * Body attendu :
     * {
     *"question_id": 123,
     *"choice_id": 456,
     *"quiz_id": 789,
     *"time_question_start": "2025-06-03T14:30:00.000Z",
     *"time_question_end": "2025-06-03T14:30:25.000Z",
     *"quiz_type": "Main Quest"
     * }
     */
    public function saveAnswer(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Validation des données reçues
            $validator = Validator::make($request->all(), [
                'question_id' => 'required|integer|exists:questions,id',
                'choice_id' => 'required|integer|exists:choices,id',
                'quiz_id' => 'required|integer|exists:quizzes,id',
                'time_question_start' => 'required|date',
                'time_question_end' => 'required|date|after:time_question_start',
                'quiz_type' => 'sometimes|string|in:Main Quest,Quiz Battle,Novelties Arena,Training,Placement'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Vérifier que le choix appartient bien à la question
            $choice = Choice::where('id', $request->choice_id)
                ->where('questions_id', $request->question_id)
                ->first();

            if (!$choice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le choix ne correspond pas à la question',
                ], 400);
            }

            // Déterminer si la réponse est correcte
            $isCorrect = $choice->correcte;

            // Enregistrer temporairement la réponse
            $response = Response::create([
                'user_id' => $user->id,
                'questions_id' => $request->question_id,
                'time_question_start' => $request->time_question_start,
                'time_question_end' => $request->time_question_end,
                'correcte' => $isCorrect,
            ]);

            // Calculer le temps de réponse en secondes
            $startTime = Carbon::parse($request->time_question_start);
            $endTime = Carbon::parse($request->time_question_end);
            $responseTimeSeconds = $endTime->diffInSeconds($startTime);

            // Calculer les points gagnés
            $basePoints = 1000; // Points de base par question
            $pointsEarned = $isCorrect ? $basePoints : 0;

            // Bonus pour les réponses rapides (optionnel)
            if ($isCorrect && $responseTimeSeconds <= 10) {
                $pointsEarned += 200; // Bonus rapidité
            }

            // Mettre à jour les points de l'utilisateur si la réponse est correcte
            if ($isCorrect) {
                $user->increment('points', $pointsEarned);
                // Vérifier si l'utilisateur peut changer de rang
                $this->checkAndUpdateUserRank($user);
            }

            // Vérifier la progression du quiz
            $quiz = Quiz::find($request->quiz_id);
            $totalQuestionsInQuiz = $quiz->questions()->count();
            $userResponsesForQuiz = Response::join('quiz_questions', 'responses.questions_id', '=', 'quiz_questions.questions_id')
                ->where('responses.user_id', $user->id)
                ->where('quiz_questions.quiz_id', $request->quiz_id)
                ->count();

            if ($userResponsesForQuiz >= $totalQuestionsInQuiz) {
                // Quiz terminé, calculer le score total
                $correctAnswers = Response::join('quiz_questions', 'responses.questions_id', '=', 'quiz_questions.questions_id')
                    ->where('responses.user_id', $user->id)
                    ->where('quiz_questions.quiz_id', $request->quiz_id)
                    ->where('responses.correcte', true)
                    ->count();

                $totalQuizPoints = $correctAnswers * $basePoints;

                // Enregistrer dans l'historique
                Historique::create([
                    'quiz_id' => $request->quiz_id,
                    'users_id' => $user->id,
                    'points' => $totalQuizPoints,
                    'date' => now(),
                    'type_quiz' => $request->quiz_type ?? 'Main Quest',
                ]);

                // Supprimer toutes les réponses de l'utilisateur pour ce quiz
                Response::join('quiz_questions', 'responses.questions_id', '=', 'quiz_questions.questions_id')
                    ->where('responses.user_id', $user->id)
                    ->where('quiz_questions.quiz_id', $request->quiz_id)
                    ->delete();
            }

            $responseData = [
                'is_correct' => $isCorrect,
                'correct_choice' => [
                    'choice_id' => $choice->correcte ? $choice->id : $choice->question->choices->where('correcte', true)->first()->id,
                    'texte' => $choice->correcte ? $choice->texte : $choice->question->choices->where('correcte', true)->first()->texte,
                ],
                'points_earned' => $pointsEarned,
                'response_time_seconds' => $responseTimeSeconds,
                'user_total_points' => $user->fresh()->points,
                'quiz_completed' => $userResponsesForQuiz >= $totalQuestionsInQuiz,
            ];

            // Supprimer la réponse si ce n'est pas la dernière question
            if ($userResponsesForQuiz < $totalQuestionsInQuiz) {
                $response->delete();
            }

            return response()->json([
                'success' => true,
                'data' => $responseData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement de la réponse',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Vérifie et met à jour le rang de l'utilisateur si nécessaire
     */
    private function checkAndUpdateUserRank(User $user): void
    {
        $newRank = DB::table('ranks')
            ->where('min_points', '<=', $user->points)
            ->orderBy('min_points', 'desc')
            ->first();

        if ($newRank && $user->rank_id !== $newRank->id) {
            $user->update(['rank_id' => $newRank->id]);
        }
    }
}
