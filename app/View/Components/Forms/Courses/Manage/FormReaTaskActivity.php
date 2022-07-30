<?php

namespace App\View\Components\Forms\Courses\Manage;

use App\Models\ReaCourseTaskActivity;
use Illuminate\View\Component;

class FormReaTaskActivity extends Component
{
    public $index;
    public $activity;
    public $edit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Int $index, ReaCourseTaskActivity $activity = null, String $edit)
    {
        $this->index = $index;
        $this->activity = $activity;
        $this->edit = $edit == 'true';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.courses.manage.form-rea-task-activity');
    }
}
