<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTopicController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic)
    {
        $nextTopicsList = ReaCourseTopic::Where('order','>',$topic->order)->get();

        foreach($nextTopicsList as $nextTopic){
            $nextTopic->order = ($nextTopic->order - 1);
            $nextTopic->save();
        }

        $topic->delete();

        Alert::success('Tema eliminado!');
        return redirect()->route('course.manage',['topics',null]);
    }
}
