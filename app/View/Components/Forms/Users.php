<?php

namespace App\View\Components\Forms;

use App\Models\Evaluator;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\Component;

class Users extends Component
{
    public $user;
    public $academicUnits;
    public $userAcademicUnitId;
    public $evaluators;
    public $roles;
    public $userUseRepository;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($user = null, $academicUnits)
    {
        $this->roles = Role::get();
        $this->user = $user;

        $this->userAcademicUnitId = $this->user ? $this->user->academicUnits()->first()->id ?? null : null;

        $this->academicUnits = $academicUnits;
        $this->evaluators = User::evaluators()->get();

        $this->userUseRepository = $user && ($user->hasRole('docente') || $user->hasRole('coordinador') || $user->hasRole('director') || $user->hasRole('secretario'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.users');
    }
}
