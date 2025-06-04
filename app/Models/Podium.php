<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Podium extends Model
{
    use HasFactory;

    protected $table = 'podium';

    protected $fillable = [
        'novelties_id',
        'user_id',
        'position',
        'score',
        'points_awarded',
        'time_total_seconds',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'novelties_id' => 'integer',
            'user_id' => 'integer',
            'position' => 'integer',
            'score' => 'integer',
            'points_awarded' => 'integer',
            'time_total_seconds' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    // Relations
    public function novelty(): BelongsTo
    {
        return $this->belongsTo(Novelty::class, 'novelties_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByNovelty($query, $noveltyId)
    {
        return $query->where('novelties_id', $noveltyId);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeTopThree($query)
    {
        return $query->whereIn('position', [1, 2, 3])->orderBy('position');
    }

    public function scopeWinners($query)
    {
        return $query->where('position', '<=', 3)->orderBy('position');
    }

    // Méthodes utilitaires
    public function getPositionTextAttribute(): string
    {
        return match ($this->position) {
            1 => '1st Place',
            2 => '2nd Place',
            3 => '3rd Place',
            default => $this->position . 'th Place'
        };
    }

    public function getPositionEmojiAttribute(): string
    {
        return match ($this->position) {
            1 => '🥇',
            2 => '🥈',
            3 => '🥉',
            default => '🏆'
        };
    }

    public function isWinner(): bool
    {
        return $this->position <= 3;
    }

    public function isFirstPlace(): bool
    {
        return $this->position === 1;
    }
}
