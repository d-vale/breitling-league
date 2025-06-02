<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'lastname',
        'firstname',
        'nickname',
        'email',
        'password',
        'site_web',
        'points',
        'rank_id',
        'profile_complete',
        'isActive',
        'registrationKeyId',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'profile_complete' => 'boolean',
            'isActive' => 'boolean',
            'points' => 'integer',
        ];
    }

    // Relations
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('date_obtained')
            ->withTimestamps();
    }

    public function ranks(): BelongsToMany
    {
        return $this->belongsToMany(Rank::class, 'user_rank')->withTimestamps();
    }

    public function noveltiesArena(): HasMany
    {
        return $this->hasMany(NoveltiesArena::class);
    }

    public function quizBattlesAsUser(): HasMany
    {
        return $this->hasMany(QuizBattle::class, 'user_id');
    }

    public function quizBattlesAsChallenger(): HasMany
    {
        return $this->hasMany(QuizBattle::class, 'user_challenger_id');
    }

    public function quizBattlesAsWinner(): HasMany
    {
        return $this->hasMany(QuizBattle::class, 'winner_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function historique(): HasMany
    {
        return $this->hasMany(Historique::class, 'users_id');
    }
}
