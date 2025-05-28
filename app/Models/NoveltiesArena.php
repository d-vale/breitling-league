<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoveltiesArena extends Model
{
    use HasFactory;

    protected $table = 'novelties_arena';

    protected $fillable = [
        'user_id',
        'novelties_id',
        'quiz_id',
        'rank_id',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'novelties_id' => 'integer',
            'quiz_id' => 'integer',
            'rank_id' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function novelty(): BelongsTo
    {
        return $this->belongsTo(Novelty::class, 'novelties_id');
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }
}
