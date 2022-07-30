<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\ReaCourseTopic;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteTaskActivityQuestionController extends Controller
{
    public function __invoke(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity, ReaCourseTaskActivityQuestion $question)
    {
        $nextQuestionsList = ReaCourseTaskActivityQuestion::Where('order','>',$question->order)->get();

        foreach($nextQuestionsList as $nextQuestion){
            $nextQuestion->order = ($nextQuestion->order - 1);
            $nextQuestion->save();
        }

        $question->delete();

        Alert::success('Pregunta eliminada!');
        return redirect()->route('course.manage.question.view',[$course,$topic,$module,$task,$activity]);
    }
}
