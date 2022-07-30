<?php

namespace App\Http\Livewire\Courses\Panel;

use App\Models\ReaCourse;
use Livewire\Component;

class Home extends Component
{
    public $course;
    public $sections;
    public $resources;

    public function mount(){
        $this->prepareSections();
    }   

    public function render()
    {
        return view('livewire.courses.panel.home');
    }

    public function prepareSections(){
        $this->course = ReaCourse::where('course_name','rea')->first();
        foreach($this->course->reaCourseSections()->get() as $index => $section){
            if(str_contains($section->key_section,'asesores')){
                $this->resources['consultants'] = $this->course->reaCourseConsultants()->get();
            }
            else{
                $this->sections[] = $section;
            }
        }
    }
}
