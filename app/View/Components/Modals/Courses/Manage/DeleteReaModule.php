<?php

namespace App\View\Components\Modals\Courses\Manage;

use Illuminate\View\Component;
use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTopic;

class DeleteReaModule extends Component
{
    public $course;
    public $topic;
    public $module;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module)
    {
        $this->course = $course;
        $this->topic = $topic;
        $this->module = $module;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.delete-rea-module');
    }
}
