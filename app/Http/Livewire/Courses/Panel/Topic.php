<?php

namespace App\Http\Livewire\Courses\Panel;

use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use Livewire\Component;

class Topic extends Component
{
    public $course;
    public $topic;

    public function mount(ReaCourseTopic $topic){
        $this->course = ReaCourse::where('course_name','rea')->first();
        $this->topic = $topic;
    }

    public function render()
    {
        return view('livewire.courses.panel.topic');
    }
}
