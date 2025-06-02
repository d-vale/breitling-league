<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    use HasFactory;

    protected $table = 'badges';

    protected $fillable = [
        'badge',
        'name',
    ];

    // Relations
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withPivot('date_obtained')
            ->withTimestamps();
    }

    public function novelties(): HasMany
    {
        return $this->hasMany(Novelty::class);
    }
}
