<?php

namespace App\Http\Controllers\League;
use App\Http\Controllers\Controller;

use App\Models\Badge;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BadgeController extends Controller
{
    /**
     * Récupère tous les badges de l'utilisateur connecté
     *
     * @return JsonResponse
     */
    public function getBadges(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Récupérer les badges de l'utilisateur avec les informations sur la date d'obtention
            $userWithBadges = User::with(['badges' => function($query) {
                $query->select('badges.*', 'user_badges.date_obtained');
            }])->find($user->id);

            // Formatter la réponse
            $badges = $userWithBadges->badges->map(function($badge) {
                return [
                    'id' => $badge->id,
                    'name' => $badge->name,
                    'badge' => $badge->badge, // Nom de l'image
                    'description' => $badge->description,
                    'date_obtained' => $badge->pivot->date_obtained,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'user_id' => $user->id,
                    'total_badges' => $badges->count(),
                    'badges' => $badges
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des badges',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crée un nouveau badge dans la base de données
     *
     * Body attendu:
     * {
     *   "name": "Nom du badge",
     *   "badge": "nom_fichier_image.png",
     *   "description": "Description du badge"
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addBadge(Request $request): JsonResponse
    {
        try {
            // Validation de la requête
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'badge' => 'required|string|max:255', // Nom du fichier image
                'description' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Créer le nouveau badge
            $badge = Badge::create([
                'name' => $request->input('name'),
                'badge' => $request->input('badge'),
                'description' => $request->input('description'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Badge créé avec succès',
                'data' => $badge
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du badge',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajoute un badge existant à l'utilisateur connecté
     *
     * Body attendu:
     * {
     *   "badge_id": 1
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addBadgeToUser(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non authentifié'
                ], 401);
            }

            // Validation de la requête
            $validator = Validator::make($request->all(), [
                'badge_id' => 'required|integer|exists:badges,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Données invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            $badgeId = $request->input('badge_id');

            // Vérifier si l'utilisateur a déjà ce badge
            if ($user->badges()->where('badge_id', $badgeId)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'L\'utilisateur possède déjà ce badge'
                ], 400);
            }

            // Récupérer le badge
            $badge = Badge::find($badgeId);

            // Attacher le badge à l'utilisateur
            $user->badges()->attach($badgeId, [
                'date_obtained' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Badge ajouté à l\'utilisateur avec succès',
                'data' => [
                    'badge_id' => $badge->id,
                    'badge_name' => $badge->name,
                    'date_obtained' => Carbon::now()->toDateTimeString(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du badge à l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
