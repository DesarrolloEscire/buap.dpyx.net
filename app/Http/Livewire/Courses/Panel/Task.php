<?php

namespace App\Http\Livewire\Courses\Panel;

use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTopic;
use Livewire\Component;

class Task extends Component
{
    public $course;
    public $topic;
    public $module;
    public $task;

    public function mount(ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task){
        $this->course = ReaCourse::where('course_name','rea')->first();
        $this->topic = $topic;
        $this->module = $module;
        $this->task = $task;
    }

    public function render()
    {
        return view('livewire.courses.panel.task');
    }
}
