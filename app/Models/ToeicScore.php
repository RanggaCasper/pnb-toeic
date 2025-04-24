<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToeicScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'correct',
        'listening_score',
        'reading_score'
    ];
}
