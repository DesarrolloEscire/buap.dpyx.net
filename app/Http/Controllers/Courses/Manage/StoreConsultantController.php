<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ReaCourseConsultant;
use App\Models\ReaCourse;

class StoreConsultantController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course)
    {
        $order = $course->reaCourseConsultants()->count()+1; 

        $consultant = new ReaCourseConsultant();
        $consultant->order = $order;
        $consultant->consultant_name = $request->consultant_name;
        $consultant->description = $request->description;
        $consultant->created_at = Carbon::now();
        $consultant->updated_at = Carbon::now();
        
        $consultant->save();

        $course->reaCourseConsultants()->attach($consultant->id);
        $course->save();

        Alert::success('¡Asesor agregado!');
        return redirect()->route('course.manage',['sections',$request->keyclear]);
    }
}
