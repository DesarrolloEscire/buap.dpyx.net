<?php

namespace App\Http\Livewire\Repositories;

use App\Models\Category;
use App\Models\Evaluator;
use App\Models\Metadata;
use App\Models\ReaCourse;
use App\Models\ReaCourseTask;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\Repository;
use App\Models\Role;
use App\Models\User;
use App\Support\Collection;
use App\Src\Users\Application\SyncUsersRepositories;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $course;

    public $total_rea = 0;
    public $total_published_rea = 0;
    public $total_unpublished_rea = 0;

    public $firstCategory;
    private $repositories;
    public $evaluators;
    public $allMetadata;
    public $search = "";
    public $search_filter = "Sin filtro";
    public $publish_filter="";
    public $evaluator_filter="";
    public $progress_filter="";

    public function mount()
    {
        $this->course = ReaCourse::Where('course_name', 'rea')->first();
       $this->evaluators = User::whereRole(Role::where('name',Role::EVALUATOR_ROLE)->first())->orderBy('name','ASC')->get();
        
        $this->firstCategory = Category::first();
        $this->allMetadata = Metadata::get();
    }

    public function render()
    {
        (new SyncUsersRepositories())->sync();

        $this->handleRepositories();
        return view('livewire.repositories.index', [
            'repositories' => $this->repositories
        ]);
    }

    protected function handleRepositories()
    {
        $this->total_rea = 0;
        $this->total_published_rea = 0;
        $this->total_unpublished_rea = 0;

        // Evaluation/REA filter
        switch ($this->search_filter){

            case 'Sin filtro':
                $this->repositories = Repository::orderBy('id', 'desc')->whereHas('responsible',function($query){
                    $query->wherehas('academicUnits')
                    ->whereHas('roles',function($query){
                        $query->whereIn('name',['docente','coordinador','director','secretario']);
                    });
                });
                break;
            case 'Filtrar en progreso':
                $this->repositories= Repository::where('repositories.status','=', 'en progreso')->orderBy('id', 'desc')->whereHas('responsible',function($query){
                    $query->wherehas('academicUnits')
                    ->whereHas('roles',function($query){
                        $query->whereIn('name',['docente','coordinador','director','secretario']);
                    });
                });
                break;
            case 'Filtrar en evaluación':
                $this->repositories= Repository::select('repositories.*', 'evaluations.status')
                     ->join('evaluations', 'repositories.id', '=', 'evaluations.id')
                     ->where('evaluations.status','=', 'en revisión')
                     ->orderBy('id', 'desc')->whereHas('responsible',function($query){
                         $query->wherehas('academicUnits')
                         ->whereHas('roles',function($query){
                             $query->whereIn('name',['docente','coordinador','director','secretario']);
                         });
                        });
                break;
            case 'Filtrar con observaciones':
                $this->repositories= Repository::where('repositories.status','=', 'observaciones')
                     ->orderBy('id', 'desc')->whereHas('responsible',function($query){
                         $query->wherehas('academicUnits')
                         ->whereHas('roles',function($query){
                             $query->whereIn('name',['docente','coordinador','director','secretario']);
                         });
                        });
                break;
            case 'Filtrar aprobado':
                $this->repositories= Repository::where('repositories.status', '=', 'aprobado')
                ->orderBy('id', 'desc')->whereHas('responsible',function($query){
                    $query->wherehas('academicUnits')
                    ->whereHas('roles',function($query){
                        $query->whereIn('name',['docente','coordinador','director','secretario']);
                    });
                });
                break;
            case 'Filtrar rechazado':
                $this->repositories= Repository::where('repositories.status', '=', 'rechazado')
                     ->orderBy('id', 'desc')->whereHas('responsible',function($query){
                         $query->wherehas('academicUnits')
                         ->whereHas('roles',function($query){
                             $query->whereIn('name',['docente','coordinador','director','secretario']);
                         });
                        });
                break;
        }

        // Match filter
        if ($this->search) {
            $this->repositories = $this->repositories->where(function ($query) {
                $query->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'")
                    ->orWhereHas('responsible', function ($query) {
                        return $query->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'");
                    });
            });
        }

        // By status
        switch($this->publish_filter){
            case 'publicado':
                $this->repositories = $this->repositories->where('is_published', true);
                break;
            case 'no_publicado':
                $this->repositories = $this->repositories->where('is_published', false);
                break;
            default:
                $this->repositories = $this->repositories;
                break;
        }

        // By evaluator
        if($this->evaluator_filter != ""){
            $this->repositories = $this->repositories->whereHas('evaluation', function ($query) {
                return $query->whereHas('evaluator', function ($query) {
                    return $query->where('users.id', $this->evaluator_filter);
                });
            });
        }

        // By REA Course status
        if($this->progress_filter != ""){
            $evidences = ReaCourseTaskActivity::where('needs_evidence',true)->count();
            $questionaries = ReaCourseTaskActivityQuestion::count();
            switch($this->progress_filter){
                case 'no_iniciado':
                    $this->repositories = $this->repositories->whereHas('responsible',function($query){
                        $query->whereDoesntHave('reaCourseResponses')->whereDoesntHave('reaCourseEvidences');
                    });
                    break;
                case 'cuestionarios':
                    $this->repositories = $this->repositories->whereHas('responsible',function($query){
                        $query->whereHas('reaCourseResponses')->whereDoesntHave('reaCourseEvidences');
                    });
                    break;
                case 'avances':
                    $this->repositories = $this->repositories->whereHas('responsible',function($query) use ($questionaries,$evidences){
                        $query->whereHas('reaCourseResponses')
                        ->has('reaCourseResponses','<=',$questionaries)
                        ->whereHas('reaCourseEvidences')
                        ->has('reaCourseEvidences','<',$evidences) ;
                    });
                    break;
                case 'terminados':
                    $this->repositories = $this->repositories->whereHas('responsible',function($query) use ($questionaries,$evidences){
                        $query->whereHas('reaCourseResponses')
                        ->has('reaCourseResponses','=',$questionaries)
                        ->whereHas('reaCourseEvidences')
                        ->has('reaCourseEvidences','>=',$evidences);
                    });
                    break;
            }
        }

        $repositories_result = null;

        // By user role
        if (Auth::user()->is_admin) {
            $repositories_result = $this->repositories;
        } else if (Auth::user()->is_evaluator) {
            $repositories_result = $this->repositories->whereHas('evaluation', function ($query) {
                return $query->whereHas('evaluator', function ($query) {
                    return $query->where('users.id', Auth::user()->id);
                });
            });
        } else {
            $repositories_result = Auth::user()->repositories();
        }

        foreach($repositories_result->get() as $repository){
            if($repository->is_published){
                $this->total_published_rea++;
            }
            else{
                $this->total_unpublished_rea++;
            }
            $this->total_rea++;
        }
        
        $this->repositories =  $repositories_result->paginate(10);
        
    }

    public function course(User $teacher){
        $user_questionary_responses = $teacher->reaCourseResponses()->pluck('rea_course_task_activity_question_id')->toArray();
        $user_questionary_data_responses = [];
        $user_evidence_responses = $teacher->reaCourseEvidences()->pluck('rea_course_task_activity_id')->toArray();
        $user_evidence_data_responses = [];

        foreach($teacher->reaCourseResponses()->get() as $response_activity){
            $user_questionary_data_responses[$response_activity->rea_course_task_activity_question_id] = $response_activity;
        }

        foreach($teacher->reaCourseEvidences()->get() as $file_activity){
            $user_evidence_data_responses[$file_activity->rea_course_task_activity_id] = $file_activity;
        }

        $questions = [];
        $tasks = [];

        $questionary = 0;
        $user_questionary = 0;

        $evidences = 0;
        $user_evidences = 0;

        foreach ($this->course->reaCourseTopics()->get() as $topics) {
            foreach ($topics->modules()->get() as $module) {
                foreach ($module->tasks()->get() as $task) {
                    foreach ($task->activities()->get() as $evaluationActivity) {
                        if ($evaluationActivity->type == ReaCourseTaskActivity::Questionary) {
                            $questionary++;
                            $answered = true;

                            $total_hits = $evaluationActivity->questions()->count();
                            $correct_hits = 0;

                            foreach ($evaluationActivity->questions()->get() as $question) {
                                $hasAnswer = array_search($question->id, $user_questionary_responses) > -1;
                                $answered = ($answered && $hasAnswer);
                                $questions[$topics->topic_name][$module->module_name][$task->task_name]['question'][$question->id]['ended'] = $hasAnswer;

                                if($hasAnswer){
                                    $correct = $question->correct_answer == $user_questionary_data_responses[$question->id]->selected_option;
                                    if($correct){
                                        $correct_hits++;
                                    }
                                }
                            }
                            
                            $questions[$topics->topic_name][$module->module_name][$task->task_name]['questionary'] = $evaluationActivity;
                            $questions[$topics->topic_name][$module->module_name][$task->task_name]['question']['correct_hits'] = $correct_hits;
                            $questions[$topics->topic_name][$module->module_name][$task->task_name]['question']['total_hits'] = $total_hits;

                            if ($answered) {
                                $user_questionary++;
                            }

                            $questions[$topics->topic_name][$module->module_name][$task->task_name]['answered'] = $answered;
                        } elseif ($evaluationActivity->type == ReaCourseTaskActivity::Content && $evaluationActivity->needs_evidence) {
                            $evidences++;
                            $uploaded = array_search($evaluationActivity->id, $user_evidence_responses) > -1;
                            $tasks[$topics->topic_name][$module->module_name][$task->task_name]['uploaded'] = $uploaded;
                            $tasks[$topics->topic_name][$module->module_name][$task->task_name]['evidence'] = $evaluationActivity->id;

                            if ($uploaded) {
                                $user_evidences++;
                            }
                        }
                    }
                }
            }
        }

        return number_format(($user_evidences/$evidences*100));
    }
}
