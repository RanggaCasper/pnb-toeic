<?php

namespace App\Models;

use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'id_section', 'questions', 'image', 'a', 'b', 'c', 'd', 'answer'
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'id_section');
    }
}
