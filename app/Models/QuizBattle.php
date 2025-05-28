<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizBattle extends Model
{
    use HasFactory;

    protected $table = 'quiz_battles';

    protected $fillable = [
        'user_id',
        'user_challenger_id',
        'winner_id',
        'quiz_id',
        'bet_points',
        'date_posted',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'user_challenger_id' => 'integer',
            'winner_id' => 'integer',
            'quiz_id' => 'integer',
            'bet_points' => 'integer',
            'date_posted' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function challenger(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_challenger_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
