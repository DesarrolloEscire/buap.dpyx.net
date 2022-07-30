<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\ReaCourseConsultant;

class SortConsultantController extends Controller
{
    public function __invoke(Request $request)
    {
        $consultantOrderedList = $request->consultantOrderedList; 

        foreach($consultantOrderedList as $orderedConsultant){
            $consultant = ReaCourseConsultant::find($orderedConsultant['id']);
            $consultant->order = $orderedConsultant['order'];
            $consultant->updated_at = Carbon::now();

            $consultant->save();
        }
        
        return response()->json('OK',200);
    }
}
