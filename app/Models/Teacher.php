<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = "teachers";

    public $timestamps = false;


    public function scopeWhereIdentifier($query, string $identifier)
    {
        return $query->where('identifier', $identifier);
    }
}
