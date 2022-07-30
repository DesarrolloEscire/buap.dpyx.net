<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTopic;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTaskActivityController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity)
    {
        $nextActivitiesList = ReaCourseTaskActivity::Where('order','>',$activity->order)->get();

        foreach($nextActivitiesList as $nextActivity){
            $nextActivity->order = ($nextActivity->order - 1);
            $nextActivity->save();
        }

        $activity->delete();

        Alert::success('Actividad eliminada!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
