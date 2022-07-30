<?php

namespace App\Http\Livewire\Repositories\Files;

use App\Models\Repository;
use Livewire\Component;

class Show extends Component
{
    public function mount(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function render()
    {
        return view('livewire.repositories.files.show');
    }
}
