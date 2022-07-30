<?php

namespace App\Http\Livewire\Courses\Manage;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\ReaCourse;

class Index extends Component
{
    public $tab;
    public $pill;
    public $course;

    public function mount(String $tab = null, String $pill = null){
        $this->tab = $tab;
        $this->pill = $pill;
        $this->course = ReaCourse::Where('course_name','rea')->first();
    }

    public function render(){
        return view('livewire.courses.manage.index',[
            'course' => $this->course,
            'tab' => $this->tab,
            'pill' => $this->pill
        ]);
    }
}
