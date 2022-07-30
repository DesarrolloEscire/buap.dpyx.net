<?php

namespace App\Http\Livewire\Users;

use App\Models\AcademicUnit;
use App\Models\Evaluator;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public $user;
    public $roles;
    public $academicUnits;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->academicUnits = AcademicUnit::orderBy('name')->get();
        $this->roles = Role::get();
    }

    public function render()
    {
        return view('livewire.users.edit');
    }

    public function randomSelectedEvaluator(String $educational_level){
        $evaluators = Evaluator::where('educational_level',$educational_level)->get();

        if($evaluators){
            return $evaluators[rand(0,sizeof($evaluators)-1)]->toJson();
        }
        return null;
    }
}
