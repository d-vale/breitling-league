<?php

use App\Http\Controllers\League\ArenaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\League\RankingController;
use App\Http\Controllers\League\QuizController;
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
            Route::get('/battle/{quiz-id}', [QuizController::class, 'getBattleQuizById'])->name('');
            Route::get('/placement', [QuizController::class, 'getPlacementQuiz'])->name('');
        });

        Route::prefix('novelties')->group(function () {
            Route::get('/', [ArenaController::class, 'isNoveltyOccuring'])->name('');
            Route::get('/arena', [ArenaController::class, 'getArenaQuiz'])->name('');
            Route::get('/results', [ArenaController::class, 'getArenaResults'])->name('');
        });
    });
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
