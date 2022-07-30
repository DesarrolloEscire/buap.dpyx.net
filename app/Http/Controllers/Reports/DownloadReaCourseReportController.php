<?php

namespace App\Http\Controllers\Reports;

use App\Exports\ReaCourseReportExport;
use App\Http\Controllers\Controller;
use App\Models\ReaCourse;
use App\Models\ReaCourseTaskActivity;
use App\Models\User;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;

class DownloadReaCourseReportController extends Controller
{
    public function __invoke(String $search, String $searchAcademicUnit, String $userStatus)
    {
        $search = $search=='@' ? null : $search;
        $searchAcademicUnit = $searchAcademicUnit=='@' ? "" : $searchAcademicUnit;
        $userStatus = $userStatus=='@' ? "" : $userStatus;
        $reportData = $this->users_progress($search,$searchAcademicUnit,$userStatus);
        return Excel::download(new ReaCourseReportExport($reportData), 'ReporteCursosREA.xlsx');
    }

    private function users_progress($search, $searchAcademicUnit,$userStatus){
        $endedCourseIndexes = [];
        $processCourseIndexes = [];

        $users = User::with(['academicUnits'])->whereHas('reaCourseResponses')->users();

        $user_list = [];

        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'ilike', '%' . $search . '%')->orWhere('identifier', 'ilike', '%' . $search . '%');
            });
        }

        if($searchAcademicUnit != ""){
            if($searchAcademicUnit == "Sin filtro"){
                $users->whereDoesntHave('academicUnits');
            }
            else{
                $users->whereHas('academicUnits',function($query) use ($searchAcademicUnit){
                    $query->where('name',$searchAcademicUnit);
                });
            }
        }

        foreach ($users->get() as $user_index => $user) {
            $user_questionary_responses = [];
            $user_evidences_updated = [];
            
            $user_questionary_responses = $user->reaCourseResponses->pluck('rea_course_task_activity_question_id')->toArray();
            $user_evidences_updated = $user->reaCourseEvidences->pluck('rea_course_task_activity_id')->toArray();

            if($userStatus != ""){
                if($userStatus == "complete"){
                    $user_questionary_responses = $user->reaCourseResponses()->orderBy('updated_at','DESC')->pluck('rea_course_task_activity_question_id')->toArray();
                    $user_evidences_updated = $user->reaCourseEvidences()->orderBy('updated_at','DESC')->pluck('rea_course_task_activity_id')->toArray();
                }
            }
            
            $user_statistics = $this->userStatistics($user_questionary_responses, $user_evidences_updated);

            $user_row = [];
            $user_row['identifier'] = $user->identifier;
            $user_row['name'] = $user->name;
            $user_row['academic_unit'] = 'Unidad académica no ligada';
            if($user->academicUnits()->exists()){
                $user_row['academic_unit'] = $user->academicUnits()->first()->name;
            }
            $user_row['questionaries_detail'] = $user_statistics->answered_questionaries.'/'.$user_statistics->total_questionaries;
            $user_row['questionaries'] = number_format(($user_statistics->answered_questionaries/$user_statistics->total_questionaries)*100).'%';
            $user_row['tasks_detail'] = $user_statistics->uploaded_evidences.'/'.$user_statistics->total_evidences;
            $user_row['tasks'] = number_format(($user_statistics->uploaded_evidences/$user_statistics->total_evidences)*100).'%';
            $user_row['status'] = 'En proceso';
            $user_row['start'] = $this->getStartDate($user);
            $user_row['end'] = $this->getEndDate($user,$user_statistics->answered_questionaries,$user_statistics->uploaded_evidences,$user_statistics->total_questionaries,$user_statistics->total_evidences);
            if($user_statistics->answered_questionaries == $user_statistics->total_questionaries && $user_statistics->uploaded_evidences == $user_statistics->total_evidences){
                $user_row['status'] = "Concluido";
            }

            if($user_statistics->answered_questionaries == $user_statistics->total_questionaries && $user_statistics->uploaded_evidences == $user_statistics->total_evidences){
                $endedCourseIndexes[] = $user_index;
            }
            else{
                $processCourseIndexes[] = $user_index;
            }

            $user_list[] = (object)$user_row;
        }

        if($userStatus != ""){
            if($userStatus == "complete"){
                foreach($processCourseIndexes as $index){
                    unset($user_list[$index]);
                }
            }
            else if($userStatus == "incomplete"){
                foreach($endedCourseIndexes as $index){
                    unset($user_list[$index]);
                }
            }
        }

        return $user_list;
    }

    private function userStatistics($user_questionary_responses, $user_evidences_updated)
    {
        $rubric = $this->rubricData();

        $answered_questionaries = 0;
        $uploaded_evidences = 0;

        $topics = $rubric->questionaries->details;
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

        $evidences = $rubric->tasks->details;
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

        return (object)['answered_questionaries' => $answered_questionaries, 'uploaded_evidences' => $uploaded_evidences,'total_questionaries'=>$rubric->questionaries->total,'total_evidences'=>$rubric->tasks->total];
    }

    private function rubricData()
    {
        $course = ReaCourse::Where('course_name', 'rea')->first();

        $questions = [];
        $tasks = [];

        $questionary = 0;
        $evidences = 0;

        foreach ($course->reaCourseTopics()->get() as $topics) {
            foreach ($topics->modules()->get() as $module) {
                foreach ($module->tasks()->get() as $task) {
                    foreach ($task->activities()->get() as $evaluationActivity) {
                        if ($evaluationActivity->type == ReaCourseTaskActivity::Questionary) {
                            $questionary++;
                            foreach ($evaluationActivity->questions()->get() as $question) {
                                $questions[$topics->topic_name][$module->module_name][$task->task_name]['question'][$question->id] = false;
                            }
                        } elseif ($evaluationActivity->type == ReaCourseTaskActivity::Content && $evaluationActivity->needs_evidence) {
                            $evidences++;
                            $tasks[$topics->topic_name][$module->module_name][$task->task_name]['evidence'] = $evaluationActivity->id;
                        }
                    }
                }
            }
        }

        return (object)[
            'questionaries' => (object)['details' => $questions,'total'=>$questionary],
            'tasks' => (object)['details'=>$tasks,'total'=>$evidences]
        ];
    }

    public function getStartDate($user){
        $questionary = $user->reaCourseResponses()->exists() ? $user->reaCourseResponses()->orderBy('created_at','ASC')->first()->created_at : null;
        $task = $user->reaCourseEvidences()->exists() ? $user->reaCourseEvidences()->orderBy('created_at','ASC')->first()->created_at : null;

        $date_questionary = $questionary ? new DateTime($questionary) : null;
        $date_task = $task ? new DateTime($task) : null;

        if($date_questionary != null && $date_task != null){
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
    
    public function getEndDate($user,$user_answers,$user_tasks,$answers,$tasks): String{
        $questionary = $user->reaCourseResponses()->exists() ? $user->reaCourseResponses()->orderBy('updated_at','DESC')->first()->updated_at : null;
        $task = $user->reaCourseEvidences()->exists() ? $user->reaCourseEvidences()->orderBy('updated_at','DESC')->first()->updated_at : null;

        $date_questionary = $questionary ? new DateTime($questionary) : null;
        $date_task = $task ? new DateTime($task) : null;

        if(($date_questionary != null && $date_task != null) && ($user_answers > 0 && $user_answers == $answers) && ($user_tasks > 0 && $user_tasks == $tasks)){
            if($date_questionary > $date_task){
                return date_format($questionary,'d/m/Y H:i:s');
            } else {
                return date_format($task,'d/m/Y H:i:s');
            }
        }else if(($date_questionary != null && $date_task == null) && ($user_answers > 0 && $user_answers == $answers)){
            return date_format($questionary,'d/m/Y H:i:s');
        }else if(($date_questionary == null && $date_task != null) && ($user_tasks > 0 && $user_tasks == $tasks)){
            return date_format($task,'d/m/Y H:i:s');
        }else{
            return "En proceso";
        }
    }
}
