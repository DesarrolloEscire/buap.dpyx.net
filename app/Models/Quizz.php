<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;

    protected $table ="quizzes";

    protected $fillable =[
        "id",
        "user_id",
        "answer",
        "answer_description",
        "question",
        "question_description"
    ];
}
