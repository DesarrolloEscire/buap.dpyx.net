<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReaCourseTaskActivity extends Model
{
    use HasFactory;

    Const Content = 1;
    const Questionary = 2;

    protected $fillable = [
        'order',
        'title',
        'instruction',
        'embed_pdf_path',
        'type',
        'needs_evidence'
    ];

    public function questions()
    {
        return $this->belongsToMany(
            ReaCourseTaskActivityQuestion::class,
            'rea_course_activities__rea_course_questions',
            'rea_course_task_activities_id',
            'rea_course_task_questions_id'
        );
    }

    public function fileEvidences()
    {
        return $this->hasMany(
            FileEvidence::class,
            'rea_course_task_activity_id',
            'id'
        )->where('user_id',auth()->user()->id);
    }



    // public function scopeEvaluationActivities($query){
    //     return $query->where('type',static::Questionary)->orWhere(function($orWhereQuery){
    //         $orWhereQuery->where('type',static::Content)->where('needs_evidence',true);
    //     });
    // }
}
