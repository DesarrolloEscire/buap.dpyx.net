<?php

namespace App\Http\Controllers\Courses\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\Manage\StoreTaskResourceRequest;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskResource;
use App\Models\ReaCourseTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StoreTaskResourceController extends Controller
{
    public function __invoke(StoreTaskResourceRequest $request, ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task){
        foreach($request->resources as $resource_item){
            $resource_item = (object)$resource_item;
            $order = $task->resources()->count() + 1;

            $resource = new ReaCourseTaskResource();
            
            $resource->order = $order;
            $resource->resource_category = $resource_item->resource_category;
            $resource->resource_type = $resource_item->resource_type;
            $resource->resource_description = $resource_item->resource_description;
            $resource->created_at = Carbon::now();
            $resource->updated_at = Carbon::now();
            
            $resource->save();

            $task->resources()->attach($resource->id);
        }


        Alert::success('Recursos agregados!');
        return redirect()->route('course.manage.task.view',[$course,$topic,$module,$task]);
    }
}
