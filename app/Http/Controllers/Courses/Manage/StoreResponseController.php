<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Models\FileEvidence;
use App\Models\Question;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StoreResponseController extends Controller
{
    public function __invoke($activity, Request $request)
    {
        $activity = ReaCourseTaskActivity::find($activity);

        // dd($request->file('evidence'));

        // dd($request->file('evidence'));

        if ($request->file('evidence')) {

            collect( $request->file('evidence') )->each( function($file) use($activity){
                $fileName = $file->getClientOriginalName();
    
                $userId = auth()->user()->id;

                $path = "app/evidences/activities/$activity->id/users/$userId";
    
                $file->move(
                    storage_path($path),
                    $fileName
                );

                FileEvidence::updateOrcreate([
                    'rea_course_task_activity_id' => $activity->id,
                    'user_id' => auth()->user()->id,
                    'path' => "$path/$fileName",
                ]);

            } );

        }



        if ($request->questions) {
            foreach ($request->questions as $questionId => $response) {
                $answer = explode('_@_', $response);
                $letter = $answer[0];
                $text = $answer[1];

                $response = Response::updateOrCreate([
                    'rea_course_task_activity_question_id' => $questionId,
                    'user_id' => auth()->user()->id,
                ], [
                    'selected_option' => $letter,
                    'response' => $text,
                    'updated_at' => Carbon::now()
                ]);
            }
        }
        Alert::success('¡Respuestas guardadas!');
        return redirect()->back();
    }
}
