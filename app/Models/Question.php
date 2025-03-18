<?php

namespace App\Models;

use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $table = 'questions';

    protected $guarded = ['id'];
    
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
