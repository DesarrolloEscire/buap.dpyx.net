<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseTaskResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'resource_category',
        'resource_type',
        'resource_description'
    ];
}
