<?php

namespace App\Http\Controllers\Metadata;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class Store extends Controller
{
    public function __invoke(Request $request)
    {
        Metadata::create([
            'hint' => $request->hint,
            'input_type' => $request->input_type,
            'is_required' => $request->is_required == "true" ? true : false,
            'is_repeatable' => $request->is_repeatable == "true" ? true : false,
            'label' => $request->label, 
            'name' => $request->name, 
            'position' => $request->position, 
            'value_pair_group' => $request->value_pair_group,
        ]);

        Metadata::where('position','>=', $request->position)->update([
            'position' => DB::raw('position + 1')
        ]);

        Alert::success("Metadato creado existosamente");
        return redirect()->back();
    }
}
