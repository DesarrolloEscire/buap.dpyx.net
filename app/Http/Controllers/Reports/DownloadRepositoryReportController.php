<?php

namespace App\Http\Controllers\Reports;

use App\Exports\RepositoryReportExport;
use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTaskActivity;
use App\Models\ReaCourseTaskActivityQuestion;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DownloadRepositoryReportController extends Controller
{
    public $course;

    public function __invoke($search, $search_filter, $publish_filter, $evaluator_filter, $progress_filter)
    {
        $this->course = ReaCourse::Where('course_name', 'rea')->first();
        $filteredRepositoryData = $this->filteredRepositoryData($search, $search_filter, $publish_filter, $evaluator_filter, $progress_filter);
        $excelRepositoryData = [];
        
        set_time_limit(0);
        foreach($filteredRepositoryData as $repository){
            $repository_row = [];
            $repository_row["repository_name"] = $repository->name;
            $repository_row["repository_published"] = $repository->is_published ? "Publicado" : "No publicado";
            $course_progress = "";
            if ($repository->responsible->reaCourseResponses()->count() > 0 && $repository->responsible->reaCourseEvidences()->count() == 0){
                $course_progress = "Cuestionario en progreso";
            }
            elseif ($repository->responsible->reaCourseResponses()->count() > 0 && $repository->responsible->reaCourseEvidences()->count() > 0){
                $course_progress = $this->course($repository->responsible).'%';
            }
            else{
                $course_progress = "No ha realizado el curso";
            }
            $repository_row["course_progress"] = $course_progress;
            $repository_row["responsible"] = $repository->responsible->name;
            $repository_row["evaluator"] = ($repository->evaluation && isset($repository->evaluation->evaluator->name)) ? $repository->evaluation->evaluator->name : 'N/A';
            $repository_row["rea_status"] = ($repository->evaluation->in_review) ? "En evaluación" : ucfirst($repository->status);
            $repository_row["evaluation_status"] = ($repository->is_aproved || $repository->is_rejected) ? "Concluido" : ucfirst($repository->evaluation->status);

            $excelRepositoryData[] = (object)$repository_row;
        }

        return Excel::download(new RepositoryReportExport($excelRepositoryData), 'ReporteRepositorios.xlsx');        
    }

    private function filteredRepositoryData($search, $search_filter, $publish_filter, $evaluator_filter, $progress_filter)
    {
        $repositories_result = null;

        // Evaluation/REA filter
        switch ($search_filter) {

            case 'Sin filtro':
            case 'null':
                $repositories_result = Repository::orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                    $query->wherehas('academicUnits')
                        ->whereHas('roles', function ($query) {
                            $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                        });
                });
                break;
            case 'Filtrar en progreso':
                $repositories_result = Repository::where('repositories.status', '=', 'en progreso')->orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                    $query->wherehas('academicUnits')
                        ->whereHas('roles', function ($query) {
                            $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                        });
                });
                break;
            case 'Filtrar en evaluación':
                $repositories_result = Repository::select('repositories.*', 'evaluations.status')
                    ->join('evaluations', 'repositories.id', '=', 'evaluations.id')
                    ->where('evaluations.status', '=', 'en revisión')
                    ->orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                        $query->wherehas('academicUnits')
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                            });
                    });
                break;
            case 'Filtrar con observaciones':
                $repositories_result = Repository::where('repositories.status', '=', 'observaciones')
                    ->orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                        $query->wherehas('academicUnits')
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                            });
                    });
                break;
            case 'Filtrar aprobado':
                $repositories_result = Repository::where('repositories.status', '=', 'aprobado')
                    ->orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                        $query->wherehas('academicUnits')
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                            });
                    });
                break;
            case 'Filtrar rechazado':
                $repositories_result = Repository::where('repositories.status', '=', 'rechazado')
                    ->orderBy('id', 'desc')->whereHas('responsible', function ($query) {
                        $query->wherehas('academicUnits')
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['docente', 'coordinador', 'director', 'secretario']);
                            });
                    });
                break;
        }

        // Match filter
        if ($search != "null") {
            $repositories_result = $repositories_result->where(function ($query) use ($search) {
                $query->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'")
                    ->orWhereHas('responsible', function ($query)  use ($search) {
                        return $query->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'");
                    });
            });
        }

        // By status
        if ($publish_filter != "null") {
            switch ($publish_filter) {
                case 'publicado':
                    $repositories_result = $repositories_result->where('is_published', true);
                    break;
                case 'no_publicado':
                    $repositories_result = $repositories_result->where('is_published', false);
                    break;
                default:
                    $repositories_result = $repositories_result;
                    break;
            }
        }

        // By evaluator
        if ($evaluator_filter != "null") {
            $repositories_result = $repositories_result->whereHas('evaluation', function ($query) use ($evaluator_filter) {
                return $query->whereHas('evaluator', function ($query) use ($evaluator_filter){
                    return $query->where('users.id', $evaluator_filter);
                });
            });
        }

        // By REA Course status
        if ($progress_filter != "null") {
            $evidences = ReaCourseTaskActivity::where('needs_evidence', true)->count();
            $questionaries = ReaCourseTaskActivityQuestion::count();
            switch ($progress_filter) {
                case 'no_iniciado':
                    $repositories_result = $repositories_result->whereHas('responsible', function ($query) {
                        $query->whereDoesntHave('reaCourseResponses')->whereDoesntHave('reaCourseEvidences');
                    });
                    break;
                case 'cuestionarios':
                    $repositories_result = $repositories_result->whereHas('responsible', function ($query) {
                        $query->whereHas('reaCourseResponses')->whereDoesntHave('reaCourseEvidences');
                    });
                    break;
                case 'avances':
                    $repositories_result = $repositories_result->whereHas('responsible', function ($query) use ($questionaries, $evidences) {
                        $query->whereHas('reaCourseResponses')
                            ->has('reaCourseResponses', '<=', $questionaries)
                            ->whereHas('reaCourseEvidences')
                            ->has('reaCourseEvidences', '<', $evidences);
                    });
                    break;
                case 'terminados':
                    $repositories_result = $repositories_result->whereHas('responsible', function ($query) use ($questionaries, $evidences) {
                        $query->whereHas('reaCourseResponses')
                            ->has('reaCourseResponses', '=', $questionaries)
                            ->whereHas('reaCourseEvidences')
                            ->has('reaCourseEvidences', '>=', $evidences);
                    });
                    break;
                default:
                    $repositories_result = $repositories_result;
                    break;
            }
        }

        // By user role
        if (Auth::user()->is_admin) {
            $repositories_result = $repositories_result;
        } else if (Auth::user()->is_evaluator) {
            $repositories_result = $repositories_result->whereHas('evaluation', function ($query) {
                return $query->whereHas('evaluator', function ($query) {
                    return $query->where('users.id', Auth::user()->id);
                });
            });
        }

        return $repositories_result->get();
    }

    private function course(User $teacher){
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
