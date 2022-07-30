<?php

namespace App\Http\Controllers\Repositories;

use App\Http\Controllers\Controller;
use App\Models\EvaluationHistory;
use App\Models\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EvaluationStatusChangeController extends Controller
{
    public function __invoke(Repository $repository){
        $repository->update(['status'=>'en progreso','updated_at'=>Carbon::now()]);
        $repository->evaluation()->first()->update(['status'=>'en revisión','updated_at'=>Carbon::now()]);

        EvaluationHistory::create([
            "repository_id" => $repository->id,
            "evaluator_id" => null,
            "status" => "en revisión",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        Alert::success("El estatus de la evaluación del repositorio ".$repository->name." ha sido cambiado con éxito");
        return redirect()->back();
    }
}
