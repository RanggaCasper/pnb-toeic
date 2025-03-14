<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{   
    protected $table = 'question_banks';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean'
    ];
}
