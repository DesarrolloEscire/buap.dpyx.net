<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourse extends Model
{
    use HasFactory;

    protected $fillable=[
        'course_name'
    ];

    public function reaCourseSections(){
        return $this->belongsToMany(
            ReaCourseSection::class,
            'rea_courses__rea_course_sections',
            'rea_courses_id',
            'rea_course_sections_id')->orderBy('order','ASC');
    }

    public function reaCourseConsultants(){
        return $this->belongsToMany(
            ReaCourseConsultant::class,
            'rea_courses__rea_course_consultants',
            'rea_courses_id',
            'rea_course_consultants_id')->orderBy('order','ASC');
    }

    public function reaCourseTopics(){
        return $this->belongsToMany(
            ReaCourseTopic::class,
            'rea_courses__rea_course_topics',
            'rea_courses_id',
            'rea_course_topics_id')->orderBy('order','ASC');
    }
}
