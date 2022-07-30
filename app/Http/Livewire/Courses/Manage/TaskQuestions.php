<?php

namespace App\Http\Livewire\Courses\Manage;

use App\Models\ReaCourse;
use App\Models\ReaCourseModule;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\ReaCourseTopic;
use Livewire\Component;

class TaskQuestions extends Component
{
    public $course;
    public $topic;
    public $module;
    public $task;
    public $activity;

    public $questions_list = [];
    public $questions = [];

    public function mount(ReaCourse $course, ReaCourseTopic $topic, ReaCourseModule $module, ReaCourseTask $task, ReaCourseTaskActivity $activity){
        $this->course = $course;
        $this->topic = $topic;
        $this->module = $module;
        $this->task = $task;
        $this->activity = $activity;

        $this->questions = $activity->questions()->get();
    }


    public function render()
    {
        return view('livewire.courses.manage.task-questions');
    }

    public function addQuestionForm(){
        $this->questions_list[] = new ReaCourseTaskActivityQuestion();
    }

    public function removeQuestionForm($index){
        unset($this->questions_list[$index]);
        $this->questions_list = array_values($this->questions_list);
    }
}
