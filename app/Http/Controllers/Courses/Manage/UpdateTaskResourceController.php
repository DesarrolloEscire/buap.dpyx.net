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

class UpdateTaskResourceController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskResource $resource){
        
        $resource->resource_category = $request->resource_category;
        $resource->resource_type = $request->resource_type;
        $resource->resource_description = $request->resource_description;
        $resource->updated_at = Carbon::now();

        $resource->save();

        Alert::success('Recurso actualizado!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
