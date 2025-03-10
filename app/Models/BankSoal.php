<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    /** @use HasFactory<\Database\Factories\BankSoalFactory> */
    use HasFactory;
    
    protected $table = 'bank_soals';

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean'
    ];
}
