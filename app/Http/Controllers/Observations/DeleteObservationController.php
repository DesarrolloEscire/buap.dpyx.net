<?php

namespace App\Http\Controllers\Observations;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteObservationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Observation $observation)
    {
        $observation->delete();

        Alert::success('¡Observación eliminada!');
        return redirect()->back();
    }
}
