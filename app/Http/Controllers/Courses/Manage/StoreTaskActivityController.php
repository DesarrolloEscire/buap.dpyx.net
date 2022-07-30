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

class StoreTaskActivityController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task){
        foreach($request->activities as $index => $activity_item){
            $activity_item = (object)$activity_item;
            $order = $task->activities()->count() + 1;

            $activity = new ReaCourseTaskActivity();
            
            $activity->order = $order;
            $activity->title = $activity_item->title;
            $activity->instruction = $activity_item->instruction;
            $activity->type = $activity_item->type;
            $activity->needs_evidence = $activity_item->needs_evidence;
            $activity->created_at = Carbon::now();
            $activity->updated_at = Carbon::now();
            $activity->save();

            if($request->input('activities.'.$index.'.file')){
                $pdf = $request->input('activities.'.$index.'.file');
                $fileName = time() . '.' . $pdf->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs(
                    'courses/manage/activities/'.$activity->id,
                    $pdf,
                    $fileName
                );
                $activity->embed_pdf_path = $path;
                $activity->save();
            }
            
            

            $task->activities()->attach($activity->id);
        }


        Alert::success('Actividades agregadas!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
