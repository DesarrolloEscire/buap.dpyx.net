<?php

namespace App\Http\Controllers\Metadata;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Delete extends Controller
{
    public function __invoke(Metadata $metadata)
    {
        $metadata->delete();

        Alert::success('metadato eliminado');
        return redirect()->back();
    }
}
