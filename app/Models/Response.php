<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Response extends Model
{
    use HasFactory;

    protected $table = 'responses';

    protected $fillable = [
        'user_id',
        'questions_id',
        'time_question_start',
        'time_question_end',
        'correcte',
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'questions_id' => 'integer',
            'time_question_start' => 'datetime',
            'time_question_end' => 'datetime',
            'correcte' => 'boolean',
        ];
    }

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'questions_id');
    }
}
