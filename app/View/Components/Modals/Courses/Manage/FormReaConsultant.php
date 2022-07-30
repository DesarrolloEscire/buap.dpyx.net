<?php

namespace App\View\Components\Modals\Courses\Manage;

use App\Models\ReaCourse;
use App\Models\ReaCourseConsultant;
use Illuminate\View\Component;

class FormReaConsultant extends Component
{
    public $edit;
    public $consultant;
    public $course;
    public $id;
    public $keyclear;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(String $edit, ReaCourse $course, ReaCourseConsultant $consultant, $id = 0, $keyclear = null)
    {
        //
        $this->edit = ($edit=='true');
        $this->course = $course;
        $this->consultant = $consultant;
        $this->id = $id;
        $this->keyclear = $keyclear;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.form-rea-consultant');
    }
}
