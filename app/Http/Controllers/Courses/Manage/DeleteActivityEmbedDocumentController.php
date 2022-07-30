<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteActivityEmbedDocumentController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity)
    {
        if(Storage::exists($activity->embed_pdf_path)){
            Storage::delete($activity->embed_pdf_path);

            $activity->embed_pdf_path = null;
            $activity->save();
        }

        Alert::success('Actividad actualizada!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
