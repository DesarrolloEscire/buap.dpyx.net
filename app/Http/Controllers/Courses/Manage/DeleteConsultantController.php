<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ReaCourseConsultant;
use App\Models\ReaCourse;

class DeleteConsultantController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseConsultant $consultant)
    {

        $nextConsultantList = ReaCourseConsultant::Where('order','>',$consultant->order)->get();

        foreach($nextConsultantList as $nextConsultant){
            $nextConsultant->order = ($nextConsultant->order - 1);
            $nextConsultant->save();
        }

        $consultant->delete();

        Alert::success('Asesor eliminado!');
        return redirect()->route('course.manage',['sections',$request->keyclear]);
    }
}
