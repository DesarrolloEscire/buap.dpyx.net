<?php

namespace App\View\Components\Modals\Courses\Manage;

use Illuminate\View\Component;
use App\Models\ReaCourse;
use App\Models\ReaCourseConsultant;

class DeleteReaConsultant extends Component
{
    public $consultant;
    public $course;
    public $keyclear;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourseConsultant $consultant, ReaCourse $course, $keyclear = null)
    {
        $this->consultant = $consultant;
        $this->course = $course;
        $this->keyclear = $keyclear;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.manage.delete-rea-consultant');
    }
}
