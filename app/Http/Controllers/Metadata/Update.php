<?php

namespace App\Http\Controllers\Metadata;

use App\Http\Controllers\Controller;
use App\Models\Metadata;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Update extends Controller
{
    public function __invoke(Metadata $metadata, Request $request)
    {
        $metadata->update([
            'hint' => $request->hint,
            'input_type' => $request->input_type,
            'is_required' => $request->is_required == "true" ? true : false,
            'is_repeatable' => $request->is_repeatable == "true" ? true : false,
            'label' => $request->label,
            'name' => $request->name,
            'position' => $request->position,
            'value_pair_group' => $request->value_pair_group,
        ]);

        Alert::success("metadato actualizado");
        return redirect()->back();
    }
}
