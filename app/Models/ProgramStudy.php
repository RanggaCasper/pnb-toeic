<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudy extends Model
{
    protected $table = 'program_studies';

    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
