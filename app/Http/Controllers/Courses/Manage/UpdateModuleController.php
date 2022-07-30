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

class UpdateModuleController extends Controller
{
    public function __invoke(Request $request,ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module)
    {
        $module->module_name = $request->module_name;
        $module->title = $request->title;
        $module->goal = $request->goal;
        $module->description = $request->description;
        $module->updated_at = Carbon::now();

        $module->save();

        Alert::success('Módulo actualizado');
        return redirect()->route('course.manage',['topics',null]);
    }
}
