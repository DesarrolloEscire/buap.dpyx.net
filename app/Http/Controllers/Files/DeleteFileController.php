<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeleteFileController extends Controller
{
    public function __invoke(File $file)
    {
        $file->delete();

        Alert::success("Archivo eliminado exitósamente");
        return redirect()->back();
    }
}
