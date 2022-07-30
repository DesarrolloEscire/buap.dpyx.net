<?php

namespace App\Http\Livewire\Courses\Board;

use App\Models\ReaCourse;
use App\Models\ReaCourseTaskActivity;
use App\Models\AcademicUnit;
use App\Models\Response;
use App\Models\User;
use App\Src\Users\Application\SyncUsersRepositories;
use App\Traits\WithPagination;
use DateTime;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $course;
    public $rubric;
    public $academicUnits;

    private $users;
    public $registeredUsers = 0;
    public $endedUsers = 0;
    public $processUsers = 0;

    public $questions = [];
    public $tasks = [];

    public $questionary = 0;
    public $evidences = 0;

    public $search;
    public $searchAcademicUnit = "";
    public $userStatus = "";

    public function mount()
    {
        $this->fixEmptyResponses();


        $this->course = ReaCourse::Where('course_name', 'rea')->first();
        $this->academicUnits = AcademicUnit::orderBy('name','ASC')->get();
        $this->rubricData();
        
        $this->users();
    }

    public function render()
    {
        (new SyncUsersRepositories())->sync();
        $this->users();
        return view('livewire.courses.board.index', [
            'users' => $this->users
        ]);
    }

    public function users()
    {
        $this->registeredUsers = 0;
        $this->endedUsers = 0;
        $this->processUsers = 0;

        $endedCourseIndexes = [];
        $processCourseIndexes = [];

        $users = User::with(['academicUnits'])->whereHas('reaCourseResponses')->users();

        $user_list = [];

        if ($this->search) {
            $users = $users->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'")->orWhere('identifier', 'ILIKE', '%' . $this->search . '%');
        }

        if($this->searchAcademicUnit != ""){
            if($this->searchAcademicUnit == "Sin filtro"){
                $users->whereDoesntHave('academicUnits');
            }
            else{
                $users->whereHas('academicUnits',function($query){
                    $query->where('name',$this->searchAcademicUnit);
                });
            }
        }      

        foreach ($users->get() as $user_index => $user) {
            $user_list[$user_index] = $user;

            $user_questionary_responses = [];
            $user_evidences_updated = [];

            $user_questionary_responses = $user->reaCourseResponses->pluck('rea_course_task_activity_question_id')->toArray();
            $user_evidences_updated = $user->reaCourseEvidences->pluck('rea_course_task_activity_id')->toArray();


            if($this->userStatus != ""){
                if($this->userStatus == "complete"){
                    $user_questionary_responses = $user->reaCourseResponses()->orderBy('updated_at','DESC')->pluck('rea_course_task_activity_question_id')->toArray();
                    $user_evidences_updated = $user->reaCourseEvidences()->orderBy('updated_at','DESC')->pluck('rea_course_task_activity_id')->toArray();
                }
            }

            $user_statistics = $this->userStatistics($user_questionary_responses, $user_evidences_updated);
            $user_list[$user_index]['answered_questionaries'] = $user_statistics['answered_questionaries'];
            $user_list[$user_index]['uploaded_evidences'] = $user_statistics['uploaded_evidences'];
            
            $this->registeredUsers++;
            if(($user_statistics['answered_questionaries'] > 0 && $user_statistics['answered_questionaries'] == $this->questionary) && ($user_statistics['uploaded_evidences'] > 0 && $user_statistics['uploaded_evidences'] == $this->evidences)){
                $this->endedUsers++;
                $user_list[$user_index]['status'] = "complete";
                $endedCourseIndexes[] = $user_index;
            }
            else{
                $this->processUsers++;
                $user_list[$user_index]['status'] = "incomplete";
                $processCourseIndexes[] = $user_index;
            }

            $user_list[$user_index]['start'] = $this->getStartDate($user);
            $user_list[$user_index]['end'] = $this->getEndDate($user);

        }

        if($this->userStatus != ""){
            if($this->userStatus == "complete"){
                foreach($processCourseIndexes as $index){
                    unset($user_list[$index]);
                }
            }
            else if($this->userStatus == "incomplete"){
                foreach($endedCourseIndexes as $index){
                    unset($user_list[$index]);
                }
            }
        }

        $this->users = collect($user_list)->sortBy('start')->paginate(10);

        if($this->userStatus != ""){
            if($this->userStatus == "complete"){
                $this->users = collect($user_list)->sortByDesc('end')->paginate(10);
            }
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function userStatistics($user_questionary_responses, $user_evidences_updated)
    {
        $answered_questionaries = 0;
        $uploaded_evidences = 0;

        $topics = $this->questions;
        foreach ($topics as $topic) {
            foreach ($topic as $module) {
                foreach ($module as $task) {
                    foreach ($task as $question) {
                        $answered = true;
                        foreach ($question as $answer_key => $answer) {
                            $hasAnswer = array_search($answer_key, $user_questionary_responses) > -1;
                            $answered = ($answered && $hasAnswer);
                        }
                        if ($answered) {
                            $answered_questionaries++;
                        }
                    }
                }
            }
        }

        $evidences = $this->tasks;
        foreach ($evidences as $topic) {
            foreach ($topic as $module) {
                foreach ($module as $task) {
                    foreach ($task as $evidence) {
                        $uploaded = array_search($evidence, $user_evidences_updated) > -1;
                        if ($uploaded) {
                            $uploaded_evidences++;
                        }
                    }
                }
            }
        }

        return ['answered_questionaries' => $answered_questionaries, 'uploaded_evidences' => $uploaded_evidences];
    }

    public function rubricData()
    {
        $this->questions = [];
        $this->tasks = [];

        $this->questionary = 0;
        $this->evidences = 0;

        foreach ($this->course->reaCourseTopics()->get() as $topics) {
            foreach ($topics->modules()->get() as $module) {
                foreach ($module->tasks()->get() as $task) {
                    foreach ($task->activities()->get() as $evaluationActivity) {
                        if ($evaluationActivity->type == ReaCourseTaskActivity::Questionary) {
                            $this->questionary++;

                            foreach ($evaluationActivity->questions()->get() as $question) {
                                $this->questions[$topics->topic_name][$module->module_name][$task->task_name]['question'][$question->id] = false;
                            }
                        } elseif ($evaluationActivity->type == ReaCourseTaskActivity::Content && $evaluationActivity->needs_evidence) {
                            $this->evidences++;
                            $this->tasks[$topics->topic_name][$module->module_name][$task->task_name]['evidence'] = $evaluationActivity->id;
                        }
                    }
                }
            }
        }
    }

    public function fixEmptyResponses(){
        $responses = Response::whereNull('selected_option');

        if($responses->count()>0){
            foreach ($responses->get() as $response) {
                $question = $response->question;
                $answer_a = $question->answer_a;
                $answer_b = $question->answer_b;
                $answer_c = $question->answer_c;
    
                $selected_option = null;
    
                switch (true) {
                    case ($answer_a == $response->response):
                        $selected_option = 'a';
                        break;
                    case ($answer_b == $response->response):
                        $selected_option = 'b';
                        break;
                    case ($answer_c == $response->response):
                        $selected_option = 'c';
                        break;
                }
                
                $response->selected_option = $selected_option;
                $response->save();
            }
        }
    }

    public function getStartDate($user): String{
        $questionary = $user->reaCourseResponses()->exists() ? $user->reaCourseResponses()->orderBy('created_at','ASC')->first()->created_at : null;
        $task = $user->reaCourseEvidences()->exists() ? $user->reaCourseEvidences()->orderBy('created_at','ASC')->first()->created_at : null;

        $date_questionary = $questionary ? new DateTime($questionary) : null;
        $date_task = $task ? new DateTime($task) : null;

        if(($date_questionary != null && $date_task != null)){
            if($date_questionary > $date_task){
                return date_format($questionary,'d/m/Y H:i:s');
            } else {
                return date_format($task,'d/m/Y H:i:s');
            }
        }else if($date_questionary != null && $date_task == null){
            return date_format($questionary,'d/m/Y H:i:s');
        }else if($date_questionary == null && $date_task != null){
            return date_format($task,'d/m/Y H:i:s');
        }else{
            return "No registrado";
        }
    }
    
    public function getEndDate($user): String{
        $questionary = $user->reaCourseResponses()->exists() ? $user->reaCourseResponses()->orderBy('updated_at','DESC')->first()->updated_at : null;
        $task = $user->reaCourseEvidences()->exists() ? $user->reaCourseEvidences()->orderBy('updated_at','DESC')->first()->updated_at : null;
        $user_questionary = $user->answered_questionaries;
        $user_tasks = $user->uploaded_evidences;

        $date_questionary = $questionary ? new DateTime($questionary) : null;
        $date_task = $task ? new DateTime($task) : null;

        if(($date_questionary != null && $date_task != null) && ($user_questionary > 0 && $user_questionary == $this->questionary) && ($user_tasks > 0 && $user_tasks == $this->evidences)){
            if($date_questionary > $date_task){
                return date_format($questionary,'d/m/Y H:i:s');
            } else {
                return date_format($task,'d/m/Y H:i:s');
            }
        }else if(($date_questionary != null && $date_task == null) && ($user_questionary > 0 && $user_questionary == $this->questionary)){
            return date_format($questionary,'d/m/Y H:i:s');
        }else if(($date_questionary == null && $date_task != null) && ($user_tasks > 0 && $user_tasks == $this->evidences)){
            return date_format($task,'d/m/Y H:i:s');
        }else{
            return "En proceso";
        }
    }
}
