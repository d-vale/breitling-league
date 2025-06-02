<?php

use Illuminate\Support\Facades\Route;
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
    });
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
