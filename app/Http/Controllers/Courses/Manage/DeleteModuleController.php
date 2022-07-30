<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use App\Models\ReaCourseModule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteModuleController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module)
    {
        $nextModulesList = ReaCourseModule::Where('order','>',$module->order)->get();

        foreach($nextModulesList as $nextModule){
            $nextModule->order = ($nextModule->order - 1);
            $nextModule->save();
        }

        $module->delete();

        Alert::success('Módulo eliminado!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
