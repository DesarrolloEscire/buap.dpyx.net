<?php

namespace App\View\Components\Modals\Courses\Manage;

use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use Illuminate\View\Component;

class FormReaTopic extends Component
{
    public $edit;
    public $topic;
    public $course;
    public $id;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(String $edit, ReaCourse $course, ReaCourseTopic $topic, $id = 0)
    {
        $this->edit = $edit=='true';
        $this->course = $course;
        $this->topic = $topic;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.form-rea-topic');
    }
}
