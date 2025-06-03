<?php

use App\Http\Controllers\League\ArenaController;
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

        Route::prefix('ranking')->group(function () {
            Route::get('/global', [RankingController::class, 'getGlobalRanking'])->name('');
            Route::get('/league', [RankingController::class, 'getLeagueRanking'])->name('');
            Route::get('/pos', [RankingController::class, 'getPosRanking'])->name('');
        });

        Route::prefix('quiz')->group(function () {
            Route::get('/', [QuizController::class, 'getNewQuiz'])->name('');
            Route::get('/placement', [QuizController::class, 'getPlacementQuiz'])->name('');
            Route::post('/response', [QuizController::class, 'saveAnswer'])->name('');

            Route::prefix('battle')->group(function () {
                Route::get('/{quiz-id}', [BattleController::class, 'getBattleQuiz'])->name('');
                Route::post('/{quiz-id}', [BattleController::class, 'getBattleQuiz'])->name('');
                /*  Route::post('/bet', [BattleController::class, 'placeBetForBattle'])->name(''); */
                Route::delete('/', [BattleController::class, 'deleteQuiz'])->name('');
            });
        });

        Route::prefix('novelties')->group(function () {
            Route::get('/', [ArenaController::class, 'isNoveltyOccuring'])->name('');
            Route::get('/arena-quiz', [ArenaController::class, 'getArenaQuiz'])->name('');
            Route::get('/results', [ArenaController::class, 'getArenaResults'])->name('');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'getUser'])->name('');
            Route::get('/history', [UserController::class, 'getUserHistory'])->name('');
            Route::get('/placement-progress', [UserController::class, 'getUserPlacement'])->name('');
        });

        Route::prefix('images')->group(function () {
            Route::get('/{image_path}', [ImagesController::class, 'getImage'])->name('');
        });
    });
});



require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
