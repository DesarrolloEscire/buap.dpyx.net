<?php

namespace App\View\Components\Forms\Courses\Manage;

use App\Models\ReaCourseTaskResource;
use Illuminate\View\Component;

class FormReaTaskResource extends Component
{
    public $index;
    public $resource;
    public $edit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Int $index, ReaCourseTaskResource $resource = null, String $edit)
    {
        $this->index = $index;
        $this->resource = $resource;
        $this->edit = $edit=='true';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.forms.courses.manage.form-rea-task-resource');
    }
}
