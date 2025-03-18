<?php

namespace App\Models\Section;

use App\Models\QuestionBank;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';

    protected $guarded = ['id'];

    public function sectionName(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SectionName::class);
    }

    public function questionBank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'bank_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class, 'id_section');
    }
}
