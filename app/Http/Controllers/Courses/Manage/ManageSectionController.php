<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Models\ReaCourseSection;

class ManageSectionController extends Controller
{
    public function __invoke(Request $request, ReaCourseSection $section)
    {
        $section->title = $request->title == NULL || $request->title == "" ? NULL : $request->title;
        $section->description = $request->description == NULL || $request->description == "" ? null : $request->description;
        $section->updated_at = Carbon::now();
        
        $section->save();

        Alert::success('¡Sección actualizada!');
        return redirect()->route('course.manage',['sections',$request->keyclear]);
    }
}
