<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StoreModuleController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic)
    {
        $order = $topic->modules()->count() + 1;

        $module = new ReaCourseModule();
        $module->order = $order;
        $module->module_name = $request->module_name;
        $module->title = $request->title;
        $module->goal = $request->goal;
        $module->description = $request->description;
        $module->created_at = Carbon::now();
        $module->updated_at = Carbon::now();

        $module->save();

        $topic->modules()->attach($module->id);

        Alert::success('Módulo agregado!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
