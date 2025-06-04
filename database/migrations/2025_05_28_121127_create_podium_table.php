<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('podium', function (Blueprint $table) {
            $table->id();
            $table->integer('novelties_id');
            $table->integer('user_id');
            $table->integer('position'); // 1, 2, 3 pour les trois premières places
            $table->integer('score'); // Score obtenu dans l'arena
            $table->integer('points_awarded'); // Points Breitling attribués selon la position
            $table->integer('time_total_seconds')->nullable(); // Temps total en secondes (si pertinent pour le classement)
            $table->dateTime('completed_at'); // Quand l'utilisateur a terminé l'arena
            $table->timestamps();

            $table->foreign('novelties_id')->references('id')->on('novelties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Index pour optimiser les requêtes
            $table->index(['novelties_id', 'position']);
            $table->index(['user_id', 'completed_at']);

            // Contrainte unique : un utilisateur ne peut avoir qu'une seule position par novelty
            $table->unique(['novelties_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podium');
    }
};
