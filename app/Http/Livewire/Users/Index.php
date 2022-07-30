<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Models\Evaluation;
use App\Src\Users\Application\SyncUsersRepositories;
use App\Traits\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    private $users;
    public $search = "";

    public function render()
    {
        (new SyncUsersRepositories())->sync();

        $this->setUsers();
        return view('livewire.users.index', [
            'users' => $this->users
        ]);
    }

    private function setUsers()
    {

        $this->users = User::orderBy('id', 'desc');

        if ($this->search) {
            $this->users = $this->users
                ->where(function($query){
                    $query->whereRaw("replace(name,' ','') ILIKE '%" . str_replace(' ','',$this->search) . "%'")
                    ->orWhere('identifier', 'ILIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'ilike', '%' . $this->search . '%')
                    ->orWhere('phone', 'ilike', '%' . $this->search . '%')
                    ->orWhereHas('roles', function ($query) {
                        return $query->where('name', 'ilike', '%'.$this->search.'%');
                });
            });
        }

        if (Auth::user()->is_admin) {
            $this->users = $this->users;
        } else {
             $repositoryResponsiblesIds = Evaluation::where('evaluator_id', Auth::user()->id)->get()->pluck('repository.responsible.id')->flatten()->unique();
           // $repositoryResponsiblesIds = (new EvaluatorService)(Auth::user())->getAllEvaluations()->pluck('repository.responsible.id')->flatten()->unique();
            $this->users = $this->users->whereIn('id', $repositoryResponsiblesIds);
        }

        $this->users = $this->users->paginate(10);

    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }
}
