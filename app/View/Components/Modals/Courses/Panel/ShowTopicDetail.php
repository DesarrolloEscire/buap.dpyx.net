<?php

namespace App\View\Components\Modals\Courses\Panel;

use App\Models\ReaCourseTopic;
use Illuminate\View\Component;

class ShowTopicDetail extends Component
{
    public $topic;
    public $index;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ReaCourseTopic $topic, Int $index)
    {
        $this->topic = $topic;
        $this->index = $index;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modals.courses.panel.show-topic-detail');
    }
}
