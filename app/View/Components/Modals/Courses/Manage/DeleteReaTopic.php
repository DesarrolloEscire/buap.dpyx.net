<?php

namespace App\View\Components\Modals\Courses\Manage;

use Illuminate\View\Component;
use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;

class DeleteReaTopic extends Component
{
    public $course;
    public $topic;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourse $course, ReaCourseTopic $topic)
    {
        $this->course = $course;
        $this->topic = $topic;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.delete-rea-topic');
    }
}
