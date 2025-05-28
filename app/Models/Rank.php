<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rank extends Model
{
    use HasFactory;

    protected $table = 'ranks';

    protected $fillable = [
        'name',
        'min_points',
    ];

    protected function casts(): array
    {
        return [
            'min_points' => 'integer',
        ];
    }

    // Relations
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function userRanks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_rank')->withTimestamps();
    }

    public function noveltiesArena(): HasMany
    {
        return $this->hasMany(NoveltiesArena::class);
    }
}
