<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'users_id',
        'questions_id',
        'user_answer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'questions_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'sections_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_banks_id');
    }

    public function toeicScore(): BelongsTo
    {
        return $this->belongsTo(ToeicScore::class, 'users_id', 'users_id');
    }
}
