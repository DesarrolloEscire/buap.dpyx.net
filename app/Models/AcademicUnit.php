<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicUnit extends Model
{
    use HasFactory;

    protected $table = "academic_units";

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'academic_unit__user',
            'academic_unit_id',
            'user_id'
        );
    }
}