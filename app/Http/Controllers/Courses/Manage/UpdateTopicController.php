<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateTopicController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic)
    {
        if($topic->order != $request->order){

        }
        $topic->topic_name = $request->topic_name;
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->updated_at = Carbon::now();
        
        $topic->save();

        Alert::success('Tema actualizado!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
