<?php

use App\Http\Controllers\League\ArenaController;
use App\Http\Controllers\League\BadgeController;
use App\Http\Controllers\League\BattleController;
use App\Http\Controllers\League\ImagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\League\RankingController;
use App\Http\Controllers\League\QuizController;
use App\Http\Controllers\League\UserController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Frontend Routes
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');


    //API Routes
    Route::prefix('api/v1')->group(function () {
        Route::get('/test', function () {
            return response()->json(['message' => 'Test API endpoint']);
        });

        Route::prefix('/ranking')->group(function () {
            Route::get('/global', [RankingController::class, 'getGlobalRanking'])->name('ranking.global');
            Route::get('/league', [RankingController::class, 'getLeagueRanking'])->name('ranking.league');
            Route::get('/pos', [RankingController::class, 'getPosRanking'])->name('ranking.pos');
        });

        Route::prefix('/quiz')->group(function () {
            Route::get('/', [QuizController::class, 'getNewQuiz'])->name('');
            Route::get('/placement', [QuizController::class, 'getPlacementQuiz'])->name('');
            Route::post('/response', [QuizController::class, 'saveAnswer'])->name('');

            Route::prefix('battle')->group(function () {
                Route::get('/', [BattleController::class, 'getBattles'])->name('');
                Route::get('/{quizId}', [BattleController::class, 'getBattleQuiz'])->name('');
                Route::post('/{quizId}', [BattleController::class, 'postBattleQuiz'])->name('');
                Route::delete('/', [BattleController::class, 'deleteBattle'])->name('');
            });
        });

        /* A FAIRE */
        Route::prefix('/novelties')->group(function () {
            Route::get('/', [ArenaController::class, 'isNoveltyOccuring'])->name('');
            Route::get('/arena-quiz', [ArenaController::class, 'getArenaQuiz'])->name('');
            Route::get('/results', [ArenaController::class, 'getArenaResults'])->name('');
        });

        Route::prefix('/badges')->group(function () {
            Route::post('/', [BadgeController::class, 'addBadge'])->name('');
            Route::post('/user', [BadgeController::class, 'addBadgeToUser'])->name('');
            Route::get('/', [BadgeController::class, 'getBadges'])->name('');
        });

        Route::prefix('/user')->group(function () {
            Route::get('/', [UserController::class, 'getUser'])->name('user.get');
            Route::get('/history', [UserController::class, 'getUserHistory'])->name('user.history');
            Route::get('/history/{type}', [UserController::class, 'getFilteredHistory'])->name('user.history_filtered');
            Route::get('/placement-progress', [UserController::class, 'getUserPlacement'])->name('user.placement');
        });

        Route::prefix('/images')->group(function () {
            Route::get('/info/{image_path}', [ImagesController::class, 'getImageInfo'])->name('images.info');
            Route::get('/{image_path}', [ImagesController::class, 'getImage'])->name('images.get');
            Route::get('/', [ImagesController::class, 'listImages'])->name('images.list');
        });
    });
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
