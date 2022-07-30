<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskResource;
use App\Models\ReaCourseTopic;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTaskResourceController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskResource $resource)
    {
        $nextResourcesList = ReaCourseTaskResource::Where('order','>',$resource->order)->get();

        foreach($nextResourcesList as $nextResource){
            $nextResource->order = ($nextResource->order - 1);
            $nextResource->save();
        }

        $resource->delete();

        Alert::success('Recurso eliminado!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
