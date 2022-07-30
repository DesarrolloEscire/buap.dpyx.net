<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseModule extends Model
{
    use HasFactory;

    protected $fillable = [
        "order",
        "module_name",
        "title",
        "goal",
        "description"
    ];

    public function tasks(){
        return $this->belongsToMany(
            ReaCourseTask::class,
            'rea_course_modules__rea_course_tasks',
            'rea_course_modules_id',
            'rea_course_tasks_id'
        )->orderBy('order','ASC');
    }
}
