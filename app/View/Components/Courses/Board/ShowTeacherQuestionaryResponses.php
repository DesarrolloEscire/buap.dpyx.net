<?php

namespace App\View\Components\Courses\Board;

use Illuminate\View\Component;

class ShowTeacherQuestionaryResponses extends Component
{
    public $topic;
    public $module;
    public $task;
    public $questionary;
    public $responses;
    public $hits;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($topic,$module,$task,$questionary,$responses,$hits)
    {
        $this->topic = $topic;
        $this->module = $module;
        $this->task = $task;
        $this->questionary = $questionary;
        $this->responses = $responses;
        $this->hits = $hits;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.courses.board.show-teacher-questionary-responses');
    }
}
