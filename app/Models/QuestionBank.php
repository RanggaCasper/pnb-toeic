<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionBank extends Model
{   
    use HasUuids;
    
    protected $table = 'question_banks';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean'
    ];
}
