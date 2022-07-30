<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'task_name',
        'title',
        'goal',
        'evidence',
        'limit_type',
        'days',
        'deadline_type',
        'evaluation'
    ];

    public function resources(){
        return $this->belongsToMany(
            ReaCourseTaskResource::class,
            'rea_course_task__rea_course_task_resources',
            'rea_course_tasks_id',
            'rea_course_task_resources_id'
        )->orderBy('order','ASC');
    }

    public function scopeRequiredResources(){
        return $this->belongsToMany(
            ReaCourseTaskResource::class,
            'rea_course_task__rea_course_task_resources',
            'rea_course_tasks_id',
            'rea_course_task_resources_id'
        )->where('resource_category',1)->orderBy('order','ASC');
    }
    public function scopeComplementaryResources(){
        return $this->belongsToMany(
            ReaCourseTaskResource::class,
            'rea_course_task__rea_course_task_resources',
            'rea_course_tasks_id',
            'rea_course_task_resources_id'
        )->where('resource_category',2)->orderBy('order','ASC');
    }
    
    public function activities(){
        return $this->belongsToMany(
            ReaCourseTaskActivity::class,
            'rea_course_task__rea_course_task_activities',
            'rea_course_tasks_id',
            'rea_course_task_activities_id'
        )->orderBy('order','ASC');
    }
}
