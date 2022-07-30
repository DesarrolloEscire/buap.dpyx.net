<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class FileEvidence extends Model
{
    use HasFactory;

    protected $table = "file_evidences";

    protected $fillable = [
        'rea_course_task_activity_id',
        'user_id',
        'path',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function reaCourseTaskActivity()
    {
        return $this->belongsTo(
            ReaCourseTaskActivity::class,
            'rea_course_task_activity_id',
            'id'
        );
    }

    public function getNameAttribute()
    {
        $path = explode("/", $this->path);
        return end($path);
    }

    public function scopeWhereUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeWhereReaCourseTaskActivity($query, ReaCourseTaskActivity $reaCourseTaskActivity)
    {
        return $query->where('rea_course_task_activity_id', $reaCourseTaskActivity->id);
    }
}
