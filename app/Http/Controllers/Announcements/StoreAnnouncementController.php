<?php

namespace App\Http\Controllers\Announcements;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StoreAnnouncementController extends Controller
{
    public function __invoke(Request $request)
    {
        $announcement = new Announcement;
        $announcement->initial_date = $request->initial_date;
        $announcement->final_date = $request->final_date;
        $announcement->motive = $request->motive;
        $announcement->save();

        Alert::success('¡Convocatoria creada!');
        return redirect()->route('announcements.index');
    }
}
