<?php

namespace App\Http\Controllers\Evaluations;

use App\Events\EvaluationFinishedEvent;
use App\Http\Controllers\Controller;
use App\Models\AnswerHistory;
use App\Models\Evaluation;
use App\Models\EvaluationHistory;
use App\Synchronizers\AnswerSynchronizer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SendEvaluationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Evaluation $evaluation)
    {
        event(new EvaluationFinishedEvent($evaluation));

        
        $evaluation->status = "en revisión";
        $evaluation->save();


        $evaluationHistory = EvaluationHistory::create([
            'repository_id' => $evaluation->repository->id,
            'status' => $evaluation->status
        ]);


        $evaluation->repository->status = 'en progreso';
        $evaluation->repository->save();


        foreach ($evaluation->answers as $answer) {
            (new AnswerSynchronizer($answer))->execute();

            $answerHistory = new AnswerHistory;
            $answerHistory->choice_id = $answer->choice_id;
            $answerHistory->question_id = $answer->question_id;
            $answerHistory->evaluation_history_id = $evaluationHistory->id;
            $answerHistory->description = $answer->description;
            $answerHistory->save();
        }

        
        Alert::success('¡La evaluación ha sido enviada para su revisión!');
        return redirect()->route('repositories.index');
    }
}
