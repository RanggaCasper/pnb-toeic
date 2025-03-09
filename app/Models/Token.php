<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /** @use HasFactory<\Database\Factories\TokenFactory> */
    use HasFactory;
    protected $fillable = [
        'token',
        'mulai',
        'selesai',
        'bank_id',
    ];
    public function bank_soal()
    {
        return $this->belongsTo(BankSoal::class, 'bank_id');
    }

}
