<?php

namespace App\View\Components\Courses\Panel;

use App\Models\ReaCourse;
use App\Models\ReaCourseTaskActivity;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public $course;
    public $title;
    public $subtitle;
    public $counter;

    public $teacher;
    public $board;

    public $questions;
    public $user_questionary_responses;
    public $user_questionary_data_responses;
    public $questionary;
    public $user_questionary;

    public $tasks;
    public $user_evidence_responses;
    public $user_evidence_data_responses;
    public $evidences;
    public $user_evidences;

    public $dates_message;
    public $teoric_days;
    public $dates_difference;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $subtitle)
    {
        $this->course = ReaCourse::where('course_name', 'rea')->first();
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->counter = 0;

        $teacher = User::with(['academicUnits'])->where(function($query){ $query->whereHas('reaCourseResponses')->orWhereHas('reaCourseEvidences');} )->where('id', auth()->user()->id)->first();
        // dd($teacher);

        $this->user_questionary_data_responses = [];
        $this->user_evidence_data_responses = [];

        if ($teacher) {
            $this->teacher = $teacher;

            $this->user_questionary_responses = $teacher->reaCourseResponses()->pluck('rea_course_task_activity_question_id')->toArray();
            $this->user_evidence_responses = $teacher->reaCourseEvidences()->pluck('rea_course_task_activity_id')->toArray();


            foreach ($teacher->reaCourseResponses()->get() as $response_activity) {
                $this->user_questionary_data_responses[$response_activity->rea_course_task_activity_question_id] = $response_activity;
            }

            foreach ($teacher->reaCourseEvidences()->get() as $file_activity) {
                $this->user_evidence_data_responses[$file_activity->rea_course_task_activity_id] = $file_activity;
            }
            $this->getCourseDays($teacher);
        } else {
            $this->user_questionary_responses = [];
            $this->user_evidence_responses = [];
        }
        
$this->user_progress();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.courses.panel.main-menu');
    }


    public function user_progress()
    {
        $this->questions = [];
        $this->tasks = [];

        $this->questionary = 0;
        $this->user_questionary = 0;

        $this->evidences = 0;
        $this->user_evidences = 0;

        foreach ($this->course->reaCourseTopics()->get() as $topics) {
            foreach ($topics->modules()->get() as $module) {
                foreach ($module->tasks()->get() as $task) {
                    foreach ($task->activities()->get() as $evaluationActivity) {
                        if ($evaluationActivity->type == ReaCourseTaskActivity::Questionary) {
                            $this->questionary++;
                            $answered = true;

                            $total_hits = $evaluationActivity->questions()->count();
                            $correct_hits = 0;

                            foreach ($evaluationActivity->questions()->get() as $question) {
                                $hasAnswer = array_search($question->id, $this->user_questionary_responses) > -1;
                                $answered = ($answered && $hasAnswer);
                                $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['question'][$question->id]['ended'] = $hasAnswer;

                                if ($hasAnswer) {
                                    $correct = $question->correct_answer == $this->user_questionary_data_responses[$question->id]->selected_option;
                                    if ($correct) {
                                        $correct_hits++;
                                    }
                                }
                            }

                            $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['questionary'] = $evaluationActivity;
                            $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['question']['correct_hits'] = $correct_hits;
                            $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['question']['total_hits'] = $total_hits;

                            if ($answered) {
                                $this->user_questionary++;
                            }

                            $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['answered'] = $answered;
                        } elseif ($evaluationActivity->type == ReaCourseTaskActivity::Content && $evaluationActivity->needs_evidence) {
                            $this->evidences++;
                            $uploaded = array_search($evaluationActivity->id, $this->user_evidence_responses) > -1;
                            $this->tasks[$topics->topic_name][$module->module_name][$task->task_name]['uploaded'] = $uploaded;
                            $this->tasks[$topics->topic_name][$module->module_name][$task->task_name]['evidence'] = $evaluationActivity->id;

                            if ($uploaded) {
                                $this->user_evidences++;
                            }
                        }
                    }
                }
            }
        }
    }

    public function getCourseDays($user): void
    {
        $questionary = $user->reaCourseResponses()->exists() ? $user->reaCourseResponses()->orderBy('created_at', 'ASC')->first()->created_at : null;
        $task = $user->reaCourseEvidences()->exists() ? $user->reaCourseEvidences()->orderBy('created_at', 'ASC')->first()->created_at : null;

        $date_questionary = $questionary ? new DateTime($questionary) : null;
        $date_task = $task ? new DateTime($task) : null;

        $dates_message = "";
        $dates_difference = 0;

        if (($date_questionary != null && $date_task != null)) {
            if ($date_questionary > $date_task) {
                $start_date = new DateTime($questionary);
                $end_date = date_add($start_date, date_interval_create_from_date_string($this->course->duration . " days"));
                $dates_message = "Inicio: " . date_format($date_questionary, 'd/m/Y H.i:s') . " - Fin: " . date_format($end_date, 'd/m/Y H.i:s');
                $dates_difference = $date_questionary->diff(new DateTime());
            } else {
                $start_date = new DateTime($task);
                $end_date = date_add($start_date, date_interval_create_from_date_string($this->course->duration . " days"));
                $dates_message = "Inicio: " . date_format($date_task, 'd/m/Y H.i:s') . " - Fin: " . date_format($end_date, 'd/m/Y H.i:s');
                $dates_difference = $date_task->diff(new DateTime());
            }
        } else if ($date_questionary != null && $date_task == null) {
            $start_date = new DateTime($questionary);
            $end_date = date_add($start_date, date_interval_create_from_date_string($this->course->duration . " days"));
            $dates_message = "Inicio: " . date_format($date_questionary, 'd/m/Y H.i:s') . " - Fin: " . date_format($end_date, 'd/m/Y H.i:s');
            $dates_difference = $date_questionary->diff(new DateTime());
        } else if ($date_questionary == null && $date_task != null) {
            $start_date = new DateTime($task);
            $end_date = date_add($start_date, date_interval_create_from_date_string($this->course->duration . " days"));
            $dates_message = "Inicio: " . date_format($date_task, 'd/m/Y H.i:s') . " - Fin: " . date_format($end_date, 'd/m/Y H.i:s');
            $dates_difference = $date_task->diff(new DateTime());
        }

        $this->dates_message = $dates_message;
        $this->dates_difference = $dates_difference->days;
        $this->teoric_days = $dates_difference->days >= $this->course->duration ? $this->course->duration : $dates_difference->days;
    }
}
