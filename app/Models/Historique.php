<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Historique extends Model
{
    use HasFactory;

    protected $table = 'historique';

    protected $fillable = [
        'quiz_id',
        'users_id',
        'points',
        'date',
        'type_quiz',
    ];

    protected function casts(): array
    {
        return [
            'quiz_id' => 'integer',
            'users_id' => 'integer',
            'points' => 'integer',
            'date' => 'datetime',
        ];
    }

    // Relations
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
