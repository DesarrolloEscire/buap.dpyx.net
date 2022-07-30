<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreTopicController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course)
    {
        $order = $course->reaCourseTopics()->count() + 1;
        
        $topic = new ReaCourseTopic();
        $topic->order = $order;
        $topic->topic_name = $request->topic_name;
        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->created_at = Carbon::now();
        $topic->updated_at = Carbon::now();

        $topic->save();

        $course->reaCourseTopics()->attach($topic->id);

        Alert::success('Tema agregado!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
