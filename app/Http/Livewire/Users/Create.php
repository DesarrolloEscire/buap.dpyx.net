<?php

namespace App\Http\Livewire\Users;

use App\Models\AcademicUnit;
use App\Models\Evaluator;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public $academicUnits;
    public $evaluator;

    public function mount()
    {
        $this->academicUnits = AcademicUnit::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.users.create');
    }

    public function randomSelectedEvaluator(String $educational_level){
        $evaluators = Evaluator::where('educational_level',$educational_level)->get();

        if($evaluators){
            return $evaluators[rand(0,sizeof($evaluators)-1)]->toJson();
        }
        return null;
    }
}
