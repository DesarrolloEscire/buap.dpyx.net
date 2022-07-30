<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ReaCourseConsultant;
use App\Models\ReaCourse;

class UpdateConsultantController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseConsultant $consultant)
    {
        if($consultant->order != $request->order){

        }
        $consultant->consultant_name = $request->consultant_name;
        $consultant->description = $request->description;
        $consultant->updated_at = Carbon::now();
        
        $consultant->save();

        Alert::success('Asesor actualizado!');
        return redirect()->route('course.manage',['sections',$request->keyclear]);
    }
}
