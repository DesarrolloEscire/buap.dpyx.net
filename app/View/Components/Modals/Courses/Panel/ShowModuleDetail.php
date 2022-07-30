<?php

namespace App\View\Components\Modals\Courses\Panel;

use App\Models\ReaCourseModule;
use Illuminate\View\Component;

class ShowModuleDetail extends Component
{
    public $module;
    public $index;
    public $order;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourseModule $module, Int $index, Int $order)
    {
        $this->module = $module;
        $this->index = $index;
        $this->order = $order;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.panel.show-module-detail');
    }
}
