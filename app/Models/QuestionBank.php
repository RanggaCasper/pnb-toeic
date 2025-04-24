<?php

namespace App\Models;

use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionBank extends Model
{   
    use HasUuids;
    
    protected $table = 'question_banks';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean'
    ];
    
    public function sections()
    {
        return $this->hasMany(Section::class, 'bank_id');
    }
}
