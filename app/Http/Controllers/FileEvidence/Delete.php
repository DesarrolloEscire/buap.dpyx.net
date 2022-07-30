<?php

namespace App\Http\Controllers\FileEvidence;

use App\Http\Controllers\Controller;
use App\Models\FileEvidence;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Delete extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(FileEvidence $fileEvidence)
    {
        $fileEvidence->delete();

        Alert::success("Archivo eliminado.");

        return redirect()->back();
    }
}
