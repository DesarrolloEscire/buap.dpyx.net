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

class StoreTaskActivityQuestionController extends Controller
{
    public function __invoke(Request $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity){
        foreach($request->questions as $question_item){
            $question_item = (object)$question_item;
            $order = $activity->questions()->count() + 1;

            $question = new ReaCourseTaskActivityQuestion();
            
            $question->order = $order;
            $question->question = $question_item->question;
            $question->answer_a = $question_item->answer_a;
            $question->answer_b = $question_item->answer_b;
            $question->answer_c = $question_item->answer_c;
            $question->correct_answer = $question_item->correct_answer;
            $question->created_at = Carbon::now();
            $question->updated_at = Carbon::now();
            
            $question->save();

            $activity->questions()->attach($question->id);
        }


        Alert::success('Preguntas agregadas!');
        return redirect()->route('course.manage.question.view',[$course,$topic,$module,$task,$activity]);
    }
}
