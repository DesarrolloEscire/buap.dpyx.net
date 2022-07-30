<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseTaskActivityQuestion extends Model
{
    use HasFactory;

    public function responses()
    {
        return $this->hasMany(
            Response::class,
            'rea_course_task_activity_question_id',
            'id'
        );
    }
}
