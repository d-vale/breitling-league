<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'name',
        'description',
        'date_realised',
        'earned_points',
    ];

    protected function casts(): array
    {
        return [
            'date_realised' => 'date',
            'earned_points' => 'integer',
        ];
    }

    // Relations
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'quiz_questions', 'quiz_id', 'questions_id')->withTimestamps();
    }

    public function quizBattles(): HasMany
    {
        return $this->hasMany(QuizBattle::class);
    }

    public function historique(): HasMany
    {
        return $this->hasMany(Historique::class);
    }
}
