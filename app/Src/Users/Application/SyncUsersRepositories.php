<?php 
namespace App\Src\Users\Application;

use App\Models\Evaluation;
use App\Models\Evaluator;
use App\Models\User;
use App\Src\Repositories\Application\RepositoryCreator;

class SyncUsersRepositories{
    function __construct()
    {
    }

    public function sync(){
        $users = User::whereHas('roles',function($query){
            $query->where('name','docente')->orWhere('name','coordinador')->orWhere('name','director')->orWhere('name','secretario');
        })->whereHas('reaCourseResponses')
        ->whereDoesntHave('repositories');

        if($users->count()>0){
            foreach($users->get() as $user){
                if($user->academicUnits()->exists()){
                    $academicUnitUser = $user->academicUnits()->first();
                    $level = (in_array($academicUnitUser->name,['Preparatorias BUAP','Bachilleratos BUAP']) ? 'media_superior':'des');
                    $evaluators = Evaluator::where('educational_level',$level)->get();

                    $evaluator = $evaluators[rand(0,sizeof($evaluators)-1)];
                    (new RepositoryCreator)->create("REA", $user, User::find($evaluator->evaluator_id));
                }
            }
        }
        // else{
        //     $user_id_list = Evaluation::join('repositories','evaluations.repository_id','=','repositories.id')->whereRaw("date(evaluations.created_at) = '2022-07-01'");
        //     $users = User::whereIn('id',$user_id_list->pluck('repositories.responsible_id'))->get();

        //     foreach($users as $user){
        //         if($user->academicUnits()->exists()){
        //             $academicUnitUser = $user->academicUnits()->first();
        //             $level = (in_array($academicUnitUser->name,['Preparatorias BUAP','Bachilleratos BUAP']) ? 'media_superior':'des');
        //             $evaluators = Evaluator::where('educational_level',$level)->get();

        //             $evaluator = $evaluators[rand(0,sizeof($evaluators)-1)];

        //             $user->repositories()->first()->evaluation()->update(["evaluator_id"=>$evaluator->evaluator_id]);
        //         }
        //     }
        // }
    }
}

?>

