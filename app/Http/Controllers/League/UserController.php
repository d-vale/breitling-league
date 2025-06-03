<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Historique;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get the authenticated user's data
     */
    public function getUser(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            // Load relationships using with() on a fresh query
            $userWithRelations = User::with(['rank', 'badges'])
                ->find($user->id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $userWithRelations->id,
                    'name' => $userWithRelations->name,
                    'lastname' => $userWithRelations->lastname,
                    'firstname' => $userWithRelations->firstname,
                    'nickname' => $userWithRelations->nickname,
                    'email' => $userWithRelations->email,
                    'site_web' => $userWithRelations->site_web,
                    'points' => $userWithRelations->points,
                    'rank' => $userWithRelations->rank,
                    'badges' => $userWithRelations->badges,
                    'profile_complete' => $userWithRelations->profile_complete,
                    'isActive' => $userWithRelations->isActive,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve user data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's complete quiz history
     */
    public function getUserHistory(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            // Build query
            $history = Historique::where('users_id', $user->id)
                ->with(['quiz'])
                ->orderBy('date', 'desc')
                ->paginate(10);

            $totalCount = $history->total();

            // Calculate statistics
            $stats = [
                'total_quizzes' => $totalCount,
                'total_points' => $history->sum('points'),
                'average_points' => $history->count() > 0 ? round($history->avg('points'), 2) : 0,
                'quiz_types' => Historique::where('users_id', $user->id)
                    ->selectRaw('type_quiz, COUNT(*) as count, SUM(points) as total_points')
                    ->groupBy('type_quiz')
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'history' => $history,
                    'statistics' => $stats,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve user history',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's placement quiz progress (first 10 quizzes to determine initial rank)
     */
    public function getUserPlacement(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            // Get the first 10 quiz entries for placement (ordered by date)
            $placementQuizzes = Historique::where('users_id', $user->id)
                ->with(['quiz'])
                ->orderBy('date', 'asc')
                ->take(10)
                ->get();

            $placementCount = $placementQuizzes->count();
            $isPlacementComplete = $placementCount >= 10;

            // Calculate placement statistics
            $totalPlacementPoints = $placementQuizzes->sum('points');
            $averagePointsPerQuiz = $placementCount > 0 ? round($totalPlacementPoints / $placementCount, 2) : 0;

            // Get points per quiz for detailed view
            $pointsPerQuiz = $placementQuizzes->map(function ($quiz, $index) {
                return [
                    'quiz_number' => $index + 1,
                    'quiz_name' => $quiz->quiz->name ?? 'Unknown Quiz',
                    'quiz_type' => $quiz->type_quiz,
                    'points' => $quiz->points,
                    'date' => $quiz->date->format('Y-m-d H:i:s')
                ];
            });

            // Calculate remaining quizzes needed
            $remainingQuizzes = max(0, 10 - $placementCount);

            return response()->json([
                'success' => true,
                'data' => [
                    'placement_complete' => $isPlacementComplete,
                    'completed_quizzes' => $placementCount,
                    'remaining_quizzes' => $remainingQuizzes,
                    'total_points' => $totalPlacementPoints,
                    'average_points_per_quiz' => $averagePointsPerQuiz,
                    'points_per_quiz' => $pointsPerQuiz,
                    'progress_percentage' => ($placementCount / 10) * 100
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve placement progress',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get filtered user quiz history by type
     */
    public function getFilteredHistory($type): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'User not authenticated'
                ], 401);
            }

            // Reconstruct type mapping
            $types = ['battle' => 'Quiz Battle', 'quest' => 'Main Quest', 'arena' => 'Novelties Arena', 'placement' => 'Training'];


            // Get filtered history
            $filteredHistory = Historique::where('users_id', $user->id)
                ->where('type_quiz', $types[$type])
                ->orderBy('date', 'desc')
                ->paginate(10);

            $totalCount = Historique::where('users_id', $user->id)
                ->where('type_quiz', $types[$type])
                ->count();

            // Calculate type-specific statistics
            $typeStats = [
                'total_count' => $totalCount,
                'total_points' => Historique::where('users_id', $user->id)
                    ->where('type_quiz', $types[$type])
                    ->sum('points'),
                'average_points' => Historique::where('users_id', $user->id)
                    ->where('type_quiz', $types[$type])
                    ->avg('points'),
                'best_score' => Historique::where('users_id', $user->id)
                    ->where('type_quiz', $types[$type])
                    ->max('points'),
                'latest_quiz' => Historique::where('users_id', $user->id)
                    ->where('type_quiz', $types[$type])
                    ->latest('date')
                    ->first()
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'type' => $types[$type] ?? 'Unknown Type',
                    'history' => $filteredHistory,
                    'statistics' => $typeStats,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve filtered history',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
