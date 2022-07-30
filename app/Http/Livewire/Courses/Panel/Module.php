<?php

namespace App\Http\Livewire\Courses\Panel;

use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTopic;
use Livewire\Component;

class Module extends Component
{
    public $course;
    public $topic;
    public $module;

    public function mount(ReaCourseTopic $topic, ReaCourseModule $module){
        $this->course = ReaCourse::where('course_name','rea')->first();
        $this->topic = $topic;
        $this->module = $module;
    }

    public function render()
    {
        return view('livewire.courses.panel.module');
    }
}
