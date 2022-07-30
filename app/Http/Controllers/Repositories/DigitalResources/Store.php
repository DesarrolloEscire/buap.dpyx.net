<?php

namespace App\Http\Controllers\Repositories\DigitalResources;

use App\Http\Controllers\Controller;
use App\Models\Repository;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Repository $repository, Request $request)
    {
        $digitalResource = $repository->digitalResources()->create();
        return redirect()->route('digital-resources.metadata.required.index', [$digitalResource]);
    }
}
