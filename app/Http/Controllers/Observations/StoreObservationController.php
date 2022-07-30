<?php

namespace App\Http\Controllers\Observations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreObservationRequest;
use App\Models\Observation;
use App\Services\ObservationService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class StoreObservationController extends Controller
{
    public function __invoke(StoreObservationRequest $request)
    {
        // 
        $observation = Observation::updateOrCreate([
            'answer_id' => $request->answer_id
        ], [
            'answer_id' => $request->answer_id,
            'description' => $request->description ?? ''
        ]);

        // 
        (new ObservationService)($observation)->removeFiles($request->filesToDelete);
        
        // 
        if ($request->hasFile('files')) {
            // TODO store files with their original and time name instied of only time
            (new ObservationService)($observation)->storeFiles($request->file('files'));
        }

        $observation->save();

        Alert::success('¡Observación creada!');
        return redirect()->route('evaluations.categories.questions.index', [$observation->answer->evaluation, $observation->answer->question->category]);
    }
}
