<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluator extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "evaluator_id",
        "educational_level",
        "identifier",
        "created_at",
        "updated_at"
    ]; 
}
