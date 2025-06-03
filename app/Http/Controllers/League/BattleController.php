<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\QuizBattle;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BattleController extends Controller
{
    /**
     * Retourne toutes les battles qui concernent le rank dans lequel l'utilisateur connecté est
     * Inclut : batailles ouvertes, en cours, et récemment terminées de son rang
     */
    public function getBattles(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            if (!$user->rank_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'utilisateur n\'a pas de rang assigné',
                ], 400);
            }

            // Récupérer les utilisateurs du même rang pour filtrer les battles
            $sameRankUserIds = User::where('rank_id', $user->rank_id)
                ->where('isActive', true)
                ->pluck('id');

            // Récupérer les battles concernant les utilisateurs du même rang
            $battles = QuizBattle::with([
                'user:id,name,nickname,points,rank_id',
                'challenger:id,name,nickname,points,rank_id',
                'winner:id,name,nickname,points,rank_id',
                'quiz:id,name,description,earned_points'
            ])
                ->where(function ($query) use ($sameRankUserIds) {
                    // Battles où l'utilisateur créateur ou le challenger est du même rang
                    $query->whereIn('user_id', $sameRankUserIds)
                        ->orWhereIn('user_challenger_id', $sameRankUserIds);
                })
                ->orderBy('date_posted', 'desc')
                ->get();

            // Categoriser les battles
            $openBattles = [];
            $activeBattles = [];
            $recentBattles = [];

            foreach ($battles as $battle) {
                $battleData = [
                    'battle_id' => $battle->id,
                    'quiz' => [
                        'id' => $battle->quiz->id,
                        'name' => $battle->quiz->name,
                        'description' => $battle->quiz->description,
                        'earned_points' => $battle->quiz->earned_points,
                    ],
                    'creator' => [
                        'id' => $battle->user->id,
                        'name' => $battle->user->name,
                        'nickname' => $battle->user->nickname,
                        'points' => $battle->user->points,
                        'is_current_user' => $battle->user->id === $user->id,
                    ],
                    'challenger' => $battle->challenger ? [
                        'id' => $battle->challenger->id,
                        'name' => $battle->challenger->name,
                        'nickname' => $battle->challenger->nickname,
                        'points' => $battle->challenger->points,
                        'is_current_user' => $battle->challenger->id === $user->id,
                    ] : null,
                    'winner' => $battle->winner ? [
                        'id' => $battle->winner->id,
                        'name' => $battle->winner->name,
                        'nickname' => $battle->winner->nickname,
                        'points' => $battle->winner->points,
                        'is_current_user' => $battle->winner->id === $user->id,
                    ] : null,
                    'bet_points' => $battle->bet_points,
                    'date_posted' => $battle->date_posted->toISOString(),
                    'end_date' => $battle->end_date ? $battle->end_date->toISOString() : null,
                    'status' => $this->getBattleStatus($battle),
                    'time_remaining_hours' => $battle->end_date ?
                        max(0, Carbon::now()->diffInHours($battle->end_date, false)) : null,
                    'can_accept' => $this->canUserAcceptBattle($battle, $user),
                    'can_participate' => $this->canUserParticipate($battle, $user),
                ];

                // Categoriser selon le statut
                switch ($battleData['status']) {
                    case 'open':
                        $openBattles[] = $battleData;
                        break;
                    case 'active':
                        $activeBattles[] = $battleData;
                        break;
                    case 'completed':
                    case 'expired':
                        $recentBattles[] = $battleData;
                        break;
                }
            }

            // Limiter les battles récentes à 10 pour éviter une liste trop longue
            $recentBattles = array_slice($recentBattles, 0, 10);

            return response()->json([
                'success' => true,
                'data' => [
                    'user_rank' => [
                        'id' => $user->rank->id,
                        'name' => $user->rank->name,
                        'min_points' => $user->rank->min_points,
                    ],
                    'open_battles' => $openBattles,
                    'active_battles' => $activeBattles,
                    'recent_battles' => $recentBattles,
                    'total_battles' => count($openBattles) + count($activeBattles) + count($recentBattles),
                    'user_active_battle_count' => $this->getUserActiveBattleCount($user),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des battles',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retourne les informations détaillées d'une battle spécifique
     */
    public function getBattleQuiz(Request $request, $quizId): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Récupérer la battle avec ses relations
            $battle = QuizBattle::with([
                'user:id,name,nickname,points,rank_id',
                'user.rank', // Ajouter le rang du créateur
                'challenger:id,name,nickname,points,rank_id',
                'challenger.rank', // Ajouter le rang du challenger
                'winner:id,name,nickname,points,rank_id',
                'quiz.questions.choices' => function ($query) {
                    $query->inRandomOrder(); // Mélanger les choix
                },
                'quiz.questions.novelty.badge'
            ])->find($quizId);

            if (!$battle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Battle non trouvée',
                ], 404);
            }

            // Vérifier si l'utilisateur peut voir cette battle
            if (!$this->canUserViewBattle($battle, $user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas accès à cette battle',
                ], 403);
            }

            // Déterminer le rang concerné par la battle (celui du créateur)
            $battleRank = $battle->user->rank;

            $battleData = [
                'battle_id' => $battle->id,
                'quiz' => [
                    'id' => $battle->quiz->id,
                    'name' => $battle->quiz->name,
                    'description' => $battle->quiz->description,
                    'total_questions' => $battle->quiz->questions->count(),
                    'questions' => $battle->quiz->questions->map(function ($question) {
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
                ],
                'creator' => [
                    'id' => $battle->user->id,
                    'name' => $battle->user->name,
                    'nickname' => $battle->user->nickname,
                    'points' => $battle->user->points,
                    'is_current_user' => $battle->user->id === $user->id,
                    'rank' => [
                        'id' => $battle->user->rank->id,
                        'name' => $battle->user->rank->name,
                        'min_points' => $battle->user->rank->min_points,
                    ],
                ],
                'challenger' => $battle->challenger ? [
                    'id' => $battle->challenger->id,
                    'name' => $battle->challenger->name,
                    'nickname' => $battle->challenger->nickname,
                    'points' => $battle->challenger->points,
                    'is_current_user' => $battle->challenger->id === $user->id,
                    'rank' => [
                        'id' => $battle->challenger->rank->id,
                        'name' => $battle->challenger->rank->name,
                        'min_points' => $battle->challenger->rank->min_points,
                    ],
                ] : null,
                'winner' => $battle->winner ? [
                    'id' => $battle->winner->id,
                    'name' => $battle->winner->name,
                    'nickname' => $battle->winner->nickname,
                    'points' => $battle->winner->points,
                    'is_current_user' => $battle->winner->id === $user->id,
                ] : null,
                'battle_rank' => [
                    'id' => $battleRank->id,
                    'name' => $battleRank->name,
                    'min_points' => $battleRank->min_points,
                ],
                'bet_points' => $battle->bet_points,
                'date_posted' => $battle->date_posted->toISOString(),
                'end_date' => $battle->end_date ? $battle->end_date->toISOString() : null,
                'status' => $this->getBattleStatus($battle),
                'time_remaining_hours' => $battle->end_date ?
                    max(0, Carbon::now()->diffInHours($battle->end_date, false)) : null,
                'can_accept' => $this->canUserAcceptBattle($battle, $user),
                'can_participate' => $this->canUserParticipate($battle, $user),
                'user_role' => $this->getUserRoleInBattle($battle, $user),
            ];

            return response()->json([
                'success' => true,
                'data' => $battleData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de la battle',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crée une nouvelle battle ou accepte une battle existante
     *
     * Body attendu pour créer une battle :
     * {
     *   "action": "create",
     *   "quiz_id": 123,
     *   "bet_points": 5000
     * }
     *
     * Body attendu pour accepter une battle :
     * {
     *   "action": "accept",
     *   "battle_id": 456
     * }
     */
    public function postBattleQuiz(Request $request, $quizId): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Validation des données de base
            $validator = Validator::make($request->all(), [
                'action' => 'required|string|in:create,accept',
                'quiz_id' => 'required_if:action,create|integer|exists:quizzes,id',
                'bet_points' => 'required_if:action,create|integer|min:1000|max:50000',
                'battle_id' => 'required_if:action,accept|integer|exists:quiz_battles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $action = $request->input('action');

            if ($action === 'create') {
                return $this->createBattle($request, $user);
            } elseif ($action === 'accept') {
                return $this->acceptBattle($request, $user);
            }

            return response()->json([
                'success' => false,
                'message' => 'Action non valide',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du traitement de la battle',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Supprime une battle (uniquement par son créateur si elle n'a pas été acceptée)
     *
     * Body attendu :
     * {
     *   "battle_id": 123
     * }
     */
    public function deleteBattle(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Validation
            $validator = Validator::make($request->all(), [
                'battle_id' => 'required|integer|exists:quiz_battles,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $battle = QuizBattle::find($request->battle_id);

            if (!$battle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Battle non trouvée',
                ], 404);
            }

            // Vérifications de sécurité
            if ($battle->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez supprimer que vos propres battles',
                ], 403);
            }

            if ($battle->user_challenger_id !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer une battle qui a été acceptée',
                ], 400);
            }

            if ($battle->end_date && Carbon::now()->greaterThan($battle->end_date)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Impossible de supprimer une battle expirée',
                ], 400);
            }

            // Rembourser les points misés au créateur
            $user->increment('points', $battle->bet_points);

            // Supprimer la battle
            $battle->delete();

            return response()->json([
                'success' => true,
                'message' => 'Battle supprimée avec succès',
                'data' => [
                    'refunded_points' => $battle->bet_points,
                    'user_total_points' => $user->fresh()->points,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la battle',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Méthodes helper privées

    private function createBattle(Request $request, User $user): JsonResponse
    {
        // Vérifier que l'utilisateur a assez de points
        $betPoints = $request->input('bet_points');
        if ($user->points < $betPoints) {
            return response()->json([
                'success' => false,
                'message' => 'Points insuffisants pour cette mise',
            ], 400);
        }

        // Vérifier qu'il n'a pas déjà une battle active
        $activeBattles = QuizBattle::where('user_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('user_challenger_id')
                    ->orWhereNull('winner_id');
            })
            ->count();

        if ($activeBattles > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà une battle active. Terminez-la avant d\'en créer une nouvelle.',
            ], 400);
        }

        // Débiter les points
        $user->decrement('points', $betPoints);

        // Créer la battle
        $battle = QuizBattle::create([
            'user_id' => $user->id,
            'user_challenger_id' => null,
            'winner_id' => null,
            'quiz_id' => $request->input('quiz_id'),
            'bet_points' => $betPoints,
            'date_posted' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(3), // 72 heures pour accepter
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Battle créée avec succès',
            'data' => [
                'battle_id' => $battle->id,
                'bet_points' => $betPoints,
                'user_points_remaining' => $user->fresh()->points,
                'end_date' => $battle->end_date->toISOString(),
            ],
        ]);
    }

    private function acceptBattle(Request $request, User $user): JsonResponse
    {
        $battle = QuizBattle::find($request->input('battle_id'));

        if (!$battle) {
            return response()->json([
                'success' => false,
                'message' => 'Battle non trouvée',
            ], 404);
        }

        // Vérifications
        if ($battle->user_id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas accepter votre propre battle',
            ], 400);
        }

        if ($battle->user_challenger_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Cette battle a déjà été acceptée',
            ], 400);
        }

        if ($battle->end_date && Carbon::now()->greaterThan($battle->end_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Cette battle a expiré',
            ], 400);
        }

        if ($user->points < $battle->bet_points) {
            return response()->json([
                'success' => false,
                'message' => 'Points insuffisants pour accepter cette battle',
            ], 400);
        }

        // Débiter les points du challenger
        $user->decrement('points', $battle->bet_points);

        // Mettre à jour la battle
        $battle->update([
            'user_challenger_id' => $user->id,
            'end_date' => Carbon::now()->addDays(3), // 72 heures pour terminer
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Battle acceptée avec succès',
            'data' => [
                'battle_id' => $battle->id,
                'bet_points' => $battle->bet_points,
                'user_points_remaining' => $user->fresh()->points,
                'end_date' => $battle->end_date->toISOString(),
            ],
        ]);
    }

    private function getBattleStatus(QuizBattle $battle): string
    {
        if ($battle->winner_id !== null) {
            return 'completed';
        }

        if ($battle->end_date && Carbon::now()->greaterThan($battle->end_date)) {
            return 'expired';
        }

        if ($battle->user_challenger_id === null) {
            return 'open';
        }

        return 'active';
    }

    private function canUserAcceptBattle(QuizBattle $battle, User $user): bool
    {
        return $battle->user_challenger_id === null
            && $battle->user_id !== $user->id
            && $user->points >= $battle->bet_points
            && (!$battle->end_date || Carbon::now()->lessThan($battle->end_date))
            && $this->getUserActiveBattleCount($user) === 0;
    }

    private function canUserParticipate(QuizBattle $battle, User $user): bool
    {
        return ($battle->user_id === $user->id || $battle->user_challenger_id === $user->id)
            && $battle->winner_id === null
            && (!$battle->end_date || Carbon::now()->lessThan($battle->end_date));
    }

    private function canUserViewBattle(QuizBattle $battle, User $user): bool
    {
        // L'utilisateur peut voir la battle s'il en fait partie ou s'il est du même rang
        return $battle->user_id === $user->id
            || $battle->user_challenger_id === $user->id
            || $battle->user->rank_id === $user->rank_id
            || ($battle->challenger && $battle->challenger->rank_id === $user->rank_id);
    }

    private function getUserRoleInBattle(QuizBattle $battle, User $user): string
    {
        if ($battle->user_id === $user->id) {
            return 'creator';
        } elseif ($battle->user_challenger_id === $user->id) {
            return 'challenger';
        }
        return 'spectator';
    }

    private function getUserActiveBattleCount(User $user): int
    {
        return QuizBattle::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('user_challenger_id', $user->id);
        })
            ->whereNull('winner_id')
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>', Carbon::now());
            })
            ->count();
    }
}
