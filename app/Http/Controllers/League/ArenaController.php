<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;

use App\Models\Novelty;
use App\Models\NoveltiesArena;
use App\Models\Podium;
use App\Models\Quiz;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArenaController extends Controller
{
    /**
     * Vérifie si une nouveauté (novelty) est en cours pour le rang de l'utilisateur
     * Retourne la nouveauté active avec ses détails si elle existe
     *
     * @return JsonResponse
     */
    public function isNoveltyOccuring(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Vérifier si l'utilisateur a un rang assigné
            if (!$user->rank_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'utilisateur n\'a pas de rang assigné'
                ], 400);
            }

            // Chercher une arène de nouveauté active (en cours) pour le rang de l'utilisateur
            $currentDate = Carbon::now();
            $activeNovelty = NoveltiesArena::with(['novelty.badge'])
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('rank_id', $user->rank_id) // Filtrer par le rang de l'utilisateur
                ->first();

            if (!$activeNovelty) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'is_active' => false,
                        'message' => 'Aucune nouveauté en cours actuellement pour votre rang',
                    ]
                ]);
            }

            // Vérifier si l'utilisateur participe déjà à cette arène
            $userParticipating = NoveltiesArena::where('user_id', $user->id)
                ->where('novelties_id', $activeNovelty->novelties_id)
                ->where('rank_id', $user->rank_id)
                ->exists();

            // Calculer combien de temps reste avant la fin de l'arène
            $hoursRemaining = $currentDate->diffInHours($activeNovelty->end_date, false);
            $daysRemaining = $currentDate->diffInDays($activeNovelty->end_date, false);

            return response()->json([
                'success' => true,
                'data' => [
                    'is_active' => true,
                    'novelty' => [
                        'id' => $activeNovelty->novelties_id,
                        'badge' => [
                            'id' => $activeNovelty->novelty->badge->id,
                            'name' => $activeNovelty->novelty->badge->name,
                            'image' => $activeNovelty->novelty->badge->badge,
                            'description' => $activeNovelty->novelty->badge->description,
                        ],
                        'formation' => $activeNovelty->novelty->formation,
                        'release_date' => $activeNovelty->novelty->date_release,
                    ],
                    'arena' => [
                        'id' => $activeNovelty->id,
                        'start_date' => $activeNovelty->start_date,
                        'end_date' => $activeNovelty->end_date,
                        'hours_remaining' => $hoursRemaining,
                        'days_remaining' => $daysRemaining,
                        'rank' => [
                            'id' => $activeNovelty->rank_id,
                            'name' => $activeNovelty->rank->name,
                        ],
                    ],
                    'user_participating' => $userParticipating,
                    'total_participants' => NoveltiesArena::where('novelties_id', $activeNovelty->novelties_id)
                        ->where('rank_id', $user->rank_id)
                        ->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la vérification des nouveautés',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère le quiz de l'arène active pour le rang de l'utilisateur avec toutes ses informations
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getArenaQuiz(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Vérifier si l'utilisateur a un rang assigné
            if (!$user->rank_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'utilisateur n\'a pas de rang assigné'
                ], 400);
            }

            // Chercher une arène de nouveauté active pour le rang de l'utilisateur
            $currentDate = Carbon::now();
            $activeNovelty = NoveltiesArena::with([
                'novelty.badge',
                'user',
                'rank',
            ])
                ->where('start_date', '<=', $currentDate)
                ->where('end_date', '>=', $currentDate)
                ->where('rank_id', $user->rank_id) // Filtrer par le rang de l'utilisateur
                ->first();

            if (!$activeNovelty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune arène active en ce moment pour votre rang'
                ], 404);
            }

            // Récupérer le quiz associé à cette arène directement via le quiz_id
            $quiz = Quiz::with([
                'questions.choices' => function ($query) {
                    // Mélanger les choix pour éviter que la bonne réponse soit toujours en première position
                    $query->inRandomOrder();
                },
                'questions.novelty.badge'
            ])->find($activeNovelty->quiz_id);

            if (!$quiz) {
                return response()->json([
                    'success' => false,
                    'message' => 'Quiz non trouvé pour cette arène'
                ], 404);
            }

            // Vérifier si l'utilisateur est déjà inscrit à cette arène
            $userParticipating = NoveltiesArena::where('user_id', $user->id)
                ->where('novelties_id', $activeNovelty->novelties_id)
                ->where('rank_id', $user->rank_id)
                ->exists();

            // Si l'utilisateur n'est pas inscrit, l'inscrire automatiquement
            if (!$userParticipating) {
                NoveltiesArena::create([
                    'user_id' => $user->id,
                    'novelties_id' => $activeNovelty->novelties_id,
                    'quiz_id' => $quiz->id,
                    'rank_id' => $user->rank_id,
                    'start_date' => $currentDate,
                    'end_date' => $activeNovelty->end_date,
                ]);
            }

            // Format de la réponse avec le quiz complet
            $formattedQuiz = [
                'quiz_id' => $quiz->id,
                'name' => $quiz->name,
                'description' => $quiz->description,
                'total_questions' => $quiz->questions->count(),
                'points_per_question' => 1500, // Points spéciaux pour l'arène
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

            // Nombre de participants du même rang à cette arène
            $totalParticipants = NoveltiesArena::where('novelties_id', $activeNovelty->novelties_id)
                ->where('rank_id', $user->rank_id)
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'arena_id' => $activeNovelty->id,
                    'novelty' => [
                        'id' => $activeNovelty->novelties_id,
                        'badge' => [
                            'id' => $activeNovelty->novelty->badge->id,
                            'name' => $activeNovelty->novelty->badge->name,
                            'image' => $activeNovelty->novelty->badge->badge,
                        ],
                        'formation' => $activeNovelty->novelty->formation,
                    ],
                    'rank' => [
                        'id' => $activeNovelty->rank_id,
                        'name' => $activeNovelty->rank->name,
                    ],
                    'start_date' => $activeNovelty->start_date,
                    'end_date' => $activeNovelty->end_date,
                    'hours_remaining' => $currentDate->diffInHours($activeNovelty->end_date, false),
                    'total_participants' => $totalParticipants,
                    'quiz' => $formattedQuiz,
                    'instructions' => 'Répondez correctement à toutes les questions pour obtenir le badge et gagner des points. Les trois meilleurs participants recevront des récompenses supplémentaires!',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du quiz de l\'arène',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère les résultats et le podium d'une arène spécifique
     * Ne montre que les résultats des utilisateurs du même rang
     *
     * @param int $arenaId
     * @return JsonResponse
     */
    public function getArenaResults($arenaId): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Vérifier que l'arène existe
            $arena = NoveltiesArena::find($arenaId);

            if (!$arena) {
                return response()->json([
                    'success' => false,
                    'message' => 'Arène non trouvée'
                ], 404);
            }

            // Vérifier si l'utilisateur peut voir les résultats de cette arène (même rang)
            if ($arena->rank_id !== $user->rank_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas accéder aux résultats d\'une arène qui n\'est pas de votre rang'
                ], 403);
            }

            // Récupérer la nouveauté associée à cette arène
            $novelty = Novelty::with('badge')->find($arena->novelties_id);

            if (!$novelty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nouveauté associée non trouvée'
                ], 404);
            }

            // Vérifier si l'arène est terminée
            $isCompleted = Carbon::now()->greaterThan($arena->end_date);

            // Récupérer les résultats du podium pour cette arène et ce rang
            $podiumResults = Podium::where('novelties_id', $arena->novelties_id)
                ->whereHas('user', function ($query) use ($arena) {
                    $query->where('rank_id', $arena->rank_id); // Filtrer par le rang de l'arène
                })
                ->with('user:id,name,nickname,points,rank_id')
                ->orderBy('position')
                ->get();

            // Organiser les résultats par position
            $formattedPodium = [
                'first_place' => null,
                'second_place' => null,
                'third_place' => null,
                'other_participants' => []
            ];

            foreach ($podiumResults as $result) {
                $resultData = [
                    'user_id' => $result->user->id,
                    'name' => $result->user->name,
                    'nickname' => $result->user->nickname,
                    'points' => $result->user->points,
                    'score' => $result->score,
                    'points_awarded' => $result->points_awarded,
                    'completion_time' => $result->time_total_seconds,
                    'completed_at' => $result->completed_at,
                    'position_emoji' => $result->getPositionEmojiAttribute(),
                    'is_current_user' => $result->user_id === $user->id,
                ];

                switch ($result->position) {
                    case 1:
                        $formattedPodium['first_place'] = $resultData;
                        break;
                    case 2:
                        $formattedPodium['second_place'] = $resultData;
                        break;
                    case 3:
                        $formattedPodium['third_place'] = $resultData;
                        break;
                    default:
                        $formattedPodium['other_participants'][] = $resultData;
                }
            }

            // Position de l'utilisateur s'il a participé
            $userResult = $podiumResults->where('user_id', $user->id)->first();
            $userPosition = $userResult ? $userResult->position : null;

            // Récupérer le nombre total de participants du même rang
            $totalParticipants = NoveltiesArena::where('novelties_id', $arena->novelties_id)
                ->where('rank_id', $arena->rank_id)
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'arena_id' => $arenaId,
                    'novelty' => [
                        'id' => $novelty->id,
                        'badge' => [
                            'id' => $novelty->badge->id,
                            'name' => $novelty->badge->name,
                            'image' => $novelty->badge->badge,
                            'description' => $novelty->badge->description,
                        ],
                        'formation' => $novelty->formation,
                    ],
                    'rank' => [
                        'id' => $arena->rank_id,
                        'name' => $arena->rank->name,
                    ],
                    'is_completed' => $isCompleted,
                    'start_date' => $arena->start_date,
                    'end_date' => $arena->end_date,
                    'total_participants' => $totalParticipants,
                    'podium' => $formattedPodium,
                    'user_position' => $userPosition,
                    'current_date' => Carbon::now()->toISOString(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des résultats de l\'arène',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
