<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        "order",
        "topic_name",
        "title",
        "description"
    ];

    public function modules(){
        return $this->belongsToMany(
            ReaCourseModule::class,
            'rea_course_topics__rea_course_modules',
            'rea_course_topics_id',
            'rea_course_modules_id')->orderBy('order','ASC');
    }
}
