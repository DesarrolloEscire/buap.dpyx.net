<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTaskController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task)
    {
        $nextTaskList = ReaCourseTask::Where('order','>',$task->order)->get();

        foreach($nextTaskList as $nextTask){
            $nextTask->order = ($nextTask->order - 1);
            $nextTask->save();
        }

        $task->delete();

        Alert::success('Tarea eliminada!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
