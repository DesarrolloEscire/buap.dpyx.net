<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskResource;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StoreTaskController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module)
    {
        $order = $module->tasks()->count() + 1;
        
        $task = new ReaCourseTask();
        $task->order = $order;
        $task->task_name = $request->task_name;
        $task->title = $request->title;
        $task->goal = $request->goal;
        $task->evidence = $request->evidence;
        $task->limit_type = $request->limit_type;
        $task->days = ($request->limit_type == 1 ? $request->days : null);
        $task->deadline_date = ($request->limit_type == 2 ? $request->deadline_date : null);
        $task->evaluation = $request->evaluation;
        $task->created_at = Carbon::now();
        $task->updated_at = Carbon::now();

        $task->save();

        $module->tasks()->attach($task->id);

        Alert::success('Tarea agregada!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
