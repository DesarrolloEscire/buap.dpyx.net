<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateCourseController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course)
    {
        $course->title = $request->title;
        $course->duration = $request->duration;
        $course->description = $request->description;
        $course->updated_at = Carbon::now();

        $course->save();

        Alert::success('Curso actualizado!');
        return redirect()->route('course.manage');
    }
}
