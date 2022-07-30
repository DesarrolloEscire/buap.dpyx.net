<?php

namespace App\View\Components\Forms\Courses\Manage;

use App\Models\ReaCourseTaskActivityQuestion;
use Illuminate\View\Component;

class FormReaTaskQuestion extends Component
{
    public $index;
    public $question;
    public $edit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Int $index, ReaCourseTaskActivityQuestion $question = null, String $edit)
    {
        $this->index = $index;
        $this->question = $question;
        $this->edit = $edit=='true';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.courses.manage.form-rea-task-question');
    }
}
