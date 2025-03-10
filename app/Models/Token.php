<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /** @use HasFactory<\Database\Factories\TokenFactory> */
    use HasFactory;
    
    protected $table = 'tokens';

    protected $guarded = ['id'];

    public function bankSoal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_id');
    }
}
