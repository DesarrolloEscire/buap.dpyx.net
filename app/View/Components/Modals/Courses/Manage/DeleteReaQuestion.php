<?php

namespace App\View\Components\Modals\Courses\Manage;

use App\Models\ReaCourse;
use App\Models\ReaCourseTopic;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use Illuminate\View\Component;

class DeleteReaQuestion extends Component
{
    public $course;
    public $topic;
    public $module;
    public $task;
    public $activity;
    public $question;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity, ReaCourseTaskActivityQuestion $question)
    {
        $this->course = $course;
        $this->topic = $topic;
        $this->module = $module;
        $this->task = $task;
        $this->activity = $activity;
        $this->question = $question;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.delete-rea-question');
    }
}
