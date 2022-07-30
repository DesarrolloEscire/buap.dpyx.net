<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UpdateTaskActivityQuestionController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity, ReaCourseTaskActivityQuestion $question){
        
        $question->question = $request->question;
        $question->answer_a = $request->answer_a;
        $question->answer_b = $request->answer_b;
        $question->answer_c = $request->answer_c;
        $question->correct_answer = $request->correct_answer;
        $question->updated_at = Carbon::now();

        $question->save();

        Alert::success('Preguta actualizada!');
        return redirect()->route('course.manage.question.view',[$course,$topic,$module,$task,$activity]);
    }
}
