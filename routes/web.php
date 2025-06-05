<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\League\RankingController;
use App\Http\Controllers\League\QuizController;
use App\Http\Controllers\League\BattleController;
use App\Http\Controllers\League\ArenaController;
use App\Http\Controllers\League\UserController;
use App\Http\Controllers\League\ImagesController;


Route::get('/', function () {
    return Auth::check() ? view('index') : view('login');
})->name('landing');


Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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

    Route::prefix('/novelties')->group(function () {
        Route::get('/', [ArenaController::class, 'isNoveltyOccuring'])->name('');
        Route::get('/arena-quiz', [ArenaController::class, 'getArenaQuiz'])->name('');
        Route::get('/results/{arenaId}', [ArenaController::class, 'getArenaResults'])->name('');
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


// Vue routes
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '^(?!api|login|register).*')->name('spa')->middleware('auth');
