<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateTaskActivityController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity){
        
        $activity->title = $request->title;
        $activity->instruction = $request->instruction;
        $activity->type = $request->type;
        $activity->needs_evidence = $request->needs_evidence;
        $activity->updated_at = Carbon::now();
        $activity->save();

        if($request->hasFile('file')){ 
            if($activity->embed_pdf_path && Storage::exists($activity->embed_pdf_path)){
                Storage::delete($activity->embed_pdf_path);
            }

            $pdf = $request->file('file');
            $fileName = time() . '.' . $pdf->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs(
                'courses/manage/activities/'.$activity->id,
                $pdf,
                $fileName
            );
            $activity->embed_pdf_path = $path;
            $activity->save();
        }

        Alert::success('Actividad actualizada!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
