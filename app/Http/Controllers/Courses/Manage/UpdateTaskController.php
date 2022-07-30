<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateTaskController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task){
        $task->task_name = $request->task_name;
        $task->title = $request->title;
        $task->goal = $request->goal;
        $task->evidence = $request->evidence;
        $task->limit_type = $request->limit_type;
        $task->days = ($request->limit_type == 1 ? $request->days : null);
        $task->deadline_date = ($request->limit_type == 2 ? $request->deadline_date : null);
        $task->evaluation = $request->evaluation;
        $task->updated_at = Carbon::now();

        $task->save();

        Alert::success('Tarea actualizada!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
