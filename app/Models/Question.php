<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'texte',
        'novelties_id',
    ];

    protected function casts(): array
    {
        return [
            'novelties_id' => 'integer',
        ];
    }

    // Relations
    public function novelty(): BelongsTo
    {
        return $this->belongsTo(Novelty::class, 'novelties_id');
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class, 'questions_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class, 'questions_id');
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions', 'questions_id', 'quiz_id')->withTimestamps();
    }
}
