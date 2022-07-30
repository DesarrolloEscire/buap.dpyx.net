<?php

namespace App\Http\Controllers\FileEvidence;

use App\Http\Controllers\Controller;
use App\Models\FileEvidence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Download extends Controller
{
    public function __invoke(FileEvidence $fileEvidence)
    {
        return response()->download( storage_path($fileEvidence->path) );
    }
}
