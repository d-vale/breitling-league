<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RankingController extends Controller
{

    /**
     * Obtient le classement global de tous les utilisateurs actifs
     * classés par points décroissants
     */
    public function getGlobalRanking(Request $request): JsonResponse
    {
        try {
            $currentUser = $request->user();

            $users = User::with('rank')
                ->where('isActive', true)
                ->where('profile_complete', true)
                ->orderBy('points', 'desc')
                ->orderBy('created_at', 'asc') // En cas d'égalité, le plus ancien utilisateur est premier
                ->get();

            $ranking = $users->map(function ($user, $index) use ($currentUser) {
                return [
                    'position' => $index + 1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'nickname' => $user->nickname,
                    'points' => $user->points,
                    'is_current_user' => $currentUser ? $user->id === $currentUser->id : false,
                    'rank' => [
                        'id' => $user->rank->id,
                        'name' => $user->rank->name,
                        'min_points' => $user->rank->min_points,
                    ],
                    'created_at' => $user->created_at->toISOString(),
                ];
            });

            // Récupérer les informations de l'utilisateur connecté
            $currentUserInfo = null;
            $currentUserPosition = null;

            if ($currentUser) {
                $currentUserRanking = $ranking->where('is_current_user', true)->first();
                if ($currentUserRanking) {
                    $currentUserPosition = $currentUserRanking['position'];
                    $currentUserInfo = [
                        'id' => $currentUser->id,
                        'name' => $currentUser->name,
                        'nickname' => $currentUser->nickname,
                        'points' => $currentUser->points,
                        'position' => $currentUserPosition,
                        'rank' => $currentUser->rank ? [
                            'id' => $currentUser->rank->id,
                            'name' => $currentUser->rank->name,
                            'min_points' => $currentUser->rank->min_points,
                        ] : null,
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'ranking' => $ranking,
                    'total_users' => $ranking->count(),
                    'current_user' => $currentUserInfo,
                    'current_user_position' => $currentUserPosition,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du classement global',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtient le classement des utilisateurs dans la même ligue
     * que l'utilisateur connecté, classés par points décroissants
     */
    public function getLeagueRanking(Request $request): JsonResponse
    {
        try {
            $currentUser = $request->user();

            if (!$currentUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            if (!$currentUser->rank_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'utilisateur n\'a pas de rang assigné',
                ], 400);
            }

            // Récupérer tous les utilisateurs du même rang
            $users = User::with('rank')
                ->where('isActive', true)
                ->where('profile_complete', true)
                ->where('rank_id', $currentUser->rank_id)
                ->orderBy('points', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();

            $ranking = $users->map(function ($user, $index) use ($currentUser) {
                return [
                    'position' => $index + 1,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'nickname' => $user->nickname,
                    'points' => $user->points,
                    'is_current_user' => $user->id === $currentUser->id,
                    'rank' => [
                        'id' => $user->rank->id,
                        'name' => $user->rank->name,
                        'min_points' => $user->rank->min_points,
                    ],
                    'created_at' => $user->created_at->toISOString(),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'ranking' => $ranking,
                    'league_name' => $currentUser->rank->name,
                    'total_users_in_league' => $ranking->count(),
                    'current_user_position' => $ranking->where('is_current_user', true)->first()['position'] ?? null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du classement de ligue',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Retourne la position de l'utilisateur connecté dans les classements
     * global et de sa ligue
     */
    public function getPosRanking(Request $request): JsonResponse
    {
        try {
            $currentUser = $request->user();

            if (!$currentUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            // Position dans le classement global
            $globalPosition = User::where('isActive', true)
                ->where('profile_complete', true)
                ->where(function ($query) use ($currentUser) {
                    $query->where('points', '>', $currentUser->points)
                        ->orWhere(function ($subQuery) use ($currentUser) {
                            $subQuery->where('points', '=', $currentUser->points)
                                ->where('created_at', '<', $currentUser->created_at);
                        });
                })
                ->count() + 1;

            // Total d'utilisateurs actifs
            $totalUsers = User::where('isActive', true)
                ->where('profile_complete', true)
                ->count();

            // Position dans la ligue (si l'utilisateur a un rang)
            $leaguePosition = null;
            $totalUsersInLeague = null;
            $leagueName = null;

            if ($currentUser->rank_id) {
                $leaguePosition = User::where('isActive', true)
                    ->where('profile_complete', true)
                    ->where('rank_id', $currentUser->rank_id)
                    ->where(function ($query) use ($currentUser) {
                        $query->where('points', '>', $currentUser->points)
                            ->orWhere(function ($subQuery) use ($currentUser) {
                                $subQuery->where('points', '=', $currentUser->points)
                                    ->where('created_at', '<', $currentUser->created_at);
                            });
                    })
                    ->count() + 1;

                $totalUsersInLeague = User::where('isActive', true)
                    ->where('profile_complete', true)
                    ->where('rank_id', $currentUser->rank_id)
                    ->count();

                $leagueName = $currentUser->rank->name;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => [
                        'id' => $currentUser->id,
                        'name' => $currentUser->name,
                        'nickname' => $currentUser->nickname,
                        'points' => $currentUser->points,
                        'rank' => $currentUser->rank ? [
                            'id' => $currentUser->rank->id,
                            'name' => $currentUser->rank->name,
                            'min_points' => $currentUser->rank->min_points,
                        ] : null,
                    ],
                    'global_ranking' => [
                        'position' => $globalPosition,
                        'total_users' => $totalUsers,
                    ],
                    'league_ranking' => $leaguePosition ? [
                        'position' => $leaguePosition,
                        'total_users' => $totalUsersInLeague,
                        'league_name' => $leagueName,
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des positions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Méthode helper pour obtenir le rang suivant d'un utilisateur
     */
    private function getNextRank(User $user): ?Rank
    {
        return Rank::where('min_points', '>', $user->points)
            ->orderBy('min_points', 'asc')
            ->first();
    }

    /**
     * Méthode helper pour calculer les points nécessaires au rang suivant
     */
    private function getPointsToNextRank(User $user): ?int
    {
        $nextRank = $this->getNextRank($user);
        return $nextRank ? $nextRank->min_points - $user->points : null;
    }
}
