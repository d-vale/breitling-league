<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Novelty extends Model
{
    use HasFactory;

    protected $table = 'novelties';

    protected $fillable = [
        'badge_id',
        'formation', // url
        'end_bonustime',
        'date_release',
    ];

    protected function casts(): array
    {
        return [
            'end_bonustime' => 'datetime',
            'date_release' => 'datetime',
            'badge_id' => 'integer',
        ];
    }

    // Relations
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'novelties_id');
    }

    public function noveltiesArena(): HasMany
    {
        return $this->hasMany(NoveltiesArena::class, 'novelties_id');
    }

    public function podiumResults(): HasMany
    {
        return $this->hasMany(Podium::class, 'novelties_id');
    }

    public function podiumWinners(): HasMany
    {
        return $this->hasMany(Podium::class, 'novelties_id')
            ->where('position', '<=', 3)
            ->orderBy('position');
    }

    public function champion(): ?Podium
    {
        return $this->podiumResults()->where('position', 1)->first();
    }
}
