<?php

namespace App\Models\Section;

use App\Models\BankSoal;
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
        return $this->belongsTo(BankSoal::class, 'bank_id');
    }
}
