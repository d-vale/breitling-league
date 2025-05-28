<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $table = 'choices';

    protected $fillable = [
        'texte',
        'questions_id',
        'correcte',
    ];

    protected function casts(): array
    {
        return [
            'questions_id' => 'integer',
            'correcte' => 'boolean',
        ];
    }

    // Relations
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'questions_id');
    }
}
