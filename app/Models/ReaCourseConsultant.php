<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseConsultant extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'consultant_name',
        'description'
    ];
}
