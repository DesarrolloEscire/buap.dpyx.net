<?php

namespace App\Http\Controllers\Constancies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowConstancyController extends Controller
{
    public function __invoke()
    {
        return view('pdfs.certification');
    }
}
