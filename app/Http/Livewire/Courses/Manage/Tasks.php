<?php

namespace App\Http\Livewire\Courses\Manage;

use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTopic;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskResource;
use Livewire\Component;

class Tasks extends Component
{
    public $course;
    public $topic;
    public $module;
    public $task;

    public $deadlineType;
    public $complementTab;
    public $resources_list = [];
    public $resources = [];
    public $activities_list = [];
    public $activities = [];



    public function mount(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, Int $task = null){
        $this->course = $course;
        $this->topic = $topic;
        $this->module = $module;
        $this->task = $task ? ReaCourseTask::find($task) : null;
        $this->deadlineType = null;
        $this->hasEvidence = true;
        $this->complementTab = 'resources';

        if($task){
            $this->deadlineType = $this->task->limit_type;
            $this->resources = $this->task->resources()->get();
            $this->activities = $this->task->activities()->get();
        }
    }

    public function render()
    {
        return view('livewire.courses.manage.tasks');
    }

    public function toggleComplementTab(String $selected_tab){
        $this->complementTab = $selected_tab;
    }

    public function addResourceForm(){
        $this->resources_list[] = new ReaCourseTaskResource();
    }

    public function removeResourceForm($index){
        unset($this->resources_list[$index]);
        $this->resources_list = array_values($this->resources_list);
    }

    public function addActivityForm(){
        $this->activities_list[] = new ReaCourseTaskActivity();
    }

    public function removeActivityForm($index){
        unset($this->activities_list[$index]);
        $this->activities_list = array_values($this->activities_list);
    }
}
