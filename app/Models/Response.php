<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        "rea_course_task_activity_question_id",
        "user_id",
        "response",
        "selected_option"
    ];

    public function question(){
        return $this->hasOne(
            ReaCourseTaskActivityQuestion::class,
            'id',
            'rea_course_task_activity_question_id'
        );
    }

    public function users()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function scopeWhereUser($query, User $user)
    {
        return $query->whereHas('users', function ($query) use ($user) {
            return $query->where('users.id', $user->id);
        });
    }

    public function scopeWhereResponse($query, string $response)
    {
        return $query->where('response', $response);
    }
}
